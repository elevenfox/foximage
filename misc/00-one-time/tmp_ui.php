<?php

require('../../bootstrap.inc.php');

$new_folder = empty($_REQUEST['new_folder']) ? '' : $_REQUEST['new_folder'];
$ori_folder = empty($_REQUEST['ori_folder']) ? '' : $_REQUEST['ori_folder'];

$new_path = '/home/eric/work/000/tgod/2016/';
$origin_path = '/home/eric/work/000/推女神/';

echo '<div><a href="http://local.tuzac.com/misc/00-one-time/tmp_ui.php">刷新</a></div>';

if(!empty($new_folder) && !empty($ori_folder)) {
    $org_name = '推女神';
    $org_name_en = 'TGOD';

    $z_arr = explode('-', $new_folder);
    $date = $z_arr[1];

    echo '<pre>';
    echo "New Folder: $new_folder\n";
    echo "Ori Folder: $ori_folder\n";
    // sync folder
    $folder_info['full_path'] = $origin_path  . '/' . $ori_folder;
    $l_ori_folder = strtolower($ori_folder);
    $l_ori_folder = sanatizeCN($l_ori_folder);
    $l_ori_folder = str_replace('_-','_',$l_ori_folder);
    $l_ori_folder = str_replace('---','-',$l_ori_folder);
    $l_ori_folder = str_replace('--','-',$l_ori_folder);
    $folder_info['name'] = $l_ori_folder;

    $l_ori_folder = mapModelNames($l_ori_folder);
    
    $xx = find_between($l_ori_folder, $org_name.'_', '-');
    $folder_info['model'] = my_mb_ucfirst(sanatizeCN($xx[0]));       
    $folder_info['model'] = str_replace('YUmi尤美', 'Yumi尤美', $folder_info['model']);


    if(strpos($ori_folder, '《') !== false) {
        $yy = find_between($ori_folder, '《', '》');
        $main = empty($yy[0]) ? '' : trim($yy[0], '-');
    }
    else {
        $yy = find_between($ori_folder, '---', '-');
        $main = empty($yy[0]) ? '' : trim($yy[0], '-');
    }
    $main = empty($main) ? '' : '《' .my_mb_ucfirst(sanatizeCN($main))  . '》';
    $folder_info['main'] = $main;

    //------------------------
    $n_full_path = $new_path . '/' . $new_folder;
    // copy desc.txt and tags.txt from origin folder
    $desc_str = file_get_contents($folder_info['full_path'] . "/desc.txt");
    $desc_str = str_replace(' 生日','生日', $desc_str);
    $pos = strpos($desc_str, '生日');
    if($pos !== false) {
        $c = $desc_str[$pos-1];
        if ($c != "\n" && $c != "\rn" && $c != "\r") {
            $desc_str = str_replace('生日',"\n生日", $desc_str);
        }
    }
    $desc_str = str_replace(' 罩杯','罩杯', $desc_str);
    $pos = strpos($desc_str, '罩杯');
    if($pos !== false) {
        $c = $desc_str[$pos-1];
        if ($c != "\n" && $c != "\rn" && $c != "\r") {
            $desc_str = str_replace('罩杯',"\n罩杯", $desc_str);
        }
    }
    echo "Processing " . $n_full_path . "/desc.txt \n";
    echo $desc_str . "\n";
    file_put_contents($n_full_path.'/desc.txt', $desc_str);

    // Gen new tags
    $tags_str = file_get_contents($folder_info['full_path'] . "/tags.txt");
    $tags = explode(',', $tags_str);
    if(! in_array($org_name_en, $tags) && ! in_array(strtolower($org_name_en), $tags)) {
        $tags[] = $org_name_en;
    }
    if(! in_array( $org_name, $tags ) ) {
        $tags[] = $org_name;
    }
    if(! in_array( $folder_info['model'], $tags ) ) {
        $tags[] = $folder_info['model'];
    }
    $new_tags_str = implode(',', $tags);
    $new_tags_str = str_replace(strtolower($org_name_en), $org_name_en, $new_tags_str);
    echo "---- New tags: $new_tags_str \n";
    // create tags.txt
    echo "file_put_contents($n_full_path/tags.txt, $new_tags_str) \n";
    file_put_contents($n_full_path.'/tags.txt', $new_tags_str);

    // create a new empty dl.txt in current folder
    //echo "file_put_contents($n_full_path/dl.txt, '') \n";
    file_put_contents($n_full_path.'/dl.txt', '');

    // rename current folder to the origin folder name
    if(!empty($folder_info['main'] )) {
        $new_folder_name = $org_name_en.$org_name.'-'. $date . '-'.$folder_info['model'] . '-' . $folder_info['main'];
        echo "rename $n_full_path to $new_path/$new_folder_name\n";
        rename($n_full_path, $new_path . '/'.$new_folder_name);
        echo "delete ori-folder: rm -rf '".$folder_info['full_path']."' \n";
        system("rm -rf '".$folder_info['full_path']."'");
    }
    echo '</pre>';
}


$scan_s = scandir($new_path);
echo '<div id="new" style="width:45%; display: inline-block; vertical-align: top; border: 1px solid #666">';
foreach($scan_s as $o_folder_name) {
    $o_full_path = $new_path . '/'. $o_folder_name;
    if (is_dir($o_full_path) && $o_folder_name!='.' && $o_folder_name!='..') {
        echo '<div><input type="radio" name="new_folder" value="'.$o_folder_name.'"><span>'.$o_folder_name.'</span></div>';
    }
}
echo '</div>';

$scan = scandir($origin_path);
echo '<div id="tujigu" style="width:45%; display: inline-block; border: 1px solid #666; margin-left:10px">';
foreach($scan as $folder_name) {
    $origin_full_path = $origin_path . '/'. $folder_name;
    if (is_dir($origin_full_path) && $folder_name!='.' && $folder_name!='..') {
        echo '<div><input type="radio" name="ori_folder" value="'.$folder_name.'" onclick="syncFolder(this.value)"><span>'.$folder_name.'</span></div>';
    }
}
echo '</div>';
echo <<<EOF
<script>
function syncFolder(oriFolder) {
    var newFolder = document.querySelector('input[name="new_folder"]:checked').value;
    var path = window.location.href.split('?')[0]
    window.location.href = path + '?new_folder=' + newFolder + '&ori_folder=' + oriFolder;
}
</script>
EOF;



function sanatizeCN($string) {
    $string = str_replace('《','-',$string);
    $string = str_replace('》','-',$string);
    $string = str_replace('(','-',$string);
    $string = str_replace(')','-',$string);
    $string = str_replace('，','-',$string);
    $string = str_replace('、','-',$string);
    $string = str_replace('&','-',$string);

    return $string;
}
function my_mb_ucfirst($str) {
    $new_str = '';
    $do_it = true;
    for ($i = 0; $i < strlen($str); $i++) {
        if(ord($str[$i]) >=97 && ord($str[$i]) <=122) {
            if($do_it) {
                $new_str[$i] = strtoupper($str[$i]);
                $do_it = false;
            }
            else {
                $new_str[$i] = $str[$i];
            }
        }
        else {
            $new_str[$i] = $str[$i];
        }

    }
    return $new_str;
}