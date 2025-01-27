<?php
require_once 'db_connection.php';
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    // Log the incoming data for debugging
    error_log("POST data: " . print_r($_POST, true));
    
    // Validate required fields
    $required_fields = ['title', 'description', 'ingredients', 'instructions', 'cuisine', 'difficulty'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: {$field}");
        }
    }

    $data = [
        'user_id' => $_SESSION['user_id'],
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'ingredients' => json_encode(
            array_filter(array_map('trim', explode("\n", $_POST['ingredients'])))
        ),
        'instructions' => json_encode(
            array_filter(array_map('trim', explode("\n", $_POST['instructions'])))
        ),
        'cuisine' => $_POST['cuisine'] ?? '',
        'dietary_preference' => $_POST['dietary_preference'] ?? 'None',
        'difficulty' => $_POST['difficulty'] ?? '',
        'prep_time' => intval($_POST['prep_time'] ?? 0),
        'cook_time' => intval($_POST['cook_time'] ?? 0),
        'total_time' => intval($_POST['total_time'] ?? 0)
    ];

    // Log the processed data
    error_log("Processed data: " . print_r($data, true));

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

    try {
        $stmt->execute($data);
    } catch (PDOException $e) {
        error_log("SQL Error: " . $e->getMessage());
        error_log("SQL State: " . $e->errorInfo[0]);
        throw $e;
    }

    $recipeId = $conn->lastInsertId();

    // Handle image URL
    if (!empty($_POST['image_url'])) {
        $stmt = $conn->prepare("
            INSERT INTO ContentImages (RecipeID, ImageURL, ContentType, IsPrimary)
            VALUES (:recipe_id, :image_url, 'recipe', 1)
        ");
        $stmt->execute([
            'recipe_id' => $recipeId,
            'image_url' => $_POST['image_url']
        ]);
    }

    $conn->commit();
    echo json_encode([
        'success' => true, 
        'message' => 'Recipe submitted successfully',
        'recipe_id' => $recipeId
    ]);

} catch (PDOException $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    error_log("PDO Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    error_log("General Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
} 