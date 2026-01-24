<?php
require_once "../DB Operations/dbconnection.php";

$db = ConnectDb::getInstance()->getConnection();

/**
 * 1️⃣ GET SUPPLIERS (unchanged)
 */
if (isset($_GET['action']) && $_GET['action'] === 'suppliers') {

    $sql = "
        SELECT DISTINCT 
            S.item_compid,
            S.item_compName
        FROM item_companydetails S
        JOIN purchase_order P ON P.SupplierId = S.item_compid
        ORDER BY S.item_compName
    ";

    echo json_encode($db->query($sql)->fetch_all(MYSQLI_ASSOC));
    exit;
}


/**
 * 2️⃣ GET SUPPLIER SUMMARY (NEW – SUPPLIER WISE)
 * Used by Supplier Expense modal
 */
if (isset($_GET['action']) && $_GET['action'] === 'supplier_summary') {

    $sid = intval($_GET['supplier_id']);

    $sql = "
SELECT
    S.item_compid,
    S.item_compName,
    S.item_compAddress,
    S.item_compLocation,
    S.item_compGSTIN,

    /* ✅ TOTAL AMOUNT = SUM OF INWARDED VALUE (SUPPLIER WISE) */
    IFNULL(
        (
            SELECT SUM(ST.ReceivedQtyAmt)
            FROM item_stock ST
            JOIN purchase_order PO ON PO.Id = ST.POID
            WHERE PO.SupplierId = S.item_compid
        ), 0
    ) AS total_amount,

    /* ✅ TOTAL PAID AMOUNT */
    IFNULL(
        (
            SELECT SUM(E.amount)
            FROM expense E
            WHERE E.supplier_id = S.item_compid
        ), 0
    ) AS paid_amount

FROM item_companydetails S
WHERE S.item_compid = $sid
";


    $row = $db->query($sql)->fetch_assoc();

    $row['balance_amount'] = $row['total_amount'] - $row['paid_amount'];

    echo json_encode($row);
    exit;
}

