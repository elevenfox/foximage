<?php

class xindong {
    public static $site_base_url = 'https://www.xie69.com';

    public static $orgs = [
        'TuiGirl' => '推女郎',
        'Xiuren' => '秀人网',
    ];

    public static function parse_html($target_url, $data = []) {
        $page_content = curl_call($target_url);
        $page_content = mb_convert_encoding($page_content, 'utf-8','UTF-8,GBK,GB2312,BIG5,zh-CN');
        
        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<title>', '</title>');
            $title = substr($title_arr[0], 0, -20);
            $data['title'] = trim($title);
        }
        
        if(empty($data['tags'])) {
            $tag_arr = find_between($page_content, '"tag-links">', '</span>');
            $tags = find_between($tag_arr[0], 'rel="tag"', '</a>');
            $data['tags'] = $tags;
        }
        
        if(empty($data['images']))  $data['images'] = [];
        $image_finder = find_between($page_content, '<div  class="spotlight text-center" data-preload="true" data-src="', '">');
        $i=1;
        $image_url_org = '';
        foreach($image_finder as $img) {
            $image_page_url = self::$site_base_url . $img;
            if($i == 1) $image_url_org = $image_page_url;
            $data['images'][] = $image_page_url;
            $i++;
        }

        if(empty($data['thumbnail']) && !empty($image_url_org)) {
            $data['thumbnail'] = str_replace('0.webp', 'cover/0.webp', $image_url_org);    
        }


        // All pages
        $pager_html_arr = find_between($page_content, 'aria-current="page">', '</div>');
        $pager_html = $pager_html_arr[0];
        $next_page_arr = find_between($pager_html, '<a href="', '" class=');
        $next_url = $next_page_arr[0];
        if(!empty($next_url)) {
            return self::parse_html($next_url, $data);
        }
        else {
            //var_dump($data); exit;
            return $data;    
        }

        //var_dump($data); exit;
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