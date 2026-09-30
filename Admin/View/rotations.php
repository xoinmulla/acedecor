<?php
include('session.php');
include('details.php');
require_once("../DB Operations/rotationOps.php");
require_once("../Model/rotationModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
 <style>
    .card-body #rotation_table th {
        font-weight: 500;
    }

    /* Modal positioning only - existing page/table/CRUD logic unchanged */
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

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    }
 </style>
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Rotations
                </h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#rotationModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="rotation_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th>Sides</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rotationList = DBrotation::getAllrotation();
                    foreach ($rotationList as $rotation) {
                        echo "<tr><td>" . $rotation->get_sides() . "</td>
                        <td>
                        <div class='dropdown'>
                        <button class='btn btn-secondary dropdown-toggle' 
                        type='button' 
                        id='dropdownMenu2' 
                        data-toggle='dropdown' 
                        aria-expanded='false'>
                        Actions
                        </button>
                        <div class='dropdown-menu' 
                        aria-labelledby='dropdownMenu2'>
                            <button class='btn btn-primary dropdown-item'
                            data-toggle='modal' 
                            data-target='#editrotationModal' 
                            role='button' 
                            data-id='" . $rotation->get_rotationId() . "'>
                            <i class='fas fa-user-edit'></i> 
                                Edit Rotation
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteRotationModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $rotation->get_rotationId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Rotation
                          </button>
                        </div>
                    </div>            
            </td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=rotationModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="rotation_form">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Add Rotation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Rotation Side <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="rotationside" id="rotationside" class="form-control"
                                    required />
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Dimension Description <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="dimensionDescription" id="dimensionDescription" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">length<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="length" id="length" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Breadth<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="breadth" id="breadth" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Thickness<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="thickness" id="thickness" class="form-control" required />
                            </div>
                        </div>
                    </div> -->
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
<div class="modal fade" id=editrotationModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="editedrotation_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Edit Rotation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Rotation Side<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="rotationside" id="editedrotationside" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name="rotationId" id="rotationId" value="">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Dimension Description <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="dimensionDescription" id="editeddimensionDescription" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">length<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="length" id="editedlength" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Breadth<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="breadth" id="editedbreadth" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Thickness<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="thickness" id="editedthickness" class="form-control" required />
                            </div>
                        </div>
                    </div> -->
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
<div class="modal fade" id=deleteRotationModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Delete Item Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this rotation record.
                    </p>
                    <input type="hidden" name="rotationid" id="rotationid" value="">
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
        $('#rotationModal').on('show.bs.modal', function () {
            $('#rotationModal #form_message').html('');
        });

        $('#editrotationModal').on('show.bs.modal', function () {
            $('#editrotationModal #form_message').html('');
        });
        $('#editrotationModal').on('show.bs.modal', function (e) {

            var button = $(e.relatedTarget);

            var rowid = button.data('id');

            var row = button.closest('tr');

            var rotationSide = row.find('td:eq(0)').text().trim();

            $('#rotationId').val(rowid);

            $('#editedrotationside').val(rotationSide);

            $('#editrotationModal #form_message').html('');

        });
        var dataTable = $('#rotation_table').DataTable({

        });

        var nEditing = null;

        $('#rotation_table tbody').on('click', 'tr', function () {

            $('#editedrotationside').val($(this).find('td:eq(0)').text().trim());

        });
        $('#rotation_form').submit(function (e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/rotationController.php",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                dataType: "json",

                success: function (res) {

                    if (res.status == "success") {

                        $('#rotationModal #form_message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    } else {

                        $('#rotationModal #form_message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );

                    }

                }

            });

        });
        $('#editedrotation_form').submit(function (e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/rotationController.php",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                dataType: "json",

                success: function (res) {

                    if (res.status == "success") {

                        $('#editrotationModal #form_message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    } else {

                        $('#editrotationModal #form_message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );

                    }

                }

            });

        });
        $('#deleteRotationModal').on('show.bs.modal', function (e) {

            var rowid = $(e.relatedTarget).data('id');

            $('#rotationid').val(rowid);

        });
        $('#deletebutton').click(function (e) {

            e.preventDefault();

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/rotationController.php",

                method: "POST",

                dataType: "json",

                data: {
                    id: $('#rotationid').val(),
                    action: 'delete'
                },

                success: function (res) {

                    $('#deleteRotationModal').modal('hide');

                    if (res.status == "success") {

                        $('#message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    } else {

                        $('#message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );

                    }

                }

            });

        });

        /*
         * Keep every Rotation modal horizontally centered and near
         * the top of the browser viewport.
         *
         * Existing DataTable, AJAX, CRUD, validation and form logic
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

            var left = Math.max(
                10,
                (windowWidth - dialogWidth) / 2
            );

            $dialog.css({
                position: "fixed",
                left: left + "px",
                top: "20px",
                margin: 0,
                transform: "none"
            });

            // Preserve existing draggable functionality.
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

                    var left = Math.max(
                        10,
                        (windowWidth - dialogWidth) / 2
                    );

                    $dialog.css({
                        left: left + "px",
                        top: "20px"
                    });
                }
            });
        });
    });
</script>