<?php
class Material_Subcategory implements JsonSerializable
{
    private $material_subcatId;
    private $material_catId;
    private $material_materialcatName;
    private $material_subcatName;
    private $material_subcatDescription;
    private $material_subcatModifiedOn;
    private $material_subcatCreatedBy;
    private $material_subcatCreatedOn;
    private $material_subcatModifiedBy;
    private $table_name = "material_subcategory";

    function set_materialcatName($materialcatName)
    {
        $this->material_materialcatName = $materialcatName;
    }
    function get_materialcatName()
    {
        return $this->material_materialcatName;
    }
    function set_materialsubcatId($materialsubcatId)
    {
        $this->material_subcatId = $materialsubcatId;
    }
    function get_materialsubcatId()
    {
        return $this->material_subcatId;
    }

    function set_materialcatId($materialcatId)
    {
        $this->material_catId = $materialcatId;
    }
    function get_materialcatId()
    {
        return $this->material_catId;
    }

    function set_materialsubcatName($materialsubcatName)
    {
        $this->material_subcatName = $materialsubcatName;
    }
    function get_materialsubcatName()
    {
        return $this->material_subcatName;
    }

    function set_materialsubcaDescription($materialsubcaDescription)
    {
        $this->material_subcatDescription = $materialsubcaDescription;
    }
    function get_materialsubcaDescription()
    {
        return $this->material_subcatDescription;
    }


    function set_materialsubcatCreatedon($materialsubcatCreatedon)
    {
        $this->material_subcatCreatedOn = $materialsubcatCreatedon;
    }
    function get_materialsubcatCreatedon()
    {
        return $this->material_subcatCreatedOn;
    }

    function set_materialsubcatCreatedby($materialsubcatCreatedby)
    {
        $this->material_subcatCreatedBy = $materialsubcatCreatedby;
    }
    function get_materialsubcatCreatedby()
    {
        return $this->material_subcatCreatedBy;
    }

    function set_materialsubcatModifiedby($materialsubcatModifiedby)
    {
        $this->material_subcatModifiedBy    = $materialsubcatModifiedby;
    }
    function get_materialsubcatModifiedby()
    {
        return $this->material_subcatModifiedBy;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
             [
                'materialcatId' => $this->material_catId,
                'materialsubcatId' => $this->material_subcatId,
                'materialsubcatName' => $this->material_subcatName,
                'materialsubcaDescription' => $this->material_subcatDescription,
             ];
     
    }
}
