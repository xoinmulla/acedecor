<?php
class Quotation implements JsonSerializable{
    private $catId;
    private $quoteId;
    private $enqId;
    private $customerId;
    private $createdby;
    private $modifiedby;
    private $quoteType;
    private $sumTotalAmount;
    private $sumTotalPrice;
    private $quoteDescription;
    private $quoteStatus;
    private $quotePDFName;
    private $itemListName;
    private $orderListName;
    private $quoteComments;
    private $customerName;
    private $quoteCode;
    private $customerCode;
    private $DOE;
    private $quoteValue;
    private $DOQ;
    private $customerAddress;
    private $customerCity;
    private $unitId;
    private $quantity;
    private $unitName;
    private $customerphone;
    private $EnqCatName;
    private $customerEmail;
    private $customerState;
    private $InputType;


    public function set_customerState($customerState){
        $this->customerState=$customerState;
    }
    public function get_customerState(){
       return $this->customerState;
    }
    
    public function set_customerName($customerName){
        $this->customerName=$customerName;
    }
    public function get_customerName(){
       return $this->customerName;
    }

    public function set_customerEmail($customerEmail){
        $this->customerEmail=$customerEmail;
    }
    public function get_customerEmail(){
       return $this->customerEmail;
    }

    public function set_quoteComments($quoteComments){
        $this->quoteComments=$quoteComments;
    }
    public function get_quoteComments(){
       return $this->quoteComments;
    }
    public function set_quoteId($quoteId){
        $this->quoteId=$quoteId;
    }
    public function get_quoteId(){
       return $this->quoteId;
    }
    public function set_enqId($enqId){
        $this->enqId=$enqId;
    }
    public function get_enqId(){
       return $this->enqId;
    }
    public function set_customerId($customerId){
        $this->customerId=$customerId;
    }
    public function get_customerId(){
       return $this->customerId;
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
    public function set_quoteType($quoteType){
        $this->quoteType=$quoteType;
    }
    public function get_quoteType(){
       return $this->quoteType;
    }
    public function set_sumTotalAmount($sumTotalAmount){
        $this->sumTotalAmount=$sumTotalAmount;
    }
    public function get_sumTotalAmount(){
       return $this->sumTotalAmount;
    }
    public function set_sumTotalPrice($sumTotalPrice){
        $this->sumTotalPrice=$sumTotalPrice;
    }
    public function get_sumTotalPrice(){
       return $this->sumTotalPrice;
    }
    public function set_quoteDescription($quoteDescription){
        $this->quoteDescription=$quoteDescription;
    }
    public function get_quoteDescription(){
       return $this->quoteDescription;
    }
    public function set_quoteStatus($quoteStatus){
        $this->quoteStatus=$quoteStatus;
    }
    public function get_quoteStatus(){
       return $this->quoteStatus;
    }
    public function set_quotePDFName($quotePDFName){
        $this->quotePDFName=$quotePDFName;
    }
    public function get_quotePDFName(){
       return $this->quotePDFName;
    }
    public function set_itemListName($itemListName){
        $this->itemListName=$itemListName;
    }
    public function get_itemListName(){
       return $this->itemListName;
    }
    public function set_orderListName($orderListName){
        $this->orderListName=$orderListName;
    }
    public function get_orderListName(){
       return $this->orderListName;
    }

    public function setEnqCatName($setEnqCatName){
        $this->EnqCatName=$setEnqCatName;
    }
    public function getEnqCatName(){
       return $this->EnqCatName;
    }
    

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
                'catId'=>$this->catId,
                'quoteId' => $this->quoteId,
                'enqId' => $this->enqId,
                'customerId' => $this->customerId,
                'createdby' => $this->createdby,
                'modifiedby' => $this->modifiedby,
                'quoteType' => $this->quoteType,
                'sumTotalAmount'=> $this->sumTotalAmount,
                'sumTotalPrice' => $this->sumTotalPrice,
                'quoteDescription' => $this->quoteDescription,
                'quoteStatus' => $this->quoteStatus,
                'itemListName' => $this->itemListName,
                'orderListName' => $this->orderListName,
                'unitId' => $this->unitId,
                'quantity' => $this->quantity,
                'customerphone' =>$this->customerphone,
                'EnqCatName'=>$this->EnqCatName,
                'QuoteCode'=>$this->quoteCode,
                'DOQ'=>$this->DOQ,
                'InputType'=>$this->InputType,
                'quoteValue' => $this->quoteValue,
        ];
    }

    /**
     * Get the value of catId
     */ 
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * Set the value of catId
     *
     * @return  self
     */ 
    public function setCatId($catId)
    {
        $this->catId = $catId;

        return $this;
    }

    /**
     * Get the value of quoteCode
     */ 
    public function getQuoteCode()
    {
        return $this->quoteCode;
    }

    /**
     * Set the value of quoteCode
     *
     * @return  self
     */ 
    public function setQuoteCode($quoteCode)
    {
        $this->quoteCode = $quoteCode;

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
     * Get the value of DOE
     */ 
    public function getDOE()
    {
        return $this->DOE;
    }

    /**
     * Set the value of DOE
     *
     * @return  self
     */ 
    public function setDOE($DOE)
    {
        $this->DOE = $DOE;

        return $this;
    }

    /**
     * Get the value of quoteValue
     */ 
    public function getQuoteValue()
    {
        return $this->quoteValue;
    }

    /**
     * Set the value of quoteValue
     *
     * @return  self
     */ 
    public function setQuoteValue($quoteValue)
    {
        $this->quoteValue = $quoteValue;

        return $this;
    }

    /**
     * Get the value of DOQ
     */ 
    public function getDOQ()
    {
        return $this->DOQ;
    }

    /**
     * Set the value of DOQ
     *
     * @return  self
     */ 
    public function setDOQ($DOQ)
    {
        $this->DOQ = $DOQ;

        return $this;
    }

    /**
     * Get the value of customerAddress
     */ 
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Set the value of customerAddress
     *
     * @return  self
     */ 
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;

        return $this;
    }

    /**
     * Get the value of customerCity
     */ 
    public function getCustomerCity()
    {
        return $this->customerCity;
    }

    /**
     * Set the value of customerCity
     *
     * @return  self
     */ 
    public function setCustomerCity($customerCity)
    {
        $this->customerCity = $customerCity;

        return $this;
    }

    /**
     * Get the value of unitId
     */ 
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set the value of unitId
     *
     * @return  self
     */ 
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of unitName
     */ 
    public function getUnitName()
    {
        return $this->unitName;
    }

    /**
     * Set the value of unitName
     *
     * @return  self
     */ 
    public function setUnitName($unitName)
    {
        $this->unitName = $unitName;

        return $this;
    }

    /**
     * Get the value of customerphone
     */ 
    public function getCustomerphone()
    {
        return $this->customerphone;
    }

    /**
     * Set the value of customerphone
     *
     * @return  self
     */ 
    public function setCustomerphone($customerphone)
    {
        $this->customerphone = $customerphone;

        return $this;
    }

   
    public function getInputType()
    {
        return $this->InputType;
    }
    public function setInputType($InputType)
    {
        $this->InputType = $InputType;

        return $this;
    }
}


?>