<?php

require "../Model/item_companydetailsmodel.php";
require "../Utilities/Sanitization.php";
require "../Utilities/Helper.php";
include "../DB Operations/item_compdetailsOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['itemcompid'])) {
    $compdetails = new Item_Companydetails();

    $compdetails->set_itemcompname(Sanitization::test_input($_POST["itemcompname"]));
    $compdetails->set_itemcompdescription(Sanitization::test_input($_POST["itemcompdescription"]));
    $compdetails->set_itemcompaddress(Sanitization::test_input($_POST["itemcompaddress"]));

    // ✅ ADD THIS LINE
    $compdetails->set_itemcomplocation(
      Sanitization::test_input($_POST["itemcomplocation"])
    );

    $compdetails->set_itemcompcreatedby(Sanitization::test_input($_POST["itemcompcreatedby"]));
    $compdetails->set_itemcompmodifiedby(Sanitization::test_input($_POST["itemcompmodifiedby"]));
    $compdetails->set_itemcompaccno(Sanitization::test_input($_POST["itemcompaccno"]));
    $compdetails->set_itemcompaccname(Sanitization::test_input($_POST["itemcompaccname"]));
    $compdetails->set_itemcompaccifsc(Sanitization::test_input($_POST["itemcompaccifsc"]));
    $compdetails->set_itemcompaccmicr(Sanitization::test_input($_POST["itemcompaccmicr"]));
    $compdetails->set_itemcompgstin(Sanitization::test_input($_POST["itemcompgstin"]));
    $compdetails->set_itemcompid(Sanitization::test_input($_POST["itemcompid"]));

    DBitemcompdetails::update($compdetails);
  } else if ($_POST["action"] == 'delete') {
    DBitemcompdetails::delete($_POST['id']);
  } else {
    $compdetails = new Item_Companydetails();
    $compdetails->set_itemcompname(Sanitization::test_input($_POST["itemcompname"]));
    $compdetails->set_itemcompdescription(Sanitization::test_input($_POST["itemcompdescription"]));
    // $compdetails->set_itemcompcontactname(Sanitization::test_input($_POST["itemcontactname"]));
    // $compdetails->set_itemcompcontactno(Sanitization::test_input($_POST["itemcompcontactno"]));
    $compdetails->set_itemcompaddress(Sanitization::test_input($_POST["itemcompaddress"]));
    if ($_FILES["itemcomplogo"]["size"] != 0) {

      $filetoupload = $_FILES["itemcomplogo"];
      Helper::fileupload($filetoupload, "../img/companylogo/");
      $compdetails->set_itemcomplogo($_FILES["itemcomplogo"]['name']);
    }
    $compdetails->set_itemcompcreatedby(Sanitization::test_input($_POST["itemcompcreatedby"]));
    $compdetails->set_itemcompmodifiedby(Sanitization::test_input($_POST["itemcompmodifiedby"]));
    $compdetails->set_itemcompaccno(Sanitization::test_input($_POST["itemcompaccno"]));
    $compdetails->set_itemcompaccname(Sanitization::test_input($_POST["itemcompaccname"]));
    $compdetails->set_itemcompaccifsc(Sanitization::test_input($_POST["itemcompaccifsc"]));
    $compdetails->set_itemcompaccmicr(Sanitization::test_input($_POST["itemcompaccmicr"]));
    $compdetails->set_itemcompgstin(Sanitization::test_input($_POST["itemcompgstin"]));
    $compdetails->set_itemcomplocation(
      Sanitization::test_input($_POST["itemcomplocation"])
    );

    if (!empty($_POST['brand_list'])) {

      $compdetails->set_brandList($_POST["brand_list"]);
    }
    DBitemcompdetails::insert($compdetails);
  }
  header("location: ../View/itemcompany.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['brandId'])) {
    $brandId = Sanitization::test_input($_GET['brandId']);
    error_log($_GET['brandId']);
    DBitemcompdetails::selectcompanybasedonBrandId($brandId);
  } else if (isset($_GET['POID'])) {
    error_log(isset($_GET['POID']));
    $POID = Sanitization::test_input($_GET['POID']);
    DBitemcompdetails::selectcompanybasedonPOID($POID);
  } else if (isset($_GET['id'])) {
    $id = Sanitization::test_input($_GET['id']);
    DBitemcompdetails::getCompanyById($id);
  } else {
    DBitemcompdetails::selectCompany();
  }

}