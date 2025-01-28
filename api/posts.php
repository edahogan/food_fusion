<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session at the beginning of the file
session_start();

// Make sure this path is correct relative to the posts.php file
require_once 'db_connection.php';

try {
    $conn = getConnection();
    error_log("Database connection successful");
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        error_log("Processing GET request for posts");
        
        // Fetch posts with user information
        $stmt = $conn->prepare("
            SELECT 
                p.post_id,
                p.user_id,
                p.top,
                p.body,
                p.created_at,
                p.parent_post_id,
                u.first_name,
                u.last_name
            FROM posts p 
            JOIN users u ON p.user_id = u.UserID
            ORDER BY p.created_at DESC
        ");
        
        if (!$stmt) {
            error_log("SQL prepare error: " . print_r($conn->errorInfo(), true));
            throw new Exception("Failed to prepare SQL statement");
        }
        
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($posts === false) {
            error_log("SQL fetch error: " . print_r($stmt->errorInfo(), true));
            throw new Exception("Failed to fetch posts");
        }
        
        error_log("Posts data: " . print_r($posts, true)); // Log the fetched posts
        
        $response = [
            'status' => 'success',
            'data' => $posts
        ];
        
        echo json_encode($response);
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
                'message' => 'Post title is required'
            ]);
            exit;
        }

        try {
            // Insert new post
            $stmt = $conn->prepare("INSERT INTO posts (user_id, top, body, created_at, parent_post_id) VALUES (?, ?, ?, NOW(), ?)");
            $stmt->execute([
                $_SESSION['user_id'],
                $data['top'],
                $data['body'] ?? null,
                $data['parent_post_id'] ?? null
            ]);
            
            $postId = $conn->lastInsertId();
            
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
        'message' => 'Server error occurred',
        'debug' => $e->getMessage() // Remove this in production
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