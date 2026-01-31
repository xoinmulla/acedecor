<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once("../Model/customerpaymentmodel.php");
require_once "../DB Operations/expenseOps.php";


class DBpayment
{
    public static function insert($payObj)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "INSERT INTO customerpaymentinfo
(quotation_id, customer_id, total_amount, received_amount,
 payment_plan, payment_mode, payment_description, due_date, modified_by)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
";


        $stmt = $conn->prepare($sql);
        error_log("customerpaymentOps.php: In function 'insert':");

        // ✅ Assign to variables (IMPORTANT)
        $quoteCode = $payObj->getQuoteCode();
        $custId = $payObj->get_custid();
        $totalAmt = (float) $payObj->get_totalamt();
        $received = (float) $payObj->get_receivedamt();
        $plan = $payObj->get_paymentplan();
        $mode = $payObj->get_paymentmode();
        $desc = $payObj->get_paymentdescription();
        $dueDate = $payObj->get_duedate();
        $modifiedBy = $payObj->get_modifiedby();

        $stmt->bind_param(
            "ssddsssss",
            $quoteCode,
            $custId,
            $totalAmt,
            $received,
            $plan,
            $mode,
            $desc,
            $dueDate,
            $modifiedBy
        );


        $stmt->execute();
    }

    public static function getAllcustomerpayment()
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
    SELECT
        C.customerCode AS customerId,
        C.customerName AS customername,
        C.customerContactNumber,
        C.customerAddress,
        C.customerDOV,
        P.DOE AS lastPaymentDate,

        Q.total_quotes AS TotalAmt,
        IFNULL(P.total_paid, 0) AS PaidAmt,
        IFNULL(P.total_discount, 0) AS creditDiscount,

        (
    Q.total_quotes
    - IFNULL(P.total_paid, 0)
    - IFNULL(P.total_discount, 0)
) AS PendingAmt,

IFNULL(E.total_expense, 0) AS Expenditure


    FROM customer C

    /* 🔹 QUOTATION SUMMARY (1 ROW PER CUSTOMER) */
    JOIN (
        SELECT
            customerId,
            SUM(quoteValue) AS total_quotes
        FROM quotation_details
        WHERE quo_status = 'Approved'
        GROUP BY customerId
    ) Q ON Q.customerId = C.customerId

    /* 🔹 PAYMENT SUMMARY (1 ROW PER CUSTOMER) */
    LEFT JOIN (
        SELECT
            customer_id,
            SUM(received_amount) AS total_paid,
            SUM(creditDiscount) AS total_discount,
            MAX(modifieddate) AS DOE
        FROM customerpaymentinfo
        GROUP BY customer_id
    ) P ON P.customer_id = C.customerCode

    LEFT JOIN (
    SELECT
        P.custId AS customerId,
        SUM(E.amount) AS total_expense
    FROM expense E
    JOIN projects P ON P.projectId = E.project_id
    WHERE E.category = 'Projects'
    GROUP BY P.custId
) E ON E.customerId = C.customerCode


    ORDER BY C.customerName
    ";

        $result = $conn->query($sql);
        $customerList = [];

        while ($row = $result->fetch_assoc()) {

            $customer = new Payment();
            $customer->set_custid($row['customerId']);
            $customer->set_custname($row['customername']);
            $customer->set_custcontactnumber($row['customerContactNumber']);
            $customer->setcustomerAddress($row['customerAddress']);
            $customer->setcustomerDOV(date('d/m/Y', strtotime($row['customerDOV'])));
            $lastPaymentDate = $row['lastPaymentDate'];
            $customer->set_modifiedon(
                $lastPaymentDate ? date('d/m/Y', strtotime($lastPaymentDate)) : ''
            );
            $customer->set_totalamt($row['TotalAmt']);
            $customer->set_paidamt($row['PaidAmt']);
            $customer->set_receivedamt($row['PaidAmt']);
            $customer->set_pendingamt($row['PendingAmt']);
            $customer->set_creditdiscount($row['creditDiscount']);

            // Customer-wise expense (already correct)
            $customer->set_expenditure($row['Expenditure']);


            $customerList[] = $customer;
        }

        return $customerList;
    }
    public static function getCustomerInfoById($custId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "
        SELECT 
            customerCode,
            customerName,
            customerContactNumber,
            customerCity
        FROM customer
        WHERE customerCode = ?
        LIMIT 1
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $custId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return [
                'custid' => $row['customerCode'],
                'custname' => $row['customerName'],
                'custcontactnumber' => $row['customerContactNumber'],
                'customerCity' => $row['customerCity']
            ];
        }

        return [];
    }

    public static function paymentcollection($viewObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "Select C.customerId,C.customerContactNumber, customerName,total_amount, SUM(paid_amount) as paid_amount from customer as C 
         LEFT JOIN paymentinfo as P on C.customerId=P.customer_id
          where C.customerId=(" . $viewObj . ")
          GROUP BY customer_name,total_amount";

        $view = new Payment();
        $result = mysqli_query($db->getConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $view->set_custcontactnumber($row['customerContactNumber']);
                $view->set_totalamt($row['total_amount']);
                $view->set_custid($row['customerId']);
                $view->set_paidamt($row['paid_amount']);
                $view->set_custname($row['customerName']);
                $view->set_pendingamt($row['total_amount'] - $row["paid_amount"]);
            }
        } else {
            $view = null;
        }
        return $view;
    }

    public static function viewtransactiondetails($quoteId, $custId)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT 
            modifieddate,
            customer_id,
            received_amount,
            (total_amount - received_amount) AS pending_amount,
            payment_mode
        FROM customerpaymentinfo
        WHERE quotation_id = ?
          AND customer_id = ?
        ORDER BY payment_id ASC
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $quoteId, $custId);
        $stmt->execute();

        $result = $stmt->get_result();
        $transactiondetails = [];

        while ($row = $result->fetch_assoc()) {
            $view = new Payment();
            $view->set_modifiedon(date('d/m/Y', strtotime($row['modifieddate'])));
            $view->set_receivedamt($row['received_amount']);
            $view->set_pendingamt($row['pending_amount']);
            $view->set_paymentmode($row['payment_mode']);
            $view->set_custid($row['customer_id']);
            $transactiondetails[] = $view;
        }

        header('Content-Type: application/json');
        echo json_encode($transactiondetails);
    }

    public static function update($payObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        if ($payObj->get_duedate() == "") {
            $sql = "insert into customerpaymentinfo (`quotation_id`,`customer_id`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`modified_by`) 
                        values ('" . $payObj->getQuoteCode() . "','" . $payObj->get_custid() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_modifiedby() . "')";
            error_log($sql);
        } else {
            $sql = "insert into  customerpaymentinfo  (`quotation_id`,`customer_id`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`due_date`,`modified_by`) 
                        values ('" . $payObj->getQuoteCode() . "','" . $payObj->get_custid() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_duedate() . "','" . $payObj->get_modifiedby() . "')";
            error_log($sql);
        }
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function updateFileName($transactionObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE customerpaymentinfo SET ";

        $sql .= "paymentPDFName='" . $transactionObj->get_paymentPDFName();

        //  $sql.= "', modifiedby='" . $purchaseObj->get_modifiedby() .
        "' WHERE customer_id=" . $transactionObj->get_custid();
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function creditdiscountByCustomer($custId, $discount)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        UPDATE customerpaymentinfo
        SET creditDiscount = IFNULL(creditDiscount,0) + ?
        WHERE customer_id = ?
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ds", $discount, $custId);
        $stmt->execute();
    }


    public static function getQuotePaymentSummary($quoteid)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
            SELECT 
    MAX(total_amount) AS totalamt,
    SUM(received_amount) AS paidamt,
    (MAX(total_amount) - SUM(received_amount)) AS pendingamt
FROM customerpaymentinfo
WHERE quotation_id = ?

        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $quoteid);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public static function getProjectAmounts($quoteCode, $custId)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        // Total amount
        $stmt1 = $conn->prepare("
        SELECT quoteValue
        FROM quotation_details
        WHERE quoteCode = ?
        LIMIT 1
    ");
        $stmt1->bind_param("s", $quoteCode);
        $stmt1->execute();
        $total = $stmt1->get_result()->fetch_assoc()['quoteValue'] ?? 0;

        // Paid amount (IMPORTANT FIX)
        $stmt2 = $conn->prepare("
        SELECT IFNULL(SUM(received_amount),0) AS paid
        FROM customerpaymentinfo
        WHERE quotation_id = ?
          AND customer_id = ?
    ");
        $stmt2->bind_param("ss", $quoteCode, $custId);
        $stmt2->execute();
        $paid = $stmt2->get_result()->fetch_assoc()['paid'] ?? 0;

        return [
            'total' => $total,
            'paid' => $paid
        ];
    }

    public static function getProjectPaymentSummary($quoteId, $custId)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT
            Q.quoteValue AS total,
            IFNULL(SUM(CP.received_amount), 0) AS paid,
            (
                Q.quoteValue
                - IFNULL(SUM(CP.received_amount), 0)
                - IFNULL(MAX(CP.creditDiscount), 0)
            ) AS pending
        FROM quotation_details Q
        LEFT JOIN customerpaymentinfo CP
            ON CP.quotation_id = Q.quoteCode
           AND CP.customer_id = ?
        WHERE Q.quoteCode = ?
        GROUP BY Q.quoteCode
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $custId, $quoteId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public static function getCustomersWithApprovedQuotes()
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT
            C.customerCode,
            C.customerName,
            C.customerCity,

            -- pick ONE project per customer (latest)
            MAX(P.projectId) AS projectId

        FROM projects P
        JOIN customer C ON C.customerCode = P.custId
        JOIN quotation_details Q ON Q.quoteCode = P.quoteId

        WHERE Q.quo_status = 'Approved'

        GROUP BY
            C.customerCode,
            C.customerName,
            C.customerCity

        ORDER BY C.customerName
    ";

        return $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }



    public static function getCustomerApprovedProjectSummary($customerCode)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        // 🔑 Convert customerCode → customerId FIRST
        $stmt = $conn->prepare("
        SELECT customerId 
        FROM customer 
        WHERE customerCode = ?
        LIMIT 1
    ");
        $stmt->bind_param("s", $customerCode);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!$row) {
            return ['total' => 0, 'paid' => 0, 'pending' => 0];
        }

        $customerId = $row['customerId'];

        // 1️⃣ TOTAL APPROVED QUOTES
        $stmt = $conn->prepare("
        SELECT IFNULL(SUM(quoteValue),0) AS total
        FROM quotation_details
        WHERE customerId = ?
          AND quo_status = 'Approved'
    ");
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total'];

        // 2️⃣ TOTAL PAID
        $stmt = $conn->prepare("
        SELECT IFNULL(SUM(received_amount),0) AS paid
        FROM customerpaymentinfo
        WHERE customer_id = ?
    ");
        $stmt->bind_param("s", $customerCode);
        $stmt->execute();
        $paid = $stmt->get_result()->fetch_assoc()['paid'];

        return [
            'total' => round($total, 2),
            'paid' => round($paid, 2),
            'pending' => round($total - $paid, 2)
        ];
    }

    public static function getCustomerFinancialSummary($custId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "
        SELECT
            IFNULL(SUM(Q.quoteValue),0) AS total,
            IFNULL(SUM(CP.received_amount),0) AS paid,
            (
                IFNULL(SUM(Q.quoteValue),0)
                - IFNULL(SUM(CP.received_amount),0)
            ) AS pending
        FROM quotation_details Q
        LEFT JOIN customerpaymentinfo CP
            ON CP.customer_id = Q.customerId
        WHERE Q.customerId = ?
          AND Q.quo_status = 'Approved'
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $custId);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        return $res;
    }

    public static function viewtransactiondetailsByCustomer($custId)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT
            modifieddate,
            received_amount,
            total_amount,
            payment_mode
        FROM customerpaymentinfo
        WHERE customer_id = ?
        ORDER BY payment_id ASC
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $custId);
        $stmt->execute();

        $res = $stmt->get_result();
        $list = [];

        while ($row = $res->fetch_assoc()) {
            $p = new Payment();
            $p->set_modifiedon(date('d/m/Y', strtotime($row['modifieddate'])));
            $p->set_receivedamt($row['received_amount']);
            $p->set_totalamt($row['total_amount']);
            $p->set_paymentmode($row['payment_mode']);
            $list[] = $p;
        }

        echo json_encode($list);
    }


}

