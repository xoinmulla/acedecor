<?php

require "../Model/enq_categorymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/enq_categoryOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST['action'] == 'delete'){
      error_log("Hi I am in delete");
      DBcategory::delete($_POST['id']);
    }else if(isset($_POST['enqcatId'])){
      $category=new Category();
      $category->set_catid(Sanitization::test_input($_POST["enqcatId"])); 
    $category->set_catname(Sanitization::test_input($_POST["catname"]));
    $category->set_catType(Sanitization::test_input($_POST["category_type"]));
    $category->set_catModifiedby(Sanitization::test_input($_POST["itemcatmodifiedby"]));
    $category->set_catcreatedby(Sanitization::test_input($_POST["catcreatedby"]));
    DBcategory::update($category);
    }else{
    $category=new Category();
    $category->set_catname(Sanitization::test_input($_POST["catname"]));
    $category->set_catType(Sanitization::test_input($_POST["category_type"]));
    $category->set_catModifiedby(Sanitization::test_input($_POST["itemcatmodifiedby"]));
    $category->set_catcreatedby(Sanitization::test_input($_POST["catcreatedby"]));
    DBcategory::insert($category); 
 
    }
    header("location:../View/enqcategory.php");
  }
  if($_SERVER["REQUEST_METHOD"] == "GET"){
    DBcategory::selectall();
  }
 
?>





