<!doctype html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('session.php');
include "paymentnavigation.php";
require_once "../DB Operations/dashboardOps.php";

// ---- Financial Dashboard Data ---- //
$totalIncome       = DBDashboard::TotalIncome();
$totalExpense      = DBDashboard::TotalExpenses();
$netBalance        = ($totalIncome['total'] ?? 0) - ($totalExpense['total'] ?? 0);
$totalsuppliers    = DBDashboard::Totalsuppliers();
$totalcustomer     = DBDashboard::Totalcustomers();
$totalEmployees    = DBDashboard::TotalEmployees();
$employeeBarChart  = DBDashboard::EmployeeSalaryDetails();
?>
<head>
  <meta charset="utf-8">
  <title>Financial Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f7fb;
      font-family: "Segoe UI", Arial;
    }
    .container-fluid { max-width: 1500px; }
    .dashboard-header { font-weight: 700; color: #0d6efd; }
    .card {
      border: none; border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      transition: all .3s ease-in-out;
    }
    .card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .stat-card { text-align: center; background: white; padding: 25px 10px; }
    .stat-icon { font-size: 2.5rem; margin-bottom: 10px; }
    .stat-title { color: #6c757d; font-weight: 600; font-size: 0.9rem; }
    .stat-value { font-size: 2rem; font-weight: 700; }
    .chart-card { background: #fff; border-radius: 15px; padding: 20px; margin-top: 20px; }
  </style>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
      drawFinancePie();
      drawEmployeeBar();
    }

    // ✅ PIE CHART: Total Income / Expense / Net Balance
    function drawFinancePie() {
      var data = google.visualization.arrayToDataTable([
        ['Metric', 'Amount'],
        ['Total Income',  <?= intval($totalIncome['total'] ?? 0); ?>],
        ['Total Expense', <?= intval($totalExpense['total'] ?? 0); ?>],
        ['Net Balance',   <?= intval($netBalance); ?>]
      ]);

      var options = {
        title: 'Total Income vs Expense vs Net Balance',
        pieHole: 0.4,
        legend: { position: 'bottom' },
        pieSliceText: 'value',
        colors: ['#198754', '#dc3545', '#0d6efd'],
        chartArea: { width: '90%', height: '80%' },
        height: 400
      };

      new google.visualization.PieChart(document.getElementById('finance_pie_chart')).draw(data, options);
    }

    // ✅ BAR CHART: Employee Salary (Paid vs Pending)
    function drawEmployeeBar() {
      var data = google.visualization.arrayToDataTable([
        ['Employee', 'Paid Amount', 'Pending Amount'],
        <?php
          $empData = DBDashboard::EmployeeSalaryDetails();
          while ($row = mysqli_fetch_array($empData)) {
            echo "['" . addslashes($row['name']) . "', " . intval($row['paid_amt']) . ", " . intval($row['pending_amt']) . "],";
          }
        ?>
      ]);

      var options = {
        title: 'Employee Salary: Paid vs Pending',
        legend: { position: 'bottom' },
        bars: 'vertical',
        colors: ['#198754', '#adb5bd'],
        height: 400
      };
      new google.visualization.ColumnChart(document.getElementById('employee_bar_chart')).draw(data, options);
    }
  </script>
</head>

<body>
  <div class="container-fluid py-4">
    <h2 class="dashboard-header mb-4"><i class="fas fa-chart-line me-2"></i>Financial Dashboard</h2>

    <!-- ===================== ROW 1: MAIN FINANCIAL SUMMARY ===================== -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card stat-card">
          <i class="fa-solid fa-hand-holding-dollar stat-icon text-success"></i>
          <div class="stat-title">Total Income</div>
          <div class="stat-value text-success">₹<?= number_format($totalIncome['total'] ?? 0, 2) ?></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card stat-card">
          <i class="fa-solid fa-money-bill-trend-up stat-icon text-danger"></i>
          <div class="stat-title">Total Expense</div>
          <div class="stat-value text-danger">₹<?= number_format($totalExpense['total'] ?? 0, 2) ?></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card stat-card">
          <i class="fa-solid fa-scale-balanced stat-icon text-primary"></i>
          <div class="stat-title">Net Balance</div>
          <div class="stat-value text-primary">₹<?= number_format($netBalance, 2) ?></div>
        </div>
      </div>
    </div>

    <!-- ===================== ROW 2: SUPPLIERS / CUSTOMERS / EMPLOYEES ===================== -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card stat-card">
          <i class="fa-solid fa-store stat-icon text-info"></i>
          <div class="stat-title">Total Suppliers</div>
          <div class="stat-value text-info"><?= $totalsuppliers['total'] ?? 0 ?></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card stat-card">
          <i class="fa-solid fa-users stat-icon text-warning"></i>
          <div class="stat-title">Total Customers</div>
          <div class="stat-value text-warning"><?= $totalcustomer['total'] ?? 0 ?></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card stat-card">
          <i class="fa-solid fa-user-tie stat-icon text-secondary"></i>
          <div class="stat-title">Total Employees</div>
          <div class="stat-value text-secondary"><?= $totalEmployees['totalEmployees'] ?? 0 ?></div>
        </div>
      </div>
    </div>

    <!-- ===================== ROW 3: CHARTS ===================== -->
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="chart-card">
          <h5 class="mb-3 text-center text-primary">
            <i class="fa-solid fa-chart-pie me-2"></i>Income vs Expense vs Net Balance
          </h5>
          <div id="finance_pie_chart"></div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="chart-card">
          <h5 class="mb-3 text-center text-secondary">
            <i class="fa-solid fa-chart-column me-2"></i>Employee Salary: Paid vs Pending
          </h5>
          <div id="employee_bar_chart"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
