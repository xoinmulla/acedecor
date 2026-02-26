<?php
include('session.php');
include('itemallocationNavigation.php');
require_once("../DB Operations/projectOps.php");
require_once("../Model/projectModel.php");
require_once("../DB Operations/allocateitemsOps.php");

$allocationDetaiks=null;
$id=$_GET["id"];
$allocationDetaiks=DBproject::getAllprojectsbasedonId($id);

?>

<head>
    <style>
    .table {
        width: 94%;
        margin-bottom: 1 rem;
        margin-left: 3%;
        color: #858796;
    }
    </style>
</head>

<h1 class="h3 mb-4 text-gray-800">Project Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Project</h6>
            </div>
            <!-- <div class="col" align="right">
                <span data-toggle=modal data-target=#projectModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <form method="post" id="project_form">
            <div class="form-group">
                <div class="row">
                    <label class="col-md-2 text-right">Customer Name <span class="text-danger">*</span></label>

                    <div class="col-md-2">
                        <p id="AllocatecustomerName" class=""><?php echo  $allocationDetaiks->get_custName()?></p>
                        <input type="hidden" name="quoteid" id="quoteid" value="">
                    </div>
                    <input type="hidden" name="AllocateprojectId" id="AllocateprojectId" value="<?php echo  $id?>">
                    <label class="col-md-2 text-right">Customer Id <span class="text-danger">*</span></label>
                    <div class="col-md-2">
                        <p id="AllocatecustomerCode" class=""><?php echo  $allocationDetaiks->get_custid()?></p>
                    </div>
                    <label class="col-md-2 text-right">Quote Id. <span class="text-danger">*</span></label>
                    <div class="col-md-2">
                        <p id="AllocatequoteCode" class=""><?php echo  $allocationDetaiks->get_quotecode()?></p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">

                    <label class="col-md-2 text-right">Quantity <span class="text-danger">*</span></label>
                    <div class="col-md-2">
                        <p id="Allocatequantity" class=""><?php echo  $allocationDetaiks->getQuantity()?></p>
                    </div>
                    <label class="col-md-2 text-right">unit <span class="text-danger">*</span></label>
                    <div class="col-md-2">
                        <p id="AllocateUnit" class=""><?php echo  $allocationDetaiks->getUnitName()?></p>
                    </div>
                    <label class="col-md-2 text-right">Quote Type <span class="text-danger">*</span></label>
                    <div class="col-md-2">
                        <p id="AllocatequoteType" class=""><?php echo  $allocationDetaiks->get_quoteType()?></p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">

                    <label class="col-md-2 text-right">Quote For<span class="text-danger">*</span></label>
                    <div class="col-md-2 input-group">
                        <p id="AllocateQuoteFor" class="pad"><?php echo  $allocationDetaiks->getEnqCatName()?></p>

                    </div>

                    <!-- <label class="col-md-2 text-right">Total Amount<span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <p id="TotalAmount" class="pad"></p>
                                <span class=""> <i class="fas fa-rupee-sign"></i></span>
                            </div> -->

                    <label class="col-md-2 text-right">Quote Amount. <span class="text-danger">*</span></label>
                    <div class="col-md-2 input-group">
                        <span class="pad"> <i class="fas fa-rupee-sign"></i></span>
                        <p id="AllocateQuoteAmount" class="pad"><?php echo  $allocationDetaiks->get_quoteamt()?></p>
                    </div>
                    <label class="col-md-2 text-right">Project Code<span class="text-danger">*</span></label>
                    <div class="col-md-2 input-group">
                        <p id="Allocateprojectcode" class=""><?php echo  $allocationDetaiks->get_projectCode()?></p>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="Allocateitemlist-tab" data-bs-toggle="tab"
                        data-bs-target="#Allocateitemlist" type="button" role="tab" aria-controls="itemlist"
                        aria-selected="true"><b>Item List</b></button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="AllocateMatlist-tab" data-bs-toggle="tab"
                        data-bs-target="#AllocateMatlist" type="button" role="tab" aria-controls="Matlist"
                        aria-selected="true"><b>Material List</b></button>
                </li>

                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Allocateproducts-tab" data-bs-toggle="tab"
                        data-bs-target="#Allocateproducts" type="button" role="tab" aria-controls="products"
                        aria-selected="false"><b>Product List</b></button>
                </li> -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Allocateissues-tab" data-bs-toggle="tab"
                        data-bs-target="#Allocateissues" type="button" role="tab" aria-controls="issues"
                        aria-selected="false"><b>Issues</b></button>
                </li>

            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="Allocateitemlist" role="tabpanel"
                aria-labelledby="Allocateitemlist-tab">
                <table class="table table-bordered" id="AllocatelineItemTable" width="80%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none">StockId</th>
                            <th style="display:none">ItemId</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Available Quantity</th>
                            <th>Allocated Qty</th>   <!-- NEW -->
                            <th>Required Qty</th>    <!-- NEW -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $itemList=DBallocate::getLineItemByProjectId($id);
                        foreach ($itemList as $item) {
                            echo "<tr>
                            <td style=display:none>" . $item->getStockId() . "</td>
                            <td style=display:none>" . $item->get_itemid() . "</td>
                            <td><img src='../img/items/" . $item->getImage() . "' style='width:100px;height:100px;'></td>
                            <td>" . $item->getName() . "</td>
                            <td>" . $item->getBrand() . "</td>
                            <td class='quotationQty'>" . $item->get_itemquantity() . "</td>
                            <td>" . $item->getUnits() . "</td>
                            <td class='availableQty'>" . $item->get_AvailableQty() . "</td>
                            <td class='allocatedQty'>" . $item->getAllocatedQty() . "</td>
                            <td class='requiredQty'></td>
                            <td>
                            <button type='button' class='btn btn-secondary'";
                            if( $item->getAllocatedQty() >= $item->get_itemquantity() ) {
                                echo "data-toggle='modal'
                             data-target='#allocationModal'
                             data-id=" . $item->get_lineItemId() . " id='allocatebtn' disabled>
                             Allocate
                            </button>
                            ";}else{ 
                                echo "data-toggle='modal'
                             data-target='#allocationModal'
                             data-id=" . $item->get_lineItemId() . " id='allocatebtn'>
                             Allocate
                            </button>
                                ";}
                            echo "
                            </td></tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>

                <div class="form-group">
                    <div class="row">

                        <div class="col-md-8">
                            <input type="hidden" name="createdby" id="editedcreatedby" class="form-control" required
                                data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">

                        <div class="col-md-8">
                            <input type="hidden" name="modifiedby" id="editedmodifiedby" class="form-control" required
                                data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="action" id="action" value="Add" />
                            <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                            <a href="../View/ongoingprojects.php" class="btn btn-secondary" role="button">Back</a>
                            <!-- <button type="button" href="" class="btn btn-default" data-dismiss="modal">Back</button> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="AllocateMatlist" role="tabpanel" aria-labelledby="AllocateMatlist-tab">
                <div class="form-group">
                    <div class="row">
                        <table class="table table-bordered" id="AllocatelineItemTable" width="80%" cellspacing="0">
                            <thead>
                                <tr>

                                    <th style=display:none> StockId</th>
                                    <th style=display:none> ItemId</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <!-- <th>Description</th> -->
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Available Quantity</th>
                                    
                                    <th>Allocated Qty</th>
                                    <th>Required Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $MatList=DBallocate::getMaterialLineItemByProjectId($id);
                                        foreach ($MatList as $Mat) {
                                            echo "<tr><td style=display:none>" . $Mat->getStockId() . "</td>
                                            <td style=display:none>" . $Mat->get_itemid() . "</td>
                                            <td><img src='../img/items/" . $Mat->getImage() . "' style='width:100px;height:100px;'></td>
                                            <td>" . $Mat->getName() . "</td>
                                            <td>" . $Mat->getBrand() . "</td>
                                            <td class='quotationQty'>" . $Mat->get_itemquantity() . "</td>
                                            <td>" . $Mat->getUnits() . "</td>
                                            <td class='availableQty'>" . $Mat->get_AvailableQty() . "</td>
                                            <td class='allocatedQty'>" . $Mat->getAllocatedQty() . "</td>
                                            <td class='requiredQty'></td>
                                            <!--<td>" . $Mat->getPOStatus() . "</td>
                                            <td>" . $Mat->getInwardStatus() . "</td>-->
                                            <td>
                                            <button type='button' class='btn btn-secondary'";
                                                if( $Mat->getAllocatedStatus() == 1 || 
                                                    $Mat->get_AvailableQty() <= 0) {
                                                echo "data-toggle='modal'
                                                data-target='#allocationModal'
                                                data-id=" . $Mat->get_lineItemId() . " id='allocatebtn' disabled>
                                                    Allocate
                                            </button>
                                            ";}else{ 
                                                echo "data-toggle='modal'
                                                data-target='#allocationModal'
                                                data-id=" . $Mat->get_lineItemId() . " id='allocatebtn'>
                                                    Allocate
                                            </button>
                                            ";}
                                                echo "
                                            </td></tr>";
                                        }
                                    ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                        <div class="col-md-8">
                            <input type="hidden" name="createdby" id="editedcreatedby" class="form-control" required
                                data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="action" id="action" value="Add" />
                            <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="Allocateproducts" role="tabpanel" aria-labelledby="Allocateproducts-tab">
                <div class="form-group">
                    <div class="row">
                        <table class="table table-bordered" id="AllocatelineItemTable" width="80%" cellspacing="0">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                        <div class="col-md-8">
                            <input type="hidden" name="createdby" id="editedcreatedby" class="form-control" required
                                data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="action" id="action" value="Add" />
                            <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="Allocateissues" role="tabpanel" aria-labelledby="Allocateissues-tab">
                <div class="container">
                    <form method="post" id="followup_form" enctype="multipart/form-data" role="form"
                        action="../Controller/Project_IssuesController.php">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 text-right">Description</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" id="Description"
                                        style="height: 100px;text-transform:capitalize"
                                        data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup"
                                        name="Description"></textarea>
                                </div>

                                <label class="col-md-2 text-right">Contact Name</label>
                                <div class="col-md-4">
                                    <input type="text" name="ContName" id="ContName" class="form-control" required
                                        data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 text-right">Contact Number</label>
                                <div class="col-md-4">
                                    <input type="text" name="ContNumber" id="ContNumber" class="form-control" required
                                        data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                                <input type="hidden" name="projectCode" id="projectCode"
                            value=<?php echo  $allocationDetaiks->get_projectCode()?>>
                        <input type="hidden" name="projectId" id="projectId" value=<?php echo $id ?>>
                            </div>
                        </div>
                      

                        <div class="col-md-8">
                            <input type="hidden" name="createdby" id="editedcreatedby" class="form-control" required
                                data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />

                            <input type="hidden" name="modifiedby" id="editedmodifiedby" class="form-control" required
                                data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">FollowUp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=allocationModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="allocate_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Allocate Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to allocate this item.
                    </p>
                    <input type="hidden" name="AllocateprojectId" id="AllocateprojectId" value="<?php echo $id?>">
                    <input type="hidden" name="StockId" id="StockId" value="">
<input type="hidden" name="quantity" id="quantity" value="">
<input type="hidden" name="availableQty" id="availableQty" value="">                    <input type="hidden" name="itemid" id="itemid" value="">
                    <input type="hidden" name="lineitemid" id="lineitemid" value="">
                    <input type="hidden" name="AllocatedInputName" id="AllocatedInputName" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="allocatebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {

    $('#allocationModal').on('show.bs.modal', function(e) {
        debugger
        var rowid = $(e.relatedTarget).data('id');
        $('#lineitemid').val(rowid);

    });

    $('#AllocatelineItemTable tbody').on('click', 'tr', function() {

    let quotationQty = parseFloat(this.cells[5].innerHTML) || 0;
    let availableQty = parseFloat($(this).find('.availableQty').text()) || 0;

    $('#StockId').val(this.cells[0].innerHTML);
    $('#itemid').val(this.cells[1].innerHTML);
    $('#AllocatedInputName').val(this.cells[3].innerHTML);

    // IMPORTANT: allocate only available quantity
    $('#quantity').val(availableQty);
    $('#availableQty').val(availableQty);
});

    $('#allocate_form').submit(function(event) {
        debugger;
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath + "/Admin/Controller/allocateitemsController.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });
$('#AllocatelineItemTable tbody tr').each(function () {

    let qty = parseFloat($(this).find('.quotationQty').text()) || 0;
    let allocated = parseFloat($(this).find('.allocatedQty').text()) || 0;

    let required = qty - allocated;

    $(this).find('.requiredQty').text(required > 0 ? required : 0);
});



});
</script>