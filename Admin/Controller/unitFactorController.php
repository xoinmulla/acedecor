<?php
require "../Model/unitFactorModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/unitFactorOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['unitFactorId'])) {
    $unitFactor = new unitFactor();
    $unitFactor->set_unitFactorId(Sanitization::test_input($_POST["unitFactorId"]));
    $unitFactor->set_unitFactorDescription(Sanitization::test_input($_POST["unitFactorDescription"]));
    $unitFactor->set_unitFactor(Sanitization::test_input($_POST["unitFactor"]));
    $unitFactor->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $unitFactor->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    $unitFactor->set_unitId(Sanitization::test_input($_POST["unitId"]));
    DBunitFactor::update($unitFactor);
  } else if ($_POST["action"] == 'delete') {
    DBunitFactor::delete($_POST["id"]);
  } else {
    $unitFactor = new unitFactor();
    $unitFactor->set_unitId(Sanitization::test_input($_POST["unitId"]));
    $unitFactor->set_unitFactorDescription(Sanitization::test_input($_POST["unitFactorDescription"]));
    $unitFactor->set_unitFactor(Sanitization::test_input($_POST["unitFactor"]));
    $unitFactor->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $unitFactor->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    DBunitFactor::insert($unitFactor);
  }
  header("location:../View/unitFactor.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  DBunitFactor::selectUnitsFactor($_GET["unitId"]);
  
}