<?php
$page = 'contact';
require_once 'header.php';
?>

<main class="flex-grow pt-24 pb-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-neutral-900 mb-6">Thank You!</h1>
            <p class="text-neutral-600 text-lg md:text-xl mb-12">
                Your message has been successfully sent. We appreciate you reaching out to us and will get back to you as soon as possible.
            </p>
            <a href="index.php" 
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white 
                      bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500
                      transform hover:scale-105 active:scale-95 transition-all duration-200
                      shadow-[0_4px_14px_0_rgba(192,38,211,0.39)] hover:shadow-[0_6px_20px_0_rgba(192,38,211,0.39)]">
                Return to Home
            </a>
        </div>
    </div>
</main>

<?php require_once 'footer.php'; ?>