<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure no whitespace or output before this point
ob_start();

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
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'errors' => ['Method not allowed']]);
    exit;
}

try {
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
        $stmt = $conn->prepare("
            UPDATE Recipes 
            SET Title = ?, Description = ?, Ingredients = ?, Instructions = ?,
                Cuisine = ?, DietaryPreference = ?, Difficulty = ?,
                PrepTime = ?, CookTime = ?, TotalTime = ?, ImageURL = ?
            WHERE RecipeID = ? AND UserID = ?
        ");
        
        $recipe_id = $_POST['recipe_id'];
        $stmt->bind_param(
            "sssssssiiisii",
            $recipeData['title'],
            $recipeData['description'],
            $recipeData['ingredients'],
            $recipeData['instructions'],
            $recipeData['cuisine'],
            $recipeData['dietary_preference'],
            $recipeData['difficulty'],
            $recipeData['prep_time'],
            $recipeData['cook_time'],
            $recipeData['total_time'],
            $recipeData['image_url'],
            $recipe_id,
            $recipeData['user_id']
        );
        
        $stmt->execute();
    } else {
        // Create new recipe
        $stmt = $conn->prepare("
            INSERT INTO Recipes (
                UserID, Title, Description, Ingredients, Instructions,
                Cuisine, DietaryPreference, Difficulty,
                PrepTime, CookTime, TotalTime, ImageURL
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param(
            "isssssssiiis",
            $recipeData['user_id'],
            $recipeData['title'],
            $recipeData['description'],
            $recipeData['ingredients'],
            $recipeData['instructions'],
            $recipeData['cuisine'],
            $recipeData['dietary_preference'],
            $recipeData['difficulty'],
            $recipeData['prep_time'],
            $recipeData['cook_time'],
            $recipeData['total_time'],
            $recipeData['image_url']
        );
        
        $stmt->execute();
        $recipe_id = $conn->insert_id;
    }

    if ($stmt->affected_rows > 0) {
        $response = ['success' => true, 'recipe_id' => $recipe_id];
        error_log("Success response: " . json_encode($response));
        echo json_encode($response);
    } else {
        $response = ['success' => false, 'errors' => ['No changes were made to the recipe']];
        error_log("Error response: " . json_encode($response));
        echo json_encode($response);
    }

} catch (Exception $e) {
    error_log("Recipe management error: " . $e->getMessage());
    echo json_encode(['success' => false, 'errors' => ['An error occurred while saving the recipe']]);
} finally {
    // Ensure all output is sent and clean any buffers
    ob_end_flush();
} 