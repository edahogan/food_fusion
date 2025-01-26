<?php
require_once 'header.php';
require_once 'db_connection.php';

if (!isset($_GET['id'])) {
    header('Location: pages/recipes.php');
    exit;
}

try {
    // Fetch recipe with all its images
    $query = "
        SELECT r.*, 
               u.FirstName, 
               u.LastName,
               GROUP_CONCAT(
                   CASE 
                       WHEN ri.IsPrimary = 1 THEN ri.ImageURL 
                       ELSE NULL 
                   END
               ) as PrimaryImage,
               GROUP_CONCAT(
                   CASE 
                       WHEN ri.IsPrimary = 0 THEN ri.ImageURL 
                       ELSE NULL 
                   END
               ) as AdditionalImages
        FROM Recipes r
        LEFT JOIN Users u ON r.UserID = u.UserID
        LEFT JOIN RecipeImages ri ON r.RecipeID = ri.RecipeID
        WHERE r.RecipeID = :recipe_id
        GROUP BY r.RecipeID
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute(['recipe_id' => $_GET['id']]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        header('Location: pages/recipes.php');
        exit;
    }

    $primaryImage = $recipe['PrimaryImage'] ?? 'https://via.placeholder.com/800x600';
    $additionalImages = array_filter(explode(',', $recipe['AdditionalImages'] ?? ''));
    $allImages = array_merge([$primaryImage], $additionalImages);
    ?>

    <div class="container mx-auto px-4 py-8">
        <!-- Image Gallery -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Main Image -->
            <div class="relative aspect-[4/3] rounded-xl overflow-hidden">
                <img src="<?= htmlspecialchars($primaryImage) ?>" 
                     alt="<?= htmlspecialchars($recipe['Title']) ?>" 
                     class="w-full h-full object-cover"
                     id="main-image">
            </div>

            <!-- Thumbnail Grid -->
            <div class="grid grid-cols-3 gap-4">
                <?php foreach ($allImages as $index => $image): ?>
                <button onclick="updateMainImage('<?= htmlspecialchars($image) ?>')" 
                        class="aspect-square rounded-lg overflow-hidden">
                    <img src="<?= htmlspecialchars($image) ?>" 
                         alt="Recipe image <?= $index + 1 ?>"
                         class="w-full h-full object-cover hover:opacity-75 transition-opacity">
                </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recipe Content -->
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($recipe['Title']) ?></h1>
            
            <div class="flex items-center gap-4 text-gray-600 mb-8">
                <span><?= htmlspecialchars($recipe['Difficulty']) ?></span>
                <span>·</span>
                <span><?= htmlspecialchars($recipe['CuisineType']) ?></span>
                <span>·</span>
                <span><?= htmlspecialchars($recipe['TotalTime']) ?> mins</span>
                <span>·</span>
                <span>By <?= htmlspecialchars($recipe['FirstName'] . ' ' . $recipe['LastName']) ?></span>
            </div>

            <p class="text-gray-700 mb-8"><?= htmlspecialchars($recipe['Description']) ?></p>

            <!-- Time Information -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="font-bold text-xl"><?= $recipe['PrepTime'] ?></div>
                    <div class="text-gray-600">Prep Time</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="font-bold text-xl"><?= $recipe['CookTime'] ?></div>
                    <div class="text-gray-600">Cook Time</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="font-bold text-xl"><?= $recipe['TotalTime'] ?></div>
                    <div class="text-gray-600">Total Time</div>
                </div>
            </div>

            <!-- Ingredients -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Ingredients</h2>
                <ul class="list-disc list-inside space-y-2">
                    <?php 
                    $ingredients = json_decode($recipe['Ingredients'], true)['ingredients'];
                    foreach ($ingredients as $ingredient): 
                    ?>
                    <li>
                        <?= htmlspecialchars($ingredient['amount'] . ' ' . $ingredient['unit'] . ' ' . $ingredient['item']) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Instructions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Instructions</h2>
                <ol class="list-decimal list-inside space-y-4">
                    <?php 
                    $instructions = json_decode($recipe['Instructions'], true);
                    foreach ($instructions as $index => $instruction): 
                    ?>
                    <li class="pl-4">
                        <span class="font-bold">Step <?= $index + 1 ?>:</span>
                        <?= htmlspecialchars($instruction) ?>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>

    <script>
    function updateMainImage(imageUrl) {
        const mainImage = document.getElementById('main-image');
        mainImage.src = imageUrl;
    }
    </script>

<?php
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

require_once 'footer.php';
?> 