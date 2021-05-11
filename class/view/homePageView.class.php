<?php

/*
 * admin view class
 * @author: Elevenfox
 */
Class homePageView extends ViewCore {
  private $listPerPage = 20;
  
  public function preDisplay() {
    parent::preDisplay();

    // Set header if needed
    $title = $this->data['pageTitle'] ? $this->data['pageTitle'] : 'Newest';
    $this->setHeader($title, 'title');
    

    if(!empty($this->data['videos'])) {
      $currentPage = empty($this->data['page']) ? 1 : $this->data['page'];
      import('Pager');
      $pager = new Pager(
              $this->listPerPage,
              (int)$this->data['videos_total'],
              $currentPage,
              '/newest/');
      $pagerHtml = $pager->generatePages();

      $this->data['filesPager'] = $pagerHtml;

      //$this->addJS('/js/thumbnail.js', 'footer');
    }
  }
}