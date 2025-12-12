<?php
class CLDimension implements JsonSerializable
{

    private $CLDimensionId;
    private $CL_Dimensions;
    

    private $table_name = "cl_dimension";


   
    public function getCLDimensionId()
    {
        return $this->CLDimensionId;
    }
    public function setCLDimensionId($CLDimensionId)
    {
        $this->CLDimensionId = $CLDimensionId;

        return $this;
    }
    

    public function getCL_Dimensions()
    {
        return $this->CL_Dimensions;
    }
    public function setCL_Dimensions($CL_Dimensions)
    {
        $this->CL_Dimensions = $CL_Dimensions;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'CLDimensionId' => $this->CLDimensionId,
                'CL_Dimensions'=> $this->CL_Dimensions,

        ];
    
    }



  
}
