<?php
require_once "../Model/taskModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/taskOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['taskId'])) {
        $Task = new Task();
        error_log($_POST['taskId']);
        $Task->set_TaskId(Sanitization::test_input($_POST["taskId"]));
        $Task->set_Date(Sanitization::test_input($_POST["editeddate"]));
        $Task->set_TaskDescription(Sanitization::test_input($_POST['editedtaskDescription']));
        $Task->set_ContactPerson(Sanitization::test_input($_POST['editedcontactPerson']));
        $Task->set_ContactNo(Sanitization::test_input($_POST['editedcontactNo']));
        $Task->set_Status(Sanitization::test_input($_POST['editedstatus']));
        $Task->set_Taskcreatedby(Sanitization::test_input($_POST["editedcreatedby"]));
        $Task->set_Taskmodifiedby(Sanitization::test_input($_POST["editedmodifiedby"]));
        DBTask::update($Task);
    } else if ($_POST["action"] == 'delete') {
        DBTask::delete($_POST["id"]);
    } else {
        $Task = new Task();
        $Task->set_Date(Sanitization::test_input($_POST["date"]));
        $Task->set_TaskDescription(Sanitization::test_input($_POST['taskDescription']));
        $Task->set_ContactPerson(Sanitization::test_input($_POST['contactPerson']));
        $Task->set_ContactNo(Sanitization::test_input($_POST['contactNo']));
        $Task->set_Status(Sanitization::test_input($_POST['status']));
        $Task->set_Taskcreatedby(Sanitization::test_input($_POST["createdby"]));
        $Task->set_Taskmodifiedby(Sanitization::test_input($_POST["modifiedby"]));
        DBTask::insert($Task);
    }
    header("location: ../View/projectView.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

    DBTask::selectTask();
}

?>
