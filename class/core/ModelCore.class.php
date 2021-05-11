<?php

/*
 * Model core class
 * @auther: Elevenfox
 */
import('dao.User');

Class ModelCore {
  public $request;
  public $db;
  public $data = array();

  public function __construct(Request $request) {
    $this->request = $request;
    $this->db = DB::$dbInstance;
    $this->initCoreBlock();
  }
  
  /*
   * initBlock is a necessary function for model class
   * to define block
   */
  public function initCoreBlock() {
    $items['blockHeader'] = array(
      'weight' => 1,
      'callBack' => 'blockHeaderData'
    );
    $items['blockFooter'] = array(
      'weight' => 1,
      'callBack' => 'blockFooterData'
    );
    
    Block::setBlock($items, __CLASS__);
  }
  
  public function blockHeaderData() {
    
    $headerData['site_logo'] = Config::get('site_logo');

    $menuLinks = [];
    $menuLinksConfig = Config::get('menuLinks');
    if(!empty($menuLinksConfig) && is_array($menuLinksConfig)) {
        foreach ($menuLinksConfig as $name => $link) {
          $menuLinks[] = ['name'=>$name, 'url'=>$link];
        }
    }
    $headerData['menuLinks'] = $menuLinks;

    // Get current nav-menu
    $headerData['currentUrl'] = empty($this->request->getMenuItem()['url']) ? '/newest' : '/'.$this->request->getMenuItem()['url'];

    return $headerData;
  }
  
  public function blockFooterData() {
    
  }
  
  public function preMake() {
    
  }
  
  public function make() {
      $this->preMake();

      // Set User info data
      $user = User::getCurrentUser();
      $this->data['currentUser'] = $user;

      // Call menuItem modelMethod
      $menuItem = $this->request->getMenuItem();
      if (!empty($menuItem['modelMethod'])) {
          $method = $menuItem['modelMethod'];
          $this->$method();
      }
      else  {
          $this->defaultMake();
      }

      $this->afterMake();
  }
  
  public function defaultMake() {
    
  }
  
  public function afterMake() {

  }
          
}