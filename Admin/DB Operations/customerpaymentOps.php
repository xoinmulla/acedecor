<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once("../Model/customerpaymentmodel.php");


class DBpayment
{
    public static function insert($payObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * from customerpaymentinfo where quotation_id='" . $payObj->getQuoteCode() . "'";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        error_log($count);
        if ($count < 1) {
            if ($payObj->get_duedate() == "") {
                $sql = "insert into customerpaymentinfo (`quotation_id`,`customer_id`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`modified_by`) 
                values ('" . $payObj->getQuoteCode() . "','" . $payObj->get_custid() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_modifiedby() . "')";
            } else {
                $sql = "insert into  customerpaymentinfo  (`customer_id`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`due_date`,`modified_by`) 
         values ('" . $payObj->get_custid() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_duedate() . "','" . $payObj->get_modifiedby() . "')";
            }
            if ($connectionObj->query($sql) === true) {
            } else {
                echo "Error: " . $sql . "<br>" . $connectionObj->error;
            }
        } else {
            echo "Payment record already exist";
        }
        error_log($sql);
    }

    public static function getAllcustomerpayment()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        // ✅ Only show customer payments for Approved quotations
        $sql = "SELECT 
        C.customerName AS customername,
        C.customerContactNumber AS customerContactNumber,
        C.customerCode AS customerId,
        C.customerDOV AS customerDOV,
        C.customerAddress AS customerAddress,
        Q.quo_createdon AS DOQ,
        Q.quoteCode AS QuoteCode,
        CP.payment_id AS PaymentId,
        CP.total_amount AS TotalAmt,
        CP.paid_amount AS PaidAmt,
        CP.creditDiscount AS creditDiscount,
        CASE WHEN CP.creditDiscount = 0 THEN SUM(CP.received_amount)
             ELSE 0 END AS ReceivedAmt,
        CASE WHEN CP.creditDiscount != 0 THEN CP.total_amount - CP.creditDiscount
             ELSE CP.total_amount - CP.paid_amount END AS PendingAmt
    FROM customer AS C
    JOIN customerpaymentinfo CP ON CP.customer_id = C.customerCode
    JOIN quotation_details Q ON Q.quotecode = CP.quotation_id
    WHERE Q.quo_status = 'Approved'   -- ✅ Only approved quotations
    GROUP BY customername, TotalAmt";

        error_log("getAllcustomerpayment SQL: " . $sql);

        $result = $connectionObj->query($sql);
        $customerList = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $customer = new Payment();
                $customer->set_paymentid($row['PaymentId']);
                $customer->set_custid($row['customerId']);
                $customer->set_custcontactnumber($row['customerContactNumber']);
                $customer->set_custname($row['customername']);
                $customer->setcustomerDOV(date('d/m/Y', strtotime($row['customerDOV'])));
                $customer->setcustomerAddress($row['customerAddress']);
                $customer->setDOQ(date('m/d/Y', strtotime($row["DOQ"])));
                $customer->setQuoteCode($row['QuoteCode']);
                $customer->set_totalamt($row['TotalAmt']);
                $customer->set_pendingamt($row['PendingAmt']);
                $customer->set_paidamt($row['TotalAmt'] - $row['PendingAmt']);
                $customer->set_receivedamt($row['ReceivedAmt']);
                $customer->set_creditdiscount($row['creditDiscount']);
                array_push($customerList, $customer);
            }
        }

        return $customerList;
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

    public static function viewtransactiondetails($viewObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "select modifieddate,customer_id,received_amount,pending_amount,payment_mode from customerpaymentinfo where quotation_id='$viewObj'";
        $result = mysqli_query($db->getConnection(), $sql);
        error_log($sql);
        $transactiondetails = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $view = new Payment();
                $view->set_modifiedon(date('m/d/Y', strtotime($row['modifieddate'])));
                $view->set_receivedamt($row['received_amount']);
                $view->set_pendingamt($row['pending_amount']);
                $view->set_paymentmode($row['payment_mode']);
                $view->set_custid($row['customer_id']);
                // $view->set_paymentreceipt($row['paymentreceipt']);
                array_push($transactiondetails, $view);
            }
        } else {
            echo "No entries ";
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

    public static function creditdiscount($creditObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE customerpaymentinfo SET creditDiscount='" . $creditObj->get_creditdiscount() . "' 
                WHERE payment_id='" . $creditObj->get_paymentid() . "' ";
        error_log($sql);
        if ($connectionObj->query($sql) === true) {
            $sql = "UPDATE customerpaymentinfo SET paid_amount='0' ";
            error_log($sql);
            if ($connectionObj->query($sql) === true) {

            } else {
                echo "Error: " . $sql . "<br>" . $connectionObj->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

}