<?php
  require_once "../DB Operations/dbconnection.php";
  require_once "../Model/material_stocksModel.php";


class DBMaterialStock
{
    public static function insert($itemstockObj)
    {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "insert into material_stock (`Material_Id`,`POID`, `Quantity`,`Unit`,`Price`,`TotalAmount`,`GST`,`InvoiceNo`,`ReceivedQtyAmt`,`ReceivedQty`,`BalanceQty`) 
        values ('".$itemstockObj->get_MaterialId()."',
        
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
    ;
                
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
        error_log($sql);
    }

    public static function getMaterialStockList()
    {
      $db=ConnectDb::getInstance();
      $connectionObj=$db->getConnection();
      $sql = "SELECT M.Material_Id as MaterialId,
      S.item_stockid  as Materialstockid,
      S.POID as POID,
      P.POcode as POcode,
      M.Material_Name as MaterialName,
      S.InvoiceNo as InvoiceNo,
      F.followup_materialId AS FollowupMaterialId,
      F.followup_Id  as followupId,
      F.Status as Status,
      F.followup_comments as Issues
       FROM materialissues_followup  F
      left Join `item_stock` S on F.followup_materialId=S.item_id
       Join `material` M on M.Material_Id=S.item_id
       Join `purchase_order` P on P.Id=S.POID
     Group by MaterialName";
      $result = $connectionObj->query($sql);
      $count = mysqli_num_rows($result);
      $stockList=[];
      if ($count>0) 
      {
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view=new Material_Stock();
        $view->set_MaterialId($row['MaterialId']);
        $view->setfollowupId($row["followupId"]);
        $view->set_StockId($row['Materialstockid']);
        $view->set_InvoiceNo($row['InvoiceNo']);
        $view->set_followupStatus($row['Status']);
        $view->set_POID($row['POID']);
        $view->setMaterialname($row["MaterialName"]);
        $view->setPOcode($row["POcode"]);
        $view->setFollowupMaterialId($row["FollowupMaterialId"]);
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
      $sql= "insert into material_stock (`Material_Id`,`POID`, `Quantity`,`Unit`,`Price`,`TotalAmount`,`GST`,`InvoiceNo`,`ReceivedQtyAmt`,`ReceivedQty`,`BalanceQty`) 
      values ('".$stockObj->get_MaterialId()."',
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
  
      
if ($connectionObj->query($sql) === true) {
} else {
  echo "Error: " . $sql . "<br>" . $connectionObj->error;
}
error_log($sql);
    }

    public static function updateFileName($stockObj)
    {
      $db = ConnectDb::getInstance();
      $connectionObj = $db->getConnection();
      $sql = "UPDATE Material_Stock SET ";
    
        $sql.="stockPDFName='".$stockObj->get_stockPDFName();
  
      //  $sql.= "', modifiedby='" . $purchaseObj->get_modifiedby() .
        "' WHERE Material_stockid id=" . $stockObj->get_StockId();
        error_log($sql);
      if ($connectionObj->query($sql) === TRUE) {
      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }
    }
  

    public static function getallMaterialstocks()
    {
      $db = ConnectDb::getInstance();
      $connectionObj = $db->getConnection();
      $sql = "SELECT 
        -- M.item_id AS ItemId,
        M.Material_Name AS MaterialName,
        M.Material_Description AS MaterialDescription,
        M.Category AS CategoryId,
        C.material_catName AS CategoryName,
        M.SubCategory AS SubCategoryId,
        SC.material_subcatName AS SubCategoryName,
        sum(MS.Quantity) As Quantity,
        sum(MS.TotalAmount) As TotalAmount
        FROM Material_Stock S
        JOIN `material` AS M ON MS.Material_Id=M.Material_Id  
        JOIN material_category C ON M.Category=C.material_catId 
        JOIN material_subcategory SC ON M.SubCategory=SC.material_subcatId
        Group By
        MaterialName,
        MaterialDescription";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $itemstockdetailslist = [];
        if ($count > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $view = new Material_Stock();
          $view->setMaterialname($row['MaterialName']);
          $view->setMaterialdescription($row["MaterialDescription"]);
          // $view->setitemsubcatid($row["SubCategoryId"]);
          // $view->setitemcatid($row["CategoryId"]);
          $view->setMaterialcatname($row["CategoryName"]);
          $view->setMaterialsubcatname($row["SubCategoryName"]);
          $view->set_quantity($row["Quantity"]);
          $view->set_totalamt($row["TotalAmount"]);
          array_push($itemstockdetailslist, $view);
        }
      } else {
        // echo "0 results";
      }
  
      return $itemstockdetailslist;
    }
  

    public static function getallMaterialsWithHighPrices()
    {
      $db = ConnectDb::getInstance();
      $connectionObj = $db->getConnection();
      $sql = "SELECT 
      M.Material_Id AS MaterialId,
      M.Material_Name AS MaterialName,
        M.Material_Description AS MaterialDescription,
        M.Category AS CategoryId,
        C.material_catName AS CategoryName,
        M.SubCategory AS SubCategoryId,
        SC.material_subcatName AS SubCategoryName,
      (S.Quantity) As Quantity,
      (S.ReceivedQtyAmt) As ReceivedQtyAmt,
      P.POcode as POcode,
      IC.item_compName as SupplierName,
      S.InvoiceNo as 	InvoiceNo,
      MP.Status as Status,
      MP.PricingIssues_Id as PricingIssues_Id,
      M.Mat_MRP as MRP,
      S.Price as Price,
      PLI.Price as LineMaterialPrice
      FROM item_stock S
      JOIN `material` AS M ON S.item_id=M.Material_Id 
      JOIN material_category C ON M.Category=C.material_catId 
      JOIN material_subcategory SC ON M.SubCategory=SC.material_subcatId
      Join purchase_order P on P.Id=S.POID
      Join purchaseorder_lineitem PLI on PLI.POID=P.Id
      LEFT JOIN material_pricingissues MP on MP.MaterialName=M.Material_Name
      Join item_companydetails IC on IC.item_compid=P.SupplierId
      WHERE S.ReceivedQtyAmt > S.Price 
      Group By
      MaterialName,
      MaterialDescription";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $MaterialList = [];
        if ($count > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $view = new Material_Stock();
          $view->set_MaterialId($row['MaterialId']);
          $view->setPricingIssues_Id($row['PricingIssues_Id']);
          $view->setMaterialname($row['MaterialName']);
          $view->setMaterialdescription($row["MaterialDescription"]);
          // $view->setitemsubcatid($row["SubCategoryId"]);
          // $view->setitemcatid($row["CategoryId"]);
          $view->setMaterialcatname($row["CategoryName"]);
          $view->setMaterialsubcatname($row["SubCategoryName"]);
          $view->set_quantity($row["Quantity"]);
          // $view->set_totalamt($row["TotalAmount"]);
          $view->set_InvoiceNo($row["InvoiceNo"]);
          $view->set_SupplierName($row["SupplierName"]);
          $view->set_ReceivedQtyAmt($row["ReceivedQtyAmt"]);
          $view->set_price($row["MRP"]);
          $view->set_LineMaterialPrice($row["LineMaterialPrice"]);
          $view->setPOcode($row["POcode"]);
          $view->setStatus($row["Status"]);
          array_push($MaterialList, $view);
        }
      } else {
        // echo "0 results";
      }
  
      return $MaterialList;
    }



    public static function viewinwarddetailsbasedonID($viewObj,$PurchaseId)
    {
       $db=ConnectDb::getInstance();
       $connectionObj=$db->getConnection();
       $sql = "select modifiedOn,Material_stockid ,POID,ReceivedQtyAmt,ReceivedQty,InvoiceNo,Price from material_stock where POID='$PurchaseId' and Material_Id='$viewObj' Order by ReceivedQtyAmt DESC";
       $result = mysqli_query($db->getConnection(), $sql);
       error_log($sql);
       $inwarddetails=[];
       if (mysqli_num_rows($result) > 0) {
           while ($row = mysqli_fetch_assoc($result)) {
               $view= new Material_Stock();
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
    public static function viewinwarddetails($MatId)
    {
       $db=ConnectDb::getInstance();
       $connectionObj=$db->getConnection();
       $sql = "select modifiedOn,Material_stockid ,POID,ReceivedQtyAmt,ReceivedQty,InvoiceNo,Price from material_stock where Material_Id='$ItemId'  Order by ReceivedQtyAmt DESC";
       $result = mysqli_query($db->getConnection(), $sql);
       error_log($sql);
       $inwarddetails=[];
       if (mysqli_num_rows($result) > 0) {
           while ($row = mysqli_fetch_assoc($result)) {
               $view= new Material_Stock();
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
      $sql="DELETE from material_stock where Material_stockid ='".$stockObj."'";
      if ($connectionObj->query($sql) === TRUE) {
      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }

    }

}