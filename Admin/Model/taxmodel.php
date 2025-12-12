<?php
class Taxinfo implements JsonSerializable {
    private $taxid;
    private $GST;
    private $SGST;
    private $CGST;
    private $IGST;
    private $createdby;
    private $modifiedby;
    private $createdon;
    private $modifiedon;
    public function get_createdby(){
        return $this->createdby;
    }
    public function set_createdby($createdby){
        $this->createdby=$createdby;
    }
    public function get_modifiedby(){
        return $this->modifiedby;
    }
    public function set_modifiedby($modifiedby){
        $this->modifiedby=$modifiedby;
    }
    public function get_createdon(){
        return $this->createdon;
    }
    public function set_createdon($createdon){
        $this->createdon=$createdon;
    }
    public function set_modifiedon($modifiedon){
        $this->modifiedon=$modifiedon;
    }
    public function get_modifiedon(){
        return $this->modifiedon;
    }
    public function get_taxid(){
        return $this->taxid;
    }

    public function set_taxid($taxId){
        $this->taxid=$taxId;
    }

    public function get_GST(){
        return $this->GST;
    }
    public function set_GST($GST){
        $this->GST=$GST;
    }
    public function get_SGST(){
        return $this->SGST;
    }
    public function set_SGST($SGST){
        $this->SGST=$SGST;
    }
    public function get_CGST(){
        return $this->CGST;
    }
    public function set_CGST($CGST){
        $this->CGST=$CGST;
    }
    public function get_IGST(){
        return $this->IGST;
    }
    public function set_IGST($IGST){
        $this->IGST=$IGST;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
                'tax_id' => $this->taxid,
                'GST' => $this->GST,
                'CGST' => $this->CGST,
                'SGST' => $this->SGST,
                'IGST' => $this->IGST,
                'createdby' => $this->createdby,
                'modifiedby'=> $this->modifiedby,
        ];
    }
}
?>