<?php

/*
 * This is the model for home page
 * @author: Eric
 */

import('dao.File');

Class fileDetailPageModel extends ModelCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
  }

  public function make() {
      $this->preMake();

      parent::make();

      $this->afterMake();
  }

  public function getFile() {
    $fileAlias = empty($this->request->arg[1]) ? '' : $this->request->arg[1];
    $fileId = empty($this->request->arg[2]) ? '' : $this->request->arg[2];

    $res = null;
    if(ctype_digit($fileAlias)) {
       // @TODO Will disable this to normal users later
       $res = File::getFileByID($fileAlias);  // file/123/<title>
    }
    else {
      if (ctype_digit($fileId)) {
          $res = File::getFileByID($fileId); // video/<title>/123
      }
      else {
          $res = File::getFileByMd5($fileId); // video/<title>/<md5>
      }
    }

    // increase view count here since this is for sure a file-view
    if(!empty($res)) {
        File::updateViewCount($res['id']);
    }

    if(empty($res)) {
        $this->data['not-found'] = true;
    }

    $this->data['file'] = $res;
    $this->data['relatedFiles'] = File::getRelatedFilesById($fileId);

  }


public function getFileThumbnail() {
    $fileId = empty($this->request->arg[1]) ? '' : $this->request->arg[1];

    $res = File::getFileByMd5($fileId); // file/<md5>/th.jpg
    if(!empty($res)) {
      $referrer = getReferrer($res['source']);
      $image_content = curl_call(str_replace('http://', 'https://',$res['thumbnail']), 'get', null, ['referrer'=>$referrer]);
    }
    header('Content-type: image/jpeg');
    echo $image_content;
    exit;
}

public function getFileContent() {
  $fileId = empty($this->request->arg[1]) ? '' : $this->request->arg[1];
  $file = File::getFileByMd5($fileId); // file/<md5>/<num>/fc.jpg

  $images = explode(',', $file['filename']);
  $num = empty($this->request->arg[2]) ? 1 : $this->request->arg[2];
  $num = $num >= count($images) ? count($images) : $num;
  $cur_image_url = $images[$num-1];

  if(!empty($cur_image_url)) {
    $referrer = getReferrer($file['source']);
    $image_content = curl_call($cur_image_url, 'get', null, ['referrer'=>$referrer]);
  }
  header('Content-type: image/jpeg');
  echo $image_content;
  exit;
}

  public function defaultMake()
  {
      $this->getFile();
  }
}