<?php
session_start();
require_once 'db_connection.php';
require_once 'header.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch user details
try {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE UserID = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("User not found.");
    }
} catch (Exception $e) {
    error_log("Error fetching user details: " . $e->getMessage());
    echo "<p class='text-red-500'>An error occurred while fetching your profile. Please try again later.</p>";
    require_once 'footer.php';
    exit;
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $email = htmlspecialchars($_POST['email']);

        $updateStmt = $pdo->prepare("
            UPDATE Users 
            SET FirstName = :firstName, LastName = :lastName, Email = :email 
            WHERE UserID = :user_id
        ");
        $updateStmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'user_id' => $_SESSION['user_id']
        ]);

        $successMessage = "Profile updated successfully!";
        $user['FirstName'] = $firstName;
        $user['LastName'] = $lastName;
        $user['Email'] = $email;
    } catch (Exception $e) {
        error_log("Error updating profile: " . $e->getMessage());
        $errorMessage = "An error occurred while updating your profile. Please try again.";
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">My Profile</h1>

    <?php if (isset($successMessage)): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($user['FirstName']) ?>" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
        </div>
        <div>
            <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($user['LastName']) ?>" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                Update Profile
            </button>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?> 