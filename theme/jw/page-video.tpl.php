<?php
/* @var Array $data */
/* @var Theme $theme */


include 'header.tpl.php';

$File = $data['File'];

$api_server = Config::get('api_server');
$api_server = empty($api_server) ? get_default_File_api_url() : $api_server;
?>


    <script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>

    <style>
        .fluid_File_wrapper {
            position: absolute;
            top: 0;
        }
        #my_File_fluid_control_theatre {
            display: none;
        }
        .fluid_File_wrapper.mobile {
            height: 100% !important;
        }
    </style>


<div class="content-container File-detail-page">

    <article class="File content" itemscope itemtype="http://schema.org/FileObject">

        <header style="text-align: left">
          <?php if(!empty($data['not-found'])) : ?>
              <h1>File not found</h1>
              <p>&nbsp;</p>
              <h4><i>You might want to see other Files: </i></h4>
          <?php else:?>
            <h1 itemprop="name"><?= $File['title'] ?></h1>

            <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

            <p class="tags">
                Tags:
                <?php
                $tags = explode(',', $File['tags']);
                foreach($tags as $tag) {
                    $tag_flat = str_replace(' ','-',strtolower($tag));
                    echo '<a class="tag" href="/tags/'.$tag_flat.'">'.$tag.'</a>';
                }
                ?>
            </p>
          <?php endif;?>
        </header>

        <?php if(empty($data['not-found'])) : ?>
        <div class="task" id="task">
            <div class="thumbnail-container" itemprop="thumbnail">
                <div class="thumbnail" style="position: relative">
                    <div id="File-holder" style="width:100%; padding-top: 56.25%; position: relative;background: black;background:url('<?=$File['thumbnail']?>') no-repeat left center; background-size:100%; display: flex"></div>
                    <div id="File-loading" style="display:none; position: absolute; opacity: 0.7; background-color: black; top: 0px; height: 100%; width: 100%;">
                        <div id="loading" style="border: 8px solid #f3f3f3;border-radius: 50%;border-top: 8px solid #3498db;width: 42px;height: 42px;position: relative;z-index: 999;top: 45%;left: 46%;-webkit-animation: spin 2s linear infinite;animation: spin 2s linear infinite;">
                            <style>
                                @-webkit-keyframes spin {0% { -webkit-transform: rotate(0deg); }100% { -webkit-transform: rotate(360deg); }}
                                @keyframes spin {0% { transform: rotate(0deg); }100% { transform: rotate(360deg); }}
                            </style>
                        </div>
                    </div>
                </div>

            </div>
            <div class="File-detail">
                <div id="File-title" class="File-title" itemprop="name"><h2><?=$File['title']?></h2></div>
                <div class="File-info">Uploaded By: <?=$File['user_name']?></div>
                <div class="File-info" itemprop="userInteractionCount">Views: <?=$File['view_count'] ? number_format($File['view_count']) : rand(1, 500) ?></div>
                <div class="File-tags">
                    Tags:
                    <?php
                    $tags = explode(',', $File['tags']);
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
            </div>
        </div>
        <?php endif;?>

        <div class="related-Files">
            <?php
            $related_Files = $data['relatedFiles'];

            $i = 0;
            $j = 1;
            $apply_mobile_native_ads = true;
            foreach ($related_Files as $rFile) {
                echo $theme->render($rFile, 'File-teaser');
                $i++;

                if($i % 4 === 0  && is_mobile() && $j<= 3) {
                    include ('ads_templates/ad-native-'.$j.'.tpl.php');
                    $j++;
                    //$j = $j >=3 ? 1 : $j;
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

      getFile('<?php echo md5($File['source_url']);?>');

      function getFile(uuid) {
        jQuery('#File-loading').show();

        jQuery.ajax({
          type: 'GET',
          url: '<?=$api_server?>/parse_File/' + uuid,
          success: function(data) {
            if(data == false || data == null) {
              showAlert('Failed to load File now, please refresh the page and try again!');
            }
            else {
              renderFile(data);
            }
          },
          error: function(err) {
            showAlert('Failed to connect to File, please try later!');
          }
        });
      }

      function renderFile(FileData) {
        var FileHTML = '<File id="my_File" class="File" poster="<?=$File['thumbnail']?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">';
        if(FileData.quality_1080p != undefined && FileData.quality_1080p.length > 0) {
          let isHLS = isM3U8(FileData.quality_1080p);
          let type = isHLS ? 'application/x-mpegURL' : "File/mp4";
          FileHTML += '<source id="File_1080p" type="'+type+'" src="'+FileData.quality_1080p+'" title="1080p" data-fluid-hd res="1080">';
        }
        if(FileData.quality_720p != undefined && FileData.quality_720p.length > 0) {
          let isHLS = isM3U8(FileData.quality_720p);
          let type = isHLS ? 'application/x-mpegURL' : "File/mp4";
          FileHTML += '<source id="File_720p" type="'+type+'" src="'+FileData.quality_720p+'" title="720p" data-fluid-hd res="720">';
        }
        if(FileData.quality_480p != undefined && FileData.quality_480p.length > 0) {
          let isHLS = isM3U8(FileData.quality_480p);
          let type = isHLS ? 'application/x-mpegURL' : "File/mp4";
          FileHTML += '<source id="File_480p" type="'+type+'" src="'+FileData.quality_480p+'" title="480p" res="480">';
        }
        if(FileData.quality_360p != undefined && FileData.quality_360p.length > 0) {
          let isHLS = isM3U8(FileData.quality_360p);
          let type = isHLS ? 'application/x-mpegURL' : "File/mp4";
          FileHTML += '<source id="File_360p" type="'+type+'" src="'+FileData.quality_360p+'" title="360p" res="360">';
        }
        if(FileData.quality_240p != undefined && FileData.quality_240p.length > 0) {
          let isHLS = isM3U8(FileData.quality_240p);
          let type = isHLS ? 'application/x-mpegURL' : "File/mp4";
          FileHTML += '<source id="File_240p" type="'+type+'" src="'+FileData.quality_240p+'" title="240p" res="240">';
        }
        FileHTML += '</File>';

        jQuery('#File-holder').append(FileHTML);
        jQuery('#File-loading').hide();

        var vj = fluidPlayer(
          "my_File",
          {
            layoutControls: {
              fillToContainer: true,
              subtitlesEnabled: false,
              allowTheatre: false,
              autoPlay:  true,
              mute: true,
              playerInitCallback: (function() {
                jQuery("#my_File").bind("contextmenu",function(){ return false;});
              })
            },

            vastOptions: {
              "adList": [
                {
                  "roll": "preRoll",
                  "vastTag": "https://syndication.exosrv.com/splash.php?idzone=3502521"
                },
                {
                  "vAlign" : "middle",
                  "roll" : "onPauseRoll",
                  "nonlinearDuration" : 5,
                  "vastTag" : "https://syndication.exosrv.com/splash.php?idzone=3502535"
                }
              ]
            }
          }
        );
      }

      function isM3U8(url) {
        let urlArr = url.split('?');
        return urlArr[0].substr(urlArr[0].length - 5).toLowerCase() === '.m3u8';
      }

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