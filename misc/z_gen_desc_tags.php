<?php
require_once realpath(dirname(__FILE__)).'/../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        if(strpos($haystack, $needle) === false) return false;
        else return true;
    }
}

###################### Define variables ################


$folder_full_path = isset($argv[1]) ? $argv[1] : null;
if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

$common_tags = isset($argv[2]) ? $argv[2] : null;


###################### End of define variables ################


echo  "#####################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start processing album: $folder_full_path .... \n";
echo  "#####################################\n";


$folder_name = basename($folder_full_path);

// If no desc.txt, generate desc from title
$desc = file_get_contents($folder_full_path.'/desc.txt');
if(empty($desc)) {
    $desc = str_replace('-', ' ', $folder_name);
    // 特殊处理 xiuren
    if(strpos($desc, 'XiuRen秀人网') === false) $desc = str_replace('XiuRen', 'XiuRen秀人网', $desc);

    $desc .= '。欢迎下载高清无水印套图。';
}
else {
    $desc = str_replace(' 生日','生日', $desc);
    $pos = strpos($desc, '生日');
    if($pos !== false) {
        $c = $desc[$pos-1];
        if ($c != "\n" && $c != "\rn" && $c != "\r") {
            $desc = str_replace('生日',"\n生日", $desc);
        }
    }
    $desc = str_replace(' 罩杯','罩杯', $desc);
    $pos = strpos($desc, '罩杯');
    if($pos !== false) {
        $c = $desc[$pos-1];
        if ($c != "\n" && $c != "\rn" && $c != "\r") {
            $desc = str_replace('罩杯',"\n罩杯", $desc);
        }
    }
}
echo date('Y-m-d H:i:s') . ' - ' . "-- desc: $desc \n";
file_put_contents($folder_full_path . '/desc.txt', $desc);



// Cleanup junk files and Handle thumbnail.jpg
$scan2 = scandir($folder_full_path);
$images = [];
$already_has_thumbnail = false;
foreach($scan2 as $file) {
    $origin_file_full = $folder_full_path . '/' . $file;
    if(strpos($file, '本套图来自') !== false) {
        unlink($origin_file_full);
    }
    if(strpos($file, '更多百度搜索') !== false) {
        unlink($origin_file_full);
    }
    if(strpos($file, '永久地址') !== false) {
        unlink($origin_file_full);
    }
    if($file == 'cover.jpg' || $file == 'cover.JPG') {
        rename($origin_file_full, $folder_full_path . '/thumbnail.jpg');
        $file = 'thumbnail.jpg';
    }
    if($file == 'thumbnail.JPG') {
        rename($origin_file_full, $folder_full_path . '/thumbnail.jpg');
        $file = 'thumbnail.jpg';
    }
    if($file == 'thumbnail.jpg') $already_has_thumbnail = true;
    if(!$already_has_thumbnail) {
        if ( is_file($origin_file_full) && @is_array(getimagesize($origin_file_full)) ) {
            $images[] = $file;
        }
    }
}
if($already_has_thumbnail) {
    echo "---- Already has a thumbnail.jpg \n\n";
}
else {
    natsort($images);
    // Get first portrait image
    $thumb = $images[0];
    foreach ($images as $im) {
        if(isImagePortrait($folder_full_path.'/'.$im)) {
            $thumb = $im;
            break;
        }
    }
    
    echo 'copy('. $folder_full_path . '/' . $thumb . ', ' . $folder_full_path . '/thumbnail.jpg' .  "\n\n";
    copy($folder_full_path . '/' . $thumb , $folder_full_path . '/thumbnail.jpg');    
}

// create a new empty dl.txt in current folder
echo "file_put_contents($folder_full_path/dl.txt, '') \n";
file_put_contents($folder_full_path.'/dl.txt', '');


// If no tags.txt, generate tags based on path and folder name
$tags_str = file_exists($folder_full_path.'/tags.txt') ? file_get_contents($folder_full_path.'/tags.txt') : '';
$tags_str = str_replace('，',',',$tags_str);
// Split folder name
$terms = explode('-', $folder_name);
// 特殊处理
if(substr( strtolower($folder_name), 0, 6 ) === "xiuren") {
    [$org_name_en, $org_name, $model_name] = ['XiuRen', '秀人网', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 5 ) === "youmi") {
    [$org_name_en, $org_name, $model_name] = ['YouMi', '尤蜜荟', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 7 ) === "xingyan") {
    [$org_name_en, $org_name, $model_name] = ['XingYan', '星颜社', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 6 ) === "mygirl") {
    [$org_name_en, $org_name, $model_name] = ['MyGirl', '美媛馆', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 7 ) === "huayang") {
    [$org_name_en, $org_name, $model_name] = ['HuaYang', '花漾', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 6 ) === "mfstar") {
    [$org_name_en, $org_name, $model_name] = ['MFStar', '模范学院', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 5 ) === "imiss") {
    [$org_name_en, $org_name, $model_name] = ['IMiss', '爱蜜社', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 6 ) === "miitao") {
    [$org_name_en, $org_name, $model_name] = ['MiiTao', '蜜桃社', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 5 ) === "girlt") {
    [$org_name_en, $org_name, $model_name] = ['Girlt', '果团网', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 6 ) === "feilin") {
    [$org_name_en, $org_name, $model_name] = ['FeiLin', '嗲囡囡', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 6 ) === "mygirl") {
    [$org_name_en, $org_name, $model_name] = ['MyGirl', '美媛馆', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 6 ) === "xiaoyu") {
    [$org_name_en, $org_name, $model_name] = ['XiaoYu', '语画界', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 9 ) === "ugirlsapp") {
    [$org_name_en, $org_name, $model_name] = ['UGirlsApp', '尤果圈爱尤物', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 7 ) === "toutiao") {
    [$org_name_en, $org_name, $model_name] = ['TouTiao', '头条女神', $terms[2]];
}
else {
    [$org_name_en, $org_name, $model_name] = ['', '', $terms[0]];
}
$tags = explode(',', $tags_str);
if(! in_array($org_name_en, $tags) && ! in_array(strtolower($org_name_en), $tags)) {
    if(!empty($org_name_en)) $tags[] = $org_name_en;
}
if(! in_array( $org_name, $tags ) ) {
    if(!empty($org_name)) $tags[] = $org_name;
}
if(! in_array( $model_name, $tags ) ) {
    $tags[] = $model_name;
}
if( str_contains($folder_name, '黑丝') && !in_array('黑丝', $tags)) {
    $tags[] = '黑丝';
}
if( str_contains($folder_name, '黑丝') && !in_array('美腿', $tags)) {
    $tags[] = '美腿';
}
if( str_contains($folder_name, '蕾丝') && !in_array('蕾丝诱惑', $tags)) {
    $tags[] = '蕾丝诱惑';
}
if( str_contains($folder_name, '比基尼') && !in_array('比基尼', $tags)) {
    $tags[] = '比基尼';
}
if( str_contains($folder_name, '丁字裤') && !in_array('丁字裤', $tags)) {
    $tags[] = '丁字裤';
}
if( str_contains($folder_name, '丁字裤') && !in_array('美臀', $tags)) {
    $tags[] = '美臀';
}
if( str_contains($folder_name, '情趣') && !in_array('情趣内衣', $tags)) {
    $tags[] = '情趣内衣';
}
if( str_contains($folder_name, '学生') && !in_array('学生装', $tags)) {
    $tags[] = '学生装';
}
if( str_contains($folder_name, '校服') && !in_array('学生装', $tags)) {
    $tags[] = '学生装';
}
if( str_contains($folder_name, '女仆') && !in_array('女仆', $tags)) {
    $tags[] = '女仆';
}
if( str_contains($folder_name, '秘书') && !in_array('女秘书', $tags)) {
    $tags[] = '女秘书';
}
if( str_contains($folder_name, '秘书') && !in_array('职业装', $tags)) {
    $tags[] = '职业装';
}
if( str_contains($folder_name, '护士') && !in_array('护士', $tags)) {
    $tags[] = '护士';
}
if( str_contains($folder_name, '护士') && !in_array('制服', $tags)) {
    $tags[] = '制服';
}
if( str_contains($folder_name, '教师') && !in_array('女教师', $tags)) {
    $tags[] = '女教师';
}
if( str_contains($folder_name, '警') && !in_array('女警', $tags)) {
    $tags[] = '女警';
}
if( str_contains($folder_name, '警') && !in_array('女警', $tags)) {
    $tags[] = '制服';
}
if( str_contains($folder_name, 'SM') && !in_array('捆绑', $tags)) {
    $tags[] = '捆绑';
}
if( str_contains($folder_name, '绑缚') && !in_array('捆绑', $tags)) {
    $tags[] = '捆绑';
}
if( str_contains($folder_name, '空姐') && !in_array('空姐', $tags)) {
    $tags[] = '空姐';
}
if( str_contains($folder_name, '空姐') && !in_array('制服', $tags)) {
    $tags[] = '制服';
}
if( str_contains($folder_name, '旗袍') && !in_array('旗袍', $tags)) {
    $tags[] = '旗袍';
}
if( str_contains($folder_name, '旗袍') && !in_array('古风', $tags)) {
    $tags[] = '古风';
}
if( str_contains($folder_name, '古装') && !in_array('古风', $tags)) {
    $tags[] = '古风';
}
if( str_contains($folder_name, '肚兜') && !in_array('古风', $tags)) {
    $tags[] = '古风';
}
if( str_contains($folder_name, '肚兜') && !in_array('肚兜', $tags)) {
    $tags[] = '肚兜';
}
if( str_contains($folder_name, '透视') && !in_array('透视装', $tags)) {
    $tags[] = '透视装';
}
if( str_contains($folder_name, '白衬') && !in_array('白衬衫', $tags)) {
    $tags[] = '白衬衫';
}
if( str_contains($folder_name, '泳池') && !in_array('泳池', $tags)) {
    $tags[] = '泳池';
}
if( str_contains($folder_name, 'OL') && !in_array('职业装', $tags)) {
    $tags[] = '职业装';
}
if( str_contains($folder_name, '湿身') && !in_array('湿身', $tags)) {
    $tags[] = '湿身';
}
if( str_contains($folder_name, '豹纹') && !in_array('豹纹', $tags)) {
    $tags[] = '豹纹';
}
if( (str_contains($folder_name, '朱可儿')  
    || str_contains($folder_name, '美七')  
    || str_contains($folder_name, '糯美子') 
    || str_contains($folder_name, '娜露') 
    || str_contains($folder_name, '尤奈') 
    ) && !in_array('童颜巨乳', $tags)) {
    $tags[] = '童颜巨乳';
}
if( (str_contains($folder_name, '朱可儿')  
    || str_contains($folder_name, '美七')  
    || str_contains($folder_name, '糯美子') 
    || str_contains($folder_name, '娜露') 
    || str_contains($folder_name, '尤奈') 
    || str_contains($folder_name, '尤妮丝') 
    || str_contains($folder_name, '潘娇娇')  
    || str_contains($folder_name, '允爾')  
    || str_contains($folder_name, '田冰冰') 
    || str_contains($folder_name, '果儿') 
    || str_contains($folder_name, '软软')  
    || str_contains($folder_name, '李丽莎') 
    || str_contains($folder_name, '小海臀')  
    || str_contains($folder_name, '刘钰儿')  
    || str_contains($folder_name, '妲己')  
    || str_contains($folder_name, '温心怡')  
    || str_contains($folder_name, '豪乳')  
    ) && !in_array('爆乳', $tags)) {
    $tags[] = '爆乳';
}
if( (str_contains($folder_name, '鱼子酱')  
    || str_contains($folder_name, '卓娅祺')  
    || str_contains($folder_name, '玛鲁娜') 
    || str_contains($folder_name, '尹菲') 
    || str_contains($folder_name, '顾奈奈') 
    || str_contains($folder_name, '阿朱') 
    || str_contains($folder_name, '心妍') 
    || str_contains($folder_name, '周于希') 
    || str_contains($folder_name, '艾小青') 
    || str_contains($folder_name, '王雨纯') 
    || str_contains($folder_name, '萌汉药') 
    || str_contains($folder_name, '土肥圆') 
    || str_contains($folder_name, '杨晨晨') 
    ) && !in_array('美胸', $tags)) {
    $tags[] = '美胸';
}
if( (str_contains($folder_name, '朱可儿')  
    || str_contains($folder_name, '美七')  
    || str_contains($folder_name, '允爾') 
    || str_contains($folder_name, '尤妮丝') 
    || str_contains($folder_name, '小海臀') 
    || str_contains($folder_name, '刘钰儿') 
    ) && !in_array('美臀', $tags)) {
    $tags[] = '美臀';
}
if( (str_contains($folder_name, '葛征')  
    || str_contains($folder_name, '阿朱')  
    || str_contains($folder_name, '周于希') 
    || str_contains($folder_name, '果儿') 
    || str_contains($folder_name, '刘钰儿') 
    ) && !in_array('美腿', $tags)) {
    $tags[] = '美腿';
}
$tag_arr = array_filter(array_unique(array_merge(explode(',', $tags_str), explode(',', $common_tags), $tags)));
$tags_str = implode(',', $tag_arr);
echo date('Y-m-d H:i:s') . ' - ' . "-- tags: $tags_str \n";
file_put_contents($folder_full_path.'/tags.txt', $tags_str);


echo " \n";