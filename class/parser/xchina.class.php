<?php

class xchina {

    public static function parse_html($target_url, $data = []) {

        //ZDebug::my_print(__DIR__); exit;
        
        $page_content = shell_exec("sudo runuser -l pi -c 'DISPLAY=:0.0  /usr/local/bin/node ".__DIR__."/../../z_tools/puppeteer_fetch.js ".$target_url."' 2>&1");
        
        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<meta property="og:title" content="', '">');
            $title = $title_arr[0];
            $data['title'] = $title;
        }

        if(empty($data['thumbnail'])) {
            $thumb_arr = find_between($page_content, '<meta property="og:image" content="', '">');
            $thumbnail = $thumb_arr[0];
            $file_headers = @get_headers($thumbnail);
            foreach($file_headers as $h) {
                if(strpos($h, 'Content-Length') !== false) {
                    $tmp_arr = explode(':', $h);
                    $length = empty($tmp_arr[1]) ? 0 : intval($tmp_arr[1]);
                    break;
                }
            }
            if(empty($length)) {
                $thumbnail = str_replace('http://xchina.co', 'https://img.xchina.xyz', $thumbnail);
                $thumbnail = str_replace('.jpg', '_400x570.jpg', $thumbnail);
                $thumbnail = substr( $thumbnail, 0, 4 ) === "http" ? $thumbnail : 'https://xchina.co' . $thumbnail;
            }
            $data['thumbnail'] = $thumbnail;
        }

        if(empty($data['tags'])) {
            $section = find_between($page_content, 'fa-tags', '<i role');
            $tag_arr = find_between($section[0], 'class="contentTag">', '</div>');
            $data['tags'] = $tag_arr;
        }

        $article_content_finder = find_between($page_content, 'class="photos"', '<div class="pager">');
        $article_html = $article_content_finder[0];
        
        if(empty($data['images']))  $data['images'] = [];
        $image_finder = find_between($article_html, '<div class="item" src="', '"');
        foreach ($image_finder as $img) {
            $img = substr( $img, 0, 4 ) === "http" ? $img : 'https://xchina.co' . $img;
            $data['images'][] = $img;    
        }
        
        $next_url = '';
        $pager_finder = find_between($page_content, '<div class="pager">', '<div class="tips">');
        $pager_html = $pager_finder[0];
        if(!empty($pager_html)) {
            $next_page_finder = find_between($pager_html, '<a', '</a>');
            foreach ($next_page_finder as $page) {
                if(strpos($page, '下一页') !== false) {
                    $next_url_finder = find_between($page, 'href="', '"');
                    if(!empty($next_url_finder)) {
                        $next_url = $next_url_finder[0];        
                    }
                }
            }

            if(!empty($next_url)) {
                $url_parts = parse_url($target_url);
                $next_url = $url_parts['scheme']."://".$url_parts['host'] . $next_url;
                
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
}