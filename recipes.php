<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/food_fusion/db_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/food_fusion/header.php';

// Initialize the $conn variable
$conn = getConnection();

if (isset($_SESSION['user_id'])): ?>
<div class="mb-8">
    <a href="add_recipe.php" 
       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add New Recipe
    </a>
</div>
<?php endif; ?>

<?php
// Check if a specific user ID is provided via the "u" query parameter
$userIdFilter = isset($_GET['u']) ? intval($_GET['u']) : null;

// Fetch the user's name if filtering by user ID
$userName = null;
if ($userIdFilter) {
    $stmt = $conn->prepare("SELECT FirstName, LastName FROM Users WHERE UserID = :user_id");
    $stmt->execute(['user_id' => $userIdFilter]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $userName = htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']);
    } else {
        echo "<p class='text-red-500'>User not found.</p>";
        exit;
    }
}

// Modify the query to filter recipes by user ID if "u" is specified
$whereClause = $userIdFilter ? "WHERE r.UserID = :user_id" : "";
$query = "
    SELECT r.*, 
           u.FirstName, 
           u.LastName,
           ci.ImageURL as PrimaryImage
    FROM Recipes r
    LEFT JOIN Users u ON r.UserID = u.UserID
    LEFT JOIN ContentImages ci ON r.RecipeID = ci.RecipeID 
        AND ci.IsPrimary = 1 
        AND ci.ContentType = 'recipe'
    $whereClause
    ORDER BY r.CreatedAt DESC
";

$stmt = $conn->prepare($query);
$params = $userIdFilter ? ['user_id' => $userIdFilter] : [];
$stmt->execute($params);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-4xl font-display font-semibold mb-8">
    <?= $userIdFilter ? "Recipes by $userName" : "Recipe Collection" ?>
</h1>

<div id="recipe-filters" class="flex flex-col sm:flex-row gap-4 mb-8">
    <!-- Cuisine Type Dropdown -->
    <div class="relative w-full sm:w-auto">
        <button id="cuisine-dropdown" data-dropdown-toggle="cuisine-options" class="w-full inline-flex items-center justify-between px-4 py-2.5 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 focus:ring-4 focus:outline-none focus:ring-primary-100">
            <span class="mr-2">All Cuisines</span>
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <div id="cuisine-options" class="z-10 hidden bg-white divide-y divide-neutral-100 rounded-lg shadow w-full sm:w-44">
            <ul class="py-2 text-sm text-neutral-700" aria-labelledby="cuisine-dropdown">
                <li>
                    <button type="button" data-value="" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">All Cuisines</button>
                </li>
                <li>
                    <button type="button" data-value="American" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">American</button>
                </li>
                <li>
                    <button type="button" data-value="Italian" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Italian</button>
                </li>
                <li>
                    <button type="button" data-value="Mexican" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Mexican</button>
                </li>
                <li>
                    <button type="button" data-value="Asian" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Asian</button>
                </li>
                <li>
                    <button type="button" data-value="Mediterranean" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Mediterranean</button>
                </li>
                <li>
                    <button type="button" data-value="French" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">French</button>
                </li>
                <li>
                    <button type="button" data-value="Spanish" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Spanish</button>
                </li>
                <li>
                    <button type="button" data-value="Greek" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Greek</button>
                </li>
                <li>
                    <button type="button" data-value="Japanese" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Japanese</button>
                </li>
                <li>
                    <button type="button" data-value="International" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">International</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Dietary Preference Dropdown -->
    <div class="relative w-full sm:w-auto">
        <button id="diet-dropdown" data-dropdown-toggle="diet-options" class="w-full inline-flex items-center justify-between px-4 py-2.5 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 focus:ring-4 focus:outline-none focus:ring-primary-100">
            <span class="mr-2">All Diets</span>
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <div id="diet-options" class="z-10 hidden bg-white divide-y divide-neutral-100 rounded-lg shadow w-full sm:w-44">
            <ul class="py-2 text-sm text-neutral-700" aria-labelledby="diet-dropdown">
                <li>
                    <button type="button" data-value="" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">All Diets</button>
                </li>
                <li>
                    <button type="button" data-value="None" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">None</button>
                </li>
                <li>
                    <button type="button" data-value="Vegetarian" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Vegetarian</button>
                </li>
                <li>
                    <button type="button" data-value="Vegan" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Vegan</button>
                </li>
                <li>
                    <button type="button" data-value="Pescatarian" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Pescatarian</button>
                </li>
                <li>
                    <button type="button" data-value="Gluten-Free" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Gluten-Free</button>
                </li>
                <li>
                    <button type="button" data-value="Dairy-Free" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Dairy-Free</button>
                </li>
                <li>
                    <button type="button" data-value="Keto" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Keto</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Difficulty Dropdown -->
    <div class="relative w-full sm:w-auto">
        <button id="difficulty-dropdown" data-dropdown-toggle="difficulty-options" class="w-full inline-flex items-center justify-between px-4 py-2.5 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 focus:ring-4 focus:outline-none focus:ring-primary-100">
            <span class="mr-2">All Difficulties</span>
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <div id="difficulty-options" class="z-10 hidden bg-white divide-y divide-neutral-100 rounded-lg shadow w-full sm:w-44">
            <ul class="py-2 text-sm text-neutral-700" aria-labelledby="difficulty-dropdown">
                <li>
                    <button type="button" data-value="" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">All Difficulties</button>
                </li>
                <li>
                    <button type="button" data-value="easy" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Easy</button>
                </li>
                <li>
                    <button type="button" data-value="medium" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Medium</button>
                </li>
                <li>
                    <button type="button" data-value="hard" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Hard</button>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="recipe-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Recipe cards will be loaded here -->
</div>

<script>
// Initialize filters object in global scope
const filters = {
    cuisine: '',
    diet: '',
    difficulty: ''
};

// Function to update recipes
function updateRecipes() {
    const recipeList = document.getElementById('recipe-list');
    recipeList.classList.add('opacity-50');

    const queryString = Object.entries(filters)
        .filter(([_, value]) => value !== '')
        .map(([key, value]) => `${key}=${encodeURIComponent(value)}`)
        .join('&');

    // Fetch filtered recipes
    fetch(`fetch_recipes.php${queryString ? '?' + queryString : ''}`)
        .then(response => response.text())
        .then(html => {
            recipeList.innerHTML = html;
            recipeList.classList.remove('opacity-50');
        })
        .catch(error => {
            console.error('Error fetching recipes:', error);
            recipeList.innerHTML = '';
            recipeList.classList.remove('opacity-50');
        });
}

// Function to reset filters
function resetFilters() {
    // Reset dropdown button texts
    document.querySelector('#cuisine-dropdown span').textContent = 'All Cuisines';
    document.querySelector('#diet-dropdown span').textContent = 'All Diets';
    document.querySelector('#difficulty-dropdown span').textContent = 'All Difficulties';
    
    // Reset filter values
    filters.cuisine = '';
    filters.diet = '';
    filters.difficulty = '';
    
    // Update recipes with reset filters
    updateRecipes();
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown selections
    const dropdowns = {
        cuisine: { button: document.getElementById('cuisine-dropdown'), options: document.getElementById('cuisine-options') },
        diet: { button: document.getElementById('diet-dropdown'), options: document.getElementById('diet-options') },
        difficulty: { button: document.getElementById('difficulty-dropdown'), options: document.getElementById('difficulty-options') }
    };

    // Handle option selection for all dropdowns
    Object.keys(dropdowns).forEach(type => {
        if (dropdowns[type].options) {
            dropdowns[type].options.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.textContent;
                    
                    // Update button text
                    dropdowns[type].button.querySelector('span').textContent = text;
                    
                    // Update filters
                    filters[type] = value;
                    
                    // Update recipes with new filters
                    updateRecipes();
                });
            });
        }
    });

    // Load all recipes by default
    updateRecipes();
});
</script>

<?php require_once 'footer.php'; ?>