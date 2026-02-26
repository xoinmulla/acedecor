<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/allocateitemsModel.php";
require_once "../Model/quoteLineItemModel.php";
class DBallocate
{
  public static function insert($allocateObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "INSERT INTO itemallocation (`item_stockId`, `ProjectId`, `itemId`,`InputName`,`AllocatedQty`) 
                values ('" . $allocateObj->get_itemstockId() .
      "','" . $allocateObj->get_ProjectId() .
      "','" . $allocateObj->get_itemId() .
      "','" . $allocateObj->getItemName() .
      "','" . $allocateObj->get_AllocatedQty() . "')";
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getLineItemByProjectId($projectId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT 
        QLI.lineItemId AS lineItemId,
        QLI.itemId AS Id,

        CASE 
            WHEN TEMP1.ItemId = TEMP.ItemId 
                 AND PO.ProjectId = PR.projectId
            THEN 'Received'
            ELSE 'Not Received'
        END as InwardStatus,

        CASE 
            WHEN QLI.itemid = TEMP1.ItemId 
                 AND PO.ProjectId = PR.projectId
            THEN 'Raised'
            ELSE 'Not Raised'
        END as POStatus,

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

COALESCE(TEMP.ReceivedQty,0) 
- COALESCE(SUM(AI.AllocatedQty),0) 
as AvailableQty,

COALESCE(SUM(AI.AllocatedQty),0) as AllocatedQty,
        PO.Id as POID,
        CASE 
            WHEN TEMP.StockId = AI.item_stockId THEN '1'
            ELSE '0'
        END as AllocatedStatus,
        PR.projectId as ProjectId

    FROM quotelineitem AS QLI 

    JOIN item_details AS I 
        ON QLI.itemId = I.item_id

    JOIN quotation_details AS Q 
        ON QLI.quoteId = Q.quoteid

    JOIN brands AS B 
        ON I.item_compid = B.brand_id 

    JOIN units AS U 
        ON U.unitId = I.item_unit

    /* ✅ FIXED JOIN */
    JOIN projects AS PR 
        ON PR.quoteId = Q.quoteCode

    LEFT JOIN itemallocation AS AI 
        ON AI.ProjectId = PR.projectId 
        AND AI.ItemId = QLI.itemid

    LEFT JOIN (
        SELECT 
            item_id as ItemId,
            Quantity as Quantity,
            SupplierId as SupplierId,
            POID as POID
        FROM purchaseorder_lineitem
    ) AS TEMP1 
        ON QLI.itemId = TEMP1.ItemId 
        AND QLI.quantity = TEMP1.Quantity

    LEFT JOIN purchase_order AS PO 
        ON PO.Id = TEMP1.POID 
        AND PO.SupplierId = TEMP1.SupplierId

    LEFT JOIN (
        SELECT 
            item_id AS ItemId,
            SUM(ReceivedQty) AS ReceivedQty,
            MAX(item_stockid) AS StockId
        FROM item_stock
        GROUP BY item_id
    ) AS TEMP 
        ON QLI.itemId = TEMP.ItemId

    WHERE PR.projectId = $projectId

    GROUP BY QLI.lineItemId";

    error_log($sql);

    $result = $connectionObj->query($sql);
    $itemList = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
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
        $item->set_itemid($row["ItemId"]);
        $item->setStockId($row["StockId"]);
        $item->setAllocatedStatus($row["AllocatedStatus"]);
        $itemList[] = $item;
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

        case 
            when TEMP1.ItemId = TEMP.ItemId 
                 and PO.ProjectId = PR.projectId
            then 'Received'
            else 'Not Received'
        end as InwardStatus,

        case 
            when QLI.itemid = TEMP1.ItemId 
                 and PO.ProjectId = PR.projectId
            then 'Raised'
            else 'Not Raised'
        end as POStatus,

        M.Mat_Image AS Image,
        M.Material_Name AS Name,
        M.Material_Code as ItemCode,
        B.brand_name AS Brand, 
        M.Material_Description AS Description,
        QLI.quantity AS Quantity,
        U.unitName AS Units,
        Q.quotecode as Quotecode,
        Q.inputType as InputType,
        M.Material_Id as ItemId,

        /* ✅ Correct Available Qty */
        COALESCE(TEMP.ReceivedQty,0) 
            - COALESCE(SUM(AI.AllocatedQty),0) 
            AS AvailableQty,

        /* ✅ Correct Allocated Qty */
        COALESCE(SUM(AI.AllocatedQty),0) as AllocatedQty,

        CASE 
            WHEN SUM(AI.AllocatedQty) > 0 THEN '1'
            ELSE '0'
        END as AllocatedStatus,

        PR.projectId as ProjectId

    FROM quotelineitem AS QLI 

    JOIN material AS M 
        ON QLI.InputName = M.Material_Name 

    JOIN quotation_details AS Q 
        ON QLI.quoteId = Q.quoteid 

    JOIN brands AS B 
        ON M.Brand = B.brand_id 

    JOIN units AS U 
        ON U.unitId = M.Mat_Unit

    JOIN projects AS PR 
        ON PR.quoteId = Q.quoteCode 

    LEFT JOIN itemallocation AS AI 
        ON AI.ProjectId = PR.projectId 
        AND AI.ItemId = QLI.itemid

    /* KEEP ORIGINAL TEMP1 SUBQUERY */
    LEFT JOIN (
        SELECT 
            item_id as ItemId,
            InputName as InputName,
            Quantity as Quantity,
            SupplierId as SupplierId,
            POID as POID
        from purchaseorder_lineitem
    ) AS TEMP1 
        ON QLI.InputName = TEMP1.InputName 
        AND QLI.quantity = TEMP1.Quantity

    LEFT JOIN purchase_order AS PO 
        ON PO.Id = TEMP1.POID 
        AND PO.SupplierId = TEMP1.SupplierId

    /* FIXED STOCK AGGREGATION */
    LEFT JOIN (
        SELECT 
            item_id AS ItemId,
            SUM(ReceivedQty) AS ReceivedQty
        FROM item_stock
        GROUP BY item_id
    ) AS TEMP 
        ON TEMP.ItemId = QLI.itemId

    WHERE PR.projectId = " . $projectId . "

    GROUP BY QLI.lineItemId";

    error_log($sql);

    $result = $connectionObj->query($sql);

    $MatList = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {

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
        $item->setUnits($row["Units"]);
        $item->setAllocatedQty($row["AllocatedQty"]);
        $item->setAllocatedStatus($row["AllocatedStatus"]);

        $MatList[] = $item;
      }
    }

    return $MatList;
  }

  public static function getAllocatedItemInfo($ItemId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT 
                A.ItemId as ItemId,
                A.ProjectId as ProjectId,
                A.AllocatedQty as AllocatedQty,
                P.projectId as ProjectId,
                P.customerName as customerName,
                P.projectCode as ProjectCode,
                S.item_stockid as StockId,
                PO.POcode as POcode,
                I.item_name as ItemName
            FROM itemallocation as A
            JOIN projects P 
                ON P.projectId = A.ProjectId
            LEFT JOIN item_stock S 
                ON S.item_stockid = A.item_stockId
            LEFT JOIN purchase_order PO 
                ON S.POID = PO.Id
            JOIN item_details as I 
                ON A.ItemId = I.item_id
            WHERE A.ItemId = $ItemId";

    error_log($sql);

    $result = $connectionObj->query($sql);
    $AllocationList = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {

        $Allocation = new Allocation();
        $Allocation->set_itemId($row['ItemId']);
        $Allocation->setItemName($row['ItemName']);
        $Allocation->setCustomerName($row['customerName']);
        $Allocation->setProjectCode($row['ProjectCode']);
        $Allocation->set_ProjectId($row['ProjectId']);
        $Allocation->setPOcode($row['POcode']);
        $Allocation->set_AllocatedQty($row['AllocatedQty']);

        array_push($AllocationList, $Allocation);
      }
    }

    return $AllocationList;
  }

  public static function delete($allocateObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE FROM itemallocation where ItemId=" . $allocateObj->get_itemId() . " and ProjectId=" . $allocateObj->get_ProjectId() . " ";
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

}
