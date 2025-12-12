<?php
class Allocation  implements JsonSerializable
{
    private $ProjectId;
    private $item_stockId;
    private $itemId;
    private $ItemName;
    private $AllocatedQty;
    private $CustomerName;
    private $ProjectCode;
    private $POcode;
    
    private $table_name = "itemallocation";

    function set_ProjectId($ProjectId)
    {
        $this->ProjectId= $ProjectId;
    }
    function get_ProjectId()
    {
        return $this->ProjectId;
    }

    function set_itemstockId($itemstockId)
    {
        $this->item_stockId= $itemstockId;
    }
    function get_itemstockId()
    {
        return $this->item_stockId;
    }

    function set_itemId($itemId)
    {
        $this->itemId = $itemId;
    }
    function get_itemId()
    {
        return $this->itemId;
    }

    function set_AllocatedQty($AllocatedQty)
    {
        $this->AllocatedQty= $AllocatedQty;
    }
    function get_AllocatedQty()
    {
        return $this->AllocatedQty;
    }

    function setCustomerName($CustomerName)
    {
        $this->CustomerName= $CustomerName;
    }
    function getCustomerName()
    {
        return $this->CustomerName;
    }

    function setProjectCode($ProjectCode)
    {
        $this->ProjectCode= $ProjectCode;
    }
    function getProjectCode()
    {
        return $this->ProjectCode;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'AllocatedQty' => $this->AllocatedQty,
                'itemId' => $this->itemId,
                'itemstockId' =>$this->item_stockId,
                'ProjectId'=>$this->ProjectId,
                'CustomerName'=>$this->CustomerName,
                'ProjectCode'=>$this->ProjectCode,
                'ItemName'=>$this->ItemName,
                'POcode'=>$this->POcode,
        ];
    }

  
    public function getItemName()
    {
        return $this->ItemName;
    }
 
    public function setItemName($ItemName)
    {
        $this->ItemName = $ItemName;

        return $this;
    }

    /**
     * Get the value of POcode
     */ 
    public function getPOcode()
    {
        return $this->POcode;
    }

    /**
     * Set the value of POcode
     *
     * @return  self
     */ 
    public function setPOcode($POcode)
    {
        $this->POcode = $POcode;

        return $this;
    }
}
