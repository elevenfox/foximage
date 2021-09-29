<?php

/*
 * This is the model for home page
 * @author: Eric
 */

import('dao.Tag');

Class siteMapModel extends ModelCore {

    private $urlsPerSiteMapFile = 4999;

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function make() {
        parent::make();
    }

    public function genSiteMapIndex() {
        $totalFileCount = File::getAllFilescount();
        //$totalTagCount = Tag::getAllTagsCount();

        $totalSiteMapFiles = ceil($totalFileCount / $this->urlsPerSiteMapFile) + 1;

        $domain = $this->getDomainUrl();


        $xml = <<< EOF
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
EOF;




        for($i = 0; $i<$totalSiteMapFiles; $i++) {
            $count = $i + 1;
            $xml .= '<sitemap><loc>'.$domain.'/sitemap/'.$count.'/sitemap-content-'.$count.'.xml</loc></sitemap>';
        }

        $xml .= '</sitemapindex>';

        Header('Content-type: text/xml');

        echo $this->utf8_for_xml(trim($xml));

        exit;
    }

    public function genSiteMapPage() {
        $fileId = empty($this->request->arg[1]) ? 1 : $this->request->arg[1];

        $domain = $this->getDomainUrl();

        $xml = <<< EOF
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
EOF;

        if($fileId == 1) {
            $totalTagCount = Tag::getAllTagsCount();
            $totalTagCount = ($totalTagCount > $this->urlsPerSiteMapFile) ? $this->urlsPerSiteMapFile : $totalTagCount;

            $xml .= '<url>
<loc>' . $domain . '/</loc>
<changefreq>hourly</changefreq>
<priority>0.9</priority>
</url>';

            $tags = Tag::getAllTags(1, $totalTagCount);

            foreach ($tags as $tag) {
                if(!empty($tag['name'])) {
                    $url = cleanStringForUrl($tag['name']);
                    if(!empty($url)) {
                        $xml .= '<url><loc>' . $domain . '/tags/' . $url . '</loc><changefreq>daily</changefreq><priority>0.7</priority></url>';
                    }
                }
            }
        }
        else {
            $page = $fileId - 1;
            $files = File::getFiles($page, $this->urlsPerSiteMapFile);

            foreach ($files as $file) {
                if(!empty($file['title'])) {
                    $url = cleanStringForUrl($file['title']) . '/' . $file['source_url_md5'];
                    if(!empty($url)) {
                        $xml .= '<url><loc>' . $domain . '/file/' . $url . '</loc><changefreq>weekly</changefreq></url>' . "\n";
                    }
                }
            }
        }

        $xml .= '</urlset>';

        Header('Content-type: text/xml');

        echo $this->utf8_for_xml(trim($xml));

        exit;
    }

    private function getDomainUrl() {
        $serverVars = $this->request->getServer();

        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        }
        else {
            $protocol = 'http://';
        }

        $domain = empty($serverVars['HTTP_X_FORWARDED_SERVER']) ? $serverVars['SERVER_NAME'] : $serverVars['HTTP_X_FORWARDED_SERVER'];

        return $protocol . $domain;
    }


    public function genRobotsTxt() {
        $txt = <<<EOF
User-agent: *
Crawl-delay: 10
# Directories
Disallow: /cache/
Disallow: /class/
Disallow: /conf/
Disallow: /css/
Disallow: /images/
Disallow: /misc/
Disallow: /nb/
Disallow: /theme/
# Files
Disallow: /CHANGELOG.txt
# Paths (clean URLs)
Disallow: /api/
Disallow: /user/register/
Disallow: /user/login/
Disallow: /user/logout/
Disallow: /*?at=*
# Paths (no clean URLs)
Disallow: /?q=api/
Disallow: /?q=user/register/
Disallow: /?q=user/login/
Disallow: /?q=user/logout/
EOF;

        $sitemap = "\n\nSitemap: " . $this->getDomainUrl() . '/sitemap.xml';

        $txt .= $sitemap;

        Header('Content-type: text/plain');

        echo trim($txt);

        exit;

    }

    private function utf8_for_xml($string)
    {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }
}