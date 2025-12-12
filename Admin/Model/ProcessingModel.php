<?php
class Processing implements JsonSerializable
{
    private $ProcessingId;
    private $Processing;
    private $CreatedBy;
    private $ModifiedBy;

    private $table_name="Processing";

    function setProcessingId($ProcessingId)
    {
        $this->ProcessingId = $ProcessingId;
    }
    function getProcessingId()
    {
        return $this->ProcessingId;
    }


    function setProcessing($Processing)
    {
        $this->Processing = $Processing;
    }
    function getProcessing()
    {
        return $this->Processing;
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
                'ProcessingId' => $this->ProcessingId,
                'Processing' => $this->Processing,
                'CreatedBy' =>$this->CreatedBy,
                'ModifiedBy' =>$this->ModifiedBy,
        ];
    }

}
?>

