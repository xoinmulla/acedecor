<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/quotationModel.php";
require_once "../Model/quoteLineItemModel.php";
require_once "../Model/orderListModel.php";

class DBLineItem
{
  private static function safe_escape($conn, $value)
  {
    return $conn->real_escape_string($value ?? '');
  }

  public static function insert($lineItemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // Helper alias
    $esc = function ($v) use ($connectionObj) {
      return $connectionObj->real_escape_string($v ?? '');
    };

    $sql = "INSERT INTO `quotelineitem`(
      `quoteId`, 
      `itemId`, 
      `InputName`,
      `item_catid`,
      `item_subcatid`,
      `quantity`, 
      `amount`, 
      `totalAmount`, 
      `discount1`, 
      `discount1Amt`, 
      `GSTAmount`, 
      `GST`, 
      `totalPrice`,  
      `InputType`,
      `value`,
      `totalValue`,
      `createdby`,  
      `modifiedby`
    ) VALUES (
  '{$esc($lineItemObj->get_quoteId())}',
  '{$esc($lineItemObj->get_itemid())}',
  '{$esc($lineItemObj->get_InputName())}',
  '{$esc($lineItemObj->get_itemcatid())}',
  '{$esc($lineItemObj->get_itemsubcatid())}',
  '{$esc($lineItemObj->get_itemquantity())}',
  '{$esc($lineItemObj->get_companyPrice())}',   -- Company Price (amount)
  '{$esc($lineItemObj->get_totalAmount())}',    -- Total Amount
  '{$esc($lineItemObj->get_discount1())}',
  '{$esc($lineItemObj->get_discount1Amt())}',
  '{$esc($lineItemObj->get_GSTAmt())}',
  '{$esc($lineItemObj->get_GST())}',
  '{$esc($lineItemObj->get_totalPrice())}',     -- Trade Price
  '{$esc($lineItemObj->get_inputType())}',
  '{$esc($lineItemObj->get_value())}',
  '{$esc($lineItemObj->get_totalValue())}',     -- Total Value
  '{$esc($lineItemObj->get_createdby())}',
  '{$esc($lineItemObj->get_modifiedby())}'
)";


    error_log($sql);

    if ($connectionObj->query($sql) !== TRUE) {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    } else {
      error_log("Line item inserted successfully for quoteId = " . $lineItemObj->get_quoteId());
    }
  }


  public static function getLineItemByQuoteId($quoteId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "

-- 🔹 ITEMS
SELECT 
    QLI.lineItemId,
    QLI.InputType AS Type,
    I.item_image AS Image,
    I.item_name AS Name,
    B.brand_name AS Brand,
    I.item_description AS Description,
    QLI.quantity AS Quantity,
    U.unitName AS Units
FROM quotelineitem QLI
JOIN item_details I 
    ON QLI.itemId = I.item_id AND QLI.InputType = 1
JOIN brands B ON I.item_compid = B.brand_id
JOIN units U ON I.item_unit = U.unitId
WHERE QLI.quoteId = $quoteId

UNION ALL

-- 🔹 MATERIALS
SELECT 
    QLI.lineItemId,
    QLI.InputType AS Type,
    M.Mat_Image AS Image,
    M.Material_Name AS Name,
    B.brand_name AS Brand,
    M.Material_Description AS Description,
    QLI.quantity AS Quantity,
    U.unitName AS Units
FROM quotelineitem QLI
JOIN material M 
    ON QLI.itemId = M.Material_Id AND QLI.InputType = 2
JOIN brands B ON M.Brand = B.brand_id
JOIN units U ON M.Mat_Unit = U.unitId
WHERE QLI.quoteId = $quoteId

ORDER BY lineItemId ASC
";

    error_log($sql);
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK);
  }


  public static function getMaterialLineItemByQuoteId($quoteId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "SELECT 
        QLI.lineItemId AS lineItemId,
        QLI.itemId AS itemId,
        M.Mat_Image AS image,
        M.Material_Name AS Name,
        B.brand_name AS brand,
        M.Material_Description AS Description,
        QLI.quantity AS itemquantity,
        U.unitName AS Units,
        QLI.discount1 AS discount1,
        QLI.totalAmount AS totalAmount,
        QLI.totalPrice AS totalPrice,
        QLI.amount AS companyPrice,
        QLI.totalValue AS totalValue,
        QLI.GST AS GST
    FROM `quotelineitem` AS QLI 
    JOIN `material` AS M ON QLI.InputName = M.Material_Name
    JOIN `brands` AS B ON M.Brand = B.brand_id
    JOIN `units` AS U ON U.unitId = M.Mat_Unit
    WHERE QLI.quoteId = $quoteId
    ORDER BY lineItemId ASC";

    error_log($sql);
    $result = $conn->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {
      $data[] = [
        "lineItemId" => $row["lineItemId"],
        "itemId" => $row["itemId"],
        "Name" => $row["Name"],
        "image" => $row["image"],
        "Brand" => $row["brand"],
        "itemquantity" => floatval($row["itemquantity"]),
        "discount1" => floatval($row["discount1"]),
        "GST" => floatval($row["GST"]),
        "totalAmount" => floatval($row["totalAmount"]),
        "companyPrice" => floatval($row["companyPrice"]),
        "totalValue" => floatval($row["totalValue"]), // ✅ correct value
        "totalPrice" => floatval($row["totalPrice"])
      ];
    }

    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK);
  }


  public static function getLineItemByProjectId($projectId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
        QLI.lineItemId AS lineItemId,
        QLI.itemId AS Id,
        case When TEMP1.ItemId=TEMP.ItemId Then 
        case when PO.ProjectId=PR.ProjectId  Then 'Received'
              else 'Not Received'end 
            else 'Not Received' end as InwardStatus,
        case When QLI.itemid=TEMP1.ItemId then
      	      case when PO.Id=TEMP1.POID  Then 
               case when PO.ProjectId=PR.ProjectId then 'Raised'
                   else 'Not Raised' end 
                    else 'Not Raised' end 
        else 'Not Raised' end as POStatus,
        I.item_image AS Image,
        I.item_name AS Name,
        I.item_ArticleNo as ItemCode,
        B.brand_name AS Brand, 
        I.item_description AS Description,
        QLI.quantity AS Quantity,
        U.unitName AS Units,
        Q.quotecode as Quotecode,
        Q.inputType as InputType,
        I.item_id as ItemId,
        TEMP.StockId as StockId,
        COALESCE(TEMP.ReceivedQty,0) as AvailableQty,
        COALESCE(AI.AllocatedQty,0) as AllocatedQty,
        PO.Id as POID,
        case When TEMP.StockId=AI.item_stockId then '1'
        else '0' end as AllocatedStatus,
         PR.projectId as ProjectId
        FROM `quotelineitem` AS QLI 
        JOIN `item_details` AS I ON QLI.InputName=I.item_name
        JOIN `quotation_details` AS Q ON QLI.quoteId=Q.quoteId 
        JOIN `brands` AS B ON I.item_compid=B.brand_id 
        JOIN units AS U ON U.unitId=I.item_unit
        JOIN `projects` AS PR ON PR.quoteId=Q.quoteCode 
        LEFT JOIN `itemallocation` AS AI on AI.ProjectId=PR.projectId and AI.ItemId=QLI.itemid
        LEFT JOIN (SELECT 
        item_id as ItemId,
        Quantity as Quantity,
        SupplierId as SupplierId,
        POID as POID
        from purchaseorder_lineitem) AS TEMP1 on QLI.itemId=TEMP1.ItemId and QLI.quantity=TEMP1.Quantity
        LEFT JOIN `purchase_order` AS PO ON  PO.Id=TEMP1.POID and PO.SupplierId=TEMP1.SupplierId
        LEFT JOIN (SELECT 
   	    SUM(ReceivedQty)As ReceivedQty,
        item_stockid  as StockId,
        item_id as ItemId,
        ItemName as ItemName,
        POID as POID
        from item_stock) AS TEMP on QLI.InputName=TEMP.ItemName
         where PR.projectId=$projectId
        group by Name,ItemId
        -- UNION
        -- SELECT 
        -- QLI.lineItemId AS lineItemId,
        -- QLI.itemId AS Id,
        -- case When TEMP1.ItemId=TEMP.ItemId Then 
        -- case when PO.ProjectId=PR.ProjectId  Then 'Received'
        --       else 'Not Received'end 
        --     else 'Not Received' end as InwardStatus,
        -- case When QLI.itemid=TEMP1.ItemId then
      	--       case when PO.Id=TEMP1.POID  Then 
        --        case when PO.ProjectId=PR.ProjectId then 'Raised'
        --            else 'Not Raised' end 
        --             else 'Not Raised' end 
        -- else 'Not Raised' end as POStatus,
        -- M.Mat_Image AS Image,
        -- M.Material_Name AS Name,
        -- M.Material_Code as ItemCode,
        -- B.brand_name AS Brand, 
        -- M.Material_Description AS Description,
        -- QLI.quantity AS Quantity,
        -- U.unitName AS Units,
        -- Q.quotecode as Quotecode,
        -- Q.inputType as InputType,
        -- M.Material_Id  as ItemId,
        -- TEMP.StockId as StockId,
        -- COALESCE(TEMP.ReceivedQty,0) as AvailableQty,
        -- COALESCE(AI.AllocatedQty,0) as AllocatedQty,
        -- PO.Id as POID,
        -- case When TEMP.StockId=AI.item_stockId then '1'
        -- else '0' end as AllocatedStatus,
        --  PR.projectId as ProjectId
        -- FROM `quotelineitem` AS QLI 
        -- JOIN `material` AS M ON QLI.itemid=M.Material_Id 
        -- JOIN `quotation_details` AS Q ON QLI.quoteId=Q.quoid 
        -- JOIN `brands` AS B ON M.Brand=B.brand_id 
        -- JOIN units AS U ON U.unitId=M.Mat_Unit
        -- JOIN `projects` AS PR ON PR.quoteId=Q.quoteCode 
        -- LEFT JOIN `itemallocation` AS AI on AI.ProjectId=PR.projectId and AI.ItemId=QLI.itemid
        -- LEFT JOIN (SELECT 
        -- item_id as ItemId,
        -- Quantity as Quantity,
        -- SupplierId as SupplierId,
        -- POID as POID
        -- from purchaseorder_lineitem) AS TEMP1 on QLI.itemId=TEMP1.ItemId and QLI.quantity=TEMP1.Quantity
        -- LEFT JOIN `purchase_order` AS PO ON  PO.Id=TEMP1.POID and PO.SupplierId=TEMP1.SupplierId
        -- LEFT JOIN (SELECT 
   	    -- SUM(ReceivedQty)As ReceivedQty,
        -- item_stockid  as StockId,
        -- item_id as ItemId,
        -- POID as POID
        -- from item_stock) AS TEMP on QLI.itemId=TEMP.ItemId
        --  where PR.projectId=" . $projectId . "
        -- group by Name,ItemId
        ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);

    $itemList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new lineItem();
        $item->set_lineItemId($row["lineItemId"]);
        $item->set_itemid($row["Id"]);
        $item->setImage($row["Image"]);
        $item->setName($row["Name"]);
        $item->setItemCode($row["ItemCode"]);
        $item->setBrand($row["Brand"]);
        $item->setPOStatus($row["POStatus"]);
        $item->setInwardStatus($row["InwardStatus"]);
        $item->setDescription($row["Description"]);
        $item->set_itemquantity($row["Quantity"]);
        $item->set_AvailableQty($row["AvailableQty"]);
        $item->setAllocatedQty($row["AllocatedQty"]);
        $item->setUnits($row["Units"]);
        $item->setStockId($row["StockId"]);
        $item->set_inputType($row["InputType"]);
        array_push($itemList, $item);
      }
    }
    header('Content-Type: application/json');
    echo json_encode($itemList);
  }

  public static function getLineItemByQuoteIdForModal($quoteId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "
SELECT QLI.lineItemId AS lineItemId,
       I.item_image AS image,
       I.item_name AS Name,
       B.brand_name AS Brand,
       I.item_description AS Description,
       U.unitName AS Units,
       QLI.quantity AS itemquantity,
       QLI.discount1 AS discount1,
       QLI.GST AS GST,
       QLI.totalAmount AS totalAmount,
       QLI.amount AS companyPrice,
       QLI.totalValue AS totalValue,
       QLI.totalPrice AS totalPrice
FROM `quotelineitem` AS QLI
JOIN `item_details` AS I ON QLI.InputName = I.item_name
JOIN `brands` AS B ON I.item_compid = B.brand_id
JOIN `units` AS U ON U.unitId = I.item_unit
WHERE QLI.quoteId = $quoteId
ORDER BY lineItemId ASC
";

    error_log($sql);

    $result = $conn->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
      $qty = floatval($row["itemquantity"]);       // quantity
      $comp = floatval($row["companyPrice"]);       // company price
      $tVal = floatval($row["totalValue"]);         // total value

      if ($comp == 0 || $comp == null) {
        $comp = $row["amount"] ?? 0;              // ✅ fallback to DB amount
      }

      if ($tVal == 0 || $tVal == null) {
        $tVal = $comp * $qty;                     // ✅ calculate if missing
      }

      $data[] = [
        "lineItemId" => $row["lineItemId"],
        "image" => $row["image"],
        "Name" => $row["Name"],
        "Brand" => $row["Brand"],        // ✅ now included
        "Description" => $row["Description"],  // ✅ now included
        "Units" => $row["Units"],        // ✅ now included
        "itemquantity" => floatval($row["itemquantity"] ?? 0),
        "discount1" => floatval($row["discount1"] ?? 0),
        "GST" => floatval($row["GST"] ?? 0),
        "totalAmount" => floatval($row["totalAmount"] ?? 0),
        "companyPrice" => floatval($row["companyPrice"] ?? 0),
        "totalValue" => floatval($row["totalValue"] ?? 0),
        "totalPrice" => floatval($row["totalPrice"] ?? 0)
      ];

    }
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK);
  }


  public static function getLineItemByQuoteIdForOrder($quoteId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    QLI.lineItemId AS lineItemId,
    QLI.itemId AS Id,
    I.item_image AS Image,
    I.item_name AS Name,
    I.item_catid As Itemcatid,
    I.item_subcatid As Itemsubcatid,
    I.item_ArticleNo as Itemcode,
    C.item_catName AS CategoryName,
    Q.quoteCode as quoteCode,
    SC.item_subcatName AS SubCategoryName,
    B.brand_name AS Brand, 
    I.item_description AS Description,
    QLI.quantity AS Quantity,
    U.unitName AS Units,
    QLI.discount1 AS CompanyDiscount,
    QLI.amount AS CompanyPrice,
    QLI.discount1Amt as DiscountAmt,
    QLI.totalAmount AS TotalAmount,
    QLI.totalPrice AS TradePrice,
    QLI.GST AS GST,
    QLI.inputType as Type,
    IP.InputType as InputTypeName,
    QLI.totalValue as totalValue,
    QLI.value as Value,
    UF.unitFactor AS unitFactor,
    I.item_pp_MRP AS MRP

        FROM `quotelineitem` AS QLI 
        JOIN `item_details` AS I ON QLI.InputName=I.item_name 
        JOIN item_category C ON I.item_catid=C.item_catid 
        JOIN item_subcategory SC ON I.item_subcatid=SC.item_subcatid 
        JOIN `brands` AS B ON I.item_compid=B.brand_id 
        JOIN units AS U ON U.unitId=I.item_unit
        JOIN unitsfactor UF ON UF.unitFactorId=I.item_unitFactor
        JOIN inputtype IP on IP.InputTypeId=QLI.inputType
        JOIN quotation_details Q on Q.quoteId=QLI.quoteId
        WHERE QLI.quoteId=$quoteId
        UNION
        SELECT 
        QLI.lineItemId AS lineItemId,
        QLI.itemId AS Id,
        M.Mat_Image AS Image,
        M.Material_Name AS Name,
        M.Category As Itemcatid,
        M.SubCategory As Itemsubcatid,
        M.Material_Code as Itemcode,
        C.material_catName AS CategoryName,
        Q.quoteCode as quoteCode,
        SC.material_subcatName AS SubCategoryName,
        B.brand_name AS Brand, 
        M.Material_Description AS Description,
        QLI.quantity AS Quantity,
        U.unitName AS Units,
        QLI.discount1 AS CompanyDiscount,
        QLI.amount AS CompanyPrice,
        QLI.discount1Amt as DiscountAmt,
        QLI.totalAmount AS TotalAmount,
        QLI.totalPrice AS TradePrice,
        QLI.GST AS GST,
        QLI.inputType as Type,
        IP.InputType as InputTypeName,
        QLI.totalValue as totalValue,
        QLI.value as Value,
        UF.unitFactor AS unitFactor,
        M.Mat_PPMRP AS MRP
        FROM `quotelineitem` AS QLI 
        JOIN `material` AS M ON QLI.InputName=M.Material_Name
        JOIN material_category C ON M.Category=C.material_catId 
        JOIN material_subcategory SC ON M.SubCategory=SC.material_subcatId 
        JOIN `brands` AS B ON M.Brand=B.brand_id 
        JOIN units AS U ON U.unitId=M.Mat_Unit
        JOIN unitsfactor UF ON UF.unitFactorId=M.Mat_factor
        JOIN inputtype IP on IP.InputTypeId=QLI.inputType
        JOIN quotation_details Q on Q.quoteId=QLI.quoteId
        WHERE QLI.quoteId=" . $quoteId;
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);

    $itemList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new lineItem();
        $item->set_lineItemId($row["lineItemId"]);
        $item->set_itemid($row["Id"]);
        $item->set_inputType($row["InputTypeName"]);
        $item->setItemCode($row["Itemcode"]);
        $item->set_itemcatname($row["CategoryName"]);
        $item->set_itemcatid($row["Itemcatid"]);
        $item->set_itemsubcatname($row["SubCategoryName"]);
        $item->set_itemsubcatid($row["Itemsubcatid"]);
        $item->setImage($row["Image"]);
        $item->setName($row["Name"]);
        $item->setBrand($row["Brand"]);
        $item->setDescription($row["Description"]);
        $item->set_itemquantity($row["Quantity"]);
        $item->setUnits($row["Units"]);
        $item->set_discount1($row['CompanyDiscount']);
        $item->set_discount1Amt($row['DiscountAmt']);
        $item->set_totalAmount($row['TotalAmount']);
        $item->set_totalPrice($row['TradePrice']);
        $item->set_totalValue($row['totalValue']);
        $item->set_value($row['Value']);
        $item->set_GST($row['GST']);
        $item->set_ppMRP($row['MRP']);
        $item->setUnitFactor($row['unitFactor']);
        $item->setQuoteCode($row['quoteCode']);
        $item->set_companyDiscount($row['CompanyDiscount']);
        $item->set_companyPrice($row['CompanyPrice']);

        array_push($itemList, $item);
      }
    }
    return $itemList;
  }

  public static function getMaterialLineItemByQuoteIdforOrder($quoteId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
        QLI.lineItemId AS lineItemId,
        QLI.itemId AS Id,
        M.Mat_Image AS Image,
        M.Material_Name AS Name,
        M.Material_Code as Material_Code,
        M.Category As Matcatid,
        M.SubCategory	 As Matsubcatid,
        C.material_catName AS CategoryName,
       Q.quoteCode as quoteCode,
        SC.material_subcatName AS SubCategoryName,
        B.brand_name AS Brand, 
        M.Material_Description	 AS Description,
        QLI.quantity AS Quantity,
        U.unitName AS Units,
        QLI.discount1 AS Discount1,
        QLI.discount1Amt as DiscountAmt,
        QLI.totalAmount AS TotalAmount,
        QLI.totalPrice AS TotalPrice,
        QLI.discount1 AS CompanyDiscount,
        QLI.amount AS CompanyPrice,
        QLI.GST AS GST,
        QLI.inputType as Type,
        IP.InputType as InputTypeName,
        QLI.totalValue as totalValue,
        UF.unitFactor AS unitFactor,
        M.Mat_PPMRP AS MRP
        FROM `quotelineitem` AS QLI 
        JOIN `material` AS M ON QLI.itemid=M.Material_Id  
        JOIN  material_category C ON  M.Category=C.material_catId 
      JOIN material_subcategory SC ON M.SubCategory=SC.material_subcatId 
        JOIN `brands` AS B ON M.Brand=B.brand_id 
        JOIN units AS U ON U.unitId=M.Mat_Unit
        JOIN unitsfactor UF ON UF.unitFactorId=M.Mat_factor
        JOIN inputtype IP on IP.InputTypeId=QLI.inputType
        join quotation_details Q on Q.quoteId=QLI.quoteId
        WHERE QLI.quoteId=" . $quoteId;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);

    $itemList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new lineItem();
        $item->set_lineItemId($row["lineItemId"]);
        $item->set_itemid($row["Id"]);
        $item->set_inputType($row["InputTypeName"]);
        $item->setItemCode($row["Material_Code"]);
        $item->set_itemcatname($row["CategoryName"]);
        $item->set_itemcatid($row["Matcatid"]);
        $item->set_itemsubcatname($row["SubCategoryName"]);
        $item->set_itemsubcatid($row["Matsubcatid"]);
        $item->setImage($row["Image"]);
        $item->setName($row["Name"]);
        $item->setBrand($row["Brand"]);
        $item->setDescription($row["Description"]);
        $item->set_itemquantity($row["Quantity"]);
        $item->setUnits($row["Units"]);
        $item->set_discount1($row['Discount1']);
        $item->set_discount1Amt($row['DiscountAmt']);
        $item->set_totalAmount($row['TotalAmount']);
        $item->set_totalPrice($row['TotalPrice']);
        $item->set_totalValue($row['totalValue']);
        $item->set_GST($row['GST']);
        $item->set_ppMRP($row['MRP']);
        $item->setUnitFactor($row['unitFactor']);
        $item->setQuoteCode($row['quoteCode']);
        array_push($itemList, $item);
      }
    }
    return $itemList;
  }

  public static function getMaterialLineItemByProjectId($projectId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
        QLI.lineItemId AS lineItemId,
        QLI.itemId AS Id,
        case When TEMP1.ItemId=TEMP.ItemId Then 
        case when PO.ProjectId=PR.ProjectId  Then 'Received'
              else 'Not Received'end 
            else 'Not Received' end as InwardStatus,
        case When QLI.itemid=TEMP1.ItemId then
      	      case when PO.Id=TEMP1.POID  Then 
               case when PO.ProjectId=PR.ProjectId then 'Raised'
                   else 'Not Raised' end 
                    else 'Not Raised' end 
        else 'Not Raised' end as POStatus,
        M.Mat_Image AS Image,
        M.Material_Name AS Name,
        M.Material_Code as ItemCode,
        B.brand_name AS Brand, 
        M.Material_Description AS Description,
        QLI.quantity AS Quantity,
        U.unitName AS Units,
        Q.quotecode as Quotecode,
        Q.inputType as InputType,
        M.Material_Id  as ItemId,
        TEMP.StockId as StockId,
        COALESCE(TEMP.ReceivedQty,0) as AvailableQty,
        COALESCE(AI.AllocatedQty,0) as AllocatedQty,
        PO.Id as POID,
        case When TEMP.StockId=AI.item_stockId then '1'
        else '0' end as AllocatedStatus,
         PR.projectId as ProjectId
        FROM `quotelineitem` AS QLI 
        JOIN `material` AS M ON QLI.InputName=M.Material_Name 
        JOIN `quotation_details` AS Q ON QLI.quoteId=Q.quoteId 
        JOIN `brands` AS B ON M.Brand=B.brand_id 
        JOIN units AS U ON U.unitId=M.Mat_Unit
        JOIN `projects` AS PR ON PR.quoteId=Q.quoteCode 
        LEFT JOIN `itemallocation` AS AI on AI.ProjectId=PR.projectId and AI.ItemId=QLI.itemid
        LEFT JOIN (SELECT 
        item_id as ItemId,
                   InputName as InputName,
        Quantity as Quantity,
        SupplierId as SupplierId,
        POID as POID
        from purchaseorder_lineitem) AS TEMP1 on QLI.InputName=TEMP1.InputName and QLI.quantity=TEMP1.Quantity
        LEFT JOIN `purchase_order` AS PO ON  PO.Id=TEMP1.POID and PO.SupplierId=TEMP1.SupplierId
        LEFT JOIN (SELECT 
   	    SUM(ReceivedQty)As ReceivedQty,
        item_stockid  as StockId,
        item_id as ItemId,
        POID as POID
        from item_stock) AS TEMP on QLI.itemId=TEMP.ItemId
         where PR.projectId=" . $projectId . "
        group by Name,ItemId";

    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);

    $itemList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new lineItem();
        $item->set_lineItemId($row["lineItemId"]);
        $item->set_itemid($row["Id"]);
        $item->setImage($row["Image"]);
        $item->setName($row["Name"]);
        $item->setItemCode($row["ItemCode"]);
        $item->setBrand($row["Brand"]);
        $item->setPOStatus($row["POStatus"]);
        $item->setInwardStatus($row["InwardStatus"]);
        $item->setDescription($row["Description"]);
        $item->set_itemquantity($row["Quantity"]);
        $item->set_AvailableQty($row["AvailableQty"]);
        $item->setAllocatedQty($row["AllocatedQty"]);
        $item->setUnits($row["Units"]);
        $item->setStockId($row["StockId"]);
        $item->set_inputType($row["InputType"]);
        array_push($itemList, $item);
      }
    }
    header('Content-Type: application/json');
    echo json_encode($itemList);
  }


  public static function getAllquotations()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM  quotation_details";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $quotationList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $quotation = new quotation();
        $quotation->set_quoteId($row["quoteId"]);
        //$quotation->set_quotationname($row["quotation_name"]);
        array_push($quotationList, $quotation);
      }
    }
    return $quotationList;
  }

  public static function update($lineItemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "UPDATE quotelineitem SET 
            quantity = {$lineItemObj->get_itemquantity()},
            amount = {$lineItemObj->get_companyPrice()},
            totalAmount = {$lineItemObj->get_totalAmount()},
            discount1 = {$lineItemObj->get_discount1()},
            discount1Amt = {$lineItemObj->get_discount1Amt()},
            GSTAmount = {$lineItemObj->get_GSTAmt()},
            GST = {$lineItemObj->get_GST()},
            totalPrice = {$lineItemObj->get_totalPrice()},
            totalValue = {$lineItemObj->get_totalValue()},
            value = {$lineItemObj->get_value()},
            modifiedby = '{$lineItemObj->get_modifiedby()}'
        WHERE lineItemId = {$lineItemObj->get_lineItemId()}";

    error_log($sql);

    if ($connectionObj->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }


  public static function delete($lineItemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE from quotelineitem where lineItemId=" . $lineItemObj;
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

  }

}