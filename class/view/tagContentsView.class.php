<?php

/*
 * admin view class
 * @author: Elevenfox
 */
Class tagContentsView extends ViewCore {
  private $listPerPage = 24;
  private $listTagsPerPage = 120;
  
  public function preDisplay() {
    parent::preDisplay();

    //ZDebug::my_print($this->data['tags_total']);exit;

    // Set header if needed
    if(empty($this->data['tagName'])) {
          $this->setHeader("全部美女写真图片分类", 'title');
    }
    else {
        $this->setHeader(ucwords($this->data['tagName']), 'title');

        // Set meta description
        $this->data['meta_desc'] = $this->data['tagName'] . ' files - ' .  $this->data['meta_desc'];

        // Set meta keyword
        $this->data['meta_keywords'] = $this->data['tagName'] . ', ' . $this->data['meta_keywords'];
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
          $url = '/all-tags/';
          $appended = '';
          if(!empty($this->request->getSysRequest()['sort'])) {
            $sort = $this->request->getSysRequest()['sort'];
            $appended = '?sort=' . $sort;
          }

          $currentPage = empty($this->data['page']) ? 1 : $this->data['page'];
          import('Pager');
          $pager = new Pager(
              $this->listTagsPerPage,
              (int)$this->data['tags_total'],
              $currentPage,
              $url,
              $appended
          );
          $pagerHtml = $pager->generatePages();

          $this->data['filesPager'] = $pagerHtml;
    }
  }
}