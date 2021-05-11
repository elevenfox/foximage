<?php

/*
 * admin view class
 * @author: Elevenfox
 */
Class videoDetailPageView extends ViewCore {

  public function preDisplay() {
    parent::preDisplay();

    // Set title in header
    $this->setHeader($this->data['video']['title'], 'title');

    // Set meta description
    $this->data['meta_desc'] = $this->data['video']['title'] . ' - ' .  $this->data['meta_desc'];

    // Set meta keyword
    $this->data['meta_keywords'] = $this->data['video']['tags'] . ',' . $this->data['meta_keywords'];
  }
}