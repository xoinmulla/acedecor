<?php
class Rotation implements JsonSerializable
{
    private $rotationId ;
    private $sides;
    private	$modifiedOn;
    private	$createdBy;
    private $createdOn;
    private $modifiedBy	;
    private $table_name="rotation";
 
   function set_rotationId($rotationId)
    {
        $this->rotationId =$rotationId;
    }
    function get_rotationId()
    {
        return $this->rotationId ;
    }

    function set_sides($sides)
    {
        $this->sides=$sides;
    }
    function get_sides()
    {
        return $this->sides;
    }

    
    function set_ModifiedOn($ModifiedOn)
    {
        $this->modifiedOn=$ModifiedOn;
    }
    function get_ModifiedOn()
    {
        return $this->modifiedOn;
    }

    function set_ModifiedBy($ModifiedBy)
    {
        $this->modifiedBy=$ModifiedBy;
    }
    function get_ModifiedBy()
    {
        return $this->modifiedBy;
    }
    function set_CreatedBy($CreatedBy)
    {
        $this->createdBy=$CreatedBy;
    }
    function get_CreatedBy()
    {
        return $this->createdBy;
    }

    function set_CreatedOn($CreatedOn)
    {
        $this->createdOn=$CreatedOn;
    }
    function get_CreatedOn()
    {
        return $this->createdOn;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return 
            [
                'rotationId' => $this->rotationId,
                'sides' => $this->sides,
                'ModifiedBy'=>$this->modifiedBy,
                'CreatedBy'=>$this->createdBy,
                'CreatedOn'=>$this->createdOn,
                'ModifiedOn'=>$this->modifiedOn
            ];
        
    }
}