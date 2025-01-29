<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/food_fusion/db_connection.php');

function getResourceDetails($resourceId) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Resources WHERE ResourceID = ?");
        $stmt->execute([$resourceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return null;
    }
}

function sanitizeFilename($filename) {
    // Remove any directory components
    $filename = basename($filename);
    // Remove any non-alphanumeric characters except dots and dashes
    $filename = preg_replace("/[^a-zA-Z0-9.-]/", "_", $filename);
    return $filename;
}

// Get resource ID from query parameter
$resourceId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($resourceId <= 0) {
    http_response_code(400);
    die('Invalid resource ID');
}

// Get resource details from database
$resource = getResourceDetails($resourceId);

if (!$resource) {
    http_response_code(404);
    die('Resource not found');
}

// Get the file URL
$fileUrl = $resource['url'];

// Generate a clean filename for the download
$filename = sanitizeFilename($resource['title'] . '.' . $resource['resourcetype']);

// Set headers for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

// Stream the file to the user
readfile($fileUrl);
exit; 