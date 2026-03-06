<?php
include('session.php');
require_once("../DB Operations/taxOps.php");
require_once("../Model/taxmodel.php");
require_once("../Utilities/permissionHelper.php");



include('details.php');
 
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Tax Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bolder;">Tax List
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
                <thead>
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
                        <td>" . $tax->get_GST() . "</td>
                        <td>" . $tax->get_SGST() . "</td>
                        <td>" . $tax->get_CGST() . "</td>
                        <td>" . $tax->get_IGST() . "</td>
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
        <form method="post" id="tax_form" action="../Controller/taxController.php">
            <div class="modal-content">
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="edittaxModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="editedtax_form">
            <div class="modal-content">
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deleteTaxModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#edittaxModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#editedTaxId').val(rowid);

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
        $('#addTax').click(function () {
            debugger;
            var IGST = $('#IGST').val();
            if (IGST != "") {
                $('#GST').val($('#IGST').val());
            } else {
                $('#GST').val(parseInt($('#SGST').val()) + parseInt($('#SGST').val()));

            }
        });

        $('#editTax').click(function () {
            var IGST = $('#editedIGST').val();
            if (IGST != "") {
                $('#editedGST').val($('#editedIGST').val());
            } else {
                $('#editedGST').val(parseInt($('#editedSGST').val()) + parseInt($('#editedSGST').val()));
            }
        });
        $('#editedtax_form').submit(function (event) {
            var urldata = config.developmentPath + "/Admin/Controller/taxController.php";
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: urldata,
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                console.log(data);
            }).error(function (e) {
                console.log(e)
            });
            $('#editbutton').dispose();
            event.preventDefault();
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
                data: {
                    id: $('#taxid').val(),
                    action: 'delete'
                },
                success: function (response) {
                    $('#deleteTaxModal').modal('hide');
                    location.reload(); // simple and reliable
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
    });
</script>