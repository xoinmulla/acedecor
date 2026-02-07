<?php
include('session.php');
include('enquirynavigation.php');
require_once("../DB Operations/enq_categoryOps.php");
require_once("../Model/enq_categorymodel.php");
?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $_SESSION['error'];
        unset($_SESSION['error']); ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<h1 class="h3 mb-4 text-gray-800">Enquiry Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Enquiry Category</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#enqcatModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="itemcat_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $enqcatlist = DBcategory::selectAllForDisplay();

                    foreach ($enqcatlist as $enqcat) {

                        // 🔒 check if category is used in enquiry
                        $isUsed = DBcategory::isCategoryUsed($enqcat->get_catid());

                        echo "<tr>
        <td>{$enqcat->get_catname()}</td>
        <td>{$enqcat->get_catType()}</td>
        <td>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle'
                    type='button'
                    data-toggle='dropdown'
                    aria-expanded='false'>
                    Actions
                </button>
                <div class='dropdown-menu'>

                    <button class='btn btn-primary dropdown-item'
                        data-toggle='modal'
                        data-target='#editEnqcatModal'
                        data-id='{$enqcat->get_catid()}'
                        data-type='{$enqcat->get_catType()}'>
                        <i class='fas fa-user-edit'></i> Edit Category
                    </button>";

                        // 🔥 DELETE BUTTON CONDITION
                        if ($isUsed) {
                            echo "
                    <button class='btn btn-secondary dropdown-item' disabled
                        title='Category is already used in enquiries'>
                        <i class='fas fa-lock'></i> Delete Disabled
                    </button>";
                        } else {
                            echo "
                    <button class='btn btn-danger dropdown-item'
                        data-toggle='modal'
                        data-target='#confirmModal'
                        data-id='{$enqcat->get_catid()}'>
                        <i class='fas fa-trash-alt'></i> Delete Category
                    </button>";
                        }

                        echo "
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
<?php include('footer.php'); ?>
<div class="modal fade" id=enqcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data"
            action="../Controller/enqcategoryController.php">
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
                                <input type="text" name="catname" id="catname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <!-- Category Type (Add modal) -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Type <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend">
                                    <button type="button" id="enqcatTypeButton" class="btn btn-secondary">
                                        Select Category Type
                                    </button>
                                    <button type="button"
                                        class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropright</span>
                                    </button>
                                    <ul class="dropdown-menu" id="enqcatTypeDropdown">
                                        <li><a class="dropdown-item enqcat-type-item" href="#"
                                                data-value="Design">Design</a></li>
                                        <li><a class="dropdown-item enqcat-type-item" href="#"
                                                data-value="Enquiry Category">Enquiry</a></li>
                                    </ul>

                                </div>
                                <!-- hidden input submitted with form -->
                                <input type="hidden" name="category_type" id="category_type" value="Enquiry Category" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="catcreatedby" id="catcreatedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcatmodifiedby" id="itemcatmodifiedby"
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
<div class="modal fade" id=editEnqcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data"
            action="../Controller/enqcategoryController.php">
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
                                <input type="text" name="catname" id="editedcatname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name=enqcatId id="editedenqcatId" />
                            </div>
                        </div>
                    </div>

                    <!-- Category Type (Edit modal) -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Type <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend">
                                    <button type="button" id="editedEnqcatTypeButton" class="btn btn-secondary">
                                        Select Category Type
                                    </button>
                                    <button type="button"
                                        class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropright</span>
                                    </button>
                                    <ul class="dropdown-menu" id="editedEnqcatTypeDropdown">
                                        <li><a class="dropdown-item edited-enqcat-type-item" href="#"
                                                data-value="Design">Design</a></li>
                                        <li><a class="dropdown-item edited-enqcat-type-item" href="#"
                                                data-value="Enquiry Category">Enquiry</a></li>
                                    </ul>
                                </div>
                                <!-- hidden input submitted with edit form -->
                                <input type="hidden" name="category_type" id="edited_category_type"
                                    value="Enquiry Category" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="catcreatedby" id="catcreatedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcatmodifiedby" id="itemcatmodifiedby"
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
<div class="modal fade" id="confirmModal" tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Enquiry Category</h4>
                    <button type="button" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Enquiry Category.
                    </p>
                    <input type="hidden" name="enqcatId" id="enqcatId" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="deleteLineItembutton" class="btn btn-danger"
                        value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#confirmModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#enqcatId').val(rowid);
        });
        $('#editEnqcatModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#editedenqcatId').val(rowid);

        });

        $('#editItemcatModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#itemcatid').val(rowid);

        });
        var dataTable = $('#itemcat_table').DataTable({

        });

        var nEditing = null;

        $('#itemcat_table tbody').on('click', 'tr', function () {
            /* Get the row as a parent of the link that was clicked on */

            $('#editedcatname').val(this.cells[0].innerHTML);

        });
        $('#editbutton').click(function (event) {
            var formData = {
                itemcatid: $('#itemcatid').val(),
                itemcatname: $('#editedItemcatname').val(),
                itemcatdescription: $('#editedItemcatdescription').val(),
                itemcatcreatedby: $('#editedItemcatcreatedby').val(),
                itemcatmodifiedby: $('#editedItemcatmodifiedby').val(),
            };

            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php/",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data);
            });
            $('#editbutton').dispose();
            event.preventDefault();
        });
        $('#deleteCategoryModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#itemcatid').val(rowid);
        });
        $('#delete_form').submit(function () {
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/enqcategoryController.php/",
                method: "POST",
                data: {
                    id: $('#enqcatId').val(),
                    action: 'delete'
                },
                success: function (data) {
                    $('#message').html(data);
                    setTimeout(function () {
                        $('#message').html('');
                    }, 5000);
                }
            });
        });

        // Category Type dropdown handling (Add modal)
        $('#enqcatTypeDropdown').on('click', '.enqcat-type-item', function (e) {
            e.preventDefault();
            var val = $(this).data('value');
            $('#category_type').val(val);
            $('#enqcatTypeButton').text(val);
        });

        // Category Type dropdown handling (Edit modal)
        $('#editedEnqcatTypeDropdown').on('click', '.edited-enqcat-type-item', function (e) {
            e.preventDefault();
            var val = $(this).data('value');
            $('#edited_category_type').val(val);
            $('#editedEnqcatTypeButton').text(val);
        });

        // Prefill logic when edit modal opens
        $('#editEnqcatModal').on('show.bs.modal', function (e) {
            // Try to read data-type from the element that triggered the modal (if present)
            var trigger = $(e.relatedTarget); // the button that opened the modal
            var existingType = trigger.data('type'); // expected like data-type="Design" or "Enquiry Category"

            if (existingType !== undefined && existingType !== '') {
                $('#edited_category_type').val(existingType);
                $('#editedEnqcatTypeButton').text(existingType);
            } else {
                // fallback default
                var fallback = 'Enquiry Category';
                $('#edited_category_type').val(fallback);
                $('#editedEnqcatTypeButton').text(fallback);
            }
        });

        // Optional: set default text on modal show for Add modal
        $('#enqcatModal').on('show.bs.modal', function () {
            var current = $('#category_type').val() || 'Enquiry Category';
            $('#enqcatTypeButton').text(current);
        });

    });
</script>