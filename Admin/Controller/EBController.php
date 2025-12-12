<?php
require_once "../Model/EBModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/EBOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedEBID'])) {
        $EB = new EB();
        error_log($_POST['editedEBID']);
        $EB->setEB(Sanitization::test_input($_POST["editedEB"]));
        $EB->setEB_Id(Sanitization::test_input($_POST['editedEBID']));
        $EB->setCreatedBy(Sanitization::test_input($_POST["editedcreatedby"]));
        $EB->setModifiedBy(Sanitization::test_input($_POST["editedmodifiedby"]));
        DB_EB::update($EB);
    } else if ($_POST["action"] == 'delete') {
        error_log($_POST["id"]);
        DB_EB::delete($_POST["id"]);
    } else {
        $EB = new EB();
        $EB->setEB(Sanitization::test_input($_POST["EB"]));
        $EB->setCreatedBy(Sanitization::test_input($_POST["createdby"]));
        $EB->setModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        DB_EB::insert($EB);
    }
    header("location:../View/EB.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

    DB_EB::selectEB();
}

?>
