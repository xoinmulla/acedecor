<?php
class Material_Stock implements JsonSerializable
{
    										
    private $Material_stockid ;
    private $Material_Id;
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
    private $InvoiceNo;
    private $BarcodeImg;
    private	$POcode;
    private	$FollowupMaterialId;
    private	$FollowupIssues;
    private $ReceivedQtyAmt;
    private $ReceivedQty;
    private $BalanceQty;
    private $modifiedOn;
    private $Materialdescription;
    private $Materialsubcatname;
    private $Materialname;
    private $Materialcatname;
    private $SupplierName;
    private $followupId;
    private $Status;
    private $PricingStatus;
    private $LineMaterialPrice;
    private $PricingIssues_Id;
   
    private $table_name="Material_stock";


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
        $this->Material_stockid =$StockId;
    }
    function get_StockId()
    {
        return $this->Material_stockid ;
    }


    function set_MaterialId($MaterialId)
    {
        $this->Material_Id =$MaterialId;
    }
    function get_MaterialId()
    {
        return $this->Material_Id ;
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

    function set_LineMaterialPrice($LineMaterialPrice)
    {
        $this->LineMaterialPrice=$LineMaterialPrice;
    }
    function get_LineMaterialPrice()
    {
        return $this->LineMaterialPrice;
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
                'MaterialId'=>$this->Material_Id,
                'StockId' => $this->Material_stockid,
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
                'Materialname'=>$this->Materialname,
                'Materialcatname'=>$this->Materialcatname,
                'Materialsubcatname'=>$this->Materialsubcatname,
                'Materialdescription'=>$this->Materialdescription,
                'InvoiceNo'=>$this->InvoiceNo,
                'barcodeimg'=>$this->BarcodeImg,
                'POcode'=>$this->POcode,
                'FollowupMaterialId'=>$this->FollowupMaterialId,
                'FollowupIssues'=>$this->FollowupIssues,
                'ReceivedQtyAmt'=>$this->ReceivedQtyAmt,
                'ReceivedQty'=>$this->ReceivedQty,
                'BalanceQty'=>$this->BalanceQty,
                'modifieddate'=>$this->modifiedOn,
                'followupId'=>$this->followupId,
                'LineMaterialPrice'=>$this->LineMaterialPrice,
                'PricingIssues_Id'=>$this->PricingIssues_Id,
        ];
    }

    public function getMaterialname()
    {
        return $this->Materialname;
    }
    public function setMaterialname($Materialname)
    {
        $this->Materialname = $Materialname;

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

    public function getMaterialcatname()
    {
        return $this->Materialcatname;
    }
    public function setMaterialcatname($Materialcatname)
    {
        $this->Materialcatname = $Materialcatname;

        return $this;
    }

    public function getMaterialsubcatname()
    {
        return $this->Materialsubcatname;
    }

    public function setMaterialsubcatname($Materialsubcatname)
    {
        $this->Materialsubcatname = $Materialsubcatname;

        return $this;
    }

    public function getMaterialdescription()
    {
        return $this->Materialdescription;
    }

    public function setMaterialdescription($Materialdescription)
    {
        $this->Materialdescription = $Materialdescription;

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




    public function getFollowupMaterialId()
    {
        return $this->FollowupMaterialId;
    }

    public function setFollowupMaterialId($FollowupMaterialId)
    {
        $this->FollowupMaterialId = $FollowupMaterialId;

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
}
