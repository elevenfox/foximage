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

// // If no desc.txt, generate desc from title
// $desc = file_get_contents($folder_full_path.'/desc.txt');
// if(empty($desc)) {
//     $desc = str_replace('-', ' ', $folder_name);
//     // 特殊处理 xiuren
//     if(strpos($desc, 'XiuRen秀人网') === false) $desc = str_replace('XiuRen', 'XiuRen秀人网', $desc);

//     $desc .= '。欢迎下载高清无水印套图。';
// }
// else {
//     $desc = str_replace(' 生日','生日', $desc);
//     $pos = strpos($desc, '生日');
//     if($pos !== false) {
//         $c = $desc[$pos-1];
//         if ($c != "\n" && $c != "\rn" && $c != "\r") {
//             $desc = str_replace('生日',"\n生日", $desc);
//         }
//     }
//     $desc = str_replace(' 罩杯','罩杯', $desc);
//     $pos = strpos($desc, '罩杯');
//     if($pos !== false) {
//         $c = $desc[$pos-1];
//         if ($c != "\n" && $c != "\rn" && $c != "\r") {
//             $desc = str_replace('罩杯',"\n罩杯", $desc);
//         }
//     }
// }
// echo date('Y-m-d H:i:s') . ' - ' . "-- desc: $desc \n";
// file_put_contents($folder_full_path . '/desc.txt', $desc);

// // If no tags.txt, generate tags based on path and folder name
// $tags_str = file_exists($folder_full_path.'/tags.txt') ? file_get_contents($folder_full_path.'/tags.txt') : '';
// $tags_str = str_replace('，',',',$tags_str);
// // Split folder name
// $terms = explode('-', $folder_name);
// // 特殊处理
// if(substr( strtolower($folder_name), 0, 6 ) === "xiuren") {
//     [$org_name_en, $org_name, $model_name] = ['XiuRen', '秀人网', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 5 ) === "youmi") {
//     [$org_name_en, $org_name, $model_name] = ['YouMi', '尤蜜荟', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 7 ) === "xingyan") {
//     [$org_name_en, $org_name, $model_name] = ['XingYan', '星颜社', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 6 ) === "mygirl") {
//     [$org_name_en, $org_name, $model_name] = ['MyGirl', '美媛馆', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 7 ) === "huayang") {
//     [$org_name_en, $org_name, $model_name] = ['HuaYang', '花漾', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 5 ) === "youwu") {
//     [$org_name_en, $org_name, $model_name] = ['YouWu', '尤物馆', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 6 ) === "mfstar") {
//     [$org_name_en, $org_name, $model_name] = ['MFStar', '模范学院', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 5 ) === "imiss") {
//     [$org_name_en, $org_name, $model_name] = ['IMiss', '爱蜜社', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 6 ) === "miitao") {
//     [$org_name_en, $org_name, $model_name] = ['MiiTao', '蜜桃社', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 5 ) === "girlt") {
//     [$org_name_en, $org_name, $model_name] = ['Girlt', '果团网', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 6 ) === "feilin") {
//     [$org_name_en, $org_name, $model_name] = ['FeiLin', '嗲囡囡', $terms[2]];
// }
// elseif(substr( strtolower($folder_name), 0, 7 ) === "missleg") {
//     [$org_name_en, $org_name, $model_name] = ['MissLeg', '蜜丝', $terms[2]];
// }
// else {
//     [$org_name_en, $org_name, $model_name] = ['', '', $terms[0]];
// }
// $tags = explode(',', $tags_str);
// if(! in_array($org_name_en, $tags) && ! in_array(strtolower($org_name_en), $tags)) {
//     $tags[] = $org_name_en;
// }
// if(! in_array( $org_name, $tags ) ) {
//     $tags[] = $org_name;
// }
// if(! in_array( $model_name, $tags ) ) {
//     $tags[] = $model_name;
// }
// $tag_arr = array_filter(array_unique(array_merge(explode(',', $tags_str), explode(',', $common_tags), $tags)));
// $tags_str = implode(',', $tag_arr);
// echo date('Y-m-d H:i:s') . ' - ' . "-- tags: $tags_str \n";
// file_put_contents($folder_full_path.'/tags.txt', $tags_str);

// Create dl.txt file for download_url
$tbox_file = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTyEtPWDpsqvn4qIEvwmk4__1fTjBTiREPcleN-crVfz4U0PDxBirWx9Vr4gqHlJE9mK5JEyugpbw6S/pub?output=csv';
$tbox_c = file_get_contents($tbox_file);
$tbox_list = [];
$lines = explode("\n", $tbox_c);
foreach($lines as $l) {
    $l = str_replace(',', ' ', $l);
    $l = preg_replace('!\s+!', ' ', $l);
    $l = str_replace(' ', ',', $l);
    $l_arr = explode(',', $l);
    $k = $l_arr[0];
    $v = empty($l_arr[1])?'':$l_arr[1];
    $tbox_list[$k] = $v;
}
$dl = empty($tbox_list[$folder_name]) ? '' : $tbox_list[$folder_name];
echo date('Y-m-d H:i:s') . ' - ' . "-- download: $dl \n";
file_put_contents($folder_full_path.'/dl.txt', $dl);
