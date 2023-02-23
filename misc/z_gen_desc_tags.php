<?php
set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

###################### Define variables ################


$folder_full_path = isset($argv[1]) ? $argv[1] : null;
if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

$common_tags = isset($argv[2]) ? $argv[2] : null;
if(empty($folder_full_path)) {
    echo "---- no common tags defined...\n";
}

###################### End of define variables ################


echo  "#####################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start processing albums .... \n";
echo  date('Y-m-d H:i:s') . ' - ' . "-- for folder: " . $folder_full_path . " \n";
echo  "#####################################\n";


$folder_name = basename($folder_full_path);

// If no desc.txt, generate desc from title
$desc = file_get_contents($folder_full_path.'/desc.txt');
if(empty($desc)) {
    $desc = str_replace('-', ' ', $folder_name);
    // 特殊处理 xiuren
    $desc = str_replace('XiuRen', 'XiuRen秀人网', $desc);

    $desc .= '。欢迎下载高清无水印套图。';
}
echo date('Y-m-d H:i:s') . ' - ' . "-- desc: $desc \n";
file_put_contents($folder_full_path . '/desc.txt', $desc);

// If no tags.txt, generate tags based on path and folder name
$tags_str = file_get_contents($folder_full_path.'/tags.txt');
if(empty($tags_str)) {
    // Split folder name
    $terms = explode('-', $folder_name);
    echo substr(strtolower($folder_name), 0, 7) . "\n";
    // 特殊处理 xiuren
    if(substr( strtolower($folder_name), 0, 6 ) === "xiuren") {
        $tags_str = 'XiuRen,秀人网,' . $terms[2];
    }
    elseif(substr( strtolower($folder_name), 0, 5 ) === "youmi") {
        $tags_str = 'YouMi,尤蜜荟,' . $terms[2];
    }
    elseif(substr( strtolower($folder_name), 0, 7 ) === "xingyan") {
        $tags_str = 'XingYan,星颜社,' . $terms[2];
    }
    elseif(substr( strtolower($folder_name), 0, 6 ) === "mygirl") {
        $tags_str = 'MyGirl,美媛馆,' . $terms[2];
    }
    elseif(substr( strtolower($folder_name), 0, 7 ) === "huayang") {
        $tags_str = 'HuaYang,花漾,' . $terms[2];
    }
    else {
        $tags_str = $terms[0];
    }
}
$tag_arr = array_filter(array_unique(array_merge(explode(',', $tags_str), explode(',', $common_tags))));
$tags_str = implode(',', $tag_arr);
echo date('Y-m-d H:i:s') . ' - ' . "-- tags: $tags_str \n";
file_put_contents($folder_full_path.'/tags.txt', $tags_str);

// Create an empty dl.txt file for download_url
file_put_contents($folder_full_path.'/dl.txt', '');