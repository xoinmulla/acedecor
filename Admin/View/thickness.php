<?php

include('session.php');
include('thicknessNavigation.php');
require_once("../DB Operations/thicknessOps.php");
require_once("../Model/thicknessModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<style>
    .card-body #thickness_table th {
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
<div class="card shadow mb-4">
    <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Thickness
                </h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#thicknessModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="thickness_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th>Thickness</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $thicknessList = DBthickness::getAllthickness();
                    foreach ($thicknessList as $thickness) {
                        echo "<tr><td>" . $thickness->get_Thickness() . "</td>
                    
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
                            data-target='#editthicknessModal' 
                            role='button' 
                            data-id='" . $thickness->get_ThicknessId() . "'> 
                            <i class='fas fa-user-edit'></i>
                                Edit Thickness
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deletethicknessModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $thickness->get_ThicknessId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Thickness
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


<div class="modal fade" id=thicknessModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="thickness_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="Thickness" id="Thickness" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="Thicknessmodifiedby" id="Thicknessmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="Thicknesscreatedby" id="Thicknesscreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
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
<div class="modal fade" id=editthicknessModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedThickness" id="editedThickness" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name="editedThicknessId" id="editedThicknessId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="editedThicknessmodifiedby" id="editedThicknessmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="editedThicknesscreatedby" id="editedThicknesscreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
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
<div class="modal fade" id=deletethicknessModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Delete Thickness</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Thickness record.
                    </p>
                    <input type="hidden" name="thicknessID" id="thicknessID" value="">
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

        $('#thicknessModal').on('show.bs.modal', function () {
            $('#thicknessModal #form_message').html('');
        });

        $('#editthicknessModal').on('show.bs.modal', function () {
            $('#editthicknessModal #form_message').html('');
        });
        $('#editthicknessModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#editedThicknessId').val(rowid);
        });
        $('#thickness_table').DataTable({
            "processing": true,
            "serverSide": false,
        });

        $('#thickness_form').submit(function (e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/thicknessController.php",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                dataType: "json",

                success: function (res) {

                    if (res.status == "success") {

                        $('#thicknessModal #form_message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    }
                    else {

                        $('#thicknessModal #form_message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );

                    }

                }

            });

        });
        $('#user_form').submit(function (e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/thicknessController.php",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                dataType: "json",

                success: function (res) {

                    if (res.status == "success") {

                        $('#editthicknessModal #form_message').html(

                            `<div class="alert alert-success">${res.message}</div>`

                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    }
                    else {

                        $('#editthicknessModal #form_message').html(

                            `<div class="alert alert-danger">${res.message}</div>`

                        );

                    }

                }

            });

        });

        var nEditing = null;

        $('#thickness_table tbody').on('click', 'tr', function () {
            /* Get the row as a parent of the link that was clicked on */
            $('#editedThickness').val(this.cells[0].innerHTML);
        });


        $('#deletethicknessModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#thicknessID').val(rowid);
        });
        $('#deletebutton').click(function (e) {

            e.preventDefault();

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/thicknessController.php",

                method: "POST",

                dataType: "json",

                data: {

                    id: $('#thicknessID').val(),

                    action: 'delete'

                },

                success: function (res) {

                    $('#deletethicknessModal').modal('hide');

                    if (res.status == "success") {

                        $('#message').html(

                            `<div class="alert alert-success">${res.message}</div>`

                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    }
                    else {

                        $('#message').html(

                            `<div class="alert alert-danger">${res.message}</div>`

                        );

                    }

                }

            });

        });
        /*
         * Keep every Thickness modal horizontally centered and near
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