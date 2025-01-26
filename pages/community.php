<h1>Community Cookbook</h1>

<?php if (isset($_SESSION['user_id'])): ?>
    <form id="recipe-submission" method="post" action="submit_recipe.php" class="space-y-6">
        <input type="text" name="title" placeholder="Recipe Title" required class="w-full px-4 py-2 border rounded-lg">
        <textarea name="description" placeholder="Recipe Description" required class="w-full px-4 py-2 border rounded-lg"></textarea>
        
        <!-- Time Fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="prep-time" class="block text-sm font-medium text-gray-700">Prep Time (minutes)</label>
                <input type="number" id="prep-time" name="prep-time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label for="cook-time" class="block text-sm font-medium text-gray-700">Cook Time (minutes)</label>
                <input type="number" id="cook-time" name="cook-time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label for="total-time" class="block text-sm font-medium text-gray-700">Total Time (minutes)</label>
                <input type="number" id="total-time" name="total-time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>

        <textarea name="ingredients" placeholder="Ingredients (one per line)" required class="w-full px-4 py-2 border rounded-lg"></textarea>
        <textarea name="instructions" placeholder="Instructions (one step per line)" required class="w-full px-4 py-2 border rounded-lg"></textarea>
        
        <select name="cuisine-type" required class="w-full px-4 py-2 border rounded-lg">
            <option value="">Select Cuisine Type</option>
            <option value="italian">Italian</option>
            <option value="mexican">Mexican</option>
            <option value="asian">Asian</option>
            <option value="mediterranean">Mediterranean</option>
            <option value="american">American</option>
            <option value="indian">Indian</option>
            <option value="french">French</option>
            <option value="other">Other</option>
        </select>
        
        <select name="dietary-preference" required class="w-full px-4 py-2 border rounded-lg">
            <option value="">Select Dietary Preference</option>
            <option value="vegetarian">Vegetarian</option>
            <option value="vegan">Vegan</option>
            <option value="gluten-free">Gluten Free</option>
            <option value="keto">Keto</option>
            <option value="paleo">Paleo</option>
            <option value="none">None</option>
        </select>
        
        <select name="difficulty" required class="w-full px-4 py-2 border rounded-lg">
            <option value="">Select Difficulty</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        
        <!-- Recipe Images Upload -->
        <div class="space-y-2">
            <label for="recipe-images" class="block text-sm font-medium text-gray-700">Recipe Images</label>
            <input type="file" id="recipe-images" name="recipe_images[]" accept="image/*" multiple 
                   class="w-full px-4 py-2 border rounded-lg text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-lg file:border-0
                          file:text-sm file:font-semibold
                          file:bg-primary-50 file:text-primary-700
                          hover:file:bg-primary-100">
            <p class="text-xs text-gray-500">You can upload multiple images. The first image will be used as the primary image.</p>
        </div>
        
        <button type="submit" class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">Submit Recipe</button>
    </form>
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