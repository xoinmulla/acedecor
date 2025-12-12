
<?php
include('session.php');
include('details.php');
require_once("../DB Operations/dimensionsOps.php");
require_once("../Model/dimensionsModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Dimensions</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#dimensionsModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dimensions_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Dimension Name</th>
                        <th>Dimension Description.</th>
                        <th>Length.</th>
                        <th>Breadth.</th>
                        <th>thickness.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dimensionList = DBdimension::getAlldimension();
                    foreach ($dimensionList as $dimension) {
                        echo "<tr><td>" . $dimension->get_dimensionName() . "</td>
                        <td>" . $dimension->get_dimensionDescription() . "</td>
                        <td>" . $dimension->get_length() . "</td>
                        <td>" . $dimension->get_breadth() . "</td>
                        <td>" . $dimension->get_thickness() . "</td>
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
                            data-target='#editdimensionModal' 
                            role='button' 
                            data-id='" . $dimension->get_dimensionId() . "'>
                            <i class='fas fa-user-edit'></i> 
                                Edit Dimension
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteCategoryModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $dimension->get_dimensionId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Dimension
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
<div class="modal fade" id=dimensionsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="dimension_form" enctype="multipart/form-data" action="../Controller/dimensionsContoller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Dimensions</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Dimension Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="dimensionName" id="dimensionName" class="form-control" required  />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
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
<div class="modal fade" id=editdimensionModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="editeddimension_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Dimensions</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Dimension Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="dimensionName" id="editeddimensionName" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <input type="hidden" name="dimensionId" id="dimensionId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
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
<div class="modal fade" id=deletedimensionsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#editdimensionModal').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#dimensionId').val(rowid);

        });
        var dataTable = $('#dimensions_table').DataTable({

        });

        var nEditing = null;

        $('#dimensions_table tbody').on('click', 'tr', function() {
            /* Get the row as a parent of the link that was clicked on */
            $('#editeddimensionName').val(this.cells[0].innerHTML);
            $('#editeddimensionDescription').val(this.cells[1].innerHTML);
            $('#editedlength').val(this.cells[2].innerHTML);
            $('#editedbreadth').val(this.cells[3].innerHTML);
            $('#editedthickness').val(this.cells[4].innerHTML);

        });
        $('#editeddimension_form').submit(function(event) {

            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: config.developmentPath+
                    "/Admin/Controller/dimensionsContoller.php/",
                data: formData,
                processData: false,
                contentType: false
            }).done(function(data) {
                console.log(data);
            });
            $('#editbutton').dispose();
            event.preventDefault();
        });
        $('#deletedimensionsModal').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#itemcatid').val(rowid);
        });
        $('#deletebutton').click(function() {
            $.ajax({
                url: config.developmentPath+"/Admin/Controller/dimensionsContoller.php/",
                method: "POST",
                data: {
                    id: $('#itemcatid').val(),
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