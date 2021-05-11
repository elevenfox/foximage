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

    public function getVideosByTag() {
        $page = empty($this->request->arg[2]) ? 1 : (int)$this->request->arg[2];
        $this->data['page'] = $page;

        $tagName = str_replace('-', ' ', $this->request->arg[1]);
        $this->data['tagName'] = ucfirst($tagName);

        $res = Tag::getVideosByTag($tagName, $page);
        $this->data['videos'] = $res;

        $count = Tag::getVideosByTagCount($tagName);
        $this->data['videos_total'] = $count;

        if(empty($this->data['videos'])) {
            $videos = Video::getRelatedVideosById(1);
            $this->data['otherVideos'] = $videos;
        }
    }

    public function getAllTags() {
        $page = empty($this->request->arg[1]) ? 1 : $this->request->arg[1];
        $this->data['page'] = $page;


        $res = Tag::getAllTags($page);
        $this->data['tags'] = $res;

        $count = Tag::getAllTagsCount();
        $this->data['tags_total'] = $count;
    }
}