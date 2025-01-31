<?php
// session_start(); // Removed as it's already called in index.php
require_once 'db_connection.php';

function registerUser($firstName, $lastName, $email, $password) {
    try {
        $conn = getConnection();
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT UserID FROM Users WHERE Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "An account with this email already exists";
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$firstName, $lastName, $email, $hashedPassword])) {
            return "success";
        }
        return "Registration failed";
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        return "An error occurred during registration";
    }
}

function loginUser($email, $password) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("SELECT UserID, Password, FailedAttempts, LockoutTime, FirstName, LastName FROM Users WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['Password'])) {
            // Reset failed attempts on successful login
            $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = 0, LockoutTime = NULL WHERE UserID = ?");
            $stmt->execute([$user['UserID']]);
            
            // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Store user data in session
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_name'] = $user['FirstName'] . ' ' . $user['LastName'];
            $_SESSION['logged_in'] = true;
            
            return "success";
        }
        
        if ($user) {
            // Check if account is locked
            if ($user['LockoutTime'] !== null) {
                $lockoutTime = strtotime($user['LockoutTime']);
                if ($lockoutTime > time()) {
                    $remainingTime = ceil(($lockoutTime - time()) / 60);
                    return "Account is locked. Please try again in {$remainingTime} minute(s).";
                } else {
                    // Reset lockout if time has expired
                    $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = 0, LockoutTime = NULL WHERE UserID = ?");
                    $stmt->execute([$user['UserID']]);
                }
            }
            
            // Increment failed attempts
            $failedAttempts = $user['FailedAttempts'] + 1;
            $lockoutTime = ($failedAttempts >= 3) ? date('Y-m-d H:i:s', strtotime('+15 minutes')) : null;
            
            $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = ?, LockoutTime = ? WHERE UserID = ?");
            $stmt->execute([$failedAttempts, $lockoutTime, $user['UserID']]);
            
            if ($failedAttempts >= 3) {
                return "Account locked for 15 minutes due to multiple failed attempts.";
            } else {
                $remainingAttempts = 3 - $failedAttempts;
                return "Invalid password. {$remainingAttempts} attempt(s) remaining before account lockout.";
            }
        }
        return "Invalid email or password.";
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return "An error occurred during login. Please try again.";
    }
}

function logoutUser() {
    // Clear all session data
    session_unset();
    session_destroy();
}

function sendEmail($to, $subject, $message) {
    $headers = "From: noreply@foodfusion.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    return mail($to, $subject, $message, $headers);
}

function requestPasswordReset($email) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT UserID, FirstName FROM Users WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            return "If an account with this email exists, a reset link will be sent.";
        }

        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $conn->prepare("UPDATE Users SET ResetToken = ?, ResetTokenExpiry = ? WHERE UserID = ?");
        $stmt->execute([$token, $expiry, $user['UserID']]);

        $resetLink = "http://localhost/food_fusion/reset_password.php?token=" . $token; // Replace with your actual domain
        $message = "
            <p>Hello {$user['FirstName']},</p>
            <p>You have requested to reset your password. Please click the link below to reset it:</p>
            <p><a href='{$resetLink}'>Reset Password</a></p>
            <p>This link will expire in 1 hour.</p>
            <p>If you did not request a password reset, please ignore this email.</p>
        ";
        
        if (sendEmail($email, "FoodFusion Password Reset", $message)) {
            return "If an account with this email exists, a reset link has been sent.";
        } else {
            return "Failed to send reset email. Please try again.";
        }
    } catch (PDOException $e) {
        error_log("Password reset request error: " . $e->getMessage());
        return "An error occurred. Please try again.";
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    try {
        if ($_POST['action'] === 'login') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
                exit;
            }
            
            $result = loginUser($email, $password);
            echo json_encode(['status' => ($result === 'success' ? 'success' : 'error'), 'message' => $result]);
            
        } elseif ($_POST['action'] === 'register') {
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required'
                ]);
                exit;
            }
            
            $result = registerUser($firstName, $lastName, $email, $password);
            echo json_encode([
                'status' => ($result === 'success' ? 'success' : 'error'),
                'message' => $result
            ]);
            exit;
        } elseif ($_POST['action'] === 'reset-request') {
            $email = $_POST['email'] ?? '';
            if (empty($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Email is required']);
                exit;
            }
            $result = requestPasswordReset($email);
            echo json_encode(['status' => ($result === 'success' ? 'success' : 'error'), 'message' => $result]);
            exit;
        }
    } catch (Exception $e) {
        error_log("Auth error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again.']);
    }
    exit;
}