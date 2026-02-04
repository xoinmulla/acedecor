<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/employeePaymentModel.php";

class DBEmployeePayment
{
    private static function getConn()
    {
        return ConnectDb::getInstance()->getConnection();
    }

    // ➕ Insert Payment
    public static function insert(EmployeePayment $pay)
    {
        $conn = self::getConn();
        $emp_id = $pay->getEmpId();
        $payment_date = $pay->getPaymentDate();
        $amount = $pay->getAmount();
        $payment_type = $pay->getPaymentType();
        $status = $pay->getStatus();
        $remarks = $pay->getRemarks();

        $stmt = $conn->prepare("
            INSERT INTO employee_payment (emp_id, payment_date, amount, payment_type, status, remarks)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isdsss", $emp_id, $payment_date, $amount, $payment_type, $status, $remarks);
        return $stmt->execute();
    }

    // ✏️ Update Payment
    public static function update(EmployeePayment $pay)
    {
        $conn = self::getConn();
        $id = $pay->getId();
        $emp_id = $pay->getEmpId();
        $payment_date = $pay->getPaymentDate();
        $amount = $pay->getAmount();
        $payment_type = $pay->getPaymentType();
        $status = $pay->getStatus();
        $remarks = $pay->getRemarks();

        $stmt = $conn->prepare("
            UPDATE employee_payment
               SET emp_id=?, payment_date=?, amount=?, payment_type=?, status=?, remarks=?
             WHERE id=?
        ");
        $stmt->bind_param("isdsssi", $emp_id, $payment_date, $amount, $payment_type, $status, $remarks, $id);
        return $stmt->execute();
    }

    // ❌ Delete Payment
    public static function delete($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("DELETE FROM employee_payment WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // 📋 Read All Payments
    public static function readAll()
    {
        $conn = self::getConn();
        $result = $conn->query("
            SELECT p.*, e.name AS emp_name
              FROM employee_payment p
              JOIN employee e ON p.emp_id = e.id
          ORDER BY p.payment_date DESC, p.id DESC
        ");
        $data = [];
        while ($row = $result->fetch_assoc())
            $data[] = $row;
        return $data;
    }

    // 🔍 Read Payment by ID
    public static function readById($id)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("SELECT * FROM employee_payment WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getEmployeeSummary()
    {
        $conn = self::getConn();

        require_once dirname(__FILE__, 2) . "/DB Operations/monthlyReportOps.php";

        $employees = $conn->query("
        SELECT id, name 
        FROM employee 
        ORDER BY name ASC
    ")->fetch_all(MYSQLI_ASSOC);

        $data = [];

        foreach ($employees as $emp) {

            // 🔥 SINGLE SOURCE OF TRUTH
            $summary = DBMonthlyReport::getEmployeeSummary($emp['id']);

            $data[] = [
                'emp_id' => $emp['id'],
                'emp_name' => $emp['name'],
                'total_amount' => $summary['total_amount'],
                'paid_amount' => $summary['paid_amount'],
                'balance' => $summary['balance'],
            ];

        }

        return $data;
    }



}
?>