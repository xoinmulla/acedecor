<?php
require_once "../Model/EB_LWModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/EB_LWOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedEBLWID'])) {
        $EBLW = new EBLW();
        error_log($_POST['editedEBLWID']);
        $EBLW->setEB_LW(Sanitization::test_input($_POST["editedEBLW"]));
        $EBLW->setEBLW_Id(Sanitization::test_input($_POST['editedEBLWID']));
        $EBLW->setCreatedBy(Sanitization::test_input($_POST["editedcreatedby"]));
        $EBLW->setModifiedBy(Sanitization::test_input($_POST["editedmodifiedby"]));
        DB_EBLW::update($EBLW);
    } else if ($_POST["action"] == 'delete') {
        error_log($_POST["id"]);
        DB_EBLW::delete($_POST["id"]);
    } else {
        $EBLW = new EBLW();
        $EBLW->setEB_LW(Sanitization::test_input($_POST["EBLW"]));
        $EBLW->setCreatedBy(Sanitization::test_input($_POST["createdby"]));
        $EBLW->setModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        DB_EBLW::insert($EBLW);
    }
    header("location:../View/EB_LW.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

    DB_EBLW::selectEBLW();
}

?>
