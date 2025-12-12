<?php
require "../Model/productsmodel.php";
require "../Utilities/Sanitization.php";
require "../Utilities/Helper.php";
include "../DB Operations/productsOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['productId'])){
    $details=new Products();
    $details->setName(Sanitization::test_input($_POST["productname"]));
    $details->setLength(Sanitization::test_input($_POST["Length"]));
    $details->setWidth(Sanitization::test_input($_POST["Width"]));
    $details->setQuantity(Sanitization::test_input($_POST["productquantity"]));
    $details->setCL_ID(Sanitization::test_input($_POST["CLID"]));
    $details->setCategoryId(Sanitization::test_input($_POST["productcategoryname"]));
    $details->setSubcategoryId(Sanitization::test_input($_POST["productmaterialSubCategory"]));
    $details->setFinishId(Sanitization::test_input($_POST["Finish"])); 
    $details->setCode(Sanitization::test_input($_POST["ProductCode"]));
    $details->setCabinetType(Sanitization::test_input($_POST["CabinetType"]));
    $details->setMat_Brand(Sanitization::test_input($_POST["matBrand"]));
    $details->setRotation(Sanitization::test_input($_POST["Rotation"]));
    $details->setMat_Category(Sanitization::test_input($_POST["materialCategory"]));
    $details->setMat_Subcategory(Sanitization::test_input($_POST["materialSubCategory"]));
    $details->setThickness(Sanitization::test_input($_POST["Thickness"]));
    $details->setMaterial(Sanitization::test_input($_POST["Material"]));
    $details->setPEB(Sanitization::test_input($_POST["PEB"]));
    $details->setPEB_Thickness(Sanitization::test_input($_POST["PEBthickness"]));
    $details->setSEB(Sanitization::test_input($_POST["SEB"]));
    $details->setSEB_Thickness(Sanitization::test_input($_POST["SEBthickness"]));
    $details->setComments(Sanitization::test_input($_POST["Comments"]));
    $details->set_productid(Sanitization::test_input($_POST["productId"]));
    // if (isset($_FILES["productimage"])) {

    //   $filetoupload = $_FILES["productimage"];
    //   Helper::fileupload($filetoupload,"../img/products/");
    //   $details->set_productImage($_FILES["productimage"]['name']);
    // }
    DBproductdetails::update($details);
  } else if ($_POST["action"] == 'delete') {
    DBproductdetails::delete($_POST['id']);
  } else {
    $details=new Products();
   
    $details->setName(Sanitization::test_input($_POST["productname"]));
    $details->setLength(Sanitization::test_input($_POST["Length"]));
    $details->setWidth(Sanitization::test_input($_POST["Width"]));
    $details->setQuantity(Sanitization::test_input($_POST["productquantity"]));
    $details->setCL_ID(Sanitization::test_input($_POST["CLID"]));
    $details->setCategoryId(Sanitization::test_input($_POST["productcategoryname"]));
    $details->setSubcategoryId(Sanitization::test_input($_POST["productmaterialSubCategory"]));
    $details->setFinishId(Sanitization::test_input($_POST["Finish"])); 
    $details->setCode(Sanitization::test_input($_POST["ProductCode"]));
    $details->setCabinetType(Sanitization::test_input($_POST["CabinetType"]));
    $details->setMat_Brand(Sanitization::test_input($_POST["matBrand"]));
    $details->setRotation(Sanitization::test_input($_POST["Rotation"]));
    $details->setMat_Category(Sanitization::test_input($_POST["materialCategory"]));
    $details->setMat_Subcategory(Sanitization::test_input($_POST["materialSubCategory"]));
    $details->setThickness(Sanitization::test_input($_POST["Thickness"]));
    $details->setMaterial(Sanitization::test_input($_POST["Material"]));
    $details->setPEB(Sanitization::test_input($_POST["PEB"]));
    $details->setPEB_Thickness(Sanitization::test_input($_POST["PEBthickness"]));
    $details->setSEB(Sanitization::test_input($_POST["SEB"]));
    $details->setSEB_Thickness(Sanitization::test_input($_POST["SEBthickness"]));
    $details->setComments(Sanitization::test_input($_POST["Comments"]));
   
    // if (isset($_FILES["productimage"])) {

    //   $filetoupload = $_FILES["productimage"];
    //   Helper::fileupload($filetoupload,"../img/products/");
    //   $details->set_productImage($_FILES["productimage"]['name']);
    // }
    
    DBproductdetails::insert($details);
  }
  header("location: ../View/inventorydashboard.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  DBitemdetails::selectitem();
  error_log("");
}
