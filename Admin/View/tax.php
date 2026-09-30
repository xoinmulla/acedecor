<?php
include('session.php');
require_once("../DB Operations/taxOps.php");
require_once("../Model/taxmodel.php");
require_once("../Utilities/permissionHelper.php");



include('details.php');

?>


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<style>
    /* Keep existing modal size, but position it relative to the viewport */
    .modal-dialog {
        max-width: 400px;
        width: 75%;
        margin: 0 !important;
    }

    .modal-dialog.modal-positioned {
        position: fixed !important;
        margin: 0 !important;
        transform: none !important;
        z-index: 1051;
    }

    /* Small-screen safety without changing the existing page layout */
    @media (max-width: 767.98px) {
        .modal-dialog {
            width: calc(100% - 20px) !important;
            max-width: calc(100% - 20px) !important;
        }
    }
    .card-body #tax_table th {
        font-weight: 500;
    }
</style>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">GST List
                </h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#taxModal>
                    <?php if (hasPermission('tax', 'write')): ?>
                        <button type="button" name="add_tax" id="add_tax" class="btn btn-success btn-circle btn-sm"><i
                                class="fas fa-plus"></i></button>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tax_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th>GST %</th>
                        <th>SGST %</th>
                        <th>CGST %</th>
                        <th>IGST %</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $taxlist = DBtax::getAll();
                    foreach ($taxlist as $tax) {
                        echo "<tr>
                        <td align='center'>" . $tax->get_GST() . "</td>
                        <td align='center'>" . $tax->get_SGST() . "</td>
                        <td align='center'>" . $tax->get_CGST() . "</td>
                        <td align='center'>" . $tax->get_IGST() . "</td>
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
                            data-target='#edittaxModal' 
                            role='button' data-id='" . $tax->get_taxid() . "'> 
                            <i class='fas fa-user-edit'></i>
                                Edit Tax
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteTaxModal' 
                           role='button' 
                           data-id='" . $tax->get_taxid() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Tax
                          </button>
                        </div>
                    </div>
                    </td>
                    </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>
<div id="taxModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="tax_form">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <label>SGST</label>
                        <input type="number" name="SGST" id="SGST" class="form-control" />
                        <input type="hidden" name="GST" id="GST">
                    </div>
                    <div class="form-group">
                        <label>CGST</label>
                        <input type="number" name="CGST" id="CGST" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>IGST</label>
                        <input type="number" name="IGST" id="IGST" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addTax" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="edittaxModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="editedtax_form">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <label>SGST</label>
                        <input type="text" name="SGST" id="editedSGST" class="form-control" />
                        <input type="hidden" name="tax_id" id="editedTaxId" class="form-control">
                        <input type="hidden" name="GST" id="editedGST" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>CGST</label>
                        <input type="text" name="CGST" id="editedCGST" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>IGST</label>
                        <input type="text" name="IGST" id="editedIGST" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="editTax" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deleteTaxModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this tax record.
                    </p>
                    <input type="hidden" name="taxid" id="taxid" value="">
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
        $('#taxModal').on('show.bs.modal', function () {

            $('#taxModal #form_message').html('');

        });
        $('#edittaxModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#editedTaxId').val(rowid);
            $('#edittaxModal #form_message').html('');

            handleTaxFields($('#editedSGST'), $('#editedCGST'), $('#editedIGST'));

        });
        $('#tax_table').DataTable({
            "processing": true,
            "serverSide": false,
        });

        $('#tax_table tbody').on('click', 'tr', function () {
            /* Get the row as a parent of the link that was clicked on */
            $('#editedGST').val(this.cells[0].innerHTML);
            $('#editedSGST').val(this.cells[1].innerHTML);
            $('#editedCGST').val(this.cells[2].innerHTML);
            $('#editedIGST').val(this.cells[3].innerHTML);

            handleTaxFields($('#editedSGST'), $('#editedCGST'), $('#editedIGST'));

        });
        $('#tax_form').submit(function (e) {

            e.preventDefault();

            if ($('#IGST').val() != "") {
                $('#GST').val($('#IGST').val());
            } else {
                $('#GST').val(
                    parseFloat($('#SGST').val() || 0) +
                    parseFloat($('#CGST').val() || 0)
                );
            }

            let formData = new FormData(this);

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/taxController.php",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                dataType: "json",

                success: function (res) {

                    if (res.status == "success") {

                        $('#taxModal #form_message').html(
                            `<div class="alert alert-success">${res.message}</div>`
                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    } else {

                        $('#taxModal #form_message').html(
                            `<div class="alert alert-danger">${res.message}</div>`
                        );

                    }

                }

            });

        });

        $('#editedtax_form').submit(function (e) {

            e.preventDefault();

            if ($('#editedIGST').val() != "") {

                $('#editedGST').val($('#editedIGST').val());

            } else {

                $('#editedGST').val(

                    parseFloat($('#editedSGST').val() || 0) +

                    parseFloat($('#editedCGST').val() || 0)

                );

            }

            let formData = new FormData(this);

            $.ajax({

                url: config.developmentPath + "/Admin/Controller/taxController.php",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                dataType: "json",

                success: function (res) {

                    if (res.status == "success") {

                        $('#edittaxModal #form_message').html(

                            `<div class="alert alert-success">${res.message}</div>`

                        );

                        setTimeout(function () {

                            location.reload();

                        }, 1500);

                    }

                    else {

                        $('#edittaxModal #form_message').html(

                            `<div class="alert alert-danger">${res.message}</div>`

                        );

                    }

                }

            });

        });
        $('#deleteTaxModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#taxid').val(rowid);   // ✅ Correct field
        });
        $('#deletebutton').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/taxController.php",
                method: "POST",
                dataType: "json",
                data: {
                    id: $('#taxid').val(),
                    action: 'delete'
                },
                success: function (res) {

                    $('#deleteTaxModal').modal('hide');

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
        $('#SGST, #CGST, #IGST').on('input', function () {
            handleTaxFields($('#SGST'), $('#CGST'), $('#IGST'));
        });
        $('#editedSGST, #editedCGST, #editedIGST').on('input', function () {
            handleTaxFields($('#editedSGST'), $('#editedCGST'), $('#editedIGST'));
        });
        function handleTaxFields(SGST, CGST, IGST) {

            SGST.prop('disabled', false);
            CGST.prop('disabled', false);
            IGST.prop('disabled', false);

            var sgstVal = SGST.val().trim();
            var cgstVal = CGST.val().trim();
            var igstVal = IGST.val().trim();

            if (igstVal !== "") {
                SGST.prop('disabled', true);
                CGST.prop('disabled', true);
                return;
            }

            if (sgstVal !== "" && cgstVal !== "") {
                IGST.prop('disabled', true);
            }
        }

        /*
         * Keep every Tax modal centered horizontally and near the top
         * of the browser viewport.
         *
         * Existing CRUD, AJAX, validation and tax calculation logic
         * is intentionally untouched.
         */
        $('.modal').on('shown.bs.modal', function () {

            var $dialog = $(this).find('.modal-dialog');

            if ($dialog.hasClass("ui-draggable")) {
                $dialog.draggable("destroy");
            }

            $dialog.addClass('modal-positioned');

            // Calculate horizontal center from the viewport.
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

            // Preserve the existing draggable modal behavior.
            $dialog.draggable({
                handle: ".modal-header",
                containment: "window",
                scroll: false
            });
        });

        // Re-center an open modal when the viewport is resized.
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