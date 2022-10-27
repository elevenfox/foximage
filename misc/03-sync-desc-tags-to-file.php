<?php

require'../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);


###################### Define variables ################

$file_root = Config::get('file_root');
$pre = Config::get('db_table_prefix');

$file_ids = isset($argv[1]) ? $argv[1] : null;

if(empty($file_ids)) {
    echo "---- Must have at least one file id as the param! \n";
    echo "---- Or <all> to sync all. \n";
    exit;
}

###################### End of define variables ################
function save_desc_tags_to_file($row) {
    // Build physical path: Use <file_root>/source/<file_title>/ as file structure
    $physical_path = buildPhysicalPath($row);
    // If folder not exist, create the folder
    if(!is_dir($physical_path)) {
        $res = mkdir($physical_path, 0755, true);
        if(!$res) {
            error_log(" ----- failed to create directory: " . $physical_path );
        }
    }
    $fullDescName = $physical_path . '/desc.txt';
    $fullTagsName = $physical_path . '/tags.txt';

    // Save field description to desc.txt, and tags to tags.txt in the full path
    echo date('Y-m-d H:i:s') . ' ----- saving ' . $fullDescName . " \n";
    file_put_contents($fullDescName, html_entity_decode($row['description']));
    echo date('Y-m-d H:i:s') . ' ----- saving ' . $fullTagsName . " \n";
    file_put_contents($fullTagsName, $row['tags']);
}



echo date('Y-m-d H:i:s') . ' - ' . " Start syncing ... \n\n";
$start_time = time();

$album_processed = 0;

// Get ids from param, use "all" for sync-all
if($file_ids === 'all') {
    $query = 'SELECT * FROM '. $pre . 'files';
    $res = DB::$dbInstance->getRows($query);
    if(count($res) >0) {
        // Loop to read each row by id
        foreach ($res as $row) {
            $album_processed++;
            echo date('Y-m-d H:i:s') . ' - ' . $album_processed . " --- processing $id \n";    
            save_desc_tags_to_file($row);
        }
    }
}
else {
    $ids = explode(',', $file_ids);

    // Loop to read each row by id
    foreach($ids as $id) {
        $album_processed++;
        echo date('Y-m-d H:i:s') . ' - ' . $album_processed . " --- processing $id \n";
        $row = File::getFileByID($id);
        save_desc_tags_to_file($row);
    }
}




echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums \n";
echo "-----------------------------------\n\n";