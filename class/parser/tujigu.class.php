<?php

class tujigu {

    public static function parse_html($target_url, $data = []) {
        $page_content = curl_call($target_url);
        $page_content = mb_convert_encoding($page_content, 'utf-8','UTF-8,GBK,GB2312,BIG5');

        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<title>', '</title>');
            $title = $title_arr[0];

            $org_finder = find_between($page_content, '拍摄机构：', '</a>');
            $org_html = $org_finder[0];
            $org_text = trim(strip_tags($org_html));

            // remove first [xxxxx] from title
            $finder = find_between($title, '[', ']');
            $fff = $finder[0];
            $title = str_replace('['.$fff.']', '', $title);
            $title = str_replace('  ', ' ', $title);
            $title = str_replace('_图集谷', '', $title);

            $data['title'] = $org_text . '_' . $title;
        }

        if(empty($data['tags'])) {
            $section = find_between($page_content, 'tags', '</div>');
            $tag_arr = find_between($section[0], 'target="_blank">', '</a>');
            $tag_arr[] = $org_text;
            $data['tags'] = $tag_arr;
        }
        
        if(empty($data['description'])) {
            // First p section would be the description
            $desc_finder = find_between($page_content, '出镜模特', '</p>');
            $description = $desc_finder[0];
            $description = trim(str_replace($data['title'], '', $description));
            $description = '出镜模特' . $description;
            $description = strip_tags($description);
            $description = preg_replace("/[[:blank:]]+/", ' ', $description);
            $description = str_replace("出镜模特：\n", '出镜模特：', $description);
            $description = str_replace(" 别名：\n", '别名：', $description);
            $description = str_replace("身高", "\n身高", $description);
            $description = str_replace("三围", "\n三围", $description);

            $data['description'] = $description;
        }

        if(empty($data['images']))  $data['images'] = [];
        $content_finder = find_between($page_content, '<div class="content">', '</div>');
        $content_html = $content_finder[0];
        $image_finder = find_between($content_html, '<img src="', '"');
        foreach ($image_finder as $image) {
            $data['images'][] = $image;    
        }

        if(empty($data['thumbnail'])) {
            if(!empty( $data['images'][0])) {
                $url_parts = explode('/', $data['images'][0]);
                array_pop($url_parts);
                $url_parts[] = '0.jpg';
                $thumbnail = implode('/', $url_parts);

                $data['thumbnail'] = $thumbnail;
            }
        }

        // Get total num of photos
        $p_num_finder = find_between($page_content, '图片数量：', 'P');
        $p_num = (int)$p_num_finder[0];
        if(!empty($p_num)) {
            $image_path = $data['images'][0];
            $data['images'] = [];
            $url_parts = explode('/', $image_path);
            array_pop($url_parts);
            for($i=1; $i<=$p_num; $i++) {
                $next = $i . '.jpg';
                $new_url_parts = $url_parts;
                array_push($new_url_parts, $next);
                $data['images'][] = implode('/', $new_url_parts);
            }
        }

        return $data;
    }


    public static function getOrganizationFromTitle($title) {
        $arr = explode('_', $title);
        $org = $arr[0];
        
        return  empty($org) ? null : $org;
    }
}