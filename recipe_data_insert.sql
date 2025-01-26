-- Insert sample users
INSERT INTO Users (FirstName, LastName, Email, Password) VALUES
('John', 'Smith', 'john.smith@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Emma', 'Johnson', 'emma.j@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Michael', 'Brown', 'michael.b@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Sarah', 'Davis', 'sarah.d@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('David', 'Wilson', 'david.w@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Lisa', 'Anderson', 'lisa.a@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('James', 'Taylor', 'james.t@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Emily', 'Thomas', 'emily.t@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Robert', 'Martinez', 'robert.m@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Jennifer', 'Garcia', 'jennifer.g@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('William', 'Lopez', 'william.l@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Elizabeth', 'Lee', 'elizabeth.l@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Christopher', 'Gonzalez', 'chris.g@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Ashley', 'Rodriguez', 'ashley.r@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Daniel', 'Perez', 'daniel.p@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Michelle', 'Turner', 'michelle.t@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Joseph', 'Phillips', 'joseph.p@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Amanda', 'Campbell', 'amanda.c@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Kevin', 'Parker', 'kevin.p@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Melissa', 'Evans', 'melissa.e@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Steven', 'Edwards', 'steven.e@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Laura', 'Collins', 'laura.c@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Timothy', 'Stewart', 'timothy.s@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Rebecca', 'Morris', 'rebecca.m@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Brian', 'Murphy', 'brian.m@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('Nicole', 'Cook', 'nicole.c@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('George', 'Rogers', 'george.r@email.com', '$2y$10$abcdefghijklmnopqrstuv');

-- Insert recipes with corresponding ingredients and instructions
INSERT INTO Recipes (UserID, Title, Description, Ingredients, Instructions, Cuisine, DietaryPreference, Difficulty, PrepTime, CookTime, TotalTime) VALUES
(1, 'Fresh Vegetable Medley', 'A vibrant assortment of fresh vegetables including bell peppers, tomatoes, and leafy greens', 
'["4 bell peppers", "2 cups cherry tomatoes", "2 cups mixed leafy greens", "2 tbsp olive oil", "Salt and pepper to taste"]',
'["Wash and chop all vegetables", "Toss with olive oil", "Season with salt and pepper", "Arrange on serving platter"]',
'Mediterranean', 'Vegan', 'easy', 15, 0, 15),

(2, 'Gourmet Pasta Dish', 'A delicious pasta dish topped with grated cheese and fresh herbs',
'["1 lb pasta", "2 cups marinara sauce", "1 cup grated parmesan", "Fresh basil", "Olive oil"]',
'["Cook pasta al dente", "Heat marinara sauce", "Combine pasta and sauce", "Top with cheese and herbs"]',
'Italian', 'Vegetarian', 'medium', 10, 20, 30),

(3, 'Assorted Sushi Platter', 'A beautiful arrangement of various sushi rolls and nigiri',
'["2 cups sushi rice", "Nori sheets", "Fresh fish assortment", "Cucumber", "Avocado"]',
'["Prepare sushi rice", "Cut fish and vegetables", "Roll sushi", "Arrange on platter"]',
'Japanese', 'Pescatarian', 'hard', 45, 30, 75),

(4, 'Decadent Chocolate Cake', 'A rich, multi-layered chocolate cake adorned with chocolate shavings and fresh berries',
'["2 cups flour", "2 cups sugar", "3/4 cup cocoa powder", "2 eggs", "1 cup milk", "1/2 cup vegetable oil", "Fresh berries for garnish"]',
'["Mix dry ingredients", "Combine wet ingredients", "Bake layers", "Assemble with frosting", "Garnish with berries"]',
'American', 'Vegetarian', 'medium', 30, 45, 75),

(5, 'Healthy Breakfast Bowl', 'A nutritious breakfast bowl filled with yogurt, granola, fresh berries, and honey',
'["1 cup Greek yogurt", "1/2 cup granola", "1 cup mixed berries", "2 tbsp honey", "Mint leaves for garnish"]',
'["Layer yogurt in bowl", "Add granola", "Top with berries", "Drizzle honey", "Garnish with mint"]',
'International', 'Vegetarian', 'easy', 10, 0, 10),

(6, 'Grilled Steak with Vegetables', 'A perfectly grilled steak served with roasted vegetables',
'["1 lb ribeye steak", "2 cups mixed vegetables", "3 tbsp olive oil", "Fresh herbs", "Salt and pepper"]',
'["Season steak", "Prepare vegetables", "Grill steak to desired doneness", "Roast vegetables", "Plate and serve"]',
'American', 'None', 'medium', 20, 25, 45),

(7, 'Colorful Macarons', 'An assortment of colorful macarons with various flavors',
'["1 cup almond flour", "1 cup powdered sugar", "3 egg whites", "Food coloring", "Various fillings"]',
'["Prepare macaron batter", "Pipe shells", "Rest and bake", "Make fillings", "Assemble macarons"]',
'French', 'Vegetarian', 'hard', 45, 20, 65),

(8, 'Classic Margherita Pizza', 'A traditional Margherita pizza with fresh ingredients',
'["Pizza dough", "Fresh mozzarella", "San Marzano tomatoes", "Fresh basil", "Olive oil"]',
'["Prepare dough", "Add tomato sauce", "Top with cheese", "Bake", "Garnish with basil"]',
'Italian', 'Vegetarian', 'medium', 20, 15, 35),

(9, 'Refreshing Fruit Salad', 'A refreshing mix of seasonal fruits with mint garnish',
'["2 cups watermelon", "1 cup blueberries", "2 kiwis", "Fresh mint leaves", "Honey for drizzling"]',
'["Cut fruits into bite-sized pieces", "Combine in bowl", "Add mint leaves", "Drizzle with honey", "Chill before serving"]',
'International', 'Vegan', 'easy', 15, 0, 15),

(10, 'Artisan Cheese Board', 'A carefully curated selection of cheeses and accompaniments',
'["3 types of cheese", "Assorted nuts", "Fresh and dried fruits", "Crackers", "Honey"]',
'["Arrange cheeses", "Add nuts and fruits", "Place crackers", "Drizzle honey", "Garnish board"]',
'International', 'Vegetarian', 'easy', 20, 0, 20),

(11, 'Homemade Burger with Fries', 'A classic burger served with crispy fries',
'["1 lb ground beef", "Burger buns", "Lettuce", "Tomato", "Cheese", "Potatoes for fries"]',
'["Form patties", "Season and cook burgers", "Cut and fry potatoes", "Assemble burgers", "Serve hot"]',
'American', 'None', 'medium', 25, 20, 45),

(12, 'Vegan Buddha Bowl', 'A nutritious bowl of grains, legumes, and vegetables',
'["1 cup quinoa", "1 can chickpeas", "1 avocado", "Roasted vegetables", "Tahini dressing"]',
'["Cook quinoa", "Roast vegetables", "Prepare chickpeas", "Assemble bowl", "Add dressing"]',
'International', 'Vegan', 'easy', 20, 30, 50),

(13, 'Seafood Paella', 'Traditional Spanish paella with seafood',
'["2 cups rice", "Mussels", "Shrimp", "Saffron", "Peas", "Bell peppers"]',
'["Prepare rice with saffron", "Cook seafood", "Add vegetables", "Combine ingredients", "Let develop socarrat"]',
'Spanish', 'Pescatarian', 'hard', 30, 45, 75),

(14, 'Stack of Pancakes', 'Fluffy pancakes with fresh berries and maple syrup',
'["2 cups flour", "2 eggs", "Milk", "Fresh berries", "Maple syrup"]',
'["Mix batter", "Cook pancakes", "Stack with berries", "Add syrup", "Serve warm"]',
'American', 'Vegetarian', 'easy', 15, 20, 35),

(15, 'Caprese Salad', 'Classic Italian salad with fresh ingredients',
'["Fresh mozzarella", "Ripe tomatoes", "Fresh basil", "Olive oil", "Balsamic glaze"]',
'["Slice mozzarella and tomatoes", "Arrange on plate", "Add basil", "Drizzle with oil and glaze", "Season"]',
'Italian', 'Vegetarian', 'easy', 10, 0, 10),

(16, 'Chocolate Chip Cookies', 'Classic homemade cookies with gooey chocolate chips',
'["2 1/4 cups flour", "1 cup butter", "3/4 cup sugar", "2 eggs", "Chocolate chips", "Vanilla extract"]',
'["Cream butter and sugar", "Add eggs and vanilla", "Mix in dry ingredients", "Add chocolate chips", "Bake until golden"]',
'American', 'Vegetarian', 'easy', 15, 12, 27),

(17, 'Sushi Rolls Assortment', 'Various sushi rolls with different fillings',
'["Sushi rice", "Nori sheets", "Assorted fish", "Vegetables", "Soy sauce"]',
'["Prepare rice", "Lay out nori", "Add fillings", "Roll tightly", "Slice and serve"]',
'Japanese', 'Pescatarian', 'hard', 40, 20, 60),

(18, 'Hearty Beef Stew', 'Rich and comforting beef stew with vegetables',
'["2 lbs beef chunks", "Potatoes", "Carrots", "Peas", "Beef broth", "Herbs"]',
'["Brown meat", "Add vegetables", "Pour in broth", "Simmer until tender", "Season to taste"]',
'International', 'None', 'medium', 30, 120, 150),

(19, 'Freshly Baked Croissants', 'Flaky, buttery French croissants',
'["4 cups flour", "2 cups butter", "Yeast", "Milk", "Egg wash"]',
'["Make dough", "Laminate with butter", "Shape croissants", "Proof", "Bake until golden"]',
'French', 'Vegetarian', 'hard', 60, 25, 85),

(20, 'Greek Salad', 'Traditional Greek salad with feta cheese',
'["Cucumbers", "Tomatoes", "Red onions", "Feta cheese", "Olives", "Olive oil"]',
'["Chop vegetables", "Add olives and feta", "Dress with olive oil", "Season", "Toss gently"]',
'Greek', 'Vegetarian', 'easy', 15, 0, 15),

(21, 'Blueberry Muffins', 'Moist muffins packed with fresh blueberries',
'["2 cups flour", "Fresh blueberries", "Sugar", "Eggs", "Milk", "Butter"]',
'["Mix dry ingredients", "Combine wet ingredients", "Fold in blueberries", "Fill muffin tins", "Bake"]',
'American', 'Vegetarian', 'easy', 20, 25, 45),

(22, 'Shrimp Tacos', 'Grilled shrimp tacos with fresh toppings',
'["Shrimp", "Tortillas", "Cabbage slaw", "Lime", "Cilantro", "Avocado"]',
'["Season shrimp", "Make slaw", "Grill shrimp", "Warm tortillas", "Assemble tacos"]',
'Mexican', 'Pescatarian', 'medium', 25, 15, 40),

(23, 'Chocolate Fondue', 'Rich chocolate fondue with dipping items',
'["Dark chocolate", "Heavy cream", "Fresh fruits", "Marshmallows", "Pound cake"]',
'["Melt chocolate", "Add cream", "Prepare dipping items", "Keep warm", "Serve with skewers"]',
'International', 'Vegetarian', 'easy', 20, 10, 30),

(24, 'Avocado Toast', 'Trendy and nutritious breakfast toast',
'["Sourdough bread", "Ripe avocados", "Cherry tomatoes", "Sesame seeds", "Red pepper flakes"]',
'["Toast bread", "Mash avocado", "Season", "Add toppings", "Serve immediately"]',
'International', 'Vegan', 'easy', 10, 5, 15),

(25, 'Lemon Meringue Pie', 'Classic pie with tangy lemon filling',
'["Pie crust", "Lemons", "Sugar", "Egg whites", "Cornstarch", "Butter"]',
'["Prepare crust", "Make lemon filling", "Whip meringue", "Assemble", "Bake until golden"]',
'American', 'Vegetarian', 'hard', 45, 35, 80),

(26, 'Ramen Noodle Bowl', 'Hearty ramen with traditional toppings',
'["Ramen noodles", "Pork belly", "Soft-boiled egg", "Green onions", "Nori", "Broth"]',
'["Prepare broth", "Cook noodles", "Slice pork", "Prepare toppings", "Assemble bowl"]',
'Japanese', 'None', 'medium', 30, 60, 90),

(27, 'Fruit Tart', 'Elegant tart with custard and fresh fruits',
'["Tart crust", "Pastry cream", "Assorted fruits", "Apricot glaze", "Vanilla bean"]',
'["Bake crust", "Make custard", "Arrange fruits", "Glaze", "Chill before serving"]',
'French', 'Vegetarian', 'hard', 40, 25, 65);

-- Insert recipe images
INSERT INTO RecipeImages (RecipeID, ImageURL, IsPrimary) VALUES
(1, 'https://www.pexels.com/photo/variety-of-vegetables-on-brown-wooden-surface-1435904/', TRUE),
(2, 'https://unsplash.com/photos/4_jhDO54BYg', TRUE),
(3, 'https://www.pexels.com/photo/assorted-sushi-on-black-plate-3577568/', TRUE),
(4, 'https://unsplash.com/photos/8npZlBR6v8I', TRUE),
(5, 'https://www.pexels.com/photo/close-up-photo-of-breakfast-bowl-704569/', TRUE),
(6, 'https://unsplash.com/photos/ekP9R60z9jI', TRUE),
(7, 'https://www.pexels.com/photo/assorted-flavor-macarons-1028714/', TRUE),
(8, 'https://unsplash.com/photos/DEuob2v77wI', TRUE),
(9, 'https://www.pexels.com/photo/fruit-salad-in-glass-bowl-1132047/', TRUE),
(10, 'https://unsplash.com/photos/8manzosDSGM', TRUE),
(11, 'https://www.pexels.com/photo/burger-and-fries-on-brown-wooden-board-1639565/', TRUE),
(12, 'https://unsplash.com/photos/IGfIGP5ONV0', TRUE),
(13, 'https://www.pexels.com/photo/seafood-paella-461326/', TRUE),
(14, 'https://unsplash.com/photos/9QzZSHmOAMY', TRUE),
(15, 'https://www.pexels.com/photo/caprese-salad-on-plate-1279330/', TRUE),
(16, 'https://unsplash.com/photos/8l8Yl2ruUsg', TRUE),
(17, 'https://www.pexels.com/photo/assorted-sushi-rolls-3577567/', TRUE),
(18, 'https://unsplash.com/photos/4qSb_FWhHKs', TRUE),
(19, 'https://www.pexels.com/photo/baked-bread-food-461060/', TRUE),
(20, 'https://unsplash.com/photos/IGfIGP5ONV0', TRUE),
(21, 'https://www.pexels.com/photo/blueberry-muffins-704569/', TRUE),
(22, 'https://unsplash.com/photos/DEuob2v77wI', TRUE),
(23, 'https://www.pexels.com/photo/chocolate-fondue-1132047/', TRUE),
(24, 'https://unsplash.com/photos/8manzosDSGM', TRUE),
(25, 'https://www.pexels.com/photo/lemon-meringue-pie-1639565/', TRUE),
(26, 'https://unsplash.com/photos/IGfIGP5ONV0', TRUE),
(27, 'https://www.pexels.com/photo/fruit-tart-461060/', TRUE);

-- Continue with more image inserts... 