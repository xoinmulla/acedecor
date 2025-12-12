<?php
include("Session.php");
include("paymentnavigation.php");
require_once("../DB Operations/expenseCategoryOps.php");
$categories = DBExpenseCategory::getAll();
?>

<!-- Expense Category Card -->
<div class="card shadow mb-4 mt-4 mx-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Expense Category</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle="modal" data-target="#expenseCategoryModal">
                    <button type="button" class="btn btn-success btn-circle btn-sm">
                        <i class="fas fa-plus"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div id="message"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="expenseCategoryTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= htmlspecialchars($cat->getName()) ?></td>
                        <td><?= htmlspecialchars($cat->getType()) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Actions</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item text-primary edit-btn"
                                       href="#"
                                       data-toggle="modal"
                                       data-target="#editExpenseCategoryModal"
                                       data-id="<?= $cat->getId() ?>"
                                       data-name="<?= htmlspecialchars($cat->getName()) ?>"
                                       data-type="<?= htmlspecialchars($cat->getType()) ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item text-danger delete-btn"
                                       href="#"
                                       data-toggle="modal"
                                       data-target="#deleteExpenseCategoryModal"
                                       data-id="<?= $cat->getId() ?>"
                                       data-name="<?= htmlspecialchars($cat->getName()) ?>">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===================== ADD MODAL ===================== -->
<div class="modal fade" id="expenseCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addExpenseCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Expense Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="category_name" id="category_name" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Type <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select name="category_type" id="category_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Expense">Expense</option>
                                <option value="Income">Income</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ===================== EDIT MODAL ===================== -->
<div class="modal fade" id="editExpenseCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editExpenseCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Expense Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="edit_category_name" id="edit_category_name" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Type <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select name="edit_category_type" id="edit_category_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Expense">Expense</option>
                                <option value="Income">Income</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ===================== DELETE MODAL ===================== -->
<div class="modal fade" id="deleteExpenseCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteExpenseCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Expense Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">Are you sure you want to delete this category?</p>
                    <h6 id="deleteCategoryName" class="text-danger font-weight-bold"></h6>
                    <input type="hidden" id="delete_id" name="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable
    const table = $('#expenseCategoryTable').DataTable({
        "drawCallback": function () {
            // Ensure dropdowns work after DataTable redraws
            $('[data-toggle="dropdown"]').dropdown();
        }
    });

    // Ensure dropdowns stay open properly
    $(document).on('click', '[data-toggle="dropdown"]', function (e) {
        e.stopPropagation();
        $(this).next('.dropdown-menu').toggle();
    });

    // ✅ ADD Category
    $('#addExpenseCategoryForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '../Controller/expenseCategoryController.php', // ✅ Correct path
            method: 'POST',
            data: $(this).serialize() + '&action=Add',
            success: function (res) {
                console.log('Add Response:', res);
                if (res.trim() === 'success') {
                    $('#expenseCategoryModal').modal('hide');
                    showToast('✅ Category added successfully!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('❌ Error adding category: ' + res, 'danger');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
                showToast('⚠️ AJAX error - check console', 'warning');
            }
        });
    });

    // ✅ Fill EDIT modal
    $(document).on('click', '.edit-btn', function () {
        $('#edit_id').val($(this).data('id'));
        $('#edit_category_name').val($(this).data('name'));
        $('#edit_category_type').val($(this).data('type'));
    });

    // ✅ EDIT submit
    $('#editExpenseCategoryForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '../Controller/expenseCategoryController.php', // ✅ Correct path
            method: 'POST',
            data: $(this).serialize() + '&action=Edit',
            success: function (res) {
                console.log('Edit Response:', res);
                if (res.trim() === 'success') {
                    $('#editExpenseCategoryModal').modal('hide');
                    showToast('✏️ Category updated successfully!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('❌ Error updating category: ' + res, 'danger');
                }
            }
        });
    });

    // ✅ DELETE modal fill
    $(document).on('click', '.delete-btn', function () {
        $('#delete_id').val($(this).data('id'));
        $('#deleteCategoryName').text($(this).data('name'));
    });

    // ✅ DELETE submit
    $('#deleteExpenseCategoryForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '../Controller/expenseCategoryController.php', // ✅ Correct path
            method: 'POST',
            data: $(this).serialize() + '&action=Delete',
            success: function (res) {
                console.log('Delete Response:', res);
                if (res.trim() === 'success') {
                    $('#deleteExpenseCategoryModal').modal('hide');
                    showToast('🗑️ Category deleted successfully!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('❌ Error deleting category: ' + res, 'danger');
                }
            }
        });
    });

    // ✅ Simple Bootstrap Toast notification
    function showToast(message, type = 'info') {
        const bgClass = {
            success: 'bg-success',
            danger: 'bg-danger',
            warning: 'bg-warning',
            info: 'bg-info'
        }[type] || 'bg-secondary';

        const toast = $(`
            <div class="toast align-items-center text-white ${bgClass} border-0" 
                 role="alert" aria-live="assertive" aria-atomic="true" 
                 style="position: fixed; top: 20px; right: 20px; z-index: 1051;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `);
        $('body').append(toast);
        toast.toast({ delay: 2500 });
        toast.toast('show');
        setTimeout(() => toast.remove(), 3000);
    }
});
</script>

