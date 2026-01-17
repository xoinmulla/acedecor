<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/purchaseModel.php";
require_once "../Model/item_detailsmodel.php";
require_once "../Model/item_companydetailsmodel.php";
class DBpurchase
{
  public static function insert($purchaseObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "INSERT INTO purchase_order 
(`Item_id`, `SupplierId`, `InventoryType`, `POcode`, `PurchasedDate`, `ProjectId`) 
VALUES (
  '" . $purchaseObj->get_itemid() . "',
  '" . $purchaseObj->get_supplier() . "',
  '" . $purchaseObj->getInventoryType() . "',
  '" . $purchaseObj->getPOcode() . "',
  '" . $purchaseObj->get_purchaseddate() . "',
  '" . $purchaseObj->get_projectId() . "'
)";

    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
      $purchaseId = $connectionObj->insert_id;

      $sql = "UPDATE purchase_order SET POcode='" . $purchaseObj->getPOcode() . $purchaseId . "' WHERE Id=" . $purchaseId;
      error_log($sql);
      $connectionObj->query($sql);
      return $purchaseId;
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getAllpurchases()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    CASE 
        WHEN PO.ProjectId = 0 THEN 'General'
        ELSE 'Project Based'
    END AS POtype,

    PO.Id AS Id,
    PO.POcode AS POcode,
    PO.Item_id AS ItemId,
    PO.Status AS POStatus,
    PO.PurchasedDate AS PurchasedDate,
    PO.SupplierId AS SupplierId,

    COALESCE(STOCK_AMT.TotalAmt, 0) AS TotalAmt,
    PO.InventoryType AS InventoryType,

    SUM(SP.received_amount) AS ReceivedAmt,

    COALESCE(STOCK_AMT.ReceivedQty, 0) AS ReceivedQty,
    COALESCE(TEMP1.Quantity - STOCK_AMT.ReceivedQty, TEMP1.Quantity) AS BalanceQuantity,

    CO.item_compname AS SupplierName,
    COALESCE(TEMP1.Quantity, 0) AS Quantity,

    CASE 
        WHEN TEMP1.Quantity = STOCK_AMT.ReceivedQty THEN 'Fully Received'
        WHEN TEMP1.Quantity > STOCK_AMT.ReceivedQty THEN 'Partially Received'
        WHEN PO.Status = 1 THEN 'Cancelled'
        ELSE 'Raised'
    END AS Status

FROM purchase_order PO

/* ✅ ORDERED QTY */
LEFT JOIN (
    SELECT 
        POID,
        SUM(Quantity) AS Quantity
    FROM purchaseorder_lineitem
    GROUP BY POID
) AS TEMP1 ON TEMP1.POID = PO.Id

/* ✅ INWARD / INVOICE AMOUNT */
LEFT JOIN (
    SELECT 
        POID,
        SUM(ReceivedQtyAmt) AS TotalAmt,
        SUM(ReceivedQty) AS ReceivedQty
    FROM item_stock
    GROUP BY POID
) AS STOCK_AMT ON STOCK_AMT.POID = PO.Id

JOIN item_companydetails CO ON CO.item_compid = PO.SupplierId

LEFT JOIN supplierpaymentinfo SP ON SP.POID = PO.Id

GROUP BY PO.Id";

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $purchaseList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $purchase = new PurchaseOrder();
        $purchase->set_Id($row["Id"]);
        $purchase->setPOcode($row["POcode"]);
        $purchase->setPOtype($row["POtype"]);
        $purchase->setPOStatus($row["POStatus"]);
        $purchase->setStatus($row["Status"]);
        $purchase->setBalanceQuantity($row["BalanceQuantity"]);
        $purchase->set_supplier($row["SupplierId"]);
        $purchase->setSupplierName($row["SupplierName"]);
        $purchase->setQuantity($row["Quantity"]);
        $purchase->set_totalAmount($row["TotalAmt"]);
        $purchase->setInventoryType($row["InventoryType"]);
        $purchase->setBalanceAmt($row['TotalAmt'] - $row['ReceivedAmt']);
        $purchase->set_purchaseddate($row["PurchasedDate"]);
        array_push($purchaseList, $purchase);
      }
    }
    return $purchaseList;
  }

  //   public static function getAllpurchasesbasedonItemId($POItemId)
//   {
//     $db = ConnectDb::getInstance();
//     $connectionObj = $db->getConnection();
//     $sql = "SELECT 
//     PO.Id AS Id,
//     PO.POcode as POcode,
//     PO.Item_id AS ItemId,
//     SUM(PLI.TotalAmt) AS TotalAmt
//     SUM(PLI.Quantity) AS Quantity
//     FROM `purchase_order` AS PO
//     JOIN `purchaseorder_lineitem` PLI oN PLI.POID=PO.Id
//  where  PO.Item_id='".$POItemId."'
//     GROUP BY   Id,
//      POcode,
//      ItemId,
//    PurchasedDate,
//     SupplierId, 
//     SupplierName";
//     $result = $connectionObj->query($sql);
//     $count = mysqli_num_rows($result);
//     $purchaseList = [];
//     if ($count > 0) {
//       while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//         $purchase = new PurchaseOrder();
//         $purchase->set_Id($row["Id"]);
//         $purchase->setPOcode($row["POcode"]);

  //         $purchase->set_supplier($row["SupplierId"]);
//         $purchase->setSupplierName($row["SupplierName"]);

  //         $purchase->set_totalAmount($row["TotalAmt"]);

  //         $purchase->set_purchaseddate($row["PurchasedDate"]);
//         array_push($purchaseList, $purchase);
//       }
//     }
//     return $purchaseList;
//   }

  public static function GetPurchaseOrderBasedOnId($purchase)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    case When PO.ProjectId = 0 Then 
    'General'
    else 'Project Based'
    end  as POtype,
    PO.Id AS Id,
    PO.POcode as POcode,
    PO.ProjectId as ProjectId,
    PO.PurchasedDate as PurchasedDate,
    PO.SupplierId AS SupplierId, 
    CO.item_compname AS SupplierName,
    CO.item_compAddress AS SupplierAddress,
    SUM(PLI.TotalAmt) AS TotalAmt,
    (TEMP.PaidAmt) AS PaidAmt,
    TEMP.PaymentMode AS PaymentMode,
    (TEMPSTOCK.TotalQty) AS TotalQuantity,
    (TEMPSTOCK.ReceivedQty) AS TotalReceivedQty,
    PLI.Price AS Price
    FROM `purchase_order` AS PO
    JOIN `purchaseorder_lineitem` PLI oN PLI.POID=PO.Id
    LEFT JOIN (SELECT 
	POID ,
    SUM(received_amount)As PaidAmt,
    payment_mode as PaymentMode
    from supplierpaymentinfo 
    group by POID) AS TEMP ON TEMP.POID=PO.Id 
    JOIN `item_companydetails` CO ON CO.item_compid=PO.SupplierId 
    LEFT JOIN (SELECT 
	  POID ,
    SUM(ReceivedQty)As ReceivedQty,
   (quantity)As TotalQty
    from item_stock 
    group by POID) AS TEMPSTOCK ON TEMPSTOCK.POID=PO.ID  
    where PO.Id='" . $purchase . "'
    ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $purchase = new PurchaseOrder();
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $purchase->setPOtype($row["POtype"]);
        $purchase->set_projectId($row["ProjectId"]);
        $purchase->set_Id($row["Id"]);
        $purchase->setPOcode($row["POcode"]);
        $purchase->setpaymentmode($row["PaymentMode"]);
        $purchase->set_supplier($row["SupplierId"]);
        $purchase->setSupplierName($row["SupplierName"]);
        $purchase->setSupplierAddress($row["SupplierAddress"]);
        $purchase->set_totalAmount($row["TotalAmt"]);
        $purchase->set_paidAmount($row["PaidAmt"]);
        $purchase->set_purchaseddate($row["PurchasedDate"]);
        $purchase->setTotalQuantity($row["TotalQuantity"]);
        $purchase->setTotalReceivedQty($row["TotalReceivedQty"]);

      }
    }
    return $purchase;
  }

  public static function getPurchasesForPrint($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT
    P.Id AS Id,
    P.Item_id AS ItemId,
    PO.TotalAmt as TotalAmt,
    P.POcode as POcode,
    P.PurchasedDate as PurchasedDate,
    P.SupplierId AS SupplierId, 
    CO.item_compname AS SupplierName,
    CO.item_compAddress AS SupplierAddress,
    CO.item_compContactName As SupplierContactName,
    CO.item_compContactNumber As SupplierContactNumber,
    I.item_name AS Name,
    I.item_unit As Unitid,
    I.item_ArticleNo as ArticleNo,
    I.item_description AS Description,
    PO.POID as Purchaseid,
    PO.Quantity as Quantity,
    U.unitName as UnitName
    FROM `purchase_order` AS P
    JOIN `item_companydetails` CO ON CO.item_compid=P.SupplierId 
    JOIN `item_details`  I ON I.item_id =P.Item_id
    JOIN `purchaseorder_lineitem`  PO ON PO.POID =P.Id
    JOIN `units`  U  ON U.unitId =I.item_unit
    WHERE P.Id=" . $id;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    error_log($sql);
    $purchaseList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $purchase = new PurchaseOrder();
        $purchase->set_Id($row["Id"]);
        $purchase->setPOcode($row["POcode"]);
        $purchase->setName($row["Name"]);
        $purchase->setSupplierName($row["SupplierName"]);
        $purchase->setArticleNo($row["ArticleNo"]);
        $purchase->setDescription($row["Description"]);
        $purchase->setSupplierAddress($row["SupplierAddress"]);

        $purchase->setQuantity($row["Quantity"]);
        $purchase->set_itemId($row["ItemId"]);
        $purchase->set_purchaseddate($row["PurchasedDate"]);
        $purchase->set_totalAmount($row["TotalAmt"]);
        $purchase->setUnitName($row["UnitName"]);


        array_push($purchaseList, $purchase);
      }
    }
    return $purchaseList;
  }



  public static function selectCompany($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT item_compName FROM item_companydetails where item_compid=$id";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Companydetails();
        $view->set_itemcompname($row['item_compName']);

      }
    } else {
      // echo "0 results";
    }
    return $view;
  }

  public static function update($purchaseObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE purchase_order SET 
        Quantity='" . $purchaseObj->get_quantity() .
      "', Price='" . $purchaseObj->get_price() .
      "', TotalAmt='" . $purchaseObj->get_totalamt() .
      "', POID='" . $purchaseObj->get_POID() .
      "' WHERE Id=" . $purchaseObj->get_Id();
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }


  public static function updateFileName($purchaseObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE purchase_order SET ";

    $sql .= "purchasePDFName='" . $purchaseObj->get_purchasePDFName();

    //  $sql.= "', modifiedby='" . $purchaseObj->get_modifiedby() .
    "' WHERE Id=" . $purchaseObj->get_Id();
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function cancel($purchaseId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE purchase_order SET Status=1 WHERE Id=" . $purchaseId;
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function resume($purchaseId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE purchase_order SET Status=0 WHERE Id=" . $purchaseId;
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function delete($purchaseId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE FROM purchase_order WHERE Id=" . $purchaseId;
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
      $sql = "DELETE FROM supplierpaymentinfo WHERE POID=" . $purchaseId;
      error_log($sql);
      if ($connectionObj->query($sql) === TRUE) {
        $sql = "DELETE FROM item_stock WHERE POID=" . $purchaseId;
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
          $sql = "DELETE FROM purchaseorder_lineitem WHERE POID=" . $purchaseId;
          error_log($sql);
          if ($connectionObj->query($sql) === TRUE) {

          } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
          }

        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }

      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

}