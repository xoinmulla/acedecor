<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once("../Model/supplierpaymentmodel.php");


class DBsupplierpayment
{
  public static function insert($payObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * from supplierpaymentinfo where supplierId='" . $payObj->get_supplierId() . "' and POID='" . $payObj->getPOID() . "'";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    error_log($count);
    if ($count < 1) {

      if ($payObj->get_duedate() == "") {
        $sql = "insert into supplierpaymentinfo (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`modified_by`) 
                values ('" . $payObj->get_supplierId() . "','" . $payObj->getPOID() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_modifiedby() . "')";

      } else {
        $sql = "insert into  supplierpaymentinfo   (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`due_date`,`modified_by`) 
         values ('" . $payObj->get_supplierId() . "','" . $payObj->getPOID() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_duedate() . "','" . $payObj->get_modifiedby() . "')";
      }
      if ($connectionObj->query($sql) === TRUE) {
      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }
    } else {
      echo "Payment record already exist";
    }
    error_log($sql);

  }
  public static function insertagain($payObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    if ($payObj->get_duedate() == "") {
      $sql = "insert into supplierpaymentinfo (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`modified_by`) 
                values ('" . $payObj->get_supplierId() . "','" . $payObj->getPOID() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_modifiedby() . "')";

    } else {
      $sql = "insert into  supplierpaymentinfo   (`supplierId`,`POID`, `total_amount`,`paid_amount`,`received_amount`,`pending_amount`, `payment_plan`,`payment_mode`,`payment_description`,`RTGS_no`,`cheque_img`,`due_date`,`modified_by`) 
         values ('" . $payObj->get_supplierId() . "','" . $payObj->getPOID() . "','" . $payObj->get_totalamt() . "','" . $payObj->get_paidamt() . "','" . $payObj->get_receivedamt() . "','" . $payObj->get_pendingamt() . "','" . $payObj->get_paymentplan() . "','" . $payObj->get_paymentmode() . "','" . $payObj->get_paymentdescription() . "','" . $payObj->get_RTGSno() . "','" . $payObj->get_chequeimg() . "','" . $payObj->get_duedate() . "','" . $payObj->get_modifiedby() . "')";
    }
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

    error_log($sql);

  }



  public static function getAllsupplierpayment()
  {
    $db = ConnectDb::getInstance()->getConnection();

    $sql = "
    SELECT
    S.item_compid AS supplier_id,
    S.item_compName AS supplier_name,
    S.item_compAddress,

    /* TOTAL INWARDED AMOUNT */
    IFNULL((
        SELECT SUM(ST.ReceivedQtyAmt)
        FROM item_stock ST
        JOIN purchase_order PO ON PO.Id = ST.POID
        WHERE PO.SupplierId = S.item_compid
    ), 0) AS total_amt,

    /* TOTAL PAID (SUPPLIER EXPENSE) */
    IFNULL((
        SELECT SUM(E.amount)
        FROM expense E
        WHERE E.supplier_id = S.item_compid
          AND E.category = 'Suppliers'
    ), 0) AS paid_amt

FROM item_companydetails S
WHERE EXISTS (
    SELECT 1 FROM purchase_order P WHERE P.SupplierId = S.item_compid
)
";

    $result = $db->query($sql);
    $supplierList = [];

    while ($row = $result->fetch_assoc()) {
      $supplier = new SupplierPayment();

      $supplier->set_supplierId($row['supplier_id']);
      $supplier->set_suppliername($row['supplier_name']);
      $supplier->set_supplierAddress($row['item_compAddress']);

      $supplier->set_totalamt($row['total_amt']);
      $supplier->set_paidamt($row['paid_amt']);
      $supplier->set_pendingamt($row['total_amt'] - $row['paid_amt']);


      $supplierList[] = $supplier;
    }

    return $supplierList;
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
      $view = NULL;
    }
    return $view;

  }

  public static function viewtransactiondetails($supplierId)
  {
    $db = ConnectDb::getInstance()->getConnection();
    $supplierId = mysqli_real_escape_string($db, $supplierId);

    // ✅ 1. Get TOTAL supplier amount (inward value)
    $totalSql = "
        SELECT IFNULL(SUM(ST.ReceivedQtyAmt),0) AS total_amt
        FROM item_stock ST
        JOIN purchase_order PO ON PO.Id = ST.POID
        WHERE PO.SupplierId = '$supplierId'
    ";

    $totalRes = mysqli_query($db, $totalSql);
    $totalRow = mysqli_fetch_assoc($totalRes);
    $totalAmount = (float) $totalRow['total_amt'];

    // ✅ 2. Get supplier expenses (payments)
    $sql = "
        SELECT
            expense_date,
            amount,
            payment_type
        FROM expense
        WHERE supplier_id = '$supplierId'
          AND category = 'Suppliers'
        ORDER BY expense_date ASC, id ASC
    ";

    $result = mysqli_query($db, $sql);

    if (!$result) {
      echo json_encode([
        'error' => mysqli_error($db),
        'sql' => $sql
      ]);
      exit;
    }

    $rows = [];
    $runningPaid = 0;

    while ($row = mysqli_fetch_assoc($result)) {

      $paid = (float) $row['amount'];
      $runningPaid += $paid;
      $pending = $totalAmount - $runningPaid;

      $rows[] = [
        'modifieddate' => date('d/m/Y', strtotime($row['expense_date'])),
        'paymentmode' => $row['payment_type'],
        'receivedamt' => number_format($paid, 2),
        'pendingamt' => number_format(max($pending, 0), 2)
      ];
    }

    header('Content-Type: application/json');
    echo json_encode($rows);
    exit;
  }


  public static function updateFileName($transactionObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE supplierpaymentinfo SET ";

    $sql .= "paymentPDFName='" . $transactionObj->get_paymentPDFName();

    //  $sql.= "', modifiedby='" . $purchaseObj->get_modifiedby() .
    "' WHERE Id=" . $transactionObj->get_supplierId();
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function update($purchaseObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE supplierpaymentinfo SET 
            total_amount='" . $purchaseObj->get_totalamt() .
      "', pending_amount='" . $purchaseObj->get_pendingamt() .
      "', paid_amount='" . $purchaseObj->get_paidamt() .
      "', received_amount='" . $purchaseObj->get_receivedamt() .
      "', payment_mode='" . $purchaseObj->get_paymentmode() .
      "' WHERE supplierId=" . $purchaseObj->get_supplierId() . " and POID=" . $purchaseObj->getPOID();
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

}