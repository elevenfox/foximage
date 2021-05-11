<?php

require'../bootstrap.inc';


set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

$pre = Config::get('db_table_prefix');

echo date('Y-m-d H:i:s') . ' - ' . " Start regenerating ... \n\n";
$start_time = time();

// truncate tags and tag_File
DB::$dbInstance->query('truncate table ' . $pre . 'tags');
DB::$dbInstance->query('truncate table ' . $pre . 'tag_File');

// read from Files
$total = File::getAllFilescount();
$itemsPerBatch = 1000;
$batches = ceil($total / $itemsPerBatch);
$x = 1;
for($i=1; $i <= $batches; $i++) {
    $Files = File::getFiles($i, $itemsPerBatch);
    foreach ($Files as $File) {
        echo date('Y-m-d H:i:s') . ' - ' . $x . " Processing for: ".$File['id']." ... \n";

        // calling File::save will update File with clean tags also save to tags and tag_File
        $res = File::save((object)$File);

        $result = empty($res) ? 'failed' : 'success';
        echo date('Y-m-d H:i:s') . ' - ' . " ----------------- $result  \n";

        $x++;
    }
}


$end_time = time();
$minutes = ceil(($end_time - $start_time) / 60);

echo "Total time: $minutes minutes \n\n";




