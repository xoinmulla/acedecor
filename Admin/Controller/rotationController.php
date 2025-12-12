<?php
require "../Model/rotationModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/rotationOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['rotationId'])) {
   $rotation = new Rotation();
   $rotation->set_sides(Sanitization::test_input($_POST["rotationside"]));
   $rotation->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
   $rotation->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
   $rotation->set_rotationId(Sanitization::test_input($_POST["rotationId"]));
    DBrotation::update($rotation);
  } else if ($_POST["action"] == 'delete') {
    DBrotation::delete($_POST["id"]);
  } else {
   $rotation = new Rotation();
    error_log("insert");
    $rotation->set_sides(Sanitization::test_input($_POST["rotationside"]));
    $rotation->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $rotation->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    DBrotation::insert($rotation);
  }
  header("location:../View/rotations.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  DBrotation::selectrotations();
}
