<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion - <?php echo ucfirst($page); ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="js/main.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {"50":"#fdf4ff","100":"#fae8ff","200":"#f5d0fe","300":"#f0abfc","400":"#e879f9","500":"#d946ef","600":"#c026d3","700":"#a21caf","800":"#86198f","900":"#701a75","950":"#4a044e"},
                        neutral: {"50":"#fafafa","100":"#f5f5f5","200":"#e5e5e5","300":"#d4d4d4","400":"#a3a3a3","500":"#737373","600":"#525252","700":"#404040","800":"#262626","900":"#171717","950":"#0a0a0a"}
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                        'display': ['Playfair Display', 'serif']
                    },
                    spacing: {
                        '128': '32rem',
                    },
                    transitionTimingFunction: {
                        'smooth': 'cubic-bezier(0.4, 0, 0.2, 1)',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');
    </style>
</head>
<body class="bg-neutral-50 text-neutral-900 font-sans antialiased min-h-screen flex flex-col">
    <header class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-neutral-200">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="index.php" class="text-2xl font-display font-semibold text-neutral-900">FoodFusion</a>
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="index.php" class="text-neutral-600 hover:text-neutral-900 transition-colors">Home</a>
                    <a href="index.php?page=about" class="text-neutral-600 hover:text-neutral-900 transition-colors">About Us</a>
                    <a href="index.php?page=recipes" class="text-neutral-600 hover:text-neutral-900 transition-colors">Recipes</a>
                    <a href="index.php?page=community" class="text-neutral-600 hover:text-neutral-900 transition-colors">Community</a>
                    <a href="index.php?page=resources" class="text-neutral-600 hover:text-neutral-900 transition-colors">Resources</a>
                    <a href="index.php?page=education" class="text-neutral-600 hover:text-neutral-900 transition-colors">Education</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">Logout</a>
                    <?php else: ?>
                        <div class="flex items-center space-x-4">
                            <button id="login-button" class="text-primary-600 hover:text-primary-700 font-medium transition-colors">Login</button>
                            <button id="register-button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">Register</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button data-collapse-toggle="mobile-menu" type="button" class="lg:hidden p-2 text-neutral-600 hover:text-neutral-900">
                    <span class="sr-only">Open menu</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            <div class="hidden lg:hidden" id="mobile-menu">
                <div class="pt-2 pb-4 space-y-1">
                    <a href="index.php" class="block px-3 py-2 text-neutral-600 hover:text-neutral-900">Home</a>
                    <a href="index.php?page=about" class="block px-3 py-2 text-neutral-600 hover:text-neutral-900">About Us</a>
                    <a href="index.php?page=recipes" class="block px-3 py-2 text-neutral-600 hover:text-neutral-900">Recipes</a>
                    <a href="index.php?page=community" class="block px-3 py-2 text-neutral-600 hover:text-neutral-900">Community</a>
                    <a href="index.php?page=resources" class="block px-3 py-2 text-neutral-600 hover:text-neutral-900">Resources</a>
                    <a href="index.php?page=education" class="block px-3 py-2 text-neutral-600 hover:text-neutral-900">Education</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="block px-3 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-lg">Logout</a>
                    <?php else: ?>
                        <button id="login-button-mobile" class="block w-full text-left px-3 py-2 text-primary-600 hover:text-primary-700 font-medium">Login</button>
                        <button id="register-button-mobile" class="block w-full text-left px-3 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-lg">Register</button>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mx-auto px-4 pt-24 pb-12 flex-grow">