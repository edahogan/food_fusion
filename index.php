<?php
session_start();
require_once 'auth.php';
require_once 'db_connection.php';

// First, handle any API/AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    
    header('Content-Type: application/json');
    
    try {
        // Add proper JSON response structure
        $response = array(
            'status' => 'success',
            'message' => 'Post created successfully'
        );
        
        error_log('Response data: ' . print_r($response, true));
        echo json_encode($response);
        exit;
        
    } catch (Exception $e) {
        $error_response = array(
            'status' => 'error',
            'message' => 'Failed to create post: ' . $e->getMessage()
        );
        
        echo json_encode($error_response);
        exit;
    }
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include header
require_once 'header.php';

// Load the home page content
include 'home.php';

// Include modals
include 'modals.php';

// Include footer
require_once 'footer.php';