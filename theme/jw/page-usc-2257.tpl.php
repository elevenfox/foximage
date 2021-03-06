<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';
?>

<?php

?>

    <div class="content-container privacy-page search-result-list-pages">

        <h1><?php print $data['page_title']; ?></h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">

            <div class="text-container">
                <p>Tuzac.com is not a producer (primary or secondary) of any and all of the content found on the website (tuzac.com). With respect to the records as per 18 USC 2257 for any and all content found on this site, please kindly direct your request to the site for which the content was produced.</p>

                <p>Tuzac.com is a File sharing site in which allows for the uploading, sharing and general viewing of various types of adult content and while Pornhub.com does the best it can with verifying compliance, it may not be 100% accurate.</p>

                <p>Tuzac.com abides by the following procedures to ensure compliance:</p>

                <p>Requiring all users to be 18 years of age to upload Files.</p>

                <p>When uploading, user must verify the content; assure he/she is 18 years of age; certify that he/she keeps records of the models in the content and that they are over 18 years of age.</p>

                <p>For further assistance and/or information in finding the content's originating site, please contact tuzac.com compliance at service@tuzac.com</p>

                <p>Tuzac.com allows content to be flagged as inappropriate. Should any content be flagged as illegal, unlawful, harassing, harmful, offensive or various other reasons, tuzac.com shall remove it from the site without delay.</p>

                <p>Users of tuzac.com who come across such content are urged to flag it as inappropriate by emailing service@tuzac.com.&nbsp;</p>
            </div>

        </div>


    </div>

    <?=$theme->render(null, 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>