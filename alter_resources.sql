-- Rename columns in Resources table
ALTER TABLE Resources CHANGE COLUMN FileURL url VARCHAR(255);
ALTER TABLE Resources CHANGE COLUMN Description description TEXT;
ALTER TABLE Resources CHANGE COLUMN Title title VARCHAR(255);

-- Insert educational video resources
INSERT INTO Resources (
    resourcetype,  -- File extension
    media,        -- 'video' for all these cases
    type,         -- 'educational' for all these cases
    title,
    url,
    description
) VALUES 
(
    'mp4',
    'video',
    'educational',
    'Growing More than Renewable Energy',
    'https://archive.org/download/Growing_More_than_Renewable_Energy/Growing_More_than_Renewable_Energy.mp4',
    'Connexus Energy is advancing the work that is being done at their community solar garden. Beyond renewable energy, they planted native species, and now they''ve brought in the pollinators.'
),
(
    'mp4',
    'video',
    'educational',
    'What next for renewable energy?',
    'https://archive.org/download/BigPictureTV-WhatNextForRenewableEnergy321/BigPictureTV-WhatNextForRenewableEnergy321_512kb.mp4',
    'Matt Simmons says that we already have the technology to make a revolution in renewable energy sources. He discusses options ranging from solar energy in space and tidal energy to a form of enhanced geothermal power generation involving turning piped sea water into steam.'
),
(
    'mp4',
    'video',
    'educational',
    'Can renewable energy power the world?',
    'https://archive.org/download/bliptv-20131013-095115-BigPictureTV-CanRenewableEnergyPowerTheWorld593/bliptv-20131013-095115-BigPictureTV-CanRenewableEnergyPowerTheWorld593.mp4',
    'Renewable energy can replace fossil fuels and nuclear power and power the world, says Hermann Scheer. Scheer was President of the European Association for Renewable Energies (EUROSOLAR.) He argued that propaganda by fossil fuel industries ignores evidence that renewables provide enough energy.'
);

