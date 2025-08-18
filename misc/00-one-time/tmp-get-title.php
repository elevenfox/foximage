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
    echo "---- Must have a end number! \n";
    exit;
}


$base_url = 'https://sscoc.cc/?s=';
//https://www.youwushow.com/?s=秀人+No.7002
//https://www.retuge03.com/?s=语画界+Vol.1100

// $term = '秀人';
// $start = 6052;
// $end = 6099;

$date_url = 'https://www.hdleg.com/search/<terms>/';

$num_pre_mapping = [
    '秀人' => 'No.',
    '语画界' => 'Vol.',
    '尤蜜荟' => 'Vol.',
    '花漾' => 'Vol.',
    '星颜社' => 'Vol.',
    '爱尤物' => 'No.',
    '嗲囡囡' => 'Vol.',
];

$en_cn_mapping = [
    '秀人' => 'Xiuren',
    '语画界' => 'xiaoyu', 
    '尤蜜荟' => 'youmi',
    '花漾' => 'huayang',
    '星颜社' => 'xingyan',
    '爱尤物' => '尤果圈',
    '嗲囡囡' => 'FeiLin',
];

$all_sub_folders = scandir($folder_full_path);
for ($i = $start; $i<=$end; $i++) {
    $num = $i<100 ? sprintf('%03d', $i) : (string)$i;
    foreach($all_sub_folders as $folder_name) {
        $date = '';
        if(strpos($folder_name, $term) !== false && strpos($folder_name, $num) !== false) {
            $tmp_term = $term;
            // echo 'Found match folder:  ' . $folder_name . "\n";

            // Fetch title from url
            $url = $base_url . $tmp_term . '+' . $num_pre_mapping[$tmp_term] . $num;
            echo $url."\n";
            $html = curl_call($url);
            // echo $html."\n";
            // 修改这里以匹配<a>标签中的文本
            $res = find_between($html, 'class="thumb" alt="', '"></a>');
            foreach($res as $title) {
                // 修正：使用正确的结束标记
                // echo $title. "\n";
                // $title_parts = explode('">', $title);
                // $title = !empty($title_parts[1]) ? trim($title_parts[1]) : '';
                if(!empty($title) && stripos($title, $tmp_term) !== false && strpos($title, $num) !== false ) {
                    echo $title . "\n";
                    // [Xiuren秀人网] No.2989 嫩模郑颖姗Bev三亚旅拍韵味旗袍配无内肉丝裤袜撩人姿势诱惑写真41P
                    $append = cleanStringForFilename($title);
                    $append = str_ireplace('半脱', '', $append);
                    $append = str_ireplace('脱', '', $append);
                    // $append = str_ireplace('露', '', $append);
                    $append = str_ireplace('吊袜', '吊带袜', $append);
                    $append = str_ireplace('吊裙', '吊带裙', $append);
                    $append = str_ireplace('私房', '', $append);
                    $append = str_ireplace('配', '', $append);
                    $append = str_ireplace('无内', '', $append);
                    $append = str_ireplace('开档', '', $append);
                    //$append = str_ireplace('性感', '', $append);
                    $append = str_ireplace('性感写真', '', $append);
    
                    //$dup = find_between($append, $tmp_term, $num);
                    $dup = explode($num, $append);
                    if(!empty($dup[1])) {
                        //$append = str_replace($tmp_term.$dup[0].$num, '', $append);
                        $append = $dup[1];
                    }
                    $append = str_ireplace('[IMiss', '', $append);
                    $append = str_ireplace('IMiss', '', $append);
                    
                    if(strpos($append, "秀") !== false) $append = substr($append, 0, strpos($append, "秀"));
                    // if(strpos($append, "撩人") !== false) $append = substr($append, 0, strpos($append, "撩人"));
                    // if(strpos($append, "诱惑") !== false) $append = substr($append, 0, strpos($append, "诱惑"));
                    if(strpos($append, "完美") !== false) $append = substr($append, 0, strpos($append, "完美"));
                    if(strpos($append, "极致") !== false) $append = substr($append, 0, strpos($append, "极致"));
                    //if(strpos($append, "写真") !== false) $append = substr($append, 0, strpos($append, "写真"));
    
                    $new_folder_name = $folder_name;
                    $new_folder_name = str_ireplace(' ', '-', $new_folder_name);
                    $a = explode('-', $folder_name);
                    $model = $a[2];
                    if(strpos($append, $model) !== false) {
                        $b = explode($model, $append);
                        $append = $b[1];   
                    }
                    $append = str_starts_with($append, '-') ? substr($append, 1) : $append;
                    $append = str_ireplace('--', '-', $append);
                    // $append = '《' . $append . '》';

                    if (isValidDate(end($a))) {
                        $date = array_pop($a);
                    }
                    $new_folder_name = implode('-', $a);
                    if(!empty($date)) $new_folder_name = $new_folder_name . '-' . $append . '-' . $date;
                    else $new_folder_name = $new_folder_name . '-' . $append;
                    $new_folder_name = str_ireplace('--', '-', $new_folder_name);
                    echo "new folder name: $new_folder_name\n";
                    break;
                }
            }

            // 如果 new_folder_name 已经是日期结尾，则不再进行日期匹配
            $c = explode('-', $new_folder_name);
            if (!isValidDate(end($c))) {
                // Use $date_url to fetch date
                $en_term = $en_cn_mapping[$tmp_term];
                $the_number = str_replace('.', '', $num_pre_mapping[$tmp_term]);
                $the_date_url = str_replace('<terms>', $en_term. '-' . strtolower($the_number) . '-' . $num, $date_url);
                echo 'the_date_url: ' . $the_date_url."\n";
                $html = curl_call($the_date_url);
                // find first li inside ul with class="list-group", make sure it has span with class="custom-list-item-name"
                // and it's content contains $tmp_term and $num, then get the content of the span with class="custom-list-item-date"
                // and it's content is a date string and convert it to YYYY.MM.DD format
                $resUL = explode('<li class="list-group-item">', $html);
                //var_dump($resUL[1]);
                if(strpos($resUL[1], $num)!== false) {
                    $res = find_between($resUL[1], '<span class="custom-list-item-date">', '<span class=');
                    if(!empty($res[0])) {
                        $date = $res[0];
                        $date = strtotime($date);
                        $date = date('Y.m.d', $date);
                        echo "Date: $date\n";

                        if(!empty($date)) {
                            $new_folder_name = $new_folder_name. '-'. $date;
                            $new_folder_name = str_ireplace('--', '-', $new_folder_name);
                            echo "new folder name: $new_folder_name\n";
                        }
                    }
                }  

                
            }

            echo "rename $folder_full_path/$folder_name to $folder_full_path/$new_folder_name\n\n"; 
            rename($folder_full_path.'/'.$folder_name, $folder_full_path . '/'.$new_folder_name);
            // exit;
            break;
        }
    }
    echo "\n\n";
}


function isValidDate($date) {
    return preg_match('/^\d{4}\.\d{2}\.\d{2}$/', $date);
}
