<?php

require'../bootstrap.inc';


set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

$pre = Config::get('db_table_prefix');

echo date('Y-m-d H:i:s') . ' - ' . " Start shuffling photos ... \n\n";
$start_time = time();

$new_items = rand(10,15);

//$res = DB::$dbInstance->query('UPDATE ' . $pre . 'files set rand_id = FLOOR( (RAND() * 1000000) + 1 )');

// The approach is get max_rand_id, then get random numbers of items as newer, append them rand_id to max_rand_id
$res = DB::$dbInstance->getRows('select MAX(rand_id) as max_rand_id from ' . $pre . 'files');
if(!empty($res[0]['max_rand_id'])) {
    $max_rand_id = $res[0]['max_rand_id'];

    $res = DB::$dbInstance->query('UPDATE ' . $pre . 'files set rand_id = '.$max_rand_id.' + FLOOR( (RAND() * '.$new_items.') + 1 )  
                                    where 
                                    rand_id < '. $max_rand_id/2 . ' 
                                    order by rand_id desc 
                                    limit '.$new_items.';
    ');

    if(!empty($res)) {
        echo "---- Done adding {$new_items} albums. \n\n";
    }
    else {
        echo "---- failed updating in db. \n\n";    
    }
}
else {
    echo "---- failed to get max_rand_id. \n\n";
}

$end_time = time();
$total = $end_time - $start_time;

$total = empty($total) ? 'less than 1 ' : $total;
echo "Total time: $total seconds \n\n";





