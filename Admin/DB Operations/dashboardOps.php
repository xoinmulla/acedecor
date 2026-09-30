<?php
require_once "../DB Operations/dbconnection.php";
class DBDashboard
{
    public static function customerenqpercentage()
    {
        $db = ConnectDb::getInstance();
        $query = "select(SELECT  count(*)from customer) AS Customer,
    (select count(*) From enquiry_details ) AS Enquiries ";
        $customer = mysqli_query($db->getConnection(), $query);
        return $customer;
    }

    public static function projectstatus()
    {
        $db = ConnectDb::getInstance();
        $query = "select(SELECT  count(*) from projects where project_status='In Progress') AS OngoingProjects,
    (select count(*) from projects where project_status='Completed' ) AS CompletedProjects ";
        $projectstatus = mysqli_query($db->getConnection(), $query);
        return $projectstatus;
    }

    public static function EnqandCustomer()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT  C.Customers AS Customer, E.Enquiries AS Enquiries, E.MONTH AS MONTH,P.Projects FROM customerlastm AS C JOIN enquirylastm AS E ON C.MONTH=E.MONTH  Join projectslastm as P ON C.MONTH=P.MONTH";
        $EnqAndCustomer = mysqli_query($db->getConnection(), $query);
        return $EnqAndCustomer;
    }

    public static function InwardedandAvailable()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT  S.ReceivedQty AS ReceivedQty, A.AvailableQty AS AvailableQty, A.MONTH AS MONTH FROM inwardedlastq AS S JOIN availableqty AS A ON S.MONTH=A.MONTH ";
        $InwardedandAvailable = mysqli_query($db->getConnection(), $query);
        return $InwardedandAvailable;
    }

    public static function Totalenquiries()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT count(*) as total from enquiry_details";
        $result = mysqli_query($db->getConnection(), $query);
        $totalenquiries = mysqli_fetch_assoc($result);
        return $totalenquiries;
    }

    public static function Totalcustomers()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT count(*) as total from (
            select customerId ,quoteCode from quotation_details where quo_status='Approved'
            group by customerId)as TEMP where TEMP.customerId ";
        $result = mysqli_query($db->getConnection(), $query);
        $totalcustomer = mysqli_fetch_assoc($result);
        return $totalcustomer;
    }

    public static function OngoingProjects()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $query = "
        SELECT COUNT(*) AS total
        FROM projects P
        JOIN quotation_details Q ON P.quoteId = Q.quoteCode
        WHERE P.project_status = 'In Progress'
          AND Q.quo_status = 'Approved'
    ";

        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public static function CompletedProjects()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $query = "
        SELECT COUNT(DISTINCT P.custId) AS total
        FROM projects P
        JOIN quotation_details Q 
            ON P.quoteId = Q.quoteCode
        WHERE P.project_status = 'Completed'
          AND Q.quo_status = 'Approved'
    ";

        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }


    public static function PendingProjects()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $query = "
        SELECT COUNT(*) AS total
        FROM projects
        WHERE project_status = 'Pending'
    ";

        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }


    public static function Totalsuppliers()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT COUNT(*) as total from (
            SELECT supplierId,POID FROM supplierpaymentinfo
            GROUP BY
            supplierId,
            POID) AS TEMP where TEMP.supplierId NOT IN (SELECT supplierId from supplierpaymentinfo where pending_amount=0) and
            TEMP.POID NOT IN(SELECT POID from supplierpaymentinfo where pending_amount=0) ";
        $result = mysqli_query($db->getConnection(), $query);
        $totalsuppliers = mysqli_fetch_assoc($result);
        return $totalsuppliers;
    }

    public static function Customerbalanceamount()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT sum(total) as total from customerbalanceamt";
        $result = mysqli_query($db->getConnection(), $query);
        $balanceamount = mysqli_fetch_assoc($result);
        return $balanceamount;
    }

    public static function Supplierbalanceamount()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT sum(total) as total from supplierbalanceamt";
        $result = mysqli_query($db->getConnection(), $query);
        $balanceamount = mysqli_fetch_assoc($result);
        return $balanceamount;
    }

    public static function PaidandReceived()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT  C.ReceivedAmt AS ReceivedAmt, S.PaidAmt AS PaidAmt,S.MONTH AS MONTH FROM customerpaymentlastq AS C JOIN supplierpaymentlastq AS S ON C.MONTH=S.MONTH";
        $EnqAndCustomer = mysqli_query($db->getConnection(), $query);
        return $EnqAndCustomer;
    }

    public static function supplierpaymentinfo()
    {
        $db = ConnectDb::getInstance();
        $query = "select(SELECT  sum(paid_amount) from supplierpaymentinfo) AS PaidAmt,
        (SELECT sum(total) as total from supplierbalanceamt ) AS BalanceAmt ";
        $Supplierpayment = mysqli_query($db->getConnection(), $query);
        return $Supplierpayment;
    }

    public static function customerpaymentinfo()
    {
        $db = ConnectDb::getInstance();
        $query = "select(SELECT  sum(received_amount) from customerpaymentinfo) AS PaidAmt,
        (SELECT sum(total) as total from customerbalanceamt) AS BalanceAmt ";
        $customerpayment = mysqli_query($db->getConnection(), $query);
        return $customerpayment;
    }

    public static function totalbrands()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT count(*) as total from brands";
        $result = mysqli_query($db->getConnection(), $query);
        $totalbrands = mysqli_fetch_assoc($result);
        return $totalbrands;
    }

    public static function totalsupplierscount()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT count(*) as total from item_companydetails";
        $result = mysqli_query($db->getConnection(), $query);
        $totalbrands = mysqli_fetch_assoc($result);
        return $totalbrands;
    }

    public static function totalbrandinwarded()
    {
        $db = ConnectDb::getInstance();
        $query = "SELECT I.item_compid as BrandId,
        S.item_id from item_stock S 
        join item_details I on I.item_compid=Sitem_id group by item_id";
        $result = mysqli_query($db->getConnection(), $query);
        $totalbrands = mysqli_fetch_assoc($result);
        return $totalbrands;
    }
    /** ✅ Total Employee Balance (Pending amount across all employees) */
    public static function EmployeeBalanceAmount()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        // Fetch hours per day from settings (default 8)
        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hours_per_day FROM settings LIMIT 1"));
        $hpd = isset($row['hours_per_day']) && $row['hours_per_day'] > 0 ? (float) $row['hours_per_day'] : 8.0;

        $query = "
            SELECT 
                SUM(GREATEST(emp_due - emp_paid, 0)) AS total
            FROM (
                SELECT 
                    e.id,
                    (
                        CASE e.salary_type
                            WHEN 'Daily'   THEN (SUM(a.worked_hours) * (e.salary_amount / $hpd))
                            WHEN 'Weekly'  THEN (SUM(a.worked_hours) * (e.salary_amount / (6 * $hpd)))
                            WHEN 'Monthly' THEN (SUM(a.worked_hours) * (e.salary_amount / (26 * $hpd)))
                            ELSE (SUM(a.worked_hours) * (e.salary_amount / $hpd))
                        END
                    ) + SUM(a.ot_pay) AS emp_due,
                    COALESCE((SELECT SUM(amount) FROM employee_payment ep WHERE ep.emp_id = e.id), 0) AS emp_paid
                FROM employee e
                JOIN attendance a ON a.emp_id = e.id
                GROUP BY e.id
            ) t
        ";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }
    /** ✅ Total Expenses (sum of all expense amounts) */
    public static function TotalExpenseAmount()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $query = "SELECT COALESCE(SUM(amount), 0) AS total FROM expense";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }
    /** ✅ Employee Payment Info (Paid vs Pending for charts) */
    public static function employeepaymentinfo()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        // Get settings
        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hours_per_day FROM settings LIMIT 1"));
        $hpd = isset($row['hours_per_day']) && $row['hours_per_day'] > 0 ? (float) $row['hours_per_day'] : 8.0;

        // Total paid amount
        $paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(amount),0) AS paid FROM employee_payment"));
        $paid = (float) $paidRow['paid'];

        // Total pending calculation
        $balQuery = "
            SELECT 
                SUM(GREATEST(emp_due - emp_paid, 0)) AS balance
            FROM (
                SELECT 
                    e.id,
                    (
                        CASE e.salary_type
                            WHEN 'Daily'   THEN (SUM(a.worked_hours) * (e.salary_amount / $hpd))
                            WHEN 'Weekly'  THEN (SUM(a.worked_hours) * (e.salary_amount / (6 * $hpd)))
                            WHEN 'Monthly' THEN (SUM(a.worked_hours) * (e.salary_amount / (26 * $hpd)))
                            ELSE (SUM(a.worked_hours) * (e.salary_amount / $hpd))
                        END
                    ) + SUM(a.ot_pay) AS emp_due,
                    COALESCE((SELECT SUM(amount) FROM employee_payment ep WHERE ep.emp_id = e.id), 0) AS emp_paid
                FROM employee e
                JOIN attendance a ON a.emp_id = e.id
                GROUP BY e.id
            ) t
        ";
        $balResult = mysqli_query($conn, $balQuery);
        $balanceRow = mysqli_fetch_assoc($balResult);
        $balance = (float) $balanceRow['balance'];

        // Return as a result set (for Google Charts)
        $data = mysqli_query($conn, "SELECT $paid AS PaidAmt, $balance AS BalanceAmt");
        return $data;
    }
    public static function TotalEmployees()
    {
        $conn = ConnectDb::getInstance()->getConnection();
        $result = $conn->query("SELECT COUNT(*) AS totalEmployees FROM employee");
        return $result->fetch_assoc();
    }
    public static function EmployeeSalaryDetails()
    {
        $db = ConnectDb::getInstance();              // ✅ consistent with other methods
        $conn = $db->getConnection();

        // Adjust this SQL according to your actual schema
        // If you don't have "employee_salary_summary", you can build from your employee & payment tables
        $sql = "
        SELECT 
            e.name,
            COALESCE(SUM(p.amount), 0) AS paid_amt,
            GREATEST(
                (
                    CASE e.salary_type
                        WHEN 'Daily'   THEN (SUM(a.worked_hours) * (e.salary_amount / 8))
                        WHEN 'Weekly'  THEN (SUM(a.worked_hours) * (e.salary_amount / (6 * 8)))
                        WHEN 'Monthly' THEN (SUM(a.worked_hours) * (e.salary_amount / (26 * 8)))
                        ELSE (SUM(a.worked_hours) * (e.salary_amount / 8))
                    END
                ) + SUM(a.ot_pay)
                - COALESCE(SUM(p.amount), 0),
                0
            ) AS pending_amt
        FROM employee e
        LEFT JOIN attendance a ON e.id = a.emp_id
        LEFT JOIN employee_payment p ON e.id = p.emp_id
        GROUP BY e.name
    ";

        return mysqli_query($conn, $sql);
    }
    /** ✅ Total Income (Sum of expenses linked to Income categories) */
    public static function TotalIncome()
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT COALESCE(SUM(amount), 0) AS total
        FROM expense
        WHERE type = 'Income'
    ";

        $res = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($res);
    }

    /** ✅ Total Expenses (Sum of expenses linked to Expense categories) */
    public static function TotalExpenses()
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT COALESCE(SUM(amount), 0) AS total
        FROM expense
        WHERE type = 'Expense'
    ";

        $res = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($res);
    }

    /** ✅ Net Balance (Income - Expense) */
    public static function NetBalance()
    {
        $incomeRow = self::TotalIncome();
        $expenseRow = self::TotalExpenses();

        $income = (float) ($incomeRow['total'] ?? 0);
        $expense = (float) ($expenseRow['total'] ?? 0);

        $balance = $income - $expense;

        return ['total' => $balance];
    }
    public static function MainProjects()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $query = "
    SELECT COUNT(DISTINCT SUBSTRING_INDEX(quoteId, '-', 1)) AS total
    FROM projects
    WHERE project_status = 'In Progress'
    ";

        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public static function CustomerFinancialGraph()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "
        SELECT 
            c.customer_name AS name,
            SUM(cp.total_amount) AS total_amt,
            SUM(cp.pending_amount) AS pending_amt,
            COALESCE(SUM(e.amount), 0) AS expenditure
        FROM customerpaymentinfo cp
        JOIN customer c ON c.customer_id = cp.customer_id
        LEFT JOIN expense e 
            ON e.type = 'Expense' 
            AND e.category = 'Customer' 
            AND e.customer_id = cp.customer_id
        GROUP BY cp.customer_id
        ORDER BY c.customer_name
    ";

        return mysqli_query($conn, $sql);
    }
    public static function getPLIncome()
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT
            COALESCE(SUM(quoteValue),0) AS sales
        FROM quotation_details
        WHERE quo_status = 'Approved'
    ";

        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);

        $sales = (float) $row['sales'];

        return [
            'sales' => $sales,
            'discount' => 0, // keep structure same (no impact)
            'net_income' => $sales
        ];
    }
    public static function getPLExpensePaid()
    {
        $conn = ConnectDb::getInstance()->getConnection();

        $sql = "
        SELECT COALESCE(SUM(amount), 0) AS total
        FROM expense
        WHERE type = 'Expense'
    ";

        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);


        return (float) $row['total'];
    }
    public static function getPLEmployeeAccrual()
    {
        $row = self::EmployeeBalanceAmount();
        return (float) ($row['total'] ?? 0);
    }
    public static function getPLExpenses()
    {
        $conn = ConnectDb::getInstance()->getConnection();

        // 1️⃣ Paid expenses (cash expense table only)
        $sql = "
        SELECT COALESCE(SUM(amount),0) AS total
        FROM expense
        WHERE type = 'Expense'
    ";

        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $paid = (float) ($row['total'] ?? 0);

        /* ===============================
           2️⃣ REAL EMPLOYEE PAYABLE
           =============================== */
        require_once dirname(__FILE__, 2) . "/DB Operations/monthlyReportOps.php";

        $employees = DBMonthlyReport::getAllEmployeeSummary();
        $employeePayable = 0;

        foreach ($employees as $emp) {
            if ($emp['balance'] > 0) {
                $employeePayable += $emp['balance'];
            }
        }

        /* ===============================
           3️⃣ REAL SUPPLIER PAYABLE
           =============================== */
        require_once dirname(__FILE__, 2) . "/DB Operations/supplierpaymentOps.php";

        $suppliers = DBsupplierpayment::getAllsupplierpayment();
        $supplierPayable = 0;

        foreach ($suppliers as $sup) {
            $supplierPayable += $sup->get_pendingamt();
        }

        $totalPayable = $employeePayable + $supplierPayable;

        return [
            'paid' => $paid,
            'payable' => $totalPayable,
            'total' => $paid + $totalPayable
        ];
    }
    public static function getPLNetProfit()
    {
        $income = self::getPLIncome();
        $expense = self::getPLExpenses();

        return [
            'net_profit' => $income['net_income'] - $expense['total']
        ];
    }


}






