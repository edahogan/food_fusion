<?php 
require_once dirname(__DIR__) . '/header.php';
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
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group hover:scale-105 transition-transform duration-300">
                            <div class="relative overflow-hidden rounded-xl aspect-golden">
                                <img src="https://images.unsplash.com/photo-1457296898342-cdd24585d095" alt="Cooking Tutorial 1" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </div>
                        <div class="group hover:scale-105 transition-transform duration-300">
                            <div class="relative overflow-hidden rounded-xl aspect-golden">
                                <img src="https://static.vecteezy.com/system/resources/previews/024/524/034/original/woman-cooking-food-free-png.png" alt="Cooking Tutorial 2" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </div>
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
                    <div class="group hover:scale-105 transition-transform duration-300">
                        <div class="relative overflow-hidden rounded-xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1525755662778-989d0524087e" alt="Kitchen Hack 1" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h3 class="text-xl font-semibold">Organization Tips</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group hover:scale-105 transition-transform duration-300">
                        <div class="relative overflow-hidden rounded-xl aspect-square">
                            <img src="https://th.bing.com/th/id/OIP.cL1i1wNRcoMJXhI7qUtu4AHaHa?rs=1&pid=ImgDetMain" alt="Kitchen Hack 2" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h3 class="text-xl font-semibold">Time-Saving Tricks</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group hover:scale-105 transition-transform duration-300">
                        <div class="relative overflow-hidden rounded-xl aspect-square">
                            <img src="https://images.unsplash.com/photo-1510627498534-cf7e9002facc" alt="Kitchen Hack 3" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h3 class="text-xl font-semibold">Smart Solutions</h3>
                                </div>
                            </div>
                        </div>
                    </div>
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