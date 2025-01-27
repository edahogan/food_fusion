<h1>Community Cookbook</h1>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="mb-8">
        <a href="add_recipe.php" 
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Share Your Recipe
        </a>
    </div>
<?php else: ?>
    <p>Please <a href="#" id="login-button" class="text-primary-600 hover:text-primary-700">log in</a> to submit your recipes.</p>
<?php endif; ?>

<div id="community-recipes">
    <!-- PHP code to fetch and display community recipes -->
</div>

<script>
// Auto-calculate total time when prep time or cook time changes
document.addEventListener('DOMContentLoaded', function() {
    const prepTimeInput = document.getElementById('prep-time');
    const cookTimeInput = document.getElementById('cook-time');
    const totalTimeInput = document.getElementById('total-time');

    function updateTotalTime() {
        const prepTime = parseInt(prepTimeInput.value) || 0;
        const cookTime = parseInt(cookTimeInput.value) || 0;
        totalTimeInput.value = prepTime + cookTime;
    }

    prepTimeInput.addEventListener('input', updateTotalTime);
    cookTimeInput.addEventListener('input', updateTotalTime);
});
</script>