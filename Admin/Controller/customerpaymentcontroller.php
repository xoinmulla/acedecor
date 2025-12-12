<?php
require_once "../Model/customerpaymentmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../Utilities/Helper.php";
//require "../Admin/navbar.php";
require_once "../DB Operations/customerpaymentOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == 'credit') {
        $admit=new Payment();
        $admit->set_paymentid(Sanitization::test_input($_POST['id']));
        $admit->set_creditdiscount(Sanitization::test_input($_POST["paidAmount"]));
        DBpayment::creditdiscount($admit);
      }
      else if (isset($_POST["paidamt"]) == 0) {
        $admit=new Payment();
        $admit->setQuoteCode(Sanitization::test_input($_POST["quoteid"])); 
        $admit->set_custid(Sanitization::test_input($_POST["custid"]));
        $admit->set_paymentid(Sanitization::test_input($_POST["paymentid"]));
        $admit->set_custname(Sanitization::test_input($_POST["custname"]));
        $admit->set_custcontactnumber(Sanitization::test_input($_POST["custcontactno"]));
        $admit->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
        $admit->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
        $admit->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
        $admit->set_receivedamt(Sanitization::test_input($_POST["receivedamt"]));
        $admit->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));
        $admit->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
        $admit->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
        $admit->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
        $admit->set_RTGSno(Sanitization::test_input($_POST["RTGSno"]));
        if (isset($_POST["duedate"])) {
            $admit->set_duedate(Sanitization::test_input($_POST["duedate"]));
        } else {
            $admit->set_duedate(null);
        }
        if (isset($_POST["chequeimg"])) {
            $filetoupload=$_FILES["chequeimg"];
            Helper::fileupload($filetoupload, "../../img/paymentimages/");
        }
        DBpayment::insert($admit);
    } 
      else {
          $admit=new Payment();
          $admit->setQuoteCode(Sanitization::test_input($_POST["quoteid"])); 
          $admit->set_custid(Sanitization::test_input($_POST["custid"]));
          $admit->set_paymentid(Sanitization::test_input($_POST["paymentid"]));
          $admit->set_custname(Sanitization::test_input($_POST["custname"]));
          $admit->set_custcontactnumber(Sanitization::test_input($_POST["custcontactno"]));
          $admit->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
          $admit->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
          $admit->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
          $admit->set_receivedamt(Sanitization::test_input($_POST["receivedamt"]));
          $admit->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));
          $admit->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
          $admit->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
          $admit->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
          $admit->set_RTGSno(Sanitization::test_input($_POST["RTGSno"]));
          if (isset($_POST["duedate"])) {
              $admit->set_duedate(Sanitization::test_input($_POST["duedate"]));
          } else {
              $admit->set_duedate(null);
          }
          if (isset($_POST["chequeimg"])) {
              $filetoupload=$_FILES["chequeimg"];
              Helper::fileupload($filetoupload, "../../img/paymentimages/");
          }
          DBpayment::update($admit);
      }
      header("location:../View/customerpaymentView.php");
  }
        
   
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        DBpayment::viewtransactiondetails($_GET["id"]);
      }
      ?>