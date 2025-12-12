<?php
require "../model/subcategorymodel.php";
require "../Utilities/Sanitization.php";
include "../dblayer/subcategoryOps.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $subcat = new Subcategory();
    $subcat->setSubCategoryName(Sanitization::test_input($_POST["itemsubcatname"] ?? ""));
    $subcat->setSubCategoryDescription(Sanitization::test_input($_POST["itemsubcatdescription"] ?? ""));
    $subcat->setSubCategoryCreatedBy(Sanitization::test_input($_POST["itemsubcatcreatedby"] ?? ""));
    $subcat->setSubCategoryModifiedBy(Sanitization::test_input($_POST["itemsubcatmodifiedby"] ?? ""));

    // Handle mapped categories
    $mappedCategories = [];
    if (isset($_POST["category"]) && is_array($_POST["category"])) {
        foreach ($_POST["category"] as $catId) {
            $mappedCategories[] = Sanitization::test_input($catId);
        }
    }
    $subcat->setMappedCategories($mappedCategories);

    // 🔹 Delete subcategory
    if (isset($_POST["action"]) && $_POST["action"] === 'delete') {
        if (!empty($_POST["id"])) {
            $id = intval(Sanitization::test_input($_POST["id"]));
            DBsubcategory::delete($id);
        }
    }
    // 🔹 Update subcategory
    elseif (!empty($_POST['itemsubcatid'])) {
        $subcat->setSubCategoryId(intval(Sanitization::test_input($_POST["itemsubcatid"])));
        DBsubcategory::update($subcat);
    }
    // 🔹 Insert new subcategory
    else {
        DBsubcategory::insert($subcat);
    }

    // Redirect to subcategory view page
    header("Location: ../views/subcategory.php");
    exit;
}

// 🔹 Handle GET requests for AJAX or list population
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    // Get mapped subcategories for a post
    if (!empty($_GET["subCatId"])) {
        $postId = intval(Sanitization::test_input($_GET["subCatId"]));
        DBsubcategory::getMappedSubCategories($postId);
    }
    // Get all subcategories for dropdowns / lists
    else {
        DBsubcategory::selectsubcategory();
    }
}
