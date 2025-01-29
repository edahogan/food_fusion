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
    ?>

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
                <span>·</span>
                <span>By <?= htmlspecialchars($recipe['FirstName'] . ' ' . $recipe['LastName']) ?></span>
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
                    <?php
                    // Fetch comments for this recipe
                    $commentStmt = $pdo->prepare("
                        SELECT c.*, u.FirstName, u.LastName 
                        FROM Comments c
                        JOIN Users u ON c.UserID = u.UserID
                        WHERE c.RecipeID = :recipe_id
                        ORDER BY c.CreatedAt DESC
                    ");
                    $commentStmt->execute(['recipe_id' => $recipe['RecipeID']]);
                    $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($comments as $comment): ?>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div class="font-medium text-gray-900">
                                    <?= htmlspecialchars($comment['FirstName'] . ' ' . $comment['LastName']) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= date('M j, Y', strtotime($comment['CreatedAt'])) ?>
                                </div>
                            </div>
                            <p class="text-gray-700"><?= htmlspecialchars($comment['Content']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

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

    // Comment form submission
    document.getElementById('comment-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('submit_comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new comment to the list
                const commentsList = document.getElementById('comments-list');
                const newComment = document.createElement('div');
                newComment.className = 'bg-gray-50 p-4 rounded-lg';
                newComment.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <div class="font-medium text-gray-900">
                            ${data.comment.author}
                        </div>
                        <div class="text-sm text-gray-500">
                            ${data.comment.created_at}
                        </div>
                    </div>
                    <p class="text-gray-700">${data.comment.content}</p>
                `;
                commentsList.insertBefore(newComment, commentsList.firstChild);
                
                // Clear the form
                this.reset();
            } else {
                alert('Error posting comment: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error posting comment. Please try again.');
        });
    });
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

require_once 'footer.php';
?> 