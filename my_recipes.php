<?php
require_once 'header.php';
require_once 'db_connection.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Fetch user's recipes
$stmt = $conn->prepare("
    SELECT r.*, 
           GROUP_CONCAT(CASE WHEN ci.IsPrimary = 1 THEN ci.ImageURL END) as PrimaryImage
    FROM Recipes r
    LEFT JOIN ContentImages ci ON r.RecipeID = ci.RecipeID
    WHERE r.UserID = :user_id
    GROUP BY r.RecipeID
    ORDER BY r.CreatedAt DESC
");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">My Recipes</h1>
        <a href="add_recipe.php" 
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Recipe
        </a>
    </div>

    <?php if (empty($recipes)): ?>
        <div class="text-center py-12 bg-neutral-50 rounded-lg">
            <h3 class="text-xl font-semibold text-neutral-700 mb-4">No Recipes Yet</h3>
            <p class="text-neutral-600 mb-6">Start sharing your culinary creations with the community!</p>
            <a href="edit_recipe.php" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                Create Your First Recipe
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($recipes as $recipe): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="<?= htmlspecialchars($recipe['PrimaryImage'] ?? 'path/to/default-image.jpg') ?>" 
                         alt="<?= htmlspecialchars($recipe['Title']) ?>"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($recipe['Title']) ?></h3>
                        <div class="flex items-center text-sm text-neutral-600 mb-4">
                            <span><?= htmlspecialchars($recipe['CuisineType']) ?></span>
                            <span class="mx-2">•</span>
                            <span><?= htmlspecialchars($recipe['Difficulty']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <a href="recipe.php?id=<?= $recipe['RecipeID'] ?>" 
                               class="text-primary-600 hover:text-primary-700">View Recipe</a>
                            <a href="edit_recipe.php?id=<?= $recipe['RecipeID'] ?>" 
                               class="text-neutral-600 hover:text-neutral-700">Edit</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?> 