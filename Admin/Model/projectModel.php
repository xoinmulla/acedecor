<?php
class Project implements JsonSerializable
{
    private $projectCode;
    private $custId;
    private $quoteId;
    private $project_status;
    private $projectId;
    private $quoteAmt;
    private $custName;
    private $progressNote;
    private $CatId;
    private $Quantity;
    private $EnqCatName;
    private $UnitName;
    private $UnitId;
    private $quoteType;
    private $QuoteCode;
    private $StockId;
    private $AllocatedQty;
    private $ItemId;
    private $DOA;
    private $DayCount;
    private $InputType;
    private $table_name = "projects";


    private $customerCity;

    public function set_customerCity($customerCity)
    {
        $this->customerCity = $customerCity;
    }
    public function get_customerCity()
    {
        return $this->customerCity;
    }

    public function set_projectId($projectId)
    {
        $this->projectId = $projectId;
    }
    public function get_projectId()
    {
        return $this->projectId;
    }

    public function set_projectCode($projectCode)
    {
        $this->projectCode = $projectCode;
    }
    public function get_projectCode()
    {
        return $this->projectCode;
    }


    public function set_progressNote($progressNote)
    {
        $this->progressNote = $progressNote;
    }
    public function get_progressNote()
    {
        return $this->progressNote;
    }


    public function set_custid($custid)
    {
        $this->custId = $custid;
    }
    public function get_custid()
    {
        return $this->custId;
    }

    public function set_quoteid($quoteid)
    {
        $this->quoteId = $quoteid;
    }
    public function get_quoteid()
    {
        return $this->quoteId;
    }

    public function set_quotecode($quotecode)
    {
        $this->QuoteCode = $quotecode;
    }
    public function get_quotecode()
    {
        return $this->QuoteCode;
    }


    public function set_quoteamt($quoteamt)
    {
        $this->quoteAmt = $quoteamt;
    }
    public function get_quoteamt()
    {
        return $this->quoteAmt;
    }


    public function set_quoteType($quoteType)
    {
        $this->quoteType = $quoteType;
    }
    public function get_quoteType()
    {
        return $this->quoteType;
    }

    // public function setQuoteCode($QuoteCode)
    // {
    //     $this->QuoteCode= $QuoteCode;
    // }
    // public function getQuoteCode()
    // {
    //     return $this->QuoteCode;
    // }

    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;
    }
    public function getQuantity()
    {
        return $this->Quantity;
    }

    public function setUnitId($UnitId)
    {
        $this->UnitId = $UnitId;
    }
    public function getUnitId()
    {
        return $this->UnitId;
    }

    public function setUnitName($UnitName)
    {
        $this->UnitName = $UnitName;
    }
    public function getUnitName()
    {
        return $this->UnitName;
    }

    public function setEnqCatName($EnqCatName)
    {
        $this->EnqCatName = $EnqCatName;
    }
    public function getEnqCatName()
    {
        return $this->EnqCatName;
    }

    public function setCatId($CatId)
    {
        $this->CatId = $CatId;
    }
    public function getCatId()
    {
        return $this->CatId;
    }

    public function set_projectstatus($projectstatus)
    {
        $this->project_status = $projectstatus;
    }
    public function get_projectstatus()
    {
        return $this->project_status;
    }

    public function setAllocatedQty($AllocatedQty)
    {
        $this->AllocatedQty = $AllocatedQty;
    }
    public function getAllocatedQty()
    {
        return $this->AllocatedQty;
    }

    public function setItemId($ItemId)
    {
        $this->ItemId = $ItemId;
    }
    public function getItemId()
    {
        return $this->ItemId;
    }

    public function setStockId($StockId)
    {
        $this->StockId = $StockId;
    }
    public function getStockId()
    {
        return $this->StockId;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [


            'custid' => $this->custId,
            'quoteid' => $this->quoteId,
            'quoteamt' => $this->quoteAmt,
            'projectstatus' => $this->project_status,
            'projectCode' => $this->projectCode,
            'custName' => $this->custName,
            'projectId' => $this->projectId,
            'quotecode' => $this->QuoteCode,
            'quoteType' => $this->quoteType,
            'Quantity' => $this->Quantity,
            'UnitId' => $this->UnitId,
            'UnitName' => $this->UnitName,
            'EnqCatName' => $this->EnqCatName,
            'CatId' => $this->CatId,
            'AllocatedQty' => $this->AllocatedQty,
            'ItemId' => $this->ItemId,
            'StockId' => $this->StockId,
            'DOA' => $this->DOA,
            'InputType' => $this->InputType,
            'customerCity' => $this->customerCity,

        ];
    }
    public function set_custName($custName)
    {
        $this->custName = $custName;
    }
    public function get_custName()
    {
        return $this->custName;
    }


    /**
     * Get the value of DOA
     */
    public function getDOA()
    {
        return $this->DOA;
    }

    /**
     * Set the value of DOA
     *
     * @return  self
     */
    public function setDOA($DOA)
    {
        $this->DOA = $DOA;

        return $this;
    }


    public function getDayCount()
    {
        return $this->DayCount;
    }
    public function setDayCount($DayCount)
    {
        $this->DayCount = $DayCount;

        return $this;
    }

    /**
     * Get the value of InputType
     */
    public function getInputType()
    {
        return $this->InputType;
    }

    /**
     * Set the value of InputType
     *
     * @return  self
     */
    public function setInputType($InputType)
    {
        $this->InputType = $InputType;

        return $this;
    }
}