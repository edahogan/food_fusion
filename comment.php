<?php
require_once 'header.php';
require_once 'db_connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

try {
    $pdo = getConnection();
    
    // Fetch comment with user info and recipe info
    $stmt = $pdo->prepare("
        SELECT c.*, u.FirstName, u.LastName, r.RecipeID, r.Title as RecipeTitle, r.Description as RecipeDescription,
               COALESCE(ci.ImageURL, r.ImageURL) as RecipeImage
        FROM Comments c
        JOIN Users u ON c.UserID = u.UserID
        JOIN Recipes r ON c.RecipeID = r.RecipeID
        LEFT JOIN ContentImages ci ON r.RecipeID = ci.RecipeID 
            AND ci.ContentType = 'recipe' 
            AND ci.IsPrimary = 1
        WHERE c.CommentID = :comment_id
    ");
    $stmt->execute(['comment_id' => $_GET['id']]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$comment) {
        header('Location: index.php');
        exit;
    }

    // Fetch replies with user info and their reply counts
    $repliesStmt = $pdo->prepare("
        SELECT c.*, u.FirstName, u.LastName,
               (SELECT COUNT(*) FROM Comments WHERE parent_comment_id = c.CommentID) as reply_count
        FROM Comments c
        JOIN Users u ON c.UserID = u.UserID
        WHERE c.parent_comment_id = :comment_id
        ORDER BY c.CreatedAt ASC
    ");
    $repliesStmt->execute(['comment_id' => $_GET['id']]);
    $replies = $repliesStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Recipe Context Section -->
    <div class="mb-8 bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="flex items-start space-x-4 p-6">
            <!-- Recipe Image -->
            <div class="flex-shrink-0 w-24 h-24 sm:w-32 sm:h-32">
                <img src="<?= htmlspecialchars($comment['RecipeImage'] ?? 'https://via.placeholder.com/300') ?>"
                     alt="<?= htmlspecialchars($comment['RecipeTitle']) ?>"
                     class="w-full h-full object-cover rounded-lg">
            </div>
            
            <!-- Recipe Info -->
            <div class="flex-1 min-w-0">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">
                    <a href="recipe.php?id=<?= $comment['RecipeID'] ?>" 
                       class="hover:text-primary-600">
                        <?= htmlspecialchars($comment['RecipeTitle']) ?>
                    </a>
                </h2>
                <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                    <?= htmlspecialchars($comment['RecipeDescription']) ?>
                </p>
                <a href="recipe.php?id=<?= $comment['RecipeID'] ?>" 
                   class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700">
                    <span>View Recipe</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Comment -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex justify-between items-start mb-4">
            <div class="font-medium text-gray-900">
                <?= htmlspecialchars($comment['FirstName'] . ' ' . $comment['LastName']) ?>
            </div>
            <div class="text-sm text-gray-500">
                <?= date('M j, Y', strtotime($comment['CreatedAt'])) ?>
            </div>
        </div>
        <p class="text-gray-700 mb-4"><?= htmlspecialchars($comment['Content']) ?></p>
    </div>

    <!-- Replies Section -->
    <?php if (!empty($replies)): ?>
        <h2 class="text-2xl font-bold mb-6">Replies</h2>
        <div class="space-y-6">
            <?php foreach ($replies as $reply): ?>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="font-medium text-gray-900">
                            <?= htmlspecialchars($reply['FirstName'] . ' ' . $reply['LastName']) ?>
                        </div>
                        <div class="text-sm text-gray-500">
                            <?= date('M j, Y', strtotime($reply['CreatedAt'])) ?>
                        </div>
                    </div>
                    <a href="comment.php?id=<?= $reply['CommentID'] ?>" class="block">
                        <p class="text-gray-700 mb-2 hover:text-gray-900">
                            <?= htmlspecialchars($reply['Content']) ?>
                        </p>
                    </a>
                    <?php if ($reply['reply_count'] > 0): ?>
                        <div class="mt-2">
                            <a href="comment.php?id=<?= $reply['CommentID'] ?>" 
                               class="text-sm text-gray-600 hover:text-gray-900">
                                <?= $reply['reply_count'] ?> <?= $reply['reply_count'] === 1 ? 'reply' : 'replies' ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Reply Form -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Leave a Reply</h3>
            <form id="reply-form" class="space-y-4">
                <input type="hidden" name="parent_comment_id" value="<?= $comment['CommentID'] ?>">
                <input type="hidden" name="recipe_id" value="<?= $comment['RecipeID'] ?>">
                <textarea 
                    name="content" 
                    rows="3" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    required
                ></textarea>
                <button type="submit" 
                        class="px-4 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                    Post Reply
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('reply-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const response = await fetch('submit_comment.php', {
            method: 'POST',
            body: new FormData(this)
        });
        
        const data = await response.json();
        if (data.success) {
            window.location.reload();
        } else {
            alert('Failed to post reply: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to post reply. Please try again.');
    }
});
</script>

<?php 
} catch (Exception $e) {
    error_log($e->getMessage());
    header('Location: index.php');
    exit;
}

require_once 'footer.php'; 
?> 
?> 