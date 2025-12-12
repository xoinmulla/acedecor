<?php
class InputType  implements JsonSerializable{
    private $InputTypeId;
    private $InputType;
    private $isMapped;
  
    function get_InputTypeId(){
        return $this->InputTypeId;
    }
    function set_InputTypeId($InputTypeId){
        $this->InputTypeId=$InputTypeId;
    }
    function get_InputType(){
        return $this->InputType;
    }
    function set_InputType($InputType){
        $this->InputType=$InputType;
    }

    function set_isMapped($isMapped)
    {
        $this->isMapped= $isMapped;
    }
    function get_isMapped()
    {
        return $this->isMapped;
    }
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'InputType' => $this->InputType,
                'InputTypeId' =>$this->InputTypeId,
                'isMapped' =>$this->isMapped,
        ];
    }
}

?>