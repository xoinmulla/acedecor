<!doctype html>
<html lang="en">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('session.php');
include "employeeNavigation.php";
require_once "../DB Operations/dbconnection.php";
require_once "../DB Operations/monthlyReportOps.php"; // ✅ For accurate due logic

$conn = ConnectDb::getInstance()->getConnection();

// ---- Summary Cards ---- //
$totalEmp = $conn->query("SELECT COUNT(*) AS total FROM employee")->fetch_assoc()['total'] ?? 0;
$presentToday = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date=CURDATE() AND status='Present'")->fetch_assoc()['total'] ?? 0;
$absentToday = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date=CURDATE() AND status='Absent'")->fetch_assoc()['total'] ?? 0;
$leaveToday = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date=CURDATE() AND status='Leave'")->fetch_assoc()['total'] ?? 0;
$otHours = $conn->query("SELECT COALESCE(SUM(ot_hours),0) AS total FROM attendance WHERE DATE_FORMAT(date,'%Y-%m') = DATE_FORMAT(CURDATE(),'%Y-%m')")->fetch_assoc()['total'] ?? 0;

// ---- Attendance Breakdown ---- //
$attBreak = $conn->query("
    SELECT status, COUNT(*) AS total 
    FROM attendance 
    WHERE DATE_FORMAT(date,'%Y-%m') = DATE_FORMAT(CURDATE(),'%Y-%m')
    GROUP BY status
");

// ---- Accurate Due vs Payments (All Time) ---- //
$salaryPayData = [];
$employees = $conn->query("SELECT id, name FROM employee");

while ($emp = $employees->fetch_assoc()) {
  $emp_id = $emp['id'];
  $name = $emp['name'];

  // Accurate due using Monthly Report logic
  $due_amt = DBMonthlyReport::getDueAmountByEmployee($emp_id);

  // Total paid across all time
  $paid_q = $conn->prepare("SELECT COALESCE(SUM(amount),0) AS total_paid FROM employee_payment WHERE emp_id=?");
  $paid_q->bind_param("i", $emp_id);
  $paid_q->execute();
  $paid_amt = $paid_q->get_result()->fetch_assoc()['total_paid'] ?? 0;

  $salaryPayData[] = [
    'name' => $name,
    'due_amt' => $due_amt,
    'paid_amt' => $paid_amt
  ];
}

// ---- OT Trend ---- //
$otTrend = $conn->query("
    SELECT DATE_FORMAT(date,'%d') AS day, SUM(ot_hours) AS hours 
    FROM attendance 
    WHERE DATE_FORMAT(date,'%Y-%m') = DATE_FORMAT(CURDATE(),'%Y-%m')
    GROUP BY DATE_FORMAT(date,'%d')
");
?>

<head>
  <meta charset="utf-8">
  <title>Employee Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    document.addEventListener('DOMContentLoaded', function () {

      const graphBtn = document.querySelector('[data-bs-target="#empGraphTab"]');

      if (graphBtn) {
        graphBtn.addEventListener('shown.bs.tab', function () {
          setTimeout(() => {
            drawCharts();
          }, 200); // allow layout to settle
        });
      }

    });
  </script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f7fb;
      font-family: "Segoe UI", Arial;
    }

    .dashboard-header {
      font-weight: 700;
      color: #0d6efd;
    }

    .stat-card {
      background: white;
      border-radius: 12px;
      padding: 25px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .stat-card i {
      font-size: 2.5rem;
      color: #0d6efd;
      margin-bottom: 10px;
    }

    .stat-title {
      color: #6c757d;
      font-weight: 600;
    }

    .stat-value {
      font-size: 2rem;
      color: #0d6efd;
      font-weight: 700;
    }

    /* ===== Full Screen Graph Cards ===== */
    .chart-card {
      height: 520px;
      border-radius: 28px;
      padding: 28px;
      background: #ffffff;
      box-shadow: 0 30px 70px rgba(0, 0, 0, 0.12);
      display: flex;
      flex-direction: column;
    }


    .chart-card h6 {
      font-size: 1.1rem;
      font-weight: 700;
      letter-spacing: 0.4px;
      margin-bottom: 20px;
    }


    /* ===== Ultimate Employee Cards ===== */
    /* ===== Ultimate Full-Screen Cards ===== */
    .emp-card {
      min-height: 260px;
      width: 100%;
      border-radius: 28px;
      padding: 36px;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 16px;
      position: relative;
      overflow: hidden;
      transition: all 0.45s ease;
      box-shadow: 0 30px 70px rgba(0, 0, 0, 0.28);
      max-width: 520px;
    }


    .emp-card::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(145deg,
          rgba(255, 255, 255, 0.25),
          rgba(255, 255, 255, 0));
    }

    .emp-card:hover {
      transform: translateY(-14px) scale(1.04);
      box-shadow: 0 45px 90px rgba(0, 0, 0, 0.45);
    }

    .emp-icon {
      font-size: 3.4rem;
      opacity: 0.95;
    }

    .emp-title {
      font-size: 1.05rem;
      letter-spacing: 0.5px;
      opacity: 0.9;
    }

    .emp-value {
      font-size: 3.2rem;
      font-weight: 900;
      letter-spacing: 1px;
    }


    /* Card Colors */
    .bg-emp-blue {
      background: linear-gradient(135deg, #5b86e5, #36d1dc);
    }

    .bg-emp-green {
      background: linear-gradient(135deg, #28a745, #20c997);
    }

    .bg-emp-red {
      background: linear-gradient(135deg, #dc3545, #ff6b6b);
    }

    .bg-emp-purple {
      background: linear-gradient(135deg, #6610f2, #9d4edd);
    }

    /* ===== Full Screen Dashboard Layout ===== */
    .dashboard-wrapper {
      min-height: calc(100vh - 120px);
      display: flex;
      flex-direction: column;
    }

    .full-height {
      flex: 1;
    }

    .section-padding {
      padding: 32px 24px;
    }

    @media (min-width: 1200px) {
      .section-padding {
        padding: 40px 60px;
      }
    }
  </style>

  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    google.charts.load('current', { packages: ['corechart', 'bar', 'line'] });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
      drawAttendance();
      drawDueVsPayments();
      drawOTTrend();
    }

    function drawAttendance() {
      var data = google.visualization.arrayToDataTable([
        ['Status', 'Count'],
        <?php
        mysqli_data_seek($attBreak, 0);
        while ($r = $attBreak->fetch_assoc()) {
          echo "['{$r['status']}', {$r['total']}],";
        }
        ?>
      ]);

      var options = {
        pieHole: 0.5,
        legend: { position: 'right', textStyle: { fontSize: 13 } },
        chartArea: {
          left: 20,
          top: 20,
          width: '85%',
          height: '85%'
        },
        colors: ['#198754', '#dc3545', '#ffc107', '#0d6efd'],
        backgroundColor: 'transparent'
      };

      new google.visualization.PieChart(
        document.getElementById('att_chart')
      ).draw(data, options);
    }


    // ✅ Updated Chart: Due vs Payments (All Time)
    function drawDueVsPayments() {

      var data = google.visualization.arrayToDataTable([
        ['Employee', 'Due Amount', 'Paid Amount'],
        <?php
        foreach ($salaryPayData as $r) {
          echo "['{$r['name']}', {$r['due_amt']}, {$r['paid_amt']}],";
        }
        ?>
      ]);

      var options = {
        legend: { position: 'top', textStyle: { fontSize: 13 } },
        bar: { groupWidth: '55%' },
        chartArea: {
          left: 60,
          top: 40,
          width: '80%',
          height: '70%'
        },
        colors: ['#fd7e14', '#198754'],
        backgroundColor: 'transparent',
        animation: {
          startup: true,
          duration: 1000,
          easing: 'out'
        },
        vAxis: {
          minValue: 0,
          gridlines: { color: '#e9ecef' }
        }
      };

      new google.visualization.ColumnChart(
        document.getElementById('salary_chart')
      ).draw(data, options);
    }


    function drawOTTrend() {
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'OT Hours');

      data.addRows([
        <?php
        while ($r = $otTrend->fetch_assoc()) {
          echo "[{$r['day']}, {$r['hours']}],";
        }
        ?>
      ]);

      var options = {
        title: 'Overtime Hours (This Month)',
        curveType: 'function',
        colors: ['#6610f2'],
        hAxis: { title: 'Day of Month', format: '0' },
        vAxis: { title: 'Hours' },
        legend: { position: 'bottom' }
      };

      new google.visualization.LineChart(document.getElementById('ot_chart')).draw(data, options);
    }
  </script>
</head>

<body>
  <div class="container-fluid py-4">
    <h2 class="dashboard-header mb-4"><i class="fa-solid fa-user-tie me-2"></i>Employee Dashboard</h2>
    <ul class="nav nav-pills mb-4 gap-2">
      <li class="nav-item">
        <button class="nav-link active px-4 fw-bold" data-bs-toggle="pill" data-bs-target="#empDashboardTab">
          <i class="fa-solid fa-layer-group me-2"></i>
          Dashboard
        </button>
      </li>

      <li class="nav-item">
        <button class="nav-link px-4 fw-bold" data-bs-toggle="pill" data-bs-target="#empGraphTab">
          <i class="fa-solid fa-chart-line me-2"></i>
          Graphs
        </button>
      </li>
    </ul>

    <!-- Summary Cards -->
    <div class="tab-content">
      <!-- ================= DASHBOARD TAB ================= -->
      <div class="tab-pane fade show active full-height" id="empDashboardTab">

        <div class="row g-5 full-height align-content-center">

          <div class="col-xl-6 col-lg-6 col-md-12 d-flex justify-content-center">
            <div class="emp-card bg-emp-blue">
              <div class="emp-icon"><i class="fa-solid fa-users"></i></div>
              <div class="emp-title">TOTAL EMPLOYEES</div>
              <div class="emp-value"><?= $totalEmp ?></div>
            </div>
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 d-flex justify-content-center">
            <div class="emp-card bg-emp-green">
              <div class="emp-icon"><i class="fa-solid fa-user-check"></i></div>
              <div class="emp-title">PRESENT TODAY</div>
              <div class="emp-value"><?= $presentToday ?></div>
            </div>
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 d-flex justify-content-center">
            <div class="emp-card bg-emp-red">
              <div class="emp-icon"><i class="fa-solid fa-user-xmark"></i></div>
              <div class="emp-title">ABSENT TODAY</div>
              <div class="emp-value"><?= $absentToday ?></div>
            </div>
          </div>

          <div class="col-xl-6 col-lg-6 col-md-12 d-flex justify-content-center">
            <div class="emp-card bg-emp-purple">
              <div class="emp-icon"><i class="fa-solid fa-clock"></i></div>
              <div class="emp-title">OT HOURS (MONTH)</div>
              <div class="emp-value"><?= number_format($otHours, 2) ?></div>
            </div>
          </div>

        </div>
      </div>



      <!-- Charts -->
      <!-- ================= GRAPH TAB ================= -->
      <div class="tab-pane fade full-height" id="empGraphTab">

        <div class="row g-5 full-height">

          <div class="col-xl-6 col-lg-12">
            <div class="chart-card">
              <h6 class="text-primary text-center">
                <i class="fa-solid fa-chart-pie me-2"></i>
                Attendance Breakdown
              </h6>
              <div id="att_chart" style="flex:1;"></div>
            </div>
          </div>

          <div class="col-xl-6 col-lg-12">
            <div class="chart-card">
              <h6 class="text-success text-center">
                <i class="fa-solid fa-money-check-dollar me-2"></i>
                Due vs Payments (All Time)
              </h6>
              <div id="salary_chart" style="flex:1;"></div>
            </div>
          </div>

        </div>
      </div>


    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>