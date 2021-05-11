<?php
/* @var File $data */

?>
<article class="clearfix node-teaser" itemscope itemtype="http://schema.org/FileObject">
    <div class="task" id="task" style="position: relative">
        <div class="thumbnail-container">
            <div class="teaser-thumbnail" <?=get_gif_preview($data['source'],$data)?> itemprop="thumbnail">
                <a href="/File/<?=cleanStringForUrl($data['title'])?>/<?=$data['source_url_md5']?>" itemprop="url">
                    <div class="stretchy-wrapper">
                        <img
                                src="<?=str_replace('http://', 'https://',$data['thumbnail'])?>"
                                alt="<?=$data['title']?>"
                        >
                    </div>
                </a>
            </div>
            <div class="duration" itemprop="duration"><?=is_hd_File($data) ? '<strong>HD</strong>  ' : ''?><?=seconds_to_duration($data['duration'])?></div>
        </div>
        <div class="teaser-File-detail">
            <div class="teaser-File-title" itemprop="name">
                <a href="/File/<?=cleanStringForUrl($data['title'])?>/<?=$data['source_url_md5']?>" itemprop="url"><?=$data['title']?></a>
            </div>
            <div class="teaser-File-info"><i class="icon-white glyphicon glyphicon-upload"></i> By: <?=$data['user_name'] ? $data['user_name'] : 'Anonymous' ?></div>
            <div class="teaser-File-info right" itemprop="userInteractionCount">
                <i class="icon-white glyphicon glyphicon-eye-open"></i> <?=$data['view_count'] ? number_format($data['view_count']) : rand(1, 500) ?>
            </div>
        </div>

        <?php if(isAdmin()) :?>
            <div class="node-admin" style="position: absolute; top:0; right:0; background-color: white; padding: 3px; opacity: 0.8">
                <a href="javascript: deleteFile('<?=$data['source_url_md5']?>')">Delete</a>
            </div>
            <script>
                function deleteFile(File_md5_id) {
                  var res = confirm("Are you sure to delete File (md5_id = " + File_md5_id + ")?");
                  if(res) {
                    // Ajax call to delete the File
                    var data = {
                      'ac' : 'delete_File_by_user',
                      'File_md5_id': File_md5_id,
                    };
                    $.post('/api/', data, function (res) {
                      if(res) {
                        location.reload();
                      }
                      else {
                        alert('Failed');
                      }
                    });
                  }
                }
            </script>
        <?php endif;?>
    </div>
</article>
