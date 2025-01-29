<?php
$page = 'contact';
require_once 'db_connection.php';
require_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    
    // Here you would typically add code to handle the form submission
    // For example, sending an email or storing in database
    $success = true;
}
?>

<main class="flex-grow pt-24 pb-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-neutral-900 mb-6 text-center">Get in Touch</h1>
            <p class="text-neutral-600 text-center mb-12">
                Whether you have a question, recipe request, or feedback, we'd love to hear from you. 
            </p>
            
            <?php if (isset($success)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg animate-fade-in-down">
                <p>Thank you for your message! We'll get back to you soon.</p>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6 transform transition-all">
                <div class="group">
                    <label for="name" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                        Your Name
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required 
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                               shadow-sm hover:shadow-md transition-all duration-200
                               bg-white/50 backdrop-blur-sm"
                    >
                </div>

                <div class="group">
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                               shadow-sm hover:shadow-md transition-all duration-200
                               bg-white/50 backdrop-blur-sm"
                    >
                </div>

                <div class="group">
                    <label for="subject" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                        Subject
                    </label>
                    <select 
                        id="subject" 
                        name="subject" 
                        required 
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                               shadow-sm hover:shadow-md transition-all duration-200
                               bg-white/50 backdrop-blur-sm"
                    >
                        <option value="">Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="recipe_request">Recipe Request</option>
                        <option value="feedback">Feedback</option>
                        <option value="support">Support</option>
                    </select>
                </div>

                <div id="recipe-request-fields" class="hidden space-y-4 mt-4">
                    <div class="group">
                        <label for="cuisine_type" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                            Cuisine Type
                        </label>
                        <select 
                            id="cuisine_type" 
                            name="cuisine_type" 
                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                                   shadow-sm hover:shadow-md transition-all duration-200
                                   bg-white/50 backdrop-blur-sm"
                        >
                            <option value="">Select cuisine type</option>
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
                    <div class="group">
                        <label for="dietary_preferences" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                            Dietary Preferences
                        </label>
                        <select 
                            id="dietary_preferences" 
                            name="dietary_preferences" 
                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                                   shadow-sm hover:shadow-md transition-all duration-200
                                   bg-white/50 backdrop-blur-sm"
                        >
                            <option value="">Select dietary preference</option>
                            <option value="None">None</option>
                            <option value="Vegetarian">Vegetarian</option>
                            <option value="Vegan">Vegan</option>
                            <option value="Pescatarian">Pescatarian</option>
                            <option value="Gluten-Free">Gluten-Free</option>
                            <option value="Dairy-Free">Dairy-Free</option>
                            <option value="Keto">Keto</option>
                        </select>
                    </div>
                </div>

                <div id="feedback-fields" class="hidden space-y-4 mt-4">
                    <div class="group">
                        <label for="feedback_type" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                            Feedback Type
                        </label>
                        <select 
                            id="feedback_type" 
                            name="feedback_type" 
                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                                   shadow-sm hover:shadow-md transition-all duration-200
                                   bg-white/50 backdrop-blur-sm"
                        >
                            <option value="">Select feedback type</option>
                            <option value="Website">Website Experience</option>
                            <option value="Recipes">Recipe Quality</option>
                            <option value="Features">Feature Suggestions</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="group">
                        <label for="rating" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                            Rating
                        </label>
                        <div class="flex items-center space-x-2">
                            <input type="radio" id="rating-5" name="rating" value="5" class="hidden peer/5">
                            <label for="rating-5" class="cursor-pointer text-2xl text-gray-300 peer-checked/5:text-yellow-400">★</label>
                            <input type="radio" id="rating-4" name="rating" value="4" class="hidden peer/4">
                            <label for="rating-4" class="cursor-pointer text-2xl text-gray-300 peer-checked/4:text-yellow-400">★</label>
                            <input type="radio" id="rating-3" name="rating" value="3" class="hidden peer/3">
                            <label for="rating-3" class="cursor-pointer text-2xl text-gray-300 peer-checked/3:text-yellow-400">★</label>
                            <input type="radio" id="rating-2" name="rating" value="2" class="hidden peer/2">
                            <label for="rating-2" class="cursor-pointer text-2xl text-gray-300 peer-checked/2:text-yellow-400">★</label>
                            <input type="radio" id="rating-1" name="rating" value="1" class="hidden peer/1">
                            <label for="rating-1" class="cursor-pointer text-2xl text-gray-300 peer-checked/1:text-yellow-400">★</label>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="message" class="block text-sm font-medium text-neutral-700 mb-1 group-hover:text-primary-600 transition-colors">
                        Your Message
                    </label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="6" 
                        required 
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                               shadow-sm hover:shadow-md transition-all duration-200
                               bg-white/50 backdrop-blur-sm resize-none"
                    ></textarea>
                </div>

                <div class="text-center">
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white 
                               bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500
                               transform hover:scale-105 active:scale-95 transition-all duration-200
                               shadow-[0_4px_14px_0_rgba(192,38,211,0.39)] hover:shadow-[0_6px_20px_0_rgba(192,38,211,0.39)]"
                    >
                        Send Message
                    </button>
                </div>
            </form>

            <div class="mt-16 grid md:grid-cols-3 gap-8 text-center">
                <div class="p-6 rounded-xl bg-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Email Us</h3>
                    <p class="text-neutral-600">contact@foodfusion.com</p>
                </div>

                <div class="p-6 rounded-xl bg-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Location</h3>
                    <p class="text-neutral-600">123 Foodie Street<br>Cuisine City, FC 12345</p>
                </div>

                <div class="p-6 rounded-xl bg-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Business Hours</h3>
                    <p class="text-neutral-600">Mon - Fri: 9AM - 6PM<br>Weekend: 10AM - 4PM</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subjectSelect = document.getElementById('subject');
    const recipeRequestFields = document.getElementById('recipe-request-fields');
    const feedbackFields = document.getElementById('feedback-fields');

    subjectSelect.addEventListener('change', function() {
        // Hide all conditional fields first
        recipeRequestFields.classList.add('hidden');
        feedbackFields.classList.add('hidden');

        // Show relevant fields based on selection
        if (this.value === 'recipe_request') {
            recipeRequestFields.classList.remove('hidden');
        } else if (this.value === 'feedback') {
            feedbackFields.classList.remove('hidden');
        }
    });
});
</script>