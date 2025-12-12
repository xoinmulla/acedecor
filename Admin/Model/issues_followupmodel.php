<?php
class Issuesfollowup implements JsonSerializable
{
    private $followupId;
    private $followup_ItemId ;
    private $followup_comments;
    private $followup_by;
    private $followup_on;
    private $followupPOID;
    private $Status;
    
    private $table_name="itemissues_followups";
    function set_followupOn($followupOn)
    {
        $this->followup_on=$followupOn;
    }
    function get_followupOn()
    {
        return $this->followup_on;
    }

    function set_followupPOID($followupPOID)
    {
        $this->followupPOID=$followupPOID;
    }
    function get_followupPOID()
    {
        return $this->followupPOID;
    }

   function set_followid($followid)
    {
        $this->followupId=$followid;
    }
    function get_followid()
    {
        return $this->followupId;
    }

    function set_followupItemId($followupItemId)
    {
        $this->followup_ItemId=$followupItemId;
    }
    function get_followupItemId()
    {
        return $this->followup_ItemId;
    }

    function set_followcomment($followcomment)
    {
        $this->followup_comments=$followcomment;
    }
    function get_followcomment()
    {
        return $this->followup_comments;
    }

    function set_followupBy($followupBy)
    {
        $this->followup_by=$followupBy;
    }
    function get_followupBy()
    {
        return $this->followup_by;
    }

    public function jsonSerialize()
    {
        return [
                'followupid' => $this->followupId,
                'followItemId' => $this->followup_ItemId,
                'followup_comments'=>$this->followup_comments,
                'followup_by'=>$this->followup_by,
                'followup_on'=>$this->followup_on,
                'followupPOID'=>$this->followupPOID,
                'followupStatus'=>$this->Status,
        ];
    }

  
    public function getEnqStatus()
    {
        return $this->enqStatus;
    } 
    public function setEnqStatus($enqStatus)
    {
        $this->enqStatus = $enqStatus;

        return $this;
    }

    public function get_followupStatus()
    {
        return $this->Status;
    } 
    public function set_followupStatus($followupStatus)
    {
        $this->Status = $followupStatus;

        return $this;
    }
}