<?php
require_once 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $data = [
        'user_id' => $_SESSION['user_id'],
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'ingredients' => json_encode([
            'ingredients' => array_map(
                function($ingredient) {
                    return [
                        'item' => trim($ingredient),
                        'amount' => $_POST['amounts'][$ingredient] ?? '',
                        'unit' => $_POST['units'][$ingredient] ?? ''
                    ];
                },
                array_filter(explode("\n", $_POST['ingredients']))
            )
        ]),
        'instructions' => json_encode(
            array_values(array_filter(
                array_map('trim', explode("\n", $_POST['instructions']))
            ))
        ),
        'cuisine' => $_POST['cuisine-type'] ?? '',
        'dietary_preference' => $_POST['dietary-preference'] ?? '',
        'difficulty' => $_POST['difficulty'] ?? '',
        'prep_time' => intval($_POST['prep-time'] ?? 0),
        'cook_time' => intval($_POST['cook-time'] ?? 0),
        'total_time' => intval($_POST['total-time'] ?? 0)
    ];

    $conn->beginTransaction();

    // Insert recipe
    $stmt = $conn->prepare("
        INSERT INTO Recipes (
            UserID, Title, Description, Ingredients, Instructions, 
            Cuisine, DietaryPreference, Difficulty,
            PrepTime, CookTime, TotalTime
        ) VALUES (
            :user_id, :title, :description, :ingredients, :instructions,
            :cuisine, :dietary_preference, :difficulty,
            :prep_time, :cook_time, :total_time
        )
    ");

    $stmt->execute($data);
    $recipeId = $conn->lastInsertId();

    // Handle image uploads
    if (!empty($_FILES['recipe_images'])) {
        $uploadDir = 'uploads/recipes/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageStmt = $conn->prepare("
            INSERT INTO RecipeImages (RecipeID, ImageURL, IsPrimary)
            VALUES (:recipe_id, :image_url, :is_primary)
        ");

        foreach ($_FILES['recipe_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['recipe_images']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . basename($_FILES['recipe_images']['name'][$key]);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($tmp_name, $targetPath)) {
                    $imageStmt->execute([
                        'recipe_id' => $recipeId,
                        'image_url' => $targetPath,
                        'is_primary' => $key === 0 // First image is primary
                    ]);
                }
            }
        }
    }

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Recipe submitted successfully']);

} catch (PDOException $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
} 