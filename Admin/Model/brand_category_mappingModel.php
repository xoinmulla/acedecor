<?php
class categoryBrandMappingModel{
    private $item_categoryId;
    private $brandId;
    private $ModifiedOn;
    private $CreatedBy;
    private $CreatedOn;
    private $ModifiedBy;
    function get_itemcategoryId(){
        return $this->item_categoryId;
    }
    function set_itemcategoryId($item_categoryId){
        $this->item_categoryId=$item_categoryId;
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