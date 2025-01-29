<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Current directory: " . __DIR__ . "<br>";
echo "Looking for header.php at: " . __DIR__ . '/header.php' . "<br>";

$headerPath = __DIR__ . '/header.php';
if (file_exists($headerPath)) {
    require_once $headerPath;
} else {
    echo "Header file not found at: $headerPath";
    exit;
}
?>

<div class="min-h-screen bg-gradient-to-b from-amber-50 to-white">
    <!-- Hero Section -->
    <div class="relative h-[50vh] overflow-hidden">
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://th.bing.com/th/id/R.dafd3090074a3bb7a5f40f9cad7f3b79?rik=Rw%2b%2brctxUfLXfA&pid=ImgRaw&r=0');" data-parallax="scroll" data-speed="0.5"></div>
        <div class="relative z-20 container mx-auto px-4 h-full flex items-center justify-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white text-center">Culinary Resources</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16 space-y-32">
        <!-- Culinary Resources Section -->
        <section id="culinary-resources" class="scroll-mt-24">
            <div class="grid grid-cols-1 md:grid-cols-golden gap-8">
                <div class="space-y-6">
                    <h2 class="text-4xl font-bold text-gray-800">Culinary Resources</h2>
                    <p class="text-lg text-gray-600">Discover our carefully curated collection of culinary resources, designed to enhance your cooking journey and expand your culinary knowledge.</p>
                    <div class="group hover:scale-105 transition-transform duration-300">
                        <div class="relative overflow-hidden rounded-xl aspect-golden">
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836" alt="Culinary Resources" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recipe Cards Section -->
        <section id="recipe-cards" class="scroll-mt-24">
            <div class="grid grid-cols-1 md:grid-cols-golden gap-8">
                <div class="space-y-6 order-2 md:order-1">
                    <div class="group hover:scale-105 transition-transform duration-300">
                        <div class="relative overflow-hidden rounded-xl aspect-golden">
                            <img src="https://images.unsplash.com/photo-1506806732259-39c2d0268443" alt="Recipe Cards" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6 order-1 md:order-2">
                    <h2 class="text-4xl font-bold text-gray-800">Downloadable Recipe Cards</h2>
                    <p class="text-lg text-gray-600">Access our collection of beautifully designed recipe cards, perfect for building your personal cookbook or sharing with friends and family.</p>
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