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
          'title' => 'Newest Photos',
          'access callback' => TRUE,
          'modelMethod' => 'getNewest',
          'template' => 'page',
      );

      $items['newest/%'] = array(
          'title' => 'Newest Photos',
          'access callback' => TRUE,
          'modelMethod' => 'getNewest',
          'template' => 'page',
      );

      $items['newest-2'] = array(
        'title' => 'Newest Photos',
        'access callback' => TRUE,
        'modelMethod' => 'getNewest_real',
        'template' => 'page',
      );

      $items['newest-2/%'] = array(
        'title' => 'Newest Photos',
        'access callback' => TRUE,
        'modelMethod' => 'getNewest_real',
        'template' => 'page',
      );

      $items['search'] = array(
          'title' => 'Search Photos',
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