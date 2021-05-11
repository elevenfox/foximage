<?php

/*
 * This is the model for home page
 * @author: Eric
 */

import('dao.Video');

Class videoDetailPageModel extends ModelCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
  }

  public function make() {
      $this->preMake();

      parent::make();

      $this->afterMake();
  }

  public function getVideo() {
    $videoAlias = empty($this->request->arg[1]) ? '' : $this->request->arg[1];
    $videoId = empty($this->request->arg[2]) ? '' : $this->request->arg[2];

    $res = null;
    if(ctype_digit($videoAlias)) {
       // @TODO Will disable this to normal users later
       $res = Video::getVideoByID($videoAlias);  // video/123/<title>
    }
    elseif($videoAlias == 'video' && !empty($videoId)) {
        $res = Video::getVideoByUrlAlias($videoId); // video/video/<text> --> this is a weird case
    }
    else {
        if(empty($videoId)) {
            $res = Video::getVideoByUrlAlias($videoAlias); // video/<title>
        }
        else {
            if (ctype_digit($videoId)) {
                $res = Video::getVideoByID($videoId); // video/<title>/123
            }
            else {
                $res = Video::getVideoByMd5($videoId); // video/<title>/<md5>
            }
        }
    }

    // increase view count here since this is for sure a video-view
    if(!empty($res)) {
        Video::updateViewCount($res['source_url_md5']);
    }

    if(empty($res)) {
        $this->data['not-found'] = true;
    }

    $this->data['video'] = $res;
    $this->data['relatedVideos'] = Video::getRelatedVideosById($videoId);

  }

  public function defaultMake()
  {
      $this->getVideo();
  }
}