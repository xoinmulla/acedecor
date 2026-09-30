<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('employeeNavigation.php');
require_once("../DB Operations/employeeOps.php");
require_once("../Controller/employeeController.php");

$editEmp = null;
if (isset($_GET['edit'])) {
    $editEmp = DBEmployee::readById($_GET['edit']);
}

// fetch all employees
$allEmployees = DBEmployee::readAll();

// ========== NEW: SEARCH, SORT, LIMIT ==========
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort   = isset($_GET['sort']) ? $_GET['sort'] : 'name';      // default sort by name
$order  = isset($_GET['order']) ? $_GET['order'] : 'asc';      // default ascending
$limit  = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 10;
$validLimits = [10, 25, 50, 100];
if (!in_array($limit, $validLimits)) $limit = 2;

// --- apply search filter (case‑insensitive on multiple fields) ---
$employees = $allEmployees; // start with all
if ($search !== '') {
    $employees = array_filter($employees, function($emp) use ($search) {
        $search = strtolower($search);
        return strpos(strtolower($emp['name'] ?? ''), $search) !== false
            || strpos(strtolower($emp['designation'] ?? ''), $search) !== false
            || strpos(strtolower($emp['contact'] ?? ''), $search) !== false
            || strpos(strtolower($emp['email'] ?? ''), $search) !== false
            || strpos(strtolower($emp['address'] ?? ''), $search) !== false;
    });
}

// --- sorting ---
usort($employees, function($a, $b) use ($sort, $order) {
    $valA = $a[$sort] ?? '';
    $valB = $b[$sort] ?? '';
    
    // special handling for numeric fields (if any – none here, but keep generic)
    if ($sort === 'working_hours' || $sort === 'salary_amount') {
        $valA = (float)$valA;
        $valB = (float)$valB;
    } else {
        $valA = strtolower((string)$valA);
        $valB = strtolower((string)$valB);
    }
    
    if ($valA == $valB) return 0;
    $comparison = ($valA < $valB) ? -1 : 1;
    return ($order === 'asc') ? $comparison : -$comparison;
});

// ✅ PAGINATION SETTINGS (using filtered & sorted list)
$totalRecords = count($employees);
$totalPages = ceil($totalRecords / $limit);
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$startIndex = ($currentPage - 1) * $limit;

// Slice for current page
$employeesPage = array_slice($employees, $startIndex, $limit);

if(!hasActionPermission('employees','employee')){
    header("Location: noaccess.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Employee Hub · Workflow</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 & Poppins -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
      top: 0; left: 0; width: 100%; height: 100%;
      background-image: radial-gradient(circle at 30% 40%, rgba(67, 97, 238, 0.03) 0%, transparent 30%),
                        radial-gradient(circle at 70% 80%, rgba(114, 9, 183, 0.03) 0%, transparent 40%);
      pointer-events: none;
      z-index: -1;
    }

    .container-fluid { max-width: 1600px; padding: 0 2rem; }
    .glass-panel {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      border: 1px solid var(--glass-border);
      border-radius: var(--card-radius);
      box-shadow: var(--soft-shadow);
    }

    .page-header {
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 1rem; margin: 2rem 0;
    }
    .page-header h2 {
      font-weight: 700;
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-size: 2.4rem;
      display: inline-flex; align-items: center; gap: 10px;
    }
    .page-header h2 i {
      background: white; padding: 12px; border-radius: 50%;
      color: #4361ee; box-shadow: 0 10px 20px -5px rgba(67,97,238,0.4);
      font-size: 1.8rem;
    }

    .btn-gradient {
      background: var(--primary-gradient); color: white; border: none;
      padding: 0.75rem 2rem; border-radius: 60px; font-weight: 500;
      box-shadow: 0 8px 18px -6px #4361ee; transition: 0.2s;
      display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-gradient:hover {
      transform: scale(1.02); box-shadow: 0 12px 24px -8px #3a56d4; color: white;
    }

    .close-btn {
      background: none; border: none; font-size: 2rem; color: #6c757d;
      width: 40px; height: 40px; border-radius: 40px; display: flex;
      align-items: center; justify-content: center;
    }
    .close-btn:hover { background: rgba(0,0,0,0.05); color: #dc3545; }

    .form-section {
      background: white; border-radius: 32px; padding: 2rem 2.5rem;
      box-shadow: 0 20px 40px -12px rgba(0,0,0,0.2);
      border: 1px solid rgba(255,255,255,0.7); position: relative; margin-bottom: 2rem;
    }
    .form-section h3 {
      font-weight: 600; color: #212529; margin-bottom: 2rem;
      display: flex; align-items: center; gap: 0.5rem;
    }
    .form-section h3 i { font-size: 2rem; color: #4361ee; }

    .form-label {
      font-weight: 500; color: #344767; margin-bottom: 0.3rem;
      font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .form-control, .form-select {
      border-radius: 18px; padding: 0.65rem 1.2rem;
      border: 1.5px solid #e9ecef; background: #f8fafc; transition: 0.2s;
    }
    .form-control:focus, .form-select:focus {
      border-color: #4361ee; box-shadow: 0 0 0 4px rgba(67,97,238,0.15);
      background: white;
    }
    textarea.form-control { border-radius: 20px; }

    .avatar {
      width: 45px; height: 45px; border-radius: 50%; object-fit: cover;
      border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .table-card {
      background: white; border-radius: 20px;
      box-shadow: 0 25px 50px -18px rgba(0,0,0,0.25); overflow: hidden;
      border: none; margin-top: 2rem;
    }
    .table-header {
      background: var(--primary-gradient); padding: 1.2rem 2rem;
      display: flex; align-items: center; justify-content: space-between;
    }
    .table-header h5 {
      margin: 0; font-weight: 600; color: white;
      display: flex; align-items: center; gap: 0.8rem;
    }
    .table-header .badge {
      background: rgba(255,255,255,0.25); color: white; font-weight: 500;
      padding: 0.5rem 1.2rem; border-radius: 100px; font-size: 0.9rem;
      backdrop-filter: blur(4px);
    }

    .table { margin-bottom: 0; }
    .table thead th {
      background: #f2f5f9; color: #1e293b; font-weight: 600;
      font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;
      border-bottom: 2px solid rgba(0,0,0,0.05); padding: 1rem;
      cursor: pointer; user-select: none; white-space: nowrap;
    }
    .table thead th i { margin-left: 6px; font-size: 0.8rem; color: #6c757d; }
    .table thead th:hover { background: #e9ecf3; }
    .table tbody td {
      padding: 1rem; vertical-align: middle; color: #1e293b;
      border-bottom: 1px solid rgba(0,0,0,0.03); background: white;
    }
    .table tbody tr:hover td { background: #f8fcff; }

    .action-dropdown .dropdown-toggle {
      border-radius: 40px; padding: 0.4rem 1.2rem; font-weight: 500;
    }
    .dropdown-menu {
      border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      padding: 0.5rem;
    }
    .dropdown-item {
      border-radius: 40px; padding: 0.5rem 1rem;
      display: flex; align-items: center; gap: 8px;
    }
    .dropdown-item i { font-size: 1.1rem; width: 1.5rem; }

    .modal-content { border-radius: 32px !important; border: none; overflow: hidden; }
    .profile-header {
      background: linear-gradient(135deg, #4361ee, #7209b7); color: white;
      padding: 2rem 1.5rem 1.5rem; text-align: center; position: relative;
    }
    .modal-profile-img {
      width: 130px; height: 130px; border-radius: 50%; object-fit: cover;
      border: 4px solid rgba(255,255,255,0.3); box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .profile-header h4 { font-weight: 600; margin-top: 1rem; }
    .profile-body { padding: 2rem; background: white; }
    .info-card {
      background: #f8fafc; border-radius: 20px; padding: 1.2rem; height: 100%;
      border: 1px solid #e9ecef; transition: 0.2s;
    }
    .info-card:hover {
      background: white; border-color: #4361ee;
      box-shadow: 0 5px 15px rgba(67,97,238,0.1);
    }
    .info-card strong {
      color: #4361ee; font-size: 0.9rem; text-transform: uppercase;
      letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;
      margin-bottom: 0.5rem;
    }
    .modal-footer {
      background: #f8fafc; border-top: 1px solid #e9ecef; padding: 1rem 2rem;
    }

    .alert {
      border-radius: 60px; border-left-width: 6px; border: none;
      box-shadow: var(--soft-shadow); backdrop-filter: blur(4px);
    }

    /* new controls bar */
    .controls-bar {
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 1rem; margin: 1.5rem 0 1rem;
    }
    .entries-control {
      display: flex; align-items: center; gap: 0.5rem;
    }
    .entries-control select {
      width: auto; display: inline-block; border-radius: 40px;
      padding: 0.3rem 1.5rem 0.3rem 1rem; background: white;
    }
    .search-control {
      display: flex; align-items: center; gap: 0.5rem;
      background: white; padding: 0.2rem 0.2rem 0.2rem 1rem;
      border-radius: 60px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .search-control input {
      border: none; background: transparent; padding: 0.4rem 0;
      min-width: 240px;
    }
    .search-control input:focus { outline: none; }
    .search-control button { border-radius: 60px; padding: 0.4rem 1.5rem; }

    @media (max-width: 768px) {
      .container-fluid { padding: 0 1rem; }
      .page-header h2 { font-size: 1.8rem; }
      .form-section { padding: 1.5rem; }
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
  transition: 0.2s;
}

.page-item.active .page-link {
  background: linear-gradient(145deg, #4361ee, #7209b7);
  color: white;
  box-shadow: 0 8px 14px -6px #4361ee;
}

.page-item.disabled .page-link {
  background: #f1f3f5;
  color: #adb5bd;
  box-shadow: none;
}

.page-link:hover {
  background: #e9ecf3;
  transform: translateY(-2px);
}
  </style>
</head>
<body>

<div class="container-fluid py-2">

  <!-- ========== HEADER ========== -->
  <div class="page-header">
    <h2></i> Employee </h2>
    <button class="btn btn-gradient" type="button" id="addEmployeeBtn">
      <i class="fas fa-plus-circle"></i> New employee
    </button>
  </div>

  <!-- ========== ALERTS ========== -->
  <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show glass-panel" role="alert" style="border-left: 6px solid #198754;">
      <i class="fas fa-check-circle me-2"></i>✅ Employee added successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif(isset($_GET['updated'])): ?>
    <div class="alert alert-success alert-dismissible fade show glass-panel" style="border-left: 6px solid #198754;">
      <i class="fas fa-check-circle me-2"></i>✅ Employee updated successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger alert-dismissible fade show glass-panel" style="border-left: 6px solid #dc3545;">
      <i class="fas fa-trash-alt me-2"></i>❌ Employee deleted successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif(isset($_GET['error']) && $_GET['error']=='due_exists'): ?>
    <div class="alert alert-warning alert-dismissible fade show glass-panel" id="dueAlert" style="border-left: 6px solid #ffc107;">
      <i class="fas fa-exclamation-triangle me-2"></i>⚠️ Cannot delete employee — ₹<?= number_format($_GET['amount'] ?? 0, 2) ?> due pending.
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- ========== ADD/EDIT FORM ========== -->
  <div class="collapse <?php echo $editEmp ? 'show' : ''; ?>" id="addEmployeeForm">
    <div class="form-section">
      <button type="button" class="close-btn position-absolute top-0 end-0 mt-3 me-3" data-bs-toggle="collapse" data-bs-target="#addEmployeeForm">
        <i class="fas fa-times"></i>
      </button>
      <h3>
        <?php if ($editEmp): ?><i class="fas fa-pen-alt"></i> Edit employee<?php else: ?><i class="fas fa-user-plus"></i> Add employee<?php endif; ?>
      </h3>

      <!-- original form (unchanged) -->
      <form action="../Controller/employeeController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo $editEmp ? 'update' : 'add'; ?>">
        <?php if($editEmp): ?>
          <input type="hidden" name="id" value="<?php echo $editEmp['id']; ?>">
          <input type="hidden" name="old_photo" value="<?php echo $editEmp['photo']; ?>">
        <?php endif; ?>

        <div class="row g-4">
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-user me-1"></i> Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $editEmp['name'] ?? ''; ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-briefcase me-1"></i> Designation</label>
            <input type="text" name="designation" class="form-control" value="<?php echo $editEmp['designation'] ?? ''; ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-phone me-1"></i> Contact</label>
            <input type="text" name="contact" class="form-control" value="<?php echo $editEmp['contact'] ?? ''; ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-envelope me-1"></i> Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $editEmp['email'] ?? ''; ?>">
          </div>
          <div class="col-12">
            <label class="form-label"><i class="fas fa-map-pin me-1"></i> Address</label>
            <textarea name="address" class="form-control" rows="2" placeholder="Enter full address"><?php echo $editEmp['address'] ?? ''; ?></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-calendar-alt me-1"></i> Date of Joining</label>
            <input type="date" name="doj" class="form-control" value="<?php echo $editEmp['doj'] ?? ''; ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-umbrella-beach me-1"></i> Weekly Off Day</label>
            <select name="weekly_off_day" class="form-select">
              <?php
              $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
              foreach ($days as $day) {
                  $selected = (isset($editEmp['weekly_off_day']) && $editEmp['weekly_off_day'] == $day) ? 'selected' : '';
                  echo "<option value='$day' $selected>$day</option>";
              }
              ?>
            </select>
          </div>

          <!-- salary row -->
          <div class="row g-3 mt-0">
            <div class="col-md-3">
              <label class="form-label"><i class="fas fa-clock me-1"></i> Working Hours</label>
              <input type="number" name="working_hours" class="form-control" step="0.5" value="<?php echo $editEmp['working_hours'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
              <label class="form-label"><i class="fas fa-coins me-1"></i> Salary Type</label>
              <select name="salary_type" class="form-select">
                <option value="Daily"   <?php echo (isset($editEmp['salary_type']) && $editEmp['salary_type']=='Daily')?'selected':''; ?>>Daily</option>
                <option value="Weekly"  <?php echo (isset($editEmp['salary_type']) && $editEmp['salary_type']=='Weekly')?'selected':''; ?>>Weekly</option>
                <option value="Monthly" <?php echo (isset($editEmp['salary_type']) && $editEmp['salary_type']=='Monthly')?'selected':''; ?>>Monthly</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label"><i class="fas fa-rupee-sign me-1"></i> Salary Amount</label>
              <input type="number" name="salary_amount" class="form-control" step="0.01" value="<?php echo $editEmp['salary_amount'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
              <div class="form-check mb-1">
                <input class="form-check-input" type="checkbox" id="is_hourly" name="is_hourly"
                       <?php echo (!empty($editEmp['hourly_rate'])) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_hourly">Hourly employee</label>
              </div>
              <input type="number" name="hourly_rate" id="hourly_rate" class="form-control"
                     step="0.01" placeholder="₹ per hour"
                     value="<?php echo $editEmp['hourly_rate'] ?? ''; ?>"
                     <?php echo (empty($editEmp['hourly_rate'])) ? 'disabled' : ''; ?>>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-camera me-1"></i> Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            <?php if(!empty($editEmp['photo'])): ?>
              <div class="mt-2">
                <img src="../<?php echo $editEmp['photo']; ?>" class="avatar" style="width:60px;height:60px;">
              </div>
            <?php endif; ?>
          </div>

          <div class="col-12">
            <label class="form-label"><i class="fas fa-sticky-note me-1"></i> Notes</label>
            <textarea name="notes" class="form-control" rows="3"><?php echo $editEmp['notes'] ?? ''; ?></textarea>
          </div>
        </div>

        <div class="mt-4 d-flex gap-3">
          <button type="submit" class="btn btn-gradient px-5 py-2">
            <i class="fas <?php echo $editEmp ? 'fa-pen' : 'fa-plus'; ?> me-2"></i><?php echo $editEmp ? 'Update' : 'Add'; ?> employee
          </button>
          <?php if($editEmp): ?>
            <a href="employee.php" class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-times me-1"></i>Cancel</a>
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
        <?php foreach ([10,25,50,100] as $opt): ?>
          <option value="<?= $opt ?>" <?= $limit == $opt ? 'selected' : '' ?>><?= $opt ?></option>
        <?php endforeach; ?>
      </select>
      <span>entries</span>
    </div>
    <div class="search-control">
      <i class="fas fa-search text-muted"></i>
      <input type="text" id="searchInput" placeholder="Search name, designation, contact..." value="<?= htmlspecialchars($search) ?>">
      <?php if ($search !== ''): ?>
        <a href="employee.php?limit=<?= $limit ?>" class="btn btn-outline-secondary rounded-pill">Clear</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- ========== EMPLOYEE LIST TABLE ========== -->
  <div class="table-card">
    <div class="table-header">
      <h5><i class="fas fa-list-ul"></i> Employee directory</h5>
      <span class="badge"><i class="far fa-user me-1"></i> <?php echo $totalRecords; ?> total</span>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Photo</th>
            <?php
            // helper for sort links
            function sortLink($column, $label, $currentSort, $currentOrder, $extraParams) {
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
            if ($currentPage > 1) $extraParams['page'] = $currentPage;
            ?>
            <th><?= sortLink('name', 'Name', $sort, $order, $extraParams) ?></th>
            <th><?= sortLink('designation', 'Designation', $sort, $order, $extraParams) ?></th>
            <th><?= sortLink('contact', 'Contact', $sort, $order, $extraParams) ?></th>
            <th><?= sortLink('email', 'Email', $sort, $order, $extraParams) ?></th>
            <th>Address</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($employeesPage)): $count = $startIndex + 1; foreach($employeesPage as $emp): ?>
          <tr>
            <td><span class="fw-semibold"><?= $count++; ?></span></td>
            <td>
              <?php if($emp['photo']): ?>
                <img src="../<?= htmlspecialchars($emp['photo']); ?>" class="avatar">
              <?php else: ?>
                <img src="https://via.placeholder.com/45" class="avatar">
              <?php endif; ?>
            </td>
            <td class="fw-semibold"><?= htmlspecialchars($emp['name']); ?></td>
            <td><?= htmlspecialchars($emp['designation']); ?></td>
            <td><?= htmlspecialchars($emp['contact']); ?></td>
            <td><?= htmlspecialchars($emp['email']); ?></td>
            <td><?= htmlspecialchars($emp['address']); ?></td>
            <td class="text-center action-dropdown">
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle px-3" type="button" data-bs-toggle="dropdown">
                   Actions
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" data-bs-toggle="modal" href="#infoModal<?= $emp['id']; ?>"><i class="bi bi-info-circle"></i> Info</a></li>
                  <li>
                    <?php
                      // preserve current parameters in edit link (except page, go to page 1 after edit)
                      $editParams = ['edit' => $emp['id'], 'search' => $search, 'limit' => $limit, 'sort' => $sort, 'order' => $order];
                      $editUrl = 'employee.php?' . http_build_query($editParams);
                    ?>
                    <a class="dropdown-item" href="<?= $editUrl ?>"><i class="bi bi-pencil-square"></i> Edit</a>
                  </li>
                  <li><a class="dropdown-item text-danger" href="../Controller/employeeController.php?delete=<?= $emp['id']; ?>" onclick="return confirm('Delete this employee?');"><i class="bi bi-trash"></i> Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- INFO MODAL (unchanged) -->
          <div class="modal fade" id="infoModal<?= $emp['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content border-0 shadow-lg">
                <div class="profile-header">
                  <?php if($emp['photo']): ?>
                    <img src="../<?= htmlspecialchars($emp['photo']); ?>" class="modal-profile-img">
                  <?php else: ?>
                    <img src="https://via.placeholder.com/130" class="modal-profile-img">
                  <?php endif; ?>
                  <h4 class="mt-3 mb-0"><?= htmlspecialchars($emp['name']); ?></h4>
                  <p class="mb-0"><?= htmlspecialchars($emp['designation']); ?></p>
                  <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="profile-body">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <div class="info-card"><strong><i class="bi bi-telephone-fill"></i> Contact</strong><span><?= htmlspecialchars($emp['contact']); ?></span></div>
                    </div>
                    <div class="col-md-6">
                      <div class="info-card"><strong><i class="bi bi-envelope-fill"></i> Email</strong><span><?= htmlspecialchars($emp['email']); ?></span></div>
                    </div>
                    <div class="col-md-6">
                      <div class="info-card"><strong><i class="bi bi-geo-alt-fill"></i> Address</strong><span><?= htmlspecialchars($emp['address']); ?></span></div>
                    </div>
                    <div class="col-md-6">
                      <div class="info-card"><strong><i class="bi bi-calendar-date-fill"></i> Date of Joining</strong><span><?= htmlspecialchars($emp['doj']); ?></span></div>
                    </div>
                    <div class="col-md-6">
                      <div class="info-card"><strong><i class="bi bi-calendar2-week"></i> Weekly Off</strong><span><?= htmlspecialchars($emp['weekly_off_day']); ?></span></div>
                    </div>
                    <div class="col-md-3">
                      <div class="info-card"><strong><i class="bi bi-cash-stack"></i> Salary</strong><span><?= htmlspecialchars($emp['salary_type']); ?> : ₹<?= htmlspecialchars($emp['salary_amount']); ?></span></div>
                    </div>
                    <div class="col-md-3">
                      <div class="info-card"><strong><i class="bi bi-briefcase-fill"></i> Hourly Rate</strong><span><?= htmlspecialchars($emp['hourly_rate']); ?></span></div>
                    </div>
                    <div class="col-12">
                      <div class="info-card"><strong><i class="bi bi-journal-text"></i> Notes</strong><span><?= nl2br(htmlspecialchars($emp['notes'])); ?></span></div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; else: ?>
            <tr><td colspan="8" class="text-center text-muted py-5"><i class="fas fa-user-slash fa-3x mb-3 opacity-50"></i><br>No employees found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ========== PAGINATION ========== -->
  <?php if ($totalPages >= 1): ?>
<nav aria-label="Employee pagination" class="mt-5">
  <ul class="pagination justify-content-center flex-wrap">

    <?php
    $queryParams = [
        'search' => $search,
        'sort'   => $sort,
        'order'  => $order,
        'limit'  => $limit
    ];
    $baseUrl = '?' . http_build_query($queryParams) . '&page=';
    ?>

    <!-- PREVIOUS -->
    <li class="page-item <?= $currentPage <= 1 ? 'disabled' : ''; ?>">
      <a class="page-link" href="<?= $baseUrl . ($currentPage - 1) ?>">
        <i class="fas fa-chevron-left me-1"></i> Prev
      </a>
    </li>

    <!-- PAGE NUMBERS -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?= $currentPage == $i ? 'active' : ''; ?>">
        <a class="page-link" href="<?= $baseUrl . $i ?>">
          <?= $i ?>
        </a>
      </li>
    <?php endfor; ?>

    <!-- NEXT -->
    <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : ''; ?>">
      <a class="page-link" href="<?= $baseUrl . ($currentPage + 1) ?>">
        Next <i class="fas fa-chevron-right ms-1"></i>
      </a>
    </li>

  </ul>
</nav>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Auto-hide alert after 5s
  const dueAlert = document.getElementById("dueAlert");
  if (dueAlert) {
    setTimeout(() => new bootstrap.Alert(dueAlert).close(), 5000);
  }

  // Add employee collapse toggle
  document.getElementById("addEmployeeBtn").addEventListener("click", function() {
    const form = document.getElementById("addEmployeeForm");
    const collapse = bootstrap.Collapse.getOrCreateInstance(form);
    collapse.toggle();
  });

  // Hourly checkbox logic
  const hourlyCheckbox = document.getElementById("is_hourly");
  const hourlyInput = document.getElementById("hourly_rate");
  if (hourlyCheckbox) {
    hourlyCheckbox.addEventListener("change", function () {
      hourlyInput.disabled = !this.checked;
      if (!this.checked) hourlyInput.value = "";
    });
  }
});

// new functions for limit and search
function changeLimit(limit) {
  let url = new URL(window.location.href);
  url.searchParams.set('limit', limit);
  url.searchParams.delete('page');
  window.location.href = url.toString();
}

// Auto search with 500ms debounce
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

document.getElementById('searchInput').addEventListener('keypress', function(e) {
  if (e.key === 'Enter') applySearch();
});
</script>
</body>
</html>