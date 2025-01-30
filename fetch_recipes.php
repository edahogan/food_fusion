<?php
require_once 'db_connection.php';

try {
    $pdo = getConnection();
    $where = ["r.IsDeleted = 0"];
    $params = [];

    // Add user filter if provided
    if (!empty($_GET['u'])) {
        $where[] = "r.UserID = :user_id";
        $params['user_id'] = intval($_GET['u']);
    }

    // Add other filters if provided
    if (!empty($_GET['cuisine'])) {
        $where[] = "r.Cuisine = :cuisine";
        $params['cuisine'] = $_GET['cuisine'];
    }
    if (!empty($_GET['diet'])) {
        $where[] = "r.DietaryPreference = :diet";
        $params['diet'] = $_GET['diet'];
    }
    if (!empty($_GET['difficulty'])) {
        $where[] = "r.Difficulty = :difficulty";
        $params['difficulty'] = $_GET['difficulty'];
    }

    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

    $query = "
        SELECT r.*, 
               u.FirstName, 
               u.LastName,
               ci.ImageURL as PrimaryImage
        FROM Recipes r
        LEFT JOIN Users u ON r.UserID = u.UserID
        LEFT JOIN ContentImages ci ON r.RecipeID = ci.RecipeID 
        AND ci.IsPrimary = 1 
        AND ci.ContentType = 'recipe'
        " . $whereClause . "
        ORDER BY r.CreatedAt DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If no recipes found, return a message
    if (empty($recipes)) {
        echo '<div class="col-span-full text-center py-12">';
        echo '<div class="max-w-md mx-auto space-y-4">';
        
        // Different message when filtering by user
        if (!empty($_GET['u'])) {
            echo '<p class="text-2xl font-semibold text-neutral-700">This user has no recipes that satisfy the current filters</p>';
        } else {
            echo '<p class="text-2xl font-semibold text-neutral-700">No recipes found</p>';
        }
        
        echo '<p class="text-neutral-600">Try adjusting your filters to find more recipes.</p>';
        echo '<button onclick="resetFilters()" ';
        echo 'class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">';
        echo 'Reset Filters';
        echo '</button>';
        echo '</div>';
        echo '</div>';
        exit;
    }

    // More detailed debug output
    echo "<!-- Total recipes found: " . count($recipes) . " -->\n";
    
    foreach ($recipes as $recipe) {
        echo "<!-- \n";
        echo "Recipe ID: " . htmlspecialchars($recipe['RecipeID']) . "\n";
        echo "Title: " . htmlspecialchars($recipe['Title']) . "\n";
        echo "Primary Image: " . htmlspecialchars($recipe['PrimaryImage'] ?? 'none') . "\n";
        echo "-->\n";
        
        // Use the primary image from DB or fallback to placeholder
        $primaryImage = !empty($recipe['ImageURL']) ? $recipe['ImageURL'] : 
                       (!empty($recipe['PrimaryImage']) ? $recipe['PrimaryImage'] : 
                       'https://via.placeholder.com/800x600');
        $additionalImages = !empty($recipe['AdditionalImages']) ? array_filter(explode(',', $recipe['AdditionalImages'])) : [];
        ?>
        <div class="recipe-card group relative overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:-translate-y-2">
            <!-- Primary Image -->
            <div class="relative aspect-[4/3] overflow-hidden">
                <img src="<?= htmlspecialchars($primaryImage) ?>" 
                     alt="<?= htmlspecialchars($recipe['Title']) ?>" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy"
                     decoding="async">
                
                <?php if (!empty($additionalImages)): ?>
                <!-- Image Gallery Indicator -->
                <div class="absolute bottom-4 right-4 bg-black/60 text-white px-2 py-1 rounded-lg text-sm">
                    +<?= count($additionalImages) ?> more
                </div>
                <?php endif; ?>
            </div>

            <!-- Always Visible Recipe Info -->
            <div class="p-4">
                <h3 class="text-xl font-bold text-neutral-900 mb-2"><?= htmlspecialchars($recipe['Title']) ?></h3>
                <div class="flex items-center gap-3 text-sm text-neutral-600 mb-3">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?= htmlspecialchars($recipe['TotalTime']) ?> mins
                    </span>
                    <span>·</span>
                    <span><?= htmlspecialchars($recipe['Difficulty']) ?></span>
                    <span>·</span>
                    <span><?= htmlspecialchars($recipe['Cuisine']) ?></span>
                </div>
            </div>

            <!-- Hover Recipe Details -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <p class="text-sm text-white/90 mb-4"><?= htmlspecialchars($recipe['Description']) ?></p>
                    <?php if (!empty($recipe['DietaryPreference']) && $recipe['DietaryPreference'] !== 'None'): ?>
                    <span class="inline-block px-2 py-1 text-xs font-medium bg-primary-500/80 rounded-full">
                        <?= htmlspecialchars($recipe['DietaryPreference']) ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Link to full recipe -->
            <a href="recipe.php?id=<?= $recipe['RecipeID'] ?>" class="absolute inset-0" aria-label="View recipe"></a>

            <!-- Add this button -->
            <button onclick="downloadRecipe(<?= $recipe['RecipeID'] ?>, '<?= htmlspecialchars($recipe['Title']) ?>')"
                    class="absolute top-4 right-4 p-2 bg-white/90 rounded-full shadow-lg hover:bg-white transition-colors z-20">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </button>
        </div>
        <?php
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
} 