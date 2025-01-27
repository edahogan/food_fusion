-- First clear existing data
DELETE FROM ContentImages WHERE ContentType = 'event';
DELETE FROM Events;

-- Reset auto-increment
ALTER TABLE Events AUTO_INCREMENT = 1;

-- Insert events
INSERT INTO Events (Title, Description, Location, MaxAttendees, EventDate, RegistrationDeadline, Status, ImageURL) VALUES
('Artisanal Bread Making Workshop', 
'Master the art of bread making with our expert bakers. Learn to create crusty sourdough, fluffy brioche, and rustic country loaves. All ingredients and tools provided. Perfect for beginners!', 
'Culinary Institute Kitchen Lab A', 
20, 
'2024-03-15 10:00:00',
'2024-03-13 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG3.11.YVWBZcnlUpicF3H6G'),

('Farm-to-Table Cooking Experience',
'Join us for a unique experience where you''ll harvest fresh ingredients from our partner farm and learn to transform them into delicious seasonal dishes. Includes farm tour and cooking session.',
'Green Meadows Farm & Kitchen',
15,
'2024-03-20 09:00:00',
'2024-03-18 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG3.YxWwtgFegge_6_QG9hgR'),

('Asian Street Food Festival',
'Experience the vibrant flavors of Asian street cuisine! Learn to make dumplings, bao buns, and other popular street food favorites. Take home your creations and detailed recipes.',
'Downtown Food Market',
50,
'2024-04-01 11:00:00',
'2024-03-30 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG3.Yf.HmaX3rG9WcO0_LycN'),

('Mediterranean Cooking Class',
'Discover the healthy and delicious Mediterranean cuisine. Learn to make authentic paella, fresh pasta, and classic Greek dishes. Wine pairing included for participants over 21.',
'Seaside Culinary Center',
25,
'2024-04-10 14:00:00',
'2024-04-08 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG1.hS3huTg6aUrvrSmr9hfi'),

('Dessert Masterclass',
'Perfect your pastry skills with our expert pastry chef. From French macarons to decadent chocolate creations, learn the secrets of professional dessert making. All skill levels welcome!',
'Sweet Dreams Bakery',
15,
'2024-04-15 13:00:00',
'2024-04-13 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG1.kCjFiFQzdxfdXsL_QBy0'),

('Sustainable Cooking Workshop',
'Learn eco-friendly cooking practices, zero-waste techniques, and how to make the most of seasonal ingredients while reducing your carbon footprint. Includes take-home composting guide.',
'Green Living Center',
30,
'2024-04-22 10:00:00',
'2024-04-20 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG1.hmXld9Uf.0p6Fnmm2ZD2'),

('BBQ & Grilling Masterclass',
'Master the art of grilling with expert tips, techniques, and recipes. From perfect steaks to grilled vegetables, become a backyard BBQ master! Includes tasting session.',
'Outdoor Cooking Pavilion',
25,
'2024-05-01 12:00:00',
'2024-04-29 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG1.gHk78_QXNh4WD5nWTpmf'),


('Wine & Food Pairing Evening',
'Join our sommelier for an educational evening of wine tasting and food pairing. Learn the principles of pairing and enhance your dining experiences. Must be 21 or older to attend.',
'Vintage Wine Cellar',
20,
'2024-05-10 18:00:00',
'2024-05-08 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG1.uqciY37xO0DzBe6N8fJO'),

('Kids Cooking Camp',
'A fun-filled cooking adventure for young chefs! Kids will learn kitchen safety, basic cooking skills, and create delicious kid-friendly recipes. Ages 8-12 welcome.',
'Junior Chef Academy',
15,
'2024-05-15 09:00:00',
'2024-05-13 23:59:59',
'upcoming',
'https://th.bing.com/th/id/OIG1.gWeZLtdAYDaVmUjMn3Z4');

-- Insert corresponding images
INSERT INTO ContentImages (ContentType, EventID, ImageURL, IsPrimary) VALUES
('event', 1, 'https://th.bing.com/th/id/OIG3.11.YVWBZcnlUpicF3H6G', TRUE),
('event', 2, 'https://th.bing.com/th/id/OIG3.YxWwtgFegge_6_QG9hgR', TRUE),
('event', 3, 'https://th.bing.com/th/id/OIG3.Yf.HmaX3rG9WcO0_LycN', TRUE),
('event', 4, 'https://th.bing.com/th/id/OIG1.hS3huTg6aUrvrSmr9hfi', TRUE),
('event', 5, 'https://th.bing.com/th/id/OIG1.kCjFiFQzdxfdXsL_QBy0', TRUE),
('event', 6, 'https://th.bing.com/th/id/OIG1.hmXld9Uf.0p6Fnmm2ZD2', TRUE),
('event', 7, 'https://th.bing.com/th/id/OIG1.gHk78_QXNh4WD5nWTpmf', TRUE),
('event', 8, 'https://th.bing.com/th/id/OIG1.uqciY37xO0DzBe6N8fJO', TRUE),
('event', 9, 'https://th.bing.com/th/id/OIG1.gWeZLtdAYDaVmUjMn3Z4', TRUE);