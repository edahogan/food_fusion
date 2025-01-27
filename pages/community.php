<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-display font-bold text-neutral-900 mb-8">Community Discussion</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- New Post Form -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <form id="new-post-form" class="space-y-4">
                <div>
                    <label for="post-top" class="block text-sm font-medium text-neutral-700 mb-1">Title</label>
                    <input 
                        type="text"
                        id="post-top" 
                        name="top" 
                        maxlength="255"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required
                    />
                </div>
                <div>
                    <label for="post-body" class="block text-sm font-medium text-neutral-700 mb-1">Additional details (optional)</label>
                    <textarea 
                        id="post-body" 
                        name="body" 
                        rows="3" 
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    ></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                        Post
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <p class="mb-8 text-center bg-neutral-50 rounded-lg p-6">
            Please <a href="#" id="login-button" class="text-primary-600 hover:text-primary-700">log in</a> to participate in discussions.
        </p>
    <?php endif; ?>

    <!-- Posts List -->
    <div id="posts-container" class="space-y-6">
        <!-- Posts will be loaded here dynamically -->
    </div>

    <!-- Reply Modal -->
    <div id="reply-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Reply to Post</h3>
            <form id="reply-form" class="space-y-4">
                <input type="hidden" id="parent-post-id" name="parent_post_id">
                <textarea 
                    id="reply-content" 
                    name="content" 
                    rows="3" 
                    class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    required
                ></textarea>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeReplyModal()" class="px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                        Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadPosts();
    
    // New post form submission
    document.getElementById('new-post-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const top = document.getElementById('post-top').value;
        const body = document.getElementById('post-body').value;
        
        try {
            const response = await fetch('api/posts.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ top, body })
            });
            
            if (!response.ok) throw new Error('Failed to create post');
            
            document.getElementById('post-top').value = '';
            document.getElementById('post-body').value = '';
            await loadPosts();
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to create post. Please try again.');
        }
    });

    // Reply form submission
    document.getElementById('reply-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const top = document.getElementById('reply-content').value;
        const parentPostId = document.getElementById('parent-post-id').value;
        
        try {
            const response = await fetch('api/posts.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ top, parent_post_id: parentPostId })
            });
            
            if (!response.ok) throw new Error('Failed to create reply');
            
            closeReplyModal();
            await loadPosts();
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to create reply. Please try again.');
        }
    });
});

async function loadPosts() {
    try {
        const response = await fetch('api/posts.php');
        const posts = await response.json();
        
        const container = document.getElementById('posts-container');
        container.innerHTML = '';
        
        // First, render all parent posts
        const parentPosts = posts.filter(post => !post.ParentPostID);
        parentPosts.forEach(post => {
            const replies = posts.filter(reply => reply.ParentPostID === post.PostID);
            container.appendChild(createPostElement(post, replies));
        });
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to load posts. Please try again.');
    }
}

function createPostElement(post, replies = []) {
    const div = document.createElement('div');
    div.className = 'bg-white rounded-lg shadow-sm p-6';
    
    div.innerHTML = `
        <div class="flex items-start space-x-4">
            <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-medium text-neutral-900">${escapeHtml(post.FirstName)} ${escapeHtml(post.LastName)}</span>
                    <span class="text-sm text-neutral-500">${formatDate(post.CreatedAt)}</span>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 mb-2">${escapeHtml(post.Top)}</h3>
                ${post.Body ? `<p class="text-neutral-700 whitespace-pre-wrap mb-4">${escapeHtml(post.Body)}</p>` : ''}
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button onclick="openReplyModal(${post.PostID})" class="mt-4 text-sm text-primary-600 hover:text-primary-700">
                        Reply
                    </button>
                <?php endif; ?>
            </div>
        </div>
        ${replies.length > 0 ? `
            <div class="mt-4 pl-6 border-l-2 border-neutral-100 space-y-4">
                ${replies.map(reply => `
                    <div class="bg-neutral-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-neutral-900">${escapeHtml(reply.FirstName)} ${escapeHtml(reply.LastName)}</span>
                            <span class="text-sm text-neutral-500">${formatDate(reply.CreatedAt)}</span>
                        </div>
                        <p class="text-neutral-700">${escapeHtml(reply.Top)}</p>
                    </div>
                `).join('')}
            </div>
        ` : ''}
    `;
    
    return div;
}

function openReplyModal(postId) {
    document.getElementById('parent-post-id').value = postId;
    document.getElementById('reply-content').value = '';
    document.getElementById('reply-modal').classList.remove('hidden');
    document.getElementById('reply-modal').classList.add('flex');
}

function closeReplyModal() {
    document.getElementById('reply-modal').classList.add('hidden');
    document.getElementById('reply-modal').classList.remove('flex');
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