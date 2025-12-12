<?php
class itemList implements JsonSerializable{
    private $id;
    private $Image;
    private $Name;
    private $Brand;
    private $Description;
    private $Quantity;
    private $Units;

    /**
     * Get the value of Units
     */ 
    public function getUnits()
    {
        return $this->Units;
    }

    /**
     * Set the value of Units
     *
     * @return  self
     */ 
    public function setUnits($Units)
    {
        $this->Units = $Units;

        return $this;
    }

    /**
     * Get the value of Quantity
     */ 
    public function getQuantity()
    {
        return $this->Quantity;
    }

    /**
     * Set the value of Quantity
     *
     * @return  self
     */ 
    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    /**
     * Get the value of Description
     */ 
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Set the value of Description
     *
     * @return  self
     */ 
    public function setDescription($Description)
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * Get the value of Brand
     */ 
    public function getBrand()
    {
        return $this->Brand;
    }

    /**
     * Set the value of Brand
     *
     * @return  self
     */ 
    public function setBrand($Brand)
    {
        $this->Brand = $Brand;

        return $this;
    }

    /**
     * Get the value of Name
     */ 
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Set the value of Name
     *
     * @return  self
     */ 
    public function setName($Name)
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * Get the value of Image
     */ 
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * Set the value of Image
     *
     * @return  self
     */ 
    public function setImage($Image)
    {
        $this->Image = $Image;

        return $this;
    }
    public function jsonSerialize()
    {

        return 
             [
                 'id' =>$this->id,
                'Image' => $this->Image,
                'Name' => $this->Name,
                'Brand' => $this->Brand,
                'Description' => $this->Description,
                'Quantity' => $this->Quantity,
                'Units' => $this->Units,
             ];
     
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
?>