<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/materialModel.php";
class DBmaterialdetails
{
  public static function insert($M)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "INSERT INTO material (
            Material_Name,
            Material_Code,
            Material_Description,
            Category,
            SubCategory,
            Mat_Qty,
            Brand,
            Mat_Thickness,
            Mat_Unit,
            Mat_factor,
            Mat_HSNCode,
            Mat_SPU,
            Mat_MRP,
            Mat_GST,
            MaterialDiscount,
            MaterialAmount,
            MaterialPrice,
            MaterialTotalValue,
            Mat_Image,
            Mat_Grains,
            Mat_modifiedBy,
            Mat_createdBy
        ) VALUES (
            '{$M->get_MaterialName()}',
            '{$M->get_MaterialCode()}',
            '{$M->get_MaterialDescription()}',
            '{$M->get_Category()}',
            '{$M->get_SubCategory()}',
            '{$M->get_MaterialQty()}',
            '{$M->get_Brand()}',
            '{$M->get_MaterialThickness()}',
            '{$M->get_MaterialUnitId()}',
            '{$M->get_MaterialUnitFactorId()}',
            '{$M->get_MaterialHSNcode()}',
            '{$M->get_MaterialSPU()}',
            '{$M->get_MaterialMRP()}',
            '{$M->get_MaterialGST()}',
            '{$M->get_MaterialDiscount()}',
            '{$M->get_MaterialAmount()}',
            '{$M->get_MaterialPrice()}',
            '{$M->get_MaterialTotalValue()}',
            '{$M->get_MaterialImage()}',
            '{$M->get_MaterialGrainsId()}',
            '{$M->get_materialmodifiedby()}',
            '{$M->get_materialcreatedby()}'
        )";

    error_log($sql);
    $conn->query($sql);
  }

  /* ======================================================
     SELECT MATERIAL LIST
  ====================================================== */
  public static function getallMaterialdetails()
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "SELECT 
            M.Material_Id AS MaterialId,
            M.Material_Name AS MaterialName,
            M.Material_Description AS MaterialDescription,

            -- Category
            M.Category AS CategoryId,
            C.material_catName AS CategoryName,

            -- Subcategory
            M.SubCategory AS SubCategoryId,
            SC.material_subcatName AS SubCategoryName,

            -- Brand
            M.Brand AS BrandId,
            B.brand_name AS BrandName,

            -- Codes
            M.Material_Code AS MaterialCode,

            -- Units
            M.Mat_Unit AS UnitId,
            U.unitName as UnitName,

            -- Unit Factor
            M.Mat_factor as UnitFactorId,
            UF.unitFactor as UnitFactor,

            -- Thickness
            M.Mat_Thickness as ThicknessId,
            T.Thickness as ThicknessName,

            -- Grains
            M.Mat_Grains as GrainsId,
            R.sides as GrainsName,

            -- Image
            M.Mat_Image as MaterialImage,

            -- Numbers
            M.Mat_Qty as Qty,
            M.Mat_HSNCode as HSNCode,
            M.Mat_SPU as SPU,
            M.Mat_MRP as MRP,
            M.Mat_GST as GST,
            M.Mat_TotalMRP as TotalMRP,
            M.Mat_PPMRP as PPMRP,
            M.MaterialDiscount as Discount,
            M.MaterialPrice as Price,
            M.MaterialTotalValue as TotalValue,

            -- Allocation
            SUM(A.AllocatedQty) as AllocatedQty,

            -- Stocks
            TEMP.ReceivedQty as InwardedQty,

            CASE 
                WHEN SUM(A.AllocatedQty) IS NOT NULL 
                    THEN TEMP.ReceivedQty - SUM(A.AllocatedQty)
                ELSE TEMP.ReceivedQty
            END AS AvailableQty

        FROM material M

        LEFT JOIN material_category C ON M.Category = C.material_catId
        LEFT JOIN material_subcategory SC ON M.SubCategory = SC.material_subcatId

        LEFT JOIN (
            SELECT 
                item_id AS ItemId,
                SUM(ReceivedQty) AS ReceivedQty
            FROM item_stock
            GROUP BY item_id
        ) AS TEMP ON TEMP.ItemId = M.Material_Id

        LEFT JOIN itemallocation A ON A.ItemId = M.Material_Id

        LEFT JOIN brands B        ON B.brand_id = M.Brand
        LEFT JOIN thickness T     ON T.Thickness_Id = M.Mat_Thickness
        LEFT JOIN units U         ON U.unitId = M.Mat_Unit
        LEFT JOIN unitsfactor UF  ON UF.unitFactorId = M.Mat_factor
        LEFT JOIN rotation R      ON R.rotationId = M.Mat_Grains

        GROUP BY M.Material_Id";

    $result = $conn->query($sql);
    $list = [];

    while ($r = mysqli_fetch_assoc($result)) {
      $M = new Material_Details();

      $M->set_MaterialId($r['MaterialId']);
      $M->set_MaterialName($r['MaterialName']);
      $M->set_MaterialDescription($r['MaterialDescription']);

      $M->set_Category($r['CategoryId']);
      $M->set_CategoryName($r['CategoryName']);

      $M->set_SubCategory($r['SubCategoryId']);
      $M->set_SubCategoryName($r['SubCategoryName']);

      $M->set_Brand($r['BrandId']);
      $M->set_BrandName($r['BrandName']);

      $M->set_MaterialImage($r['MaterialImage']);
      $M->set_MaterialCode($r['MaterialCode']);

      $M->set_MaterialUnitId($r['UnitId']);
      $M->set_MaterialUnit($r['UnitName']);

      $M->set_MaterialUnitFactorId($r['UnitFactorId']);
      $M->set_MaterialUnitFactor($r['UnitFactor']);

      $M->set_MaterialThicknessID($r['ThicknessId']);
      $M->set_MaterialThickness($r['ThicknessName']);

      $M->set_MaterialGrainsId($r['GrainsId']);
      $M->set_MaterialGrains($r['GrainsName']);

      $M->set_MaterialQty($r['Qty']);
      $M->set_MaterialHSNcode($r['HSNCode']);
      $M->set_MaterialSPU($r['SPU']);
      $M->set_MaterialMRP($r['MRP']);
      $M->set_MaterialGST($r['GST']);
      $M->set_MaterialTotalMRP($r['TotalMRP']);
      $M->set_MaterialPPMRP($r['PPMRP']);
      $M->set_MaterialDiscount($r['Discount']);
      $M->set_MaterialPrice($r['Price']);
      $M->set_MaterialTotalValue($r['TotalValue']);

      $M->set_ReceivedQty($r['InwardedQty']);
      $M->setAllocatedQty($r['AllocatedQty']);
      $M->setAvailableQty($r['AvailableQty']);

      $list[] = $M;
    }

    return $list;
  }

  /* ======================================================
     UPDATE MATERIAL
  ====================================================== */
  public static function update($M)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "UPDATE material SET
            Material_Name       = '{$M->get_MaterialName()}',
            Material_Description= '{$M->get_MaterialDescription()}',
            Brand               = '{$M->get_Brand()}',
            Material_Code       = '{$M->get_MaterialCode()}',
            Category            = '{$M->get_Category()}',
            SubCategory         = '{$M->get_SubCategory()}',
            Mat_Unit            = '{$M->get_MaterialUnitId()}',
            Mat_factor          = '{$M->get_MaterialUnitFactorId()}',
            Mat_Image           = '{$M->get_MaterialImage()}',
            Mat_Grains          = '{$M->get_MaterialGrainsId()}',
            Mat_modifiedBy      = '{$M->get_materialmodifiedby()}',
            Mat_createdBy       = '{$M->get_materialcreatedby()}',
            MaterialDiscount    = '{$M->get_MaterialDiscount()}',
            MaterialAmount       = '{$M->get_MaterialAmount()}',
            MaterialPrice       = '{$M->get_MaterialPrice()}',
            MaterialTotalValue  = '{$M->get_MaterialTotalValue()}'
        WHERE Material_Id = {$M->get_MaterialId()}";

    error_log($sql);
    $conn->query($sql);
  }

  /* ======================================================
     DELETE MATERIAL
  ====================================================== */
  public static function delete($id)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "DELETE FROM material WHERE Material_Id = '$id'";
    error_log($sql);

    $conn->query($sql);
  }



  public static function getallMaterialdetailsbasedonIDforstocks($Matid)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT M.Material_Id  AS MaterialId ,
      M.Material_Name AS MaterialName,
      M.Material_Description AS MaterialDescription,
      M.Mat_MRP AS MRP,
      M.Mat_PPMRP AS PPMRP,
      M.Mat_GST AS GST
      FROM material M 
      where M.Material_Id='" . $Matid . "'";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $view = new Material_Details();
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $view->set_MaterialId($row['MaterialId']);
        $view->set_MaterialName($row['MaterialName']);
        $view->set_MaterialDescription($row["MaterialDescription"]);
      }
    } else {
      // echo "0 results";
    }

    return $view;
  }

  //   public static function update($detailsObj)
//   {
//     $db = ConnectDb::getInstance();
//     $connectionObj = $db->getConnection();
//     $sql = "UPDATE material SET 
//     Material_Name='" . $detailsObj->get_MaterialName() . "',
//     Material_Description='" . $detailsObj->get_MaterialDescription() . "',
//     Brand='" . $detailsObj->get_Brand() . "',
//     Material_Code='" . $detailsObj->get_MaterialCode() . "',
//     Category='" . $detailsObj->get_Category() . "',
//     SubCategory='" . $detailsObj->get_SubCategory() . "',
//     Mat_Unit='" . $detailsObj->get_MaterialUnit() . "',
//     Mat_factor='" . $detailsObj->get_MaterialUnitFactor() . "',
//     Mat_Image='" . $detailsObj->get_MaterialImage() . "',
//     Mat_Grains='" . $detailsObj->get_MaterialGrains() . "',
//     Mat_modifiedBy='" . $detailsObj->get_materialmodifiedby() . "',
//     Mat_createdBy='" . $detailsObj->get_materialcreatedby() . "',
//     MaterialDiscount='" . $detailsObj->get_MaterialDiscount() . "',
//     MaterialPrice='" . $detailsObj->get_MaterialPrice() . "',
//     MaterialTotalValue='" . $detailsObj->get_MaterialTotalValue() . "'
// WHERE Material_Id=" . $detailsObj->get_MaterialId();

  //     error_log($sql);
//     if ($connectionObj->query($sql) === TRUE) {
//     } else {
//       echo "Error: " . $sql . "<br>" . $connectionObj->error;
//     }
//   }

  public static function selectmaterial()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT material_id,material_name from material";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $materialdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_Details();
        $view->set_MaterialId($row['material_id']);
        $view->set_MaterialName($row['material_name']);
        array_push($materialdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($materialdetailslist);
    }
  }

  public static function selectMaterialbasedonBrandCatId($brandId, $catId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT material_id,material_name from material where Brand=$brandId and Category=$catId";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $materialdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_Details();
        $view->set_MaterialId($row['material_id']);
        $view->set_MaterialName($row['material_name']);
        array_push($materialdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($materialdetailslist);
    }
  }

  public static function selectMaterialbasedonBrandCatSubcatId($catId, $subcatId, $brandId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT M.Material_Id  AS MaterialId,
    M.Material_Name AS Material_Name,
    M.Material_Description AS Material_Description,
    M.Category AS CategoryId,
    MC.material_catName AS CategoryName,
    M.SubCategory AS SubCategoryId,
    MSC.material_subcatName AS SubCategoryName,
    M.Brand AS CompanyId,
    B.brand_name AS CompanyName,
    B.brand_id AS BrandId,
    M.Mat_HSNCode AS HSNcode,
    M.Mat_Image AS MaterialImage,
    M.Material_Code AS Material_Code,
    M.Mat_Qty AS Size,
    M.Mat_SPU AS PackingUnit,
    M.Mat_MRP AS MRP,
    M.Mat_PPMRP AS PPMRP,
    M.Mat_GST AS GST,
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    M.Mat_TotalMRP AS totalMRP
    FROM material M
    JOIN material_category MC ON M.Category=MC.material_catId 
    JOIN material_subcategory MSC ON MSC.material_subcatId =M.SubCategory 
    JOIN brands B ON M.Brand=B.brand_id
    JOIN units U ON U.unitId=M.Mat_Unit
    JOIN unitsfactor UF ON UF.unitFactorId=M.Mat_factor
  where Brand=$brandId and Category=$catId and SubCategory=$subcatId";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $materialdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_Details();
        $view->set_MaterialId($row['MaterialId']);
        $view->set_MaterialName($row['Material_Name']);
        $view->set_MaterialPPMRP($row['PPMRP']);
        $view->set_MaterialGST($row['GST']);
        $view->set_MaterialCode($row['Material_Code']);
        $view->set_MaterialImage($row['MaterialImage']);
        $view->set_MaterialUnitFactor($row['unitFactor']);
        array_push($materialdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($materialdetailslist);
    }
  }

  public static function selectMaterialbasedonMatId($catId, $subcatId, $brandId, $matId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT M.Material_Id AS MaterialId,
    M.Material_Name AS Material_Name,
    M.Material_Description AS Material_Description,
    M.Category AS CategoryId,
    MC.material_catName AS CategoryName,
    M.SubCategory AS SubCategoryId,
    MSC.material_subcatName AS SubCategoryName,
    M.Brand AS CompanyId,
    B.brand_name AS CompanyName,
    B.brand_id AS BrandId,
    M.Mat_HSNCode AS HSNcode,
    M.Mat_Image AS MaterialImage,
    M.Material_Code AS Material_Code,
    M.Mat_Qty AS Size,
    M.Mat_SPU AS PackingUnit,
    M.Mat_MRP AS MRP,
    M.Mat_PPMRP AS PPMRP,
    M.Mat_GST AS GST,
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    M.Mat_TotalMRP AS totalMRP,
    PO.POcode AS POcode,
    PO.Modified_date as DateofPurchase,
    S.InvoiceNo AS InvoiceNo,
    S.item_stockid as Stockid,
    S.ReceivedQty as ReceivedQty,
    S.ReceivedQtyAmt as ReceivedQtyAmt,
    S.ReceivedQty * S.ReceivedQtyAmt  as TotalAmount,
    S.Price as ItemPrice,
    S.POID as POID
    FROM material M
    JOIN material_category MC ON M.Category=MC.material_catId 
    JOIN material_subcategory MSC ON MSC.material_subcatId =M.SubCategory 
    JOIN `item_stock` S on S.item_id=M.Material_Id
    JOIN `purchase_order` PO on PO.Id=S.POID
    JOIN brands B ON M.Brand=B.brand_id
    JOIN units U ON U.unitId=M.Mat_Unit
    JOIN unitsfactor UF ON UF.unitFactorId=M.Mat_factor
    where Material_Id =$matId";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $materialdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_Details();
        $view->set_MaterialId($row['MaterialId']);
        $view->set_MaterialName($row['Material_Name']);
        $view->set_MaterialPPMRP($row['PPMRP']);
        $view->set_MaterialGST($row['GST']);
        $view->set_MaterialCode($row['Material_Code']);
        $view->set_MaterialImage($row['MaterialImage']);
        $view->set_MaterialUnitFactor($row['unitFactor']);
        $view->setPOcode($row["POcode"]);
        $view->setInvoiceNo($row["InvoiceNo"]);
        $view->setDateofPurchase($row["DateofPurchase"]);
        $view->setItemPrice($row["ItemPrice"]);
        $view->setReceivedQtyAmt($row["ReceivedQtyAmt"]);
        $view->setReceivedQty($row["ReceivedQty"]);
        $view->setTotalAmount($row["TotalAmount"]);
        array_push($materialdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($materialdetailslist);
    }
  }

  public static function getMaterialWithInwardHistory($matId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "
        SELECT
            M.Material_Id AS MaterialId,
            M.Material_Name AS MaterialName,
            M.Material_Description AS MaterialDescription,

            MC.material_catName AS CategoryName,
            MSC.material_subcatName AS SubCategoryName,
            B.brand_name AS BrandName,

            M.Material_Code AS MaterialCode,
            M.Mat_HSNCode AS HSNCode,
            M.Mat_SPU AS MaterialSPU,
            U.unitName AS Unit,
            UF.unitFactor AS MaterialUnitFactor,
            T.Thickness AS Thickness,
            R.sides AS Grains,
            M.Mat_Qty AS Qty,

            M.Mat_MRP AS MaterialPPMRP,
            M.Mat_GST AS MaterialGST,
            M.MaterialDiscount AS MaterialDiscount,
            M.MaterialPrice AS MaterialCompanyPrice,
            M.MaterialTotalValue AS MaterialTotalValue,

            M.Mat_Image AS MaterialImage,

            PO.POcode,
            PO.PurchasedDate AS DateofPurchase,

            IC.item_compName AS SupplierName,   -- ✅ SUPPLIER FIX

            S.InvoiceNo,
            COALESCE(S.Price, M.MaterialPrice) AS ItemPrice,
            S.ReceivedQty,
            S.ReceivedQtyAmt                    -- ✅ DIVIDED VALUE (NO TOTAL)
        FROM material M
        LEFT JOIN material_category MC ON MC.material_catId = M.Category
        LEFT JOIN material_subcategory MSC ON MSC.material_subcatId = M.SubCategory
        LEFT JOIN brands B ON B.brand_id = M.Brand
        LEFT JOIN units U ON U.unitId = M.Mat_Unit
        LEFT JOIN unitsfactor UF ON UF.unitFactorId = M.Mat_factor
        LEFT JOIN thickness T ON T.Thickness_Id = M.Mat_Thickness
        LEFT JOIN rotation R ON R.rotationId = M.Mat_Grains

        LEFT JOIN item_stock S ON S.item_id = M.Material_Id
        LEFT JOIN purchase_order PO ON PO.Id = S.POID
        LEFT JOIN item_companydetails IC ON IC.item_compid = PO.SupplierId

        WHERE M.Material_Id = ?
        ORDER BY PO.PurchasedDate ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $matId);
    $stmt->execute();

    $res = $stmt->get_result();
    $data = [];

    while ($row = $res->fetch_assoc()) {
      $data[] = $row;
    }

    header("Content-Type: application/json");
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    exit;
  }


  public static function selectMaterialbasedonThicknessId($thicknessId, $catId, $subcatId, $brandId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT M.Material_Id  AS MaterialId,
    M.Material_Name AS Material_Name,
    M.Material_Description AS Material_Description,
    M.Category AS CategoryId,
    MC.material_catName AS CategoryName,
    M.SubCategory AS SubCategoryId,
    MSC.material_subcatName AS SubCategoryName,
    M.Brand AS CompanyId,
    B.brand_name AS CompanyName,
    B.brand_id AS BrandId,
    T.Thickness as Thickness,
    M.Mat_Thickness as ThicknessId,
    M.Mat_HSNCode AS HSNcode,
    M.Mat_Image AS MaterialImage,
    M.Material_Code AS Material_Code,
    M.Mat_Qty AS Size,
    M.Mat_SPU AS PackingUnit,
    M.Mat_MRP AS MRP,
    M.Mat_PPMRP AS PPMRP,
    M.Mat_GST AS GST,
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    M.Mat_TotalMRP AS totalMRP
    FROM material M
    JOIN material_category MC ON M.Category=MC.material_catId 
    JOIN material_subcategory MSC ON MSC.material_subcatId =M.SubCategory 
    JOIN brands B ON M.Brand=B.brand_id
    JOIN units U ON U.unitId=M.Mat_Unit
    JOIN unitsfactor UF ON UF.unitFactorId=M.Mat_factor
    JOIN thickness T on M.Mat_Thickness=T.Thickness_Id
  where M.Category =$catId and M.SubCategory=$subcatId and M.Brand=$brandId and M.Mat_Thickness= $thicknessId";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $materialdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_Details();
        $view->set_MaterialId($row['MaterialId']);
        $view->set_MaterialName($row['Material_Name']);
        $view->set_MaterialPPMRP($row['PPMRP']);
        $view->set_MaterialGST($row['GST']);
        $view->set_MaterialCode($row['Material_Code']);
        $view->set_MaterialImage($row['MaterialImage']);
        $view->set_MaterialUnitFactor($row['unitFactor']);
        array_push($materialdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($materialdetailslist);
    }
  }



  // public static function delete($itemObj)
  // {
  //   $db = ConnectDb::getInstance();
  //   $connectionObj = $db->getConnection();
  //   $sql = "DELETE from material where material_id='" . $itemObj . "'";
  //   error_log($sql);
  //   if ($connectionObj->query($sql) === TRUE) {
  //   } else {
  //     echo "Error: " . $sql . "<br>" . $connectionObj->error;
  //   }

  public static function getMaterialFullDetailsById($matId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "SELECT 
            M.Material_Id AS MaterialId,
            M.Material_Name AS MaterialName,
            M.Material_Description AS MaterialDescription,

            MC.material_catName AS CategoryName,
            MSC.material_subcatName AS SubCategoryName,
            B.brand_name AS BrandName,

            M.Material_Code AS MaterialCode,
            M.Mat_HSNCode AS HSNCode,

            -- SPU
            M.Mat_SPU AS MaterialSPU,

            -- Unit & Factor
            M.Mat_Unit AS UnitId,
            U.unitName AS Unit,
            M.Mat_factor AS UnitFactorId,
            UF.unitFactor AS MaterialUnitFactor,

            -- Grains
            M.Mat_Grains AS GrainsId,
            R.sides AS Grains,

            -- Thickness
            M.Mat_Thickness AS ThicknessId,
            T.Thickness AS Thickness,

            -- Quantity
            M.Mat_Qty AS Qty,

            -- Prices
            M.Mat_MRP AS MaterialPPMRP,
            M.Mat_PPMRP AS PPMRP,
            M.Mat_GST AS MaterialGST,

            M.MaterialDiscount AS MaterialCompanyDiscount,
            M.MaterialPrice AS MaterialCompanyPrice,
            M.MaterialTotalValue AS MaterialTotalValue,

            -- Image
            M.Mat_Image AS MaterialImage

        FROM material M
        LEFT JOIN material_category MC ON MC.material_catId = M.Category
        LEFT JOIN material_subcategory MSC ON MSC.material_subcatId = M.SubCategory
        LEFT JOIN brands B ON B.brand_id = M.Brand
        LEFT JOIN thickness T ON T.Thickness_Id = M.Mat_Thickness
        LEFT JOIN rotation R ON R.rotationId = M.Mat_Grains
        LEFT JOIN units U ON U.unitId = M.Mat_Unit
        LEFT JOIN unitsfactor UF ON UF.unitFactorId = M.Mat_factor
        WHERE M.Material_Id = ?";

    error_log($sql);
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $matId);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    header("Content-Type: application/json");
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    exit;
  }



}
