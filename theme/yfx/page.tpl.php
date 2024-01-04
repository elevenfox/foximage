<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';
?>
    <div class="content-container newest-File-list-page search-result-list-pages <?=empty($data['dev_mode']) ? '' : 'dev-mode'?>">

        <h1><?php print $data['page_title']; ?>
            <a id="auto-play" data="search----<?=empty($data['keywords'])?'':$data['keywords']?>" href="#"><span class="glyphicon-circle"><span class="glyphicon glyphicon-play"></span></span>Shuffle</a>    
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