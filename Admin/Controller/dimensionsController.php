<?php
require "../Model/dimensionsModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/dimensionsOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['dimensionId'])) {
    $dimension = new dimension();
    $dimension->set_dimensionName(Sanitization::test_input($_POST["dimensionName"]));
    $dimension->set_dimensionDescription(Sanitization::test_input($_POST["dimensionDescription"]));
    $dimension->set_length(Sanitization::test_input($_POST["length"]));
    $dimension->set_breadth(Sanitization::test_input($_POST["breadth"]));
    $dimension->set_thickness(Sanitization::test_input($_POST["thickness"]));
    $dimension->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $dimension->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    $dimension->set_dimensionId(Sanitization::test_input($_POST["dimensionId"]));
    DBdimension::update($dimension);
  } else if ($_POST["action"] == 'delete') {
    DBitemcategory::delete($_POST["id"]);
  } else {
    $dimension = new dimension();
    error_log("insert");
    $dimension->set_dimensionName(Sanitization::test_input($_POST["dimensionName"]));
    $dimension->set_dimensionDescription(Sanitization::test_input($_POST["dimensionDescription"]));
    $dimension->set_length(Sanitization::test_input($_POST["length"]));
    $dimension->set_breadth(Sanitization::test_input($_POST["breadth"]));
    $dimension->set_thickness(Sanitization::test_input($_POST["thickness"]));
    $dimension->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $dimension->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    DBdimension::insert($dimension);
  }
  header("location:../View/dimensions.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  DBdimension::selectdimensions();
}
