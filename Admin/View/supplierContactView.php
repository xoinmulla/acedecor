
<?php
include('session.php');
include('channelpartnerheader.php');
require_once "../DB Operations/supplierContactOps.php";
require_once("../Model/supplierContactModel.php");
$id=$_GET['id'];
?>
<h1 class="h3 mb-4 text-gray-800"> Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Supplier Contact</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#addContactModal data-id='<?php echo $id;?>'>
                    <button type="button"  class="btn btn-success btn-circle btn-sm" ><i
                            class="fas fa-plus" ></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="contact_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>Supplier</th>    
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th style="display:none">supplierId</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contactlist =  DBsupplierContact::getAllContact($id);
                    foreach ($contactlist as $contact) {
                        echo "<tr>
                        <td>" . $contact->getSupplier() . "</td>
                        <td>" . $contact->getName() . "</td>
                        <td>" . $contact->getDesignation() . "</td>
                        <td>" . $contact->getPhone() . "</td>
                        <td>" . $contact->getEmail() . "</td>
                        <td style='display:none'>" . $contact->getSupplierId() . "</td>
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
                            data-target='#editContactModal' 
                            role='button' 
                            data-id='".$contact->getContactId()."'>
                            <i class='fas fa-user-edit'></i> 
                                Edit Contact
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteContactModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $contact->getContactId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Contact
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
<div class="modal fade" id=addContactModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="POST" id="itemcompdetails_form" enctype="multipart/form-data"
            action="../Controller/supplierContactController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                                         
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="contactName" id="contactName" class="form-control"
                                        required  />
                                    <input type="hidden" name="supplierId" id="supplierId" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Desgination <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="contactDesignation" id="contactDesignation"
                                        class="form-control" required  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Phone<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" 
                                    name="phone" 
                                    id="phone" 
                                    class="form-control"
                                    maxlength="10"
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Email<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" name="email" id="email" class="form-control"
                                        />
                                </div>
                            </div>
                        </div>
                   
                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails CreatedBy <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompcreatedby" id="itemcompcreatedby" class="form-control"
                                    required value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails Modified By <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompmodifiedby" id="itemcompmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
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
        </form>
    </div>
</div>
<div class="modal fade" id=editContactModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="POST" id="itemcompdetails_form" enctype="multipart/form-data"
            action="../Controller/supplierContactController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                                         
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="contactName" id="editedcontactName" class="form-control"
                                        required  />
                                    <input type="hidden" name="contactId" id="contactId" value="">
                                    <input type="hidden" name="supplierId" id="editedsupplierId" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Desgination <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="contactDesignation" id="editedcontactDesignation"
                                        class="form-control" required  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Phone<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" 
                                    name="phone" 
                                    id="editedphone" 
                                    class="form-control"
                                    maxlength="10"
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Email<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" name="email" id="editedemail" class="form-control"
                                        />
                                </div>
                            </div>
                        </div>
                   
                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails CreatedBy <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompcreatedby" id="itemcompcreatedby" class="form-control"
                                    required value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails Modified By <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompmodifiedby" id="itemcompmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
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
        </form>
    </div>
</div>
<div class="modal fade" id=deleteContactModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this contact record.
                    </p>
                    <input type="hidden" name="conId" id="conId" value="">
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
    $(document).ready(function(){
        var dataTable = $('#contact_table').DataTable({

});
$('#addContactModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#supplierId').val(rowid);
    });
    $('#editContactModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#contactId').val(rowid);
     
        
    });
$('#deleteContactModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#conId').val(rowid);
    });
    $('#contact_table tbody').on('click', 'tr', function() {
            /* Get the row as a parent of the link that was clicked on */
            $('#editedcontactName').val(this.cells[1].innerHTML);
            $('#editedcontactDesignation').val(this.cells[2].innerHTML);
            $('#editedphone').val(this.cells[3].innerHTML);
            $('#editedemail').val(this.cells[4].innerHTML);
            $('#editedsupplierId').val(this.cells[5].innerHTML);
        });
    $('#deletebutton').click(function() {
        $.ajax({
            url:  config.developmentPath+"/Admin/Controller/supplierContactController.php/",
            method: "POST",
            data: {
                id: $('#conId').val(),
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