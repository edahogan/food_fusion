<?php
// session_start();
// require_once 'db_connection.php';

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
        if ($user['LockoutTime'] !== null && strtotime($user['LockoutTime']) > time()) {
            return "Account is locked. Please try again later.";
        }
        
        if (password_verify($password, $user['Password'])) {
            // Reset failed attempts on successful login
            $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = 0, LockoutTime = NULL WHERE UserID = ?");
            $stmt->bind_param("i", $user['UserID']);
            $stmt->execute();
            
            $_SESSION['user_id'] = $user['UserID'];
            return "success";
        } else {
            // Increment failed attempts
            $failedAttempts = $user['FailedAttempts'] + 1;
            $lockoutTime = ($failedAttempts >= 3) ? date('Y-m-d H:i:s', strtotime('+3 minutes')) : null;
            
            $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = ?, LockoutTime = ? WHERE UserID = ?");
            $stmt->bind_param("isi", $failedAttempts, $lockoutTime, $user['UserID']);
            $stmt->execute();
            
            if ($failedAttempts >= 3) {
                return "Account locked for 3 minutes due to multiple failed attempts.";
            } else {
                return "Invalid email or password.";
            }
        }
    } else {
        return "Invalid email or password.";
    }
}

function logoutUser() {
    session_unset();
    session_destroy();
}