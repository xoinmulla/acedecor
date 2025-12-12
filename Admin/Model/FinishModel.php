<?php
class Finish implements JsonSerializable
{
    private $FinishId;
    private $Finish;
    private $CreatedBy;
    private $ModifiedBy;

    private $table_name="finish";

    function setFinishId($FinishId)
    {
        $this->FinishId = $FinishId;
    }
    function getFinishId()
    {
        return $this->FinishId;
    }


    function setFinish($Finish)
    {
        $this->Finish = $Finish;
    }
    function getFinish()
    {
        return $this->Finish;
    }


    function setCreatedBy($CreatedBy)
    {
        $this->CreatedBy = $CreatedBy;
    }
    function getCreatedBy()
    {
        return $this->CreatedBy;
    }

    function setModifiedBy($ModifiedBy)
    {
        $this->ModifiedBy = $ModifiedBy;
    }
    function getModifiedBy()
    {
        return $this->ModifiedBy;
    }



    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
                'FinishId' => $this->FinishId,
                'Finish' => $this->Finish,
                'CreatedBy' =>$this->CreatedBy,
                'ModifiedBy' =>$this->ModifiedBy,
        ];
    }

}
?>

