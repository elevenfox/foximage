<?php
$sources = array(
	// Tujigu 
    'tujigu.com' => array(
        'key_class_name' => 'hezi',
        'keywords_of_file_link' => '/a/',
        'tag_links' => array(
            'https://www.tujigu.com/zhongguo/#page.html',			
        ),
		'start_page_num' => 2,
    ),
);


require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

###################### Define variables ################

$max_urls_per_source = isset($argv[1]) ? (int)$argv[1] : null;
$max_urls_per_source = empty($max_urls_per_source) ? 500 : $max_urls_per_source;

$prod_api = Config::get('prod_api_url');
$site_name = Config::get('theme');
$default_start_page = 1;
$existed_files = 0;
$total_parsed_urls = 0;

###################### End of define variables ################



###################### Define functions ################
function file_db_exist($url) {
	$res = File::getFileBySourceUrl($url);

	if(!$res) {
		$res = File::getIgnoredFileBySourceUrl($url);
	}

	return !empty($res);
}

function get_file_links_in_page($link, $page_number, $key_class_name, $keywords_of_file_link, $file_urls) {
	global $max_urls_per_source, $existed_files, $total_parsed_urls;
	$link = str_replace('#page', $page_number, $link);
	echo "... processing page: $link ... \n";
	$url_info = parse_url($link);
	$content = curl_call($link);
	$dom = new DOMDocument();
	@$dom->loadHTML($content);
	$finder = new DomXPath($dom);
	$elements = $finder->query("//*[contains(@class, '$key_class_name')]");
	foreach ($elements as $element) {
		foreach($element->getElementsByTagName('a') as $link) {
			foreach($link->attributes as $attr) {
				if($attr->name == 'href' && stristr($attr->value, $keywords_of_file_link)!==false) {
					if(stripos($attr->value, 'http') === 0) {
						$s_url = $attr->value;
					}
					else {
						$s_url = $url_info['scheme'] . '://'. $url_info['host'] . $attr->value;
					}
					if(!file_db_exist($s_url)) {
						array_push($file_urls ,$s_url);
						$file_urls = array_unique($file_urls);
						if(count($file_urls) >= $max_urls_per_source) {
							break 3;
						}
					}
					else {
						$existed_files++;
					}
					$total_parsed_urls++;
				}
			}
		}
	}
	return $file_urls;
}
###################### end of define functions ################


$mailMsg = '';

$m  = "#####################################\n";
$m .= date('Y-m-d H:i:s') . ' - ' . "Start importing files .... \n";
$m .= date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
$m .= "#####################################\n";
echo $m;
$mailMsg .= $m;

$urls = array();
// Get urls first
foreach ($sources as $source) {
	$urls_of_this_source = array();
	$start_page = $source['start_page_num'];
	$page_processed = 0;
	while(count($urls_of_this_source) < $max_urls_per_source) {
		shuffle($source['tag_links']);
		foreach($source['tag_links'] as $tag_link) {
			$urls_of_this_source = get_file_links_in_page($tag_link, $start_page, $source['key_class_name'], $source['keywords_of_file_link'], $urls_of_this_source);
			if(count($urls_of_this_source) >= $max_urls_per_source) {
				break 2;
			}
		}
		$start_page++;
		$page_processed++;
		if($page_processed > 30) {
			break 1;
		}
	}

	$urls = array_merge($urls, $urls_of_this_source);
}

shuffle($urls);

$m  = "-----------------------------------\n";
$m .= date('Y-m-d H:i:s') . ' - ' . 'Total url parsed: ' . $total_parsed_urls . ', existed_files: ' . $existed_files . ", finial get urls: ". count($urls) ."\n";
$m .=  "-----------------------------------\n";
echo $m;
$mailMsg .= $m;

// Start importing to current (dev) site: getting contents of file page and parsing and saving
$i = 1;
$success = 0;
$failed = 0;
foreach ($urls as $url) {
	echo date('Y-m-d H:i:s') . ' - ' . "$i - importing: $url \n";

	// call xparser server
    $api_server = Config::get('api_server');
    $imv_url = $api_server . '?ac=import_file&url=' . urlencode($url);
    echo date('Y-m-d H:i:s') . ' - ' . "calling: $imv_url \n";
	$res = json_decode(curl_call($imv_url));
	echo date('Y-m-d H:i:s') . ' - ' . "---- status: ".$res->status.", msg: ".$res->msg." \n\n";
	if($res->status) {
		$success++;
	}
	else {
		$failed++;
	}
	$i++;
}

$m = date('Y-m-d H:i:s') . ' - ' . "In local totally have " . ($i-1) . " files, successfully imported $success, failed $failed \n\n";
echo $m;
$mailMsg .= $m;

// Sync to prod files table
// $m = date('Y-m-d H:i:s') . ' - ' . "Start to sync new files to prod...\n";
// echo $m;
// $mailMsg .= $m;
// $max_file_id_local = File::getMaxFileId();
// $max_file_id_prod = curl_call($prod_api . '?ac=get_max_file_id');
// $m = date('Y-m-d H:i:s') . ' - ' . "Local max file id = $max_file_id_local, prod max file id = $max_file_id_prod\n";
// echo $m;
// $mailMsg .= $m;
// $i = 0;
// $success = 0;
// $failed = 0;
// if($max_file_id_prod < $max_file_id_local) {
// 	$sql = 'select * from '.Config::get('db_table_prefix').'files where id > ' . $max_file_id_prod;
// 	$res = DB::$dbInstance->getRows($sql);
// 	foreach ($res as $fileObj) {
// 		$i++;
// 		$res2 = curl_call($prod_api.'?ac=save_file_data_and_node', 'post', array('obj'=>json_encode($fileObj)));
// 		$res2 == '1' ? $success++ : $failed++;
// 		$result = $res2?'1':'0';

//         $m = date('Y-m-d H:i:s') . ' - ' . "$i - sync to prod: ".$fileObj['source_url']." -- $result\n";
//         echo $m;
//         $mailMsg .= $m;
// 	}
// }

// $m  = "-----------------------------------\n";
// $m .= date('Y-m-d H:i:s') . ' - ' . "Totally syncing $i files, success $success, failed $failed \n";
// $m .= "-----------------------------------\n\n";
// echo $m;
// $mailMsg .= $m;

// mail("elevenfox11@gmail.com","$site_name import files", $mailMsg);

