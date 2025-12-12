<?php
class contactInfo implements JsonSerializable{
    private $contactId;
    private $name;
    private $phone;
    private $email;
    private $designation;
    private $supplierId;
    private $supplier;
    private $createdby;
    private $modifiedby;
    public function jsonSerialize()
    {

        return [
                'contactId' => $this->contactId,
                'contactName' => $this->name,
                'phone' => $this->phone,
                'createdby' => $this->createdby,
                'modifiedby' => $this->modifiedby,
                'email' => $this->email,
                'contactDesignation'=> $this->designation,
                'supplierId' => $this->supplierId
        ];
    }

    /**
     * Get the value of contactId
     */ 
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set the value of contactId
     *
     * @return  self
     */ 
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
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

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of designation
     */ 
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set the value of designation
     *
     * @return  self
     */ 
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get the value of supplierId
     */ 
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * Set the value of supplierId
     *
     * @return  self
     */ 
    public function setSupplierId($supplierId)
    {
        $this->supplierId = $supplierId;

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
     * Get the value of supplier
     */ 
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set the value of supplier
     *
     * @return  self
     */ 
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;

        return $this;
    }
}
?>