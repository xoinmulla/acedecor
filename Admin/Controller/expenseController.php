<?php
require_once("../DB Operations/expenseOps.php");
require_once("../Model/expenseModel.php");
require_once("../DB Operations/projectOps.php");
require_once("../DB Operations/customerpaymentOps.php");
require_once("../Model/projectModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    /* ===================== NORMAL EXPENSE ===================== */
    if ($_POST['action'] === 'add') {


        $e = new Expense();
        error_log('SUB ID = ' . ($_POST['subcategory_id'] ?? 'NULL'));
        error_log('SUB NAME = ' . ($_POST['subcategory_name'] ?? 'NULL'));


        $e->setType($_POST['type'] ?? 'Expense');
        $e->setCategory($_POST['category_type'] ?? 'General');

        if ($e->getCategory() === 'General') {
            $e->setSubcategoryId($_POST['subcategory_id'] ?? null);
            $e->setSubcategoryName($_POST['subcategory_name'] ?? null);
        }

        $e->setAmount($_POST['amount']);
        $e->setExpenseDate($_POST['expense_date']);
        $e->setPaymentType($_POST['payment_type']);
        $e->setNotes($_POST['notes']);

        DBExpense::insert($e);
        header("Location: ../View/expense.php?success=1");
        exit;
    }

    /* ===================== PROJECT EXPENSE ===================== */
    if ($_POST['action'] === 'add_project_expense') {

        $expense = new Expense();

        $expense->setCategory('Projects');
        $expense->setType('Expense');
        $expense->setProjectId($_POST['project_id']);

        $expense->setSubcategoryId($_POST['subcategory_id']);
        $expense->setSubcategoryName($_POST['subcategory_name']);

        $expense->setAmount($_POST['amount']);
        $expense->setExpenseDate($_POST['expense_date']);
        $expense->setPaymentType($_POST['payment_type']);
        $expense->setNotes($_POST['notes']);

        DBExpense::insertProjectExpense($expense);

        echo json_encode([
            'status' => 'success',
            'message' => 'Project expense added successfully'
        ]);
        exit;
    }

    /* ===================== UPDATE ===================== */
    if ($_POST['action'] === 'update') {

        $e = new Expense();
        $e->setId($_POST['id']);

        $e->setType($_POST['type'] ?? 'Expense');
        $e->setCategory($_POST['category_type'] ?? 'General');

        $e->setSubcategoryId($_POST['subcategory_id'] ?? null);
        $e->setSubcategoryName($_POST['subcategory_name'] ?? null);

        $e->setAmount($_POST['amount']);
        $e->setExpenseDate($_POST['expense_date']);
        $e->setPaymentType($_POST['payment_type']);
        $e->setNotes($_POST['notes']);

        DBExpense::update($e);
        header("Location: ../View/expense.php?updated=1");
        exit;
    }

}



if (isset($_GET['delete'])) {
    DBExpense::delete($_GET['delete']);
    header("Location: ../View/expense.php?deleted=1");
    exit;
}
if (
    $_SERVER['REQUEST_METHOD'] === 'GET'
    && isset($_GET['action'])
    && $_GET['action'] === 'get_project_details'
) {

    $projectId = intval($_GET['project_id']);

    // 🔹 Project object
    $project = DBproject::getAllprojectsbasedonId($projectId);

    // ✅ Use quoteCode, NOT projectId
    $amounts = DBpayment::getProjectAmounts(
        $project->get_quotecode(),
        $project->get_custid()
    );

    $total = $amounts['total'] ?? 0;
    $paid = $amounts['paid'] ?? 0;

    $expense = DBExpense::getProjectExpenditure($projectId);


    echo json_encode([
        'status' => 'success',
        'project_id' => $project->get_projectId(),
        'customer_id' => $project->get_custid(),
        'location' => $project->get_customerCity(),
        'total_amount' => number_format($total, 2),
        'paid_amount' => number_format($paid, 2),
        'expenditure' => number_format($expense, 2)
    ]);
    exit;
}

if (
    isset($_GET['action']) &&
    $_GET['action'] === 'getCustomerProjectExpense'
) {
    header('Content-Type: application/json');

    $custId = $_GET['custid'] ?? '';

    if (!$custId) {
        echo json_encode([
            'status' => 'error',
            'expenditure' => '0.00'
        ]);
        exit;
    }

    $total = DBExpense::getCustomerProjectExpenditure($custId);

    echo json_encode([
        'status' => 'success',
        'expenditure' => number_format((float) $total, 2, '.', '')
    ]);
    exit;
}





?>