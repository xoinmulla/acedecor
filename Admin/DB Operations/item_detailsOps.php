<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/item_detailsmodel.php";
class DBitemdetails
{
  /*
  function accepts the input item object and inserts the record in 
  item details table.
  */
  public static function insert($itemdetailsObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // -------------------------------
    // 1️⃣ CHECK DUPLICATE ITEM
    // -------------------------------
    $itemName = $itemdetailsObj->get_itemname();
    $brandId = $itemdetailsObj->get_itemcompid();

    $checkSql = "SELECT COUNT(*) AS total 
                 FROM item_details 
                 WHERE item_name = ? AND item_compid = ?";

    $stmt = $connectionObj->prepare($checkSql);
    $stmt->bind_param("si", $itemName, $brandId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['total'] > 0) {
      return [
        "status" => "error",
        "message" => "❌ Item with same name and brand already exists!"
      ];
    }

    // -------------------------------
    // 2️⃣ INSERT NEW ITEM
    // -------------------------------
    $sql = "INSERT INTO item_details (
    item_name, item_description, item_createdby, item_modifiedby,
    item_subcatid, item_catid, item_compid, item_image,
    item_HSNcode, item_ArticleNo, item_Size, item_PackingUnit,
    item_MRP, item_Amount, item_pp_MRP, item_GST, item_Discount,
    item_Price, item_TotalValue, item_unit, item_unitFactor, item_totalMRP
) VALUES (
    '" . $itemdetailsObj->get_itemname() . "',
    '" . $itemdetailsObj->get_itemdescription() . "',
    '" . $itemdetailsObj->get_itemcreatedby() . "',
    '" . $itemdetailsObj->get_itemmodifiedby() . "',
    '" . $itemdetailsObj->get_itemsubcatid() . "',
    '" . $itemdetailsObj->get_itemcatid() . "',
    '" . $itemdetailsObj->get_itemcompid() . "',
    '" . $itemdetailsObj->get_itemimage() . "',
    '" . $itemdetailsObj->get_itemhsncode() . "',
    '" . $itemdetailsObj->get_itemarticleno() . "',
    '" . $itemdetailsObj->get_size() . "',
    '" . $itemdetailsObj->get_packingunit() . "',
    '" . $itemdetailsObj->get_MRP() . "',
    '" . $itemdetailsObj->get_itemAmount() . "',
    '" . $itemdetailsObj->get_ppMRP() . "',
    '" . $itemdetailsObj->get_itemGST() . "',
    '" . $itemdetailsObj->get_itemDiscount() . "',
    '" . $itemdetailsObj->get_itemPrice() . "',
    '" . $itemdetailsObj->get_itemTotalValue() . "',
    '" . $itemdetailsObj->get_itemunitId() . "',
    '" . $itemdetailsObj->get_itemunitFactorId() . "',
    '" . $itemdetailsObj->get_itemtotalMRP() . "'
)";


    if ($connectionObj->query($sql)) {
      return [
        "status" => "success",
        "message" => "Item added successfully!"
      ];
    } else {
      return [
        "status" => "error",
        "message" => "Database Error: " . $connectionObj->error
      ];
    }
  }

  public static function getallItemdetails()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    I.item_id AS ItemId,
    I.item_name AS ItemName,
    I.item_description AS ItemDescription,
    I.item_catid AS CategoryId,
    C.item_catName AS CategoryName,
    I.item_subcatid AS SubCategoryId,
    SC.item_subcatName AS SubCategoryName,
    I.item_compid AS CompanyId,
    B.brand_name AS CompanyName,
    I.item_HSNcode AS HSNcode,
    I.item_ArticleNo AS ArticleNo,
    I.item_Size AS Size,
    I.item_PackingUnit AS PackingUnit,
    I.item_MRP AS MRP,
    I.item_pp_MRP AS PPMRP,
    I.item_GST AS GST,
    I.item_Discount AS Discount,        
    I.item_Price AS Price,              
    I.item_TotalValue AS TotalValue,    
    I.item_image AS ItemImage,          
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    SUM(A.AllocatedQty) AS AllocatedQty,
    TEMP.ReceivedQty AS InwardedQty,
    CASE 
        WHEN SUM(A.AllocatedQty) IS NULL THEN TEMP.ReceivedQty
        ELSE TEMP.ReceivedQty - SUM(A.AllocatedQty)
    END AS AvailableQty,
    I.item_totalMRP AS totalMRP,

    -- 🔒 DELETE-PROTECTION FLAG
    -- 🔒 USED IN ANY QUOTATION (ANY STATUS)
CASE 
    WHEN EXISTS (
        SELECT 1
        FROM quotelineitem qli
        WHERE qli.itemId = I.item_id
    )
    THEN 1 ELSE 0
END AS IsUsedInQuotation,
-- 🔒 USED IN ANY PURCHASE ORDER
CASE 
    WHEN EXISTS (
        SELECT 1
        FROM purchaseorder_lineitem pli
        WHERE pli.Item_id = I.item_id
    )
    THEN 1 ELSE 0
END AS IsUsedInPO


FROM item_details I
JOIN item_category C ON I.item_catid = C.item_catid 
JOIN item_subcategory SC ON I.item_subcatid = SC.item_subcatid 
JOIN brands B ON I.item_compid = B.brand_id
JOIN units U ON U.unitId = I.item_unit
LEFT JOIN (
    SELECT item_id, SUM(ReceivedQty) AS ReceivedQty
    FROM item_stock
    GROUP BY item_id
) TEMP ON TEMP.item_id = I.item_id
LEFT JOIN itemallocation A ON A.ItemId = I.item_id
JOIN unitsfactor UF ON UF.unitFactorId = I.item_unitFactor
GROUP BY I.item_id";

    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Details();
        $view->set_itemid($row['ItemId']);
        $view->set_itemname($row['ItemName']);
        $view->set_itemdescription($row["ItemDescription"]);
        $view->set_itemCompanyname($row['CompanyName']);
        $view->set_itemcompid($row["CompanyId"]);
        $view->set_itemsubcatid($row["SubCategoryId"]);
        $view->set_itemcatid($row["CategoryId"]);
        $view->set_itemhsncode($row["HSNcode"]);
        $view->set_itemimage($row["ItemImage"]);
        $view->set_itemcategoryname($row["CategoryName"]);
        $view->set_itemsubcategoryname($row["SubCategoryName"]);
        $view->set_ReceivedQty($row["InwardedQty"]);
        $view->set_packingunit($row["PackingUnit"]);
        $view->set_ppMRP($row["PPMRP"]);
        $view->set_MRP($row["MRP"]);
        $view->set_size($row["Size"]);
        $view->set_itemarticleno($row["ArticleNo"]);
        $view->set_itemGST($row["GST"]);
        $view->set_AllocatedQty($row["AllocatedQty"]);
        $view->set_itemunitId($row["unitId"]);
        $view->set_itemunitFactorId($row["unitFactorId"]);
        $view->set_itemunit($row["unitName"]);
        $view->set_itemunitFactor($row["unitFactor"]);
        $view->set_itemtotalMRP($row["totalMRP"]);
        $view->set_AvailableQty($row["AvailableQty"]);
        $view->set_itemDiscount($row["Discount"]);
        $view->set_itemPrice($row["Price"]);
        $view->set_itemTotalValue($row["TotalValue"]);
        $view->set_isUsedInQuotation($row['IsUsedInQuotation']);
        $view->set_isUsedInPO($row['IsUsedInPO']);

        array_push($itemdetailslist, $view);
      }
    } else {
      // echo "0 results";
    }

    return $itemdetailslist;
  }
  public static function isItemUsedInQuotation($itemId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "SELECT COUNT(*) AS total FROM quotelineitem WHERE itemId = ?"
    );
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['total'] > 0;
  }

  public static function isItemUsedInPO($itemId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "SELECT COUNT(*) AS total FROM purchaseorder_lineitem WHERE Item_id = ?"
    );
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['total'] > 0;
  }

  public static function getallItemdetailsbasedonID($Itemid)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "
SELECT
    I.item_id AS itemid,
    I.item_name AS itemname,
    I.item_description AS itemdescription,
    C.item_catName AS categoryname,
    SC.item_subcatName AS subcategoryname,
    B.brand_name AS brandname,
    I.item_ArticleNo AS itemcode,
    I.item_HSNcode AS hsncode,
    I.item_PackingUnit AS spu,
    I.item_Size AS qty,
    U.unitName AS unitname,
    UF.unitFactor AS unitfactor,
    I.item_MRP AS itemMRP,
    I.item_Amount AS itemAmount,
    I.item_GST AS itemGST,
    I.item_Discount AS itemDiscount,
    I.item_Price AS itemPrice,
    I.item_TotalValue AS itemTotalValue,
    I.item_pp_MRP AS itemppMRP,
    I.item_image AS itemimage,

    -- SUPPLIER
    SUP.item_compName AS SupplierName,

    -- PO / INWARD
    PO.POcode AS POcode,
    PO.PurchasedDate AS DateofPurchase,
    S.InvoiceNo AS InvoiceNo,

    -- PRICE (same logic as itemstocks.php)
    COALESCE(S.Price, I.item_Price) AS ItemPrice,

    -- ✅ AGGREGATED VALUES (THIS FIXES THE MISMATCH)
    SUM(S.ReceivedQty) AS ReceivedQty,
    SUM(S.ReceivedQtyAmt) AS ReceivedQtyAmt

FROM item_details I

LEFT JOIN item_category C ON C.item_catid = I.item_catid
LEFT JOIN item_subcategory SC ON SC.item_subcatid = I.item_subcatid
LEFT JOIN brands B ON B.brand_id = I.item_compid
LEFT JOIN units U ON U.unitId = I.item_unit
LEFT JOIN unitsfactor UF ON UF.unitFactorId = I.item_unitFactor

LEFT JOIN item_stock S 
    ON S.item_id = I.item_id

LEFT JOIN purchase_order PO 
    ON PO.Id = S.POID

LEFT JOIN item_companydetails SUP 
    ON SUP.item_compid = PO.SupplierId

WHERE I.item_id = ?

GROUP BY 
    S.InvoiceNo,
    PO.POcode,
    PO.PurchasedDate,
    SUP.item_compName,
    ItemPrice

ORDER BY PO.PurchasedDate DESC
";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Itemid);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    while ($row = $res->fetch_assoc()) {
      $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK);
    exit;
  }

  public static function isItemUsedInApprovedQuotation($itemId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "
        SELECT COUNT(*) AS total
        FROM quotelineitem qli
        JOIN quotation_details qd ON qd.quoteid = qli.quoteId
        WHERE qli.itemId = ?
          AND qd.quo_status = 'Approved'
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    return ($res['total'] > 0);
  }

  public static function getallItemdetailsbasedonIDforstocks($Itemid)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT I.item_id AS ItemId,
      I.item_name AS ItemName,
      I.item_description AS ItemDescription,
      I.item_MRP AS MRP,
      I.item_pp_MRP AS PPMRP,
      I.item_GST AS GST
      FROM item_details I 
      where I.item_id='" . $Itemid . "'";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $view = new Item_Details();
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $view->set_itemid($row['ItemId']);
        $view->set_itemname($row['ItemName']);
        $view->set_itemdescription($row["ItemDescription"]);
      }
    } else {
      // echo "0 results";
    }

    return $view;
  }

  public static function selectallitems()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT item_id,item_name FROM item_details";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Details();
        $view->set_itemid($row['item_id']);
        $view->set_itemname($row['item_name']);
        array_push($itemdetailslist, $view);
      }
    } else {
      // echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($itemdetailslist);
  }

  public static function update($detailsObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "UPDATE item_details SET 
        item_name='" . $detailsObj->get_itemname() . "',
        item_description='" . $detailsObj->get_itemdescription() . "',
        item_compid='" . $detailsObj->get_itemcompid() . "',
        item_catid='" . $detailsObj->get_itemcatid() . "',
        item_subcatid='" . $detailsObj->get_itemsubcatid() . "',
        item_HSNcode='" . $detailsObj->get_itemhsncode() . "',
        item_createdby='" . $detailsObj->get_itemcreatedby() . "',
        item_modifiedby='" . $detailsObj->get_itemmodifiedby() . "',
        item_ArticleNo='" . $detailsObj->get_itemarticleno() . "',
        item_Size='" . $detailsObj->get_size() . "',
        item_PackingUnit='" . $detailsObj->get_packingunit() . "',
        item_MRP='" . $detailsObj->get_MRP() . "',
        item_pp_MRP='" . $detailsObj->get_ppMRP() . "',
        item_Amount='" . $detailsObj->get_itemAmount() . "',
        item_GST='" . $detailsObj->get_itemGST() . "',
        item_Discount='" . $detailsObj->get_itemDiscount() . "',
        item_Price='" . $detailsObj->get_itemPrice() . "',
        item_TotalValue='" . $detailsObj->get_itemTotalValue() . "',
        item_unit='" . $detailsObj->get_itemunitId() . "',
        item_unitFactor='" . $detailsObj->get_itemunitFactorId() . "',
        item_totalMRP='" . $detailsObj->get_itemtotalMRP() . "'";

    if ($detailsObj->get_itemimage() != "") {
      $sql .= ", item_image='" . $detailsObj->get_itemimage() . "'";
    }

    $sql .= " WHERE item_id=" . $detailsObj->get_itemid();

    error_log("FINAL SQL UPDATE: " . $sql);

    if (!$connectionObj->query($sql)) {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function selectitem($catId, $subcatId, $brandId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT I.item_id AS ItemId,
    I.item_name AS ItemName,
    I.item_description AS ItemDescription,
    I.item_catid AS CategoryId,
    C.item_catName AS CategoryName,
    I.item_subcatid AS SubCategoryId,
    SC.item_subcatName AS SubCategoryName,
    I.item_compid AS CompanyId,
    B.brand_name AS CompanyName,
    B.brand_id AS BrandId,
    I.item_HSNcode AS HSNcode,
    I.item_OrderNumber AS OrderNo,
    I.item_image AS ItemImage,
    I.item_ArticleNo AS ArticleNo,
    I.item_Size AS Size,
    I.item_PackingUnit AS PackingUnit,
    I.item_MRP AS MRP,
    I.item_pp_MRP AS PPMRP,
    I.item_GST AS GST,
    I.item_Discount AS itemDiscount,   -- ⭐ ADD THIS
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    I.item_totalMRP AS totalMRP
    FROM item_details I 
    JOIN item_category C ON I.item_catid=C.item_catid 
    JOIN item_subcategory SC ON I.item_subcatid=SC.item_subcatid 
    JOIN brands B ON I.item_compid=B.brand_id
    JOIN units U ON U.unitId=I.item_unit
    JOIN unitsfactor UF ON UF.unitFactorId=I.item_unitFactor
    WHERE I.item_catid=$catId and I.item_subcatid=$subcatId and I.item_compid=$brandId";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Details();
        $view->set_itemid($row['ItemId']);
        $view->set_itemname($row['ItemName']);
        $view->set_itemdescription($row["ItemDescription"]);
        $view->set_itemCompanyname($row['CompanyName']);
        $view->set_itemcompid($row["CompanyId"]);
        $view->set_brandId($row["BrandId"]);
        $view->set_itemsubcatid($row["SubCategoryId"]);
        $view->set_itemcatid($row["CategoryId"]);
        $view->set_itemhsncode($row["HSNcode"]);
        $view->set_OrderNo($row["OrderNo"]);
        $view->set_itemimage($row["ItemImage"]);
        $view->set_itemcategoryname($row["CategoryName"]);
        $view->set_itemsubcategoryname($row["SubCategoryName"]);

        $view->set_packingunit($row["PackingUnit"]);
        $view->set_ppMRP($row["PPMRP"]);
        $view->set_MRP($row["MRP"]);
        $view->set_size($row["Size"]);
        $view->set_itemarticleno($row["ArticleNo"]);
        $view->set_itemGST($row["GST"]);
        $view->set_itemDiscount($row["itemDiscount"]);
        $view->set_itemunitId($row["unitId"]);
        $view->set_itemunitFactorId($row["unitFactorId"]);
        $view->set_itemunit($row["unitName"]);
        $view->set_itemunitFactor($row["unitFactor"]);
        $view->set_itemtotalMRP($row["totalMRP"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  public static function selectitembasedonCatId($catId, $subcatId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT I.item_id AS ItemId,
    I.item_name AS ItemName,
    I.item_description AS ItemDescription,
    I.item_catid AS CategoryId,
    C.item_catName AS CategoryName,
    I.item_subcatid AS SubCategoryId,
    SC.item_subcatName AS SubCategoryName,
    I.item_compid AS CompanyId,
    B.brand_name AS CompanyName,
    B.brand_id AS BrandId,
    I.item_HSNcode AS HSNcode,
    I.item_OrderNumber AS OrderNo,
    I.item_image AS ItemImage,
    I.item_HSNcode AS HSNCode,
    I.item_ArticleNo AS ArticleNo,
    I.item_Size AS Size,
    I.item_PackingUnit AS PackingUnit,
    I.item_MRP AS MRP,
    I.item_pp_MRP AS PPMRP,
    I.item_GST AS GST,
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    I.item_totalMRP AS totalMRP
    FROM item_details I 
    JOIN item_category C ON I.item_catid=C.item_catid 
    JOIN item_subcategory SC ON I.item_subcatid=SC.item_subcatid 
    JOIN brands B ON I.item_compid=B.brand_id
    JOIN units U ON U.unitId=I.item_unit
    JOIN unitsfactor UF ON UF.unitFactorId=I.item_unitFactor
    WHERE I.item_catid=$catId and I.item_subcatid=$subcatId ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Details();
        $view->set_itemid($row['ItemId']);
        $view->set_itemname($row['ItemName']);
        $view->set_itemdescription($row["ItemDescription"]);
        $view->set_itemCompanyname($row['CompanyName']);
        $view->set_itemcompid($row["CompanyId"]);
        $view->set_brandId($row["BrandId"]);
        $view->set_itemsubcatid($row["SubCategoryId"]);
        $view->set_itemcatid($row["CategoryId"]);
        $view->set_itemhsncode($row["HSNcode"]);
        $view->set_OrderNo($row["OrderNo"]);
        $view->set_itemimage($row["ItemImage"]);
        $view->set_itemcategoryname($row["CategoryName"]);
        $view->set_itemsubcategoryname($row["SubCategoryName"]);

        $view->set_packingunit($row["PackingUnit"]);
        $view->set_ppMRP($row["PPMRP"]);
        $view->set_MRP($row["MRP"]);
        $view->set_size($row["Size"]);
        $view->set_itemarticleno($row["ArticleNo"]);
        $view->set_itemGST($row["GST"]);

        $view->set_itemunitId($row["unitId"]);
        $view->set_itemunitFactorId($row["unitFactorId"]);
        $view->set_itemunit($row["unitName"]);
        $view->set_itemunitFactor($row["unitFactor"]);
        $view->set_itemtotalMRP($row["totalMRP"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  public static function selectitembasedonProj($projId, $brandId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT I.item_id AS ItemId,
    I.item_name AS ItemName,
    I.item_catid AS CategoryId,
    C.item_catName AS CategoryName,
    I.item_subcatid AS SubCategoryId,
    SC.item_subcatName AS SubCategoryName,
    I.item_compid AS CompanyId,
    B.brand_name AS CompanyName,
    B.brand_id AS BrandId,
    I.item_HSNcode AS HSNCode,
    I.item_ArticleNo AS ArticleNo,
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    QLI.itemId as QuoteItemId,
    QLI.quantity as ReqItemQuantity,
    Q.quoId as QuoteId,
    Q.quoteCode As quoteCode,
    COALESCE(ST.Price, 0)as Price,
    COALESCE(ST.TotalAmount,0) as totalamt,
    COALESCE(ST.Quantity ,0) as Quantity,
    PR.quoteId as ProjectQuoteId
    FROM item_details I 
    JOIN item_category C ON I.item_catid=C.item_catid 
    JOIN item_subcategory SC ON I.item_subcatid=SC.item_subcatid 
    JOIN brands B ON I.item_compid=B.brand_id
    JOIN quotelineitem QLI ON I.item_id=QLI.itemId
    JOIN quotation_details Q ON Q.quoid=QLI.quoteId
    Left JOIN item_stock ST ON ST.item_id=I.item_id
    JOIN projects PR ON PR.quoteId=Q.quoteCode
    JOIN units U ON U.unitId=I.item_unit
    JOIN unitsfactor UF ON UF.unitFactorId=I.item_unitFactor
    WHERE PR.projectId=$projId and B.brand_id=$brandId
    group by ItemName
    UNION
    SELECT M.Material_Id  AS ItemId,
    M.Material_Name AS Name,
    M.Category As Matcatid,
    C.material_catName AS CategoryName,
    M.SubCategory As Matsubcatid,
    SC.material_subcatName AS SubCategoryName,
    M.Brand AS CompanyId,
    B.brand_name AS CompanyName,
    B.brand_id AS BrandId,
    M.Mat_HSNCode AS HSNCode,
    M.Material_Code AS ArticleNo,
    U.unitId AS unitId,
    U.unitName AS unitName,
    UF.unitFactorId AS unitFactorId,
    UF.unitFactor AS unitFactor,
    QLI.itemId as QuoteItemId,
    QLI.quantity as ReqItemQuantity,
    Q.quoId as QuoteId,
    Q.quoteCode As quoteCode,
    COALESCE(ST.Price, 0)as Price,
    COALESCE(ST.TotalAmount,0) as totalamt,
    COALESCE(ST.Quantity ,0) as Quantity,
    PR.quoteId as ProjectQuoteId
    FROM material M
    JOIN material_category C ON M.Category=C.material_catId 
      JOIN material_subcategory SC ON M.SubCategory=SC.material_subcatId 
        JOIN `brands` AS B ON M.Brand=B.brand_id 
    JOIN quotelineitem QLI ON M.Material_Id=QLI.itemId
    JOIN quotation_details Q ON Q.quoid=QLI.quoteId
    Left JOIN item_stock ST ON ST.item_id=M.Material_Id
    JOIN projects PR ON PR.quoteId=Q.quoteCode
    JOIN units AS U ON U.unitId=M.Mat_Unit
    JOIN unitsfactor UF ON UF.unitFactorId=M.Mat_factor
    WHERE PR.projectId=$projId and B.brand_id=$brandId
    group by Name";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Details();
        $view->set_itemid($row['ItemId']);
        $view->set_itemname($row['ItemName']);
        $view->setprice($row['Price']);
        $view->settotalamt($row['totalamt']);
        $view->setquantity($row['Quantity']);
        $view->setitemquantity($row['ReqItemQuantity']);
        $view->set_itemCompanyname($row['CompanyName']);
        $view->set_itemcompid($row["CompanyId"]);
        $view->set_itemsubcatid($row["SubCategoryId"]);
        $view->set_itemcatid($row["CategoryId"]);
        $view->set_itemhsncode($row["HSNCode"]);
        $view->set_itemcategoryname($row["CategoryName"]);
        $view->set_itemsubcategoryname($row["SubCategoryName"]);
        $view->set_itemarticleno($row["ArticleNo"]);
        $view->set_itemunitId($row["unitId"]);
        $view->set_itemunitFactorId($row["unitFactorId"]);
        $view->set_itemunit($row["unitName"]);
        $view->set_itemunitFactor($row["unitFactor"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  public static function delete($itemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE from item_details where item_id='" . $itemObj . "'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function recalculateItemsByUnitFactor($unitFactorId, $newFactor)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "
        UPDATE item_details
        SET
            item_Amount = item_MRP * ? * item_PackingUnit,

            item_Price = (
                (item_MRP * ? * item_PackingUnit)
                - ((item_MRP * ? * item_PackingUnit) * (item_Discount / 100))
            ) * (1 + (item_GST / 100)),

            item_TotalValue = (
                (
                    (item_MRP * ? * item_PackingUnit)
                    - ((item_MRP * ? * item_PackingUnit) * (item_Discount / 100))
                ) * (1 + (item_GST / 100))
            ),

            item_totalMRP = item_MRP * item_PackingUnit
        WHERE item_unitFactor = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      "dddddi",
      $newFactor,
      $newFactor,
      $newFactor,
      $newFactor,
      $newFactor,
      $unitFactorId
    );

    $stmt->execute();
    $stmt->close();
  }


}