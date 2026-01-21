<?php
class Item_Companydetails implements JsonSerializable
{
    private $item_compid;
    private $item_compName;
    private $brand_list = [];
    private $item_compContactName;
    private $item_compContactNumber;
    private $item_compDescription;
    private $item_compGSTIN;
    private $item_compAccountno;
    private $item_compAccountname;
    private $item_compaccIFSCcode;
    private $item_compaccMICRcode;
    private $item_compAddress;
    private $item_compCreatedBy;
    private $item_compModifiedBy;
    private $item_complogo;
    private $item_brandName;
    private $table_name = "item_companydetails";

    private $item_compLocation;

    public function set_itemcomplocation($location)
    {
        $this->item_compLocation = $location;
    }

    public function get_itemcomplocation()
    {
        return $this->item_compLocation;
    }

    function set_brandList($list)
    {
        $this->brand_list = $list;
    }
    function get_brandList()
    {
        return $this->brand_list;
    }
    public function set_itemcompid($itemcompid)
    {
        $this->item_compid = $itemcompid;
    }
    public function get_itemcompid()
    {
        return $this->item_compid;
    }

    public function set_itemcompcontactname($itemcompcontactname)
    {
        $this->item_compContactName = $itemcompcontactname;
    }
    public function get_itemcompcontactname()
    {
        return $this->item_compContactName;
    }

    public function set_itemcompname($itemcompname)
    {
        $this->item_compName = $itemcompname;
    }
    public function get_itemcompname()
    {
        return $this->item_compName;
    }

    public function set_brandname($brandname)
    {
        $this->item_brandName = $brandname;
    }
    public function get_brandname()
    {
        return $this->item_brandName;
    }

    // public function set_brandid($brandid)
    // {
    //     $this->item_brandId=$brandid;
    // }
    // public function get_brandid()
    // {
    //     return $this->item_brandId;
    // }

    public function set_itemcompcontactno($itemcompcontactno)
    {
        $this->item_compContactNumber = $itemcompcontactno;
    }
    public function get_itemcompcontactno()
    {
        return $this->item_compContactNumber;
    }

    public function set_itemcompaddress($itemcompaddress)
    {
        $this->item_compAddress = $itemcompaddress;
    }
    public function get_itemcompaddress()
    {
        return $this->item_compAddress;
    }

    public function set_itemcomplogo($itemcomplogo)
    {
        $this->item_complogo = $itemcomplogo;
    }
    public function get_itemcomplogo()
    {
        return $this->item_complogo;
    }

    public function set_itemcompaccname($itemcompaccname)
    {
        $this->item_compAccountname = $itemcompaccname;
    }
    public function get_itemcompaccname()
    {
        return $this->item_compAccountname;
    }


    public function set_itemcompaccno($itemcompaccno)
    {
        $this->item_compAccountno = $itemcompaccno;
    }
    public function get_itemcompaccno()
    {
        return $this->item_compAccountno;
    }

    public function set_itemcompaccifsc($itemcompaccifsc)
    {
        $this->item_compaccIFSCcode = $itemcompaccifsc;
    }
    public function get_itemcompaccifsc()
    {
        return $this->item_compaccIFSCcode;
    }

    public function set_itemcompaccmicr($itemcompaccmicr)
    {
        $this->item_compaccMICRcode = $itemcompaccmicr;
    }
    public function get_itemcompaccmicr()
    {
        return $this->item_compaccMICRcode;
    }

    public function set_itemcompcreatedby($itemcompcreatedby)
    {
        $this->item_compCreatedBy = $itemcompcreatedby;
    }
    public function get_itemcompcreatedby()
    {
        return $this->item_compCreatedBy;
    }

    public function set_itemcompmodifiedby($itemcompmodifiedby)
    {
        $this->item_compModifiedBy = $itemcompmodifiedby;
    }
    public function get_itemcompmodifiedby()
    {
        return $this->item_compModifiedBy;
    }

    public function set_itemcompdescription($itemcompdescription)
    {
        $this->item_compDescription = $itemcompdescription;
    }
    public function get_itemcompdescription()
    {
        return $this->item_compDescription;
    }

    public function set_itemcompgstin($itemcompgstin)
    {
        $this->item_compGSTIN = $itemcompgstin;
    }
    public function get_itemcompgstin()
    {
        return $this->item_compGSTIN;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return
            [
                'itemcompid' => $this->item_compid,
                'brandname' => $this->item_brandName,
                'itemcompname' => $this->item_compName,
                'itemcompdescription' => $this->item_compDescription,
                'itemcontactname' => $this->item_compContactName,
                'itemcompcontactno' => $this->item_compContactNumber,
                'itemcompaddress' => $this->item_compAddress,
                'itemcompaccno' => $this->item_compAccountno,
                'itemcompaccname' => $this->item_compAccountname,
                'itemcompaccifsc' => $this->item_compaccIFSCcode,
                'itemcompaccmicr' => $this->item_compaccMICRcode,
                'itemcompgstin' => $this->item_compGSTIN,
                'itemcomplogo' => $this->item_complogo,
                'itemcompcreatedby' => $this->item_compCreatedBy,
                'itemcompmodifiedby' => $this->item_compModifiedBy,
                'itemcomplocation' => $this->item_compLocation
            ];
    }
}
