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
    font-family: Arial;
    font-size: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background:#343a40;
    color:#fff;
    padding:10px;
    text-align:center;
}

td {
    border:1px solid #000;
    padding:8px;
}

h2 { margin-bottom:5px; }
h3 { margin-bottom:5px; }

img {
    width:80px;
    height:80px;
    object-fit:contain;
}
    /* =========================================================
   FIXED INPUT LIST PDF TABLE
   Used by:
   WQ - BOQ
   WOQ - BOQ
   ========================================================= */

#inputListTable {
    width: 180mm !important;
    max-width: 180mm !important;
    table-layout: fixed !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
    margin: 0 !important;
}

/* =========================================================
   FIXED COLUMN WIDTHS
   Total = 180mm
   ========================================================= */

#inputListTable col:nth-child(1),
#inputListTable th:nth-child(1),
#inputListTable td:nth-child(1) {
    width: 11mm !important;
    max-width: 11mm !important;
}

#inputListTable col:nth-child(2),
#inputListTable th:nth-child(2),
#inputListTable td:nth-child(2) {
    width: 18mm !important;
    max-width: 18mm !important;
}

#inputListTable col:nth-child(3),
#inputListTable th:nth-child(3),
#inputListTable td:nth-child(3) {
    width: 31mm !important;
    max-width: 31mm !important;
}

#inputListTable col:nth-child(4),
#inputListTable th:nth-child(4),
#inputListTable td:nth-child(4) {
    width: 41mm !important;
    max-width: 41mm !important;
}

#inputListTable col:nth-child(5),
#inputListTable th:nth-child(5),
#inputListTable td:nth-child(5) {
    width: 25mm ;
    max-width: 25mm ;
}

#inputListTable col:nth-child(6),
#inputListTable th:nth-child(6),
#inputListTable td:nth-child(6) {
    width: 16mm !important;
    max-width: 16mm !important;
}

#inputListTable col:nth-child(7),
#inputListTable th:nth-child(7),
#inputListTable td:nth-child(7) {
    width: 13mm !important;
    max-width: 13mm !important;
}

#inputListTable col:nth-child(8),
#inputListTable th:nth-child(8),
#inputListTable td:nth-child(8) {
    width: 25mm !important;
    max-width: 25mm !important;
}


/* =========================================================
   HEADER
   ========================================================= */

#inputListTable th {
    padding: 6px !important;
    text-align: center;
    vertical-align: middle;

    /* IMPORTANT:
       Allow header text to wrap */
    white-space: normal !important;
    overflow-wrap: break-word !important;
    word-wrap: break-word !important;
    word-break: normal !important;

    font-size: 13px;
    line-height: 1.2;
}


/* =========================================================
   BODY CELLS
   ========================================================= */

#inputListTable td {
    padding: 6px !important;
    vertical-align: middle;

    /* IMPORTANT:
       Long values must wrap INSIDE their fixed column */
    white-space: normal !important;
    overflow-wrap: break-word !important;
    word-wrap: break-word !important;
    word-break: normal !important;

    font-size: 13px;
    line-height: 1.25;
}


/* =========================================================
   # COLUMN
   ========================================================= */

#inputListTable th:nth-child(1),
#inputListTable td:nth-child(1) {
    text-align: center !important;
}


/* =========================================================
   IMAGE COLUMN
   ========================================================= */

#inputListTable th:nth-child(2),
#inputListTable td:nth-child(2) {
    text-align: center !important;
    vertical-align: middle !important;
}

#inputListTable td:nth-child(2) img {
    width: 55px !important;
    height: 55px !important;
    max-width: 55px !important;
    max-height: 55px !important;
    object-fit: contain;
}


/* =========================================================
   NAME
   ========================================================= */

#inputListTable th:nth-child(3),
#inputListTable td:nth-child(3) {
    text-align: left !important;
}


/* =========================================================
   DESCRIPTION
   ========================================================= */

#inputListTable th:nth-child(4),
#inputListTable td:nth-child(4) {
    text-align: left !important;

    white-space: normal !important;
    overflow-wrap: break-word !important;
    word-wrap: break-word !important;
}


/* =========================================================
   BRAND
   ========================================================= */

#inputListTable th:nth-child(5),
#inputListTable td:nth-child(5) {
    text-align: center !important;
}


/* =========================================================
   QUANTITY
   ========================================================= */

#inputListTable th:nth-child(6),
#inputListTable td:nth-child(6) {
    text-align: center !important;
}


/* =========================================================
   UNIT
   ========================================================= */

#inputListTable th:nth-child(7),
#inputListTable td:nth-child(7) {
    text-align: center !important;
}


/* =========================================================
   PRICE
   ========================================================= */

#inputListTable th:nth-child(8),
#inputListTable td:nth-child(8) {
    text-align: right !important;

    white-space: normal !important;
    overflow-wrap: break-word !important;
    word-wrap: break-word !important;
}


/* =========================================================
   ROW PAGINATION
   ========================================================= */

#inputListTable tr {
    page-break-inside: avoid !important;
}
";
    if (in_array($fileType, ['itemList', 'quotations']) && empty($_POST['quoteId'])) {
        error_log("❌ quoteId missing in PDF generation");
        exit;
    }
    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

    $html = $_POST['html'] ?? '';

    if (!is_string($html)) {
        $html = '';
    }

    $html = str_replace("\0", '', $html);

    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

    try {

        $pdfPath = '../pdfs/' . $fileType . '/' . $fileName . '.pdf';

        $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

        if (file_exists($pdfPath)) {
            echo "PDF CREATED";
        } else {
            echo "PDF NOT CREATED";
        }

    } catch (\Throwable $e) {

        echo "MPDF ERROR: " . $e->getMessage();

    }
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