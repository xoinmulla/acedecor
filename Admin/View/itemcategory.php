<?php
include('session.php');
include('itemcategoryNavigation.php');
require_once("../DB Operations/item_categoryOps.php");
require_once("../Model/item_categorymodel.php");
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

    /* =========================================================
   RESPONSIVE MODALS
   ========================================================= */

    .modal .modal-dialog {
        width: calc(100% - 2rem);
        max-width: 500px;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* Large modal */
    .modal .modal-dialog.modal-lg {
        max-width: 900px;
    }

    /* Tablet */
    @media (max-width: 991.98px) {

        .modal .modal-dialog,
        .modal .modal-dialog.modal-lg {
            width: calc(100% - 2rem);
            max-width: 750px;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {

        .modal .modal-dialog,
        .modal .modal-dialog.modal-lg {
            width: calc(100% - 1rem);
            max-width: 500px;
        }
    }

    /* Very small screens */
    @media (max-width: 399.98px) {

        .modal .modal-dialog,
        .modal .modal-dialog.modal-lg {
            width: calc(100% - .5rem);
        }
    }

    .card-body #itemcat_table th {
        font-weight: 500;
    }
</style>
<h1 class="h3 mb-4 text-gray-800 ">Inventory Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Item Category</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#itemcatModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="itemcat_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th>Item Category</th>
                        <th>Item Category Description.</th>
                        <th style=display:none>Brand Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $itemcatlist = DBitemcategory::getallItemcategory();
                    if (!is_array($itemcatlist) && !is_object($itemcatlist)) {
                        $itemcatlist = [];
                    }
                    foreach ($itemcatlist as $itemcat) {
                        echo "<tr><td>" . $itemcat->get_itemcatname() . "</td>
                        <td>" . $itemcat->get_itemcatdescription() . "</td>
                        <td style=display:none>" . $itemcat->get_itemcatdescription() . "</td>
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
                            data-target='#editItemcatModal' 
                            role='button' 
                            data-id='" . $itemcat->get_itemcatid() . "'>
                            <i class='fas fa-user-edit'></i> 
                                Edit Category
                           </button>
                    
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#infoItemcatModal' 
                           role='button' 
                           data-id='" . $itemcat->get_itemcatid() . "'>
                           <i class='fas fa-info-circle'></i>
                                Category Info
                          </button>
                            <button class='btn btn-danger dropdown-item'
    data-toggle='modal'
    data-target='#deleteCategoryModal'
    role='button'
    data-id='" . $itemcat->get_itemcatid() . "'
    " . (!$itemcat->get_canDelete() ? 'disabled title="Category in use"' : '') . ">
    <i class='fas fa-trash-alt'></i>
    " . (!$itemcat->get_canDelete() ? 'Cannot Delete' : 'Delete Category') . "
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
<div class="modal fade" id=itemcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="addCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
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
                                        data-toggle="dropdown" aria-expanded="false">
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
                                <input type="text" name="itemcatname" id="itemcatname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatdescription" id="itemcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemcatcreatedby" id="itemcatcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
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
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=infoItemcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
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
                                        <label for="displayCategoryName"> Name:</label>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-title" id="displayCategoryName"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label for="displayCategoryDescription"> Description:</label>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-title" id="displayCategoryDescription"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label for="displayCategoryBrand">Brands Mapped:</label>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-title" id="displayCategoryBrand"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />

                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id=editItemcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="edititemcat_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
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
                                        data-toggle="dropdown" aria-expanded="false" id="editedBrand">
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
                                <input type="text" name="itemcatname" id="editedItemcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name="itemcatid" id="itemcatid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatdescription" id="editedItemcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemcatcreatedby" id="editedItemcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemcatmodifiedby" id="editedItemcatmodifiedby"
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
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteCategoryModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title" id="modal_title">Delete Item Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this category record.
                    </p>
                    <input type="hidden" name="itemcatid" id="itemcatid" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="deletebutton" class="btn btn-success" value="Confirmed" />
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#itemcatModal').on('show.bs.modal', function () {
            $('#itemcatModal #form_message').html('');
        });

        $('#editItemcatModal').on('show.bs.modal', function () {
            $('#editItemcatModal #form_message').html('');
        });
        $('#itemcat_table tbody').on('click', 'tr', function () {

            /* Get the row as a parent of the link that was clicked on */
            $('#editedItemcatname').val(this.cells[0].innerHTML);
            $('#editedItemcatdescription').val(this.cells[1].innerHTML);
            $('#displayCategoryName').text(this.cells[0].innerHTML);
            $('#displayCategoryDescription').text(this.cells[1].innerHTML);

        });
        var InputType = 1;
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

        $('#editItemcatModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#itemcatid').val(rowid);
            $('#editedcheckboxes').empty();
            var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?catId=" +
                $('#itemcatid').val() + "&InputId=" + InputType;
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    if (value.isMapped == 0) {
                        checked = false;
                    } else {
                        checked = true;
                    }
                    $('#editedcheckboxes').append(
                        $(document.createElement('li')).prop({
                            class: 'form-check form-switch'
                        }).append(
                            $(document.createElement('input')).prop({
                                class: 'form-check-input me-1',
                                id: 'editedmyCheckBox',
                                name: 'brand_list[]',
                                checked: checked,
                                value: value.brandid,
                                type: 'checkbox',

                            })).append(
                                $(document.createElement('label')).prop({
                                    for: 'myCheckBox'
                                }).html(value.brandname)
                            ).append(document.createElement('br')));
                });
            });
        });
        var dataTable = $('#itemcat_table').DataTable({

        });

        var nEditing = null;

        $('#infoItemcatModal').on('show.bs.modal', function (e) {
            debugger;

            var rowid = $(e.relatedTarget).data('id');
            $("#displayCategoryBrand").find("ul").remove();
            var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?catId=" +
                rowid + "&InputId=" + InputType;
            console.log(fetchsubcaturl);
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    if (value.isMapped) {
                        $('#displayCategoryBrand').append(
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

        $('#edititemcat_form').submit(function (event) {
            event.preventDefault();
            debugger;
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php/",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (res) {

                let json = typeof res === "string" ? JSON.parse(res) : res;

                if (json.status == "success") {

                    $('#editItemcatModal #form_message').html(
                        `<div class="alert alert-success">${json.message}</div>`
                    );

                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else {

                    $('#editItemcatModal #form_message').html(
                        `<div class="alert alert-danger">${json.message}</div>`
                    );

                }

            });
        });
    });
    $('#deleteCategoryModal').on('show.bs.modal', function (e) {

        var rowid = $(e.relatedTarget).data('id');
        $('#itemcatid').val(rowid);

    });

    $('#deletebutton').click(function (e) {

        e.preventDefault();

        $.ajax({

            url: config.developmentPath + "/Admin/Controller/item_categorycontroller.php/",

            method: "POST",

            dataType: "json",

            data: {
                id: $('#itemcatid').val(),
                action: 'delete'
            },

            success: function (res) {

                $('#deleteCategoryModal').modal('hide');

                if (res.status == "success") {

                    $('#message').html(
                        `<div class="alert alert-success">${res.message}</div>`
                    );

                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else {

                    $('#message').html(
                        `<div class="alert alert-danger">${res.message}</div>`
                    );

                }

            }

        });

    });



    $('#addCategoryForm').on('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: config.developmentPath + "/Admin/Controller/item_categorycontroller.php/",
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

                    // ✅ Success Message (same style as brand form)
                    $('#form_message').html(
                        `<div class="alert alert-success">${json.message}</div>`
                    );

                    // Small delay to let user read the message
                    setTimeout(() => {
                        // Close modal
                        $('#itemcatModal').modal('hide');

                        // Remove ghost backdrop (Bootstrap bug fix)
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');

                        // Reload categories inside item modal
                        reloadCategoryList(() => {
                            $('#itemCategory').val(json.newCategoryId);
                        });

                        // Reopen the Item Modal
                        setTimeout(() => {
                            $('#itemdetailsModal').modal('show');
                        }, 200);

                        // Reset category form
                        $('#addCategoryForm')[0].reset();

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

    $(document).on('click', '.dropdown-item[disabled]', function (e) {
        e.preventDefault();
        alert('❌ This category cannot be deleted because it is in use.');
    });

    /* =========================================================
       CENTER ALL MODALS IN VIEWPORT
       + KEEP MODALS DRAGGABLE
       ========================================================= */

    $('.modal').on('shown.bs.modal', function () {

        var $modal = $(this);
        var $dialog = $modal.find('.modal-dialog');

        if (!$dialog.length) {
            return;
        }

        /* Destroy previous draggable instance */
        if ($dialog.hasClass('ui-draggable')) {
            $dialog.draggable('destroy');
        }

        /*
         * Force browser to calculate the actual
         * displayed dimensions of the modal.
         */
        var dialogWidth = $dialog.outerWidth();
        var dialogHeight = $dialog.outerHeight();

        var windowWidth = $(window).width();
        var windowHeight = $(window).height();

        /*
         * Calculate exact center position.
         */
        var left = (windowWidth - dialogWidth) / 2;
        var top = (windowHeight - dialogHeight) / 2;

        /*
         * Prevent the modal from going outside
         * the viewport on small screens.
         */
        left = Math.max(10, left);
        top = Math.max(10, top);

        /*
         * Position modal exactly in the center.
         */
        $dialog.css({
            margin: 0,
            position: 'fixed',
            left: left + 'px',
            top: top + 'px',
            transform: 'none'
        });

        /*
         * Make modal draggable.
         */
        if (typeof $dialog.draggable === 'function') {

            $dialog.draggable({
                handle: '.modal-header',
                containment: 'window',
                scroll: false,

                start: function () {
                    $(this).css('transform', 'none');
                },

                drag: function () {
                    $(this).css('transform', 'none');
                }
            });

        }

    });

</script>