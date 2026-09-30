<?php
include('session.php');
require_once "../DB Operations/invoiceOps.php";
?>
<?php include('invoicenavbar.php'); ?>

<style>
    .card-body #Invoice_table th {
        font-weight: 500;
    }
    .invoice-page .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-radius: 8px 8px 0 0;
    }

    /* Match Customer page table spacing */
    .invoice-page #Invoice_table {
        width: 100% !important;
    }

    .invoice-page #Invoice_table thead th {
        vertical-align: middle;
        text-align: center;
        white-space: nowrap;
        padding: 10px 12px !important;
    }

    .invoice-page #Invoice_table tbody td {
        vertical-align: middle;
        padding: 10px 12px !important;
    }

    .invoice-page #Invoice_table tbody tr {
        height: 48px;
    }

    .invoice-page #Invoice_table td:nth-child(1),
    .invoice-page #Invoice_table th:nth-child(1) {
        width: 6%;
        text-align: center;
    }

    .invoice-page #Invoice_table td:nth-child(2),
    .invoice-page #Invoice_table th:nth-child(2) {
        width: 16%;
    }

    .invoice-page #Invoice_table td:nth-child(3),
    .invoice-page #Invoice_table th:nth-child(3) {
        width: 18%;
    }

    .invoice-page #Invoice_table td:nth-child(4),
    .invoice-page #Invoice_table th:nth-child(4) {
        width: 20%;
    }

    .invoice-page #Invoice_table td:nth-child(5),
    .invoice-page #Invoice_table th:nth-child(5) {
        width: 15%;
    }

    .invoice-page #Invoice_table td:nth-child(6),
    .invoice-page #Invoice_table th:nth-child(6) {
        width: 13%;
    }

    .invoice-page #Invoice_table td:nth-child(7),
    .invoice-page #Invoice_table th:nth-child(7) {
        width: 12%;
        text-align: center;
    }

    /* Same simple dropdown sizing as the Customer page. */
    /* Same simple dropdown sizing as the Customer page. */
    .invoice-page #Invoice_table .dropdown-menu {
        min-width: 185px;
        z-index: 2000;
        display: none;
    }

    .invoice-page #Invoice_table .dropdown-menu.show {
        display: block;
        position: absolute;
    }

    /* Prevent the table wrapper from clipping the dropdown. */
    .invoice-page .table-responsive {
        overflow-x: auto;
        overflow-y: visible;
    }


    .invoice-page .table-responsive {
        overflow-x: auto;
    }

    #invoiceModal .modal-dialog {
        max-width: 1100px;
    }

    #invoiceModal .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
    }

    #invoiceModal .modal-body {
        background: #f7f8fc;
    }

    #invoiceModal .section-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    #invoiceModal .section-title {
        font-weight: 700;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #667eea;
    }

    #invoiceItemsTable th {
        background: #667eea;
        color: #fff;
        font-size: 13px;
        text-align: center;
    }

    #invoiceItemsTable td {
        vertical-align: middle;
    }

    #invoiceItemsTable input {
        min-width: 80px;
    }

    /* Scroll only the invoice items area */
    #invoiceModal .invoice-items-scroll {
        max-height: 350px;
        overflow-y: auto;
        overflow-x: auto;
    }

    /* Keep the table header visible while scrolling */
    #invoiceItemsTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #667eea;
    }

    /* Keep item rows compact */
    #invoiceItemsTable tbody td {
        padding: 3px 4px;
    }

    /* Keep inputs compact */
    #invoiceItemsTable tbody input {
        height: 34px;
        padding: 4px 8px;
    }

    .invoice-total-box {
        font-size: 18px;
        font-weight: 700;
        text-align: right;
    }

    /* =========================================================
       RESPONSIVE LAYOUT
       - Desktop: existing layout
       - Tablet: 2-column form layout
       - Mobile: 1-column form layout
       - Data tables: horizontal scrolling instead of squeezing
       - Modals: always remain inside viewport
       ========================================================= */

    .invoice-page {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    .invoice-page .card {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    .invoice-page .card-header,
    .invoice-page .card-body {
        min-width: 0;
    }

    /* Main invoice table */
    .invoice-page .table-responsive {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        overflow-x: auto !important;
        overflow-y: visible !important;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .invoice-page #Invoice_table {
        min-width: 900px !important;
        width: 100% !important;
        margin-bottom: 0;
    }

    .invoice-page #Invoice_table th,
    .invoice-page #Invoice_table td {
        white-space: nowrap;
    }

    .invoice-page #Invoice_table td:nth-child(3),
    .invoice-page #Invoice_table td:nth-child(4) {
        white-space: normal;
        min-width: 180px;
        max-width: 300px;
        word-break: break-word;
    }

    /* Keep DataTables controls inside the viewport */
    .invoice-page .dataTables_wrapper {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    .invoice-page .dataTables_wrapper .row {
        margin-left: 0;
        margin-right: 0;
    }

    .invoice-page .dataTables_wrapper .dataTables_length,
    .invoice-page .dataTables_wrapper .dataTables_filter {
        max-width: 100%;
    }

    .invoice-page .dataTables_wrapper .dataTables_filter input {
        max-width: 100%;
    }

    /* Prevent action dropdown from making the page wider */
    .invoice-page #Invoice_table .dropdown {
        position: relative;
    }

    .invoice-page #Invoice_table .dropdown-menu {
        max-width: calc(100vw - 20px);
    }

    /* Invoice modal */
    #invoiceModal {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #invoiceModal .modal-dialog {
        width: calc(100% - 30px);
        max-width: 1100px;
        margin: 15px auto;
    }

    #invoiceModal .modal-content {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        border: 0;
        border-radius: 10px;
    }

    #invoiceModal .modal-header {
        min-height: 60px;
        padding: 14px 18px;
        cursor: move;
    }

    #invoiceModal .modal-title {
        min-width: 0;
        font-size: 1.25rem;
        line-height: 1.3;
        word-break: break-word;
    }

    #invoiceModal .modal-body {
        max-height: calc(100vh - 155px);
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    #invoiceModal .section-card {
        width: 100%;
        min-width: 0;
    }

    #invoiceModal .form-row {
        margin-left: -7px;
        margin-right: -7px;
    }

    #invoiceModal .form-row > [class*="col-"] {
        min-width: 0;
        padding-left: 7px;
        padding-right: 7px;
    }

    #invoiceModal label {
        display: block;
        max-width: 100%;
        overflow-wrap: anywhere;
    }

    #invoiceModal .form-control,
    #invoiceModal select {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    /* Invoice item table is intentionally scrollable */
    #invoiceModal .invoice-items-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: auto !important;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    #invoiceItemsTable {
        min-width: 760px;
        width: 100%;
        margin-bottom: 0;
    }

    #invoiceItemsTable th,
    #invoiceItemsTable td {
        white-space: nowrap;
    }

    #invoiceItemsTable th:nth-child(2),
    #invoiceItemsTable td:nth-child(2) {
        min-width: 220px;
    }

    #invoiceItemsTable th:nth-child(3),
    #invoiceItemsTable td:nth-child(3) {
        min-width: 100px;
    }

    #invoiceItemsTable th:nth-child(4),
    #invoiceItemsTable td:nth-child(4) {
        min-width: 130px;
    }

    #invoiceItemsTable th:nth-child(5),
    #invoiceItemsTable td:nth-child(5),
    #invoiceItemsTable th:nth-child(6),
    #invoiceItemsTable td:nth-child(6) {
        min-width: 150px;
    }

    #invoiceItemsTable input {
        width: 100%;
        min-width: 0;
    }

    #invoiceModal .invoice-total-box {
        white-space: nowrap;
        overflow-x: auto;
        text-align: right;
    }

    #invoiceModal .modal-footer {
        flex-wrap: wrap;
        gap: 8px;
    }

    #invoiceModal .modal-footer .btn {
        margin-left: 0;
    }

    /* =========================================================
       TABLET
       ========================================================= */
    @media (max-width: 991.98px) {
        .invoice-page .card-header {
            padding: 12px 15px;
        }

        .invoice-page .card-body {
            padding: 15px;
        }

        #invoiceModal .modal-dialog {
            width: calc(100% - 24px);
            max-width: 900px;
            margin: 12px auto;
        }

        #invoiceModal .form-row > .col-md-3 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        #invoiceModal .modal-body {
            max-height: calc(100vh - 140px);
        }
    }

    /* =========================================================
       MOBILE
       ========================================================= */
    @media (max-width: 767.98px) {
        .invoice-page {
            padding-left: 10px;
            padding-right: 10px;
        }

        .invoice-page h1 {
            font-size: 1.5rem;
        }

        .invoice-page .d-sm-flex {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
        }

        .invoice-page .card-header .d-flex {
            gap: 10px;
        }

        .invoice-page .card-header h6 {
            font-size: 1rem;
        }

        .invoice-page .card-body {
            padding: 10px;
        }

        /* DataTables top controls stack cleanly */
        .invoice-page .dataTables_wrapper .row {
            display: flex;
            flex-wrap: wrap;
        }

        .invoice-page .dataTables_wrapper .dataTables_length,
        .invoice-page .dataTables_wrapper .dataTables_filter {
            width: 100%;
            text-align: left !important;
            margin-bottom: 10px;
        }

        .invoice-page .dataTables_wrapper .dataTables_filter label {
            width: 100%;
        }

        .invoice-page .dataTables_wrapper .dataTables_filter input {
            width: calc(100% - 55px);
            max-width: 220px;
        }

        .invoice-page #Invoice_table {
            min-width: 900px !important;
        }

        /* Modal */
        #invoiceModal .modal-dialog {
            width: calc(100% - 16px);
            max-width: none;
            margin: 8px auto;
        }

        #invoiceModal .modal-content {
            border-radius: 8px;
        }

        #invoiceModal .modal-header {
            padding: 12px 14px;
            cursor: default;
        }

        #invoiceModal .modal-title {
            font-size: 1.1rem;
        }

        #invoiceModal .modal-body {
            padding: 10px;
            max-height: calc(100vh - 120px);
        }

        #invoiceModal .section-card {
            padding: 10px;
            margin-bottom: 10px;
        }

        #invoiceModal .section-title {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        /* Every form field gets its own row on mobile */
        #invoiceModal .form-row > .col-md-3,
        #invoiceModal .form-row > [class*="col-md-"] {
            flex: 0 0 100%;
            max-width: 100%;
            width: 100%;
        }

        #invoiceModal .form-group {
            margin-bottom: 10px;
        }

        #invoiceModal .form-control,
        #invoiceModal select {
            min-height: 38px;
        }

        #invoiceModal .d-flex.justify-content-between.align-items-center {
            align-items: flex-start !important;
            gap: 8px;
        }

        #invoiceModal #addInvoiceRow {
            flex-shrink: 0;
            white-space: nowrap;
        }

        #invoiceModal .invoice-items-scroll {
            max-height: 320px;
        }

        #invoiceModal .invoice-total-box {
            font-size: 16px;
        }

        #invoiceModal .modal-footer {
            padding: 10px;
            justify-content: flex-end;
        }

        #invoiceModal .modal-footer .btn {
            min-width: 90px;
        }
    }

    /* Very small phones */
    @media (max-width: 380px) {
        .invoice-page {
            padding-left: 6px;
            padding-right: 6px;
        }

        .invoice-page .card-body {
            padding: 7px;
        }

        .invoice-page .card-header {
            padding: 10px;
        }

        .invoice-page .card-header .btn {
            font-size: 12px;
            padding: 5px 8px;
        }

        #invoiceModal .modal-dialog {
            width: calc(100% - 8px);
            margin: 4px auto;
        }

        #invoiceModal .modal-body {
            padding: 7px;
            max-height: calc(100vh - 105px);
        }

        #invoiceModal .section-card {
            padding: 8px;
        }

        #invoiceModal .modal-footer {
            padding: 8px;
        }

        #invoiceModal .modal-footer .btn {
            flex: 1 1 auto;
        }
    }

    /* Landscape mobile: give the modal more usable vertical space */
    @media (max-width: 767.98px) and (orientation: landscape) {
        #invoiceModal .modal-dialog {
            margin: 5px auto;
        }

        #invoiceModal .modal-body {
            max-height: calc(100vh - 105px);
        }
    }

</style>

<div class="container-fluid invoice-page">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Invoice</h1>
    </div>

    <span id="invoiceMessage"></span>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 text-white">Invoice List</h6>
                <button type="button" class="btn btn-light btn-sm" id="addInvoiceBtn">
                    <i class="fas fa-plus"></i> Add Invoice
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="Invoice_table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Client Name</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTableBody">
                        <?php
                        $invoiceList = DBInvoice::getAll();
                        $serial = 1;

                        foreach ($invoiceList as $invoice):
                            ?>
                            <tr data-id="<?= (int) $invoice['invoice_id']; ?>">
                                <td>
                                    <?= $serial++; ?>
                                </td>
                                <td align="center">
                                    <?= htmlspecialchars($invoice['invoice_number']); ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($invoice['client_name']); ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($invoice['address']); ?>
                                </td>
                                <td align="center">
                                    <?= htmlspecialchars($invoice['location']); ?>
                                </td>
                                <td align="left">₹
                                    <?= number_format((float) $invoice['total_amount'], 2); ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>

                                        <div class="dropdown-menu">
                                            <button type="button" class="btn dropdown-item edit-invoice"
                                                data-id="<?= (int) $invoice['invoice_id']; ?>">
                                                <i class="fas fa-edit"></i> Edit Invoice
                                            </button>

                                            <button type="button" class="btn dropdown-item print-invoice"
                                                data-id="<?= (int) $invoice['invoice_id']; ?>">
                                                <i class="fas fa-print"></i> Print Invoice
                                            </button>

                                            <div class="dropdown-divider"></div>

                                            <button type="button" class="btn btn-danger dropdown-item delete-invoice"
                                                data-id="<?= (int) $invoice['invoice_id']; ?>">
                                                <i class="fas fa-trash"></i> Delete Invoice
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Invoice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form id="invoiceForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalTitle">Create Invoice</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="invoiceId" name="invoiceId">

                    <div class="section-card">
                        <div class="section-title">Create Invoice</div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Date</label>
                                <input type="date" class="form-control" id="invoiceDate" name="invoiceDate" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Invoice No.</label>
                                <input type="text" class="form-control" id="invoiceNumber" name="invoiceNumber"
                                    required>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Dispatch Through</label>
                                <input type="text" class="form-control" id="dispatchThrough" name="dispatchThrough">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Destination</label>
                                <input type="text" class="form-control" id="destination" name="destination">
                            </div>
                        </div>

                        <div class="form-row">
                            

                            <div class="form-group col-md-3">
                                <label>Client Name</label>
                                <input type="text" class="form-control" id="clientName" name="clientName" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Location</label>
                                <input type="text" class="form-control" id="location" name="location">
                            </div>

                            <div class="form-group col-md-3">
                                <label>Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact">
                            </div>
                        </div>

                        <div class="form-row">

                            
                            <div class="form-group col-md-3">
                                <label>Vehicle No.</label>
                                <input type="text" class="form-control" id="vehicleNo" name="vehicleNo">
                            </div>
                            <div class="form-group col-md-3">
                                <label>GST</label>
                                <select class="form-control" id="gst" name="gst">
                                    <option value="">Select GST</option>
                                    <option value="0">0%</option>
                                    <option value="5">5%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>
                                    <option value="28">28%</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>IGST</label>
                                <select class="form-control" id="igst" name="igst">
                                    <option value="">Select IGST</option>
                                    <option value="0">0%</option>
                                    <option value="5">5%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>
                                    <option value="28">28%</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="section-card">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="section-title mb-0 flex-grow-1">Invoice Items</div>
                            <button type="button" class="btn btn-primary btn-sm ml-3" id="addInvoiceRow">
                                <i class="fas fa-plus"></i> Add Row
                            </button>
                        </div>

                        <div class="invoice-items-scroll">
                            <table class="table table-bordered mb-0" id="invoiceItemsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">+</th>
                                        <th>Description Of Goods</th>
                                        <th style="width: 100px;">QTY</th>
                                        <th style="width: 130px;">HSN</th>
                                        <th style="width: 150px;">Unit Price</th>
                                        <th style="width: 150px;">Amount</th>
                                    </tr>
                                </thead>

                                <tbody id="invoiceItemsBody"></tbody>
                            </table>
                        </div>

                        <div class="invoice-total-box mt-3">
                            Total Amount: ₹ <span id="invoiceTotal">0.00</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="saveInvoiceBtn">
                        <i class="fas fa-save"></i> Save Invoice
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    // Same DataTables initialization pattern used by Customer page
    var dataTable = $('#Invoice_table').DataTable({
        pageLength: 10,
        autoWidth: false,
        columnDefs: [
            {
                targets: 0,
                searchable: false
            },
            {
                targets: 6,
                orderable: false,
                searchable: false
            }
        ],
        drawCallback: function () {
            var api = this.api();
            var pageInfo = api.page.info();

            api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                cell.innerHTML = pageInfo.start + i + 1;
            });
        }
    });
    // Initialize Invoice Actions dropdowns explicitly.
    // footer.php loads Bootstrap 4 and Bootstrap 5, so relying only on
    // data-toggle can be inconsistent on this page.
    // Manual dropdown toggle — bypasses Bootstrap 4/5 JS entirely to avoid
    // data-toggle vs data-bs-toggle conflicts on this page.
    $(document).on("click", "#Invoice_table .dropdown-toggle", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $menu = $(this).siblings(".dropdown-menu");
        var isOpen = $menu.hasClass("show");

        $("#Invoice_table .dropdown-menu").removeClass("show");

        if (!isOpen) {
            $menu.addClass("show");
        }
    });

    $(document).on("click", function () {
        $("#Invoice_table .dropdown-menu").removeClass("show");
    });

    $(document).on("click", "#Invoice_table .dropdown-menu", function (e) {
        e.stopPropagation();
    });

    (function () {
        const controllerUrl = "../Controller/invoice.php";

        function today() {
            const d = new Date();
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const day = String(d.getDate()).padStart(2, "0");
            return d.getFullYear() + "-" + month + "-" + day;
        }
        function updateTaxFieldState() {
            const gstValue = $("#gst").val();
            const igstValue = $("#igst").val();

            if (gstValue !== "") {
                $("#igst").prop("disabled", true);
            } else {
                $("#igst").prop("disabled", false);
            }

            if (igstValue !== "") {
                $("#gst").prop("disabled", true);
            } else {
                $("#gst").prop("disabled", false);
            }
        }
        function escapeHtml(value) {
            return $("<div>").text(value == null ? "" : value).html();
        }

        function showMessage(message, type) {
            $("#invoiceMessage").html(
                '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                escapeHtml(message) +
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '</div>'
            );
        }
        $("#gst").on("change", function () {
            if ($(this).val() !== "") {
                $("#igst").val("");
            }

            updateTaxFieldState();

            $("#invoiceItemsBody tr").each(function () {
                calculateRow($(this));
            });
        });

        $("#igst").on("change", function () {
            if ($(this).val() !== "") {
                $("#gst").val("");
            }

            updateTaxFieldState();

            $("#invoiceItemsBody tr").each(function () {
                calculateRow($(this));
            });
        });

        function clearForm() {
            $("#invoiceForm")[0].reset();
            $("#invoiceId").val("");
            $("#invoiceDate").val(today());

            $("#gst").val("");
            $("#igst").val("");

            $("#gst").prop("disabled", false);
            $("#igst").prop("disabled", false);

            $("#invoiceItemsBody").empty();
            addItemRow();
            calculateTotal();
        }

        function addItemRow(item) {
            item = item || {};

            const row = `
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-invoice-row">
                            <i class="fas fa-minus"></i>
                        </button>
                    </td>
                    <td>
                        <input type="text" class="form-control item-description"
                            value="${escapeHtml(item.description || "")}">
                    </td>
                    <td>
                        <input type="number" min="0" step="any" class="form-control item-qty"
                            value="${item.qty != null ? item.qty : 1}">
                    </td>
                    <td>
                        <input type="text" class="form-control item-hsn"
                            value="${escapeHtml(item.hsn || "")}">
                    </td>
                    <td>
                        <input type="number" min="0" step="0.01" class="form-control item-unit-price"
                            value="${item.unit_price != null ? item.unit_price : (item.unitPrice != null ? item.unitPrice : 0)}">
                    </td>
                    <td>
                        <input type="text" class="form-control item-amount" readonly
                            value="0.00">
                    </td>
                </tr>
            `;

            $("#invoiceItemsBody").append(row);

            const $row = $("#invoiceItemsBody tr:last");
            calculateRow($row);
        }

        function calculateRow($row) {
            const qty = parseFloat($row.find(".item-qty").val()) || 0;
            const unitPrice = parseFloat($row.find(".item-unit-price").val()) || 0;

            // Base amount
            const baseAmount = qty * unitPrice;

            // Get selected tax
            const gstValue = $("#gst").val();
            const igstValue = $("#igst").val();

            let taxRate = 0;

            // GST and IGST are mutually exclusive
            if (gstValue !== "") {
                taxRate = parseFloat(gstValue) || 0;
            } else if (igstValue !== "") {
                taxRate = parseFloat(igstValue) || 0;
            }

            // Tax-inclusive amount for display
            const taxAmount = baseAmount * (taxRate / 100);
            const finalAmount = baseAmount + taxAmount;

            $row.find(".item-amount").val(finalAmount.toFixed(2));

            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;

            $("#invoiceItemsBody .item-amount").each(function () {
                total += parseFloat($(this).val()) || 0;
            });

            $("#invoiceTotal").text(total.toFixed(2));
        }

        function collectItems() {
            const items = [];

            $("#invoiceItemsBody tr").each(function () {
                const $row = $(this);

                const description = $row.find(".item-description").val().trim();
                const qty = parseFloat($row.find(".item-qty").val()) || 0;
                const hsn = $row.find(".item-hsn").val().trim();
                const unitPrice = parseFloat($row.find(".item-unit-price").val()) || 0;

                if (description !== "" || qty > 0 || hsn !== "" || unitPrice > 0) {
                    items.push({
                        description: description,
                        qty: qty,
                        hsn: hsn,
                        unitPrice: unitPrice
                    });
                }
            });

            return items;
        }

        function refreshTable() {
            window.location.reload();
        }

        $("#addInvoiceBtn").on("click", function () {
            clearForm();
            $("#invoiceModalTitle").text("Create Invoice");
            $("#saveInvoiceBtn").html('<i class="fas fa-save"></i> Save Invoice');
            $("#invoiceModal").modal("show");
        });

        $("#addInvoiceRow").on("click", function () {
            addItemRow();
        });

        $(document).on("click", ".remove-invoice-row", function () {
            const rows = $("#invoiceItemsBody tr");

            if (rows.length <= 1) {
                showMessage("At least one invoice row is required.", "warning");
                return;
            }

            $(this).closest("tr").remove();
            calculateTotal();
        });

        $(document).on("input", ".item-qty, .item-unit-price", function () {
            calculateRow($(this).closest("tr"));
        });

        $(document).on("click", ".edit-invoice", function () {
            const id = $(this).data("id");

            $.ajax({
                url: controllerUrl,
                type: "GET",
                data: { action: "get", id: id },
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        showMessage(response.message || "Unable to load invoice.", "danger");
                        return;
                    }

                    const invoice = response.data;

                    $("#invoiceId").val(invoice.invoice_id);
                    $("#invoiceDate").val(invoice.invoice_date);
                    $("#invoiceNumber").val(invoice.invoice_number);
                    $("#dispatchThrough").val(invoice.dispatch_through);
                    $("#destination").val(invoice.destination);
                    $("#clientName").val(invoice.client_name);
                    $("#address").val(invoice.address);
                    $("#location").val(invoice.location);
                    $("#contact").val(invoice.contact);
                    $("#gst").val(invoice.gst);
                    $("#igst").val(invoice.igst || "");
                    $("#vehicleNo").val(invoice.vehicle_no || "");
                    updateTaxFieldState();

                    $("#invoiceItemsBody").empty();

                    if (invoice.items && invoice.items.length) {
                        invoice.items.forEach(function (item) {
                            addItemRow(item);
                        });
                    } else {
                        addItemRow();
                    }

                    calculateTotal();

                    $("#invoiceModalTitle").text("Edit Invoice");
                    $("#saveInvoiceBtn").html('<i class="fas fa-save"></i> Update Invoice');
                    $("#invoiceModal").modal("show");
                },
                error: function () {
                    showMessage("Unable to load invoice.", "danger");
                }
            });
        });

        $("#invoiceForm").on("submit", function (e) {
            e.preventDefault();

            const id = $("#invoiceId").val();
            const items = collectItems();

            if (!items.length) {
                showMessage("Please add at least one invoice item.", "warning");
                return;
            }

            const action = id ? "update" : "add";

            const formData = {
                action: action,
                invoiceId: id,
                invoiceDate: $("#invoiceDate").val(),
                invoiceNumber: $("#invoiceNumber").val(),
                dispatchThrough: $("#dispatchThrough").val(),
                destination: $("#destination").val(),
                clientName: $("#clientName").val(),
                address: $("#address").val(),
                location: $("#location").val(),
                contact: $("#contact").val(),
                gst: $("#gst").val(),
                igst: $("#igst").val(),
                vehicleNo: $("#vehicleNo").val(),
                items: JSON.stringify(items)
            };

            $("#saveInvoiceBtn").prop("disabled", true);

            $.ajax({
                url: controllerUrl,
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        $("#invoiceModal").modal("hide");
                        showMessage(response.message, "success");

                        setTimeout(function () {
                            refreshTable();
                        }, 500);
                    } else {
                        showMessage(response.message || "Unable to save invoice.", "danger");
                    }
                },
                error: function (xhr) {
                    let message = "Unable to save invoice.";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    showMessage(message, "danger");
                },
                complete: function () {
                    $("#saveInvoiceBtn").prop("disabled", false);
                }
            });
        });

        $(document).on("click", ".delete-invoice", function () {
            const id = $(this).data("id");

            if (!confirm("Are you sure you want to delete this invoice?")) {
                return;
            }

            $.ajax({
                url: controllerUrl,
                type: "POST",
                data: {
                    action: "delete",
                    id: id
                },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        showMessage(response.message, "success");

                        setTimeout(function () {
                            refreshTable();
                        }, 500);
                    } else {
                        showMessage(response.message || "Delete failed.", "danger");
                    }
                },
                error: function () {
                    showMessage("Unable to delete invoice.", "danger");
                }
            });
        });

        $(document).on("click", ".print-invoice", function () {
            const id = $(this).data("id");

            // Opens the PDF directly in a new browser tab.
            window.open("printInvoice.php?id=" + encodeURIComponent(id), "_blank");
        });

        /* Responsive modal positioning / dragging.
           Desktop/tablet: draggable.
           Mobile: normal Bootstrap positioning so touch scrolling works. */
        function setupResponsiveInvoiceModal() {
            var $modal = $('#invoiceModal');
            var $dialog = $modal.find('.modal-dialog');
            var isMobile = window.matchMedia('(max-width: 767.98px)').matches;

            if ($dialog.hasClass("ui-draggable")) {
                $dialog.draggable("destroy");
            }

            $dialog.removeAttr("style");

            if (isMobile) {
                $dialog.css({
                    width: "calc(100% - 16px)",
                    maxWidth: "none",
                    margin: "8px auto",
                    position: "relative",
                    left: "auto",
                    top: "auto",
                    transform: "none"
                });
            } else {
                var modalWidth = $dialog.outerWidth();
                var modalHeight = $dialog.outerHeight();
                var viewportWidth = $(window).width();
                var viewportHeight = $(window).height();

                var left = Math.max(8, (viewportWidth - modalWidth) / 2);
                var top = Math.max(15, (viewportHeight - modalHeight) / 2);

                $dialog.css({
                    margin: 0,
                    position: "fixed",
                    left: left + "px",
                    top: top + "px",
                    transform: "none"
                });

                if ($.fn.draggable) {
                    $dialog.draggable({
                        handle: ".modal-header",
                        containment: "window",
                        scroll: false
                    });
                }
            }
        }

        $('#invoiceModal').on('shown.bs.modal', function () {
            setupResponsiveInvoiceModal();
        });

        $(window).on('resize orientationchange', function () {
            if ($('#invoiceModal').hasClass('show')) {
                setupResponsiveInvoiceModal();
            }
        });
    })();
</script>