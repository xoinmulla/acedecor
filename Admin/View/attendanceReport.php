<?php
include('session.php');
include('employeeNavigation.php');
require_once("../DB Operations/attendanceReportOps.php");

$viewType = $_GET['type'] ?? 'monthly';
$month = $_GET['month'] ?? date('Y-m');
$year = $_GET['year'] ?? date('Y');
$quarter = $_GET['quarter'] ?? 1;

if ($viewType === 'monthly')
    $reports = DBAttendanceReport::getReport($month);
elseif ($viewType === 'quarterly')
    $reports = DBAttendanceReport::getQuarterlyReport($year, $quarter);
else
    $reports = DBAttendanceReport::getYearlyReport($year);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Reports Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: "Segoe UI", Arial;
        }

        .container-fluid {
            max-width: 1400px;
        }

        .card {
            border-radius: 10px;
        }

        .nav-tabs .nav-link.active {
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4">
        <h2 class="fw-semibold text-primary mb-4">📊 Reports Dashboard</h2>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link <?= $viewType === 'monthly' ? 'active' : '' ?>"
                    href="?type=monthly&month=<?= $month ?>">Monthly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $viewType === 'quarterly' ? 'active' : '' ?>"
                    href="?type=quarterly&year=<?= $year ?>&quarter=<?= $quarter ?>">Quarterly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $viewType === 'yearly' ? 'active' : '' ?>"
                    href="?type=yearly&year=<?= $year ?>">Yearly</a>
            </li>
        </ul>

        <!-- Filters -->
        <?php if ($viewType === 'monthly'): ?>
            <form method="POST" action="../Controller/attendanceReportController.php"
                class="d-flex align-items-center mb-3">
                <input type="hidden" name="type" value="monthly">
                <input type="month" name="month" class="form-control me-2" value="<?= $month ?>" required>
                <button class="btn btn-primary">View Report</button>
            </form>
            <h5 class="text-secondary mb-3">Report for
                <?= date('F Y', strtotime($month)) ?>
            </h5>
        <?php endif; ?>

        <?php if ($viewType === 'quarterly'): ?>
            <form method="POST" action="../Controller/attendanceReportController.php" class="row g-2 mb-3">
                <input type="hidden" name="type" value="quarterly">
                <div class="col-md-3">
                    <select name="quarter" class="form-select">
                        <option value="1" <?= $quarter == 1 ? 'selected' : '' ?>>Q1 (Jan–Mar)</option>
                        <option value="2" <?= $quarter == 2 ? 'selected' : '' ?>>Q2 (Apr–Jun)</option>
                        <option value="3" <?= $quarter == 3 ? 'selected' : '' ?>>Q3 (Jul–Sep)</option>
                        <option value="4" <?= $quarter == 4 ? 'selected' : '' ?>>Q4 (Oct–Dec)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="year" class="form-control" value="<?= $year ?>" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">View</button>
                </div>
            </form>
            <h5 class="text-secondary mb-3">Quarter
                <?= $quarter ?> -
                <?= $year ?>
            </h5>
        <?php endif; ?>

        <?php if ($viewType === 'yearly'): ?>
            <form method="POST" action="../Controller/attendanceReportController.php"
                class="d-flex align-items-center mb-3">
                <input type="hidden" name="type" value="yearly">
                <input type="number" name="year" class="form-control me-2" value="<?= $year ?>" required>
                <button class="btn btn-primary">View Report</button>
            </form>
            <h5 class="text-secondary mb-3">Year
                <?= $year ?>
            </h5>
        <?php endif; ?>

        <!-- Simplified Table -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee</th>
                            <th>Absent</th>
                            <th>Half Day</th>
                            <th>Full Day</th>
                            <th>OT Hours</th>
                            <th>1.5 Day</th>
                            <th>2 Day</th>
                            <th>Hourly</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r->name) ?></td>
                                <td><?= $r->absent ?></td>
                                <td><?= $r->half_days ?></td>
                                <td><?= $r->full_days ?></td>
                                <td><?= number_format($r->ot_hours, 2) ?></td>
                                <td><?= $r->one_point_five_days ?></td>
                                <td><?= $r->two_days ?></td>
                                <td><?= number_format($r->hourly_hours, 2) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#info<?= $r->emp_id ?>">
                                        Info
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>


                    <?php foreach ($reports as $r): ?>
                        <div class="modal fade" id="info<?= $r->emp_id ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            <?= htmlspecialchars($r->name) ?> – Attendance
                                        </h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Absent:</strong> <?= $r->absent ?></p>
                                        <p><strong>Half Day:</strong> <?= $r->half_days ?></p>
                                        <p><strong>Full Day:</strong> <?= $r->full_days ?></p>
                                        <p><strong>OT Hours:</strong> <?= number_format($r->ot_hours, 2) ?></p>
                                        <p><strong>1.5 Day:</strong> <?= $r->one_point_five_days ?></p>
                                        <p><strong>2 Day:</strong> <?= $r->two_days ?></p>
                                        <p><strong>Hourly:</strong> <?= number_format($r->hourly_hours, 2) ?></p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>