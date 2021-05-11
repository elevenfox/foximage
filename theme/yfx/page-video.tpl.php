<?php
/* @var Array $data */
/* @var Theme $theme */


include 'header.tpl.php';

$video = $data['video'];

$api_server = Config::get('api_server');
$api_server = empty($api_server) ? get_default_video_api_url() : $api_server;
?>

    <script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>

    <style>
        .fluid_video_wrapper {
            position: absolute;
            top: 0;
        }
        #my_video_fluid_control_theatre {
            display: none;
        }
        .fluid_video_wrapper.mobile {
            height: 100% !important;
        }
    </style>


<div class="content-container video-detail-page">

    <article class="video content" itemscope itemtype="http://schema.org/VideoObject">

        <header style="text-align: left">
          <?php if(!empty($data['not-found'])) : ?>
              <h1>Video not found</h1>
              <p>&nbsp;</p>
              <h4><i>You might want to see other videos: </i></h4>
          <?php else:?>
            <h1 itemprop="name"><?= $video['title'] ?></h1>

            <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

            <p class="tags">
                Tags:
                <?php
                $tags = explode(',', $video['tags']);
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
                    <div id="video-holder" style="width:100%; padding-top: 56.25%; position: relative;background: black;background:url('<?=$video['thumbnail']?>') no-repeat left center; background-size:100%; display: flex"></div>
                    <div id="video-loading" style="display:none; position: absolute; opacity: 0.7; background-color: black; top: 0px; height: 100%; width: 100%;">
                        <div id="loading" style="border: 8px solid #f3f3f3;border-radius: 50%;border-top: 8px solid #3498db;width: 42px;height: 42px;position: relative;z-index: 999;top: 45%;left: 46%;-webkit-animation: spin 2s linear infinite;animation: spin 2s linear infinite;">
                            <style>
                                @-webkit-keyframes spin {0% { -webkit-transform: rotate(0deg); }100% { -webkit-transform: rotate(360deg); }}
                                @keyframes spin {0% { transform: rotate(0deg); }100% { transform: rotate(360deg); }}
                            </style>
                        </div>
                    </div>
                </div>

            </div>
            <div class="video-detail">
                <div id="video-title" class="video-title" itemprop="name"><h2><?=$video['title']?></h2></div>
                <div class="video-info">Uploaded By: <?=$video['user_name']?></div>
                <div class="video-info" itemprop="userInteractionCount">Views: <?=$video['view_count'] ? number_format($video['view_count']) : rand(1, 500) ?></div>
                <div class="video-tags">
                    Tags:
                    <?php
                    $tags = explode(',', $video['tags']);
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

        <div class="related-videos">
            <?php
            $related_videos = $data['relatedVideos'];

            $i = 0;
            $j = 1;
            $apply_mobile_native_ads = true;
            foreach ($related_videos as $rVideo) {
                echo $theme->render($rVideo, 'video-teaser');
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
                function randStr(e,t){for(var n="",r=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",o=0;o<e;o++)n+=r.charAt(Math.floor(Math.random()*r.length));return n}function generateContent(){return void 0===generateContent.val&&(generateContent.val=" \ndocument.dispatchEvent("+randStr(4*Math.random()+3)+");"),generateContent.val}try{Object.defineProperty(document.currentScript,"innerHTML",{get:generateContent}),Object.defineProperty(document.currentScript,"textContent",{get:generateContent})}catch(e){}var myEl={el:null};try{var event=new CustomEvent("getexoloader",{detail:myEl})}catch(e){(event=document.createEvent("CustomEvent")).initCustomEvent("getexoloader",!1,!1,myEl)}window.document.dispatchEvent(event);var ExoLoader=myEl.el;
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

      getVideo('<?php echo md5($video['source_url']);?>');

      function getVideo(uuid) {
        jQuery('#video-loading').show();

        jQuery.ajax({
          type: 'GET',
          url: '<?=$api_server?>/parse_video/' + uuid,
          success: function(data) {
            if(data == false || data == null) {
              showAlert('Failed to load video now, please refresh the page and try again!');
            }
            else {
              renderVideo(data);
            }
          },
          error: function(err) {
            showAlert('Failed to connect to video, please try later!');
          }
        });
      }

      function renderVideo(videoData) {
        var videoHTML = '<video id="my_video" class="video" poster="<?=$video['thumbnail']?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">';
        if(videoData.quality_1080p != undefined && videoData.quality_1080p.length > 0) {
          let isHLS = isM3U8(videoData.quality_1080p);
          let type = isHLS ? 'application/x-mpegURL' : "video/mp4";
          videoHTML += '<source id="video_1080p" type="'+type+'" src="'+videoData.quality_1080p+'" title="1080p" data-fluid-hd res="1080">';
        }
        if(videoData.quality_720p != undefined && videoData.quality_720p.length > 0) {
          let isHLS = isM3U8(videoData.quality_720p);
          let type = isHLS ? 'application/x-mpegURL' : "video/mp4";
          videoHTML += '<source id="video_720p" type="'+type+'" src="'+videoData.quality_720p+'" title="720p" data-fluid-hd res="720">';
        }
        if(videoData.quality_480p != undefined && videoData.quality_480p.length > 0) {
          let isHLS = isM3U8(videoData.quality_480p);
          let type = isHLS ? 'application/x-mpegURL' : "video/mp4";
          videoHTML += '<source id="video_480p" type="'+type+'" src="'+videoData.quality_480p+'" title="480p" res="480">';
        }
        if(videoData.quality_360p != undefined && videoData.quality_360p.length > 0) {
          let isHLS = isM3U8(videoData.quality_360p);
          let type = isHLS ? 'application/x-mpegURL' : "video/mp4";
          videoHTML += '<source id="video_360p" type="'+type+'" src="'+videoData.quality_360p+'" title="360p" res="360">';
        }
        if(videoData.quality_240p != undefined && videoData.quality_240p.length > 0) {
          let isHLS = isM3U8(videoData.quality_240p);
          let type = isHLS ? 'application/x-mpegURL' : "video/mp4";
          videoHTML += '<source id="video_240p" type="'+type+'" src="'+videoData.quality_240p+'" title="240p" res="240">';
        }
        videoHTML += '</video>';

        jQuery('#video-holder').append(videoHTML);
        jQuery('#video-loading').hide();

        var vj = fluidPlayer(
          "my_video",
          {
            layoutControls: {
              fillToContainer: true,
              subtitlesEnabled: false,
              allowTheatre: false,
              autoPlay:  true,
              mute: true,
              playerInitCallback: (function() {
                jQuery("#my_video").bind("contextmenu",function(){ return false;});
              })
            },

            vastOptions: {
              "adList": [
                {
                  "roll": "preRoll",
                  "vastTag": "https://syndication.realsrv.com/splash.php?idzone=2598179"
                },
                {
                  "vAlign" : "middle",
                  "roll" : "onPauseRoll",
                  "vastTag" : "https://syndication.realsrv.com/splash.php?idzone=3287794"
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
