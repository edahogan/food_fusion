<?php
require_once 'header.php';
?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-display font-bold text-neutral-900 mb-4">Culinary Community Discussion</h1>
    <p class="text-lg text-neutral-600 mb-8">Share your cooking questions, tips, and experiences with fellow food enthusiasts. Start a discussion or join existing conversations about recipes, techniques, and kitchen adventures.</p>

    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- New Post Form -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-medium text-neutral-900 mb-4">Start a Discussion</h2>
            <form id="new-post-form" class="space-y-4">
                <div>
                    <label for="post-top" class="block text-sm font-medium text-neutral-700 mb-1">Topic</label>
                    <input 
                        type="text"
                        id="post-top" 
                        name="top" 
                        maxlength="255"
                        placeholder="e.g., 'Looking for bread baking tips' or 'Best way to cook risotto?'"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required
                    />
                </div>
                <div>
                    <label for="post-body" class="block text-sm font-medium text-neutral-700 mb-1">Details (optional)</label>
                    <textarea 
                        id="post-body" 
                        name="body" 
                        rows="3" 
                        placeholder="Share more context about your question or discussion topic..."
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    ></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                        Post Discussion
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
    document.getElementById('new-post-form')?.addEventListener('submit', createPost);

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

// Function to load posts
function loadPosts() {
    fetch('api/posts.php', {
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
            displayPosts(data.data);
        } else {
            throw new Error(data.message || 'Failed to load posts');
        }
    })
    .catch(error => {
        console.error('Error loading posts:', error);
        document.getElementById('posts-container').innerHTML = 
            `<div class="alert alert-danger">Error loading posts: ${error.message}</div>`;
    });
}

// Function to display posts
function displayPosts(posts) {
    const container = document.getElementById('posts-container');
    if (!posts || posts.length === 0) {
        container.innerHTML = '<p class="text-center text-gray-500">No posts yet. Be the first to post!</p>';
        return;
    }

    container.innerHTML = posts.map(post => `
        <div class="bg-white rounded-lg shadow-sm p-6 mb-4">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="font-medium text-lg">${escapeHtml(post.first_name)} ${escapeHtml(post.last_name)}</h3>
                    <p class="text-sm text-gray-500">${formatDate(post.created_at)}</p>
                </div>
            </div>
            <h4 class="font-medium text-lg mb-2">${escapeHtml(post.top)}</h4>
            ${post.body ? `<p class="text-gray-700 whitespace-pre-wrap">${escapeHtml(post.body)}</p>` : ''}
            ${post.parent_post_id ? '<div class="mt-2 text-sm text-gray-500">(Reply)</div>' : ''}
        </div>
    `).join('');
}

// Function to create a new post
function createPost(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const top = formData.get('top');
    const body = formData.get('body') || '';

    fetch('api/posts.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ 
            top: top,
            body: body 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            event.target.reset();
            loadPosts(); // Reload posts after successful creation
        } else {
            throw new Error(data.message || 'Failed to create post');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to create post. Please try again.\n' + error.message);
    });
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