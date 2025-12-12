<?php
require "../Model/productDefinitionModel.php";
require "../Utilities/Sanitization.php";
require "../Utilities/Helper.php";
include "../DB Operations/productDefinitionOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['prodDefinition_Id'])){
    $details=new ProductDefinition();
    $details->setProdDefinition_Id(Sanitization::test_input($_POST["prodDefinition_Id"]));
    $details->setProd_Name(Sanitization::test_input($_POST["editedproductName"]));
    $details->setProd_Description(Sanitization::test_input($_POST["editedproductDescription"]));
    $details->setRotation(Sanitization::test_input($_POST["editedGrains"]));
    $details->setOverride(Sanitization::test_input($_POST["editedoverride"]));
    $details->setType(Sanitization::test_input($_POST["editedType"])); 
    $details->setFinish(Sanitization::test_input($_POST["editedFinish"]));
    $details->setProd_Category(Sanitization::test_input($_POST["editedproductCategory"]));
    $details->setProd_SubCategory(Sanitization::test_input($_POST["editedproductSubCategory"]));
    $details->setQuantity(Sanitization::test_input($_POST["editedQuantity"])); 
    $details->setLengthValue(Sanitization::test_input($_POST["editedLength"])); 
    $details->setDimension1(Sanitization::test_input($_POST["editedLengthDimension"])); 
    $details->setWidthValue(Sanitization::test_input($_POST["editedWidth"])); 
    $details->setDimension2(Sanitization::test_input($_POST["editedWidthDimension"])); 
    $details->setDepthValue(Sanitization::test_input($_POST["editedDepth"]));
    $details->setDimension3(Sanitization::test_input($_POST["editedDepthDimension"]));
    $formula_string= $details->getLengthValue() .'*'. $details->getDimension1()
     .'-'. $details->getWidthValue() .'*'. $details->getDimension2()
     .'-'. $details->getDepthValue() .'*'. $details->getDimension3();
    error_log($formula_string);
    $details->setCLFormula($formula_string);
    $details->setCW($formula_string);
    $details->setGL(Sanitization::test_input($_POST["editedGLW"]));
    $details->setFL(Sanitization::test_input($_POST["editedFL"]));
    $details->setBL(Sanitization::test_input($_POST["editedBL"]));
    $details->setRL(Sanitization::test_input($_POST["editedRL"]));
    $details->setRW(Sanitization::test_input($_POST["editedRW"]));
    $details->setEB_LW(Sanitization::test_input($_POST["editedEB_LW"]));
    $details->setCreatedby(Sanitization::test_input($_POST["editedproductcreatedby"]));
    $details->setModifiedby(Sanitization::test_input($_POST["editedproductmodifiedby"]));
    DBProductDefinition::update($details);
  } else if ($_POST["action"] == 'delete') {
    DBProductDefinition::delete($_POST['id']);
  } else {
    $details=new ProductDefinition();
    $details->setProd_Name(Sanitization::test_input($_POST["productName"]));
    $details->setProd_Description(Sanitization::test_input($_POST["productDescription"]));
    $details->setRotation(Sanitization::test_input($_POST["Grains"]));
    $details->setOverride(Sanitization::test_input($_POST["override"]));
    $details->setType(Sanitization::test_input($_POST["CabinetType"])); 
    $details->setFinish(Sanitization::test_input($_POST["Finish"]));
    $details->setProd_Category(Sanitization::test_input($_POST["productCategory"]));
    $details->setProd_SubCategory(Sanitization::test_input($_POST["productSubCategory"]));
    $details->setQuantity(Sanitization::test_input($_POST["Quantity"])); 
    $details->setLengthValue(Sanitization::test_input($_POST["Lengthvalue"])); 
    $details->setDimension1(Sanitization::test_input($_POST["Dimension1"])); 
    $details->setWidthValue(Sanitization::test_input($_POST["Widthvalue"])); 
    $details->setDimension2(Sanitization::test_input($_POST["Dimension2"])); 
    $details->setDepthValue(Sanitization::test_input($_POST["Depthvalue"]));
    $details->setDimension3(Sanitization::test_input($_POST["Dimension3"]));
    $formula_string= $details->getLengthValue() .'*'. $details->getDimension1()
     .'-'. $details->getWidthValue() .'*'. $details->getDimension2()
     .'-'. $details->getDepthValue() .'*'. $details->getDimension3();
    error_log($formula_string);
    $details->setCLFormula($formula_string);
    $details->setCW($formula_string);
    $details->setGL(Sanitization::test_input($_POST["GL"]));
    $details->setFL(Sanitization::test_input($_POST["FL"]));
    $details->setBL(Sanitization::test_input($_POST["BL"]));
    $details->setRL(Sanitization::test_input($_POST["RL"]));
    $details->setRW(Sanitization::test_input($_POST["RW"]));
    $details->setEB_LW(Sanitization::test_input($_POST["EB_LW"]));
    $details->setCreatedby(Sanitization::test_input($_POST["productcreatedby"]));
    $details->setModifiedby(Sanitization::test_input($_POST["productmodifiedby"]));
    DBProductDefinition::insert($details);
  }
  header("location: ../View/product_Definition.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $catId=Sanitization::test_input($_GET['catId']);
  $finishId=Sanitization::test_input($_GET['finishId']);
  $subcatId=Sanitization::test_input($_GET['subcatId']);
  $typeId=Sanitization::test_input($_GET['typeId']);
  DBProductDefinition::selectproduct($catId,$subcatId,$finishId,$typeId);
  error_log("");
}
