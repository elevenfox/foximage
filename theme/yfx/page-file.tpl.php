<?php
/* @var Array $data */
/* @var Theme $theme */


include 'header.tpl.php';

$file = $data['file'];
$images = explode(',', $file['filename']);
$total_photos = count($images);

$photos_per_page = Config::get('photos_per_page');
$photos_per_page = empty($photos_per_page) ? 1 : $photos_per_page;

$total_pages = ceil($total_photos/$photos_per_page);

$num = empty($_GET['at']) ? 1 : $_GET['at'];
$num = $num >= $total_pages ? $total_pages : $num;

$at = $num >= $total_pages ? 1 : $num + 1;

$api_server = Config::get('api_server');

$src_arr = (array)processPhotoSrc($file, $num, $photos_per_page);
?>

<script type="text/javascript">window.devMode = <?= empty($data['dev_mode']) ? 0 : 1 ?></script>


<div class="content-container file-detail-page <?=empty($data['dev_mode']) ? '' : 'dev-mode'?>">

    <article class="file content" itemscope itemtype="http://schema.org/fileObject">
        <?php if(!empty($data['not-found'])) : ?>
          <div class="fc-text-content">
            <h1>Photo not found</h1>
            <p>&nbsp;</p>
            <h4><i>You might want to see other photos: </i></h4>
          </div>
        <?php else:?>
          <div class="fc-text-content">
            <h1 itemprop="name"><?= $file['title'] ?></h1>

            <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

            <?php
              if(!empty($file['download_url'])) {
                if(empty($file['short_url'])) {
                  // Call ouo.io to get short URL, then update db
                  $su_service = 'https://ouo.io';
                  $res = curl_call('https://ouo.io/api/dVxF4lIm?s=' . $file['download_url']);
                  if(!empty($res) && substr($res, 0, strlen($su_service)) === $su_service) {
                    File::updateShortUrl($file['id'], $res);
                    // Update sesstion
                    $file['short_url'] = $res;
                    $_SESSION['current_file'] = $file;
                  }
                }

                echo '<div class="file-album-download">Download HD no-watermark pictures: <a href="' . $file['short_url'] . '" target="_blank">TerraBox</a></div>';
                echo '<div>Unzip Password: tuzac</div><br>';
              }
            ?>
            <div class="file-info">Upload By: <?=$file['user_name']?></div>
            <div class="file-info">Upload at: <?=date('Y-m-d', strtotime($file['modified']))?></div>
            <div class="file-info" itemprop="userInteractionCount">Views: <?=$file['view_count'] ? number_format($file['view_count']) : rand(1, 500) ?></div>
            
            <div class="file-tags">
                <span class="not-in-mobile">Tags:</span>
                <span id="tags_box_links">
                    <?php
                    $tags = explode(',', $file['tags']);
                    foreach($tags as $tag) {
                        $tag_flat = str_replace(' ','-',strtolower($tag));
                        echo '<a class="tag" href="/tags/'.urlencode($tag_flat).'"><h2>'.t($tag).'</h2></a>';
                    }
                    ?>
                </span>
                <div id="tags_box_text" style="display: none">
                    <input id="tags-string" type="text" value="<?= $file['tags']?>" style="width:100%"/>
                    <button id="tags-cancel">Cancel</button>&nbsp;&nbsp;&nbsp;&nbsp;<button id="tags-save">Save</button>
                </div>
                <?php
                    if(isAdmin()) {
                        echo '<a href="#" id="edit-tags" style="font-style: italic; margin: 0 8px; display: inline-block; cursor: pointer; font-size: 12px;">Edit</a>';
                    }
                ?>
            </div>
            <div class="file-description"><?= nl2br($file['description'])?></div>
          </div>

          <div class="task" id="task">
            <div id="auto-play" data="album----<?=$file['id']?>" num="<?=$num?>" total="<?=$total_photos?>">Slideshow</div>
            <div class="file-detail">
              <div>
                  <?php foreach($src_arr as $src) { ?>
                      <img src="<?=$src?>" alt="<?=$file['title']?>" loading="lazy"></img>
                  <?php } ?>
              </div>
            </div>
          </div>
          <?php
            import('Pager');
            $pager = new Pager(
                    $photos_per_page,
                    count($images),
                    $num,
                    '/file/'.cleanStringForUrl($file['title']).'/'.$file['id'].'/?at='
                  );
            $pagerHtml = $pager->generatePages();
          ?>
          <div id="pager"><?=$pagerHtml?></div>
      
        <?php endif;?>
        
        <div class="file-tags ft-bottom">
            <span class="not-in-mobile">Tags:</span>
                    <?php
                    $tags = explode(',', $file['tags']);
                    foreach($tags as $tag) {
                        $tag_flat = str_replace(' ','-',strtolower($tag));
                        echo '<a class="tag" href="/tags/'.urlencode($tag_flat).'"><h2>'.t($tag).'</h2></a>';
                    }
                    ?>
        </div>

        <div class="related-files">
            <?php
            if(!empty($data['relatedFiles'])) {
              $related_files = $data['relatedFiles'];

              $i = 0;
              $j = 1;
              // $apply_mobile_native_ads = true;
              foreach ($related_files as $rFile) {
                  echo $theme->render($rFile, 'file-teaser');
                  $i++;

                  // //if($i % 4 === 0  && is_mobile() && $j<= 3) {
                  // if($i % 4 === 0  && $j<= 3) {
                  //     include ('ads_templates/ad-native-'.$j.'.tpl.php');
                  //     $j++;
                  //     //$j = $j >=3 ? 1 : $j;
                  // }
              }
            }
            ?>
        </div>

    </article>
</div>


<?=$theme->render($data, 'ads_templates/ad-side-right')?>

<script type="text/javascript" src="/theme/<?=THEME?>/js/file_page.js"></script>
<script type="text/javascript" src="/theme/<?=THEME?>/js/slideshow.js"></script>

<?php if(empty($data['not-found'])) : ?>
<script>
(function($) {
  $('#edit-tags').on('click', function(e) {
    e.preventDefault();
    $('#tags_box_links').hide();
    $('#tags_box_text').show();
    $('#edit-tags').hide();
  });
  $('#tags-cancel').on('click', function() {
      $('#tags_box_links').show();
      $('#tags_box_text').hide();
      $('#edit-tags').show();
  });
  $('#tags-save').on('click', function() {
      let newTags = $('#tags-string').val();
      // Call api to save tags for this album
      let api_endpoint = '/api/?ac=save_tags';
      let data = {
        'tags': newTags,
        'id' : <?=$file['id']?>
      };
      $.post(api_endpoint, data, function(res) {
          if(res.status) {
              window.location.reload();
          }
          else {
            alert('Failed to save tags');
          }
      });
  });
})(jQuery);
</script>
<?php endif;?>

<?php include 'footer.tpl.php';?>