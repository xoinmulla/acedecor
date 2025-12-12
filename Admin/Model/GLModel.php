<?php
class GL implements JsonSerializable
{

    private $GL_Id;
    private $GL;
    

    private $table_name = "gl";


   
    public function getGL_Id()
    {
        return $this->GL_Id;
    }
    public function setGL_Id($GL_Id)
    {
        $this->GL_Id = $GL_Id;

        return $this;
    }
    
    public function getGL()
    {
        return $this->GL;
    }
    public function setGL($GL)
    {
        $this->GL = $GL;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            
                'GL_Id' => $this->GL_Id,
                'GL'=> $this->GL,

        ];
    
    }
 
   
}
