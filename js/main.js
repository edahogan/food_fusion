$(document).ready(function() {
    // Initialize Flowbite
    initFlowbite();

    // Parallax scrolling effect
    window.addEventListener('scroll', function() {
        const parallaxElements = document.querySelectorAll('[style*="translateZ"]');
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const speed = 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateZ(${element.style.transform.split('translateZ')[1].split(')')[0]}) translateY(${yPos}px)`;
        });
    });

    // Add smooth reveal animations on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('motion-safe:animate-fadeIn');
                entry.target.style.opacity = 1;
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.group').forEach((el) => {
        el.style.opacity = 0;
        observer.observe(el);
    });

    // Show signup popup after 9 seconds if user is not logged in and we're on the homepage
    if (!$('body').hasClass('logged-in')) {
        // Check if we're on the homepage by checking the URL path
        const isHomepage = window.location.pathname === '/' || 
                          window.location.pathname === '/index.php' ||
                          window.location.pathname.endsWith('/food_fusion/') ||
                          window.location.pathname.endsWith('/food_fusion/index.php');
        
        if (isHomepage) {
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

    // Replace the ensureModalInitialization function and its usage
    function ensureModalInitialization(modalId) {
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            // Create new Modal instance if it doesn't exist
            return new Modal(modalElement, {
                placement: 'center',
                backdrop: 'dynamic',
                closable: true
            });
        }
        return null;
    }

    // Initialize modals after DOM is ready
    const modals = {
        login: ensureModalInitialization('login-modal'),
        register: ensureModalInitialization('register-modal'),
        signup: ensureModalInitialization('signup-popup'),
        cookieSettings: ensureModalInitialization('cookie-settings-modal'),
        'forgot-password-modal': ensureModalInitialization('forgot-password-modal')
    };

    // Make modals available globally if needed
    window.modals = modals;

    // Handle modal close buttons
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) {
                const modalInstance = modals[modalId] || new Modal(modal);
                modalInstance.hide();
            }
        });
    });

    // Handle modal transitions between signup/login/register
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', function() {
            const hideModalId = this.getAttribute('data-modal-hide');
            const showModalId = this.getAttribute('data-modal-target');

            // Hide current modal
            if (hideModalId) {
                const currentModal = document.getElementById(hideModalId);
                if (currentModal && modals[hideModalId]) {
                    modals[hideModalId].hide();
                }
            }

            // Show new modal after a short delay
            if (showModalId) {
                setTimeout(() => {
                    const newModal = document.getElementById(showModalId);
                    if (newModal) {
                        const modalInstance = modals[showModalId] || new Modal(newModal);
                        modalInstance.show();
                    }
                }, 300);
            }
        });
    });

    // Handle login button in header
    $('#login-button, #login-button-mobile').click(function(e) {
        e.preventDefault();
        const loginModal = document.getElementById('login-modal');
        if (loginModal) {
            modals.login.show();
        }
    });

    // Handle register button in header
    $('#register-button, #register-button-mobile').click(function(e) {
        e.preventDefault();
        const registerModal = document.getElementById('register-modal');
        if (registerModal) {
            modals.register.show();
        }
    });

    // Handle forgot password link
    $('#forgot-password-link').click(function(e) {
        e.preventDefault();
        const forgotPasswordModal = document.getElementById('forgot-password-modal');
        if (forgotPasswordModal) {
            modals['forgot-password-modal'].show();
        }
    });

    // Cookie consent management
    const cookieConsent = {
        essential: true, // Essential cookies are always enabled
        functional: localStorage.getItem('cookieConsent_functional') === 'true',
        analytics: localStorage.getItem('cookieConsent_analytics') === 'true',
        marketing: localStorage.getItem('cookieConsent_marketing') === 'true'
    };

    // Show cookie notice if no preferences are set
    if (window.location.pathname === '/' || 
        window.location.pathname === '/index.php' ||
        window.location.pathname.endsWith('/food_fusion/') ||
        window.location.pathname.endsWith('/food_fusion/index.php')) {
        $('#cookie-notice').fadeIn();
    }

    // Handle cookie preferences
    $('#accept-cookies').click(function() {
        localStorage.setItem('cookiesAccepted', 'true');
        // Enable all cookies by default when accepting
        localStorage.setItem('cookieConsent_functional', 'true');
        localStorage.setItem('cookieConsent_analytics', 'true');
        localStorage.setItem('cookieConsent_marketing', 'true');
        $('#cookie-notice').fadeOut();
        
        // Initialize third-party services based on consent
        initializeThirdPartyServices();
    });

    // Handle cookie settings modal
    $('#open-cookie-settings').click(function(e) {
        e.preventDefault();
        const cookieModal = document.getElementById('cookie-settings-modal');
        if (cookieModal) {
            if (!modals.cookieSettings) {
                modals.cookieSettings = new Modal(cookieModal, {
                    placement: 'center',
                    backdrop: 'dynamic',
                    closable: true
                });
            }
            modals.cookieSettings.show();
        }
    });

    // Save cookie preferences
    $('#save-cookie-preferences').click(function() {
        cookieConsent.functional = $('#functional-cookies').is(':checked');
        cookieConsent.analytics = $('#analytics-cookies').is(':checked');
        cookieConsent.marketing = $('#marketing-cookies').is(':checked');

        // Save preferences to localStorage
        localStorage.setItem('cookiesAccepted', 'true');
        localStorage.setItem('cookieConsent_functional', cookieConsent.functional);
        localStorage.setItem('cookieConsent_analytics', cookieConsent.analytics);
        localStorage.setItem('cookieConsent_marketing', cookieConsent.marketing);

        // Initialize services based on new preferences
        initializeThirdPartyServices();

        // Close modal using the stored instance
        if (modals.cookieSettings) {
            modals.cookieSettings.hide();
        }
    });

    // Function to initialize third-party services based on consent
    function initializeThirdPartyServices() {
        if (cookieConsent.analytics) {
            // Initialize analytics (e.g., Google Analytics)
            if (typeof gtag === 'function') {
                gtag('consent', 'update', {
                    'analytics_storage': 'granted'
                });
            }
        }

        if (cookieConsent.marketing) {
            // Initialize marketing cookies (e.g., ad platforms)
            if (typeof fbq === 'function') {
                fbq('consent', 'grant');
            }
        }

        if (cookieConsent.functional) {
            // Initialize functional cookies (e.g., preferences)
            initializeFunctionalFeatures();
        }
    }

    // Function to initialize functional features
    function initializeFunctionalFeatures() {
        // Add any functional features that require cookies
        // For example: theme preferences, language settings, etc.
    }

    // Recipe filters with smooth transitions
    $('#cuisine-type, #dietary-preference, #difficulty').change(function() {
        $('#recipe-list').addClass('opacity-50 transition-opacity duration-300');
        
        $.ajax({
            url: 'fetch_recipes.php',
            method: 'GET',
            data: {
                cuisine: $('#cuisine-type').val(),
                diet: $('#dietary-preference').val(),
                difficulty: $('#difficulty').val()
            },
            success: function(response) {
                setTimeout(function() {
                    $('#recipe-list').html(response).removeClass('opacity-50');
                }, 300);
            }
        });
    });

    // Smooth scroll for anchor links
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        const target = $($(this).attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 500, 'swing');
        }
    });

    // Form submissions
    $('#signup-form, #contact-form, #recipe-submission').submit(function(e) {
        e.preventDefault();
        // AJAX call to submit form data
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Handle success (e.g., show message, clear form)
            },
            error: function() {
                // Handle error
            }
        });
    });

    // Close mobile menu when clicking outside
    $(document).click(function(e) {
        const mobileMenu = $('#mobile-menu');
        const mobileMenuButton = $('[data-collapse-toggle="mobile-menu"]');
        
        // If click target is not the menu or menu button and menu is visible
        if (!mobileMenu.is(e.target) && 
            !mobileMenu.has(e.target).length && 
            !mobileMenuButton.is(e.target) && 
            !mobileMenuButton.has(e.target).length && 
            mobileMenu.hasClass('block')) {
            
            mobileMenu.addClass('hidden').removeClass('block');
        }
    });

    // Prevent menu from closing when clicking inside it
    $('#mobile-menu').click(function(e) {
        e.stopPropagation();
    });

    // Update the login form submission handler
    $('#login-form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'auth.php',
            method: 'POST',
            data: {
                action: 'login',
                email: $('#login-email').val(),
                password: $('#login-password').val()
            },
            success: function(response) {
                if (response.status === 'success') {
                    // Reload the page to update the UI
                    window.location.reload();
                } else {
                    $('#login-message').text(response.message);
                }
            },
            error: function() {
                $('#login-message').text('An error occurred. Please try again.');
            }
        });
    });

    // Handle forgot password form submission
    $('#forgot-password-form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'auth.php',
            method: 'POST',
            data: {
                action: 'reset-request',
                email: $('#reset-email').val()
            },
            success: function(response) {
                $('#forgot-password-message').text(response.message);
            },
            error: function() {
                $('#forgot-password-message').text('An error occurred. Please try again.');
            }
        });
    });
});