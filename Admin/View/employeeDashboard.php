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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body { background:#f4f7fb; font-family:"Segoe UI",Arial; }
    .dashboard-header { font-weight:700; color:#0d6efd; }
    .stat-card { background:white; border-radius:12px; padding:25px; text-align:center; box-shadow:0 4px 15px rgba(0,0,0,0.05); }
    .stat-card i { font-size:2.5rem; color:#0d6efd; margin-bottom:10px; }
    .stat-title { color:#6c757d; font-weight:600; }
    .stat-value { font-size:2rem; color:#0d6efd; font-weight:700; }
    .chart-card { background:white; border-radius:15px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.05); margin-top:20px; }
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
        <?php while($r = $attBreak->fetch_assoc()) echo "['{$r['status']}', {$r['total']}],"; ?>
      ]);
      new google.visualization.PieChart(document.getElementById('att_chart'))
        .draw(data, { title:'Attendance Breakdown', pieHole:0.4, colors:['#198754','#dc3545','#ffc107','#0d6efd'] });
    }

    // ✅ Updated Chart: Due vs Payments (All Time)
    function drawDueVsPayments() {
      var data = google.visualization.arrayToDataTable([
        ['Employee', 'Due Amount', 'Paid Amount'],
        <?php foreach($salaryPayData as $r) echo "['{$r['name']}', {$r['due_amt']}, {$r['paid_amt']}],"; ?>
      ]);

      new google.visualization.ColumnChart(document.getElementById('salary_chart'))
        .draw(data, { 
          title: 'Due vs Payments (All Time)', 
          legend: { position: 'bottom' }, 
          colors: ['#fd7e14', '#198754']
        });
    }

    function drawOTTrend() {
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'OT Hours');

      data.addRows([
        <?php 
          while($r = $otTrend->fetch_assoc()) {
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

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-3"><div class="stat-card"><i class="fa-solid fa-users"></i><div class="stat-title">Total Employees</div><div class="stat-value"><?= $totalEmp ?></div></div></div>
      <div class="col-md-3"><div class="stat-card"><i class="fa-solid fa-user-check"></i><div class="stat-title">Present Today</div><div class="stat-value"><?= $presentToday ?></div></div></div>
      <div class="col-md-3"><div class="stat-card"><i class="fa-solid fa-user-times"></i><div class="stat-title">Absent</div><div class="stat-value"><?= $absentToday ?></div></div></div>
      <div class="col-md-3"><div class="stat-card"><i class="fa-solid fa-clock"></i><div class="stat-title">OT Hours (Month)</div><div class="stat-value"><?= $otHours ?></div></div></div>
    </div>

    <!-- Charts -->
    <div class="row g-4">
      <div class="col-md-6"><div class="chart-card"><div id="att_chart" style="height:300px;"></div></div></div>
      <div class="col-md-6"><div class="chart-card"><div id="salary_chart" style="height:300px;"></div></div></div>
      <!-- <div class="col-md-12"><div class="chart-card"><div id="ot_chart" style="height:300px;"></div></div></div> -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
