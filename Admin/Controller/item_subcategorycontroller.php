<?php

require "../Model/item_subcategorymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/item_subcategoryOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  header('Content-Type: application/json'); // Always return JSON

  /* ----------------------------------------
     DELETE SUBCATEGORY
  ---------------------------------------- */
  if (isset($_POST["action"]) && $_POST["action"] == "delete") {

    $result = DBitemsubcategory::delete($_POST["id"]);

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
  if (!empty($_POST['itemsubcatid'])) {

    $subcat = new Item_Subcategory();

    $subcat->set_itemsubcatid(Sanitization::test_input($_POST["itemsubcatid"]));
    $subcat->set_itemcatid(Sanitization::test_input($_POST["itemcatid"]));
    $subcat->set_itemsubcatname(Sanitization::test_input($_POST["itemsubcatname"]));
    $subcat->set_itemsubcatdescription(Sanitization::test_input($_POST["itemsubcatdescription"]));
    $subcat->set_itemsubcatcreatedby(Sanitization::test_input($_POST["itemsubcatcreatedby"]));
    $subcat->set_itemsubcatmodifiedby(Sanitization::test_input($_POST["itemsubcatmodifiedby"]));

    DBitemsubcategory::update($subcat);

    echo json_encode([
      "status" => "success",
      "message" => "SubCategory updated successfully"
    ]);
    exit;
  }

  /* ----------------------------------------
     INSERT SUBCATEGORY
  ---------------------------------------- */ 
  else {

    $subcat = new Item_Subcategory();

    $subcat->set_itemcatid(Sanitization::test_input($_POST["itemcatid"]));
    $subcat->set_itemsubcatname(Sanitization::test_input($_POST["itemsubcatname"]));
    $subcat->set_itemsubcatdescription(Sanitization::test_input($_POST["itemsubcatdescription"]));
    $subcat->set_itemsubcatcreatedby(Sanitization::test_input($_POST["itemsubcatcreatedby"]));
    $subcat->set_itemsubcatmodifiedby(Sanitization::test_input($_POST["itemsubcatmodifiedby"]));

     DBitemsubcategory::insert($subcat);

    echo json_encode([
      "status" => "success",
      "message" => "SubCategory added successfully"
      
    ]);
    exit;
  }
}

/* ----------------------------------------------------
   GET REQUESTS (Return list of subcategories by category)
------------------------------------------------------ */
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if (isset($_GET['catId'])) {
    DBitemsubcategory::selectsubcategory(Sanitization::test_input($_GET['catId']));
    exit;
  }
}

?>