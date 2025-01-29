<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$headerPath = __DIR__ . '/header.php';
if (file_exists($headerPath)) {
    require_once $headerPath;
} else {
    echo "Header file not found at: $headerPath";
    exit;
}
?>

<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-[50vh] overflow-hidden rounded-b-3xl">
        <div class="absolute inset-0 bg-black/60 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://th.bing.com/th/id/R.dafd3090074a3bb7a5f40f9cad7f3b79?rik=Rw%2b%2brctxUfLXfA&pid=ImgRaw&r=0');" data-parallax="scroll" data-speed="0.5"></div>
        <div class="relative z-20 container mx-auto px-4 h-full flex items-center">
            <div class="flex flex-col space-y-6 max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-bold text-white">Culinary Resources</h1>
                <p class="text-xl md:text-2xl text-white/90">
                    Discover our carefully curated collection of culinary resources, designed to enhance your cooking journey and expand your culinary knowledge
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16 space-y-32">
        <!-- Recipe Cards Section -->
        <section id="recipe-cards" class="scroll-mt-24">
            <div class="grid grid-cols-1 md:grid-cols-golden gap-8">
                <div class="space-y-6 order-2 md:order-1">
                    <h2 class="text-4xl font-bold text-gray-800">Recipe Cards</h2>
                    <p class="text-lg text-gray-600">Download beautifully formatted recipe cards of our most popular dishes, perfect for building your personal cookbook or sharing with friends and family.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php
                        try {
                            require_once($_SERVER['DOCUMENT_ROOT'].'/food_fusion/db_connection.php');
                            $pdo = getConnection();
                            
                            $stmt = $pdo->prepare("
                                SELECT r.*, 
                                       u.FirstName, 
                                       u.LastName,
                                       ci.ImageURL as PrimaryImage
                                FROM Recipes r
                                LEFT JOIN Users u ON r.UserID = u.UserID
                                LEFT JOIN ContentImages ci ON r.RecipeID = ci.RecipeID 
                                    AND ci.IsPrimary = 1 
                                    AND ci.ContentType = 'recipe'
                                WHERE r.IsDeleted = 0
                                ORDER BY r.CreatedAt DESC
                                LIMIT 3
                            ");
                            $stmt->execute();
                            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($recipes as $recipe) {
                                $primaryImage = !empty($recipe['PrimaryImage']) ? $recipe['PrimaryImage'] : 'https://via.placeholder.com/800x600';
                                ?>
                                <div class="recipe-card group relative bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:-translate-y-1">
                                    <!-- Primary Image -->
                                    <div class="relative aspect-[4/3] overflow-hidden">
                                        <img src="<?= htmlspecialchars($primaryImage) ?>" 
                                             alt="<?= htmlspecialchars($recipe['Title']) ?>" 
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                             loading="lazy"
                                             decoding="async">
                                    </div>

                                    <!-- Recipe Info -->
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
                                        </div>

                                        <!-- Download Button - Updated with relative positioning and higher z-index -->
                                        <button onclick="downloadRecipeCard(event, <?= $recipe['RecipeID'] ?>, '<?= htmlspecialchars($recipe['Title']) ?>')"
                                                class="relative z-20 w-full mt-2 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download Recipe Card
                                        </button>
                                    </div>

                                    <!-- Link to full recipe - Updated with lower z-index -->
                                    <a href="recipe.php?id=<?= $recipe['RecipeID'] ?>" 
                                       class="absolute inset-0 z-10" 
                                       aria-label="View recipe"></a>
                                </div>
                                <?php
                            }
                        } catch (PDOException $e) {
                            echo '<div class="col-span-full text-center py-12">';
                            echo '<p class="text-gray-600">Unable to load recipe cards at this time.</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- Add Find More Recipes button -->
                    <div class="flex justify-center mt-8">
                        <a href="recipes.php" 
                           class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                            <span>Find More Recipes</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cooking Tutorials Section -->
        <section id="cooking-tutorials" class="scroll-mt-24">
            <div class="grid grid-cols-1 md:grid-cols-golden gap-8">
                <div class="space-y-6">
                    <h2 class="text-4xl font-bold text-gray-800">Cooking Tutorials</h2>
                    <p class="text-lg text-gray-600">Step-by-step video guides and tutorials to help you master essential cooking techniques and create amazing dishes.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                        try {
                            require_once($_SERVER['DOCUMENT_ROOT'].'/food_fusion/db_connection.php');
                            $pdo = getConnection();
                            
                            $stmt = $pdo->prepare("
                                SELECT * FROM Resources 
                                WHERE type = 'cooking'
                                ORDER BY title ASC
                            ");
                            $stmt->execute();
                            $tutorials = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($tutorials as $tutorial) {
                                ?>
                                <div class="resource-card group relative bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:-translate-y-1">
                                    <!-- Thumbnail -->
                                    <div class="relative aspect-video overflow-hidden bg-neutral-800">
                                        <!-- Download button overlay -->
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6">
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                            <?= htmlspecialchars($tutorial['title']) ?>
                                        </h3>
                                        <div class="relative">
                                            <p class="text-gray-600 line-clamp-2 group-hover:line-clamp-none transition-all duration-300">
                                                <?= htmlspecialchars($tutorial['description']) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Resource Type Badge -->
                                    <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        Video
                                    </div>

                                    <!-- Download link -->
                                    <a href="download_resource.php?id=<?= $tutorial['ResourceID'] ?>"
                                       class="absolute inset-0 z-10" 
                                       aria-label="Download <?= htmlspecialchars($tutorial['title']) ?>">
                                    </a>
                                </div>
                                <?php
                            }
                        } catch (PDOException $e) {
                            echo '<div class="col-span-full text-center py-12">';
                            echo '<p class="text-gray-600">Unable to load cooking tutorials at this time.</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kitchen Hacks Section -->
        <section id="kitchen-hacks" class="scroll-mt-24">
            <div class="space-y-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-4xl font-bold text-gray-800">Kitchen Hacks</h2>
                    <p class="text-lg text-gray-600 mt-4">Discover time-saving tips and clever tricks to make your time in the kitchen more efficient and enjoyable.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    try {
                        $stmt = $pdo->prepare("
                            SELECT * FROM Resources 
                            WHERE type = 'info'
                            ORDER BY title ASC
                        ");
                        $stmt->execute();
                        $hacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($hacks as $hack) {
                            ?>
                            <div class="resource-card group relative bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:-translate-y-1">
                                <!-- Thumbnail -->
                                <div class="relative aspect-square overflow-hidden bg-neutral-800">
                                    <?php if ($hack['media'] === 'video'): ?>
                                        <!-- Download button overlay -->
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <img 
                                            src="<?= htmlspecialchars($hack['url']) ?>" 
                                            alt="<?= htmlspecialchars($hack['title']) ?>"
                                            class="w-full h-full object-cover"
                                        >
                                    <?php endif; ?>
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                        <?= htmlspecialchars($hack['title']) ?>
                                    </h3>
                                    <div class="relative">
                                        <p class="text-gray-600 line-clamp-2 group-hover:line-clamp-none transition-all duration-300">
                                            <?= htmlspecialchars($hack['description']) ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Resource Type Badge -->
                                <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-medium 
                                    <?= $hack['media'] === 'video' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' ?>">
                                    <?= ucfirst($hack['media']) ?>
                                </div>

                                <!-- Download link -->
                                <a href="download_resource.php?id=<?= $hack['ResourceID'] ?>"
                                   class="absolute inset-0 z-10" 
                                   aria-label="Download <?= htmlspecialchars($hack['title']) ?>">
                                </a>
                            </div>
                            <?php
                        }
                    } catch (PDOException $e) {
                        echo '<div class="col-span-full text-center py-12">';
                        echo '<p class="text-gray-600">Unable to load kitchen hacks at this time.</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Add required scripts -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            offset: 100,
            once: true
        });

        // Initialize Parallax
        const parallaxImages = document.querySelectorAll('[data-parallax="scroll"]');
        parallaxImages.forEach(image => {
            new simpleParallax(image, {
                scale: 1.2,
                delay: .6,
                transition: 'cubic-bezier(0,0,0,1)'
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>

<script>
function downloadRecipeCard(event, recipeId, title) {
    // Prevent the click from bubbling up to the recipe link
    event.preventDefault();
    event.stopPropagation();
    
    // Call the download function
    downloadRecipe(recipeId, title);
}
</script>

<!-- Add this before the footer -->
<script src="assets/js/recipe-download.js"></script>

<?php require_once 'footer.php'; ?>