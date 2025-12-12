<?php
include('session.php');
include('paymentnavigation.php');
require_once("../DB Operations/employeePaymentOps.php");
require_once("../DB Operations/employeeOps.php");
require_once("../Controller/employeePaymentController.php");


$employees = DBEmployee::readAll();
$payments = DBEmployeePayment::readAll();
?>
<!-- DataTables (Bootstrap 4 theme) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

<h1 class="h3 mb-4 text-gray-800">Employee Payment Management</h1>
<span id="message"></span>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col">
        <h6 class="m-0 font-weight-bold text-primary">Employee Payment List</h6>
      </div>
      <div class="col" align="right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addPaymentModal" role="button">
          <i class="fas fa-plus-circle"></i> Add Payment
        </button>
      </div>

    </div>
  </div>

  <div class="card-body">
    <div class="container-fluid">
      <table class="table table-bordered table-hover" id="employee_payment_table" width="100%"
        cellspacing="0">
        <thead>
          <tr>
            <th style="width:60px;">S.No</th>
            <th>Date</th>
            <th>Employee</th>
            <th>Amount (₹)</th>
            <th>Type</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $serial = 1;
          foreach ($payments as $p): ?>
            <tr>
              <td><?= $serial++; ?></td>
              <td><?= $p['payment_date']; ?></td>
              <td><?= htmlspecialchars($p['emp_name']); ?></td>
              <td>₹<?= number_format($p['amount'], 2); ?></td>
              <td><?= htmlspecialchars($p['payment_type']); ?></td>
              <td>
                <?php if ($p['status'] == 'Paid'): ?>
                  <span class="badge badge-success">Paid</span>
                <?php else: ?>
                  <span class="badge badge-warning text-dark">Pending</span>
                <?php endif; ?>
              </td>
              <td><?= nl2br(htmlspecialchars($p['remarks'])); ?></td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-expanded="false">
                    Actions
                  </button>
                  <div class="dropdown-menu">
                    <button class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#editPaymentModal"
                      data-id="<?= $p['id']; ?>">
                      <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger dropdown-item" data-toggle="modal" data-target="#deletePaymentModal"
                      data-id="<?= $p['id']; ?>">
                      <i class="fas fa-trash-alt"></i> Delete
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($payments)): ?>
            <tr>
              <td colspan="8" class="text-center text-muted">No payments found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- ADD PAYMENT MODAL -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="../Controller/employeePaymentController.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Payment</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" value="add">
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Date *</label>
            <div class="col-md-8">
              <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Employee *</label>
            <div class="col-md-8">
              <select name="emp_id" class="form-control" required>
                <option value="">Select Employee</option>
                <?php foreach ($employees as $emp): ?>
                  <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Due Amount (₹)</label>
            <div class="col-md-8">
              <input type="text" name="due_amount" class="form-control" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Amount *</label>
            <div class="col-md-8">
              <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Payment Type</label>
            <div class="col-md-8">
              <select name="payment_type" class="form-control">
                <option>Cash</option>
                <option>Bank Transfer</option>
                <option>UPI</option>
                <option>Cheque</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Status</label>
            <div class="col-md-8">
              <select name="status" class="form-control">
                <option>Paid</option>
                <option>Pending</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Remarks</label>
            <div class="col-md-8">
              <textarea name="remarks" class="form-control" rows="2"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- EDIT PAYMENT MODAL -->
<div class="modal fade" id="editPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="../Controller/employeePaymentController.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Payment</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Date *</label>
            <div class="col-md-8">
              <input type="date" name="payment_date" id="edit_payment_date" class="form-control" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Employee *</label>
            <div class="col-md-8">
              <select name="emp_id" id="edit_emp_id" class="form-control" required>
                <option value="">Select Employee</option>
                <?php foreach ($employees as $emp): ?>
                  <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Due Amount (₹)</label>
            <div class="col-md-8">
              <input type="text" id="edit_due_amount" class="form-control" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Amount *</label>
            <div class="col-md-8">
              <input type="number" step="0.01" name="amount" id="edit_amount" class="form-control" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Payment Type</label>
            <div class="col-md-8">
              <select name="payment_type" id="edit_payment_type" class="form-control">
                <option>Cash</option>
                <option>Bank Transfer</option>
                <option>UPI</option>
                <option>Cheque</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Status</label>
            <div class="col-md-8">
              <select name="status" id="edit_status" class="form-control">
                <option>Paid</option>
                <option>Pending</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-right">Remarks</label>
            <div class="col-md-8">
              <textarea name="remarks" id="edit_remarks" class="form-control" rows="2"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deletePaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="deleteForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Payment</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this payment?</p>
          <input type="hidden" id="delete_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function () {
    // ===== Due Amount Fetch (for Add & Edit) =====
    function fetchDue(modal) {
      var empSelect = modal.find('select[name="emp_id"]');
      var payDate = modal.find('input[name="payment_date"]');
      var dueField = modal.find('input[name="due_amount"], #edit_due_amount');

      function updateDue() {
        var empId = empSelect.val();
        if (!empId) { dueField.val(''); return; }
        var month = (payDate.val() || new Date().toISOString().slice(0, 10)).slice(0, 7);
        $.getJSON('../Controller/employeePaymentController.php', { action: 'getDue', emp_id: empId, month: month }, function (data) {
          var v = parseFloat(data.due);
          dueField.val(isFinite(v) ? '₹ ' + v.toFixed(2) : '₹ 0.00');
        });
      }
      empSelect.change(updateDue);
      payDate.change(updateDue);
      updateDue();
    }

    $('#addPaymentModal').on('shown.bs.modal', function () { fetchDue($(this)); });
    $('#editPaymentModal').on('shown.bs.modal', function () { fetchDue($(this)); });

    // ===== Edit Prefill =====
    $('#editPaymentModal').on('show.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
      $('#edit_id').val(id);
      $.getJSON('../Controller/employeePaymentController.php', { action: 'fetch', id: id }, function (data) {
        if (data.error) { alert(data.error); return; }
        $('#edit_payment_date').val(data.payment_date);
        $('#edit_emp_id').val(data.emp_id);
        $('#edit_amount').val(data.amount);
        $('#edit_payment_type').val(data.payment_type);
        $('#edit_status').val(data.status);
        $('#edit_remarks').val(data.remarks);
      });
    });

    // ===== Delete =====
    $('#deletePaymentModal').on('show.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
      $('#delete_id').val(id);
    });

    $('#deleteForm').submit(function (e) {
      e.preventDefault();
      var id = $('#delete_id').val();
      $.post('../Controller/employeePaymentController.php', { delete: id }, function () {
        window.location.href = 'employeePayment.php?deleted=1';
      });
    });
    $('#employee_payment_table').DataTable({
    "order": [[1, "desc"]],         // Default sort by Date column
    "pageLength": 10,               // Show 10 rows per page
    "columnDefs": [
      { "orderable": false, "targets": [0, 7] } // Disable sorting on S.No and Actions
    ]
  });
  });
</script>