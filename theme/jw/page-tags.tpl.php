<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';

?>

<?php

?>

    <div class="content-container all-tags-page">
        <h1>
            <?php print $data['page_title']; ?>
            <select name="sort_by" id="tags-sort-by">
                <option value="1">按字母升序</option>
                <option value="2">按字母降序</option>
                <option value="3">按图集数量升序</option>
                <option value="4">按图集数量降序</option>
            </select>
        </h1>
        
        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
            <?php foreach ($data['tags'] as $tag) : ?>

                <article class="clearfix node-teaser tag-name" style="text-align: left">
                    <div class="task" id="task" style="position: relative">
                        <div class="thumbnail-container">
                            <div class="teaser-thumbnail">
                                <a href="/tags/<?=$tag['name']?>">
                                    <?=ucwords($tag['name'])?> (<?=$tag['vid']?>)
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

<script>
    $(function() {
        $('#tags-sort-by').on('change', function() {
            window.location.href = '?sort=' + $(this).val();
        });
    });
</script>