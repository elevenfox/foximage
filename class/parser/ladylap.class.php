<?php

class ladylap {
    public static $site_base_url = 'https://www.ladylap.com/';

    public static $orgs = [
        'TuiGirl' => '推女郎',
        'Xiuren' => '秀人网',
    ];

    public static function parse_html($target_url, $data = []) {
        $page_content = curl_call($target_url);
        $page_content = mb_convert_encoding($page_content, 'utf-8','UTF-8,GBK,GB2312,BIG5');

        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<title>', ' | LadyLap.com');
            $title = $title_arr[0];
            $title_arr = explode(' - ', $title);
            array_pop($title_arr);
            $data['title'] = trim(implode(' - ',$title_arr));
        }

        if(empty($data['tags']) && !empty($data['title'])) {
            $title_arr = explode(' ', $data['title']);
            $tags = [$title_arr[0]];
            if(self::$orgs[$title_arr[0]]) $tags[] = self::$orgs[$title_arr[0]];
            $data['tags'] = $tags;
        }

        if(empty($data['images']))  $data['images'] = [];
        $image_finder = find_between($page_content, '<a class="thumbnail" href="', '">');
        $i=1;
        foreach($image_finder as $img) {
            $image_page_url = self::$site_base_url . $img;
            $image_page_html = curl_call($image_page_url,'get',null,['user_proxy'=>1,'referrer'=>self::$site_base_url]);
            //sleep(5);
            var_dump($image_page_html);
            $img_arr = find_between($image_page_html, 'class="img-res" src="', '" />');
            if(empty($img_arr[0])) {
                echo $i.' -- capcha.... <br>';
                break;
            }
            $data['images'][] = self::$site_base_url . $img_arr[0];
            $i++;
        }

        if(empty($data['thumbnail']) && !empty($image_url_org)) {
            $background_arr = find_between($page_content, '<div class="img-div" style="background-image: url(\'', '\');">');
            $data['thumbnail'] = self::$site_base_url . $background_arr[0];    
        }


        var_dump($data);
        exit;
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