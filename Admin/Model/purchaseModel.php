<?php
class PurchaseOrder implements JsonSerializable
{
    private $Id;
    private $POcode;
    private $SupplierId;
    private $Item_id;
    private $ProjectId;
    private $Price;
    private $Quantity;
    private $TotalAmt;
    private $BalanceAmt;
    private $PaidAmt;
    private $purchasePDFName;
    private $PurchasedDate;
    private $POtype;
    private $Status;
    private $PaymentMode;
    private $SupplierName;
    private $SupplierAddress;
    private $TotalReceivedQty;
    private $TotalQuantity;
    private $POStatus;
    private $BalanceQuantity;

    private $InventoryType;
    private $HasInward;

    private $SupplierLocation;
    public function setSupplierLocation($SupplierLocation)
    {
        $this->SupplierLocation = $SupplierLocation;
    }
    public function getSupplierLocation()
    {
        return $this->SupplierLocation;
    }

    public function setHasInward($HasInward)
    {
        $this->HasInward = $HasInward;
    }

    public function getHasInward()
    {
        return $this->HasInward;
    }


    public function setInventoryType($InventoryType)
    {
        $this->InventoryType = $InventoryType;
    }

    public function getInventoryType()
    {
        return $this->InventoryType;
    }


    // public function set_GST($GST)
    // {
    //     $this->GST=$GST;
    // }
    // public function get_GST()
    // {
    //     return $this->GST;
    // }

    public function set_id($id)
    {
        $this->Id = $id;
    }
    public function get_id()
    {
        return $this->Id;
    }

    public function getPOcode()
    {
        return $this->POcode;
    }
    public function setPOcode($POcode)
    {
        $this->POcode = $POcode;

        return $this;
    }

    public function getPOtype()
    {
        return $this->POtype;
    }
    public function setPOtype($POtype)
    {
        $this->POtype = $POtype;

        return $this;
    }

    public function getStatus()
    {
        return $this->Status;
    }
    public function setStatus($Status)
    {
        $this->Status = $Status;

        return $this;
    }

    public function getPOStatus()
    {
        return $this->POStatus;
    }
    public function setPOStatus($POStatus)
    {
        $this->POStatus = $POStatus;

        return $this;
    }

    public function getBalanceQuantity()
    {
        return $this->BalanceQuantity;
    }
    public function setBalanceQuantity($BalanceQuantity)
    {
        $this->BalanceQuantity = $BalanceQuantity;

        return $this;
    }


    public function set_supplier($supplier)
    {
        $this->SupplierId = $supplier;
    }
    public function get_supplier()
    {
        return $this->SupplierId;
    }

    public function set_projectId($projectId)
    {
        $this->ProjectId = $projectId;
    }
    public function get_projectId()
    {
        return $this->ProjectId;
    }


    public function set_itemid($itemid)
    {
        $this->Item_id = $itemid;
    }
    public function get_itemid()
    {
        return $this->Item_id;
    }


    public function set_itemperpieceprice($itemperpieceprice)
    {
        $this->Price = $itemperpieceprice;
    }
    public function get_itemperpieceprice()
    {
        return $this->Price;
    }


    public function set_itemquantity($itemquantity)
    {
        $this->Quantity = $itemquantity;
    }
    public function get_itemquantity()
    {
        return $this->Quantity;
    }


    public function set_totalAmount($totalAmount)
    {
        $this->TotalAmt = $totalAmount;
    }
    public function get_totalAmount()
    {
        return $this->TotalAmt;
    }
    public function set_paidAmount($paidAmount)
    {
        $this->PaidAmt = $paidAmount;
    }
    public function get_paidAmount()
    {
        return $this->PaidAmt;
    }

    public function set_purchaseddate($purchaseddate)
    {
        $this->PurchasedDate = $purchaseddate;
    }
    public function get_purchaseddate()
    {
        return $this->PurchasedDate;
    }

    public function set_purchasePDFName($purchasePDFName)
    {
        $this->purchasePDFName = $purchasePDFName;
    }
    public function get_purchasePDFName()
    {
        return $this->purchasePDFName;
    }

    public function setTotalQuantity($TotalQuantity)
    {
        $this->TotalQuantity = $TotalQuantity;
    }
    public function getTotalQuantity()
    {
        return $this->TotalQuantity;
    }

    public function setTotalReceivedQty($TotalReceivedQty)
    {
        $this->TotalReceivedQty = $TotalReceivedQty;
    }
    public function getTotalReceivedQty()
    {
        return $this->TotalReceivedQty;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'POcode' => $this->POcode,
            'supplier' => $this->SupplierId,
            'projectId' => $this->ProjectId,
            'itemid' => $this->Item_id,
            'itemquantity' => $this->Quantity,
            'itemperpieceprice' => $this->Price,
            'totalAmount' => $this->TotalAmt,
            'purchaseddate' => $this->PurchasedDate,
            'SupplierName' => $this->SupplierName,
            'ArticleNo' => $this->ArticleNo,
            'Description' => $this->Description,
            'SupplierAddress' => $this->SupplierAddress,
            'Name' => $this->Name,
            'Itemcatname' => $this->Itemcatname,
            'Itemsubcatname' => $this->Itemsubcatname,
            'Quantity' => $this->Quantity,
            'UnitName' => $this->unitName,
            'purchasePDFName' => $this->purchasePDFName,
            'Projectcode' => $this->Projectcode,
            'BrandName' => $this->BrandName,
            'POtype' => $this->POtype,
            'Status' => $this->Status,
            'BalanceQuantity' => $this->BalanceQuantity,
            'paidAmount' => $this->PaidAmt,
            'TotalReceivedQty' => $this->TotalReceivedQty,
            'TotalQuantity' => $this->TotalQuantity,
            'BalanceAmt' => $this->BalanceAmt,
            'inventoryType' => $this->InventoryType,
        ];
    }
    public function getSupplierName()
    {
        return $this->SupplierName;
    }
    public function setSupplierName($SupplierName)
    {
        $this->SupplierName = $SupplierName;

        return $this;
    }

    public function getBrandName()
    {
        return $this->BrandName;
    }
    public function setBrandName($BrandName)
    {
        $this->BrandName = $BrandName;

        return $this;
    }

    public function getName()
    {
        return $this->Name;
    }
    public function setName($Name)
    {
        $this->Name = $Name;

        return $this;
    }

    // public function getItemcatname()
    // {
    //     return $this->Itemcatname;
    // }

    // /**
    //  * Set the value of Name
    //  *
    //  * @return  self
    //  */ 
    // public function setItemcatname($Itemcatname)
    // {
    //     $this->Itemcatname = $Itemcatname;

    //     return $this;
    // }

    // public function getItemsubcatname()
    // {
    //     return $this->Itemsubcatname;
    // }

    // /**
    //  * Set the value of Name
    //  *
    //  * @return  self
    //  */ 
    // public function setItemsubcatname($Itemsubcatname)
    // {
    //     $this->Itemsubcatname = $Itemsubcatname;

    //     return $this;
    // }

    public function getQuantity()
    {
        return $this->Quantity;
    }
    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getUnitName()
    {
        return $this->unitName;
    }
    public function setUnitName($unitName)
    {
        $this->unitName = $unitName;

        return $this;
    }

    public function getArticleNo()
    {
        return $this->ArticleNo;
    }
    public function setArticleNo($ArticleNo)
    {
        $this->ArticleNo = $ArticleNo;

        return $this;
    }


    public function getDescription()
    {
        return $this->Description;
    }
    public function setDescription($Description)
    {
        $this->Description = $Description;

        return $this;
    }

    public function getSupplierAddress()
    {
        return $this->SupplierAddress;
    }
    public function setSupplierAddress($SupplierAddress)
    {
        $this->SupplierAddress = $SupplierAddress;

        return $this;
    }
    public function getProjectcode()
    {
        return $this->Projectcode;
    }
    public function setProjectcode($Projectcode)
    {
        $this->Projectcode = $Projectcode;

        return $this;
    }

    public function getpaymentmode()
    {
        return $this->PaymentMode;
    }
    public function setpaymentmode($paymentmode)
    {
        $this->PaymentMode = $paymentmode;

        return $this;
    }

    /**
     * Get the value of BalanceAmt
     */
    public function getBalanceAmt()
    {
        return $this->BalanceAmt;
    }

    /**
     * Set the value of BalanceAmt
     *
     * @return  self
     */
    public function setBalanceAmt($BalanceAmt)
    {
        $this->BalanceAmt = $BalanceAmt;

        return $this;
    }
}


?>