<?php
require "../Model/customerModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/customerOps.php";
require_once "../Model/enq_cat_mappingmodel.php";
require_once "../DB Operations/enq_cat_mappingOps.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['customerId'])) {
    $customer = new customer();
    $customer->set_customerName(Sanitization::test_input($_POST["customerName"]));
    $customer->set_customerPhone(Sanitization::test_input($_POST["customerPhone"]));
    $customer->set_customerEmail(Sanitization::test_input($_POST["customerEmail"]));
    $customer->set_customerAddress(Sanitization::test_input($_POST["customerAddress"]));
    $customer->set_customerCity(Sanitization::test_input($_POST["customerCity"]));
    $customer->set_customerState(Sanitization::test_input($_POST["customerState"]));
    $customer->setCustomerCountry(Sanitization::test_input($_POST["SelectedCountry"]));
    $customer->set_customerDov(Sanitization::test_input($_POST["customerDov"]));
    $customer->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $customer->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    $customer->set_customerId(Sanitization::test_input($_POST["customerId"]));
    $customer->setCustomerCode(Sanitization::test_input($_POST["customerCode"]));
    $words = preg_split("/\s+/", $customer->get_customerName());
    $acronym = "";
    foreach ($words as $w) {
      $acronym .= $w[0];
    }
    $codes = preg_split("/-/", $customer->getCustomerCode());
    $textArray = str_split($codes[2]);
    $id = '';
    foreach ($textArray as $char) {
      if (is_numeric($char)) {
        $id .= $char;
      }
    }
    $customerCode = 'AD-' . substr((str_replace('-', '', $customer->get_customerDov())), 0, 6) . '-' . $acronym . $id;
    $customer->setCustomerCode($customerCode);
    error_log($customerCode);
    DBcustomer::update($customer);



    $enqId = DBcustomer::selectenqbasedonId($customer->get_customerId())->get_enqId();

    // 1️⃣ Delete old mappings
    $db = ConnectDb::getInstance()->getConnection();
    $enqId = (int) DBcustomer::selectenqbasedonId($customer->get_customerId())->get_enqId();

    if ($enqId > 0) {
      $db->query("DELETE FROM enq_cat_mapping WHERE enq_id = $enqId");
    }


    // 2️⃣ Insert new selected ones
    if (isset($_POST['interest_list'])) {
      foreach ($_POST['interest_list'] as $catId) {
        $map = new enqCatMappingModel();
        $map->set_enqId($enqId);
        $map->set_catId($catId);
        DBenqCatMapping::insert($map);
      }
    }


  } else if ($_POST["action"] == 'delete') {

    if (DBcustomer::hasQuotation($_POST["id"])) {
      $_SESSION['error'] = "Cannot delete customer. Quotation already exists.";
      header("location:../View/customer.php");
      exit;
    }

    DBcustomer::delete($_POST["id"]);

  } else {
    $customer = new customer();
    $customer->set_customerName(Sanitization::test_input($_POST["customerName"]));
    $customer->set_customerPhone(Sanitization::test_input($_POST["customerPhone"]));
    $customer->set_customerEmail(Sanitization::test_input($_POST["customerEmail"]));
    $customer->set_customerAddress(Sanitization::test_input($_POST["customerAddress"]));
    $customer->set_customerCity(Sanitization::test_input($_POST["customerCity"]));
    $customer->set_customerState(Sanitization::test_input($_POST["customerState"]));
    $customer->setCustomerCountry(Sanitization::test_input($_POST["SelectCountry"]));
    $customer->set_customerDov(Sanitization::test_input($_POST["customerDov"]));
    $customer->set_enqId(Sanitization::test_input($_POST["enqId"]));
    $customer->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $customer->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    $words = preg_split("/\s+/", $customer->get_customerName());
    $acronym = "";
    foreach ($words as $w) {
      $acronym .= $w[0];
    }
    $customerCode = 'AD-' . substr((str_replace('-', '', $customer->get_customerDov())), 0, 6) . '-' . $acronym;
    $customer->setCustomerCode($customerCode);
    DBcustomer::insert($customer);
  }
  header("location:../View/customer.php");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  DBcustomer::selectcustomer();
}
