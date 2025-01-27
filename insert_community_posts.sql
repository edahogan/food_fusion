-- Insert community posts using existing user IDs
-- Assuming user_id exists in the posts table
INSERT INTO posts (user_id, top, body, created_at) VALUES
(1, 'Looking for Traditional Italian Pasta Recipes', 
   'Hi everyone! I''m trying to expand my Italian cooking skills. Does anyone have authentic family recipes for pasta dishes they''d be willing to share? Particularly interested in traditional sauce recipes!',
   NOW() - INTERVAL 2 DAY),

(2, 'Tips for Perfecting Macarons?', 
   'I''ve been trying to make French macarons but keep running into issues with hollow shells and cracked tops. Any experienced bakers have tips for getting that perfect texture?',
   NOW() - INTERVAL 1 DAY),

(3, 'Best Way to Season Cast Iron?', 
   'Just got my first cast iron skillet and want to make sure I''m seasoning it properly. What''s your preferred method and oil choice for seasoning?',
   NOW() - INTERVAL 12 HOUR),

(1, 'Weekly Meal Prep Strategies', 
   'Looking to start meal prepping to save time during the week. What are your favorite make-ahead recipes that stay fresh for several days?',
   NOW() - INTERVAL 6 HOUR),

(2, 'Favorite Kitchen Gadget?', 
   'Just curious - what''s the one kitchen tool or gadget you can''t live without? Mine is my instant-read thermometer!',
   NOW() - INTERVAL 3 HOUR);

-- Add replies to these posts
INSERT INTO posts (user_id, top, body, parent_post_id, created_at) VALUES
(3, 'My nonna''s marinara sauce is amazing - happy to share! The key is using San Marzano tomatoes and fresh basil. Let me know if you want the full recipe.', 
    NULL, 1, NOW() - INTERVAL 1 DAY),

(1, 'The game-changer for my macarons was aging the egg whites for 24 hours and using a silicon mat instead of parchment paper. Also, make sure to let them rest until they form a skin before baking!',
    NULL, 2, NOW() - INTERVAL 12 HOUR),

(2, 'Flaxseed oil worked best for me. Make sure to apply very thin layers and heat until it smokes. Repeat 3-4 times for the best results.',
    NULL, 3, NOW() - INTERVAL 6 HOUR),

(3, 'I do a big batch of grilled chicken, roasted vegetables, and quinoa on Sundays. They all keep well and can be mixed and matched throughout the week.',
    NULL, 4, NOW() - INTERVAL 2 HOUR),

(1, 'My food processor is my MVP! Use it almost daily for everything from chopping veggies to making pie crust.',
    NULL, 5, NOW() - INTERVAL 1 HOUR); 