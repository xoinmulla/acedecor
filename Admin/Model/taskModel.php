<?php
class Task  implements JsonSerializable
{
    private $TaskId;
    private $Date;
    private $TaskDescription;
    private $ContactPerson;
    private $ContactNo;
    private $Status;
    private $Task_modifiedBy;
    private $Task_createdBy;
    private $table_name = "projecttasks";


    function set_TaskId($TaskId)
    {
        $this->TaskId= $TaskId;
    }
    function get_TaskId()
    {
        return $this->TaskId;
    }

    function set_Date($Date)
    {
        $this->Date= $Date;
    }
    function get_Date()
    {
        return $this->Date;
    }

    function set_TaskDescription($TaskDescription)
    {
        $this->TaskDescription= $TaskDescription;
    }
    function get_TaskDescription()
    {
        return $this->TaskDescription;
    }

    function set_ContactPerson($ContactPerson)
    {
        $this->ContactPerson= $ContactPerson;
    }
    function get_ContactPerson()
    {
        return $this->ContactPerson;
    }

    function set_ContactNo($ContactNo)
    {
        $this->ContactNo= $ContactNo;
    }
    function get_ContactNo()
    {
        return $this->ContactNo;
    }

    function set_Status($Status)
    {
        $this->Status= $Status;
    }
    function get_Status()
    {
        return $this->Status;
    }

    function set_TaskmodifiedBy($TaskmodifiedBy)
    {
        $this->Task_modifiedBy= $TaskmodifiedBy;
    }
    function get_TaskmodifiedBy()
    {
        return $this->Task_modifiedBy;
    }

    function set_TaskcreatedBy($TaskcreatedBy)
    {
        $this->Task_createdBy= $TaskcreatedBy;
    }
    function get_TaskcreatedBy()
    {
        return $this->Task_createdBy;
    }



    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'TaskId' => $this->TaskId,
                'Date' => $this->Date,
               'TaskDescription'=> $this->TaskDescription,
               'ContactPerson'=> $this->ContactPerson,
               'ContactNo'=> $this->ContactNo,
               'Status'=> $this->Status,
               'TaskmodifiedBy'=> $this->Task_modifiedBy,
               'TaskcreatedBy'=> $this->Task_createdBy,
        ];
    }
}
