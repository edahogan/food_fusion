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
            <a href="#featured-recipes" class="inline-flex items-center justify-center px-6 py-3 text-lg font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
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

<!-- Featured Recipes Grid using Golden Ratio -->
<section id="featured-recipes" class="py-24 bg-neutral-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-display font-bold text-neutral-900 mb-12 text-center">Featured Recipes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Recipe Card 1 -->
            <div class="group relative overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:-translate-y-2">
                <img src="https://images.pexels.com/photos/5175537/pexels-photo-5175537.jpeg?auto=compress&cs=tinysrgb&w=640" 
                     srcset="https://images.pexels.com/photos/5175537/pexels-photo-5175537.jpeg?auto=compress&cs=tinysrgb&w=640 640w,
                             https://images.pexels.com/photos/5175537/pexels-photo-5175537.jpeg?auto=compress&cs=tinysrgb&w=1280 1280w"
                     sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                     alt="Ravioli with Tomato Sauce" 
                     class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy"
                     decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-xl font-bold mb-2">Homemade Ravioli</h3>
                    <p class="text-sm text-white/90">Classic Italian pasta filled with ricotta and spinach</p>
                </div>
            </div>

            <!-- Recipe Card 2 -->
            <div class="group relative overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:-translate-y-2">
                <img src="https://images.pexels.com/photos/2664216/pexels-photo-2664216.jpeg?auto=compress&cs=tinysrgb&w=640" 
                     srcset="https://images.pexels.com/photos/2664216/pexels-photo-2664216.jpeg?auto=compress&cs=tinysrgb&w=640 640w,
                             https://images.pexels.com/photos/2664216/pexels-photo-2664216.jpeg?auto=compress&cs=tinysrgb&w=1280 1280w"
                     sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                     alt="Spring Rolls" 
                     class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy"
                     decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-xl font-bold mb-2">Fresh Spring Rolls</h3>
                    <p class="text-sm text-white/90">Vietnamese-style rolls with vegetables and herbs</p>
                </div>
            </div>

            <!-- Recipe Card 3 -->
            <div class="group relative overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:-translate-y-2">
                <img src="https://img.freepik.com/free-photo/chicken-fajita-chicken-fillet-fried-with-bell-pepper-lavash-with-bread-slices-white-plate_1150-21760.jpg?w=640&q=80" 
                     srcset="https://img.freepik.com/free-photo/chicken-fajita-chicken-fillet-fried-with-bell-pepper-lavash-with-bread-slices-white-plate_1150-21760.jpg?w=640&q=80 640w,
                             https://img.freepik.com/free-photo/chicken-fajita-chicken-fillet-fried-with-bell-pepper-lavash-with-bread-slices-white-plate_1150-21760.jpg?w=1280&q=80 1280w"
                     sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                     alt="Chicken Fajitas" 
                     class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy"
                     decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-xl font-bold mb-2">Sizzling Chicken Fajitas</h3>
                    <p class="text-sm text-white/90">Mexican-style fajitas with bell peppers and onions</p>
                </div>
            </div>
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
            <a href="#" class="inline-flex items-center justify-center px-6 py-3 text-lg font-medium text-primary-600 bg-white hover:bg-neutral-100 rounded-lg transition-colors">
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
            <!-- Main Recipe (Golden Ratio: 1.618) -->
            <div class="md:col-span-2 group relative overflow-hidden rounded-xl shadow-lg">
                <img src="https://img.freepik.com/free-photo/fried-chicken-breast-with-vegetables_1339-7824.jpg?w=960&q=80" 
                     srcset="https://img.freepik.com/free-photo/fried-chicken-breast-with-vegetables_1339-7824.jpg?w=960&q=80 960w,
                             https://img.freepik.com/free-photo/fried-chicken-breast-with-vegetables_1339-7824.jpg?w=1440&q=80 1440w"
                     sizes="(max-width: 768px) 100vw, 66vw"
                     alt="Fried Chicken Breast" 
                     class="w-full h-[500px] object-cover transition-transform duration-500 group-hover:scale-105"
                     loading="lazy"
                     decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <h3 class="text-2xl font-bold text-white mb-3">Pan-Seared Chicken Breast</h3>
                    <p class="text-white/90">Perfectly seasoned chicken breast with roasted vegetables</p>
                </div>
            </div>
            <!-- Side Recipes -->
            <div class="space-y-8">
                <div class="group relative overflow-hidden rounded-xl shadow-lg">
                    <img src="https://img.freepik.com/free-photo/tasty-noodles-wrapped-around-fork_23-2148726890.jpg?w=640&q=80" 
                         srcset="https://img.freepik.com/free-photo/tasty-noodles-wrapped-around-fork_23-2148726890.jpg?w=640&q=80 640w,
                                 https://img.freepik.com/free-photo/tasty-noodles-wrapped-around-fork_23-2148726890.jpg?w=960&q=80 960w"
                         sizes="(max-width: 768px) 100vw, 33vw"
                         alt="Noodles" 
                         class="w-full h-[235px] object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy"
                         decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-xl font-bold text-white mb-2">Asian Noodle Bowl</h3>
                        <p class="text-sm text-white/90">Savory noodles with fresh vegetables</p>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-xl shadow-lg">
                    <img src="https://images.unsplash.com/photo-1590779033100-9f60a05a013d?auto=format&fit=crop&w=800" 
                         srcset="https://images.unsplash.com/photo-1590779033100-9f60a05a013d?auto=format&fit=crop&w=800 800w,
                                 https://images.unsplash.com/photo-1590779033100-9f60a05a013d?auto=format&fit=crop&w=1280 1280w"
                         sizes="(max-width: 768px) 100vw, 33vw"
                         alt="Fresh Vegetables" 
                         class="w-full h-[235px] object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy"
                         decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-xl font-bold text-white mb-2">Garden Fresh Salad</h3>
                        <p class="text-sm text-white/90">Colorful mix of seasonal vegetables</p>
                    </div>
                </div>
            </div>
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