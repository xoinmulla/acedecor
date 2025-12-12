<?php
require_once("../DB Operations/attendanceOps.php");
require_once("../Model/attendanceModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    $att = new Attendance();
    if (isset($_POST['id'])) $att->setId($_POST['id']);
    $att->setEmpId($_POST['emp_id']);
    $att->setDate($_POST['date']);
    $att->setStatus($_POST['status']);
    $att->setInTime($_POST['in_time']);
    $att->setOutTime($_POST['out_time']);
    $att->setRemarks($_POST['remarks']);

    if ($action === 'add') {
        // ✅ Prevent duplicate attendance for same employee & date
        if (DBAttendance::isDuplicate($att->getEmpId(), $att->getDate())) {
            header("Location: ../View/attendance.php?duplicate=1");
            exit;
        }

        DBAttendance::insert($att);
        header("Location: ../View/attendance.php?success=1");
    } 
    elseif ($action === 'update') {
        // ✅ Prevent duplicate attendance on update (excluding same record)
        if (DBAttendance::isDuplicate($att->getEmpId(), $att->getDate(), $att->getId())) {
            header("Location: ../View/attendance.php?duplicate=1");
            exit;
        }

        DBAttendance::update($att);
        header("Location: ../View/attendance.php?updated=1");
    }
    exit;
}

if (isset($_GET['delete'])) {
    DBAttendance::delete($_GET['delete']);
    header("Location: ../View/attendance.php?deleted=1");
    exit;
}
?>
