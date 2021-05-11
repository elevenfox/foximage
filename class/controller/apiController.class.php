<?php

/*
 * home page
 * @author: Elevenfox
 */

Class apiController extends ControllerCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
    $this->initMenu();
  }
  
  private function initMenu() {
      $items = array();

      $items['api'] = array(
          'access callback' => TRUE,
      );

      Menu::setMenu($items, __CLASS__);
  }
  
  public function start() {
    include_once ('./video_api.php');
    exit;
  }


}