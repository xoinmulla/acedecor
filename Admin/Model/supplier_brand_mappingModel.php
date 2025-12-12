<?php
class supplierBrandMappingModel{
    private $supplierId;
    private $brandId;
    private $ModifiedOn;
    private $CreatedBy;
    private $CreatedOn;
    private $ModifiedBy;
    function get_supplierId(){
        return $this->supplierId;
    }
    function set_supplierId($supplierId){
        $this->supplierId=$supplierId;
    }
    function get_brandId(){
        return $this->brandId;
    }
    function set_brandId($brandId){
        $this->brandId=$brandId;
    }
    function set_ModifiedOn($ModifiedOn)
    {
        $this->ModifiedOn = $ModifiedOn;
    }
    function get_ModifiedOn()
    {
        return $this->ModifiedOn;
    }

    function set_ModifiedBy($ModifiedBy)
    {
        $this->ModifiedBy = $ModifiedBy;
    }
    function get_ModifiedBy()
    {
        return $this->ModifiedBy;
    }
    function set_CreatedBy($CreatedBy)
    {
        $this->CreatedBy = $CreatedBy;
    }
    function get_CreatedBy()
    {
        return $this->CreatedBy;
    }

    function set_CreatedOn($CreatedOn)
    {
        $this->CreatedOn = $CreatedOn;
    }
    function get_CreatedOn()
    {
        return $this->CreatedOn;
    }
}

?>