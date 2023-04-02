<?php

require'../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);


###################### Define variables ################

$base = Config::get('db_table_base_prefix');
$limit = 100;
$total = 0;

$pre = isset($argv[1]) ? $argv[1] : null;
if(empty($pre)) {
    echo "---- Must have prefix! \n";
    exit;
}


// Remove deleted files first
echo date('Y-m-d H:i:s') . ' - ' . "Start to remove deleted files in $pre ...\n";
$sql = "SELECT p.id FROM `$pre` as p left join ".$base."files jf on jf.id=p.file_id where jf.id is null";
$res = DB::$dbInstance->getRows($sql);
if(count($res)) {
    foreach($res as $r) {
        $query = "delete from $pre where id=" . $r['id'];
        DB::$dbInstance->query($query);
    }
}


echo date('Y-m-d H:i:s') . ' - ' . "Start to sync new files to $pre ...\n";

// Get $max_base_file_id
$max_base_file_id = File::getMaxBaseFileId();

// Get $max_pre_file_id
$max_pre_file_id = get_max_pre_file_id();

// 递归同步rows，每次$limit rows
sync_files($max_pre_file_id);

echo date('Y-m-d H:i:s') . ' - ' . " -- Totally sync ".$total." files to $pre ...\n\n";


function sync_files($max_pre_file_id) {
    global $base, $pre, $limit, $total, $max_base_file_id;

    // if $max_pre_file_id < $max_base_file_id
    if($max_pre_file_id < $max_base_file_id) {
        // get max to 20 rows from $max_pre_file_id in random order
        $query = 'select id from '.$base.'files where id > '.$max_pre_file_id.' ORDER BY id LIMIT '.$limit;
        $res = DB::$dbInstance->getRows($query);
        $ids = [];
        if(count($res)) {
            foreach($res as $r) {
                $ids[] = $r['id'];
            }
        }
        shuffle($ids);
        echo date('Y-m-d H:i:s') . ' - ' . " -- getting ".count($ids)." files ...\n";
        echo print_r($ids,1) . "\n";

        // get random users
        $query = 'select name from '.$base.'users ORDER BY RAND() LIMIT '.$limit;
        $res = DB::$dbInstance->getRows($query);
        $users = [];
        if(count($res)) {
            foreach($res as $r) {
                $users[] = $r['name'];
            }
        }

        // insert new rows to pre_table
        foreach($ids as $id) {
            $query = 'insert into '.$pre.' (file_id, user_name) values('.$id.', "'.$users[array_rand($users)].'")';
            DB::$dbInstance->query($query);
        }
        echo date('Y-m-d H:i:s') . ' - ' . " -- Successfully sync ".count($ids)." files to $pre ...\n\n";
        $total += count($ids);
        $max_pre_file_id = get_max_pre_file_id();
        sync_files($max_pre_file_id);
    }
    else {
        return;
    }
}

function get_max_pre_file_id() {
    global $pre;
    $res = DB::$dbInstance->getRows('select max(file_id) as maxId from ' . $pre);
    $max_pre_file_id = $res[0]['maxId'] ? $res[0]['maxId'] : 0;
    return $max_pre_file_id;
}
