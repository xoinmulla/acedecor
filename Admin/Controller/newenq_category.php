<?php

require "../Model/enq_categorymodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/enq_categoryOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['action'])) {
      if($_POST['action'] == 'delete'){
        DBcategory::delete($_POST['id']);
      }else{
    $category=new Category();
    $category->set_catname(Sanitization::test_input($_POST["catname"]));
    $category->set_catdescription(Sanitization::test_input($_POST["catdescription"]));
    $category->set_catcreatedby(Sanitization::test_input($_POST["catcreatedby"]));
    DBcategory::insert($category);
      }
  }
}
  
?>