<?php
class unit implements JsonSerializable
{
    private $unitId ;
    private $unitName;
    private	$unitDescription;
    private	$ModifiedOn;
    private	$CreatedBy;
    private $CreatedOn;
    private $ModifiedBy	;
    private $table_name="units";
 
   function set_unitId($unitId)
    {
        $this->unitId =$unitId;
    }
    function get_unitId()
    {
        return $this->unitId ;
    }

    function set_unitName($unitName)
    {
        $this->unitName=$unitName;
    }
    function get_unitName()
    {
        return $this->unitName;
    }

    function set_unitDescription($unitDescription)
    {
        $this->unitDescription=$unitDescription;
    }
    function get_unitDescription()
    {
        return $this->unitDescription;
    }


    function set_ModifiedOn($ModifiedOn)
    {
        $this->ModifiedOn=$ModifiedOn;
    }
    function get_ModifiedOn()
    {
        return $this->ModifiedOn;
    }

    function set_ModifiedBy($ModifiedBy)
    {
        $this->ModifiedBy=$ModifiedBy;
    }
    function get_ModifiedBy()
    {
        return $this->ModifiedBy;
    }
    function set_CreatedBy($CreatedBy)
    {
        $this->CreatedBy=$CreatedBy;
    }
    function get_CreatedBy()
    {
        return $this->CreatedBy;
    }

    function set_CreatedOn($CreatedOn)
    {
        $this->CreatedOn=$CreatedOn;
    }
    function get_CreatedOn()
    {
        return $this->CreatedOn;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
            [
                'unitId' => $this->unitId,
                'unitName' => $this->unitName,
                'unitDescription' => $this->unitDescription,
                'modifiedBy'=>$this->ModifiedBy,
                'createdBy'=>$this->CreatedBy,
                'createdOn'=>$this->CreatedOn,
                'modifiedOn'=>$this->ModifiedOn
            ];
        
    }
}