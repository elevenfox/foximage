<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';
?>

<?php

?>

    <div class="content-container newest-File-list-page search-result-list-pages">

        <h1><?php print $data['page_title']; ?></h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
            <div style="text-align: center; line-height: 50px ">The URL you requested is not found. Please double check the URL.</div>
        </div>


    </div>

    <?=$theme->render(null, 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>