<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 0);


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
        'format' => 'A4',
        'orientation' => 'P',
        'margin_top' => 20,
        'margin_bottom' => 20,
        'margin_left' => 15,
        'margin_right' => 15,
    ]);

    $fileType = $_POST['fileType'];
    $fileName = $_POST['fileName'];
    if ($waterMarked == 'true') {
        $mpdf->WriteHTML('<watermarktext content="ACE DECORS" alpha="0.1" />');
    }
    $stylesheet = "
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        background: #fff !important;
        color: #000 !important;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
    }

    th {
        background: #f2f2f2;
    }

    h1, h2, h3 {
        margin: 5px 0;
    }

    button {
        display: none;
    }

    nav, header, footer {
        display: none;
    }
";

    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

    $html = $_POST['html'] ?? '';

    if (!is_string($html)) {
        $html = '';
    }

    $html = str_replace("\0", '', $html);

    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

    $mpdf->Output('../pdfs/' . $fileType . '/' . $fileName . '.pdf', \Mpdf\Output\Destination::FILE);
    error_log($fileType);

    if ($fileType == 'itemList') {
        $Quotation = new Quotation();
        $Quotation->set_quoteId($_POST['quoteId']);
        $Quotation->set_modifiedby($_POST['modifiedby']);
        $Quotation->set_itemListName($fileName . '.pdf');
        DBQuotation::updateFileName($Quotation);

    } else if ($fileType == 'quotations') {
        $Quotation = new Quotation();
        $Quotation->set_quoteId($_POST['quoteId']);
        $Quotation->set_modifiedby($_POST['modifiedby']);
        $Quotation->set_quotePDFName($fileName . '.pdf');
        DBQuotation::updateFileName($Quotation);

    } else if ($fileType == 'purchaseorder') {
        $Purchase = new PurchaseOrder();
        $Purchase->set_purchasePDFName($fileName . '.pdf');
        error_log($fileName . '.pdf');
        DBpurchase::updateFileName($Purchase);
    } else if ($fileType == 'stockinward') {
        if (file_exists($fileName . '.pdf')) {
            unlink($fileName . '.pdf');
        } else {
            $itemstock = new Item_Stock();
            $itemstock->set_stockPDFName($fileName . '.pdf');
            error_log($fileName . '.pdf');
            DBitemstock::updateFileName($itemstock);
        }
    } else if ($fileType == 'supplierpayment') {
        $supplier = new SupplierPayment();
        $supplier->set_supplierId($_POST['supplierId']);
        $supplier->set_modifiedby($_POST['modifiedby']);
        $supplier->set_paymentPDFName($fileName . '.pdf');
        DBsupplierpayment::updateFileName($supplier);
    } else if ($fileType == 'customerpayment') {
        $customer = new Payment();
        $customer->set_custid($_POST['transactioncustcode']);
        $customer->set_modifiedby($_POST['modifiedby']);
        $customer->set_paymentPDFName($fileName . '.pdf');
        DBpayment::updateFileName($customer);
    }
    if (!file_exists('../pdfs/' . $fileType . '/' . $fileName . '.pdf')) {
        error_log("PDF NOT CREATED!");
    }

}