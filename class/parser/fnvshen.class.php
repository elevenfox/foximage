<?php

class fnvshen {
    public static $site_base_url = 'https://www.fnvshen.com/';

    public static $orgs = [
        '秀人网',

    ];

    public static function parse_html($target_url, $data = []) {
        $page_content = curl_call($target_url);
        $page_content = mb_convert_encoding($page_content, 'utf-8','UTF-8,GBK,GB2312,BIG5');

        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<title>', '-宅男女神图片</title>');
            $title = $title_arr[0];
            $data['title'] = $title;
        }

        if(empty($data['description'])) {
            $desc_finder = find_between($page_content, '<meta name="description" content="', '" />');
            $description = $desc_finder[0];
            if($description[0] == ',' || $description[0] == '.') {
                $description = substr($description, 1);
            }
            $data['description'] = strip_tags($description);
        }

        if(empty($data['tags'])) {
            $section = find_between($page_content, '<div class="album_tags">', '</div>');
            $tag_arr = find_between($section[0], '<a', '/a>');
            $tags = [];
            foreach ($tag_arr as $t_str) {
                $ts_tmp_arr = find_between($t_str, '>', '<');
                $tags[] = $ts_tmp_arr[0];
            }
            $data['tags'] = $tags;
        }

        $article_content_finder = find_between($page_content, '<ul id="hgallery">', '</ul>');
        $article_html = $article_content_finder[0];
        
        if(empty($data['images']))  $data['images'] = [];
        $image_finder = find_between($article_html, '<img src=\'', '\'');
        $image_url_org = $image_finder[0];
        foreach($image_finder as $img) {
            $img_big = str_replace('s/', '', $img);
            $data['images'][] = $img_big;
        }

        if(empty($data['thumbnail']) && !empty($image_url_org)) {
            if(strpos($image_url_org, 's/') !== false) {
                $tmp_arr = explode('s/', $image_url_org);
                $data['thumbnail'] = $tmp_arr[0] . 'cover/0.jpg';    
            }
        }

        $next_page_finder = find_between($page_content, '<div id="pages">', '</div>');
        if(!empty($next_page_finder)) {
            $next_page_html = $next_page_finder[0];
            $next_url_finder = find_between($next_page_html, '<a', '</a>');
            $next_url = '';
            foreach ($next_url_finder as $n_url) {
                if(strpos($n_url, '下一页') !== false) {
                    $tmp_arr = find_between($n_url, 'href=\'', '\'');
                    $next_url = self::$site_base_url . $tmp_arr[0];
                }
            }
            
            if(!empty($next_url) && strpos($next_url, '.html') !== false && strpos($next_url, '/1.html') === false) {
                return self::parse_html($next_url, $data);
            }
            else {
                return $data;    
            }
        } 
        else {
            return $data;
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
            $tags = explode(',', $row['tags']);
            if(in_array($org, $tags)) {
                return $org;
            }
        }

        return '';
    }
}