<?php
require_once '../db_connection.php';
session_start();

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Fetch all posts with user information
        $query = "
            SELECT 
                p.*,
                u.FirstName,
                u.LastName
            FROM Posts p
            JOIN Users u ON p.UserID = u.UserID
            ORDER BY p.CreatedAt DESC
        ";
        
        $result = $conn->query($query);
        $posts = [];
        
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        
        echo json_encode($posts);
        break;

    case 'POST':
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['top'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Title is required']);
            exit;
        }

        $top = $data['top'];
        $body = $data['body'] ?? null;
        $userId = $_SESSION['user_id'];
        $parentPostId = $data['parent_post_id'] ?? null;

        $stmt = $conn->prepare("
            INSERT INTO Posts (UserID, ParentPostID, Top, Body)
            VALUES (?, ?, ?, ?)
        ");
        
        $stmt->bind_param('iiss', $userId, $parentPostId, $top, $body);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'post_id' => $stmt->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create post']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
} 