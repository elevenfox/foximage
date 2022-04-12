<?php

/*
 * This is the model for home page
 * @author: Eric
 */

import('dao.File');

Class homePageModel extends ModelCore {
  
  public function __construct(Request $request) {
    parent::__construct($request);
  }

  public function make() {
      parent::make();
  }

  public function getNewest() {
    $page = empty($this->request->arg[1]) ? 1 : $this->request->arg[1];
    $this->data['page'] = $page;

    $res = File::getFilesRand($page);
    $this->data['files'] = $res;

    $count = File::getAllFilescount();
    $this->data['files_total'] = $count;

    $this->data['pageTitle'] = 'Newest';
  }

  public function getNewest_real() {
    $page = empty($this->request->arg[1]) ? 1 : $this->request->arg[1];
    $this->data['page'] = $page;

    $res = File::getFiles($page);
    $this->data['files'] = $res;

    $count = File::getAllFilescount();
    $this->data['files_total'] = $count;

    $this->data['pageTitle'] = 'Newest';
  }

  public function defaultMake()
  {
      $this->getNewest();
  }

  public function getSearchResult() {
      if(empty($this->request->getSysRequest()['term'])) {
          $this->getNewest();
      }
      else {
          $term = $this->request->getSysRequest()['term'];
          $this->data['keywords'] = $term;

          $this->data['pageTitle'] = '搜索: ' . $term;

          $page = empty($this->request->arg[1]) ? 1 : $this->request->arg[1];
          $this->data['page'] = $page;

          $res = File::searchFile($term, $page);

          $this->data['files'] = empty($res) ? [] : $res;

          $count = File::searchFileCount($term);
          $this->data['files_total'] = $count;

      }
  }
}