<?php

class xchina {

    public static function parse_html($target_url, $data = []) {

        //ZDebug::my_print(__DIR__); exit;
        
        $page_content = shell_exec("sudo runuser -l eric -c 'DISPLAY=:0.0  /usr/local/bin/node ".__DIR__."/../../z_tools/puppeteer_fetch.js ".$target_url."' 2>&1");
        
        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<meta property="og:title" content="', '">');
            $title = $title_arr[0];
            $data['title'] = $title;
        }

        if(empty($data['thumbnail'])) {
            $thumb_arr = find_between($page_content, '<meta property="og:image" content="', '">');
            $thumbnail = $thumb_arr[0];
            $thumbnail = str_replace('http://xchina.co', 'https://img.xchina.xyz', $thumbnail);
            $thumbnail = str_replace('.jpg', '_400x570.jpg', $thumbnail);
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
        $data['images'] = array_merge($data['images'], $image_finder);
        
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