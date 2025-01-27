<?php
require_once 'header.php';
require_once 'db_connection.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Add New Recipe</h1>
    
    <form id="recipe-form" method="post" action="submit_recipe.php" class="space-y-6">
        <input type="text" name="title" placeholder="Recipe Title" required class="w-full px-4 py-2 border rounded-lg">
        <textarea name="description" placeholder="Recipe Description" required class="w-full px-4 py-2 border rounded-lg"></textarea>
        
        <!-- Time Fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="prep_time" class="block text-sm font-medium text-gray-700">Prep Time (minutes)</label>
                <input type="number" id="prep_time" name="prep_time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label for="cook_time" class="block text-sm font-medium text-gray-700">Cook Time (minutes)</label>
                <input type="number" id="cook_time" name="cook_time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label for="total_time" class="block text-sm font-medium text-gray-700">Total Time (minutes)</label>
                <input type="number" id="total_time" name="total_time" min="0" required class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>

        <!-- Ingredients Section -->
        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">Ingredients</label>
            <div id="ingredients-list" class="space-y-2">
                <!-- Ingredients will be added here dynamically -->
            </div>
            <button type="button" 
                    onclick="addIngredient()"
                    class="inline-flex items-center px-3 py-1 border border-primary-500 text-primary-500 rounded-md hover:bg-primary-50 text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Ingredient
            </button>
        </div>

        <!-- Instructions Section -->
        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">Instructions</label>
            <div id="instructions-list" class="space-y-2">
                <!-- Instructions will be added here dynamically -->
            </div>
            <button type="button" 
                    onclick="addInstruction()"
                    class="inline-flex items-center px-3 py-1 border border-primary-500 text-primary-500 rounded-md hover:bg-primary-50 text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Instruction
            </button>
        </div>
        
        <!-- Hidden inputs for JSON data -->
        <input type="hidden" name="ingredients" id="ingredients-json">
        <input type="hidden" name="instructions" id="instructions-json">
        
        <!-- Rest of the form fields -->
        <select name="cuisine" required class="w-full px-4 py-2 border rounded-lg">
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
        
        <select name="dietary_preference" required class="w-full px-4 py-2 border rounded-lg">
            <option value="">Select Dietary Preference</option>
            <option value="None">None</option>
            <option value="Vegetarian">Vegetarian</option>
            <option value="Vegan">Vegan</option>
            <option value="Pescatarian">Pescatarian</option>
            <option value="Gluten-Free">Gluten-Free</option>
            <option value="Dairy-Free">Dairy-Free</option>
            <option value="Keto">Keto</option>
        </select>
        
        <select name="difficulty" required class="w-full px-4 py-2 border rounded-lg">
            <option value="">Select Difficulty</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        
        <!-- Recipe Images Upload -->
        <div class="space-y-2">
            <label for="recipe-image-url" class="block text-sm font-medium text-gray-700">Recipe Image URL</label>
            <input type="url" 
                   id="recipe-image-url" 
                   name="image_url" 
                   placeholder="https://example.com/your-image.jpg"
                   class="w-full px-4 py-2 border rounded-lg text-sm text-gray-500"
                   required>
            <p class="text-xs text-gray-500">Enter a URL to an image of your recipe</p>
        </div>
        
        <button type="submit" class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">Submit Recipe</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time calculation logic
    const prepTimeInput = document.getElementById('prep_time');
    const cookTimeInput = document.getElementById('cook_time');
    const totalTimeInput = document.getElementById('total_time');

    function updateTotalTime() {
        const prepTime = parseInt(prepTimeInput.value) || 0;
        const cookTime = parseInt(cookTimeInput.value) || 0;
        totalTimeInput.value = prepTime + cookTime;
    }

    prepTimeInput.addEventListener('input', updateTotalTime);
    cookTimeInput.addEventListener('input', updateTotalTime);

    // Add initial empty fields
    addIngredient();
    addInstruction();

    // Form submission handling
    document.getElementById('recipe-form').addEventListener('submit', function(e) {
        e.preventDefault();
        updateJSONFields();
        this.submit();
    });
});

function createDeleteButton() {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'ml-2 text-red-500 hover:text-red-700';
    button.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    `;
    button.onclick = function() {
        this.closest('.input-group').remove();
    };
    return button;
}

function addIngredient() {
    const container = document.createElement('div');
    container.className = 'input-group flex items-center';
    container.innerHTML = `
        <input type="text" 
               placeholder="Enter ingredient" 
               class="flex-1 px-4 py-2 border rounded-lg"
               required>
    `;
    container.appendChild(createDeleteButton());
    document.getElementById('ingredients-list').appendChild(container);
}

function addInstruction() {
    const container = document.createElement('div');
    container.className = 'input-group flex items-center';
    container.innerHTML = `
        <input type="text" 
               placeholder="Enter instruction step" 
               class="flex-1 px-4 py-2 border rounded-lg"
               required>
    `;
    container.appendChild(createDeleteButton());
    document.getElementById('instructions-list').appendChild(container);
}

function updateJSONFields() {
    // Collect ingredients
    const ingredients = Array.from(document.querySelectorAll('#ingredients-list input'))
        .map(input => input.value.trim())
        .filter(value => value !== '');
    document.getElementById('ingredients-json').value = JSON.stringify(ingredients);

    // Collect instructions
    const instructions = Array.from(document.querySelectorAll('#instructions-list input'))
        .map(input => input.value.trim())
        .filter(value => value !== '');
    document.getElementById('instructions-json').value = JSON.stringify(instructions);
}
</script>

<?php require_once 'footer.php'; ?> 