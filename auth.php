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
            return "Email already registered";
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
        
        $stmt = $conn->prepare("SELECT UserID, Password, FailedAttempts, LockoutTime FROM Users WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
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
            
            if (password_verify($password, $user['Password'])) {
                // Reset failed attempts on successful login
                $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = 0, LockoutTime = NULL WHERE UserID = ?");
                $stmt->execute([$user['UserID']]);
                
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
                $stmt->execute([$failedAttempts, $lockoutTime, $user['UserID']]);
                
                if ($failedAttempts >= 3) {
                    return "Account locked for 15 minutes due to multiple failed attempts.";
                } else {
                    $remainingAttempts = 3 - $failedAttempts;
                    return "Invalid password. {$remainingAttempts} attempt(s) remaining before account lockout.";
                }
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
        }
    } catch (Exception $e) {
        error_log("Auth error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again.']);
    }
    exit;
}