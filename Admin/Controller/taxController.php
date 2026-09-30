<?php
require_once "../Model/taxmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/taxOps.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  header('Content-Type: application/json');

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
    if (
      DBTax::isTaxExists(
        $tax->get_CGST(),
        $tax->get_SGST(),
        $tax->get_IGST(),
        $tax->get_taxid()
      )
    ) {

      echo json_encode([
        "status" => "error",
        "message" => "Tax already exists."
      ]);
      exit;
    }

    DBTax::update($tax);

    echo json_encode([
      "status" => "success",
      "message" => "Tax updated successfully."
    ]);
    exit;

  } else if (isset($_POST["action"]) && $_POST["action"] == 'delete') {

    DBTax::delete($_POST['id']);

    echo json_encode([
      "status" => "success",
      "message" => "Tax deleted successfully."
    ]);

    exit;
  } else {

    $tax = new Taxinfo();

    $tax->set_CGST(Sanitization::test_input($CGST));
    $tax->set_SGST(Sanitization::test_input($SGST));
    $tax->set_IGST(Sanitization::test_input($IGST));
    $tax->set_GST(Sanitization::test_input($GST));

    $tax->set_createdby($createdby);
    $tax->set_modifiedby(Sanitization::test_input($createdby));
    if (
      DBTax::isTaxExists(
        $tax->get_CGST(),
        $tax->get_SGST(),
        $tax->get_IGST()
      )
    ) {

      echo json_encode([
        "status" => "error",
        "message" => "Tax already exists."
      ]);
      exit;
    }

    DBTax::insert($tax);

    echo json_encode([
      "status" => "success",
      "message" => "Tax added successfully."
    ]);
    exit;
  }
}

/* 🚀 Redirect only if NOT ajax delete */
if (!$isAjaxDelete) {
  header("location: ../View/tax.php");
  exit;
}