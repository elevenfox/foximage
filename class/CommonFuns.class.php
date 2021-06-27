<?php

/*
 * Some common functions
 */

function find_between($str, $startDelimiter, $endDelimiter) {
    $contents = array();
    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;
    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
      $contentStart += $startDelimiterLength;
      $contentEnd = strpos($str, $endDelimiter, $contentStart);
      if (false === $contentEnd) {
        break;
      }
      $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
      $startFrom = $contentEnd + $endDelimiterLength;
    }
  
    return $contents;
  }

function formatWhere($where) {
  if(!empty($where)) {
      $where = trim($where);
      if(strtoupper(substr($where, 0, 3)) != 'AND') $where = ' AND ' . $where;      
    }
  return $where;
}

function isId($string) {
  return preg_match("/^\d*$/",$string);
}

function goToUrl($url) {
  header('location: ' . $url);
  exit;
}

function l($link, $text) {
  return '<a href="' . $link . '">' . $text . '</a>';
}

function apiReturnJson($str) {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($str);
  exit;
}


function curl_call($url, $method='get', $data=null, $options=[]) {
    $postData = $data;

    $timeout = empty($options['timeout']) ? 0 : $options['timeout']; 
    $use_proxy = empty($options['user_proxy']) ? false : $options['user_proxy']; 
    $referrer = empty($options['referrer']) ? null : $options['referrer']; 

    $ch = curl_init(); // 启动一个CURL会话
    curl_setopt($ch, CURLOPT_URL, $url); // 要访问的地址
    if($use_proxy) {
        curl_setopt($ch, CURLOPT_PROXY, 'socks5://localhost:9050');
    }
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate',"charset=UTF-8"));
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    if(!empty($referrer)) {
        curl_setopt($ch, CURLOPT_REFERER, $referrer);
    }
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36');
    // 获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    if($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    if(!empty($timeout)) {
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    }

    $result = curl_exec($ch); // 执行操作
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($result == NULL) {
        error_log('CURL error: ' . curl_errno($ch) . " – " . print_r(curl_error($ch),1));
    }
    curl_close($ch); // 关闭CURL会话

    return $result;
}

function isAdmin() {
    return !empty($_SESSION['user']) && $_SESSION['user']['uid'] == 1;
}

function is_hd_video($video) {
  return !empty($video['quality_1080p']) || !empty($video['quality_720p']);
}

function seconds_to_duration($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}

function get_default_video_api_url() {
    $http_host = $_SERVER['HTTP_HOST'];
    $arr = explode('.', $http_host);
    if(count($arr) == 2 || count($arr) == 3 ) {
        $arr[0] = 'api';
    }
    $new_url = 'http://' . implode('.', $arr) . ':3000/api';
    return $new_url;
}

function get_gif_preview($source, $video) {
    if(!empty($source)) {
        $needle = 'gif-preview=';
        if(substr($video['gif_preview'], 0, strlen($needle)) == $needle) {
            return $video['gif_preview'];
        }
        else {
            switch ($source) {
                case 'pornhub':
                    if(empty($video['gif_preview'])) {
                        $ext = '.jpg';
                        $preivews = array();
                        $thumbnail = $video['thumbnail'];
                        if( (strlen($thumbnail) - 4) == stripos($thumbnail, $ext) ) {
                            $res = explode(')', str_ireplace($ext, '', $thumbnail));
                            array_pop($res);
                            for($i = 1; $i <=16; $i++) {
                                $url = implode(')', $res);
                                $url = $url . ')' . $i . $ext;
                                $preivews[] = $url;
                            }
                        }
                        return 'gif-preview="'. implode(',', $preivews) .'"';
                    }
                    else {
                        $thumb_info = json_decode('{'.$video['gif_preview'].'}');
                        if(empty($thumb_info)) {
                            $thumb_info = json_decode($video['gif_preview']);
                        }
                        $res = explode('/',$thumb_info->urlPattern);
                        $last = array_pop($res);
                        $n = explode('.', $last);
                        $name_extra = explode('S', $n[0]);
                        $file_name = 'S0.'.$n[1];
                        $url = implode('/', $res) . '/' . $name_extra[0] .$file_name;
                        return 'gif-preview="'. $url .'" gif-format="5x5"';
                    }
                    break;
                case 'youjizz':
                    $ext = '.jpg';
                    $preivews = array();
                    $thumbnail = $video['thumbnail'];
                    if( (strlen($thumbnail) - 4) == stripos($thumbnail, $ext) ) {
                        $res = explode('-', str_ireplace($ext, '', $thumbnail));
                        array_pop($res);
                        for($i = 1; $i <=8; $i++) {
                            $url = implode('-', $res);
                            $url = $url . '-' . $i . $ext;
                            $preivews[] = $url;
                        }
                    }
                    return 'gif-preview="'. implode(',', $preivews) .'"';
                    break;
                case 'redtube':
                    $thumb_info = json_decode($video['gif_preview']);
                    if(!empty($thumb_info)) {
                        $res = explode('/', $thumb_info->urlPattern);
                        $last = array_pop($res);
                        $n = explode('.', $last);
                        $url = implode('/', $res) . '/0.' . $n[1];
                        return 'gif-preview="' . $url . '" gif-format="5x5"';
                    }
                    return '';
                    break;
            }
        }
    }
}



function cleanStringForUrl($string, $separator = '-') {

    // Generate and cache variables used in this function so that on the second
    // call to pathauto_cleanstring() we focus on processing.
    if (!isset($cache)) {
        $cache = array(
            'separator' => $separator,
            'strings' => array(),
            'punctuation' => array(),
            'reduce_ascii' => TRUE,
            'ignore_words_regex' => FALSE,
            'lowercase' => TRUE,
            'maxlength' => 1000,
        );

        // Generate and cache the punctuation replacements for strtr().
        $punctuations = ['"', '\'', '`', ',', '.', '-', '_', ':', ';', '|', '{', '}', '[', ']', '+', '-', '=', '*', '&', '%', '^', '$', '#', '@', '!', '~', '(', ')', '?', '<', '>', '/', '\\'];
        foreach ($punctuations as $p) {
            $cache['punctuation'][$p] = '';
        }

        // Generate and cache the ignored words regular expression.
        $ignore_words = 'a, an, as, at, before, but, by, for, from, is, in, into, like, of, off, on, onto, per, since, than, the, this, that, to, up, via, with';
        $ignore_words_regex = preg_replace(array('/^[,\s]+|[,\s]+$/', '/[,\s]+/'), array('', '\b|\b'), $ignore_words);
        if ($ignore_words_regex) {
            $cache['ignore_words_regex'] = '\b' . $ignore_words_regex . '\b';
            if (function_exists('mb_eregi_replace')) {
                mb_regex_encoding('UTF-8');
                $cache['ignore_words_callback'] = 'mb_eregi_replace';
            }
            else {
                $cache['ignore_words_callback'] = 'preg_replace';
                $cache['ignore_words_regex'] = '/' . $cache['ignore_words_regex'] . '/i';
            }
        }
    }

    // Empty strings do not need any processing.
    if ($string === '' || $string === NULL) {
        return '';
    }

    // Remove all HTML tags from the string.
    $output = strip_tags(html_entity_decode($string));

    // Drop punctuation based on user settings
    $output = strtr($output, $cache['punctuation']);

    // Reduce strings to letters and numbers
    //if ($cache['reduce_ascii']) {
    //    $output = preg_replace('/[^a-zA-Z0-9\/]+/', $cache['separator'], $output);
    //}

    // Get rid of words that are on the ignore list
    if ($cache['ignore_words_regex']) {
        $words_removed = $cache['ignore_words_callback']($cache['ignore_words_regex'], '', $output);
        if (strlen(trim($words_removed)) > 0) {
            $output = $words_removed;
        }
    }

    // Always replace whitespace with the separator.
    $output = preg_replace('/\s+/', $cache['separator'], $output);

    // Trim duplicates and remove trailing and leading separators.
    $output = _pathauto_clean_separators($output, $cache['separator']);

    // Optionally convert to lower case.
    if ($cache['lowercase']) {
        $output = strtolower($output);
    }

    // Shorten to a logical place based on word boundaries.
    $output = substr($output, 0, $cache['maxlength']);

    return $output;
}
function _pathauto_clean_separators($string, $separator = NULL) {
    static $default_separator;

    if (!isset($separator)) {
        if (!isset($default_separator)) {
            $default_separator = '-';
        }
        $separator = $default_separator;
    }

    $output = $string;

    if (strlen($separator)) {
        // Trim any leading or trailing separators.
        $output = trim($output, $separator);

        // Escape the separator for use in regular expressions.
        $seppattern = preg_quote($separator, '/');

        // Replace multiple separators with a single one.
        $output = preg_replace("/$seppattern+/", $separator, $output);

        // Replace trailing separators around slashes.
        if ($separator !== '/') {
            $output = preg_replace("/\/+$seppattern\/+|$seppattern\/+|\/+$seppattern/", "/", $output);
        }
    }

    return $output;
}

function getDomainUrl() {
    if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    }
    else {
        $protocol = 'http://';
    }

    $domain = empty($_SERVER['HTTP_X_FORWARDED_SERVER']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_X_FORWARDED_SERVER'];

    return $protocol . $domain;
}


function is_mobile() {
    $useragent=$_SERVER['HTTP_USER_AGENT'];

    return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));

}

function cleanStringForFilename($filename) {
    // sanitize filename
    $filename = preg_replace(
        '~
        [<>:"/\\|?*]|            # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
        [#\[\]@!$&\'()+,;=]|     # URI reserved https://tools.ietf.org/html/rfc3986#section-2.2
        [{}^\~`]                 # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
        ~x',
        '-', $filename);
        
        //[\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
        //[\x7F\xA0\xAD]|          # non-printing characters DEL, NO-BREAK SPACE, SOFT HYPHEN
        
        

    // avoids ".", ".." or ".hiddenFiles"
    $filename = ltrim($filename, '.-');
    /*
    // maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $filename = mb_strcut(pathinfo($filename, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($filename)) . ($ext ? '.' . $ext : '');
    */
    $filename = str_replace(' ', '-', $filename);
    return $filename;
}


function buildPhysicalPath($file_row) {
    $file_root = Config::get('file_root');
    if(empty($file_root)) {
        $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
    }
    if($file_row['source'] != 'tujigu') {
        $physical_path = $file_root . $file_row['source'] . '/' . cleanStringForFilename($file_row['title']);
    }
    else {
        import('parser.tujigu');
        $org = tujigu::getOrganizationFromTitle($file_row['title']);
        if(empty($org)) {
            $physical_path = $file_root . $file_row['source'] . '/' . cleanStringForFilename($file_row['title']);
        }
        else {
            $physical_path = $file_root . $file_row['source'] . '/' . $org . '/'. cleanStringForFilename($file_row['title']);
        }
    }

    return $physical_path;
}

function getReferrer($source) {
    $referrer = '';
    if($source == 'tujigu') {
        $referrer = 'https://www.tujigu.com/';
    }
    if($source == 'qqc') {
        $referrer = 'https://qqc962.com/';
    }

    return $referrer;
}


function processThumbnail($row) {
    // Build physical path: Use <file_root>/source/<file_title>/ as file structure
    $physical_path = buildPhysicalPath($row);

    // If folder not exist, create the folder
    if(!is_dir($physical_path)) {
        $res = mkdir($physical_path, 0744, true);
        if(!$res) {
            error_log(" ----- failed to create directory: " . $physical_path );
        }
    }

    $fullname = $physical_path . '/thumbnail.jpg';

    $name_arr = explode('/jw-photos/', $fullname);
    $relative_path = '/jw-photos/' . $name_arr[1];    

    $result = '/file_thumbnail/' . $row['source_url_md5'] . '/th.jpg';

    // if file does not exist locally or force_download, then download it
    if(!file_exists($fullname)) {
      $referrer = getReferrer($row['source']);  
      $result = curl_call(str_replace('http://', 'https://', $row['thumbnail']), 'get', null, ['referrer'=>$referrer]);
      if(!empty($result)) {
          $res = file_put_contents($fullname, $result);
          if(!$res) {
              error_log(" ----- failed to save thumbnail: " . $fullname);    
          }
          else {
            $result = $relative_path;
          }
      }
      else {
          error_log(" ---- failed to download: " . $row['thumbnail'] ); 
      }
    }
    else {
      $result = $relative_path;
    }

    return $result;
  }  