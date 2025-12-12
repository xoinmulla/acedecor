<?php
class lineItem implements JsonSerializable{

    private $quoteId;
    private $lineItemId;
    private $itemid;
    private $InputName;
    private $item_subcatid;
    private $item_subcatname;
    private $item_catid;
    private $item_catname;
    private $createdby;
    private $modifiedby;
    private $itemppMRP;
    private	$itemquantity;
    private $totalAmount;
    private $totalPrice;
    private $GST;
    private $GSTAmt;
    private $discount1;
    private $value;
    private $discount1Amt;
    private $totalValue;
    private $image;
    private $Name;
    private $Brand;
    private $Description;
    private $Units;
    private $unitFactor;
    private $POStatus;
    private $InwardStatus;
    private $ItemCode;
    private $AvailableQty;
    private $StockId;
    private $InputType;
    private $QuoteCode;
    private $AllocatedStatus;
    private $AllocatedQty;
    private $companyPrice;
    private $quoteValue;
    private $tradePrice;

    public function get_tradePrice() {
        return $this->tradePrice;
    }

    public function set_tradePrice($tradePrice) {
        $this->tradePrice = $tradePrice;
    }

     public function setQuoteCode($QuoteCode){
        $this->QuoteCode=$QuoteCode;
    }
    public function getQuoteCode(){
       return $this->QuoteCode;
    }

     public function set_inputType($inputType){
        $this->InputType=$inputType;
    }
    public function get_inputType(){
       return $this->InputType;
    }

    public function set_GSTAmt($GSTAmt){
        $this->GSTAmt=$GSTAmt;
    }
    public function get_GSTAmt(){
       return $this->GSTAmt;
    }

    public function set_GST($GST){
        $this->GST=$GST;
    }
    public function get_GST(){
       return $this->GST;
    }

    public function set_totalPrice($totalPrice){
        $this->totalPrice=$totalPrice;
    }
    public function get_totalPrice(){
       return $this->totalPrice;
    }

    public function get_totalValue(){
        return $this->totalValue;
     }
     public function set_totalValue($totalValue){
         $this->totalValue=$totalValue;
     }

    public function get_discount1Amt(){
        return $this->discount1Amt;
     }
     public function set_discount1Amt($discount1Amt){
         $this->discount1Amt=$discount1Amt;
     }
    public function get_companyPrice(){
        return $this->companyPrice;
     }
     public function set_companyPrice($companyPrice){
         $this->companyPrice=$companyPrice;
     }
    public function get_quoteValue(){
        return $this->quoteValue;
     }
     public function set_quoteValue($quoteValue){
         $this->quoteValue=$quoteValue;
     }

    // Add missing companyDiscount getter and setter
    private $companyDiscount;

    public function get_companyDiscount(){
        return $this->companyDiscount;
    }
    public function set_companyDiscount($companyDiscount){
        $this->companyDiscount = $companyDiscount;
    }

    public function get_value(){
        return $this->value;
     }
     public function set_value($value){
         $this->value=$value;
     }
    public function get_discount1(){
        return $this->discount1;
     }
     public function set_discount1($discount1){
         $this->discount1=$discount1;
     }
    public function get_quoteId(){
        return $this->quoteId;
     }
     public function set_quoteId($quoteId){
         $this->quoteId=$quoteId;
     }
     public function get_lineItemId(){
        return $this->lineItemId;
     }
     public function set_lineItemId($lineItemId){
         $this->lineItemId=$lineItemId;
     }
     function set_itemid($itemid)
    {
        $this->itemid =$itemid;
    }
    function get_itemid()
    {
        return $this->itemid ;
    }
    function set_itemcatid($itemcatid)
    {
        $this->item_catid =$itemcatid;
    }
    function get_itemcatid()
    {
        return $this->item_catid ;
    }

    function set_itemcatname($itemcatname)
    {
        $this->item_catname =$itemcatname;
    }
    function get_itemcatname()
    {
        return $this->item_catname ;
    }

    function set_itemsubcatid($itemsubcatid)
    {
        $this->item_subcatid =$itemsubcatid;
    }
    function get_itemsubcatid()
    {
        return $this->item_subcatid ;
    }

    function set_itemsubcatname($itemsubcatname)
    {
        $this->item_subcatname =$itemsubcatname;
    }
    function get_itemsubcatname()
    {
        return $this->item_subcatname ;
    }

    function set_ppMRP($ppMRP){
        $this->itemppMRP=$ppMRP;
    }
    function get_ppMRP(){
        return $this->itemppMRP;
    }
    function set_itemquantity($itemquantity){
        $this->itemquantity=$itemquantity;
    }
    function get_itemquantity(){
        return $this->itemquantity;
    }
    public function set_createdby($createdby){
        $this->createdby=$createdby;
    }
    public function get_createdby(){
       return $this->createdby;
    }
    public function set_modifiedby($modifiedby){
        $this->modifiedby=$modifiedby;
    }
    public function get_modifiedby(){
       return $this->modifiedby;
    }
    public function set_totalAmount($totalAmount){
        $this->totalAmount=$totalAmount;
    }
    public function get_totalAmount(){
       return $this->totalAmount;
    }

    public function setPOStatus($POStatus){
        $this->POStatus=$POStatus;
    }
    public function getPOStatus(){
       return $this->POStatus;
    }

    public function setInwardStatus($InwardStatus){
        $this->InwardStatus=$InwardStatus;
    }
    public function getInwardStatus(){
       return $this->InwardStatus;
    }

    public function setAllocatedStatus($AllocatedStatus){
        $this->AllocatedStatus=$AllocatedStatus;
    }
    public function getAllocatedStatus(){
       return $this->AllocatedStatus;
    }

    public function setItemCode($ItemCode){
        $this->ItemCode=$ItemCode;
    }
    public function getItemCode(){
       return $this->ItemCode;
    }

    
    public function set_AvailableQty($AvailableQty){
        $this->AvailableQty=$AvailableQty;
    }
    public function get_AvailableQty(){
       return $this->AvailableQty;
    }

    public function setStockId($StockId){
        $this->StockId=$StockId;
    }
    public function getStockId(){
       return $this->StockId;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {

        return [
                'quoteId' => $this->quoteId,
                'lineItemId' => $this->lineItemId,
                'itemid' => $this->itemid,
                'itemcatid' => $this->item_catid,
                'itemcatname' => $this->item_catname,
                'itemsubcatid' => $this->item_subcatid,
                'itemsubcatname' => $this->item_subcatname,
                'createdby' => $this->createdby,
                'modifiedby' => $this->modifiedby,
                'itemppMRP' => $this->itemppMRP,
                'itemquantity'=> $this->itemquantity,
                'totalAmount' => $this->totalAmount,
                'totalPrice' => $this->totalPrice,
                'GST' => $this->GST,
                'discount1' => $this->discount1,
                'discount1Amt' => $this->discount1Amt,
                'image'=>$this->image,
                'Name' => $this->Name,
                'Brand' => $this->Brand,
                'Description' => $this->Description,
                'Units' => $this->Units,
                'POStatus'=> $this->POStatus,
                'InwardStatus'=> $this->InwardStatus,
                'ItemCode'=> $this->ItemCode,
                'AvailableQty'=> $this->AvailableQty,
                'StockId'=> $this->StockId,
                'inputType'=> $this->InputType,
                'QuoteCode'=> $this->QuoteCode,
                'AllocatedQty'=> $this->AllocatedQty,
                'InputName'=> $this->InputName,
                'companyPrice'=> $this->companyPrice,
                'quoteValue'=> $this->quoteValue,
                'totalValue'=> $this->totalValue,
        ];
    }

    /**
     * Alias for get_InputName
     */
    public function getInputNameAlias()
    {
        return $this->get_InputName();
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of Name
     */ 
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
     * Get the value of Brand
     */ 
    public function getBrand()
    {
        return $this->Brand;
    }

    /**
     * Set the value of Brand
     *
     * @return  self
     */ 
    public function setBrand($Brand)
    {
        $this->Brand = $Brand;

        return $this;
    }

    /**
     * Get the value of Description
     */ 
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Set the value of Description
     *
     * @return  self
     */ 
    public function setDescription($Description)
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * Get the value of Units
     */ 
    public function getUnits()
    {
        return $this->Units;
    }

    /**
     * Set the value of Units
     *
     * @return  self
     */ 
    public function setUnits($Units)
    {
        $this->Units = $Units;

        return $this;
    }

    /**
     * Get the value of unitFactor
     */ 
    public function getUnitFactor()
    {
        return $this->unitFactor;
    }

    /**
     * Set the value of unitFactor
     *
     * @return  self
     */ 
    public function setUnitFactor($unitFactor)
    {
        $this->unitFactor = $unitFactor;

        return $this;
    }

     /**
      * Get the value of AllocatedQty
      */ 
     public function getAllocatedQty()
     {
          return $this->AllocatedQty;
     }

     /**
      * Set the value of AllocatedQty
      *
      * @return  self
      */ 
     public function setAllocatedQty($AllocatedQty)
     {
          $this->AllocatedQty = $AllocatedQty;

          return $this;
     }

    /**
     * Get the value of InputName
     */ 
    public function get_InputName()
    {
        return $this->InputName;
    }

    /**
     * Set the value of InputName
     *
     * @return  self
     */ 
    public function set_InputName($InputName)
    {
        $this->InputName = $InputName;

        return $this;
    }
}