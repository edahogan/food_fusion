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