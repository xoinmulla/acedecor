<?php
class orderList implements JsonSerializable{
    private $id;
    private $orderNo;
    private $ArticleNo;
    private $SAP;
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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'id' =>$this->id,
            'orderNo' => $this->orderNo,
            'ArticleNo' => $this->ArticleNo,
            'SAP' => $this->SAP,
            'Description' => $this->Description,
            'Quantity' => $this->Quantity,
            'Units' => $this->Units,
        ];
    }

    /**
     * Get the value of orderNo
     */ 
    public function getOrderNo()
    {
        return $this->orderNo;
    }

    /**
     * Set the value of orderNo
     *
     * @return  self
     */ 
    public function setOrderNo($orderNo)
    {
        $this->orderNo = $orderNo;

        return $this;
    }

    /**
     * Get the value of ArticleNo
     */ 
    public function getArticleNo()
    {
        return $this->ArticleNo;
    }

    /**
     * Set the value of ArticleNo
     *
     * @return  self
     */ 
    public function setArticleNo($ArticleNo)
    {
        $this->ArticleNo = $ArticleNo;

        return $this;
    }

    /**
     * Get the value of SAP
     */ 
    public function getSAP()
    {
        return $this->SAP;
    }

    /**
     * Set the value of SAP
     *
     * @return  self
     */ 
    public function setSAP($SAP)
    {
        $this->SAP = $SAP;

        return $this;
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