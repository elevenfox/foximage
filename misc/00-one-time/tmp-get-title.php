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
    echo "---- Must have a term! \n";
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
    $num = (string)$i;
    foreach($all_sub_folders as $folder_name) {
        if(strpos($folder_name, $term) !== false && strpos($folder_name, $num) !== false) {
            // echo 'Found match folder:  ' . $folder_name . "\n";
            $url = $base_url . $term . '%20' . $i;
            $html = curl_call($url);
            $res = find_between($html, '__i18n:{langs:{}}}}(' , ',');
            echo $res[0] . "\n";
            if(!empty($res[0])) {
                $new_folder_name = $folder_name . '-' . cleanStringForFilename($res[0]);
                echo "rename $folder_full_path/$folder_name to $folder_full_path/$new_folder_name\n\n";
                rename($folder_full_path.'/'.$folder_name, $folder_full_path . '/'.$new_folder_name);
            }
            break;
        }
    }
}

