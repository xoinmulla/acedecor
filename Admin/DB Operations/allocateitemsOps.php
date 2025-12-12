<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/allocateitemsModel.php";
require_once "../Model/quoteLineItemModel.php";
class DBallocate
    {
      public static function insert($allocateObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "INSERT INTO itemallocation (`item_stockId`, `ProjectId`, `itemId`,`InputName`,`AllocatedQty`) 
                values ('".$allocateObj->get_itemstockId().
                "','".$allocateObj->get_ProjectId().
                "','".$allocateObj->get_itemId().
                "','".$allocateObj->getItemName().
                "','".$allocateObj->get_AllocatedQty()."')";
                error_log( $sql );
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }
      
      public static function getLineItemByProjectId($projectId){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql ="SELECT 
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
        JOIN `quotation_details` AS Q ON QLI.quoteId=Q.quoid 
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
        group by Name,ItemId";
      
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);

        $itemList=[];
        if($count>0){
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $item=new lineItem();
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
            $item->set_itemid($row["ItemId"]);
            $item->setStockId($row["StockId"]);
            $item->setAllocatedStatus($row["AllocatedStatus"]);
            array_push($itemList,$item);
          }
        }
       return $itemList;
      }

      public static function getMaterialLineItemByProjectId($projectId){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql ="SELECT 
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
        JOIN `quotation_details` AS Q ON QLI.quoteId=Q.quoid 
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
         where PR.projectId=".$projectId."
        group by Name,ItemId";
      
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);

        $MatList=[];
        if($count>0){
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $item=new lineItem();
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
            $item->set_itemid($row["ItemId"]);
            $item->setStockId($row["StockId"]);
            $item->setAllocatedStatus($row["AllocatedStatus"]);
            array_push($MatList,$item);
          }
        }
       return $MatList;
      } 
      

      public static function getAllocatedItemInfo($ItemId)
      {
          $db = ConnectDb::getInstance();
          $connectionObj = $db->getConnection();
          $sql= "SELECT A.ItemId as ItemId,
          A.ProjectId as ProjectId,
          A.AllocatedQty as AllocatedQty,
          P.projectId as ProjectId,
          P.customerName as customerName,
          P.projectCode as ProjectCode,
          S.item_stockid as StockId,
          PO.ProjectId as POProjectId,
          PO.POcode as POcode,
          I.item_name as ItemName
           FROM itemallocation as A
           JOIN projects P on P.projectId=A.ProjectId
           LEFT JOIN item_stock S on S.item_stockid=A.item_stockId
           LEFT JOIN purchase_order PO on PO.ProjectId=P.projectId
           JOIN item_details as I on A.InputName=I.item_name
            WHERE ItemId=$ItemId 
            UNION
            SELECT A.ItemId as ItemId,
          A.ProjectId as ProjectId,
          A.AllocatedQty as AllocatedQty,
          P.projectId as ProjectId,
          P.customerName as customerName,
          P.projectCode as ProjectCode,
          S.item_stockid as StockId,
          PO.ProjectId as POProjectId,
          PO.POcode as POcode,
          M.Material_Name as ItemName
           FROM itemallocation as A
           JOIN projects P on P.projectId=A.ProjectId
           LEFT JOIN item_stock S on S.item_stockid=A.item_stockId
           LEFT JOIN purchase_order PO on PO.ProjectId=P.projectId
           LEFT JOIN material as M on A.ItemId=M.Material_Id 
            WHERE ItemId=$ItemId ";
          error_log($sql);
          $result = $connectionObj->query($sql);
          $AllocationList = [];
          if (mysqli_num_rows($result) > 0) {
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
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "DELETE FROM itemallocation where ItemId=".$allocateObj->get_itemId()." and ProjectId=".$allocateObj->get_ProjectId()." ";
                error_log( $sql );
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }

  }
