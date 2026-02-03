<?php
include('session.php');
include('employeeNavigation.php');
require_once("../DB Operations/attendanceOps.php");
require_once("../DB Operations/employeeOps.php");
require_once("../Controller/attendanceController.php");

$editAtt = null;
if (isset($_GET['edit'])) {
  $editAtt = DBAttendance::readById($_GET['edit']);
}
$employees = DBEmployee::readAll();
$attendanceList = DBAttendance::readAll();

// ✅ PAGINATION SETTINGS
$recordsPerPage = 10;
$totalRecords = count($attendanceList);
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$startIndex = ($currentPage - 1) * $recordsPerPage;

// ✅ Slice the array for current page
$attendanceListPage = array_slice($attendanceList, $startIndex, $recordsPerPage);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Attendance Management</title>
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

    .form-section {
      background: #fff;
      border-radius: 8px;
      padding: 25px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      position: relative;
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      border: none;
      background: none;
      font-size: 1.5rem;
      color: #888;
      cursor: pointer;
    }

    .pagination a,
    .pagination span {
      color: #007bff;
    }

    .pagination .active span {
      background-color: #007bff;
      color: #fff;
      border-color: #007bff;
    }
  </style>
</head>

<body>

  <div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-semibold text-primary">🕒 Attendance Management</h2>
      <button class="btn btn-success btn-sm" data-bs-toggle="collapse" data-bs-target="#addAttendanceForm">
        ➕ Add Attendance
      </button>
    </div>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">✅ Attendance added successfully!</div>
    <?php elseif (isset($_GET['updated'])): ?>
      <div class="alert alert-success">✅ Attendance updated successfully!</div>
    <?php elseif (isset($_GET['deleted'])): ?>
      <div class="alert alert-danger">❌ Attendance deleted!</div>
    <?php endif; ?>
    <?php if (isset($_GET['duplicate'])): ?>
      <div class="alert alert-warning">⚠️ Attendance already exists for this employee on that date!</div>
    <?php endif; ?>

    <div class="collapse <?php echo $editAtt ? 'show' : ''; ?>" id="addAttendanceForm">
      <div class="form-section mb-4">
        <button type="button" class="close-btn" data-bs-toggle="collapse"
          data-bs-target="#addAttendanceForm">&times;</button>
        <h4><?php echo $editAtt ? "✏️ Edit Attendance" : "➕ Add Attendance"; ?></h4>

        <form action="../Controller/attendanceController.php" method="POST" id="attendanceForm">
          <input type="hidden" name="action" value="<?php echo $editAtt ? 'update' : 'add'; ?>">
          <?php if ($editAtt): ?><input type="hidden" name="id" value="<?php echo $editAtt['id']; ?>"><?php endif; ?>

          <!-- Row 1: Employee & Date -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Employee</label>
              <select name="emp_id" id="empSelect" class="form-select" required>
                <option value="">Select Employee</option>
                <?php foreach ($employees as $emp): ?>
                  <option value="<?php echo $emp['id']; ?>" data-hours="<?php echo $emp['working_hours']; ?>"
                    data-hourly="<?php echo (!empty($emp['hourly_rate']) && $emp['hourly_rate'] > 0) ? 1 : 0; ?>">
                    <?php echo htmlspecialchars($emp['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Date</label>
              <input type="date" name="date" class="form-control"
                value="<?php echo $editAtt['date'] ?? date('Y-m-d'); ?>" required>
            </div>
          </div>

          <!-- Row 2: Status + In/Out -->
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label class="form-label">Status</label>
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
              <label class="form-label">In Time</label>
              <input type="time" name="in_time" class="form-control" value="<?php echo $editAtt['in_time'] ?? ''; ?>">
            </div>

            <div class="col-md-4 inout-group">
              <label class="form-label">Out Time</label>
              <input type="time" name="out_time" class="form-control" value="<?php echo $editAtt['out_time'] ?? ''; ?>">
            </div>
          </div>

          <!-- Row 3: Remarks -->
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" class="form-control" rows="2"><?php echo $editAtt['remarks'] ?? ''; ?></textarea>
            </div>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary px-4"><?php echo $editAtt ? 'Update' : 'Add'; ?></button>
            <?php if ($editAtt): ?><a href="attendance.php" class="btn btn-secondary ms-2">Cancel</a><?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <!-- Attendance List -->
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📋 Attendance List</h5>
        <span class="badge bg-light text-dark"><?php echo $totalRecords; ?> Total</span>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Date</th>
              <th>Employee</th>
              <th>Status</th>
              <th>In</th>
              <th>Out</th>
              <th>Worked (hrs)</th>
              <th>OT (hrs)</th>
              <th>OT Pay (₹)</th>
              <th>Remarks</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $serial = $startIndex + 1;
            foreach ($attendanceListPage as $att): ?>
              <tr>
                <td><?php echo $serial++; ?></td>
                <td><?php echo $att['date']; ?></td>
                <td><?php echo htmlspecialchars($att['emp_name']); ?></td>
                <td><?php echo htmlspecialchars($att['status']); ?></td>
                <td><?php echo $att['in_time'] ?: '-'; ?></td>
                <td><?php echo $att['out_time'] ?: '-'; ?></td>
                <td><?php echo $att['worked_hours']; ?></td>
                <td><?php echo $att['ot_hours']; ?></td>
                <td>₹<?php echo number_format($att['ot_pay'], 2); ?></td>
                <td><?php echo nl2br(htmlspecialchars($att['remarks'])); ?></td>
                <td class="text-center">
                  <a href="attendance.php?edit=<?php echo $att['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                  <a href="../Controller/attendanceController.php?delete=<?php echo $att['id']; ?>"
                    class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Delete this attendance record?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($attendanceListPage)): ?>
              <tr>
                <td colspan="11" class="text-center text-muted">No attendance records found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ✅ Pagination Section -->
    <?php if ($totalPages > 1): ?>
      <nav aria-label="Attendance Pagination" class="mt-4">
        <ul class="pagination justify-content-center">
          <!-- Previous -->
          <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" tabindex="-1">Previous</a>
          </li>

          <!-- Page Numbers -->
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $currentPage == $i ? 'active' : ''; ?>">
              <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>

          <!-- Next -->
          <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
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

        // Remove existing Hourly option if any
        [...statusField.options].forEach(opt => {
          if (opt.value === 'Hourly') opt.remove();
        });

        // Add Hourly only for hourly employees
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
  </script>



</body>

</html>