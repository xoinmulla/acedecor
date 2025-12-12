<?php
require_once "../DB Operations/lineItemOps.php";
require "../Utilities/Sanitization.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $projId = Sanitization::test_input($_GET['projId']);
  if ($_GET['projId'] == 0) {
    error_log("Fetching line items for quote ID: " . $_GET['id']);
    DBLineItem::getLineItemByQuoteIdForModal($_GET['id']);
  } else {
    DBLineItem::getLineItemByProjectId($_GET['projId']);
  }

}

?>