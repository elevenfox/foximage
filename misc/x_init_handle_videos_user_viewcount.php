<?php

require'../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

$pre = Config::get('db_table_prefix');

$res = DB::$dbInstance->getRows("select * from ".$pre."videos where view_count is null or user_name =''");
$i = 1;
foreach ($res as $video) {

    echo $i . ' - process video id: ' . $video['id'] . " ... \n";

    $sql = 'update '.$pre.'videos v
left join field_data_field_video_source_url vs on field_video_source_url_value = v.source_url
left join node n on n.nid=vs.entity_id
left join users u on u.uid=n.uid
left join node_counter c on c.nid = n.nid
set v.user_name = u.name, v.view_count=c.totalcount
where v.id = ' . $video['id'];
    echo $sql . "\n";
    DB::$dbInstance->query($sql);

    $i++;
}


$total = $i;
echo "Totally processed " . $total . " videos \n";
