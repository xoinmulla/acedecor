<?php
class Product_subcategory implements JsonSerializable
{
    private $product_catid ;
    private $product_subcatid ;
    private $product_subcatName;
    private $product_subcatDescription;
    private	$product_subcatModifiedOn;
    private	$product_subcatCreatedBy;
    private $product_subcatCreatedOn;
    private $product_subcatModifiedBy	;
    private $table_name="product_subcategory";
 
   function set_productsubcatid($productsubcatid)
    {
        $this->product_subcatid =$productsubcatid;
    }
    function get_productsubcatid()
    {
        return $this->product_subcatid ;
    }


    function set_productcatid($productcatid)
    {
        $this->product_catid =$productcatid;
    }
    function get_productcatid()
    {
        return $this->product_catid ;
    }


    function set_productsubcatname($productsubcatname)
    {
        $this->product_subcatName=$productsubcatname;
    }
    function get_productsubcatname()
    {
        return $this->product_subcatName;
    }

    function set_productsubcatdescription($productsubcatdescription)
    {
        $this->product_subcatDescription=$productsubcatdescription;
    }
    function get_productsubcatdescription()
    {
        return $this->product_subcatDescription;
    }


    function set_productsubcatcreatedon($productsubcatcreatedon)
    {
        $this->product_subcatCreatedOn=$productsubcatcreatedon;
    }
    function get_productsubcatcreatedon()
    {
        return $this->product_subcatCreatedOn;
    }

    function set_productsubcatcreatedby($productsubcatcreatedby)
    {
        $this->product_subcatCreatedBy=$productsubcatcreatedby;
    }
    function get_productsubcatcreatedby()
    {
        return $this->product_subcatCreatedBy;
    }

    function set_productsubcatmodifiedby($productsubcatmodifiedby)
    {
        $this->product_subcatModifiedBy	=$productsubcatmodifiedby;
    }
    function get_productsubcatmodifiedby()
    {
        return $this->product_subcatModifiedBy;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
            [
                'productcatid' => $this->product_catid,
                'productsubcatid' => $this->product_subcatid,
                'productsubcatname' => $this->product_subcatName,
                'productsubcatdescription' => $this->product_subcatDescription,
                
            ];
        
    }
}
