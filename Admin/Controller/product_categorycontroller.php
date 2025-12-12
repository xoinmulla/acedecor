<?php

require "../Model/product_categorymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/product_categoryOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['productcatid'])){
    $category=new Product_Category();
   
    $category->set_productcatname(Sanitization::test_input($_POST["productcatname"]));
    $category->set_productcatdescription(Sanitization::test_input($_POST["productcatdescription"]));
    $category->set_productcatcreatedby(Sanitization::test_input($_POST["productcatcreatedby"]));
    $category->set_productcatmodifiedby(Sanitization::test_input($_POST["productcatmodifiedby"]));
    $category->set_productcatid(Sanitization::test_input($_POST["productcatid"]));
    DBproductcategory::update($category);
    }else if($_POST["action"]=='delete'){
      DBproductcategory::delete($_POST["id"]); 
    }else{
      $category=new Product_Category();
   
    $category->set_productcatname(Sanitization::test_input($_POST["productcatname"]));
    $category->set_productcatdescription(Sanitization::test_input($_POST["productcatdescription"]));
    $category->set_productcatcreatedby(Sanitization::test_input($_POST["productcatcreatedby"]));
    $category->set_productcatmodifiedby(Sanitization::test_input($_POST["productcatmodifiedby"]));
      DBproductcategory::insert($category); 
    }
    header("location:../View/productcategory.php");
  }
  if($_SERVER["REQUEST_METHOD"]=="GET"){
    DBproductcategory::selectproductcategory();
  }
?>



