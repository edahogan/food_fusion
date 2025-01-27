<?php
require_once 'header.php';
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$recipe = null;
$error = null;

if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("
            SELECT * FROM Recipes 
            WHERE RecipeID = ? AND UserID = ? AND IsDeleted = FALSE
        ");
        $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            $error = "Recipe not found or unauthorized";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php else: ?>
        <h1 class="text-3xl font-bold mb-8"><?= $recipe ? 'Edit Recipe' : 'Create New Recipe' ?></h1>
        
        <form id="recipe-form" class="space-y-6" enctype="multipart/form-data">
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

            <!-- Add similar fields for ingredients, instructions, cuisine type, etc. -->

            <div>
                <label class="block text-sm font-medium text-gray-700">Images</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-primary-50 file:text-primary-700
                              hover:file:bg-primary-100">
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
        document.getElementById('recipe-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('recipe_management.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
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
        </script>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?> 