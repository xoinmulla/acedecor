<?php

require "../Model/item_categorymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/item_categoryOps.php";

// =============================
//       POST REQUESTS
// =============================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  header('Content-Type: application/json');  // Always return JSON for POST

  /* ----------------------------------------
     DELETE CATEGORY
  ---------------------------------------- */
  if (isset($_POST["action"]) && $_POST["action"] == "delete") {

    $result = DBitemcategory::delete($_POST["id"]);

    echo json_encode([
      "status" => "success",
      "message" => "Category deleted",
      "html" => $result   // Your delete() returns HTML message
    ]);
    exit;
  }

  /* ----------------------------------------
     UPDATE CATEGORY
  ---------------------------------------- */
  if (isset($_POST['itemcatid'])) {

    $category = new Item_Category();

    $category->set_itemcatid(Sanitization::test_input($_POST["itemcatid"]));
    $category->set_itemcatname(Sanitization::test_input($_POST["itemcatname"]));
    $category->set_itemcatdescription(Sanitization::test_input($_POST["itemcatdescription"]));
    $category->set_itemcatcreatedby(Sanitization::test_input($_POST["itemcatcreatedby"]));
    $category->set_itemcatmodifiedby(Sanitization::test_input($_POST["itemcatmodifiedby"]));

    if (!empty($_POST["brand_list"])) {
      $category->set_brandList($_POST["brand_list"]);
    }

    DBitemcategory::update($category);

    echo json_encode([
      "status" => "success",
      "message" => "Category updated successfully"
    ]);
    exit;
  }

  /* ----------------------------------------
     INSERT CATEGORY
  ---------------------------------------- */
  // This is for your ADD CATEGORY Modal
  else {

    $category = new Item_Category();

    $category->set_itemcatname(Sanitization::test_input($_POST["itemcatname"]));
    $category->set_itemcatdescription(Sanitization::test_input($_POST["itemcatdescription"]));
    $category->set_itemcatcreatedby(Sanitization::test_input($_POST["itemcatcreatedby"]));
    $category->set_itemcatmodifiedby(Sanitization::test_input($_POST["itemcatmodifiedby"]));

    if (!empty($_POST["brand_list"])) {
      $category->set_brandList($_POST["brand_list"]);
    }

    // Insert will NOW return categoryId or error array
    $result = DBitemcategory::insert($category);

    // If duplicate category → return error JSON
    if (is_array($result) && $result["status"] == "error") {
      echo json_encode([
        "status" => "error",
        "message" => $result["message"]
      ]);
      exit;
    }

    // If insert is successful → return success JSON
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
    DBitemcategory::selectcategorybasedonBrandId($brandId);
    exit;
  }

  // Get all categories
  DBitemcategory::selectcategory();
  exit;
}

?>