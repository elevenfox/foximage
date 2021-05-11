<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';

?>

<?php

?>

    <div class="content-container all-tags-page">
        <h1><?php print $data['page_title']; ?></h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
            <?php foreach ($data['tags'] as $tag) : ?>

                <article class="clearfix node-teaser tag-name" style="text-align: left">
                    <div class="task" id="task" style="position: relative">
                        <div class="thumbnail-container">
                            <div class="teaser-thumbnail">
                                <a href="/tags/<?=$tag['name']?>">
                                    <?=ucwords($tag['name'])?>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

            <?php endforeach; ?>

            <div id="pager"><?php print $data['filesPager']; ?></div>
        </div>

    </div>

    <?=$theme->render(null, 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>