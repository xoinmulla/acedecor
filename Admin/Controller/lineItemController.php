<?php
require_once "../DB Operations/lineItemOps.php";
require_once "../Utilities/Sanitization.php";
include "../DB Operations/customerpaymentOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* ------------------------- EDIT / UPDATE --------------------------- */
    if (isset($_POST["action"]) && $_POST["action"] == "edit") {
        $lineItem = new lineItem();

        $lineItem->set_lineItemId($_POST['lineItemId']);
        $lineItem->set_quoteId($_POST['quoteId']);

        // Numeric safe defaults to avoid SQL crash
        $qty = floatval($_POST['itemquantity'] ?? 0);
        $mrp = floatval($_POST['itemppMRP'] ?? 0);
        $gst = floatval($_POST['GST'] ?? 0);
        $tDis = floatval($_POST['tradeDiscount'] ?? 0);

        $totalAmount = floatval($_POST['totalAmount'] ?? 0);
        $discount1Amt = floatval($_POST['discount1Amt'] ?? 0);
        $GSTAmount = floatval($_POST['GSTAmount'] ?? 0);
        $totalPrice = floatval($_POST['tradePrice'] ?? 0);
        $totalValue = floatval($_POST['totalValue'] ?? 0);
        $value = floatval($_POST['inputValue'] ?? 0);
        $modifiedby = $_POST['modifiedby'] ?? $_SESSION['login_user'];

        // ✅ Correct assignments
        $lineItem->set_itemquantity($qty);
        $lineItem->set_totalAmount($totalAmount);
        $lineItem->set_companyDiscount(floatval($_POST['companyDiscount'] ?? 0));
        $lineItem->set_companyPrice(floatval($_POST['companyPrice'] ?? 0));
        $lineItem->set_discount1(floatval($_POST['tradeDiscount'] ?? 0));     // Trade Discount %
        $lineItem->set_discount1Amt($discount1Amt);                           // Discount amount
        $lineItem->set_GST($gst);                                             // GST %
        $lineItem->set_GSTAmt($GSTAmount);
        $lineItem->set_reference($_POST['reference'] ?? '');
        $lineItem->set_note($_POST['note'] ?? '');                                // GST amount
        $lineItem->set_totalPrice($totalPrice);                               // final price
        $lineItem->set_totalValue($totalValue);                               // SPU based value
        $lineItem->set_value($value);
        $lineItem->set_modifiedby($modifiedby);
        $lineItem->set_reference($_POST['reference'] ?? '');
        $lineItem->set_note($_POST['note'] ?? '');

        error_log(("Updating Line Item: " . print_r($lineItem, true)));
        DBLineItem::update($lineItem);


        echo "success";
        exit();
    }


    /* ------------------------- DELETE --------------------------- */ else if (isset($_POST["action"]) && $_POST["action"] == "delete") {
        DBLineItem::delete($_POST["id"]);
        exit();
    }

    /* ------------------------- INSERT NEW ITEM --------------------------- */ else {

        $lineItem = new lineItem();

        $lineItem->set_itemid($_POST['itemid']);
        $lineItem->set_quoteId($_POST['quoteId']);
        $lineItem->setQuoteCode($_POST['quoteCode']);
        $lineItem->set_inputType($_POST['inputType']);
        $lineItem->set_itemcatid(Sanitization::test_input($_POST['itemCategory']));
        $lineItem->set_itemsubcatid(Sanitization::test_input($_POST['itemsubCategory']));
        $lineItem->set_InputName(Sanitization::test_input($_POST['selectedItemName']));
        $lineItem->set_itemquantity(Sanitization::test_input($_POST['itemquantity']));
        $lineItem->set_ppMRP(Sanitization::test_input($_POST['itemppMRP']));

        $totalAmount = floatval($_POST['totalAmount']);
        $companyDiscount = floatval($_POST['companyDiscount']);
        $companyPrice = floatval($_POST['companyPrice']);
        $tradeDiscount = floatval($_POST['tradeDiscount']);
        $tradePrice = floatval($_POST['tradePrice']);
        $totalValue = floatval($_POST['totalValue']);
        $GST = floatval($_POST['GST']);
        $GSTAmount = floatval($_POST['GSTAmount']);

        $lineItem->set_totalAmount($totalAmount);
        $lineItem->set_discount1($companyDiscount);
        $lineItem->set_discount1Amt(($totalAmount * $companyDiscount) / 100);
        $lineItem->set_companyPrice($companyPrice);
        $lineItem->set_value($tradeDiscount);
        $lineItem->set_totalPrice($tradePrice);
        $lineItem->set_totalValue($totalValue);
        $lineItem->set_GST($GST);
        $lineItem->set_GSTAmt($GSTAmount);
        $lineItem->set_reference($_POST['reference'] ?? '');
        $lineItem->set_note($_POST['note'] ?? '');

        $lineItem->set_createdby(Sanitization::test_input($_POST['createdby']));
        $lineItem->set_modifiedby(Sanitization::test_input($_POST['modifiedby']));

        DBLineItem::insert($lineItem);

        header("location: ../View/lineItemView.php?id=" . $_POST["quoteId"]);
        exit();
    }
}

/* ------------------------- GET REQUEST --------------------------- */ else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    DBLineItem::getLineItemByQuoteId($_GET['id']);
}

if (isset($_GET['quoteId'])) {
    $data = DBLineItem::getLineItemByQuoteIdForOrder($_GET['quoteId']);
    echo json_encode($data);
    exit();
}
?>