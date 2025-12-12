<?php
require_once "../Model/ProcessingModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/ProcessingOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedProcessingId'])) {
        $Processing = new Processing();
        $Processing->setProcessing(Sanitization::test_input($_POST["ProcessingName"]));
        $Processing->setProcessingId(Sanitization::test_input($_POST['editedProcessingId']));
        $Processing->setModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        
       
        DBProcessing::update($Processing);
    } else if ($_POST["action"] == 'delete') {
        DBProcessing::delete($_POST["id"]);
    } else {
        $Processing = new Processing();
        $Processing->setProcessing(Sanitization::test_input($_POST["ProcessingName"]));
        $Processing->setCreatedBy(Sanitization::test_input($_POST["createdby"]));
        $Processing->setModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        DBProcessing::insert($Processing);
    }
    header("location:../View/processing.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

}
?>
