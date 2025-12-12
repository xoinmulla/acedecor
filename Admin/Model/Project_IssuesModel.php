<?php
class ProjectIssues implements JsonSerializable
{
    private $IssueId ;
    private $Issue_ProjectId  ;
    private $Issue_ProjCode  ;
    private $Issue_Description;
    private $Issue_ContactName;
    private $Issue_ContactDetails;
    private $Status;
    private $Issue_createdby;
    private $Issue_createdon;
    private $Issue_modifiedby;	
    
    private $table_name="project_issues";
    
    public function getIssueId()
    {
        return $this->IssueId;
    }
    public function setIssueId($IssueId)
    {
        $this->IssueId = $IssueId;

        return $this;
    }

   
    public function getIssue_ProjectId()
    {
        return $this->Issue_ProjectId;
    }
    public function setIssue_ProjectId($Issue_ProjectId)
    {
        $this->Issue_ProjectId = $Issue_ProjectId;

        return $this;
    }

    
    public function getIssue_ProjCode()
    {
        return $this->Issue_ProjCode;
    }
    public function setIssue_ProjCode($Issue_ProjCode)
    {
        $this->Issue_ProjCode = $Issue_ProjCode;

        return $this;
    }

     
    public function getIssue_Description()
    {
        return $this->Issue_Description;
    }
    public function setIssue_Description($Issue_Description)
    {
        $this->Issue_Description = $Issue_Description;

        return $this;
    }

    public function getIssue_ContactName()
    {
        return $this->Issue_ContactName;
    }
    public function setIssue_ContactName($Issue_ContactName)
    {
        $this->Issue_ContactName = $Issue_ContactName;

        return $this;
    }

    
    public function getIssue_ContactDetails()
    {
        return $this->Issue_ContactDetails;
    }
    public function setIssue_ContactDetails($Issue_ContactDetails)
    {
        $this->Issue_ContactDetails = $Issue_ContactDetails;

        return $this;
    }
   
    public function getStatus()
    {
        return $this->Status;
    }
    public function setStatus($Status)
    {
        $this->Status = $Status;

        return $this;
    }

   
    public function getIssue_createdby()
    {
        return $this->Issue_createdby;
    }
    public function setIssue_createdby($Issue_createdby)
    {
        $this->Issue_createdby = $Issue_createdby;

        return $this;
    }

   
    public function getIssue_modifiedby()
    {
        return $this->Issue_modifiedby;
    }
    public function setIssue_modifiedby($Issue_modifiedby)
    {
        $this->Issue_modifiedby = $Issue_modifiedby;

        return $this;
    }
   
    public function jsonSerialize()
    {
        return [
                'IssueId' => $this->IssueId,
                'Issue_ProjectId'=> $this->Issue_ProjectId,
                'Issue_ProjCode' => $this->Issue_ProjCode,
                'Issue_Description'=>$this->Issue_Description,
                'Status'=>$this->Status,
                'Issue_createdby'=>$this->Issue_createdby,
                'Issue_createdon'=>$this->Issue_createdon,
                'Issue_modifiedby'=>$this->Issue_modifiedby,
                'Issue_ContactName'=>$this->Issue_ContactName,
                'Issue_ContactDetails'=>$this->Issue_ContactDetails,
                
        ];
    }

   

    /**
     * Get the value of Issue_createdon
     */ 
    public function getIssue_createdon()
    {
        return $this->Issue_createdon;
    }

    /**
     * Set the value of Issue_createdon
     *
     * @return  self
     */ 
    public function setIssue_createdon($Issue_createdon)
    {
        $this->Issue_createdon = $Issue_createdon;

        return $this;
    }
}