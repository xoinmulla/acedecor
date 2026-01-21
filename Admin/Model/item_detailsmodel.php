<?php
class Item_Details implements JsonSerializable
{
    private $item_id;
    private $item_name;
    private $item_description;
    private $item_categoryname;
    private $item_subcategoryname;
    private $item_catid;
    private $item_subcatid;
    private $item_companyName;
    private $item_compid;
    private $item_image;
    private $item_createdby;
    private $item_modifiedby;
    private $item_HSNcode;
    private $item_articleNumber;
    private $item_SAPId;
    private $item_OrderNo;
    private $item_size;
    private $item_packingunit;
    private $item_MRP;
    private $item_ppMRP;
    private $itemdescriptionforcust;
    private $item_GST;
    private $item_unit;
    private $item_unitFactor;
    private $item_unitId;
    private $item_unitFactorId;
    private $item_totalMRP;
    private $price;
    private $quantity;
    private $totalamt;
    private $TotalStock;
    private $itemquantity;
    private $ReceivedQty;
    private $ReceivedQtyAmt;
    private $InvoiceNo;
    private $POcode;
    private $DateofPurchase;
    private $ItemPrice;
    private $TotalAmount;
    private $BrandId;
    private $AllocatedQty;
    private $AvailableQty;
    private $item_Discount;
    private $item_Price;
    private $item_TotalValue;
    private $item_Amount;
    // 🔒 Flag: item used in approved quotation
    private $isUsedInApprovedQuotation = 0;

    public function set_isUsedInApprovedQuotation($value)
    {
        $this->isUsedInApprovedQuotation = (int) $value;
    }

    public function get_isUsedInApprovedQuotation()
    {
        return $this->isUsedInApprovedQuotation;
    }
    // ========== DISCOUNT ==========
    function set_itemDiscount($item_Discount)
    {
        $this->item_Discount = $item_Discount;
    }
    function get_itemDiscount()
    {
        return $this->item_Discount;
    }

    // ========== PRICE ==========
    function set_itemPrice($item_Price)
    {
        $this->item_Price = $item_Price;
    }
    function get_itemPrice()
    {
        return $this->item_Price;
    }

    // ========== TOTAL VALUE ==========
    function set_itemTotalValue($item_TotalValue)
    {
        $this->item_TotalValue = $item_TotalValue;
    }
    function get_itemTotalValue()
    {
        return $this->item_TotalValue;
    }

    function set_itemAmount($item_Amount)
    {
        $this->item_Amount = $item_Amount;
    }

    function get_itemAmount()
    {
        return $this->item_Amount;
    }

    private $table_name = "item_details";
    function set_itemunit($itemunit)
    {
        $this->item_unit = $itemunit;
    }
    function get_itemunit()
    {
        return $this->item_unit;
    }
    function set_itemunitId($itemunitId)
    {
        $this->item_unitId = $itemunitId;
    }
    function get_itemunitId()
    {
        return $this->item_unitId;
    }
    function set_itemunitFactor($itemunitFactor)
    {
        $this->item_unitFactor = $itemunitFactor;
    }
    function get_itemunitFactor()
    {
        return $this->item_unitFactor;
    }
    function set_itemunitFactorId($itemunitFactorId)
    {
        $this->item_unitFactorId = $itemunitFactorId;
    }
    function get_itemunitFactorId()
    {
        return $this->item_unitFactorId;
    }
    function set_itemtotalMRP($itemtotalMRP)
    {
        $this->item_totalMRP = $itemtotalMRP;
    }
    function get_itemtotalMRP()
    {
        return $this->item_totalMRP;
    }

    function set_itemGST($itemGST)
    {
        $this->item_GST = $itemGST;
    }
    function get_itemGST()
    {
        return $this->item_GST;
    }
    function set_descriptionForCustomer($itemdescriptionforcust)
    {
        $this->itemdescriptionforcust = $itemdescriptionforcust;
    }
    function get_descriptionForCustomer()
    {
        return $this->itemdescriptionforcust;
    }

    function set_ppMRP($ppMRP)
    {
        $this->item_ppMRP = $ppMRP;
    }
    function get_ppMRP()
    {
        return $this->item_ppMRP;
    }
    function set_MRP($MRP)
    {
        $this->item_MRP = $MRP;
    }
    function get_MRP()
    {
        return $this->item_MRP;
    }
    function set_packingunit($packingunit)
    {
        $this->item_packingunit = $packingunit;
    }
    function get_packingunit()
    {
        return $this->item_packingunit;
    }
    function set_size($size)
    {
        $this->item_size = $size;
    }
    function get_size()
    {
        return $this->item_size;
    }
    function set_OrderNo($OrderNo)
    {
        $this->item_OrderNo = $OrderNo;
    }
    function get_OrderNo()
    {
        return $this->item_OrderNo;
    }
    function set_itemSAPId($SAPId)
    {
        $this->item_SAPId = $SAPId;
    }
    function get_itemSAPId()
    {
        return $this->item_SAPId;
    }

    function set_itemCompanyname($companyname)
    {
        $this->item_companyName = $companyname;
    }
    function get_itemCompanyname()
    {
        return $this->item_companyName;
    }

    function set_itemid($itemid)
    {
        $this->item_id = $itemid;
    }
    function get_itemid()
    {
        return $this->item_id;
    }

    function set_itemname($itemname)
    {
        $this->item_name = $itemname;
    }
    function get_itemname()
    {
        return $this->item_name;
    }

    function set_itemcategoryname($itemcategoryname)
    {
        $this->item_categoryname = $itemcategoryname;
    }
    function get_itemcategoryname()
    {
        return $this->item_categoryname;
    }
    function set_itemsubcategoryname($itemsubcategoryname)
    {
        $this->item_subcategoryname = $itemsubcategoryname;
    }
    function get_itemsubcategoryname()
    {
        return $this->item_subcategoryname;
    }

    function set_itemdescription($itemdescription)
    {
        $this->item_description = $itemdescription;
    }
    function get_itemdescription()
    {
        return $this->item_description;
    }

    function set_itemcatid($itemcatid)
    {
        $this->item_catid = $itemcatid;
    }
    function get_itemcatid()
    {
        return $this->item_catid;
    }

    function set_itemsubcatid($itemsubcatid)
    {
        $this->item_subcatid = $itemsubcatid;
    }
    function get_itemsubcatid()
    {
        return $this->item_subcatid;
    }

    function set_itemcompid($itemcompid)
    {
        $this->item_compid = $itemcompid;
    }
    function get_itemcompid()
    {
        return $this->item_compid;
    }

    function set_itembrandid($itembrandid)
    {
        $this->itembrandid = $itembrandid;
    }
    function get_itembrandid()
    {
        return $this->itembrandid;
    }

    function set_itemimage($itemimage)
    {
        $this->item_image = $itemimage;
    }
    function get_itemimage()
    {
        return $this->item_image;
    }

    function set_itemcreatedby($itemcreatedby)
    {
        $this->item_createdby = $itemcreatedby;
    }
    function get_itemcreatedby()
    {
        return $this->item_createdby;
    }

    function set_itemmodifiedby($itemmodifiedby)
    {
        $this->item_modifiedby = $itemmodifiedby;
    }
    function get_itemmodifiedby()
    {
        return $this->item_modifiedby;
    }

    function set_itemhsncode($itemhsncode)
    {
        $this->item_HSNcode = $itemhsncode;
    }
    function get_itemhsncode()
    {
        return $this->item_HSNcode;
    }
    function set_itemarticleno($articleNumber)
    {
        $this->item_articleNumber = $articleNumber;
    }
    function get_itemarticleno()
    {
        return $this->item_articleNumber;
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



    function set_TotalAmount($TotalAmount)
    {
        $this->TotalAmount = $TotalAmount;
    }
    function get_TotalAmount()
    {
        return $this->TotalAmount;
    }

    function set_POcode($POcode)
    {
        $this->POcode = $POcode;
    }
    function get_POcode()
    {
        return $this->POcode;
    }

    function set_InvoiceNo($InvoiceNo)
    {
        $this->InvoiceNo = $InvoiceNo;
    }
    function get_InvoiceNo()
    {
        return $this->InvoiceNo;
    }

    function set_DateofPurchase($DateofPurchase)
    {
        $this->DateofPurchase = $DateofPurchase;
    }
    function get_DateofPurchase()
    {
        return $this->DateofPurchase;
    }

    function set_brandId($brandId)
    {
        $this->BrandId = $brandId;
    }
    function get_brandId()
    {
        return $this->BrandId;
    }




    function set_AllocatedQty($AllocatedQty)
    {
        $this->AllocatedQty = $AllocatedQty;
    }
    function get_AllocatedQty()
    {
        return $this->AllocatedQty;
    }

    function set_AvailableQty($AvailableQty)
    {
        $this->AvailableQty = $AvailableQty;
    }
    function get_AvailableQty()
    {
        return $this->AvailableQty;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'itemname' => $this->item_name,
            'itemid' => $this->item_id,

            'itemdescription' => $this->item_description,
            'itemcompid' => $this->item_compid,
            'itemhsncode' => $this->item_HSNcode,
            'itemarticleNo' => $this->item_articleNumber,
            'itemimage' => $this->item_image,
            'company' => $this->item_compid,
            'subCategory' => $this->item_subcatid,
            'itemCategory' => $this->item_catid,
            'itemppMRP' => $this->item_ppMRP,
            'itemMRP' => $this->item_MRP,
            'itempu' => $this->item_packingunit,
            'itemsize' => $this->item_size,
            'itemOrderNo' => $this->item_OrderNo,
            'itemSAPId' => $this->item_SAPId,
            'itemGST' => $this->item_GST,
            'unitFactor' => $this->item_unitFactor,
            'unit' => $this->item_unit,
            'itemmodifiedby' => $this->item_modifiedby,
            'itemcreatedby' => $this->item_createdby,
            'price' => $this->price,
            'totalamt' => $this->totalamt,
            'quantity' => $this->quantity,
            'itemquantity' => $this->itemquantity,
            'itembrandid' => $this->itemquantity,
            'totalstock' => $this->TotalStock,
            'ReceivedQty' => $this->ReceivedQty,
            'POcode' => $this->POcode,
            'InvoiceNo' => $this->InvoiceNo,
            'DateofPurchase' => $this->DateofPurchase,
            'ReceivedQtyAmt' => $this->ReceivedQtyAmt,
            'TotalAmount' => $this->TotalAmount,
            'BrandId' => $this->BrandId,
            'AllocatedQty' => $this->AllocatedQty,
            'AvailableQty' => $this->AvailableQty,
            'itemDiscount' => $this->item_Discount,
            'itemPrice' => $this->item_Price,
            'itemTotalValue' => $this->item_TotalValue,
            'itemAmount' => $this->item_Amount,

        ];
    }

    public function getprice()
    {
        return $this->price;
    }
    public function setprice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function gettotalamt()
    {
        return $this->totalamt;
    }
    public function settotalamt($totalamt)
    {
        $this->totalamt = $totalamt;

        return $this;
    }

    public function gettotalstock()
    {
        return $this->TotalStock;
    }
    public function settotalstock($totalstock)
    {
        $this->TotalStock = $totalstock;

        return $this;
    }


    public function getquantity()
    {
        return $this->quantity;
    }
    public function setquantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getitemquantity()
    {
        return $this->itemquantity;
    }
    public function setitemquantity($itemquantity)
    {
        $this->itemquantity = $itemquantity;

        return $this;
    }
}
