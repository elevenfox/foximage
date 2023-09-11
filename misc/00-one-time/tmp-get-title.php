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


$base_url = 'https://nshens.com/search/';

// $term = '秀人';
// $start = 6052;
// $end = 6099;
$all_sub_folders = scandir($folder_full_path);
for ($i = $start; $i<=$end; $i++) {
    $num = $i<100 ? sprintf('%03d', $i) : (string)$i;
    foreach($all_sub_folders as $folder_name) {
        if(strpos($folder_name, $term) !== false && strpos($folder_name, $num) !== false) {
            $tmp_term = $term == '语画界' ? '画语界' : $term;
            // echo 'Found match folder:  ' . $folder_name . "\n";

            $url = $base_url . $tmp_term . '%20' . $num;
            echo $url."\n";
            $html = curl_call($url);
            $res = find_between($html, '__i18n:{langs:{}}}}(' , ',');
            echo $res[0] . "\n";
            if(!empty($res[0])) {
                // [Xiuren秀人网] No.2989 嫩模郑颖姗Bev三亚旅拍韵味旗袍配无内肉丝裤袜撩人姿势诱惑写真41P
                $append = cleanStringForFilename($res[0]);
                $append = str_ireplace('半脱', '', $append);
                $append = str_ireplace('脱', '', $append);
                $append = str_ireplace('露', '', $append);
                $append = str_ireplace('吊袜', '吊带袜', $append);
                $append = str_ireplace('吊裙', '吊带裙', $append);
                $append = str_ireplace('私房', '', $append);
                $append = str_ireplace('配', '', $append);
                $append = str_ireplace('无内', '', $append);
                $append = str_ireplace('开档', '', $append);

                $dup = find_between($append, $tmp_term, $num);
                $append = str_replace($tmp_term.$dup[0].$num, '', $append);
                $append = str_ireplace('[Xiuren', '', $append);
                $append = str_ireplace('Xiuren', '', $append);

                if(strpos($append, "秀") !== false) $append = substr($append, 0, strpos($append, "秀"));
                if(strpos($append, "撩人") !== false) $append = substr($append, 0, strpos($append, "撩人"));
                if(strpos($append, "诱惑") !== false) $append = substr($append, 0, strpos($append, "诱惑"));
                if(strpos($append, "完美") !== false) $append = substr($append, 0, strpos($append, "完美"));
                if(strpos($append, "极致") !== false) $append = substr($append, 0, strpos($append, "极致"));
                if(strpos($append, "写真") !== false) $append = substr($append, 0, strpos($append, "写真"));

                $new_folder_name = $folder_name;
                $a = explode('-', $folder_name);
                $model = $a[2];
                if(strpos($append, $model) !== false) {
                    $b = explode($model, $append);
                    $append = $b[1];   
                }

                $date = array_pop($a);
                $new_folder_name = implode('-', $a);
                if(!empty($date)) $new_folder_name = $new_folder_name . '-' . $append . '-' . $date;
                else $new_folder_name = $new_folder_name . '-' . $append;
                $new_folder_name = str_ireplace('--', '-', $new_folder_name);
                echo "rename $folder_full_path/$folder_name to $folder_full_path/$new_folder_name\n\n";
                rename($folder_full_path.'/'.$folder_name, $folder_full_path . '/'.$new_folder_name);
            }
            break;
        }
    }
    
}

