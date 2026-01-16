<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once "../DB Operations/POlineitemOps.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  error_log($_GET['id']);
  DBPOLineItem::getPOLineItemByPurchaseId($_GET['id']);
}

?>