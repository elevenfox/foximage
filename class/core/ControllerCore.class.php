<?php

/*
 * Basic controller class
 * @Author: Elevenfox
 */

Class ControllerCore {
  
  public $request;
  public $model;
  public $view;

  /*
   * This is the construnt of controller, Resquest came from router
   * InitMenu is to register menu for router
   */
  public function __construct(Request $request) {
    $this->request = $request;
    $this->initMenu();
  }
  
  /*
   * Set menu here, a menu is a url request
   */
  private function initMenu() {
    $items = array();
    Menu::setMenu($items, __CLASS__);
  }
  
  public function preStart() {
    // Sub class can override this function if needed
  }
  
  public function afterStart() {
    // Sub class can override this function if needed
  }

  /*
   * This run fucntion is a core function for a controller, it will call model
   * class to get data, and then call view class to render html with templates.
   */
  public function start() {
    if(!isAdmin()) {
      // Set browser cache for 1 hour
      header('Cache-Control: public, max-age=3600');
      header('Expires: ' . date('D, j M Y H:m:s T', time() + 3600));

      //////// Use ETag to cache 1 url for 1 hour in browser
      // Get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
      $etagHeader=(isset($this->request->getServer()['HTTP_IF_NONE_MATCH']) ? trim($this->request->getServer()['HTTP_IF_NONE_MATCH']) : false);
      $uri = $this->request->getServer()['REQUEST_URI'];
      $eTag = md5($uri.date('Y-m-d H'));
      header("Etag: $eTag");
      if($etagHeader == $eTag) {
        header("HTTP/1.1 304 Not Modified");
        exit;
      }
    }

    $this->preStart();
    
    $this->getModel();    
    $this->model->make();

    $this->buildBlockData(get_class($this->model));

    $this->getView();
    $this->view->display();

    $this->afterStart();


  }
  
  private function getModel() {
    $menuItem = $this->request->getMenuItem();
    
    // Get Model class name
    $modelClassName = str_replace('Controller', 'Model', $menuItem['controller']);
    
    // Call model class and call menu callback function
    if(import('model', $modelClassName, TRUE)) {
      $model = new $modelClassName($this->request);
    }    
    else {
      $model = new ModelCore($this->request);
    }
    $this->model = $model;
  }
  
  private function getView() {
    $menuItem = $this->request->getMenuItem();
    
    // Get view class name
    $viewClassName = str_replace('Controller', 'View', $menuItem['controller']);

    // Call view class, pass request and model data to the view
    if(import('view', $viewClassName, TRUE)) {
      $view = new $viewClassName($this->request, $this->model->data);
    }
    else {
      $view = new ViewCore($this->request, $this->model->data);
    }

    $this->view = $view;
  }
  
  private function buildBlockData($modelName) {
    
    //$menuItem = $this->request->getMenuItem();
    
    // Load blocks and get blocks data here, based on menu's block settings
    $blocks = array();

    foreach (Block::$blocks as $blockName => $block) {
      if($block['model'] == $modelName || $block['model'] == 'ModelCore') {
          if (import('model', $block['model'], TRUE)) {
              $theModel = new $block['model']($this->request);
          } else {
              $theModel = new ModelCore($this->request);
          }

          $blockCallBack = $block['callBack'];

          $block['data'] = $theModel->$blockCallBack();
          $blocks[$blockName] = $block;
      }
    }

    $this->model->data['blocks'] = $blocks;
  }
  
}