<?php
/* @var Array $data */
/* @var Theme $theme */


include 'header.tpl.php';

$file = $data['file'];

$api_server = Config::get('api_server');
$api_server = empty($api_server) ? get_default_file_api_url() : $api_server;
?>

<div class="content-container file-detail-page">

    <article class="file content" itemscope itemtype="http://schema.org/fileObject">

        <header style="text-align: left">
          <?php if(!empty($data['not-found'])) : ?>
              <h1>Photo not found</h1>
              <p>&nbsp;</p>
              <h4><i>You might want to see other photos: </i></h4>
          <?php else:?>
            <h1 itemprop="name"><?= $file['title'] ?></h1>

            <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

            <div class="file-info">Uploaded By: <?=$file['user_name']?></div>
            <div class="file-info" itemprop="userInteractionCount">Views: <?=$file['view_count'] ? number_format($file['view_count']) : rand(1, 500) ?></div>
            <div class="file-tags">
                Tags:
                <?php
                $tags = explode(',', $file['tags']);
                foreach($tags as $tag) {
                    $tag_flat = str_replace(' ','-',strtolower($tag));
                    if ($tag === end($tags)) {
                        echo '<a class="tag" href="/tags/'.$tag_flat.'">'.$tag.'</a>';
                    }
                    else {
                        echo '<a class="tag" href="/tags/'.$tag_flat.'">'.$tag.'</a>, ';
                    }
                }
                ?>
            </div>
            <div class="file-description"><?= nl2br($file['description'])?></div>

            <div class="task" id="task">
              <div class="file-detail">
                <div>
                    <?php
                        $images = explode(',', $file['filename']);
                        $num = empty($_GET['at']) ? 1 : $_GET['at'];
                        $num = $num >= count($images) ? count($images) : $num;
                    ?>
                    <div style="text-align: center" id="fdp-photo">
                      <a title="next" href="<?='/file/'.cleanStringForUrl($file['title']).'/'.$file['id'].'/?at='.($num+1).'#fdp-photo'?>" style="cursor:e-resize"><img src="<?=$images[$num-1]?>" alt="<?=$file['title']?>"></img></a>
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
        </header>
        
        <div class="file-tags ft-bottom">
                    Tags:
                    <?php
                    $tags = explode(',', $file['tags']);
                    foreach($tags as $tag) {
                        $tag_flat = str_replace(' ','-',strtolower($tag));
                        if ($tag === end($tags)) {
                            echo '<a class="tag" href="/tags/'.$tag_flat.'">'.$tag.'</a>';
                        }
                        else {
                            echo '<a class="tag" href="/tags/'.$tag_flat.'">'.$tag.'</a>, ';
                        }
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


    <!-- Modal -->
    <div id="alert-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content" style="background-color: white; padding: 25px; min-width: 400px">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="a_message" style="padding: 30px 0;font-size: 1.8em;text-align: center;border-bottom: 1px solid #ddd;margin: 5px 0;"></div>


                <div class="ad-container" style="text-align: center">
                    <script type="application/javascript">
                      var ad_idzone = "3502519",
                        ad_width = "300",
                        ad_height = "100"
                    </script>
                    <script type="application/javascript" src="https://a.realsrv.com/ads.js"></script>
                    <noscript>
                        <iframe src="https://syndication.realsrv.com/ads-iframe-display.php?idzone=3502519&output=noscript&type=300x100" width="300" height="100" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
                    </noscript>
                </div>

                <script type="text/javascript">
                  (function () {
                    var myEl = {el: null}; var event = new CustomEvent('getexoloader', {"detail": myEl}); window.document.dispatchEvent(event); var ExoLoader = myEl.el || window['ExoLoader'];
                    ExoLoader.addZone({"idzone":"3502519"}); // m_middle
                  })();
                </script>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" style="min-width: 100px;">OK</button>
                </div>
            </div>
        </div>
    </div>

<?php if(empty($data['not-found'])) : ?>
<script>
(function($) {

      function showAlert(msg) {
        $('#alert-modal').modal('show');
        $('#alert-modal .a_message').text(msg);
      }

      $('#alert-modal .btn-primary').on('click', function () {
        $('#alert-modal').modal('hide');
        window.location.reload();
      });
})(jQuery);
</script>
<?php endif;?>

<?php include 'footer.tpl.php';?>