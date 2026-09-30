<?php
class MatIssuesfollowup implements JsonSerializable
{
    private $followupId;
    private $followup_MaterialId;
    private $followup_comments;
    private $followup_by;
    private $followup_on;
    private $followupPOID;
    private $Status;

    private $table_name = "materialissues_followup";
    function set_followupOn($followupOn)
    {
        $this->followup_on = $followupOn;
    }
    function get_followupOn()
    {
        return $this->followup_on;
    }

    function set_followupPOID($followupPOID)
    {
        $this->followupPOID = $followupPOID;
    }
    function get_followupPOID()
    {
        return $this->followupPOID;
    }

    function set_followupid($followid)
    {
        $this->followupId = $followid;
    }
    function get_followupid()
    {
        return $this->followupId;
    }

    function set_followupMaterialId($followupMaterialId)
    {
        $this->followup_MaterialId = $followupMaterialId;
    }
    function get_followupMaterialId()
    {
        return $this->followup_MaterialId;
    }

    function set_followcomment($followcomment)
    {
        $this->followup_comments = $followcomment;
    }
    function get_followcomment()
    {
        return $this->followup_comments;
    }

    function set_followupBy($followupBy)
    {
        $this->followup_by = $followupBy;
    }
    function get_followupBy()
    {
        return $this->followup_by;
    }
    #[\ReturnTypeWillChange]

    public function jsonSerialize()
    {
        return [
            'followupid' => $this->followupId,
            'followupMaterialId ' => $this->followup_MaterialId,
            'followup_comments' => $this->followup_comments,
            'followup_by' => $this->followup_by,
            'followup_on' => $this->followup_on,
            'followupPOID' => $this->followupPOID,
            'followupStatus' => $this->Status,
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