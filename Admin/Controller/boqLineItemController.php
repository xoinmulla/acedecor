<?php
require_once "../DB Operations/lineItemOps.php";
require "../Utilities/Sanitization.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $quoteId = Sanitization::test_input($_GET['id']);
    error_log("BOQ: Fetching ALL line items for quoteId = " . $quoteId);

    // 🔥 THIS RETURNS BOTH ITEM + MATERIAL
    DBLineItem::getLineItemByQuoteId($quoteId);
}
