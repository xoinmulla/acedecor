<?php
include('session.php');
include('unitheader.php');
require_once("../DB Operations/unitFactorOps.php");
require_once("../Model/unitFactorModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<style>
    .card-body #unitFactor_table th {
        font-weight: 500;
    }

    /* Modal positioning only - existing page/CRUD logic remains unchanged */
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
<div class="card shadow mb-4">
    <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Unit
                    Factor</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#unitFactorModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="unitFactor_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th style='display:none'>unit Id</th>
                        <th>Unit</th>
                        <th>Unit Factor</th>
                        <th>Unit Factor Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $unitFactorList = DBunitFactor::getAllUnitFactor();

                    foreach ($unitFactorList as $unitFactor) {

                        // ✅ CORRECT CHECK (ID-based via JOIN)
                        $isMapped =
                            DBunitFactor::isUnitFactorMappedToItemById($unitFactor->get_unitFactorId()) ||
                            DBunitFactor::isUnitFactorMappedToMaterialById($unitFactor->get_unitFactorId());
                        ?>
                        <tr>
                            <td style="display:none"><?= $unitFactor->get_unitId(); ?></td>
                            <td><?= $unitFactor->get_unitName(); ?></td>
                            <td><?= $unitFactor->get_unitFactor(); ?></td>
                            <td><?= $unitFactor->get_unitFactorDescription(); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>

                                    <div class="dropdown-menu">

                                        <!-- EDIT -->
                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#editUnitFactorModal"
                                            data-id="<?= $unitFactor->get_unitFactorId(); ?>">
                                            <i class="fas fa-user-edit"></i> Edit Unit Factor
                                        </button>

                                        <!-- DELETE -->
                                        <?php if ($isMapped) { ?>
                                            <button class="btn btn-secondary dropdown-item" disabled
                                                title="Unit Factor is used in Item or Material">
                                                <i class="fas fa-lock"></i> Delete Disabled
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-danger dropdown-item" data-toggle="modal"
                                                data-target="#deleteSubCategoryModal"
                                                data-id="<?= $unitFactor->get_unitFactorId(); ?>">
                                                <i class="fas fa-trash-alt"></i> Delete Unit Factor
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
<div class="modal fade" id=unitFactorModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data"
            action="../Controller/unitFactorController.php">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Add Unit Factor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="units" class="form-select" required name="unitId">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Factor <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="unitFactor" id="unitFactor" step="0.01"
                                    min="0" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Factor Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitFactorDescription" id="unitFactorDescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
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
<div class="modal fade" id=editUnitFactorModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="editUnitFactor_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="editunits" class="form-select" required name="unitId">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Factor<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="unitFactor" id="editedunitFactor"
                                    step="0.01" min="0" required />
                                <input type="hidden" name="unitFactorId" id="unitFactorId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Factor Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitFactorDescription" id="editedunitFactorDescription"
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
                        <input type="hidden" name="action" id="edit_action" value="" />
                        <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteSubCategoryModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_subcategory_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Delete Sub Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Subcategory record.
                    </p>
                    <input type="hidden" id="deleteUnitFactorId">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="deletebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        // $('#editUnitFactorModal').on('show.bs.modal', function (e) {
        //     var rowid = $(e.relatedTarget).data('id');
        //     $('#unitFactorId').val(rowid);

        // });
        var dataTable = $('#unitFactor_table').DataTable({

        });

        var nEditing = null;

        // $('#unitFactor_table tbody').on('click', 'tr', function () {
        //     /* Get the row as a parent of the link that was clicked on */
        //     $('#editunits').val(this.cells[0].innerHTML);
        //     $('#editedunitFactor').val(this.cells[2].innerHTML);
        //     $('#editedunitFactorDescription').val(this.cells[3].innerHTML);

        // });
        $('#unitFactor_table').on('click', '[data-target="#editUnitFactorModal"]', function () {

            const unitFactorId = $(this).data('id');
            const row = $(this).closest('tr');

            $('#unitFactorId').val(unitFactorId);                 // ✅ IMPORTANT
            $('#editunits').val(row.find('td:eq(0)').text().trim());
            $('#editedunitFactor').val(row.find('td:eq(2)').text().trim());
            $('#editedunitFactorDescription').val(row.find('td:eq(3)').text().trim());

        });

        $('#user_form').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/unitFactorController.php",
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

        $('#editUnitFactor_form').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/unitFactorController.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        $('#editUnitFactorModal #form_message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        $('#editUnitFactorModal #form_message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );
                    }
                }
            });
        });


        var url = config.developmentPath + "/Admin/Controller/unitsContoller.php";

        $.getJSON(url, function (data) {
            $.each(data, function (index, value) {
                $('#units').append('<option hidden disabled selected value>-- select an option --</option>');
                $('#units').append('<option value="' + value.unitId + '">' + value
                    .unitName + '</option>');
                $('#editunits').append('<option value="' + value.unitId + '">' + value
                    .unitName + '</option>');
            });
        });
        $('#deleteSubCategoryModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#deleteUnitFactorId').val(rowid); // ✅ CORRECT
        });

        $('#deletebutton').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/unitFactorController.php",
                method: "POST",
                dataType: "json",
                data: {
                    id: $('#deleteUnitFactorId').val(),
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
         * Keep every Unit Factor modal horizontally centered
         * and near the top of the browser viewport.
         *
         * Existing DataTable, AJAX, CRUD, validation and mapping
         * logic is intentionally untouched.
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

        // Re-center an open modal after browser/device resize.
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