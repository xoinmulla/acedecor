<?php
 header('Content-Type: application/json');
require "../Model/supplierContactModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/supplierContactOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_POST['action'] == 'delete') {
        DBsupplierContact::delete($_POST['id']);
       
      } else if (isset($_POST['contactId'])){
  
        $contactInfo = new contactInfo();
        $contactInfo->setContactId(Sanitization::test_input($_POST["contactId"]));
      
        $contactInfo->setPhone(Sanitization::test_input($_POST["phone"]));
        $contactInfo->setDesignation(Sanitization::test_input($_POST["contactDesignation"]));
        $contactInfo->setEmail(Sanitization::test_input($_POST["email"]));
        $contactInfo->setName(Sanitization::test_input($_POST["contactName"]));
        $contactInfo->setCreatedby(Sanitization::test_input($_POST["itemcompcreatedby"]));
        $contactInfo->setModifiedby(Sanitization::test_input($_POST["itemcompmodifiedby"]));
        DBsupplierContact::update($contactInfo);
        
      } else {
        $contactInfo = new contactInfo();
        $contactInfo->setPhone(Sanitization::test_input($_POST["phone"]));
        $contactInfo->setDesignation(Sanitization::test_input($_POST["contactDesignation"]));
        $contactInfo->setEmail(Sanitization::test_input($_POST["email"]));
        $contactInfo->setName(Sanitization::test_input($_POST["contactName"]));
        $contactInfo->setCreatedby(Sanitization::test_input($_POST["itemcompcreatedby"]));
        $contactInfo->setModifiedby(Sanitization::test_input($_POST["itemcompmodifiedby"]));
        $contactInfo->setSupplierId(Sanitization::test_input($_POST["supplierId"]));
        DBsupplierContact::insert($contactInfo);

      }
      header("location: ../View/supplierContactView.php?id=".$_POST["supplierId"]);
}
if($_SERVER["REQUEST_METHOD"]=="GET"){
  if(isset($_GET['id'])){
    DBsupplierContact::getAllContactJson($_GET['id']);
  }
}
?>