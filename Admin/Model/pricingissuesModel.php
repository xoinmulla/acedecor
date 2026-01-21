<?php
class PricingIssues implements JsonSerializable
{
    private $PricingIssues_Id;
    private $InvoiceNo;
    private $SupplierName;
    private $ItemName;
    private $POID;
    private $Status;

    private $table_name = "item_pricingissues";


    function set_POID($POID)
    {
        $this->POID = $POID;
    }
    function get_POID()
    {
        return $this->POID;
    }

    function set_PricingIssuesId($PricingIssuesId)
    {
        $this->PricingIssues_Id = $PricingIssuesId;
    }
    function get_PricingIssuesId()
    {
        return $this->PricingIssues_Id;
    }

    function set_ItemName($ItemName)
    {
        $this->ItemName = $ItemName;
    }
    function get_ItemName()
    {
        return $this->ItemName;
    }

    function set_SupplierName($SupplierName)
    {
        $this->SupplierName = $SupplierName;
    }
    function get_SupplierName()
    {
        return $this->SupplierName;
    }

    function set_Status($Status)
    {
        $this->Status = $Status;
    }
    function get_Status()
    {
        return $this->Status;
    }

    function set_InvoiceNo($InvoiceNo)
    {
        $this->InvoiceNo = $InvoiceNo;
    }
    function get_InvoiceNo()
    {
        return $this->InvoiceNo;
    }
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'PricingIssuesId' => $this->PricingIssues_Id,
            'ItemName' => $this->ItemName,
            'SupplierName' => $this->SupplierName,
            'POID' => $this->POID,
            'Status' => $this->Status,
            'InvoiceNo' => $this->InvoiceNo
        ];
    }

}