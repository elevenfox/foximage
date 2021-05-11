<?php

/*
 * home page
 * @author: Elevenfox
 */

Class staticPageController extends ControllerCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
    $this->initMenu();
  }
  
  private function initMenu() {
      $items = array();

      $items['privacy-policy'] = array(
          'title' => 'Privacy Policy',
          'access callback' => TRUE,
          'template' => 'page-privacy',
      );

      $items['terms-conditions'] = array(
          'title' => 'Terms & Conditions',
          'access callback' => TRUE,
          'template' => 'page-term-condition',
      );

      $items['dmca-notice'] = array(
          'title' => 'DMCA Notice Of Copyright Infringement',
          'access callback' => TRUE,
          'template' => 'page-dmca',
      );

      $items['usc-2257'] = array(
          'title' => '18 USC 2257 Statement',
          'access callback' => TRUE,
          'template' => 'page-usc-2257',
      );


      Menu::setMenu($items, __CLASS__);
  }
  
  public function preStart() {
    parent::preStart();
  }

}