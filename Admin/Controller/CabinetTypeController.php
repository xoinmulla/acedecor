<?php
require_once "../Model/CabinetTypeModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/CabinetTypeOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedCabinetTypeID'])) {
        $CabinetType = new CabinetType();
        error_log($_POST['editedCabinetTypeID']);
        $CabinetType->setCabinetType(Sanitization::test_input($_POST["editedCabinetType"]));
        $CabinetType->setCabinetType_Id(Sanitization::test_input($_POST['editedCabinetTypeID']));
        $CabinetType->setCreatedBy(Sanitization::test_input($_POST["editedcreatedby"]));
        $CabinetType->setModifiedBy(Sanitization::test_input($_POST["editedmodifiedby"]));
        DBCabinetType::update($CabinetType);
    } else if ($_POST["action"] == 'delete') {
        error_log($_POST["id"]);
        DBCabinetType::delete($_POST["id"]);
    } else {
        $CabinetType = new CabinetType();
        $CabinetType->setCabinetType(Sanitization::test_input($_POST["CabinetType"]));
        $CabinetType->setCreatedBy(Sanitization::test_input($_POST["createdby"]));
        $CabinetType->setModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        DBCabinetType::insert($CabinetType);
    }
    header("location:../View/CabinetType.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

    DBCabinetType::selectCabinetTypes();
}

?>
