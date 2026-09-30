<?php
include('session.php');
require_once("../DB Operations/dbconnection.php");

// ===== PERMISSION CHECK FIRST =====
$db = ConnectDb::getInstance();
$conn = $db->getConnection();

$user_name = $_SESSION['login_user'];
$user_type = $_SESSION['User_type']; // role

// Run your existing permission logic ONLY for non-admin users
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
        AND ma.action_key='po_general'
    ");

    if ($check->num_rows == 0) {
        header("Location: noaccess.php");
        exit;
    }
}
// ===== END PERMISSION CHECK =====


// SAFE TO LOAD UI
include "purchaseorderheader.php";
require_once("../DB Operations/purchaseorderOps.php");
require_once("../Model/purchaseModel.php");
?>

<style>
    thead th {
        font-weight: 500;
    }

    /* Center only selected table data columns */
    #lineItemTable tbody td:nth-child(1),
    #lineItemTable tbody td:nth-child(2),
    #lineItemTable tbody td:nth-child(4),
    #lineItemTable tbody td:nth-child(6) {
        text-align: center;
    }

    #editItemModal .modal-dialog {
        margin: 0;
    }

    #editItemModal .modal-header {
        cursor: move;
    }

    .modal-header {
        cursor: move;
    }

    .form-check-input {
        position: static;
        margin-top: .3rem;
        margin-left: 0rem;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 6px;
    }


    /* =========================================================
       RESPONSIVE PURCHASE ORDER LAYOUT
       - Keeps the existing PHP/JS/business logic untouched
       - Form becomes 2 columns on tablets and 1 column on phones
       - Tables scroll horizontally instead of crushing columns
       - Modals stay inside the viewport on every screen size
       ========================================================= */
    html, body {
        max-width: 100%;
        overflow-x: hidden;
    }

    #content,
    #content-wrapper,
    #wrapper {
        min-width: 0;
    }

    #quote_form {
        width: 100%;
    }

    #quote_form .accordion-body {
        width: 100%;
        min-width: 0;
        overflow: hidden;
    }

    /* Form controls */
    #quote_form .row {
        margin-left: -8px;
        margin-right: -8px;
    }

    #quote_form .row > [class*="col-"] {
        padding-left: 8px;
        padding-right: 8px;
    }

    #quote_form select,
    #quote_form input,
    #editItemModal select,
    #editItemModal input {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Table: deliberately wide enough to remain readable */
    .po-table-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .po-table-scroll #lineItemTable {
        width: 100% !important;
        min-width: 820px !important;
        margin-bottom: 0;
        table-layout: fixed;
    }

    .po-table-scroll #lineItemTable th,
    .po-table-scroll #lineItemTable td {
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
        vertical-align: middle;
    }

    .po-table-scroll #lineItemTable th:nth-child(1),
    .po-table-scroll #lineItemTable td:nth-child(1) { width: 120px; }
    .po-table-scroll #lineItemTable th:nth-child(2),
    .po-table-scroll #lineItemTable td:nth-child(2) { width: 140px; }
    .po-table-scroll #lineItemTable th:nth-child(3),
    .po-table-scroll #lineItemTable td:nth-child(3) { width: 180px; }
    .po-table-scroll #lineItemTable th:nth-child(4),
    .po-table-scroll #lineItemTable td:nth-child(4) { width: 130px; }
    .po-table-scroll #lineItemTable th:nth-child(5),
    .po-table-scroll #lineItemTable td:nth-child(5) { width: 240px; }
    .po-table-scroll #lineItemTable th:nth-child(6),
    .po-table-scroll #lineItemTable td:nth-child(6) { width: 110px; }
    .po-table-scroll #lineItemTable th:nth-child(7),
    .po-table-scroll #lineItemTable td:nth-child(7) { width: 110px; }

    /* Modal base */
    .modal {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .modal-dialog {
        width: auto;
        max-width: calc(100vw - 30px);
        margin: 30px auto;
    }

    .modal-content {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .modal-header {
        cursor: move;
        user-select: none;
        -webkit-user-select: none;
        touch-action: none;
    }

    .modal-body {
        max-height: calc(100vh - 190px);
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    #editItemModal .modal-dialog {
        width: 700px;
        max-width: calc(100vw - 30px);
        margin: 30px auto;
    }

    #editItemModal .modal-body .row {
        margin-left: -8px;
        margin-right: -8px;
    }

    #editItemModal .modal-body .row > [class*="col-"] {
        padding-left: 8px;
        padding-right: 8px;
    }

    .modal-footer {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .modal-footer .btn {
        margin: 0 !important;
    }

    /* Tablet: don't force four narrow controls into one row */
    @media (max-width: 991.98px) {
        #quote_form .row > .col-md-3 {
            flex: 0 0 50%;
            max-width: 50%;
            margin-bottom: 14px;
        }

        #quote_form .form-group.mt-3 {
            margin-top: 4px !important;
        }

        .card-header,
        .card-body {
            padding-left: 14px !important;
            padding-right: 14px !important;
        }

        #editItemModal .modal-dialog {
            width: 92vw;
            max-width: 92vw;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        h1.h3,
        .h3 {
            font-size: 1.35rem;
            margin-bottom: 1rem !important;
        }

        .card {
            width: 100%;
            max-width: 100%;
        }

        .card-header {
            padding: 12px !important;
        }

        .card-header h6 {
            font-size: 1.05rem !important;
        }

        #quote_form .accordion-body {
            padding: 12px !important;
        }

        #quote_form .row > .col-md-3,
        #editItemModal .row > .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 12px;
        }

        #quote_form .form-group {
            margin-bottom: 10px;
        }

        #quote_form label,
        #editItemModal label {
            display: block;
            font-size: .92rem;
            margin-bottom: 5px;
        }

        #quote_form .form-control,
        #quote_form .form-select,
        #editItemModal .form-control,
        #editItemModal .form-select {
            min-height: 40px;
            font-size: .92rem;
        }

        .po-table-scroll #lineItemTable {
            min-width: 820px !important;
        }

        .modal-dialog,
        #editItemModal .modal-dialog {
            width: calc(100vw - 20px) !important;
            max-width: calc(100vw - 20px) !important;
            margin: 10px auto !important;
        }

        .modal-header {
            padding: 12px 14px;
        }

        .modal-title {
            font-size: 1rem;
            padding-right: 10px;
        }

        .modal-body {
            max-height: calc(100vh - 145px);
            padding: 14px !important;
        }

        .modal-footer {
            padding: 10px 14px;
            justify-content: flex-end;
        }

        .modal-footer .btn {
            flex: 0 0 auto;
        }
    }

    /* Very small phones */
    @media (max-width: 380px) {
        #quote_form .accordion-body {
            padding: 9px !important;
        }

        .card-header {
            padding: 10px !important;
        }

        .po-table-scroll #lineItemTable {
            min-width: 780px !important;
        }

        .modal-dialog,
        #editItemModal .modal-dialog {
            width: calc(100vw - 12px) !important;
            max-width: calc(100vw - 12px) !important;
            margin: 6px auto !important;
        }

        .modal-body {
            padding: 10px !important;
        }

        .modal-footer {
            justify-content: stretch;
        }

        .modal-footer .btn {
            flex: 1 1 auto;
        }
    }

    /* If DataTables adds its own wrapper, allow the same horizontal behavior */
    #lineItemTable_wrapper,
    #lineItemTable_wrapper .dataTables_scroll,
    #lineItemTable_wrapper .dataTables_scrollBody {
        max-width: 100%;
    }

    #lineItemTable_wrapper .dataTables_scrollBody {
        -webkit-overflow-scrolling: touch;
    }

</style>
<h1 class="h3 mb-4 text-gray-800">Purchase Order</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-primary" style="font-size: 1.2rem;">Purchase
                    Order</h6><br>
            </div>
            <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
                <div class="accordion-item">
                    <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="form-group">
                                <div class="row">
                                    <input type="hidden" name="selectedItemName" id="selectedItemName">
                                    <input type="hidden" name="Articleno" id="Articleno">
                                    <input type="hidden" name="itemdescription" id="itemdescription">
                                    <input type="hidden" name="unitFactor" id="unitFactor">
                                    <input type="hidden" name="selectedBrandName" id="selectedBrandName">


                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">Supplier <span
                                                class="text-danger">*</span></label>
                                        <select id="supplier" class="form-select" required name="supplier"></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">Brands <span
                                                class="text-danger">*</span></label>
                                        <select id="brands" class="form-select" required name="brands"></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">DOP <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="purchaseddate" name="purchaseddate">
                                    </div>

                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">Inventory <span
                                                class="text-danger">*</span></label>
                                        <select id="inventoryType" name="inventoryType" class="form-select" required>
                                            <option value="" hidden>-- Select --</option>
                                        </select>

                                    </div>

                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="row">

                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">Category <span
                                                class="text-danger">*</span></label>
                                        <select id="itemCategory" class="form-select" required></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">Sub Category <span
                                                class="text-danger">*</span></label>
                                        <select id="itemsubCategory" class="form-select" required></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">Name *</label>
                                        <select id="itemid" name="itemid" class="form-select" required></select>

                                    </div>

                                    <div class="col-md-3">
                                        <label style="font-weight: 500;">Quantity *</label>
                                        <input type="text" id="itemquantity" name="itemquantity" class="form-control"
                                            required>
                                    </div>


                                </div>

                            </div>


                            <div class="form-group">
                                <div class="row">




                                </div>
                            </div>
                            <div class="po-table-scroll">
                                <table class="table table-bordered" id="lineItemTable" width="100%" cellspacing="0">
                                </div>
                                <thead align="center">
                                    <tr>
                                        <th>Inventory</th>
                                        <th>Article Code</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th width="90">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                            <div class="form-group">
                                <div class="row ">


                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-primary" id="createQuote">Add
                                    </button>
                                    <button type="button" class="btn btn-primary" id="Quote">Create Purchase
                                        Order</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Edit Purchase Item
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Supplier</label>
                        <select id="editSupplier" class="form-select" disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Brand</label>
                        <select id="editBrand" class="form-select" disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>DOP</label>
                        <input type="date" id="editPurchasedDate" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Inventory</label>
                        <select id="editInventory" class="form-select" disabled>
                            <option value="item">Item</option>
                            <option value="material">Material</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Category</label>
                        <select id="editCategory" class="form-select" disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sub Category</label>
                        <select id="editSubCategory" class="form-select" disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <select id="editItem" class="form-select" disabled></select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Quantity</label>
                        <input type="number" id="editQuantity" class="form-control">
                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>

                <button type="button" class="btn btn-success" id="updateRow">
                    Update
                </button>

            </div>

        </div>
    </div>
</div>
<?php
include "footer.php";
?>

<script>

    let inventoryType = "";
    let itemDetails = [];

    let editIndex = -1;
    let editItemDetails = [];

    $('#inventoryType').on('change', function () {
        inventoryType = this.value;
        $('#itemCategory, #itemsubCategory, #itemid').empty();
        if (!inventoryType) return;
        loadCategoryByInventory();
    });

    function loadCategoryByInventory() {

        let brandId = $('#brands').val();
        if (!brandId) {
            alert("Please select Brand first");
            $('#inventoryType').val('');
            return;
        }

        let url = inventoryType === "item"
            ? config.developmentPath + "/Admin/Controller/item_categorycontroller.php?brandId=" + brandId
            : config.developmentPath + "/Admin/Controller/material_CategoryController.php?brandId=" + brandId;

        $.getJSON(url, function (data) {

            console.log("Category API Data:", data); // debug

            $('#itemCategory')
                .empty()
                .append('<option hidden selected>-- select --</option>');

            if (!data || data.length === 0) {
                alert("No categories found");
                return;
            }

            data.forEach(v => {

                let id, name;

                if (inventoryType === "item") {
                    id = v.itemcatid;
                    name = v.itemcatname;
                } else {
                    // ✅ EXACT keys from your API
                    id = v.materialcatId;
                    name = v.materialCatname;
                }

                if (id && name) {
                    $('#itemCategory').append(
                        `<option value="${id}">${name}</option>`
                    );
                }
            });
        });
    }
    $('#brands').on('change', function () {

        const brandId = this.value;
        const brandName = $('#brands option:selected').text();
        $('#selectedBrandName').val(brandName);

        // reset dependent fields
        $('#itemCategory, #itemsubCategory, #itemid').empty();

        const $inventory = $('#inventoryType');
        $inventory.empty().append('<option value="" hidden>-- Select --</option>');

        if (!brandId) return;

        const url = config.developmentPath +
            "/Admin/Controller/brandcontroller.php?action=inventoryTypes&brandId=" + brandId;

        $.getJSON(url)
            .done(function (res) {

                console.log("Inventory mapping:", res);

                const $inventory = $('#inventoryType');
                $inventory.empty().append('<option value="" hidden>-- Select --</option>');

                // 🔒 BUSINESS RULE OVERRIDE
                if (res.item === true) {
                    $inventory.append('<option value="item">Item</option>');
                }

                if (res.material === true) {
                    $inventory.append('<option value="material">Material</option>');
                }


                // ❌ IGNORE material if item exists
            });

    });




    $('#itemCategory').on('change', function () {

        $('#itemsubCategory').empty();
        $('#itemid').empty();

        let url = inventoryType === "item"
            ? config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php?catId=" + this.value
            : config.developmentPath + "/Admin/Controller/material_SubcategoryController.php?catId=" + this.value;

        $.getJSON(url, function (data) {

            console.log("Material SubCategory API:", data); // debug

            $('#itemsubCategory')
                .append('<option hidden selected>-- select --</option>');

            if (!data || data.length === 0) return;

            data.forEach(v => {

                let id, name;

                if (inventoryType === "item") {
                    id = v.itemsubcatid;
                    name = v.itemsubcatname;
                } else {
                    // ✅ EXACT keys from your JSON
                    id = v.materialsubcatId;
                    name = v.materialsubcatName;
                }

                if (id && name) {
                    $('#itemsubCategory').append(
                        `<option value="${id}">${name}</option>`
                    );
                }
            });
        });
    });


    $('#itemsubCategory').on('change', function () {

        $('#itemid').empty();

        let url = inventoryType === "item"
            ? config.developmentPath + "/Admin/Controller/item_detailscontroller.php?catId=" +
            $('#itemCategory').val() + "&subcatId=" + this.value + "&brandId=" + $('#brands').val()
            : config.developmentPath + "/Admin/Controller/materialController.php?catId=" +
            $('#itemCategory').val() + "&subcatId=" + this.value + "&brandId=" + $('#brands').val();

        $.getJSON(url, function (data) {

            console.log("Material Items API:", data); // 🔍 DEBUG

            itemDetails = data;

            $('#itemid')
                .empty()
                .append('<option hidden selected>-- select --</option>');

            if (!data || data.length === 0) return;

            data.forEach(v => {

                if (inventoryType === "item") {
                    $('#itemid').append(
                        `<option value="${v.itemid}">${v.itemname}</option>`
                    );
                } else {
                    // ✅ MATERIAL (EXACT KEYS FROM API)
                    $('#itemid').append(
                        `<option value="${v.MaterialId}">${v.MaterialName}</option>`
                    );
                }
            });
        });
    });





    function resetItemEntryForm() {

        // Lock supplier
        // Keep supplier selected
        $('#supplier').prop('disabled', true);

        // Keep brand list, just clear selection
        $('#brands').val('');

        // Keep inventory list, just clear selection
        $('#inventoryType').val('');

        // Clear dependent dropdowns
        $('#itemCategory').empty()
            .append('<option hidden selected>-- select --</option>');

        $('#itemsubCategory').empty()
            .append('<option hidden selected>-- select --</option>');

        $('#itemid').empty()
            .append('<option hidden selected>-- select --</option>');

        // Quantity
        $('#itemquantity').val('');

        // Hidden fields
        $('#selectedItemName').val('');
        $('#Articleno').val('');
        $('#itemdescription').val('');
        $('#selectedBrandName').val('');
        $('#unitFactor').val('');

        inventoryType = "";
        itemDetails = [];
        // selectedSupplier = "";
    }
    var purchases = [];
    let selectedRow = null;
    $(document).ready(function () {

        // Responsive draggable modal. On phones the modal stays centered and
        // dragging is disabled so touch scrolling works normally.
        $('#editItemModal').on('shown.bs.modal', function () {

            var $dialog = $(this).find('.modal-dialog');
            var isMobile = window.matchMedia('(max-width: 767.98px)').matches;

            if ($dialog.hasClass('ui-draggable')) {
                $dialog.draggable('destroy');
            }

            if (isMobile) {
                $dialog.css({
                    position: 'fixed',
                    left: '50%',
                    top: '10px',
                    margin: 0,
                    transform: 'translateX(-50%)'
                });
                return;
            }

            $dialog.css({
                position: 'fixed',
                left: '50%',
                top: '50%',
                margin: 0,
                transform: 'translate(-50%, -50%)'
            });

            $dialog.draggable({
                handle: '.modal-header',
                containment: 'window',
                scroll: false,
                start: function () {
                    $(this).css('transform', 'none');
                }
            });
        });

        // Keep an opened modal inside the viewport after resize/orientation change.
        $(window).on('resize orientationchange', function () {
            $('.modal.show').each(function () {
                var $dialog = $(this).find('.modal-dialog');
                if (!$dialog.length) return;

                if (window.matchMedia('(max-width: 767.98px)').matches) {
                    if ($dialog.hasClass('ui-draggable')) {
                        $dialog.draggable('destroy');
                    }
                    $dialog.css({
                        position: 'fixed',
                        left: '50%',
                        top: '10px',
                        margin: 0,
                        transform: 'translateX(-50%)'
                    });
                } else {
                    if (!$dialog.hasClass('ui-draggable')) {
                        $dialog.css({
                            position: 'fixed',
                            left: '50%',
                            top: '50%',
                            margin: 0,
                            transform: 'translate(-50%, -50%)'
                        });
                    }
                }
            });
        });
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;

        document.getElementById("purchaseddate").value = today;

        $('#createQuote').click(function () {
            var formData = $('#quote_form').serializeJSON();


            // Supplier is disabled, so serializeJSON() won't include it.
            // Add it manually.
            formData.supplier = selectedSupplier;
            formData.inventoryType = inventoryType;
            formData.category = $('#itemCategory').val();
            formData.subcategory = $('#itemsubCategory').val();
            formData.item = $('#itemid').val();

            // Duplicate validation
            let duplicate = purchases.some(function (row) {

                return row.inventoryType === formData.inventoryType &&
                    row.item == formData.item;

            });

            if (duplicate) {

                alert("This Item/Material has already been added.");

                return;

            }
            console.log("========== ADD ITEM ==========");
            console.log(formData);
            console.log("Supplier :", formData.supplier);
            console.log("Brand :", formData.brands);
            console.log("Inventory :", formData.inventoryType);
            purchases.push(formData);
            if (formData['itemquantity'] != "" && formData['itemquantity'] != "0") {
                $('#lineItemTable tbody').
                    append($(document.createElement('tr')).prop({

                    }));
                $('#lineItemTable tr:last').append(
                    `<td>${inventoryType.toUpperCase()}</td>`
                );

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['Articleno']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['selectedItemName']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['selectedBrandName']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['itemdescription']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['itemquantity']
                    }));


                $('#lineItemTable tr:last').append(`
                    <td class="text-center">

                        <button
                            type="button"
                            class="btn btn-warning btn-sm editRow"
                            data-index="${purchases.length - 1}"
                            title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button
                            type="button"
                            class="btn btn-danger btn-sm deleteRow"
                            data-index="${purchases.length - 1}"
                            title="Delete">
                            <i class="fa fa-trash"></i>
                        </button>

                    </td>
                    `);

                // Reset form for next item
                resetItemEntryForm();
                // $('#lineItemTable tr:last').
                // append($(document.createElement('td')).prop({
                //     innerHTML: formData['itemperpieceprice']
                // }));

            } else {
                alert("Please add the appropriate values in the Quantity")
            }





        });
        $(document).on("click", ".editRow", function (e) {

            e.preventDefault();

            editIndex = $(this).data("index");

            selectedRow = purchases[editIndex];

            console.log("===== EDIT CLICK =====");
            console.log("Row :", editIndex);
            console.log(selectedRow);

            loadEditModal(selectedRow);

        });

        $(document).on("click", ".deleteRow", function () {

            let rowIndex = $(this).data("index");

            if (!confirm("Are you sure you want to delete this item?")) {
                return;
            }

            // Remove from purchases array
            purchases.splice(rowIndex, 1);

            // Remove row from table
            $(this).closest("tr").remove();

            // Re-index all Edit/Delete buttons
            $("#lineItemTable tbody tr").each(function (index) {

                $(this).find(".editRow")
                    .attr("data-index", index);

                $(this).find(".deleteRow")
                    .attr("data-index", index);

            });

        });

        function loadEditModal(data) {

            // Supplier
            $('#editSupplier').empty();

            $('#editSupplier').append(
                `<option value="${data.supplier}">
            ${$('#supplier option:selected').text()}
        </option>`
            );

            // Date

            $('#editPurchasedDate').val(data.purchaseddate);

            // Inventory

            $('#editInventory').val(data.inventoryType);

            // Quantity

            $('#editQuantity').val(data.itemquantity);

            // Brand

            loadEditBrands(data);

        }

        function loadEditBrands(data) {

            $('#editBrand').empty();

            let supplierId = data.supplier;

            $.getJSON(

                config.developmentPath +
                "/Admin/Controller/brandcontroller.php/?supplierId=" + supplierId,

                function (res) {

                    $.each(res, function (i, v) {

                        $('#editBrand').append(

                            `<option value="${v.brandid}">
                        ${v.brandname}
                    </option>`

                        );

                    });

                    $('#editBrand').val(data.brands);

                    loadEditInventory(data);

                }

            );

        }

        function loadEditInventory(data) {

            $('#editInventory').trigger('change');

            setTimeout(function () {

                loadEditCategory(data);

            }, 300);

        }
        $('#editInventory').change(function () {

            editInventoryType = this.value;

        });

        function loadEditCategory(data) {

            let url = "";

            if (data.inventoryType == "item") {

                url = config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php?brandId=" +
                    data.brands;

            }
            else {

                url = config.developmentPath +
                    "/Admin/Controller/material_CategoryController.php?brandId=" +
                    data.brands;

            }

            $.getJSON(url, function (res) {

                $('#editCategory').empty();

                $.each(res, function (i, v) {

                    if (data.inventoryType == "item") {

                        $('#editCategory').append(

                            `<option value="${v.itemcatid}">
                    ${v.itemcatname}
                    </option>`

                        );

                    }
                    else {

                        $('#editCategory').append(

                            `<option value="${v.materialcatId}">
                    ${v.materialCatname}
                    </option>`

                        );

                    }

                });

                $('#editCategory').val(data.category);

                loadEditSubCategory(data);


            });

        }
        function loadEditSubCategory(data) {
            let url = "";

            if (data.inventoryType == "item") {

                url = config.developmentPath +
                    "/Admin/Controller/item_subcategorycontroller.php?catId=" +
                    data.category;

            } else {

                url = config.developmentPath +
                    "/Admin/Controller/material_SubcategoryController.php?catId=" +
                    data.category;

            }

            $.getJSON(url, function (res) {

                $('#editSubCategory').empty();

                $.each(res, function (i, v) {

                    if (data.inventoryType == "item") {

                        $('#editSubCategory').append(
                            `<option value="${v.itemsubcatid}">
                        ${v.itemsubcatname}
                    </option>`
                        );

                    } else {

                        $('#editSubCategory').append(
                            `<option value="${v.materialsubcatId}">
                        ${v.materialsubcatName}
                    </option>`
                        );

                    }

                });

                $('#editSubCategory').val(data.subcategory);

                loadEditItem(data);

            });

        }
        function loadEditItem(data) {
            let url = "";

            if (data.inventoryType == "item") {

                url = config.developmentPath +
                    "/Admin/Controller/item_detailscontroller.php?catId=" +
                    data.category +
                    "&subcatId=" + data.subcategory +
                    "&brandId=" + data.brands;

            } else {

                url = config.developmentPath +
                    "/Admin/Controller/materialController.php?catId=" +
                    data.category +
                    "&subcatId=" + data.subcategory +
                    "&brandId=" + data.brands;

            }

            $.getJSON(url, function (res) {

                $('#editItem').empty();

                $.each(res, function (i, v) {

                    if (data.inventoryType == "item") {

                        $('#editItem').append(
                            `<option value="${v.itemid}">
                        ${v.itemname}
                    </option>`
                        );

                    } else {

                        $('#editItem').append(
                            `<option value="${v.MaterialId}">
                        ${v.MaterialName}
                    </option>`
                        );

                    }

                });

                $('#editItem').val(data.item);

                $('#editItemModal').modal('show');

            });

        }



        $(document).on("click", "#updateRow", function () {

            // Update purchases array
            purchases[editIndex].itemquantity = $("#editQuantity").val();

            // Update table quantity column
            $("#lineItemTable tbody tr")
                .eq(editIndex)
                .find("td:eq(5)")
                .text($("#editQuantity").val());

            // Close modal
            $('#editItemModal').modal('hide');
        });

        $('#Quote').click(function () {

            if (purchases.length === 0) {
                alert("Please add at least one item.");
                return;
            }
            console.log(purchases);
            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/purchaseordercontroller.php",
                data: {
                    obj: purchases
                },
                dataType: "json"
            })
                .done(function (response) {

                    console.log(response);

                    if (response.status) {
                        window.location.href = config.developmentPath + "/Admin/View/POview.php";
                    }

                })
                .fail(function (xhr) {

                    console.log("AJAX FAILED");
                    console.log(xhr.responseText);

                });

        });

        var uniturl = config.developmentPath +
            "/Admin/Controller/unitsContoller.php"
        $.getJSON(uniturl, function (data) {
            loadUnitFactor(data[0].unitId);
            $.each(data, function (index, value) {
                $('#unit').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#unit').append('<option value="' + value.unitId + '">' + value
                    .unitName + '</option>');
            });

        });

        function loadUnitFactor(unitId) {
            $('#unitFactor').empty();
            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#unitFactor').append(
                        '<option hidden disabled selected value>Blank</option>');
                    $('#unitFactor').append('<option value="' + value.unitFactorId +
                        '">' + value.unitFactor + '</option>');

                });
            });
        }



        $('#itemperpieceprice').blur(function (e) {

            $('#totalAmount').val((parseFloat($('#itemquantity').val() * parseFloat($(
                '#itemperpieceprice')
                .val()) * parseFloat($('#unitFactor').val()))).toFixed(2));

        });



        // $('#itemid').empty();

        // var url = config.developmentPath + "/Admin/Controller/item_detailscontroller.php";
        // $.getJSON(url, function (data) {

        //     itemDetails = data;
        //     mappItemPrice(data[0].itemperpieceprice,
        //         data[0].itemname,
        //         data[0].unitFactor,
        //         data[0].itemarticleNo,
        //         data[0].itemdescription);
        //     $.each(data, function (index, value) {
        //         $('#itemid').append('<option value="' + value.itemid + '">' + value
        //             .itemname + '</option>');
        //     });
        // });

        $('#itemid').on('change', function () {

            let id = this.value;

            let item = inventoryType === "item"
                ? itemDetails.find(x => x.itemid == id)
                : itemDetails.find(x => x.MaterialId == id);

            if (!item) return;

            if (inventoryType === "item") {
                $('#selectedItemName').val(item.itemname);
                $('#Articleno').val(item.itemarticleNo || '');
                $('#itemdescription').val(item.itemdescription || '');
                $('#unitFactor').val(item.unitFactor || 1);
            } else {
                // ✅ MATERIAL
                $('#selectedItemName').val(item.MaterialName);
                $('#Articleno').val(item.MaterialCode || '');
                $('#itemdescription').val(item.MaterialDescription || '');
                $('#unitFactor').val(1);
            }
        });



        var fetchCompanylist = config.developmentPath +
            "/Admin/Controller/item_compdetailscontroller.php/";
        console.log(fetchCompanylist);
        console.log(this.value);
        $.getJSON(fetchCompanylist, function (data) {

            $.each(data, function (index, value) {
                $('#supplier').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#supplier').append('<option value="' + value.itemcompid + '">' +
                    value
                        .itemcompname + '</option>');
                $('#editedcompany').append('<option value="' + value.itemcompid + '">' +
                    value
                        .itemcompname + '</option>');
            });
        });
        $('#supplier').on('change', function (e) {
            selectedSupplier = this.value;
            debugger;
            $('#brands').empty();
            fetchbrandlist =
                config.developmentPath +
                "/Admin/Controller/brandcontroller.php/?supplierId=" + this.value;
            console.log(fetchbrandlist);
            console.log(this.value);
            $.getJSON(fetchbrandlist, function (data) {
                console.log(data)
                $('#brands').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#brands').append('<option value="' + value.brandid +
                        '">' + value.brandname + '</option>');
                });
            });

        });
        // $('#brands').on('change', function () {
        //     debugger;
        //     let brandId = 0;
        //     $('#itemCategory').empty();

        //     fetchcatlist = config.developmentPath +
        //         "/Admin/Controller/item_categorycontroller.php/?brandId=" + this.value;
        //     console.log(fetchcatlist);
        //     $.getJSON(fetchcatlist, function (data) {
        //         $('#itemCategory').append(
        //             '<option hidden disabled selected value>-- select an option --</option>'
        //         );
        //         $.each(data, function (index, value) {

        //             $('#itemCategory').append('<option value="' + value
        //                 .itemcatid +
        //                 '">' +
        //                 value
        //                     .itemcatname + '</option>');
        //         });
        //     });

        // });
        // $('#itemCategory').on('change', function () {
        //     debugger;
        //     $('#itemsubCategory').empty();
        //     var fetchsubcaturl = config.developmentPath +
        //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
        //         this.value;
        //     let subcatId = 0;
        //     let projId = 0;
        //     $.getJSON(fetchsubcaturl, function (data) {
        //         $('#itemsubCategory').append(
        //             '<option hidden disabled selected value>-- select an option --</option>');
        //         $.each(data, function (index, value) {
        //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
        //             $('#itemsubCategory').append('<option value="' + value.itemsubcatid +
        //                 '">' +
        //                 value
        //                     .itemsubcatname + '</option>');
        //             $('#editeditemsubCategory').append('<option value="' + value
        //                 .itemsubcatid +
        //                 '">' +
        //                 value
        //                     .itemsubcatname + '</option>');
        //         });
        //     });
        // });



        function mappItemPrice(price, name, unitFactor, itemarticleNo, itemdescription) {
            debugger;
            $('#itemperpieceprice').val(price);
            $('#selectedItemName').val(name);
            $('#unitFactor').val(unitFactor);
            $('#Articleno').val(itemarticleNo);
            $('#itemdescription').val(itemdescription);
        }

        // function setItemlist(catId, subcatId, brandId) {
        //     debugger;
        //     let itemId = 0;

        //     var fetchitemlisturl = config.developmentPath +
        //         "/Admin/Controller/item_detailscontroller.php/?catId=" + catId + "&subcatId=" + subcatId + "&brandId=" + brandId;
        //     console.log(fetchitemlisturl);
        //     $.getJSON(fetchitemlisturl, function (data) {
        //         itemDetails = data;
        //         $('#itemid').append(
        //             '<option hidden disabled selected value>-- select an option --</option>');
        //         $.each(data, function (index, value) {
        //             $('#itemid').append('<option value="' + value.itemid + '">' + value.itemname +
        //                 '</option>');
        //         });
        //     });
        // }

        // function setBrandlist(itemId) {
        //     debugger;
        //     let brandId = 0;
        //     var fetchbrandlisturl = config.developmentPath +
        //         "/Admin/Controller/brandcontroller.php/?itemId=";
        //     console.log(fetchbrandlisturl);
        //     $.getJSON(fetchbrandlisturl, function(data) {

        //         // console.log(itemDetails);
        //         $('#brands').append(
        //             '<option hidden disabled selected value>-- select an option --</option>'
        //         );
        //         $.each(data, function(index, value) {
        //             $('#brands').append('<option value="' + value.brandid + '">' + value
        //                 .brandname +
        //                 '</option>');
        //         });
        //     });
        // }

        function setCompanylist(brandId) {
            debugger;
            var fetchCompanylist = config.developmentPath +
                "/Admin/Controller/item_compdetailscontroller.php/?brandId=" + brandId;
            $.getJSON(fetchCompanylist, function (data) {

                $.each(data, function (index, value) {
                    $('#supplier').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $('#supplier').append('<option value="' + value.itemcompid + '">' + value
                        .itemcompname + '</option>');
                    $('#editedcompany').append('<option value="' + value.itemcompid + '">' + value
                        .itemcompname + '</option>');
                });
            });

        }




        // $('#itemCategory').on('change', function() {
        //     $('#itemsubCategory').empty();

        //     fetchsubcaturl =
        //         config.developmentPath +
        //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
        //         .value;
        //     $.getJSON(fetchsubcaturl, function(data) {
        //         $('#itemsubCategory').append(
        //             '<option hidden disabled selected value>-- select an option --</option>'
        //         );
        //         $.each(data, function(index, value) {
        //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
        //             $('#itemsubCategory').append('<option value="' + value.itemsubcatid +
        //                 '">' + value.itemsubcatname + '</option>');
        //         });
        //     });
        // });
        // $('#itemsubCategory').on('change', function () {
        //     debugger;
        //     $('#itemid').empty();
        //     setItemlist($('#itemCategory').val(), this.value, $('#brands').val());

        // });
    });
</script>