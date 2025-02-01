SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `food_fusion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `food_fusion`;

CREATE TABLE `Comments` (
  `CommentID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `RecipeID` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_comment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Comments` (`CommentID`, `UserID`, `RecipeID`, `Content`, `CreatedAt`, `parent_comment_id`) VALUES
(1, 136, 27, 'hello', '2025-01-29 04:02:42', NULL),
(2, 136, 27, '144', '2025-01-29 04:31:04', 1),
(3, 136, 32, 'hi', '2025-01-29 04:32:44', NULL),
(4, 136, 32, '144', '2025-01-29 04:33:10', 3),
(5, 136, 32, '126', '2025-01-29 04:33:15', 3),
(6, 136, 32, '126', '2025-01-29 04:41:55', 4),
(7, 136, 32, 'sup', '2025-01-29 04:42:44', NULL),
(8, 136, 32, 'has r', '2025-01-29 04:43:22', 4),
(9, 136, 32, 'sdf', '2025-01-29 04:47:20', NULL),
(10, 136, 32, '126', '2025-01-29 04:47:29', 7),
(11, 136, 32, '369', '2025-01-29 04:47:49', 7),
(12, 136, 32, 'fg', '2025-01-29 16:48:37', 9),
(13, 136, 32, 'heyo', '2025-01-30 04:43:52', 12);

CREATE TABLE `ContentImages` (
  `ImageID` int(11) NOT NULL,
  `ContentType` enum('recipe','event') NOT NULL DEFAULT 'recipe',
  `RecipeID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) NOT NULL,
  `IsPrimary` tinyint(1) DEFAULT 0,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `EventID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ContentImages` (`ImageID`, `ContentType`, `RecipeID`, `ImageURL`, `IsPrimary`, `CreatedAt`, `EventID`) VALUES
(55, 'event', NULL, 'https://th.bing.com/th/id/OIG3.11.YVWBZcnlUpicF3H6G', 1, '2025-01-27 03:03:37', 1),
(56, 'event', NULL, 'https://th.bing.com/th/id/OIG3.YxWwtgFegge_6_QG9hgR', 1, '2025-01-27 03:03:37', 2),
(57, 'event', NULL, 'https://th.bing.com/th/id/OIG3.Yf.HmaX3rG9WcO0_LycN', 1, '2025-01-27 03:03:37', 3),
(58, 'event', NULL, 'https://th.bing.com/th/id/OIG1.hS3huTg6aUrvrSmr9hfi', 1, '2025-01-27 03:03:37', 4),
(59, 'event', NULL, 'https://th.bing.com/th/id/OIG1.kCjFiFQzdxfdXsL_QBy0', 1, '2025-01-27 03:03:37', 5),
(60, 'event', NULL, 'https://th.bing.com/th/id/OIG1.hmXld9Uf.0p6Fnmm2ZD2', 1, '2025-01-27 03:03:37', 6),
(61, 'event', NULL, 'https://th.bing.com/th/id/OIG1.gHk78_QXNh4WD5nWTpmf', 1, '2025-01-27 03:03:37', 7),
(62, 'event', NULL, 'https://th.bing.com/th/id/OIG1.uqciY37xO0DzBe6N8fJO', 1, '2025-01-27 03:03:37', 8),
(63, 'event', NULL, 'https://th.bing.com/th/id/OIG1.gWeZLtdAYDaVmUjMn3Z4', 1, '2025-01-27 03:03:37', 9),
(145, 'recipe', 1, 'https://th.bing.com/th/id/OIG4.ea7Smeqv0qJ6xNTdcPPW', 1, '2025-01-27 08:42:08', NULL),
(146, 'recipe', 2, 'https://th.bing.com/th/id/OIG1.TB9cPLe_FqN7PMpXPybM', 1, '2025-01-27 08:42:08', NULL),
(147, 'recipe', 3, 'https://th.bing.com/th/id/OIG2.OaS0Fm0vt7WcUl.iog9i', 1, '2025-01-27 08:42:08', NULL),
(148, 'recipe', 4, 'https://th.bing.com/th/id/OIG1.a2WhwS.khOoD2U1W1eqt', 1, '2025-01-27 08:42:08', NULL),
(149, 'recipe', 5, 'https://th.bing.com/th/id/OIG2.VsJdye_NzoHbds7alXC2', 1, '2025-01-27 08:42:08', NULL),
(150, 'recipe', 6, 'https://th.bing.com/th/id/OIG1.Cu91I1KmaSPjChhRrRkG', 1, '2025-01-27 08:42:08', NULL),
(151, 'recipe', 7, 'https://th.bing.com/th/id/OIG1.LcB6ABwBagzz6pfaFHgt', 1, '2025-01-27 08:42:08', NULL),
(152, 'recipe', 8, 'https://th.bing.com/th/id/OIG1.Tg92q2.2Z3LcKR0ZwtoX', 1, '2025-01-27 08:42:08', NULL),
(153, 'recipe', 9, 'https://th.bing.com/th/id/OIG2.b.0qZvkUjACzlTBUxhdL', 1, '2025-01-27 08:42:08', NULL),
(154, 'recipe', 10, 'https://th.bing.com/th/id/OIG2.28RR7SQ4.5kLqL83U3NA', 1, '2025-01-27 08:42:08', NULL),
(155, 'recipe', 11, 'https://th.bing.com/th/id/OIG4.HL7jjnZipyBG41THliVL', 1, '2025-01-27 08:42:08', NULL),
(156, 'recipe', 12, 'https://th.bing.com/th/id/OIG4.zC8SUC.Y8mYzvUzX89O4', 1, '2025-01-27 08:42:08', NULL),
(157, 'recipe', 13, 'https://th.bing.com/th/id/OIG3.Y0ZhS2KkO8lLOzzhi4Av', 1, '2025-01-27 08:42:08', NULL),
(158, 'recipe', 14, 'https://th.bing.com/th/id/OIG4.YAgSSWIl293pIoc6Vx5_', 1, '2025-01-27 08:42:08', NULL),
(159, 'recipe', 15, 'https://th.bing.com/th/id/OIG3.WEhEShuAIOgCCsEz.Ern', 1, '2025-01-27 08:42:08', NULL),
(160, 'recipe', 16, 'https://th.bing.com/th/id/OIG3.AMaevyayD8.XiO0XekVP', 1, '2025-01-27 08:42:08', NULL),
(161, 'recipe', 17, 'https://th.bing.com/th/id/OIG2.J9KxNy_SeVfF2BTsIp_R', 1, '2025-01-27 08:42:08', NULL),
(162, 'recipe', 18, 'https://th.bing.com/th/id/OIG4.tJfrCmEX.QbaBfu08tec', 1, '2025-01-27 08:42:08', NULL),
(163, 'recipe', 19, 'https://th.bing.com/th/id/OIG4.xzK9HTzWmZX1eMmagDav', 1, '2025-01-27 08:42:08', NULL),
(164, 'recipe', 20, 'https://th.bing.com/th/id/OIG3.qLRbGvIxKVA_4AMCVLKl', 1, '2025-01-27 08:42:08', NULL),
(165, 'recipe', 21, 'https://th.bing.com/th/id/OIG3.mLRCJHGgz9xaxl5c1GjK', 1, '2025-01-27 08:42:08', NULL),
(166, 'recipe', 22, 'https://th.bing.com/th/id/OIG4.wnreLIHAoP6koup_YylK', 1, '2025-01-27 08:42:08', NULL),
(167, 'recipe', 23, 'https://th.bing.com/th/id/OIG1.agPX.Ws4bjsArMz0uyN.', 1, '2025-01-27 08:42:08', NULL),
(168, 'recipe', 24, 'https://th.bing.com/th/id/OIG2.i3Y5j87Ek4.X9V7MskNb', 1, '2025-01-27 08:42:08', NULL),
(169, 'recipe', 25, 'https://th.bing.com/th/id/OIG2.0dTtTiJ94EHrlQOwI46T', 1, '2025-01-27 08:42:08', NULL),
(170, 'recipe', 26, 'https://th.bing.com/th/id/OIG2.AayXwbNboQy15ZULew6z', 1, '2025-01-27 08:42:08', NULL),
(171, 'recipe', 27, 'https://th.bing.com/th/id/OIG3.qo7HcTP5ERZ8c4Y5wVun', 1, '2025-01-27 08:42:08', NULL),
(174, 'recipe', 32, 'https://th.bing.com/th/id/OIG4.8lm4jML2rxQ0eqR.ZGoC?pid=ImgGn', 1, '2025-01-28 00:51:43', NULL);

CREATE TABLE `Events` (
  `EventID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `MaxAttendees` int(11) DEFAULT NULL,
  `RegistrationDeadline` datetime DEFAULT NULL,
  `Status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `EventDate` datetime DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Events` (`EventID`, `Title`, `Description`, `ImageURL`, `Location`, `MaxAttendees`, `RegistrationDeadline`, `Status`, `EventDate`, `CreatedAt`) VALUES
(1, 'Artisanal Bread Making Workshop', 'Master the art of bread making with our expert bakers. Learn to create crusty sourdough, fluffy brioche, and rustic country loaves. All ingredients and tools provided. Perfect for beginners!', 'https://th.bing.com/th/id/OIG3.11.YVWBZcnlUpicF3H6G', 'Culinary Institute Kitchen Lab A', 20, '2024-03-13 23:59:59', 'upcoming', '2024-03-15 10:00:00', '2025-01-27 03:03:37'),
(2, 'Farm-to-Table Cooking Experience', 'Join us for a unique experience where you\'ll harvest fresh ingredients from our partner farm and learn to transform them into delicious seasonal dishes. Includes farm tour and cooking session.', 'https://th.bing.com/th/id/OIG3.YxWwtgFegge_6_QG9hgR', 'Green Meadows Farm & Kitchen', 15, '2024-03-18 23:59:59', 'upcoming', '2024-03-20 09:00:00', '2025-01-27 03:03:37'),
(3, 'Asian Street Food Festival', 'Experience the vibrant flavors of Asian street cuisine! Learn to make dumplings, bao buns, and other popular street food favorites. Take home your creations and detailed recipes.', 'https://th.bing.com/th/id/OIG3.Yf.HmaX3rG9WcO0_LycN', 'Downtown Food Market', 50, '2024-03-30 23:59:59', 'upcoming', '2024-04-01 11:00:00', '2025-01-27 03:03:37'),
(4, 'Mediterranean Cooking Class', 'Discover the healthy and delicious Mediterranean cuisine. Learn to make authentic paella, fresh pasta, and classic Greek dishes. Wine pairing included for participants over 21.', 'https://th.bing.com/th/id/OIG1.hS3huTg6aUrvrSmr9hfi', 'Seaside Culinary Center', 25, '2024-04-08 23:59:59', 'upcoming', '2024-04-10 14:00:00', '2025-01-27 03:03:37'),
(5, 'Dessert Masterclass', 'Perfect your pastry skills with our expert pastry chef. From French macarons to decadent chocolate creations, learn the secrets of professional dessert making. All skill levels welcome!', 'https://th.bing.com/th/id/OIG1.kCjFiFQzdxfdXsL_QBy0', 'Sweet Dreams Bakery', 15, '2024-04-13 23:59:59', 'upcoming', '2024-04-15 13:00:00', '2025-01-27 03:03:37'),
(6, 'Sustainable Cooking Workshop', 'Learn eco-friendly cooking practices, zero-waste techniques, and how to make the most of seasonal ingredients while reducing your carbon footprint. Includes take-home composting guide.', 'https://th.bing.com/th/id/OIG1.hmXld9Uf.0p6Fnmm2ZD2', 'Green Living Center', 30, '2024-04-20 23:59:59', 'upcoming', '2024-04-22 10:00:00', '2025-01-27 03:03:37'),
(7, 'BBQ & Grilling Masterclass', 'Master the art of grilling with expert tips, techniques, and recipes. From perfect steaks to grilled vegetables, become a backyard BBQ master! Includes tasting session.', 'https://th.bing.com/th/id/OIG1.gHk78_QXNh4WD5nWTpmf', 'Outdoor Cooking Pavilion', 25, '2024-04-29 23:59:59', 'upcoming', '2024-05-01 12:00:00', '2025-01-27 03:03:37'),
(8, 'Wine & Food Pairing Evening', 'Join our sommelier for an educational evening of wine tasting and food pairing. Learn the principles of pairing and enhance your dining experiences. Must be 21 or older to attend.', 'https://th.bing.com/th/id/OIG1.uqciY37xO0DzBe6N8fJO', 'Vintage Wine Cellar', 20, '2024-05-08 23:59:59', 'upcoming', '2024-05-10 18:00:00', '2025-01-27 03:03:37'),
(9, 'Kids Cooking Camp', 'A fun-filled cooking adventure for young chefs! Kids will learn kitchen safety, basic cooking skills, and create delicious kid-friendly recipes. Ages 8-12 welcome.', 'https://th.bing.com/th/id/OIG1.gWeZLtdAYDaVmUjMn3Z4', 'Junior Chef Academy', 15, '2024-05-13 23:59:59', 'upcoming', '2024-05-15 09:00:00', '2025-01-27 03:03:37');

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `top` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `posts` (`post_id`, `user_id`, `top`, `body`, `created_at`, `parent_post_id`) VALUES
(1, 136, '144', '126', '2025-01-28 12:11:18', NULL),
(2, 136, '144', '144', '2025-01-28 12:12:11', NULL),
(3, 136, '126 144', NULL, '2025-01-28 15:28:40', 2),
(4, 136, 'yooo\n', NULL, '2025-01-28 15:33:57', 2),
(5, 136, 'wasup 144', NULL, '2025-01-28 15:54:38', 4),
(6, 136, 'hj\n', NULL, '2025-01-29 18:51:35', 1);

CREATE TABLE `Recipes` (
  `RecipeID` int(11) NOT NULL,
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
  `IsDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Recipes` (`RecipeID`, `UserID`, `Title`, `Description`, `Ingredients`, `Instructions`, `Cuisine`, `DietaryPreference`, `Difficulty`, `PrepTime`, `CookTime`, `TotalTime`, `ImageURL`, `CreatedAt`, `IsDeleted`) VALUES
(1, 1, 'Fresh Vegetable Medley', 'A vibrant assortment of fresh vegetables including bell peppers, tomatoes, and leafy greens', '[\"4 bell peppers\", \"2 cups cherry tomatoes\", \"2 cups mixed leafy greens\", \"2 tbsp olive oil\", \"Salt and pepper to taste\"]', '[\"Wash and chop all vegetables\", \"Toss with olive oil\", \"Season with salt and pepper\", \"Arrange on serving platter\"]', 'Mediterranean', 'Vegan', 'easy', 15, 0, 15, NULL, '2025-01-27 08:42:08', 0),
(2, 2, 'Carbonara', 'A delicious pasta dish topped with grated cheese and fresh herbs', '[\"1 lb pasta\", \"2 cups marinara sauce\", \"1 cup grated parmesan\", \"Fresh basil\", \"Olive oil\"]', '[\"Cook pasta al dente\", \"Heat marinara sauce\", \"Combine pasta and sauce\", \"Top with cheese and herbs\"]', 'Italian', 'Vegetarian', 'medium', 10, 20, 30, NULL, '2025-01-27 08:42:08', 0),
(3, 3, 'Assorted Sushi Platter', 'A beautiful arrangement of various sushi rolls and nigiri', '[\"2 cups sushi rice\", \"Nori sheets\", \"Fresh fish assortment\", \"Cucumber\", \"Avocado\"]', '[\"Prepare sushi rice\", \"Cut fish and vegetables\", \"Roll sushi\", \"Arrange on platter\"]', 'Japanese', 'Pescatarian', 'hard', 45, 30, 75, NULL, '2025-01-27 08:42:08', 0),
(4, 4, 'Decadent Chocolate Cake', 'A rich, multi-layered chocolate cake adorned with chocolate shavings and fresh berries', '[\"2 cups flour\", \"2 cups sugar\", \"3/4 cup cocoa powder\", \"2 eggs\", \"1 cup milk\", \"1/2 cup vegetable oil\", \"Fresh berries for garnish\"]', '[\"Mix dry ingredients\", \"Combine wet ingredients\", \"Bake layers\", \"Assemble with frosting\", \"Garnish with berries\"]', 'American', 'Vegetarian', 'medium', 30, 45, 75, NULL, '2025-01-27 08:42:08', 0),
(5, 5, 'Healthy Breakfast Bowl', 'A nutritious breakfast bowl filled with yogurt, granola, fresh berries, and honey', '[\"1 cup Greek yogurt\", \"1/2 cup granola\", \"1 cup mixed berries\", \"2 tbsp honey\", \"Mint leaves for garnish\"]', '[\"Layer yogurt in bowl\", \"Add granola\", \"Top with berries\", \"Drizzle honey\", \"Garnish with mint\"]', 'International', 'Vegetarian', 'easy', 10, 0, 10, NULL, '2025-01-27 08:42:08', 0),
(6, 6, 'Grilled Steak with Vegetables', 'A perfectly grilled steak served with roasted vegetables', '[\"1 lb ribeye steak\", \"2 cups mixed vegetables\", \"3 tbsp olive oil\", \"Fresh herbs\", \"Salt and pepper\"]', '[\"Season steak\", \"Prepare vegetables\", \"Grill steak to desired doneness\", \"Roast vegetables\", \"Plate and serve\"]', 'American', 'None', 'medium', 20, 25, 45, NULL, '2025-01-27 08:42:08', 0),
(7, 7, 'Colorful Macarons', 'An assortment of colorful macarons with various flavors', '[\"1 cup almond flour\", \"1 cup powdered sugar\", \"3 egg whites\", \"Food coloring\", \"Various fillings\"]', '[\"Prepare macaron batter\", \"Pipe shells\", \"Rest and bake\", \"Make fillings\", \"Assemble macarons\"]', 'French', 'Vegetarian', 'hard', 45, 20, 65, NULL, '2025-01-27 08:42:08', 0),
(8, 8, 'Classic Margherita Pizza', 'A traditional Margherita pizza with fresh ingredients', '[\"Pizza dough\", \"Fresh mozzarella\", \"San Marzano tomatoes\", \"Fresh basil\", \"Olive oil\"]', '[\"Prepare dough\", \"Add tomato sauce\", \"Top with cheese\", \"Bake\", \"Garnish with basil\"]', 'Italian', 'Vegetarian', 'medium', 20, 15, 35, NULL, '2025-01-27 08:42:08', 0),
(9, 9, 'Refreshing Fruit Salad', 'A refreshing mix of seasonal fruits with mint garnish', '[\"2 cups watermelon\", \"1 cup blueberries\", \"2 kiwis\", \"Fresh mint leaves\", \"Honey for drizzling\"]', '[\"Cut fruits into bite-sized pieces\", \"Combine in bowl\", \"Add mint leaves\", \"Drizzle with honey\", \"Chill before serving\"]', 'International', 'Vegan', 'easy', 15, 0, 15, NULL, '2025-01-27 08:42:08', 0),
(10, 10, 'Artisan Cheese Board', 'A carefully curated selection of cheeses and accompaniments', '[\"3 types of cheese\", \"Assorted nuts\", \"Fresh and dried fruits\", \"Crackers\", \"Honey\"]', '[\"Arrange cheeses\", \"Add nuts and fruits\", \"Place crackers\", \"Drizzle honey\", \"Garnish board\"]', 'International', 'Vegetarian', 'easy', 20, 0, 20, NULL, '2025-01-27 08:42:08', 0),
(11, 11, 'Homemade Burger with Fries', 'A classic burger served with crispy fries', '[\"1 lb ground beef\", \"Burger buns\", \"Lettuce\", \"Tomato\", \"Cheese\", \"Potatoes for fries\"]', '[\"Form patties\", \"Season and cook burgers\", \"Cut and fry potatoes\", \"Assemble burgers\", \"Serve hot\"]', 'American', 'None', 'medium', 25, 20, 45, NULL, '2025-01-27 08:42:08', 0),
(12, 12, 'Vegan Buddha Bowl', 'A nutritious bowl of grains, legumes, and vegetables', '[\"1 cup quinoa\", \"1 can chickpeas\", \"1 avocado\", \"Roasted vegetables\", \"Tahini dressing\"]', '[\"Cook quinoa\", \"Roast vegetables\", \"Prepare chickpeas\", \"Assemble bowl\", \"Add dressing\"]', 'International', 'Vegan', 'easy', 20, 30, 50, NULL, '2025-01-27 08:42:08', 0),
(13, 13, 'Seafood Paella', 'Traditional Spanish paella with seafood', '[\"2 cups rice\", \"Mussels\", \"Shrimp\", \"Saffron\", \"Peas\", \"Bell peppers\"]', '[\"Prepare rice with saffron\", \"Cook seafood\", \"Add vegetables\", \"Combine ingredients\", \"Let develop socarrat\"]', 'Spanish', 'Pescatarian', 'hard', 30, 45, 75, NULL, '2025-01-27 08:42:08', 0),
(14, 14, 'Stack of Pancakes', 'Fluffy pancakes with fresh berries and maple syrup', '[\"2 cups flour\", \"2 eggs\", \"Milk\", \"Fresh berries\", \"Maple syrup\"]', '[\"Mix batter\", \"Cook pancakes\", \"Stack with berries\", \"Add syrup\", \"Serve warm\"]', 'American', 'Vegetarian', 'easy', 15, 20, 35, NULL, '2025-01-27 08:42:08', 0),
(15, 15, 'Caprese Salad', 'Classic Italian salad with fresh ingredients', '[\"Fresh mozzarella\", \"Ripe tomatoes\", \"Fresh basil\", \"Olive oil\", \"Balsamic glaze\"]', '[\"Slice mozzarella and tomatoes\", \"Arrange on plate\", \"Add basil\", \"Drizzle with oil and glaze\", \"Season\"]', 'Italian', 'Vegetarian', 'easy', 10, 0, 10, NULL, '2025-01-27 08:42:08', 0),
(16, 16, 'Chocolate Chip Cookies', 'Classic homemade cookies with gooey chocolate chips', '[\"2 1/4 cups flour\", \"1 cup butter\", \"3/4 cup sugar\", \"2 eggs\", \"Chocolate chips\", \"Vanilla extract\"]', '[\"Cream butter and sugar\", \"Add eggs and vanilla\", \"Mix in dry ingredients\", \"Add chocolate chips\", \"Bake until golden\"]', 'American', 'Vegetarian', 'easy', 15, 12, 27, NULL, '2025-01-27 08:42:08', 0),
(17, 17, 'Sushi Rolls Assortment', 'Various sushi rolls with different fillings', '[\"Sushi rice\", \"Nori sheets\", \"Assorted fish\", \"Vegetables\", \"Soy sauce\"]', '[\"Prepare rice\", \"Lay out nori\", \"Add fillings\", \"Roll tightly\", \"Slice and serve\"]', 'Japanese', 'Pescatarian', 'hard', 40, 20, 60, NULL, '2025-01-27 08:42:08', 0),
(18, 18, 'Hearty Beef Stew', 'Rich and comforting beef stew with vegetables', '[\"2 lbs beef chunks\", \"Potatoes\", \"Carrots\", \"Peas\", \"Beef broth\", \"Herbs\"]', '[\"Brown meat\", \"Add vegetables\", \"Pour in broth\", \"Simmer until tender\", \"Season to taste\"]', 'International', 'None', 'medium', 30, 120, 150, NULL, '2025-01-27 08:42:08', 0),
(19, 19, 'Freshly Baked Croissants', 'Flaky, buttery French croissants', '[\"4 cups flour\", \"2 cups butter\", \"Yeast\", \"Milk\", \"Egg wash\"]', '[\"Make dough\", \"Laminate with butter\", \"Shape croissants\", \"Proof\", \"Bake until golden\"]', 'French', 'Vegetarian', 'hard', 60, 25, 85, NULL, '2025-01-27 08:42:08', 0),
(20, 20, 'Greek Salad', 'Traditional Greek salad with feta cheese', '[\"Cucumbers\", \"Tomatoes\", \"Red onions\", \"Feta cheese\", \"Olives\", \"Olive oil\"]', '[\"Chop vegetables\", \"Add olives and feta\", \"Dress with olive oil\", \"Season\", \"Toss gently\"]', 'Greek', 'Vegetarian', 'easy', 15, 0, 15, NULL, '2025-01-27 08:42:08', 0),
(21, 21, 'Blueberry Muffins', 'Moist muffins packed with fresh blueberries', '[\"2 cups flour\", \"Fresh blueberries\", \"Sugar\", \"Eggs\", \"Milk\", \"Butter\"]', '[\"Mix dry ingredients\", \"Combine wet ingredients\", \"Fold in blueberries\", \"Fill muffin tins\", \"Bake\"]', 'American', 'Vegetarian', 'easy', 20, 25, 45, NULL, '2025-01-27 08:42:08', 0),
(22, 22, 'Shrimp Tacos', 'Grilled shrimp tacos with fresh toppings', '[\"Shrimp\", \"Tortillas\", \"Cabbage slaw\", \"Lime\", \"Cilantro\", \"Avocado\"]', '[\"Season shrimp\", \"Make slaw\", \"Grill shrimp\", \"Warm tortillas\", \"Assemble tacos\"]', 'Mexican', 'Pescatarian', 'medium', 25, 15, 40, NULL, '2025-01-27 08:42:08', 0),
(23, 23, 'Chocolate Fondue', 'Rich chocolate fondue with dipping items', '[\"Dark chocolate\", \"Heavy cream\", \"Fresh fruits\", \"Marshmallows\", \"Pound cake\"]', '[\"Melt chocolate\", \"Add cream\", \"Prepare dipping items\", \"Keep warm\", \"Serve with skewers\"]', 'International', 'Vegetarian', 'easy', 20, 10, 30, NULL, '2025-01-27 08:42:08', 0),
(24, 24, 'Avocado Toast', 'Trendy and nutritious breakfast toast', '[\"Sourdough bread\", \"Ripe avocados\", \"Cherry tomatoes\", \"Sesame seeds\", \"Red pepper flakes\"]', '[\"Toast bread\", \"Mash avocado\", \"Season\", \"Add toppings\", \"Serve immediately\"]', 'International', 'Vegan', 'easy', 10, 5, 15, NULL, '2025-01-27 08:42:08', 0),
(25, 25, 'Lemon Meringue Pie', 'Classic pie with tangy lemon filling', '[\"Pie crust\", \"Lemons\", \"Sugar\", \"Egg whites\", \"Cornstarch\", \"Butter\"]', '[\"Prepare crust\", \"Make lemon filling\", \"Whip meringue\", \"Assemble\", \"Bake until golden\"]', 'American', 'Vegetarian', 'hard', 45, 35, 80, NULL, '2025-01-27 08:42:08', 0),
(26, 26, 'Ramen Noodle Bowl', 'Hearty ramen with traditional toppings', '[\"Ramen noodles\", \"Pork belly\", \"Soft-boiled egg\", \"Green onions\", \"Nori\", \"Broth\"]', '[\"Prepare broth\", \"Cook noodles\", \"Slice pork\", \"Prepare toppings\", \"Assemble bowl\"]', 'Japanese', 'None', 'medium', 30, 60, 90, NULL, '2025-01-27 08:42:08', 0),
(27, 27, 'Fruit Tart', 'Elegant tart with custard and fresh fruits', '[\"Tart crust\", \"Pastry cream\", \"Assorted fruits\", \"Apricot glaze\", \"Vanilla bean\"]', '[\"Bake crust\", \"Make custard\", \"Arrange fruits\", \"Glaze\", \"Chill before serving\"]', 'French', 'Vegetarian', 'hard', 40, 25, 65, NULL, '2025-01-27 08:42:08', 0),
(32, 136, '9', '9', '[\"9\",\"45\"]', '[\"9\",\"45\"]', 'American', 'Vegan', 'hard', 9, 9, 9, 'https://th.bing.com/th/id/OIG4.8lm4jML2rxQ0eqR.ZGoC?pid=ImgGn', '2025-01-28 00:51:43', 1);

CREATE TABLE `Resources` (
  `ResourceID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `resourcetype` varchar(10) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `media` varchar(50) DEFAULT NULL,
  `type` enum('cooking','educational','info') NOT NULL DEFAULT 'info'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Resources` (`ResourceID`, `title`, `description`, `url`, `resourcetype`, `CreatedAt`, `media`, `type`) VALUES
(1, 'Growing More than Renewable Energy', 'Connexus Energy is advancing the work that is being done at their community solar garden. Beyond renewable energy, they planted native species, and now they\'ve brought in the pollinators.', 'https://archive.org/download/Growing_More_than_Renewable_Energy/Growing_More_than_Renewable_Energy.mp4', 'mp4', '2025-01-29 08:17:53', 'video', 'educational'),
(2, 'What next for renewable energy?', 'Matt Simmons says that we already have the technology to make a revolution in renewable energy sources. He discusses options ranging from solar energy in space and tidal energy to a form of enhanced geothermal power generation involving turning piped sea water into steam.', 'https://archive.org/download/BigPictureTV-WhatNextForRenewableEnergy321/BigPictureTV-WhatNextForRenewableEnergy321_512kb.mp4', 'mp4', '2025-01-29 08:17:53', 'video', 'educational'),
(3, 'Can renewable energy power the world?', 'Renewable energy can replace fossil fuels and nuclear power and power the world, says Hermann Scheer. Scheer was President of the European Association for Renewable Energies (EUROSOLAR.) He argued that propaganda by fossil fuel industries ignores evidence that renewables provide enough energy.', 'https://archive.org/download/bliptv-20131013-095115-BigPictureTV-CanRenewableEnergyPowerTheWorld593/bliptv-20131013-095115-BigPictureTV-CanRenewableEnergyPowerTheWorld593.mp4', 'mp4', '2025-01-29 08:17:53', 'video', 'educational'),
(4, 'Renewable Energy Project Spotlight', 'A comprehensive spotlight on renewable energy projects, highlighting key initiatives and their impact on sustainable energy development.', 'https://archive.org/download/renewableenergypv1v7montrich/renewableenergypv1v7montrich_bw.pdf', 'pdf', '2025-01-29 12:01:15', 'PDF', 'educational'),
(5, 'Global Weighted Average LCOE from Utility-Scale Renewables', 'Chart showing the global weighted average levelised cost of electricity (LCOE) from utility-scale renewable power generation technologies, comparing 2010 and 2019 data.', 'https://archive.org/download/1-global-weighted-average-levelised-cost-of-electricity-from-utility-scale-renew/Screen%20Shot%202022-03-15%20at%207.48.14%20AM.png', 'png', '2025-01-29 12:01:15', 'image', 'educational'),
(6, 'Cost Of Electricity From Renewables', 'Infographic illustrating the comparative costs of electricity generation from various renewable energy sources.', 'https://archive.org/download/cost-of-electricity-from-renewables/Cost-of-electricity-from-renewables.jpeg', 'jpeg', '2025-01-29 12:01:15', 'image', 'educational'),
(7, 'Renewable Energy Price Trends', 'Graph demonstrating the historical trend of declining prices in renewable energy technologies over time, showing the increasing cost-effectiveness of renewable solutions.', 'https://archive.org/download/graph-of-falling-prices-of-renewables-over-time/Screen%20Shot%202022-05-27%20at%208.58.36%20AM.png', 'png', '2025-01-29 12:01:15', 'image', 'educational'),
(8, 'Cooking Tutorial - Episode 20', 'A fun and educational cooking tutorial demonstrating basic cooking techniques and recipe preparation.', 'https://archive.org/download/youtube-Uj4eEDDqNzk/Uj4eEDDqNzk.mp4', 'mp4', '2025-01-29 13:19:16', 'video', 'cooking'),
(9, 'Kitchen Tips and Tricks - Episode 37', 'Helpful kitchen tips and tricks to improve your cooking efficiency and food preparation skills.', 'https://archive.org/download/youtube-gxQS_J8Fc80/gxQS_J8Fc80.mp4', 'mp4', '2025-01-29 13:19:16', 'video', 'info');

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FailedAttempts` int(11) DEFAULT 0,
  `LockoutTime` datetime DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Users` (`UserID`, `FirstName`, `LastName`, `Email`, `Password`, `FailedAttempts`, `LockoutTime`, `CreatedAt`) VALUES
(1, 'John', 'Smith', 'john.smith@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(2, 'Emma', 'Johnson', 'emma.j@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(3, 'Michael', 'Brown', 'michael.b@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(4, 'Sarah', 'Davis', 'sarah.d@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(5, 'David', 'Wilson', 'david.w@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(6, 'Lisa', 'Anderson', 'lisa.a@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(7, 'James', 'Taylor', 'james.t@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(8, 'Emily', 'Thomas', 'emily.t@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(9, 'Robert', 'Martinez', 'robert.m@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(10, 'Jennifer', 'Garcia', 'jennifer.g@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(11, 'William', 'Lopez', 'william.l@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(12, 'Elizabeth', 'Lee', 'elizabeth.l@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(13, 'Christopher', 'Gonzalez', 'chris.g@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(14, 'Ashley', 'Rodriguez', 'ashley.r@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(15, 'Daniel', 'Perez', 'daniel.p@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(16, 'Michelle', 'Turner', 'michelle.t@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(17, 'Joseph', 'Phillips', 'joseph.p@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(18, 'Amanda', 'Campbell', 'amanda.c@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(19, 'Kevin', 'Parker', 'kevin.p@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(20, 'Melissa', 'Evans', 'melissa.e@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(21, 'Steven', 'Edwards', 'steven.e@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(22, 'Laura', 'Collins', 'laura.c@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(23, 'Timothy', 'Stewart', 'timothy.s@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(24, 'Rebecca', 'Morris', 'rebecca.m@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(25, 'Brian', 'Murphy', 'brian.m@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(26, 'Nicole', 'Cook', 'nicole.c@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(27, 'George', 'Rogers', 'george.r@email.com', '$2y$10$abcdefghijklmnopqrstuv', 0, NULL, '2025-01-26 23:36:01'),
(136, 'Gold Edward', 'Edem Hogan', 'edge37@outlook.com', '$2y$10$twPUets2rnFvw0Bc2LgB8Oh8YmJUY36RR8kS5.cg8wPJENVExF2zq', 0, NULL, '2025-01-27 09:01:34'),
(137, 'Gold', 'Edem Hogan', 'efs@ecom', '$2y$10$5YHBtU5qoqAf6CPtXR6dUu3Yh4UgmuRrHLOH8QsIJ497aetdiU1zK', 0, NULL, '2025-01-27 09:12:17'),
(138, 'Gold', 'Edem Hogan', 'e@outlook.com', '$2y$10$O40uSoHKQ0fAgxVYyuh/r.DikXLBl5j89X.LZIZJ4iC2O8HWwKN.K', 0, NULL, '2025-01-27 12:03:36'),
(139, 'Eds', 'FES', 'sdf@d.com', '$2y$10$s.Kj3P6QnqyNvLrEbZiX5OppIkUSYuka2RHTB09nxlo2eiJpX0XyO', 0, NULL, '2025-01-27 12:05:46'),
(140, 'X', 'X', 'x@outlook.com', '$2y$10$c1IWDyyUWNkclphC/spHQeahoSsCSjGj6gSf9a40IllY4fS9772xW', 0, NULL, '2025-01-27 12:06:55');


ALTER TABLE `Comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `RecipeID` (`RecipeID`),
  ADD KEY `idx_parent_comment` (`parent_comment_id`);

ALTER TABLE `ContentImages`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `RecipeID` (`RecipeID`),
  ADD KEY `idx_event_images` (`EventID`);

ALTER TABLE `Events`
  ADD PRIMARY KEY (`EventID`);

ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_post_id` (`parent_post_id`);

ALTER TABLE `Recipes`
  ADD PRIMARY KEY (`RecipeID`),
  ADD KEY `UserID` (`UserID`);

ALTER TABLE `Resources`
  ADD PRIMARY KEY (`ResourceID`);

ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);


ALTER TABLE `Comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `ContentImages`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

ALTER TABLE `Events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `Recipes`
  MODIFY `RecipeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

ALTER TABLE `Resources`
  MODIFY `ResourceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;


ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`),
  ADD CONSTRAINT `comments_parent_fk` FOREIGN KEY (`parent_comment_id`) REFERENCES `Comments` (`CommentID`) ON DELETE CASCADE;

ALTER TABLE `ContentImages`
  ADD CONSTRAINT `ContentImages_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_images` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`) ON DELETE CASCADE;

ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`parent_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

ALTER TABLE `Recipes`
  ADD CONSTRAINT `Recipes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
