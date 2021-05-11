<?php
// --- tube8 and pornhd are using IP to verify video, not easy to hack...
// 'tube8.com' => array(
// 	'key_class_name' => 'video_title',
// 	'keywords_of_video_link' => '/www.tube8.com/',
// 	'tag_links' => array(
// 		'https://www.tube8.com/cat/amateur/6/page/#page/',
// 		'https://www.tube8.com/cat/anal/13/page/#page/',
// 		'https://www.tube8.com/cat/anal/13/page/#page/',
// 		'https://www.tube8.com/cat/asian/12/page/#page/',
// 		'https://www.tube8.com/cat/blowjob/7/page/#page/',
// 		'https://www.tube8.com/cat/hd/22/page/#page/',
// 		'https://www.tube8.com/cat/hentai/24/page/#page/',
// 		'https://www.tube8.com/cat/indian/21/page/#page/',
// 		'https://www.tube8.com/cat/latina/14/page/#page/',
// 		'https://www.tube8.com/cat/lesbian/8/page/#page/',
// 		'https://www.tube8.com/cat/milf/23/page/#page/',
// 		'https://www.tube8.com/cat/strip/10/page/#page/',
// 		'https://www.tube8.com/porntags/japanese/?page=#page',
// 		'https://www.tube8.com/porntags/riding/?page=#page',
// 		'https://www.tube8.com/porntags/pussies/?page=#page',
// 		'https://www.tube8.com/porntags/masturbate/?page=#page',
// 		'https://www.tube8.com/porntags/dildo/?page=#page',
// 		'https://www.tube8.com/porntags/cumshot/?page=#page',
// 		'https://www.tube8.com/porntags/blonde/?page=#page',
// 		'https://www.tube8.com/porntags/facials/?page=#page',
// 		'https://www.tube8.com/porntags/queen/?page=#page',
// 	),
// ),
// 'pornhd.com' => array(
// 	'key_class_name' => 'thumb',
// 	'keywords_of_video_link' => '/videos/',
// 	'tag_links' => array(
// 		'https://www.pornhd.com/category/blowjob-videos?page=#page',
// 		'https://www.pornhd.com/category/cumshot-videos?page=#page',
// 		'https://www.pornhd.com/category/pussy-licking-videos?page=#page',
// 		'https://www.pornhd.com/category/brunette-videos?page=#page',
// 		'https://www.pornhd.com/category/japanese-videos?page=#page',
// 		'https://www.pornhd.com/category/anal-videos?page=#page',
// 		'https://www.pornhd.com/category/school-videos?page=#page',
// 		'https://www.pornhd.com/category/milf-videos?page=#page',
// 		'https://www.pornhd.com/category/blonde-videos?page=#page',
// 		'https://www.pornhd.com/category/threesome-videos?page=#page',
// 		'https://www.pornhd.com/category/group-videos?page=#page',
// 		'https://www.pornhd.com/category/solo-girl-videos?page=#page',
// 		'https://www.pornhd.com/category/interracial-videos?page=#page',
// 		'https://www.pornhd.com/category/natural-tits-videos?page=#page',
// 		'https://www.pornhd.com/category/masturbation-videos?page=#page',
// 		'https://www.pornhd.com/category/facials-videos?page=#page',
// 		'https://www.pornhd.com/category/doggystyle-videos?page=#page',
// 		'https://www.pornhd.com/category/shaved-videos?page=#page',
// 		'https://www.pornhd.com/category/toys-videos?page=#page',
// 		'https://www.pornhd.com/category/riding-videos?page=#page',
// 	),
// ),
//'hclips.com' => array(
//  'key_class_name' => 'thumb',
//  'keywords_of_video_link' => '/videos/',
//  'tag_links' => array(
//    'http://www.hclips.com/categories/amateur/#page/',
//    'http://www.hclips.com/categories/asian/#page/',
//    'http://www.hclips.com/categories/big-tits/#page/',
//    'http://www.hclips.com/categories/blonde/#page/',
//    'http://www.hclips.com/categories/blowjob/#page/',
//    'http://www.hclips.com/categories/chaturbate/#page/',
//    'http://www.hclips.com/categories/doggy-style/#page/',
//    'http://www.hclips.com/categories/masturbation/#page/',
//    'http://www.hclips.com/categories/panties-and-bikini/#page/',
//    'http://www.hclips.com/categories/stockings/#page/',
//  ),
//),

// ---- Xhamster start using ip based verification, give up for now
//	'xhamster.com' => array(
//		'key_class_name' => 'video',
//		'keywords_of_video_link' => '/videos/',
//		'tag_links' => array(
//			'https://xhamster.com/categories/big-boobs/#page',
//			'https://xhamster.com/categories/blowjobs/#page',
//			'https://xhamster.com/categories/cartoons/#page',
//			'https://xhamster.com/categories/japanese/#page',
//			'https://xhamster.com/categories/webcams/#page',
// 		    'https://xhamster.com/categories/masturbation/#page',
//		),
//	),

// ---- Give up pornhub, the hls using cors, no idea how to hack this
//'pornhub.com' => array(
//    'key_class_name' => 'videoblock',
//    'keywords_of_video_link' => '/view_video.php?',
//    'tag_links' => array(
//        'https://www.pornhub.com/categories/hentai?page=#page',
//        'https://www.pornhub.com/video?c=111&page=#page', // Japanese
//        'https://www.pornhub.com/video?c=86&page=#page', // Catoon
//        'https://www.pornhub.com/video?c=10&page=#page', // Bandage
//        'https://www.pornhub.com/video?c=8&page=#page', // Big tits
//        'https://www.pornhub.com/video?c=61&page=#page', // Webcam
//        'https://www.pornhub.com/video?c=1&page=#page', // Asian
//        'https://www.pornhub.com/video?c=13&page=#page', // Blowjob
//        'https://www.pornhub.com/hd?page=#page',
//    ),
//),
$sources = array(
    'youjizz.com' => array(
        'key_class_name' => 'video-thumb',
        'keywords_of_video_link' => '/videos/',
        'tag_links' => array(
            'https://www.youjizz.com/random',
			'https://www.youjizz.com/search/japanese-#page.html',
            'https://www.youjizz.com/search/blonde-#page.html',
            'https://www.youjizz.com/search/brunette-#page.html',
            'https://www.youjizz.com/search/brown%20hair-#page.html',
            'https://www.youjizz.com/search/college-#page.html',
            'https://www.youjizz.com/search/highdefinition-#page.html',
            'https://www.youjizz.com/search/lesbian-#page.html',
            'https://www.youjizz.com/search/outdoors-#page.html',
            'https://www.youjizz.com/search/pornstars-#page.html',
            'https://www.youjizz.com/most-popular/#page.html',
            'https://www.youjizz.com/tags/18-#page.html',
            'https://www.youjizz.com/tags/anal-#page.html',
            'https://www.youjizz.com/tags/anime-#page.html',
            'https://www.youjizz.com/tags/blowjob-#page.html',
            'https://www.youjizz.com/tags/cartoon-#page.html',
            'https://www.youjizz.com/tags/cowgirl-#page.html',
            'https://www.youjizz.com/tags/doggystyle-#page.html',
        ),
    ),
    'redtube.com' => array(
        'key_class_name' => 'video_thumb_wrap',
        'keywords_of_video_link' => '/',
        'tag_links' => array(
          'https://www.redtube.com/redtube/blonde?page=#page',
			'https://www.redtube.com/redtube/bigtits?page=#page',
            'https://www.redtube.com/redtube/blowjob?page=#page',
            'https://www.redtube.com/redtube/anal?page=#page',
            'https://www.redtube.com/redtube/japanese?page=#page',
            'https://www.redtube.com/redtube/webcam?page=#page',
//          'https://www.redtube.com/redtube/stockings?page=#page',
            'https://www.redtube.com/redtube/hd?page=#page',
            'https://www.redtube.com/redtube/hentai?page=#page',
        ),
    ),
//    'youporn.com' => array(
//        'key_class_name' => 'video-box',
//        'keywords_of_video_link' => '/watch/',
//        'tag_links' => array(
//            'https://www.youporn.com/category/71/japanese/?page=#page',
//            'https://www.youporn.com/category/23/hentai/?page=#page',
//            'https://www.youporn.com/category/103/cartoon/?page=#page',
//            //'https://www.youporn.com/category/32/teen/?page=#page',
//            'https://www.youporn.com/category/9/blowjob/?page=#page',
//            'https://www.youporn.com/category/61/romantic/?page=#page',
//            'https://www.youporn.com/category/30/public/?page=#page',
//            //'https://www.youporn.com/category/48/european/?page=#page',
//            //'https://www.youporn.com/category/29/milf/?page=#page',
//            'https://www.youporn.com/category/7/big-tits/?page=#page',
//            //'https://www.youporn.com/category/51/blonde/?page=#page',
//            //'https://www.youporn.com/category/52/brunette/?page=#page',
//            'https://www.youporn.com/category/47/straight-sex/?page=#page',
//            //'https://www.youporn.com/category/1/amateur/?page=#page',
//        ),
//    ),

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
$default_start_page = 8;
$existed_videos = 0;
$total_parsed_urls = 0;

###################### End of define variables ################



###################### Define functions ################
function video_db_exist($url) {
	$res = Video::getVideoBySourceUrl($url);
	return !empty($res);
}

function get_video_links_in_page($link, $page_number, $key_class_name, $keywords_of_video_link, $video_urls) {
	global $max_urls_per_source, $existed_videos, $total_parsed_urls;
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
				if($attr->name == 'href' && stristr($attr->value, $keywords_of_video_link)!==false) {
					if(stripos($attr->value, 'http') === 0) {
						$s_url = $attr->value;
					}
					else {
						$s_url = $url_info['scheme'] . '://'. $url_info['host'] . $attr->value;
					}
					if(!video_db_exist($s_url)) {
						array_push($video_urls ,$s_url);
						$video_urls = array_unique($video_urls);
						if(count($video_urls) >= $max_urls_per_source) {
							break 3;
						}
					}
					else {
						$existed_videos++;
					}
					$total_parsed_urls++;
				}
			}
		}
	}
	return $video_urls;
}
###################### end of define functions ################


$mailMsg = '';

$m  = "#####################################\n";
$m .= date('Y-m-d H:i:s') . ' - ' . "Start importing videos .... \n";
$m .= date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
$m .= "#####################################\n";
echo $m;
$mailMsg .= $m;

$urls = array();
// Get urls first
foreach ($sources as $source) {
	$urls_of_this_source = array();
	$start_page = $default_start_page;
	while(count($urls_of_this_source) < $max_urls_per_source) {
		shuffle($source['tag_links']);
		foreach($source['tag_links'] as $tag_link) {
			$urls_of_this_source = get_video_links_in_page($tag_link, $start_page, $source['key_class_name'], $source['keywords_of_video_link'], $urls_of_this_source);
			if(count($urls_of_this_source) >= $max_urls_per_source) {
				break 2;
			}
		}
		$start_page++;
		if($start_page > 30) {
			break 1;
		}
	}

	// A specific case, to use random to get more videos
	if($source == 'youjizz' && count($urls_of_this_source) < $max_urls_per_source) {
	    $l = 0;
        while(count($urls_of_this_source) < $max_urls_per_source) {
            $tag_link = 'https://www.youjizz.com/random';
            $urls_of_this_source = get_video_links_in_page($tag_link, 1, $source['key_class_name'], $source['keywords_of_video_link'], $urls_of_this_source);
            if(count($urls_of_this_source) >= $max_urls_per_source) {
                break;
            }
            $l++;
            if($l > 30) {
                break;
            }
        }
    }

	$urls = array_merge($urls, $urls_of_this_source);
}

shuffle($urls);

$m  = "-----------------------------------\n";
if(!empty($l)) {
    $m .= date('Y-m-d H:i:s') . ' - ' . "loaded youjizz-random " . $l . " times ... \n";
}
$m .= date('Y-m-d H:i:s') . ' - ' . 'Total url parsed: ' . $total_parsed_urls . ', existed_videos: ' . $existed_videos . ", finial get urls: ". count($urls) ."\n";
$m .=  "-----------------------------------\n";
echo $m;
$mailMsg .= $m;

// Start importing to current (dev) site: getting contents of video page and parsing and saving
$i = 1;
$success = 0;
$failed = 0;
foreach ($urls as $url) {
	echo date('Y-m-d H:i:s') . ' - ' . "$i - importing: $url \n";

	// call xparser server
    $api_server = Config::get('api_server');
    $imv_url = $api_server . '/import_video/' . urlencode($url);
    echo date('Y-m-d H:i:s') . ' - ' . "calling: $imv_url \n";
	$res = json_decode(curl_call($imv_url));
	echo date('Y-m-d H:i:s') . ' - ' . "---- status: ".$res->status.", msg: ".$res->msg." \n";
	if($res->status) {
		$success++;
	}
	else {
		$failed++;
	}
	$i++;
}

$m = date('Y-m-d H:i:s') . ' - ' . "In local totally have " . ($i-1) . " videos, successfully imported $success, failed $failed \n\n";
echo $m;
$mailMsg .= $m;

// Sync to prod videos table
$m = date('Y-m-d H:i:s') . ' - ' . "Start to sync new videos to prod...\n";
echo $m;
$mailMsg .= $m;
$max_video_id_local = Video::getMaxVideoId();
$max_video_id_prod = curl_call($prod_api . '?ac=get_max_video_id');
$m = date('Y-m-d H:i:s') . ' - ' . "Local max video id = $max_video_id_local, prod max video id = $max_video_id_prod\n";
echo $m;
$mailMsg .= $m;
$i = 0;
$success = 0;
$failed = 0;
if($max_video_id_prod < $max_video_id_local) {
	$sql = 'select * from '.Config::get('db_table_prefix').'videos where id > ' . $max_video_id_prod;
	$res = DB::$dbInstance->getRows($sql);
	foreach ($res as $videoObj) {
		$i++;
		$res2 = curl_call($prod_api.'?ac=save_video_data_and_node', 'post', array('obj'=>json_encode($videoObj)));
		$res2 == '1' ? $success++ : $failed++;
		$result = $res2?'1':'0';

        $m = date('Y-m-d H:i:s') . ' - ' . "$i - sync to prod: ".$videoObj['source_url']." -- $result\n";
        echo $m;
        $mailMsg .= $m;
	}
}

$m  = "-----------------------------------\n";
$m .= date('Y-m-d H:i:s') . ' - ' . "Totally syncing $i videos, success $success, failed $failed \n";
$m .= "-----------------------------------\n\n";
echo $m;
$mailMsg .= $m;

mail("elevenfox11@gmail.com","$site_name import videos", $mailMsg);

