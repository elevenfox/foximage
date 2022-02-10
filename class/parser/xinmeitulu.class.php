<?php

class xinmeitulu {
    public static $site_base_url = 'https://www.xinmeitulu.com/';

    public static $orgs = [
        '秀人网',

    ];

    public static $keywordsTagMapping = [
        'xiuren' => '秀人网',
        'XIUREN' => '秀人网',
    ];

    public static function parse_html($target_url, $data = []) {
        $data['source'] = 'xinmeitulu';

        $page_content = curl_call($target_url);
        $page_content = mb_convert_encoding($page_content, 'utf-8','UTF-8,GBK,GB2312,BIG5');

        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<title>', '高清大图在线浏览 - 新美图录</title>');
            $title = $title_arr[0];
            $data['title'] = $title;
        }

        if(empty($data['description'])) {
            $desc_finder = find_between($page_content, '</h1>', '<div class="text-center">');
            $description = $desc_finder[0];
            if($description[0] == ',' || $description[0] == '.') {
                $description = substr($description, 1);
            }
            $data['description'] = strip_tags($description);
        }

        if(empty($data['tags'])) {
            $section = find_between($page_content, '<meta name="keywords" content="', '" />');
            $tags = explode(',', $section[0]);
            foreach (self::$keywordsTagMapping as $key => $tag) {
                if(strpos($data['title'], $key) !== false) {
                    $tags[] = $tag;
                }
            }
            array_unique($tags);
            $data['tags'] = $tags;
        }

        $article_content_finder = find_between($page_content, '<div class="container">', '</div>');
        $article_html = $article_content_finder[0];
        
        if(empty($data['images']))  $data['images'] = [];
        $image_finder = find_between($article_html, '<img data-original="', '" src');
        $image_url_org = $image_finder[0];
        foreach($image_finder as $img) {
            $data['images'][] = $img;
        }

        if(empty($data['thumbnail']) && !empty($image_url_org)) {
            /* Resize first image as thumbnail */
            $physical_path = buildPhysicalPath($data);
            // If folder not exist, create the folder
            if(!is_dir($physical_path)) {
                $res = mkdir($physical_path, 0744, true);
                if(!$res) {
                    error_log(date('Y-m-d H:i:s') . " ----- failed to create directory: " . $physical_path);
                }
            }
            $fullname = $physical_path . '/thumbnail.jpg';

            // if file does not exist locally or force_download, then download it
            if(!file_exists($fullname)) {
                $referrer = getReferrer($data['source']);  
                $result = curl_call($image_url_org, 'get', null, ['timeout' => 15, 'referrer'=>$referrer]);
                if(!empty($result)) {
                    $res = file_put_contents($fullname, $result);
                    if(!$res) {
                        error_log(date('Y-m-d H:i:s') . " ------------------ failed!!!");    
                    } 
                    else {
                        // resize the image to thumbnail size
                        $image = imagecreatefromjpeg($fullname);
                        $imgResized = imagescale($image , 500, 400); // width=500 and height = 400
                        imagejpeg($imgResized, $fullname);
                    }                   
                }
                else {
                    error_log(date('Y-m-d H:i:s') . " --------- \033[31m failed to download: " . $img . "\033[39m"); 
                }
            }
        }

        return $data;
    }

    /**
     * Get the organization which the image belongs to
     *
     * @param array $row
     * @return string
     */  
    public static function getOrganizationFromTag(array $row) : string
    {
        foreach(self::$orgs as $org) {
            $tags = is_array($row['tags']) ? $row['tags'] : explode(',', $row['tags']);
            if(in_array($org, $tags)) {
                return $org;
            }
        }

        return '';
    }
}