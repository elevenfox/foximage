<?php

/*
 * admin view class
 * @author: Elevenfox
 */
Class homePageView extends ViewCore {
  private $listPerPage = 24;
  
  public function preDisplay() {
    parent::preDisplay();

    // Set header if needed
    $title = '最新美女写真图片推荐';
    $this->setHeader($title, 'title');
    

    if(!empty($this->data['files'])) {
      $currentPage = empty($this->data['page']) ? 1 : $this->data['page'];

      if(!empty($this->request->getSysRequest()['term'])) {
        $term = $this->request->getSysRequest()['term'];
        $url = '/search/';
        $appended = '?term=' . $term;
      }
      else {
        $url = '/newest/';
        $appended = '';
      }

      import('Pager');
      $pager = new Pager(
              $this->listPerPage,
              (int)$this->data['files_total'],
              $currentPage,
              $url,
              $appended
            );
      $pagerHtml = $pager->generatePages();

      $this->data['filesPager'] = $pagerHtml;

      //$this->addJS('/js/thumbnail.js', 'footer');
    }
  }
}