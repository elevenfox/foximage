<?php

/*
 * home page
 * @author: Elevenfox
 */

Class homePageController extends ControllerCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
    $this->initMenu();
  }
  
  private function initMenu() {
      $items = array();

      $items['newest'] = array(
          'title' => 'Newest Videos',
          'access callback' => TRUE,
          'modelMethod' => 'getNewest',
          'template' => 'page',
      );

      $items['newest/%'] = array(
          'title' => 'Newest Videos',
          'access callback' => TRUE,
          'modelMethod' => 'getNewest',
          'template' => 'page',
      );

      $items['search'] = array(
          'title' => 'Search Videos',
          'access callback' => TRUE,
          'modelMethod' => 'getSearchResult',
          'template' => 'page',
      );

      Menu::setMenu($items, __CLASS__);
  }
  
  public function preStart() {
    parent::preStart();
  }


}