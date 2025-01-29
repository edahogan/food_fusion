<?php
require_once 'header.php';
require_once 'db_connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id'])) {
    error_log("No recipe ID provided");
    header('Location: pages/recipes.php');
    exit;
}

// Add this near the top of the file, after the session checks
if (isset($_GET['screenshot'])) {
    // Only output the main content for screenshots
    $isScreenshot = true;
    // Don't include header/footer for screenshots
    ob_start();
} else {
    $isScreenshot = false;
    require_once 'header.php';
}

try {
    // Debug log
    error_log("Attempting to fetch recipe ID: " . $_GET['id']);

    // Get PDO connection
    $pdo = getConnection();
    
    // Update query to include primary image from ContentImages
    $query = "
        SELECT r.*, u.FirstName, u.LastName,
               COALESCE(ci.ImageURL, r.ImageURL) as PrimaryImage
        FROM Recipes r
        LEFT JOIN Users u ON r.UserID = u.UserID
        LEFT JOIN ContentImages ci ON r.RecipeID = ci.RecipeID 
            AND ci.ContentType = 'recipe' 
            AND ci.IsPrimary = 1
        WHERE r.RecipeID = :recipe_id
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['recipe_id' => $_GET['id']]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$recipe) {
        error_log("No recipe found for ID: " . $_GET['id']);
        header('Location: pages/recipes.php');
        exit;
    }

    // For debugging - output before the HTML
    echo "<!-- Debug: Recipe found -->";
    
    // Update image handling to use PrimaryImage
    $primaryImage = $recipe['PrimaryImage'] ?? 'https://via.placeholder.com/800x600';

    // Update the comment query to include parent_comment_id and order properly
    $commentStmt = $pdo->prepare("
        SELECT c.*, u.FirstName, u.LastName 
        FROM Comments c
        JOIN Users u ON c.UserID = u.UserID
        WHERE c.RecipeID = :recipe_id AND c.parent_comment_id IS NULL
        ORDER BY c.CreatedAt DESC
    ");
    $commentStmt->execute(['recipe_id' => $recipe['RecipeID']]);
    $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch replies for all comments
    $repliesStmt = $pdo->prepare("
        SELECT c.*, u.FirstName, u.LastName 
        FROM Comments c
        JOIN Users u ON c.UserID = u.UserID
        WHERE c.RecipeID = :recipe_id AND c.parent_comment_id IS NOT NULL
        ORDER BY c.CreatedAt ASC
    ");
    $repliesStmt->execute(['recipe_id' => $recipe['RecipeID']]);
    $replies = $repliesStmt->fetchAll(PDO::FETCH_ASSOC);

    // Group replies by parent comment
    $repliesByParent = [];
    foreach ($replies as $reply) {
        $parentId = $reply['parent_comment_id'];
        if (!isset($repliesByParent[$parentId])) {
            $repliesByParent[$parentId] = [];
        }
        $repliesByParent[$parentId][] = $reply;
    }
    ?>

    <?php if ($recipe): ?>
        <div class="container mx-auto px-4 py-8">
            <!-- Recipe Content -->
            <div class="max-w-4xl mx-auto">
                <!-- Image Section -->
                <div class="mb-8 rounded-xl overflow-hidden">
                    <img src="<?= htmlspecialchars($primaryImage) ?>" 
                         alt="<?= htmlspecialchars($recipe['Title']) ?>"
                         class="w-full h-[400px] object-cover">
                </div>

                <!-- Title and Author -->
                <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($recipe['Title']) ?></h1>
                <div class="flex items-center gap-4 text-gray-600 mb-8">
                    <span><?= htmlspecialchars($recipe['Difficulty']) ?></span>
                    <span>·</span>
                    <span><?= htmlspecialchars($recipe['Cuisine']) ?></span>
                    <?php if ($recipe['DietaryPreference'] !== 'None'): ?>
                        <span>·</span>
                        <span><?= htmlspecialchars($recipe['DietaryPreference']) ?></span>
                    <?php endif; ?>
                    <?php if (!$isScreenshot): ?>
                        <span>·</span>
                        <span>By <?= htmlspecialchars($recipe['FirstName'] . ' ' . $recipe['LastName']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <?php if (isset($recipe['Description']) && !empty($recipe['Description'])): ?>
                    <p class="text-gray-700 mb-8"><?= htmlspecialchars($recipe['Description']) ?></p>
                <?php endif; ?>

                <!-- Time Information -->
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="font-bold text-xl"><?= htmlspecialchars($recipe['PrepTime']) ?> mins</div>
                        <div class="text-gray-600">Prep Time</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="font-bold text-xl"><?= htmlspecialchars($recipe['CookTime']) ?> mins</div>
                        <div class="text-gray-600">Cook Time</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="font-bold text-xl"><?= htmlspecialchars($recipe['TotalTime']) ?> mins</div>
                        <div class="text-gray-600">Total Time</div>
                    </div>
                </div>

                <!-- Ingredients -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Ingredients</h2>
                    <ul class="list-disc list-inside space-y-2">
                        <?php 
                        $ingredients = json_decode($recipe['Ingredients'], true);
                        if ($ingredients) {
                            foreach ($ingredients as $ingredient): 
                        ?>
                            <li class="text-gray-700"><?= htmlspecialchars($ingredient) ?></li>
                        <?php 
                            endforeach;
                        }
                        ?>
                    </ul>
                </div>

                <!-- Instructions -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Instructions</h2>
                    <ol class="list-decimal list-inside space-y-4">
                        <?php 
                        $instructions = json_decode($recipe['Instructions'], true);
                        if ($instructions) {
                            foreach ($instructions as $index => $instruction): 
                        ?>
                            <li class="pl-4 text-gray-700">
                                <span class="font-medium">Step <?= $index + 1 ?>:</span>
                                <?= htmlspecialchars($instruction) ?>
                            </li>
                        <?php 
                            endforeach;
                        }
                        ?>
                    </ol>
                </div>

                <!-- Recipe Meta Information -->
                <div class="text-sm text-gray-500 mt-8 pt-8 border-t">
                    <p>Created on <?= date('F j, Y', strtotime($recipe['CreatedAt'])) ?></p>
                </div>

                <?php if (!$isScreenshot): ?>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $recipe['UserID']): ?>
                        <div class="flex gap-4 mt-8">
                            <a href="edit_recipe.php?id=<?= $recipe['RecipeID'] ?>" 
                               class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                                Edit Recipe
                            </a>
                            <button onclick="deleteRecipe(<?= $recipe['RecipeID'] ?>)"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                                Delete Recipe
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Comments Section -->
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold mb-6">Comments</h2>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- Comment Form -->
                            <form id="comment-form" class="mb-8">
                                <input type="hidden" name="recipe_id" value="<?= $recipe['RecipeID'] ?>">
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Add a Comment</label>
                                    <textarea id="comment" 
                                            name="content" 
                                            rows="3" 
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-primary-500 focus:border-primary-500"
                                            required></textarea>
                                </div>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                                    Post Comment
                                </button>
                            </form>
                        <?php else: ?>
                            <p class="mb-8 text-gray-600">Please <a href="login.php" class="text-primary-600 hover:text-primary-700">log in</a> to leave a comment.</p>
                        <?php endif; ?>

                        <!-- Comments List -->
                        <div id="comments-list" class="space-y-6">
                            <?php foreach ($comments as $comment): ?>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <!-- Main comment -->
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="font-medium text-gray-900">
                                            <?= htmlspecialchars($comment['FirstName'] . ' ' . $comment['LastName']) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?= date('M j, Y', strtotime($comment['CreatedAt'])) ?>
                                        </div>
                                    </div>
                                    <!-- Make the comment content clickable -->
                                    <a href="comment.php?id=<?= $comment['CommentID'] ?>" class="block">
                                        <p class="text-gray-700 mb-2 hover:text-gray-900"><?= htmlspecialchars($comment['Content']) ?></p>
                                    </a>
                                    
                                    <div class="flex items-center gap-4">
                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <button onclick="showReplyForm(<?= $comment['CommentID'] ?>)" 
                                                    class="text-sm text-primary-600 hover:text-primary-700">
                                                Reply
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        $replyCount = isset($repliesByParent[$comment['CommentID']]) ? count($repliesByParent[$comment['CommentID']]) : 0;
                                        if ($replyCount > 0): 
                                        ?>
                                            <a href="comment.php?id=<?= $comment['CommentID'] ?>" 
                                               class="text-sm text-gray-600 hover:text-gray-900">
                                                <?= $replyCount ?> <?= $replyCount === 1 ? 'reply' : 'replies' ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Reply form (hidden by default) -->
                                    <div id="reply-form-<?= $comment['CommentID'] ?>" class="hidden mt-4">
                                        <form class="reply-form space-y-3">
                                            <input type="hidden" name="parent_comment_id" value="<?= $comment['CommentID'] ?>">
                                            <textarea name="content" 
                                                    rows="2" 
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-primary-500 focus:border-primary-500"
                                                    required></textarea>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" 
                                                        onclick="hideReplyForm(<?= $comment['CommentID'] ?>)"
                                                        class="px-3 py-1 text-sm text-gray-600 hover:text-gray-700">
                                                    Cancel
                                                </button>
                                                <button type="submit" 
                                                        class="px-3 py-1 text-sm text-white bg-primary-600 hover:bg-primary-700 rounded-lg">
                                                    Submit Reply
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <script>
    function deleteRecipe(recipeId) {
        if (confirm('Are you sure you want to delete this recipe? This action cannot be undone.')) {
            fetch('recipe_management.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `recipe_id=${recipeId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'pages/recipes.php';
                } else {
                    alert('Error deleting recipe: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting recipe. Please try again.');
            });
        }
    }

    // Add these functions to your existing script
    function showReplyForm(commentId) {
        document.getElementById(`reply-form-${commentId}`).classList.remove('hidden');
    }

    function hideReplyForm(commentId) {
        document.getElementById(`reply-form-${commentId}`).classList.add('hidden');
    }

    // Update the comment form submission handling
    document.addEventListener('DOMContentLoaded', function() {
        // Handle main comment form
        document.getElementById('comment-form')?.addEventListener('submit', submitComment);
        
        // Handle reply forms
        document.querySelectorAll('.reply-form').forEach(form => {
            form.addEventListener('submit', submitReply);
        });
    });

    async function submitComment(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        try {
            const response = await fetch('submit_comment.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            
            if (data.success) {
                // Add new comment to the list
                addCommentToList(data.comment);
                this.reset();
            } else {
                alert('Error posting comment: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error posting comment. Please try again.');
        }
    }

    async function submitReply(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('recipe_id', document.querySelector('[name="recipe_id"]').value);
        
        try {
            const response = await fetch('submit_comment.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            
            if (data.success) {
                // Redirect to the parent comment's page
                window.location.href = `comment.php?id=${formData.get('parent_comment_id')}`;
            } else {
                alert('Error posting reply: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error posting reply. Please try again.');
        }
    }

    function addCommentToList(comment) {
        const commentsList = document.getElementById('comments-list');
        const commentHtml = `
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-medium text-gray-900">
                        ${comment.author}
                    </div>
                    <div class="text-sm text-gray-500">
                        ${comment.created_at}
                    </div>
                </div>
                <p class="text-gray-700 mb-2">${comment.content}</p>
                <button onclick="showReplyForm(${comment.id})" 
                        class="text-sm text-primary-600 hover:text-primary-700">
                    Reply
                </button>
                <div id="reply-form-${comment.id}" class="hidden mt-4">
                    <!-- Reply form HTML -->
                </div>
            </div>
        `;
        commentsList.insertBefore(
            createElementFromHTML(commentHtml), 
            commentsList.firstChild
        );
    }

    function addReplyToComment(reply) {
        const parentComment = document.querySelector(`#reply-form-${reply.parent_comment_id}`).closest('.bg-gray-50');
        let repliesContainer = parentComment.querySelector('.replies');
        
        if (!repliesContainer) {
            repliesContainer = document.createElement('div');
            repliesContainer.className = 'mt-4 ml-6 space-y-3 replies';
            parentComment.appendChild(repliesContainer);
        }
        
        const replyHtml = `
            <div class="bg-white p-3 rounded-lg border border-gray-100">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-medium text-gray-900">
                        ${reply.author}
                    </div>
                    <div class="text-sm text-gray-500">
                        ${reply.created_at}
                    </div>
                </div>
                <p class="text-gray-700">${reply.content}</p>
            </div>
        `;
        repliesContainer.insertBefore(
            createElementFromHTML(replyHtml), 
            repliesContainer.firstChild
        );
    }

    function createElementFromHTML(htmlString) {
        const div = document.createElement('div');
        div.innerHTML = htmlString.trim();
        return div.firstChild;
    }
    </script>

<?php
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    
    // For development only
    if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
        echo "<div class='container mx-auto px-4 py-8'>";
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded'>";
        echo "<strong>Debug Error:</strong> " . htmlspecialchars($e->getMessage());
        echo "</div></div>";
    } else {
        header('Location: pages/recipes.php');
        exit;
    }
}

// Update the ending of the file
if ($isScreenshot) {
    $content = ob_get_clean();
    echo $content;
} else {
    require_once 'footer.php';
}
?> 