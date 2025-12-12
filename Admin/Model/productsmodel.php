<?php
class Products implements JsonSerializable
{
    private $product_id ;
    private $Name;
    private $Length;
    private $Width;
    private $Quantity;
    private $CL_ID;
    private $CategoryId;
    private $CategoryName;
    private $SubcategoryId;
    private $SubcategoryName;
    private $FinishId;
    private $Code;
    private $CabinetType;
    private $Mat_Brand;
    private $Mat_BrandName;
    private $Rotation;
    private $Mat_Category;
    private $Mat_Subcategory;
    private $Thickness;
    private $Material;
    private $MaterialName;
    private $PEB;
    private $PEB_Thickness;
    private $SEB;
    private $SEB_Thickness;
    private $Comments;
    // private $product_image;
    private $product_modifiedby;
    private $product_createdby;
    private $productmaterialName;

   

    private $table_name="products";
 
    public function set_productid($productid)
    {
        $this->product_id =$productid;
    }
    public function get_productid()
    {
        return $this->product_id ;
    }

    public function getName()
    {
        return $this->Name;
    }
    public function setName($Name)
    {
        $this->Name = $Name;

        return $this;
    }
    public function getLength()
    {
        return $this->Length;
    }


    public function setLength($Length)
    {
        $this->Length = $Length;

        return $this;
    }

    public function getWidth()
    {
        return $this->Width;
    }
    public function setWidth($Width)
    {
        $this->Width = $Width;

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

   
    public function getCL_ID()
    {
        return $this->CL_ID;
    }
    public function setCL_ID($CL_ID)
    {
        $this->CL_ID = $CL_ID;

        return $this;
    }

    
    public function getCategoryId()
    {
        return $this->CategoryId;
    }
    public function setCategoryId($CategoryId)
    {
        $this->CategoryId = $CategoryId;

        return $this;
    }

  
    public function getSubcategoryId()
    {
        return $this->SubcategoryId;
    }
    public function setSubcategoryId($SubcategoryId)
    {
        $this->SubcategoryId = $SubcategoryId;

        return $this;
    }

    public function getFinishId()
    {
        return $this->FinishId;
    }
    public function setFinishId($FinishId)
    {
        $this->FinishId = $FinishId;

        return $this;
    }

    public function getCode()
    {
        return $this->Code;
    }
    public function setCode($Code)
    {
        $this->Code = $Code;

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

    public function getMat_Brand()
    {
        return $this->Mat_Brand;
    }
    public function setMat_Brand($Mat_Brand)
    {
        $this->Mat_Brand = $Mat_Brand;

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

    public function getMat_Category()
    {
        return $this->Mat_Category;
    }
    public function setMat_Category($Mat_Category)
    {
        $this->Mat_Category = $Mat_Category;

        return $this;
    }

    
    public function getMat_Subcategory()
    {
        return $this->Mat_Subcategory;
    }
    public function setMat_Subcategory($Mat_Subcategory)
    {
        $this->Mat_Subcategory = $Mat_Subcategory;

        return $this;
    }


    public function getThickness()
    {
        return $this->Thickness;
    }
    public function setThickness($Thickness)
    {
        $this->Thickness = $Thickness;

        return $this;
    }


    public function getMaterial()
    {
        return $this->Material;
    }
    public function setMaterial($Material)
    {
        $this->Material = $Material;

        return $this;
    }

   
    public function getPEB()
    {
        return $this->PEB;
    }
    public function setPEB($PEB)
    {
        $this->PEB = $PEB;

        return $this;
    }


    public function getPEB_Thickness()
    {
        return $this->PEB_Thickness;
    } 
    public function setPEB_Thickness($PEB_Thickness)
    {
        $this->PEB_Thickness = $PEB_Thickness;

        return $this;
    }

   
    public function getSEB()
    {
        return $this->SEB;
    } 
    public function setSEB($SEB)
    {
        $this->SEB = $SEB;

        return $this;
    }

  
    public function getSEB_Thickness()
    {
        return $this->SEB_Thickness;
    }
    public function setSEB_Thickness($SEB_Thickness)
    {
        $this->SEB_Thickness = $SEB_Thickness;

        return $this;
    }

   
    public function getComments()
    {
        return $this->Comments;
    }
    public function setComments($Comments)
    {
        $this->Comments = $Comments;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return
        [
            'productid' => $this->product_id,
            'Name' => $this->Name,
            'Length' => $this->Length,
            'Width' => $this->Width,
            'Quantity' => $this->Quantity,
            'CL_ID' => $this->CL_ID,
            'CategoryId'=> $this->CategoryId,
            'SubcategoryId' => $this->SubcategoryId,
            'FinishId' => $this->FinishId,
            'Code' => $this->Code,
            'CabinetType' => $this->CabinetType,
            'Mat_Brand' => $this->Mat_Brand,
            'Rotation' => $this->Rotation,
            'Mat_Category' => $this->Mat_Category,
            'Mat_Subcategory' => $this->Mat_Subcategory,
            'Thickness' => $this->Thickness,
            'Material' => $this->Material,
            'PEB' => $this->PEB,
            'PEB_Thickness' => $this->PEB_Thickness,
            'SEB'=> $this->SEB,
            'SEB_Thickness'=> $this->SEB_Thickness,
            'Comments'=> $this->Comments,
        ];
    }
 
    public function getCategoryName()
    {
        return $this->CategoryName;
    }
    public function setCategoryName($CategoryName)
    {
        $this->CategoryName = $CategoryName;

        return $this;
    }

    public function getSubcategoryName()
    {
        return $this->SubcategoryName;
    }
    public function setSubcategoryName($SubcategoryName)
    {
        $this->SubcategoryName = $SubcategoryName;

        return $this;
    }

    public function getMat_BrandName()
    {
        return $this->Mat_BrandName;
    }
    public function setMat_BrandName($Mat_BrandName)
    {
        $this->Mat_BrandName = $Mat_BrandName;

        return $this;
    }

   
    public function getMaterialName()
    {
        return $this->MaterialName;
    }
    public function setMaterialName($MaterialName)
    {
        $this->MaterialName = $MaterialName;

        return $this;
    }
}