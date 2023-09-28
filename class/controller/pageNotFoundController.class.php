<?php

/*
 * This is the "page not found"(404) controller
 * @Author: Elevenfox
 */

Class pageNotFoundController extends ControllerCore {
  
  /*
   * This run fucntion is a core function for a controller, it will call model
   * class to get data, and then call view class to render html with templates.
   */
  public function start() {
    $this->request->setMenuItem([
        'controller' => 'pageNotFoundController',
        'url' => $this->request->getServer()['REQUEST_URI'],
        'template' => 'page-404',
        'title' => 'Page Not Found',
    ]);

    parent::start();
  }
}