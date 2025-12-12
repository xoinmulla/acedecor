<?php
require_once("../DB Operations/expenseOps.php");
require_once("../Model/expenseModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    $e = new Expense();
    if (isset($_POST['id'])) $e->setId($_POST['id']);
    $e->setCategory($_POST['category']);
    $e->setAmount($_POST['amount']);
    $e->setExpenseDate($_POST['expense_date']);
    $e->setPaymentType($_POST['payment_type']);
    $e->setNotes($_POST['notes']);

    if ($action === 'add') {
        DBExpense::insert($e);
        header("Location: ../View/expense.php?success=1");
    } elseif ($action === 'update') {
        DBExpense::update($e);
        header("Location: ../View/expense.php?updated=1");
    }
    exit;
}

if (isset($_GET['delete'])) {
    DBExpense::delete($_GET['delete']);
    header("Location: ../View/expense.php?deleted=1");
    exit;
}
?>
