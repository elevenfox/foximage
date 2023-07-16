const puppeteer = require('puppeteer');

(async () => {
	const browser = await puppeteer.launch({headless: false, defaultViewport: null});
    const context = browser.defaultBrowserContext();
    await context.overridePermissions('https://www.terabox.com/', ['clipboard-read']);
	const page = await browser.newPage();
    page. setDefaultNavigationTimeout(0); 
    //await page.setViewport({ width: 1366, height: 768});

	await page.goto('https://www.terabox.com/');

    // Login
    await page.waitForSelector('input[class="input email-input"]'),
    await delay(2000);
    await page.type('input[class="input email-input"]', 'tutusoft0011@gmail.com');
    await page.type('input[class="input pwd-input"]', 'tbox1102*');
    await delay(2000);
    const login = await page.waitForSelector('div[class="login-submit-btn btn-abled"]');
    await login.click();
	await delay(2000);

    // Go to first level dir
    const tuzac = await page.waitForSelector('a[title="tuzac-4"]');
    await tuzac.click();
    await delay(2000);

    // Go to second level dir
    const ishow = await page.waitForSelector('a[title="mtcos"]');
    await ishow.click();
    await delay(2000);

    // Go to second level dir
    const sub = await page.waitForSelector('a[title="500"]');
    await sub.click();
    await delay(2000);

    // Order by file name
    const [orderBy] = await page.$x("//span[contains(., 'File name')]");
    if (orderBy) {
        await orderBy.click();
    }
    await delay(2000);
    
    // Get items loaded
    let itemCount = await getItemCount(page);

    // Start processing items
    let rows = [];
    rows = await processItems(page, rows);

    // Check processed items and total items
    do {
        await scrollDown(page, rows.length);
        await delay(5000)
        itemCount = await getItemCount(page);
        rows = await processItems(page, rows);
    }
    while(rows.length < itemCount);
    
    
    await delay(10000);
	await browser.close();
})();

function delay(time) {
    return new Promise(function(resolve) { 
        setTimeout(resolve, time)
    }); 
}

async function scrollDown(page, count) {
    count = count - 1;
    await page.$eval('tr[index="' + count + '"]', e => {
        e.scrollIntoView({ behavior: 'smooth', block: 'end', inline: 'end' });
    });
}

async function getItemCount(page) {
    let countText = await page.$eval('span.wp-s-pan-file-main__nav-right-count', el => el.textContent);
    let itemCount = countText.match(/\d+/)[0];
    console.log('--- itemCount:' + itemCount);
    return itemCount;
}

async function processItems(page, rows) {
    const fs = require('fs');
    let stream = fs.createWriteStream("zzz.csv", {flags:'a'});

    const els = await page.$$('tr.wp-s-table-skin-hoc__tr');
    for (let i = 0; i < els.length; i++) {
        let text = await els[i].$eval('a.wp-s-pan-list__file-name-title-text', el => el.textContent);
        text = text.trim();
        if(rows.includes(text) === false) {
            console.log(i + '---- inner text: ');
            console.log(text);
            rows.push(text);
            stream.write(text + ', ');

            // Hover to get share link
            await els[i].hover();
            await delay(100);
            await els[i].$eval('i.u-icon-share', el => el.click());
            await delay(100);
            const share = await page.waitForSelector('div.private-share-btn');
            await share.click();
            await delay(2000);
            await page.$x("//p[contains(., 'The link has been copied')]");
            let shareLink = await page.evaluate(() => navigator.clipboard.readText());
            console.log('---- share link: ' + shareLink);
            stream.write(shareLink + "\n");
            await delay(1000);
            //await page.evaluate(() => navigator.clipboard.writeText(''));
        }

        await delay(200);
    }
    let items = [...new Set(rows)];
    console.log('------ rows in processItems = ' + items.length);
    return items;
}