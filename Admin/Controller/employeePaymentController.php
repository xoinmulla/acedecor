<?php
require_once("../DB Operations/employeePaymentOps.php");
require_once("../Model/employeePaymentModel.php");

/**
 * ------------------------------
 * 1️⃣ FETCH ONE PAYMENT (AJAX)
 * ------------------------------
 */
if (isset($_GET['action']) && $_GET['action'] === 'fetch' && isset($_GET['id'])) {
    header('Content-Type: application/json');

    $id = (int) $_GET['id'];
    $row = DBEmployeePayment::readById($id);

    echo json_encode($row ? $row : ['error' => 'No record found']);
    exit;
}


/**
 * ------------------------------
 * 3️⃣ ADD / UPDATE / DELETE (POST)
 * ------------------------------
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- Handle AJAX delete (POST method) ---
    if (isset($_POST['delete'])) {
        $id = (int) $_POST['delete'];
        $result = DBEmployeePayment::delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
        exit;
    }

    // --- Safely read action ---
    $action = $_POST['action'] ?? '';

    // --- Create Payment Object (only for add/update) ---
    if (in_array($action, ['add', 'update'])) {
        $p = new EmployeePayment();
        if (!empty($_POST['id']))
            $p->setId((int) $_POST['id']);
        $p->setEmpId((int) ($_POST['emp_id'] ?? 0));
        $p->setPaymentDate($_POST['payment_date'] ?? date('Y-m-d'));
        $p->setAmount((float) ($_POST['amount'] ?? 0));
        $p->setPaymentType($_POST['payment_type'] ?? '');
        $p->setStatus($_POST['status'] ?? 'Pending');
        $p->setRemarks($_POST['remarks'] ?? '');

        if ($action === 'add') {

            $payment_id = DBEmployeePayment::insert($p);

            // 🔹 ALSO INSERT INTO EXPENSE TABLE
            require_once "../DB Operations/expenseOps.php";
            require_once "../Model/expenseModel.php";

            $e = new Expense();
            $e->setType('Expense');
            $e->setCategory('Employee');
            $e->setAmount($p->getAmount());
            $e->setExpenseDate($p->getPaymentDate());
            $e->setPaymentType($p->getPaymentType());
            $e->setNotes('Employee Salary Payment');

            $e->setPaymentId($payment_id); // 🔥 IMPORTANT
            DBExpense::insert($e);

            echo json_encode(['status' => 'success']);
            exit;
        } elseif ($action === 'update') {
            DBEmployeePayment::update($p);
            echo json_encode(['status' => 'success']);
            exit;
        }
    }

    // --- Invalid or missing action ---
    header("Location: ../View/expense.php?error=invalid_action#employee");
    exit;
}

/**
 * ------------------------------
 * 4️⃣ DELETE VIA GET PARAM (link click)
 * ------------------------------
 */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    DBEmployeePayment::delete($id);
    header("Location: ../View/expense.php?deleted=1#employee");
    exit;
}
require_once "../DB Operations/monthlyReportOps.php";

if (isset($_GET['action']) && $_GET['action'] === 'getEmployeeSummary') {
    header('Content-Type: application/json');

    if (!empty($_GET['emp_id'])) {
        $s = DBMonthlyReport::getEmployeeSummary((int) $_GET['emp_id']);

        echo json_encode([
            'total_amount' => $s['total_amount'],
            'paid_amount' => $s['paid_amount'],
            'balance' => $s['balance']
        ]);

    } else {
        echo json_encode(DBEmployeePayment::getEmployeeSummary());
    }
    exit;
}




