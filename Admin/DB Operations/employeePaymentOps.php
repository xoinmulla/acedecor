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

    /** ✅ Accurate due for a given month (YYYY-MM)
     *  Matches Monthly Report logic exactly.
     *  Uses: settings.hours_per_day, attendance.worked_hours + ot_pay
     *  Only counts rows where status='Present'
     */
    // public static function getEmployeeDue(int $emp_id, string $month): float
    // {
    //     $conn = self::getConn();

    //     // 1️⃣ Employee salary info
    //     $empStmt = $conn->prepare("SELECT salary_type, salary_amount FROM employee WHERE id=?");
    //     $empStmt->bind_param("i", $emp_id);
    //     $empStmt->execute();
    //     $emp = $empStmt->get_result()->fetch_assoc();
    //     if (!$emp)
    //         return 0.0;

    //     $type = $emp['salary_type'];
    //     $rate = (float) $emp['salary_amount'];

    //     // 2️⃣ Attendance summary (same logic as monthlyReportOps)
    //     $att = $conn->prepare("
    //     SELECT status, worked_hours, ot_pay 
    //       FROM attendance
    //      WHERE emp_id=? AND DATE_FORMAT(date,'%Y-%m')=?
    // ");
    //     $att->bind_param("is", $emp_id, $month);
    //     $att->execute();
    //     $rows = $att->get_result()->fetch_all(MYSQLI_ASSOC);

    //     $full_days = $half_days = 0;
    //     $ot_pay = 0.0;
    //     foreach ($rows as $r) {
    //         if ($r['status'] === 'Present')
    //             $full_days++;
    //         elseif ($r['status'] === 'Half-day')
    //             $half_days++;
    //         $ot_pay += (float) $r['ot_pay'];
    //     }

    //     // 3️⃣ Due calculation (same formula as monthlyReportOps::calculateSalary)
    //     if ($type === 'Daily') {
    //         $due_amount = ($full_days * $rate) + ($half_days * $rate * 0.5) + $ot_pay;
    //     } elseif ($type === 'Weekly') {
    //         $due_amount = (($full_days / 6) * $rate) + (($half_days / 12) * $rate) + $ot_pay;
    //     } else { // Monthly
    //         $due_amount = (($full_days / 26) * $rate) + (($half_days / 52) * $rate) + $ot_pay;
    //     }

    //     // 4️⃣ Subtract payments made
    //     $pay = $conn->prepare("
    //     SELECT COALESCE(SUM(amount),0) AS paid
    //       FROM employee_payment
    //      WHERE emp_id=? AND DATE_FORMAT(payment_date,'%Y-%m')=?
    // ");
    //     $pay->bind_param("is", $emp_id, $month);
    //     $pay->execute();
    //     $paid = (float) ($pay->get_result()->fetch_assoc()['paid'] ?? 0);

    //     // 5️⃣ Final due
    //     $due = round($due_amount - $paid, 2);
    //     return max($due, 0.0);
    // }
    // public static function getTotalDueAmount($emp_id)
    // {
    //     // Sum all pending amounts of this employee
    //     $sql = "SELECT SUM(pendingamt) AS total_due FROM employee_payment WHERE emp_id = ?";
    //     $db = DB::connect();
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute([$emp_id]);
    //     return $stmt->fetchColumn() ?: 0;
    // }
    // // 🔥 TOTAL DUE FOR ALL MONTHS (Full History)
    // public static function getTotalDue(int $emp_id): float
    // {
    //     $conn = self::getConn();

    //     // Fetch employee salary type + amount
    //     $empStmt = $conn->prepare("
    //     SELECT salary_type, salary_amount 
    //     FROM employee 
    //     WHERE id=?
    // ");
    //     $empStmt->bind_param("i", $emp_id);
    //     $empStmt->execute();
    //     $emp = $empStmt->get_result()->fetch_assoc();
    //     if (!$emp)
    //         return 0.0;

    //     $type = $emp['salary_type'];
    //     $rate = (float) $emp['salary_amount'];

    //     // 1️⃣ Total salary earned from attendance table
    //     $att = $conn->prepare("
    //     SELECT status, worked_hours, ot_pay 
    //     FROM attendance 
    //     WHERE emp_id=?
    // ");
    //     $att->bind_param("i", $emp_id);
    //     $att->execute();
    //     $rows = $att->get_result()->fetch_all(MYSQLI_ASSOC);

    //     $full_days = $half_days = 0;
    //     $ot_pay = 0.0;

    //     foreach ($rows as $r) {
    //         if ($r['status'] === 'Present')
    //             $full_days++;
    //         else if ($r['status'] === 'Half-day')
    //             $half_days++;
    //         $ot_pay += (float) $r['ot_pay'];
    //     }

    //     // 2️⃣ Apply same logic as monthly due calc
    //     if ($type === 'Daily') {
    //         $earned = ($full_days * $rate) + ($half_days * $rate * 0.5) + $ot_pay;
    //     } elseif ($type === 'Weekly') {
    //         $earned = (($full_days / 6) * $rate) + (($half_days / 12) * $rate) + $ot_pay;
    //     } else { // Monthly
    //         $earned = (($full_days / 26) * $rate) + (($half_days / 52) * $rate) + $ot_pay;
    //     }

    //     // 3️⃣ Total amount paid till date
    //     $pay = $conn->prepare("
    //     SELECT COALESCE(SUM(amount),0) AS paid
    //     FROM employee_payment
    //     WHERE emp_id=?
    // ");
    //     $pay->bind_param("i", $emp_id);
    //     $pay->execute();
    //     $paid = (float) ($pay->get_result()->fetch_assoc()['paid'] ?? 0);

    //     // 4️⃣ Final due (cannot be negative)
    //     return max(round($earned - $paid, 2), 0.0);
    // }
    // 🔥 EMPLOYEE PAYMENT SUMMARY (ONE ROW PER EMPLOYEE)
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