<?php
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
define('DRUPAL_ROOT', getcwd().'/../../');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$count = isset($argv[1]) ? (int)$argv[1] : null;
$count = empty($count) ? 50 : $count;

$count_max = isset($argv[2]) ? (int)$argv[2] : null;
if(!empty($count_max)) {
    $count = rand($count, $count_max);
}

chdir('../rname');
require('./mudnames.php');

function create_niu_user() {
    $file = 'random';
    $name_org = Mudnames::generate_name_from($file);
    $name_org2 = Mudnames::generate_name_from($file);

    // Build name
    $number = random_one(array('',11,12,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,'001','002','1028','0718'));
    $in = random_one(array('_', '-', '.', ''));
    $name = $name_org . random_one(array($in . $number, $name_org2, ''));

    // Build domain name
    $ext = random_one(array('com','com','com','com','com','com','com', 'net', 'uk', 'co', 'cn', 'org', 'jp'));
    $domain = Mudnames::generate_name_from($file) . '.' . $ext;
    $known_domains = array('google.com', 'yahoo.com', 'aol.com', 'mail.com');
    $k_domain = $known_domains[array_rand($known_domains)];
    $domain_name = random_one(array($domain, $k_domain));

    // Build email name
    $name2 = Mudnames::generate_name_from($file);
    $email_name = random_one(array($name_org, $name_org, $name_org, $name_org, $name, $name, $name, $name2, $name2.$in.$number));
    $email_name = str_replace(' ', $in, $email_name);

    $new_user = array(
      'name' => $name,
      'pass' => uniqid(),
      'mail' => $name.'@'.$domain,
      'status' => 1,
      'init' => $email,
      'roles' => array(
        DRUPAL_AUTHENTICATED_RID => 'authenticated user'
      ),
    );

    // The first parameter is sent blank so a new user is created.
    user_save('', $new_user);

    return $new_user;
}

function random_one($array) {
    return $array[array_rand($array)];
}

$i = 1;
for($i = 1; $i<=$count; $i++) {
    $user = create_niu_user();
    echo "$i - Create user: name = {$user['name']}, email={$user['mail']}\n";
}
