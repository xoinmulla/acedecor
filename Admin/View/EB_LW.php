
<?php
include('session.php');
include('details.php');
require_once("../DB Operations/EB_LWOps.php");
require_once("../Model/EB_LWModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bolder;">EB-LW</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#EBLWModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="EBLW_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'>EBLW_Id </th>
                        <th>EB_LW</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $EBLWList = DB_EBLW::getAllEBLW();
                    foreach ($EBLWList as $EBLW) {
                        echo "<tr><td style='display:none'>" . $EBLW->getEBLW_Id() . "</td>
                        <td>" . $EBLW->getEB_LW() . "</td>
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
                            data-target='#editEBLWModal' 
                            role='button' 
                            data-id='" . $EBLW->getEBLW_Id() . "'>
                            <i class='fas fa-user-edit'></i> 
                                Edit EB-LW
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteEBLWModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $EBLW->getEBLW_Id() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete EB-LW
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
<div class="modal fade" id=EBLWModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="CLDimension_form" enctype="multipart/form-data" action="../Controller/EB_LWController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add EB-LW</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">EB-LW <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="EBLW" id="EBLW" class="form-control" required  />
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
<div class="modal fade" id=editEBLWModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="EBLW_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit EBLW</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">EB_LW <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedEBLW" id="editedEBLW" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <input type="hidden" name="editedEBLWID" id="editedEBLWID" value="">
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="editedcreatedby" id="editedcreatedby" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="editedmodifiedby" id="editedmodifiedby" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
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
<div class="modal fade" id=deleteEBLWModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Item Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this CLDimension record.
                    </p>
                    <input type="hidden" name="EBLWID" id="EBLWID" value="">
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

        $('#editEBLWModal').on('show.bs.modal', function(e) {
            debugger
            var rowid = $(e.relatedTarget).data('id');
            $('#editedEBLWID').val(rowid);

        });
        var dataTable = $('#EBLW_table').DataTable({

        });

        var nEditing = null;

        $('#EBLW_table tbody').on('click', 'tr', function() {
            debugger;
            /* Get the row as a parent of the link that was clicked on */
            $('#editedEBLWID').val(this.cells[0].innerHTML);
            $('#EBLWID').val(this.cells[0].innerHTML);
            $('#editedEBLW').val(this.cells[1].innerHTML);

        });
        $('#EBLW_form').submit(function(event) {

            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: config.developmentPath+
                    "/Admin/Controller/EB_LWController.php/",
                data: formData,
                processData: false,
                contentType: false
            }).done(function(data) {
                console.log(data);
            });
            $('#editbutton').dispose();
            event.preventDefault();
        });
        
        $('#deleteEBLWModal').on('show.bs.modal', function(e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#EBLWID').val(rowid);
        });

        $('#deletebutton').click(function() {
            $.ajax({
                url: config.developmentPath+"/Admin/Controller/EB_LWController.php/",
                method: "POST",
                data: {
                    id: $('#EBLWID').val(),
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