<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';

?>

<?php

?>

    <div class="content-container tag-videos-list-page">
        <h1><?php print $data['page_title']; ?></h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
         <?php
            if(!empty($data['videos'])) {
                $i = 0;
                $j = 1;
                $apply_mobile_native_ads = true;
                foreach ($data['videos'] as $video) {
                    echo $theme->render($video, 'video-teaser');
                    $i++;

                    if($i % 4 === 0  && is_mobile() && $j<= 3) {
                        include ('ads_templates/ad-native-'.$j.'.tpl.php');
                        $j++;
                        //$j = $j >=3 ? 1 : $j;
                    }
                }
            }
            else {
                echo "<h4 style='line-height: 50px; width: 100%; text-align: center; padding: 5px 10px 40px 10px; border-bottom: 1px solid;'>No video found!</h4>";


                echo '<h4 style="margin: 20px 0;">Other videos you may like: </h4>';

                if(!empty($data['otherVideos'])) {
                    foreach ($data['otherVideos'] as $video) {
                        echo $theme->render($video, 'video-teaser');
                    }
                }
            }
         ?>


            <?php if(!empty( $data['filesPager'])) :?>
                <div id="pager"><?php print $data['filesPager']; ?></div>
            <?php endif;?>
        </div>


    </div>

    <?=$theme->render(null, 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>