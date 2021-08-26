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
    

    if(!empty($this->data['files'])) {
      $currentPage = empty($this->data['page']) ? 1 : $this->data['page'];

      if(!empty($this->request->getSysRequest()['search_term'])) {
        $term = $this->request->getSysRequest()['search_term'];
        $url = '/search/';
        $_SERVER['QUERY_STRING'] = 'search_term=' . $term;
      }
      else {
        $url = '/newest';
      }

      import('Pager');
      $pager = new Pager(
              $this->listPerPage,
              (int)$this->data['files_total'],
              $currentPage,
              $url);
      $pagerHtml = $pager->generatePages();

      $this->data['filesPager'] = $pagerHtml;

      //$this->addJS('/js/thumbnail.js', 'footer');
    }
  }
}