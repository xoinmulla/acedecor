<?php
require_once "../Model/taxmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/taxOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (isset($_POST['tax_id'])) {
    $tax = new Taxinfo();
    $tax->set_CGST(Sanitization::test_input($_POST["CGST"]));
    $tax->set_SGST(Sanitization::test_input($_POST["SGST"]));
    $tax->set_IGST(Sanitization::test_input($_POST["IGST"]));
    $tax->set_GST(Sanitization::test_input($_POST["GST"]));
    $tax->set_createdby($_POST["modifiedby"]);
    $tax->set_taxid(Sanitization::test_input($_POST["tax_id"]));
    error_log($_POST["tax_id"]);
    $tax->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
    error_log("hey there i am here");
    DBTax::update($tax);
  } else if ($_POST["action"] == 'delete') {
    DBTax::delete($_POST['id']);
  } else {
    $tax = new Taxinfo();
    
    $tax->set_CGST(Sanitization::test_input($_POST["CGST"]));
    $tax->set_SGST(Sanitization::test_input($_POST["SGST"]));
    $tax->set_IGST(Sanitization::test_input($_POST["IGST"]));
    $tax->set_GST(Sanitization::test_input($_POST["GST"]));
    $tax->set_createdby($_POST["modifiedby"]);
    $tax->set_modifiedby(Sanitization::test_input($_POST["createdby"]));
    DBTax::insert($tax);
  }
}
header("location: ../View/tax.php");
