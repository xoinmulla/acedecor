<?php
session_start();

require "../Model/enq_categorymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/enq_categoryOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // DELETE
  if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    DBcategory::delete($_POST['id']);
    $_SESSION['success'] = "Category deleted successfully";
    header("location:../View/enqcategory.php");
    exit;
  }

  // UPDATE
  if (isset($_POST['enqcatId'])) {
    $category = new Category();
    $category->set_catid($_POST['enqcatId']);
    $category->set_catname($_POST['catname']);
    $category->set_catType($_POST['category_type']);
    $category->set_catcreatedby($_POST['catcreatedby']);
    $category->set_catModifiedby($_POST['itemcatmodifiedby']);

    if (!DBcategory::update($category)) {
      // duplicate found
      header("location:../View/enqcategory.php");
      exit;
    }

    $_SESSION['success'] = "Category updated successfully";
    header("location:../View/enqcategory.php");
    exit;
  }

  // INSERT
  $category = new Category();
  $category->set_catname($_POST['catname']);
  $category->set_catType($_POST['category_type']);
  $category->set_catcreatedby($_POST['catcreatedby']);
  $category->set_catModifiedby($_POST['itemcatmodifiedby']);

  if (!DBcategory::insert($category)) {
    // duplicate found
    header("location:../View/enqcategory.php");
    exit;
  }

  $_SESSION['success'] = "Category added successfully";
  header("location:../View/enqcategory.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  // If request is from Add/Edit Enquiry → return ONLY Enquiry Category
  if (isset($_GET['type']) && $_GET['type'] === 'enquiry') {
    DBcategory::selectEnquiryCategories();
  }
  // Default → return all (used in Enquiry Category master screen)
  else {
    DBcategory::selectall();
  }
}


?>