<?php
require_once "../DB Operations/POlineitemOps.php";
include "../DB Operations/supplierpaymentOps.php";

require_once "../Utilities/Sanitization.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateQuantity"])) {

        $purchaselineItem = new PurchaselineItem();

        $purchaselineItem->set_POlineitemId(
            Sanitization::test_input($_POST["POlineitemId"])
        );

        $purchaselineItem->set_quantity(
            Sanitization::test_input($_POST["quantity"])
        );

        DBPOLineItem::updateQuantity($purchaselineItem);

        header("location: ../View/POlineitemview.php?id=" . $_POST["POID"]);
        exit;
    }
    if (isset($_POST['obj'])) {
        $value = $_POST['obj'];
        $totalamt = 0;
        foreach ($value as $key => $value) {
            $purchaselineItem = new PurchaselineItem();
            $purchaselineItem->set_POlineitemId(Sanitization::test_input($value["POlineitemId"]));
            $purchaselineItem->set_POID(Sanitization::test_input($value["Pid"]));
            $purchaselineItem->set_supplierId(Sanitization::test_input($value["supplierid"]));
            $purchaselineItem->set_price(Sanitization::test_input($value["price"]));
            $purchaselineItem->set_quantity(Sanitization::test_input($value["quantity"]));
            $purchaselineItem->set_totalamt(Sanitization::test_input($value["totalamt"]));
            $totalamt = $totalamt + $purchaselineItem->get_totalamt();
            error_log($totalamt);
            DBPOLineItem::update($purchaselineItem);
        }
        $supplier = new SupplierPayment();
        $supplier->set_supplierId(Sanitization::test_input($value["supplierid"]));
        $supplier->setPOID(Sanitization::test_input($value["Pid"]));
        $supplier->set_totalamt($totalamt);
        $supplier->set_paidamt(0);
        $supplier->set_pendingamt($totalamt);
        $supplier->set_receivedamt(0);
        $supplier->set_paymentplan(0);
        $supplier->set_paymentmode(0);
        $supplier->set_paymentdescription(0);
        DBsupplierpayment::update($supplier);
    } elseif (isset($_POST["action"]) && $_POST["action"] == 'delete') {
        DBPOLineItem::delete($_POST["id"]);
    } else {
        $purchaselineItem = new PurchaselineItem();
        $purchaselineItem->set_itemid($_POST['additemid']);

        $purchaselineItem->setInputName(
            Sanitization::test_input($_POST["selectedItemName"])
        );

        $purchaselineItem->set_POID(
            Sanitization::test_input($_POST["POID"])
        );

        $purchaselineItem->set_quantity(
            Sanitization::test_input($_POST["quantity"])
        );

        $purchaselineItem->set_supplierId(
            Sanitization::test_input($_POST["supplierid"])
        );

        $purchaselineItem->set_price(0);

        $purchaselineItem->set_totalamt(0);
        $Amt = (float) Sanitization::test_input($_POST["totalAmt"]);
        $currentTotal = (float) $purchaselineItem->get_totalamt();

        $totalamt = $Amt + $currentTotal;
        error_log(print_r($_POST, true));
        DBPOLineItem::insert($purchaselineItem);

        $supplier = new SupplierPayment();
        $supplier->set_supplierId(Sanitization::test_input($_POST["supplierid"]));
        $supplier->setPOID(Sanitization::test_input($_POST["POID"]));
        $supplier->set_totalamt($totalamt);
        $supplier->set_paidamt(0);
        $supplier->set_pendingamt($totalamt);
        $supplier->set_receivedamt(0);
        $supplier->set_paymentplan(0);
        $supplier->set_paymentmode(0);
        $supplier->set_paymentdescription(0);
        DBsupplierpayment::update($supplier);
    }
}

header("location: ../View/POlineitemview.php?id=" . $_POST["POID"]);
// else if($_SERVER["REQUEST_METHOD"]=="GET"){
//   DBLineItem::getLineItemByQuoteId($_GET['id']);
//   // header("location: ../View/PurchaselineItemView.php?id=".$_POST["POID"]);
// }

?>