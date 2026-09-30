<?php
class BrandSection
{
    private $id, $heading, $paragraph;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getHeading()
    {
        return $this->heading;
    }
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    public function getParagraph()
    {
        return $this->paragraph;
    }
    public function setParagraph($paragraph)
    {
        $this->paragraph = $paragraph;
    }
}