<?php

/*
 * Some common functions
 */

function get_supported_sources() {
    return array(
        'qqc962.com' => 'qqc',
        'v8.qqv13.vip' => 'qqc',
        'tujigu.com' => 'tujigu',
        'tujigu.net' => 'tujigu',
        'xchina.co' => 'xchina',
        'xchina.xyz' => 'xchina',
        'fnvshen.com' => 'fnvshen',
        'gnvshen.com' => 'fnvshen',
        'xinmeitulu.com' => 'xinmeitulu',
        'xie69.com' => 'xindong',
    );
}

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

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

function t($text) {
    $to_lang = empty(Config::get('site_lang')) ? 'zh-CN' : Config::get('site_lang');
    if(empty($to_lang)) return $text;

    if( !array_key_exists($text, TRANSLATION) || empty(TRANSLATION[$text]) ) return $text;
    else return TRANSLATION[$text];
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

    // Build request headers
    $options_headers = empty($options['headers']) ? [] : $options['headers'];
    $headers = array_merge($options_headers, ['Accept-Encoding: gzip, deflate', "charset=UTF-8"]);

    $ch = curl_init(); 
    $url = str_replace(" ", "%20", $url);
    curl_setopt($ch, CURLOPT_URL, $url); 
    if($use_proxy) {
        curl_setopt($ch, CURLOPT_PROXY, 'socks5://rand_user_'.time().':foo@localhost:9050');
    }
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    if(!empty($referrer)) {
        curl_setopt($ch, CURLOPT_REFERER, $referrer);
    }
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    if($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    if($method == 'put') {
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_INFILE, fopen($data, 'rb'));
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($data));
        curl_setopt($ch, CURLOPT_UPLOAD, true);

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

function tor_new_identity($tor_ip='127.0.0.1', $control_port='9051', $auth_code=''){
    $fp = fsockopen($tor_ip, $control_port, $errno, $errstr, 30);
    var_dump($fp);
    if (!$fp) return false; //can't connect to the control port
     
    // fputs($fp, "AUTHENTICATE $auth_code\r\n");
    // $response = fread($fp, 1024);
    // list($code, $text) = explode(' ', $response, 2);
    // if ($code != '250') return false; //authentication failed
     
    //send the request to for new identity
    fputs($fp, "signal NEWNYM\r\n");
    $response = fread($fp, 1024);
    var_dump($response);
    list($code, $text) = explode(' ', $response, 2);
    if ($code != '250') return false; //signal failed
     
    fclose($fp);
    return true;
}

function isAdmin() {
    return !empty($_SESSION['user']) && $_SESSION['user']['uid'] == 1;
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
        $punctuations = ['"', '\'', '`', ',', '.', '_', ':', ';', '|', '{', '}', '[', ']', '+', '=', '*', '&', '%', '^', '$', '#', '@', '!', '~', '(', ')', '?', '<', '>', '/', '\\'];
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


function titleToKeywords($title) {
    $keywords = [];

    // remove [xxp] at the end of the title if exists
    if(strrpos($title, ']') === strlen($title)-1) {
        $textArr = find_between($title, '[', ']');
        $text = '[' . $textArr[count($textArr) - 1] .']';
        $title = str_replace($text, '', $title);
    }
    
    // split by '_' first, add first element as keyword
    $textArr = explode('_', $title);
    if(count($textArr) > 1) {
        $keywords[] = $textArr[0];
        $t = $textArr[0]. '_';
        $title = str_replace($t, '', $title);
    }
    
    // If start with [xxxx], use it as keyword
    if(strpos($title, '[') === 0) {
        $textArr = find_between($title, '[', ']');
        $keywords[] = $textArr[0];
        $text = '[' . $textArr[count($textArr) - 1] .']';
        $title = str_replace($text, '', $title);
    }
    
    // get word between 《》 as keyword, then remove it in title
    $textArr = find_between($title, '《', '》');
    if(!empty($textArr)) {
        $keywords = array_merge($keywords, $textArr);
        foreach($textArr as $t) {
            $t = '《' . $t. '》';
            $title = str_replace($t, ' ', $title);
        }
    }
        
    // split by space again for the rest elements
    $rest = stringToKeywords($title);

    return array_merge($keywords, $rest);
}

function stringToKeywords($string) {
    $string = preg_replace("/ {2,}/", " ", $string);
    $separators = ['_', '-', ' ', '+', '@' , '(', ')', '+'];
    foreach($separators as $separator) {
        $string = str_replace($separator, '|||', $string);
    }
    $smarts = ['第', '套图', '写真', 'No.', 'Vol.'];
    foreach($smarts as $smart) {
        $string = str_replace($smart, '|||'.$smart, $string);
    }
    $smarts_r = ['期'];
    foreach($smarts_r as $smart_r) {
        $string = str_replace($smart_r, $smart_r.'|||', $string);
    }
    $res = explode('|||', $string);
    $res = array_filter($res, function($value) { return !empty($value); });
    return $res;
}

function getBeautyInfoFromTags($fileObj) {
    $beauty_info ='';
    if(in_array($fileObj['source'], ['xiuren5000', 'korea'])){
        $tag_arr = explode(',', $fileObj['tags']);
        foreach($tag_arr as $t) {
            $t = trim($t);
            if(in_array($t, ALL_BEAUTY)) {
                if(file_exists(BEAUTY_PATH . $t . '.txt')) {
                    $beauty_info = file_get_contents(BEAUTY_PATH . $t . '.txt');
                }
            }        
        }
    }
    return $beauty_info;
}

function buildPhysicalPath($file_row, $file_root='') {
    if(empty($file_root)) {
        $file_root = Config::get('file_root');
    }
    if(empty($file_root)) {
        $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
    }
    
    if($file_row['source'] == 'tujigu') {
        import('parser.tujigu');
        $org = tujigu::getOrganizationFromTitle($file_row['title']);
        if(empty($org)) {
            $physical_path = $file_root . $file_row['source'] . '/' . cleanStringForFilename($file_row['title']);
        }
        else {
            $physical_path = $file_root . $file_row['source'] . '/' . cleanStringForFilename($org) . '/'. cleanStringForFilename($file_row['title']);
        }
    }
    elseif ($file_row['source'] == 'fnvshen' || $file_row['source'] == 'xinmeitulu') {
        import('parser.fnvshen');
        import('parser.xinmeitulu');
        $org = $file_row['source'] == 'fnvshen' 
                ? fnvshen::getOrganizationFromTag($file_row)
                : xinmeitulu::getOrganizationFromTag($file_row);
        if(empty($org)) {
            $physical_path = $file_root . $file_row['source'] . '/' . cleanStringForFilename($file_row['title']);
        }
        else {
            $physical_path = $file_root . $file_row['source'] . '/' . cleanStringForFilename($org) . '/'. cleanStringForFilename($file_row['title']);
        }
    }
    elseif ($file_row['source'] == 'zac' || $file_row['source'] == 'japan') {
        $physical_path = $file_root . $file_row['source_url'];
    } 
    else {
        $physical_path = $file_root . $file_row['source'] . '/' . cleanStringForFilename($file_row['title']);
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
    if($source == 'fnvshen') {
        $referrer = 'https://www.fnvshen.com/';
    }

    return $referrer;
}


function processThumbnail($row, $force_download = false, $b2_upload = false) {
    $img_src = '';

    // Build physical path: Use <file_root>/source/<file_title>/ as file structure
    $physical_path = buildPhysicalPath($row);
    
    $file_root = Config::get('file_root');
    if(empty($file_root)) {
        $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
    }
    $relative_path = str_replace($file_root, '', $physical_path);
    $key = $relative_path . '/thumbnail.jpg';
    $key = str_replace('//','/',$key);

    $dev_mode = Config::get('dev_mode');
    if( empty($dev_mode) && $force_download === false) {
        // Use B2
        //$base_b2_url = 'https://photo.tuzac.com/';
        $cdn_domain = Config::get('cdn_domain');
        $base_b2_url = 'https://'.$cdn_domain.'/file/jw-photos-2021/';
        $img_src = $base_b2_url . str_replace('%2F','/', urlencode($key));
    }
    else {
        // Use local filesystem
        // If folder not exist, create the folder
        if(!is_dir($physical_path)) {
            $res = mkdir($physical_path, 0755, true);
            if(!$res) {
                error_log(" ----- failed to create directory: " . $physical_path );
            }
        }

        $fullname = $physical_path . '/thumbnail.jpg';
        $fullname = str_replace('//','/',$fullname);

        // if file does not exist locally, then download it
        if(!file_exists($fullname)) {
            $referrer = getReferrer($row['source']);  
            $tn_url = str_replace('http://', 'https://', $row['thumbnail']);
            $tn_url = str_replace('tjg.hywly.com', 'tjg.gzhuibei.com', $tn_url);
            $result = curl_call($tn_url, 'get', null, ['timeout'=>10,'referrer'=>$referrer]);
            if(!empty($result)) {
                $res = file_put_contents($fullname, $result);
                chmod($fullname, 0755);
                // If thumbnail_url shows it's a webp file, convert it to jpg
                convert_webp_to_jpg($tn_url, $fullname);
                if(!$res) {
                    error_log(" ----- failed to save thumbnail: " . $fullname);    
                }
                else {
                    // Upload to B2 if key is empty in B2
                    import('B2');
                    $b2 = new B2();
                    $res = $b2->get_photo_content($key);
                    if(empty($res)) {
                        $res = $b2->upload_photo($key, $fullname);
                    }

                    // Update db to set thumbnail field to 1
                    $pre = Config::get('db_table_prefix');
                    $sql = "update ". $pre . "files set thumbnail=1 where source_url = '" . $row['source_url'] . "'";
                    DB::$dbInstance->query($sql);
                }
            }
            else {
                error_log(" ---- failed to download: " . $tn_url ); 
            }
        }
        else if($b2_upload) {
            // Upload to B2 if key is empty in B2
            import('B2');
            $b2 = new B2();
            $res = $b2->get_photo_content($key);
            if(empty($res)) {
                $res = $b2->upload_photo($key, $fullname);
            }
        }

        $img_src = '/jw-photos/' . $key;
    }

    return $img_src;
}  

function uploadB2Thumbnail($file_id, $logging=false) {
    $row = File::getFileByID($file_id);
    
    // Build physical path: Use <file_root>/source/<file_title>/ as file structure
    $physical_path = buildPhysicalPath($row);
    // If folder not exist, create the folder
    if(!is_dir($physical_path)) {
        $res = mkdir($physical_path, 0755, true);
        if(!$res) {
            error_log(" ----- failed to create directory: " . $physical_path );
        }
    }
    $fullname = $physical_path . '/thumbnail.jpg';
    
    $file_root = Config::get('file_root');
    if(empty($file_root)) {
        $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
    }
    $relative_path = str_replace($file_root, '', $physical_path);
    $key = $relative_path . '/thumbnail.jpg';

    if($logging) {
        echo '--- fullname = ' . $fullname . "\n";
        echo '--- b2 key = ' . $key . "\n";
    }
    // Upload to B2 with the key
    import('B2');
    $b2 = new B2();
    try {
        $res = $b2->upload_photo($key, $fullname);
    }
    catch(Exception $e) {
        var_dump($e->getMessage());
    }
}

function processPhotoSrc($file) {
    $src = '';

    $images = explode(',', $file['filename']);
    $num = empty($_GET['at']) ? 1 : $_GET['at'];
    $num = $num >= count($images) ? count($images) : $num;

    // Step-1, use photo url from source
    $cur_image_url = $images[$num-1];
    
    // Get filename based on photo-url
    $name_arr = explode('/', $cur_image_url);
    $filename = array_pop($name_arr);
    // if filename has no extention name, use leading-zero-number.jpg
    if(strpos($filename, '.jpg') === false) {
        $filename = sprintf('%03d', $num-1) . '.jpg';
    }

    // Get physical path based on title
    $physical_path = buildPhysicalPath($file);

    // Get relative path
    $file_root = Config::get('file_root');
    if(empty($file_root)) {
        $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
    }
    $relative_path = str_replace($file_root, '', $physical_path);
    $relative_fullname = $relative_path . '/' . $filename;
    $relative_fullname = str_replace('//','/',$relative_fullname);

    // If it's dev mode, try to use local photo first
    $dev_mode = Config::get('dev_mode');
    if( !empty($dev_mode) ) {
        if(file_exists($file_root . $relative_fullname)) {
            $src = '/jw-photos/' . $relative_fullname;
        }
    }

    // If src is empty, use B2 for some categories, otherwise use api(which is using Onedrive for now)
    if(empty($src)) {
        // Use B2 url
        // if(strpos($file['title'], '头条女神', 0) !== false ) {
        //     $base_b2_url = 'https://img.tuzac.com/file/jw-photos-2021/';
        //     $key = $relative_path . '/' . $filename;
        //     $src = $base_b2_url . urlencode($key);
        // }
        // else {
            // If file not exists in B2, try to use own api

            // if($file['source'] == 'tujigu') {
            //     $src = '/jw-photos/file_content/' . $file['source_url_md5'] . '/' . $num . '/fc.jpg';
            // }
            // else {
            //     // For qqc photos, just use its internet url
            //     $src = $cur_image_url;
            // }

            // Use home's dev server (RPI4) to serve photos for now
            $src = 'https://image.tuzac.com/jw-photos/' . $relative_fullname;
            
        // }
    }


    
    // else {
    //     // Try to see if the file exists in B2
    //     //$base_b2_url = 'https://photo.tuzac.com/';
    //     $base_b2_url = 'https://img.tuzac.com/file/jw-photos-2021/';
    //     $key = $relative_path . '/' . $filename;
    //     $url = $base_b2_url . urlencode($key);
    //     $file_headers = @get_headers($url);
    //     if(!empty($file_headers) && strpos($file_headers[0], '200') !== false) 
    //     {
    //         $cur_image_url = $url;
    //     }
    //     else {
    //         // If file not exists in B2, try to use own api
    //         if($file['source'] == 'tujigu') {
    //             $cur_image_url = '/jw-photos/file_content/' . $file['source_url_md5'] . '/' . $num . '/fc.jpg';
    //         }
    //     }
    // }

    return $src;
}


function get_random_hot_searches($count = 0) {
    if(!empty($_SESSION['hot_searches'])) {
        return $_SESSION['hot_searches'];
    }
    else {
        $hot_models_list = Config::get('model_highlighted');
        $hot_models = json_decode(str_replace("'", '"', $hot_models_list));

        if(!empty($count)) {
            $hot_models = array_rand(array_flip($hot_models), $count);
        }
        $_SESSION['hot_searches'] = $hot_models;
        return $hot_models;
    }
}


function convert_webp_to_jpg($url, $fullname) {
    // remove all parameters from url, then check the file extension
    $path = parse_url($url, PHP_URL_PATH);
    if(substr($path, -strlen('.webp')) === '.webp') {
        // Load the WebP file
        $im = imagecreatefromwebp($fullname);

        // Convert it to a jpeg file with 100% quality
        $new_file_name = str_replace('.webp', '.jpg', $fullname);
        imagejpeg($im, $new_file_name, 100);
        imagedestroy($im);
    }
}

function smartResizeThumbnail($thumbnail_origin) {
    list($width, $height, $type) = getimagesize($thumbnail_origin);

    // Crop and create the thumbnail
    $thumbnail_filename = $thumbnail_origin;
    $thumb_width = 333;
    $thumb_height = 500;

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if ( $original_aspect >= $thumb_aspect )
    {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
    }
    else
    {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
    }

    $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

    // Resize and crop
    $image = imagecreatefromjpeg($thumbnail_origin);
    imagecopyresampled($thumb,
                    $image,
                    0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                    0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                    0, 0,
                    $new_width, $new_height,
                    $width, $height);
    imagejpeg($thumb, $thumbnail_filename, 90);
}

function processDesc($desc_str) {
    $desc_str = str_replace(' 生日','生日', $desc_str);
    $pos = strpos($desc_str, '生日');
    if($pos !== false) {
        $c = $desc_str[$pos-1];
        if ($c != "\n" && $c != "\rn" && $c != "\r") {
            $desc_str = str_replace('生日',"\n生日", $desc_str);
        }
    }
    $desc_str = str_replace(' 罩杯','罩杯', $desc_str);
    $pos = strpos($desc_str, '罩杯');
    if($pos !== false) {
        $c = $desc_str[$pos-1];
        if ($c != "\n" && $c != "\rn" && $c != "\r") {
            $desc_str = str_replace('罩杯',"\n罩杯", $desc_str);
        }
    }

    return $desc_str;
}

function downloadFile($url, $path)
{
    $newfname = $path;
    $file = fopen($url, 'rb');
    if ($file) {
        $newf = fopen($newfname, 'wb');
        if ($newf) {
            while (!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
}


if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        if(strpos($haystack, $needle) === false) return false;
        else return true;
    }
}

function sanatizeCN($string) {
    $string = str_replace('《','-',$string);
    $string = str_replace('》','-',$string);
    $string = str_replace('(','-',$string);
    $string = str_replace(')','-',$string);
    $string = str_replace('，','-',$string);
    $string = str_replace('、','-',$string);
    $string = str_replace('&','-',$string);

    return $string;
}
function my_mb_ucfirst($str) {
    $new_str = '';
    $do_it = true;
    for ($i = 0; $i < strlen($str); $i++) {
        if(ord($str[$i]) >=97 && ord($str[$i]) <=122) {
            if($do_it) {
                $new_str[$i] = strtoupper($str[$i]);
                $do_it = false;
            }
            else {
                $new_str[$i] = $str[$i];
            }
        }
        else {
            $new_str[$i] = $str[$i];
        }

    }
    return $new_str;
}

function mapModelNames($l_folder_name) {
    $l_folder_name = str_replace('cris_卓娅祺', '卓娅祺', $l_folder_name);
    $l_folder_name = str_replace('egg_尤妮丝', '尤妮丝', $l_folder_name);
    $l_folder_name = str_replace('egg-尤妮丝', '尤妮丝', $l_folder_name);
    $l_folder_name = str_replace('emily顾奈奈', '顾奈奈', $l_folder_name);
    $l_folder_name = str_replace('lucky沈欢欣', '沈欢欣', $l_folder_name);
    $l_folder_name = str_replace('yumi-尤美', 'Yumi尤美', $l_folder_name);
    $l_folder_name = str_replace('柴婉艺averie', '柴婉艺', $l_folder_name);
    $l_folder_name = str_replace('妲己_toxic', '妲己', $l_folder_name);
    $l_folder_name = str_replace('葛征model', '葛征', $l_folder_name);
    $l_folder_name = str_replace('果儿victoria', '果儿', $l_folder_name);
    $l_folder_name = str_replace('萌汉药baby', '萌汉药', $l_folder_name);
    $l_folder_name = str_replace('奶瓶土肥圆矮挫丑黑穷', '土肥圆', $l_folder_name);
    $l_folder_name = str_replace('奶瓶土肥圆', '土肥圆', $l_folder_name);
    $l_folder_name = str_replace('土肥圆矮挫丑黑穷', '土肥圆', $l_folder_name);
    $l_folder_name = str_replace('土肥圆矮挫穷', '土肥圆', $l_folder_name);
    $l_folder_name = str_replace('土肥圆矮挫', '土肥圆', $l_folder_name);
    $l_folder_name = str_replace('女神yumi-尤美', 'Yumi尤美', $l_folder_name);
    $l_folder_name = str_replace('女神妲己_toxic', '妲己', $l_folder_name);
    $l_folder_name = str_replace('潘琳琳ber', '潘琳琳', $l_folder_name);
    $l_folder_name = str_replace('孙梦瑶v', '孙梦瑶', $l_folder_name);
    $l_folder_name = str_replace('唐婉儿lucky', '唐婉儿', $l_folder_name);
    $l_folder_name = str_replace('筱慧icon', '筱慧', $l_folder_name);
    $l_folder_name = str_replace('易阳silvia', '易阳', $l_folder_name);
    $l_folder_name = str_replace('樱小白baby', '樱小白', $l_folder_name);
    $l_folder_name = str_replace('御姐-穆菲菲', '穆菲菲', $l_folder_name);
    $l_folder_name = str_replace('御姐女神-穆菲菲', '穆菲菲', $l_folder_name);
    $l_folder_name = str_replace('战姝羽zina', '战姝羽', $l_folder_name);
    $l_folder_name = str_replace('周琰琳lin', '周琰琳', $l_folder_name);
    $l_folder_name = str_replace('周于希sandy', '周于希', $l_folder_name);
    $l_folder_name = str_replace('朱可儿flower', '朱可儿', $l_folder_name);
    $l_folder_name = str_replace('俏丽少女-思淇sukiiii', '思淇sukiiii', $l_folder_name);
    $l_folder_name = str_replace('童颜巨乳妹子-思淇sukiiii', '思淇sukiiii', $l_folder_name);
    $l_folder_name = str_replace('quella-瑰娜', '瑰娜', $l_folder_name);
    $l_folder_name = str_replace('甜美妹子-不柠bling', '不柠Bling', $l_folder_name);
    $l_folder_name = str_replace('宋-kiki', '宋Kiki', $l_folder_name);
    $l_folder_name = str_replace('solo-尹菲', '尹菲', $l_folder_name);
    $l_folder_name = str_replace('solo_尹菲', '尹菲', $l_folder_name);
    $l_folder_name = str_replace('奶茶-emily', '奶茶', $l_folder_name);
    $l_folder_name = str_replace('龚叶轩paris', '龚叶轩', $l_folder_name);
    $l_folder_name = str_replace('chen美妍', '美妍', $l_folder_name);
    $l_folder_name = str_replace('cheryl青树', '青树', $l_folder_name);
    $l_folder_name = str_replace('傅詩瑤siri', '傅詩瑤', $l_folder_name);
    $l_folder_name = str_replace('晗大大via', '晗大大', $l_folder_name);
    $l_folder_name = str_replace('abby黎允婷', '黎允婷', $l_folder_name);
    $l_folder_name = str_replace('K8傲娇萌萌Vivian', 'K8傲娇萌萌', $l_folder_name);
    $l_folder_name = str_replace('luna张静燕', '张静燕', $l_folder_name);
    $l_folder_name = str_replace('sibyl李思宁', '李思宁', $l_folder_name);
    $l_folder_name = str_replace('冯木木lris', '冯木木', $l_folder_name);
    $l_folder_name = str_replace('鱼子酱fish', '鱼子酱', $l_folder_name);
    $l_folder_name = str_replace('程慧娴phoebe', '程慧娴', $l_folder_name);
    $l_folder_name = str_replace('久久aimee', '久久', $l_folder_name);
    $l_folder_name = str_replace('小蛮妖yummy', '小蛮妖', $l_folder_name);
    $l_folder_name = str_replace('诗诗kiki', '诗诗', $l_folder_name);
    $l_folder_name = str_replace('waya小帝姬', '小帝姬', $l_folder_name);
    $l_folder_name = str_replace('陈雅漫vicky', '陈雅漫', $l_folder_name);
    $l_folder_name = str_replace('方绮言ayaka', '方绮言', $l_folder_name);
    $l_folder_name = str_replace('凯竹buibui', '凯竹', $l_folder_name);
    $l_folder_name = str_replace('李筱乔jo', '李筱乔', $l_folder_name);
    $l_folder_name = str_replace('陆芷翊lucia', '陆芷翊', $l_folder_name);
    $l_folder_name = str_replace('模特姗姗就打奥特曼', '姗姗就打奥特曼', $l_folder_name);
    $l_folder_name = str_replace('青妍celina', '青妍', $l_folder_name);
    $l_folder_name = str_replace('施忆佳kitty', '施忆佳', $l_folder_name);
    $l_folder_name = str_replace('史雯swan', '史雯', $l_folder_name);
    $l_folder_name = str_replace('赵小米kitty', '赵小米', $l_folder_name);
    $l_folder_name = str_replace('史雯swan', '史雯', $l_folder_name);
    $l_folder_name = str_replace('萌琪琪irene', '萌琪琪', $l_folder_name);
    $l_folder_name = str_replace('凯竹vision', '凯竹', $l_folder_name);
    $l_folder_name = str_replace('foxyini孟狐狸', '孟狐狸', $l_folder_name);
    $l_folder_name = str_replace('赵欢颜jessica', '赵欢颜', $l_folder_name);
    $l_folder_name = str_replace('娜露selena', '娜露', $l_folder_name);
    $l_folder_name = str_replace('杨晨晨sugar', '杨晨晨', $l_folder_name);
    $l_folder_name = str_replace('陈嘉嘉tiffany', '陈嘉嘉', $l_folder_name);
    $l_folder_name = str_replace('谢芷馨sindy', '谢芷馨', $l_folder_name);
    $l_folder_name = str_replace('兜豆靓youlina', '兜豆靓', $l_folder_name);
    $l_folder_name = str_replace('绯月樱-cherry', '绯月樱', $l_folder_name);
    $l_folder_name = str_replace('芝芝booty', '芝芝', $l_folder_name);
    $l_folder_name = str_replace('angela小热巴', '小热巴', $l_folder_name);
    $l_folder_name = str_replace('manuela玛鲁娜', '玛鲁娜', $l_folder_name);
    $l_folder_name = str_replace('玛鲁娜Manuela', '玛鲁娜', $l_folder_name);
    $l_folder_name = str_replace('绮里嘉Ula', '绮里嘉', $l_folder_name);
    $l_folder_name = str_replace('evelyn艾莉', '艾莉', $l_folder_name);
    $l_folder_name = str_replace('flower朱可儿', '朱可儿', $l_folder_name);
    $l_folder_name = str_replace('love陆瓷', '陆瓷', $l_folder_name);
    $l_folder_name = str_replace('vetiver嘉宝贝儿', '嘉宝贝儿', $l_folder_name);
    $l_folder_name = str_replace('绮里嘉ula', '绮里嘉', $l_folder_name);
    $l_folder_name = str_replace('绮里ula', '绮里嘉', $l_folder_name);
    $l_folder_name = str_replace('蔡文钰angle', '蔡文钰', $l_folder_name);
    $l_folder_name = str_replace('李雪婷anna', '李雪婷', $l_folder_name);
    $l_folder_name = str_replace('刘飞儿faye', '刘飞儿', $l_folder_name);
    $l_folder_name = str_replace('刘雪妮verna', '刘雪妮', $l_folder_name);
    $l_folder_name = str_replace('糯美子mini', '糯美子', $l_folder_name);
    $l_folder_name = str_replace('佘贝拉bella', '佘贝拉', $l_folder_name);
    $l_folder_name = str_replace('唐琪儿beauty', '唐琪儿', $l_folder_name);
    $l_folder_name = str_replace('唐琪儿il', '唐琪儿', $l_folder_name);
    $l_folder_name = str_replace('王馨瑶yanni', '王馨瑶', $l_folder_name);
    $l_folder_name = str_replace('徐微微mia', '徐微微', $l_folder_name);
    $l_folder_name = str_replace('许诺sabrina', '许诺', $l_folder_name);
    $l_folder_name = str_replace('sandy陈天扬', '陈天扬', $l_folder_name);
    $l_folder_name = str_replace('vetiver嘉宝贝儿', '嘉宝贝儿', $l_folder_name);
    $l_folder_name = str_replace('夏笑笑summer', '夏笑笑', $l_folder_name);
    $l_folder_name = str_replace('刘奕宁lynn', '刘奕宁', $l_folder_name);
        
    
    
    
    
    

    return $l_folder_name;
}