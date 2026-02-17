<?php
class Enquiry
{
    private $enqid;
    private $enq_name;
    private $enq_email;
    private $enq_address;
    private $enq_Country;
    private $enq_phone;
    private $isCustomerCreated;
    // private $enq_modifiedBy;
    private $status;
    private $interest_list = [];
    private $createdDate;

    private $enq_city;

    private $enq_state;

    public function setEnq_State($state)
    {
        $this->enq_state = $state;
    }

    public function getEnq_State()
    {
        return $this->enq_state;
    }


    public function set_enqcity($city)
    {
        $this->enq_city = $city;
    }

    public function get_enqcity()
    {
        return $this->enq_city;
    }



    // private $enq_preffered_contact_mode;

    private $table_name = "enquiry_details";
    function set_isCustomerCreated($value)
    {
        $this->isCustomerCreated = $value;
    }
    function get_isCustomerCreated()
    {
        return $this->isCustomerCreated;
    }
    function set_id($id)
    {
        $this->enqid = $id;
    }
    function get_id()
    {
        return $this->enqid;
    }


    function set_interestList($list)
    {
        $this->interest_list = $list;
    }
    function get_interestList()
    {
        return $this->interest_list;
    }
    function set_enqname($enqname)
    {
        $this->enq_name = $enqname;
    }

    function get_enqname()
    {
        return $this->enq_name;
    }

    function set_enqemail($enqemail)
    {
        $this->enq_email = $enqemail;
    }

    function get_enqemail()
    {
        return $this->enq_email;
    }

    function set_enqphone($enqphone)
    {
        $this->enq_phone = $enqphone;
    }

    function get_enqphone()
    {
        return $this->enq_phone;
    }
    function set_enqaddress($enqaddress)
    {
        $this->enq_address = $enqaddress;
    }
    function get_enqaddress()
    {
        return $this->enq_address;
    }

    // function set_enqmodifiedby($enqmodifiedby)
    // {
    //     $this->enq_modifiedBy = $enqmodifiedby;
    // }
    // function get_enqmodifiedby()
    // {
    //     return $this->enq_modifiedBy;
    // }

    function set_enqueryFor($enqueryForvalue)
    {
        $this->enqueryFor = $enqueryForvalue;
    }
    function get_enqueryFor()
    {
        return $this->enqueryFor;
    }


    // function set_enqcontactmode($enqcontactmode)
    // {
    //     $this->enq_preffered_contact_mode = $enqcontactmode;
    // }
    // function get_enqcontactmode()
    // {
    //     return $this->enq_preffered_contact_mode;
    // }

    /**
     * Get the value of createdDate
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set the value of createdDate
     *
     * @return  self
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    public function getEnq_Country()
    {
        return $this->enq_Country;
    }
    public function setEnq_Country($enq_Country)
    {
        $this->enq_Country = $enq_Country;

        return $this;
    }
    // public function setEnqPrefferedContactMode($mode) {
    //     $this->enq_preffered_contact_mode = $mode;
    // }

    // public function __construct() {
    //     $this->enq_preffered_contact_mode = ''; // or set a default value
    // }
}
