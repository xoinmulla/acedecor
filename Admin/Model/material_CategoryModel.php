<?php
class Material_category implements JsonSerializable
{
    private $material_catId ;
    private $material_catName;
    private	$material_catDescription;
    private	$material_catModifiedOn;
    private	$material_catCreatedBy;
    private $material_catCreatedOn;
    private $material_catModifiedBy	;
    private $material_brandName;
    private $brand_list = [];
    private $table_name="material_category";
    function set_brandList($list)
    {
        $this->brand_list = $list;
    }
    function get_brandList()
    {
        return $this->brand_list;
    }

   function set_materialcatId($materialcatId)
    {
        $this->material_catId =$materialcatId;
    }
    function get_materialcatId()
    {
        return $this->material_catId ;
    }

    function set_materialCatname($materialCatname)
    {
        $this->material_catName=$materialCatname;
    }
    function get_materialCatname()
    {
        return $this->material_catName;
    }

    function set_materialCatdescription($materialCatdescription)
    {
        $this->material_catDescription=$materialCatdescription;
    }
    function get_materialCatdescription()
    {
        return $this->material_catDescription;
    }


    function set_Materialcatcreatedon($Materialcatcreatedon)
    {
        $this->Material_catcreatedOn=$Materialcatcreatedon;
    }
    function get_Materialcatcreatedon()
    {
        return $this->Material_catcreatedOn;
    }

    function set_materialCatcreatedby($materialCatcreatedby)
    {
        $this->material_catCreatedBy=$materialCatcreatedby;
    }
    function get_materialCatcreatedby()
    {
        return $this->material_catCreatedBy;
    }

    function set_materialCatmodifiedby($materialCatmodifiedby)
    {
        $this->material_catModifiedBy	=$materialCatmodifiedby;
    }
    function get_materialCatmodifiedby()
    {
        return $this->material_catModifiedBy;
    }
    
    public function set_brandname($brandname)
    {
        $this->material_brandName=$brandname;
    }
    public function get_brandname()
    {
        return $this->material_brandName;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
            [
                'materialcatId' => $this->material_catId,
                'materialCatname' => $this->material_catName,
                'materialCatdescription' => $this->material_catDescription,
                'brandname' => $this->material_brandName,
            ];
        
    }
}
