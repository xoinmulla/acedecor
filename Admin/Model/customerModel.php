<?php
class customer implements JsonSerializable
{
    private $customerId;
    private $customerCode;
    private $customerName;
    private $customerPhone;
    private $customerEmail;
    private $customerAddress;
    private $customerCity;
    private $customerState;
    private $customerCountry;
    private $customerDov;
    private $enqId;
    private $quoteCode;
    private $quoteId;
    private $isQuoteGenerated;
    private $ModifiedOn;
    private $CreatedBy;
    private $CreatedOn;
    private $ModifiedBy;
    private $listOfEnq=[];
    private $QuotationCount;

    function set_enqId($enqId)
    {
        $this->enqId = $enqId;
    }
    function get_enqId()
    {
        return $this->enqId;
    }

    function set_quoteCode($quoteCode)
    {
        $this->quoteCode = $quoteCode;
    }
    function get_quoteCode()
    {
        return $this->quoteCode;
    }
    

    function set_customerDov($customerDov)
    {
        $this->customerDov = $customerDov;
    }
    function get_customerDov()
    {
        return $this->customerDov;
    }
    function set_customerState($customerState)
    {
        $this->customerState = $customerState;
    }
    function get_customerState()
    {
        return $this->customerState;
    }
    function set_customerCity($customerCity)
    {
        $this->customerCity = $customerCity;
    }
    function get_customerCity()
    {
        return $this->customerCity;
    }
    function set_customerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;
    }
    function get_customerAddress()
    {
        return $this->customerAddress;
    }
    function set_customerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }
    function get_customerEmail()
    {
        return $this->customerEmail;
    }
    function set_customerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;
    }
    function get_customerPhone()
    {
        return $this->customerPhone;
    }

    function set_customerName($customerName)
    {
        $this->customerName = $customerName;
    }
    function get_customerName()
    {
        return $this->customerName;
    }
    function set_customerId($customerId)
    {
        $this->customerId = $customerId;
    }
    function get_customerId()
    {
        return $this->customerId;
    }
    function set_ModifiedOn($ModifiedOn)
    {
        $this->ModifiedOn = $ModifiedOn;
    }
    function get_ModifiedOn()
    {
        return $this->ModifiedOn;
    }

    function set_ModifiedBy($ModifiedBy)
    {
        $this->ModifiedBy = $ModifiedBy;
    }
    function get_ModifiedBy()
    {
        return $this->ModifiedBy;
    }
    function set_CreatedBy($CreatedBy)
    {
        $this->CreatedBy = $CreatedBy;
    }
    function get_CreatedBy()
    {
        return $this->CreatedBy;
    }

    function set_CreatedOn($CreatedOn)
    {
        $this->CreatedOn = $CreatedOn;
    }
    function get_CreatedOn()
    {
        return $this->CreatedOn;
    }
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return   [
            'customerId' => $this->customerId,
            'customerName' => $this->customerName,
            'customerPhone' => $this->customerPhone,
            'customerEmail' => $this->customerEmail,
            'customerAddress' => $this->customerAddress,
            'customerCity' => $this->customerCity,
            'customerState' => $this->customerState,
            'customerCountry' => $this->customerCountry,
            'customerDov'=>$this->customerDov,
            'enqId'=>$this->enqId,
            'modifiedBy' => $this->ModifiedBy,
            'createdBy' => $this->CreatedBy,
            'createdOn' => $this->CreatedOn,
            'modifiedOn' => $this->ModifiedOn,
            'quoteCode'=> $this->quoteCode,
            'QuotationCount'=> $this->QuotationCount,
            'quoteId'=> $this->quoteId,
        ];
    }

    /**
     * Get the value of listOfEnq
     */ 
    public function getListOfEnq()
    {
        return $this->listOfEnq;
    }

    /**
     * Set the value of listOfEnq
     *
     * @return  self
     */ 
    public function setListOfEnq($listOfEnq)
    {
        $this->listOfEnq = $listOfEnq;

        return $this;
    }

    /**
     * Get the value of customerCode
     */ 
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * Set the value of customerCode
     *
     * @return  self
     */ 
    public function setCustomerCode($customerCode)
    {
        $this->customerCode = $customerCode;

        return $this;
    }

    /**
     * Get the value of isQuoteGenerated
     */ 
    public function getIsQuoteGenerated()
    {
        return $this->isQuoteGenerated;
    }

    /**
     * Set the value of isQuoteGenerated
     *
     * @return  self
     */ 
    public function setIsQuoteGenerated($isQuoteGenerated)
    {
        $this->isQuoteGenerated = $isQuoteGenerated;

        return $this;
    }

    
    public function getQuotationCount()
    {
        return $this->QuotationCount;
    }
    public function setQuotationCount($QuotationCount)
    {
        $this->QuotationCount = $QuotationCount;

        return $this;
    }

    /**
     * Get the value of quoteId
     */ 
    public function getQuoteId()
    {
        return $this->quoteId;
    }

    /**
     * Set the value of quoteId
     *
     * @return  self
     */ 
    public function setQuoteId($quoteId)
    {
        $this->quoteId = $quoteId;

        return $this;
    }

    /**
     * Get the value of customerCountry
     */ 
    public function getCustomerCountry()
    {
        return $this->customerCountry;
    }

    /**
     * Set the value of customerCountry
     *
     * @return  self
     */ 
    public function setCustomerCountry($customerCountry)
    {
        $this->customerCountry = $customerCountry;

        return $this;
    }
}
