
<?php
include('session.php');
include('subcategory.php');
require_once("../DB Operations/product_subcategoryOps.php");
require_once("../Model/product_subcategorymodel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Product Sub Category</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#productsubcatModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="productsubcat_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Product SubCategory</th>
                        <th>Product SubCategory Description.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $productsubcatlist = DBproductsubcategory::getallproductsubcategory();
                    foreach ($productsubcatlist as $product) {
                        echo "<tr><td>" . $product->get_productsubcatname() . "</td>
                        <td>" . $product->get_productsubcatdescription() . "</td>
                        <td><a class='btn btn-secondary btn-circle btn-sm tooltip action-btn' data-toggle='modal' data-target='#editproductsubcatModal' role='button' data-id='".$product->get_productsubcatid()."'> <i class='fas fa-user-edit'></i> </a>
                       "."</td></tr>
                    </span></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=productsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data"
            action="../Controller/product_subcategorycontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="productcatid" class="form-select" required name="productcatid">
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <label class="col-md-4 text-right">Product SubCategory Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productsubcatname" id="productsubcatname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product SubCategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productsubcatdescription" id="productsubcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="productsubcatcreatedby" id="productsubcatcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="productsubcatmodifiedby" id="productsubcatmodifiedby"
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
<div class="modal fade" id=editproductsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="productsubcat_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                    <div class="row">
                            <label class="col-md-4 text-right">Product Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="editedproductcatid" class="form-select" required name="editedproductcatid">

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-4 text-right">Product SubCategory Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productsubcatname" id="editedproductsubcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name="productsubcatid" id="editedproductsubcatid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product SubCategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productsubcatdescription" id="editedproductsubcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="productsubcatcreatedby" id="editedproductsubcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="productsubcatmodifiedby" id="editedproductsubcatmodifiedby"
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
<div class="modal fade" id=deleteproductsubcategoryModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Product Sub Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this product sub category record.
                    </p>
                    <input type="hidden" name="productsubcatid" id="productsubcatid" value="">
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

    $('#editproductsubcatModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#productsubcatid').val(rowid);

    });
    var dataTable = $('#productsubcat_table').DataTable({

    });

    var nEditing = null;

    $('#productsubcat_table tbody').on('click', 'tr', function() {
        /* Get the row as a parent of the link that was clicked on */
        $('#editedproductsubcatname').val(this.cells[0].innerHTML);
        $('#editedproductsubcatdescription').val(this.cells[1].innerHTML);

        $('#editproductsubcatModal').show();

    });
    $('#editbutton').click(function(event) {
        var formData = {
            productcatid: $('#productcatid').val(),
            productsubcatid: $('#productsubcatid').val(),
            productsubcatname: $('#editedproductsubcatname').val(),
            productsubcatdescription: $('#editedproductsubcatdescription').val(),
            productsubcatcreatedby: $('#editedproductsubcatcreatedby').val(),
            productsubcatmodifiedby: $('#editedproductsubcatmodifiedby').val(),
        };

        $.ajax({
            type: "POST",
            url: config.developmentPath+
                "/Admin/Controller/product_subcategorycontroller.php/",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
        });
        $('#editbutton').dispose();
        event.preventDefault();
    });

    var url = config.developmentPath+ "/Admin/Controller/product_categorycontroller.php";

$.getJSON(url, function(data) {
    $.each(data, function(index, value) {
        $('#productcatid').append('<option hidden disabled selected value>-- select an option --</option>');
        $('#productcatid').append('<option value="' + value.productcatid + '">' + value
            .productcatname + '</option>');
        $('#editedproductcatid').append('<option value="' + value.productcatid + '">' + value
            .productcatname + '</option>');
    });
});

    $('#deleteproductsubcategoryModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#productsubcatid').val(rowid);
    });
    $('#deletebutton').click(function() {
        $.ajax({
            url:  config.developmentPath+"/Admin/Controller/product_subcategorycontroller.php/",
            method: "POST",
            data: {
                id: $('#productsubcatid').val(),
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