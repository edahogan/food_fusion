<?php
require_once 'db_connection.php';

try {
    $where = [];
    $params = [];

    // Add filters if provided
    if (!empty($_GET['cuisine'])) {
        $where[] = "r.Cuisine = ?";
        $params[] = $_GET['cuisine'];
    }
    if (!empty($_GET['diet'])) {
        $where[] = "r.DietaryPreference = ?";
        $params[] = $_GET['diet'];
    }
    if (!empty($_GET['difficulty'])) {
        $where[] = "r.Difficulty = ?";
        $params[] = $_GET['difficulty'];
    }

    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

    // Updated query to include WHERE clause
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

    $stmt = $conn->prepare($query);
    
    // Execute with parameters if there are any
    if (!empty($params)) {
        $stmt->execute($params);
    } else {
        $stmt->execute();
    }
    
    $result = $stmt->get_result();
    $recipes = $result->fetch_all(MYSQLI_ASSOC);

    // If no recipes found, return a message
    if (empty($recipes)) {
        echo '<div class="col-span-full text-center py-12">';
        echo '<div class="max-w-md mx-auto space-y-4">';
        echo '<p class="text-2xl font-semibold text-neutral-700">No recipes found</p>';
        echo '<p class="text-neutral-600">Try adjusting your filters to find more recipes.</p>';
        echo '<button onclick="resetFilters()" class="mt-4 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">';
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
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
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
        </div>
        <?php
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
} 