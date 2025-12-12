<?php
require_once("../vendor/autoload.php");
require_once("../Model/quotationModel.php");
require_once("../DB Operations/quotationOps.php");
require_once("../DB Operations/purchaseorderOps.php");
require_once("../DB Operations/item_stocksOps.php");
require_once("../DB Operations/supplierpaymentOps.php");
require_once("../DB Operations/customerpaymentOps.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $waterMarked = $_POST['waterMarked'];
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'showWatermarkText' => $waterMarked,
        'orientation' => 'P',
        'autoPadding' => 'true',
        'collapseBlockMargins' => 'false',
        'defaultheaderline' => '2',
    ]);
    $fileType = $_POST['fileType'];
    $fileName = $_POST['fileName'];
    if ($waterMarked == 'true') {
        $mpdf->WriteHTML('<watermarktext content="ACE DECORS" alpha="0.1" />');
    }
    $mpdf->WriteHTML($_POST['html'], \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output('../pdfs/' . $fileType . '/' . $fileName . '.pdf', \Mpdf\Output\Destination::FILE);
error_log($fileType);
   
    if($fileType=='itemList'){
        $Quotation= new Quotation();
        $Quotation->set_quoteId($_POST['quoteId']);
        $Quotation->set_modifiedby($_POST['modifiedby']);
    $Quotation->set_itemListName($fileName.'.pdf');
    DBQuotation::updateFileName($Quotation);

    }else if ($fileType=='quotations'){
        $Quotation= new Quotation();
        $Quotation->set_quoteId($_POST['quoteId']);
        $Quotation->set_modifiedby($_POST['modifiedby']);
    $Quotation->set_quotePDFName($fileName.'.pdf');
    DBQuotation::updateFileName($Quotation);
    
    }else if ($fileType=='purchaseorder'){
        $Purchase= new PurchaseOrder();
        $Purchase->set_purchasePDFName($fileName.'.pdf');
        error_log($fileName.'.pdf');
        DBpurchase::updateFileName($Purchase);
    }
    else if ($fileType=='stockinward'){
        if(file_exists($fileName.'.pdf')){
            unlink($fileName.'.pdf');
        }else{
             $itemstock= new Item_Stock();
            $itemstock->set_stockPDFName($fileName.'.pdf');
            error_log($fileName.'.pdf');
            DBitemstock::updateFileName($itemstock);
        }
    }else if ($fileType=='supplierpayment'){
        $supplier= new SupplierPayment();
        $supplier->set_supplierId($_POST['supplierId']);
        $supplier->set_modifiedby($_POST['modifiedby']);
        $supplier->set_paymentPDFName($fileName.'.pdf');
        DBsupplierpayment::updateFileName($supplier);
    }
    else if ($fileType=='customerpayment'){
        $customer= new Payment();
        $customer->set_custid($_POST['transactioncustcode']);
        $customer->set_modifiedby($_POST['modifiedby']);
        $customer->set_paymentPDFName($fileName.'.pdf');
        DBpayment::updateFileName($customer);
    }
  
}