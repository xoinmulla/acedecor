<?php
class Material_Details implements JsonSerializable
{
    private $Material_Id;
    private $Material_Name;
    private $Material_Code;
    private $Material_Description;
    private $MaterialAmount;

    private $Category;
    private $CategoryName;

    private $SubCategory;
    private $SubCategoryName;

    private $Brand;
    private $BrandName;

    private $Mat_Unit;               // Unit Value
    private $MaterialUnitId;         // Unit ID

    private $MaterialUnitFactorId;   // Unit Factor ID
    private $MaterialUnitFactorValue; // ✔ NEW: Unit Factor VALUE

    private $Mat_Image;

    // GRAINS
    private $Mat_Grains;
    private $MaterialGrainsId;
    private $MaterialGrainsName;

    // THICKNESS
    private $Mat_Thickness;
    private $Mat_ThicknessID;

    // PRICING
    private $Mat_SPU;
    private $Mat_HSNCode;
    private $Mat_MRP;
    private $Mat_GST;
    private $Mat_TotalMRP;
    private $Mat_PPMRP;
    private $Mat_Qty;

    private $AvailableQty;
    private $AllocatedQty;
    private $ReceivedQty;

    private $POcode;
    private $InvoiceNo;
    private $DateofPurchase;
    private $ItemPrice;
    private $ReceivedQtyAmt;
    private $TotalAmount;

    private $MaterialDiscount;
    private $MaterialPrice;
    private $MaterialTotalValue;

    private $Mat_createdBy;
    private $Mat_modifiedBy;

    /* ---------------------------------------------
       BASIC GETTERS & SETTERS
    --------------------------------------------- */
    
    function set_MaterialId($v) { $this->Material_Id = $v; }
    function get_MaterialId() { return $this->Material_Id; }

    function set_MaterialName($v) { $this->Material_Name = $v; }
    function get_MaterialName() { return $this->Material_Name; }

    function set_MaterialDescription($v) { $this->Material_Description = $v; }
    function get_MaterialDescription() { return $this->Material_Description; }

    function set_MaterialCode($v) { $this->Material_Code = $v; }
    function get_MaterialCode() { return $this->Material_Code; }

    /* CATEGORY */
    function set_Category($v) { $this->Category = $v; }
    function get_Category() { return $this->Category; }

    function set_CategoryName($v) { $this->CategoryName = $v; }
    function get_CategoryName() { return $this->CategoryName; }

    /* SUBCATEGORY */
    function set_SubCategory($v) { $this->SubCategory = $v; }
    function get_SubCategory() { return $this->SubCategory; }

    function set_SubCategoryName($v) { $this->SubCategoryName = $v; }
    function get_SubCategoryName() { return $this->SubCategoryName; }

    /* BRAND */
    function set_Brand($v) { $this->Brand = $v; }
    function get_Brand() { return $this->Brand; }

    function set_BrandName($v) { $this->BrandName = $v; }
    function get_BrandName() { return $this->BrandName; }

    /* IMAGE */
    function set_MaterialImage($v) { $this->Mat_Image = $v; }
    function get_MaterialImage() { return $this->Mat_Image; }

    /* GRAINS */
    function set_MaterialGrains($v) { $this->Mat_Grains = $v; }
    function get_MaterialGrains() { return $this->Mat_Grains; }

    function set_MaterialGrainsId($v) { $this->MaterialGrainsId = $v; }
    function get_MaterialGrainsId() { return $this->MaterialGrainsId; }

    function set_MaterialGrainsName($v) { $this->MaterialGrainsName = $v; }
    function get_MaterialGrainsName() { return $this->MaterialGrainsName; }

    /* THICKNESS */
    function set_MaterialThickness($v) { $this->Mat_Thickness = $v; }
    function get_MaterialThickness() { return $this->Mat_Thickness; }

    function set_MaterialThicknessID($v) { $this->Mat_ThicknessID = $v; }
    function get_MaterialThicknessID() { return $this->Mat_ThicknessID; }

    /* UNIT */
    function set_MaterialUnit($v) { $this->Mat_Unit = $v; }
    function get_MaterialUnit() { return $this->Mat_Unit; }

    function set_MaterialUnitId($v) { $this->MaterialUnitId = $v; }
    function get_MaterialUnitId() { return $this->MaterialUnitId; }

    /* UNIT FACTOR — FIXED ✔ */
    function set_MaterialUnitFactorId($v) { $this->MaterialUnitFactorId = $v; }
    function get_MaterialUnitFactorId() { return $this->MaterialUnitFactorId; }

    // ✔ NEW: VALUE SEPARATE FROM ID
    function set_MaterialUnitFactor($v) { $this->MaterialUnitFactorValue = $v; }
    function get_MaterialUnitFactor() { return $this->MaterialUnitFactorValue; }

    /* PRICING */
    function set_MaterialSPU($v) { $this->Mat_SPU = $v; }
    function get_MaterialSPU() { return $this->Mat_SPU; }

    function set_MaterialHSNcode($v) { $this->Mat_HSNCode = $v; }
    function get_MaterialHSNcode() { return $this->Mat_HSNCode; }

    function set_MaterialMRP($v) { $this->Mat_MRP = $v; }
    function get_MaterialMRP() { return $this->Mat_MRP; }

    function set_MaterialGST($v) { $this->Mat_GST = $v; }
    function get_MaterialGST() { return $this->Mat_GST; }

    function set_MaterialTotalMRP($v) { $this->Mat_TotalMRP = $v; }
    function get_MaterialTotalMRP() { return $this->Mat_TotalMRP; }

    function set_MaterialPPMRP($v) { $this->Mat_PPMRP = $v; }
    function get_MaterialPPMRP() { return $this->Mat_PPMRP; }

    function set_MaterialQty($v) { $this->Mat_Qty = $v; }
    function get_MaterialQty() { return $this->Mat_Qty; }

    /* DISCOUNT & PRICE */
    function set_MaterialDiscount($v) { $this->MaterialDiscount = $v; }
    function get_MaterialDiscount() { return $this->MaterialDiscount; }

    function set_MaterialAmount($v) { $this->MaterialAmount = $v; }
    function get_MaterialAmount() { return $this->MaterialAmount; }

    function set_MaterialPrice($v) { $this->MaterialPrice = $v; }
    function get_MaterialPrice() { return $this->MaterialPrice; }

    function set_MaterialTotalValue($v) { $this->MaterialTotalValue = $v; }
    function get_MaterialTotalValue() { return $this->MaterialTotalValue; }

    /* STOCK */
    function set_ReceivedQty($v) { $this->ReceivedQty = $v; }
    function get_ReceivedQty() { return $this->ReceivedQty; }

    function setAllocatedQty($v) { $this->AllocatedQty = $v; }
    function getAllocatedQty() { return $this->AllocatedQty; }

    function setAvailableQty($v) { $this->AvailableQty = $v; }
    function getAvailableQty() { return $this->AvailableQty; }

    /* CREATED / MODIFIED */
    function set_MaterialCreatedBy($v) { $this->Mat_createdBy = $v; }
    function get_MaterialCreatedBy() { return $this->Mat_createdBy; }

    function set_MaterialModifiedBy($v) { $this->Mat_modifiedBy = $v; }
    function get_MaterialModifiedBy() { return $this->Mat_modifiedBy; }

    /* JSON OUTPUT */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'MaterialId' => $this->Material_Id,
            'MaterialName' => $this->Material_Name,
            'MaterialDescription' => $this->Material_Description,
            'MaterialImage' => $this->Mat_Image,

            'Category' => $this->Category,
            'CategoryName' => $this->CategoryName,

            'SubCategory' => $this->SubCategory,
            'SubCategoryName' => $this->SubCategoryName,

            'Brand' => $this->Brand,
            'BrandName' => $this->BrandName,

            'MaterialCode' => $this->Material_Code,

            'MaterialUnitId' => $this->MaterialUnitId,
            'MaterialUnit' => $this->Mat_Unit,

            'MaterialUnitFactorId' => $this->MaterialUnitFactorId,
            'MaterialUnitFactor' => $this->MaterialUnitFactorValue, // ✔ FIXED

            'MaterialThicknessID' => $this->Mat_ThicknessID,
            'MaterialThickness' => $this->Mat_Thickness,

            'MaterialGrains' => $this->Mat_Grains,
            'MaterialGrainsId' => $this->MaterialGrainsId,
            'MaterialGrainsName' => $this->MaterialGrainsName,

            'MaterialSPU' => $this->Mat_SPU,
            'MaterialHSNcode' => $this->Mat_HSNCode,
            'MaterialMRP' => $this->Mat_MRP,
            'MaterialGST' => $this->Mat_GST,
            'MaterialTotalMRP' => $this->Mat_TotalMRP,
            'MaterialPPMRP' => $this->Mat_PPMRP,
            'MaterialQty' => $this->Mat_Qty,

            'MaterialDiscount' => $this->MaterialDiscount,
            'MaterialPrice' => $this->MaterialPrice,
            'MaterialTotalValue' => $this->MaterialTotalValue,

            'ReceivedQty' => $this->ReceivedQty,
            'AllocatedQty' => $this->AllocatedQty,
            'AvailableQty' => $this->AvailableQty,
            'MaterialAmount' => $this->MaterialAmount,
        ];
    }
}
