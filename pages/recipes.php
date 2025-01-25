<h1 class="text-4xl font-display font-semibold mb-8">Recipe Collection</h1>

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
                    <button type="button" data-value="italian" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Italian</button>
                </li>
                <li>
                    <button type="button" data-value="mexican" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Mexican</button>
                </li>
                <li>
                    <button type="button" data-value="asian" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Asian</button>
                </li>
                <li>
                    <button type="button" data-value="mediterranean" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Mediterranean</button>
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
                    <button type="button" data-value="vegetarian" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Vegetarian</button>
                </li>
                <li>
                    <button type="button" data-value="vegan" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Vegan</button>
                </li>
                <li>
                    <button type="button" data-value="gluten-free" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Gluten Free</button>
                </li>
                <li>
                    <button type="button" data-value="keto" class="w-full px-4 py-2 hover:bg-neutral-100 text-left">Keto</button>
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
document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown selections
    const dropdowns = {
        cuisine: { button: document.getElementById('cuisine-dropdown'), options: document.getElementById('cuisine-options') },
        diet: { button: document.getElementById('diet-dropdown'), options: document.getElementById('diet-options') },
        difficulty: { button: document.getElementById('difficulty-dropdown'), options: document.getElementById('difficulty-options') }
    };

    // Initialize filters object
    const filters = {
        cuisine: '',
        diet: '',
        difficulty: ''
    };

    // Handle option selection for all dropdowns
    Object.keys(dropdowns).forEach(type => {
        if (dropdowns[type].options) {
            dropdowns[type].options.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    filters[type] = value;
                    dropdowns[type].button.querySelector('span').textContent = 
                        value ? this.textContent : `All ${type.charAt(0).toUpperCase() + type.slice(1)}s`;
                    
                    // Update recipes
                    updateRecipes(filters);
                });
            });
        }
    });

    // Function to update recipes
    function updateRecipes(filters) {
        $('#recipe-list').addClass('opacity-50 transition-opacity duration-300');
        
        $.ajax({
            url: 'fetch_recipes.php',
            method: 'GET',
            data: filters,
            success: function(response) {
                setTimeout(function() {
                    $('#recipe-list').html(response).removeClass('opacity-50');
                }, 300);
            }
        });
    }
});
</script>