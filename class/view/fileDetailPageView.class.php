<?php

/*
 * admin view class
 * @author: Elevenfox
 */
Class fileDetailPageView extends ViewCore {

  public function preDisplay() {
    parent::preDisplay();

    // Set title in header
    $this->setHeader($this->data['file']['title'], 'title');

    // Set meta description
    $this->data['meta_desc'] = $this->data['file']['title'] . ' - ' .  $this->data['meta_desc'];

    // Set meta keyword
    $this->data['meta_keywords'] = implode(', ', titleToKeywords($this->data['file']['title'])) . ', ' . $this->data['file']['tags'] . ',' . $this->data['meta_keywords'];
  }
}