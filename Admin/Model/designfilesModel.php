<?php
class designFile implements JsonSerializable
{
    private $designFileId;
    private $customerId;
    private $designFilePath;
    private $designFileDescription;
    private $createdby;
    private $createon;
    private $modifiedby;
    private $modifedon;
    private $designCategory;

    // Human readable category name (joined from enquiry_category)
    private $categoryName;

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'designFileId' => $this->designFileId,
            'customerId' => $this->customerId,
            'designFilePath' => $this->designFilePath,
            'designFileDescription' => $this->designFileDescription,
            'designCategory' => $this->designCategory,
            'categoryName' => $this->categoryName,
            'createdby' => $this->createdby,
            'modifiedby' => $this->modifiedby,
            'createon' => $this->createon,
            'modifedon' => $this->modifedon
        ];
    }

    // designCategory id (FK)
    public function setDesignCategory($cat)
    {
        $this->designCategory = $cat;
    }
    public function getDesignCategory()
    {
        return $this->designCategory;
    }

    // categoryName (joined name from enquiry_category)
    public function setCategoryName($name)
    {
        $this->categoryName = $name;
        return $this;
    }
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Get the value of modifedon
     */
    public function getModifedon()
    {
        return $this->modifedon;
    }

    /**
     * Set the value of modifedon
     *
     * @return  self
     */
    public function setModifedon($modifedon)
    {
        $this->modifedon = $modifedon;
        return $this;
    }

    /**
     * Get the value of modifiedby
     */
    public function getModifiedby()
    {
        return $this->modifiedby;
    }

    /**
     * Set the value of modifiedby
     *
     * @return  self
     */
    public function setModifiedby($modifiedby)
    {
        $this->modifiedby = $modifiedby;
        return $this;
    }

    /**
     * Get the value of createon
     */
    public function getCreateon()
    {
        return $this->createon;
    }

    /**
     * Set the value of createon
     *
     * @return  self
     */
    public function setCreateon($createon)
    {
        $this->createon = $createon;
        return $this;
    }

    /**
     * Get the value of createdby
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set the value of createdby
     *
     * @return  self
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;
        return $this;
    }

    /**
     * Get the value of designFileDescription
     */
    public function getDesignFileDescription()
    {
        return $this->designFileDescription;
    }

    /**
     * Set the value of designFileDescription
     *
     * @return  self
     */
    public function setDesignFileDescription($designFileDescription)
    {
        $this->designFileDescription = $designFileDescription;
        return $this;
    }

    /**
     * Get the value of designFilePath
     */
    public function getDesignFilePath()
    {
        return $this->designFilePath;
    }

    /**
     * Set the value of designFilePath
     *
     * @return  self
     */
    public function setDesignFilePath($designFilePath)
    {
        $this->designFilePath = $designFilePath;
        return $this;
    }

    /**
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set the value of customerId
     *
     * @return  self
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * Get the value of designFileId
     */
    public function getDesignFileId()
    {
        return $this->designFileId;
    }

    /**
     * Set the value of designFileId
     *
     * @return  self
     */
    public function setDesignFileId($designFileId)
    {
        $this->designFileId = $designFileId;
        return $this;
    }
}
?>
