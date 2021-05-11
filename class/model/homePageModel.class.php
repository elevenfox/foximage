<?php

/*
 * This is the model for home page
 * @author: Eric
 */

import('dao.Video');

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

    $res = Video::getVideos($page);
    $this->data['videos'] = $res;

    $count = Video::getAllVideoscount();
    $this->data['videos_total'] = $count;

    $this->data['pageTitle'] = 'Newest';
  }

  public function defaultMake()
  {
      $this->getNewest();
  }

  public function getSearchResult() {
      if(empty($this->request->getSysRequest()['search_term'])) {
          $this->getNewest();
      }
      else {
          $term = $this->request->getSysRequest()['search_term'];

          $this->data['pageTitle'] = 'Search for: ' . $term;

          $page = empty($this->request->arg[1]) ? 1 : $this->request->arg[1];
          $this->data['page'] = $page;

          $res = Video::searchVideo($term, $page);

          $this->data['videos'] = $res;

          $count = Video::searchVideoCount($term);
          $this->data['videos_total'] = $count;
      }
  }
}