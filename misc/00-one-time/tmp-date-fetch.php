<?php
require_once '../../bootstrap.inc.php';


$folder_full_path = isset($argv[1]) ? $argv[1] : null;
$term = isset($argv[2]) ? $argv[2] : '';
$start = isset($argv[3]) ? (int)$argv[3] : 0;
$end = isset($argv[4]) ? (int)$argv[4] : 0;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}
if(empty($term)) {
    echo "---- Must have a search keyword term! \n";
    exit;
}
if(empty($start)) {
    echo "---- Must have a start number! \n";
    exit;
}
if(empty($end)) {
    echo "---- Must have a en number! \n";
    exit;
}

function startsWithNumber($string) {
    return strlen($string) > 0 && ctype_digit(substr($string, 0, 1));
}


$base_url = 'https://www.nicesss.com/?s=';
// https://xzm2048.com/?s=huayang+489
// https://www.aitlh.com/?s=youmi+583

// $term = '秀人';
// $start = 6052;
// $end = 6099;
$all_sub_folders = scandir($folder_full_path);
for ($i = $start; $i<=$end; $i++) {
    $num = $i<100 ? sprintf('%03d', $i) : (string)$i;
    foreach($all_sub_folders as $folder_name) {
        if(stripos($folder_name, $term) !== false && strpos($folder_name, $num) !== false) {
            $tmp_term = $term == '语画界' ? '画语界' : $term;
            // echo 'Found match folder:  ' . $folder_name . "\n";

            $url = $base_url . $tmp_term . '+Vol.' . $num;
            echo $url."\n";
            $html = curl_call($url);
            $res = find_between($html, '<h2' , '</h2>');
            foreach($res as $h2) {
                //echo $h2 ."\n"; exit;
                if(!empty($h2) && stripos($h2, $term) !== false && strpos($h2, $num) !== false) {
                    $res2 = find_between($h2, 'title="' , '"');
                    if(!empty($res2[0])) {
                        echo $res2[0] . "\n";
                        // [XiuRen秀人网] 2023.06.21 NO.6961 幼幼 [82+1P811M]
                        $title = cleanStringForFilename($res2[0]);
                        $title = str_ireplace('--', '-', $title);
                        $a = explode('-', $title);
                        $date = $a[1];
    
                        if(startsWithNumber($date)) {
                            $new_folder_name = $folder_name;
                            $new_folder_name = str_ireplace(' ', '-', $new_folder_name);
                            
                            if(strpos($new_folder_name, $date) === false) {
                                $new_folder_name = $new_folder_name . '-' . $date;
                                $new_folder_name = str_ireplace('--', '-', $new_folder_name);
                            
                                echo "rename $folder_full_path/$folder_name to $folder_full_path/$new_folder_name\n\n";
                                //rename($folder_full_path.'/'.$folder_name, $folder_full_path . '/'.$new_folder_name);
                            }
                            else {
                                echo "------ Already have date string! \n";
                            }
                        }
                        else {
                            echo "------ No date string found! \n";
                        }
                    }
                    break;
                }
            }
            
            break;
        }
    }
    
}

