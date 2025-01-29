-- Insert educational document and image resources
INSERT INTO Resources (
    resourcetype,  -- File extension
    media,        -- Type of media
    type,         -- 'educational' for all these cases
    title,
    url,
    description
) VALUES 
(
    'pdf',
    'none',       -- Changed from 'document' to 'file'
    'educational',
    'Renewable Energy Project Spotlight',
    'https://archive.org/download/renewableenergypv1v7montrich/renewableenergypv1v7montrich_bw.pdf',
    'A comprehensive spotlight on renewable energy projects, highlighting key initiatives and their impact on sustainable energy development.'
),
(
    'png',
    'image',
    'educational',
    'Global Weighted Average LCOE from Utility-Scale Renewables',
    'https://archive.org/download/1-global-weighted-average-levelised-cost-of-electricity-from-utility-scale-renew/Screen%20Shot%202022-03-15%20at%207.48.14%20AM.png',
    'Chart showing the global weighted average levelised cost of electricity (LCOE) from utility-scale renewable power generation technologies, comparing 2010 and 2019 data.'
),
(
    'jpeg',
    'image',
    'educational',
    'Cost Of Electricity From Renewables',
    'https://archive.org/download/cost-of-electricity-from-renewables/Cost-of-electricity-from-renewables.jpeg',
    'Infographic illustrating the comparative costs of electricity generation from various renewable energy sources.'
),
(
    'png',
    'image',
    'educational',
    'Renewable Energy Price Trends',
    'https://archive.org/download/graph-of-falling-prices-of-renewables-over-time/Screen%20Shot%202022-05-27%20at%208.58.36%20AM.png',
    'Graph demonstrating the historical trend of declining prices in renewable energy technologies over time, showing the increasing cost-effectiveness of renewable solutions.'
);

-- First alter the column to ensure it can hold the new value
ALTER TABLE Resources MODIFY COLUMN media VARCHAR(50);

-- Then perform the update
UPDATE Resources 
SET media = 'pdf'
WHERE media = 'none';

