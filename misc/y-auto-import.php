<?php

$folder_full_path = isset($argv[1]) ? $argv[1] : null;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
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
        //'cosplay' => '',
        'feilin' => 'FeiLin嗲囡囡-',
        //'girlt' => '',
        'huayang' => 'HuaYang花漾-',
        'imiss' => 'IMiss爱蜜社-',
        //'japan' => '',
        'kelagirls' => 'KelaGirls克拉女神-',
        //'korea' => '',
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
        'xiaoyu' => 'XiaoYu语画界-',
        //'xingyan' => 'XingYan星颜社-',
        'xiuren6000' => 'XiuRen秀人网-6',
        'youmi' => 'YouMi尤蜜荟-',
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

echo  "#################################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start auto importing albums .... \n";
echo  "#################################################\n";

$dst_base = '/mnt/extreme_ssd/jw-photos/';

$total = 20;

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
        $alb = array_shift($groups[$key]);
        if(!empty($alb)) $albums[] = $alb;
        if($val > 50) {
            $alb = array_shift($groups[$key]);
            if(!empty($alb)) $albums[] = $alb;
        }
        if(count($albums) >= $total) break;
    }
    $current_groups = folderStatus($groups);
}

echo date('Y-m-d H:i:s') . " -- Albums are going to be imported: \n";
print_r($albums);

# Loop through the albums 
foreach($albums as $f) {
    echo date('Y-m-d H:i:s') . " ---- Start importing $f ... \n";
    $origin_full_path = $path . '/'. $f;

    // Find the dest folder based on album name
    $dest = getDestFolder($f);
    $dest_full = $dst_base . $dest . '/'; 

    // Move album to dest folder
    echo date('Y-m-d H:i:s') . ' ------ ' . 'mv ' . $origin_full_path . ' ' . $dest_full ."\n";
    $output = shell_exec('mv ' . $origin_full_path . ' ' . $dest_full);
    echo "<pre>$output</pre>";

    // Start importing
    echo date('Y-m-d H:i:s') . ' ------ php z_import_physical.php ' . $dest_full . $f . "\n";
    $output = shell_exec('php z_import_physical.php ' . $dest_full . $f);
    echo "<pre>$output</pre>";

    // Sync to prod
    echo date('Y-m-d H:i:s') . ' ------ php z_sync_to_prod.php' . "\n";
    $output = shell_exec('php z_sync_to_prod.php');
    echo "<pre>$output</pre>";
}

echo "\n";
echo "\n";
echo "\n";