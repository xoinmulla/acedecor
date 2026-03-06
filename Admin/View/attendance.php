<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('employeeNavigation.php');
require_once("../DB Operations/attendanceOps.php");
require_once("../DB Operations/employeeOps.php");
require_once("../Controller/attendanceController.php");

$editAtt = null;
if (isset($_GET['edit'])) {
  $editAtt = DBAttendance::readById($_GET['edit']);
}
$employees = DBEmployee::readAll();
$attendanceList = DBAttendance::readAll();   // fetch all records

// ========== NEW: SEARCH, SORT, LIMIT ==========
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';   // default sort by date
$order = isset($_GET['order']) ? $_GET['order'] : 'desc'; // default newest first
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int) $_GET['limit'] : 10;
$validLimits = [10, 25, 50, 100];
if (!in_array($limit, $validLimits))
  $limit = 10;

// --- apply search filter (case‑insensitive, multiple fields) ---
if ($search !== '') {
  $attendanceList = array_filter($attendanceList, function ($att) use ($search) {
    $search = strtolower($search);
    return strpos(strtolower($att['emp_name']), $search) !== false
      || strpos(strtolower($att['status']), $search) !== false
      || strpos($att['date'], $search) !== false
      || strpos(strtolower($att['remarks'] ?? ''), $search) !== false;
  });
}

// --- sorting ---
usort($attendanceList, function ($a, $b) use ($sort, $order) {
  // determine values to compare
  $valA = $a[$sort] ?? '';
  $valB = $b[$sort] ?? '';

  // special handling for numeric fields
  if (in_array($sort, ['worked_hours', 'ot_hours', 'ot_pay'])) {
    $valA = (float) $valA;
    $valB = (float) $valB;
  } elseif ($sort === 'date') {
    $valA = strtotime($valA);
    $valB = strtotime($valB);
  } else {
    $valA = strtolower((string) $valA);
    $valB = strtolower((string) $valB);
  }

  if ($valA == $valB)
    return 0;
  $comparison = ($valA < $valB) ? -1 : 1;
  return ($order === 'asc') ? $comparison : -$comparison;
});

// ✅ PAGINATION SETTINGS (using filtered & sorted list)
$totalRecords = count($attendanceList);
$totalPages = ceil($totalRecords / $limit);
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$startIndex = ($currentPage - 1) * $limit;

// Slice for current page
$attendanceListPage = array_slice($attendanceList, $startIndex, $limit);

if(!hasActionPermission('employees','attendance')){
    header("Location: noaccess.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance · Workflow</title>
  <!-- Bootstrap 5 & Poppins -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* ----- your existing styles (kept exactly) ----- */
    :root {
      --glass-bg: rgba(255, 255, 255, 0.85);
      --glass-border: rgba(255, 255, 255, 0.5);
      --soft-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15);
      --card-radius: 24px;
      --primary-gradient: linear-gradient(145deg, #4361ee, #7209b7);
      --secondary-gradient: linear-gradient(145deg, #f8f9fa, #e9ecef);
      --table-header-bg: #212529;
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

    .glass-panel {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      border-radius: var(--card-radius);
      box-shadow: var(--soft-shadow);
    }

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

    .btn-gradient {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.75rem 2rem;
      border-radius: 60px;
      font-weight: 500;
      letter-spacing: 0.3px;
      box-shadow: 0 8px 18px -6px #4361ee;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-gradient:hover {
      transform: scale(1.02);
      box-shadow: 0 12px 24px -8px #3a56d4;
      color: white;
    }

    .close-btn {
      background: none;
      border: none;
      font-size: 2rem;
      line-height: 1;
      color: #6c757d;
      transition: 0.2s;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 40px;
    }

    .close-btn:hover {
      background: rgba(0, 0, 0, 0.05);
      color: #dc3545;
    }

    .form-section {
      background: white;
      border-radius: 32px;
      padding: 2rem 2.5rem;
      box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.7);
      position: relative;
      margin-bottom: 2rem;
    }

    .form-section h4 {
      font-weight: 600;
      color: #212529;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .form-section h4 i {
      font-size: 2rem;
      color: #4361ee;
    }

    .form-label {
      font-weight: 500;
      color: #344767;
      margin-bottom: 0.3rem;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-control,
    .form-select {
      border-radius: 18px;
      padding: 0.65rem 1.2rem;
      border: 1.5px solid #e9ecef;
      background: #f8fafc;
      transition: 0.2s;
      font-weight: 400;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #4361ee;
      box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
      background: white;
    }

    textarea.form-control {
      border-radius: 20px;
    }

    .inout-group {
      transition: all 0.2s;
    }

    .btn-sm-outline {
      border-radius: 40px;
      padding: 0.25rem 1rem;
      font-size: 0.8rem;
      font-weight: 500;
      border-width: 2px;
      transition: 0.15s;
    }

    .btn-outline-primary {
      border-radius: 40px;
      border-width: 2px;
    }

    .btn-outline-danger {
      border-radius: 40px;
      border-width: 2px;
    }

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
      padding: 1rem 1rem;
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
      padding: 1rem 1rem;
      vertical-align: middle;
      color: #1e293b;
      font-weight: 400;
      border-bottom: 1px solid rgba(0, 0, 0, 0.03);
      background: white;
    }

    .table tbody tr:hover td {
      background: #f8fcff;
    }

    .status-badge {
      display: inline-block;
      padding: 0.2rem 1rem;
      border-radius: 40px;
      font-weight: 500;
      font-size: 0.8rem;
    }

    .status-present {
      background: #d1fae5;
      color: #065f46;
    }

    .status-absent {
      background: #fee2e2;
      color: #991b1b;
    }

    .status-halfday {
      background: #fef3c7;
      color: #92400e;
    }

    .status-weeklyoff {
      background: #e0e7ff;
      color: #3730a3;
    }

    .status-hourly {
      background: #ffe4e6;
      color: #9d174d;
    }

    .status-2days {
      background: #dbeafe;
      color: #1e40af;
    }

    .status-1-5day {
      background: #ede9fe;
      color: #5b21b6;
    }

    .mono-number {
      font-family: 'Inter', monospace;
      font-weight: 500;
    }

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

    .page-item.disabled .page-link {
      background: #f1f3f5;
      color: #adb5bd;
    }

    /* new controls bar */
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
    }

    @media (max-width: 768px) {
      .container-fluid {
        padding: 0 1rem;
      }

      .page-header h2 {
        font-size: 1.8rem;
      }

      .form-section {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>

  <div class="container-fluid py-2">

    <!-- ========== HEADER ========== -->
    <div class="page-header">
      <h2> Attendance </h2>
      <button class="btn btn-gradient" data-bs-toggle="collapse" data-bs-target="#addAttendanceForm">
        <i class="fas fa-plus-circle"></i> New record
      </button>
    </div>

    <!-- ========== ALERTS ========== -->
    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show glass-panel" role="alert"
        style="border-left: 6px solid #198754;">
        <i class="fas fa-check-circle me-2"></i>✅ Attendance added successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php elseif (isset($_GET['updated'])): ?>
      <div class="alert alert-success alert-dismissible fade show glass-panel" style="border-left: 6px solid #198754;">
        <i class="fas fa-check-circle me-2"></i>✅ Attendance updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php elseif (isset($_GET['deleted'])): ?>
      <div class="alert alert-danger alert-dismissible fade show glass-panel" style="border-left: 6px solid #dc3545;">
        <i class="fas fa-trash-alt me-2"></i>❌ Attendance deleted!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if (isset($_GET['duplicate'])): ?>
      <div class="alert alert-warning alert-dismissible fade show glass-panel" style="border-left: 6px solid #ffc107;">
        <i class="fas fa-exclamation-triangle me-2"></i>⚠️ Attendance already exists for this employee on that date!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- ========== ADD/EDIT FORM (unchanged) ========== -->
    <div class="collapse <?php echo $editAtt ? 'show' : ''; ?>" id="addAttendanceForm">
      <div class="form-section">
        <button type="button" class="close-btn position-absolute top-0 end-0 mt-3 me-3" data-bs-toggle="collapse"
          data-bs-target="#addAttendanceForm">
          <i class="fas fa-times"></i>
        </button>
        <h4><?php if ($editAtt): ?><i class="fas fa-pen-alt"></i> Edit attendance<?php else: ?><i
              class="fas fa-plus-circle"></i> Add attendance<?php endif; ?></h4>
        <form action="../Controller/attendanceController.php" method="POST" id="attendanceForm">
          <input type="hidden" name="action" value="<?php echo $editAtt ? 'update' : 'add'; ?>">
          <?php if ($editAtt): ?><input type="hidden" name="id" value="<?php echo $editAtt['id']; ?>"><?php endif; ?>
          <div class="row g-4 mb-4">
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-user-tie me-1"></i> Employee</label>
              <select name="emp_id" id="empSelect" class="form-select" required>
                <option value="">— Select employee —</option>
                <?php foreach ($employees as $emp): ?>
                  <?php $selected = ($editAtt && $editAtt['emp_id'] == $emp['id']) ? 'selected' : ''; ?>
                  <option value="<?php echo $emp['id']; ?>" data-hours="<?php echo $emp['working_hours']; ?>"
                    data-hourly="<?php echo (!empty($emp['hourly_rate']) && $emp['hourly_rate'] > 0) ? 1 : 0; ?>">
                    <?php echo htmlspecialchars($emp['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-calendar-alt me-1"></i> Date</label>
              <input type="date" name="date" class="form-control"
                value="<?php echo $editAtt['date'] ?? date('Y-m-d'); ?>" required>
            </div>
          </div>
          <div class="row g-4 mb-4">
            <div class="col-md-4">
              <label class="form-label"><i class="fas fa-tag me-1"></i> Status</label>
              <select name="status" id="statusField" class="form-select" required>
                <?php
                $statuses = ['Present', '2 Days', '1.5 Day', 'Half-day', 'Weekly Off', 'Absent'];
                foreach ($statuses as $s) {
                  $sel = (isset($editAtt['status']) && $editAtt['status'] == $s) ? 'selected' : '';
                  echo "<option $sel>$s</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-4 inout-group">
              <label class="form-label"><i class="fas fa-sign-in-alt me-1"></i> In time</label>
              <input type="time" name="in_time" class="form-control" value="<?php echo $editAtt['in_time'] ?? ''; ?>">
            </div>
            <div class="col-md-4 inout-group">
              <label class="form-label"><i class="fas fa-sign-out-alt me-1"></i> Out time</label>
              <input type="time" name="out_time" class="form-control" value="<?php echo $editAtt['out_time'] ?? ''; ?>">
            </div>
          </div>
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label"><i class="fas fa-comment me-1"></i> Remarks (optional)</label>
              <textarea name="remarks" class="form-control" rows="2"
                placeholder="e.g. late arrival, remote..."><?php echo $editAtt['remarks'] ?? ''; ?></textarea>
            </div>
          </div>
          <div class="mt-5 d-flex gap-3">
            <button type="submit" class="btn btn-gradient px-5 py-2">
              <i
                class="fas <?php echo $editAtt ? 'fa-pen' : 'fa-plus'; ?> me-2"></i><?php echo $editAtt ? 'Update' : 'Add'; ?>
              record
            </button>
            <?php if ($editAtt): ?>
              <a href="attendance.php" class="btn btn-outline-secondary rounded-pill px-4"><i
                  class="fas fa-times me-1"></i>Cancel</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

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
        <input type="text" id="searchInput" placeholder="Search by name, status, date..."
          value="<?= htmlspecialchars($search) ?>">
        <?php if ($search !== ''): ?>
          <a href="attendance.php?limit=<?= $limit ?>" class="btn btn-outline-secondary rounded-pill">Clear</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- ========== ATTENDANCE TABLE ========== -->
    <div class="table-card">
      <div class="table-header">
        <h5><i class="fas fa-list-ul"></i> Attendance records</h5>
        <span class="badge"><i class="far fa-file-alt me-1"></i> <?php echo $totalRecords; ?> total entries</span>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <?php
              // Helper to create sort links
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
              $extraParams = ['search' => $search, 'limit' => $limit];
              if ($currentPage > 1)
                $extraParams['page'] = $currentPage; // keep page if any
              ?>
              <th>#</th>
              <th><?= sortLink('date', 'Date', $sort, $order, $extraParams) ?></th>
              <th><?= sortLink('emp_name', 'Employee', $sort, $order, $extraParams) ?></th>
              <th><?= sortLink('status', 'Status', $sort, $order, $extraParams) ?></th>
              <th><?= sortLink('in_time', 'In', $sort, $order, $extraParams) ?></th>
              <th><?= sortLink('out_time', 'Out', $sort, $order, $extraParams) ?></th>
              <th><?= sortLink('worked_hours', 'Worked', $sort, $order, $extraParams) ?></th>
              <th><?= sortLink('ot_hours', 'OT', $sort, $order, $extraParams) ?></th>
              <th><?= sortLink('ot_pay', 'OT pay', $sort, $order, $extraParams) ?></th>
              <th>Remarks</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $serial = $startIndex + 1;
            foreach ($attendanceListPage as $att): ?>
              <tr>
                <td><span class="fw-semibold"><?php echo $serial++; ?></span></td>
                <td><span class="badge bg-light text-dark p-2"><?php echo $att['date']; ?></span></td>
                <td class="fw-semibold"><?php echo htmlspecialchars($att['emp_name']); ?></td>
                <td>
                  <?php
                  $statusClass = '';
                  $status = $att['status'];
                  if ($status == 'Present')
                    $statusClass = 'status-present';
                  elseif ($status == 'Absent')
                    $statusClass = 'status-absent';
                  elseif ($status == 'Half-day')
                    $statusClass = 'status-halfday';
                  elseif ($status == 'Weekly Off')
                    $statusClass = 'status-weeklyoff';
                  elseif ($status == 'Hourly')
                    $statusClass = 'status-hourly';
                  elseif ($status == '2 Days')
                    $statusClass = 'status-2days';
                  elseif ($status == '1.5 Day')
                    $statusClass = 'status-1-5day';
                  ?>
                  <span class="status-badge <?php echo $statusClass; ?>"><?php echo $status; ?></span>
                </td>
                <td><?php echo $att['in_time'] ?: '<span class="text-muted">—</span>'; ?></td>
                <td><?php echo $att['out_time'] ?: '<span class="text-muted">—</span>'; ?></td>
                <td class="mono-number"><?php echo $att['worked_hours']; ?></td>
                <td class="mono-number"><?php echo $att['ot_hours']; ?></td>
                <td class="mono-number">₹<?php echo number_format($att['ot_pay'], 2); ?></td>
                <td><span class="small text-secondary"><?php echo nl2br(htmlspecialchars($att['remarks'])); ?></span></td>
                <td class="text-center">
                  <a href="attendance.php?edit=<?php echo $att['id']; ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&order=<?= $order ?>"
                    class="btn btn-sm btn-outline-primary btn-sm-outline me-1">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="../Controller/attendanceController.php?delete=<?php echo $att['id']; ?>"
                    class="btn btn-sm btn-outline-danger btn-sm-outline"
                    onclick="return confirm('Delete this attendance record?')">
                    <i class="fas fa-trash"></i> Del
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($attendanceListPage)): ?>
              <tr>
                <td colspan="11" class="text-center text-muted py-5">
                  <i class="fas fa-inbox fa-3x mb-3" style="opacity:0.4;"></i><br>No attendance records found.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ========== PAGINATION ========== -->
    <?php if ($totalPages > 1): ?>
      <nav aria-label="Attendance pagination" class="mt-5">
        <ul class="pagination justify-content-center flex-wrap">
          <?php
          // Build query string for pagination links (preserve search, sort, limit)
          $queryParams = [
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'limit' => $limit
          ];
          $baseUrl = '?' . http_build_query($queryParams) . '&page=';
          ?>
          <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?= $baseUrl . ($currentPage - 1) ?>" tabindex="-1">
              <i class="fas fa-chevron-left me-1"></i> Prev
            </a>
          </li>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $currentPage == $i ? 'active' : ''; ?>">
              <a class="page-link" href="<?= $baseUrl . $i ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?= $baseUrl . ($currentPage + 1) ?>">
              Next <i class="fas fa-chevron-right ms-1"></i>
            </a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>

  </div>

  <!-- JavaScript for controls -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // original attendance form logic (unchanged)
      const statusField = document.getElementById('statusField');
      const empSelect = document.getElementById('empSelect');
      const inTimeField = document.querySelector('[name="in_time"]');
      const outTimeField = document.querySelector('[name="out_time"]');
      const inOutGroups = document.querySelectorAll('.inout-group');
      const DEFAULT_IN_TIME = "11:00";

      function addHours(time, hours) {
        const [h, m] = time.split(':').map(Number);
        const d = new Date();
        d.setHours(h, m, 0);
        d.setMinutes(d.getMinutes() + (hours * 60));
        return d.toTimeString().slice(0, 5);
      }

      function updateStatusOptions() {
        const selectedEmp = empSelect.options[empSelect.selectedIndex];
        if (!selectedEmp) return;
        const isHourly = selectedEmp.dataset.hourly === "1";
        [...statusField.options].forEach(opt => {
          if (opt.value === 'Hourly') opt.remove();
        });
        if (isHourly) {
          const opt = document.createElement("option");
          opt.value = "Hourly";
          opt.textContent = "Hourly";
          statusField.appendChild(opt);
        }
      }

      function toggleInOut() {
        const status = statusField.value;
        const selectedEmp = empSelect.options[empSelect.selectedIndex];
        if (!selectedEmp) return;
        const workingHours = parseFloat(selectedEmp.dataset.hours || 0);
        const isHourly = selectedEmp.dataset.hourly === "1";
        if (status === 'Present') {
          inOutGroups.forEach(div => div.style.display = 'block');
          inTimeField.value = DEFAULT_IN_TIME;
          outTimeField.value = addHours(DEFAULT_IN_TIME, workingHours);
        }
        else if (status === 'Hourly' && isHourly) {
          inOutGroups.forEach(div => div.style.display = 'block');
          inTimeField.value = '';
          outTimeField.value = '';
        }
        else {
          inOutGroups.forEach(div => div.style.display = 'none');
          inTimeField.value = '';
          outTimeField.value = '';
        }
      }

      empSelect.addEventListener('change', () => {
        updateStatusOptions();
        toggleInOut();
      });
      statusField.addEventListener('change', toggleInOut);
      updateStatusOptions();
      toggleInOut();
    });

    // new functions for limit and search
    function changeLimit(limit) {
      let url = new URL(window.location.href);
      url.searchParams.set('limit', limit);
      url.searchParams.delete('page'); // reset to first page
      window.location.href = url.toString();
    }

    // Auto search while typing (debounce)
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
      }, 500); // 500ms delay to avoid too many reloads
    });

    // trigger search on Enter key
    document.getElementById('searchInput').addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        applySearch();
      }
    });
  </script>

</body>

</html>