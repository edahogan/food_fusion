<?php
// session_start(); // Removed as it's already called in index.php
require_once 'db_connection.php';

function registerUser($firstName, $lastName, $email, $password) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function loginUser($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT UserID, Password, FailedAttempts, LockoutTime FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Check if account is locked
        if ($user['LockoutTime'] !== null) {
            $lockoutTime = strtotime($user['LockoutTime']);
            if ($lockoutTime > time()) {
                $remainingTime = ceil(($lockoutTime - time()) / 60);
                return "Account is locked. Please try again in {$remainingTime} minute(s).";
            } else {
                // Reset lockout if time has expired
                $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = 0, LockoutTime = NULL WHERE UserID = ?");
                $stmt->bind_param("i", $user['UserID']);
                $stmt->execute();
            }
        }
        
        if (password_verify($password, $user['Password'])) {
            // Reset failed attempts on successful login
            $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = 0, LockoutTime = NULL WHERE UserID = ?");
            $stmt->bind_param("i", $user['UserID']);
            $stmt->execute();
            
            // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['user_id'] = $user['UserID'];
            return "success";
        } else {
            // Increment failed attempts
            $failedAttempts = $user['FailedAttempts'] + 1;
            $lockoutTime = ($failedAttempts >= 3) ? date('Y-m-d H:i:s', strtotime('+15 minutes')) : null;
            
            $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = ?, LockoutTime = ? WHERE UserID = ?");
            $stmt->bind_param("isi", $failedAttempts, $lockoutTime, $user['UserID']);
            $stmt->execute();
            
            if ($failedAttempts >= 3) {
                return "Account locked for 15 minutes due to multiple failed attempts.";
            } else {
                $remainingAttempts = 3 - $failedAttempts;
                return "Invalid password. {$remainingAttempts} attempt(s) remaining before account lockout.";
            }
        }
    }
    return "Invalid email or password.";
}

function logoutUser() {
    session_unset();
    session_destroy();
}

// Add this at the end of the file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'login') {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if already logged in
        if (isset($_SESSION['user_id'])) {
            echo "You are already logged in.";
            exit;
        }
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        $result = loginUser($email, $password);
        echo $result;
        exit;
    } elseif ($_POST['action'] === 'register') {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT UserID FROM Users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "Email already registered. Please use a different email.";
            exit;
        }
        
        if (registerUser($firstName, $lastName, $email, $password)) {
            // Auto login after successful registration
            echo loginUser($email, $password);
        } else {
            echo "Registration failed. Please try again.";
        }
        exit;
    }
}