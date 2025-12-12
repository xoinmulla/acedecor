<?php
include "session.php";
include('header.php');
require_once("../dblayer/categoryOps.php");
require_once("../model/categoryModel.php");
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Category</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle="modal" data-target="#itemcatModal">
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="message"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="itemcat_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Has Subcategory</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $itemcatlist = DBCategory::getAllCategory();
                    foreach ($itemcatlist as $itemcat) {
                        $id = $itemcat->getCategoryId();
                        // escape for attributes
                        $name_attr = htmlspecialchars($itemcat->getCategoryName(), ENT_QUOTES);
                        $desc_attr = htmlspecialchars($itemcat->getCategoryDescription(), ENT_QUOTES);
                        echo "<tr data-id='{$id}'>
                                <td>{$itemcat->getCategoryName()}</td>
                                <td>{$itemcat->getCategoryDescription()}</td>
                                <td>". $itemcat->getHasSubcategory() ."</td>
                                <td>
                                    <div class='dropdown'>
                                        <button class='btn btn-secondary dropdown-toggle' 
                                                type='button' 
                                                id='dropdownMenu2' 
                                                data-toggle='dropdown' 
                                                aria-expanded='false'>
                                            Actions
                                        </button>
                                        <div class='dropdown-menu' aria-labelledby='dropdownMenu2'>
                                            <button class='btn btn-primary dropdown-item'
                                                    data-toggle='modal' 
                                                    data-target='#editItemcatModal' 
                                                    type='button'
                                                    data-id='{$id}'
                                                    data-name='{$name_attr}'
                                                    data-description='{$desc_attr}'>
                                                <i class='fas fa-user-edit'></i> Edit Category
                                            </button>
                                            <button class='btn btn-danger dropdown-item'
                                                    data-toggle='modal' 
                                                    data-target='#deleteCategoryModal' 
                                                    type='button'
                                                    data-id='{$id}'>
                                                <i class='fas fa-trash-alt'></i> Delete Category
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
<?php include('footer.php'); ?>

<!-- Add Modal (unchanged other than fixing + sign earlier) -->
<div class="modal fade" id="itemcatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="user_form" action="../controller/categoryController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatname" id="itemcatname" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <textarea name="itemcatdescription" id="itemcatdescription" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="itemcatcreatedby" id="itemcatcreatedby" value="<?php echo $_SESSION['login_user']; ?>" />
                    <input type="hidden" name="itemcatmodifiedby" id="itemcatmodifiedby" value="<?php echo $_SESSION['login_user']; ?>" />

                    <div class="modal-footer">
                        <input type="hidden" name="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editItemcatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- submit via AJAX -->
        <form method="post" id="itemcat_form" action="../controller/categoryController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message_edit"></span>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatname" id="editedItemcatname" class="form-control" required />
                                <input type="hidden" name="itemcatid" id="edit_itemcatid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <textarea name="itemcatdescription" id="editedItemcatdescription" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="itemcatcreatedby" id="editedItemcatcreatedby" value="<?php echo $_SESSION['login_user']; ?>" />
                    <input type="hidden" name="itemcatmodifiedby" id="editedItemcatmodifiedby" value="<?php echo $_SESSION['login_user']; ?>" />

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="Edit" />
                    <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">Are you sure you would like to delete this category?</p>
                    <input type="hidden" name="itemcatid" id="delete_itemcatid" value="">
                </div>
                <div class="modal-footer">
                    <input type="submit" name="submit" id="deletebutton" class="btn btn-danger" value="Confirm" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Initialize DataTable
        var dataTable = $('#itemcat_table').DataTable();

        // Populate Edit modal when opened (reads data- attributes from the button that triggered modal)
        $('#editItemcatModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget); // Button that opened the modal
            var id = button.data('id');
            var name = button.data('name') || '';
            var description = button.data('description') || '';

            $('#edit_itemcatid').val(id);
            $('#editedItemcatname').val(name);
            $('#editedItemcatdescription').val(description);
        });

        // Submit Edit form via AJAX
        $('#itemcat_form').on('submit', function(event) {
            event.preventDefault();
            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/cmsadmin/controller/categoryController.php",
                data: formData,
                success: function(response) {
                    // optional: show response in console
                    console.log(response);
                    $('#editItemcatModal').modal('hide');
                    // refresh to show changes (you can instead update the row in-place)
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#form_message_edit').html('<div class="alert alert-danger">Update failed. See console for details.</div>');
                }
            });
        });

        // Prepare Delete modal
        $('#deleteCategoryModal').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            $('#delete_itemcatid').val(id);
        });

        // Submit delete via AJAX (on form submit)
        $('#delete_category_form').on('submit', function(e) {
            e.preventDefault();
            var id = $('#delete_itemcatid').val();
            $.ajax({
                url: config.developmentPath + "/cmsadmin/controller/categoryController.php",
                method: "POST",
                data: {
                    id: id,
                    action: 'delete'
                },
                success: function(data) {
                    console.log(data);
                    $('#deleteCategoryModal').modal('hide');
                    // refresh to reflect deletion
                    location.reload();
                },
                error: function(xhr, status, err) {
                    console.error(err);
                    alert('Delete failed. See console for details.');
                }
            });
        });

    });
</script>
