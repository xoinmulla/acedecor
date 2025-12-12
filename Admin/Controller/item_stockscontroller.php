<?php
require "../Model/item_stocksmodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/item_stocksOps.php";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      error_log("hiii");
      if (isset($_POST['StockId'])!='') {
          // error_log($_POST['obj']);
          // $value=$_POST['obj'];
          // foreach ($value as $key=>$value) 
          $stock=new Item_Stock();
          $stock->set_POID(Sanitization::test_input($_POST["POID"]));
          $stock->set_StockId(Sanitization::test_input($_POST["StockId"]));
          $stock->set_InvoiceNo(Sanitization::test_input($_POST["InvoiceNo"]));
          // $stock->set_barcodeimg(Sanitization::test_input($_POST["barcode"]));
          $stock->set_quantity(Sanitization::test_input($_POST["quantity"]));
          $stock->set_itemid(Sanitization::test_input($_POST["itemid"]));
          $stock->set_price(Sanitization::test_input($_POST["price"]));
          $stock->set_unit(Sanitization::test_input($_POST["unit"]));
          $stock->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
          $stock->setItemCode(Sanitization::test_input($_POST["ItemCode"]));
          $stock->setItemname(Sanitization::test_input($_POST["ItemName"]));
          // $stock->set_othercharges(Sanitization::test_input($value["charges"]));
          // $stock->set_discount(Sanitization::test_input($value["discount"]));
          // $stock->set_CD(Sanitization::test_input($value["CD"]));
          // $stock->set_taxablevalue(Sanitization::test_input($value["taxablevalue"]));
          // $stock->set_IGST(Sanitization::test_input($value["IGST"]));
          // $stock->set_GSTamt(Sanitization::test_input($value["GSTamt"]));
          $stock->set_ReceivedQty(Sanitization::test_input($_POST["ReceivedQty"]));
          $stock->set_ReceivedQtyAmt(Sanitization::test_input($_POST["ReceivedQtyAmt"]));
          $stock->set_GST(Sanitization::test_input($_POST["GST"]));
          $stock->set_BalanceQty(Sanitization::test_input($_POST["BalanceQty"]));
          
          DBitemstock::update($stock);
      } elseif ($_POST["action"] == 'delete') {
          DBitemstock::delete($_POST["id"]);
      } else {
          $stock=new Item_Stock();
          $stock->set_POID(Sanitization::test_input($_POST["POID"]));
          $stock->set_StockId(Sanitization::test_input($_POST["StockId"]));
          $stock->set_InvoiceNo(Sanitization::test_input($_POST["InvoiceNo"]));
          // $stock->set_barcodeimg(Sanitization::test_input($_POST["barcode"]));
          $stock->set_quantity(Sanitization::test_input($_POST["quantity"]));
          $stock->set_itemid(Sanitization::test_input($_POST["itemid"]));
          $stock->set_price(Sanitization::test_input($_POST["price"]));
          $stock->set_unit(Sanitization::test_input($_POST["unit"]));
          $stock->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
          $stock->setItemCode(Sanitization::test_input($_POST["ItemCode"]));
          $stock->setItemname(Sanitization::test_input($_POST["ItemName"]));
          // $stock->set_othercharges(Sanitization::test_input($value["charges"]));
          // $stock->set_discount(Sanitization::test_input($value["discount"]));
          // $stock->set_CD(Sanitization::test_input($value["CD"]));
          // $stock->set_taxablevalue(Sanitization::test_input($value["taxablevalue"]));
          // $stock->set_IGST(Sanitization::test_input($value["IGST"]));
          // $stock->set_GSTamt(Sanitization::test_input($value["GSTamt"]));
          $stock->set_ReceivedQty(Sanitization::test_input($_POST["ReceivedQty"]));
          $stock->set_ReceivedQtyAmt(Sanitization::test_input($_POST["ReceivedQtyAmt"]));
          $stock->set_GST(Sanitization::test_input($_POST["GST"]));
          $stock->set_BalanceQty(Sanitization::test_input($_POST["BalanceQty"]));
          DBitemstock::insert($stock);
      }
      // error_log($value['StockId']);
  

  header("location: ../View/itemstocks.php");
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"]) && !isset($_GET["POID"])){
        $ItemId=Sanitization::test_input($_GET['id']);
        DBitemstock::viewinwarddetails($ItemId);
    }else if(isset($_GET["ItemCode"])){
        
        $ItemCode=Sanitization::test_input($_GET['ItemCode']);
        DBitemstock::getStockListbasedonItemCode($ItemCode);
    }
    else{
        $PurchaseId=Sanitization::test_input($_GET["POID"]);
        DBitemstock::viewinwarddetailsbasedonID($_GET["id"],$PurchaseId);
    }
  }
?>