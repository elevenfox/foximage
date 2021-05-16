<?php

require'../bootstrap.inc';


set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

$pre = Config::get('db_table_prefix');

echo date('Y-m-d H:i:s') . ' - ' . " Start shuffling photos ... \n\n";
$start_time = time();

$res = DB::$dbInstance->query('UPDATE ' . $pre . 'files set rand_id = FLOOR( (RAND() * 1000000) + 1 )');
if($res) {
    echo "---- Done. \n\n";
}
else {
    echo "---- failed. \n\n";
}

$end_time = time();
$total = $end_time - $start_time;

$total = empty($total) ? 'less than 1 ' : $total;
echo "Total time: $total seconds \n\n";




