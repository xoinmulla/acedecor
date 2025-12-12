<?php
require_once "../Model/FinishModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/FinishOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedFinishId'])) {
        $finish = new Finish();
        $finish->setFinish(Sanitization::test_input($_POST["FinishName"]));
        $finish->setFinishId(Sanitization::test_input($_POST['editedFinishId']));
        $finish->setModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        
       
        DBFinish::update($finish);
    } else if ($_POST["action"] == 'delete') {
        DBFinish::delete($_POST["id"]);
    } else {
        $finish = new Finish();
        $finish->setFinish(Sanitization::test_input($_POST["FinishName"]));
        $finish->setCreatedBy(Sanitization::test_input($_POST["createdby"]));
        $finish->setModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        DBFinish::insert($finish);
    }
    header("location:../View/finish.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){
    DBFinish::selectfinish();
}
?>
