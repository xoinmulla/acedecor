<?php
class Content {
    private $id;
    private $title;
    private $paragraph;
    private $image;
    private $type;
    private $brief;

    public function getType() { return $this->type; }
    public function setType($type) { $this->type = $type; }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }

    public function getBrief() { return $this->brief; }
    public function setBrief($brief) { $this->brief = $brief; }

    public function getParagraph() { return $this->paragraph; }
    public function setParagraph($paragraph) { $this->paragraph = $paragraph; }

    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; }
}
?>
