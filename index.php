<?php
session_start();
require_once 'auth.php';
// require_once 'db_connection.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

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
include 'header.php';

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
include 'footer.php';