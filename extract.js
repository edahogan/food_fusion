const puppeteer = require('puppeteer');

const urls = [
  { id: 1, url: 'https://www.pexels.com/photo/variety-of-vegetables-on-brown-wooden-surface-1435904/', pexels: true },
  { id: 2, url: 'https://unsplash.com/photos/4_jhDO54BYg', unsplash: true },
  { id: 3, url: 'https://www.pexels.com/photo/assorted-sushi-on-black-plate-3577568/', pexels: true },
  { id: 4, url: 'https://unsplash.com/photos/8npZlBR6v8I', unsplash: true },
  { id: 5, url: 'https://www.pexels.com/photo/close-up-photo-of-breakfast-bowl-704569/', pexels: true },
  // Add more URLs as needed
];

const selectors = {
  pexels: '#__next > main > div > div > div.Wrapper_edgeMarginExtended__4umlW.PhotoZoom_overflowContainer__vE3Le.spacing_noMargin__F5u9R.spacing_mmb20__SO2Ac.spacing_tmb20__001C1.spacing_dmb30__d4T3_.spacing_omb30__A_Qq9 > div > div > img',
  unsplash: '#app > div > div > div:nth-child(4) > div > div:nth-child(1) > div.JSprG > div > div > button > div.xH5KD > img.tzC2N.fbGdz.cnmNG'
};

const scrapeImageUrl = async (url, selector) => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();

  try {
    await page.goto(url, { waitUntil: 'networkidle2' });
    await page.waitForSelector(selector);
    const imageUrl = await page.$eval(selector, img => img.src);
    return imageUrl;
  } catch (error) {
    console.error(`Error scraping ${url}:`, error);
    return null;
  } finally {
    await browser.close();
  }
};

(async () => {
  for (const { id, url, pexels, unsplash } of urls) {
    const selector = pexels ? selectors.pexels : unsplash ? selectors.unsplash : null;

    if (!selector) {
      console.log(`No selector defined for URL ID ${id}`);
      continue;
    }

    console.log(`Scraping image from URL ID ${id}: ${url}`);
    const imageUrl = await scrapeImageUrl(url, selector);

    if (imageUrl) {
      console.log(`Image URL for ID ${id}: ${imageUrl}`);
    } else {
      console.log(`Failed to scrape image for ID ${id}`);
    }
  }
})();
