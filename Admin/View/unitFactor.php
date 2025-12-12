<?php
include('session.php');
include('unitheader.php');
require_once("../DB Operations/unitFactorOps.php");
require_once("../Model/unitFactorModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Units Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Unit Factor</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#unitFactorModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="unitFactor_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'>unit Id</th>
                        <th>Unit</th>
                        <th>Unit Factor</th>
                        <th>Unit Factor Description.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $unitFactorList = DBunitFactor::getAllUnitFactor();
                    foreach ($unitFactorList as $unitFactor) {
                        echo "<tr>
                        <td style='display:none'>" . $unitFactor->get_unitId() . "</td>
                        <td>" . $unitFactor->get_unitName() . "</td>
                        <td>" . $unitFactor->get_unitFactor() . "</td>
                        <td>" . $unitFactor->get_unitFactorDescription() . "</td>
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
                            data-toggle='modal' data-target='#editUnitFactorModal' role='button' data-id='" . $unitFactor->get_unitFactorId() . "'> 
                            <i class='fas fa-user-edit'></i>
                                Edit Unit Factor
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' data-target='#deleteSubCategoryModal' name='delete_button' role='button' data-id='" . $unitFactor->get_unitFactorId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Unit Factor
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
<div class="modal fade" id=unitFactorModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data" action="../Controller/unitFactorController.php">
            <div class="modal-content">
                <div class="modal-header">
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
                                <input type="text" name="unitFactor" id="unitFactor" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Factor Description <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitFactorDescription" id="unitFactorDescription" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="createdby" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <div class="modal-header">
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
                                <input type="text" name="unitFactor" id="editedunitFactor" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <input type="hidden" name="unitFactorId" id="unitFactorId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit Factor Description <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="unitFactorDescription" id="editedunitFactorDescription" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="editedcreatedby" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="editedmodifiedby" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Sub Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Subcategory record.
                    </p>
                    <input type="hidden" name="itemsubcatid" id="itemsubcatid" value="">
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
    $(document).ready(function() {

        $('#editUnitFactorModal').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#unitFactorId').val(rowid);

        });
        var dataTable = $('#unitFactor_table').DataTable({

        });

        var nEditing = null;

        $('#unitFactor_table tbody').on('click', 'tr', function() {
            /* Get the row as a parent of the link that was clicked on */
            $('#editunits').val(this.cells[0].innerHTML);
            $('#editedunitFactor').val(this.cells[2].innerHTML);
            $('#editedunitFactorDescription').val(this.cells[3].innerHTML);

        });
        $('#editUnitFactor_form').submit(function(event) {
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: config.developmentPath+
                    "/Admin/Controller/unitFactorController.php",
                data: formData,
                processData: false,
                contentType: false
            }).done(function(data) {
                console.log(data);
            });
            $('#editbutton').dispose();
            event.preventDefault();
        });

        var url = config.developmentPath+ "/Admin/Controller/unitsContoller.php";

        $.getJSON(url, function(data) {
            $.each(data, function(index, value) {
                $('#units').append('<option hidden disabled selected value>-- select an option --</option>');
                $('#units').append('<option value="' + value.unitId + '">' + value
                    .unitName + '</option>');
                $('#editunits').append('<option value="' + value.unitId + '">' + value
                    .unitName + '</option>');
            });
        });
        $('#deleteSubCategoryModal').on('show.bs.modal', function(e) {

            var rowid = $(e.relatedTarget).data('id');
            $('#unitFactorId').val(rowid);
        });
        $('#deletebutton').click(function() {

            $.ajax({
                url:  config.developmentPath+"/Admin/Controller/unitFactorController.php/",
                method: "POST",
                data: {
                    id: $('#itemsubcatid').val(),
                    action: 'delete'
                },
                success: function(data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        });
    });
</script>