<?php
class Item_Subcategory implements JsonSerializable
{
    private $item_subcatid;
    private $item_catid;
    private $item_categoryName;
    private $item_subcatName;
    private $item_subcatDescription;
    private $item_subcatModifiedOn;
    private $item_subcatCreatedBy;
    private $item_subcatCreatedOn;
    private $item_subcatModifiedBy;
    private $table_name = "item_subcategory";
    function set_categoryName($categoryName)
    {
        $this->item_categoryName = $categoryName;
    }
    function get_categoryName()
    {
        return $this->item_categoryName;
    }
    function set_itemsubcatid($itemsubcatid)
    {
        $this->item_subcatid = $itemsubcatid;
    }
    function get_itemsubcatid()
    {
        return $this->item_subcatid;
    }

    function set_itemcatid($itemcatid)
    {
        $this->item_catid = $itemcatid;
    }
    function get_itemcatid()
    {
        return $this->item_catid;
    }

    function set_itemsubcatname($itemsubcatname)
    {
        $this->item_subcatName = $itemsubcatname;
    }
    function get_itemsubcatname()
    {
        return $this->item_subcatName;
    }

    function set_itemsubcatdescription($itemsubcatdescription)
    {
        $this->item_subcatDescription = $itemsubcatdescription;
    }
    function get_itemsubcatdescription()
    {
        return $this->item_subcatDescription;
    }


    function set_itemsubcatcreatedon($itemsubcatcreatedon)
    {
        $this->item_subcatCreatedOn = $itemsubcatcreatedon;
    }
    function get_itemsubcatcreatedon()
    {
        return $this->item_subcatCreatedOn;
    }

    function set_itemsubcatcreatedby($itemsubcatcreatedby)
    {
        $this->item_subcatCreatedBy = $itemsubcatcreatedby;
    }
    function get_itemsubcatcreatedby()
    {
        return $this->item_subcatCreatedBy;
    }

    function set_itemsubcatmodifiedby($itemsubcatmodifiedby)
    {
        $this->item_subcatModifiedBy    = $itemsubcatmodifiedby;
    }
    function get_itemsubcatmodifiedby()
    {
        return $this->item_subcatModifiedBy;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
             [
                'itemcatid' => $this->item_catid,
                'itemsubcatid' => $this->item_subcatid,
                'itemsubcatname' => $this->item_subcatName,
                'itemsubcatdescription' => $this->item_subcatDescription,
             ];
     
    }
}
