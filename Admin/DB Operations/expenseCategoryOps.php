<?php
require_once("dbconnection.php");
require_once("../Model/expenseCategoryModel.php");

class DBExpenseCategory {

    private static function getConn() {
        return ConnectDb::getInstance()->getConnection();
    }

    public static function getAll() {
        $conn = self::getConn();
        $result = $conn->query("SELECT * FROM expense_category ORDER BY id DESC");
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = new ExpenseCategory($row['id'], $row['name'], $row['type']);
        }
        return $categories;
    }

    public static function insert($name, $type) {
        $conn = self::getConn();
        $stmt = $conn->prepare("INSERT INTO expense_category (name, type) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $type);
        return $stmt->execute();
    }

    public static function update($id, $name, $type) {
        $conn = self::getConn();
        $stmt = $conn->prepare("UPDATE expense_category SET name=?, type=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $type, $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $conn = self::getConn();
        $stmt = $conn->prepare("DELETE FROM expense_category WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
