-- Add ENUM constraints for DietaryPreference and Cuisine
ALTER TABLE Recipes 
    MODIFY COLUMN DietaryPreference ENUM('None', 'Vegetarian', 'Vegan', 'Pescatarian', 'Gluten-Free', 'Dairy-Free', 'Keto') NOT NULL DEFAULT 'None',
    MODIFY COLUMN Cuisine ENUM('American', 'Italian', 'Mexican', 'Asian', 'Mediterranean', 'French', 'Spanish', 'Greek', 'Japanese', 'International') NOT NULL DEFAULT 'International'; 