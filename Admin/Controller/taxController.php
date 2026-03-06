<?php
require_once "../Model/taxmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/taxOps.php";

$isAjaxDelete = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $CGST = $_POST["CGST"] ?? 0;
  $SGST = $_POST["SGST"] ?? 0;
  $IGST = $_POST["IGST"] ?? 0;
  $GST = $_POST["GST"] ?? 0;
  $createdby = $_POST["createdby"] ?? null;
  $modifiedby = $_POST["modifiedby"] ?? null;

  if (isset($_POST['tax_id'])) {

    $tax = new Taxinfo();

    $tax->set_CGST(Sanitization::test_input($CGST));
    $tax->set_SGST(Sanitization::test_input($SGST));
    $tax->set_IGST(Sanitization::test_input($IGST));
    $tax->set_GST(Sanitization::test_input($GST));

    $tax->set_createdby($modifiedby);
    $tax->set_taxid(Sanitization::test_input($_POST["tax_id"]));
    $tax->set_modifiedby(Sanitization::test_input($modifiedby));

    DBTax::update($tax);

  } else if (isset($_POST["action"]) && $_POST["action"] == 'delete') {

    DBTax::delete($_POST['id']);

    // Mark as AJAX delete
    $isAjaxDelete = true;

    echo json_encode(["status" => "success"]);
  } else {

    $tax = new Taxinfo();

    $tax->set_CGST(Sanitization::test_input($CGST));
    $tax->set_SGST(Sanitization::test_input($SGST));
    $tax->set_IGST(Sanitization::test_input($IGST));
    $tax->set_GST(Sanitization::test_input($GST));

    $tax->set_createdby($createdby);
    $tax->set_modifiedby(Sanitization::test_input($createdby));

    DBTax::insert($tax);
  }
}

/* 🚀 Redirect only if NOT ajax delete */
if (!$isAjaxDelete) {
  header("location: ../View/tax.php");
  exit;
}