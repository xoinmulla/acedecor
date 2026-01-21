<?php

require "../Model/pricingissuesModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/pricingissuesOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (!empty($_POST['PricingIssueId'])) {

    $follow = new PricingIssues();
    $follow->set_PricingIssuesId(
      Sanitization::test_input($_POST["PricingIssueId"])
    );
    $follow->set_ItemName(
      Sanitization::test_input($_POST["editedPriceItemName"])
    );
    $follow->set_SupplierName(
      Sanitization::test_input($_POST["editedPriceSupplierName"])
    );
    $follow->set_InvoiceNo(
      Sanitization::test_input($_POST["invoiceNo"])
    );
    $follow->set_POID(
      Sanitization::test_input($_POST["PricingPOID"])
    );
    $follow->set_Status(
      Sanitization::test_input($_POST["editedPricestatus"])
    );

    DBPricingIssues::update($follow);

  } else {

    $follow = new PricingIssues();
    $follow->set_ItemName(
      Sanitization::test_input($_POST["editedPriceItemName"])
    );
    $follow->set_SupplierName(
      Sanitization::test_input($_POST["editedPriceSupplierName"])
    );
    $follow->set_InvoiceNo(
      Sanitization::test_input($_POST["invoiceNo"])
    );
    $follow->set_POID(
      Sanitization::test_input($_POST["PricingPOID"])
    );
    $follow->set_Status(
      Sanitization::test_input($_POST["editedPricestatus"])
    );

    DBPricingIssues::insert($follow);
  }
}

// else if($_SERVER["REQUEST_METHOD"] == "GET"){
//     DBPricingIssues::getFollowUpByItemId($_GET['id']);
// }

?>