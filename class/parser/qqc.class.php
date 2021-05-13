<?php

class qqc {

    public static function parse_html($target_url, $data = []) {
        $page_content = curl_call($target_url);
        $page_content = mb_convert_encoding($page_content, 'utf-8','UTF-8,GBK,GB2312,BIG5');

        if(empty($data['title'])) {
            $title_arr = find_between($page_content, '<meta property="og:title" content="', '"/>');
            $title = $title_arr[0];
            $data['title'] = $title;
        }

        if(empty($data['thumbnail'])) {
            $thumb_arr = find_between($page_content, '<meta property="og:image" content="', '"/>');
            $thumbnail = $thumb_arr[0];
            $data['thumbnail'] = $thumbnail;
        }

        if(empty($data['tags'])) {
            $section = find_between($page_content, 'article-tags', '</div>');
            $tag_arr = find_between($section[0], 'rel="tag">', '</a>');
            $data['tags'] = $tag_arr;
        }

        $article_content_finder = find_between($page_content, 'article-content', '</article>');
        $article_html = $article_content_finder[0];
        if(empty($data['description'])) {
            // First p section would be the description
            $desc_finder = find_between($article_html, '<p>', '<img');
            $description = $desc_finder[0];
            $description = trim(str_replace($data['title'], '', $description));
            if($description[0] == ',' || $description[0] == '.') {
                $description = substr($description, 1);
            }
            $data['description'] = strip_tags($description);
        }

        if(empty($data['images']))  $data['images'] = [];
        $image_finder = find_between($article_html, '<img', '>');
        foreach ($image_finder as $image_html) {
            $img_finder = find_between($image_html, 'src="', '"');
            $data['images'][] = $img_finder[0];    
        }

        $next_page_finder = find_between($page_content, 'next-page', '</li>');
        if(!empty($next_page_finder)) {
            $next_page_html = $next_page_finder[0];
            $next_url_finder = find_between($next_page_html, '<a href=\'', '\'>');
            $next_url = $next_url_finder[0];
            
            $url_parts = explode('/', $target_url);
            array_pop($url_parts);
            $url_parts[] = $next_url;
            $next_url = implode('/', $url_parts);

            if(!empty($next_url)) {
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