<?php
require "../Model/rotationModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/rotationOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  header('Content-Type: application/json');
  if (isset($_POST['rotationId'])) {
    $rotation = new Rotation();
    $rotation->set_sides(Sanitization::test_input($_POST["rotationside"]));
    $rotation->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $rotation->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    $rotation->set_rotationId(Sanitization::test_input($_POST["rotationId"]));
    if (
      DBrotation::isRotationExists(
        $rotation->get_sides(),
        $rotation->get_rotationId()
      )
    ) {

      echo json_encode([
        "status" => "error",
        "message" => "Rotation already exists."
      ]);
      exit;
    }

    DBrotation::update($rotation);

    echo json_encode([
      "status" => "success",
      "message" => "Rotation updated successfully."
    ]);
    exit;
  } else if (isset($_POST["action"]) && $_POST["action"] == 'delete') {
    DBrotation::delete($_POST["id"]);

    echo json_encode([
      "status" => "success",
      "message" => "Rotation deleted successfully."
    ]);
    exit;
  } else {
    $rotation = new Rotation();
    error_log("insert");
    $rotation->set_sides(Sanitization::test_input($_POST["rotationside"]));
    $rotation->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $rotation->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    if (
      DBrotation::isRotationExists(
        $rotation->get_sides()
      )
    ) {

      echo json_encode([
        "status" => "error",
        "message" => "Rotation already exists."
      ]);
      exit;
    }

    DBrotation::insert($rotation);

    echo json_encode([
      "status" => "success",
      "message" => "Rotation added successfully."
    ]);
    exit;
  }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  DBrotation::selectrotations();
}
