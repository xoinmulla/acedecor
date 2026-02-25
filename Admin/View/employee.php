<?php
include('session.php');
include('employeeNavigation.php');
require_once("../DB Operations/employeeOps.php");
require_once("../Controller/employeeController.php");

$editEmp = null;
if (isset($_GET['edit'])) {
    $editEmp = DBEmployee::readById($_GET['edit']);
}
$employees = DBEmployee::readAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Employee Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
 <style>
    body { background: #f8f9fa; font-family: 'Poppins', sans-serif;}
    .container-fluid { max-width: 1400px; }
    .table th, .table td { vertical-align: middle; }
    img.avatar {
      width: 45px; height: 45px; border-radius: 50%;
      object-fit: cover; border: 1px solid #dee2e6;
    }
    .modal-profile-img {
      width: 120px; height: 120px; border-radius: 50%;
      object-fit: cover; border: 3px solid #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }
    .profile-header {
      background: linear-gradient(135deg, #0d6efd, #0dcaf0);
      color: #fff; border-radius: 10px 10px 0 0;
      padding: 25px; text-align: center;
    }
    .profile-body {
      background: #fff; padding: 25px;
      border-radius: 0 0 10px 10px;
    }
    .action-dropdown .dropdown-menu a {
      display: flex; align-items: center;
      gap: 6px;
    }
    .form-section {
      background: #fff;
      border-radius: 8px;
      padding: 25px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      position: relative;
    }
    .close-btn {
      position: absolute; top: 15px; right: 20px;
      border: none; background: none; font-size: 1.5rem;
      color: #888; cursor: pointer;
    }
  </style>
</head>
<body>

<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold text-primary mb-0">👷 Employee Management</h2>
    <button class="btn btn-success btn-sm" type="button" id="addEmployeeBtn">
      ➕ Add Employee
    </button>
  </div>

  <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">✅ Employee added successfully!</div>
  <?php elseif(isset($_GET['updated'])): ?>
    <div class="alert alert-success">✅ Employee updated successfully!</div>
  <?php elseif(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger">❌ Employee deleted successfully!</div>
  <?php elseif(isset($_GET['error']) && $_GET['error']=='due_exists'): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="dueAlert">
      ⚠️ Cannot delete employee — ₹<?= number_format($_GET['amount'] ?? 0, 2) ?> due pending.
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- =================== ADD / EDIT EMPLOYEE FORM =================== -->
  <div class="collapse <?php echo $editEmp ? 'show' : ''; ?>" id="addEmployeeForm">
    <div class="form-section mb-4">
      <button type="button" class="close-btn" data-bs-toggle="collapse" data-bs-target="#addEmployeeForm">&times;</button>
      <h3><?php echo $editEmp ? "✏️ Edit Employee" : "➕ Add Employee"; ?></h3>
      <form action="../Controller/employeeController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo $editEmp ? 'update' : 'add'; ?>">
        <?php if($editEmp): ?>
          <input type="hidden" name="id" value="<?php echo $editEmp['id']; ?>">
          <input type="hidden" name="old_photo" value="<?php echo $editEmp['photo']; ?>">
        <?php endif; ?>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $editEmp['name'] ?? ''; ?>" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" value="<?php echo $editEmp['designation'] ?? ''; ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label">Contact</label>
            <input type="text" name="contact" class="form-control" value="<?php echo $editEmp['contact'] ?? ''; ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $editEmp['email'] ?? ''; ?>">
          </div>

          <div class="col-md-12">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="2" placeholder="Enter full address"><?php echo $editEmp['address'] ?? ''; ?></textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label">Date of Joining</label>
            <input type="date" name="doj" class="form-control" value="<?php echo $editEmp['doj'] ?? ''; ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label">Weekly Off Day</label>
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

          <div class="row g-3">
  <!-- Working Hours -->
  <div class="col-md-3">
    <label class="form-label">Working Hours</label>
    <input type="number" name="working_hours" class="form-control"
           step="0.5"
           value="<?php echo $editEmp['working_hours'] ?? ''; ?>">
  </div>

  <!-- Salary Type -->
  <div class="col-md-3">
    <label class="form-label">Salary Type</label>
    <select name="salary_type" class="form-select">
      <option value="Daily"   <?php echo (isset($editEmp['salary_type']) && $editEmp['salary_type']=='Daily')?'selected':''; ?>>Daily</option>
      <option value="Weekly"  <?php echo (isset($editEmp['salary_type']) && $editEmp['salary_type']=='Weekly')?'selected':''; ?>>Weekly</option>
      <option value="Monthly" <?php echo (isset($editEmp['salary_type']) && $editEmp['salary_type']=='Monthly')?'selected':''; ?>>Monthly</option>
    </select>
  </div>

  <!-- Salary Amount -->
  <div class="col-md-3">
    <label class="form-label">Salary Amount (₹)</label>
    <input type="number" name="salary_amount" class="form-control"
           step="0.01"
           value="<?php echo $editEmp['salary_amount'] ?? ''; ?>">
  </div>

  <!-- Hourly -->
  <div class="col-md-3">
    

    <div class="form-check mb-1">
      
      <input class="form-check-input" type="checkbox" id="is_hourly"
             name="is_hourly"
             <?php echo (!empty($editEmp['hourly_rate'])) ? 'checked' : ''; ?>>
             <label class="form-label d-block">Hourly</label>
      
    </div>

    <input type="number" name="hourly_rate" id="hourly_rate"
           class="form-control"
           step="0.01"
           placeholder="₹ per hour"
           value="<?php echo $editEmp['hourly_rate'] ?? ''; ?>"
           <?php echo (empty($editEmp['hourly_rate'])) ? 'disabled' : ''; ?>>
  </div>
</div>


          <div class="col-md-6">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            <?php if(!empty($editEmp['photo'])): ?>
              <div class="mt-2">
                <img src="../<?php echo $editEmp['photo']; ?>" class="avatar">
              </div>
            <?php endif; ?>
          </div>

          <div class="col-12">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3"><?php echo $editEmp['notes'] ?? ''; ?></textarea>
          </div>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary px-4"><?php echo $editEmp ? 'Update Employee' : 'Add Employee'; ?></button>
          <?php if($editEmp): ?>
            <a href="employee.php" class="btn btn-secondary ms-2">Cancel</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <!-- =================== EMPLOYEE LIST TABLE =================== -->
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">📋 Employee List</h5>
      <span class="badge bg-light text-dark"><?php echo count($employees); ?> Total</span>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Address</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($employees)): $count = 1; foreach($employees as $emp): ?>
          <tr>
            <td><?= $count++; ?></td>
            <td>
              <?php if($emp['photo']): ?>
                <img src="../<?= htmlspecialchars($emp['photo']); ?>" class="avatar">
              <?php else: ?>
                <img src="https://via.placeholder.com/45" class="avatar">
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($emp['name']); ?></td>
            <td><?= htmlspecialchars($emp['designation']); ?></td>
            <td><?= htmlspecialchars($emp['contact']); ?></td>
            <td><?= htmlspecialchars($emp['email']); ?></td>
            <td><?= htmlspecialchars($emp['address']); ?></td>
            <td class="text-center action-dropdown">
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Actions</button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" data-bs-toggle="modal" href="#infoModal<?= $emp['id']; ?>"><i class="bi bi-info-circle"></i> Info</a></li>
                  <li><a class="dropdown-item" href="employee.php?edit=<?= $emp['id']; ?>"><i class="bi bi-pencil-square"></i> Edit</a></li>
                  <li><a class="dropdown-item text-danger" href="../Controller/employeeController.php?delete=<?= $emp['id']; ?>" onclick="return confirm('Delete this employee?');"><i class="bi bi-trash"></i> Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>


          <!-- Info Modal -->
          <div class="modal fade" id="infoModal<?= $emp['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                
                <!-- Modal Header -->
                <div class="profile-header position-relative text-center p-4" style="background: linear-gradient(135deg, #0d6efd, #6f42c1);">
                  <?php if($emp['photo']): ?>
                    <img src="../<?= htmlspecialchars($emp['photo']); ?>" class="modal-profile-img mb-2 border border-3 border-light shadow-sm" style="width:130px;height:130px;border-radius:50%;object-fit:cover;">
                  <?php else: ?>
                    <img src="https://via.placeholder.com/130" class="modal-profile-img mb-2 border border-3 border-light shadow-sm" style="width:130px;height:130px;border-radius:50%;object-fit:cover;">
                  <?php endif; ?>
                  <h4 class="mt-3 mb-0 fw-semibold text-white"><?= htmlspecialchars($emp['name']); ?></h4>
                  <p class="text-light mb-0"><?= htmlspecialchars($emp['designation']); ?></p>

                  <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-light p-2 rounded-circle shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="profile-body bg-white p-4">
                  <div class="row g-4">

                    <div class="col-md-6">
                      <div class="p-3 bg-light rounded">
                        <strong class="text-secondary d-block mb-1"><i class="bi bi-telephone-fill"></i> Contact</strong>
                        <span><?= htmlspecialchars($emp['contact']); ?></span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 bg-light rounded">
                        <strong class="text-secondary d-block mb-1"><i class="bi bi-envelope-fill"></i> Email</strong>
                        <span><?= htmlspecialchars($emp['email']); ?></span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 bg-light rounded">
                        <strong class="text-secondary d-block mb-1"><i class="bi bi-geo-alt-fill"></i> Address</strong>
                        <span><?= htmlspecialchars($emp['address']); ?></span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 bg-light rounded">
                        <strong class="text-secondary d-block mb-1"><i class="bi bi-calendar-date-fill"></i> Date of Joining</strong>
                        <span><?= htmlspecialchars($emp['doj']); ?></span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 bg-light rounded">
                        <strong class="text-secondary d-block mb-1"><i class="bi bi-calendar2-week"></i> Weekly Off</strong>
                        <span><?= htmlspecialchars($emp['weekly_off_day']); ?></span>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 bg-light rounded">
                        <strong class="text-secondary d-block mb-1"><i class="bi bi-cash-stack"></i> Salary</strong>
                        <span><?= htmlspecialchars($emp['salary_type']); ?> — ₹<?= htmlspecialchars($emp['salary_amount']); ?></span>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="p-3 bg-light rounded">
                        <strong class="text-secondary d-block mb-1"><i class="bi bi-journal-text"></i> Notes</strong>
                        <div><?= nl2br(htmlspecialchars($emp['notes'])); ?></div>
                      </div>
                    </div>

                  </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light py-3">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                </div>

              </div>
            </div>
          </div>


          <?php endforeach; else: ?>
            <tr><td colspan="8" class="text-center text-muted">No employees found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  // Auto-hide alert after 5s
  const dueAlert = document.getElementById("dueAlert");
  if (dueAlert) {
    setTimeout(() => new bootstrap.Alert(dueAlert).close(), 5000);
  }

  // ✅ Fix for Add Employee collapse toggle
  document.getElementById("addEmployeeBtn").addEventListener("click", function() {
    const form = document.getElementById("addEmployeeForm");
    const collapse = bootstrap.Collapse.getOrCreateInstance(form);
    collapse.toggle();
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const hourlyCheckbox = document.getElementById("is_hourly");
  const hourlyInput = document.getElementById("hourly_rate");

  if (hourlyCheckbox) {
    hourlyCheckbox.addEventListener("change", function () {
      hourlyInput.disabled = !this.checked;
      if (!this.checked) {
        hourlyInput.value = "";
      }
    });
  }
});
</script>
</body>
</html>
