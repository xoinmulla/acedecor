<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type = $_POST['type'] ?? 'monthly';

    $redirect = "../View/attendanceReport.php?type=$type";

    if ($type == "monthly") {

        $redirect .= "&month=" . $_POST['month'];

    } elseif ($type == "weekly") {

        $redirect .=
            "&fromDate=" . $_POST['fromDate'] .
            "&toDate=" . $_POST['toDate'];

    } elseif ($type == "quarterly") {

        $redirect .=
            "&year=" . $_POST['year'] .
            "&quarter=" . $_POST['quarter'];

    } elseif ($type == "yearly") {

        $redirect .=
            "&year=" . $_POST['year'];
    }

    header("Location: $redirect");
    exit;
}