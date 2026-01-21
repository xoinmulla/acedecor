<?php
header('Content-Type: application/json');
require "../Model/quotationModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/quotationOps.php";
require_once "../DB Operations/lineItemOps.php";
require_once "../Model/quoteLineItemModel.php";
require_once "../Model/projectModel.php";
require_once "../DB Operations/projectOps.php";
require_once "../Model/customerpaymentmodel.php";
require_once "../DB Operations/customerpaymentOps.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['obj'])) {
        $value = $_POST['obj'];
        error_log(" hii" . $value[0]['itemquantity']);
        $quotation = new Quotation();
        $quotation->set_enqId(Sanitization::test_input($value[0]['enqId']));
        $quotation->setCatId(Sanitization::test_input($value[0]['enqCategory']));
        $quotation->set_customerId(Sanitization::test_input($value[0]['customerId']));
        $quotation->set_quoteType(Sanitization::test_input($value[0]['quoteType']));
        $quotation->set_quoteStatus(Sanitization::test_input('pending'));
        $quotation->set_createdby(Sanitization::test_input($value[0]['createdby']));
        $quotation->set_modifiedby(Sanitization::test_input($value[0]['createdby']));
        $quotation->setQuoteValue(Sanitization::test_input($value[0]['quoteValue']));
        $quotation->setInputType(Sanitization::test_input($value[0]['inputType']));
        error_log($quotation->getQuoteValue());
        $customerCode = Sanitization::test_input($value[0]['customerCode']);
        $createdby = $quotation->get_createdby();
        $codes = preg_split("/-/", $customerCode);
        $quoteCode = $codes[2];
        $QuoteFor = Sanitization::test_input($value[0]['encatName']);
        $words = preg_split("/\s+/", $QuoteFor);
        $acronym = "";
        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        $quoteCode .= '-' . $acronym;
        $quotation->setQuoteCode($quoteCode);
        error_log($quoteCode);
        $quoteId = DBQuotation::insert($quotation);
        foreach ($value as $key => $value) {
            error_log("hiii" . $value['itemCategory']);

            $lineItem = new lineItem();

            // basic IDs / names
            $lineItem->set_quoteId($quoteId);
            $lineItem->set_inputType($value['inputType']);
            $lineItem->set_itemcatid($value['itemCategory']);
            $lineItem->set_itemsubcatid($value['itemsubCategory']);
            $lineItem->set_itemid(Sanitization::test_input($value['itemid']));
            $lineItem->set_InputName(Sanitization::test_input($value['selectedItemName']));

            // quantity & MRP
            $qty = floatval($value['itemquantity'] ?? 0);
            $mrp = floatval($value['itemppMRP'] ?? 0);
            $gst = floatval($value['GST'] ?? 0);

            $lineItem->set_itemquantity($qty);
            $lineItem->set_ppMRP($mrp);

            // totals coming from customer quote modal
            $totalAmount = floatval($value['totalAmount'] ?? 0);   // MRP × qty × unitFactor
            $companyPrice = floatval($value['companyPrice'] ?? 0);   // TOTAL company price
            $totalValue = floatval($value['totalValue'] ?? 0);   // SPU logic total value
            $tradePrice = floatval($value['tradePrice'] ?? 0);   // TOTAL trade price

            $lineItem->set_totalAmount($totalAmount);
            $lineItem->set_totalValue($totalValue);
            $lineItem->set_companyPrice($companyPrice);   // we’ll store this in `amount` column
            $lineItem->set_totalPrice($tradePrice);       // we’ll store this in `totalPrice` column

            // Discount: tradeDiscount if present, else companyDiscount, else 0
            $tradeDis = floatval($value['tradeDiscount'] ?? 0);
            $companyDis = floatval($value['companyDiscount'] ?? 0);
            $discount1 = $tradeDis > 0 ? $tradeDis : $companyDis;

            $lineItem->set_discount1($discount1);

            // calculate discount amount on server
            $discount1Amt = ($totalAmount * $discount1) / 100.0;
            $lineItem->set_discount1Amt($discount1Amt);

            // GST / GST amount
            $lineItem->set_GST($gst);
            $GSTAmount = (($totalAmount - $discount1Amt) * $gst) / 100.0;
            $lineItem->set_GSTAmt($GSTAmount);

            // optional: store stock/value field if present
            $lineItem->set_value(floatval($value['value'] ?? 0));

            // audit
            $lineItem->set_createdby(Sanitization::test_input($createdby));
            $lineItem->set_modifiedby(Sanitization::test_input($createdby));

            error_log("CALC: qId=$quoteId, item={$value['selectedItemName']}, TotalAmt=$totalAmount, Comp=$companyPrice, TVal=$totalValue, TPrice=$tradePrice, Disc%=$discount1, DiscAmt=$discount1Amt, GSTAmt=$GSTAmount");

            DBLineItem::insert($lineItem);


        }

    } else if (isset($_POST['quoteid'])) {
        $quotation = new Quotation();
        $quotation->set_quoteId($_POST['quoteid']);
        $quotation->setUnitId(Sanitization::test_input($_POST['unit']));
        $quotation->set_customerId(Sanitization::test_input($_POST['customerCode']));
        $quotation->set_customerName(Sanitization::test_input($_POST['customeName']));
        $quotation->setQuantity(Sanitization::test_input($_POST['quantity']));
        $quotation->setQuoteValue(Sanitization::test_input($_POST['QuoteAmount']));
        $quotation->set_quoteType(Sanitization::test_input($_POST['quoteType']));
        $quotation->set_quoteStatus(Sanitization::test_input($_POST['quoteStatus']));
        $quotation->set_quoteDescription(Sanitization::test_input($_POST['quoteDescription']));
        $quotation->set_quoteComments(Sanitization::test_input($_POST['quoteComments']));
        $quotation->set_modifiedby(Sanitization::test_input($_POST['modifiedby']));
        DBQuotation::update($quotation);
        if ($_POST['quoteStatus'] == 'Approved') {
            $project = new Project();

            $project->set_custid(Sanitization::test_input($_POST["customerCode"]));
            $project->set_quoteid($_POST["quoteCode"]);     // project.quoteId stores quoteCode
            $project->set_quotecode($_POST["quoteCode"]);  // keep model consistent

            $project->set_quoteamt(Sanitization::test_input($_POST["QuoteAmount"]));
            $project->set_custName(Sanitization::test_input($_POST["customeName"]));

            // $project->set_projectstatus(Sanitization::test_input($_POST["projectstatus"]));
            $date = date('my h:i:s a', time());
            $custname = DBproject::selectcustomer($project->get_custid());
            $customername = $custname->get_customerName();
            $words = preg_split("/\s+/", $customername);
            $acronym = "";
            foreach ($words as $w) {
                $acronym .= $w[0];
            }
            $projectCode = 'AD-PROJ-' . substr((str_replace('-', '', $date)), 0, 5) . '-' . $acronym;
            $project->set_projectCode($projectCode);
            DBproject::insert($project);

            $admit = new Payment();
            $admit->setQuoteCode(Sanitization::test_input($_POST["quoteCode"]));
            $admit->set_custid(Sanitization::test_input($_POST["customerCode"]));
            $admit->set_totalamt(Sanitization::test_input($_POST["QuoteAmount"]));
            $admit->set_paidamt(0);
            $admit->set_pendingamt(Sanitization::test_input($_POST["QuoteAmount"]));
            $admit->set_receivedamt(0);
            $admit->set_paymentplan(0);
            $admit->set_paymentmode(0);
            $admit->set_paymentdescription(0);
            $admit->set_modifiedby(0);
            $admit->set_RTGSno(0);
            if (isset($_POST["duedate"])) {
                $admit->set_duedate(0);
            } else {
                $admit->set_duedate(null);
            }
            if (isset($_POST["chequeimg"])) {
                $filetoupload = $_FILES["chequeimg"];
                Helper::fileupload($filetoupload, "../../img/paymentimages/");
            }
            // $filename="". $admit->get_custname().date("Y-m-d").".pdf";
            // $admit->set_paymentreceipt($filename);
            DBpayment::insert($admit);
        }
    } else if (isset($_POST["action"])) {

        switch ($_POST["action"]) {

            // ✅ Delete whole quotation
            case 'delete':

                $quoteId = intval($_POST['id']);

                // 🔐 Fetch quote status before delete
                $quote = DBQuotation::getQuotations($quoteId);

                if ($quote && strtolower($quote->get_quoteStatus()) === 'approved') {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Approved quotation cannot be deleted'
                    ]);
                    exit;
                }

                DBQuotation::delete($quoteId);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Quotation deleted successfully'
                ]);
                exit;


            // ✅ Update line item
            case 'update_lineitem':
                $response = DBQuotation::updateLineItem($_POST);
                echo json_encode($response);
                exit;

            // ✅ Delete line item
            case 'delete_lineitem':
                $response = DBQuotation::deleteLineItem($_POST['id']);
                echo json_encode($response);
                exit;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
                exit;
        }
    }

    // ✅ only redirect if no AJAX action
    if (!isset($_POST["action"])) {
        header("location:../View/quotationView.php");
    }


    header("location:../View/quotationView.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['custId'])) {
        echo json_encode(DBQuotation::getquotationdetailsbasedonCustId($_GET['custId']));

    }
}
?>