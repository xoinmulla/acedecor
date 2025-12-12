<?php
include('session.php');
include('employeeNavigation.php');
require_once("../DB Operations/settingsOps.php");
$set = DBSettings::read();
$presets = json_decode($set['time_presets'] ?? '[]', true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Settings</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa}
    .container-fluid{max-width:1200px}
    .card{border-radius:10px}
    .table td input{width:100%}
  </style>
</head>
<body>
<div class="container-fluid py-4">
  <h2 class="fw-semibold text-primary mb-4">⚙️ Settings</h2>

  <?php if(isset($_GET['saved'])): ?>
    <div class="alert alert-success">✅ Settings saved successfully.</div>
  <?php endif; ?>

  <form method="POST" action="../Controller/settingsController.php" id="settingsForm">
    <!-- Work Settings -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white"><strong>Work Settings</strong></div>
      <div class="card-body row g-3">
        <div class="col-md-3">
          <label class="form-label">Hours per Day</label>
          <input type="number" step="0.25" name="hours_per_day" class="form-control"
                 value="<?= htmlspecialchars($set['hours_per_day'] ?? 8) ?>" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">OT Multiplier</label>
          <input type="number" step="0.1" name="ot_multiplier" class="form-control"
                 value="<?= htmlspecialchars($set['ot_multiplier'] ?? 1.5) ?>" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Half-day Threshold (hrs)</label>
          <input type="number" step="0.25" name="half_day_threshold" class="form-control"
                 value="<?= htmlspecialchars($set['half_day_threshold'] ?? 0) ?>">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="weekly_off_paid" id="weeklyOffPaid"
                   <?= !empty($set['weekly_off_paid']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="weeklyOffPaid">Weekly Off is Paid</label>
          </div>
        </div>
      </div>
    </div>

    <!-- Time Presets -->
    <div class="card shadow-sm mb-3">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <strong>Time Presets</strong>
        <button type="button" class="btn btn-light btn-sm" id="btnAddPreset">+ Add Row</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered align-middle" id="presetTable">
            <thead class="table-light">
              <tr>
                <th style="width:45%">Description</th>
                <th style="width:25%">Hours</th>
                <th style="width:20%">Type</th>
                <th style="width:10%" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($presets as $p): ?>
                <tr>
                  <td><input class="form-control" name="desc" value="<?= htmlspecialchars($p['desc']) ?>"></td>
                  <td><input class="form-control" name="hours" value="<?= htmlspecialchars($p['hours']) ?>" placeholder="e.g. 8 or Present+OT"></td>
                  <td>
                    <select class="form-select" name="type">
                      <option value="preset" <?= ($p['type'] ?? '')==='preset'?'selected':'' ?>>Time Preset</option>
                      <option value="input"  <?= ($p['type'] ?? '')==='input' ?'selected':'' ?>>Time Input</option>
                    </select>
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger btnDel">Delete</button>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php if(empty($presets)): ?>
                <tr>
                  <td><input class="form-control" name="desc" value="Present"></td>
                  <td><input class="form-control" name="hours" value="8"></td>
                  <td>
                    <select class="form-select" name="type">
                      <option value="preset" selected>Time Preset</option>
                      <option value="input">Time Input</option>
                    </select>
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger btnDel">Delete</button>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <small class="text-muted">
          Tip: For OT row, set Hours to <strong>Present+OT</strong> and Type to <strong>Time Input</strong>.
        </small>
      </div>
    </div>

    <input type="hidden" name="time_presets_json" id="time_presets_json" value="">
    <button class="btn btn-primary px-4">Save Settings</button>
  </form>
</div>

<script>
(function(){
  const tbody = document.querySelector('#presetTable tbody');
  const btnAdd = document.getElementById('btnAddPreset');

  btnAdd.addEventListener('click', () => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><input class="form-control" name="desc" placeholder="Description"></td>
      <td><input class="form-control" name="hours" placeholder="e.g. 8 or Present+OT"></td>
      <td>
        <select class="form-select" name="type">
          <option value="preset" selected>Time Preset</option>
          <option value="input">Time Input</option>
        </select>
      </td>
      <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-danger btnDel">Delete</button>
      </td>`;
    tbody.appendChild(tr);
  });

  tbody.addEventListener('click', (e) => {
    if (e.target.classList.contains('btnDel')) {
      e.preventDefault();
      e.target.closest('tr').remove();
    }
  });

  document.getElementById('settingsForm').addEventListener('submit', () => {
    const rows = [...tbody.querySelectorAll('tr')];
    const data = rows.map(r => {
      const desc  = r.querySelector('input[name="desc"]').value.trim();
      const hours = r.querySelector('input[name="hours"]').value.trim();
      const type  = r.querySelector('select[name="type"]').value;
      return { desc, hours: hours || "", type };
    }).filter(x => x.desc !== "");
    document.getElementById('time_presets_json').value = JSON.stringify(data);
  });
})();
</script>
</body>
</html>
