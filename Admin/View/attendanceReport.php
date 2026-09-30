<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('employeeNavigation.php');
require_once("../DB Operations/attendanceReportOps.php");

// ========== REPORT TYPE PARAMETERS (original) ==========
$viewType = $_GET['type'] ?? 'monthly';

$month = $_GET['month'] ?? date('Y-m');

$year = $_GET['year'] ?? date('Y');

$quarter = $_GET['quarter'] ?? 1;

$fromDate = $_GET['fromDate'] ?? date('Y-m-d', strtotime('monday this week'));

$toDate = $_GET['toDate'] ?? date('Y-m-d', strtotime('sunday this week'));

// Fetch reports based on type (original logic)
if ($viewType == "monthly") {

    $reports = DBAttendanceReport::getReport($month);

} elseif ($viewType == "weekly") {

    $reports = DBAttendanceReport::getWeeklyReport(
        $fromDate,
        $toDate
    );

} elseif ($viewType == "quarterly") {

    $reports = DBAttendanceReport::getQuarterlyReport(
        $year,
        $quarter
    );

} else {

    $reports = DBAttendanceReport::getYearlyReport($year);

}

// ========== NEW: SEARCH, SORT, LIMIT ==========
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name';        // default sort by name
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int) $_GET['limit'] : 10;
$validLimits = [10, 25, 50, 100];
if (!in_array($limit, $validLimits))
    $limit = 10;

// --- apply search filter (by employee name) ---
if ($search !== '') {
    $reports = array_filter($reports, function ($r) use ($search) {
        return stripos($r->name, $search) !== false;
    });
}

// --- sorting ---
usort($reports, function ($a, $b) use ($sort, $order) {
    // map sort column to object property
    $sortMap = [
        'name' => 'name',
        'absent' => 'absent',
        'half_days' => 'half_days',
        'full_days' => 'full_days',
        'ot_hours' => 'ot_hours',
        'one_point_five_days' => 'one_point_five_days',
        'two_days' => 'two_days',
        'hourly_only' => 'hourly_only'
    ];
    $prop = $sortMap[$sort] ?? 'name';

    $valA = $a->$prop ?? 0;
    $valB = $b->$prop ?? 0;

    // numeric comparison for most fields, string for name
    if ($prop === 'name') {
        $valA = strtolower($valA);
        $valB = strtolower($valB);
        if ($valA == $valB)
            return 0;
        $comparison = ($valA < $valB) ? -1 : 1;
    } else {
        // numeric
        $valA = (float) $valA;
        $valB = (float) $valB;
        if ($valA == $valB)
            return 0;
        $comparison = ($valA < $valB) ? -1 : 1;
    }
    return ($order === 'asc') ? $comparison : -$comparison;
});

// ✅ PAGINATION SETTINGS
$totalRecords = count($reports);
$totalPages = ceil($totalRecords / $limit);
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$startIndex = ($currentPage - 1) * $limit;
$reportsPage = array_slice($reports, $startIndex, $limit);

if (!hasActionPermission('employees', 'attendance_reports')) {
    header("Location: noaccess.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Reports Dashboard · Workflow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 & Poppins -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome 6 (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ----- DESIGN TOKENS (matching employee/attendance hubs) ----- */
        :root {
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.5);
            --soft-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15);
            --card-radius: 24px;
            --primary-gradient: linear-gradient(145deg, #4361ee, #7209b7);
        }

        body {
            background: #f4f7fc;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding-bottom: 2rem;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 30% 40%, rgba(67, 97, 238, 0.03) 0%, transparent 30%),
                radial-gradient(circle at 70% 80%, rgba(114, 9, 183, 0.03) 0%, transparent 40%);
            pointer-events: none;
            z-index: -1;
        }

        .container-fluid {
            max-width: 1600px;
            padding: 0 2rem;
        }

        /* ----- PAGE HEADER ----- */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 2rem 0 2rem 0;
        }

        .page-header h2 {
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.4rem;
            letter-spacing: -0.5px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .page-header h2 i {
            background: white;
            padding: 12px;
            border-radius: 50%;
            color: #4361ee;
            box-shadow: 0 10px 20px -5px rgba(67, 97, 238, 0.4);
            font-size: 1.8rem;
        }

        /* tabs styling (keep consistent with design) */
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 1.5rem;
            gap: 0.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 60px;
            padding: 0.6rem 1.8rem;
            font-weight: 500;
            color: #495057;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: 0.2s;
        }

        .nav-tabs .nav-link:hover {
            background: #e9ecef;
        }

        .nav-tabs .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 8px 14px -6px #4361ee;
        }

        /* filter forms – inline and subtle */
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
            background: white;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 1.5rem;
        }

        .filter-form .form-control,
        .filter-form .form-select {
            border-radius: 40px;
            border: 1px solid #e9ecef;
            background: #f8fafc;
            min-width: 160px;
        }

        .filter-form .btn-primary {
            border-radius: 40px;
            padding: 0.5rem 2rem;
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 8px 18px -6px #4361ee;
        }

        .filter-form .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 24px -8px #3a56d4;
        }

        /* controls bar (show entries + search) */
        .controls-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 1.5rem 0 1rem;
        }

        .entries-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .entries-control select {
            width: auto;
            display: inline-block;
            border-radius: 40px;
            padding: 0.3rem 1.5rem 0.3rem 1rem;
            background: white;
        }

        .search-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            padding: 0.2rem 0.2rem 0.2rem 1rem;
            border-radius: 60px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .search-control input {
            border: none;
            background: transparent;
            padding: 0.4rem 0;
            min-width: 240px;
        }

        .search-control input:focus {
            outline: none;
        }

        .search-control button {
            border-radius: 60px;
            padding: 0.4rem 1.5rem;
            background: var(--primary-gradient);
            border: none;
            color: white;
        }

        .search-control a {
            border-radius: 60px;
        }

        /* table card */
        .table-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -18px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            border: none;
            margin-top: 2rem;
        }

        .table-header {
            background: var(--primary-gradient);
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-header h5 {
            margin: 0;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .table-header .badge {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 100px;
            font-size: 0.9rem;
            backdrop-filter: blur(4px);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f2f5f9;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(0, 0, 0, 0.05);
            padding: 1rem;
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
        }

        .table thead th i {
            margin-left: 6px;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .table thead th:hover {
            background: #e9ecf3;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #1e293b;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            background: white;
        }

        .table tbody tr:hover td {
            background: #f8fcff;
        }

        /* modal design (matching employee hub) */
        .modal-content {
            border-radius: 32px !important;
            border: none;
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, #4361ee, #7209b7);
            color: white;
            padding: 2rem 1.5rem 1.5rem;
            text-align: center;
            position: relative;
        }

        .modal-profile-icon {
            font-size: 4rem;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .profile-header h4 {
            font-weight: 600;
            margin-top: 1rem;
        }

        .profile-body {
            padding: 2rem;
            background: white;
        }

        .info-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1.2rem;
            height: 100%;
            border: 1px solid #e9ecef;
            transition: 0.2s;
        }

        .info-card:hover {
            background: white;
            border-color: #4361ee;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.1);
        }

        .info-card strong {
            color: #4361ee;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 0.5rem;
        }

        .modal-footer {
            background: #f8fafc;
            border-top: 1px solid #e9ecef;
            padding: 1rem 2rem;
        }

        /* pagination */
        .pagination {
            gap: 6px;
        }

        .page-link {
            border-radius: 40px !important;
            border: none;
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: #344767;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin: 0 2px;
        }

        .page-item.active .page-link {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 8px 14px -6px #4361ee;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 1rem;
            }

            .page-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid py-2">

        <!-- ========== HEADER ========== -->
        <div class="page-header">
            <h2> Reports dashboard</h2>
            <!-- no extra button -->
        </div>

        <!-- ========== TABS ========== -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?= $viewType == 'weekly' ? 'active' : '' ?>"
                    href="?type=weekly&fromDate=<?= $fromDate ?>&toDate=<?= $toDate ?>">
                    Weekly
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $viewType === 'monthly' ? 'active' : '' ?>"
                    href="?type=monthly&month=<?= $month ?>&search=<?= urlencode($search) ?>&sort=<?= $sort ?>&order=<?= $order ?>&limit=<?= $limit ?>">Monthly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $viewType === 'quarterly' ? 'active' : '' ?>"
                    href="?type=quarterly&year=<?= $year ?>&quarter=<?= $quarter ?>&search=<?= urlencode($search) ?>&sort=<?= $sort ?>&order=<?= $order ?>&limit=<?= $limit ?>">Quarterly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $viewType === 'yearly' ? 'active' : '' ?>"
                    href="?type=yearly&year=<?= $year ?>&search=<?= urlencode($search) ?>&sort=<?= $sort ?>&order=<?= $order ?>&limit=<?= $limit ?>">Yearly</a>
            </li>

        </ul>

        <!-- ========== FILTER FORMS (preserve search/sort/limit) ========== -->
        <?php if ($viewType === 'monthly'): ?>
            <form method="POST" action="../Controller/attendanceReportController.php" class="filter-form">
                <input type="hidden" name="type" value="monthly">
                <input type="month" name="month" class="form-control" value="<?= $month ?>" required>
                <!-- carry over current search/sort/limit -->
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                <input type="hidden" name="sort" value="<?= $sort ?>">
                <input type="hidden" name="order" value="<?= $order ?>">
                <input type="hidden" name="limit" value="<?= $limit ?>">
                <button class="btn btn-primary">View Report</button>
            </form>
            <h5 class="text-secondary mb-3"><i class="far fa-calendar-alt me-2"></i>Report for
                <?= date('F Y', strtotime($month)) ?>
            </h5>
        <?php endif; ?>

        <?php if ($viewType === 'quarterly'): ?>
            <form method="POST" action="../Controller/attendanceReportController.php" class="filter-form">
                <input type="hidden" name="type" value="quarterly">
                <select name="quarter" class="form-select">
                    <option value="1" <?= $quarter == 1 ? 'selected' : '' ?>>Q1 (Jan–Mar)</option>
                    <option value="2" <?= $quarter == 2 ? 'selected' : '' ?>>Q2 (Apr–Jun)</option>
                    <option value="3" <?= $quarter == 3 ? 'selected' : '' ?>>Q3 (Jul–Sep)</option>
                    <option value="4" <?= $quarter == 4 ? 'selected' : '' ?>>Q4 (Oct–Dec)</option>
                </select>
                <input type="number" name="year" class="form-control" value="<?= $year ?>" required>
                <!-- carry over current search/sort/limit -->
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                <input type="hidden" name="sort" value="<?= $sort ?>">
                <input type="hidden" name="order" value="<?= $order ?>">
                <input type="hidden" name="limit" value="<?= $limit ?>">
                <button class="btn btn-primary">View</button>
            </form>
            <h5 class="text-secondary mb-3"><i class="far fa-calendar-alt me-2"></i>Quarter <?= $quarter ?> – <?= $year ?>
            </h5>
        <?php endif; ?>
        <?php if ($viewType == "weekly"): ?>

            <form method="POST" action="../Controller/attendanceReportController.php" class="filter-form">

                <input type="hidden" name="type" value="weekly">

                <input type="date" class="form-control" name="fromDate" value="<?= $fromDate ?>" required>

                <input type="date" class="form-control" name="toDate" value="<?= $toDate ?>" required>

                <button class="btn btn-primary">
                    View Report
                </button>

            </form>

            <h5 class="text-secondary mb-3">
                <i class="far fa-calendar-alt me-2"></i>

                Report From

                <?= date('d M Y', strtotime($fromDate)) ?>

                -

                <?= date('d M Y', strtotime($toDate)) ?>

            </h5>

        <?php endif; ?>
        <?php if ($viewType === 'yearly'): ?>
            <form method="POST" action="../Controller/attendanceReportController.php" class="filter-form">
                <input type="hidden" name="type" value="yearly">
                <input type="number" name="year" class="form-control" value="<?= $year ?>" required>
                <!-- carry over current search/sort/limit -->
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                <input type="hidden" name="sort" value="<?= $sort ?>">
                <input type="hidden" name="order" value="<?= $order ?>">
                <input type="hidden" name="limit" value="<?= $limit ?>">
                <button class="btn btn-primary">View Report</button>
            </form>
            <h5 class="text-secondary mb-3"><i class="far fa-calendar-alt me-2"></i>Year <?= $year ?></h5>
        <?php endif; ?>

        <!-- ========== CONTROLS: SHOW ENTRIES & SEARCH ========== -->
        <div class="controls-bar">
            <div class="entries-control">
                <span>Show</span>
                <select class="form-select" id="limitSelect" onchange="changeLimit(this.value)">
                    <?php foreach ([10, 25, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $limit == $opt ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
                <span>entries</span>
            </div>
            <div class="search-control">
                <i class="fas fa-search text-muted"></i>
                <input type="text" id="searchInput" placeholder="Search by employee name..."
                    value="<?= htmlspecialchars($search) ?>">
                <?php if ($search !== ''): ?>
                    <a href="?type=<?= $viewType ?>&month=<?= $month ?>&year=<?= $year ?>&quarter=<?= $quarter ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&order=<?= $order ?>&fromDate=<?= $fromDate ?>&toDate=<?= $toDate ?>"
                        class=" btn btn-outline-secondary rounded-pill">Clear</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- ========== REPORT TABLE ========== -->
        <div class="table-card">
            <div class="table-header">
                <h5><i class="fas fa-list-ul"></i> Attendance summary</h5>
                <span class="badge"><i class="far fa-file-alt me-1"></i> <?= $totalRecords ?> total</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <?php
                            // Helper for sort links (preserve all GET params)
                            function sortLink($column, $label, $currentSort, $currentOrder, $extraParams)
                            {
                                $newOrder = ($currentSort == $column && $currentOrder == 'asc') ? 'desc' : 'asc';
                                $icon = '';
                                if ($currentSort == $column) {
                                    $icon = $currentOrder == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>';
                                } else {
                                    $icon = '<i class="fas fa-sort text-muted"></i>';
                                }
                                $params = array_merge($extraParams, ['sort' => $column, 'order' => $newOrder]);
                                $query = http_build_query($params);
                                return "<a href=\"?$query\" style=\"color:inherit; text-decoration:none;\">$label $icon</a>";
                            }
                            $extraParams = [
                                'type' => $viewType,
                                'month' => $month,
                                'year' => $year,
                                'quarter' => $quarter,

                                'fromDate' => $fromDate,
                                'toDate' => $toDate,

                                'search' => $search,
                                'limit' => $limit
                            ];
                            if ($currentPage > 1)
                                $extraParams['page'] = $currentPage;
                            ?>
                            <th><?= sortLink('name', 'Employee', $sort, $order, $extraParams) ?></th>
                            <th><?= sortLink('absent', 'Absent', $sort, $order, $extraParams) ?></th>
                            <th><?= sortLink('half_days', 'Half Day', $sort, $order, $extraParams) ?></th>
                            <th><?= sortLink('full_days', 'Full Day', $sort, $order, $extraParams) ?></th>
                            <th><?= sortLink('ot_hours', 'OT Hours', $sort, $order, $extraParams) ?></th>
                            <th><?= sortLink('one_point_five_days', '1.5 Day', $sort, $order, $extraParams) ?></th>
                            <th><?= sortLink('two_days', '2 Day', $sort, $order, $extraParams) ?></th>
                            <th><?= sortLink('hourly_only', 'Hourly', $sort, $order, $extraParams) ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serial = $startIndex + 1; ?>
                        <?php foreach ($reportsPage as $r): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($r->name) ?></td>
                                <td><?= $r->absent ?></td>
                                <td><?= $r->half_days ?></td>
                                <td><?= $r->full_days ?></td>
                                <td><?= number_format($r->ot_hours, 2) ?></td>
                                <td><?= $r->one_point_five_days ?></td>
                                <td><?= $r->two_days ?></td>
                                <td><?= number_format($r->hourly_only ?? 0, 2) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary px-3" style="border-radius:40px;"
                                        data-bs-toggle="modal" data-bs-target="#info<?= $r->emp_id ?>">
                                        <i class="fas fa-info-circle"></i> Info
                                    </button>
                                </td>
                            </tr>

                            <!-- INFO MODAL (matching employee hub design) -->
                            <div class="modal fade" id="info<?= $r->emp_id ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="profile-header">
                                            <div class="modal-profile-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <h4 class="mt-3 mb-0"><?= htmlspecialchars($r->name) ?></h4>
                                            <p class="mb-0">Attendance details</p>
                                            <button type="button"
                                                class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="profile-body">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <div class="info-card"><strong><i class="fas fa-user-slash"></i>
                                                            Absent</strong><span><?= $r->absent ?></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card"><strong><i class="fas fa-clock"></i> Half
                                                            Day</strong><span><?= $r->half_days ?></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card"><strong><i class="fas fa-calendar-check"></i>
                                                            Full Day</strong><span><?= $r->full_days ?></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card"><strong><i class="fas fa-clock"></i> OT
                                                            Hours</strong><span><?= number_format($r->ot_hours, 2) ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card"><strong><i class="fas fa-calendar"></i> 1.5
                                                            Day</strong><span><?= $r->one_point_five_days ?></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card"><strong><i class="fas fa-calendar"></i> 2
                                                            Day</strong><span><?= $r->two_days ?></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-card"><strong><i class="fas fa-hourglass"></i>
                                                            Hourly</strong><span><?= number_format($r->hourly_only ?? 0, 2) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                                data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($reportsPage)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i><br>No records found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========== PAGINATION ========== -->
        <?php if ($totalPages >= 1): ?>
            <nav aria-label="Reports pagination" class="mt-5">
                <ul class="pagination justify-content-center flex-wrap">
                    <?php
                    $queryParams = [

                        'type' => $viewType,

                        'month' => $month,

                        'year' => $year,

                        'quarter' => $quarter,

                        'fromDate' => $fromDate,

                        'toDate' => $toDate,

                        'search' => $search,

                        'sort' => $sort,

                        'order' => $order,

                        'limit' => $limit

                    ];
                    $baseUrl = '?' . http_build_query($queryParams) . '&page=';
                    ?>
                    <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $baseUrl . ($currentPage - 1) ?>" tabindex="-1"><i
                                class="fas fa-chevron-left me-1"></i> Prev</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $currentPage == $i ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $baseUrl . $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $baseUrl . ($currentPage + 1) ?>">Next <i
                                class="fas fa-chevron-right ms-1"></i></a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // functions for limit and search
        function changeLimit(limit) {
            let url = new URL(window.location.href);
            url.searchParams.set('limit', limit);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        let searchTimer;
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                let search = searchInput.value.trim();
                let url = new URL(window.location.href);

                if (search === '') {
                    url.searchParams.delete('search');
                } else {
                    url.searchParams.set('search', search);
                }

                url.searchParams.delete('page'); // reset to first page
                window.location.href = url.toString();
            }, 500); // wait 500ms after typing stops
        });

        document.getElementById('searchInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') applySearch();
        });
    </script>
</body>

</html>