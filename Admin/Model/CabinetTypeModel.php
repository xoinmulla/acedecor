<?php
class CabinetType implements JsonSerializable
{

    private $CabinetType_Id ;
    private $CabinetType;
    private $CreatedBy;
    private $ModifiedBy;
    

    private $table_name = "cabinettype";


    public function getCabinetType_Id()
    {
        return $this->CabinetType_Id;
    }
    public function setCabinetType_Id($CabinetType_Id)
    {
        $this->CabinetType_Id = $CabinetType_Id;

        return $this;
    }

   
    public function getCabinetType()
    {
        return $this->CabinetType;
    }
    public function setCabinetType($CabinetType)
    {
        $this->CabinetType = $CabinetType;

        return $this;
    }
   
    public function getCreatedBy()
    {
        return $this->CreatedBy;
    }
    public function setCreatedBy($CreatedBy)
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }

    public function getModifiedBy()
    {
        return $this->ModifiedBy;
    }
    public function setModifiedBy($ModifiedBy)
    {
        $this->ModifiedBy = $ModifiedBy;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'CabinetType_Id' =>$this->CabinetType_Id,
                'CabinetType'=>$this->CabinetType,

        ];
    
    }
    
}
