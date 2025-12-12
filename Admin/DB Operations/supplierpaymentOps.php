<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once("../Model/supplierpaymentmodel.php");


    class DBsupplierpayment
    {
      public static function insert($payObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="SELECT * from supplierpaymentinfo where supplierId='".$payObj->get_supplierId()."' and POID='".$payObj->getPOID()."'";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        error_log($count);
        if ($count < 1) {
     
        if($payObj->get_duedate()==""){
          $sql = "insert into supplierpaymentinfo (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`modified_by`) 
                values ('".$payObj->get_supplierId()."','".$payObj->getPOID()."','".$payObj->get_totalamt()."','".$payObj->get_paidamt()."','".$payObj->get_receivedamt()."','".$payObj->get_pendingamt()."','".$payObj->get_paymentplan()."','".$payObj->get_paymentmode()."','".$payObj->get_paymentdescription()."','".$payObj->get_RTGSno()."','".$payObj->get_chequeimg()."','".$payObj->get_modifiedby()."')";
                
        }else {
         $sql = "insert into  supplierpaymentinfo   (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`due_date`,`modified_by`) 
         values ('".$payObj->get_supplierId()."','".$payObj->getPOID()."','".$payObj->get_totalamt()."','".$payObj->get_paidamt()."','".$payObj->get_receivedamt()."','".$payObj->get_pendingamt()."','".$payObj->get_paymentplan()."','".$payObj->get_paymentmode()."','".$payObj->get_paymentdescription()."','".$payObj->get_RTGSno()."','".$payObj->get_chequeimg()."','".$payObj->get_duedate()."','".$payObj->get_modifiedby()."')";
        }    
                if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      } else {
        echo "Payment record already exist";
      }
      error_log($sql);
        
    }
    public static function insertagain($payObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();

        if($payObj->get_duedate()==""){
          $sql = "insert into supplierpaymentinfo (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`modified_by`) 
                values ('".$payObj->get_supplierId()."','".$payObj->getPOID()."','".$payObj->get_totalamt()."','".$payObj->get_paidamt()."','".$payObj->get_receivedamt()."','".$payObj->get_pendingamt()."','".$payObj->get_paymentplan()."','".$payObj->get_paymentmode()."','".$payObj->get_paymentdescription()."','".$payObj->get_RTGSno()."','".$payObj->get_chequeimg()."','".$payObj->get_modifiedby()."')";
                
        }else {
         $sql = "insert into  supplierpaymentinfo   (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`due_date`,`modified_by`) 
         values ('".$payObj->get_supplierId()."','".$payObj->getPOID()."','".$payObj->get_totalamt()."','".$payObj->get_paidamt()."','".$payObj->get_receivedamt()."','".$payObj->get_pendingamt()."','".$payObj->get_paymentplan()."','".$payObj->get_paymentmode()."','".$payObj->get_paymentdescription()."','".$payObj->get_RTGSno()."','".$payObj->get_chequeimg()."','".$payObj->get_duedate()."','".$payObj->get_modifiedby()."')";
        }    
                if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }

      error_log($sql);
        
      }

     

      public static function getAllsupplierpayment()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT 
        S.item_compName as SupplierName,
        S.item_compid as SupplierId,
        S.item_compAddress as SupplierAddress,
        P.Id as POID,
        P.POcode as POCode,
        Sum(PLI.TotalAmt) as TotalAmt,
        -- SP.total_amount as TotalAmt,
        TEMP.PaidAmt as PaidAmt,
        TEMP.ReceivedAmt as ReceivedAmt,
        TEMP.PaymentId as PaymentId,
        TEMP.PendingAmt as PendingAmt
        FROM item_companydetails as S

       LEFT JOIN (SELECT 
	      POID ,
        SUM(received_amount)As ReceivedAmt,
        supplierpaymentId as PaymentId,
        Sum(paid_amount) as PaidAmt,
        supplierId as supplierId,
        pending_amount as PendingAmt
        from supplierpaymentinfo 
        group by POID) AS TEMP ON TEMP.supplierId =S.item_compid 
        JOIN `purchase_order` P on P.Id=TEMP.POID
       JOIN `purchaseorder_lineitem` PLI on PLI.POID=P.Id
       where PLI.TotalAmt!=''
       GROUP BY POID
  
        ";
error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $supplierList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $supplier = new SupplierPayment();
                $supplier->set_supplierId($row['SupplierId']);
                $supplier->set_suppliername($row['SupplierName']);
                $supplier->set_supplierpaymentId($row['PaymentId']);
                $supplier->setPOID($row['POID']);
                $supplier->setPOCode($row['POCode']);
                $supplier->set_supplierAddress($row['SupplierAddress']);
                $supplier->set_totalamt($row['TotalAmt']);
                $supplier->set_pendingamt($row['TotalAmt']-$row['ReceivedAmt']);
                $supplier->set_paidamt($row['TotalAmt']-$row['PendingAmt']);
                $supplier->set_receivedamt($row['ReceivedAmt']);
                array_push($supplierList, $supplier);
            }
        } else {
            // echo "0 results";
        }
        return $supplierList;
    }

    public static function paymentcollection($viewObj)
    {
      $db=ConnectDb::getInstance();
      $connectionObj=$db->getConnection();
      
         $sql="Select C.customerId,C.customerContactNumber, customerName,total_amount, SUM(paid_amount) as paid_amount from customer as C 
         LEFT JOIN paymentinfo as P on C.customerId=P.customer_id
          where C.customerId=(".$viewObj.")
          GROUP BY customer_name,total_amount";

          $view= new Payment();
          $result=mysqli_query($db->getConnection(), $sql);
          if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
              $view->set_custcontactnumber($row['customerContactNumber']);
              $view->set_totalamt($row['total_amount']);
              $view->set_custid($row['customerId']);
              $view->set_paidamt($row['paid_amount']);
              $view->set_custname($row['customerName']);
              $view->set_pendingamt($row['total_amount']-$row["paid_amount"]);
              
            }
          }else {
            $view=NULL;
          }
          return $view;
  
        }
        
        public static function viewtransactiondetails($viewObj,$PurchaseId)
       {
          $db=ConnectDb::getInstance();
          $connectionObj=$db->getConnection();
          $sql = "select modifieddate,supplierpaymentId,supplierId,received_amount,pending_amount,payment_mode from supplierpaymentinfo where supplierId='$viewObj' and POID='$PurchaseId'";
          $result = mysqli_query($db->getConnection(), $sql);
          error_log($sql);
          $suppliertransactiondetails=[];
          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $view= new SupplierPayment();
                  $view->set_modifieddate(date('m/d/Y',strtotime($row['modifieddate'])));
                  $view->set_receivedamt($row['received_amount']);
                  $view->set_pendingamt($row['pending_amount']);
                  $view->set_paymentmode($row['payment_mode']);
                  $view->set_supplierId($row['supplierId']);
                  // $view->set_paymentreceipt($row['paymentreceipt']);
                  array_push($suppliertransactiondetails, $view);
              }
          }
         else {
            echo "No entries ";
         } 
         header('Content-Type: application/json');
         echo json_encode($suppliertransactiondetails);
        
       }
      
       public static function updateFileName($transactionObj)
       {
         $db = ConnectDb::getInstance();
         $connectionObj = $db->getConnection();
         $sql = "UPDATE supplierpaymentinfo SET ";
       
           $sql.="paymentPDFName='".$transactionObj->get_paymentPDFName();
     
         //  $sql.= "', modifiedby='" . $purchaseObj->get_modifiedby() .
           "' WHERE Id=" . $transactionObj->get_supplierId();
           error_log($sql);
         if ($connectionObj->query($sql) === TRUE) {
         } else {
           echo "Error: " . $sql . "<br>" . $connectionObj->error;
         }
       }
     
       public static function update($purchaseObj)
       {
         $db = ConnectDb::getInstance();
         $connectionObj = $db->getConnection();
         $sql = "UPDATE supplierpaymentinfo SET 
            total_amount='".$purchaseObj->get_totalamt().
             "', pending_amount='".$purchaseObj->get_pendingamt().
             "', paid_amount='".$purchaseObj->get_paidamt().
             "', received_amount='".$purchaseObj->get_receivedamt().
             "', payment_mode='".$purchaseObj->get_paymentmode().
           "' WHERE supplierId=" . $purchaseObj->get_supplierId()." and POID=". $purchaseObj->getPOID();
           error_log($sql);
         if ($connectionObj->query($sql) === TRUE) {
         } else {
           echo "Error: " . $sql . "<br>" . $connectionObj->error;
         }
       }
     
   }