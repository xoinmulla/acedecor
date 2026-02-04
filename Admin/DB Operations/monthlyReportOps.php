<?php
require_once dirname(__FILE__, 2) . "/DB Operations/dbconnection.php";
require_once dirname(__FILE__, 2) . "/Model/monthlyReportModel.php";

class DBMonthlyReport
{
    private static function getConn()
    {
        return ConnectDb::getInstance()->getConnection();
    }

    // ================= MONTHLY REPORT =================
    public static function getReport($month)
    {
        $conn = self::getConn();
        $employees = $conn->query("SELECT * FROM employee")->fetch_all(MYSQLI_ASSOC);
        $reports = [];

        foreach ($employees as $emp) {
            $emp_id = $emp['id'];

            $att_q = $conn->prepare("SELECT status, worked_hours, ot_hours, ot_pay 
                                     FROM attendance WHERE emp_id=? AND DATE_FORMAT(date,'%Y-%m')=?");
            $att_q->bind_param("is", $emp_id, $month);
            $att_q->execute();
            $att_data = $att_q->get_result()->fetch_all(MYSQLI_ASSOC);

            $full_days = $half_days = $compensation_days = $absent = $ot_hours = $ot_pay = 0;
            foreach ($att_data as $a) {
                if ($a['status'] === 'Present')
                    $full_days++;
                elseif ($a['status'] === 'Half-day')
                    $half_days++;
                elseif ($a['status'] === 'Weekly Off' || $a['status'] === 'Compensation Day')
                    $compensation_days++;
                elseif ($a['status'] === 'Absent')
                    $absent++;
                $ot_hours += $a['ot_hours'];
                $ot_pay += $a['ot_pay'];
            }


            $pay_q = $conn->prepare("SELECT SUM(amount) AS total_paid 
                                     FROM employee_payment WHERE emp_id=? AND DATE_FORMAT(payment_date,'%Y-%m')=?");
            $pay_q->bind_param("is", $emp_id, $month);
            $pay_q->execute();
            $paid_amount = $pay_q->get_result()->fetch_assoc()['total_paid'] ?? 0;

            $rate = (float) $emp['salary_amount'];
            $due_amount = self::calculateSalary($emp['salary_type'], $rate, $full_days, $half_days, $ot_pay);
            $balance = $due_amount - $paid_amount;

            $r = new MonthlyReport();
            $r->emp_id = $emp['id'];
            $r->name = $emp['name'];
            $r->salary_type = $emp['salary_type'];
            $r->salary_amount = $rate;
            $r->full_days = $full_days;
            $r->half_days = $half_days;
            $r->compensation_days = $compensation_days;
            $r->absent = $absent;
            $r->ot_hours = $ot_hours;
            $r->ot_pay = $ot_pay;
            $r->due_amount = $due_amount;
            $r->paid_amount = $paid_amount;
            $r->balance = $balance;
            $reports[] = $r;
        }

        return $reports;
    }

    // ================= QUARTERLY REPORT =================
    public static function getQuarterlyReport($year, $quarter)
    {
        $conn = self::getConn();
        $start_month = ($quarter - 1) * 3 + 1;
        $end_month = $start_month + 2;
        $reports = [];

        for ($m = $start_month; $m <= $end_month; $m++) {
            $month = sprintf("%04d-%02d", $year, $m);
            $monthly = self::getReport($month);
            foreach ($monthly as $report) {
                $reports[$report->emp_id]['emp'] = $report;
                $reports[$report->emp_id]['due'] = ($reports[$report->emp_id]['due'] ?? 0) + $report->due_amount;
                $reports[$report->emp_id]['paid'] = ($reports[$report->emp_id]['paid'] ?? 0) + $report->paid_amount;
                $reports[$report->emp_id]['ot'] = ($reports[$report->emp_id]['ot'] ?? 0) + $report->ot_pay;
            }
        }

        $final = [];
        foreach ($reports as $emp_id => $r) {
            $report = $r['emp'];
            $report->due_amount = $r['due'];
            $report->paid_amount = $r['paid'];
            $report->ot_pay = $r['ot'];
            $report->balance = $r['due'] - $r['paid'];
            $final[] = $report;
        }

        return $final;
    }

    // ================= YEARLY REPORT =================
    public static function getYearlyReport($year)
    {
        $reports = [];
        for ($m = 1; $m <= 12; $m++) {
            $month = sprintf("%04d-%02d", $year, $m);
            $monthly = self::getReport($month);
            foreach ($monthly as $report) {
                $reports[$report->emp_id]['emp'] = $report;
                $reports[$report->emp_id]['due'] = ($reports[$report->emp_id]['due'] ?? 0) + $report->due_amount;
                $reports[$report->emp_id]['paid'] = ($reports[$report->emp_id]['paid'] ?? 0) + $report->paid_amount;
                $reports[$report->emp_id]['ot'] = ($reports[$report->emp_id]['ot'] ?? 0) + $report->ot_pay;
            }
        }

        $final = [];
        foreach ($reports as $emp_id => $r) {
            $report = $r['emp'];
            $report->due_amount = $r['due'];
            $report->paid_amount = $r['paid'];
            $report->ot_pay = $r['ot'];
            $report->balance = $r['due'] - $r['paid'];
            $final[] = $report;
        }

        return $final;
    }

    // ================= Expense Helpers =================
    public static function getTotalExpenses($month)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("SELECT SUM(amount) AS total_expense FROM expense WHERE DATE_FORMAT(expense_date,'%Y-%m')=?");
        $stmt->bind_param("s", $month);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total_expense'] ?? 0;
    }

    public static function getTotalExpensesForQuarter($year, $quarter)
    {
        $conn = self::getConn();
        $start_month = ($quarter - 1) * 3 + 1;
        $end_month = $start_month + 2;
        $stmt = $conn->prepare("SELECT SUM(amount) AS total_expense 
                                FROM expense WHERE expense_date BETWEEN ? AND ?");
        $from = sprintf("%04d-%02d-01", $year, $start_month);
        $to = sprintf("%04d-%02d-31", $year, $end_month);
        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total_expense'] ?? 0;
    }

    public static function getTotalExpensesForYear($year)
    {
        $conn = self::getConn();
        $stmt = $conn->prepare("SELECT SUM(amount) AS total_expense FROM expense WHERE YEAR(expense_date)=?");
        $stmt->bind_param("i", $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total_expense'] ?? 0;
    }

    private static function calculateSalary($type, $rate, $full, $half, $ot_pay)
    {
        if ($type === 'Daily')
            return ($full * $rate) + ($half * $rate * 0.5) + $ot_pay;
        elseif ($type === 'Weekly')
            return (($full / 6) * $rate) + (($half / 12) * $rate) + $ot_pay;
        else
            return (($full / 26) * $rate) + (($half / 52) * $rate) + $ot_pay;
    }

    public static function getDueAmountByEmployee($emp_id)
    {
        $conn = self::getConn();

        // Get all months where employee has attendance
        $att_q = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date, '%Y-%m') AS month FROM attendance WHERE emp_id=?");
        $att_q->bind_param("i", $emp_id);
        $att_q->execute();
        $months = $att_q->get_result()->fetch_all(MYSQLI_ASSOC);

        $total_due = 0;
        foreach ($months as $m) {
            $month = $m['month'];
            $reports = self::getReport($month);
            foreach ($reports as $r) {
                if ($r->emp_id == $emp_id) {
                    $balance = round($r->balance, 2);
                    // ✅ Only add positive dues (ignore zero or negative)
                    if ($balance > 0.01) {
                        $total_due += $balance;
                    }
                }
            }
        }

        return $total_due;
    }
    // ================= EMPLOYEE SALARY SUMMARY (ALL TIME) =================
    public static function getEmployeeSummary($emp_id)
    {
        $conn = self::getConn();

        /* ===============================
           1️⃣ TOTAL DUE (Attendance based)
           =============================== */

        // 🔹 Monthly-based due (fixed salary / OT / etc)
        $att_q = $conn->prepare("
        SELECT DISTINCT DATE_FORMAT(date,'%Y-%m') AS month
        FROM attendance
        WHERE emp_id=?
    ");
        $att_q->bind_param("i", $emp_id);
        $att_q->execute();
        $months = $att_q->get_result()->fetch_all(MYSQLI_ASSOC);

        $total_due = 0;

        foreach ($months as $m) {
            $month = $m['month'];
            $reports = self::getReport($month);

            foreach ($reports as $r) {
                if ($r->emp_id == $emp_id) {
                    $total_due += (float) $r->due_amount;
                }
            }
        }

        /* ===============================
           2️⃣ HOURLY SALARY FROM ATTENDANCE
           =============================== */

        $hourlyQ = $conn->prepare("
        SELECT 
            COALESCE(SUM(a.worked_hours * e.hourly_rate), 0) AS total
        FROM attendance a
        JOIN employee e ON e.id = a.emp_id
        WHERE a.emp_id = ?
          AND e.hourly_rate > 0
    ");
        $hourlyQ->bind_param("i", $emp_id);
        $hourlyQ->execute();
        $hourlySalary = (float) $hourlyQ->get_result()->fetch_assoc()['total'];

        // ✅ Add hourly salary to total due
        $total_due += $hourlySalary;

        /* ===============================
           3️⃣ TOTAL PAID (All payments)
           =============================== */

        $pay_q = $conn->prepare("
        SELECT COALESCE(SUM(amount),0) AS paid
        FROM employee_payment
        WHERE emp_id=?
    ");
        $pay_q->bind_param("i", $emp_id);
        $pay_q->execute();
        $total_paid = (float) $pay_q->get_result()->fetch_assoc()['paid'];

        /* ===============================
           4️⃣ FINAL SUMMARY
           =============================== */

        return [
            'total_amount' => round($total_due, 2),
            'paid_amount' => round($total_paid, 2),
            'balance' => round($total_due - $total_paid, 2)
        ];
    }


    // ================= EMPLOYEE SUMMARY (ALL EMPLOYEES | ALL TIME) =================
    public static function getAllEmployeeSummary()
    {
        $conn = self::getConn();
        $employees = $conn->query("SELECT id, name FROM employee")->fetch_all(MYSQLI_ASSOC);

        $result = [];

        foreach ($employees as $emp) {
            $summary = self::getEmployeeSummary($emp['id']);

            $result[] = [
                'emp_id' => $emp['id'],
                'emp_name' => $emp['name'],
                'total_amount' => $summary['total_amount'],
                'paid_amount' => $summary['paid_amount'],
                'balance' => $summary['balance'],
            ];

        }

        return $result;
    }

}
?>