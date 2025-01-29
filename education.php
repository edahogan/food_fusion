<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Resources - Food Fusion</title>
    <link href="../css/output.css" rel="stylesheet">
    <script src="https://unpkg.com/tailwindcss-golden-ratio"></script>
    <style>
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .image-overlay {
            transition: all 0.3s ease-in-out;
        }
        .image-overlay:hover {
            transform: scale(1.02);
        }
        @tailwind base;
        @tailwind components;
        @tailwind utilities;

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .group:hover .line-clamp-2 {
            -webkit-line-clamp: unset;
        }

        .resource-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/food_fusion/header.php'); ?>

    <!-- Hero Section -->
    <div class="relative h-[60vh] parallax rounded-xl" style="background-image: url('https://th.bing.com/th/id/OIG1.4YCRuRoct7kK2tK0omx0');">
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 to-black/50 flex items-center justify-center rounded-xl">
            <div class="text-center px-4">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">Educational Resources</h1>
                <p class="text-xl text-white/90 max-w-2xl mx-auto">Discover expert tips, tutorials, and guides to enhance your culinary journey</p>
            </div>
        </div>
    </div>

    <!-- Educational Resources Section -->
    <section class="px-0 md:px-0 max-w-7xl mx-auto mt-16 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            try {
                require_once($_SERVER['DOCUMENT_ROOT'].'/food_fusion/db_connection.php');
                $pdo = getConnection();
                
                $stmt = $pdo->prepare("
                    SELECT * FROM Resources 
                    WHERE type = 'educational'
                    ORDER BY title ASC
                ");
                $stmt->execute();
                $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resources as $resource) {
                    ?>
                    <div class="resource-card group relative bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:-translate-y-1">
                        <!-- Thumbnail -->
                        <div class="relative aspect-video overflow-hidden bg-neutral-800">
                            <?php if ($resource['media'] === 'video'): ?>
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
                                    src="<?= htmlspecialchars($resource['url']) ?>" 
                                    alt="<?= htmlspecialchars($resource['title']) ?>"
                                    class="w-full h-full object-cover"
                                >
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                <?= htmlspecialchars($resource['title']) ?>
                            </h3>
                            <div class="relative">
                                <p class="text-gray-600 line-clamp-2 group-hover:line-clamp-none transition-all duration-300">
                                    <?= htmlspecialchars($resource['description']) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Resource Type Badge -->
                        <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-medium 
                            <?= $resource['media'] === 'video' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' ?>">
                            <?= ucfirst($resource['media']) ?>
                        </div>

                        <!-- Download link -->
                        <a href="download_resource.php?id=<?= $resource['ResourceID'] ?>"
                           class="absolute inset-0 z-10" 
                           aria-label="Download <?= htmlspecialchars($resource['title']) ?>">
                        </a>
                    </div>
                    <?php
                }
            } catch (PDOException $e) {
                echo '<div class="col-span-full text-center py-12">';
                echo '<p class="text-gray-600">Unable to load educational resources at this time.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <script>
        // Smooth scroll implementation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Parallax effect
        window.addEventListener('scroll', function() {
            const parallax = document.querySelectorAll('.parallax');
            parallax.forEach(element => {
                let scrollPosition = window.pageYOffset;
                element.style.backgroundPositionY = scrollPosition * 0.5 + 'px';
            });
        });
    </script>

    </main>

    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/food_fusion/footer.php'); ?>
</body>
</html>