<?php
require_once '../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');

echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start re-handling tags for tujigu photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";

$num = 0;

// Get all rows which source is tujigu
$query = 'SELECT * FROM '. $pre . 'files where source ="tujigu" and id>18523 order by id';

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        // Get title, then get org_name
        $org_name = explode('_', $row['title'])[0];

        //  Get all tags
        $tags = explode(',', $row['tags']);

        // Check if org_name is in tags, if not, add org_name as a tag
        if(!in_array($org_name, $tags)) {
            $tags[] = $org_name;
        }
        
        // Build file obj
        $row['tags'] = implode(',', $tags);
        unset($row['created']);
        unset($row['modified']);

        $fileObj = (object)$row;

        $fileObj->images = explode(',', $row['filename']);
           
        $res = FILE::save($fileObj);
        if($res) {
            echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - resaving: id=" . $row['id'] .', '. $row['title'] . " \n";  
            $num++;
        }
    }
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $num photos \n";
echo "-----------------------------------\n\n";
