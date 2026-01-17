<?php
require_once "../DB Operations/dbconnection.php";

$db = ConnectDb::getInstance()->getConnection();

if ($_GET['action'] === 'suppliers') {
    $sql = "SELECT DISTINCT S.item_compid, S.item_compName
          FROM item_companydetails S
          JOIN purchase_order P ON P.SupplierId = S.item_compid";
    echo json_encode($db->query($sql)->fetch_all(MYSQLI_ASSOC));
}

if ($_GET['action'] === 'supplier_po') {
    $sid = intval($_GET['supplier_id']);

    $sql = "SELECT 
            P.Id AS poid,
            P.POcode,
            P.TotalAmt,
            S.item_compAddress,
            IFNULL(SUM(E.amount),0) AS expense
          FROM purchase_order P
          JOIN item_companydetails S ON S.item_compid=P.SupplierId
          LEFT JOIN expense E ON E.po_id=P.Id
          WHERE P.SupplierId=$sid
          GROUP BY P.Id";

    echo json_encode($db->query($sql)->fetch_all(MYSQLI_ASSOC));
}
?>