<?php
require_once 'db_connection.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Add New Recipe</h1>
    
    <form id="recipe-submission" method="post" action="submit_recipe.php" enctype="multipart/form-data" class="space-y-6">
        <input type="text" name="title" placeholder="Recipe Title" required class="w-full px-4 py-2 border rounded-lg">
        <textarea name="description" placeholder="Recipe Description" required class="w-full px-4 py-2 border rounded-lg h-32"></textarea>
        
        <!-- Time Fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="prep-time" class="block text-sm font-medium text-gray-700">Prep Time (minutes)</label>
                <input type="number" id="prep-time" name="prep_time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label for="cook-time" class="block text-sm font-medium text-gray-700">Cook Time (minutes)</label>
                <input type="number" id="cook-time" name="cook_time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label for="total-time" class="block text-sm font-medium text-gray-700">Total Time (minutes)</label>
                <input type="number" id="total-time" name="total_time" min="0" required class="w-full px-4 py-2 border rounded-lg" readonly>
            </div>
        </div>

        <div>
            <label for="ingredients" class="block text-sm font-medium text-gray-700 mb-2">Ingredients (one per line)</label>
            <textarea id="ingredients" name="ingredients" required class="w-full px-4 py-2 border rounded-lg h-40"></textarea>
        </div>

        <div>
            <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">Instructions (one step per line)</label>
            <textarea id="instructions" name="instructions" required class="w-full px-4 py-2 border rounded-lg h-40"></textarea>
        </div>
        
        <div>
            <label for="cuisine" class="block text-sm font-medium text-gray-700 mb-2">Cuisine Type</label>
            <select id="cuisine" name="cuisine" required class="w-full px-4 py-2 border rounded-lg">
                <option value="">Select Cuisine Type</option>
                <option value="American">American</option>
                <option value="Italian">Italian</option>
                <option value="Mexican">Mexican</option>
                <option value="Asian">Asian</option>
                <option value="Mediterranean">Mediterranean</option>
                <option value="French">French</option>
                <option value="Spanish">Spanish</option>
                <option value="Greek">Greek</option>
                <option value="Japanese">Japanese</option>
                <option value="International">International</option>
            </select>
        </div>
        
        <div>
            <label for="dietary-preference" class="block text-sm font-medium text-gray-700 mb-2">Dietary Preference</label>
            <select id="dietary-preference" name="dietary_preference" required class="w-full px-4 py-2 border rounded-lg">
                <option value="">Select Dietary Preference</option>
                <option value="None">None</option>
                <option value="Vegetarian">Vegetarian</option>
                <option value="Vegan">Vegan</option>
                <option value="Pescatarian">Pescatarian</option>
                <option value="Gluten-Free">Gluten-Free</option>
                <option value="Dairy-Free">Dairy-Free</option>
                <option value="Keto">Keto</option>
            </select>
        </div>
        
        <div>
            <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty Level</label>
            <select id="difficulty" name="difficulty" required class="w-full px-4 py-2 border rounded-lg">
                <option value="">Select Difficulty</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
        </div>
        
        <!-- Recipe Images Upload -->
        <div class="space-y-2">
            <label for="recipe-image-url" class="block text-sm font-medium text-gray-700">Recipe Image URL</label>
            <input type="url" 
                   id="recipe-image-url" 
                   name="image_url" 
                   placeholder="https://example.com/your-image.jpg"
                   class="w-full px-4 py-2 border rounded-lg text-sm text-gray-500">
            <p class="text-xs text-gray-500">Enter a URL to an image of your recipe</p>
        </div>
        
        <div class="flex justify-end gap-4">
            <button type="button" onclick="history.back()"
                    class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                Cancel
            </button>
            <button type="submit" 
                    class="px-6 py-3 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                Submit Recipe
            </button>
        </div>
    </form>
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

document.getElementById('recipe-submission').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = 'Submitting...';
    
    fetch('submit_recipe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response:', data);
        if (data.success && data.recipe_id) {
            window.location.href = `recipe.php?id=${data.recipe_id}`;
        } else {
            throw new Error(data.error || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting recipe: ' + error.message);
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    });
});
</script> 