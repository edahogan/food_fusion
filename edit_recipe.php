<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'header.php';
require_once 'db_connection.php';

if (!$conn) {
    die("Database connection failed");
}

if (!isset($_SESSION['user_id'])) {
    echo "Not logged in"; // Temporary debug message
    header('Location: login.php');
    exit;
}

$recipe = null;
$error = null;

if (isset($_GET['id'])) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            SELECT * FROM Recipes 
            WHERE RecipeID = :id AND UserID = :user_id
        ");
        
        $stmt->execute([
            'id' => $_GET['id'],
            'user_id' => $_SESSION['user_id']
        ]);
        
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            $error = "Recipe not found or unauthorized";
        }
    } catch (Exception $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!-- Add container with proper Tailwind classes -->
<main class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php else: ?>
            <h1 class="text-3xl font-bold mb-8 text-gray-900"><?= $recipe ? 'Edit Recipe' : 'Create New Recipe' ?></h1>
            
            <!-- Add proper form styling -->
            <form id="recipe-form" class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <?php if ($recipe): ?>
                    <input type="hidden" name="recipe_id" value="<?= $recipe['RecipeID'] ?>">
                <?php endif; ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" required
                           value="<?= htmlspecialchars($recipe['Title'] ?? '') ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" required rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    ><?= htmlspecialchars($recipe['Description'] ?? '') ?></textarea>
                </div>

                <!-- Time Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="prep_time" class="block text-sm font-medium text-gray-700">Prep Time (minutes)</label>
                        <input type="number" id="prep_time" name="prep_time" min="0" required 
                               value="<?= htmlspecialchars($recipe['PrepTime'] ?? '') ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label for="cook_time" class="block text-sm font-medium text-gray-700">Cook Time (minutes)</label>
                        <input type="number" id="cook_time" name="cook_time" min="0" required
                               value="<?= htmlspecialchars($recipe['CookTime'] ?? '') ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label for="total_time" class="block text-sm font-medium text-gray-700">Total Time (minutes)</label>
                        <input type="number" id="total_time" name="total_time" min="0" required
                               value="<?= htmlspecialchars($recipe['TotalTime'] ?? '') ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <!-- Ingredients Section -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700">Ingredients</label>
                    <div id="ingredients-list" class="space-y-2">
                        <?php 
                        $ingredients = $recipe ? json_decode($recipe['Ingredients'], true) : [];
                        if (!empty($ingredients)):
                            foreach ($ingredients as $ingredient): ?>
                                <div class="input-group flex items-center">
                                    <input type="text" value="<?= htmlspecialchars($ingredient) ?>"
                                           class="flex-1 px-4 py-2 border rounded-lg" required>
                                    <button type="button" onclick="this.parentElement.remove()"
                                            class="ml-2 text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                    <button type="button" onclick="addIngredient()"
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
                        <?php 
                        $instructions = $recipe ? json_decode($recipe['Instructions'], true) : [];
                        if (!empty($instructions)):
                            foreach ($instructions as $instruction): ?>
                                <div class="input-group flex items-center">
                                    <input type="text" value="<?= htmlspecialchars($instruction) ?>"
                                           class="flex-1 px-4 py-2 border rounded-lg" required>
                                    <button type="button" onclick="this.parentElement.remove()"
                                            class="ml-2 text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                    <button type="button" onclick="addInstruction()"
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

                <!-- Recipe Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cuisine Type</label>
                        <select name="cuisine" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Select Cuisine Type</option>
                            <?php
                            $cuisines = ['American', 'Italian', 'Mexican', 'Asian', 'Mediterranean', 'French', 'Spanish', 'Greek', 'Japanese', 'International'];
                            foreach ($cuisines as $cuisine):
                                $selected = ($recipe['Cuisine'] ?? '') === $cuisine ? 'selected' : '';
                            ?>
                                <option value="<?= $cuisine ?>" <?= $selected ?>><?= $cuisine ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dietary Preference</label>
                        <select name="dietary_preference" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Select Dietary Preference</option>
                            <?php
                            $preferences = ['None', 'Vegetarian', 'Vegan', 'Pescatarian', 'Gluten-Free', 'Dairy-Free', 'Keto'];
                            foreach ($preferences as $pref):
                                $selected = ($recipe['DietaryPreference'] ?? '') === $pref ? 'selected' : '';
                            ?>
                                <option value="<?= $pref ?>" <?= $selected ?>><?= $pref ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Difficulty</label>
                        <select name="difficulty" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Select Difficulty</option>
                            <?php
                            $difficulties = ['easy', 'medium', 'hard'];
                            foreach ($difficulties as $diff):
                                $selected = ($recipe['Difficulty'] ?? '') === $diff ? 'selected' : '';
                            ?>
                                <option value="<?= $diff ?>" <?= $selected ?>><?= ucfirst($diff) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Recipe Image URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Recipe Image URL</label>
                    <input type="url" name="image_url" required
                           value="<?= htmlspecialchars($recipe['ImageURL'] ?? '') ?>"
                           placeholder="https://example.com/your-image.jpg"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="history.back()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
                        <?= $recipe ? 'Update Recipe' : 'Create Recipe' ?>
                    </button>
                </div>
            </form>

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

                    // Add initial empty fields if no recipe
                    if (!document.querySelector('#ingredients-list .input-group')) {
                        addIngredient();
                    }
                    if (!document.querySelector('#instructions-list .input-group')) {
                        addInstruction();
                    }

                    // Form submission handling
                    document.getElementById('recipe-form').addEventListener('submit', function(e) {
                        e.preventDefault();
                        updateJSONFields();
                        
                        const formData = new FormData(this);
                        
                        fetch('recipe_management.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text().then(text => {
                                console.log('Raw response:', text);
                                try {
                                    return JSON.parse(text);
                                } catch (e) {
                                    console.error('Failed to parse JSON:', e);
                                    throw new Error('Invalid JSON response');
                                }
                            });
                        })
                        .then(data => {
                            if (data.success) {
                                window.location.href = `recipe.php?id=${data.recipe_id}`;
                            } else {
                                alert('Error: ' + (data.errors ? data.errors.join('\n') : 'Unknown error'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error submitting recipe. Please try again.');
                        });
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
        <?php endif; ?>
    </div>
</main>

<?php require_once 'footer.php'; ?> 