<?php

/*
 * home page
 * @author: Elevenfox
 */

Class tagContentsController extends ControllerCore {

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->initMenu();
    }

    private function initMenu() {
        $items = array();

        $items['all-tags'] = array(
            'title' => 'Tags List',
            'access callback' => TRUE,
            'modelMethod' => 'getAllTags',
            'template' => 'page-tags',
        );

        $items['tags/%'] = array(
            'title' => 'Files with this tag',
            'access callback' => TRUE,
            'modelMethod' => 'getFilesByTag',
            'template' => 'page-tag-contents',
        );

        Menu::setMenu($items, __CLASS__);
    }

    public function preStart() {
        parent::preStart();
    }


}