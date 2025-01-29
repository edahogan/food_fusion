<?php
require_once 'header.php';
require_once 'db_connection.php';

// Add error logging at the start of the file
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add the formatDate function
function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('M j, Y, g:i A');
}

if (!isset($_GET['id'])) {
    header('Location: community.php');
    exit;
}

try {
    $pdo = getConnection();
    
    // Fetch the main post with user information
    $stmt = $pdo->prepare("
        SELECT 
            p.post_id,
            p.user_id,
            p.top,
            p.body,
            p.created_at,
            p.parent_post_id,
            u.FirstName as first_name,
            u.LastName as last_name,
            (SELECT COUNT(*) FROM posts WHERE parent_post_id = p.post_id) as reply_count
        FROM posts p 
        JOIN Users u ON p.user_id = u.UserID
        WHERE p.post_id = :post_id
    ");
    
    $stmt->execute(['post_id' => $_GET['id']]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$post) {
        header('Location: community.php');
        exit;
    }
?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Back to Community Link -->
    <a href="community.php" class="inline-flex items-center text-primary-600 hover:text-primary-700 mb-6">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Community
    </a>

    <!-- Main Post -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="font-medium text-2xl"><?= htmlspecialchars($post['top']) ?></h1>
                <div class="flex items-center mt-2 text-neutral-600">
                    <span class="font-medium"><?= htmlspecialchars($post['first_name']) ?> <?= htmlspecialchars($post['last_name']) ?></span>
                    <span class="mx-2">•</span>
                    <span class="text-sm"><?= formatDate($post['created_at']) ?></span>
                </div>
            </div>
        </div>
        <?php if ($post['body']): ?>
            <div class="prose max-w-none">
                <p class="text-neutral-700 whitespace-pre-wrap"><?= htmlspecialchars($post['body']) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Replies Section -->
    <div class="mb-6">
        <h2 class="text-xl font-medium text-neutral-900 mb-4">Replies</h2>
        <div id="replies-container" class="space-y-4">
            <!-- Replies will be loaded here dynamically -->
        </div>
    </div>

    <!-- Reply Form -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-medium mb-4">Leave a Reply</h3>
            <form id="reply-form" class="space-y-4">
                <input type="hidden" id="parent-post-id" value="<?= $post['post_id'] ?>">
                <div>
                    <label for="reply-content" class="block text-sm font-medium text-neutral-700 mb-1">Your Reply</label>
                    <textarea 
                        id="reply-content" 
                        name="content" 
                        rows="3" 
                        placeholder="Share your thoughts..."
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required
                    ></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                        Post Reply
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="mb-8 text-center bg-neutral-50 rounded-lg p-6">
            <p class="text-neutral-600">Please <a href="#" id="login-button" class="text-primary-600 hover:text-primary-700">log in</a> to reply to this discussion.</p>
        </div>
    <?php endif; ?>
</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadReplies();
    
    // Reply form submission
    document.getElementById('reply-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const content = document.getElementById('reply-content').value;
        const parentPostId = document.getElementById('parent-post-id').value;
        
        try {
            const response = await fetch('api/posts.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                    top: content,
                    parent_post_id: parentPostId 
                })
            });
            
            if (!response.ok) throw new Error('Failed to create reply');
            
            document.getElementById('reply-content').value = '';
            await loadReplies();
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to post reply. Please try again.');
        }
    });
});

function loadReplies() {
    const postId = <?= $post['post_id'] ?>;
    
    fetch(`api/posts.php?parent_id=${postId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            displayReplies(data.data);
        } else {
            throw new Error(data.message || 'Failed to load replies');
        }
    })
    .catch(error => {
        console.error('Error loading replies:', error);
        document.getElementById('replies-container').innerHTML = 
            '<div class="alert alert-danger">Error loading replies: ' + error.message + '</div>';
    });
}

function displayReplies(replies) {
    const container = document.getElementById('replies-container');
    
    if (!replies || replies.length === 0) {
        container.innerHTML = '<p class="text-center text-neutral-500 py-4">No replies yet. Be the first to reply!</p>';
        return;
    }
    
    container.innerHTML = replies.map(reply => `
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <div class="flex items-center">
                        <span class="font-medium text-neutral-900">${escapeHtml(reply.first_name)} ${escapeHtml(reply.last_name)}</span>
                        <span class="mx-2 text-neutral-300">•</span>
                        <span class="text-sm text-neutral-500">${formatDate(reply.created_at)}</span>
                    </div>
                </div>
            </div>
            <div class="prose max-w-none">
                <p class="text-neutral-700">${escapeHtml(reply.top)}</p>
            </div>
        </div>
    `).join('');
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}
</script>

<?php require_once 'footer.php'; ?> 