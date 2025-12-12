<?php
include('session.php');
include('materialNavigation.php');
require_once("../DB Operations/material_stocksOps.php");
require_once("../DB Operations/POlineitemOps.php");
require_once("../DB Operations/materialOps.php");
require_once("../Model/material_stocksModel.php");

?>
<style>
#editedPOlineMaterialTable {
    height: 200px;
    display: inline-block;
    width: 100%;
    overflow: auto;
}

#editedPOlineMaterialTable thead {
    background-color: grey;
    color: whitesmoke;
    position: sticky;
    top: 0;
}

.pad {
    padding-right: .5rem;
}
</style>
<h1 class="h3 mb-4 text-gray-800">Material Stock Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Material List With Issues </h6>
            </div>
            
        </div>
    </div>
    <div class="card-body">
        <div class="col-md-9">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-Material" role="presentation">
                    <button class="nav-link active" id="Issues-tab" data-bs-toggle="tab" data-bs-target="#Issues"
                        type="button" role="tab" aria-controls="Issues" aria-selected="true"><b>Issues</b></button>
                </li>

                <li class="nav-Material" role="presentation">
                    <button class="nav-link" id="PricingIssues-tab" data-bs-toggle="tab" data-bs-target="#PricingIssues"
                        type="button" role="tab" aria-controls="PricingIssues" aria-selected="false"><b>Pricing
                            Issues</b></button>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="Issues" role="tabpanel" aria-labelledby="Issues-tab">
                <br />
                <div class="table-responsive">
                    <table class="table table-bordered" id="quote_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style='display:none'>Material Stock Id</th>
                                <th style='display:none'>Material Id</th>
                                <th>Material Name</th>
                                <th style='display:none'>Purchase Order ID</th>
                                <th>Purchase Order Code</th>
                                <th>Invoice No</th>
                                <th>Status</th>
                                <th style='display:none'> FollowupId</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $stockList = DBMaterialStock::getMaterialStockList();
                    foreach ($stockList as $stockObj) {
                        echo "<tr>
                        <td style='display:none'>" . $stockObj->get_StockId() . "</td>
                        <td style='display:none'>" . $stockObj->get_MaterialId() . "</td>
                        <td>" . $stockObj->getMaterialname() . "</td>
                        <td style='display:none'>" . $stockObj->get_POID() . "</td>
                        <td >" . $stockObj->getPOcode() . "</td>
                        <td >" . $stockObj->get_InvoiceNo() . "</td>
                        <td style='display:none'>" . $stockObj->getfollowupId() . "</td>
                        <td>" . $stockObj->get_followupStatus() . "</td>
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
                            <button class='btn btn-primary dropdown-Material'
                            data-toggle='modal' 
                            data-target='#editIssuesModal' 
                            role='button' 
                            data-id='".$stockObj->get_MaterialId()."'>
                            <i class='fas fa-user-edit'></i> 
                                Edit
                           </button>

                           <button class='btn btn-primary dropdown-Material'
                           data-toggle='modal' 
                           data-target='#IssuesfollowupModal' 
                           role='button' data-id='" . $stockObj->get_MaterialId() . "'> 
                           <i class='fas fa-info-circle'></i>
                              Issues
                           </button>

                           <button class='btn btn-primary dropdown-Material'
                           data-toggle='modal' 
                           data-target='#deleteCategoryModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $stockObj->get_MaterialId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete 
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
            <div class="tab-pane fade " id="PricingIssues" role="tabpanel" aria-labelledby="PricingIssues-tab">
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered" id="priceissue_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style='display:none'>Material ID</th>
                                <th style='display:none'>Pricing Issue ID</th>
                                <th>POID</th>
                                <th>Invoice No</th>
                                <th>Supplier</th>
                                <th>Name</th>
                                <th>MRP</th>
                                <th>Received Price</th>
                                <th>Paid Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $MaterialList = DBMaterialStock::getallMaterialsWithHighPrices();
                    foreach ($MaterialList as $Materials) {
                        echo "<tr><td style='display:none'>" . $Materials->get_MaterialId() . "</td>
                        <td style='display:none'>" . $Materials->getPricingIssues_Id() . "</td>
                        <td>" . $Materials->getPOcode() . "</td>
                        <td>" . $Materials->get_InvoiceNo() . "</td>
                        <td >" . $Materials->get_SupplierName() . "</td>
                        <td >" . $Materials->getMaterialname() . "</td>
                        <td >" . $Materials->get_price() . "</td>
                        <td> " . $Materials->get_LineMaterialPrice() . "</td>
                        <td style='background-color:red;color:black'>" . $Materials->get_ReceivedQtyAmt() . "</td>
                        <td>" . $Materials->getStatus() . "</td>
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
                            data-target='#editPricingIssuesModal' 
                            role='button' 
                            data-id='".$Materials->get_MaterialId()."'>
                            <i class='fas fa-user-edit'></i> 
                                Edit
                           </button>

                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deletePricingIssuesModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $Materials->get_MaterialId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete 
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
    </div>
</div>
<?php include('footer.php'); ?>

<div class="modal fade" id=editIssuesModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog ">
        <form method="POST" id="editedIssues_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Issues</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Material Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedMaterialName" id="editedMaterialName" class="form-control"
                                    readonly />
                                <input type="hidden" name="followupId" id="followupId" value="">
                                <input type="hidden" name="POcode" id="POcode" value="">
                                <input type="hidden" name="followupPOID" id="followupPOID" value="">
                                <input type="hidden" name="purchaseddate" id="purchaseddate" value="">
                                <input type="hidden" name="supplier" id="supplier" value="">
                                <input type="hidden" name="MaterialId" id="MaterialId" value="">
                                <input type="hidden" name="unitFactor" id="unitFactor" value="">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4 text-right">Status<span class="text-danger">*</span></label>
                        <div class="col-md-8 input-group">
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
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id=editPricingIssuesModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog ">
        <form method="POST" id="editedPricingIssues_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Issues</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Material Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedPriceMaterialName" id="editedPriceMaterialName"
                                    class="form-control" readonly />
                                <input type="hidden" name="PricingIssueId" id="PricingIssueId" value="">
                                <input type="hidden" name="POcode" id="POcode" value="">
                                <input type="hidden" name="PricingPOID" id="PricingPOID" value="">
                                <input type="hidden" name="purchaseddate" id="purchaseddate" value="">
                                <input type="hidden" name="MaterialId" id="MaterialId" value="">
                                <input type="hidden" name="invoiceNo" id="invoiceNo" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Supplier Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedPriceSupplierName" id="editedPriceSupplierName"
                                    class="form-control" readonly />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Status<span class="text-danger">*</span></label>
                            <div class="col-md-8 input-group">
                                <select class="form-select" id="editedPricestatus" name="editedPricestatus" required>
                                    <option value="">--Select an Option--</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>

                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                value="<?php echo $_SESSION['login_user']; ?>" />
                            <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                value="<?php echo $_SESSION['login_user']; ?>" />
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

<div class="modal fade" id="IssuesfollowupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <form method="post" id="followup_form" enctype="multipart/form-data"
            action="../Controller/MatIssues_followupcontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Issue Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="Issuesfollowuptable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>

                                    Followed By

                                </th>
                                <th>

                                    Issues

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
                            <div class="col-md-8">
                                <input type="hidden" name="followupBy" id="followupBy" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value=<?php echo $_SESSION['login_user']; ?> />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deleteMaterialModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_material_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Material</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Material.
                    </p>
                    <input type="hidden" name="MaterialId" id="deleteMaterialId" value="">
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
    $('#IssuesfollowupModal').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $('#followupMaterialId').val(rowid);
        var POID = 0;
        var contactUrl = config.developmentPath +
            "/Admin/Controller/MatIssues_followupController.php/?id=" +
            rowid + "&POID=" + POID;
        $.getJSON(contactUrl, function(data) {
            $("#Issuesfollowuptable").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#Issuesfollowuptable tbody').
                append($(document.createElement('tr')).prop({
                    id: value.followupPOID
                }));

                $('#Issuesfollowuptable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.followup_by
                }));
                $('#Issuesfollowuptable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.followup_comments
                }));
                $('#Issuesfollowuptable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.followup_on
                }));
            });
        });
    });

    $('#AllocateModal').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $('#followupMaterialId').val(rowid);
        var contactUrl = config.developmentPath +
            "/Admin/Controller/allocateMaterialsController.php/?id=" +
            rowid;
        $.getJSON(contactUrl, function(data) {
            $("#Allocationtable").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#Allocationtable tbody').
                append($(document.createElement('tr')).prop({
                    id: value.followupMaterialId
                }));

                $('#Allocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.CustomerName
                }));
                $('#Allocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.ProjectCode
                }));
                $('#Allocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.AllocatedQty
                }));
            });
        });
    });


    $('#editedIssues_form').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/MatIssues_followupcontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });

    $('#editedPricingIssues_form').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/MatPricingIssueController.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });


    var dataTable = $('#quote_table').DataTable({});
    var nEditing = null;

    var dataTable = $('#priceissue_table').DataTable({});
    var nEditing = null;

    var dataTable = $('#material_table').DataTable({});
    var nEditing = null;
    $('#quote_table tbody').on('click', 'tr', function() {
        debugger;
        /* Get the row as a parent of the link that was clicked on */
        $('#id').val(this.cells[0].innerHTML);
        $('#POcode').val(this.cells[1].innerHTML);
        $('#followupPOID').val(this.cells[3].innerHTML);
        $('#PricingPOID').val(this.cells[1].innerHTML);
        $('#MaterialId').val(this.cells[1].innerHTML);
        $('#purchaseddate').val(this.cells[2].innerHTML);
        $('#POtype').val(this.cells[3].innerHTML);
        $('#supplier').val(this.cells[4].innerHTML);
        $('#editedMaterialName').val(this.cells[2].innerHTML);
        $('#editedPriceMaterialName').val(this.cells[4].innerHTML);
        $('#displaySupplierName').val(this.cells[2].innerHTML);
        $('#editedPriceSupplierName').val(this.cells[3].innerHTML);
        $('#followupId').val(this.cells[6].innerHTML);
        $('#invoiceNo').val(this.cells[2].innerHTML);

    });
    $('#priceissue_table tbody').on('click', 'tr', function() {
        debugger;
        /* Get the row as a parent of the link that was clicked on */

        $('#POcode').val(this.cells[2].innerHTML);
        $('#PricingPOID').val(this.cells[2].innerHTML);
        $('#editedPriceMaterialName').val(this.cells[5].innerHTML.replace('&amp;', '&'));
        $('#editedPriceSupplierName').val(this.cells[4].innerHTML);
        $('#invoiceNo').val(this.cells[3].innerHTML);
        $('#PricingIssueId').val(this.cells[1].innerHTML);
    });



});
</script>