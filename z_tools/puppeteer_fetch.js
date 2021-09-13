const puppeteer = require('puppeteer');

(async () => {
  try {
	const browser = await puppeteer.launch({
		headless: false
	});
	const page = await browser.newPage();

	let url = process.argv[2];
	
	await page.goto(url, {
	    waitUntil: 'networkidle2',
	});
	
	let data = await page.evaluate(() => document.querySelector('*').outerHTML);

    console.log(data);

	await browser.close();
  } 
  catch (err) {
    console.error(err);
  }
})();