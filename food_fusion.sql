SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `food_fusion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `food_fusion`;

DROP TABLE IF EXISTS `Comments`;
CREATE TABLE `Comments` (
  `CommentID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `RecipeID` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ContentImages`;
CREATE TABLE `ContentImages` (
  `ImageID` int(11) NOT NULL,
  `ContentType` enum('recipe','event') NOT NULL DEFAULT 'recipe',
  `RecipeID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) NOT NULL,
  `IsPrimary` tinyint(1) DEFAULT 0,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `EventID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Events`;
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

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `top` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `Recipes`;
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

DROP TABLE IF EXISTS `Resources`;
CREATE TABLE `Resources` (
  `ResourceID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `FileURL` varchar(255) DEFAULT NULL,
  `ResourceType` enum('Recipe Card','Tutorial','Video','Infographic') NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Users`;
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


ALTER TABLE `Comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `RecipeID` (`RecipeID`);

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
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ContentImages`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Recipes`
  MODIFY `RecipeID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Resources`
  MODIFY `ResourceID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`);

ALTER TABLE `ContentImages`
  ADD CONSTRAINT `ContentImages_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_images` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`) ON DELETE CASCADE;

ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`parent_post_id`) REFERENCES `posts` (`post_id`);

ALTER TABLE `Recipes`
  ADD CONSTRAINT `Recipes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
