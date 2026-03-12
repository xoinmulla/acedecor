<?php
include('session.php');
require_once("../DB Operations/dbconnection.php");

// ===== PERMISSION CHECK FIRST =====
$db = ConnectDb::getInstance();
$conn = $db->getConnection();

$user_name = $_SESSION['login_user'];
$user_type = $_SESSION['User_type']; // get role

// Only check permissions if NOT Admin
if ($user_type != 'Admin') {

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
        AND ma.action_key='po_view'
    ");

    if ($check->num_rows == 0) {
        header("Location: noaccess.php");
        exit;
    }
}
// ===== END PERMISSION CHECK =====


// SAFE TO LOAD UI NOW
include('POviewnavigation.php');
require_once("../DB Operations/purchaseorderOps.php");
require_once("../DB Operations/POlineitemOps.php");
require_once("../Model/purchaseModel.php");
?>
<style>
    #editedPOlineItemTable {
        height: 200px;
        display: inline-block;
        width: 100%;
        overflow: auto;
    }

    #editedPOlineItemTable thead {
        background-color: grey;
        color: whitesmoke;
        position: sticky;
        top: 0;
    }

    .pad {
        padding-right: .5rem;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Purchase Order Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Purchase
                    Order List</h6>
            </div>
            <!-- <div class="col" align="right">
                <span data-toggle=modal data-target=#purchaseModal>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="quote_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'> Purchase Order Id</th>
                        <th>Purchase Order ID</th>
                        <th>Purchased Date</th>
                        <th>PO type</th>
                        <th>Inventory</th>
                        <th style='display:none'>Supplier Id</th>
                        <th>Supplier Name</th>
                        <th>Total Quantity</th>
                        <th>Balance Quantity</th>
                        <th>Total Amount</th>
                        <th>Balance Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $purchaseList = DBpurchase::getAllpurchases();
                    foreach ($purchaseList as $purchaseObj) {
                        ?>

                        <tr>

                            <td style="display:none"><?= $purchaseObj->get_id(); ?></td>
                            <td><?= $purchaseObj->getPOcode(); ?></td>
                            <td><?= $purchaseObj->get_purchaseddate(); ?></td>
                            <td><?= $purchaseObj->getPOtype(); ?></td>
                            <td><?= $purchaseObj->getInventoryType(); ?></td>
                            <td style="display:none"><?= $purchaseObj->get_supplier(); ?></td>
                            <td><?= $purchaseObj->getSupplierName(); ?></td>
                            <td><?= $purchaseObj->getQuantity(); ?></td>
                            <td><?= $purchaseObj->getBalanceQuantity(); ?></td>
                            <td><?= $purchaseObj->get_totalAmount(); ?></td>
                            <td><?= $purchaseObj->getBalanceAmt(); ?></td>
                            <td><?= $purchaseObj->getStatus(); ?></td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>

                                    <div class="dropdown-menu">

                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#viewModal" data-id="<?= $purchaseObj->get_id(); ?>">
                                            <i class="fas fa-info-circle"></i>
                                            Purchase Order Info
                                        </button>

                                        <a class="btn btn-primary dropdown-item"
                                            href="../View/itemstocks.php?id=<?= $purchaseObj->get_id(); ?>">
                                            <i class="fas fa-layer-group"></i>
                                            Inward stock
                                        </a>

                                        <?php if ($purchaseObj->getPOStatus() == '1') { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#ResumePurchaseModal" data-id="<?= $purchaseObj->get_id(); ?>">
                                                <i class="far fa-pause-circle"></i>
                                                Resume Purchase Order
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#cancelPurchaseModal" data-id="<?= $purchaseObj->get_id(); ?>">
                                                <i class="far fa-times-circle"></i>
                                                Cancel Purchase Order
                                            </button>
                                        <?php } ?>

                                        <?php if ($purchaseObj->getHasInward() == 1) { ?>
                                            <button class="btn btn-secondary dropdown-item" disabled
                                                title="Cannot delete. Stock already inwarded">
                                                <i class="fas fa-trash-alt"></i>
                                                Delete Purchase Order
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-danger dropdown-item" data-toggle="modal"
                                                data-target="#deletePurchaseModal" data-id="<?= $purchaseObj->get_id(); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                                Delete Purchase Order
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

<div class="modal fade" id=viewModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Purchase Order Information</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    PO Details
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body row g-3">
                                    <div class="col-md-4">
                                        <label for="POcode" class="form-label">PurchaseOrder Id</label>
                                        <input id="POcode" name="POcode" class="form-control" required readonly />
                                        <!-- <input type="hidden" class="form-control" id="supplier"
                                            name="supplier" /> -->
                                    </div>
                                    <div class="col-md-4">
                                        <label for="POtype" class="form-label">PO Type</label>
                                        <input type="text" class="form-control" name="POtype" id="POtype" readonly>


                                    </div>
                                    <div class="col-md-4">
                                        <label for="SupplierName" class="form-label">Supplier Name</label>
                                        <input type="text" class="form-control" name="displaySupplierName"
                                            id="displaySupplierName" readonly>


                                    </div>
                                    <div class="col-md-4">
                                        <label for="purchaseddate" class="form-label">Date of Purchase</label>
                                        <input type="date" class="form-control" id="purchaseddate" name="purchaseddate"
                                            readonly>
                                    </div>

                                    <!-- <div class="col-md-4">
                                        <label for="Projectcode" class="form-label">Project Id</label>
                                        <input id="Projectcode" name="Projectcode" class="form-control" required readonly />
                                        <input type="hidden" class="form-control" id="supplier"
                                            name="supplier" />
                                    </div> -->
                                    <div class="col-md-4">
                                        <label for="quotecustomerEmail" class="form-label">Total Amount</label>
                                        <input type="text" class="form-control" id="displayTotalAmount"
                                            name="displayTotalAmount" readonly>
                                    </div>

                                    <div class="col-md-8">
                                        <input type="hidden" name="createdby" id="createdby" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                    <div class="col-md-8">
                                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Item Details
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <table class="table table-bordered" id="displayPOlineItemTable" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Item Image</th>
                                                <th>Item Code</th>
                                                <th>Name</th>
                                                <th>Brand</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Unit </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                    <div class="form-group">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                                    <input type="hidden" name="action" id="action" value="Add" />
                                    <a name="button" id="editPOLineItem" class="btn btn-success">Edit </a>
                                    <a name="button" id="printPDF" class="btn btn-success">Print/Save as PDF</a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=editpurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Purchase Order Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_message"></span>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4 text-right">Supplier Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="editedSupplierName" id="editedSupplierName" class="form-control"
                                readonly />
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="POcode" id="POcode" value="">
                            <input type="hidden" name="purchaseddate" id="purchaseddate" value="">
                            <input type="hidden" name="supplier" id="supplier" value="">
                            <input type="hidden" name="itemid" id="itemid" value="">
                            <input type="hidden" name="unitFactor" id="unitFactor" value="">
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 text-right">Total Amount<span class="text-danger">*</span></label>
                    <div class="col-md-8 input-group">
                        <input id="editedTotalAmount" name="editedTotalAmount" class="form-control" required readonly />
                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                    </div>
                </div>
            </div>


            <table class="table table-bordered" id="editedPOlineItemTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
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
                <a name="button" id="editPOLineItem" class="btn btn-success">Edit Line Item</a>
                <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id=itemListModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemListForm" enctype="multipart/form-data" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Item List Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="printtopdf">
                        <div class="card">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>
                                            ACE DECORS
                                        </td>
                                        <td>
                                            <p id='customerCode'></p>
                                        </td>
                                        <td>
                                            <p id='listquoteCode'></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="POlineItemTable" width="100%" cellspacing="0">
                                <thead class="table-dark">
                                    <tr>

                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit </th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
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
                </div>
                <div class="modal-footer">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Water
                            Mark</label>
                    </div>
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="PDF" class="btn btn-success" value="Save AS PDF" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=cancelPurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Cancel Purchase Order</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. You would like to cancel this purchase order.
                    </p>
                    <input type="hidden" name="id" id="id" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="cancelbutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=ResumePurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Resume Purchase Order</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. You would like to resume this purchase order.
                    </p>
                    <input type="hidden" name="id" id="id" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="resumebtn" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deletePurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Purchase Order</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this purchase order.
                    </p>
                    <input type="hidden" name="id" id="id" value="">
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
        // var waterMarked = false;
        // $('#flexSwitchCheckDefault').on('click', function(e) {
        //     if ($(this).attr('checked') != 'checked') {
        //         $(this).attr('checked', 'checked');
        //         waterMarked = true;
        //     } else {
        //         $(this).removeAttr('checked');
        //         waterMarked = false;
        //     }
        // })
        // $('#itemListForm').submit(function(e) {
        //     var content = $('#printtopdf').html();
        //     var fileName = $('#customerCode').text() + $('#listquoteCode').text();
        //     var uniturl = config.developmentPath +
        //         "/Admin/Controller/pdfGeneratorContorller.php";
        //     $.ajax({
        //         type: "POST",
        //         url: uniturl,
        //         data: {
        //             "modifiedby": $('#modifiedby').val(),
        //             "quoteId": $('#quoteid').val(),
        //             "fileType": "itemList",
        //             "waterMarked": waterMarked,
        //             "fileName": fileName,
        //             "html": content
        //         },
        //         dataType: "json",
        //         encode: true,
        //     }).done(function(data) {
        //         console.log(data);
        //     });
        // });

        $('#editpurchaseModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            debugger;
            $('#id').val(rowid);
            $('#editPOLineItem').attr('href', 'POlineitemview.php?id=' + rowid);
            var uniturl = config.developmentPath +
                "/Admin/Controller/POitemlistcontroller.php?id=" + rowid;

            $.getJSON(uniturl, function (data) {
                $("#editedPOlineItemTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#editedPOlineItemTable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.Id

                        }));
                    $('#editedPOlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Name
                        }));

                    $('#editedPOlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Brand
                        }));


                    $('#editedPOlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Description
                        }));


                    $('#editedPOlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.quantity
                        }));

                    $('#editedPOlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.unitName
                        }));




                });

            });
        });


        $('#viewModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#printPDF').attr('href', 'printPurchase.php?id=' + rowid);
            $('#editPOLineItem').attr('href', 'POlineitemview.php?id=' + rowid);
            var uniturl = config.developmentPath +
                "/Admin/Controller/POitemlistcontroller.php?id=" + rowid;

            $.getJSON(uniturl, function (data) {
                $("#displayPOlineItemTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    console.log("PO View Data:", data);

                    $('#displayPOlineItemTable tbody').append(
                        $('<tr>', { id: value.POlineitemId })
                            .append($('<td>').append(
                                $('<img>', {
                                    src: "../img/items/" + value.ItemImage,
                                    style: "width:100px; height:100px",
                                    class: "img-fluid"
                                })
                            ))
                            .append($('<td>').text(value.Itemcode))
                            .append($('<td>').text(value.Name))
                            .append($('<td>').text(value.Brand))
                            .append($('<td>').text(value.Description))
                            .append($('<td>').text(value.quantity))
                            .append($('<td>').text(value.unitName))
                    );
                });
            });
        });

        var dataTable = $('#quote_table').DataTable({});
        var nEditing = null;
        $('#quote_table tbody').on('click', 'tr', function () {
            debugger;
            /* Get the row as a parent of the link that was clicked on */
            $('#id').val(this.cells[0].innerHTML);
            $('#POcode').val(this.cells[1].innerHTML);
            $('#purchaseddate').val(this.cells[2].innerHTML);
            $('#POtype').val(this.cells[3].innerHTML);
            $('#supplier').val(this.cells[5].innerHTML);              // Supplier ID (hidden)
            $('#editedSupplierName').val(this.cells[6].innerHTML);   // Supplier Name
            $('#displaySupplierName').val(this.cells[6].innerHTML);  // Supplier Name

            $('#editedTotalAmount').val(this.cells[9].innerHTML);    // Total Amount
            $('#displayTotalAmount').val(this.cells[9].innerHTML);   // Total Amount

            // if (this.cells[11].innerHTML != "") {
            //     $('#downloadPOLineItem').attr('href', '../pdfs/itemList/' + this.cells[11].innerHTML);
            // } else {
            //     $('#downloadPOLineItem').removeAttr('target');
            //     $('#downloadPOLineItem').attr('onclick', 'alert("Please save the Item List as PDF")');
            // }
            // if (this.cells[12].innerHTML != "") {

            //     $('#downloadPO').attr('href', '../pdfs/quotations/' + this.cells[12].innerHTML);
            // } else {
            //     $('#downloadPO').removeAttr('target');
            //     $('#downloadPO').attr('onclick', 'alert("Please save the Quotation as PDF")');
            // }
        });

        $('#InwardModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#Id').val(rowid);
            // reloadloadItemTable(rowid);
        });

        $('#itemListModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#Id').val(rowid);
            reloadloadItemTable(rowid);
        });

        function reloadloadItemTable(rowid) {
            debugger;
            var uniturl = config.developmentPath +
                "/Admin/Controller/POitemlistcontroller.php?id=" + rowid;
            $.getJSON(uniturl, function (data) {
                $("#POlineItemTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#POlineItemTable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.POlineItemId

                        }));

                    $('#POlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Name
                        }));

                    $('#POlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Brand
                        }));

                    $('#POlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Description
                        }));



                    $('#POlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.quantity
                        }));
                    $('#POlineItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.unitName
                        }));
                });
            });
        }

        $('#cancelPurchaseModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#id').val(rowid);
        });
        $('#cancelbutton').click(function () {
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/purchaseordercontroller.php/",
                method: "POST",
                data: {
                    id: $('#id').val(),
                    action: 'cancel'
                },
                success: function (data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();

                }
            });
        });

        $('#ResumePurchaseModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#id').val(rowid);
        });
        $('#resumebtn').click(function () {
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/purchaseordercontroller.php/",
                method: "POST",
                data: {
                    id: $('#id').val(),
                    action: 'resume'
                },
                success: function (data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();

                }
            });
        });
        $('#deletePurchaseModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#id').val(rowid);
        });
        $('#deletebutton').click(function () {
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/purchaseordercontroller.php/",
                method: "POST",
                data: {
                    id: $('#id').val(),
                    action: 'delete'
                },
                success: function (data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();

                }
            });
        });


    });
</script>