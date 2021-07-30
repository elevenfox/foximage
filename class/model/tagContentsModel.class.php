<?php

/*
 * This is the model for home page
 * @author: Eric
 */

Class tagContentsModel extends ModelCore {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function make() {
        parent::make();
    }

    public function getFilesByTag() {
        $page = empty($this->request->arg[2]) ? 1 : (int)$this->request->arg[2];
        $this->data['page'] = $page;

        $tagName = str_replace('-', ' ', $this->request->arg[1]);
        $this->data['tagName'] = ucfirst($tagName);

        $res = Tag::getFilesByTag($tagName, $page);
        $this->data['files'] = $res;

        $count = Tag::getFilesByTagCount($tagName);
        $this->data['files_total'] = $count;

        if(empty($this->data['files'])) {
            $files = File::getRelatedFilesById(1);
            $this->data['otherFiles'] = $files;
        }
    }

    public function getAllTags() {
        $page = empty($this->request->arg[1]) ? 1 : $this->request->arg[1];
        $this->data['page'] = $page;

        $sort = empty($this->request->getSysRequest()['sort']) ? '1' : $this->request->getSysRequest()['sort'];
        
        $res = Tag::getAllTags($page, 120, $sort);
        $this->data['tags'] = $res;

        $count = Tag::getAllTagsCount();
        $this->data['tags_total'] = $count;
    }
}