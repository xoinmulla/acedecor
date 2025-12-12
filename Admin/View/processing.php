<?php
include('session.php');
include('details.php');
require_once("../DB Operations/ProcessingOps.php");
require_once("../Model/ProcessingModel.php");
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Processing Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Processing List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#ProcessingModal>
                    <button type="button" name="add_Processing" id="add_Processing" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="Processing_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style=display:none>Processing Id</th>
                        <th>Processing</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $ProcessingList = DBProcessing::getAllProcessing();
                    foreach ($ProcessingList as $Processing) {
                    echo "<tr>
                    <td style=display:none> " . $Processing->getProcessingId() . " </td>
                        <td>" . $Processing->getProcessing() . "</td>
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
                            data-target='#editProcessingModal' 
                            role='button' data-id='" . $Processing->getProcessingid() . "'> 
                            <i class='fas fa-user-edit'></i>
                                Edit Processing
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteProcessingModal' 
                           role='button' 
                           data-id='" . $Processing->getProcessingid() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Processing
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
<div id="ProcessingModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="Processing_form" action="../Controller/ProcessingController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <label>Processing</label>
                        <input type="text" name="ProcessingName" id="ProcessingName" class="form-control"  />
                    </div>
                    
                    <div class="form-group">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                    value=<?php echo $_SESSION['login_user']; ?> />
                    </div>

                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addProcessing" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="editProcessingModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="editedProcessing_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <label>Processing</label>
                        <input type="text" name="ProcessingName" id="editedProcessingName" class="form-control"  />
                        <input type="hidden" id="editedProcessingId" name="editedProcessingId" value="">
                    </div>
                   
                    <div class="form-group">
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                    value=<?php echo $_SESSION['login_user']; ?> />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="editProcessing" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteProcessingModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Processing record.
                    </p>
                    <input type="hidden" name="Processingid" id="Processingid" value="">
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
        $('#editProcessingModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');

        $('#editedProcessingId').val(rowid);
    });
    var dataTable = $('#Processing_table').DataTable({

});

    $('#Processing_table tbody').on( 'click', 'tr', function () {
        /* Get the row as a parent of the link that was clicked on */
        $('#editedProcessingId').val(this.cells[1].innerHTML);  
        $('#editedProcessingName').val(this.cells[1].innerHTML);      
    });
   
    $('#editedProcessing_form').submit(function(event){
var urldata= config.developmentPath+"/Admin/Controller/ProcessingController.php";
        var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: urldata,
                data: formData,
                processData: false,
                contentType: false
            }).done(function(data) {
                console.log(data);
            }).error(function(e){
                console.log(e)
            });
            $('#editbutton').dispose();
            event.preventDefault();
    });
    $('#deleteProcessingModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#editedProcessingId').val(rowid);
    });
    $('#deletebutton').click(function() {
        $.ajax({
            url:  config.developmentPath+"/Admin/Controller/Processingcontroller.php/",
            method: "POST",
            data: {
                id: $('#editedProcessingId').val(),
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