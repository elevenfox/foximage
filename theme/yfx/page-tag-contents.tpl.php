<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';
?>
    <div class="content-container tag-file-list-page <?=empty($data['dev_mode']) ? '' : 'dev-mode'?>">
        <h1><?=t($data['page_title'])?>
        <a id="auto-play" data="tag----<?=$data['tagName']?>" href="#"><span class="glyphicon-circle"><span class="glyphicon glyphicon-play"></span></span>Random Slideshow</a>
        </h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
         <?php
            if(!empty($data['files'])) {
                $i = 0;
                $j = 1;
                // $apply_mobile_native_ads = true;
                foreach ($data['files'] as $file) {
                    echo $theme->render($file, 'file-teaser');
                    $i++;

                    // if($i % 4 === 0  && is_mobile() && $j<= 3) {
                    // //if($i % 4 === 0 && $j<= 3) {
                    //     include ('ads_templates/ad-native-'.$j.'.tpl.php');
                    //     $j++;
                    //     //$j = $j >=3 ? 1 : $j;
                    // }
                }
            }
            else {
                echo "<h4 style='line-height: 50px; width: 100%; text-align: center; padding: 5px 10px 40px 10px; border-bottom: 1px solid;'>No file found!</h4>";

                echo '<h4 style="margin: 20px 0;">Other file you may like: </h4>';

                if(!empty($data['otherFiles'])) {
                    foreach ($data['otherFiles'] as $file) {
                        echo $theme->render($file, 'file-teaser');
                    }
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

<script type="text/javascript" src="/theme/<?=THEME?>/js/slideshow.js"></script>