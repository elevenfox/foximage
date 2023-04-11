<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';
$dev_mode = Config::get('dev_mode');
?>

<?php

?>

    <div class="content-container all-tags-page <?=empty($dev_mode) ? '' : 'dev-mode'?>">
        <h1>
            <?php print $data['page_title']; ?>
            <select name="sort_by" id="tags-sort-by">
                <option value="1" <?= !empty($_GET['sort']) && $_GET['sort'] == 1 ? "selected" : ""?>>按字母升序</option>
                <option value="2" <?= !empty($_GET['sort']) && $_GET['sort'] == 2 ? "selected" : ""?>>按字母降序</option>
                <option value="3" <?= !empty($_GET['sort']) && $_GET['sort'] == 3 ? "selected" : ""?>>按图集数量升序</option>
                <option value="4" <?= !empty($_GET['sort']) && $_GET['sort'] == 4 ? "selected" : ""?>>按图集数量降序</option>
            </select>
        </h1>
        
        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
            <?php foreach ($data['tags'] as $tag) : ?>

                <article class="clearfix node-teaser tag-name" style="text-align: left">
                    <div class="task" id="task" style="position: relative">
                        <div class="thumbnail-container">
                            <div class="teaser-thumbnail">
                                <a href="/tags/<?=urlencode($tag['term'])?>">
                                    <?=ucwords($tag['term'])?> (<?=$tag['num']?>)
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

            <?php endforeach; ?>

            <div id="pager"><?php print $data['filesPager']; ?></div>
        </div>

    </div>

    <?=$theme->render(['dev_mode' => $dev_mode], 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>

<script>
    $(function() {
        $('#tags-sort-by').on('change', function() {
            window.location.href = '?sort=' + $(this).val();
        });
    });
</script>