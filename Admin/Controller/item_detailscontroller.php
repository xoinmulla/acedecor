<?php
require "../Model/item_detailsmodel.php";
require "../Utilities/Sanitization.php";
require "../Utilities/Helper.php";
include "../DB Operations/item_detailsOps.php";

// Helper function to safely read POST values
function getPostValue($key)
{
  return isset($_POST[$key]) ? Sanitization::test_input($_POST[$key]) : '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

  // ================== UPDATE EXISTING ITEM ==================
  if (isset($_POST['itemid'])) {

    $details = new Item_Details();

    $details->set_itemname(getPostValue("itemname"));
    $details->set_itemdescription(getPostValue("itemdescription"));
    $details->set_itemcatid(getPostValue("itemCategory"));
    $details->set_itemsubcatid(getPostValue("subCategory"));
    $details->set_itemcompid(getPostValue("company"));
    $details->set_packingunit(getPostValue("itempu"));
    $details->set_MRP(getPostValue("itemMRP"));
    $details->set_itemAmount(getPostValue("itemAmount"));
    $details->set_size(getPostValue("itemsize"));
    $details->set_itemhsncode(getPostValue("itemhsncode"));
    $details->set_itemarticleno(getPostValue("itemarticleNo"));

    $details->set_itemGST(getPostValue("itemGST"));
    $details->set_itemDiscount(getPostValue("itemDiscount"));
    $details->set_itemPrice(getPostValue("itemPrice"));
    $details->set_itemTotalValue(getPostValue("itemTotalValue"));

    $details->set_itemunitId(getPostValue("unit"));
    $details->set_itemunitFactorId(getPostValue("unitFactor"));

    if (!empty($_FILES["itemimage"]["name"])) {
      $filetoupload = $_FILES["itemimage"];
      Helper::fileupload($filetoupload, "../img/items/");
      $details->set_itemimage($_FILES["itemimage"]['name']);
    }

    $details->set_itemcreatedby(getPostValue("itemcreatedby"));
    $details->set_itemmodifiedby(getPostValue("itemmodifiedby"));
    $details->set_itemid(getPostValue("itemid"));

    DBitemdetails::update($details);

    if ($isAjax) {
      echo json_encode(["status" => "success", "message" => "Item updated successfully"]);
      exit();
    }

    header("Location: ../View/inventory.php");
    exit();
  }

  // ================== DELETE ITEM ==================
  if (isset($_POST["action"]) && $_POST["action"] == 'delete') {
    DBitemdetails::delete($_POST['id']);

    if ($isAjax) {
      echo json_encode(["status" => "success", "message" => "Item deleted"]);
      exit();
    }

    header("Location: ../View/inventory.php");
    exit();
  }

  // ================== INSERT NEW ITEM ==================
  $details = new Item_Details();

  $details->set_itemname(getPostValue("itemname"));
  $details->set_itemdescription(getPostValue("itemdescription"));
  $details->set_itemcatid(getPostValue("itemCategory"));
  $details->set_itemsubcatid(getPostValue("subCategory"));
  $details->set_itemcompid(getPostValue("company"));
  $details->set_packingunit(getPostValue("itempu"));
  $details->set_MRP(getPostValue("itemMRP"));
  $details->set_itemAmount(getPostValue("itemAmount"));
  $details->set_size(getPostValue("itemsize"));
  $details->set_itemhsncode(getPostValue("itemhsncode"));
  $details->set_itemarticleno(getPostValue("itemarticleNo"));

  $details->set_itemGST(getPostValue("itemGST"));
  $details->set_itemDiscount(getPostValue("itemDiscount"));
  $details->set_itemPrice(getPostValue("itemPrice"));
  $details->set_itemTotalValue(getPostValue("itemTotalValue"));

  $details->set_itemunitId(getPostValue("unit"));
  $details->set_itemunitFactorId(getPostValue("unitFactor"));

  if (!empty($_FILES["itemimage"]["name"])) {
    $filetoupload = $_FILES["itemimage"];
    Helper::fileupload($filetoupload, "../img/items/");
    $details->set_itemimage($_FILES["itemimage"]['name']);
  }

  $details->set_itemcreatedby(getPostValue("itemcreatedby"));
  $details->set_itemmodifiedby(getPostValue("itemmodifiedby"));

  $insertResult = DBitemdetails::insert($details);

  // ================== SEND JSON BACK FOR AJAX ==================
  if ($isAjax) {
    echo json_encode($insertResult);   // result contains status + message
    exit();
  }

  header("Location: ../View/inventory.php");
  exit();
}


// ================== GET REQUEST HANDLERS ==================
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  // 🧩 Single item fetch (for infoitemid)
  if (isset($_GET['infoitemid']) && !empty($_GET['infoitemid'])) {
    $itemid = Sanitization::test_input($_GET['infoitemid']);
    DBitemdetails::getallItemdetailsbasedonID($itemid);
    exit(); // ✅ Ensure no further output
  }

  // 🧩 Fetch items by category, subcategory, and brand
  if (!empty($_GET['catId']) && !empty($_GET['subcatId']) && !empty($_GET['brandId'])) {
    $catId = Sanitization::test_input($_GET['catId']);
    $subcatId = Sanitization::test_input($_GET['subcatId']);
    $brandId = Sanitization::test_input($_GET['brandId']);
    DBitemdetails::selectitem($catId, $subcatId, $brandId);
    exit();
  }

  // 🧩 Fetch items by project and brand
  if (!empty($_GET['projId']) && !empty($_GET['brandId']) && empty($_GET['catId']) && empty($_GET['subcatId'])) {
    $projId = Sanitization::test_input($_GET['projId']);
    $brandId = Sanitization::test_input($_GET['brandId']);
    DBitemdetails::selectitembasedonProj($projId, $brandId);
    exit();
  }

  // 🧩 Fetch items by category + subcategory only
  if (!empty($_GET['catId']) && !empty($_GET['subcatId']) && empty($_GET['projId']) && empty($_GET['brandId'])) {
    $catId = Sanitization::test_input($_GET['catId']);
    $subcatId = Sanitization::test_input($_GET['subcatId']);
    DBitemdetails::selectitembasedonCatId($catId, $subcatId);
    exit();
  }

  // 🧩 Default: all items
  DBitemdetails::selectallitems();
  exit();
}

?>