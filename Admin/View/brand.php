<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
require_once("../DB Operations/dbconnection.php");

$db = ConnectDb::getInstance();
$conn = $db->getConnection();

$user_name = $_SESSION['login_user'];

$userQuery = $conn->query("
SELECT user_id 
FROM user 
WHERE user_name='$user_name'
");

$userData = $userQuery->fetch_assoc();

if (!$userData) {
    die("User not found");
}

$user_id = $userData['user_id'];

$check = $conn->query("
SELECT uap.allowed
FROM user_action_permissions uap
JOIN module_actions ma ON ma.id = uap.action_id
WHERE uap.user_id='$user_id'
AND ma.action_key='brands'
");

if ($check->num_rows == 0) {
    header("Location: noaccess.php");
    exit;
}

include('channelpartnerheader.php');
require_once("../DB Operations/brandOps.php");
require_once("../Model/brandmodel.php");
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
<h1 class="h3 mb-4 text-gray-800">Channel Partners</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bolder;">Brands
                    List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#brandModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="brand_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'>Brand Id</th>
                        <th>Brand Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $brandList = DBbrand::getAllbrands();
                    foreach ($brandList as $brand) {
                        $brandId = $brand->get_brandid();
                        $brandName = $brand->get_brandname();

                        // ✅ Check if brand is mapped
                        $isMapped = DBbrand::isMappedInItemCategory($brandId);
                        $isMappedInInventory = DBbrand::isMappedInInventory($brandId);


                        echo "<tr>
            <td style='display:none'>$brandId</td>
            <td>$brandName</td>
            <td>
                <div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-expanded='false'>
                        Actions
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenu2'>

                        <button class='btn btn-primary dropdown-item'
                                data-toggle='modal'
                                data-target='#editbrandModal' 
                                role='button' 
                                data-id='$brandId'> 
                                <i class='fas fa-user-edit'></i> Edit Brand
                        </button>

                        <button class='btn btn-primary dropdown-item'
                                data-toggle='modal'
                                data-target='#brandInfoModal' 
                                role='button' 
                                data-id='$brandId'> 
                                <i class='fas fa-info-circle'></i> Brand Info
                        </button>";

                        // ✅ Delete condition
                        if (!$isMapped) {
                            echo "<button class='btn btn-danger dropdown-item'
                        data-toggle='modal'
                        data-target='#deletebrandModal'
                        role='button'
                        data-id='$brandId'>
                        <i class='fas fa-trash-alt'></i> Delete Brand
              </button>";
                        } else {
                            echo "<button class='btn btn-secondary dropdown-item' disabled>
                        <i class='fas fa-ban'></i> Cannot Delete ( Brand is Mapped )
              </button>";
                        }

                        echo "      </div>
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

<div class="modal fade" id=brandModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog ">
        <form method="post" id="brand_form" enctype="multipart/form-data" action="../Controller/brandcontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="brandname" id="brandname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">InputType <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-secondary">
                                        Select InputTypes
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
                            <div class="col-md-8">
                                <input type="hidden" name="brandmodifiedby" id="brandmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="brandcreatedby" id="brandcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="origin" value="brand_page">

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
<div class="modal fade" id=editbrandModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="editbrand_form" enctype="multipart/form-data"
            action="../Controller/brandcontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="brandname" id="editedbrandname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                            <input type="hidden" id="editBrandId" name="editBrandId">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">InputType <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-secondary">
                                        Select InputTypes
                                    </button>
                                    <button type="button"
                                        class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropright</span>
                                    </button>
                                    <ul class="dropdown-menu" id="editcheckboxes">

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="brandmodifiedby" id="brandmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="brandcreatedby" id="brandcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
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
<div class="modal fade" id=brandInfoModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Brand Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="displayBrandName">Brand Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="card-title" id="displayBrandName"></h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompgstin">Input Type</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="mappedInputType"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id=deletebrandModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Brand</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this brand record.
                    </p>
                    <input type="hidden" name="brandid" id="brandid" value="">
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

        $('#brand_table tbody').on('click', 'tr', function () {
            debugger;
            /* Get the row as a parent of the link that was clicked on */
            $('#editBrandId').val(this.cells[0].innerHTML);
            $('#editedbrandname').val(this.cells[1].innerHTML);
            $('#displayBrandName').text(this.cells[1].innerHTML);
        });


        $('#brandInfoModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $("#mappedInputType").find("ul").remove();
            var fetchInputTypeurl = config.developmentPath + "/Admin/Controller/inputTypeController.php?brandId=" +
                rowid;
            console.log(fetchInputTypeurl);
            $.getJSON(fetchInputTypeurl, function (data) {
                $.each(data, function (index, value) {
                    if (value.isMapped) {
                        $('#mappedInputType').append(
                            $(document.createElement('ul')).prop({
                                class: 'list-group list-group-flush'
                            }).append(
                                $(document.createElement('li')).prop({
                                    class: 'list-group-item'
                                })).html(value.InputType).append(
                                    document.createElement('br')));
                    }
                });
            });
        });

        var fetchinputtypeurl = config.developmentPath + "/Admin/Controller/inputTypeController.php";
        $.getJSON(fetchinputtypeurl, function (data) {
            $.each(data, function (index, value) {
                $('#checkboxes').append(
                    $(document.createElement('li')).prop({
                        class: 'form-check form-switch'
                    }).append(
                        $(document.createElement('input')).prop({
                            class: 'form-check-input me-1',
                            id: 'myCheckBox',
                            name: 'inputtype_list[]',
                            value: value.InputTypeId,
                            type: 'checkbox'
                        })).append(
                            $(document.createElement('label')).prop({
                                for: 'myCheckBox'
                            }).html(value.InputType)
                        ).append(document.createElement('br')));
            });
        });

        $('#editbrandModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#brandid').val(rowid);
            $('#editcheckboxes').empty();
            var fetchinputtypeurl = config.developmentPath + "/Admin/Controller/inputTypeController.php?brandId=" + rowid;
            $.getJSON(fetchinputtypeurl, function (data) {
                $.each(data, function (index, value) {
                    let checked = value.isMapped === true || value.isUsed === true;
                    let disabled = value.isUsed === true;


                    $('#editcheckboxes').append(
                        $('<li>', { class: 'form-check form-switch' }).append(
                            $('<input>', {
                                class: 'form-check-input me-1',
                                id: 'editedmyCheckBox_' + value.InputTypeId,
                                name: 'inputtype_list[]',
                                checked: checked,
                                disabled: disabled,
                                value: value.InputTypeId,
                                type: 'checkbox'
                            })

                        ).append(
                            $('<label>', {
                                for: 'editedmyCheckBox_' + value.InputTypeId
                            }).html(value.InputType)
                        ).append('<br>')
                    );

                });
            });
        });
        var dataTable = $('#brand_table').DataTable({

        });

        var nEditing = null;

        $('#brand_table tbody').on('click', 'tr', function () {
            /* Get the row as a parent of the link that was clicked on */

        });

        // $('#editbutton').click(function(event) {
        //     debugger;
        //     var formData = {
        //         brandid: $('#brandid').val(),
        //         brandname: $('#editedbrandname').val(),
        //         inputtype_list: [$('#editcheckboxes').val()],

        //         brandcreatedby:$('#brandcreatedby').val(),
        //         brandmodifiedby:$('#brandmodifiedby').val(),
        //     };
        //     console.log($('#editcheckboxes').val());
        //     $.ajax({
        //         type: "POST",
        //         url: config.developmentPath + "/Admin/Controller/brandcontroller.php/",
        //         data: formData,
        //         dataType: "json",
        //         encode: true,
        //         editBrandId:'editBrandId'
        //     }).done(function(data) {
        //         console.log(data);
        //     });
        // });
        $('#editbrand_form').submit(function (event) {
            event.preventDefault();
            debugger;

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/brandcontroller.php",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {

                console.log(data);

                // 1️⃣ Close the modal
                $('#editbrandModal').modal('hide');

                // 2️⃣ Show success message
                $('#message').html(
                    "<div class='alert alert-success'>Brand updated successfully</div>"
                );

                // 3️⃣ Auto clear message
                setTimeout(() => $('#message').html(''), 4000);

                // 4️⃣ Reload table if needed
                // dataTable.ajax.reload();

            });
        });
        $('#brand_form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/brandcontroller.php",
                data: formData,
                processData: false,
                contentType: false,

                success: function (res) {
                    let json;

                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {
                        // SHOW SUCCESS MESSAGE INSIDE MODAL
                        $('#form_message').html(
                            '<div class="alert alert-success">Brand added successfully!</div>'
                        );

                        // WAIT FOR USER TO READ THE MESSAGE
                        setTimeout(function () {

                            // CLOSE MODAL
                            $('#brandModal').modal('hide');

                            // FIX BACKDROP GHOST BUG
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // RESET FORM
                            $('#brand_form')[0].reset();

                        }, 600);
                    }
                    else {
                        $('#form_message').html(
                            `<div class='alert alert-danger'>${json.message || "Error while adding brand"}</div>`
                        );
                    }
                },

                error: function (xhr, status, error) {
                    $('#form_message').html(`<div class='alert alert-danger'>AJAX Error: ${error}</div>`);
                }
            });
        });



        $('#deletebrandModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#brandid').val(rowid);
        });
        $('#deletebutton').click(function () {
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/brandcontroller.php/",
                method: "POST",
                data: {
                    id: $('#brandid').val(),
                    action: 'delete'
                },
                success: function (data) {
                    $('#message').html(data);
                    //dataTable.ajax.reload();
                    setTimeout(function () {
                        $('#message').html('');
                    }, 5000);
                }
            });
        });
    });
</script>