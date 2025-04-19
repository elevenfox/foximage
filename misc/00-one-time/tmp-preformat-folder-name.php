<?php
//echo phpinfo(); exit;

require('../../bootstrap.inc.php');  

$path = isset($argv[1]) ? $argv[1] : null;
if(empty($path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}


$scan = scandir($path);
foreach($scan as $folder_name) {
    $origin_full_path = $path . '/'. $folder_name;
    
    if (is_dir($origin_full_path) && $folder_name!='.' && $folder_name!='..') {
        echo '-- Processing folder: ' . $folder_name . "\n";
        $l_folder_name = strtolower($folder_name);
        $l_folder_name = str_replace('vol.', 'no.', $l_folder_name);

        $new_folder_name = $folder_name;

        $new_folder_name = str_ireplace('[YouMi尤蜜荟]', 'YouMi尤蜜荟-', $new_folder_name);
        $new_folder_name = str_ireplace('[XiuRen秀人网]', 'XiuRen秀人网-', $new_folder_name);
        $new_folder_name = str_ireplace('XiuRen秀人网 No.', 'XiuRen秀人网-', $new_folder_name);
        $new_folder_name = str_ireplace('[爱尤物]2023 NO.', 'UGirlsApp尤果圈爱尤物-', $new_folder_name);
        $new_folder_name = str_ireplace('Ugirls App尤果圈 NO.', 'UGirlsApp尤果圈爱尤物-', $new_folder_name);
        $new_folder_name = str_ireplace('[Feilin嗲囡囡]', 'FeiLin嗲囡囡-', $new_folder_name);
        $new_folder_name = str_ireplace('[HuaYang花漾show]', 'HuaYang花漾-', $new_folder_name);
        $new_folder_name = str_ireplace('[IMiss爱蜜社]', 'IMiss爱蜜社-', $new_folder_name);
        $new_folder_name = str_ireplace('[XINGYAN星颜社]', 'XingYan星颜社-', $new_folder_name);
        $new_folder_name = str_ireplace('[XIAOYU语画界]', 'XiaoYu语画界-', $new_folder_name);

        $y = find_between($new_folder_name, '[', ']');
        if(!empty($y[0])) {
            $new_folder_name = trim(str_replace('['.$y[0].']', '', $new_folder_name));
        }

        // // Get model name and put into the 3rd position
        // // $tmp_arr = explode(' ', $new_folder_name);
        // // $m = $tmp_arr[2];
        // // $t = '《' . $tmp_arr[1] . '》';
        // // $tmp_arr[1] = $m;
        // // $tmp_arr[2] = $t;
        // // $new_folder_name = implode('-', $tmp_arr);

        $new_folder_name = str_replace('，', '-', $new_folder_name);
        $new_folder_name = str_replace('！', '-', $new_folder_name);
        $new_folder_name = str_replace('~', '', $new_folder_name);
        $new_folder_name = str_replace(' ', '-', $new_folder_name);
        $new_folder_name = str_replace('--', '-', $new_folder_name);

        // // $new_folder_name = str_ireplace('-VOL.', '-', $new_folder_name);
        // // //$new_folder_name = mapModelNames($new_folder_name);
        // // // $new_folder_name = str_replace('《', '-《', $new_folder_name);
        // // // $new_folder_name = str_replace('》', '》-', $new_folder_name);
        
        $a = explode('-', $new_folder_name);
        // if(!empty($a[2]) && !str_starts_with($a[2], '《') ) $a_tmp = '《'.$a[2].'》';
        $date = $a[1];
        if (isValidDate($date)) {
            unset($a[1]);
            $new_folder_name = implode('-', $a);
            $new_folder_name = $new_folder_name.'-'.$date;
        }

        // $b = explode('-', $new_folder_name);
        // $title = $b[2];
        // unset($b[2]);
        // $new_folder_name = implode('-', $b) . '-《' . $title.'》';
        
        // // $new_folder_name = str_replace('--', '-', $new_folder_name);
        $new_folder_name = str_ireplace('XiuRen秀人网-NO.', 'XiuRen秀人网-', $new_folder_name);
        $new_folder_name = str_ireplace('-VOL.', '-', $new_folder_name);
        
        echo 'rename('. $origin_full_path . ', ' . $path . '/' . $new_folder_name .  "\n\n";
        rename($origin_full_path, $path . '/' . $new_folder_name);    
    }
}

function isValidDate($date) {
    return preg_match('/^\d{4}\.\d{2}\.\d{2}$/', $date);
}

exit;