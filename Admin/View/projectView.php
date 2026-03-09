<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('projectNavigation.php');
require_once("../DB Operations/taskOps.php");
require_once("../Model/taskModel.php");
?>

<!-- <head>
    <style>
    .table {
        width: 94%;
        margin-bottom: 1 rem;
        margin-left: 3%;
        color: #858796;
    }
    </style>
</head> -->
<h1 class="h3 mb-4 text-gray-800">Project Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Project
                    Tasks</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#projectModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tasks_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style=display:none>Task Id</th>
                        <th>Date</th>
                        <th>Task Description</th>
                        <th>Contact Person</th>
                        <th>Contact No</th>
                        <th>Follow Up</th>
                        <th> Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $TaskList = DBTask::getAllTasks();
                    foreach ($TaskList as $Task) {
                        ?>
                        <tr>
                            <td style="display:none"><?= $Task->get_TaskId() ?></td>
                            <td><?= $Task->get_Date() ?></td>
                            <td><?= $Task->get_TaskDescription() ?></td>
                            <td><?= $Task->get_ContactPerson() ?></td>
                            <td><?= $Task->get_ContactNo() ?></td>
                            <td></td>
                            <td><?= $Task->get_Status() ?></td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu">

                                        <?php if (hasActionPermission('projects', 'task_followup')) { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#followUp" data-id="<?= $Task->get_TaskId() ?>">
                                                <i class="fas fa-user-edit"></i> FollowUp
                                            </button>
                                        <?php } ?>

                                        <?php if (hasActionPermission('projects', 'task_edit')) { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#editTask" data-id="<?= $Task->get_TaskId() ?>">
                                                <i class="fas fa-tasks"></i> Edit Task
                                            </button>
                                        <?php } ?>

                                        <?php if (hasActionPermission('projects', 'task_delete')) { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#deletetaskModal" data-id="<?= $Task->get_TaskId() ?>">
                                                <i class="fas fa-trash-alt"></i> Delete Task
                                            </button>
                                        <?php } ?>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=projectModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data" action="../Controller/taskController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Tasks</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-4 text-right" for="date" class="form-label">Date of Task<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Task Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="taskDescription" id="taskDescription" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Contact Person <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="contactPerson" id="contactPerson" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                            <input type="hidden" name="status" id="status" value="Open">
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Status <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">--Select an Option--</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>

                                </select>

                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Contact Number <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="contactNo" id="contactNo" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
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

<div class="modal fade" id="followUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <form method="post" id="followup_form" enctype="multipart/form-data"
            action="../Controller/taskfollowupController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Follow Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="followuptable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>

                                    Follwed By

                                </th>
                                <th>

                                    Comments

                                </th>
                                <th>

                                    Date

                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <legend>Comments:</legend>
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here"
                                            id="followcomment" style="height: 100px"
                                            data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup"
                                            name="followcomment"></textarea>
                                        <label for="followcomment">Comments</label>
                                    </div>
                                    <input type="hidden" name="taskfollowupid" id="taskfollowupid" value="">

                                    <fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="followupBy" id="followupBy" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value=<?php echo $_SESSION['login_user']; ?> />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="FollowupBtn">FollowUp</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=editTask tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="project_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        <legend>Task Info</legend>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-4 text-right" for="date" class="form-label">Date of Task<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="editeddate" name="editeddate" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Task Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedtaskDescription" id="editedtaskDescription"
                                    class="form-control" />
                                <input type="hidden" name="taskId" id="taskId" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Contact Person <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedcontactPerson" id="editedcontactPerson"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Contact Number <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedcontactNo" id="editedcontactNo" class="form-control"
                                    required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Status <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select" id="editedstatus" name="editedstatus" required>
                                    <option value="">--Select an Option--</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>

                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="editedcreatedby" id="editedcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="editedmodifiedby" id="editedmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deletetaskModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_task_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Task record.
                    </p>
                    <input type="hidden" name="deleteTaskId" id="deleteTaskId" value="">
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
        $(document).on('blur', '#followcomment', function () {
            debugger;
            if ($("#followcomment").val() == "") {
                $("#FollowupBtn").addClass('disabled');
            } else {
                $("#FollowupBtn").removeClass('disabled');
            }
        });
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;

        document.getElementById("date").value = today;


        var dataTable = $('#tasks_table').DataTable({
        });
        var nEditing = null;




        $('#tasks_table tbody').on('click', 'tr', function () {
            debugger;
            /* Get the row as a parent of the link that was clicked on */
            $('#taskId').val(this.cells[0].innerHTML);
            $('#taskfollowupid').val(this.cells[0].innerHTML);
            $('#deleteTaskId').val(this.cells[0].innerHTML);
            $('#editeddate').val(this.cells[1].innerHTML);
            $('#editedtaskDescription').val(this.cells[2].innerHTML);
            $('#editedcontactPerson').val(this.cells[3].innerHTML);
            $('#editedcontactNo').val(this.cells[4].innerHTML);
            // $('#editedstatus').val(this.cells[6].innerHTML);
        });

        $('#project_form').submit(function (event) {
            debugger;
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/taskController.php",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                console.log(data);
            });
            location.reload();
            // $('#editbutton').dispose();
            event.preventDefault();
        });

        $('#deletetaskModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#deleteTaskId').val(rowid);
        });

        $('#deletebutton').click(function () {
            debugger;
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/taskController.php/",
                method: "POST",
                data: {
                    id: $('#deleteTaskId').val(),
                    action: 'delete'
                },
                success: function (data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();
                    setTimeout(function () {
                        $('#message').html('');
                    }, 5000);
                }
            });
        });

        $('#followUp').on('show.bs.modal', function (e) {
            debugger;
            $('#FollowupBtn').addClass('disabled');
            var rowid = $(e.relatedTarget).data('id');
            $('#taskfollowupid').val(rowid);
            var contactUrl = config.developmentPath +
                "/Admin/Controller/taskfollowupController.php/?id=" +
                rowid;
            $.getJSON(contactUrl, function (data) {
                $("#followuptable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#followuptable tbody').
                        append($(document.createElement('tr')).prop({

                        }));

                    $('#followuptable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.FollowUp_Comments
                        }));
                    $('#followuptable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.FollowUp_createdBy
                        }));
                    $('#followuptable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.FollowUp_createdOn
                        }));
                });
            });
        });

    });
</script>