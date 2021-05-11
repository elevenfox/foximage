<?php
/* @var Video $data */

?>
<article class="clearfix node-teaser" itemscope itemtype="http://schema.org/VideoObject">
    <div class="task" id="task" style="position: relative">
        <div class="thumbnail-container">
            <div class="teaser-thumbnail" <?=get_gif_preview($data['source'],$data)?> itemprop="thumbnail">
                <a href="/video/<?=cleanStringForUrl($data['title'])?>/<?=$data['source_url_md5']?>" itemprop="url">
                    <div class="stretchy-wrapper">
                        <img
                                src="<?=str_replace('http://', 'https://',$data['thumbnail'])?>"
                                alt="<?=$data['title']?>"
                        >
                    </div>
                </a>
            </div>
            <div class="duration" itemprop="duration"><?=is_hd_video($data) ? '<strong>HD</strong>  ' : ''?><?=seconds_to_duration($data['duration'])?></div>
        </div>
        <div class="teaser-video-detail">
            <div class="teaser-video-title" itemprop="name">
                <a href="/video/<?=cleanStringForUrl($data['title'])?>/<?=$data['source_url_md5']?>" itemprop="url"><?=$data['title']?></a>
            </div>
            <div class="teaser-video-info" itemprop="userInteractionCount">
                <i class="icon-white glyphicon glyphicon-eye-open"></i> <?=$data['view_count'] ? number_format($data['view_count']) : rand(1, 500) ?>
            </div>
            <div class="teaser-video-info">
                <i class="icon-white glyphicon glyphicon-upload"></i> By: <?=$data['user_name'] ? $data['user_name'] : 'Anonymous' ?>
            </div>
        </div>

        <?php if(isAdmin()) :?>
            <div class="node-admin" style="position: absolute; top:0; right:0; background-color: black; padding: 3px; opacity: 0.8">
                <a href="javascript: deleteVideo('<?=$data['source_url_md5']?>')">Delete</a>
            </div>
            <script>
                function deleteVideo(video_md5_id) {
                  var res = confirm("Are you sure to delete video (md5_id = " + video_md5_id + ")?");
                  if(res) {
                    // Ajax call to delete the video
                    var data = {
                      'ac' : 'delete_video_by_user',
                      'video_md5_id': video_md5_id,
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
