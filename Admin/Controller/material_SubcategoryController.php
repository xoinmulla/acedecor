<?php

require "../Model/material_subcategoryModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/material_subcategoryOps.php";

// =============================
//       POST REQUESTS
// =============================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  header('Content-Type: application/json');

  /* ----------------------------------------
     DELETE SUBCATEGORY
  ---------------------------------------- */
  if (isset($_POST["action"]) && $_POST["action"] == "delete") {

    $result = DBMaterialsubcategory::delete($_POST["id"]);

    echo json_encode([
      "status" => "success",
      "message" => "SubCategory deleted",
      "html" => $result
    ]);
    exit;
  }

  /* ----------------------------------------
     UPDATE SUBCATEGORY
  ---------------------------------------- */
  if (!empty($_POST['materialsubcatid'])) {

    $subcat = new Material_Subcategory();

    $subcat->set_materialsubcatId(Sanitization::test_input($_POST["materialsubcatid"]));
    $subcat->set_materialcatId(Sanitization::test_input($_POST["materialcatid"]));
    $subcat->set_materialsubcatName(Sanitization::test_input($_POST["materialsubcatname"]));
    $subcat->set_materialsubcaDescription(Sanitization::test_input($_POST["materialsubcatdescription"]));
    $subcat->set_materialsubcatCreatedby(Sanitization::test_input($_POST["materialsubcatcreatedby"]));
    $subcat->set_materialsubcatModifiedby(Sanitization::test_input($_POST["materialsubcatmodifiedby"]));

    DBMaterialsubcategory::update($subcat);

    echo json_encode([
      "status" => "success",
      "message" => "SubCategory updated successfully"
    ]);
    exit;
  }

  /* ----------------------------------------
     INSERT SUBCATEGORY
  ---------------------------------------- */ else {

    $subcat = new Material_Subcategory();

    $subcat->set_materialcatId(Sanitization::test_input($_POST["materialcatid"] ?? ''));
    $subcat->set_materialsubcatName(Sanitization::test_input($_POST["materialsubcatname"] ?? ''));
    $subcat->set_materialsubcaDescription(Sanitization::test_input($_POST["materialsubcatdescription"] ?? ''));
    $subcat->set_materialsubcatCreatedby(Sanitization::test_input($_POST["materialsubcatcreatedby"] ?? ''));
    $subcat->set_materialsubcatModifiedby(Sanitization::test_input($_POST["materialsubcatmodifiedby"] ?? ''));

    DBMaterialsubcategory::insert($subcat);

    echo json_encode([
      "status" => "success",
      "message" => "SubCategory added successfully"
    ]);
    exit;
  }
}

// =============================
//       GET REQUESTS
// =============================
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if (isset($_GET['catId'])) {
    DBMaterialsubcategory::selectsubcategory(Sanitization::test_input($_GET['catId']));
    exit;
  }
}
