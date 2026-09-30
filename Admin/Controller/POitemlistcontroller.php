<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once "../DB Operations/POlineitemOps.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  $data = DBPOLineItem::getPOLineItemByPurchaseId($_GET['id']);

  header('Content-Type: application/json');   // IMPORTANT
  echo json_encode($data);                    // 🔥 THIS WAS MISSING
}
?>