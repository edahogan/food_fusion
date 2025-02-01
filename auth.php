<?php
// session_start(); // Removed as it's already called in index.php
require_once 'db_connection.php';
// Include PHPMailer
// require_once __DIR__ . '/PHPMailer/src/Exception.php';
// require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
// require_once __DIR__ . '/PHPMailer/src/SMTP.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

function registerUser($firstName, $lastName, $email, $password) {
    try {
        $conn = getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
        return "success";
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        return "An error occurred. Please try again.";
    }
}

function loginUser($email, $password) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT UserID, FirstName, LastName, Password, FailedAttempts, LockoutTime FROM Users WHERE Email = ?");
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
                    return "Account locked. Please try again in {$remainingTime} minutes.";
                } else {
                    // Reset failed attempts and lockout time if lockout has expired
                    $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = 1, LockoutTime = NULL WHERE UserID = ?");
                    $stmt->execute([$user['UserID']]);
                }
            }
            
            // Increment failed login attempts
            $failedAttempts = $user['FailedAttempts'] + 1;
            $lockoutTime = null;
            if ($failedAttempts >= 5) {
                $lockoutTime = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = ?, LockoutTime = ? WHERE UserID = ?");
                $stmt->execute([$failedAttempts, $lockoutTime, $user['UserID']]);
                return "Too many failed login attempts. Account locked for 15 minutes.";
            } else {
                $stmt = $conn->prepare("UPDATE Users SET FailedAttempts = ? WHERE UserID = ?");
                $stmt->execute([$failedAttempts, $user['UserID']]);
                return "Invalid email or password.";
            }
        }
        
        return "Invalid email or password.";
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return "An error occurred. Please try again.";
    }
}

function logoutUser() {
    // Clear all session data
    session_unset();
    session_destroy();
}

// function sendEmail($to, $subject, $message) {
//     $mail = new PHPMailer(true);
//     try {
//         //Server settings
//         $mail->SMTPDebug = 0; // Enable verbose debug output (set to 2 for debugging)
//         $mail->isSMTP();                                            // Send using SMTP
//         $mail->Host       = 'smtp.mandrillapp.com';                    // Set the SMTP server to send through
//         // $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//         $mail->Username   = 'AngelWings Communications';                     // SMTP username
//         $mail->Password   = 'md-O6tCK0kxxDJIiNa6yFUrGg';                               // SMTP password
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//         $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//         //Recipients
//         $mail->setFrom('thecreatorgetswhathewants@gmail.com', 'FoodFusion');
//         $mail->addAddress($to);     // Add a recipient

//         // Content
//         $mail->isHTML(true);                                  // Set email format to HTML
//         $mail->Subject = $subject;
//         $mail->Body    = $message;

//         $mail->send();
//         return true;
//     } catch (Exception $e) {
//         error_log("Email sending failed: " . $mail->ErrorInfo);
//         return false;
//     }
// }

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
        
        // Debug: Log the token and expiry being stored
        error_log("Token stored: " . $token);
        error_log("Expiry stored: " . $expiry);

        $resetLink = "http://localhost/food_fusion/reset_password.php?token=" . $token; // Replace with your actual domain
        
        return [
            'status' => 'success',
            'message' => "If an account with this email exists, a reset link has been sent.",
            'user_name' => $user['FirstName'],
            'reset_link' => $resetLink,
            'token' => $token // Include the token in the response
        ];
    } catch (PDOException $e) {
        error_log("Password reset request error: " . $e->getMessage());
        return [
            'status' => 'error',
            'message' => "An error occurred. Please try again."
        ];
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
            echo json_encode($result);
            exit;
        }
    } catch (Exception $e) {
        error_log("Auth error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again.']);
    }
    exit;
}