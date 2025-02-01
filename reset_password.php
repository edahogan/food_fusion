<?php
require_once 'db_connection.php';

$token = $_GET['token'] ?? '';
$message = '';
$error = '';

if (!$token) {
    $error = "Invalid reset token.";
} else {
    try {
        $conn = getConnection();
        // Debug: Log the token received
        error_log("Token received: " . $token);
        $stmt = $conn->prepare("SELECT UserID, ResetTokenExpiry FROM Users WHERE ResetToken = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        
        // Debug: Log the user data fetched
        error_log("User data fetched: " . print_r($user, true));

        if (!$user) {
            $error = "Invalid reset token.";
        } elseif (strtotime($user['ResetTokenExpiry']) < time()) {
            $error = "Reset token has expired.";
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $error = "An error occurred. Please try again.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        $error = "Please fill in all fields.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE Users SET Password = ?, ResetToken = NULL, ResetTokenExpiry = NULL WHERE ResetToken = ?");
            $stmt->execute([$hashedPassword, $token]);
            $message = "Password reset successfully. You can now <a href='login.php'>log in</a> with your new password.";
        } catch (PDOException $e) {
            error_log("Password reset error: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-neutral-100">
    <div class="container mx-auto px-4 py-12 max-w-md">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-neutral-900">Reset Your Password</h2>
            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4"><?= htmlspecialchars($error) ?></div>
            <?php elseif ($message): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4"><?= $message ?></div>
            <?php else: ?>
                <?php if (!$error): ?>
                    <form method="post" class="space-y-6">
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-neutral-700 mb-1">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-neutral-700 mb-1">Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">Reset Password</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 