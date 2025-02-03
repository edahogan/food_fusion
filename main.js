// Show signup popup after 9 seconds if user is not logged in and we're on the homepage
if (!$('body').hasClass('logged-in')) {
    // Check if we're on the homepage by checking the URL path
    const isHomepage = window.location.pathname === '/' || 
                      window.location.pathname === '/index.php' ||
                      window.location.pathname.endsWith('/food_fusion/') ||
                      window.location.pathname.endsWith('/food_fusion/index.php');
    
    if (isHomepage) {
        // Check if the signup popup has been interacted with
        if (localStorage.getItem('signup-popup-interact') !== '' && !$('body').hasClass('logged-in')) {
            setTimeout(function() {
                const signupPopup = document.getElementById('signup-popup');
                if (signupPopup) {
                    const modalInstance = modals.signup || new Modal(signupPopup, {
                        placement: 'center',
                        backdrop: 'dynamic',
                        closable: true
                    });
                    modalInstance.show();
                }
            }, 9000);
        }
    }
} 

// Recipe filters with smooth transitions
$('#cuisine-type, #dietary-preference, #difficulty').change(function() {
    updateRecipes();
}); 

// Function to update recipes
function updateRecipes() {
    const recipeList = document.getElementById('recipe-list');
    recipeList.classList.add('opacity-50');

    let queryParams = Object.entries(filters)
        .filter(([_, value]) => value !== '')
        .map(([key, value]) => `${key}=${encodeURIComponent(value)}`);
    
    // Add user filter if it exists
    if (typeof currentUserFilter !== 'undefined') {
        queryParams.push(`u=${currentUserFilter}`);
    }

    // Get current page
    const currentPage = document.getElementById('current-page').value;
    queryParams.push(`page=${currentPage}`);

    const queryString = queryParams.join('&');

    // Fetch filtered recipes
    fetch(`fetch_recipes.php${queryString ? '?' + queryString : ''}`)
        .then(response => response.json())
        .then(data => {
            recipeList.innerHTML = data.html;
            recipeList.classList.remove('opacity-50');
            updatePaginationControls(parseInt(currentPage), data.totalPages);
        })
        .catch(error => {
            console.error('Error fetching recipes:', error);
            recipeList.innerHTML = '';
            recipeList.classList.remove('opacity-50');
        });
} 