<?php
class Taskfollowup implements JsonSerializable
{
    private $FollowUp_Id;
    private $TaskID;
    private $FollowUp_Comments;
    private $FollowUp_createdBy;
    private $FollowUp_createdOn;
    private $FollowUp_modifiedBy;
    private $Followup_Status;
    
    private $table_name="taskfollowups";
    
    public function getFollowUp_Id()
    {
        return $this->FollowUp_Id;
    }
    public function setFollowUp_Id($FollowUp_Id)
    {
        $this->FollowUp_Id = $FollowUp_Id;

        return $this;
    }

    
    public function getTaskID()
    {
        return $this->TaskID;
    }
    public function setTaskID($TaskID)
    {
        $this->TaskID = $TaskID;

        return $this;
    }

  
    public function getFollowUp_Comments()
    {
        return $this->FollowUp_Comments;
    }
    public function setFollowUp_Comments($FollowUp_Comments)
    {
        $this->FollowUp_Comments = $FollowUp_Comments;

        return $this;
    }

    
    public function getFollowUp_createdBy()
    {
        return $this->FollowUp_createdBy;
    }
    public function setFollowUp_createdBy($FollowUp_createdBy)
    {
        $this->FollowUp_createdBy = $FollowUp_createdBy;

        return $this;
    }

   
    public function getFollowUp_modifiedBy()
    {
        return $this->FollowUp_modifiedBy;
    }
    public function setFollowUp_modifiedBy($FollowUp_modifiedBy)
    {
        $this->FollowUp_modifiedBy = $FollowUp_modifiedBy;

        return $this;
    }

    public function getFollowup_Status()
    {
        return $this->Followup_Status;
    }
    public function setFollowup_Status($Followup_Status)
    {
        $this->Followup_Status = $Followup_Status;

        return $this;
    }

    public function getFollowUp_createdOn()
    {
        return $this->FollowUp_createdOn;
    }
    public function setFollowUp_createdOn($FollowUp_createdOn)
    {
        $this->FollowUp_createdOn = $FollowUp_createdOn;

        return $this;
    }


    public function jsonSerialize()
    {
        return [
                'FollowUp_Id' => $this->FollowUp_Id,
                'TaskID' => $this->TaskID,
                'FollowUp_Comments'=>$this->FollowUp_Comments,
                'FollowUp_createdBy'=>$this->FollowUp_createdBy,
                'FollowUp_modifiedBy'=>$this->FollowUp_modifiedBy,
                'Followup_Status'=>$this->Followup_Status,
                'FollowUp_createdOn'=>$this->FollowUp_createdOn,
        ];
    }


   
    
}