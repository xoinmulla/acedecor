<?php
require_once "../Model/supplierpaymentmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../Utilities/Helper.php";
//require "../Admin/navbar.php";
require_once "../DB Operations/supplierpaymentOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(isset($_POST["paidamt"])==0){
      $supplier=new SupplierPayment();
      $supplier->set_supplierId(Sanitization::test_input($_POST["supplierId"]));
      $supplier->set_supplierpaymentId(Sanitization::test_input($_POST["supplierpaymentId"]));
      $supplier->setPOID(Sanitization::test_input($_POST["POID"]));
      $supplier->set_suppliername(Sanitization::test_input($_POST["suppliername"]));
      $supplier->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
      $supplier->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
      $supplier->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
      $supplier->set_receivedamt(Sanitization::test_input($_POST["receivedamt"]));
      $supplier->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));
      $supplier->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
      $supplier->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
      $supplier->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
      $supplier->set_RTGSno(Sanitization::test_input($_POST["RTGSno"]));
      if (isset($_POST["duedate"])){
        $supplier->set_duedate(Sanitization::test_input($_POST["duedate"]));
      }else{
        $supplier->set_duedate(NULL); 
      }
      if (isset($_POST["chequeimg"])) {
          $filetoupload=$_FILES["chequeimg"];
          Helper::fileupload($filetoupload, "../../img/paymentimages/");
      }
      DBsupplierpayment::update($supplier);
  
    }
    $supplier=new SupplierPayment();
    $supplier->set_supplierId(Sanitization::test_input($_POST["supplierId"]));
    // $supplier->set_supplierpaymentId(Sanitization::test_input($_POST["supplierpaymentId"]));
    $supplier->setPOID(Sanitization::test_input($_POST["POID"]));
    $supplier->set_suppliername(Sanitization::test_input($_POST["suppliername"]));
    $supplier->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
    $supplier->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
    $supplier->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
    $supplier->set_receivedamt(Sanitization::test_input($_POST["receivedamt"]));
    $supplier->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));
    $supplier->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
    $supplier->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
    $supplier->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
    $supplier->set_RTGSno(Sanitization::test_input($_POST["RTGSno"]));
    if (isset($_POST["duedate"])){
      $supplier->set_duedate(Sanitization::test_input($_POST["duedate"]));
    }else{
      $supplier->set_duedate(NULL); 
    }
    if (isset($_POST["chequeimg"])) {
        $filetoupload=$_FILES["chequeimg"];
        Helper::fileupload($filetoupload, "../../img/paymentimages/");
    }
    DBsupplierpayment::insertagain($supplier);

    header("location:../View/supplierpaymentView.php");
  }

  if($_SERVER["REQUEST_METHOD"] == "GET"){
    $PurchaseId=Sanitization::test_input($_GET["POID"]);
    DBsupplierpayment::viewtransactiondetails($_GET["id"],$PurchaseId);
  }
?>
