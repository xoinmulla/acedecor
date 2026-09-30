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
    /* =========================================================
       PURCHASE ORDER PAGE - RESPONSIVE ONLY
       Existing colors, Bootstrap structure and business logic
       are intentionally preserved.
       ========================================================= */

    /* Main page/table responsiveness */
    #quote_table {
        width: 100% !important;
    }

    #quote_table th,
    #quote_table td {
        white-space: nowrap;
    }

    /* Keep the existing table usable on small screens.
       Only the table scrolls horizontally - NOT the whole page. */
    .po-main-table-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .po-main-table-scroll #quote_table {
        min-width: 900px;
    }

    /* Existing edited table behavior, improved for mobile */
    #editedPOlineItemTable {
        width: 100% !important;
        min-width: 650px;
        border-collapse: collapse;
    }

    #editedPOlineItemTable thead {
        background-color: grey;
        color: whitesmoke;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .po-modal-table-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 4px;
    }

    /* Minimum widths prevent columns from being crushed on phones. */
    #displayPOlineItemTable {
        min-width: 900px;
        margin-bottom: 0;
    }

    #POlineItemTable {
        min-width: 650px;
        margin-bottom: 0;
    }

    .po-modal-table-scroll th,
    .po-modal-table-scroll td {
        white-space: nowrap;
        vertical-align: middle;
    }

    #displayPOlineItemTable th,
    #displayPOlineItemTable td {
        white-space: nowrap;
    }

    #POlineItemTable th,
    #POlineItemTable td,
    #editedPOlineItemTable th,
    #editedPOlineItemTable td {
        white-space: nowrap;
    }

    .po-modal-table-scroll img {
        max-width: 100px;
        height: 100px;
        object-fit: contain;
    }

    .pad {
        padding-right: .5rem;
    }

    .card-body #quote_table th {
        font-weight: 500;
    }

    /* -------------------- MODAL RESPONSIVENESS -------------------- */

    .modal {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .modal-dialog {
        width: auto;
        max-width: calc(100vw - 30px);
        margin: 15px auto;
    }

    .modal-content {
        width: 100%;
        max-width: 100%;
        max-height: calc(100vh - 30px);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .modal-header {
        flex: 0 0 auto;
        cursor: move;
        user-select: none;
        -webkit-user-select: none;
        touch-action: none;
    }

    .modal-body {
        min-height: 0;
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .modal-footer {
        flex: 0 0 auto;
        flex-wrap: wrap;
        gap: 6px;
    }

    .modal-footer > * {
        margin: 0 !important;
    }

    /* Accordion content must not force the modal wider. */
    .modal-body .accordion,
    .modal-body .accordion-item,
    .modal-body .accordion-body {
        max-width: 100%;
    }

    /* Prevent Bootstrap rows from creating accidental horizontal overflow. */
    .modal-body .row {
        margin-left: -8px;
        margin-right: -8px;
    }

    /* -------------------- PHONE -------------------- */

    @media (max-width: 767.98px) {

        .card-body {
            min-width: 0 !important;
        }

        h1.h3.mb-4.text-gray-800 {
            font-size: 1.35rem;
            line-height: 1.3;
        }

        .card-header .row {
            margin-left: 0;
            margin-right: 0;
        }

        .card-header h6 {
            font-size: 1rem !important;
        }

        .po-main-table-scroll #quote_table {
            min-width: 900px;
        }

        /* Bootstrap modal-lg/modal-xl become almost full width. */
        .modal-dialog,
        .modal-dialog.modal-lg,
        .modal-dialog.modal-xl {
            width: calc(100vw - 16px) !important;
            max-width: calc(100vw - 16px) !important;
            margin: 8px auto !important;
        }

        .modal-content {
            max-height: calc(100vh - 16px);
            border-radius: 8px;
        }

        .modal-header {
            padding: 10px 12px;
        }

        .modal-title {
            font-size: 1rem;
            line-height: 1.35;
            padding-right: 8px;
        }

        .modal-body {
            padding: 12px;
        }

        .modal-footer {
            padding: 10px 12px;
            justify-content: flex-end;
        }

        .modal-footer .btn,
        .modal-footer input[type="submit"],
        .modal-footer input[type="button"],
        .modal-footer a.btn {
            margin: 0 !important;
        }

        /* Form columns inside modal become full width. */
        .modal-body .col-md-4,
        .modal-body .col-md-8,
        .modal-body .col-md-12 {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
        }

        .modal-body label.text-right {
            text-align: left !important;
            margin-bottom: 4px;
        }

        /* Tables remain readable and can be swiped horizontally. */
        .po-modal-table-scroll {
            max-width: 100%;
        }

        #displayPOlineItemTable {
            min-width: 900px;
        }

        #editedPOlineItemTable {
            min-width: 650px;
        }

        #POlineItemTable {
            min-width: 650px;
        }

        .po-modal-table-scroll th,
        .po-modal-table-scroll td {
            font-size: 0.88rem;
            padding: 7px 9px;
        }

        /* Image column stays controlled. */
        #displayPOlineItemTable th:first-child,
        #displayPOlineItemTable td:first-child {
            width: 90px;
            min-width: 90px;
        }

        #displayPOlineItemTable img {
            width: 75px !important;
            height: 75px !important;
            object-fit: contain;
        }

        /* The print/item-list card should not force the modal wider. */
        #printtopdf {
            max-width: 100%;
            overflow: hidden;
        }

        /* Action buttons wrap instead of overflowing. */
        .modal-footer .form-check {
            margin-right: auto;
        }

        /* Confirmation modals */
        #cancelPurchaseModal .modal-dialog,
        #ResumePurchaseModal .modal-dialog,
        #deletePurchaseModal .modal-dialog {
            width: calc(100vw - 24px) !important;
            max-width: calc(100vw - 24px) !important;
        }

        #cancelPurchaseModal .lead,
        #ResumePurchaseModal .lead,
        #deletePurchaseModal .lead {
            font-size: 1rem;
        }
    }

    @media (max-width: 400px) {
        .modal-body {
            padding: 9px;
        }

        .modal-header {
            padding: 9px 10px;
        }

        .modal-footer {
            padding: 8px 10px;
        }

        .modal-footer .btn,
        .modal-footer input[type="submit"] {
            font-size: 0.85rem;
            padding: 7px 10px;
        }

        .accordion-button {
            padding: 10px;
            font-size: 0.95rem;
        }
    }

    /* -------------------- TOUCH DRAGGING -------------------- */

    .po-draggable-dialog {
        will-change: left, top;
    }

    .po-modal-dragging {
        user-select: none !important;
        -webkit-user-select: none !important;
    }

    /* =========================================================
       CREATE PURCHASE ORDER MODAL
       Isolated styles - does not alter existing PO modals.
       ========================================================= */

    #createPurchaseOrderModal .create-po-dialog {
        width: calc(100vw - 30px);
        max-width: 1250px;
        margin: 15px auto;
    }

    #createPurchaseOrderModal .create-po-modal-content {
        max-height: calc(100vh - 30px);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border-radius: 8px;
    }

    #createPurchaseOrderModal .modal-body {
        overflow-y: auto;
        overflow-x: hidden;
        min-height: 0;
        padding: 15px;
    }

    #createPurchaseOrderModal .modal-header {
        cursor: move;
        user-select: none;
        touch-action: none;
    }

    #createPurchaseOrderModal label,
    #createPOEditItemModal label {
        font-weight: 500;
        margin-bottom: 6px;
    }

    #createPurchaseOrderModal .form-control,
    #createPOEditItemModal .form-control {
        min-width: 0;
    }

    .create-po-table-scroll {
        width: 100%;
        overflow-x: auto;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    #createPOLineItemTable {
        min-width: 820px;
        margin-bottom: 0;
    }

    #createPOLineItemTable th,
    #createPOLineItemTable td {
        white-space: nowrap;
        vertical-align: middle;
    }

    #createPOLineItemTable thead th {
        font-weight: 500;
        background-color: #343a40;
        color: #fff;
    }

    .create-po-empty-state {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 70px;
        color: #7b8494;
        font-size: .92rem;
    }

    .create-po-empty-state i {
        font-size: 18px;
    }

    #createPurchaseOrderModal .card-header {
        padding: 10px 14px;
    }

    #createPurchaseOrderModal .card-body {
        padding: 14px;
    }

    #createPurchaseOrderModal .card-footer {
        padding: 10px 14px;
    }

    #createPurchaseOrderModal .btn {
        margin-left: 4px;
    }

    #createPOMessage .alert {
        margin-bottom: 12px;
    }

    #createPOEditItemModal .modal-dialog {
        width: calc(100vw - 30px);
        max-width: 900px;
        margin: 15px auto;
    }

    #createPOEditItemModal .modal-content {
        max-height: calc(100vh - 30px);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    #createPOEditItemModal .modal-body {
        overflow-y: auto;
        min-height: 0;
    }

    @media (max-width: 767.98px) {

        #createPurchaseOrderModal .create-po-dialog,
        #createPOEditItemModal .modal-dialog {
            width: calc(100vw - 16px) !important;
            max-width: calc(100vw - 16px) !important;
            margin: 8px auto !important;
        }

        #createPurchaseOrderModal .create-po-modal-content,
        #createPOEditItemModal .modal-content {
            max-height: calc(100vh - 16px);
        }

        #createPurchaseOrderModal .modal-body,
        #createPOEditItemModal .modal-body {
            padding: 10px;
        }

        #createPurchaseOrderModal .modal-header,
        #createPOEditItemModal .modal-header {
            padding: 10px 12px;
        }

        #createPurchaseOrderModal .card-body {
            padding: 10px;
        }

        #createPurchaseOrderModal .card-footer {
            padding: 10px;
        }

        #createPurchaseOrderModal .card-footer > div {
            width: 100%;
        }

        #createPurchaseOrderModal .card-footer .btn {
            margin: 3px 0 0 3px;
        }

        #createPOLineItemTable {
            min-width: 820px;
        }

        #createPurchaseOrderModal .row > [class*="col-"],
        #createPOEditItemModal .row > [class*="col-"] {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
        }
    }

    @media (max-width: 400px) {
        #createPurchaseOrderModal .card-footer .btn {
            width: 100%;
            margin-left: 0;
        }
    }

    /* =========================================================
       CREATE PO - TABLET AND BELOW
       Keep the modal inside the viewport and make the modal body
       itself vertically scrollable.
       ========================================================= */
    @media (max-width: 991.98px) {

        #createPurchaseOrderModal {
            overflow: hidden !important;
        }

        #createPurchaseOrderModal .create-po-dialog {
            height: calc(100vh - 30px) !important;
            max-height: calc(100vh - 30px) !important;
            display: flex !important;
            flex-direction: column !important;
        }

        #createPurchaseOrderModal .create-po-modal-content {
            height: 100% !important;
            max-height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
        }

        /* IMPORTANT:
           The form sits between modal-content and modal-body.
           It must also be a flex container so modal-body can
           become the actual scrolling area. */
        #createPurchaseOrderModal #createPOForm {
            display: flex !important;
            flex: 1 1 auto !important;
            flex-direction: column !important;
            min-height: 0 !important;
            overflow: hidden !important;
        }

        #createPurchaseOrderModal #createPOForm > .modal-body {
            flex: 1 1 auto !important;
            min-height: 0 !important;
            height: 0 !important;
            max-height: none !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }
    }

    /* Smaller tablet / phone: use almost the full viewport width. */
    @media (max-width: 767.98px) {
        #createPurchaseOrderModal .create-po-dialog {
            height: calc(100vh - 16px) !important;
            max-height: calc(100vh - 16px) !important;
        }

        #createPurchaseOrderModal .create-po-modal-content {
            height: 100% !important;
            max-height: 100% !important;
        }
    }

</style>
<h1 class="h3 mb-4 text-gray-800">Purchase Order Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Purchase
                    Order List</h6>
            </div>
            <div class="col text-right">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-toggle="modal"
                    data-target="#createPurchaseOrderModal">
                    <i class="fas fa-plus"></i> 
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive po-main-table-scroll">
            <table class="table table-bordered" id="quote_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th style='display:none'> Purchase Order Id</th>
                        <th>PO ID</th>
                        <th>PO Date</th>
                        <!-- <th>PO type</th>
                        <th>Inventory</th> -->
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
                        <?php $status = $purchaseObj->getStatus(); ?>
                        <tr>

                            <td style="display:none"><?= $purchaseObj->get_id(); ?></td>
                            <td align="center"><?= $purchaseObj->getPOcode(); ?></td>
                            <td align="center"><?= $purchaseObj->get_purchaseddate(); ?></td>
                            <!-- <td><?= $purchaseObj->getPOtype(); ?></td>
                            <td><?= $purchaseObj->getInventoryType(); ?></td> -->
                            <td style="display:none"><?= $purchaseObj->get_supplier(); ?></td>
                            <td><?= $purchaseObj->getSupplierName(); ?></td>
                            <td align="center"><?= $purchaseObj->getQuantity(); ?></td>
                            <td align="center"><?= $purchaseObj->getBalanceQuantity(); ?></td>
                            <td align="left">₹ <?= $purchaseObj->get_totalAmount(); ?></td>
                            <td align="left">₹ <?= $purchaseObj->getBalanceAmt(); ?></td>
                            <td align="center"><?= $purchaseObj->getStatus(); ?></td>

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

                                        <?php if ($status == 'Fully Received' || $purchaseObj->getPOStatus() == '1') { ?>
                                            <a class="btn btn-secondary dropdown-item disabled" href="#" title="<?= ($purchaseObj->getPOStatus() == '1')
                                                ? 'Purchase Order Cancelled'
                                                : 'Already Fully Received'; ?>">
                                                <i class="fas fa-layer-group"></i>
                                                Inward stock
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn btn-primary dropdown-item"
                                                href="../View/itemstocks.php?id=<?= $purchaseObj->get_id(); ?>">
                                                <i class="fas fa-layer-group"></i>
                                                Inward stock
                                            </a>
                                        <?php } ?>

                                        <?php if ($purchaseObj->getPOStatus() == '1') { ?>

                                            <?php if ($status == 'Fully Received') { ?>
                                                <button class="btn btn-secondary dropdown-item" disabled
                                                    title="Already Fully Received">
                                                    <i class="far fa-pause-circle"></i>
                                                    Resume Purchase Order
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                    data-target="#ResumePurchaseModal" data-id="<?= $purchaseObj->get_id(); ?>">
                                                    <i class="far fa-pause-circle"></i>
                                                    Resume Purchase Order
                                                </button>
                                            <?php } ?>

                                        <?php } else { ?>

                                            <?php if ($status == 'Fully Received' || $status == 'Partially Received') { ?>
                                                <button class="btn btn-secondary dropdown-item" disabled
                                                    title="Already Fully Received">
                                                    <i class="far fa-times-circle"></i>
                                                    Cancel Purchase Order
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                    data-target="#cancelPurchaseModal" data-id="<?= $purchaseObj->get_id(); ?>">
                                                    <i class="far fa-times-circle"></i>
                                                    Cancel Purchase Order
                                                </button>
                                            <?php } ?>

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


<!-- =========================================================
     CREATE PURCHASE ORDER MODAL
     Uses the existing Purchase Order controller/AJAX endpoints.
     All IDs are prefixed with createPO to avoid conflicts with
     the existing PO information/edit/cancel/delete modals.
     ========================================================= -->
<div class="modal fade" id="createPurchaseOrderModal" tabindex="-1"
    role="dialog" aria-labelledby="createPurchaseOrderModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl create-po-dialog" role="document">
        <div class="modal-content create-po-modal-content">

            <div class="modal-header text-white"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">

                <h5 class="modal-title" id="createPurchaseOrderModalLabel">
                    <i class="fas fa-file-invoice"></i> Create Purchase Order
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="createPOForm" enctype="multipart/form-data"
                onsubmit="return false;">

                <div class="modal-body">

                    <div id="createPOMessage"></div>

                    <!-- Hidden values expected by the existing PO controller -->
                    <input type="hidden" name="selectedItemName" id="createPOSelectedItemName">
                    <input type="hidden" name="Articleno" id="createPOArticleNo">
                    <input type="hidden" name="itemdescription" id="createPOItemDescription">
                    <input type="hidden" name="unitFactor" id="createPOUnitFactor" value="1">
                    <input type="hidden" name="selectedBrandName" id="createPOSelectedBrandName">
                    <input type="hidden" name="totalAmount" id="createPOTotalAmount" value="0">
                    <input type="hidden" name="unitName" id="createPOUnitName" value="">

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h6 class="m-0 text-primary">
                                <i class="fas fa-shopping-cart"></i> Purchase Order Details
                            </h6>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label for="createPOSupplier">
                                        Supplier <span class="text-danger">*</span>
                                    </label>
                                    <select id="createPOSupplier"
                                        name="supplier"
                                        class="form-control"
                                        required>
                                        <option value="">-- select an option --</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOBrand">
                                        Brands <span class="text-danger">*</span>
                                    </label>
                                    <select id="createPOBrand"
                                        name="brands"
                                        class="form-control"
                                        required
                                        disabled>
                                        <option value="">-- select an option --</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOPurchasedDate">
                                        DOP <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                        class="form-control"
                                        id="createPOPurchasedDate"
                                        name="purchaseddate"
                                        required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOInventoryType">
                                        Inventory <span class="text-danger">*</span>
                                    </label>
                                    <select id="createPOInventoryType"
                                        name="inventoryType"
                                        class="form-control"
                                        required
                                        disabled>
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label for="createPOCategory">
                                        Category <span class="text-danger">*</span>
                                    </label>
                                    <select id="createPOCategory"
                                        name="category"
                                        class="form-control"
                                        required
                                        disabled>
                                        <option value="">-- select --</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOSubCategory">
                                        Sub Category <span class="text-danger">*</span>
                                    </label>
                                    <select id="createPOSubCategory"
                                        name="subcategory"
                                        class="form-control"
                                        required
                                        disabled>
                                        <option value="">-- select --</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOItem">
                                        Name <span class="text-danger">*</span>
                                    </label>
                                    <select id="createPOItem"
                                        name="itemid"
                                        class="form-control"
                                        required
                                        disabled>
                                        <option value="">-- select --</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOQuantity">
                                        Quantity <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                        min="1"
                                        step="any"
                                        id="createPOQuantity"
                                        name="itemquantity"
                                        class="form-control"
                                        required>
                                </div>

                            </div>

                            <!-- <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label for="createPOItemPrice">Price</label>
                                    <input type="text"
                                        id="createPOItemPrice"
                                        class="form-control"
                                        readonly
                                        placeholder="--">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOUnit">Unit</label>
                                    <input type="text"
                                        id="createPOUnit"
                                        class="form-control"
                                        readonly
                                        placeholder="--">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPOItemCode">Article Code</label>
                                    <input type="text"
                                        id="createPOItemCode"
                                        class="form-control"
                                        readonly
                                        placeholder="--">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="createPODescription">Description</label>
                                    <input type="text"
                                        id="createPODescription"
                                        class="form-control"
                                        readonly
                                        placeholder="--">
                                </div>

                            </div> -->

                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="m-0 text-primary">
                                <i class="fas fa-list"></i> Purchase Order Items
                            </h6>
                        </div>

                        <div class="card-body">

                            <div class="create-po-table-scroll">
                                <table class="table table-bordered table-hover mb-0"
                                    id="createPOLineItemTable"
                                    width="100%"
                                    cellspacing="0">

                                    <thead class="text-center">
                                        <tr>
                                            <th>Inventory</th>
                                            <th>Article Code</th>
                                            <th>Name</th>
                                            <th>Brand</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody></tbody>

                                </table>
                            </div>

                            <div class="create-po-empty-state" id="createPOEmptyState">
                                <i class="fas fa-box-open"></i>
                                <span>No items added yet.</span>
                            </div>

                        </div>

                        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap">
                            <div class="small text-muted">
                                <strong>Total Items:</strong>
                                <span id="createPOTotalItems">0</span>
                            </div>

                            <div class="mt-2 mt-md-0">
                                <button type="button"
                                    class="btn btn-primary"
                                    id="createPOAddItem">
                                    <i class="fas fa-plus"></i> Add
                                </button>

                                <button type="button"
                                    class="btn btn-success"
                                    id="createPOCreateButton">
                                    <i class="fas fa-check"></i> Create Purchase Order
                                </button>

                                <button type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<!-- =========================================================
     EDIT LINE ITEM MODAL FOR CREATE PO
     ========================================================= -->
<div class="modal fade" id="createPOEditItemModal" tabindex="-1"
    role="dialog" aria-labelledby="createPOEditItemModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg create-po-edit-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createPOEditItemModalLabel">
                    Edit Purchase Item
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Supplier</label>
                        <select id="createPOEditSupplier"
                            class="form-control"
                            disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Brand</label>
                        <select id="createPOEditBrand"
                            class="form-control"
                            disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>DOP</label>
                        <input type="date"
                            id="createPOEditPurchasedDate"
                            class="form-control"
                            readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Inventory</label>
                        <select id="createPOEditInventory"
                            class="form-control"
                            disabled>
                            <option value="item">Item</option>
                            <option value="material">Material</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Category</label>
                        <select id="createPOEditCategory"
                            class="form-control"
                            disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sub Category</label>
                        <select id="createPOEditSubCategory"
                            class="form-control"
                            disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <select id="createPOEditItem"
                            class="form-control"
                            disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Quantity</label>
                        <input type="number"
                            min="1"
                            step="any"
                            id="createPOEditQuantity"
                            class="form-control">
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal">
                    Cancel
                </button>

                <button type="button"
                    class="btn btn-success"
                    id="createPOUpdateItem">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<div class="modal fade" id=viewModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h5 class="modal-title" id="exampleModalLabel">Purchase Order Information</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                                    data-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    PO Details
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
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
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                                    data-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Item/Material Details
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="po-modal-table-scroll">
                                        <table class="table table-bordered" id="displayPOlineItemTable" width="100%"
                                            cellspacing="0">
                                        <thead>
                                            <tr style="text-align: center; background-color: #343a40; color: white">
                                                <th>Image</th>
                                                <th>Code</th>
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
                                    <div class="form-group">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                                    <input type="hidden" name="action" id="action" value="Add" />
                                    <a name="button" id="editPOLineItem" class="btn btn-warning">Edit </a>
                                    <a name="button" id="printPDF" class="btn btn-success">Print</a>
                                    <button type="button" class="btn btn-default btn-danger"
                                        data-dismiss="modal">Close</button>
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
            <div class="modal-header text-white"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
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


            <div class="po-modal-table-scroll">
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
                <a name="button" id="editPOLineItem" class="btn btn-success">Edit Line Item</a>
                <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id=itemListModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemListForm" enctype="multipart/form-data" action="">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
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
                            <div class="po-modal-table-scroll">
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
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=cancelPurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
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
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=ResumePurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
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
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deletePurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
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
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
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
            console.log("Selected PO ID:", rowid);
            $('#printPDF').attr('href', 'printPurchase.php?id=' + rowid);
            $('#editPOLineItem').attr('href', 'POlineitemview.php?id=' + rowid);
            var uniturl = config.developmentPath +
                "/Admin/Controller/POitemlistcontroller.php?id=" + rowid;

            $.getJSON(uniturl, function (data) {
                console.log(data);
                console.log("Total Records =", data.length);
                $("#displayPOlineItemTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    console.log("PO View Data:", data);

                    $('#displayPOlineItemTable tbody').append(
                        $('<tr>', { id: value.POlineitemId })
                            .append($('<td>').append(
                                $('<img>', {
                                    src:
                                        (value.inventoryType === "material"
                                            ? "../img/materials/"
                                            : "../img/items/") + value.ItemImage,
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

    /* =========================================================
       RESPONSIVE MODAL CENTERING + DRAGGING
       - Works for ALL Bootstrap modals on this page.
       - Mouse + touch + pen.
       - Centers on every open.
       - Keeps dialog inside the viewport.
       - Header is the drag handle.
       ========================================================= */
    (function () {

        function getViewportBounds(dialog) {
            const margin = 8;
            const vw = document.documentElement.clientWidth || window.innerWidth;
            const vh = document.documentElement.clientHeight || window.innerHeight;

            const width = dialog.offsetWidth;
            const height = dialog.offsetHeight;

            return {
                minX: margin,
                minY: margin,
                maxX: Math.max(margin, vw - width - margin),
                maxY: Math.max(margin, vh - height - margin)
            };
        }

        function clamp(value, min, max) {
            return Math.min(Math.max(value, min), max);
        }

        function centerDialog(dialog) {
            if (!dialog) return;

            dialog.classList.add('po-draggable-dialog');

            /* Clear previous drag position before measuring. */
            dialog.style.margin = '0';
            dialog.style.position = 'fixed';
            dialog.style.transform = 'none';
            dialog.style.left = '0px';
            dialog.style.top = '0px';

            const vw = document.documentElement.clientWidth || window.innerWidth;
            const vh = document.documentElement.clientHeight || window.innerHeight;

            const bounds = getViewportBounds(dialog);

            const left = clamp(
                Math.round((vw - dialog.offsetWidth) / 2),
                bounds.minX,
                bounds.maxX
            );

            const top = clamp(
                Math.round((vh - dialog.offsetHeight) / 2),
                bounds.minY,
                bounds.maxY
            );

            dialog.style.left = left + 'px';
            dialog.style.top = top + 'px';

            dialog.dataset.dragLeft = left;
            dialog.dataset.dragTop = top;
            dialog.dataset.wasDragged = 'false';
        }

        function clampCurrentPosition(dialog) {
            if (!dialog) return;

            const bounds = getViewportBounds(dialog);
            const currentLeft = parseFloat(dialog.style.left) || 0;
            const currentTop = parseFloat(dialog.style.top) || 0;

            const left = clamp(currentLeft, bounds.minX, bounds.maxX);
            const top = clamp(currentTop, bounds.minY, bounds.maxY);

            dialog.style.left = left + 'px';
            dialog.style.top = top + 'px';

            dialog.dataset.dragLeft = left;
            dialog.dataset.dragTop = top;
        }

        function makeDraggable(modal) {
            const dialog = modal.querySelector('.modal-dialog');
            const header = modal.querySelector('.modal-header');

            if (!dialog || !header) return;

            /* Prevent duplicate handlers if Bootstrap reopens the modal. */
            if (header._poDragPointerDown) {
                header.removeEventListener('pointerdown', header._poDragPointerDown);
            }

            if (modal._poDragMove) {
                document.removeEventListener('pointermove', modal._poDragMove);
            }

            if (modal._poDragUp) {
                document.removeEventListener('pointerup', modal._poDragUp);
                document.removeEventListener('pointercancel', modal._poDragUp);
            }

            header.style.cursor = 'move';
            header.style.touchAction = 'none';

            let dragging = false;
            let pointerId = null;
            let offsetX = 0;
            let offsetY = 0;

            const pointerDown = function (e) {
                /* Do not start dragging when interacting with close/buttons. */
                if ($(e.target).closest('button, a, input, select, textarea, label').length) {
                    return;
                }

                if (e.button !== undefined && e.button !== 0) {
                    return;
                }

                /* Make sure Bootstrap's centered transform is gone. */
                const rect = dialog.getBoundingClientRect();

                dialog.style.position = 'fixed';
                dialog.style.margin = '0';
                dialog.style.transform = 'none';
                dialog.style.left = rect.left + 'px';
                dialog.style.top = rect.top + 'px';

                offsetX = e.clientX - rect.left;
                offsetY = e.clientY - rect.top;

                dragging = true;
                pointerId = e.pointerId;

                dialog.dataset.wasDragged = 'true';

                document.body.classList.add('po-modal-dragging');

                try {
                    header.setPointerCapture(pointerId);
                } catch (ignore) {}

                e.preventDefault();
            };

            const pointerMove = function (e) {
                if (!dragging || (pointerId !== null && e.pointerId !== pointerId)) {
                    return;
                }

                const bounds = getViewportBounds(dialog);

                const left = clamp(
                    e.clientX - offsetX,
                    bounds.minX,
                    bounds.maxX
                );

                const top = clamp(
                    e.clientY - offsetY,
                    bounds.minY,
                    bounds.maxY
                );

                dialog.style.left = left + 'px';
                dialog.style.top = top + 'px';

                dialog.dataset.dragLeft = left;
                dialog.dataset.dragTop = top;

                e.preventDefault();
            };

            const pointerUp = function (e) {
                if (!dragging) return;

                dragging = false;
                pointerId = null;

                document.body.classList.remove('po-modal-dragging');

                try {
                    header.releasePointerCapture(e.pointerId);
                } catch (ignore) {}
            };

            header._poDragPointerDown = pointerDown;
            modal._poDragMove = pointerMove;
            modal._poDragUp = pointerUp;

            header.addEventListener('pointerdown', pointerDown, { passive: false });
            document.addEventListener('pointermove', pointerMove, { passive: false });
            document.addEventListener('pointerup', pointerUp);
            document.addEventListener('pointercancel', pointerUp);
        }

        /* Every modal on this page. */
        $('.modal').on('shown.bs.modal.poResponsive', function () {
            const modal = this;
            const dialog = modal.querySelector('.modal-dialog');

            if (!dialog) return;

            /*
             * Wait one frame so Bootstrap has completed its modal
             * transition and the real dimensions are available.
             */
            requestAnimationFrame(function () {
                centerDialog(dialog);
                makeDraggable(modal);
            });
        });

        /*
         * Re-center newly opened modals after viewport changes.
         * If the user has dragged a modal, only clamp it back into
         * the visible viewport rather than unexpectedly recentering it.
         */
        let resizeTimer = null;

        $(window).on('resize.poResponsiveModal orientationchange.poResponsiveModal', function () {
            clearTimeout(resizeTimer);

            resizeTimer = setTimeout(function () {
                $('.modal.show').each(function () {
                    const dialog = this.querySelector('.modal-dialog');
                    if (!dialog) return;

                    if (dialog.dataset.wasDragged === 'true') {
                        clampCurrentPosition(dialog);
                    } else {
                        centerDialog(dialog);
                    }
                });
            }, 100);
        });

        /* Reset positioning when Bootstrap closes the modal. */
        $('.modal').on('hidden.bs.modal.poResponsive', function () {
            const dialog = this.querySelector('.modal-dialog');
            const header = this.querySelector('.modal-header');

            if (dialog) {
                dialog.style.position = '';
                dialog.style.left = '';
                dialog.style.top = '';
                dialog.style.margin = '';
                dialog.style.transform = '';
                dialog.classList.remove('po-draggable-dialog');
                delete dialog.dataset.dragLeft;
                delete dialog.dataset.dragTop;
                delete dialog.dataset.wasDragged;
            }

            if (header) {
                header.style.cursor = '';
                header.style.touchAction = '';
            }
        });

    })();

</script>

<script>
/* =========================================================
   CREATE PURCHASE ORDER MODAL LOGIC
   ---------------------------------------------------------
   This is an isolated copy of the existing purchaseorder.php
   client-side flow, adapted only for the POview modal.

   Existing controller and DB logic are NOT changed.
   ========================================================= */
(function ($) {
    "use strict";

    var createPOState = {
        inventoryType: "",
        selectedSupplier: "",
        itemDetails: [],
        purchases: [],
        editIndex: -1
    };

    var createPONormalize = function (value) {
        return value === undefined || value === null ? "" : value;
    };

    function createPOGetToday() {
        var date = new Date();
        var month = String(date.getMonth() + 1).padStart(2, "0");
        var day = String(date.getDate()).padStart(2, "0");
        return date.getFullYear() + "-" + month + "-" + day;
    }

    function createPOResetDependentFields() {
        $("#createPOInventoryType")
            .empty()
            .append('<option value="">-- Select --</option>')
            .prop("disabled", true);

        $("#createPOCategory")
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $("#createPOSubCategory")
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $("#createPOItem")
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $("#createPOSelectedItemName").val("");
        $("#createPOArticleNo").val("");
        $("#createPOItemDescription").val("");
        $("#createPOUnitFactor").val("1");
        $("#createPOSelectedBrandName").val("");
        $("#createPOUnitName").val("");
        $("#createPOTotalAmount").val("0");

        $("#createPOItemPrice").val("");
        $("#createPOUnit").val("");
        $("#createPOItemCode").val("");
        $("#createPODescription").val("");

        createPOState.inventoryType = "";
        createPOState.itemDetails = [];
    }

    function createPOResetEntryFields(keepSupplier) {

        if (!keepSupplier) {
            $("#createPOSupplier").val("").prop("disabled", false);

            $("#createPOBrand")
                .empty()
                .append('<option value="">-- select an option --</option>')
                .prop("disabled", true);

            createPOState.selectedSupplier = "";
        }

        $("#createPOBrand").val("");

        createPOResetDependentFields();

        $("#createPOQuantity").val("");
    }

    function createPOShowMessage(type, message) {
        $("#createPOMessage").html(
            '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                $('<div>').text(message).html() +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                '</button>' +
            '</div>'
        );
    }

    function createPOClearMessage() {
        $("#createPOMessage").empty();
    }

    function createPOLoadSuppliers() {

        var url = config.developmentPath +
            "/Admin/Controller/item_compdetailscontroller.php/";

        $.getJSON(url)
            .done(function (data) {

                var $supplier = $("#createPOSupplier");

                $supplier.empty().append(
                    '<option value="">-- select an option --</option>'
                );

                $.each(data || [], function (index, value) {
                    $supplier.append(
                        $('<option>', {
                            value: value.itemcompid,
                            text: value.itemcompname
                        })
                    );
                });

            })
            .fail(function () {
                createPOShowMessage(
                    "danger",
                    "Unable to load suppliers."
                );
            });
    }

    function createPOLoadBrands(supplierId) {

        var url = config.developmentPath +
            "/Admin/Controller/brandcontroller.php/?supplierId=" +
            encodeURIComponent(supplierId);

        var $brand = $("#createPOBrand");

        $brand
            .empty()
            .append('<option value="">-- select an option --</option>')
            .prop("disabled", true);

        $.getJSON(url)
            .done(function (data) {

                $.each(data || [], function (index, value) {

                    $brand.append(
                        $('<option>', {
                            value: value.brandid,
                            text: value.brandname
                        })
                    );

                });

                $brand.prop("disabled", false);

            })
            .fail(function () {
                createPOShowMessage(
                    "danger",
                    "Unable to load brands for the selected supplier."
                );
            });
    }

    function createPOLoadInventoryTypes(brandId) {

        var url = config.developmentPath +
            "/Admin/Controller/brandcontroller.php?action=inventoryTypes&brandId=" +
            encodeURIComponent(brandId);

        var $inventory = $("#createPOInventoryType");

        $inventory
            .empty()
            .append('<option value="">-- Select --</option>')
            .prop("disabled", true);

        $.getJSON(url)
            .done(function (res) {

                /*
                 * Preserve the existing business rule:
                 * if item exists, show Item;
                 * if material exists, show Material.
                 */
                if (res && res.item === true) {
                    $inventory.append(
                        '<option value="item">Item</option>'
                    );
                }

                if (res && res.material === true) {
                    $inventory.append(
                        '<option value="material">Material</option>'
                    );
                }

                $inventory.prop("disabled", false);

            })
            .fail(function () {
                createPOShowMessage(
                    "danger",
                    "Unable to load inventory types for the selected brand."
                );
            });
    }

    function createPOLoadCategoryByInventory() {

        var brandId = $("#createPOBrand").val();

        if (!brandId) {
            createPOShowMessage(
                "warning",
                "Please select Brand first."
            );

            $("#createPOInventoryType")
                .val("")
                .prop("disabled", true);

            return;
        }

        var url = createPOState.inventoryType === "item"
            ? config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php?brandId=" +
                encodeURIComponent(brandId)
            : config.developmentPath +
                "/Admin/Controller/material_CategoryController.php?brandId=" +
                encodeURIComponent(brandId);

        var $category = $("#createPOCategory");

        $category
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $.getJSON(url)
            .done(function (data) {

                if (!data || data.length === 0) {
                    createPOShowMessage(
                        "warning",
                        "No categories found."
                    );
                    return;
                }

                $.each(data, function (index, value) {

                    var id = "";
                    var name = "";

                    if (createPOState.inventoryType === "item") {
                        id = value.itemcatid;
                        name = value.itemcatname;
                    } else {
                        id = value.materialcatId;
                        name = value.materialCatname;
                    }

                    if (id !== undefined && id !== "" &&
                        name !== undefined && name !== "") {

                        $category.append(
                            $('<option>', {
                                value: id,
                                text: name
                            })
                        );
                    }
                });

                $category.prop("disabled", false);

            })
            .fail(function () {
                createPOShowMessage(
                    "danger",
                    "Unable to load categories."
                );
            });
    }

    function createPOLoadSubCategories(categoryId) {

        var url = createPOState.inventoryType === "item"
            ? config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php?catId=" +
                encodeURIComponent(categoryId)
            : config.developmentPath +
                "/Admin/Controller/material_SubcategoryController.php?catId=" +
                encodeURIComponent(categoryId);

        var $subCategory = $("#createPOSubCategory");

        $subCategory
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $("#createPOItem")
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $.getJSON(url)
            .done(function (data) {

                if (!data || data.length === 0) {
                    return;
                }

                $.each(data, function (index, value) {

                    var id = "";
                    var name = "";

                    if (createPOState.inventoryType === "item") {
                        id = value.itemsubcatid;
                        name = value.itemsubcatname;
                    } else {
                        id = value.materialsubcatId;
                        name = value.materialsubcatName;
                    }

                    if (id !== undefined && id !== "" &&
                        name !== undefined && name !== "") {

                        $subCategory.append(
                            $('<option>', {
                                value: id,
                                text: name
                            })
                        );
                    }
                });

                $subCategory.prop("disabled", false);

            })
            .fail(function () {
                createPOShowMessage(
                    "danger",
                    "Unable to load sub categories."
                );
            });
    }

    function createPOLoadItems(categoryId, subCategoryId) {

        var brandId = $("#createPOBrand").val();

        var url = createPOState.inventoryType === "item"
            ? config.developmentPath +
                "/Admin/Controller/item_detailscontroller.php?catId=" +
                encodeURIComponent(categoryId) +
                "&subcatId=" +
                encodeURIComponent(subCategoryId) +
                "&brandId=" +
                encodeURIComponent(brandId)
            : config.developmentPath +
                "/Admin/Controller/materialController.php?catId=" +
                encodeURIComponent(categoryId) +
                "&subcatId=" +
                encodeURIComponent(subCategoryId) +
                "&brandId=" +
                encodeURIComponent(brandId);

        var $item = $("#createPOItem");

        $item
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $.getJSON(url)
            .done(function (data) {

                createPOState.itemDetails = data || [];

                if (!data || data.length === 0) {
                    return;
                }

                $.each(data, function (index, value) {

                    if (createPOState.inventoryType === "item") {

                        $item.append(
                            $('<option>', {
                                value: value.itemid,
                                text: value.itemname
                            })
                        );

                    } else {

                        $item.append(
                            $('<option>', {
                                value: value.MaterialId,
                                text: value.MaterialName
                            })
                        );
                    }
                });

                $item.prop("disabled", false);

            })
            .fail(function () {
                createPOShowMessage(
                    "danger",
                    "Unable to load items/materials."
                );
            });
    }

    function createPOGetSelectedItem() {

        var id = $("#createPOItem").val();

        if (!id) {
            return null;
        }

        if (createPOState.inventoryType === "item") {
            return createPOState.itemDetails.find(function (x) {
                return x.itemid == id;
            }) || null;
        }

        return createPOState.itemDetails.find(function (x) {
            return x.MaterialId == id;
        }) || null;
    }

    function createPOMapSelectedItem() {

        var item = createPOGetSelectedItem();

        if (!item) {
            $("#createPOSelectedItemName").val("");
            $("#createPOArticleNo").val("");
            $("#createPOItemDescription").val("");
            $("#createPOUnitFactor").val("1");
            $("#createPOUnitName").val("");
            $("#createPOItemPrice").val("");
            $("#createPOUnit").val("");
            $("#createPOItemCode").val("");
            $("#createPODescription").val("");
            return;
        }

        if (createPOState.inventoryType === "item") {

            $("#createPOSelectedItemName").val(
                createPONormalize(item.itemname)
            );

            $("#createPOArticleNo").val(
                createPONormalize(item.itemarticleNo)
            );

            $("#createPOItemDescription").val(
                createPONormalize(item.itemdescription)
            );

            $("#createPOUnitFactor").val(
                createPONormalize(item.unitFactor) || "1"
            );

            $("#createPOItemPrice").val(
                createPONormalize(item.itemperpieceprice)
            );

            $("#createPOUnit").val(
                createPONormalize(item.unitName || item.UnitName)
            );

            $("#createPOUnitName").val(
                createPONormalize(item.unitName || item.UnitName)
            );

            $("#createPOItemCode").val(
                createPONormalize(item.itemarticleNo)
            );

            $("#createPODescription").val(
                createPONormalize(item.itemdescription)
            );

        } else {

            $("#createPOSelectedItemName").val(
                createPONormalize(item.MaterialName)
            );

            $("#createPOArticleNo").val(
                createPONormalize(item.MaterialCode)
            );

            $("#createPOItemDescription").val(
                createPONormalize(item.MaterialDescription)
            );

            $("#createPOUnitFactor").val("1");

            $("#createPOItemPrice").val(
                createPONormalize(
                    item.MaterialPrice ||
                    item.Material_Price ||
                    item.Mat_PPMRP
                )
            );

            $("#createPOUnit").val(
                createPONormalize(item.unitName || item.UnitName)
            );

            $("#createPOUnitName").val(
                createPONormalize(item.unitName || item.UnitName)
            );

            $("#createPOItemCode").val(
                createPONormalize(item.MaterialCode)
            );

            $("#createPODescription").val(
                createPONormalize(item.MaterialDescription)
            );
        }
    }

    function createPOCalculateTotalAmount(row) {

        /*
         * Keep the existing page behavior. The original PO creation
         * page currently submits totalAmount as zero because there is
         * no active price input in the submitted form.
         *
         * We therefore do not alter the backend calculation contract.
         */
        var quantity = parseFloat(row.itemquantity);
        var price = parseFloat(row.itemperpieceprice);
        var factor = parseFloat(row.unitFactor);

        if (!isNaN(quantity) && !isNaN(price) && !isNaN(factor)) {
            return (quantity * price * factor).toFixed(2);
        }

        return "0";
    }

    function createPORenderTable() {

        var $tbody = $("#createPOLineItemTable tbody");
        $tbody.empty();

        $.each(createPOState.purchases, function (index, row) {

            var $tr = $("<tr>");

            $("<td>")
                .text(createPONormalize(row.inventoryType).toUpperCase())
                .appendTo($tr);

            $("<td>")
                .text(createPONormalize(row.Articleno))
                .appendTo($tr);

            $("<td>")
                .text(createPONormalize(row.selectedItemName))
                .appendTo($tr);

            $("<td>")
                .text(createPONormalize(row.selectedBrandName))
                .appendTo($tr);

            $("<td>")
                .text(createPONormalize(row.itemdescription))
                .appendTo($tr);

            $("<td>")
                .text(createPONormalize(row.itemquantity))
                .appendTo($tr);

            var $action = $("<td>", {
                "class": "text-center"
            });

            $("<button>", {
                type: "button",
                "class": "btn btn-warning btn-sm mr-1 createPOEditRow",
                "data-index": index,
                title: "Edit"
            })
                .html('<i class="fa fa-edit"></i>')
                .appendTo($action);

            $("<button>", {
                type: "button",
                "class": "btn btn-danger btn-sm createPODeleteRow",
                "data-index": index,
                title: "Delete"
            })
                .html('<i class="fa fa-trash"></i>')
                .appendTo($action);

            $action.appendTo($tr);
            $tbody.append($tr);
        });

        $("#createPOTotalItems").text(createPOState.purchases.length);

        if (createPOState.purchases.length === 0) {
            $("#createPOEmptyState").show();
        } else {
            $("#createPOEmptyState").hide();
        }
    }

    function createPOResetModal() {

        createPOState.inventoryType = "";
        createPOState.selectedSupplier = "";
        createPOState.itemDetails = [];
        createPOState.purchases = [];
        createPOState.editIndex = -1;

        $("#createPOPurchasedDate").val(createPOGetToday());

        $("#createPOSupplier")
            .val("")
            .prop("disabled", false);

        $("#createPOBrand")
            .empty()
            .append('<option value="">-- select an option --</option>')
            .prop("disabled", true);

        $("#createPOQuantity").val("");

        createPOResetDependentFields();
        createPORenderTable();
        createPOClearMessage();
    }

    function createPOAddCurrentItem() {

        createPOClearMessage();

        var supplier = $("#createPOSupplier").val();
        var brand = $("#createPOBrand").val();
        var inventoryType = createPOState.inventoryType;
        var category = $("#createPOCategory").val();
        var subcategory = $("#createPOSubCategory").val();
        var itemid = $("#createPOItem").val();
        var quantity = $("#createPOQuantity").val();

        if (!supplier) {
            createPOShowMessage("warning", "Please select Supplier.");
            return;
        }

        if (!brand) {
            createPOShowMessage("warning", "Please select Brand.");
            return;
        }

        if (!inventoryType) {
            createPOShowMessage("warning", "Please select Inventory.");
            return;
        }

        if (!category) {
            createPOShowMessage("warning", "Please select Category.");
            return;
        }

        if (!subcategory) {
            createPOShowMessage("warning", "Please select Sub Category.");
            return;
        }

        if (!itemid) {
            createPOShowMessage("warning", "Please select Name.");
            return;
        }

        if (!quantity || parseFloat(quantity) <= 0) {
            createPOShowMessage(
                "warning",
                "Please add the appropriate values in the Quantity."
            );
            return;
        }

        var item = createPOGetSelectedItem();

        if (!item) {
            createPOShowMessage(
                "warning",
                "Please select a valid Item/Material."
            );
            return;
        }

        var duplicate = createPOState.purchases.some(function (row) {

            return row.inventoryType === inventoryType &&
                row.itemid == itemid;

        });

        if (duplicate) {
            createPOShowMessage(
                "warning",
                "This Item/Material has already been added."
            );
            return;
        }

        var brandName = $("#createPOBrand option:selected").text();

        var row = {
            supplier: supplier,
            brands: brand,
            purchaseddate: $("#createPOPurchasedDate").val(),
            inventoryType: inventoryType,
            category: category,
            subcategory: subcategory,
            itemid: itemid,
            item: itemid,
            itemquantity: quantity,
            selectedItemName: $("#createPOSelectedItemName").val(),
            Articleno: $("#createPOArticleNo").val(),
            itemdescription: $("#createPOItemDescription").val(),
            selectedBrandName: brandName,
            unitFactor: $("#createPOUnitFactor").val() || "1",
            unitName: $("#createPOUnitName").val() || "",
            totalAmount: "0"
        };

        /*
         * Preserve the existing controller payload shape.
         * The original page also carries the selected item name,
         * article number, description, supplier and inventory type.
         */
        createPOState.purchases.push(row);

        createPORenderTable();

        /*
         * After adding an item, keep the supplier selected/locked
         * exactly like the existing purchaseorder.php behavior.
         */
        $("#createPOSupplier").prop("disabled", true);

        $("#createPOBrand").val("");
        $("#createPOInventoryType")
            .val("")
            .prop("disabled", false);

        $("#createPOCategory")
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $("#createPOSubCategory")
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $("#createPOItem")
            .empty()
            .append('<option value="">-- select --</option>')
            .prop("disabled", true);

        $("#createPOQuantity").val("");

        $("#createPOSelectedItemName").val("");
        $("#createPOArticleNo").val("");
        $("#createPOItemDescription").val("");
        $("#createPOUnitFactor").val("1");
        $("#createPOSelectedBrandName").val("");
        $("#createPOUnitName").val("");

        $("#createPOItemPrice").val("");
        $("#createPOUnit").val("");
        $("#createPOItemCode").val("");
        $("#createPODescription").val("");

        createPOState.inventoryType = "";
        createPOState.itemDetails = [];
    }

    function createPOLoadEditModal(index) {

        var data = createPOState.purchases[index];

        if (!data) {
            return;
        }

        createPOState.editIndex = index;

        $("#createPOEditSupplier")
            .empty()
            .append(
                $("<option>", {
                    value: data.supplier,
                    text: $("#createPOSupplier option:selected").text()
                })
            );

        $("#createPOEditBrand")
            .empty()
            .append(
                $("<option>", {
                    value: data.brands,
                    text: data.selectedBrandName
                })
            );

        $("#createPOEditPurchasedDate")
            .val(data.purchaseddate);

        $("#createPOEditInventory")
            .val(data.inventoryType);

        $("#createPOEditQuantity")
            .val(data.itemquantity);

        /*
         * These values are informational in the edit dialog because
         * the original purchaseorder.php disables them as well.
         */
        $("#createPOEditCategory")
            .empty()
            .append('<option value="' + data.category + '">Loading...</option>');

        $("#createPOEditSubCategory")
            .empty()
            .append('<option value="' + data.subcategory + '">Loading...</option>');

        $("#createPOEditItem")
            .empty()
            .append('<option value="' + data.itemid + '">Loading...</option>');

        createPOLoadEditCategory(data);

        $("#createPOEditItemModal").modal("show");
    }

    function createPOLoadEditCategory(data) {

        var url = data.inventoryType === "item"
            ? config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php?brandId=" +
                encodeURIComponent(data.brands)
            : config.developmentPath +
                "/Admin/Controller/material_CategoryController.php?brandId=" +
                encodeURIComponent(data.brands);

        $.getJSON(url)
            .done(function (res) {

                var $category = $("#createPOEditCategory");
                $category.empty();

                $.each(res || [], function (i, v) {

                    if (data.inventoryType === "item") {
                        $category.append(
                            $("<option>", {
                                value: v.itemcatid,
                                text: v.itemcatname
                            })
                        );
                    } else {
                        $category.append(
                            $("<option>", {
                                value: v.materialcatId,
                                text: v.materialCatname
                            })
                        );
                    }
                });

                $category.val(data.category);

                createPOLoadEditSubCategory(data);
            });
    }

    function createPOLoadEditSubCategory(data) {

        var url = data.inventoryType === "item"
            ? config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php?catId=" +
                encodeURIComponent(data.category)
            : config.developmentPath +
                "/Admin/Controller/material_SubcategoryController.php?catId=" +
                encodeURIComponent(data.category);

        $.getJSON(url)
            .done(function (res) {

                var $subCategory = $("#createPOEditSubCategory");
                $subCategory.empty();

                $.each(res || [], function (i, v) {

                    if (data.inventoryType === "item") {
                        $subCategory.append(
                            $("<option>", {
                                value: v.itemsubcatid,
                                text: v.itemsubcatname
                            })
                        );
                    } else {
                        $subCategory.append(
                            $("<option>", {
                                value: v.materialsubcatId,
                                text: v.materialsubcatName
                            })
                        );
                    }
                });

                $subCategory.val(data.subcategory);

                createPOLoadEditItem(data);
            });
    }

    function createPOLoadEditItem(data) {

        var url = data.inventoryType === "item"
            ? config.developmentPath +
                "/Admin/Controller/item_detailscontroller.php?catId=" +
                encodeURIComponent(data.category) +
                "&subcatId=" +
                encodeURIComponent(data.subcategory) +
                "&brandId=" +
                encodeURIComponent(data.brands)
            : config.developmentPath +
                "/Admin/Controller/materialController.php?catId=" +
                encodeURIComponent(data.category) +
                "&subcatId=" +
                encodeURIComponent(data.subcategory) +
                "&brandId=" +
                encodeURIComponent(data.brands);

        $.getJSON(url)
            .done(function (res) {

                var $item = $("#createPOEditItem");
                $item.empty();

                $.each(res || [], function (i, v) {

                    if (data.inventoryType === "item") {
                        $item.append(
                            $("<option>", {
                                value: v.itemid,
                                text: v.itemname
                            })
                        );
                    } else {
                        $item.append(
                            $("<option>", {
                                value: v.MaterialId,
                                text: v.MaterialName
                            })
                        );
                    }
                });

                $item.val(data.itemid);
            });
    }

    function createPOCreateOrder() {

        createPOClearMessage();

        if (createPOState.purchases.length === 0) {
            createPOShowMessage(
                "warning",
                "Please add at least one item."
            );
            return;
        }

        var $button = $("#createPOCreateButton");

        $button.prop("disabled", true)
            .html('<i class="fas fa-spinner fa-spin"></i> Creating...');

        /*
         * The existing purchaseordercontroller.php expects:
         * POST obj = array of PO line objects.
         */
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/purchaseordercontroller.php",
            data: {
                obj: createPOState.purchases
            },
            dataType: "json"
        })
        .done(function (response) {

            if (response && response.status) {

                createPOShowMessage(
                    "success",
                    response.message || "Purchase Order Created"
                );

                /*
                 * Give Bootstrap a moment to show the success state,
                 * then close and reload the actual PO management page.
                 */
                setTimeout(function () {
                    $("#createPurchaseOrderModal").modal("hide");
                    window.location.href =
                        config.developmentPath +
                        "/Admin/View/POview.php";
                }, 500);

            } else {

                createPOShowMessage(
                    "danger",
                    response && response.message
                        ? response.message
                        : "Unable to create Purchase Order."
                );

                $button.prop("disabled", false)
                    .html(
                        '<i class="fas fa-check"></i> Create Purchase Order'
                    );
            }

        })
        .fail(function (xhr) {

            console.error("Purchase Order AJAX failed:", xhr.responseText);

            createPOShowMessage(
                "danger",
                "Purchase Order could not be created. Please check the server response."
            );

            $button.prop("disabled", false)
                .html(
                    '<i class="fas fa-check"></i> Create Purchase Order'
                );
        });
    }

    function createPOCenterAndDragModal(modalSelector, disableDragOnMobile) {

        var modal = document.querySelector(modalSelector);

        if (!modal) {
            return;
        }

        var dialog = modal.querySelector(".modal-dialog");
        var header = modal.querySelector(".modal-header");

        if (!dialog || !header) {
            return;
        }

        var isMobile =
            window.matchMedia("(max-width: 767.98px)").matches;

        dialog.style.position = "fixed";
        dialog.style.margin = "0";
        dialog.style.transform = "none";

        if (isMobile && disableDragOnMobile) {
            dialog.style.left = "50%";
            dialog.style.top = "8px";
            dialog.style.transform = "translateX(-50%)";
            header.style.cursor = "default";
            return;
        }

        var vw = document.documentElement.clientWidth || window.innerWidth;
        var vh = document.documentElement.clientHeight || window.innerHeight;

        var width = dialog.offsetWidth;
        var height = dialog.offsetHeight;

        var left = Math.max(8, Math.round((vw - width) / 2));
        var top = Math.max(8, Math.round((vh - height) / 2));

        left = Math.min(left, Math.max(8, vw - width - 8));
        top = Math.min(top, Math.max(8, vh - height - 8));

        dialog.style.left = left + "px";
        dialog.style.top = top + "px";

        /*
         * Do not add a second drag handler.
         */
        if (header.dataset.createPoDragBound === "1") {
            return;
        }

        header.dataset.createPoDragBound = "1";

        var dragging = false;
        var pointerId = null;
        var offsetX = 0;
        var offsetY = 0;

        function clampPosition(leftValue, topValue) {

            var vwNow =
                document.documentElement.clientWidth || window.innerWidth;

            var vhNow =
                document.documentElement.clientHeight || window.innerHeight;

            var widthNow = dialog.offsetWidth;
            var heightNow = dialog.offsetHeight;

            return {
                left: Math.min(
                    Math.max(8, leftValue),
                    Math.max(8, vwNow - widthNow - 8)
                ),
                top: Math.min(
                    Math.max(8, topValue),
                    Math.max(8, vhNow - heightNow - 8)
                )
            };
        }

        header.addEventListener("pointerdown", function (e) {

            if (window.matchMedia("(max-width: 767.98px)").matches &&
                disableDragOnMobile) {
                return;
            }

            if ($(e.target).closest(
                "button, a, input, select, textarea, label"
            ).length) {
                return;
            }

            if (e.button !== undefined && e.button !== 0) {
                return;
            }

            var rect = dialog.getBoundingClientRect();

            dialog.style.left = rect.left + "px";
            dialog.style.top = rect.top + "px";

            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            dragging = true;
            pointerId = e.pointerId;

            try {
                header.setPointerCapture(pointerId);
            } catch (ignore) {}

            e.preventDefault();
        });

        document.addEventListener("pointermove", function (e) {

            if (!dragging ||
                (pointerId !== null && e.pointerId !== pointerId)) {
                return;
            }

            var position = clampPosition(
                e.clientX - offsetX,
                e.clientY - offsetY
            );

            dialog.style.left = position.left + "px";
            dialog.style.top = position.top + "px";

            e.preventDefault();
        }, { passive: false });

        document.addEventListener("pointerup", function (e) {

            if (!dragging) {
                return;
            }

            dragging = false;
            pointerId = null;

            try {
                header.releasePointerCapture(e.pointerId);
            } catch (ignore) {}
        });

        document.addEventListener("pointercancel", function () {
            dragging = false;
            pointerId = null;
        });
    }

    $(document).ready(function () {

        /*
         * Open Create PO modal.
         */
        $("#createPurchaseOrderModal").on(
            "show.bs.modal",
            function () {
                createPOResetModal();
                createPOLoadSuppliers();
            }
        );

        $("#createPurchaseOrderModal").on(
            "shown.bs.modal",
            function () {

                requestAnimationFrame(function () {
                    createPOCenterAndDragModal(
                        "#createPurchaseOrderModal",
                        true
                    );
                });
            }
        );

        /*
         * When closing the Create PO modal, also close the edit modal
         * and reset the temporary client-side array.
         */
        $("#createPurchaseOrderModal").on(
            "hidden.bs.modal",
            function () {

                if ($("#createPOEditItemModal").hasClass("show")) {
                    $("#createPOEditItemModal").modal("hide");
                }

                createPOState.purchases = [];
                createPOState.itemDetails = [];
                createPOState.inventoryType = "";
                createPOState.selectedSupplier = "";
                createPOState.editIndex = -1;

                $("#createPOForm")[0].reset();

                $("#createPOBrand")
                    .empty()
                    .append(
                        '<option value="">-- select an option --</option>'
                    )
                    .prop("disabled", true);

                createPOResetDependentFields();
                createPORenderTable();
            }
        );

        /*
         * Supplier -> Brands
         */
        $("#createPOSupplier").on("change", function () {

            createPOState.selectedSupplier = this.value;

            $("#createPOBrand")
                .empty()
                .append(
                    '<option value="">-- select an option --</option>'
                )
                .prop("disabled", true);

            createPOResetDependentFields();

            if (!this.value) {
                return;
            }

            createPOLoadBrands(this.value);
        });

        /*
         * Brand -> Inventory Type
         */
        $("#createPOBrand").on("change", function () {

            var brandId = this.value;
            var brandName = $("#createPOBrand option:selected").text();

            $("#createPOSelectedBrandName").val(
                brandName
            );

            createPOResetDependentFields();

            if (!brandId) {
                return;
            }

            createPOLoadInventoryTypes(brandId);
        });

        /*
         * Inventory Type -> Category
         */
        $("#createPOInventoryType").on("change", function () {

            createPOState.inventoryType = this.value;

            $("#createPOCategory")
                .empty()
                .append('<option value="">-- select --</option>')
                .prop("disabled", true);

            $("#createPOSubCategory")
                .empty()
                .append('<option value="">-- select --</option>')
                .prop("disabled", true);

            $("#createPOItem")
                .empty()
                .append('<option value="">-- select --</option>')
                .prop("disabled", true);

            if (!this.value) {
                return;
            }

            createPOLoadCategoryByInventory();
        });

        /*
         * Category -> Sub Category
         */
        $("#createPOCategory").on("change", function () {

            var categoryId = this.value;

            $("#createPOSubCategory")
                .empty()
                .append('<option value="">-- select --</option>')
                .prop("disabled", true);

            $("#createPOItem")
                .empty()
                .append('<option value="">-- select --</option>')
                .prop("disabled", true);

            if (!categoryId) {
                return;
            }

            createPOLoadSubCategories(categoryId);
        });

        /*
         * Sub Category -> Item/Material
         */
        $("#createPOSubCategory").on("change", function () {

            var subCategoryId = this.value;

            $("#createPOItem")
                .empty()
                .append('<option value="">-- select --</option>')
                .prop("disabled", true);

            if (!subCategoryId) {
                return;
            }

            createPOLoadItems(
                $("#createPOCategory").val(),
                subCategoryId
            );
        });

        /*
         * Item/Material -> map details.
         */
        $("#createPOItem").on("change", function () {
            createPOMapSelectedItem();
        });

        /*
         * Add item.
         */
        $("#createPOAddItem").on("click", function () {
            createPOAddCurrentItem();
        });

        /*
         * Edit item.
         */
        $(document).on(
            "click",
            "#createPOLineItemTable .createPOEditRow",
            function (e) {

                e.preventDefault();

                var index = parseInt(
                    $(this).attr("data-index"),
                    10
                );

                createPOLoadEditModal(index);
            }
        );

        /*
         * Delete item.
         */
        $(document).on(
            "click",
            "#createPOLineItemTable .createPODeleteRow",
            function (e) {

                e.preventDefault();

                var index = parseInt(
                    $(this).attr("data-index"),
                    10
                );

                if (
                    isNaN(index) ||
                    !createPOState.purchases[index]
                ) {
                    return;
                }

                if (!confirm(
                    "Are you sure you want to delete this item?"
                )) {
                    return;
                }

                createPOState.purchases.splice(index, 1);

                createPORenderTable();
            }
        );

        /*
         * Update edited item quantity.
         * The original page only updates quantity in the edit modal,
         * so we preserve that behavior.
         */
        $("#createPOUpdateItem").on("click", function () {

            var index = createPOState.editIndex;

            if (
                index < 0 ||
                !createPOState.purchases[index]
            ) {
                return;
            }

            var quantity = $("#createPOEditQuantity").val();

            if (!quantity || parseFloat(quantity) <= 0) {
                alert(
                    "Please add the appropriate values in the Quantity."
                );
                return;
            }

            createPOState.purchases[index].itemquantity = quantity;

            createPORenderTable();

            $("#createPOEditItemModal").modal("hide");
        });

        /*
         * Create PO.
         */
        $("#createPOCreateButton").on("click", function () {
            createPOCreateOrder();
        });

        /*
         * Edit modal centering.
         */
        $("#createPOEditItemModal").on(
            "shown.bs.modal",
            function () {

                requestAnimationFrame(function () {
                    createPOCenterAndDragModal(
                        "#createPOEditItemModal",
                        true
                    );
                });
            }
        );

        /*
         * If the user resizes the browser while either new modal is
         * open, keep it within the viewport.
         */
        $(window).on(
            "resize.createPOModal orientationchange.createPOModal",
            function () {

                $(".modal.show").each(function () {

                    if (
                        this.id !== "createPurchaseOrderModal" &&
                        this.id !== "createPOEditItemModal"
                    ) {
                        return;
                    }

                    var dialog =
                        this.querySelector(".modal-dialog");

                    if (!dialog) {
                        return;
                    }

                    var vw =
                        document.documentElement.clientWidth ||
                        window.innerWidth;

                    var vh =
                        document.documentElement.clientHeight ||
                        window.innerHeight;

                    var width = dialog.offsetWidth;
                    var height = dialog.offsetHeight;

                    var left = Math.min(
                        Math.max(8, parseFloat(dialog.style.left) || 0),
                        Math.max(8, vw - width - 8)
                    );

                    var top = Math.min(
                        Math.max(8, parseFloat(dialog.style.top) || 8),
                        Math.max(8, vh - height - 8)
                    );

                    dialog.style.left = left + "px";
                    dialog.style.top = top + "px";
                });
            }
        );
    });

})(jQuery);
</script>
