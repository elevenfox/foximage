<?php
/* @var File $data */

$thumbnail = processThumbnail($data);

?>
<article class="clearfix node-teaser" itemscope itemtype="http://schema.org/FileObject">
    <div class="task" id="task" style="position: relative">
        <div class="thumbnail-container" title="<?=$data['title']?>">
            <div class="teaser-thumbnail" itemprop="thumbnail">
                <a href="/file/<?=cleanStringForUrl($data['title'])?>/<?=$data['source_url_md5']?>" itemprop="url">
                    <div class="stretchy-wrapper" data-bg-text="Loading...">
                        <img class="lazy"
                              data-src="<?=$thumbnail?>"
                              alt="<?=$data['title']?>"
                              src="<?=$thumbnail?>"
                              title="<?=$data['title']?>"
                        >
                    </div>
                </a>
            </div>
        </div>
        <div class="teaser-file-detail">
            <div class="teaser-file-title" itemprop="name" title="<?=$data['title']?>">
                <a href="/file/<?=cleanStringForUrl($data['title'])?>/<?=$data['source_url_md5']?>" itemprop="url"><?=$data['title']?></a>
            </div>
            <div class="teaser-file-info">
              <span><img src="/theme/jw/images/upload-icon.svg" width="12" height="12" alt="views" loading="lazy"></span>  
                By: <?=$data['user_name'] ? $data['user_name'] : 'Anonymous' ?>
            </div>
            <div class="teaser-file-info right" itemprop="userInteractionCount">
                <span><img src="/theme/jw/images/eye-open.svg" width="12" height="12" alt="views" loading="lazy"></span> <?=$data['view_count'] ? number_format($data['view_count']) : rand(1, 500) ?>
            </div>
        </div>

        <?php if(isAdmin()) :?>
            <div class="node-admin" style="position: absolute; top:0; right:0; background-color: white; padding: 3px; opacity: 0.8">
                <a href="javascript: deleteFile('<?=$data['id']?>')">Delete</a>
            </div>
            <script>
                function deleteFile(file_id) {
                  var res = confirm("Are you sure to delete File (id = " + file_id + ")?");
                  if(res) {
                    // Ajax call to delete the File
                    var data = {
                      'ac' : 'delete_file_by_user',
                      'file_id': file_id,
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
