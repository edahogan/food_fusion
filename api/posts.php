<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session at the beginning of the file
session_start();

// Make sure this path is correct relative to the posts.php file
require_once 'db_connection.php';

try {
    $pdo = getConnection();
    error_log("Database connection successful");
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        error_log("Processing GET request for posts");
        
        $query = "
            SELECT 
                p.post_id,
                p.user_id,
                p.top,
                p.body,
                p.created_at,
                p.parent_post_id,
                u.FirstName as first_name,
                u.LastName as last_name
            FROM posts p 
            JOIN Users u ON p.user_id = u.UserID
        ";
        
        // If parent_id is provided, fetch only replies for that post
        if (isset($_GET['parent_id'])) {
            $query .= " WHERE p.parent_post_id = :parent_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['parent_id' => $_GET['parent_id']]);
        } else {
            // Original query for fetching all posts
            $query .= " ORDER BY p.created_at DESC";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        }
        
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($posts === false) {
            error_log("SQL fetch error: " . print_r($stmt->errorInfo(), true));
            throw new Exception("Failed to fetch posts");
        }
        
        error_log("Posts data: " . print_r($posts, true)); // Log the fetched posts
        
        echo json_encode([
            'status' => 'success',
            'data' => $posts
        ]);
        exit;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log("Processing POST request for posts");
        
        // Debug session
        error_log("Session data: " . print_r($_SESSION, true));
        
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            error_log("User not authenticated - user_id not in session");
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'User not authenticated'
            ]);
            exit;
        }

        // Get POST data
        $rawData = file_get_contents('php://input');
        error_log("Raw POST data: " . $rawData);
        
        $data = json_decode($rawData, true);
        
        // If JSON decode fails, log the error
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decode error: " . json_last_error_msg());
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ]);
            exit;
        }
        
        // Validate required fields
        if (empty($data['top'])) {
            error_log("Post title (top) is empty");
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Post content is required'
            ]);
            exit;
        }

        try {
            // Insert new post
            $stmt = $pdo->prepare("
                INSERT INTO posts (user_id, top, body, parent_post_id) 
                VALUES (:user_id, :top, :body, :parent_post_id)
            ");
            $stmt->execute([
                'user_id' => $_SESSION['user_id'],
                'top' => $data['top'],
                'body' => $data['body'] ?? null,
                'parent_post_id' => $data['parent_post_id'] ?? null
            ]);
            
            $postId = $pdo->lastInsertId();
            
            error_log("Post created successfully with ID: " . $postId);
            http_response_code(201); // Created
            echo json_encode([
                'status' => 'success',
                'message' => 'Post created successfully',
                'post_id' => $postId
            ]);
            exit;
        } catch (PDOException $e) {
            error_log("Database error while creating post: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error occurred: ' . $e->getMessage()
            ]);
            exit;
        }
    }
    
} catch (Exception $e) {
    error_log("Posts API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Server error occurred'
    ]);
    exit;
}

// If we get here, it means the request method is not supported
http_response_code(405);
echo json_encode([
    'status' => 'error',
    'message' => 'Method not allowed'
]);
exit; 