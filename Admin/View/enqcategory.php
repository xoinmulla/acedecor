<?php
include('session.php');
include('enquiryNavigation.php');
require_once("../DB Operations/enq_categoryOps.php");
require_once("../Model/enq_categorymodel.php");
?>

<style>

    .enquiry-category-page {
        width: 100%;
        max-width: 100%;
        min-width: 0
    }

    .enquiry-category-page .page-title {
        font-size: clamp(1.35rem, 2.2vw, 2rem);
        line-height: 1.25;
        word-break: break-word
    }

    .enquiry-category-page .card {
        width: 100%;
        max-width: 100%;
        overflow: hidden
    }

    .enquiry-category-page .card-header {
        padding: .85rem 1rem !important
    }

    .enquiry-category-page .card-header>.row {
        align-items: center
    }

    .enquiry-category-page .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin
    }

    .enquiry-category-page #itemcat_table {
        width: 100% !important;
        min-width: 650px;
        margin-bottom: 0
    }

    .enquiry-category-page #itemcat_table th,
    .enquiry-category-page #itemcat_table td {
        vertical-align: middle;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere
    }

    .enquiry-category-page #itemcat_table th {
        white-space: nowrap
    }

    .enquiry-category-page #itemcat_table td:last-child {
        min-width: 145px;
        white-space: nowrap;
        overflow: visible
    }

    .enquiry-category-page #itemcat_table .dropdown-menu {
        z-index: 2000
    }

    .enquiry-category-page .dataTables_wrapper {
        width: 100%;
        max-width: 100%
    }

    .enquiry-category-page .dataTables_wrapper .dataTables_length,
    .enquiry-category-page .dataTables_wrapper .dataTables_filter {
        margin-bottom: .75rem
    }

    .enquiry-category-page .dataTables_wrapper .dataTables_filter input {
        max-width: 100%
    }

    .modal .modal-dialog {
        width: calc(100% - 2rem);
        max-width: 700px;
        margin: 1rem auto
    }

    .modal .modal-content {
        max-width: 100%;
        overflow: hidden
    }

    .modal .modal-body {
        max-height: calc(100vh - 180px);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch
    }

    .modal .modal-footer {
        flex-wrap: wrap;
        gap: .5rem
    }

    .modal .modal-footer .btn {
        margin: 0
    }

    .modal .form-control,
    .modal .form-select,
    .modal select,
    .modal textarea {
        max-width: 100%
    }

    .modal p,
    .modal h4,
    .modal h5,
    .modal label,
    .modal td,
    .modal th {
        overflow-wrap: anywhere
    }

    @media (max-width:991.98px) {
        .enquiry-category-page .card-body {
            padding: .9rem
        }

        .enquiry-category-page .card-header>.row {
            margin: 0
        }

        .enquiry-category-page .card-header .col {
            padding-left: .25rem;
            padding-right: .25rem
        }

        .enquiry-category-page #itemcat_table {
            min-width: 620px
        }

        /* Tablet: compact modal. Position is calculated by JS. */
        .modal .modal-dialog {
            width: min(76vw, 620px);
            max-width: 620px;
            margin: 0;
        }
    }

    @media (max-width:767.98px) {
        .enquiry-category-page {
            padding-left: 0;
            padding-right: 0
        }

        .enquiry-category-page .page-title {
            margin-bottom: 1rem !important;
            font-size: 1.35rem
        }

        .enquiry-category-page .card {
            border-radius: 8px
        }

        .enquiry-category-page .card-header {
            padding: .85rem .9rem !important
        }

        .enquiry-category-page .card-header>.row {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: .75rem
        }

        .enquiry-category-page .card-header .col {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%
        }

        .enquiry-category-page .card-header .col:last-child {
            text-align: left !important
        }

        .enquiry-category-page .table-responsive {
            margin-left: 0;
            margin-right: 0;
            border-radius: 4px
        }

        .enquiry-category-page #itemcat_table {
            min-width: 600px
        }

        .enquiry-category-page .dataTables_wrapper .dataTables_length,
        .enquiry-category-page .dataTables_wrapper .dataTables_filter {
            float: none !important;
            width: 100%;
            text-align: left !important
        }

        .enquiry-category-page .dataTables_wrapper .dataTables_filter {
            margin-top: .5rem
        }

        .enquiry-category-page .dataTables_wrapper .dataTables_filter label {
            width: 100%;
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .enquiry-category-page .dataTables_wrapper .dataTables_filter input {
            flex: 1 1 auto;
            min-width: 0;
            width: auto;
            margin-left: 0 !important
        }

        .enquiry-category-page #itemcat_table .dropdown-menu {
            max-width: calc(100vw - 2rem);
            white-space: normal
        }

        .enquiry-category-page #itemcat_table .dropdown-item {
            white-space: normal
        }

        .modal .modal-dialog {
            width: calc(100vw - 32px);
            max-width: calc(100vw - 32px);
            margin: 0;
        }

        .modal .modal-content {
            border-radius: .5rem
        }

        .modal .modal-header,
        .modal .modal-footer {
            padding: .75rem
        }

        .modal .modal-body {
            padding: .85rem;
            max-height: calc(100vh - 145px)
        }

        .modal .modal-title {
            font-size: 1.05rem;
            padding-right: .5rem
        }

        .modal .modal-footer {
            justify-content: stretch
        }

        .modal .modal-footer .btn {
            flex: 1 1 auto;
            min-width: 110px
        }

        #enqcatModal .col-md-4,
        #enqcatModal .col-md-8,
        #editEnqcatModal .col-md-4,
        #editEnqcatModal .col-md-8 {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%
        }

        #enqcatModal .row,
        #editEnqcatModal .row {
            margin-left: 0;
            margin-right: 0
        }

        #enqcatModal .row>[class*=col-],
        #editEnqcatModal .row>[class*=col-] {
            padding-left: .25rem;
            padding-right: .25rem
        }

        #enqcatModal label,
        #editEnqcatModal label {
            text-align: left !important;
            margin-bottom: .35rem
        }

        #enqcatTypeButton,
        #editedEnqcatTypeButton {
            max-width: calc(100% - 42px);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        #enqcatTypeDropdown,
        #editedEnqcatTypeDropdown {
            max-width: calc(100vw - 2rem)
        }
    }

    @media (max-width:399.98px) {
        .enquiry-category-page .page-title {
            font-size: 1.2rem
        }

        .enquiry-category-page .card-header h6 {
            font-size: 1rem !important
        }

        .modal .modal-dialog {
            width: calc(100vw - 20px);
            max-width: calc(100vw - 20px);
            margin: 0;
        }

        .modal .modal-footer .btn {
            width: 100%;
            flex-basis: 100%
        }
    }

    @media (max-width:991.98px) {
        .modal .modal-dialog {
            transform: none !important
        }
    }
    .card-body #itemcat_table th{
        font-weight: 500;
    }
</style>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $_SESSION['error'];
        unset($_SESSION['error']); ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $_SESSION['success'];
        unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="enquiry-category-page">
    <h1 class="h3 mb-4 text-gray-800">Enquiry Management</h1>
    <!-- DataTales Example -->
    <span id="message"></span>
    <div class="card shadow mb-4 ">
        <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="row ">
                <div class="col">
                    <h6 class="m-0 text-white">Enquiry Category</h6>
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
                    <thead align="center">
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
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=enqcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data"
            action="../Controller/enqcategoryController.php">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title text-white" id="modal_title">Add Data</h4>
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
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
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
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
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
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
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
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

        $('.modal').on('shown.bs.modal', function () {

            var $dialog = $(this).find('.modal-dialog');
            var isResponsive = window.innerWidth <= 991.98;

            if ($dialog.hasClass("ui-draggable")) {
                $dialog.draggable("destroy");
            }

            /* Keep existing desktop behaviour (1024px+). */
            if (!isResponsive) {
                var desktopOffset = $dialog.offset();

                $dialog.css({
                    margin: 0,
                    position: "fixed",
                    left: desktopOffset.left,
                    top: desktopOffset.top,
                    transform: "none"
                });
            } else {
                /* Calculate tablet/mobile position from the viewport, not offset(). */
                var viewportWidth = $(window).width();
                var viewportHeight = $(window).height();
                var margin = window.innerWidth <= 399.98 ? 10 : 16;
                var dialogWidth = Math.min($dialog.outerWidth(), viewportWidth - (margin * 2));

                $dialog.css({
                    margin: 0,
                    position: "fixed",
                    width: dialogWidth + "px",
                    maxWidth: dialogWidth + "px",
                    left: Math.max(margin, (viewportWidth - dialogWidth) / 2),
                    top: Math.max(margin, (viewportHeight - $dialog.outerHeight()) / 2),
                    transform: "none"
                });

                var finalWidth = $dialog.outerWidth();
                var finalHeight = $dialog.outerHeight();
                var maxLeft = Math.max(margin, viewportWidth - finalWidth - margin);
                var maxTop = Math.max(margin, viewportHeight - finalHeight - margin);
                var currentLeft = parseFloat($dialog.css("left")) || margin;
                var currentTop = parseFloat($dialog.css("top")) || margin;

                $dialog.css({
                    left: Math.min(Math.max(currentLeft, margin), maxLeft),
                    top: Math.min(Math.max(currentTop, margin), maxTop)
                });
            }

            /* Existing draggable functionality is preserved. */
            $dialog.draggable({
                handle: ".modal-header",
                containment: "window",
                scroll: false,
                start: function () {
                    $(this).css("transform", "none");
                }
            });

        });

        /* Keep responsive dialogs inside the viewport after orientation/resize. */
        $(window).on('resize', function () {
            if (window.innerWidth > 991.98) {
                return;
            }

            $('.modal.show').each(function () {
                var $dialog = $(this).find('.modal-dialog');
                if (!$dialog.length) return;

                var viewportWidth = $(window).width();
                var viewportHeight = $(window).height();
                var margin = window.innerWidth <= 399.98 ? 10 : 16;
                var width = Math.min($dialog.outerWidth(), viewportWidth - (margin * 2));

                $dialog.css({ width: width + "px", maxWidth: width + "px" });

                var maxLeft = Math.max(margin, viewportWidth - $dialog.outerWidth() - margin);
                var maxTop = Math.max(margin, viewportHeight - $dialog.outerHeight() - margin);
                var left = parseFloat($dialog.css("left")) || margin;
                var top = parseFloat($dialog.css("top")) || margin;

                $dialog.css({
                    left: Math.min(Math.max(left, margin), maxLeft),
                    top: Math.min(Math.max(top, margin), maxTop)
                });
            });
        });

    });
</script>