<?php
include('session.php');
include('unitheader.php');
require_once("../DB Operations/unitOps.php");
require_once("../Model/unitsModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<style>
    .card-body #units_table th {
        font-weight: 500;
    }

    /* Modal positioning only - existing page/table logic remains unchanged */
    .modal-dialog {
        margin: 0 !important;
    }

    .modal-dialog.modal-positioned {
        position: fixed !important;
        margin: 0 !important;
        transform: none !important;
        z-index: 1051;
    }

    @media (max-width: 767.98px) {
        .modal-dialog {
            width: calc(100% - 20px) !important;
            max-width: calc(100% - 20px) !important;
        }
    }
</style>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Unit List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#unitModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="units_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th>Unit Name</th>
                        <th>Unit Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $unitList = DBunit::getAllUnit();

                    foreach ($unitList as $unit) {

                        // ✅ check mapping
                        $isMapped = DBunit::isUnitMapped($unit->get_unitId());
                        ?>
                        <tr>
                            <td><?= $unit->get_unitName(); ?></td>
                            <td><?= $unit->get_unitDescription(); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>

                                    <div class="dropdown-menu">

                                        <!-- EDIT -->
                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#editUnitModal" data-id="<?= $unit->get_unitId(); ?>">
                                            <i class="fas fa-user-edit"></i> Edit Unit
                                        </button>

                                        <!-- DELETE -->
                                        <?php if ($isMapped) { ?>
                                            <button class="btn btn-secondary dropdown-item" disabled
                                                title="Unit is mapped to Unit Factor">
                                                <i class="fas fa-lock"></i> Delete Disabled
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-danger dropdown-item" data-toggle="modal"
                                                data-target="#deleteUnitsModal" data-id="<?= $unit->get_unitId(); ?>">
                                                <i class="fas fa-trash-alt"></i> Delete Unit
                                            </button>
                                        <?php } ?>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=unitModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data" action="../Controller/unitsContoller.php">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Add Units</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitName" id="unitName" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitDescription" id="unitDescription" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=editUnitModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="unit_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Edit Units</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitName" id="editedUnitName" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name="unitId" id="unitId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitDescription" id="editedUnitDescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="editedcreatedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="editedmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteUnitsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Delete Item Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this category record.
                    </p>
                    <input type="hidden" name="itemcatid" id="itemcatid" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="deletebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        // =============================
        // DATATABLE
        // =============================
        var dataTable = $('#units_table').DataTable({});

        // =============================
        // EDIT MODAL – LOAD DATA
        // =============================
        $('#editUnitModal').on('show.bs.modal', function (e) {
            let button = $(e.relatedTarget);
            let unitId = button.data('id');

            let row = button.closest('tr');

            $('#unitId').val(unitId);
            $('#editedUnitName').val(row.find('td:eq(0)').text());
            $('#editedUnitDescription').val(row.find('td:eq(1)').text());

            $('#editUnitModal #form_message').html('');
        });

        // =============================
        // INSERT UNIT
        // =============================
        $('#user_form').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/unitsContoller.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        $('#form_message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        $('#form_message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );
                    }
                }
            });
        });

        // =============================
        // UPDATE UNIT
        // =============================
        $('#unit_form').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/unitsContoller.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        $('#editUnitModal #form_message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        $('#editUnitModal #form_message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );
                    }
                }
            });
        });

        // =============================
        // DELETE MODAL
        // =============================
        $('#deleteUnitsModal').on('show.bs.modal', function (e) {
            let unitId = $(e.relatedTarget).data('id');
            $('#itemcatid').val(unitId);
        });

        // =============================
        // DELETE UNIT
        // =============================
        $('#deletebutton').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/unitsContoller.php",
                method: "POST",
                dataType: "json",
                data: {
                    id: $('#itemcatid').val(),
                    action: 'delete'
                },
                success: function (res) {
                    if (res.status === "error") {
                        alert(res.message);
                    } else {
                        alert(res.message);
                        location.reload();
                    }
                }
            });
        });

        /*
         * Keep every Unit modal horizontally centered and near the top
         * of the browser viewport.
         *
         * Existing DataTable, AJAX, CRUD, validation and mapping logic
         * is intentionally untouched.
         */
        $('.modal').on('shown.bs.modal', function () {

            var $dialog = $(this).find('.modal-dialog');

            if ($dialog.hasClass("ui-draggable")) {
                $dialog.draggable("destroy");
            }

            $dialog.addClass('modal-positioned');

            var dialogWidth = $dialog.outerWidth();
            var windowWidth = $(window).width();
            var left = Math.max(10, (windowWidth - dialogWidth) / 2);

            $dialog.css({
                position: "fixed",
                left: left + "px",
                top: "20px",
                margin: 0,
                transform: "none"
            });

            // Preserve the existing draggable modal functionality.
            $dialog.draggable({
                handle: ".modal-header",
                containment: "window",
                scroll: false
            });

        });

        // Re-center an open modal after a device/browser resize.
        $(window).on('resize', function () {
            $('.modal.show').each(function () {
                var $dialog = $(this).find('.modal-dialog');

                if (!$dialog.hasClass("ui-draggable-dragging")) {
                    var dialogWidth = $dialog.outerWidth();
                    var windowWidth = $(window).width();
                    var left = Math.max(10, (windowWidth - dialogWidth) / 2);

                    $dialog.css({
                        left: left + "px",
                        top: "20px"
                    });
                }
            });
        });

    });
</script>