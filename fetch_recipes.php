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

    // Fetch recipes with their primary images
    $query = "
        SELECT r.*, 
               u.FirstName, 
               u.LastName,
               GROUP_CONCAT(DISTINCT 
                   CASE 
                       WHEN ri.IsPrimary = 1 THEN ri.ImageURL 
                       ELSE NULL 
                   END
               ) as PrimaryImage,
               GROUP_CONCAT(DISTINCT 
                   CASE 
                       WHEN ri.IsPrimary = 0 THEN ri.ImageURL 
                       ELSE NULL 
                   END
               ) as AdditionalImages
        FROM Recipes r
        LEFT JOIN Users u ON r.UserID = u.UserID
        LEFT JOIN RecipeImages ri ON r.RecipeID = ri.RecipeID
        $whereClause
        GROUP BY r.RecipeID
        ORDER BY r.CreatedAt DESC
    ";

    $stmt = $conn->prepare($query);
    
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $recipes = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($recipes as $recipe) {
        $primaryImage = $recipe['PrimaryImage'] ?? 'https://via.placeholder.com/400x300';
        $additionalImages = array_filter(explode(',', $recipe['AdditionalImages'] ?? ''));
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

            <!-- Recipe Info -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($recipe['Title']) ?></h3>
                <p class="text-sm text-white/90 mb-4"><?= htmlspecialchars($recipe['Description']) ?></p>
                <div class="flex items-center justify-between text-sm">
                    <span><?= htmlspecialchars($recipe['Difficulty']) ?></span>
                    <span>·</span>
                    <span><?= htmlspecialchars($recipe['Cuisine']) ?></span>
                    <span>·</span>
                    <span><?= htmlspecialchars($recipe['TotalTime']) ?> mins</span>
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