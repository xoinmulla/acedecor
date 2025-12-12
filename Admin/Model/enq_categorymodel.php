<?php
class Category implements JsonSerializable
{
    private $enq_catid;
    private $enq_cat_name;
    private $enq_cat_description;
    private $enq_cat_createdon;
    private $enq_cat_createdby;
    private $enq_cat_modifiedby;
    private $enq_cat_modifiedon;
    private $enq_cat_type;

    private $table_name = "enquiry_category";

    function set_catType($type)
    {
        $this->enq_cat_type = $type;
    }

    function get_catType()
    {
        return $this->enq_cat_type;
    }

    function set_catid($catid)
    {
        $this->enq_catid = $catid;
    }
    function get_catid()
    {
        return $this->enq_catid;
    }
    function set_catname($catname)
    {
        $this->enq_cat_name = $catname;
    }
    function get_catname()
    {
        return $this->enq_cat_name;
    }
    function set_catdescription($catdescription)
    {
        $this->enq_cat_description = $catdescription;
    }
    function get_catdescription()
    {
        return $this->enq_cat_description;
    }
    function set_catModifiedon($catModifiedon)
    {
        $this->enq_cat_modifiedon = $catModifiedon;
    }
    function get_catModifiedon()
    {
        return $this->enq_cat_modifiedon;
    }

    function set_catcreatedon($catcreatedon)
    {
        $this->enq_cat_createdon = $catcreatedon;
    }
    function get_catcreatedon()
    {
        return $this->enq_cat_createdon;
    }

    function set_catcreatedby($catcreatedby)
    {
        $this->enq_cat_createdby = $catcreatedby;
    }
    function get_catcreatedby()
    {
        return $this->enq_cat_createdby;
    }
    function set_catModifiedby($modifiedby)
    {
        $this->enq_cat_modifiedby = $modifiedby;
    }
    function get_catModifiedby()
    {
        return $this->enq_cat_modifiedby;
    }
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'catname' => $this->enq_cat_name,
            'CatId' => $this->enq_catid
        ];
    }
}