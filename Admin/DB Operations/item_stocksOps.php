<?php
  require_once "../DB Operations/dbconnection.php";
  require_once "../Model/item_stocksmodel.php";


class DBitemstock
{
    public static function insert($itemstockObj)
    {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "insert into item_stock (`item_id`,`ItemCode`,`ItemName`,`POID`, `Quantity`,`Unit`,`Price`,`TotalAmount`,`GST`,`InvoiceNo`,`ReceivedQtyAmt`,`ReceivedQty`,`BalanceQty`) 
        values ('".$itemstockObj->get_itemid()."',
        '".$itemstockObj->getItemCode()."',
        '".$itemstockObj->getItemname()."',
        '".$itemstockObj->get_POID()."',
        '".$itemstockObj->get_quantity()."',
        '".$itemstockObj->get_unit()."',
        '".$itemstockObj->get_price()."',
        '".$itemstockObj->get_totalamt()."',
        '".$itemstockObj->get_GST()."',
        '".$itemstockObj->get_InvoiceNo()."',
        '".$itemstockObj->get_ReceivedQtyAmt()."',
        '".$itemstockObj->get_ReceivedQty()."',
        '".$itemstockObj->get_BalanceQty()."')";
        error_log($sql);
                
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
        
    }

    public static function getStockList()
    {
      $db=ConnectDb::getInstance();
      $connectionObj=$db->getConnection();
      $sql = "SELECT I.item_id as ItemId,
      I.item_stockid as ItemStockId,
      I.POID as POID,
      P.POcode as POcode,
      IT.item_name as ItemName,
      I.InvoiceNo as InvoiceNo,
      F.followup_itemid AS FollowupItemId,
      F.followupId as followupId,
      F.Status as Status,
      F.followup_comments as Issues
       FROM itemissues_followup  F
      left Join `item_stock` I on F.followup_itemid=I.item_id
       Join `item_details` IT on IT.item_id=I.item_id
       Join `purchase_order` P on P.Id=I.POID
 Group by ItemName  ";
      $result = $connectionObj->query($sql);
      $count = mysqli_num_rows($result);
      $stockList=[];
      if ($count>0) 
      {
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view=new Item_Stock();
        $view->set_itemid($row['ItemId']);
        $view->setfollowupId($row["followupId"]);
        $view->set_StockId($row['ItemStockId']);
        $view->set_InvoiceNo($row['InvoiceNo']);
        $view->set_followupStatus($row['Status']);
        $view->set_POID($row['POID']);
        $view->setItemname($row["ItemName"]);
        $view->setPOcode($row["POcode"]);
        $view->setFollowupItemId($row["FollowupItemId"]);
        $view->setFollowupIssues($row["Issues"]);

        array_push($stockList,$view);
      }
      } else {
      // echo "0 results";
    }
    
    return $stockList;

    }

    public static function update($stockObj){
      $db=ConnectDb::getInstance();
      $connectionObj=$db->getConnection();
      $sql= "insert into item_stock (`item_id`,`ItemCode`,`Itemname`,`POID`, `Quantity`,`Unit`,`Price`,`TotalAmount`,`GST`,`InvoiceNo`,`ReceivedQtyAmt`,`ReceivedQty`,`BalanceQty`) 
      values ('".$stockObj->get_itemid()."',
      '".$stockObj->getItemCode()."',
      '".$stockObj->getItemname()."',
      '".$stockObj->get_POID()."',
      '".$stockObj->get_quantity()."',
      '".$stockObj->get_unit()."',
      '".$stockObj->get_price()."',
      '".$stockObj->get_totalamt()."',
      '".$stockObj->get_GST()."',
      '".$stockObj->get_InvoiceNo()."',
      '".$stockObj->get_ReceivedQtyAmt()."',
      '".$stockObj->get_ReceivedQty()."',
      '".$stockObj->get_BalanceQty()."')";
      error_log($sql);
      
if ($connectionObj->query($sql) === true) {
} else {
  echo "Error: " . $sql . "<br>" . $connectionObj->error;
}

    }

    public static function updateFileName($stockObj)
    {
      $db = ConnectDb::getInstance();
      $connectionObj = $db->getConnection();
      $sql = "UPDATE item_stock SET ";
    
        $sql.="stockPDFName='".$stockObj->get_stockPDFName();
  
      //  $sql.= "', modifiedby='" . $purchaseObj->get_modifiedby() .
        "' WHERE item_stockidid=" . $stockObj->get_StockId();
        error_log($sql);
      if ($connectionObj->query($sql) === TRUE) {
      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }
    }
  

    public static function getallItemstocks()
    {
      $db = ConnectDb::getInstance();
      $connectionObj = $db->getConnection();
      $sql = "SELECT 
        -- I.item_id AS ItemId,
        I.item_name AS ItemName,
        I.item_description AS ItemDescription,
        I.item_catid AS CategoryId,
        C.item_catName AS CategoryName,
        I.item_subcatid AS SubCategoryId,
        SC.item_subcatName AS SubCategoryName,
        sum(S.Quantity) As Quantity,
        sum(S.TotalAmount) As TotalAmount
        FROM item_stock S
        JOIN `item_details` AS I ON S.Item_id=I.item_id 
        JOIN item_category C ON I.item_catid=C.item_catid 
        JOIN item_subcategory SC ON I.item_subcatid=SC.item_subcatid
        Group By
        ItemName,
        ItemDescription";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $itemstockdetailslist = [];
        if ($count > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $view = new Item_Stock();
          $view->setitemname($row['ItemName']);
          $view->setItemdescription($row["ItemDescription"]);
          // $view->setitemsubcatid($row["SubCategoryId"]);
          // $view->setitemcatid($row["CategoryId"]);
          $view->setItemcatname($row["CategoryName"]);
          $view->setItemsubcatname($row["SubCategoryName"]);
          $view->set_quantity($row["Quantity"]);
          $view->set_totalamt($row["TotalAmount"]);
          array_push($itemstockdetailslist, $view);
        }
      } else {
        // echo "0 results";
      }
  
      return $itemstockdetailslist;
    }
  

    public static function getallItemsWithHighPrices()
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
      (S.Quantity) As Quantity,
      (S.ReceivedQtyAmt) As ReceivedQtyAmt,
      P.POcode as POcode,
      IC.item_compName as SupplierName,
      S.InvoiceNo as 	InvoiceNo,
      IP.Status as Status,
      IP.PricingIssues_Id as PricingIssues_Id,
      I.item_MRP as MRP,
      S.Price as Price,
      PLI.Price as LineitemPrice
      FROM item_stock S
      JOIN `item_details` AS I ON S.Item_id=I.item_id 
      JOIN item_category C ON I.item_catid=C.item_catid 
      JOIN item_subcategory SC ON I.item_subcatid=SC.item_subcatid
      Join  purchase_order P on P.Id=S.POID
      Join purchaseorder_lineitem PLI on PLI.POID=P.Id
      LEFT JOIN item_pricingissues IP on IP.ItemName=I.item_name
      Join item_companydetails IC on IC.item_compid=P.SupplierId
      WHERE S.ReceivedQtyAmt > S.Price 
      Group By
      ItemName,
      ItemDescription ";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $ItemList = [];
        if ($count > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $view = new Item_Stock();
          $view->set_itemid($row['ItemId']);
          $view->setPricingIssues_Id($row['PricingIssues_Id']);
          $view->setitemname($row['ItemName']);
          $view->setItemdescription($row["ItemDescription"]);
          // $view->setitemsubcatid($row["SubCategoryId"]);
          // $view->setitemcatid($row["CategoryId"]);
          $view->setItemcatname($row["CategoryName"]);
          $view->setItemsubcatname($row["SubCategoryName"]);
          $view->set_quantity($row["Quantity"]);
          // $view->set_totalamt($row["TotalAmount"]);
          $view->set_InvoiceNo($row["InvoiceNo"]);
          $view->set_SupplierName($row["SupplierName"]);
          $view->set_ReceivedQtyAmt($row["ReceivedQtyAmt"]);
          $view->set_price($row["MRP"]);
          $view->set_LineitemPrice($row["LineitemPrice"]);
          $view->setPOcode($row["POcode"]);
          $view->setStatus($row["Status"]);
          array_push($ItemList, $view);
        }
      } else {
        // echo "0 results";
      }
  
      return $ItemList;
    }



    public static function viewinwarddetailsbasedonID($viewObj,$PurchaseId)
    {
       $db=ConnectDb::getInstance();
       $connectionObj=$db->getConnection();
       $sql = "select modifiedOn,item_stockid,POID,ReceivedQtyAmt,ReceivedQty,InvoiceNo,Price from item_stock where POID='$PurchaseId' and item_id='$viewObj' Order by ReceivedQtyAmt DESC";
       $result = mysqli_query($db->getConnection(), $sql);
       error_log($sql);
       $inwarddetails=[];
       if (mysqli_num_rows($result) > 0) {
           while ($row = mysqli_fetch_assoc($result)) {
               $view= new Item_Stock();
               $view->set_modifieddate($row['modifiedOn']);
               $view->set_price($row['Price']);
               $view->set_ReceivedQty($row['ReceivedQty']);
               $view->set_ReceivedQtyAmt($row['ReceivedQtyAmt']);
               $view->set_InvoiceNo($row['InvoiceNo']);
               
               // $view->set_paymentreceipt($row['paymentreceipt']);
               array_push($inwarddetails, $view);
           }
       }
      else {
         echo "No entries ";
      } 
      header('Content-Type: application/json');
      echo json_encode($inwarddetails);
     
    }

    public static function viewinwarddetails($ItemId)
    {
       $db=ConnectDb::getInstance();
       $connectionObj=$db->getConnection();
       $sql = "select modifiedOn,item_stockid,POID,ReceivedQtyAmt,ReceivedQty,
       InvoiceNo,Price from item_stock where item_id='$ItemId' Order by ReceivedQtyAmt DESC";
       $result = mysqli_query($db->getConnection(), $sql);
       error_log($sql);
       $inwarddetails=[];
       if (mysqli_num_rows($result) > 0) {
           while ($row = mysqli_fetch_assoc($result)) {
               $view= new Item_Stock();
               $view->set_modifieddate($row['modifiedOn']);
               $view->set_price($row['Price']);
               $view->set_ReceivedQty($row['ReceivedQty']);
               $view->set_ReceivedQtyAmt($row['ReceivedQtyAmt']);
               $view->set_InvoiceNo($row['InvoiceNo']);
               
               // $view->set_paymentreceipt($row['paymentreceipt']);
               array_push($inwarddetails, $view);
           }
       }
      else {
         echo "No entries ";
      } 
      header('Content-Type: application/json');
      echo json_encode($inwarddetails);
    }

    public static function getStockListbasedonItemCode($ItemCode)
    {
       $db=ConnectDb::getInstance();
       $connectionObj=$db->getConnection();
       $sql = "select modifiedOn,item_stockid,POID,ReceivedQtyAmt,ReceivedQty,
       InvoiceNo,Price from item_stock where  ItemCode='$ItemCode' Order by ReceivedQtyAmt DESC";
       $result = mysqli_query($db->getConnection(), $sql);
       error_log($sql);
       $inwarddetails=[];
       if (mysqli_num_rows($result) > 0) {
           while ($row = mysqli_fetch_assoc($result)) {
               $view= new Item_Stock();
               $view->set_modifieddate($row['modifiedOn']);
               $view->set_price($row['Price']);
               $view->set_ReceivedQty($row['ReceivedQty']);
               $view->set_ReceivedQtyAmt($row['ReceivedQtyAmt']);
               $view->set_InvoiceNo($row['InvoiceNo']);
               
               // $view->set_paymentreceipt($row['paymentreceipt']);
               array_push($inwarddetails, $view);
           }
       }
      else {
         echo "No entries ";
      } 
      header('Content-Type: application/json');
      echo json_encode($inwarddetails);
    }



    public static function delete($stockObj){
      $db=ConnectDb::getInstance();
      $connectionObj=$db->getConnection();
      $sql="DELETE from item_stock where item_stockid='".$stockObj."'";
      if ($connectionObj->query($sql) === TRUE) {
      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }

    }

}                                                                                                                                                                         