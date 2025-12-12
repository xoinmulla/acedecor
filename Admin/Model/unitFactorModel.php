<?php
class unitFactor implements JsonSerializable
{
    private $unitFactorId;
    private $unitId ;
    private $unitName;
    private $unitFactor;
    private	$unitFactorDescription;
    private	$ModifiedOn;
    private	$CreatedBy;
    private $CreatedOn;
    private $ModifiedBy	;
    private $table_name="units";
 
    function set_unitFactor($unitFactor)
    {
        $this->unitFactor =$unitFactor;
    }
    function get_unitFactor()
    {
        return $this->unitFactor ;
    }
    function set_unitFactorId($unitFactorId)
    {
        $this->unitFactorId =$unitFactorId;
    }
    function get_unitFactorId()
    {
        return $this->unitFactorId ;
    }
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

    function set_unitFactorDescription($unitFactorDescription)
    {
        $this->unitFactorDescription=$unitFactorDescription;
    }
    function get_unitFactorDescription()
    {
        return $this->unitFactorDescription;
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
                'unitFactorId' => $this->unitFactorId,
                'unitId' => $this->unitId,
                'unitName' => $this->unitName,
                'unitFactor'=> $this->unitFactor,
                'unitFactorDescription' => $this->unitFactorDescription,
                'modifiedBy'=>$this->ModifiedBy,
                'createdBy'=>$this->CreatedBy,
                'createdOn'=>$this->CreatedOn,
                'modifiedOn'=>$this->ModifiedOn
            ];
        
    }
}