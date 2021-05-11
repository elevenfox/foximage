<?php

/*
 * home page
 * @author: Elevenfox
 */

Class videoDetailPageController extends ControllerCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
    $this->initMenu();
  }
  
  private function initMenu() {
      $items = array();

      $items['video/%'] = array(
          'title' => 'Video page',
          'access callback' => TRUE,
          'modelMethod' => 'getVideo',
          'template' => 'page-video',
      );

      Menu::setMenu($items, __CLASS__);
  }
  
  public function preStart() {
    parent::preStart();
  }


}