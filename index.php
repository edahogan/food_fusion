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

// Regular page handling below
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Add this at the beginning of your PHP post handling code
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle login and registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $loginResult = loginUser($_POST['email'], $_POST['password']);
        if ($loginResult === "success") {
            header("Location: index.php");
            exit;
        } else {
            $error = $loginResult;
        }
    } elseif (isset($_POST['register'])) {
        if (registerUser($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'])) {
            $success = "Registration successful. Please log in.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}

// Include header
require_once 'header.php';

// Load appropriate page content
switch ($page) {
    case 'home':
        include 'pages/home.php';
        break;
    case 'about':
        include 'pages/about.php';
        break;
    case 'recipes':
        include 'pages/recipes.php';
        break;
    case 'community':
        include 'pages/community.php';
        break;
    case 'add_recipe':
        include 'add_recipe.php';
        break;
    case 'contact':
        include 'pages/contact.php';
        break;
    case 'resources':
        include 'pages/resources.php';
        break;
    case 'education':
        include 'pages/education.php';
        break;
    default:
        include 'pages/404.php';
        break;
}

// Include modals
include 'modals.php';

// Include footer
require_once 'footer.php';