<?php
include('session.php');
include "purchaseorderheader.php";
include('../DB Operations/POlineitemOps.php');
include('../DB Operations/purchaseorderOps.php');
include('../DB Operations/item_compdetailsOps.php');
$id = $_GET['id'];
?>
<style>
    .card-body #lineItem_table th{
        font-weight: 500;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Purchase Order Management</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-white"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;"">
        <div class=" row">
        <div class="col">
            <h5 class="m-0 text-white">Edit PO List</h5>
        </div><br><br>
        <div class="col" align="right">

            <!-- <button type="submit" class="btn btn-primary btn-circle btn-sm" id="Save" formnovalidate="off"><i
                        class="fas fa-save"></i></button> -->

            <span data-toggle=modal data-target=#AddModal data-id=<?php echo $id ?> <button type="button"
                class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
            </span>
        </div>

    </div>

    <?php $purchaseList = DBpurchase::GetPurchaseOrderBasedOnId($id) ?>
    <?php $inventoryType = $purchaseList->getInventoryType(); ?>

    <input type="hidden" id="inventoryType" value="<?php echo $inventoryType; ?>">

    <fieldset>

        <div class="row">
            <div class="col">
                <label>Supplier Name :
                    <span><?php echo $purchaseList->getSupplierName() ?></span>
                </label>
            </div>
            <br><br>
            <div class="col">
                <label>Supplier Address :
                    <span><?php echo $purchaseList->getSupplierAddress() ?></span>
                </label>
            </div>
            <div class="col">
                <label>Supplier location :
                    <span><?php echo $purchaseList->getSupplierLocation() ?></span>
                </label>
            </div>


        </div>
        <div class="row">
            <div class="col">
                <label>PO Type :
                    <span><?php echo $purchaseList->getPOtype() ?></span>
                </label>
            </div>
            <div class="col">
                <label>PO Id :
                    <span>
                        <?php echo $purchaseList->getPOcode() ?>
                    </span>
                </label>
            </div>
            <div class="col">
                <label>Date of Purchase :
                    <span><?php echo $purchaseList->get_purchaseddate() ?></span>
                </label>
            </div>

        </div>

</div>
</fieldset>


<div class="card-body">
    <div class="container-fluid px-0">
        <div class="responsive-table-container">
            <table class="table table-bordered" id="lineItem_table" width="100%" cellspacing="0">
                <thead align='center'>
                    <tr>
                        <th style='display:none'>POlineitem ID</th>
                        <th style='display:none'>Supplier ID</th>
                        <th style='display:none'>POID</th>
                        <th style="width: 500px; font-weight: 500;">Name</th>
                        <th style="font-weight: 500;">Code</th>
                        <th style="font-weight: 500;">Brand</th>
                        <th style="font-weight: 500;">MRP</th>
                        <th style='width: 100px; font-weight: 500;'>Quantity</th>

                        <!-- <th> Price</th>
                        <th>Total Amount</th> -->
                        <th style='display:none'>Item Category</th>
                        <th style='display:none'>Item Sub Category</th>
                        <th style='display:none'>Unit factor</th>
                        <th style="font-weight: 500;">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $POListItem = DBPOLineItem::getLineItemByPurchaseIdForOrder($id);
                    foreach ($POListItem as $Item) {
                        echo "<tr>
                        <td style='display:none'>" . $Item->get_POlineitemId() . "</td>
                        <td style='display:none' id='supplierid'>" . $Item->get_supplierId() . "</td>
                        <td style='display:none' id='Pid'>" . $Item->get_POID() . "</td>
                        <td>" . $Item->getName() . "</td>
                        <td style='text-align: center;'>" . $Item->getItemCode() . "</td>
                        <td style='text-align: center;'>" . $Item->getBrand() . "</td>
                        <td style='text-align: center;'>" . $Item->get_PPMRP() . "</td>

                        <td ><input class='form-control' readonly type='text' id= 'quantity_" . $Item->get_POlineitemId() . "' name='quantity' value='" . $Item->get_quantity() . "'/>
                        <input type='hidden' id='POlineitemId' name='POlineitemId' value='" . $Item->get_POlineitemId() . "'/></td>
                        <!-- <td >
                        <input class='form-control' readonly type='text' id= 'price_" . $Item->get_POlineitemId() . "' name='price' value='" . $Item->get_price() . "'/>
                        <input type='hidden' id='POlineitemId' name='POlineitemId' value='" . $Item->get_POlineitemId() . "'/>
                        
                        </td> -->
                        <td style='display:none'>" . $Item->getItemcatname() . "</td>
                        <td style='display:none'>" . $Item->getItemsubcatname() . "</td>
                        <td style='display:none'>" . $Item->getunitName() . "</td>
                        <td style='text-align: center;'> 

                        <a class='btn btn-warning editQuantityBtn'
                        href='#'
                        data-id=" . $Item->get_POlineitemId() . "
                        data-qty=" . $Item->get_quantity() . ">
                            <i class='fas fa-pencil-alt' style='color: black;'></i>
                        </a>                        
                        <button class='btn btn-danger'
                          data-toggle='modal' 
                          data-target='#deleteLineItemModal' 
                          role='button' 
                          data-id='" . $Item->get_POlineitemId() . "'>
                           <i class='fas fa-trash-alt'></i>
                         </button>
                       </td> </tr>";
                    }

                    ?>


                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php include('footer.php'); ?>
<style>
    /* =========================================================
       RESPONSIVE PURCHASE ORDER LINE ITEM PAGE
       ========================================================= */

    html,
    body {
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Keep the main DataTable inside its own horizontal scroller. */
    .responsive-table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: visible;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    #lineItem_table {
        min-width: 900px;
        width: 100% !important;
        margin-bottom: 0;
    }

    #lineItem_table th,
    #lineItem_table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    #lineItem_table th:nth-child(4) {
        min-width: 220px;
    }

    #lineItem_table th:nth-child(8),
    #lineItem_table td:nth-child(8) {
        min-width: 110px;
    }

    #lineItem_table th:last-child,
    #lineItem_table td:last-child {
        min-width: 120px;
        text-align: center;
    }

    /* Supplier / PO information header */
    .po-info-row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -10px;
        margin-right: -10px;
    }

    .po-info-row>.col,
    .po-info-row>[class*="col-"] {
        flex: 1 1 30%;
        min-width: 220px;
        padding: 5px 10px;
    }

    .po-info-row label {
        margin-bottom: 0;
        line-height: 1.5;
        word-break: break-word;
    }

    /* Modal base */
    .modal-dialog {
        width: auto;
        max-width: calc(100vw - 30px);
        margin: 1.75rem auto;
    }

    .modal-content {
        max-width: 100%;
        overflow: hidden;
        border-radius: 8px;
    }

    .modal-header.drag-header {
        cursor: move;
        user-select: none;
        -webkit-user-select: none;
        touch-action: none;
    }

    .modal-title {
        overflow-wrap: anywhere;
    }

    .modal-body {
        max-height: calc(100vh - 190px);
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .modal-footer {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: flex-end;
    }

    .modal-footer>* {
        margin: 0 !important;
    }

    /* Wide tables inside any modal */
    .modal .table-responsive,
    .modal .responsive-table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Prevent forms from becoming wider than the viewport. */
    .modal form,
    .modal .form-group,
    .modal .row {
        max-width: 100%;
    }

    .modal select.form-control,
    .modal select.form-select,
    .modal input.form-control {
        min-width: 0;
        max-width: 100%;
    }

    /* Desktop/tablet */
    @media (min-width: 768px) {
        #AddModal .modal-dialog {
            max-width: min(800px, calc(100vw - 40px));
        }

        #EditQuantityModal .modal-dialog {
            max-width: 500px;
        }

        #deleteLineItemModal .modal-dialog {
            max-width: 500px;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        h1.h3 {
            font-size: 1.15rem;
            margin-bottom: 1rem !important;
        }

        .card {
            width: 100%;
            margin-bottom: 1rem;
        }

        .card-header {
            padding: .75rem !important;
        }

        .card-header .row {
            align-items: center;
        }

        .card-header h6 {
            font-size: 1rem !important;
        }

        fieldset {
            padding: 10px !important;
        }

        .po-info-row {
            margin-left: 0;
            margin-right: 0;
        }

        .po-info-row>.col,
        .po-info-row>[class*="col-"] {
            flex: 0 0 100%;
            width: 100%;
            min-width: 0;
            padding: 6px 0;
        }

        /* Do not shrink the table; let the user swipe horizontally. */
        .responsive-table-container {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        #lineItem_table {
            min-width: 900px;
        }

        /* DataTables search / length controls */
        .dataTables_wrapper .row {
            margin-left: 0;
            margin-right: 0;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            width: 100%;
            text-align: left !important;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            max-width: 100%;
            width: calc(100% - 70px);
        }

        .dataTables_wrapper .dataTables_info {
            white-space: normal;
            margin-bottom: 8px;
        }

        .dataTables_wrapper .dataTables_paginate {
            white-space: normal;
            text-align: left !important;
        }

        /* Bootstrap modal */
        .modal-dialog,
        #AddModal .modal-dialog,
        #EditQuantityModal .modal-dialog,
        #deleteLineItemModal .modal-dialog {
            width: calc(100vw - 20px) !important;
            max-width: calc(100vw - 20px) !important;
            margin: 10px auto !important;
        }

        .modal-content {
            width: 100%;
        }

        .modal-header {
            padding: .75rem 1rem;
        }

        .modal-header .modal-title {
            font-size: 1rem;
            padding-right: 8px;
        }

        .modal-body {
            padding: 1rem;
            max-height: calc(100vh - 145px);
        }

        .modal-footer {
            padding: .75rem 1rem;
            justify-content: stretch;
        }

        .modal-footer .btn {
            flex: 1 1 auto;
            min-width: 110px;
        }

        /* Add modal form: labels and controls stack cleanly. */
        #AddModal .form-group .row {
            margin-left: 0;
            margin-right: 0;
        }

        #AddModal .form-group .row>label,
        #AddModal .form-group .row>div[class*="col-"] {
            flex: 0 0 100%;
            width: 100%;
            max-width: 100%;
            text-align: left !important;
            padding-left: 0;
            padding-right: 0;
        }

        #AddModal .form-group .row>label {
            margin-top: 8px;
            margin-bottom: 5px;
        }

        #AddModal .form-group .row>div[class*="col-"] {
            margin-bottom: 8px;
        }

        /* Confirmation modals */
        #deleteLineItemModal .lead {
            font-size: 1rem;
        }

        /* Make the floating plus button stay inside the card. */
        .card-header .col[align="right"] {
            text-align: right !important;
        }
    }

    /* Very small phones */
    @media (max-width: 374.98px) {

        .modal-dialog,
        #AddModal .modal-dialog,
        #EditQuantityModal .modal-dialog,
        #deleteLineItemModal .modal-dialog {
            width: calc(100vw - 10px) !important;
            max-width: calc(100vw - 10px) !important;
            margin: 5px auto !important;
        }

        .modal-body {
            padding: .75rem;
        }

        .modal-footer .btn {
            min-width: 0;
            width: 100%;
            flex-basis: 100%;
        }

        #lineItem_table {
            min-width: 850px;
        }
    }

    /* Landscape phones / short screens */
    @media (max-width: 767.98px) and (orientation: landscape) {
        .modal-body {
            max-height: calc(100vh - 125px);
        }
    }
</style>
<div class="modal fade" id=AddModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg" id="AddModalDialog">
        <form class="" method="POST" id="add_form" enctype="multipart/form-data"
            action="../Controller/POlineitemcontroller.php">
            <div class="modal-content">
                <div class="modal-header drag-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h5 class="modal-title" id="exampleModalLabel">Item/Material Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-group">
                        <div class="row">
                            <!-- <label class="col-md-3 text-right">Supplier <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="SupplierId" class="form-select" required name="SupplierId">

                                </select>
                            </div> -->

                            <label class="col-md-3 text-right">Brand<span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="brand" class="form-select" required name="brand">

                                </select>
                            </div>
                            <label class="col-md-3 text-right">
                                Inventory <span class="text-danger">*</span>
                            </label>

                            <div class="col-md-3">
                                <select id="inventoryTypeSelect" class="form-select" required>

                                    <option value="" hidden>-- Select --</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Category <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemCategory" class="form-select" required name="itemCategory">

                                </select>
                            </div>
                            <label class="col-md-3 text-right">Sub Category <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemsubCategory" class="form-select" required name="itemsubCategory">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-3 text-right">Item/Material <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemid" class="form-select" required name="additemid">
                                </select>
                                <input type='hidden' id='supplierid' name='supplierid'
                                    value="<?php echo $purchaseList->get_supplier() ?>" />
                                <input type='hidden' id='totalAmt' name='totalAmt'
                                    value="<?php echo $purchaseList->get_totalAmount() ?>" />
                                <input type="hidden" name="POID" id="POID">
                                <input type="hidden" name="Pid" id="Pid">
                                <input type="hidden" name="selectedItemName" id="addselectedItemName"
                                    class="form-control" value="" />
                                <input type="hidden" name="unitFactor" id="unitFactor" class="form-control" value="" />
                                <input type="hidden" name="POLineItemId" id="POLineItemId" class="form-control"
                                    value="" />
                            </div>

                            <label class="col-md-3 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="quantity" id="quantity" class="form-control" required />
                            </div>


                        </div>
                    </div>
                    <div class="form-group" style="display:none;">

                        <input type="hidden" name="price" id="price" value="0">
                        <input type="hidden" name="totalamt" id="totalamt" value="0">

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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deleteLineItemModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_lineItem_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title" id="modal_title">Delete Purchase Order Line Item</h4>
                    <button type="button" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Line Item.
                    </p>
                    <input type="hidden" name="POlineItemId" id="POlineItemId" value="">
                    <input type="hidden" name="POID" id="deletePOID" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="deleteLineItembutton" class="btn btn-danger"
                        value="Confirmed" />
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Edit Quantity Modal -->
<div class="modal fade" id="EditQuantityModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" id="EditQuantityModalDialog">
        <form id="editQuantityForm" method="POST" action="../Controller/POlineitemcontroller.php">
            <div class="modal-content">

                <div class="modal-header drag-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h5 class="modal-title">Edit Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="updateQuantity" value="1">

                    <input type="hidden" name="POlineitemId" id="editPOlineitemId">

                    <input type="hidden" name="POID" id="editPOID" value="<?php echo $id; ?>">

                    <div class="form-group">
                        <label>Quantity</label>

                        <input type="number" min="1" class="form-control" id="editQuantity" name="quantity" required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">
                        Save
                    </button>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Cancel
                    </button>

                </div>

            </div>
        </form>
    </div>
</div>
<script>
    var pricechange = [];

    var projId = 0;

    $(document).on("click", ".editQuantityBtn", function (e) {

        e.preventDefault();

        $("#editPOlineitemId").val($(this).data("id"));

        $("#editQuantity").val($(this).data("qty"));

        $("#EditQuantityModal").modal("show");

    });

    function qChange(POlineitemId) {

        var price = document.getElementById('editeditemperpieceprice').value;
        pricechange.forEach(function (item, index, arr) {
            if (item.itemid == itemId) {
                item.itemperpieceprice = price;
                item.totalAmount = parseFloat(quantity) * parseFloat(price);
            }
        })

    }

    function saveItem(POlineitemId) {
        debugger;
        document.getElementById("quantity_" + POlineitemId).setAttribute("readonly", "readonly");
        document.getElementById("price_" + POlineitemId).setAttribute("readonly", "readonly");
        document.getElementById("save_" + POlineitemId).classList.add('disabled');
        document.getElementById("edit_" + POlineitemId).classList.remove('disabled');
        var row = document.getElementById(POlineitemId);
        var price = document.getElementById('price').value;
        var price = document.getElementById("price_" + POlineitemId).value;
        var quantity = document.getElementById("quantity_" + POlineitemId).value;
        var supplierId = document.getElementById("supplierid").value;
        var PurchaseId = document.getElementById("Pid").value;
        var editedPrice = {
            POlineitemId: POlineitemId,
            totalamt: price * quantity,
            price: price,
            quantity: quantity,
            Pid: PurchaseId,
            supplierid: supplierId

        }
        pricechange.push(editedPrice);
    }

    $(document).ready(function () {


        var catId;
        var subcatId;
        var dataTable = $('#lineItem_table').DataTable({
            scrollX: true,
            autoWidth: false,
            responsive: false
        });
        $('#deleteLineItemModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#POlineItemId').val(rowid);

        });


        $('#Save').click(function (event) {
            debugger;
            console.log(pricechange)
            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/POlineitemcontroller.php",
                data: {
                    "obj": pricechange
                },
                dataType: "json",
                encode: true,
            }).done(function (data) {
                window.location.replace(config.developmentPath +
                    "/Admin/View/POlineitemview.php");
            });

        });



        $('#EditModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#POlineItemId').val(rowid);

            var url = config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php";
            let isSelectedSet1 = false;
            $('#editeditemCategory').empty();
            $('#editeditemsubCategory').empty();
            $('#additemid').empty();

            // var catid=
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    if (catId == value.itemcatid) {
                        $('#editeditemCategory').append(
                            '<option selected value ="' + value
                                .itemcatid + '">' +
                            value
                                .itemcatname + '</option>');

                    } else {
                        $('#editeditemCategory').append('<option value="' +
                            value
                                .itemcatid + '">' +
                            value
                                .itemcatname + '</option>');
                    }


                });

            });
            setSubCategory(catId);
        });

        // $('#additemid').empty();
        // var url = config.developmentPath + "/Admin/Controller/item_detailscontroller.php";
        // $.getJSON(url,
        //     function (
        //         data) {

        //         itemDetails = data;
        //         mappItemPrice(data[0].price,
        //             data[0].name,
        //             data[0].unitFactor);
        //         $.each(data, function (index, value) {
        //             $('#additemid').append('<option value="' + value.itemid + '">' +
        //                 value
        //                     .itemname + '</option>');
        //         });
        //     });

        $('#additemid').on('change', function () {

            let id = this.value;

            let inventoryType = $("#inventoryTypeSelect").val();

            let item = inventoryType === "item"
                ? itemDetails.find(x => x.itemid == id)
                : itemDetails.find(x => x.MaterialId == id);

            if (!item) return;

            if (inventoryType === "item") {

                $('#addselectedItemName').val(item.itemname);
                $('#unitFactor').val(item.unitFactor || 1);

            } else {

                $('#addselectedItemName').val(item.MaterialName);
                $('#unitFactor').val(item.unitFactor || 1);

            }

        });






        $('#delete_lineItem_form').submit(function (event) {
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/POlineItemController.php/",
                method: "POST",
                data: {
                    id: $('#POlineItemId').val(),
                    quoteId: $('#deletePOID').val(),
                    action: 'delete'
                },
            }).done(function (data) {
                console.log(data);
            });
            location.reload();
        });
        $('#lineItem_table tbody').on('click', 'tr', function () {
            debugger;
            $('#POlineItemId').val(this.cells[0].innerHTML);

            $('#supplierid').val(this.cells[1].innerHTML);
            $('#Pid').val(this.cells[2].innerHTML);
            $('#editeditemname').val(this.cells[3].innerHTML);
            $('#editedquantity').val(this.cells[4].innerHTML);
            $('#editedtotalamt').val(this.cells[5].innerHTML);

            $('#editedprice').val(this.cells[6].innerHTML);

            $('#editeditemCategory').val(this.cells[7].innerHTML);
            $('#editeditemsubCategory').val(this.cells[8].innerHTML);
            $('#unitFactor').val(this.cells[9].innerHTML);
        });
        $('#editedquantity').blur(function (e) {
            calculateAmount();
        });

        function calculateAmount() {
            var quantity = $('#editedquantity').val();
            var price = $('#editedprice').val();
            var unitFactor = $('#unitFactor').val();

            $('#editedtotalamt').val((parseFloat($('#editedquantity').val() * parseFloat($(
                '#editedprice').val()) * parseFloat($('#unitFactor').val()))).toFixed(2));

        };
        $('#editedquantity').on('keydown', function (e) {
            calculateAmount();
        });
        $('#editedquantity').on('keyup', function (e) {
            calculateAmount();
        });

        $('#edit_form').submit(function (event) {

            var formData = new FormData(this);
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/POlineitemcontroller.php/",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                console.log(data);
            });
        });



        $('#AddModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#POID').val(rowid);
            $('#Pid').val(rowid);
            var fetchCompanylist = config.developmentPath +
                "/Admin/Controller/item_compdetailscontroller.php/?POID=" + rowid;
            console.log(fetchCompanylist);
            console.log(this.value);
            let suppId = 0;
            $.getJSON(fetchCompanylist, function (data) {
                $.each(data, function (index, value) {
                    $('#SupplierId').append('<option value="' + value.itemcompid + '">' +
                        value.itemcompname + '</option>');
                    setBrand(value.itemcompid);
                });

            });
        });


        function setBrand(suppId) {
            fetchbrandurl = config.developmentPath + "/Admin/Controller/brandcontroller.php/?supplierId=" + suppId;
            console.log(fetchbrandurl);
            $.getJSON(fetchbrandurl, function (data) {
                $('#brand').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#brand').append('<option value="' + value.brandid +
                        '">' +
                        value
                            .brandname + '</option>');
                });
            });
        }

        function setSubCategory(catId) {

            let inventoryType = $("#inventoryTypeSelect").val();

            $('#additemsubCategory').empty();

            var fetchsubcaturl = "";

            if (inventoryType == "item") {

                fetchsubcaturl =
                    config.developmentPath +
                    "/Admin/Controller/item_subcategorycontroller.php?catId=" + catId;

            } else {

                fetchsubcaturl =
                    config.developmentPath +
                    "/Admin/Controller/material_SubcategoryController.php?catId=" + catId;

            }

            $.getJSON(fetchsubcaturl, function (data) {

                $('#additemsubCategory').append(
                    '<option hidden selected>-- select an option --</option>'
                );

                $.each(data, function (index, value) {

                    if (inventoryType == "item") {

                        $('#additemsubCategory').append(

                            '<option value="' +
                            value.itemsubcatid +
                            '">' +
                            value.itemsubcatname +
                            '</option>'

                        );

                    } else {

                        $('#additemsubCategory').append(

                            '<option value="' +
                            value.materialsubcatId +
                            '">' +
                            value.materialsubcatName +
                            '</option>'

                        );

                    }

                });

            });

        }

        function setItemlist(catId, subcatId, brandId, projId = 0) {

            let inventoryType = $("#inventoryTypeSelect").val();

            $('#additemid').empty();

            $('#quantity').val("");
            $('#price').val("0");
            $('#totalamt').val("0");

            let fetchitemlisturl = "";

            if (inventoryType == "item") {

                fetchitemlisturl =
                    config.developmentPath +
                    "/Admin/Controller/item_detailscontroller.php?catId=" +
                    catId +
                    "&subcatId=" +
                    subcatId +
                    "&brandId=" +
                    brandId +
                    "&projId=" +
                    projId;

            } else {

                fetchitemlisturl =
                    config.developmentPath +
                    "/Admin/Controller/materialController.php?catId=" +
                    catId +
                    "&subcatId=" +
                    subcatId +
                    "&brandId=" +
                    brandId;

            }

            $.getJSON(fetchitemlisturl, function (data) {

                itemDetails = data;

                $('#additemid').append(
                    '<option hidden selected>-- select an option --</option>'
                );

                $.each(data, function (index, value) {

                    if (inventoryType == "item") {

                        $('#additemid').append(

                            '<option value="' +
                            value.itemid +
                            '">' +
                            value.itemname +
                            '</option>'

                        );

                    } else {

                        $('#additemid').append(

                            '<option value="' +
                            value.MaterialId +
                            '">' +
                            value.MaterialName +
                            '</option>'

                        );

                    }

                });

            });

        }

        $('#brand').on('change', function () {

            // Reset everything
            $('#inventoryTypeSelect')
                .empty()
                .append('<option value="" hidden>-- Select --</option>');

            $('#additemCategory').empty();
            $('#additemsubCategory').empty();
            $('#additemid').empty();

            $('#quantity').val("");
            $('#price').val("0");
            $('#totalamt').val("0");

            let brandId = this.value;

            if (!brandId) {
                return;
            }

            // Load Inventory Types for selected Brand
            $.getJSON(
                config.developmentPath +
                "/Admin/Controller/brandcontroller.php?action=inventoryTypes&brandId=" +
                brandId,

                function (res) {

                    if (res.item === true) {
                        $('#inventoryTypeSelect').append(
                            '<option value="item">Item</option>'
                        );
                    }

                    if (res.material === true) {
                        $('#inventoryTypeSelect').append(
                            '<option value="material">Material</option>'
                        );
                    }

                }

            );

        });
        $('#inventoryTypeSelect').on('change', function () {

            $('#additemCategory').empty();
            $('#additemsubCategory').empty();
            $('#additemid').empty();

            $('#quantity').val("");
            $('#price').val("0");
            $('#totalamt').val("0");

            let inventoryType = this.value;

            let url = "";

            if (inventoryType == "item") {

                url =
                    config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php?brandId=" +
                    $('#brand').val();

            } else {

                url =
                    config.developmentPath +
                    "/Admin/Controller/material_CategoryController.php?brandId=" +
                    $('#brand').val();

            }

            $.getJSON(url, function (data) {

                $('#additemCategory')
                    .empty()
                    .append('<option hidden selected>-- select an option --</option>');

                $.each(data, function (index, value) {

                    if (inventoryType == "item") {

                        $('#additemCategory').append(
                            '<option value="' +
                            value.itemcatid +
                            '">' +
                            value.itemcatname +
                            '</option>'
                        );

                    } else {

                        $('#additemCategory').append(
                            '<option value="' +
                            value.materialcatId +
                            '">' +
                            value.materialCatname +
                            '</option>'
                        );

                    }

                });

            });

        });


        $('#additemCategory').on('change', function () {

            $('#additemsubCategory').empty();
            $('#additemid').empty();

            $('#quantity').val("");
            $('#price').val("0");
            $('#totalamt').val("0");

            setSubCategory(this.value);

        });

        $('#editeditemCategory').on('change', function () {
            $('#editeditemsubCategory').empty();
            $('#additemid').empty();
            $('#editedquantity').val("");
            $('#editedtotalamt').val("");
            $('#editedprice').val("");

            fetchsubcaturl =
                config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
                    .value;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#editeditemsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#editeditemsubCategory').append(
                        '<option value="' + value
                            .itemsubcatid +
                        '">' +
                        value
                            .itemsubcatname + '</option>');
                });
            });
        });

        $('#additemsubCategory').on('change', function () {

            $('#additemid').empty();

            setItemlist(
                $('#additemCategory').val(),
                this.value,
                $('#brand').val()
            );

        });
        $('#editeditemsubCategory').on('change', function () {
            $('#additemid').empty();
            setItemlist($('#editeditemCategory').val(), this.value);
        });
    });

    // =========================================================
    // RESPONSIVE + DRAGGABLE MODALS
    // One implementation for all modals.
    // =========================================================
    (function () {

        var active = null;

        function viewportBounds(dialog) {
            var rect = dialog.getBoundingClientRect();
            var margin = window.innerWidth <= 767 ? 5 : 10;

            var minLeft = margin;
            var maxLeft = Math.max(minLeft, window.innerWidth - rect.width - margin);

            var minTop = margin;
            var maxTop = Math.max(minTop, window.innerHeight - rect.height - margin);

            return {
                minLeft: minLeft,
                maxLeft: maxLeft,
                minTop: minTop,
                maxTop: maxTop
            };
        }

        function clampDialog(dialog) {
            if (!dialog) return;

            var rect = dialog.getBoundingClientRect();
            var bounds = viewportBounds(dialog);

            var left = Math.min(
                Math.max(rect.left, bounds.minLeft),
                bounds.maxLeft
            );

            var top = Math.min(
                Math.max(rect.top, bounds.minTop),
                bounds.maxTop
            );

            dialog.style.position = "fixed";
            dialog.style.margin = "0";
            dialog.style.transform = "none";
            dialog.style.left = left + "px";
            dialog.style.top = top + "px";
        }

        function centerDialog(dialog) {
            if (!dialog) return;

            dialog.style.position = "fixed";
            dialog.style.margin = "0";
            dialog.style.transform = "none";

            var rect = dialog.getBoundingClientRect();
            var bounds = viewportBounds(dialog);

            var left = (window.innerWidth - rect.width) / 2;
            var top = Math.max(
                window.innerWidth <= 767 ? 8 : 20,
                (window.innerHeight - rect.height) / 2
            );

            left = Math.min(
                Math.max(left, bounds.minLeft),
                bounds.maxLeft
            );

            top = Math.min(
                Math.max(top, bounds.minTop),
                bounds.maxTop
            );

            dialog.style.left = left + "px";
            dialog.style.top = top + "px";
        }

        function startDrag(e) {
            var header = e.currentTarget;

            if (e.target.closest("button, a, input, select, textarea")) {
                return;
            }

            var modal = header.closest(".modal");
            if (!modal) return;

            var dialog = modal.querySelector(".modal-dialog");
            if (!dialog) return;

            /* On touch, dragging is only initiated from the header. */
            e.preventDefault();

            var rect = dialog.getBoundingClientRect();

            active = {
                dialog: dialog,
                pointerId: e.pointerId,
                offsetX: e.clientX - rect.left,
                offsetY: e.clientY - rect.top
            };

            try {
                header.setPointerCapture(e.pointerId);
            } catch (err) { }

            header.style.cursor = "grabbing";
        }

        function dragMove(e) {
            if (!active || e.pointerId !== active.pointerId) return;

            var dialog = active.dialog;
            var bounds = viewportBounds(dialog);

            var left = e.clientX - active.offsetX;
            var top = e.clientY - active.offsetY;

            left = Math.min(Math.max(left, bounds.minLeft), bounds.maxLeft);
            top = Math.min(Math.max(top, bounds.minTop), bounds.maxTop);

            dialog.style.left = left + "px";
            dialog.style.top = top + "px";
        }

        function endDrag(e) {
            if (!active) return;

            var header = active.dialog ?
                active.dialog.querySelector(".modal-header") :
                null;

            if (header) {
                header.style.cursor = "move";
                try {
                    header.releasePointerCapture(e.pointerId);
                } catch (err) { }
            }

            active = null;
        }

        function prepareModal(modal) {
            var dialog = modal.querySelector(".modal-dialog");
            var header = modal.querySelector(".modal-header");

            if (!dialog) return;

            /* Bootstrap's transform/margins are removed only while open. */
            dialog.style.position = "fixed";
            dialog.style.margin = "0";
            dialog.style.transform = "none";

            /* Recalculate dimensions after Bootstrap finishes showing it. */
            requestAnimationFrame(function () {
                centerDialog(dialog);
            });

            if (header && !header.dataset.dragBound) {
                header.dataset.dragBound = "1";
                header.classList.add("drag-header");

                header.addEventListener("pointerdown", startDrag);
                header.addEventListener("pointermove", dragMove);
                header.addEventListener("pointerup", endDrag);
                header.addEventListener("pointercancel", endDrag);
                header.addEventListener("lostpointercapture", function () {
                    if (active) active = null;
                    header.style.cursor = "move";
                });
            }
        }

        $(".modal").on("shown.bs.modal", function () {
            prepareModal(this);
        });

        $(".modal").on("hidden.bs.modal", function () {
            var dialog = this.querySelector(".modal-dialog");

            if (dialog) {
                dialog.style.position = "";
                dialog.style.left = "";
                dialog.style.top = "";
                dialog.style.margin = "";
                dialog.style.transform = "";
            }
        });

        $(window).on("resize orientationchange", function () {
            $(".modal.show").each(function () {
                var dialog = this.querySelector(".modal-dialog");
                if (dialog) {
                    requestAnimationFrame(function () {
                        clampDialog(dialog);
                    });
                }
            });
        });

        /* Prevent accidental page scrolling while dragging a modal header. */
        $(document).on("pointermove", function (e) {
            if (active) {
                dragMove(e.originalEvent || e);
            }
        });

        $(document).on("pointerup pointercancel", function (e) {
            if (active) {
                endDrag(e.originalEvent || e);
            }
        });

    })();
</script>