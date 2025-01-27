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

    // Validate JSON fields
    $ingredients = json_decode($_POST['ingredients'], true);
    $instructions = json_decode($_POST['instructions'], true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON format: " . json_last_error_msg());
    }
    
    if (empty($ingredients) || empty($instructions)) {
        throw new Exception("Ingredients and instructions cannot be empty");
    }

    // Start transaction using mysqli
    $conn->autocommit(FALSE);
    
    // Prepare the recipe data
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $ingredients_json = json_encode($ingredients);
    $instructions_json = json_encode($instructions);
    $cuisine = $conn->real_escape_string($_POST['cuisine']);
    $dietary_preference = $conn->real_escape_string($_POST['dietary_preference'] ?? 'None');
    $difficulty = $conn->real_escape_string($_POST['difficulty']);
    $prep_time = intval($_POST['prep_time'] ?? 0);
    $cook_time = intval($_POST['cook_time'] ?? 0);
    $total_time = intval($_POST['total_time'] ?? 0);
    $user_id = $_SESSION['user_id'];
    $image_url = $conn->real_escape_string($_POST['image_url'] ?? '');

    // Insert recipe
    $query = "INSERT INTO Recipes (UserID, Title, Description, Ingredients, Instructions, 
              Cuisine, DietaryPreference, Difficulty, PrepTime, CookTime, TotalTime, ImageURL) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssssiiis", $user_id, $title, $description, $ingredients_json, 
                      $instructions_json, $cuisine, $dietary_preference, $difficulty, 
                      $prep_time, $cook_time, $total_time, $image_url);

    // After successful recipe insertion, add the image to ContentImages
    if ($stmt->execute()) {
        $recipe_id = $conn->insert_id;
        
        // Only insert into ContentImages if an image URL was provided
        if (!empty($image_url)) {
            $image_query = "INSERT INTO ContentImages (RecipeID, ImageURL, IsPrimary, ContentType) 
                           VALUES (?, ?, 1, 'recipe')";
            $image_stmt = $conn->prepare($image_query);
            $image_stmt->bind_param("is", $recipe_id, $image_url);
            $image_stmt->execute();
        }
        // If everything is successful, commit the transaction
        if (!$conn->commit()) {
            throw new Exception("Commit failed");
        }
        
        // Return success response
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Recipe added successfully',
            'recipe_id' => $recipe_id
        ]);
    }

} catch (Exception $e) {
    // Roll back the transaction on error
    $conn->rollback();
    
    error_log("Error in submit_recipe.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error: ' . $e->getMessage()
    ]);
} finally {
    // Reset autocommit to true
    $conn->autocommit(TRUE);
    
    if (isset($stmt)) {
        $stmt->close();
    }
} 