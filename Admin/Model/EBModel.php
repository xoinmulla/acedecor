<?php
class EB implements JsonSerializable
{

    private $EB_Id  ;
    private $EB;
    private $CreatedBy;
    private $ModifiedBy;
    

    private $table_name = "EB";


    public function getEB_Id()
    {
        return $this->EB_Id;
    }
    public function setEB_Id($EB_Id)
    {
        $this->EB_Id = $EB_Id;

        return $this;
    }

   
    public function getEB()
    {
        return $this->EB;
    }
    public function setEB($EB)
    {
        $this->EB = $EB;

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
            
                'EB_Id' => $this->EB_Id,
                'EB'=> $this->EB,

        ];
    
    }
    

   
}
