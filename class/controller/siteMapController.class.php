<?php

/*
 * home page
 * @author: Elevenfox
 */

Class siteMapController extends ControllerCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
    $this->initMenu();
  }
  
  private function initMenu() {
      $items = array();

      $items['sitemap'] = array(
          'access callback' => TRUE,
          'modelMethod' => 'genSiteMapIndex',
      );

      $items['sitemap.xml'] = array(
          'access callback' => TRUE,
          'modelMethod' => 'genSiteMapIndex',
      );

      $items['sitemap/%'] = array(
          'access callback' => TRUE,
          'modelMethod' => 'genSiteMapPage',
      );

      $items['robots.txt'] = array(
          'access callback' => TRUE,
          'modelMethod' => 'genRobotsTxt',
      );

      Menu::setMenu($items, __CLASS__);
  }
}