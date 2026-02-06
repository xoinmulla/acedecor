<?php
include('session.php');
include('material_catNavigation.php');
require_once("../DB Operations/material_CategoryOps.php");
require_once("../Model/material_CategoryModel.php");
?>
<style>
    .form-switch .form-check-input {
        margin-left: 0 !important;
    }

    .form-check .form-check-input {
        margin-left: 0 !important;
        float: none;
    }

    .form-check-input {
        position: static;
        margin-top: .3em;
        margin-left: 0;
    }
</style>

<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>

<!-- DataTales Example -->
<span id="message"></span>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Material
                    Category</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#materialcatModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="materialCat_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Material Category</th>
                        <th>Material Category Description.</th>
                        <th style=display:none>Brand Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $materialcatlist = DBMaterialcategory::getallMaterialcategory();
                    if (is_array($materialcatlist) || is_object($materialcatlist)) {
                        foreach ($materialcatlist as $materialcat) {

                            // ✅ check once per row
                            $canDelete = DBMaterialcategory::canDelete($materialcat->get_materialCatid());

                            echo "<tr>
            <td>" . $materialcat->get_materialCatname() . "</td>
            <td>" . $materialcat->get_materialCatdescription() . "</td>
            <td style='display:none'>" . $materialcat->get_materialCatdescription() . "</td>
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
                            data-target='#editMatcatModal'
                            data-id='" . $materialcat->get_materialCatid() . "'>
                            <i class='fas fa-user-edit'></i> Edit Category
                        </button>

                        <button class='btn btn-primary dropdown-item'
                            data-toggle='modal'
                            data-target='#infoMatcatModal'
                            data-id='" . $materialcat->get_materialCatid() . "'>
                            <i class='fas fa-info-circle'></i> Category Info
                        </button>";

                            // 🔴 DELETE (conditionally disabled)
                            if ($canDelete) {
                                echo "<button class='btn btn-danger dropdown-item'
                data-toggle='modal'
                data-target='#deleteCategoryModal'
                data-id='" . $materialcat->get_materialCatid() . "'>
                <i class='fas fa-trash-alt'></i> Delete Category
            </button>";
                            } else {
                                echo "<button class='btn btn-danger dropdown-item' 
                disabled 
                title='Cannot delete: Category is in use'>
                <i class='fas fa-trash-alt'></i> Delete Category
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

<!-- ADD MODAL (Now uses AJAX and same behavior as itemcategory.php) -->
<div class="modal fade" id=materialcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <!-- Updated form id to match item flow -->
        <form method="post" id="addMaterialCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend">

                                    <button type="button" class="btn btn-secondary">
                                        Select Brands
                                    </button>
                                    <button type="button"
                                        class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropright</span>
                                    </button>
                                    <ul class="dropdown-menu" id="checkboxes">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialCatname" id="materialCatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialCatdescription" id="materialCatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="materialCatcreatedby" id="materialCatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="materialCatmodifiedby" id="materialCatmodifiedby"
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

<!-- INFO MODAL -->
<div class="modal fade" id=infoMatcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Category Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="displayMatCategoryName"> Name:</label>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-title" id="displayMatCategoryName"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label for="displayMatCategoryDescription"> Description:</label>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-title" id="displayMatCategoryDescription"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label for="displayMatCategoryBrand">Brands Mapped:</label>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-title" id="displayMatCategoryBrand"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id=editMatcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="editMaterialCatForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message_edit"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-secondary">
                                        Select Brands
                                    </button>
                                    <button type="button"
                                        class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false" id="editedBrand">
                                        <span class="visually-hidden">Toggle Dropright</span>
                                    </button>
                                    <ul class="dropdown-menu" id="editedcheckboxes">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialCatname" id="editedmaterialCatname"
                                    class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <input type="hidden" name="materialCatid" id="materialCatid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialCatdescription" id="editedmaterialCatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="materialCatcreatedby" id="editedmaterialCatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="materialCatmodifiedby" id="editedmaterialCatmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id_edit" />
                        <input type="hidden" name="action" id="action_edit" value="Edit" />
                        <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id=deleteCategoryModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Material Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this category record.
                    </p>
                    <input type="hidden" name="materialCatid" id="materialCatid" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id_del" />
                    <input type="submit" name="submit" id="deletebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Row click to populate edit/info fields (same as itemcategory)
        $('#materialCat_table tbody').on('click', 'tr', function () {
            $('#editedmaterialCatname').val(this.cells[0].innerHTML);
            $('#editedmaterialCatdescription').val(this.cells[1].innerHTML);
            $('#displayMatCategoryName').text(this.cells[0].innerHTML);
            $('#displayMatCategoryDescription').text(this.cells[1].innerHTML);
        });

        // InputType for brandcontroller (2 for material)
        var InputType = 2;

        // Load brand checkboxes for Add modal
        var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputType;
        $.getJSON(fetchsubcaturl, function (data) {
            $.each(data, function (index, value) {
                $('#checkboxes').append(
                    $(document.createElement('li')).prop({
                        class: 'form-check form-switch'
                    }).append(
                        $(document.createElement('input')).prop({
                            class: 'form-check-input me-1',
                            id: 'myCheckBox',
                            name: 'brand_list[]',
                            value: value.brandid,
                            type: 'checkbox'
                        })).append(
                            $(document.createElement('label')).prop({
                                for: 'myCheckBox'
                            }).html(value.brandname)
                        ).append(document.createElement('br')));
            });
        });

        // When Edit modal opens => load mapped brands with checked state
        $('#editMatcatModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#materialCatid').val(rowid);
            $('#editedcheckboxes').empty();
            var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?matcatId=" +
                $('#materialCatid').val() + "&InputId=" + InputType;
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    var checked = value.isMapped == 0 ? false : true;
                    $('#editedcheckboxes').append(
                        $(document.createElement('li')).prop({
                            class: 'form-check form-switch'
                        }).append(
                            $(document.createElement('input')).prop({
                                class: 'form-check-input me-1',
                                id: 'editedmyCheckBox',
                                name: 'brand_list[]',
                                value: value.brandid,
                                type: 'checkbox',
                                checked: checked
                            })).append(
                                $(document.createElement('label')).prop({
                                    for: 'myCheckBox'
                                }).html(value.brandname)
                            ).append(document.createElement('br')));
                });
            });
        });

        // DataTable init
        var dataTable = $('#materialCat_table').DataTable({});

        // Info modal: show mapped brands
        $('#infoMatcatModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $("#displayMatCategoryBrand").find("ul").remove();
            var fetchsubcaturl = config.developmentPath +
                "/Admin/Controller/brandcontroller.php?matcatId=" +
                rowid + "&InputId=" + InputType;
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    if (value.isMapped) {
                        $('#displayMatCategoryBrand').append(
                            $(document.createElement('ul')).prop({
                                class: 'list-group list-group-flush'
                            }).append(
                                $(document.createElement('li')).prop({
                                    class: 'list-group-item'
                                })).html(value.brandname).append(
                                    document.createElement('br')));
                    }
                });
            });
        });

        // -----------------------------
        //  EDIT (AJAX) - mirrors itemcategory behavior
        // -----------------------------
        $('#editMaterialCatForm').submit(function (event) {
            event.preventDefault();

            // Build FormData manually to include brand_list checkboxes
            var formData = new FormData();

            formData.append('materialCatid', $('#materialCatid').val());
            formData.append('materialCatname', $('#editedmaterialCatname').val());
            formData.append('materialCatdescription', $('#editedmaterialCatdescription').val());
            formData.append('materialCatcreatedby', $('#editedmaterialCatcreatedby').val());
            formData.append('materialCatmodifiedby', $('#editedmaterialCatmodifiedby').val());

            // gather brand_list[] from editedcheckboxes
            $('#editedcheckboxes input[name="brand_list[]"]:checked').each(function () {
                formData.append('brand_list[]', $(this).val());
            });

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_CategoryController.php",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                // Expecting JSON like {status:"success", message:"..."}
                try {
                    var json = (typeof data === "string") ? JSON.parse(data) : data;
                    if (json.status && json.status === "success") {
                        $('#form_message_edit').html('<div class="alert alert-success">Category updated successfully!</div>');
                        // close modal and refresh table
                        setTimeout(function () {
                            $('#editMatcatModal').modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            // optional: reload page part or table - here simply reload datatable
                            // If you have an ajax source for datatable, call dataTable.ajax.reload()
                            // else you might refresh the page or update row manually.
                            location.reload(); // simple safe option to reflect changes
                        }, 500);
                    } else {
                        $('#form_message_edit').html('<div class="alert alert-danger">' + (json.message || 'Error updating category.') + '</div>');
                    }
                } catch (e) {
                    console.error('Invalid JSON from server', data);
                    $('#form_message_edit').html('<div class="alert alert-danger">Invalid server response.</div>');
                }
            }).fail(function (xhr, status, err) {
                $('#form_message_edit').html('<div class="alert alert-danger">AJAX Error: ' + err + '</div>');
            });
        });

        // -----------------------------
        //  DELETE (AJAX) - mirrors itemcategory behavior
        // -----------------------------
        $('#deleteCategoryModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#materialCatid').val(rowid);
        });

        $('#deletebutton').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/material_CategoryController.php",
                method: "POST",
                data: {
                    id: $('#materialCatid').val(),
                    action: 'delete'
                },
                dataType: "json"
            }).done(function (res) {
                // Expecting {status:"success", message:"Category deleted", html: "<div>..</div>"}
                if (res && res.html) {
                    $('#message').html(res.html);
                } else if (res && res.status === "success") {
                    $('#message').html('<div class="alert alert-success">Category deleted successfully.</div>');
                } else {
                    $('#message').html('<div class="alert alert-danger">Error deleting category.</div>');
                }

                setTimeout(function () {
                    $('#message').html('');
                    // reload datatable or page to reflect deletion
                    location.reload();
                }, 1500);
            }).fail(function (xhr, status, err) {
                $('#message').html('<div class="alert alert-danger">AJAX Error: ' + err + '</div>');
                setTimeout(function () {
                    $('#message').html('');
                }, 3000);
            });
        });

        // -----------------------------
        //  ADD (AJAX) - mirrors itemcategory behavior
        // -----------------------------
        $('#addMaterialCategoryForm').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_CategoryController.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    var json;
                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        console.log("Invalid JSON:", res);
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {

                        // Success Message
                        $('#form_message').html('<div class="alert alert-success">Category added successfully!</div>');

                        // Small delay to let user read the message
                        setTimeout(() => {
                            // Close modal
                            $('#materialcatModal').modal('hide');

                            // Remove ghost backdrop (Bootstrap bug fix)
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // Reload categories inside material modal (helper) and set value
                            reloadMaterialCategoryList(() => {
                                // set the newly created category in any selector if present
                                $('#materialCategory').val(json.newCategoryId);
                            });

                            // Reopen details modal (mirrors item flow)
                            // NOTE: If you want to open some other modal (e.g., #itemdetailsModal), replace the ID below.
                            setTimeout(() => {
                                $('#materialdetailsModal').modal('show');
                            }, 200);

                            // Reset category form
                            $('#addMaterialCategoryForm')[0].reset();

                        }, 600);
                    } else {
                        $('#form_message').html(
                            `<div class="alert alert-danger">${json.message || 'Error adding category.'}</div>`
                        );
                    }
                },
                error: function (xhr, status, error) {
                    $('#form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });
        });

        // -----------------------------
        //  Helper: reloadMaterialCategoryList
        //  (replace or remove if you already have a similar function in your code)
        // -----------------------------
        function reloadMaterialCategoryList(callback) {
            // Example implementation: fetch all material categories and populate a dropdown #materialCategory
            // If you don't have such a dropdown, this will silently do nothing.
            $.getJSON(config.developmentPath + "/Admin/Controller/material_CategoryController.php", function (data) {
                // data should be an array of { material_catId, material_catName } objects (or similar)
                // In material_CategoryOps::selectMatcategory we return an array of objects with material_catId & material_catName
                try {
                    // Clear existing options if select exists
                    var $sel = $('#materialCategory');
                    if ($sel.length) {
                        $sel.empty();
                        $.each(data, function (index, obj) {
                            var id = obj.material_catId || obj.materialcatId || obj.materialCatid || obj.materialcatid;
                            var name = obj.material_catName || obj.materialCatname || obj.materialCatname;
                            if (id && name) {
                                $sel.append($('<option>', { value: id }).text(name));
                            }
                        });
                    }
                } catch (e) {
                    // ignore
                } finally {
                    if (typeof callback === 'function') callback();
                }
            }).fail(function () {
                if (typeof callback === 'function') callback();
            });
        }

    });
</script>