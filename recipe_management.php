<?php
require_once 'db_connection.php';
session_start();

// Check authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

function validateRecipeData($data) {
    $errors = [];
    
    if (empty($data['title'])) $errors[] = 'Title is required';
    if (empty($data['description'])) $errors[] = 'Description is required';
    if (empty($data['ingredients'])) $errors[] = 'Ingredients are required';
    if (empty($data['instructions'])) $errors[] = 'Instructions are required';
    if (empty($data['cuisine'])) $errors[] = 'Cuisine type is required';
    if (empty($data['difficulty'])) $errors[] = 'Difficulty level is required';
    
    return $errors;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // Create or Update recipe
        $recipeData = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'ingredients' => $_POST['ingredients'] ?? '',
            'instructions' => $_POST['instructions'] ?? '',
            'cuisine' => $_POST['cuisine'] ?? '',
            'dietary_preference' => $_POST['dietary_preference'] ?? 'None',
            'difficulty' => $_POST['difficulty'] ?? '',
            'prep_time' => intval($_POST['prep_time'] ?? 0),
            'cook_time' => intval($_POST['cook_time'] ?? 0),
            'total_time' => intval($_POST['total_time'] ?? 0),
            'user_id' => $_SESSION['user_id']
        ];

        $errors = validateRecipeData($recipeData);
        
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            exit;
        }

        try {
            $conn->beginTransaction();

            if (isset($_POST['recipe_id'])) {
                // Update existing recipe
                $stmt = $conn->prepare("
                    UPDATE Recipes 
                    SET Title = ?, Description = ?, Ingredients = ?, Instructions = ?,
                        Cuisine = ?, DietaryPreference = ?, Difficulty = ?,
                        PrepTime = ?, CookTime = ?, TotalTime = ?
                    WHERE RecipeID = ? AND UserID = ? AND IsDeleted = FALSE
                ");
                
                $stmt->execute([
                    $recipeData['title'], $recipeData['description'],
                    $recipeData['ingredients'], $recipeData['instructions'],
                    $recipeData['cuisine'], $recipeData['dietary_preference'],
                    $recipeData['difficulty'], $recipeData['prep_time'],
                    $recipeData['cook_time'], $recipeData['total_time'],
                    $_POST['recipe_id'], $recipeData['user_id']
                ]);
                
                $recipeId = $_POST['recipe_id'];
            } else {
                // Create new recipe
                $stmt = $conn->prepare("
                    INSERT INTO Recipes (
                        UserID, Title, Description, Ingredients, Instructions,
                        Cuisine, DietaryPreference, Difficulty,
                        PrepTime, CookTime, TotalTime
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                
                $stmt->execute([
                    $recipeData['user_id'], $recipeData['title'],
                    $recipeData['description'], $recipeData['ingredients'],
                    $recipeData['instructions'], $recipeData['cuisine'],
                    $recipeData['dietary_preference'], $recipeData['difficulty'],
                    $recipeData['prep_time'], $recipeData['cook_time'],
                    $recipeData['total_time']
                ]);
                
                $recipeId = $conn->lastInsertId();
            }

            // Handle image uploads
            if (!empty($_FILES['images'])) {
                $uploadDir = 'uploads/recipes/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName = uniqid() . '_' . basename($_FILES['images']['name'][$key]);
                        $targetPath = $uploadDir . $fileName;

                        if (move_uploaded_file($tmp_name, $targetPath)) {
                            $stmt = $conn->prepare("
                                INSERT INTO RecipeImages (RecipeID, ImageURL, IsPrimary)
                                VALUES (?, ?, ?)
                            ");
                            $stmt->execute([$recipeId, $targetPath, $key === 0]);
                        }
                    }
                }
            }

            $conn->commit();
            echo json_encode(['success' => true, 'recipe_id' => $recipeId]);

        } catch (Exception $e) {
            $conn->rollBack();
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;

    case 'DELETE':
        // Soft delete recipe
        parse_str(file_get_contents("php://input"), $deleteData);
        $recipeId = $deleteData['recipe_id'] ?? null;

        if (!$recipeId) {
            http_response_code(400);
            echo json_encode(['error' => 'Recipe ID is required']);
            exit;
        }

        try {
            $stmt = $conn->prepare("
                UPDATE Recipes 
                SET IsDeleted = TRUE 
                WHERE RecipeID = ? AND UserID = ?
            ");
            
            $stmt->execute([$recipeId, $_SESSION['user_id']]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Recipe not found or unauthorized']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
} 