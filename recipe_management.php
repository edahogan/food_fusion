<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable error display but keep logging
ob_start(); // Start output buffering

require_once 'db_connection.php';
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'errors' => ['User not authenticated']]);
    exit;
}

// Validate request method
if (!in_array($_SERVER['REQUEST_METHOD'], ['POST', 'DELETE'])) {
    http_response_code(405);
    echo json_encode(['success' => false, 'errors' => ['Method not allowed']]);
    exit;
}

try {
    $pdo = getConnection(); // Make sure we have a PDO connection
    
    // Handle DELETE requests first
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Parse DELETE request body
        parse_str(file_get_contents('php://input'), $deleteData);
        error_log('Delete data received: ' . print_r($deleteData, true)); // Debug log
        
        if (empty($deleteData['recipe_id'])) {
            throw new Exception('Recipe ID is required');
        }
        
        // Verify recipe ownership
        $stmt = $pdo->prepare("
            SELECT UserID 
            FROM Recipes 
            WHERE RecipeID = :recipe_id
        ");
        $stmt->execute(['recipe_id' => $deleteData['recipe_id']]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$recipe) {
            throw new Exception('Recipe not found');
        }
        
        if ($recipe['UserID'] != $_SESSION['user_id']) {
            throw new Exception('Unauthorized to delete this recipe');
        }
        
        // Soft delete the recipe
        $stmt = $pdo->prepare("
            UPDATE Recipes 
            SET IsDeleted = 1 
            WHERE RecipeID = :recipe_id 
            AND UserID = :user_id
        ");
        
        $result = $stmt->execute([
            'recipe_id' => $deleteData['recipe_id'],
            'user_id' => $_SESSION['user_id']
        ]);
        
        if ($result) {
            ob_clean(); // Clear any previous output
            echo json_encode(['success' => true]);
        } else {
            throw new Exception('Failed to delete recipe');
        }
        exit;
    }
    
    // Handle POST requests (create/update recipe)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Debug: Log the incoming data
        error_log("POST data: " . print_r($_POST, true));
        
        // Collect and validate form data
        $recipeData = [
            'user_id' => $_SESSION['user_id'],
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'ingredients' => $_POST['ingredients'] ?? '[]',
            'instructions' => $_POST['instructions'] ?? '[]',
            'cuisine' => $_POST['cuisine'] ?? '',
            'dietary_preference' => $_POST['dietary_preference'] ?? '',
            'difficulty' => $_POST['difficulty'] ?? '',
            'prep_time' => intval($_POST['prep_time'] ?? 0),
            'cook_time' => intval($_POST['cook_time'] ?? 0),
            'total_time' => intval($_POST['total_time'] ?? 0),
            'image_url' => $_POST['image_url'] ?? ''
        ];

        // Debug: Log the processed data
        error_log("Processed data: " . print_r($recipeData, true));

        // Validate required fields
        $required_fields = ['title', 'description', 'ingredients', 'instructions', 'cuisine', 'difficulty'];
        $errors = [];
        
        foreach ($required_fields as $field) {
            if (empty($recipeData[$field])) {
                $errors[] = ucfirst($field) . " is required";
            }
        }

        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit;
        }

        // Check if this is an update or new recipe
        if (isset($_POST['recipe_id'])) {
            // Update existing recipe
            $stmt = $pdo->prepare("
                UPDATE Recipes 
                SET Title = :title, 
                    Description = :description, 
                    Ingredients = :ingredients, 
                    Instructions = :instructions,
                    Cuisine = :cuisine, 
                    DietaryPreference = :dietary_preference, 
                    Difficulty = :difficulty,
                    PrepTime = :prep_time, 
                    CookTime = :cook_time, 
                    TotalTime = :total_time, 
                    ImageURL = :image_url
                WHERE RecipeID = :recipe_id AND UserID = :user_id
            ");
            
            $stmt->execute([
                'title' => $recipeData['title'],
                'description' => $recipeData['description'],
                'ingredients' => $recipeData['ingredients'],
                'instructions' => $recipeData['instructions'],
                'cuisine' => $recipeData['cuisine'],
                'dietary_preference' => $recipeData['dietary_preference'],
                'difficulty' => $recipeData['difficulty'],
                'prep_time' => $recipeData['prep_time'],
                'cook_time' => $recipeData['cook_time'],
                'total_time' => $recipeData['total_time'],
                'image_url' => $recipeData['image_url'],
                'recipe_id' => $_POST['recipe_id'],
                'user_id' => $recipeData['user_id']
            ]);
        } else {
            // Create new recipe
            $stmt = $pdo->prepare("
                INSERT INTO Recipes (
                    UserID, Title, Description, Ingredients, Instructions,
                    Cuisine, DietaryPreference, Difficulty,
                    PrepTime, CookTime, TotalTime, ImageURL
                ) VALUES (
                    :user_id, :title, :description, :ingredients, :instructions,
                    :cuisine, :dietary_preference, :difficulty,
                    :prep_time, :cook_time, :total_time, :image_url
                )
            ");
            
            $stmt->execute([
                'user_id' => $recipeData['user_id'],
                'title' => $recipeData['title'],
                'description' => $recipeData['description'],
                'ingredients' => $recipeData['ingredients'],
                'instructions' => $recipeData['instructions'],
                'cuisine' => $recipeData['cuisine'],
                'dietary_preference' => $recipeData['dietary_preference'],
                'difficulty' => $recipeData['difficulty'],
                'prep_time' => $recipeData['prep_time'],
                'cook_time' => $recipeData['cook_time'],
                'total_time' => $recipeData['total_time'],
                'image_url' => $recipeData['image_url']
            ]);
            
            $recipe_id = $pdo->lastInsertId();
        }

        if ($stmt->rowCount() > 0) {
            $response = ['success' => true, 'recipe_id' => $recipe_id];
            error_log("Success response: " . json_encode($response));
            echo json_encode($response);
        } else {
            $response = ['success' => false, 'errors' => ['No changes were made to the recipe']];
            error_log("Error response: " . json_encode($response));
            echo json_encode($response);
        }
    }

} catch (Exception $e) {
    error_log("Recipe management error: " . $e->getMessage());
    ob_clean(); // Clear any previous output
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'errors' => [$e->getMessage()]
    ]);
} finally {
    // Ensure all output is sent and clean any buffers
    if (ob_get_length()) ob_end_flush();
} 