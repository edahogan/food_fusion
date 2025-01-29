<?php
require_once 'db_connection.php';
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get POST data
    $content = trim($_POST['content'] ?? '');
    $recipe_id = intval($_POST['recipe_id'] ?? 0);
    $user_id = $_SESSION['user_id'];

    // Validate data
    if (empty($content) || empty($recipe_id)) {
        throw new Exception('Missing required fields');
    }

    // Get PDO connection
    $pdo = getConnection();

    // Insert comment
    $stmt = $pdo->prepare("
        INSERT INTO Comments (UserID, RecipeID, Content)
        VALUES (:user_id, :recipe_id, :content)
    ");

    $stmt->execute([
        'user_id' => $user_id,
        'recipe_id' => $recipe_id,
        'content' => $content
    ]);

    // Fetch the newly created comment with user info
    $commentStmt = $pdo->prepare("
        SELECT c.*, u.FirstName, u.LastName 
        FROM Comments c
        JOIN Users u ON c.UserID = u.UserID
        WHERE c.CommentID = :comment_id
    ");
    $commentStmt->execute(['comment_id' => $pdo->lastInsertId()]);
    $comment = $commentStmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'message' => 'Comment added successfully',
        'comment' => [
            'id' => $comment['CommentID'],
            'content' => $comment['Content'],
            'author' => $comment['FirstName'] . ' ' . $comment['LastName'],
            'created_at' => date('M j, Y', strtotime($comment['CreatedAt']))
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error adding comment: ' . $e->getMessage()
    ]);
} 