<?php
require_once "../Model/paymentmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../Utilities/Helper.php";
//require "../Admin/navbar.php";
require_once "../DB Operations/paymentOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $admit=new Payment();
    $admit->set_custid(Sanitization::test_input($_POST["custid"]));
    $admit->set_paymentid(Sanitization::test_input($_POST["paymentid"]));
    $admit->set_custname(Sanitization::test_input($_POST["custname"]));
    $admit->set_custcontactnumber(Sanitization::test_input($_POST["custcontactno"]));
    $admit->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
    $admit->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
    $admit->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
    $admit->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));
    $admit->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
    $admit->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
    $admit->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
    $admit->set_RTGSno(Sanitization::test_input($_POST["RTGSno"]));
    if (isset($_POST["duedate"])){
      $admit->set_duedate(Sanitization::test_input($_POST["duedate"]));
    }else{
      $admit->set_duedate(NULL); 
    }
    if (isset($_POST["chequeimg"])) {
        $filetoupload=$_FILES["chequeimg"];
        Helper::fileupload($filetoupload, "../../img/paymentimages/");
    }
    // $filename="". $admit->get_custname().date("Y-m-d").".pdf";
    // $admit->set_paymentreceipt($filename);
    DBpayment::insert($admit);
    // $receipt=DBpayment::paymentcollection( $admit->get_custid());
    // Helper::paymentreceipt($receipt);
    

  }

  // function Pendingfees($tfees,$pfees){
  //   $pendingfees=$pendingfees-$pfees;
  //   return $pendingfees;
  //  }
?>
<html>

    <head>
        <title> New Admission </title>
    </head>

    <body>
        <?php 
        //  header("location:../View/fees.php");
?>


    </body>

</html>