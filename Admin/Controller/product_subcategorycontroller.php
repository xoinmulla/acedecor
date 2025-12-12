<?php

require "../Model/product_subcategorymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/product_subcategoryOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['productsubcatid'])){
    $category=new Product_subcategory();
   
    $category->set_productsubcatname(Sanitization::test_input($_POST["productsubcatname"]));
    $category->set_productsubcatdescription(Sanitization::test_input($_POST["productsubcatdescription"]));
    $category->set_productsubcatcreatedby(Sanitization::test_input($_POST["productsubcatcreatedby"]));
    $category->set_productsubcatmodifiedby(Sanitization::test_input($_POST["productsubcatmodifiedby"]));
    $category->set_productsubcatid(Sanitization::test_input($_POST["productsubcatid"]));
    $category->set_productcatid(Sanitization::test_input($_POST["productcatid"]));
    DBproductsubcategory::update($category);
    }else if($_POST["action"]=='delete'){
      DBproductsubcategory::delete($_POST["id"]); 
    }else{
      $category=new Product_subcategory();
      $category->set_productcatid(Sanitization::test_input($_POST["productcatid"]));
    $category->set_productsubcatname(Sanitization::test_input($_POST["productsubcatname"]));
    $category->set_productsubcatdescription(Sanitization::test_input($_POST["productsubcatdescription"]));
    $category->set_productsubcatcreatedby(Sanitization::test_input($_POST["productsubcatcreatedby"]));
    $category->set_productsubcatmodifiedby(Sanitization::test_input($_POST["productsubcatmodifiedby"]));
      DBproductsubcategory::insert($category); 
    }
    header("location:../View/productsubcategory.php");
  }
  if($_SERVER["REQUEST_METHOD"]=="GET"){
    DBproductsubcategory::selectproductsubcategory($_GET['productcatid']);
  }
?>



