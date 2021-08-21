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
    $this->data['relatedFiles'] = File::getRelatedFilesById($res['id']);

  }

  public function getFileThumbnail() {
      $fileId = empty($this->request->arg[1]) ? '' : $this->request->arg[1];

      $img_data = null;
      $res = File::getFileByMd5($fileId); // file/<md5>/th.jpg
      if(!empty($res)) {
        $row = $res;
        // Build physical path: Use <file_root>/source/<file_title>/ as file structure
        $physical_path = buildPhysicalPath($row);

        // If folder not exist, create the folder
        if(!is_dir($physical_path)) {
            $res = mkdir($physical_path, 0755, true);
            if(!$res) {
                error_log(" ----- failed to create directory: " . $physical_path );
            }
        }

        $fullname = $physical_path . '/thumbnail.jpg';
        // if file does not exist locally or force_download, then download it
        if(!file_exists($fullname)) {
          $referrer = getReferrer($row['source']);  
          $tn_url = str_replace('http://', 'https://', $row['thumbnail']);
          $tn_url = str_replace('tjg.hywly.com', 'tjg.gzhuibei.com', $tn_url);
          $result = curl_call($tn_url, 'get', null, ['timeout'=>10,'referrer'=>$referrer]);
          if(!empty($result)) {
              $res = file_put_contents($fullname, $result);
              chmod($fullname, 0755);
              if(!$res) {
                  error_log(" ----- failed to save thumbnail: " . $fullname);    
              }
              else {
                $img_data = $result;
              }
          }
          else {
              error_log(" ---- failed to download: " . $tn_url ); 
          }
        }
        else {
          $img_data = file_get_contents($fullname);
        }
      }

      header('Content-type: image/jpeg');
      echo $img_data;
      exit;
  }

  public function getFileContent() {
    $fileId = empty($this->request->arg[2]) ? '' : $this->request->arg[2];
    $file = File::getFileByMd5($fileId); // jw-photos/file_content/<md5>/<num>/fc.jpg

    $images = explode(',', $file['filename']);
    $num = empty($this->request->arg[3]) ? 1 : $this->request->arg[3];
    $num = $num >= count($images) ? count($images) : $num;
    $cur_image_url = $images[$num-1];

    $image_content = null;

    /* 2021-08-13 Looks like tujigu blocked our domain name, have to use dev for now */
    // if(!empty($cur_image_url)) {
    //   $referrer = getReferrer($file['source']);
    //   $image_content = curl_call($cur_image_url, 'get', null, ['timeout'=>10, 'referrer'=>$referrer]);
    // }

    
    // Tr to get relative_fullname first, Onedrive and dev url will both need it
    $relative_fullname = null;
    if(!empty($cur_image_url)) {
      $name_arr = explode('/', $cur_image_url);
      $filename = array_pop($name_arr);
      $physical_path = buildPhysicalPath($file);
      $file_root = Config::get('file_root');
      if(empty($file_root)) {
        $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
      }
      $relative_path = str_replace($file_root, '', $physical_path);
      
      $relative_fullname = '/jw-photos/' . $relative_path . '/' . $filename;
    }

    
    // test Baidipan class (working!)
    // import('Baidupan');
    // $list = Baidupan::get_file_list_by_path('/jw-photos/' . $relative_path);
    // $fs_id = null;
    // foreach($list as $f) {
    //     if($f->path == $relative_fullname) { 
    //       $fs_id = $f->fs_id;
    //     }
    // }
    // $image_content = Baidupan::get_photo_content($fs_id);
    // header('Content-type: image/jpeg');
    // echo $image_content;
    // exit;


    // First try to use Onedrive to get photo
    if(!empty($relative_fullname)) {
      // Try to use Onedrive for photo storage for now
      import('Onedrive');  
      $image_content = Onedrive::get_photo_content($relative_fullname);
    }

    // Use Wasabi S3 to serve the photo
    // if(!empty($relative_fullname)) {
    //   // Use Wasabi S3
    //   import('Wasabi');
    //   $w3 = new Wasabi();
    //   $key = $relative_path . '/' . $filename;
    //   $res = $w3->get_photo_content($key);
    //   if(!empty($res['Body'])) {
    //     $image_content = $res['Body'];
    //   }
    // }

    // // Use B2 to serve the photo
    // if(!empty($relative_fullname)) {
    //   // Use BackBlaze B2
    //   $base_b2_url = 'https://jw-photos-2021.s3.us-west-002.backblazeb2.com/';
    //   $key = $relative_path . '/' . $filename;
    //   $url = $base_b2_url . $key;
    //   error_log('---- url: ' . $url);
    //   $res = curl_call($url);
    //   if(!empty($res) || stripos($res, 'Key not found') === false) {
    //     $image_content = $res;
    //     error_log('---- good, using b2');
    //   }
    // }
    
    // If not found in cloud, use dev
    if( empty($image_content) 
         || stripos($image_content, '404 Not Found') !== false 
         || stripos($image_content, 'itemNotFound') !== false
         || stripos($image_content, 'key does not exist') !== false ) 
    {   
      error_log('----- using dev image');
      $dev_url = 'http://dev.tuzac.com' . $relative_fullname; 
      $image_content = curl_call($dev_url, 'get', null, ['timeout'=>10]);
    }
    else {
      error_log('----- using Onedrive image');
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