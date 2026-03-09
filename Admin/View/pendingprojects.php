<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('pendingprojectNavigation.php');
require_once("../DB Operations/projectOps.php");
require_once("../Model/projectModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Projects Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h5 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Pending
                    Projects List</h5>
            </div>
            <!-- <div class="col" align="right">
                <span data-toggle=modal data-target=#projectModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="projects_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style=display:none>Project Id</th>
                        <th>Project Code</th>
                        <th>Customer Name</th>
                        <th>Customer Code</th>
                        <th style=display:none>Quote Id</th>
                        <th>Quote Code</th>
                        <th style=display:none>Quote Type</th>
                        <th style=display:none>Quote For</th>
                        <th style=display:none>Quote Amount</th>
                        <th style=display:none>Quantity</th>
                        <th style=display:none>Unit</th>
                        <th>Project Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $projectList = DBproject::getAllprojectsbasedonPendingStatus();
                    foreach ($projectList as $project) {
                        ?>
                        <tr>
                            <td style="display:none"><?= $project->get_projectId() ?></td>
                            <td><?= $project->get_projectCode() ?></td>
                            <td><?= $project->get_custName() ?></td>
                            <td><?= $project->get_custid() ?></td>
                            <td style="display:none"><?= $project->get_quoteid() ?></td>
                            <td><?= $project->get_quotecode() ?></td>
                            <td style="display:none"><?= $project->get_quoteType() ?></td>
                            <td style="display:none"><?= $project->getEnqCatName() ?></td>
                            <td style="display:none"><?= $project->get_quoteamt() ?></td>
                            <td style="display:none"><?= $project->getQuantity() ?></td>
                            <td style="display:none"><?= $project->getUnitName() ?></td>
                            <td><?= $project->get_projectstatus() ?></td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu">

                                        <?php if (hasActionPermission('projects', 'pending_info')) { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#ProjectInfoModal" data-id="<?= $project->get_projectId() ?>">
                                                <i class="fas fa-info"></i> Project Info
                                            </button>
                                        <?php } ?>

                                        <?php if (hasActionPermission('projects', 'pending_allocate')) { ?>
                                            <a class="btn btn-primary dropdown-item"
                                                href="../View/ItemAllocation.php?id=<?= $project->get_projectId() ?>">
                                                <i class="fas fa-tasks"></i> Project Allocation
                                            </a>
                                        <?php } ?>

                                        <?php if (hasActionPermission('projects', 'pending_delete')) { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#deleteprojectsModal" data-id="<?= $project->get_projectId() ?>">
                                                <i class="fas fa-trash-alt"></i> Delete Project
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

<div class="modal fade" id=ProjectInfoModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form method="post" id="project_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit projects</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Customer Name <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <p id="customerName" class=""></p>
                                <input type="hidden" name="quoteid" id="quoteid" value="">
                            </div>
                            <label class="col-md-2 text-right">Customer Id <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <p id="customerCode" class=""></p>
                            </div>
                            <label class="col-md-2 text-right">Quote Id. <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <p id="quoteCode" class=""></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-2 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <p id="quantity" class=""></p>
                            </div>
                            <label class="col-md-2 text-right">unit <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <p id="Unit" class=""></p>
                            </div>
                            <label class="col-md-2 text-right">Quote Type <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <p id="quoteType" class=""></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-2 text-right">Quote For<span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <p id="QuoteFor" class="pad"></p>

                            </div>

                            <!-- <label class="col-md-2 text-right">Total Amount<span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <p id="TotalAmount" class="pad"></p>
                                <span class=""> <i class="fas fa-rupee-sign"></i></span>
                            </div> -->

                            <label class="col-md-2 text-right">Quote Amount. <span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <p id="QuoteAmount" class="pad"></p>
                                <span class=""> <i class="fas fa-rupee-sign"></i></span>
                            </div>
                            <label class="col-md-2 text-right">Project Code<span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <p id="projectcode" class=""></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-2 text-right"> Project Status<span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select name="projectStatus" id="editedprojectStatus" class="form-select">
                                    <option>-- select an option --</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>

                                </select>
                                <input type="hidden" name="projectId" id="projectId" value="">
                            </div>
                            <label class="col-md-2 text-right">Progress Note<span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <textarea class="form-control" placeholder="Leave a note here" id="progressNote"
                                    style="height: 100px" data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                    data-parsley-trigger="keyup" name="progressNote"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="itemlist-tab" data-bs-toggle="tab"
                                    data-bs-target="#itemlist" type="button" role="tab" aria-controls="itemlist"
                                    aria-selected="true"><b>Item List</b></button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="material-tab" data-bs-toggle="tab"
                                    data-bs-target="#material" type="button" role="tab" aria-controls="democlass"
                                    aria-selected="false"><b>Material List</b></button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="products-tab" data-bs-toggle="tab"
                                    data-bs-target="#products" type="button" role="tab" aria-controls="products"
                                    aria-selected="false"><b>Product List</b></button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ProjIssues-tab" data-bs-toggle="tab"
                                    data-bs-target="#ProjIssues" type="button" role="tab" aria-controls="issues"
                                    aria-selected="false"><b>Issues</b></button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active " id="itemlist" role="tabpanel"
                            aria-labelledby="itemlist-tab">
                            <table class="table table-bordered" id="editedlineItemTable" width="80%" cellspacing="0">
                                <thead>
                                    <tr>

                                        <th>Image</th>
                                        <th>Item Code</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Quantity</th>
                                        <th>Available Qty</th>
                                        <th>Allocated Qty</th>
                                        <th>Unit</th>
                                        <th>PO Status</th>
                                        <th>Inward Status</th>

                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-8">
                                        <input type="hidden" name="createdby" id="editedcreatedby" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-8">
                                        <input type="hidden" name="modifiedby" id="editedmodifiedby"
                                            class="form-control" required data-parsley-type="integer"
                                            data-parsley-minlength="10" data-parsley-maxlength="12"
                                            data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="hidden" name="action" id="action" value="Add" />
                                        <input type="submit" name="submit" id="editbutton" class="btn btn-success"
                                            value="Save" />
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="material" role="tabpanel" aria-labelledby="material-tab">
                            <table class="table table-bordered" id="editedMaterialTable" width="80%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Material Code</th>
                                        <th>Material Name</th>
                                        <th>Brand</th>
                                        <th>Quantity</th>
                                        <th>Available Qty</th>
                                        <th>Allocated Qty</th>
                                        <th>Unit</th>
                                        <th>PO Status</th>
                                        <th>Inward Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" name="createdby" id="editedcreatedby" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" name="modifiedby" id="editedmodifiedby"
                                            class="form-control" required data-parsley-type="integer"
                                            data-parsley-minlength="10" data-parsley-maxlength="12"
                                            data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="hidden" name="action" id="action" value="Add" />
                                        <input type="submit" name="submit" id="editbutton" class="btn btn-success"
                                            value="Save" />
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                            <div class="form-group">
                                <div class="row">
                                    <table class="table table-bordered" id="editedlineItemTable" width="80%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>

                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <!-- <th>Status</th> -->
                                                <!-- <th>TotalAmount</th>
                                                <th>TotalPrice</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                    <div class="col-md-8">
                                        <input type="hidden" name="createdby" id="editedcreatedby" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="hidden" name="action" id="action" value="Add" />
                                        <input type="submit" name="submit" id="editbutton" class="btn btn-success"
                                            value="Save" />
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-8">
                                        <input type="hidden" name="modifiedby" id="editedmodifiedby"
                                            class="form-control" required data-parsley-type="integer"
                                            data-parsley-minlength="10" data-parsley-maxlength="12"
                                            data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ProjIssues" role="tabpanel" aria-labelledby="ProjIssues-tab">
                            <div class="container">
                                <table class="table table-bordered" id="ProjectIssuesTable" width="80%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>

                                                Issue Created By

                                            </th>
                                            <th>

                                                Description

                                            </th>
                                            <th>
                                                Contact Name
                                            </th>
                                            <th>
                                                Contact Details
                                            </th>
                                            <th>

                                                Date

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <div class="col-md-8">
                                    <input type="hidden" name="createdby" id="editedcreatedby" class="form-control"
                                        required data-parsley-type="integer" data-parsley-minlength="10"
                                        data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                        value="<?php echo $_SESSION['login_user']; ?>" />
                                </div>

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <input type="hidden" name="modifiedby" id="editedmodifiedby"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="10" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteprojectsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_category_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Item Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this project record.
                    </p>
                    <input type="hidden" name="projectId" id="projectId" value="">
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
        $('#projects_table tbody').on('click', 'tr', function () {
            debugger;
            /* Get the row as a parent of the link that was clicked on */
            $('#projectId').val(this.cells[0].innerHTML);
            $('#projectcode').text(this.cells[1].innerHTML);
            $('#customerName').text(this.cells[2].innerHTML);
            $('#customerCode').text(this.cells[3].innerHTML);
            $('#quoteid').val(this.cells[4].innerHTML);
            $('#quoteCode').text(this.cells[5].innerHTML);
            $('#quoteType').text(this.cells[6].innerHTML);
            $('#QuoteFor').text(this.cells[7].innerHTML);
            $('#QuoteAmount').text(this.cells[8].innerHTML);
            $('#quantity').text(this.cells[9].innerHTML);
            $('#Unit').text(this.cells[10].innerHTML);
            $('#editedprojectStatus').val(this.cells[11].innerHTML);
        });

        $('#ProjectInfoModal').on('show.bs.modal', function (e) {
            var projId = $('#projectId').val();

            // $('#editLineItem').attr('href', 'lineItemView.php?id=' + rowid);
            var uniturl = config.developmentPath +
                "/Admin/Controller/itemListController.php?projId=" + projId;
            var sumTotalAmount = 0;
            var sumTotalPrice = 0;
            $.getJSON(uniturl, function (data) {

                $("#editedlineItemTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {

                    $('#editedlineItemTable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.lineItemId
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).append($(document
                            .createElement(
                                'img'))
                            .prop({
                                src: "../img/items/" + value.image,
                                style: "width:100px; height:100px",
                                class: 'img-fluid'
                            })));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.ItemCode
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Name
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Brand
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.itemquantity
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.AvailableQty
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.AllocatedQty
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Units
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.POStatus
                        }));

                    $('#editedlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.InwardStatus
                        }));
                    sumTotalAmount = sumTotalAmount + parseFloat(value.totalAmount);
                    sumTotalPrice = sumTotalPrice + parseFloat(value.totalPrice);
                });
                $('#sumTotalAmount').val(sumTotalAmount);
                $('#sumTotalPrice').val(sumTotalPrice);
                var uniturl = config.developmentPath + "/Admin/Controller/unitsContoller.php"
                $.getJSON(uniturl, function (data) {

                    $.each(data, function (index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        if (value.unitId == $('#unitId').val()) {
                            $('#unit').append('<option selected value="' + value
                                .unitId + '">' +
                                value.unitName + '</option>');
                        } else {
                            $('#unit').append('<option  value="' + value
                                .unitId +
                                '">' +
                                value.unitName + '</option>');
                        }
                    });
                });
            });

            var uniturl = config.developmentPath +
                "/Admin/Controller/materialListController.php?projId=" + projId;
            var sumTotalAmount = 0;
            var sumTotalPrice = 0;
            $.getJSON(uniturl, function (data) {

                $("#editedMaterialTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {

                    $('#editedMaterialTable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.lineItemId
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).append($(document
                            .createElement(
                                'img'))
                            .prop({
                                src: "../img/items/" + value.image,
                                style: "width:100px; height:100px",
                                class: 'img-fluid'
                            })));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.ItemCode
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Name
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Brand
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.itemquantity
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.AvailableQty
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.AllocatedQty
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Units
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.POStatus
                        }));

                    $('#editedMaterialTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.InwardStatus
                        }));
                    sumTotalAmount = sumTotalAmount + parseFloat(value.totalAmount);
                    sumTotalPrice = sumTotalPrice + parseFloat(value.totalPrice);
                });
                $('#sumTotalAmount').val(sumTotalAmount);
                $('#sumTotalPrice').val(sumTotalPrice);
                var uniturl = config.developmentPath + "/Admin/Controller/unitsContoller.php"
                $.getJSON(uniturl, function (data) {

                    $.each(data, function (index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        if (value.unitId == $('#unitId').val()) {
                            $('#unit').append('<option selected value="' + value
                                .unitId + '">' +
                                value.unitName + '</option>');
                        } else {
                            $('#unit').append('<option  value="' + value
                                .unitId +
                                '">' +
                                value.unitName + '</option>');
                        }
                    });
                });
            });

        });
        $('#ProjectInfoModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#projectId').val(rowid);
            var contactUrl = config.developmentPath +
                "/Admin/Controller/Project_IssuesController.php/?id=" +
                rowid;
            console.log(contactUrl);
            $.getJSON(contactUrl, function (data) {
                $("#ProjectIssuesTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#ProjectIssuesTable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.IssueId
                        }));

                    $('#ProjectIssuesTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Issue_createdby
                        }));
                    $('#ProjectIssuesTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Issue_Description
                        }));

                    $('#ProjectIssuesTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Issue_ContactName
                        }));
                    $('#ProjectIssuesTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Issue_ContactDetails
                        }));
                    $('#ProjectIssuesTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Issue_createdon
                        }));
                });
            });
        });
        var dataTable = $('#projects_table').DataTable({

        });

        var nEditing = null;

        // $('#projects_table tbody').on('click', 'tr', function() {
        //     /* Get the row as a parent of the link that was clicked on */
        //     $('#editedprojectStatus').val(this.cells[0].innerHTML);
        //     // $('#editedprogressNote').text(this.cells[1].innerHTML);
        // });
        $('#project_form').submit(function (event) {
            debugger;
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/projectController.php",
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
        $('#deleteprojectsModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#projectId').val(rowid);
        });
        $('#deletebutton').click(function () {
            debugger;
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/projectController.php/",
                method: "POST",
                data: {
                    id: $('#projectId').val(),
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
    });
</script>