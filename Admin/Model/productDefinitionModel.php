<?php
class ProductDefinition implements JsonSerializable
{
    private $prodDefinition_Id ;
    private $Prod_Name;
    private $Prod_Description;
    private $Rotation;
    private $RotationSide;
    private $Override;
    private $Type;
    private $CabinetType;
    private $Finish;
    private $Finishtype;
    private $Prod_Category;
    private $Prod_CategoryName;
    private $Prod_SubCategory;
    private $Prod_SubCategoryName;
    private $Quantity;
    private $LengthValue;
    private $Dimension1;
    private $WidthValue;
    private $Dimension2;
    private $DepthValue;
    private $Dimension3;
    private $CLFormula;
    private $CW;
    private $GL;
    private $GW;
    private $FL;
    private $BL;
    private $EB_L;
    private $RL;
    private $RW;
    private $EB_LW;
    private $Modifiedby;
    private $Createdby;

    private $table_name="product_definition";


    

   
    public function getProdDefinition_Id()
    {
        return $this->prodDefinition_Id;
    }

    public function setProdDefinition_Id($prodDefinition_Id)
    {
        $this->prodDefinition_Id = $prodDefinition_Id;

        return $this;
    }

    public function getProd_Name()
    {
        return $this->Prod_Name;
    }
    public function setProd_Name($Prod_Name)
    {
        $this->Prod_Name = $Prod_Name;

        return $this;
    }

    public function getProd_Description()
    {
        return $this->Prod_Description;
    }
    public function setProd_Description($Prod_Description)
    {
        $this->Prod_Description = $Prod_Description;

        return $this;
    }

    public function getRotation()
    {
        return $this->Rotation;
    }
    public function setRotation($Rotation)
    {
        $this->Rotation = $Rotation;

        return $this;
    }


    public function getOverride()
    {
        return $this->Override;
    }
    public function setOverride($Override)
    {
        $this->Override = $Override;

        return $this;
    }

    public function getType()
    {
        return $this->Type;
    }
    public function setType($Type)
    {
        $this->Type = $Type;

        return $this;
    }


    public function getFinish()
    {
        return $this->Finish;
    }
    public function setFinish($Finish)
    {
        $this->Finish = $Finish;

        return $this;
    }

    public function getProd_Category()
    {
        return $this->Prod_Category;
    }
    public function setProd_Category($Prod_Category)
    {
        $this->Prod_Category = $Prod_Category;

        return $this;
    }


    public function getProd_SubCategory()
    {
        return $this->Prod_SubCategory;
    }
    public function setProd_SubCategory($Prod_SubCategory)
    {
        $this->Prod_SubCategory = $Prod_SubCategory;

        return $this;
    }

    public function getQuantity()
    {
        return $this->Quantity;
    }

    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;

        return $this;
    }

  
    public function getCLFormula()
    {
        return $this->CLFormula;
    }
    public function setCLFormula($CLFormula)
    {
        $this->CLFormula = $CLFormula;

        return $this;
    }

    
    public function getCW()
    {
        return $this->CW;
    }
    public function setCW($CW)
    {
        $this->CW = $CW;

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

  
    public function getFL()
    {
        return $this->FL;
    }
    public function setFL($FL)
    {
        $this->FL = $FL;

        return $this;
    }

    
    public function getBL()
    {
        return $this->BL;
    }
    public function setBL($BL)
    {
        $this->BL = $BL;

        return $this;
    }



    public function getRL()
    {
        return $this->RL;
    }
    public function setRL($RL)
    {
        $this->RL = $RL;

        return $this;
    }

 
    public function getRW()
    {
        return $this->RW;
    }
    public function setRW($RW)
    {
        $this->RW = $RW;

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


    public function getModifiedby()
    {
        return $this->Modifiedby;
    }

    public function setModifiedby($Modifiedby)
    {
        $this->Modifiedby = $Modifiedby;

        return $this;
    }

   
    public function getCreatedby()
    {
        return $this->Createdby;
    }
    public function setCreatedby($Createdby)
    {
        $this->Createdby = $Createdby;

        return $this;
    }

    public function getLengthValue()
    {
        return $this->LengthValue;
    }
    public function setLengthValue($LengthValue)
    {
        $this->LengthValue = $LengthValue;

        return $this;
    }

    public function getDimension1()
    {
        return $this->Dimension1;
    }
    public function setDimension1($Dimension1)
    {
        $this->Dimension1 = $Dimension1;

        return $this;
    }

    
    public function getWidthValue()
    {
        return $this->WidthValue;
    }
    public function setWidthValue($WidthValue)
    {
        $this->WidthValue = $WidthValue;

        return $this;
    }

   
    public function getDimension2()
    {
        return $this->Dimension2;
    }
    public function setDimension2($Dimension2)
    {
        $this->Dimension2 = $Dimension2;

        return $this;
    }

   
    public function getDepthValue()
    {
        return $this->DepthValue;
    }
    public function setDepthValue($DepthValue)
    {
        $this->DepthValue = $DepthValue;

        return $this;
    }

   
    public function getDimension3()
    {
        return $this->Dimension3;
    } 
    public function setDimension3($Dimension3)
    {
        $this->Dimension3 = $Dimension3;

        return $this;
    }

    public function getProd_CategoryName()
    {
        return $this->Prod_CategoryName;
    }
    public function setProd_CategoryName($Prod_CategoryName)
    {
        $this->Prod_CategoryName = $Prod_CategoryName;

        return $this;
    }

    
    public function getProd_SubCategoryName()
    {
        return $this->Prod_SubCategoryName;
    }
    public function setProd_SubCategoryName($Prod_SubCategoryName)
    {
        $this->Prod_SubCategoryName = $Prod_SubCategoryName;

        return $this;
    }
    public function getRotationSide()
    {
        return $this->RotationSide;
    }
    public function setRotationSide($RotationSide)
    {
        $this->RotationSide = $RotationSide;

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

    
    public function getFinishtype()
    {
        return $this->Finishtype;
    }
    public function setFinishtype($Finishtype)
    {
        $this->Finishtype = $Finishtype;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return
        [
            'prodDefinition_Id' => $this->prodDefinition_Id,
            'Prod_Name' => $this->Prod_Name,
            'Prod_Description' => $this->Prod_Description,
            'Rotation' => $this->Rotation,
            'Override' => $this->Override,
            'Type' => $this->Type,
            'Finish'=> $this->Finish,
            'Prod_Category' => $this->Prod_Category,
            'Prod_SubCategory' => $this->Prod_SubCategory,
            'Quantity' => $this->Quantity,
            'LengthValue'=> $this->LengthValue,
            'Dimension1'=> $this->Dimension1,
            'WidthValue'=> $this->WidthValue,
            'Dimension2'=> $this->Dimension2,
            'DepthValue'=> $this->DepthValue,
            'Dimension3'=> $this->Dimension3,
            'CLFormula' => $this->CLFormula,
            'CW' => $this->CW,
            'GL' => $this->GL,
            'FL' => $this->FL,
            'BL' => $this->BL,
            'EB_L' => $this->EB_L,
            'RL' => $this->RL,
            'RW' => $this->RW,
            'EB_LW' => $this->EB_LW,
           
        ];
    }

    
   

   
    
}

