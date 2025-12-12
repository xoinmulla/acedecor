<?php

require "../Model/material_CategoryModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/material_CategoryOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  header('Content-Type: application/json');

  /* ----------------------------------------
     DELETE CATEGORY
  ---------------------------------------- */
  if (isset($_POST["action"]) && $_POST["action"] == "delete") {
    $resultHtml = DBMaterialcategory::delete($_POST["id"]);

    echo json_encode([
      "status" => "success",
      "message" => "Category deleted",
      "html" => $resultHtml
    ]);
    exit;
  }

  /* ----------------------------------------
     UPDATE CATEGORY
  ---------------------------------------- */
  if (isset($_POST['materialCatid'])) {

    $category = new Material_category();

    $category->set_materialcatId(Sanitization::test_input($_POST["materialCatid"]));
    $category->set_materialCatname(Sanitization::test_input($_POST["materialCatname"] ?? ''));
    $category->set_materialCatdescription(Sanitization::test_input($_POST["materialCatdescription"] ?? ''));
    $category->set_materialCatcreatedby(Sanitization::test_input($_POST["materialCatcreatedby"] ?? ''));
    $category->set_materialCatmodifiedby(Sanitization::test_input($_POST["materialCatmodifiedby"] ?? ''));

    if (!empty($_POST["brand_list"])) {
      $category->set_brandList($_POST["brand_list"]);
    }

    DBMaterialcategory::update($category);

    echo json_encode([
      "status" => "success",
      "message" => "Category updated successfully"
    ]);
    exit;
  }

  /* ----------------------------------------
     INSERT CATEGORY
  ---------------------------------------- */ else {

    $category = new Material_category();

    $category->set_materialCatname(Sanitization::test_input($_POST["materialCatname"] ?? ''));
    $category->set_materialCatdescription(Sanitization::test_input($_POST["materialCatdescription"] ?? ''));
    $category->set_materialCatcreatedby(Sanitization::test_input($_POST["materialCatcreatedby"] ?? ''));
    $category->set_materialCatmodifiedby(Sanitization::test_input($_POST["materialCatmodifiedby"] ?? ''));

    if (!empty($_POST["brand_list"])) {
      $category->set_brandList($_POST["brand_list"]);
    }

    // Insert will return an array similar to item ops
    $result = DBMaterialcategory::insert($category);

    if (is_array($result) && isset($result["status"]) && $result["status"] == "error") {
      echo json_encode([
        "status" => "error",
        "message" => $result["message"]
      ]);
      exit;
    }

    echo json_encode([
      "status" => "success",
      "message" => "Category added successfully",
      "newCategoryId" => $result["newCategoryId"]
    ]);
    exit;
  }
}


// =============================
//       GET REQUESTS
// =============================
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  // Get categories by brand
  if (isset($_GET['brandId'])) {
    $brandId = Sanitization::test_input($_GET['brandId']);
    DBMaterialcategory::selectMatcategorybasedonBrandId($brandId);
    exit;
  }

  // Get all categories
  DBMaterialcategory::selectMatcategory();
  exit;
}
