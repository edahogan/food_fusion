<?php if (!isset($_SESSION['user_id'])): ?>
    <!-- Sign Up Now Popup -->
    <div id="signup-popup" 
        tabindex="-1" 
        aria-hidden="true" 
        data-modal-target="signup-popup"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-neutral-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="signup-popup">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-8">
                    <div class="text-center">
                        <h3 class="mb-4 text-3xl font-display font-medium text-neutral-900">Join Our Culinary Community!</h3>
                        <p class="mb-6 text-neutral-600">Sign up now to unlock exclusive features:</p>
                        <ul class="mb-8 space-y-3 text-left max-w-md mx-auto">
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Share your favorite recipes with the community</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Get personalized recipe recommendations</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Save your favorite recipes for quick access</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Join cooking challenges and win prizes</span>
                            </li>
                        </ul>
                        <div class="space-y-4">
                            <button type="button" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors" data-modal-target="register-modal" data-modal-toggle="register-modal" data-modal-hide="signup-popup" onclick="localStorage.setItem('signup-popup-interact', '')">Sign Up Now</button>
                            <button type="button" class="w-full text-neutral-500 hover:text-neutral-700 focus:ring-4 focus:outline-none focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors" data-modal-hide="signup-popup" onclick="localStorage.setItem('signup-popup-interact', '')">Maybe Later</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="login-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-neutral-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="login-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-2xl font-display font-medium text-neutral-900">Sign in to FoodFusion</h3>
                    <form id="login-form" class="space-y-6" method="post">
                        <div>
                            <label for="login-email" class="block mb-2 text-sm font-medium text-neutral-900">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="login-email" 
                                   class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                                   placeholder="name@company.com" 
                                   required>
                        </div>
                        <div>
                            <label for="login-password" class="block mb-2 text-sm font-medium text-neutral-900">Password</label>
                            <input type="password" 
                                   name="password" 
                                   id="login-password" 
                                   placeholder="••••••••" 
                                   class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                                   required>
                        </div>
                        <div id="login-message" class="text-sm text-red-600"></div>
                        <button type="submit" 
                                name="login" 
                                class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                            Sign in
                        </button>
                        <div class="text-sm font-medium text-neutral-500">
                            Not registered? <button type="button" class="text-primary-600 hover:underline" data-modal-target="register-modal" data-modal-toggle="register-modal" data-modal-hide="login-modal">Create account</button>
                        </div>
                        <div class="text-sm font-medium text-neutral-500">
                            <a href="#" id="forgot-password-link" class="text-primary-600 hover:underline">Forgot password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="register-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-neutral-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="register-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-2xl font-display font-medium text-neutral-900">Create an account</h3>
                    <form id="register-form" class="space-y-6" method="post">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="firstName" class="block mb-2 text-sm font-medium text-neutral-900">First Name</label>
                                <input type="text" name="firstName" id="firstName" class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label for="lastName" class="block mb-2 text-sm font-medium text-neutral-900">Last Name</label>
                                <input type="text" name="lastName" id="lastName" class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            </div>
                        </div>
                        <div>
                            <label for="registerEmail" class="block mb-2 text-sm font-medium text-neutral-900">Email</label>
                            <input type="email" name="email" id="registerEmail" class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="name@company.com" required>
                        </div>
                        <div>
                            <label for="registerPassword" class="block mb-2 text-sm font-medium text-neutral-900">Password</label>
                            <input type="password" name="password" id="registerPassword" placeholder="••••••••" class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                        </div>
                        <div id="register-message" class="text-sm text-red-600"></div>
                        <button type="submit" name="register" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">Create account</button>
                        <div class="text-sm font-medium text-neutral-500">
                            Already have an account? <button type="button" class="text-primary-600 hover:underline" data-modal-target="login-modal" data-modal-toggle="login-modal" data-modal-hide="register-modal">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookie Settings Modal -->
    <div id="cookie-settings-modal" tabindex="-1" aria-hidden="true" 
        data-modal-target="cookie-settings-modal"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-neutral-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="cookie-settings-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 lg:p-8">
                    <h3 class="mb-4 text-2xl font-display font-medium text-neutral-900">Cookie Preferences</h3>
                    <p class="mb-6 text-neutral-600">Manage your cookie preferences below. Essential cookies are always enabled as they are necessary for the website to function properly.</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="essential-cookies" type="checkbox" checked disabled class="w-4 h-4 border border-neutral-300 rounded bg-neutral-50 focus:ring-3 focus:ring-primary-300">
                            </div>
                            <div class="ml-3">
                                <label for="essential-cookies" class="font-medium text-neutral-900">Essential Cookies</label>
                                <p class="text-sm text-neutral-500">These cookies are necessary for the website to function and cannot be switched off.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="functional-cookies" type="checkbox" class="w-4 h-4 border border-neutral-300 rounded bg-neutral-50 focus:ring-3 focus:ring-primary-300">
                            </div>
                            <div class="ml-3">
                                <label for="functional-cookies" class="font-medium text-neutral-900">Functional Cookies</label>
                                <p class="text-sm text-neutral-500">These cookies enable personalized features and remember your preferences.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="analytics-cookies" type="checkbox" class="w-4 h-4 border border-neutral-300 rounded bg-neutral-50 focus:ring-3 focus:ring-primary-300">
                            </div>
                            <div class="ml-3">
                                <label for="analytics-cookies" class="font-medium text-neutral-900">Analytics Cookies</label>
                                <p class="text-sm text-neutral-500">These cookies help us understand how visitors interact with our website.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="marketing-cookies" type="checkbox" class="w-4 h-4 border border-neutral-300 rounded bg-neutral-50 focus:ring-3 focus:ring-primary-300">
                            </div>
                            <div class="ml-3">
                                <label for="marketing-cookies" class="font-medium text-neutral-900">Marketing Cookies</label>
                                <p class="text-sm text-neutral-500">These cookies are used to deliver advertisements more relevant to you and your interests.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" data-modal-hide="cookie-settings-modal" class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 transition-colors">Cancel</button>
                        <button type="button" id="save-cookie-preferences" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">Save Preferences</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgot-password-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button" class="absolute top-3 right-2.5 text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-neutral-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="forgot-password-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-2xl font-display font-medium text-neutral-900">Reset your password</h3>
                    <form id="forgot-password-form" class="space-y-6" method="post">
                        <div>
                            <label for="reset-email" class="block mb-2 text-sm font-medium text-neutral-900">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="reset-email" 
                                   class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                                   placeholder="name@company.com" 
                                   required>
                        </div>
                        <div id="forgot-password-message" class="text-sm text-red-600"></div>
                        <button type="submit" 
                                name="reset-request" 
                                class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                            <span id="reset-button-text">Send Reset Link</span>
                            <svg id="reset-loading-icon" class="hidden w-5 h-5 ml-3 -mr-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forgotPasswordForm = document.getElementById('forgot-password-form');
            const forgotPasswordMessage = document.getElementById('forgot-password-message');
            const resetButtonText = document.getElementById('reset-button-text');
            const resetLoadingIcon = document.getElementById('reset-loading-icon');

            forgotPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault();
                resetButtonText.textContent = 'Sending...';
                resetLoadingIcon.classList.remove('hidden');
                forgotPasswordMessage.textContent = '';

                const formData = new FormData(forgotPasswordForm);
                formData.append('action', 'reset-request');

                fetch('auth.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    resetButtonText.textContent = 'Send Reset Link';
                    resetLoadingIcon.classList.add('hidden');
                    if (data.status === 'success') {
                        // EmailJS integration
                        emailjs.init('rjcUi1kJkTIIxjBLR'); // Replace with your EmailJS user ID
                        const templateParams = {
                            user_name: data.user_name,
                            reset_link: data.reset_link,
                            message: `
                                <p>Hello ${data.user_name},</p>
                                <p>You have requested to reset your password. Please click the button below to reset it:</p>
                                <p style='text-align: center;'>
                                    <a href='${data.reset_link}' style='display: inline-block; padding: 12px 24px; background-color: #c026d3; color: #ffffff; text-decoration: none; border-radius: 6px; transition: background-color 0.3s ease; text-align: center;'>Reset Password</a>
                                </p>
                                <p>This link will expire in 1 hour.</p>
                                <p>If you did not request a password reset, please ignore this email.</p>
                                <p>Best regards,<br>The FoodFusion Team</p>
                            `
                        };
                        emailjs.send('sense5', 'password_reset', templateParams) // Replace with your service ID and template ID
                            .then(function(response) {
                                forgotPasswordMessage.textContent = 'If an account with this email exists, a reset link has been sent.';
                                forgotPasswordMessage.classList.remove('text-red-600');
                                forgotPasswordMessage.classList.add('text-green-600');
                                console.log('Email sent successfully', response);
                            }, function(error) {
                                forgotPasswordMessage.textContent = 'Failed to send reset email. Please try again.';
                                forgotPasswordMessage.classList.remove('text-green-600');
                                forgotPasswordMessage.classList.add('text-red-600');
                                console.error('Email sending failed', error);
                            });
                    } else {
                        forgotPasswordMessage.textContent = data.message;
                        forgotPasswordMessage.classList.remove('text-green-600');
                        forgotPasswordMessage.classList.add('text-red-600');
                    }
                })
                .catch(error => {
                    resetButtonText.textContent = 'Send Reset Link';
                    resetLoadingIcon.classList.add('hidden');
                    forgotPasswordMessage.textContent = 'An error occurred. Please try again.';
                    forgotPasswordMessage.classList.remove('text-green-600');
                    forgotPasswordMessage.classList.add('text-red-600');
                    console.error('Fetch error:', error);
                });
            });
        });
    </script>
<?php endif; ?> 