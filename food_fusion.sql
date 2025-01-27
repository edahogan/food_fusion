-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2025 at 01:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_fusion`
--
CREATE DATABASE IF NOT EXISTS `food_fusion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `food_fusion`;

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--
-- Creation: Jan 26, 2025 at 11:35 PM
--

DROP TABLE IF EXISTS `Comments`;
CREATE TABLE `Comments` (
  `CommentID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `RecipeID` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `Comments`:
--   `UserID`
--       `Users` -> `UserID`
--   `RecipeID`
--       `Recipes` -> `RecipeID`
--

-- --------------------------------------------------------

--
-- Table structure for table `ContentImages`
--
-- Creation: Jan 27, 2025 at 01:08 AM
--

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

--
-- RELATIONSHIPS FOR TABLE `ContentImages`:
--   `RecipeID`
--       `Recipes` -> `RecipeID`
--   `EventID`
--       `Events` -> `EventID`
--

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--
-- Creation: Jan 27, 2025 at 03:03 AM
--

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

--
-- RELATIONSHIPS FOR TABLE `Events`:
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--
-- Creation: Jan 27, 2025 at 10:44 AM
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `top` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `posts`:
--   `user_id`
--       `users` -> `id`
--   `parent_post_id`
--       `posts` -> `post_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `Recipes`
--
-- Creation: Jan 27, 2025 at 10:22 AM
--

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

--
-- RELATIONSHIPS FOR TABLE `Recipes`:
--   `UserID`
--       `Users` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `Resources`
--
-- Creation: Jan 26, 2025 at 11:35 PM
--

DROP TABLE IF EXISTS `Resources`;
CREATE TABLE `Resources` (
  `ResourceID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `FileURL` varchar(255) DEFAULT NULL,
  `ResourceType` enum('Recipe Card','Tutorial','Video','Infographic') NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `Resources`:
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jan 26, 2025 at 11:35 PM
-- Last update: Jan 27, 2025 at 12:06 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--
-- Creation: Jan 26, 2025 at 11:35 PM
-- Last update: Jan 27, 2025 at 12:06 PM
--

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

--
-- RELATIONSHIPS FOR TABLE `Users`:
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `RecipeID` (`RecipeID`);

--
-- Indexes for table `ContentImages`
--
ALTER TABLE `ContentImages`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `RecipeID` (`RecipeID`),
  ADD KEY `idx_event_images` (`EventID`);

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_post_id` (`parent_post_id`);

--
-- Indexes for table `Recipes`
--
ALTER TABLE `Recipes`
  ADD PRIMARY KEY (`RecipeID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Resources`
--
ALTER TABLE `Resources`
  ADD PRIMARY KEY (`ResourceID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ContentImages`
--
ALTER TABLE `ContentImages`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Events`
--
ALTER TABLE `Events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Recipes`
--
ALTER TABLE `Recipes`
  MODIFY `RecipeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Resources`
--
ALTER TABLE `Resources`
  MODIFY `ResourceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`);

--
-- Constraints for table `ContentImages`
--
ALTER TABLE `ContentImages`
  ADD CONSTRAINT `ContentImages_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `Recipes` (`RecipeID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_images` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`parent_post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `Recipes`
--
ALTER TABLE `Recipes`
  ADD CONSTRAINT `Recipes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
