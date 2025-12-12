<?php

class enqCatMappingModel implements JsonSerializable
{
    private $name;
    private $enqId;
    private $catId;
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
            [
                'name' => $this->name,
                'enqId' => $this->enqId,
                'catId' => $this->catId
            ];
        
    }
    function get_enqId(){
        return $this->enqId;
    }
    function set_enqId($enqId){
        $this->enqId=$enqId;
    }
    function get_catId(){
        return $this->catId;
    }
    function set_catId($catId){
        $this->catId=$catId;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}

?>