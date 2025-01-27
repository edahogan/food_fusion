START TRANSACTION;

-- First delete all recipe images
DELETE FROM ContentImages 
WHERE ContentType = 'recipe';

-- Then delete all recipes
DELETE FROM Recipes;

-- Reset auto-increment counters
ALTER TABLE Recipes AUTO_INCREMENT = 1;

COMMIT; 