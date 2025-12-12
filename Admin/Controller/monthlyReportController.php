<?php
require_once("../DB Operations/monthlyReportOps.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? 'monthly';
    $redirect = "../View/monthlyReport.php?type=$type";

    if ($type === 'monthly' && isset($_POST['month'])) {
        $redirect .= "&month=" . $_POST['month'];
    } elseif ($type === 'quarterly' && isset($_POST['year'], $_POST['quarter'])) {
        $redirect .= "&year=" . $_POST['year'] . "&quarter=" . $_POST['quarter'];
    } elseif ($type === 'yearly' && isset($_POST['year'])) {
        $redirect .= "&year=" . $_POST['year'];
    }

    header("Location: $redirect");
    exit;
}
?>
