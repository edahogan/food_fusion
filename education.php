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
    </style>
</head>
<body class="bg-gray-50">
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/food_fusion/header.php'); ?>

    <!-- Hero Section -->
    <div class="relative h-[60vh] parallax" style="background-image: url('https://images.unsplash.com/photo-1577106263724-2c8e03bfe9cf?auto=format&fit=crop&w=2000');">
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 to-black/50 flex items-center justify-center">
            <div class="text-center px-4">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">Educational Resources</h1>
                <p class="text-xl text-white/90 max-w-2xl mx-auto">Discover expert tips, tutorials, and guides to enhance your culinary journey</p>
            </div>
        </div>
    </div>

    <!-- Culinary Resources Section -->
    <section id="culinary-resources" class="py-16 px-4 md:px-8 max-w-7xl mx-auto">
        <div class="relative rounded-xl overflow-hidden mb-12">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=1600" 
                 alt="Culinary Background"
                 class="w-full h-48 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <h2 class="text-4xl font-bold text-white text-center">Culinary Resources</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 golden-ratio">
            <div class="image-overlay rounded-lg overflow-hidden shadow-xl">
                <img src="https://images.unsplash.com/photo-1556911261-6bd341186b2f?auto=format&fit=crop&w=1200" 
                     alt="Culinary Resource 1" 
                     class="w-full h-[400px] object-cover">
                <div class="p-6 bg-white">
                    <h3 class="text-xl font-semibold mb-2">Essential Kitchen Tools Guide</h3>
                    <p class="text-gray-600">Master the basics with our comprehensive guide to kitchen essentials.</p>
                </div>
            </div>
            <div class="image-overlay rounded-lg overflow-hidden shadow-xl">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200" 
                     alt="Culinary Resource 2" 
                     class="w-full h-[400px] object-cover">
                <div class="p-6 bg-white">
                    <h3 class="text-xl font-semibold mb-2">Ingredient Encyclopedia</h3>
                    <p class="text-gray-600">Explore our detailed guide to cooking ingredients and their uses.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Downloadable Recipe Cards Section -->
    <section id="recipe-cards" class="py-16 px-4 md:px-8 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Downloadable Recipe Cards</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 golden-ratio">
                <div class="image-overlay rounded-lg overflow-hidden shadow-xl bg-white">
                    <img src="https://images.unsplash.com/photo-1506806732259-39c2d0268443" 
                         alt="Recipe Card 1" 
                         class="w-full h-[300px] object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Seasonal Recipes Collection</h3>
                        <p class="text-gray-600 mb-4">Download our curated collection of seasonal recipes.</p>
                        <a href="#" class="inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">Download PDF</a>
                    </div>
                </div>
                <div class="image-overlay rounded-lg overflow-hidden shadow-xl bg-white">
                    <img src="https://images.unsplash.com/photo-1484723091739-30a097e8f929" 
                         alt="Recipe Card 2" 
                         class="w-full h-[300px] object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Quick & Easy Meals</h3>
                        <p class="text-gray-600 mb-4">30-minute recipes for busy weeknights.</p>
                        <a href="#" class="inline-block bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cooking Tutorials Section -->
    <section id="cooking-tutorials" class="py-16 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Cooking Tutorials</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 golden-ratio">
                <div class="image-overlay rounded-lg overflow-hidden shadow-xl relative group">
                    <img src="https://images.unsplash.com/photo-1457296898342-cdd24585d095" 
                         alt="Tutorial 1" 
                         class="w-full h-[400px] object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <a href="#" class="bg-white text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-100">Watch Tutorial</a>
                    </div>
                </div>
                <div class="image-overlay rounded-lg overflow-hidden shadow-xl relative group">
                    <img src="https://images.unsplash.com/photo-1495521821757-a1efb6729352?auto=format&fit=crop&w=1200" 
                         alt="Tutorial 2" 
                         class="w-full h-[400px] object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <a href="#" class="bg-white text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-100">Watch Tutorial</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kitchen Hacks Section -->
    <section id="kitchen-hacks" class="py-16 px-4 md:px-8 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Kitchen Hacks</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 golden-ratio">
                <div class="image-overlay rounded-lg overflow-hidden shadow-xl bg-white">
                    <img src="https://images.unsplash.com/photo-1525755662778-989d0524087e" 
                         alt="Kitchen Hack 1" 
                         class="w-full h-[250px] object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">Time-Saving Tips</h3>
                        <p class="text-gray-600">Quick tricks to speed up your cooking process.</p>
                    </div>
                </div>
                <div class="image-overlay rounded-lg overflow-hidden shadow-xl bg-white">
                    <img src="https://images.unsplash.com/photo-1584473457406-6240486418e9?auto=format&fit=crop&w=800" 
                         alt="Kitchen Hack 2" 
                         class="w-full h-[250px] object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">Food Storage Solutions</h3>
                        <p class="text-gray-600">Keep your ingredients fresh longer.</p>
                    </div>
                </div>
                <div class="image-overlay rounded-lg overflow-hidden shadow-xl bg-white">
                    <img src="https://images.unsplash.com/photo-1510627498534-cf7e9002facc" 
                         alt="Kitchen Hack 3" 
                         class="w-full h-[250px] object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">Smart Substitutions</h3>
                        <p class="text-gray-600">Creative ingredient alternatives for any recipe.</p>
                    </div>
                </div>
            </div>
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