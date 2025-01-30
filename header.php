<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rootPath = '';
if(!empty($_SERVER['DOCUMENT_ROOT'])) {
    $rootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_FILENAME']));
}
$page = htmlspecialchars($_GET['page'] ?? 'home', ENT_QUOTES, 'UTF-8');

function isCurrentPage($path) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $path;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion - <?php echo ucfirst($page); ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="js/main.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/food_fusion/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
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
        .font-display {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="bg-neutral-50 text-neutral-900 font-sans antialiased min-h-screen flex flex-col <?php echo isset($_SESSION['user_id']) ? 'logged-in' : ''; ?>">
    <header class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-neutral-200">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="<?php echo $rootPath; ?>/index.php" class="text-2xl font-display font-semibold text-neutral-900">FoodFusion</a>
                <div class="hidden xl:flex items-center space-x-8">
                    <a href="index.php" class="<?= isCurrentPage('index.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">Home</a>
                    <a href="about.php" class="<?= isCurrentPage('about.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">About Us</a>
                    <a href="recipes.php" class="<?= isCurrentPage('recipes.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">Recipes</a>
                    <a href="community.php" class="<?= isCurrentPage('community.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">Community</a>
                    <a href="resources.php" class="<?= isCurrentPage('resources.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">Resources</a>
                    <a href="education.php" class="<?= isCurrentPage('education.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">Education</a>
                    <a href="contact.php" class="<?= isCurrentPage('contact.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">Contact</a>
                    
                    <?php if (isLoggedIn()): ?>
                        <a href="profile.php" class="<?= isCurrentPage('profile.php') ? 'text-primary-600' : 'text-neutral-600 hover:text-neutral-900' ?> transition-colors">Profile</a>
                    <?php endif; ?>
                    
                    <?php if (isLoggedIn()): ?>
                        <!-- User Menu Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-neutral-600 hover:text-neutral-900">
                                <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="add_recipe.php" class="flex items-center px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add New Recipe
                                </a>
                                <a href="recipes.php?u=<?= $_SESSION['user_id'] ?>" class="flex items-center px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    My Recipes
                                </a>
                                <a href="profile.php" class="flex items-center px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile Settings
                                </a>
                                <div class="border-t border-neutral-200 my-1"></div>
                                <a href="logout.php" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-neutral-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center space-x-4">
                            <button id="login-button" class="text-primary-600 hover:text-primary-700 font-medium transition-colors">Login</button>
                            <button id="register-button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">Register</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button data-collapse-toggle="mobile-menu" type="button" class="xl:hidden p-2 text-neutral-600 hover:text-neutral-900">
                    <span class="sr-only">Open menu</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            <div class="hidden xl:hidden" id="mobile-menu">
                <div class="pt-2 pb-4 space-y-1">
                    <a href="index.php" class="block px-3 py-2 <?= isCurrentPage('index.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">Home</a>
                    <a href="about.php" class="block px-3 py-2 <?= isCurrentPage('about.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">About Us</a>
                    <a href="recipes.php" class="block px-3 py-2 <?= isCurrentPage('recipes.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">Recipes</a>
                    <a href="community.php" class="block px-3 py-2 <?= isCurrentPage('community.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">Community</a>
                    <a href="resources.php" class="block px-3 py-2 <?= isCurrentPage('resources.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">Resources</a>
                    <a href="education.php" class="block px-3 py-2 <?= isCurrentPage('education.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">Education</a>
                    <a href="contact.php" class="block px-3 py-2 <?= isCurrentPage('contact.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">Contact Us</a>
                    <?php if (isLoggedIn()): ?>
                        <a href="profile.php" class="block px-3 py-2 <?= isCurrentPage('profile.php') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900' ?>">Profile</a>
                        <a href="logout.php" class="block px-3 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-lg">Logout</a>
                    <?php else: ?>
                        <button id="login-button-mobile" class="block w-full text-left px-3 py-2 text-primary-600 hover:text-primary-700 font-medium">Login</button>
                        <button id="register-button-mobile" class="block w-full text-left px-3 py-2 text-white bg-primary-600 hover:bg-primary-700 rounded-lg">Register</button>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mx-auto px-4 pt-32 pb-12 flex-grow">