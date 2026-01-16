<?php
class PurchaselineItem implements JsonSerializable
{
    private $POID;
    private $POlineitemId;
    private $SupplierId;
    private $Item_id;
    private $InputName;
    private $Price;
    private $Quantity;
    private $TotalAmt;
    private $GST;
    private $OtherCharges;
    private $Discount;
    private $CD;
    private $TaxableValue;
    private $IGST;
    private $GSTamt;
    private $StockId;
    private $POcode;
    private $POType;
    private $Itemcode;
    private $BarcodeImg;
    private $InvoiceNo;
    private $ReceivedQtyAmt;
    private $ReceivedQty;
    private $ItemImage;
    private $BalanceQty;
    private $ItemCode;
    private $Brand;
    private $PPMRP;
    private $RaisedQty;
    private $Name;
    private $unitName;
    private $HSNcode;
    private $Itemcatname;
    private $Itemsubcatname;

    private $InventoryPrice;

    private $InventoryType;

    private $Description;



    public function setInventoryType($InventoryType)
    {
        $this->InventoryType = $InventoryType;
    }

    public function getInventoryType()
    {
        return $this->InventoryType;
    }

    public function setInventoryPrice($price)
    {
        $this->InventoryPrice = $price;
    }

    public function getInventoryPrice()
    {
        return $this->InventoryPrice ?? 0;
    }


    public function set_GST($GST)
    {
        $this->GST = $GST;
    }
    public function get_GST()
    {
        return $this->GST;
    }
    public function set_totalamt($totalamt)
    {
        $this->TotalAmt = $totalamt;
    }
    public function get_totalamt()
    {
        return $this->TotalAmt;
    }

    public function get_POID()
    {
        return $this->POID;
    }
    public function set_POID($POID)
    {
        $this->POID = $POID;
    }

    public function get_POlineitemId()
    {
        return $this->POlineitemId;
    }
    public function set_POlineitemId($POlineitemId)
    {
        $this->POlineitemId = $POlineitemId;
    }

    public function set_itemid($itemid)
    {
        $this->Item_id = $itemid;
    }
    public function get_itemid()
    {
        return $this->Item_id;
    }

    public function set_supplierId($supplierId)
    {
        $this->SupplierId = $supplierId;
    }
    public function get_supplierId()
    {
        return $this->SupplierId;
    }
    public function set_price($price)
    {
        $this->Price = $price;
    }
    public function get_price()
    {
        return $this->Price;
    }

    public function set_PPMRP($PPMRP)
    {
        $this->PPMRP = $PPMRP;
    }
    public function get_PPMRP()
    {
        return $this->PPMRP;
    }


    public function set_quantity($quantity)
    {
        $this->Quantity = $quantity;
    }
    public function get_quantity()
    {
        return $this->Quantity;
    }

    public function setRaisedQty($RaisedQty)
    {
        $this->RaisedQty = $RaisedQty;
    }
    public function getRaisedQty()
    {
        return $this->RaisedQty;
    }


    public function setbarcodeimg($barcodeimg)
    {
        $this->BarcodeImg = $barcodeimg;
    }
    public function getbarcodeimg()
    {
        return $this->BarcodeImg;
    }

    function set_ReceivedQty($ReceivedQty)
    {
        $this->ReceivedQty = $ReceivedQty;
    }
    function get_ReceivedQty()
    {
        return $this->ReceivedQty;
    }

    function set_ReceivedQtyAmt($ReceivedQtyAmt)
    {
        $this->ReceivedQtyAmt = $ReceivedQtyAmt;
    }
    function get_ReceivedQtyAmt()
    {
        return $this->ReceivedQtyAmt;
    }



    function set_BalanceQty($BalanceQty)
    {
        $this->BalanceQty = $BalanceQty;
    }
    function get_BalanceQty()
    {
        return $this->BalanceQty;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'POID' => $this->POID,
            'POlineitemId' => $this->POlineitemId,
            'itemid' => $this->Item_id,
            'price' => $this->Price,
            // 'issues'=>$this->Issues,
            'quantity' => $this->Quantity,
            'totalamt' => $this->TotalAmt,
            'GST' => $this->GST,
            'Name' => $this->Name,
            'Brand' => $this->Brand,
            'unitName' => $this->unitName,
            'Description' => $this->Description,
            // 'Itemcatname'=>$this->Itemcatname,
            // 'Itemsubcatname'=>$this->Itemsubcatname, 
            'OtherCharges' => $this->OtherCharges,
            'TaxableValue' => $this->TaxableValue,
            'CD' => $this->CD,
            'Discount' => $this->Discount,
            'IGST' => $this->IGST,
            'GSTamt' => $this->GSTamt,
            'StockId' => $this->StockId,
            'POcode' => $this->POcode,
            'Itemcode' => $this->Itemcode,
            'barcodeimg' => $this->BarcodeImg,
            'InvoiceNo' => $this->InvoiceNo,
            'supplierId' => $this->SupplierId,
            'ReceivedQtyAmt' => $this->ReceivedQtyAmt,
            'ReceivedQty' => $this->ReceivedQty,
            'ItemImage' => $this->ItemImage,
            'BalanceQty' => $this->BalanceQty,
            'PPMRP' => $this->PPMRP,
            'RaisedQty' => $this->RaisedQty,
            'InventoryPrice' => $this->InventoryPrice,
            'InventoryType' => $this->InventoryType,
        ];
    }

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
     * Set the value of unitName
     *
     * @return  self
     */
    public function setunitName($unitName)
    {
        $this->unitName = $unitName;

        return $this;
    }
    public function getunitName()
    {
        return $this->unitName;
    }



    public function setBrand($Brand)
    {
        $this->Brand = $Brand;

        return $this;
    }
    public function getBrand()
    {
        return $this->Brand;
    }

    public function setDescription($Description)
    {
        $this->Description = $Description;

        return $this;
    }
    public function getDescription()
    {
        return $this->Description;
    }

    public function setHSNcode($HSNcode)
    {
        $this->HSNcode = $HSNcode;

        return $this;
    }
    public function getHSNcode()
    {
        return $this->HSNcode;
    }

    public function setInvoiceNo($InvoiceNo)
    {
        $this->InvoiceNo = $InvoiceNo;

        return $this;
    }
    public function getInvoiceNo()
    {
        return $this->InvoiceNo;
    }


    public function setItemcode($Itemcode)
    {
        $this->Itemcode = $Itemcode;

        return $this;
    }
    public function getItemcode()
    {
        return $this->Itemcode;
    }

    public function setItemImage($ItemImage)
    {
        $this->ItemImage = $ItemImage;

        return $this;
    }
    public function getItemImage()
    {
        return $this->ItemImage;
    }


    public function setPOcode($POcode)
    {
        $this->POcode = $POcode;

        return $this;
    }
    public function getPOcode()
    {
        return $this->POcode;
    }

    public function setOtherCharges($OtherCharges)
    {
        $this->OtherCharges = $OtherCharges;

        return $this;
    }
    public function getOtherCharges()
    {
        return $this->OtherCharges;
    }


    public function setDiscount($Discount)
    {
        $this->Discount = $Discount;

        return $this;
    }
    public function getDiscount()
    {
        return $this->Discount;
    }


    public function setCD($CD)
    {
        $this->CD = $CD;

        return $this;
    }
    public function getCD()
    {
        return $this->CD;
    }


    public function setIGST($IGST)
    {
        $this->IGST = $IGST;

        return $this;
    }
    public function getIGST()
    {
        return $this->IGST;
    }

    public function setGSTamt($GSTamt)
    {
        $this->GSTamt = $GSTamt;

        return $this;
    }
    public function getGSTamt()
    {
        return $this->GSTamt;
    }

    public function setStockId($StockId)
    {
        $this->StockId = $StockId;

        return $this;
    }
    public function getStockId()
    {
        return $this->StockId;
    }


    public function setTaxableValue($TaxableValue)
    {
        $this->TaxableValue = $TaxableValue;

        return $this;
    }
    public function getTaxableValue()
    {
        return $this->TaxableValue;
    }


    public function getItemcatname()
    {
        return $this->Itemcatname;
    }

    /**
     * Set the value of Name
     *
     * @return  self
     */
    public function setItemcatname($Itemcatname)
    {
        $this->Itemcatname = $Itemcatname;

        return $this;
    }

    public function getItemsubcatname()
    {
        return $this->Itemsubcatname;
    }

    /**
     * Set the value of Name
     *
     * @return  self
     */
    public function setItemsubcatname($Itemsubcatname)
    {
        $this->Itemsubcatname = $Itemsubcatname;

        return $this;
    }

    /**
     * Get the value of POType
     */
    public function getPOType()
    {
        return $this->POType;
    }

    /**
     * Set the value of POType
     *
     * @return  self
     */
    public function setPOType($POType)
    {
        $this->POType = $POType;

        return $this;
    }


    public function getInputName()
    {
        return $this->InputName;
    }
    public function setInputName($InputName)
    {
        $this->InputName = $InputName;

        return $this;
    }
}