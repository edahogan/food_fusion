<h1>Community Cookbook</h1>

<?php if (isset($_SESSION['user_id'])): ?>
    <form id="recipe-submission" method="post" action="submit_recipe.php">
        <input type="text" name="title" placeholder="Recipe Title" required>
        <textarea name="description" placeholder="Recipe Description" required></textarea>
        <textarea name="ingredients" placeholder="Ingredients (one per line)" required></textarea>
        <textarea name="instructions" placeholder="Instructions" required></textarea>
        <select name="cuisine-type" required>
            <!-- Add cuisine options -->
        </select>
        <select name="dietary-preference" required>
            <!-- Add dietary preference options -->
        </select>
        <select name="difficulty" required>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        <button type="submit">Submit Recipe</button>
    </form>
<?php else: ?>
    <p>Please <a href="#" id="login-button">log in</a> to submit your recipes.</p>
<?php endif; ?>

<div id="community-recipes">
    <!-- PHP code to fetch and display community recipes -->
</div>