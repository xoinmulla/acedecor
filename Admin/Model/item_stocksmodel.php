<?php
class Item_Stock implements JsonSerializable
{
    										
    private $item_stockid ;
    private $item_id;
    private	$POID;
    private	$Quantity;
    private	$Price;
    private $Unit;
    private $TotalAmount;
    private $OtherCharges;
    private $Discount;
    private $CD;
    private $TaxableValue;
    private $IGST;
    private $GST;
    private $stockPDFName;
    private $InvoiceNo;
    private $BarcodeImg;
    private	$POcode;
    private	$FollowupItemId;
    private	$FollowupIssues;
    private $ReceivedQtyAmt;
    private $ReceivedQty;
    private $BalanceQty;
    private $modifiedOn;
    private $Itemdescription;
    private $Itemsubcatname;
    private $Itemname;
    private $Itemcatname;
    private $SupplierName;
    private $followupId;
    private $Status;
    private $PricingStatus;
    private $LineitemPrice;
    private $PricingIssues_Id;
    private $ItemCode;
    
   
    private $table_name="item_stock";


    function set_SupplierName($SupplierName)
    {
        $this->SupplierName =$SupplierName;
    }
    function get_SupplierName()
    {
        return $this->SupplierName ;
    }


 
    function set_InvoiceNo($InvoiceNo)
    {
        $this->InvoiceNo =$InvoiceNo;
    }
    function get_InvoiceNo()
    {
        return $this->InvoiceNo ;
    }

   function set_StockId($StockId)
    {
        $this->item_stockid =$StockId;
    }
    function get_StockId()
    {
        return $this->item_stockid ;
    }


    function set_itemid($itemid)
    {
        $this->item_id =$itemid;
    }
    function get_itemid()
    {
        return $this->item_id ;
    }
    
    function set_quantity($quantity)
    {
        $this->Quantity=$quantity;
    }
    function get_quantity()
    {
        return $this->Quantity;
    }

    function set_price($price)
    {
        $this->Price=$price;
    }
    function get_price()
    {
        return $this->Price;
    }

    function set_LineitemPrice($LineitemPrice)
    {
        $this->LineitemPrice=$LineitemPrice;
    }
    function get_LineitemPrice()
    {
        return $this->LineitemPrice;
    }



    function set_unit($unit)
    {
        $this->Unit=$unit;
    }
    function get_unit()
    {
        return $this->Unit;
    }

    function set_totalamt($totalamt)
    {
        $this->TotalAmount=$totalamt;
    }
    function get_totalamt()
    {
        return $this->TotalAmount;
    }

    function set_othercharges($othercharges)
    {
        $this->OtherCharges =$othercharges;
    }
    function get_othercharges()
    {
        return $this->OtherCharges;
    }

    function set_discount($discount)
    {
        $this->Discount	=$discount;
    }
    function get_discount()
    {
        return $this->Discount;
    }


    function set_CD($CD)
    {
        $this->CD	=$CD;
    }
    function get_CD()
    {
        return $this->CD;
    }

    function set_POID($POID)
    {
        $this->POID	=$POID;
    }
    function get_POID()
    {
        return $this->POID;
    }


    function set_taxablevalue($taxablevalue)
    {
        $this->TaxableValue	=$taxablevalue;
    }
    function get_taxablevalue()
    {
        return $this->TaxableValue;
    }



    function set_IGST($IGST)
    {
        $this->IGST	=$IGST;
    }
    function get_IGST()
    {
        return $this->IGST;
    }

    function set_GST($GST)
    {
        $this->GST	=$GST;
    }
    function get_GST()
    {
        return $this->GST;
    }


    public function set_stockPDFName($stockPDFName){
        $this->stockPDFName=$stockPDFName;
    }
    public function get_stockPDFName(){
       return $this->stockPDFName;
    }

    function set_barcodeimg($barcodeimg)
    {
        $this->BarcodeImg =$barcodeimg;
    }
    function get_barcodeimg()
    {
        return $this->BarcodeImg ;
    }

    function set_ReceivedQty($ReceivedQty)
    {
        $this->ReceivedQty	=$ReceivedQty;
    }
    function get_ReceivedQty()
    {
        return $this->ReceivedQty;
    }

    function set_ReceivedQtyAmt($ReceivedQtyAmt)
    {
        $this->ReceivedQtyAmt	=$ReceivedQtyAmt;
    }
    function get_ReceivedQtyAmt()
    {
        return $this->ReceivedQtyAmt;
    }

    function set_BalanceQty($BalanceQty)
    {
        $this->BalanceQty	=$BalanceQty;
    }
    function get_BalanceQty()
    {
        return $this->BalanceQty;
    }

    function set_modifieddate($modifieddate)
    {
        $this->modifiedOn	=$modifieddate;
    }
    function get_modifieddate()
    {
        return $this->modifiedOn;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
                'itemid'=>$this->item_id,
                'StockId' => $this->item_stockid,
                'POID' => $this->POID,
                'quantity' => $this->Quantity,
                'unit' => $this->Unit,
                'price' =>$this->Price,
                'discount'=>$this->Discount,
                'othercharges'=>$this->OtherCharges,
                'taxablevalue'=>$this->TaxableValue,
                'CD'=>$this->CD,
                'IGST'=>$this->IGST,
                'totalamt'=>$this->TotalAmount,
                'GST'=>$this->GST,
                'Itemname'=>$this->Itemname,
                'Itemcatname'=>$this->Itemcatname,
                'Itemsubcatname'=>$this->Itemsubcatname,
                'Itemdescription'=>$this->Itemdescription,
                'InvoiceNo'=>$this->InvoiceNo,
                'barcodeimg'=>$this->BarcodeImg,
                'POcode'=>$this->POcode,
                'FollowupItemId'=>$this->FollowupItemId,
                'FollowupIssues'=>$this->FollowupIssues,
                'ReceivedQtyAmt'=>$this->ReceivedQtyAmt,
                'ReceivedQty'=>$this->ReceivedQty,
                'BalanceQty'=>$this->BalanceQty,
                'modifieddate'=>$this->modifiedOn,
                'followupId'=>$this->followupId,
                'LineitemPrice'=>$this->LineitemPrice,
                'PricingIssues_Id'=>$this->PricingIssues_Id,
                'ItemCode'=>$this->ItemCode,
               
        ];
    }

    public function getItemname()
    {
        return $this->Itemname;
    }
    public function setItemname($Itemname)
    {
        $this->Itemname = $Itemname;

        return $this;
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

    public function getItemcatname()
    {
        return $this->Itemcatname;
    }
    public function setItemcatname($Itemcatname)
    {
        $this->Itemcatname = $Itemcatname;

        return $this;
    }

    public function getItemsubcatname()
    {
        return $this->Itemsubcatname;
    }

    public function setItemsubcatname($Itemsubcatname)
    {
        $this->Itemsubcatname = $Itemsubcatname;

        return $this;
    }

    public function getItemdescription()
    {
        return $this->Itemdescription;
    }

    public function setItemdescription($Itemdescription)
    {
        $this->Itemdescription = $Itemdescription;

        return $this;
    }


    public function getfollowupId()
    {
        return $this->followupId;
    }

    public function setfollowupId($followupId)
    {
        $this->followupId = $followupId;

        return $this;
    }




    public function getFollowupItemId()
    {
        return $this->FollowupItemId;
    }

    public function setFollowupItemId($FollowupItemId)
    {
        $this->FollowupItemId = $FollowupItemId;

        return $this;
    }

    public function getFollowupIssues()
    {
        return $this->FollowupIssues;
    }

    public function setFollowupIssues($FollowupIssues)
    {
        $this->FollowupIssues = $FollowupIssues;

        return $this;
    }


    public function get_followupStatus()
    {
        return $this->Status;
    }

    public function set_followupStatus($followupStatus)
    {
        $this->Status = $followupStatus;

        return $this;
    }

    public function getStatus()
    {
        return $this->PricingStatus;
    }

    public function setStatus($Status)
    {
        $this->PricingStatus = $Status;

        return $this;
    }



    public function getPricingIssues_Id()
    {
        return $this->PricingIssues_Id;
    }
    public function setPricingIssues_Id($PricingIssues_Id)
    {
        $this->PricingIssues_Id = $PricingIssues_Id;

        return $this;
    }

  
    public function getItemCode()
    {
        return $this->ItemCode;
    }
    public function setItemCode($ItemCode)
    {
        $this->ItemCode = $ItemCode;

        return $this;
    }

  
}
