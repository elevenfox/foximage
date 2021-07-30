<?php
/* @var Array $data */
/* @var Theme $theme */


include 'header.tpl.php';

$file = $data['file'];

$api_server = Config::get('api_server');
$api_server = empty($api_server) ? get_default_file_api_url() : $api_server;
?>

<script>
  function orientation() {
    <?php if(!empty($data['dev_mode'])):?>
      let image = $('#the-photo');
      let currentOrientation = window.innerHeight > window.innerWidth ? 'portrait' : 'landscape';
      
      let originImageWidth = image.width();
      let originImageHeight = image.height();
      let aspectRatio = originImageWidth/originImageHeight;
      image.data("aspect-ratio", aspectRatio);

      if( aspectRatio > 1 && currentOrientation === 'portrait' ) {
          // Image is landscape, so rotate it
          image.addClass('rotate');
          $('#the-photo-link').width(originImageHeight * aspectRatio);
          $('#the-photo-link').height(originImageWidth * aspectRatio);
          image.width(originImageWidth * aspectRatio);
          image.height(originImageHeight * aspectRatio);
          image.css('top', (originImageWidth * (aspectRatio - 1))/2 );
          image.css('left', (originImageWidth * (1 - aspectRatio))/2 );
          
      } 
      if (aspectRatio < 1 && currentOrientation === 'landscape') {
          // Image is portrait, rotate it to landscape and scale it
          image.addClass('rotate');
          $('#the-photo-link').height(originImageWidth * aspectRatio);
          image.width(originImageWidth * aspectRatio);
          image.height(originImageHeight * aspectRatio);
          image.css('top', (originImageWidth * (aspectRatio-1))/2 );
      }
    <?php endif;?>

    document.getElementById('the-photo').scrollIntoView();
  }
</script>
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

            <div class="file-info">Uploaded By: <?=$file['user_name']?></div>
            <div class="file-info" itemprop="userInteractionCount">Views: <?=$file['view_count'] ? number_format($file['view_count']) : rand(1, 500) ?></div>
            <div class="file-tags">
                <span class="not-in-mobile">Tags:</span>
                <?php
                $tags = explode(',', $file['tags']);
                foreach($tags as $tag) {
                    $tag_flat = str_replace(' ','-',strtolower($tag));
                    echo '<a class="tag" href="/tags/'.$tag_flat.'">'.$tag.'</a>';
                }
                ?>
            </div>
            <div class="file-description"><?= nl2br($file['description'])?></div>
          </div>

          <div class="task" id="task">
            <div class="file-detail">
              <div>
                  <?php
                      $images = explode(',', $file['filename']);
                      $num = empty($_GET['at']) ? 1 : $_GET['at'];
                      $num = $num >= count($images) ? count($images) : $num;

                      $cur_image_url = $images[$num-1];
                      
                      $name_arr = explode('/', $cur_image_url);
                      $filename = array_pop($name_arr);
                      $physical_path = buildPhysicalPath($file);
                      $file_root = Config::get('file_root');
                      $relative_path = str_replace($file_root, '', $physical_path);
                      $relative_fullname = '/jw-photos/' . $relative_path . '/' . $filename;
                      if(file_exists($_SERVER['DOCUMENT_ROOT'] . $relative_fullname)) {
                        $cur_image_url = $relative_fullname;
                      }
                      else {
                        if($file['source'] == 'tujigu') {
                          $cur_image_url = '/file_content/' . $file['source_url_md5'] . '/' . $num . '/fc.jpg';
                        }
                      }

                  ?>
                  <div id="fdp-photo">
                    <a id="the-photo-link" href="<?='/file/'.cleanStringForUrl($file['title']).'/'.$file['id'].'/?at='.($num+1).'#fdp-photo'?>" data-bg-text="Loading...">
                      <img id="the-photo" src="<?=$cur_image_url?>" alt="<?=$file['title']?>" loading="lazy" onload="javascript: orientation()"></img>
                    </a>
                    <div class="fdp-click-area">
                      <a class="fdp-click-area-left"  title="previous" href="<?='/file/'.cleanStringForUrl($file['title']).'/'.$file['id'].'/?at='.($num-1).'#fdp-photo'?>"></a>
                      <a class="fdp-click-area-right"  title="next" href="<?='/file/'.cleanStringForUrl($file['title']).'/'.$file['id'].'/?at='.($num+1).'#fdp-photo'?>"></a>
                    </div>
                    <?php if( !empty($_REQUEST['ppt']) ):?>
                    <div class="fdp-random-btns">
                      <span class="fdp-random-count-down">20</span>
                      <span class="fdp-random-previous" title="Previous">
                          <svg style="height: 14px;-webkit-transform: scaleX(-1);transform: scaleX(-1);" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 20.465 20.465" xml:space="preserve"><g id="c91_rewind"><path d="M9.112,1.372c0.139-0.069,0.303-0.049,0.424,0.045l10.776,8.501c0.094,0.076,0.153,0.191,0.153,0.312s-0.06,0.24-0.153,0.314L9.536,19.047c-0.071,0.056-0.163,0.088-0.248,0.088l-0.176-0.042c-0.138-0.064-0.226-0.204-0.226-0.359V1.732C8.887,1.58,8.975,1.437,9.112,1.372z"/><path d="M0.225,1.372C0.364,1.303,0.529,1.323,0.65,1.417l10.776,8.501c0.093,0.076,0.152,0.191,0.152,0.312s-0.06,0.24-0.152,0.314L0.649,19.047c-0.073,0.056-0.163,0.088-0.249,0.088l-0.176-0.042C0.088,19.028,0,18.889,0,18.733V1.732C0,1.58,0.088,1.437,0.225,1.372z"/></g></svg>
                      </span>
                      <span class="fdp-random-pause glyphicon glyphicon-pause" title="Pause"></span>
                      <span class="fdp-random-next" title="Next">
                          <svg style="height: 14px" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 20.465 20.465" xml:space="preserve"><g id="c91_rewind"><path d="M9.112,1.372c0.139-0.069,0.303-0.049,0.424,0.045l10.776,8.501c0.094,0.076,0.153,0.191,0.153,0.312s-0.06,0.24-0.153,0.314L9.536,19.047c-0.071,0.056-0.163,0.088-0.248,0.088l-0.176-0.042c-0.138-0.064-0.226-0.204-0.226-0.359V1.732C8.887,1.58,8.975,1.437,9.112,1.372z"/><path d="M0.225,1.372C0.364,1.303,0.529,1.323,0.65,1.417l10.776,8.501c0.093,0.076,0.152,0.191,0.152,0.312s-0.06,0.24-0.152,0.314L0.649,19.047c-0.073,0.056-0.163,0.088-0.249,0.088l-0.176-0.042C0.088,19.028,0,18.889,0,18.733V1.732C0,1.58,0.088,1.437,0.225,1.372z"/></g></svg>
                      </span>
                    </div>
                    <?php endif;?>
                  </div>
              </div>
            </div>
          </div>

          <?php
            import('Pager');
            $pager = new Pager(
                    1,
                    count($images),
                    $num,
                    '/file/'.cleanStringForUrl($file['title']).'/'.$file['id'].'/?at=',
                    '#fdp-photo'
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
                        echo '<a class="tag" href="/tags/'.$tag_flat.'">'.$tag.'</a>';
                    }
                    ?>
        </div>

        <div class="related-files">
            <?php
            if(!empty($data['relatedFiles'])) {
              $related_files = $data['relatedFiles'];

              $i = 0;
              $j = 1;
              $apply_mobile_native_ads = true;
              foreach ($related_files as $rFile) {
                  echo $theme->render($rFile, 'file-teaser');
                  $i++;

                  if($i % 4 === 0  && is_mobile() && $j<= 3) {
                      include ('ads_templates/ad-native-'.$j.'.tpl.php');
                      $j++;
                      //$j = $j >=3 ? 1 : $j;
                  }
              }
            }
            ?>
        </div>

    </article>
</div>


<?=$theme->render(null, 'ads_templates/ad-side-right')?>


<?php if(empty($data['not-found'])) : ?>
<script>
(function($) {

      <?php if( !empty($_REQUEST['ppt']) ):?>
        let seconds = 20;
        let timeoutCallback = function() {
          let api_endpoint = '/api/?ac=get_random_file_by_tag&tag=<?=$_REQUEST['tag']?>';
          $.get(api_endpoint, function(data) {
              if(data.url) {
                  window.location.href = data.url;
              }
          });
        };
        let intervalCallback = function() {
          seconds = seconds - 1;
          $('.fdp-random-count-down').text(seconds);
          if(seconds < -5) {
            timeoutCallback();
          }
        };

        let to = setTimeout(timeoutCallback, seconds * 1000);

        let itv = setInterval(intervalCallback, 1000);

        $('.fdp-random-pause').on('click', function() {
          if($('.fdp-random-pause').hasClass('glyphicon-pause')) {
            window.clearInterval(itv);
            window.clearTimeout(to);
            $('.fdp-random-pause').removeClass('glyphicon-pause');
            $('.fdp-random-pause').addClass('glyphicon-play');
          }
          else {
            $('.fdp-random-pause').removeClass('glyphicon-play');
            $('.fdp-random-pause').addClass('glyphicon-pause');
            to = setTimeout(timeoutCallback, seconds * 1000);
            itv = setInterval(intervalCallback, 1000);
          }
        });

        $('.fdp-random-previous').on('click', function(){
          window.history.go(-1);
        });

        $('.fdp-random-next').on('click', function(){
          timeoutCallback();
        });


      <?php endif; ?>
})(jQuery);
</script>
<?php endif;?>

<?php include 'footer.tpl.php';?>