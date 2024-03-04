<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';
?>

<?php
$title = $data['pageTitle'] == 'Newest' ? '最新美女写真图片推荐' : $data['pageTitle'];
?>

<div class="backlink-ads">
<?php
// THE FOLLOWING BLOCK IS USED TO RETRIEVE AND DISPLAY LINK INFORMATION.
// PLACE THIS ENTIRE BLOCK IN THE AREA YOU WANT THE DATA TO BE DISPLAYED.

// MODIFY THE VARIABLES BELOW:
// The following variable defines whether links are opened in a new window
// (1 = Yes, 0 = No)
$OpenInNewWindow = "1";

// # DO NOT MODIFY ANYTHING ELSE BELOW THIS LINE!
// ----------------------------------------------
$BLKey = "SIM8-A4RT-49CN";

if(isset($_SERVER['SCRIPT_URI']) && strlen($_SERVER['SCRIPT_URI'])){
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_URI'].((strlen($_SERVER['QUERY_STRING']))?'?'.$_SERVER['QUERY_STRING']:'');
}

if(!isset($_SERVER['REQUEST_URI']) || !strlen($_SERVER['REQUEST_URI'])){
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'].((isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']))?'?'.$_SERVER['QUERY_STRING']:'');
}

$QueryString  = "LinkUrl=".urlencode(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$QueryString .= "&Key=" .urlencode($BLKey);
$QueryString .= "&OpenInNewWindow=" .urlencode($OpenInNewWindow);


if(intval(get_cfg_var('allow_url_fopen')) && function_exists('readfile')) {
    @readfile("http://www.backlinks.com/engine.php?".$QueryString); 
}
elseif(intval(get_cfg_var('allow_url_fopen')) && function_exists('file')) {
    if($content = @file("http://www.backlinks.com/engine.php?".$QueryString)) 
        print @join('', $content);
}
elseif(function_exists('curl_init')) {
    $ch = curl_init ("http://www.backlinks.com/engine.php?".$QueryString);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_exec ($ch);

    if(curl_error($ch))
        print "Error processing request";

    curl_close ($ch);
}
else {
    print "It appears that your web host has disabled all functions for handling remote pages and as a result the BackLinks software will not function on your web page. Please contact your web host for more information.";
}
?>
</div>


    <div class="content-container newest-File-list-page search-result-list-pages <?=empty($data['dev_mode']) ? '' : 'dev-mode'?>">

        <h1><?php print $title; ?>
            <a id="auto-play" data="search----<?=empty($data['keywords'])?'':$data['keywords']?>" href="#"><span class="glyphicon-circle"><span class="glyphicon glyphicon-play"></span></span>随机播放</a>    
        </h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
            <?php
            if(empty($data['files'])) {
                echo '<h2 style="text-align: center">No photos found.</h2>';
            }
            else {
                $i = 0;
                $j = 1;
                // $apply_mobile_native_ads = true;
                foreach ($data['files'] as $file) {
                    echo $theme->render($file, 'file-teaser');
                    $i++;

                    // if($i % 4 === 0 && is_mobile() && $j<= 3) {
                    // //if($i % 4 === 0 && $j<= 3) {
                    //     include ('ads_templates/ad-native-'.$j.'.tpl.php');
                    //     $j++;
                    //     //$j = $j >3 ? 1 : $j;
                    // }
                }
            }
            ?>

            <?php if(!empty( $data['filesPager'])) :?>
                <div id="pager"><?php print $data['filesPager']; ?></div>
            <?php endif;?>
        </div>


    </div>

    <?=$theme->render($data, 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>


<script type="text/javascript" src="/theme/<?=THEME?>/js/slideshow.js" async></script>