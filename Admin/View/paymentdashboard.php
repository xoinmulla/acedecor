<!doctype html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('session.php');
include "paymentnavigation.php";
require_once "../DB Operations/dashboardOps.php";
require_once "../DB Operations/customerpaymentOps.php";


// ---- Financial Dashboard Data ---- //
$totalIncome = DBDashboard::TotalIncome();
$totalExpense = DBDashboard::TotalExpenses();
$netBalance = ($totalIncome['total'] ?? 0) - ($totalExpense['total'] ?? 0);
$totalsuppliers = DBDashboard::Totalsuppliers();
$totalcustomer = DBDashboard::Totalcustomers();
$totalEmployees = DBDashboard::TotalEmployees();
$employeeBarChart = DBDashboard::EmployeeSalaryDetails();
?>

<head>
  <meta charset="utf-8">
  <title>Financial Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    /* ===================== ROOT THEME ===================== */
    :root {
      --primary: #2563eb;
      --success: #16a34a;
      --danger: #dc2626;
      --warning: #f59e0b;
      --info: #06b6d4;
      --dark: #0f172a;
      --glass: rgba(255, 255, 255, 0.75);
    }

    /* ===================== PAGE ===================== */
    body {
      background: radial-gradient(circle at top left, #e0e7ff, #f8fafc);
      font-family: "Inter", "Segoe UI", system-ui;
      color: #0f172a;
    }

    .container-fluid {
      max-width: 1600px;
    }

    /* ===================== HEADER ===================== */
    .dashboard-header {
      font-size: 1.8rem;
      font-weight: 800;
      letter-spacing: .3px;
      color: var(--dark);
    }

    /* ===================== NAV TABS ===================== */
    .nav-pills {
      gap: 12px;
    }

    .nav-pills .nav-link {
      border-radius: 14px;
      padding: 12px 22px;
      font-weight: 600;
      background: rgba(255, 255, 255, 0.6);
      color: #334155;
      backdrop-filter: blur(10px);
      transition: all .35s ease;
    }

    .nav-pills .nav-link:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .nav-pills .nav-link.active {
      background: linear-gradient(135deg, #2563eb, #06b6d4);
      color: #fff;
      box-shadow: 0 14px 40px rgba(37, 99, 235, .45);
    }

    /* ===================== STAT CARDS ===================== */
    .stat-card {
      background: var(--glass);
      backdrop-filter: blur(14px);
      border-radius: 22px;
      padding: 30px 20px;
      text-align: center;
      transition: all .4s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-card::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(120deg, transparent, rgba(255, 255, 255, .6), transparent);
      transform: translateX(-100%);
    }

    .stat-card:hover::after {
      transform: translateX(100%);
      transition: 1s;
    }

    .stat-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
      font-size: 3rem;
      margin-bottom: 12px;
    }

    .stat-title {
      font-size: .95rem;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: #475569;
    }

    .stat-value {
      font-size: 2.2rem;
      font-weight: 800;
    }

    /* ===================== CHART CARDS ===================== */
    .chart-card {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(16px);
      border-radius: 26px;
      padding: 30px;
      box-shadow: 0 18px 45px rgba(0, 0, 0, .12);
      animation: fadeUp .6s ease;
    }

    .chart-card h5 {
      font-weight: 800;
      letter-spacing: .4px;
    }

    /* ===================== ALERT ===================== */
    .alert {
      border-radius: 18px;
      font-size: 1.05rem;
    }

    /* ===================== ANIMATION ===================== */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ===================== ELITE TABS ===================== */

    .tabs-wrapper {
      display: flex;
      justify-content: center;
    }

    .tabs-elite {
      display: flex;
      gap: 8px;
      padding: 10px;
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(16px);
      border-radius: 20px;
      box-shadow: 0 25px 55px rgba(0, 0, 0, 0.12);
    }

    .tabs-elite .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 14px 22px;
      border-radius: 14px;
      font-weight: 600;
      font-size: 0.95rem;
      color: #334155;
      background: transparent;
      border: none;
      position: relative;
      transition: all .35s ease;
    }

    .tabs-elite .nav-link i {
      font-size: 1.05rem;
      opacity: .75;
    }

    /* Hover */
    .tabs-elite .nav-link:hover {
      background: rgba(37, 99, 235, 0.08);
      color: #2563eb;
    }

    /* Active */
    .tabs-elite .nav-link.active {
      background: linear-gradient(135deg, #2563eb, #06b6d4);
      color: #fff;
      box-shadow: 0 12px 35px rgba(37, 99, 235, 0.45);
    }

    .tabs-elite .nav-link.active i {
      opacity: 1;
    }

    /* Animated underline */
    .tabs-elite .nav-link::after {
      content: "";
      position: absolute;
      bottom: -8px;
      left: 50%;
      width: 0;
      height: 4px;
      background: linear-gradient(135deg, #2563eb, #06b6d4);
      border-radius: 6px;
      transform: translateX(-50%);
      transition: width .35s ease;
    }

    .tabs-elite .nav-link.active::after {
      width: 40%;
    }

    .tab-pane {
      animation: tabFade .5s ease;
    }

    @keyframes tabFade {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
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
        ['Total Income', <?= intval($totalIncome['total'] ?? 0); ?>],
        ['Total Expense', <?= intval($totalExpense['total'] ?? 0); ?>],
        ['Net Balance', <?= intval($netBalance); ?>]
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
    function drawCustomerGraph() {

      var data = google.visualization.arrayToDataTable([
        ['Customer', 'Total Amount', 'Balance Amount', 'Expenditure'],
        <?php
        $customerList = DBpayment::getAllcustomerpayment();

        foreach ($customerList as $customer) {
          echo "[
          '" . addslashes($customer->get_custname()) . "',
          " . floatval($customer->get_totalamt()) . ",
          " . floatval($customer->get_pendingamt()) . ",
          " . floatval($customer->get_expenditure()) . "
        ],";
        }
        ?>
      ]);

      var options = {
        title: 'Customer: Total vs Balance vs Expenditure',
        bars: 'vertical',
        height: 420,
        legend: { position: 'bottom' },
        colors: ['#0d6efd', '#dc3545', '#f0ad4e'],
        chartArea: { width: '85%', height: '75%' }
      };

      new google.visualization.ColumnChart(
        document.getElementById('customer_graph_chart')
      ).draw(data, options);
    }
  </script>
</head>

<body>
  <div class="container-fluid py-4">
    <h2 class="dashboard-header mb-4"><i class="fas fa-chart-line me-2"></i>Financial Dashboard</h2>
    <div class="tabs-wrapper mb-5">
      <ul class="nav tabs-elite" id="dashboardTabs" role="tablist">

        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-dashboard">
            <i class="fas fa-layer-group"></i>
            <span>Dashboard</span>
          </button>
        </li>

        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="pill" data-bs-target="">
            <i class="fas fa-solid fa-money-check-dollar"></i>
            <span>Profit & Loss</span>
          </button>
        </li>

        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-ien">
            <i class="fas fa-chart-pie"></i>
            <span>IEN</span>
          </button>
        </li>

        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-customer">
            <i class="fas fa-users"></i>
            <span>Customer’s Graph</span>
          </button>
        </li>

        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-supplier">
            <i class="fas fa-store"></i>
            <span>Supplier’s Graph</span>
          </button>
        </li>

        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-employee">
            <i class="fas fa-user-tie"></i>
            <span>Employee’s Graph</span>
          </button>
        </li>

      </ul>
    </div>

    <div class="tab-content" id="dashboardTabsContent">

      <!-- ===================== ROW 1: MAIN FINANCIAL SUMMARY ===================== -->
      <div class="tab-pane fade show active" id="tab-dashboard">

        <!-- ROW 1 -->
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

        <!-- ROW 2 -->
        <div class="row g-3">
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
      </div>

      <div class="tab-pane fade" id="tab-ien">
        <div class="chart-card">
          <h5 class="text-center text-primary mb-3">
            <i class="fa-solid fa-chart-pie me-2"></i>
            Income vs Expense vs Net Balance
          </h5>
          <div id="finance_pie_chart"></div>
        </div>
      </div>

      <div class="tab-pane fade" id="tab-customer">
        <div class="chart-card">
          <h5 class="text-center text-info mb-3">
            <i class="fa-solid fa-users me-2"></i>
            Customer Financial Summary
          </h5>
          <div id="customer_graph_chart"></div>
        </div>
      </div>

      <div class="tab-pane fade" id="tab-supplier">
        <div class="alert alert-warning text-center fw-semibold">
          📈 Supplier graph will be added here
        </div>
      </div>

      <div class="tab-pane fade" id="tab-employee">
        <div class="chart-card">
          <h5 class="text-center text-secondary mb-3">
            <i class="fa-solid fa-chart-column me-2"></i>
            Employee Salary: Paid vs Pending
          </h5>
          <div id="employee_bar_chart"></div>
        </div>
      </div>


    </div>
  </div>
  <script>
    document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
      tab.addEventListener('shown.bs.tab', function (e) {
        drawCharts();

        if (e.target.getAttribute('data-bs-target') === '#tab-customer') {
          drawCustomerGraph();
        }
      });
    });

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>