<?php
require_once "../Model/allocateitemsModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../Utilities/Helper.php";
//require "../Admin/navbar.php";
require_once "../DB Operations/allocateitemsOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['AllocateprojectId'])) {
    error_log($_POST['AllocateprojectId']);
    $allocate = new Allocation();
    $allocate->set_ProjectId(Sanitization::test_input($_POST["AllocateprojectId"]));
    $allocate->set_itemstockId(Sanitization::test_input($_POST["StockId"]));
    $allocate->set_itemId(Sanitization::test_input($_POST["itemid"]));
    $allocate->setItemName(Sanitization::test_input($_POST["AllocatedInputName"]));
    $allocateQty = (float) $_POST["quantity"];
    $availableQty = (float) $_POST["availableQty"];
    $stockId = $_POST["StockId"];

    // ❌ PREVENT OVER ALLOCATION
    if ($allocateQty > $availableQty) {
      die("Error: Cannot allocate more than available stock");
    }

    // ✅ INSERT ALLOCATION
    // ✅ INSERT ALLOCATION
    $allocate->set_AllocatedQty($allocateQty);
    DBallocate::insert($allocate);

    // ✅ UPDATE STOCK TABLE
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    

    // REMOVE THIS LINE
// DBallocate::insert($allocate);
  } else {
    $allocate = new Allocation();
    $allocate->set_itemId(Sanitization::test_input($_POST["DeallocateItemId"]));
    $allocate->set_ProjectId(Sanitization::test_input($_POST["ProjectId"]));
    DBallocate::delete($allocate);
  }
  header("location:../View/projectView.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['id'])) {
    DBallocate::getAllocatedItemInfo($_GET['id']);
  }
}
