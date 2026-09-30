<?php

require "../Model/purchaseModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/purchaseorderOps.php";
include "../DB Operations/item_compdetailsOps.php";
include "../DB Operations/supplierpaymentOps.php";
// include  "../Model/supplierpaymentmodel.php";
require "../Model/POlineitemModel.php";
include "../DB Operations/POlineitemOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['obj'])) {
    $value = $_POST['obj'];

    $purchase = new PurchaseOrder();
    $purchase->setInventoryType(
      Sanitization::test_input($value[0]["inventoryType"])
    );

    $purchase->set_supplier(Sanitization::test_input($value[0]["supplier"]));
    $purchase->set_projectId(
      isset($value[0]["project"])
      ? Sanitization::test_input($value[0]["project"])
      : 0
    );
    $purchase->set_itemid(Sanitization::test_input($value[0]["itemid"]));
    $purchase->set_totalAmount(
      isset($value[0]["totalAmount"])
      ? Sanitization::test_input($value[0]["totalAmount"])
      : 0
    );
    $purchase->set_itemquantity(Sanitization::test_input($value[0]["itemquantity"]));

    // $purchase->set_itemperpieceprice(Sanitization::test_input($value[0]["itemperpieceprice"]));
    $purchase->set_purchaseddate(Sanitization::test_input($value[0]["purchaseddate"]));
    $compname = DBpurchase::selectcompany($purchase->get_supplier());
    $companyname = $compname->get_itemcompname();
    $words = preg_split("/\s+/", $companyname);
    $acronym = "";
    foreach ($words as $w) {
      $acronym .= $w[0];
    }
    $purchaseCode = 'AD-' . substr((str_replace('-', '', $purchase->get_purchaseddate())), 0, 6) . '-' . $acronym;
    $purchase->setPOcode($purchaseCode);
    error_log(print_r($value[0], true));
    $purchaseId = DBpurchase::insert($purchase);
    error_log($purchaseId);
    foreach ($value as $key => $row) {

      $purchaselineitem = new PurchaselineItem();

      $purchaselineitem->set_POID($purchaseId);
      $purchaselineitem->set_itemid(Sanitization::test_input($row["itemid"]));
      $purchaselineitem->set_supplierId(Sanitization::test_input($row["supplier"]));
      $purchaselineitem->set_quantity(Sanitization::test_input($row["itemquantity"]));
      $purchaselineitem->setInputName(Sanitization::test_input($row["selectedItemName"]));

      $purchaselineitem->setunitName(
        isset($row["unitName"])
        ? Sanitization::test_input($row["unitName"])
        : ""
      );

      DBPOLineItem::insert($purchaselineitem);
    }
    $supplier = new SupplierPayment();
    $supplier->set_supplierId(
      Sanitization::test_input($value[0]["supplier"])
    );
    $supplier->setPOID($purchaseId);
    error_log($purchaseId);
    $supplier->set_totalamt(0);
    $supplier->set_paidamt(0);
    $supplier->set_pendingamt(0);
    $supplier->set_receivedamt(0);
    $supplier->set_paymentplan(0);
    $supplier->set_paymentmode(0);
    $supplier->set_paymentdescription(0);
    DBsupplierpayment::insert($supplier);
    echo json_encode([
      "status" => true,
      "message" => "Purchase Order Created"
    ]);
    exit;

  } elseif ($_POST["action"] == 'cancel') {
    DBpurchase::cancel($_POST["id"]);
  } elseif ($_POST["action"] == 'resume') {
    DBpurchase::resume($_POST["id"]);
  } elseif ($_POST["action"] == 'delete') {
    DBpurchase::delete($_POST["id"]);
  } elseif (isset($_POST['id'])) {
    $purchase = new PurchaseOrder();
    $purchase->set_Id($_POST['id']);
    $purchase->set_supplier(Sanitization::test_input($_POST["supplier"]));
    $purchase->set_itemid(Sanitization::test_input($_POST["itemid"]));
    $purchase->set_projectId(
      isset($value[0]["project"])
      ? Sanitization::test_input($value[0]["project"])
      : 0
    );    // $purchase->set_totalAmount(Sanitization::test_input($_POST["totalAmount"]));
    $purchase->set_itemquantity(Sanitization::test_input($_POST["itemquantity"]));
    $purchase->set_itemperpieceprice(Sanitization::test_input($_POST["itemperpieceprice"]));
    $purchase->set_purchaseddate(Sanitization::test_input($_POST["purchaseddate"]));
    DBpurchase::update($purchase);
  }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  DBpurchase::selectCompany();
}


?>