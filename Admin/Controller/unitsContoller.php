<?php
require "../Model/unitsModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/unitOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['unitId'])) {
    $unit = new unit();
    error_log($_POST['unitId']);
    $unit->set_unitName(Sanitization::test_input($_POST["unitName"]));
    $unit->set_unitDescription(Sanitization::test_input($_POST["unitDescription"]));
    $unit->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $unit->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    $unit->set_unitId(Sanitization::test_input($_POST["unitId"]));
    DBunit::update($unit);
  } else if ($_POST["action"] == 'delete') {
    DBitemcategory::delete($_POST["id"]);
  } else {
    $unit = new unit();
    $unit->set_unitName(Sanitization::test_input($_POST["unitName"]));
    $unit->set_unitDescription(Sanitization::test_input($_POST["unitDescription"]));
    $unit->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $unit->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    DBunit::insert($unit);
    error_log("Inserted");
  }
  header("location:../View/units.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  echo DBunit::selectUnits();
}
exit;

