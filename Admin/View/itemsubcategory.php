<?php
include('session.php');
include('itemcategoryNavigation.php');
require_once("../DB Operations/item_subcategoryOps.php");
require_once("../Model/item_subcategorymodel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Item SubCategory</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#itemsubcatModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="itemsubcat_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'>Category Id</th>
                        <th>Item Category</th>
                        <th>Item SubCategory</th>
                        <th>Item SubCategory Description.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $itemsubcatlist = DBitemsubcategory::getallitemsubcategory();
                    foreach ($itemsubcatlist as $itemsubcat) {
                        echo "<tr>
                        <td style='display:none'>" . $itemsubcat->get_itemcatid() . "</td>
                        <td>" . $itemsubcat->get_categoryName() . "</td>
                        <td>" . $itemsubcat->get_itemsubcatname() . "</td>
                        <td>" . $itemsubcat->get_itemsubcatdescription() . "</td>
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
                            data-target='#edititemsubcatModal' 
                            role='button' 
                            data-id='" . $itemsubcat->get_itemsubcatid() . "'>
                            <i class='fas fa-user-edit'></i> 
                                Edit SubCategory
                           </button>
                           <button class='btn btn-danger dropdown-item'
                            data-toggle='modal'
                            data-target='#deleteSubCategoryModal'
                            role='button'
                            data-id='" . $itemsubcat->get_itemsubcatid() . "'>
                            <i class='fas fa-trash-alt'></i>
                                Delete SubCategory
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
<div class="modal fade" id=itemsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="itemcatid" class="form-select" required name="itemcatid">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SubCategory Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatname" id="itemsubcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SubCategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatdescription" id="itemsubcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatcreatedby" id="itemsubcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatmodifiedby" id="itemsubcatmodifiedby"
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=edititemsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="itemsubcat_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="edititemCategory" class="form-select" required name="itemcatid">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SubCategory Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatname" id="editeditemsubcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name="itemsubcatid" id="itemsubcatid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SubCategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatdescription" id="editeditemsubcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatcreatedby" id="editeditemsubcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatmodifiedby" id="editeditemsubcatmodifiedby"
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
    $(document).ready(function () {

        $('#edititemsubcatModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#itemsubcatid').val(rowid);

        });
        var dataTable = $('#itemsubcat_table').DataTable({

        });

        var nEditing = null;

        $('#itemsubcat_table tbody').on('click', 'tr', function () {
            /* Get the row as a parent of the link that was clicked on */
            $('#edititemCategory').val(this.cells[0].innerHTML);
            $('#editeditemsubcatname').val(this.cells[2].innerHTML);
            $('#editeditemsubcatdescription').val(this.cells[3].innerHTML);

        });
        $('#editbutton').click(function (event) {
            var formData = {
                itemcatid: $('#edititemCategory').val(),
                itemsubcatid: $('#itemsubcatid').val(),
                itemsubcatname: $('#editeditemsubcatname').val(),
                itemsubcatdescription: $('#editeditemsubcatdescription').val(),
                itemsubcatcreatedby: $('#editeditemsubcatcreatedby').val(),
                itemsubcatmodifiedby: $('#editeditemsubcatmodifiedby').val(),
            };

            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/item_subcategorycontroller.php",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data);
            });
            $('#editbutton').dispose();
            event.preventDefault();
        });

        var url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";

        $.getJSON(url, function (data) {
            $('#itemcatid').append('<option hidden disabled selected value="">-- select an option --</option>');
            $.each(data, function (index, value) {
                debugger;
                $('#itemcatid').append('<option value="' + value.itemcatid + '">' + value
                    .itemcatname + '</option>');
                $('#edititemCategory').append('<option value="' + value.itemcatid + '">' + value
                    .itemcatname + '</option>');
            });
        });
        $('#deleteSubCategoryModal').on('show.bs.modal', function (e) {

            var rowid = $(e.relatedTarget).data('id');
            $('#itemsubcatid').val(rowid);
        });
        $('#deletebutton').click(function () {

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php",
                method: "POST",
                data: {
                    id: $('#itemsubcatid').val(),
                    action: 'delete'
                },
                success: function (data) {
                    $('#message').html(data);
                    // dataTable.ajax.reload();
                    setTimeout(function () {
                        $('#message').html('');
                    }, 5000);
                }
            });
        });
        // ADD SUBCATEGORY FORM SUBMIT
        $('#user_form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php",
                data: formData,
                processData: false,
                contentType: false,

                success: function (res) {
                    let json;

                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        console.log("Invalid JSON:", res);
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {

                        // SUCCESS MESSAGE
                        $('#form_message').html(
                            '<div class="alert alert-success">SubCategory added successfully!</div>'
                        );

                        setTimeout(() => {
                            // Close modal
                            $('#itemsubcatModal').modal('hide');

                            // Remove backdrop
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // Reset form fields
                            $('#user_form')[0].reset();

                            // Reload table (if required)
                            // dataTable.ajax.reload();

                        }, 600);

                    } else {
                        $('#form_message').html(
                            `<div class="alert alert-danger">${json.message || 'Error adding subcategory.'}</div>`
                        );
                    }
                },

                error: function (xhr, status, error) {
                    $('#form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });

        });

    });
</script>