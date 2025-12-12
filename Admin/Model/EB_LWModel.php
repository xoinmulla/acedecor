<?php
class EBLW implements JsonSerializable
{

    private $EBLW_Id  ;
    private $EB_LW;
    private $CreatedBy;
    private $ModifiedBy;
    

    private $table_name = "eb_lw";


    public function getEBLW_Id()
    {
        return $this->EBLW_Id;
    }
    public function setEBLW_Id($EBLW_Id)
    {
        $this->EBLW_Id = $EBLW_Id;

        return $this;
    }

   
    public function getEB_LW()
    {
        return $this->EB_LW;
    }
    public function setEB_LW($EB_LW)
    {
        $this->EB_LW = $EB_LW;

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
            
                'EBLW_Id' => $this->EBLW_Id,
                'EB_LW'=> $this->EB_LW,

        ];
    
    }
    

   
}
