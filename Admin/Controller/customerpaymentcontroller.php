<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);


require_once "../Model/customerpaymentmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../Utilities/Helper.php";
require_once "../DB Operations/customerpaymentOps.php";
require_once "../Model/expenseModel.php";
require_once "../DB Operations/expenseOps.php";


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    ini_set('display_errors', 0);
    error_reporting(E_ALL);
}
if (isset($_GET['action']) && $_GET['action'] === 'checkQuotePaymentLock') {

    $quoteCode = $_GET['quoteCode'] ?? '';
    $customerCode = $_GET['customerCode'] ?? '';

    $locked = DBpayment::isQuotePaymentLocked($quoteCode, $customerCode);

    echo json_encode(['locked' => $locked]);
    exit;
}



// Detect AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

/* ================= PROJECT INCOME ================= */
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] === "project_income"
) {
    try {
        $pay = new Payment();

        $quoteId = isset($_POST["quoteid"])
            ? trim(Sanitization::test_input($_POST["quoteid"]))
            : null;

        $pay->setQuoteCode($quoteId);

        $pay->set_custid(Sanitization::test_input($_POST["custid"]));
        $pay->set_custname(Sanitization::test_input($_POST["custname"]));

        // ✅ THESE WERE MISSING
        $pay->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
        $pay->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
        error_log('PAID AMT = ' . $pay->get_paidamt());
        $pay->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
        error_log('PENDING AMT = ' . $pay->get_pendingamt());
        $pay->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));

        $pay->set_receivedamt(Sanitization::test_input($_POST["receivedamt"]));
        $pay->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
        $pay->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
        $pay->set_modifiedby("Admin");

        $payment_id = DBpayment::insert($pay);

        // ================= ADD TO EXPENSE TABLE (PROJECT INCOME) =================
        $expense = new Expense();
        $expense->setCategory('Customer');

        $expense->setSubcategoryId(0);                 // Projects (no subcategory)
        $expense->setSubcategoryName('Projects');
        $expense->setAmount($_POST['receivedamt']);
        $expense->setExpenseDate($_POST['paymentdate']);
        $expense->setPaymentType($_POST['paymentmode']);
        $expense->setNotes($_POST['paymentdescription'] ?? 'Project Income');
        $expense->setType('Income');                   // 🔑 VERY IMPORTANT
        $expense->setPaymentId($payment_id);

        DBExpense::insert($expense);


        if ($isAjax) {
            $summary = DBpayment::getCustomerApprovedProjectSummary($_POST['custid']);



            echo json_encode([
                'status' => 'success',
                'message' => 'Project income saved successfully',
                'custid' => $_POST['custid'],
                'total' => $summary['total'],
                'paid' => $summary['paid'],
                'pending' => $summary['pending']
            ]);
            exit;


        }

        header("Location: ../View/customerpaymentView.php?project_income=1");
        exit;

    } catch (Exception $e) {
        if ($isAjax) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            exit;
        }
        throw $e;
    }
}

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] !== "project_income"
) {
    error_log('POST action: ' . $_POST['action']);
    if ($_POST['action'] === 'credit') {
        error_log('POST action: ' . $_POST['action']);
        $custId = $_POST['custId'] ?? null;
        $pending = $_POST['pendingAmount'] ?? null;

        if (!$custId || $pending === null) {
            error_log($custId === null ? 'custId is null' : 'custId: ' . $custId);
            error_log($pending === null ? 'pendingAmount is null' : 'pendingAmount: ' . $pending);
            error_log('Invalid data for credit discount');
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            exit;
        }

        DBpayment::creditdiscountByCustomer($custId, $pending);

        echo json_encode([
            'status' => 'success',
            'message' => 'Credit discount applied successfully'
        ]);
        exit;
    } else if (isset($_POST["paidamt"]) == 0) {
        $admit = new Payment();
        $admit->setQuoteCode(Sanitization::test_input($_POST["quoteid"]));
        $admit->set_custid(Sanitization::test_input($_POST["custid"]));
        $admit->set_paymentid(Sanitization::test_input($_POST["paymentid"]));
        $admit->set_custname(Sanitization::test_input($_POST["custname"]));
        $admit->set_custcontactnumber(Sanitization::test_input($_POST["custcontactno"]));
        $admit->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
        $admit->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
        $admit->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
        $admit->set_receivedamt(Sanitization::test_input($_POST["receivedamt"]));
        $admit->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));
        $admit->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
        $admit->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
        $admit->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
        $admit->set_RTGSno(Sanitization::test_input($_POST["RTGSno"]));
        if (isset($_POST["duedate"])) {
            $admit->set_duedate(Sanitization::test_input($_POST["duedate"]));
        } else {
            $admit->set_duedate(null);
        }
        if (isset($_POST["chequeimg"])) {
            $filetoupload = $_FILES["chequeimg"];
            Helper::fileupload($filetoupload, "../../img/paymentimages/");
        }
        DBpayment::insert($admit);
    } else {
        $admit = new Payment();
        $admit->setQuoteCode(Sanitization::test_input($_POST["quoteid"]));
        $admit->set_custid(Sanitization::test_input($_POST["custid"]));
        $admit->set_paymentid(Sanitization::test_input($_POST["paymentid"]));
        $admit->set_custname(Sanitization::test_input($_POST["custname"]));
        $admit->set_custcontactnumber(Sanitization::test_input($_POST["custcontactno"]));
        $admit->set_totalamt(Sanitization::test_input($_POST["totalamt"]));
        $admit->set_paidamt(Sanitization::test_input($_POST["paidamt"]));
        $admit->set_pendingamt(Sanitization::test_input($_POST["pendingamt"]));
        $admit->set_receivedamt(Sanitization::test_input($_POST["receivedamt"]));
        $admit->set_paymentplan(Sanitization::test_input($_POST["paymentplan"]));
        $admit->set_paymentmode(Sanitization::test_input($_POST["paymentmode"]));
        $admit->set_paymentdescription(Sanitization::test_input($_POST["paymentdescription"]));
        $admit->set_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
        $admit->set_RTGSno(Sanitization::test_input($_POST["RTGSno"]));
        if (isset($_POST["duedate"])) {
            $admit->set_duedate(Sanitization::test_input($_POST["duedate"]));
        } else {
            $admit->set_duedate(null);
        }
        if (isset($_POST["chequeimg"])) {
            $filetoupload = $_FILES["chequeimg"];
            Helper::fileupload($filetoupload, "../../img/paymentimages/");
        }
        DBpayment::update($admit);
    }
    if (!$isAjax) {
        header("location:../View/customerpaymentView.php");
        exit;
    }

}

// if (
//     isset($_GET['action']) &&
//     $_GET['action'] === 'getProjectPaymentSummary'
// ) {
//     $quoteId = $_GET['quoteid'] ?? '';
//     $custId = $_GET['custid'] ?? '';

//     if (!$quoteId || !$custId) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'Invalid project or customer'
//         ]);
//         exit;
//     }

//     $data = DBpayment::getProjectPaymentSummary($quoteId, $custId);

//     echo json_encode([
//         'status' => 'success',
//         'total' => $data['total'] ?? 0,
//         'paid' => $data['paid'] ?? 0,
//         'pending' => $data['pending'] ?? 0
//     ]);
//     exit;
// }

if (
    $_SERVER["REQUEST_METHOD"] === "GET" &&
    isset($_GET["quoteid"], $_GET["custid"])
) {
    DBpayment::viewtransactiondetails(
        $_GET["quoteid"],
        $_GET["custid"]
    );
    exit;
}

if (
    isset($_GET['action']) &&
    $_GET['action'] === 'getCustomerInfo'
) {
    $custId = $_GET['custid'] ?? null;

    if (!$custId) {
        echo json_encode(['error' => 'Customer ID missing']);
        exit;
    }

    $customer = DBpayment::getCustomerInfoById($custId);

    header('Content-Type: application/json');
    echo json_encode($customer);
    exit;
}


if (isset($_GET['action']) && $_GET['action'] === 'getQuotationTotal') {

    $quoteid = Sanitization::test_input($_GET['quoteid']);

    $summary = DBpayment::getQuotePaymentSummary($quoteid);

    echo json_encode([
        "total" => $summary['totalamt'],
        "paid" => $summary['paidamt']
    ]);
    exit;
}
if (
    isset($_GET['action']) &&
    $_GET['action'] === 'getCustomerProjectSummary'
) {
    $custId = $_GET['custid'] ?? '';

    if (!$custId) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid customer'
        ]);
        exit;
    }

    $data = DBpayment::getCustomerApprovedProjectSummary($custId);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'total' => $data['total'],
        'paid' => $data['paid'],
        'pending' => $data['pending']
    ]);
    exit;
}



if (
    isset($_GET['action']) &&
    $_GET['action'] === 'getProjectPaymentSummary'
) {

    $quoteId = $_GET['quoteid'] ?? null;
    $custId = $_GET['custid'] ?? null;

    if (!$quoteId || !$custId) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing quote or customer'
        ]);
        exit;
    }

    $data = DBpayment::getProjectPaymentSummary($quoteId, $custId);

    echo json_encode([
        'status' => 'success',
        'total' => $data['total'],
        'paid' => $data['paid'],
        'pending' => $data['pending']
    ]);
    exit;
}

if (
    isset($_GET['action']) &&
    $_GET['action'] === 'getCustomerFinancialSummary'
) {
    $custId = $_GET['custid'] ?? '';

    if (!$custId) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid customer'
        ]);
        exit;
    }

    $data = DBpayment::getCustomerFinancialSummary($custId);

    echo json_encode([
        'status' => 'success',
        'total' => (float) $data['total'],
        'paid' => (float) $data['paid'],
        'pending' => (float) $data['pending']
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["custid"])) {
    DBpayment::viewtransactiondetailsByCustomer($_GET["custid"]);
    exit;
}


?>