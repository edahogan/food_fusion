<?php
$page = 'about';
require_once('header.php');
?>

<!-- Hero Section with Parallax -->
<section class="relative golden-height overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://tse2.mm.bing.net/th?id=OIP.vif9IUe5tKjh27zn0ftXFgHaE8&pid=Api" 
             alt="Chef Plating"
             class="w-full h-full object-cover"
             style="transform: translateZ(-1px) scale(1.5);"
             fetchpriority="high">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-transparent"></div>
    </div>
    <div class="relative h-full flex items-center">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-7xl font-display font-bold text-white mb-6 opacity-0 translate-y-8 animate-[fadeInUp_1s_ease-out_forwards]">Our Story</h1>
            <p class="text-xl md:text-2xl text-white/90 max-w-2xl mb-8 opacity-0 translate-y-8 animate-[fadeInUp_1s_ease-out_0.3s_forwards]">
                Discover the passion and dedication behind FoodFusion's journey to bring you the finest culinary experiences.
            </p>
        </div>
    </div>
</section>

<!-- Mission Section with Golden Ratio -->
<section class="py-24 bg-white">
    <div class="container mx-auto golden-padding">
        <div class="grid grid-cols-1 lg:grid-cols-golden golden-gap items-center">
            <!-- Content (Golden Ratio: 1) -->
            <div class="space-y-6 opacity-0 translate-y-8 golden-padding" data-aos="fade-up">
                <h2 class="text-4xl font-display font-bold text-neutral-900">Our Mission</h2>
                <p class="text-lg text-neutral-600 leading-relaxed">
                    At FoodFusion, we believe that great food has the power to bring people together and create lasting memories. Our mission is to inspire home cooks and food enthusiasts to explore the world of culinary arts, share their passion, and create extraordinary dishes that delight the senses.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <div class="flex items-center space-x-3 bg-neutral-50 p-4 rounded-xl">
                        <span class="text-4xl">🌟</span>
                        <div>
                            <h3 class="font-bold text-neutral-900">Quality First</h3>
                            <p class="text-sm text-neutral-600">Only the finest ingredients</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 bg-neutral-50 p-4 rounded-xl">
                        <span class="text-4xl">🌍</span>
                        <div>
                            <h3 class="font-bold text-neutral-900">Global Cuisine</h3>
                            <p class="text-sm text-neutral-600">Flavors from around the world</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Image (Golden Ratio: 0.618) -->
            <div class="lg:pl-12 opacity-0 translate-y-8 golden-aspect" data-aos="fade-up" data-aos-delay="200">
                <img src="https://tse3.mm.bing.net/th?id=OIP.SEoh2E4RMgBSMB34UHjfwAHaHa&pid=Api"
                     alt="Colorful Food"
                     class="w-full rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
            </div>
        </div>
    </div>
</section>

<!-- Team Section with Parallax -->
<section class="relative py-32 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://tse2.mm.bing.net/th?id=OIP.Zni-jBodqdDHlrLjjEgTTQHaFE&pid=Api"
             alt="Restaurant Atmosphere"
             class="w-full h-full object-cover"
             style="transform: translateZ(-1px) scale(1.5);"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/80"></div>
    </div>
    <div class="relative container mx-auto px-4 text-center">
        <h2 class="golden-text font-display font-bold text-white mb-16 opacity-0" data-aos="fade-up">Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 golden-gap">
            <!-- Team Member Cards -->
            <div class="group golden-padding" data-aos="fade-up" data-aos-delay="0">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 transform hover:-translate-y-2 transition-transform duration-300">
                    <img src="https://tse1.mm.bing.net/th?id=OIP.NGYPVUEeLwt_mlreIU7kjQHaHa&pid=Api"
                         alt="Chef Portrait"
                         class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-white/20">
                    <h3 class="text-xl font-bold text-white mb-2">Sarah Johnson</h3>
                    <p class="text-white/80">Executive Chef</p>
                </div>
            </div>
            <div class="group golden-padding" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 transform hover:-translate-y-2 transition-transform duration-300">
                    <img src="https://tse3.mm.bing.net/th?id=OIP.ed6zwMWIUvCLEMLT-ds6wgHaLH&pid=Api"
                         alt="Chef Portrait"
                         class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-white/20">
                    <h3 class="text-xl font-bold text-white mb-2">Michael Chen</h3>
                    <p class="text-white/80">Culinary Director</p>
                </div>
            </div>
            <div class="group golden-padding" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 transform hover:-translate-y-2 transition-transform duration-300">
                    <img src="https://tse4.mm.bing.net/th?id=OIP.8EjlJVjuK5r9cT3Ey-afIQHaFW&pid=Api"
                         alt="Chef Portrait"
                         class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-white/20">
                    <h3 class="text-xl font-bold text-white mb-2">Emma Martinez</h3>
                    <p class="text-white/80">Pastry Chef</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-24 bg-white">
    <div class="container mx-auto golden-padding">
        <h2 class="golden-text font-display font-bold text-neutral-900 text-center mb-16 opacity-0" data-aos="fade-up">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 golden-gap">
            <!-- Value Cards -->
            <div class="group" data-aos="fade-up" data-aos-delay="0">
                <div class="bg-neutral-50 rounded-xl golden-padding transform hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                    <div class="golden-aspect overflow-hidden rounded-lg mb-6">
                        <img src="https://tse1.mm.bing.net/th?id=OIP.Q0A01BkUS4EmTQXbuXsGYQHaJQ&pid=Api"
                             alt="Fresh Ingredients"
                             class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-4">Quality Ingredients</h3>
                    <p class="text-neutral-600">We source only the finest, freshest ingredients to ensure exceptional taste and quality in every dish.</p>
                </div>
            </div>
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-neutral-50 rounded-xl golden-padding transform hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                    <div class="golden-aspect overflow-hidden rounded-lg mb-6">
                        <img src="https://tse3.mm.bing.net/th?id=OIP.n7u1eDLkAnTGxP-7ZyavwQHaL4&pid=Api"
                             alt="Innovation"
                             class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-4">Culinary Innovation</h3>
                    <p class="text-neutral-600">We constantly explore new techniques and flavors to bring you unique and exciting culinary experiences.</p>
                </div>
            </div>
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-neutral-50 rounded-xl golden-padding transform hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                    <div class="golden-aspect overflow-hidden rounded-lg mb-6">
                        <img src="https://tse1.mm.bing.net/th?id=OIP.Qk-Usgn374Sc6o45-D1rnwHaLH&pid=Api"
                             alt="Community"
                             class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-4">Community Focus</h3>
                    <p class="text-neutral-600">We believe in building a strong community of food lovers who share our passion for great cuisine.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="relative golden-height overflow-hidden bg-primary-900">
    <div class="absolute inset-0 opacity-10">
        <img src="https://tse3.mm.bing.net/th?id=OIP.BsG_5TJXwfJu7spDQS3O_gHaLG&pid=Api"
             alt="Background Pattern"
             class="w-full h-full object-cover"
             style="transform: translateZ(-1px) scale(1.5);">
    </div>
    <div class="relative container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl font-display font-bold text-white mb-8 opacity-0" data-aos="fade-up">Join Our Culinary Journey</h2>
            <p class="text-xl text-white/90 mb-12 opacity-0" data-aos="fade-up" data-aos-delay="100">
                Be part of our growing community and discover the joy of cooking with FoodFusion.
            </p>
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-primary-900 bg-white hover:bg-neutral-100 rounded-xl transition-colors duration-300 transform hover:scale-105">
                Start Cooking Today
            </a>
        </div>
    </div>
</section>

<!-- Initialize AOS -->
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    });
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(2rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Golden Ratio Classes */
    .grid-cols-golden {
        grid-template-columns: 1fr 0.618fr;
    }
    
    .golden-padding {
        padding: calc(1rem * 1.618);
    }
    
    .golden-gap {
        gap: calc(1rem * 1.618);
    }
    
    .golden-margin {
        margin: calc(1rem * 1.618);
    }
    
    .golden-height {
        height: calc(100vh * 0.618);
    }
    
    .golden-width {
        width: calc(100% * 0.618);
    }
    
    .golden-text {
        font-size: calc(1rem * 1.618);
    }
    
    .golden-aspect {
        aspect-ratio: 1.618;
    }
</style>
