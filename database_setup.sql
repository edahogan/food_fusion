-- Create Users table
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    FailedAttempts INT DEFAULT 0,
    LockoutTime DATETIME,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Recipes table
CREATE TABLE Recipes (
    RecipeID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Title VARCHAR(100) NOT NULL,
    Description TEXT,
    Ingredients JSON NOT NULL,
    Instructions JSON NOT NULL,
    Cuisine VARCHAR(50),
    DietaryPreference VARCHAR(50),
    Difficulty ENUM('easy', 'medium', 'hard') NOT NULL,
    PrepTime INT NOT NULL COMMENT 'Preparation time in minutes',
    CookTime INT NOT NULL COMMENT 'Cooking time in minutes',
    TotalTime INT NOT NULL COMMENT 'Total time in minutes',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Create RecipeImages table
CREATE TABLE RecipeImages (
    ImageID INT PRIMARY KEY AUTO_INCREMENT,
    RecipeID INT NOT NULL,
    ImageURL VARCHAR(255) NOT NULL,
    IsPrimary BOOLEAN DEFAULT FALSE,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RecipeID) REFERENCES Recipes(RecipeID) ON DELETE CASCADE
);

-- Create Comments table
CREATE TABLE Comments (
    CommentID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    RecipeID INT,
    Content TEXT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RecipeID) REFERENCES Recipes(RecipeID)
);

-- Create Events table
CREATE TABLE Events (
    EventID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(100) NOT NULL,
    Description TEXT,
    EventDate DATETIME,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Resources table
CREATE TABLE Resources (
    ResourceID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(100) NOT NULL,
    Description TEXT,
    FileURL VARCHAR(255),
    ResourceType ENUM('Recipe Card', 'Tutorial', 'Video', 'Infographic') NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cooking_events (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date TIMESTAMP NOT NULL,
    image_url VARCHAR(512),
    spots_available INTEGER,
    price DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add some sample data
INSERT INTO cooking_events (title, description, event_date, image_url, spots_available, price) VALUES
    ('Italian Pasta Masterclass', 'Learn the art of handmade pasta from our expert chefs', '2024-04-15 18:00:00', '/images/events/pasta-class.jpg', 12, 89.99),
    ('Sushi Rolling Workshop', 'Master the techniques of rolling perfect sushi', '2024-04-20 19:00:00', '/images/events/sushi-class.jpg', 8, 99.99),
    ('French Pastry Basics', 'Discover the secrets of French pastry making', '2024-04-25 17:30:00', '/images/events/pastry-class.jpg', 10, 79.99);