<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/purchaseModel.php";
require_once "../Model/POlineitemModel.php";


class DBPOLineItem
{
  public static function insert($lineItemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * from purchaseorder_lineitem where 	Item_id='" . $lineItemObj->get_itemid() . "' and POID='" . $lineItemObj->get_POID() . "'";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    error_log($count);
    if ($count < 1) {
      if ($_POST["totalamt"] == 0) {
        $sql = "INSERT INTO `purchaseorder_lineitem`(
            `POID`, 
            `Item_id`,
            `InputName`,
            `SupplierId`,
            `Quantity`,  
            `GST`, 
            `Price`) 
                values ('" . $lineItemObj->get_POID() . "',
                '" . $lineItemObj->get_itemid() . "',
               '" . $lineItemObj->getInputName() . "',
                '" . $lineItemObj->get_supplierId() . "',
                '" . $lineItemObj->get_quantity() . "',
                '" . $lineItemObj->get_GST() . "',
               '" . $lineItemObj->get_price() . "')";
        error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      } else {
        $sql = "INSERT INTO `purchaseorder_lineitem`(
            `POID`, 
            `Item_id`,
            `SupplierId`,
            `TotalAmt`,
            `Quantity`,  
            `GST`, 
            `Price`) 
                values ('" . $lineItemObj->get_POID() . "',
                '" . $lineItemObj->get_itemid() . "',
                '" . $lineItemObj->get_supplierId() . "',
                '" . $lineItemObj->get_totalamt() . "',
                '" . $lineItemObj->get_quantity() . "',
                '" . $lineItemObj->get_GST() . "',
               '" . $lineItemObj->get_price() . "')";
        error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }


  public static function getPOLineItemByPurchaseId($purchaseId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
        PLI.POlineitemId AS Polineitemid,
        PLI.Item_id AS Item_id,
        I.item_name AS Name,
        I.item_image as ItemImage,
        I.item_description as Description,
        I.item_ArticleNo as Itemcode,
        B.brand_name AS Brand, 
        U.unitName AS Units,
        PLI.Quantity AS Quantity,
        PLI.TotalAmt AS TotalAmount,
        PLI.Price AS Price,
        C.item_catName AS CategoryName,
        SC.item_subcatName AS SubCategoryName,
        PLI.GST AS GST
        FROM `purchaseorder_lineitem` AS PLI 
        JOIN `item_details` AS I ON PLI.InputName=I.item_name
        Join `item_category` C ON C.item_catid=I.item_catid
        Join `item_subcategory` SC ON SC.item_subcatid=I.item_subcatid
        JOIN `brands` AS B ON I.item_compid=B.brand_id 
        JOIN units AS U ON U.unitId=I.item_unit
        Where PLI.POID=$purchaseId
        UNION
        SELECT 
        PLI.POlineitemId AS Polineitemid,
        PLI.Item_id AS Item_id,
        M.Material_Name AS Name,
        M.Mat_Image as ItemImage,
        M.Material_Description as Description,
        M.Material_Code as Itemcode,
        B.brand_name AS Brand, 
        U.unitName AS Units,
        PLI.Quantity AS Quantity,
        PLI.TotalAmt AS TotalAmount,
        PLI.Price AS Price,
        C.material_catName AS CategoryName,
        SC.material_subcatName AS SubCategoryName,
        PLI.GST AS GST
        FROM `purchaseorder_lineitem` AS PLI 
        JOIN `material` AS M ON PLI.InputName=M.Material_Name 
        JOIN material_category C ON M.Category=C.material_catId 
      JOIN material_subcategory SC ON M.SubCategory=SC.material_subcatId 
        JOIN `brands` AS B ON M.Brand=B.brand_id 
        JOIN units AS U ON U.unitId=M.Mat_Unit
        Where PLI.POID=" . $purchaseId . "
        ";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    error_log($sql);
    $lineitemList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new PurchaselineItem();
        $item->set_POlineitemId($row["Polineitemid"]);
        $item->setName($row["Name"]);
        $item->set_itemid($row["Item_id"]);
        $item->setItemcode($row["Itemcode"]);
        $item->setItemImage($row["ItemImage"]);
        $item->set_quantity($row["Quantity"]);
        $item->set_totalamt($row['TotalAmount']);
        $item->set_price($row['Price']);
        $item->set_GST($row['GST']);
        $item->setunitName($row["Units"]);
        $item->setBrand($row["Brand"]);
        $item->setDescription($row["Description"]);
        array_push($lineitemList, $item);
      }
    }
    header('Content-Type: application/json');
    echo json_encode($lineitemList);
  }


  public static function getPOLineItemByItemId($ItemId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
        PLI.POlineitemId AS Polineitemid,
        PLI.Item_id AS Item_id,
        I.item_name AS Name,
        PLI.POID AS POID,
        PLI.Quantity AS Quantity,
        PLI.TotalAmt AS TotalAmount,
        -- S.Barcodeimg as Barcode,
        S.ReceivedQtyAmt as LatestAmt,
        S.ReceivedQty as InwardedQty,
        S.Quantity as RaisedQty,
        (PLI.TotalAmt/PLI.Quantity) AS Price,
        case When P.ProjectId =0 Then 
    'General'
    else 'Project Based'
    end  as POType,
        P.POcode as POCode
        FROM `purchaseorder_lineitem` AS PLI 
        JOIN `purchase_order` AS P ON PLI.POID=P.Id
        JOIN `item_stock` AS S ON PLI.POID=S.POID and S.item_id=PLI.Item_id
        JOIN `item_details` AS I ON PLI.InputName=I.item_name
        Where PLI.Item_id=$ItemId
        UNION
        SELECT 
        PLI.POlineitemId AS Polineitemid,
        PLI.Item_id AS Item_id,
        M.Material_Name AS Name,
        PLI.POID AS POID,
        PLI.Quantity AS Quantity,
        PLI.TotalAmt AS TotalAmount,
        -- S.Barcodeimg as Barcode,
        S.ReceivedQtyAmt as LatestAmt,
        S.ReceivedQty as InwardedQty,
        S.Quantity as RaisedQty,
        (PLI.TotalAmt/PLI.Quantity) AS Price,
        case When P.ProjectId =0 Then 
    'General'
    else 'Project Based'
    end  as POType,
        P.POcode as POCode
        FROM `purchaseorder_lineitem` AS PLI 
        JOIN `purchase_order` AS P ON PLI.POID=P.Id
        JOIN `item_stock` AS S ON PLI.POID=S.POID and S.item_id=PLI.Item_id
        JOIN `material` AS M ON PLI.InputName=M.Material_Name 
        Where PLI.Item_id=" . $ItemId . "";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    error_log($sql);
    $lineitemList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new PurchaselineItem();
        $item->set_POlineitemId($row["Polineitemid"]);
        $item->setPOcode($row["POCode"]);
        $item->setPOType($row["POType"]);

        $item->set_POID($row["POID"]);
        $item->setRaisedQty($row["RaisedQty"]);
        $item->setName($row["Name"]);
        $item->set_itemid($row["Item_id"]);
        $item->set_quantity($row["Quantity"]);
        $item->set_totalamt($row['TotalAmount']);
        $item->set_price($row['Price']);
        $item->set_ReceivedQtyAmt($row['LatestAmt']);
        $item->set_ReceivedQty($row['InwardedQty']);
        array_push($lineitemList, $item);
      }
    }
    return $lineitemList;
  }

  public static function getPOLineItemByMaterialId($MatId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
        PLI.POlineitemId AS Polineitemid,
        PLI.Item_id AS Item_id,
        M.Material_Name AS Name,
        PLI.POID AS POID,
        PLI.Quantity AS Quantity,
        PLI.TotalAmt AS TotalAmount,
        -- S.Barcodeimg as Barcode,
        S.ReceivedQtyAmt as LatestAmt,
        S.ReceivedQty as InwardedQty,
        S.Quantity as RaisedQty,
        (PLI.TotalAmt/PLI.Quantity) AS Price,
        case When P.ProjectId =0 Then 
    'General'
    else 'Project Based'
    end  as POType,
        P.POcode as POCode
        FROM `purchaseorder_lineitem` AS PLI 
        JOIN `purchase_order` AS P ON PLI.POID=P.Id
        JOIN `item_stock` AS S ON PLI.POID=S.POID and S.item_id=PLI.Item_id
        JOIN `material` AS M ON PLI.Item_id=M.Material_Id 
        Where PLI.Item_id=" . $MatId . "";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    error_log($sql);
    $lineitemList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new PurchaselineItem();
        $item->set_POlineitemId($row["Polineitemid"]);
        $item->setPOcode($row["POCode"]);
        $item->setPOType($row["POType"]);

        $item->set_POID($row["POID"]);
        $item->setRaisedQty($row["RaisedQty"]);
        $item->setName($row["Name"]);
        $item->set_itemid($row["Item_id"]);
        $item->set_quantity($row["Quantity"]);
        $item->set_totalamt($row['TotalAmount']);
        $item->set_price($row['Price']);
        $item->set_ReceivedQtyAmt($row['LatestAmt']);
        $item->set_ReceivedQty($row['InwardedQty']);
        array_push($lineitemList, $item);
      }
    }
    return $lineitemList;
  }


  public static function getLineItemByPurchaseIdForOrder($purchaseId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    PLI.POlineitemId AS Id,
    P.Id As POID,
    PLI.Item_id AS Item_id,
    I.item_name AS Name,
    I.item_HSNcode AS HSNCode,
    I.item_ArticleNo AS ItemCode,
    I.item_image AS ItemImage,
    I.item_pp_MRP as PPMRP,
    B.brand_name as BrandName,
    PLI.Quantity AS Quantity,
    COALESCE(SUM(S.ReceivedQtyAmt),0) AS TotalAmount,
I.item_Price AS InventoryPrice,
    P.POcode as POcode,
    P.SupplierId as SupplierId,
    MAX(S.GST) AS GSTamt,
    MAX(S.item_stockid) AS StockId,
    MAX(S.InvoiceNo) AS InvoiceNo,
    PLI.Quantity - COALESCE(SUM(S.ReceivedQty),0) AS BalanceQty,
    COALESCE(SUM(S.ReceivedQtyAmt),0) AS ReceivedQtyAmt,
    COALESCE(SUM(S.ReceivedQty),0) AS ReceivedQty,
    C.item_catName AS CategoryName,
    SC.item_subcatName AS SubCategoryName,
    UF.unitName AS unitName,
    'item' AS inventoryType
FROM purchaseorder_lineitem PLI
JOIN item_details I ON PLI.InputName = I.item_name
JOIN purchase_order P ON PLI.POID = P.ID
LEFT JOIN item_stock S ON S.POID = PLI.POID AND S.item_id = PLI.Item_id
JOIN units UF ON UF.unitId = I.item_unit
JOIN item_category C ON C.item_catid = I.item_catid
JOIN item_subcategory SC ON SC.item_subcatid = I.item_subcatid
JOIN brands B ON B.brand_id = I.item_compid
WHERE PLI.POID = $purchaseId
GROUP BY PLI.POlineitemId

        UNION
        SELECT 
        PLI.POlineitemId AS Id,
        P.Id As POID,
        PLI.Item_id AS Item_id,
        M.Material_Name AS Name,
        M.Mat_HSNCode AS HSNCode,
        M.Material_Code AS ItemCode,
        M.Mat_Image AS ItemImage,
        M.Mat_PPMRP as PPMRP,
        B.brand_name as BrandName,
        PLI.Quantity AS Quantity,
        COALESCE(SUM(S.ReceivedQtyAmt), 0) AS TotalAmount,
M.MaterialPrice AS InventoryPrice,
        P.POcode as POcode,
        P.SupplierId as SupplierId,
        S.GST AS GSTamt,
        S.item_stockid AS StockId,
        S.InvoiceNo AS InvoiceNo,
        PLI.Quantity - Sum(S.ReceivedQty) As BalanceQty,
        sum(S.ReceivedQtyAmt) AS ReceivedQtyAmt,
        Sum(S.ReceivedQty) AS ReceivedQty,
        C.material_catName AS CategoryName,
        SC.material_subcatName AS SubCategoryName,
        UF.unitName AS unitName,
        'material' AS inventoryType
        FROM `purchaseorder_lineitem` AS PLI 
        JOIN `material` AS M ON PLI.InputName=M.Material_Name  
        JOIN `purchase_order` AS P ON PLI.POID=P.ID 
        JOIN units UF ON UF.unitId=M.Mat_Unit
        JOIN material_category C ON M.Category=C.material_catId 
        JOIN material_subcategory SC ON M.SubCategory=SC.material_subcatId 
        JOIN `brands` AS B ON M.Brand=B.brand_id 
        LEFT Join `item_stock` S ON S.POID=PLI.POID AND PLI.item_id=S.item_id
        WHERE PLI.POID='" . $purchaseId . "'
          GROUP BY PLI.POlineitemId";

    $result = $connectionObj->query($sql);
    error_log($sql);
    $count = mysqli_num_rows($result);
    $POListItem = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $item = new PurchaselineItem();
        $item->set_POlineitemId($row["Id"]);
        $item->set_POID($row["POID"]);
        $item->setPOcode($row["POcode"]);
        $item->set_supplierId($row["SupplierId"]);
        $item->set_itemid($row["Item_id"]);
        $item->setItemImage($row["ItemImage"]);
        $item->setBrand($row["BrandName"]);
        $item->setName($row["Name"]);
        $item->set_quantity($row["Quantity"]);
        $item->set_totalamt($row['TotalAmount']);
        $item->setInventoryPrice($row['InventoryPrice']);
        $item->set_PPMRP($row['PPMRP']);
        // $item->set_GST($row['GST']);
        $item->setunitName($row['unitName']);
        $item->setHSNcode($row['HSNCode']);
        // $item-> setbarcodeimg($row['BarcodeImg']);
        $item->setInvoiceNo($row['InvoiceNo']);
        $item->setItemcode($row['ItemCode']);
        // $item-> setOtherCharges($row['Othercharges']);
        // $item-> setDiscount($row['Discount']);
        // $item-> setTaxableValue($row['TaxableValue']);
        // $item-> setCD($row['CD']);
        // $item-> setIGST($row['IGST']);
        $item->setGSTamt($row['GSTamt']);
        $item->set_ReceivedQtyAmt($row['ReceivedQtyAmt']);
        $item->set_ReceivedQty($row['ReceivedQty']);
        $item->setStockId($row['StockId']);
        $item->set_BalanceQty($row['BalanceQty']);
        $item->setItemcatname($row["CategoryName"]);
        $item->setItemsubcatname($row["SubCategoryName"]);
        $item->setInventoryType($row["inventoryType"]);

        array_push($POListItem, $item);
      }
    }
    return $POListItem;
  }



  public static function getAllpurchaseorders()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM  purchase_order";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $purchaseList = [];
    if ($count > 0) {
      while ($row = mysPLI_fetch_array($result, MYSPLI_ASSOC)) {
        $purchase = new PurchaseOrder();
        $purchase->set_Id($row["Id"]);
        //$quotation->set_quotationname($row["quotation_name"]);
        array_push($purchaseList, $quotation);
      }
    }
    return $purchaseList;
  }

  public static function update($lineItemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE purchaseorder_lineitem SET 
            TotalAmt=" . $lineItemObj->get_totalamt() .
      " ,
            SupplierId= '" . $lineItemObj->get_supplierId() . "',
            Quantity=" . $lineItemObj->get_quantity() . " ,
             Price=" . $lineItemObj->get_price() .
      " WHERE POlineitemId=" . $lineItemObj->get_POlineitemId();
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function delete($lineItemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE from purchaseorder_lineitem where POlineitemId=" . $lineItemObj;
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

  }

}