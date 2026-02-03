<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/expenseModel.php";

class DBExpense
{
    private static function getConn()
    {
        return ConnectDb::getInstance()->getConnection();
    }

    public static function insert(Expense $e)
    {
        $conn = self::getConn();

        $stmt = $conn->prepare("
        INSERT INTO expense 
        (category, subcategory_id, subcategory_name, amount, expense_date, payment_type, notes, type)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

        $subcategory_id = $e->getSubcategoryId();
        $subcategory_name = $e->getSubcategoryName();
        $amount = $e->getAmount();
        $expense_date = $e->getExpenseDate();
        $payment_type = $e->getPaymentType();
        $notes = $e->getNotes();
        $type = $e->getType();

        $category = $e->getCategory();


        $stmt->bind_param(
            "sisdssss",
            $category,
            $subcategory_id,
            $subcategory_name,
            $amount,
            $expense_date,
            $payment_type,
            $notes,
            $type
        );



        return $stmt->execute();
    }


    public static function update(Expense $e)
    {
        $conn = self::getConn();

        $stmt = $conn->prepare("
        UPDATE expense SET
        subcategory_id = ?,
        subcategory_name = ?,
        amount = ?,
        expense_date = ?,
        payment_type = ?,
        notes = ?,
        type = ?
        WHERE id = ?
    ");

        $subcategory_id = $e->getSubcategoryId();
        $subcategory_name = $e->getSubcategoryName();
        $amount = $e->getAmount();
        $expense_date = $e->getExpenseDate();
        $payment_type = $e->getPaymentType();
        $notes = $e->getNotes();
        $type = $e->getType();
        $id = $e->getId();

        $stmt->bind_param(
            "isdssssi",
            $subcategory_id,
            $subcategory_name,
            $amount,
            $expense_date,
            $payment_type,
            $notes,
            $type,
            $id
        );


        return $stmt->execute();
    }


    public static function delete($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("DELETE FROM expense WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function readAll()
    {
        $conn = self::getConn();
        $result = $conn->query("SELECT * FROM expense ORDER BY expense_date DESC");
        $data = [];
        while ($row = $result->fetch_assoc())
            $data[] = $row;
        return $data;
    }

    public static function readById($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("SELECT * FROM expense WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public static function getProjectExpenditure($projectId)
    {
        $conn = self::getConn();

        $stmt = $conn->prepare("
        SELECT IFNULL(SUM(amount), 0) AS total
        FROM expense
        WHERE category = 'Projects'
        AND project_id = ?
    ");
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        return $res['total'] ?? 0;
    }
    public static function insertProjectExpense(Expense $e)
    {
        $conn = self::getConn();

        $stmt = $conn->prepare("
        INSERT INTO expense
        (category, project_id, subcategory_id, subcategory_name,
         amount, expense_date, payment_type, notes, type)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

        $category = 'Projects';
        $project_id = $e->getProjectId();
        $subcategory_id = $e->getSubcategoryId();
        $subcategory_name = $e->getSubcategoryName();
        $amount = $e->getAmount();
        $expense_date = $e->getExpenseDate();
        $payment_type = $e->getPaymentType();
        $notes = $e->getNotes();
        $type = 'Expense';

        $stmt->bind_param(
            "siisdssss",
            $category,
            $project_id,
            $subcategory_id,
            $subcategory_name,
            $amount,
            $expense_date,
            $payment_type,
            $notes,
            $type
        );

        return $stmt->execute();
    }
    public static function insertEmployeeExpense(Expense $e)
    {
        $conn = self::getConn();

        $stmt = $conn->prepare("
        INSERT INTO expense
        (type, category, amount, expense_date, payment_type, notes)
        VALUES ('Expense', 'Employee', ?, ?, ?, ?)
    ");

        $stmt->bind_param(
            "dsss",
            $e->getAmount(),
            $e->getExpenseDate(),
            $e->getPaymentType(),
            $e->getNotes()
        );

        return $stmt->execute();
    }

    public static function getCustomerProjectExpenditure($custId)
    {
        $conn = self::getConn();

        $sql = "
        SELECT COALESCE(SUM(E.amount), 0) AS total
        FROM expense E
        JOIN projects P ON P.projectId = E.project_id
        WHERE E.category = 'Projects'
        AND P.custId = ?
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $custId);
        $stmt->execute();

        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'] ?? 0;
    }

    public static function getCustomerTotalExpenditure($custId)
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT IFNULL(SUM(amount),0) AS total
        FROM expense
        WHERE project_id = ?
          AND type = 'Expense'
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $custId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
    }

    public static function insertSupplierExpense(Expense $e)
    {
        $db = ConnectDb::getInstance()->getConnection();

        $sql = "
        INSERT INTO expense
        (
            type,
            category,
            supplier_id,
            amount,
            expense_date,
            payment_type,
            notes
        )
        VALUES
        (
            '{$e->getType()}',
            '{$e->getCategory()}',
            '{$e->getSupplierId()}',
            '{$e->getAmount()}',
            '{$e->getExpenseDate()}',
            '{$e->getPaymentType()}',
            '{$e->getNotes()}'
        )
    ";

        error_log($sql);

        return $db->query($sql);
    }


}
?>