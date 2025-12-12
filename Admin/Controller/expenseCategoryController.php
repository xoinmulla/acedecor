<?php
require_once("../DB Operations/expenseCategoryOps.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'Add') {
        $name = $_POST['category_name'];
        $type = $_POST['category_type'];
        if (DBExpenseCategory::insert($name, $type)) {
            echo "success";
        } else {
            echo "error";
        }
    }

    if ($action === 'Edit') {
        $id = $_POST['edit_id'];
        $name = $_POST['edit_category_name'];
        $type = $_POST['edit_category_type'];
        if (DBExpenseCategory::update($id, $name, $type)) {
            echo "success";
        } else {
            echo "error";
        }
    }

    if ($action === 'Delete') {
        $id = $_POST['delete_id'];
        if (DBExpenseCategory::delete($id)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
?>
