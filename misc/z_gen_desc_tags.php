<?php
require_once realpath(dirname(__FILE__)).'/../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


###################### Define variables and functions ################

$folder_full_path = isset($argv[1]) ? $argv[1] : null;
if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

$common_tags = isset($argv[2]) ? $argv[2] : null;
if(!empty($common_tags)) $common_tags = str_replace('，',',',$common_tags);

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        if(strpos($haystack, $needle) === false) return false;
        else return true;
    }
}

function getPhotoVideoInfo ($folderPath ) {
    if (is_dir($folderPath)) {
        $files = scandir($folderPath);
        $picFileCount = 0;
        $picFileSize = 0;
        $videoFileCount = 0;
        $vodeoFileSize = 0;
        foreach ($files as $file) {
            $filePath = $folderPath . '/' . $file;
            if ( is_file($filePath) && isImageFile($file) && $file != 'thumbnail.jpg' )  {
                $picFileCount++;
                $picFileSize += filesize($filePath);
            }
            // Check if the file is a regular file and has a video extension
            if (is_file($filePath) && isVideoFile($file)) {
                $videoFileCount++;
                $vodeoFileSize += filesize($filePath);
            }
        }
        return [$picFileCount, $videoFileCount, formatBytes($picFileSize), formatBytes($vodeoFileSize)];
    } else {
        return false;
    }
}
// Function to check if a file has a video extension
function isVideoFile($fileName) {
    $videoExtensions = array('mp4', 'avi', 'mkv', 'mov'); // Add more extensions if needed
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    return in_array(strtolower($fileExtension), $videoExtensions);
}
function isImageFile($fileName) {
    $acceptExtensions = array('jpg', 'JPG');
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    return in_array(strtolower($fileExtension), $acceptExtensions);
}

function formatBytes($bytes, $precision = 2) {
    // $units = array('B', 'KB', 'MB', 'GB', 'TB');

    // $bytes = max($bytes, 0);
    // $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    // $pow = min($pow, count($units) - 1);

    // // Calculate the size in the chosen unit
    // $bytes /= (1 << (10 * $pow));

    // return round($bytes, $precision) . ' ' . $units[$pow];
    return round($bytes/1024/1024, $precision);
}

###################### End of define variables ################


echo  "#####################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start processing album: $folder_full_path .... \n";
echo  "#####################################\n";


$folder_name = basename($folder_full_path);

// If no desc.txt, generate desc from title
$desc = file_get_contents($folder_full_path.'/desc.txt');
if(empty($desc)) {
    $desc = $folder_name;
    // 特殊处理 xiuren
    if(strpos($desc, 'XiuRen秀人网') === false) {
        $desc = str_replace('XiuRen', 'XiuRen秀人网', $desc);
    }
    $desc = str_replace('XiuRen秀人网-', 'XiuRen秀人网-No.', $desc);
    $desc = str_replace('MFStar模范学院-', 'MFStar模范学院-Vol.', $desc);
    $desc = str_replace('YouMi尤蜜荟-', 'YouMi尤蜜荟-Vol.', $desc);
    $desc = str_replace('MyGirl美媛馆-', 'MyGirl美媛馆-Vol.', $desc);
    $desc = str_replace('XingYan星颜社-', 'XingYan星颜社-Vol.', $desc);
    
    $desc = str_replace('-', ' ', $desc);
    
    list($picFileCount, $videoFileCount, $picFileSize, $vodeoFileSize) = getPhotoVideoInfo($folder_full_path);
    $videoInfo = $videoFileCount > 0 ? "以及{$videoFileCount}部视频" : '';
    $desc .= "。欢迎下载高清无水印套图{$picFileCount}张{$videoInfo}。";
    $desc .= "( {$picFileCount}P - ". number_format($picFileSize) . " MB";
    if($videoFileCount > 0) {
        $desc .= ", {$videoFileCount}V - " . number_format($vodeoFileSize) . " MB";
    }
    $desc .= " )";
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



// If no tags.txt, generate tags based on path and folder name
$tags_str = file_exists($folder_full_path.'/tags.txt') ? file_get_contents($folder_full_path.'/tags.txt') : '';
$tags_str = str_replace('，',',',$tags_str);
// Split folder name
$terms = explode('-', $folder_name);
// 特殊处理
if(substr( strtolower($folder_name), 0, 6 ) === "xiuren") {
    [$org_name_en, $org_name, $model_name] = ['XiuRen', '秀人网', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 12 ) === "youmi尤蜜-") {
    [$org_name_en, $org_name, $model_name] = ['YouMi', '尤蜜', $terms[2]];
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
elseif(substr( strtolower($folder_name), 0, 6 ) === "ugirls") {
    [$org_name_en, $org_name, $model_name] = ['UGirls', '尤果网', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 7 ) === "toutiao") {
    [$org_name_en, $org_name, $model_name] = ['TouTiao', '头条女神', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 9 ) === "kelagirls") {
    [$org_name_en, $org_name, $model_name] = ['KelaGirls', '克拉女神', $terms[2]];
}
elseif(substr( strtolower($folder_name), 0, 4 ) === "jvid") {
    [$org_name_en, $org_name, $model_name] = ['JVID', '台湾JVID', $terms[1]];
}
else {
    [$org_name_en, $org_name, $model_name] = ['', '', $terms[0]];
}

$tags_str = str_replace('，',',',$tags_str);
$tags = explode(',', $tags_str);
if(! in_array($org_name_en, $tags) && ! in_array(strtolower($org_name_en), $tags)) {
    if(!empty($org_name_en)) $tags[] = $org_name_en;
}
if(! in_array( $org_name, $tags ) ) {
    if(!empty($org_name)) $tags[] = $org_name;
}
$model_name = mapModelNames($model_name);
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
if( str_contains($folder_name, '警') && !in_array('制服', $tags)) {
    $tags[] = '制服';
}
if( str_contains($folder_name, 'SM') && !in_array('捆绑', $tags)) {
    $tags[] = '捆绑';
}
if( str_contains($folder_name, '绑缚') && !in_array('捆绑', $tags)) {
    $tags[] = '捆绑';
}
if( str_contains($folder_name, '束缚') && !in_array('捆绑', $tags)) {
    $tags[] = '捆绑';
}
if( str_contains($folder_name, '捆绑') && !in_array('捆绑', $tags)) {
    $tags[] = '捆绑';
}
if( str_contains($folder_name, '空姐') && !in_array('空姐', $tags)) {
    $tags[] = '空姐';
}
if( str_contains($folder_name, '空姐') && !in_array('制服', $tags)) {
    $tags[] = '制服';
}
if( str_contains($folder_name, '制服') && !in_array('制服', $tags)) {
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
if( str_contains($folder_name, '古风') && !in_array('古风', $tags)) {
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
if( str_contains($folder_name, '轻透') && !in_array('透视装', $tags)) {
    $tags[] = '透视装';
}
if( str_contains($folder_name, '薄透') && !in_array('透视装', $tags)) {
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
if( str_contains($folder_name, '西装') && !in_array('职业装', $tags)) {
    $tags[] = '职业装';
}
if( str_contains($folder_name, '职') && !in_array('职业装', $tags)) {
    $tags[] = '职业装';
}
if( str_contains($folder_name, '湿身') && !in_array('湿身', $tags)) {
    $tags[] = '湿身';
}
if( str_contains($folder_name, '豹纹') && !in_array('豹纹', $tags)) {
    $tags[] = '豹纹';
}
if( str_contains($folder_name, '健身') && !in_array('运动装', $tags)) {
    $tags[] = '运动装';
}
if( str_contains($folder_name, '体操服') && !in_array('运动装', $tags)) {
    $tags[] = '运动装';
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