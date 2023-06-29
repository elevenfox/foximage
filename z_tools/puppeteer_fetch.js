const puppeteer = require('puppeteer');

(async () => {
  try {
	// const browser = await puppeteer.launch({
	// 	headless: true,
	// 	executablePath: '/usr/bin/chromium-browser',
    //     args: ['--no-sandbox', '--disable-setuid-sandbox']
	// });
	// const page = await browser.newPage();

	const browser = await puppeteer.launch({
		headless: false, 
		defaultViewport: null,
		args: ['--no-sandbox', '--disable-setuid-sandbox']
	});
    // const context = browser.defaultBrowserContext();
    const page = await browser.newPage();
    page. setDefaultNavigationTimeout(0); 

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