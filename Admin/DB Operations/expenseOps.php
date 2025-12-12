<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/expenseModel.php";

class DBExpense {
    private static function getConn() {
        return ConnectDb::getInstance()->getConnection();
    }

    public static function insert(Expense $e) {
        $conn = self::getConn();
        $category = $e->getCategory();
        $amount = $e->getAmount();
        $expense_date = $e->getExpenseDate();
        $payment_type = $e->getPaymentType();
        $notes = $e->getNotes();

        $stmt = $conn->prepare("INSERT INTO expense (category, amount, expense_date, payment_type, notes)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $category, $amount, $expense_date, $payment_type, $notes);
        return $stmt->execute();
    }

    public static function update(Expense $e) {
        $conn = self::getConn();
        $id = $e->getId();
        $category = $e->getCategory();
        $amount = $e->getAmount();
        $expense_date = $e->getExpenseDate();
        $payment_type = $e->getPaymentType();
        $notes = $e->getNotes();

        $stmt = $conn->prepare("UPDATE expense 
            SET category=?, amount=?, expense_date=?, payment_type=?, notes=? WHERE id=?");
        $stmt->bind_param("sdsssi", $category, $amount, $expense_date, $payment_type, $notes, $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $conn = self::getConn();
        $stmt = $conn->prepare("DELETE FROM expense WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function readAll() {
        $conn = self::getConn();
        $result = $conn->query("SELECT * FROM expense ORDER BY expense_date DESC");
        $data = [];
        while ($row = $result->fetch_assoc()) $data[] = $row;
        return $data;
    }

    public static function readById($id) {
        $conn = self::getConn();
        $stmt = $conn->prepare("SELECT * FROM expense WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
