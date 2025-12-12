<?php
class dimension implements JsonSerializable
{
    private $dimensionId ;
    private $dimensionName;
    private	$dimensionDescription;
    private $length;
    private $breadth;
    private $thickness;
    private	$ModifiedOn;
    private	$CreatedBy;
    private $CreatedOn;
    private $ModifiedBy	;
    private $table_name="dimensions";
 
   function set_dimensionId($dimensionId)
    {
        $this->dimensionId =$dimensionId;
    }
    function get_dimensionId()
    {
        return $this->dimensionId ;
    }

    function set_dimensionName($dimensionName)
    {
        $this->dimensionName=$dimensionName;
    }
    function get_dimensionName()
    {
        return $this->dimensionName;
    }

    function set_dimensionDescription($dimensionDescription)
    {
        $this->dimensionDescription=$dimensionDescription;
    }
    function get_dimensionDescription()
    {
        return $this->dimensionDescription;
    }
    function set_length($length)
    {
        $this->length=$length;
    }
    function get_length()
    {
        return $this->length;
    }
    function set_breadth($breadth)
    {
        $this->breadth=$breadth;
    }
    function get_breadth()
    {
        return $this->breadth;
    }
    function set_thickness($thickness)
    {
        $this->thickness=$thickness;
    }
    function get_thickness()
    {
        return $this->thickness;
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
                'dimensionId' => $this->dimensionId,
                'dimensionName' => $this->dimensionName,
                'dimensionDescription' => $this->dimensionDescription,
                'length' =>$this->length,
                'breadth' =>$this->breadth,
                'thickness' =>$this->thickness,
                'modifiedBy'=>$this->ModifiedBy,
                'createdBy'=>$this->CreatedBy,
                'createdOn'=>$this->CreatedOn,
                'modifiedOn'=>$this->ModifiedOn
            ];
        
    }
}