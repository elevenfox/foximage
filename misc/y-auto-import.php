<?php

$folder_full_path = isset($argv[1]) ? $argv[1] : null;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

function folderStatus($groups) {
    $status = [];
    foreach($groups as $k=>$v) {
        $status[$k] = count($v);
    }
    arsort($status);
    return $status;
}

function getDestFolder($album) {
    $mapping = [
        'ai-generated' => 'AI美女-',
        'aiss' => 'AISS爱丝-',
        'candy' => 'Candy网红馆-',
        'cosplay' => 'Cosplay-',
        'feilin' => 'FeiLin嗲囡囡-',
        //'girlt' => '',
        'huayang' => 'HuaYang花漾-',
        'imiss' => 'IMiss爱蜜社-',
        'japan' => '日本美女-',
        'jvid' => 'JVID-',
        'kelagirls' => 'KelaGirls克拉女神-',
        'korea' => '韩国美女-',
        'mfstar' => 'MFStar模范学院-',
        'miitao' => 'MiiTao蜜桃社-',
        'mistar' => 'MiStar魅妍社-',
        'mtcos' => 'MTCos喵糖映画-',
        'mygirl' => 'MyGirl美媛馆-', 
        //'qingdouke' => '',
        'tgod' => 'TGOD推女神-',
        'toutiao' => 'TouTiao头条女神-',
        //'ugirls' => 'UGirls尤果网-',  
        'ugirls_app-2000' => 'UGirlsApp尤果圈爱尤物-2',  
        //'xiaoyu' => 'XiaoYu语画界-',
        'xiaoyu1000' => 'XiaoYu语画界-1',
        'xingyan' => 'XingYan星颜社-',
        // 'xiuren6000' => 'XiuRen秀人网-6',
        'xiuren7000' => 'XiuRen秀人网-7',
        //'youmi' => 'YouMi尤蜜荟-',
        'youmi1000' => 'YouMi尤蜜荟-1',
        'youmi尤蜜' => 'YouMi尤蜜-',
        //'zac' => '',
    ];

    $dest = '';
    foreach($mapping as $k=>$v) {
        if(strpos($album, $v) !== false) {
            $dest = $k;
            break;
        }
    }
    return $dest;
}

$mailMsg = '';
$m  = "#################################################\n";
$m .=  date('Y-m-d H:i:s') . ' - ' . "Start auto importing albums .... \n";
$m .=  "#################################################\n";
echo $m;
$mailMsg .= $m;

$dst_base = '/mnt/extreme_ssd/jw-photos/';

$shuffle_alb = [
    'AI美女',
    'Cosplay',
    '韩国美女',
    '日本美女',
    'JVID',
];

$total = 12;
$dryrun = 0;

$path = $folder_full_path;
$scan = scandir($path);

$groups = [];
foreach($scan as $folder_name) {
    $origin_full_path = $path . '/'. $folder_name;
    
    if (is_dir($origin_full_path) && $folder_name!='.' && $folder_name!='..') {
        $a = explode('-', $folder_name);
        $pre = $a[0];
        $groups[$pre][] = $folder_name;
    }
}


$current_groups = folderStatus($groups);
// print_r($current_groups); exit;

# Pick up 20 folders from source and mix them
$albums = [];
while(count($albums) < $total && !empty($groups)) {
    foreach($current_groups as $key => $val) {
        if(in_array($key, $shuffle_alb)) {
            // Randomly pick one album
            $random_key = array_rand($groups[$key], 1);
            $alb = $groups[$key][$random_key];
            unset($groups[$key][$random_key]);
        }
        else {
            // Pick the first album for this source
            $alb = array_shift($groups[$key]);
        }
        if(!empty($alb)) $albums[] = $alb;

        // If a source has more than 100 albums, choose a 2nd one
        if($val > 100 && !in_array($key, $shuffle_alb)) {
            $alb = array_shift($groups[$key]);
            if(!empty($alb)) $albums[] = $alb;
        }
        // If it's xiuren, choose a 3rd one
        if($key == 'XiuRen秀人网' && !in_array($key, $shuffle_alb)) {
            $alb = array_shift($groups[$key]);
            if(!empty($alb)) $albums[] = $alb;
        }
        
        if(count($albums) >= $total) break;
    }
    $current_groups = folderStatus($groups);
}

$m  = date('Y-m-d H:i:s') . " -- Albums are going to be imported: \n";
$m .= print_r($albums, 1);
echo $m;
$mailMsg .= $m;

# Loop through the albums 
foreach($albums as $f) {
    $m  = date('Y-m-d H:i:s') . " ---- Start importing $f ... \n";
    echo $m;
    $mailMsg .= $m;

    // Find the dest folder based on album name
    $dest = getDestFolder($f);
    $dest_full = $dst_base . $dest . '/'; 

    // Specially handle some album
    if(str_starts_with($f, 'Cosplay-')) {
        $new_folder_name = str_ireplace('Cosplay-', '', $f);
        rename($path . '/'. $f, $path . '/' . $new_folder_name);  
        $f = $new_folder_name;
    }
    $origin_full_path = $path . '/'. $f;

   
    // Move album to dest folder
    $m  = date('Y-m-d H:i:s') . ' ------ ' . 'mv ' . $origin_full_path . ' ' . $dest_full ."\n";
    echo $m;
    $mailMsg .= $m;
    if($dryrun !== 1) {
        $output = shell_exec('mv ' . $origin_full_path . ' ' . $dest_full);
        echo "$output \n";
    }

    // Start importing
    $m  = date('Y-m-d H:i:s') . ' ------ php z_import_physical.php ' . $dest_full . $f . "\n";
    echo $m;
    $mailMsg .= $m;
    if($dryrun !== 1) {
        $output = shell_exec('php z_import_physical.php ' . $dest_full . $f);
        echo "$output \n";
    }
}

// Sync to prod
$m  = date('Y-m-d H:i:s') . ' ------ php z_sync_to_prod.php' . "\n";
if($dryrun !== 1) {
    $output = shell_exec('php z_sync_to_prod.php');
    $m .= $output . "\n";
}
echo $m;
$mailMsg .= $m;

mail("elevenfox11@gmail.com","Tuzac import albums", $mailMsg);

echo "\n";
echo "\n";
echo "\n";