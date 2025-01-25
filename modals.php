<?php if (!isset($_SESSION['user_id'])): ?>
    <!-- Sign Up Now Popup -->
    <div id="signup-popup" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
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
                                <span>Share your favorite recipes</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Connect with other food enthusiasts</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Access exclusive cooking tips</span>
                            </li>
                        </ul>
                        <div class="space-y-4">
                            <button type="button" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors" data-modal-target="register-modal" data-modal-toggle="register-modal" data-modal-hide="signup-popup">Sign Up Now</button>
                            <p class="text-sm text-neutral-500">Already have an account? <button type="button" class="text-primary-600 hover:underline font-medium" data-modal-target="login-modal" data-modal-toggle="login-modal" data-modal-hide="signup-popup">Sign in</button></p>
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
                            <label for="email" class="block mb-2 text-sm font-medium text-neutral-900">Email</label>
                            <input type="email" name="email" id="email" class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="name@company.com" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-neutral-900">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-neutral-50 border border-neutral-300 text-neutral-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                        </div>
                        <div id="login-message" class="text-sm text-red-600"></div>
                        <button type="submit" name="login" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">Sign in</button>
                        <div class="text-sm font-medium text-neutral-500">
                            Not registered? <button type="button" class="text-primary-600 hover:underline" data-modal-target="register-modal" data-modal-toggle="register-modal" data-modal-hide="login-modal">Create account</button>
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
    <div id="cookie-settings-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
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

<?php endif; ?> 