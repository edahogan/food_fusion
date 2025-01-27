SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `food_fusion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `food_fusion`;

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FailedAttempts` int(11) DEFAULT 0,
  `LockoutTime` datetime DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Events`;
CREATE TABLE `Events` (
  `EventID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `MaxAttendees` int(11) DEFAULT NULL,
  `RegistrationDeadline` datetime DEFAULT NULL,
  `Status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `EventDate` datetime DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`EventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Recipes`;
CREATE TABLE `Recipes` (
  `RecipeID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Ingredients` text DEFAULT NULL,
  `Instructions` text DEFAULT NULL,
  `Cuisine` enum('American','Italian','Mexican','Asian','Mediterranean','French','Spanish','Greek','Japanese','International') NOT NULL DEFAULT 'International',
  `DietaryPreference` enum('None','Vegetarian','Vegan','Pescatarian','Gluten-Free','Dairy-Free','Keto') NOT NULL DEFAULT 'None',
  `Difficulty` enum('easy','medium','hard') NOT NULL,
  `PrepTime` int(11) NOT NULL COMMENT 'Preparation time in minutes',
  `CookTime` int(11) NOT NULL COMMENT 'Cooking time in minutes',
  `TotalTime` int(11) NOT NULL COMMENT 'Total time in minutes',
  `ImageURL` varchar(512) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsDeleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`RecipeID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `Recipes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Comments`;
CREATE TABLE `Comments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `RecipeID` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`CommentID`),
  KEY `UserID` (`UserID`),
  KEY `RecipeID` (`RecipeID`),
  CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ContentImages`;
CREATE TABLE `ContentImages` (
  `ImageID` int(11) NOT NULL AUTO_INCREMENT,
  `ContentType` enum('recipe','event') NOT NULL DEFAULT 'recipe',
  `RecipeID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) NOT NULL,
  `IsPrimary` tinyint(1) DEFAULT 0,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `EventID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ImageID`),
  KEY `RecipeID` (`RecipeID`),
  KEY `idx_event_images` (`EventID`),
  CONSTRAINT `ContentImages_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`) ON DELETE CASCADE,
  CONSTRAINT `fk_event_images` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Resources`;
CREATE TABLE `Resources` (
  `ResourceID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `FileURL` varchar(255) DEFAULT NULL,
  `ResourceType` enum('Recipe Card','Tutorial','Video','Infographic') NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ResourceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `top` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `parent_post_id` (`parent_post_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`parent_post_id`) REFERENCES `posts` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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

(2, 'Carbonara', 'A delicious pasta dish topped with grated cheese and fresh herbs',
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

-- Insert recipe images from recipe_data_insert.sql into ContentImages table
INSERT INTO ContentImages (RecipeID, ImageURL, IsPrimary, ContentType) VALUES
(1, 'https://th.bing.com/th/id/OIG4.ea7Smeqv0qJ6xNTdcPPW', 1, 'recipe'),
(2, 'https://th.bing.com/th/id/OIG1.TB9cPLe_FqN7PMpXPybM', 1, 'recipe'),
(3, 'https://th.bing.com/th/id/OIG2.OaS0Fm0vt7WcUl.iog9i', 1, 'recipe'),
(4, 'https://th.bing.com/th/id/OIG1.a2WhwS.khOoD2U1W1eqt', 1, 'recipe'),
(5, 'https://th.bing.com/th/id/OIG2.VsJdye_NzoHbds7alXC2', 1, 'recipe'),
(6, 'https://th.bing.com/th/id/OIG1.Cu91I1KmaSPjChhRrRkG', 1, 'recipe'),
(7, 'https://th.bing.com/th/id/OIG1.LcB6ABwBagzz6pfaFHgt', 1, 'recipe'),
(8, 'https://th.bing.com/th/id/OIG1.Tg92q2.2Z3LcKR0ZwtoX', 1, 'recipe'),
(9, 'https://th.bing.com/th/id/OIG2.b.0qZvkUjACzlTBUxhdL', 1, 'recipe'),
(10, 'https://th.bing.com/th/id/OIG2.28RR7SQ4.5kLqL83U3NA', 1, 'recipe'),
(11, 'https://th.bing.com/th/id/OIG4.HL7jjnZipyBG41THliVL', 1, 'recipe'),
(12, 'https://th.bing.com/th/id/OIG4.zC8SUC.Y8mYzvUzX89O4', 1, 'recipe'),
(13, 'https://th.bing.com/th/id/OIG3.Y0ZhS2KkO8lLOzzhi4Av', 1, 'recipe'),
(14, 'https://th.bing.com/th/id/OIG4.YAgSSWIl293pIoc6Vx5_', 1, 'recipe'),
(15, 'https://th.bing.com/th/id/OIG3.WEhEShuAIOgCCsEz.Ern', 1, 'recipe'),
(16, 'https://th.bing.com/th/id/OIG3.AMaevyayD8.XiO0XekVP', 1, 'recipe'),
(17, 'https://th.bing.com/th/id/OIG2.J9KxNy_SeVfF2BTsIp_R', 1, 'recipe'),
(18, 'https://th.bing.com/th/id/OIG4.tJfrCmEX.QbaBfu08tec', 1, 'recipe'),
(19, 'https://th.bing.com/th/id/OIG4.xzK9HTzWmZX1eMmagDav', 1, 'recipe'),
(20, 'https://th.bing.com/th/id/OIG3.qLRbGvIxKVA_4AMCVLKl', 1, 'recipe'),
(21, 'https://th.bing.com/th/id/OIG3.mLRCJHGgz9xaxl5c1GjK', 1, 'recipe'),
(22, 'https://th.bing.com/th/id/OIG4.wnreLIHAoP6koup_YylK', 1, 'recipe'),
(23, 'https://th.bing.com/th/id/OIG1.agPX.Ws4bjsArMz0uyN.', 1, 'recipe'),
(24, 'https://th.bing.com/th/id/OIG2.i3Y5j87Ek4.X9V7MskNb', 1, 'recipe'),
(25, 'https://th.bing.com/th/id/OIG2.0dTtTiJ94EHrlQOwI46T', 1, 'recipe'),
(26, 'https://th.bing.com/th/id/OIG2.AayXwbNboQy15ZULew6z', 1, 'recipe'),
(27, 'https://th.bing.com/th/id/OIG3.qo7HcTP5ERZ8c4Y5wVun', 1, 'recipe');

-- Update recipe inserts to use valid enum values
UPDATE Recipes SET 
    Cuisine = 'International' 
WHERE Cuisine NOT IN ('American', 'Italian', 'Mexican', 'Asian', 'Mediterranean', 'French', 'Spanish', 'Greek', 'Japanese', 'International');

UPDATE Recipes SET 
    DietaryPreference = 'None' 
WHERE DietaryPreference NOT IN ('None', 'Vegetarian', 'Vegan', 'Pescatarian', 'Gluten-Free', 'Dairy-Free', 'Keto');

-- For future inserts, ensure values match the enums
-- Example update for specific recipes:
UPDATE Recipes SET Cuisine = 'Mediterranean' WHERE Title = 'Fresh Vegetable Medley';
UPDATE Recipes SET Cuisine = 'Italian' WHERE Title LIKE '%Pasta%';
UPDATE Recipes SET Cuisine = 'Japanese' WHERE Title LIKE '%Sushi%';
UPDATE Recipes SET Cuisine = 'American' WHERE Title IN ('Decadent Chocolate Cake', 'Stack of Pancakes', 'Chocolate Chip Cookies');
UPDATE Recipes SET Cuisine = 'French' WHERE Title IN ('Colorful Macarons', 'Freshly Baked Croissants');
UPDATE Recipes SET Cuisine = 'Greek' WHERE Title = 'Greek Salad';