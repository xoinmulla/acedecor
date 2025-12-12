<?php
// require "../Admin/session.php";
// require_once "../../DB Operations/dbconnection.php";
require_once "../../Admin/Model/customerModel.php";


    class DBpayment
    {
      public static function insert($payObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        if($payObj->get_duedate()==""){
          $sql = "insert into paymentinfo (`customer_id`,`customer_name`,`customer_contactnumber`, `total_amount`,`paid_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`modified_by`) 
                values ('".$payObj->get_custid()."','".$payObj->get_custname()."','".$payObj->get_custcontactnumber()."','".$payObj->get_totalamt()."','".$payObj->get_paidamt()."','".$payObj->get_pendingamt()."','".$payObj->get_paymentplan()."','".$payObj->get_paymentmode()."','".$payObj->get_paymentdescription()."','".$payObj->get_RTGSno()."','".$payObj->get_chequeimg()."','".$payObj->get_modifiedby()."')";
                
        }else {
         $sql = "insert into paymentinfo (`customer_id`,`customer_name`,`customer_contactnumber`, `total_amount`,`paid_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`due_date`,`modified_by`) 
         values ('".$payObj->get_custid()."','".$payObj->get_custname()."','".$payObj->get_custcontactnumber()."','".$payObj->get_totalamt()."','".$payObj->get_paidamt()."','".$payObj->get_pendingamt()."','".$payObj->get_paymentplan()."','".$payObj->get_paymentmode()."','".$payObj->get_paymentdescription()."','".$payObj->get_RTGSno()."','".$payObj->get_chequeimg()."','".$payObj->get_duedate()."','".$payObj->get_modifiedby()."')";
        }    
                if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      
        
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
        
        public static function viewfeesdetails($viewObj)
       {
          $db=ConnectDb::getInstance();
          $connectionObj=$db->getConnection();
          $sql = "select Modified_Date,customer_id,paid_amount,pending_amount,payment_mode,payment_receipt from paymentinfo where customer_id=$viewObj";
          $result = mysqli_query($db->getConnection(), $sql);
          $paymentdetails=[];
          if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
          $view= new Payment();
          $view->set_modifiedon($row['modifiedon']);
          $view->set_paidamt($row['paid_amount']);
          $view->set_pendingamt($row['pending_amount']);
          $view->set_paymentmode($row['payment_mode']);
          $view->set_custid($row['customer_id']);
          $view->set_paymentreceipt($row['paymentreceipt']);
         array_push($paymentdetails,$view);
        
         }    
         } else {
            echo "No entries ";
         } 
         return $paymentdetails;
       }
      
    

   }