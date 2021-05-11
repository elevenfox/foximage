<?php

/*
 * home page
 * @author: Elevenfox
 */

Class userPageController extends ControllerCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
    $this->initMenu();
  }
  
  private function initMenu() {
      $items = array();

      $items['user/login'] = array(
          'title' => 'User Account',
          'access callback' => TRUE,
          'template' => 'page-user-login',
      );

      $items['user/logout'] = array(
          'title' => 'User Account',
          'access callback' => TRUE,
          'modelMethod' => 'userLogout',
      );

      $items['user/register'] = array(
          'title' => 'User Account',
          'access callback' => TRUE,
          'template' => 'page-user-register',
      );

//      $items['user/%'] = array(
//          'title' => 'User Account',
//          'access callback' => TRUE,
//          'modelMethod' => 'getUser',
//          'template' => 'page-user',
//      );

      $items['user/password'] = array(
          'title' => 'Reset Password',
          'access callback' => TRUE,
          'template' => 'page-user-reset-pw',
      );

      $items['user'] = array(
          'title' => 'User Account',
          'access callback' => TRUE,
          'modelMethod' => 'userAction',
          'template' => 'page-user',
      );

      Menu::setMenu($items, __CLASS__);
  }
  
  public function preStart() {
    parent::preStart();
  }


}