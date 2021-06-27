<?php

/*
 * home page
 * @author: Elevenfox
 */

Class fileDetailPageController extends ControllerCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
    $this->initMenu();
  }
  
  private function initMenu() {
      $items = array();

      $items['file/%'] = array(
          'title' => 'File page',
          'access callback' => TRUE,
          'modelMethod' => 'getFile',
          'template' => 'page-file',
      );
      $items['file_thumbnail/%/th.jpg'] = array(
          'title' => 'File page',
          'access callback' => TRUE,
          'modelMethod' => 'getFileThumbnail',
      );
      $items['file_content/%/%/fc.jpg'] = array(
        'title' => 'File page',
        'access callback' => TRUE,
        'modelMethod' => 'getFileContent',
      );

      Menu::setMenu($items, __CLASS__);
  }
  
  public function preStart() {
    parent::preStart();
  }


}