<?php

/*
 * admin view class
 * @author: Elevenfox
 */
Class tagContentsView extends ViewCore {
  private $listPerPage = 20;
  private $listTagsPerPage = 120;
  
  public function preDisplay() {
    parent::preDisplay();

    //ZDebug::my_print($this->data['tags_total']);exit;

    // Set header if needed
    if(empty($this->data['tagName'])) {
          $this->setHeader("All Tags", 'title');
    }
    else {
        $this->setHeader(ucwords($this->data['tagName']), 'title');

        // Set meta description
        $this->data['meta_desc'] = $this->data['tagName'] . ' files - ' .  $this->data['meta_desc'];

        // Set meta keyword
        $this->data['meta_keywords'] = $this->data['tagName'] . ',' . $this->data['meta_keywords'];
    }


    if(!empty($this->data['files'])) {
      $currentPage = empty($this->data['page']) ? 1 : $this->data['page'];
      import('Pager');
      $pager = new Pager(
              $this->listPerPage,
              (int)$this->data['files_total'],
              $currentPage,
              '/tags/'.str_replace(' ', '-', strtolower($this->data['tagName'])).'/'
      );
      $pagerHtml = $pager->generatePages();

      $this->data['filesPager'] = $pagerHtml;
    }

    if(!empty($this->data['tags'])) {
          $currentPage = empty($this->data['page']) ? 1 : $this->data['page'];
          import('Pager');
          $pager = new Pager(
              $this->listTagsPerPage,
              (int)$this->data['tags_total'],
              $currentPage,
              '/all-tags/'
          );
          $pagerHtml = $pager->generatePages();

          $this->data['filesPager'] = $pagerHtml;
    }
  }
}