<?php

class qqc {

    public static function parse_html($target_url, $data = []) {
        $page_content = curl_call($target_url);

        $dom = new DOMDocument();
        $dom->loadHTML($page_content);
        $finder = new DomXPath($dom);

        if(empty($data['title'])) {
            $title_node = $finder->query('//meta[@property="og:title"]/@content');
            $title = $title_node->item(0)->nodeValue;
            $data['title'] = $title;
        }

        if(empty($data['thumbnail'])) {
            $thumbnail_node = $finder->query('//meta[@property="og:image"]/@content');
            $thumbnail = $thumbnail_node->item(0)->nodeValue;
            $data['thumbnail'] = $thumbnail;
        }

        if(empty($data['tags'])) {
            $data['tags'] = [];
            $tags_container = $finder->query('//div[@class="article-tags"]');
            foreach($tags_container->item(0)->childNodes as $t_node) {
                if($t_node->tagName == 'a') {
                   $data['tags'][] = $t_node->nodeValue;
                }
            }
        }

        
        $article = $dom->getElementsByTagName("article")->item(0);
        $all_sections = $finder->query('//p', $article);
        
        if(empty($data['description'])) {
            $description = $all_sections->item(0)->nodeValue;
            $data['description'] = $description;
        }

        if(empty($data['images']))  $data['images'] = [];
        foreach ($all_sections as $element) {
            foreach($element->childNodes as $img) {
                if($img->tagName == 'img') {
                    $data['images'][] = $img->getAttribute('src');
                }
            }
        }

        $next_page = $finder->query('//li[@class="next-page"]');
        if(!empty($next_page)) {
            foreach($next_page->item(0)->childNodes as $node) {
                if($node->tagName == 'a') {
                    $next_url = $node->getAttribute('href');
                    $url_parts = explode('/', $target_url);
                    array_pop($url_parts);
                    $url_parts[] = $next_url;
                    $next_url = implode('/', $url_parts);
                }
            }
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