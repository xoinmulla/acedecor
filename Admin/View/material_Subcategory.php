<?php
include('session.php');
include('material_subcatNavigation.php');
require_once("../DB Operations/material_subcategoryOps.php");
require_once("../Model/material_subcategoryModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<style>
    .card-body #materialsubcat_table th {
        font-weight: 500;
    }
</style>
<div class="card shadow mb-4">
    <div class="card-header py-3 "
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Material
                    SubCategory</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle="modal" data-target="#materialsubcatModal">
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="materialsubcat_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th style='display:none'>Category Id</th>
                        <th>Material Category</th>
                        <th>Material SubCategory</th>
                        <th>Material SubCategory Description.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $materialsubcatlist = DBMaterialsubcategory::getallmatsubcategory();
                    if (is_array($materialsubcatlist) || is_object($materialsubcatlist)) {
                        foreach ($materialsubcatlist as $materialsubcat) {

                            // ✅ check once per row
                            $canDelete = DBMaterialsubcategory::canDelete(
                                $materialsubcat->get_materialsubcatId()
                            );

                            echo "<tr>
            <td style='display:none'>" . $materialsubcat->get_materialcatId() . "</td>
            <td>" . htmlspecialchars($materialsubcat->get_materialcatName()) . "</td>
            <td>" . htmlspecialchars($materialsubcat->get_materialsubcatName()) . "</td>
            <td>" . htmlspecialchars($materialsubcat->get_materialsubcaDescription()) . "</td>
            <td>
                <div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle'
                        type='button'
                        data-toggle='dropdown'>
                        Actions
                    </button>

                    <div class='dropdown-menu'>
                        <button class='btn btn-primary dropdown-item'
                            data-toggle='modal'
                            data-target='#editmaterialsubcatModal'
                            data-id='" . $materialsubcat->get_materialsubcatId() . "'>
                            <i class='fas fa-user-edit'></i> Edit SubCategory
                        </button>";

                            // 🔴 DELETE (conditionally disabled)
                            if ($canDelete) {
                                echo "<button class='btn btn-danger dropdown-item'
                data-toggle='modal'
                data-target='#deleteSubCategoryModal'
                data-id='" . $materialsubcat->get_materialsubcatId() . "'>
                <i class='fas fa-trash-alt'></i> Delete SubCategory
            </button>";
                            } else {
                                echo "<button class='btn btn-danger dropdown-item'
                disabled
                title='Cannot delete: Materials are linked'>
                <i class='fas fa-trash-alt'></i> Delete SubCategory
            </button>";
                            }

                            echo "</div>
                </div>
            </td>
        </tr>";
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<!-- ADD Modal -->
<div class="modal fade" id="materialsubcatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="addMaterialSubcatForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title">Add Material SubCategory</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message_add"></span>

                    <div class="form-group row">
                        <label class="col-md-5 text-right">Material Category Name <span
                                class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <select id="materialcatid" name="materialcatid" class="form-select" required></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-5 text-right">Material SubCategory Name <span
                                class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <input type="text" name="materialsubcatname" id="materialsubcatname" class="form-control"
                                required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                data-parsley-trigger="keyup" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-5 text-right">Material SubCategory Description <span
                                class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <input type="text" name="materialsubcatdescription" id="materialsubcatdescription"
                                class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="255"
                                data-parsley-trigger="keyup" />
                        </div>
                    </div>

                    <input type="hidden" name="materialsubcatcreatedby" id="materialsubcatcreatedby"
                        value="<?php echo $_SESSION['login_user']; ?>" />
                    <input type="hidden" name="materialsubcatmodifiedby" id="materialsubcatmodifiedby"
                        value="<?php echo $_SESSION['login_user']; ?>" />

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="Add" />
                    <input type="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- EDIT Modal -->
<div class="modal fade" id="editmaterialsubcatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="editMaterialSubcatForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title">Edit Material SubCategory</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message_edit"></span>

                    <div class="form-group row">
                        <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select id="editmaterialcatid" name="materialcatid" class="form-select" required></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 text-right">SubCategory Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="materialsubcatname" id="editedmaterialsubcatname"
                                class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                            <input type="hidden" id="edit_materialsubcatid" name="materialsubcatid" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 text-right">SubCategory Description <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="materialsubcatdescription" id="editedmaterialsubcatdescription"
                                class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="255"
                                data-parsley-trigger="keyup" />
                        </div>
                    </div>

                    <input type="hidden" name="materialsubcatcreatedby" id="editedmaterialsubcatcreatedby"
                        value="<?php echo $_SESSION['login_user']; ?>" />
                    <input type="hidden" name="materialsubcatmodifiedby" id="editedmaterialsubcatmodifiedby"
                        value="<?php echo $_SESSION['login_user']; ?>" />

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="Edit" />
                    <input type="submit" id="edit_submit_button" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- DELETE Modal -->
<div class="modal fade" id="deleteSubCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="deleteMaterialSubcatForm">
            <span class="delete_message"></span>
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title">Delete Sub Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">Are you sure you want to delete this Subcategory record?</p>
                    <input type="hidden" id="delete_modal_subcat_id" name="id" value="">
                </div>
                <div class="modal-footer">
                    <input type="submit" id="delete_confirm_button" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {

        // Initialize DataTable
        var dataTable = $('#materialsubcat_table').DataTable();

        // Load categories once (populate both add & edit selects)
        $.getJSON(config.developmentPath + "/Admin/Controller/material_CategoryController.php", function (data) {
            var $add = $('#materialcatid');
            var $edit = $('#editmaterialcatid');

            $add.html('<option hidden disabled selected value="">-- select an option --</option>');
            $edit.html('<option hidden disabled selected value="">-- select an option --</option>');

            $.each(data, function (index, value) {
                // material_CategoryOps::selectMatcategory returns objects; keys may vary — try common ones
                var id = value.material_catId || value.materialcatId || value.material_catId || value.materialcatid || value.materialCatid || value.materialcatId;
                var name = value.material_catName || value.materialCatname || value.material_catName || value.materialCatName || value.materialCatname;
                // fallback to expected properties if available:
                if (!id) { id = value.material_catId || value.materialcatId || value.materialcatId || value.materialCatid; }
                if (!name) { name = value.material_catName || value.materialCatname || value.materialCatName; }

                // Use the properties your controller returns (material_CategoryOps::selectMatcategory sets materialcatId & materialCatname)
                id = value.materialcatId || value.material_catId || value.materialCatid || id;
                name = value.materialCatname || value.material_catName || name;

                $add.append('<option value="' + id + '">' + name + '</option>');
                $edit.append('<option value="' + id + '">' + name + '</option>');
            });
        });

        // When an action button opens the Edit modal, set the hidden id
        $('#editmaterialsubcatModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#edit_materialsubcatid').val(rowid);

            // Populate fields using the table row values
            // find the table row that contains the button
            var $btn = $(e.relatedTarget);
            var $tr = $btn.closest('tr')[0];
            if ($tr) {
                $('#editmaterialcatid').val($tr.cells[0].innerHTML);
                $('#editedmaterialsubcatname').val($tr.cells[2].innerHTML);
                $('#editedmaterialsubcatdescription').val($tr.cells[3].innerHTML);
            }
        });

        // ADD (AJAX)
        $('#addMaterialSubcatForm').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_SubcategoryController.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    var json;
                    try {
                        json = (typeof res === "string") ? JSON.parse(res) : res;
                    } catch (e) {
                        $('#form_message_add').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {
                        $('#form_message_add').html('<div class="alert alert-success">' + (json.message || 'SubCategory added successfully!') + '</div>');

                        setTimeout(function () {
                            $('#materialsubcatModal').modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            $('#addMaterialSubcatForm')[0].reset();
                            location.reload();
                        }, 600);
                    } else {
                        $('#form_message_add').html('<div class="alert alert-danger">' + (json.message || 'Error adding subcategory.') + '</div>');
                    }
                },
                error: function (xhr, status, error) {
                    $('#form_message_add').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });
        });

        // EDIT (AJAX)
        $('#editMaterialSubcatForm').on('submit', function (event) {
            event.preventDefault();

            var payload = {
                materialsubcatid: $('#edit_materialsubcatid').val(),
                materialcatid: $('#editmaterialcatid').val(),
                materialsubcatname: $('#editedmaterialsubcatname').val(),
                materialsubcatdescription: $('#editedmaterialsubcatdescription').val(),
                materialsubcatcreatedby: $('#editedmaterialsubcatcreatedby').val(),
                materialsubcatmodifiedby: $('#editedmaterialsubcatmodifiedby').val()
            };

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_SubcategoryController.php",
                data: payload,
                dataType: "json"
            }).done(function (res) {
                if (res && res.status === "success") {
                    $('#form_message_edit').html('<div class="alert alert-success">' + (res.message || 'SubCategory updated successfully') + '</div>');
                    setTimeout(function () {
                        $('#editmaterialsubcatModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        location.reload();
                    }, 600);
                } else {
                    $('#form_message_edit').html('<div class="alert alert-danger">' + (res.message || 'Error updating subcategory') + '</div>');
                }
            }).fail(function (xhr, status, err) {
                $('#form_message_edit').html('<div class="alert alert-danger">AJAX Error: ' + err + '</div>');
            });
        });

        // DELETE modal show => set id
        $('#deleteSubCategoryModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#delete_modal_subcat_id').val(rowid);
        });

        // DELETE (AJAX)
        $('#deleteMaterialSubcatForm').on('submit', function (e) {
            e.preventDefault();

            var id = $('#delete_modal_subcat_id').val();
            if (!id) return;

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/material_SubcategoryController.php",
                method: "POST",
                data: {
                    id: id,
                    action: 'delete'
                },
                dataType: "json"
            }).done(function (res) {
                if (res && res.html) {
                    $('#message').html(res.html);
                } else if (res && res.status === "success") {
                    $('#message').html('<div class="alert alert-success">SubCategory deleted.</div>');
                } else {
                    $('#delete_message').html('<div class="alert alert-danger">Delete failed.</div>');
                }

                setTimeout(function () {
                    location.reload();
                }, 1200);
            }).fail(function (xhr, status, err) {
                $('#message').html('<div class="alert alert-danger">AJAX Error: ' + err + '</div>');
                setTimeout(function () { $('#message').html(''); }, 3000);
            });
        });

        $('.modal').on('shown.bs.modal', function () {

            var $dialog = $(this).find('.modal-dialog');

            if ($dialog.hasClass("ui-draggable")) {
                $dialog.draggable("destroy");
            }

            $dialog.draggable({
                handle: ".modal-header",
                containment: "window",
                scroll: false
            });

        });

    });
</script>