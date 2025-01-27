<?php
session_start();
require_once 'auth.php';

// Call the logout function from auth.php
logoutUser();

// Redirect to home page
header('Location: index.php');
exit; 