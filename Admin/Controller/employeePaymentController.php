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
 * 2️⃣ GET DUE AMOUNT (AJAX)
 * ------------------------------
 */
if (isset($_GET['action']) && $_GET['action'] === 'getDue' && isset($_GET['emp_id'])) {
    header('Content-Type: application/json');

    $emp_id = (int) $_GET['emp_id'];
    $month = $_GET['month'] ?? (
        isset($_GET['date']) ? substr($_GET['date'], 0, 7) : date('Y-m')
    );

    $due = DBEmployeePayment::getEmployeeDue($emp_id, $month);
    echo json_encode(['due' => $due]);
    exit;
}
/**
 * ------------------------------
 *  New: GET TOTAL DUE (All Time)
 * ------------------------------
 */
if (isset($_GET['action']) && $_GET['action'] === 'getTotalDue' && isset($_GET['emp_id'])) {
    header('Content-Type: application/json');

    $emp_id = (int) $_GET['emp_id'];
    $due = DBEmployeePayment::getTotalDue($emp_id);

    echo json_encode(['due' => $due]);
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
            DBEmployeePayment::insert($p);
            header("Location: ../View/expense.php?success=1#employee");
            exit;
        } elseif ($action === 'update') {
            DBEmployeePayment::update($p);
            header("Location: ../View/expense.php?updated=1#employee");
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

