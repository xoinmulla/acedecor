<?php
class Thickness  implements JsonSerializable
{
    private $Thickness_Id;
    private $Thickness;
    private $Thickness_modifiedby;
    private $Thickness_createdby;
    
    private $table_name = "thickness";

    function set_ThicknessId($ThicknessId)
    {
        $this->Thickness_Id= $ThicknessId;
    }
    function get_ThicknessId()
    {
        return $this->Thickness_Id;
    }

    function set_Thickness($Thickness)
    {
        $this->Thickness= $Thickness;
    }
    function get_Thickness()
    {
        return $this->Thickness;
    }

    function set_Thicknesscreatedby($Thicknesscreatedby)
    {
        $this->Thickness_createdby= $Thicknesscreatedby;
    }
    function get_Thicknesscreatedby()
    {
        return $this->Thickness_createdby;
    }

    function set_Thicknessmodifiedby($Thicknessmodifiedby)
    {
        $this->Thickness_modifiedby= $Thicknessmodifiedby;
    }
    function get_Thicknessmodifiedby()
    {
        return $this->Thickness_modifiedby;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'ThicknessId' => $this->Thickness_Id,
                'Thickness' => $this->Thickness,
               
            
        ];
    }
}
