<!-- Hero Section with Parallax -->
<section class="relative h-screen overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://th.bing.com/th/id/OIG3.cUTd2t1EBzxaicope80r?w=1024&h=1024&rs=1&pid=ImgDetMain" 
             
             alt="Grilled Salmon Hero" 
             class="w-full h-full object-cover rounded-b-3xl"
             style="transform: translateZ(-1px) scale(2);"
             fetchpriority="high"
             loading="eager">
    </div>
    <div class="relative h-full flex items-center justify-center text-center">
        <div class="max-w-4xl px-6 bg-black/40 p-8 rounded-xl backdrop-blur-sm">
            <h1 class="text-5xl md:text-6xl font-display font-bold text-white mb-6">Welcome to FoodFusion</h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8">Discover a world of culinary delights and connect with food enthusiasts from around the globe.</p>
            <a href="recipes.php" class="inline-flex items-center justify-center px-6 py-3 text-lg font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                Explore Recipes
            </a>
        </div>
    </div>
</section>

<!-- Events Carousel Section -->
<section class="py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-display font-bold text-neutral-900 mb-12 text-center">Upcoming Events</h2>
        
        <!-- Flowbite Carousel -->
        <div id="events-carousel" class="relative w-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-[28rem] overflow-hidden rounded-xl">
                <!-- Event 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="absolute block w-full h-full">
                        <img src="https://th.bing.com/th/id/OIG3.11.YVWBZcnlUpicF3H6G" 
                             class="absolute block w-full h-full object-cover"
                             alt="Artisanal Bread Making Workshop">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <span class="px-3 py-1 text-sm font-medium bg-primary-100 text-primary-700 rounded-full">March 15, 2024</span>
                            <h3 class="text-2xl font-bold mt-4 mb-2">Artisanal Bread Making Workshop</h3>
                            <p class="text-white/90 mb-4">Master the art of bread making with our expert bakers. Learn to create crusty sourdough, fluffy brioche, and rustic country loaves.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-white/80">Culinary Institute Kitchen Lab A</span>
                                <button class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Event 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="absolute block w-full h-full">
                        <img src="https://th.bing.com/th/id/OIG3.YxWwtgFegge_6_QG9hgR" 
                             class="absolute block w-full h-full object-cover"
                             alt="Farm-to-Table Cooking Experience">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <span class="px-3 py-1 text-sm font-medium bg-primary-100 text-primary-700 rounded-full">March 20, 2024</span>
                            <h3 class="text-2xl font-bold mt-4 mb-2">Farm-to-Table Cooking Experience</h3>
                            <p class="text-white/90 mb-4">Join us for a unique experience where you'll harvest fresh ingredients from our partner farm and learn to transform them into delicious seasonal dishes.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-white/80">Green Meadows Farm & Kitchen</span>
                                <button class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Event 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="absolute block w-full h-full">
                        <img src="https://th.bing.com/th/id/OIG1.gWeZLtdAYDaVmUjMn3Z4" 
                             class="absolute block w-full h-full object-cover"
                             alt="Asian Fusion Masterclass">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <span class="px-3 py-1 text-sm font-medium bg-primary-100 text-primary-700 rounded-full">March 25, 2024</span>
                            <h3 class="text-2xl font-bold mt-4 mb-2">Asian Fusion Masterclass</h3>
                            <p class="text-white/90 mb-4">Explore the exciting world of Asian fusion cuisine. Learn to combine traditional Asian flavors with modern cooking techniques.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-white/80">Asian Fusion Culinary Center</span>
                                <button class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-1/2 left-4 z-30 flex items-center justify-center h-10 w-10 rounded-full bg-white/30 backdrop-blur-sm hover:bg-white/50 focus:outline-none group" data-carousel-prev>
                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
            </button>
            <button type="button" class="absolute top-1/2 right-4 z-30 flex items-center justify-center h-10 w-10 rounded-full bg-white/30 backdrop-blur-sm hover:bg-white/50 focus:outline-none group" data-carousel-next>
                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
            </button>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full bg-white/50" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            </div>
        </div>
    </div>
</section>

<!-- Featured Recipes Grid -->
<section id="featured-recipes" class="py-24 bg-neutral-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-display font-bold text-neutral-900 mb-12 text-center">Featured Recipes</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            // Fetch featured recipes from database
            try {
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
                    LIMIT 3
                ");
                $stmt->execute();
                $featuredRecipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($featuredRecipes as $recipe) {
                    $primaryImage = !empty($recipe['PrimaryImage']) ? $recipe['PrimaryImage'] : 'https://via.placeholder.com/800x600';
                    ?>
                    <div class="recipe-card group relative overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:-translate-y-2">
                        <!-- Primary Image -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="<?= htmlspecialchars($primaryImage) ?>" 
                                 alt="<?= htmlspecialchars($recipe['Title']) ?>" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy"
                                 decoding="async">
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
                    </div>
                    <?php
                }
            } catch (PDOException $e) {
                error_log("Database Error: " . $e->getMessage());
                // Show a graceful fallback message if there's an error
                echo '<div class="col-span-3 text-center py-12">';
                echo '<p class="text-neutral-600">Unable to load featured recipes at this time.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Ingredients Section with Parallax -->
<section class="relative py-32 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.pexels.com/photos/1435896/pexels-photo-1435896.jpeg?auto=compress&cs=tinysrgb&w=1280" 
             srcset="https://images.pexels.com/photos/1435896/pexels-photo-1435896.jpeg?auto=compress&cs=tinysrgb&w=800 800w,
                     https://images.pexels.com/photos/1435896/pexels-photo-1435896.jpeg?auto=compress&cs=tinysrgb&w=1280 1280w,
                     https://images.pexels.com/photos/1435896/pexels-photo-1435896.jpeg?auto=compress&cs=tinysrgb&w=1920 1920w"
             sizes="100vw"
             alt="Fresh Ingredients" 
             class="w-full h-full object-cover rounded-3xl"
             style="transform: translateZ(-1px) scale(1.5);"
             loading="lazy"
             decoding="async">
    </div>
    <div class="relative container mx-auto px-4 text-center">
        <div class="bg-black/40 p-8 rounded-xl backdrop-blur-sm inline-block">
            <h2 class="text-4xl font-display font-bold text-white mb-8">Fresh Ingredients Matter</h2>
            <p class="text-xl text-white/90 max-w-2xl mx-auto mb-12">We believe in using only the finest, freshest ingredients to create extraordinary dishes that delight the senses.</p>
            <a href="about.php" class="inline-flex items-center justify-center px-6 py-3 text-lg font-medium text-primary-600 bg-white hover:bg-neutral-100 rounded-lg transition-colors">
                Learn More
            </a>
        </div>
    </div>
</section>

<!-- Latest Recipes with Golden Ratio Grid -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-display font-bold text-neutral-900 mb-12 text-center">Latest Recipes</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            try {
                $pdo = getConnection();
                // Fetch latest recipes, including the primary recipe
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
                $latestRecipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($latestRecipes)) {
                    // Display the first recipe in the larger grid space
                    $mainRecipe = $latestRecipes[0];
                    $mainImage = !empty($mainRecipe['PrimaryImage']) ? $mainRecipe['PrimaryImage'] : 'https://via.placeholder.com/800x600';
                    ?>
                    <!-- Main Recipe (Golden Ratio: 1.618) -->
                    <div class="md:col-span-2 group relative overflow-hidden rounded-xl shadow-lg">
                        <img src="<?= htmlspecialchars($mainImage) ?>" 
                             alt="<?= htmlspecialchars($mainRecipe['Title']) ?>" 
                             class="w-full h-[500px] object-cover transition-transform duration-500 group-hover:scale-105"
                             loading="lazy"
                             decoding="async">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <h3 class="text-2xl font-bold text-white mb-3"><?= htmlspecialchars($mainRecipe['Title']) ?></h3>
                            <p class="text-white/90"><?= htmlspecialchars($mainRecipe['Description']) ?></p>
                        </div>
                        <a href="recipe.php?id=<?= $mainRecipe['RecipeID'] ?>" class="absolute inset-0" aria-label="View recipe"></a>
                    </div>

                    <!-- Side Recipes -->
                    <div class="space-y-8">
                        <?php
                        // Display the next 2 recipes in smaller spaces
                        for ($i = 1; $i < min(3, count($latestRecipes)); $i++) {
                            $recipe = $latestRecipes[$i];
                            $image = !empty($recipe['PrimaryImage']) ? $recipe['PrimaryImage'] : 'https://via.placeholder.com/800x600';
                            ?>
                            <div class="group relative overflow-hidden rounded-xl shadow-lg">
                                <img src="<?= htmlspecialchars($image) ?>" 
                                     alt="<?= htmlspecialchars($recipe['Title']) ?>" 
                                     class="w-full h-[235px] object-cover transition-transform duration-500 group-hover:scale-105"
                                     loading="lazy"
                                     decoding="async">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-xl font-bold text-white mb-2"><?= htmlspecialchars($recipe['Title']) ?></h3>
                                    <p class="text-sm text-white/90"><?= htmlspecialchars($recipe['Description']) ?></p>
                                </div>
                                <a href="recipe.php?id=<?= $recipe['RecipeID'] ?>" class="absolute inset-0" aria-label="View recipe"></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    // Show a message if no recipes are found
                    echo '<div class="col-span-3 text-center py-12">';
                    echo '<p class="text-neutral-600">No recipes available at this time.</p>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                error_log("Database Error: " . $e->getMessage());
                // Show a graceful fallback message if there's an error
                echo '<div class="col-span-3 text-center py-12">';
                echo '<p class="text-neutral-600">Unable to load latest recipes at this time.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Join Community Section -->
<section class="py-24 bg-neutral-50">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-display font-bold text-neutral-900 mb-8">Join Our Culinary Community</h2>
        <p class="text-xl text-neutral-600 max-w-2xl mx-auto mb-12">Connect with food lovers, share your recipes, and explore endless culinary possibilities.</p>
        <button id="join-us-button" class="inline-flex items-center justify-center px-6 py-3 text-lg font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
            Join Now
        </button>
    </div>
</section>

<!-- Hidden Join Us Popup -->
<div id="join-us-popup" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50">
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl p-8 max-w-md w-full">
        <h2 class="text-2xl font-display font-bold text-neutral-900 mb-6">Join FoodFusion</h2>
        <form id="signup-form" class="space-y-4">
            <input type="text" name="firstName" placeholder="First Name" required
                   class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <input type="text" name="lastName" placeholder="Last Name" required
                   class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <input type="email" name="email" placeholder="Email" required
                   class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <button type="submit"
                    class="w-full px-6 py-3 text-lg font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                Sign Up
            </button>
        </form>
        <button class="close absolute top-4 right-4 text-neutral-400 hover:text-neutral-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>