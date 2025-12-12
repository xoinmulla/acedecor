<?php

include('session.php');
include('thicknessNavigation.php');
require_once("../DB Operations/thicknessOps.php");
require_once("../Model/thicknessModel.php");
?>
<h1 class="h3 mb-4 text-gray-800"></h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Thickness </h6>
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
                <thead>
                    <tr>
                        <th>Thickness</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $thicknessList = DBthickness:: getAllthickness();
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
                            data-id='".$thickness->get_ThicknessId()."'> 
                            <i class='fas fa-user-edit'></i>
                                Edit Thickness
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deletethicknessModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" .$thickness->get_ThicknessId(). "'>
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
        <form method="post" id="thickness_form" enctype="multipart/form-data" action="../Controller/thicknessController.php">
            <div class="modal-content">
                <div class="modal-header">
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
                                <input type="hidden" name="Thicknessmodifiedby" id="Thicknessmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="Thicknesscreatedby" id="Thicknesscreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
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
<div class="modal fade" id=editthicknessModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedThickness" id="editedThickness" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                    <input type="hidden" name="editedThicknessId" id="editedThicknessId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="editedThicknessmodifiedby" id="editedThicknessmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="editedThicknesscreatedby" id="editedThicknesscreatedby" class="form-control"
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#editthicknessModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#editedThicknessId').val(rowid);
    });
    var dataTable = $('#brand_table').DataTable({

    });
    
    var nEditing = null;

    $('#thickness_table tbody').on('click', 'tr', function() {
        /* Get the row as a parent of the link that was clicked on */
        $('#editedThickness').val(this.cells[0].innerHTML);
    });
    $('#editbutton').click(function(event) {
        var formData = {
            ThicknessId: $('#editedThicknessId').val(),
            Thickness: $('#editedThickness').val(),

        };
       
        $.ajax({
            type: "POST",
            url: config.developmentPath+"/Admin/Controller/thicknessController.php/",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
        });
        $('#editbutton').dispose();
        event.preventDefault();
    });

    $('#deletethicknessModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#thicknessID').val(rowid);
    });
    $('#deletebutton').click(function() {
        $.ajax({
            url: config.developmentPath +"/Admin/Controller/thicknessController.php/",
            method: "POST",
            data: {
                id: $('#thicknessID').val(),
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