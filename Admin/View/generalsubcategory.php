<?php
include("Session.php");
include("paymentnavigation.php");
require_once("../DB Operations/generalSubcategoryOps.php");

$subcategories = DBGeneralSubcategory::getAll();
?>

<div class="card shadow mb-4 mt-4 mx-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">General Subcategory</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle="modal" data-target="#generalSubcategoryModal">
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
            <table class="table table-bordered" id="generalSubcategoryTable" width="100%">
                <thead>
                    <tr>
                        <th>Subcategory Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subcategories as $sub): ?>
                        <tr>
                            <td><?= htmlspecialchars($sub->getName()) ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-primary edit-btn" href="#" data-toggle="modal"
                                            data-target="#editGeneralSubcategoryModal" data-id="<?= $sub->getId() ?>"
                                            data-name="<?= htmlspecialchars($sub->getName()) ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a class="dropdown-item text-danger delete-btn" href="#" data-toggle="modal"
                                            data-target="#deleteGeneralSubcategoryModal" data-id="<?= $sub->getId() ?>"
                                            data-name="<?= htmlspecialchars($sub->getName()) ?>">
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

<div class="modal fade" id="generalSubcategoryModal">
    <div class="modal-dialog">
        <form id="addGeneralSubcategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add General Subcategory</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Category</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="General" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 text-right">Subcategory Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="subcategory_name" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editGeneralSubcategoryModal">
    <div class="modal-dialog">
        <form id="editGeneralSubcategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Subcategory</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Subcategory Name</label>
                        <div class="col-md-8">
                            <input type="text" name="edit_subcategory_name" id="edit_subcategory_name"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteGeneralSubcategoryModal">
    <div class="modal-dialog">
        <form id="deleteGeneralSubcategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Subcategory</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                    <h6 id="deleteSubcategoryName" class="text-danger"></h6>
                    <input type="hidden" name="delete_id" id="delete_id">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger">Confirm</button>
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

<!-- jQuery (if not already loaded globally) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {

        // ✅ Initialize DataTable (sorting, search, pagination)
        const table = $('#generalSubcategoryTable').DataTable({
            "pageLength": 10,
            "lengthChange": true,
            "ordering": true,
            "searching": true,
            "drawCallback": function () {
                // 🔥 Fix dropdown after pagination / search / sort
                $('[data-toggle="dropdown"]').dropdown();
            }
        });

        // 🔥 Prevent dropdown auto-close issues
        $(document).on('click', '[data-toggle="dropdown"]', function (e) {
            e.stopPropagation();
            $(this).next('.dropdown-menu').toggle();
        });

        // ================= ADD =================
        $('#addGeneralSubcategoryForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: '../Controller/generalSubcategoryController.php',
                type: 'POST',
                data: $(this).serialize() + '&action=Add',
                success: function (res) {
                    if (res.trim() === 'success') {
                        $('#generalSubcategoryModal').modal('hide');
                        showToast('✅ Subcategory added successfully!', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast('❌ Failed to add subcategory: ' + res, 'danger');
                    }
                }

            });
        });

        // ================= EDIT =================
        $(document).on('click', '.edit-btn', function () {
            $('#edit_id').val($(this).data('id'));
            $('#edit_subcategory_name').val($(this).data('name'));
        });

        $('#editGeneralSubcategoryForm').submit(function (e) {
            e.preventDefault();
            $.post('../Controller/generalSubcategoryController.php',
                $(this).serialize() + '&action=Edit',
                function (res) {
                    if (res.trim() === 'success') {
                        $('#editGeneralSubcategoryModal').modal('hide');
                        showToast('✏️ Subcategory updated successfully!', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast('❌ Failed to update subcategory', 'danger');
                    }
                }

            );
        });

        // ================= DELETE =================
        $(document).on('click', '.delete-btn', function () {
            $('#delete_id').val($(this).data('id'));
            $('#deleteSubcategoryName').text($(this).data('name'));
        });

        $('#deleteGeneralSubcategoryForm').submit(function (e) {
            e.preventDefault();
            $.post('../Controller/generalSubcategoryController.php',
                $(this).serialize() + '&action=Delete',
                function (res) {
                    if (res.trim() === 'success') {
                        $('#deleteGeneralSubcategoryModal').modal('hide');
                        showToast('🗑️ Subcategory deleted successfully!', 'danger');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast('❌ Failed to delete subcategory', 'danger');
                    }
                }

            );
        });
        // ✅ Bootstrap Toast helper
        function showToast(message, type = 'success') {

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
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
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