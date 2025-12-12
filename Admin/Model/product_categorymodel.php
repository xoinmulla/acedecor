<?php
class Product_Category implements JsonSerializable
{
    private $product_catid ;
    private $product_catName;
    private	$product_catDescription;
    private	$product_catModifiedOn;
    private	$product_catCreatedBy;
    private $product_catCreatedOn;
    private $product_catModifiedBy	;
    private $table_name="product_category";
 
   function set_productcatid($productcatid)
    {
        $this->product_catid =$productcatid;
    }
    function get_productcatid()
    {
        return $this->product_catid ;
    }

    function set_productcatname($productcatname)
    {
        $this->product_catName=$productcatname;
    }
    function get_productcatname()
    {
        return $this->product_catName;
    }

    function set_productcatdescription($productcatdescription)
    {
        $this->product_catDescription=$productcatdescription;
    }
    function get_productcatdescription()
    {
        return $this->product_catDescription;
    }


    function set_productcatcreatedon($productcatcreatedon)
    {
        $this->product_catCreatedOn=$productcatcreatedon;
    }
    function get_productcatcreatedon()
    {
        return $this->product_catCreatedOn;
    }

    function set_productcatcreatedby($productcatcreatedby)
    {
        $this->product_catCreatedBy=$productcatcreatedby;
    }
    function get_productcatcreatedby()
    {
        return $this->product_catCreatedBy;
    }

    function set_productcatmodifiedby($productcatmodifiedby)
    {
        $this->product_catModifiedBy	=$productcatmodifiedby;
    }
    function get_productcatmodifiedby()
    {
        return $this->product_catModifiedBy;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
            [
                'productcatid' => $this->product_catid,
                'productcatname' => $this->product_catName,
                'productcatdescription' => $this->product_catDescription,
                
            ];
        
    }
}
