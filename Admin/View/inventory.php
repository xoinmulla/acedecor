<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('itemListNavigation.php');
require_once("../DB Operations/item_detailsOps.php");
require_once("../DB Operations/item_categoryOps.php");
require_once("../DB Operations/item_subcategoryOps.php");
require_once("../Model/item_detailsmodel.php");
require_once("../DB Operations/taxOps.php");

if (!hasActionPermission('inventory', 'item')) {
    header("Location: noaccess.php");
    exit;
}
$taxList = DBTax::getAll();
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<style>
    /* Soft, modern shadows and rounding */
    .modal-content-modern {
        border-radius: 1rem;
        /* 16px */
        border: none;
        overflow: hidden;
    }

    .modal-header-modern {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem;
    }

    /* The Image container */
    .product-img-frame {
        background-color: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        padding: 10px;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .product-img-frame img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    /* Data Cards */
    .info-card {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 12px 15px;
        height: 100%;
        border-left: 4px solid #e3e6f0;
        transition: transform 0.2s;
    }

    .info-card:hover {
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    /* Specific colors for specific cards */
    .card-highlight {
        border-left-color: #1cc88a;
        background-color: #f0fdf4;
    }

    /* Green for money */
    .card-info {
        border-left-color: #36b9cc;
    }

    /* Blue for codes */
    .card-warn {
        border-left-color: #f6c23e;
    }

    /* Yellow for units */

    /* Typography */
    .label-text {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #858796;
        display: block;
        margin-bottom: 4px;
        font-weight: 700;
    }

    .value-text {
        font-size: 1rem;
        font-weight: 700;
        color: #5a5c69;
        margin: 0;
    }

    .value-text-lg {
        font-size: 1.25rem;
        color: #1cc88a;
    }

    /* Large price text */

    /* Table Polish */
    .table-modern thead th {
        background-color: #eaecf4;
        color: #4e73df;
        font-size: 0.8rem;
        text-transform: uppercase;
        border-top: none;
        border-bottom: none;
    }
</style>
<style>
    /* Brand Tags */
    .brand-tag {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        animation: fadeIn 0.3s ease;
        box-shadow: 0 2px 8px rgba(250, 112, 154, 0.3);
    }

    .brand-tag .remove-brand-tag {
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s ease;
        font-size: 14px;
        margin-left: 5px;
    }

    .brand-tag .remove-brand-tag:hover {
        opacity: 1;
        transform: scale(1.2);
    }

    /* Dropdown Checkbox Styles */
    #checkboxes .form-check {
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s ease;
        margin: 2px 0;
    }

    #checkboxes .form-check:hover {
        background: #f8f9fa;
    }

    #checkboxes .form-check-input {
        cursor: pointer;
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
    }

    #checkboxes .form-check-input:checked {
        background-color: #667eea;
        border-color: #764ba2;
    }

    #checkboxes .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #2d3436;
        padding-left: 5px;
    }

    /* Success Button States */
    .btn-success:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }

        .d-flex.gap-2 .btn {
            width: 100%;
        }
    }

    /* Card Styles */
    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    /* Header */
    .modal-header {
        border-bottom: none;
        padding: 18px 25px;
    }

    .modal-header .close {
        opacity: 0.8;
        text-shadow: none;
        font-size: 28px;
        transition: transform 0.3s ease;
    }

    .modal-header .close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    /* Form Controls */
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 10px 15px;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
    }

    .form-label {
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        color: #2d3436;
        font-weight: 600;
    }

    /* Input Group */
    .input-group-text {
        background: #f1f3f5;
        border: 2px solid #e9ecef;
        border-right: none;
        border-radius: 8px 0 0 8px;
        color: #4facfe;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control:focus {
        border-left: none;
    }

    /* Dropdown Button */
    .dropdown-toggle {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: white;
        transition: all 0.3s ease;
    }

    .dropdown-toggle:hover {
        border-color: #4facfe;
        background: #f8f9fa;
    }

    .dropdown-toggle:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
    }

    /* Dropdown Menu */
    .dropdown-menu {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
    }

    .dropdown-menu .form-check {
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s ease;
    }

    .dropdown-menu .form-check:hover {
        background: #f8f9fa;
    }

    .dropdown-menu .form-check-input {
        cursor: pointer;
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
    }

    .dropdown-menu .form-check-input:checked {
        background-color: #4facfe;
        border-color: #4facfe;
    }

    .dropdown-menu .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #2d3436;
        padding-left: 5px;
    }

    /* Selected Types Tags */
    #selectedTypesTags {
        gap: 8px;
    }

    .type-tag {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        animation: fadeIn 0.3s ease;
    }

    .type-tag .remove-tag {
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s ease;
        font-size: 14px;
        margin-left: 5px;
    }

    .type-tag .remove-tag:hover {
        opacity: 1;
    }

    /* Buttons */
    .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(56, 239, 125, 0.4);
    }

    .btn-success:active {
        transform: translateY(0px);
    }

    .btn-secondary {
        border-radius: 8px;
        padding: 10px 25px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Badge */
    .badge {
        font-size: 0.75rem;
        padding: 5px 10px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .badge-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Message Alerts */
    .alert {
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        margin-bottom: 20px;
        animation: slideDown 0.3s ease;
    }

    .alert-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #155724;
        font-weight: 500;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        font-weight: 500;
    }

    /* Scrollbar for dropdown */
    #brand_inputtypes::-webkit-scrollbar {
        width: 6px;
    }

    #brand_inputtypes::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #brand_inputtypes::-webkit-scrollbar-thumb {
        background: #4facfe;
        border-radius: 10px;
    }

    @media (max-width: 576px) {

        .modal-dialog {
            margin: 0.5rem auto;
        }

        .modal-body {
            padding: 15px !important;
        }

        .btn-success,
        .btn-secondary {
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>
<style>
    /* Modern Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        font-weight: 600;
    }

    /* Modern Form Controls */
    .form-control,
    .form-select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
        color: #495057;
    }

    /* Input Group Enhancement */
    .input-group-text {
        background: #f1f3f5;
        border: 1px solid #ced4da;
        border-radius: 8px 0 0 8px;
        font-weight: 500;
    }

    .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    /* Buttons */
    .btn-outline-primary {
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        border-color: #667eea;
        color: #667eea;
    }

    .btn-outline-primary:hover {
        background: #667eea;
        color: white;
    }

    /* Modern Scrollbar */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }


    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Smooth Animations */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }

    /* Hover effects on cards */
    .bg-light {
        border: 1px solid #e9ecef;
    }
</style>
<style>
    /* =========================================================
   INVENTORY TABLE - RESPONSIVE
   ========================================================= */

    .inventory-table-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .inventory-table-wrapper #item_table {
        width: 100% !important;
        min-width: 1000px;
        margin-bottom: 0;
    }

    /* DataTables wrapper */
    .inventory-table-wrapper .dataTables_wrapper {
        width: 100%;
        max-width: 100%;
    }

    /* DataTables horizontal scroll */
    .inventory-table-wrapper .dataTables_scroll {
        width: 100%;
    }

    .inventory-table-wrapper .dataTables_scrollBody {
        overflow-x: auto !important;
        overflow-y: hidden !important;
    }

    /* Tablet */
    @media (max-width: 991.98px) {

        .inventory-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .inventory-table-wrapper #item_table {
            min-width: 1000px;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {

        .inventory-table-wrapper #item_table {
            min-width: 950px;
        }

    }

    .card-body #item_table th {
        font-weight: 500;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        font-weight: 600;
    }

    /* Form Controls */
    .form-control,
    .form-select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #f093fb;
        box-shadow: 0 0 0 0.2rem rgba(240, 147, 251, 0.25);
    }

    .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
        color: #495057;
    }

    /* Input Group */
    .input-group-text {
        background: #f1f3f5;
        border: 1px solid #ced4da;
        border-radius: 8px 0 0 8px;
        font-weight: 500;
    }

    .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    /* Buttons */
    .btn-outline-primary {
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        border-color: #f093fb;
        color: #f093fb;
    }

    .btn-outline-primary:hover {
        background: #f093fb;
        color: white;
        border-color: #f093fb;
    }

    .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 8px;
        padding: 8px 25px;
        font-weight: 600;
        transition: transform 0.2s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(56, 239, 125, 0.4);
    }

    .btn-secondary {
        border-radius: 8px;
        padding: 8px 25px;
    }

    /* Image Preview */
    #itemImage {
        transition: transform 0.3s ease;
    }

    #itemImage:hover {
        transform: scale(1.05);
    }

    /* Scrollbar */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #f093fb;
        border-radius: 10px;
    }

    /* Draggable Handle */
    .modal-header {
        cursor: grab;
        padding: 15px 20px;
    }

    .modal-header:active {
        cursor: grabbing;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Alert Messages */
    .alert-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        border: none;
        border-radius: 8px;
        color: #155724;
        font-weight: 500;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 500;
    }

    /* Glowing animation for save button */
    @keyframes glow {
        0% {
            box-shadow: 0 0 5px rgba(56, 239, 125, 0.2);
        }

        50% {
            box-shadow: 0 0 20px rgba(56, 239, 125, 0.6);
        }

        100% {
            box-shadow: 0 0 5px rgba(56, 239, 125, 0.2);
        }
    }

    .btn-success:focus {
        animation: glow 1.5s ease-in-out infinite;
    }

    /* Loading spinner for save button */
    .btn-success.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .btn-success.loading::after {
        content: "...";
        animation: dots 1.5s steps(4, end) infinite;
    }

    @keyframes dots {
        0% {
            content: "";
        }

        25% {
            content: ".";
        }

        50% {
            content: "..";
        }

        75% {
            content: "...";
        }
    }

    /* =========================================================
   INVENTORY MODALS
   RESPONSIVE + DRAGGABLE
   Existing design remains unchanged
   ========================================================= */

    /* ---------------------------------------------------------
   COMMON MODAL SAFETY
   --------------------------------------------------------- */

    .inventory-item-modal .modal-dialog,
    #detailsItemModal .modal-dialog,
    #deleteItemModal .modal-dialog,
    #itemcatModal .modal-dialog,
    #itemsubcatModal .modal-dialog,
    #brandModal .modal-dialog {

        box-sizing: border-box;
        max-width: calc(100vw - 24px);
    }

    .inventory-item-modal .modal-content,
    #detailsItemModal .modal-content,
    #deleteItemModal .modal-content,
    #itemcatModal .modal-content,
    #itemsubcatModal .modal-content,
    #brandModal .modal-content {

        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Header is the drag handle */
    .inventory-item-modal .modal-header,
    #detailsItemModal .modal-header,
    #deleteItemModal .modal-header,
    #itemcatModal .modal-header,
    #itemsubcatModal .modal-header,
    #brandModal .modal-header {

        cursor: grab;
        user-select: none;
        -webkit-user-select: none;
        touch-action: none;
    }

    .inventory-item-modal .modal-header:active,
    #detailsItemModal .modal-header:active,
    #deleteItemModal .modal-header:active,
    #itemcatModal .modal-header:active,
    #itemsubcatModal .modal-header:active,
    #brandModal .modal-header:active {

        cursor: grabbing;
    }


    /* =========================================================
   ADD / EDIT ITEM
   ========================================================= */

    .inventory-item-modal .modal-dialog {

        width: calc(100vw - 40px);
        max-width: 1140px;

        height: calc(100vh - 40px);

        margin: 20px auto;

        box-sizing: border-box;
    }

    .inventory-item-modal .modal-dialog>form {

        width: 100%;
        height: 100%;

        min-height: 0;

        display: flex;
        flex-direction: column;
    }

    .inventory-item-modal .modal-content {

        width: 100%;
        height: 100%;

        max-height: 100%;
        min-height: 0;

        display: flex;
        flex-direction: column;

        overflow: hidden;
    }

    .inventory-item-modal .modal-header {

        flex: 0 0 auto;
    }

    .inventory-item-modal .modal-body {

        flex: 1 1 auto;
        min-height: 0;

        overflow-y: auto;
        overflow-x: hidden;

        -webkit-overflow-scrolling: touch;
    }

    .inventory-item-modal .modal-footer {

        flex: 0 0 auto;
    }


    /* =========================================================
   ITEM INFORMATION MODAL
   ========================================================= */

    #detailsItemModal .modal-dialog {

        width: calc(100vw - 40px);
        max-width: 1140px;

        max-height: calc(100vh - 40px);

        margin: 20px auto;

        box-sizing: border-box;
    }

    #detailsItemModal .modal-content {

        max-height: calc(100vh - 40px);

        display: flex;
        flex-direction: column;

        overflow: hidden;
    }

    #detailsItemModal .modal-body {

        flex: 1 1 auto;

        min-height: 0;

        overflow-y: auto;
        overflow-x: hidden;

        -webkit-overflow-scrolling: touch;
    }

    /* Prevent long text from breaking the layout */

    #detailsItemModal .modal-body * {
        max-width: 100%;
    }

    #detailsItemModal #displayItemName,
    #detailsItemModal #displayItemComapny,
    #detailsItemModal #displayItemDescription,
    #detailsItemModal #displayItemArticleNo,
    #detailsItemModal #displayItemHSNCode,
    #detailsItemModal #displayItemDiscount {

        overflow-wrap: anywhere;
        word-break: break-word;
    }

    /* Description should occupy full width */
    #detailsItemModal .col-md-14 {

        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }

    /* Information cards */
    #detailsItemModal .info-card {

        min-width: 0;
        overflow: hidden;
    }

    #detailsItemModal .info-card .value-text {

        overflow-wrap: anywhere;
        word-break: break-word;
    }

    /* Price history */
    #detailsItemModal .table-responsive {

        width: 100%;
        max-width: 100%;

        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    #detailsItemModal #details_table {

        min-width: 700px;
    }


    /* =========================================================
   SMALL MODALS
   ========================================================= */

    #deleteItemModal .modal-dialog,
    #itemcatModal .modal-dialog,
    #itemsubcatModal .modal-dialog,
    #brandModal .modal-dialog {

        width: calc(100vw - 40px);
        max-width: 600px;

        max-height: calc(100vh - 40px);

        margin: 20px auto;
    }

    #deleteItemModal .modal-content,
    #itemcatModal .modal-content,
    #itemsubcatModal .modal-content,
    #brandModal .modal-content {

        max-height: calc(100vh - 40px);

        display: flex;
        flex-direction: column;

        overflow: hidden;
    }

    #deleteItemModal .modal-body,
    #itemcatModal .modal-body,
    #itemsubcatModal .modal-body,
    #brandModal .modal-body {

        overflow-y: auto;
        overflow-x: hidden;

        max-height: calc(100vh - 160px);

        -webkit-overflow-scrolling: touch;
    }


    /* =========================================================
   TABLET
   768px - 991px
   ========================================================= */

    @media (min-width: 768px) and (max-width: 991.98px) {

        /* Add / Edit */
        .inventory-item-modal .modal-dialog {

            width: calc(100vw - 24px) !important;
            max-width: none !important;

            height: calc(100vh - 24px);

            margin: 12px auto;
        }

        .inventory-item-modal .modal-content {

            max-height: calc(100vh - 24px);
        }


        /* Item Information */

        #detailsItemModal .modal-dialog {

            width: calc(100vw - 24px) !important;
            max-width: none !important;

            max-height: calc(100vh - 24px);

            margin: 12px auto;
        }

        #detailsItemModal .modal-content {

            max-height: calc(100vh - 24px);
        }

        /*
     * Tablet:
     * Image goes above information instead of squeezing
     * the right side into a very narrow column.
     */

        #detailsItemModal .modal-body>.row:first-of-type {

            display: flex;
            flex-wrap: wrap;
        }

        #detailsItemModal .modal-body>.row:first-of-type>.col-lg-3,
        #detailsItemModal .modal-body>.row:first-of-type>.col-md-4 {

            flex: 0 0 35%;
            max-width: 35%;
        }

        #detailsItemModal .modal-body>.row:first-of-type>.col-lg-9,
        #detailsItemModal .modal-body>.row:first-of-type>.col-md-8 {

            flex: 0 0 65%;
            max-width: 65%;
        }

        #detailsItemModal .product-img-frame {

            height: 170px;
        }

        /*
     * Top information section
     */
        #detailsItemModal .modal-body .d-flex.justify-content-between {

            gap: 15px;
        }

        #detailsItemModal .modal-body .d-flex.justify-content-between>div {

            min-width: 0;
        }

        /*
     * Code / HSN / Discount
     */
        #detailsItemModal .bg-white .row>.col-md-4 {

            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            min-width: 0;
        }
    }


    /* =========================================================
   MOBILE
   ========================================================= */

    @media (max-width: 767.98px) {

        /* -----------------------------------------------------
       ALL MODALS
       ----------------------------------------------------- */

        .inventory-item-modal .modal-dialog,
        #detailsItemModal .modal-dialog,
        #deleteItemModal .modal-dialog,
        #itemcatModal .modal-dialog,
        #itemsubcatModal .modal-dialog,
        #brandModal .modal-dialog {

            width: calc(100vw - 12px) !important;

            max-width: none !important;

            margin: 6px auto !important;

            box-sizing: border-box;
        }


        /* -----------------------------------------------------
       ADD / EDIT
       ----------------------------------------------------- */

        .inventory-item-modal .modal-dialog {

            height: calc(100vh - 12px);
        }

        .inventory-item-modal .modal-content {

            max-height: calc(100vh - 12px);
        }

        .inventory-item-modal .modal-body {

            padding: 15px !important;
        }

        .inventory-item-modal .modal-header {

            padding: 12px 15px;
        }

        .inventory-item-modal .modal-footer {

            padding: 10px 15px;

            flex-wrap: wrap;
        }

        .inventory-item-modal .modal-footer .btn {

            margin-bottom: 5px;
        }


        /* -----------------------------------------------------
       ITEM INFORMATION
       ----------------------------------------------------- */

        #detailsItemModal .modal-dialog {

            max-height: calc(100vh - 12px);
        }

        #detailsItemModal .modal-content {

            max-height: calc(100vh - 12px);

            border-radius: 12px;
        }

        #detailsItemModal .modal-body {

            padding: 15px !important;
        }

        /*
     * Stack image and item information.
     */
        #detailsItemModal .modal-body>.row:first-of-type {

            display: block;
            margin-left: 0;
            margin-right: 0;
        }

        #detailsItemModal .modal-body>.row:first-of-type>.col-lg-3,
        #detailsItemModal .modal-body>.row:first-of-type>.col-md-4,
        #detailsItemModal .modal-body>.row:first-of-type>.col-lg-9,
        #detailsItemModal .modal-body>.row:first-of-type>.col-md-8 {

            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;

            padding-left: 0;
            padding-right: 0;
        }

        #detailsItemModal .product-img-frame {

            width: 100%;
            height: 170px;

            margin-bottom: 15px;
        }

        /*
     * Item name + brand
     */
        #detailsItemModal .modal-body .d-flex.justify-content-between {

            display: block !important;
        }

        #detailsItemModal .modal-body .d-flex.justify-content-between .text-right {

            text-align: left !important;

            margin-top: 10px;
        }

        /*
     * Description / codes
     */
        #detailsItemModal .bg-white {

            padding: 12px !important;
        }

        #detailsItemModal .bg-white .row>.col-md-4 {

            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;

            margin-top: 8px;
        }

        /*
     * Specification cards:
     * two cards per row on mobile.
     */
        #detailsItemModal .modal-body .row>.col-md-3.col-6 {

            width: 50%;
            max-width: 50%;
            flex: 0 0 50%;
        }

        #detailsItemModal .info-card {

            padding: 10px;
        }

        #detailsItemModal .label-text {

            font-size: 0.68rem;

            letter-spacing: 0.2px;
        }

        #detailsItemModal .value-text {

            font-size: 0.9rem;
        }

        #detailsItemModal .value-text-lg {

            font-size: 1.05rem;
        }

        /*
     * Price history remains horizontally scrollable.
     */
        #detailsItemModal #details_table {

            min-width: 700px;
        }


        /* -----------------------------------------------------
       SMALL MODALS
       ----------------------------------------------------- */

        #deleteItemModal .modal-dialog,
        #itemcatModal .modal-dialog,
        #itemsubcatModal .modal-dialog,
        #brandModal .modal-dialog {

            max-height: calc(100vh - 12px);
        }

        #deleteItemModal .modal-content,
        #itemcatModal .modal-content,
        #itemsubcatModal .modal-content,
        #brandModal .modal-content {

            max-height: calc(100vh - 12px);
        }

        #deleteItemModal .modal-body,
        #itemcatModal .modal-body,
        #itemsubcatModal .modal-body,
        #brandModal .modal-body {

            max-height: calc(100vh - 145px);

            padding: 15px !important;
        }

        #deleteItemModal .modal-footer,
        #itemcatModal .modal-footer,
        #itemsubcatModal .modal-footer,
        #brandModal .modal-footer {

            flex-wrap: wrap;
        }
    }


    /* =========================================================
   VERY SMALL PHONES
   ========================================================= */

    @media (max-width: 399.98px) {

        .inventory-item-modal .modal-dialog,
        #detailsItemModal .modal-dialog,
        #deleteItemModal .modal-dialog,
        #itemcatModal .modal-dialog,
        #itemsubcatModal .modal-dialog,
        #brandModal .modal-dialog {

            width: calc(100vw - 8px) !important;

            margin: 4px auto !important;
        }

        .inventory-item-modal .modal-header,
        #detailsItemModal .modal-header,
        #deleteItemModal .modal-header,
        #itemcatModal .modal-header,
        #itemsubcatModal .modal-header,
        #brandModal .modal-header {

            padding-left: 10px;
            padding-right: 10px;
        }

        #detailsItemModal .modal-body {

            padding: 10px !important;
        }

        #detailsItemModal .modal-body .row>.col-md-3.col-6 {

            padding-left: 4px;
            padding-right: 4px;
        }
    }
</style>

<!-- DataTales Example -->

<div id="inventory_message"></div>
<div class="card shadow mb-4">
    <div class="card-header py-3"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Item List
                </h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#itemdetailsModal>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="inventory-table-wrapper">
                <table class="table table-bordered" id="item_table" width="100%" cellspacing="0">
                    <thead align="center">
                        <tr>
                            <th>Item Name</th>
                            <th>Item Description</th>
                            <th style='display:none'>Category Id</th>
                            <th>Item Category</th>
                            <th style='display:none'>SubCategory Id</th>
                            <th>Item Subcategory</th>
                            <th style='display:none'>Comapny Id</th>
                            <th>Brand</th>
                            <th style='display:none'>HSNCode</th>
                            <th style='display:none'>Article no</th>
                            <th style='display:none'>SPU</th>
                            <th style='display:none'>Size</th>
                            <th style='display:none'>MRP</th>
                            <th style='display:none'>PP MRP</th>
                            <th style='display:none'>GST</th>
                            <th style='display:none'>image</th>

                            <th style='display:none'>unit</th>
                            <th style='display:none'>unitFactor</th>
                            <th style='display:none'>unitId</th>
                            <th style='display:none'>unitFactorId</th>
                            <th style='display:none'>totalMRP</th>
                            <th style='display:none'>Company Discount</th>
                            <th>Price</th>
                            <th>Inwarded Qty</th>
                            <th>Allocated Qty</th>
                            <th>Available Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $itemdetailslist = DBitemdetails::getallItemdetails();
                        foreach ($itemdetailslist as $itemdetails) {
                            ?>
                            <tr>
                                <td><?= $itemdetails->get_itemname(); ?></td>
                                <td><?= $itemdetails->get_itemdescription(); ?></td>

                                <td style="display:none"><?= $itemdetails->get_itemcatid(); ?></td>
                                <td><?= $itemdetails->get_itemcategoryname(); ?></td>

                                <td style="display:none"><?= $itemdetails->get_itemsubcatid(); ?></td>
                                <td><?= $itemdetails->get_itemsubcategoryname(); ?></td>

                                <td style="display:none"><?= $itemdetails->get_itemcompid(); ?></td>
                                <td><?= $itemdetails->get_itemCompanyname(); ?></td>

                                <td style="display:none"><?= $itemdetails->get_itemhsncode(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemarticleno(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_packingunit(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_size(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_MRP(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_ppMRP(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemGST(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemimage(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemunit(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemunitFactor(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemunitId(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemunitFactorId(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemtotalMRP(); ?></td>
                                <td style="display:none"><?= $itemdetails->get_itemDiscount(); ?></td>

                                <td><?= $itemdetails->get_itemPrice(); ?></td>
                                <td><?= $itemdetails->get_ReceivedQty(); ?></td>
                                <td><?= $itemdetails->get_AllocatedQty(); ?></td>
                                <td><?= $itemdetails->get_AvailableQty(); ?></td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown"
                                            style="background-color:gray; color:white; border-radius: 8px; padding: 5px 10px;">
                                            Actions
                                        </button>

                                        <div class="dropdown-menu">
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#detailsItemModal"
                                                data-id="<?= $itemdetails->get_itemid(); ?>">
                                                <i class="fas fa-info-circle"></i> Item Info
                                            </button>

                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#edititemdetailsModal"
                                                data-id="<?= $itemdetails->get_itemid(); ?>">
                                                <i class="fas fa-user-edit"></i> Edit Item
                                            </button>

                                            <?php if ($itemdetails->isUsedAnywhere()) { ?>
                                                <button class="btn btn-secondary dropdown-item" disabled
                                                    title="Item is used in Quotation or Purchase Order">
                                                    <i class="fas fa-lock"></i> Delete Item
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-danger dropdown-item" data-toggle="modal"
                                                    data-target="#deleteItemModal" data-id="<?= $itemdetails->get_itemid(); ?>">
                                                    <i class="fas fa-trash-alt"></i> Delete Item
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


    <!-- Item Details Modal -->
    <div id="inventory_message" class="mb-3"></div>
    <div class="modal fade inventory-item-modal" id="itemdetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <form method="post" id="itemdetails_form" enctype="multipart/form-data"
                action="../Controller/item_detailscontroller.php">
                <input type="hidden" name="from_modal" value="1">
                <div class="modal-content">
                    <!-- Modern Header with Gradient -->
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                        <h4 class="modal-title text-white">
                            </i>Add Item Information
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="background: #f8f9fa; padding: 25px;">
                        <span id="form_message"></span>

                        <!-- Two Column Grid Layout -->
                        <div class="row g-3">
                            <!-- LEFT COLUMN -->
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-header"
                                        style="background: #f1f3f5; border-bottom: 2px solid #667eea;">
                                        <h6 class="mb-0"><i class="fas fa-tag me-2"></i>Item Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Item Name -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Item Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="itemname" id="itemname" class="form-control"
                                                required data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup"
                                                placeholder="Enter item name" />
                                            <input type="hidden" id="itemcatid" name="itemcatid" value="">
                                            <input type="hidden" id="itemsubcatid" name="itemsubcatid" value="">
                                            <input type="hidden" id="itemcompid" name="itemcompid" value="">
                                        </div>

                                        <!-- Brand -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Brand <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <select id="company" class="form-select me-2" required name="company"
                                                    style="flex:1;">
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Category & Subcategory Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-7">
                                                <label class="form-label fw-bold">Category <span
                                                        class="text-danger">*</span></label>
                                                <div class="d-flex">
                                                    <select id="itemCategory" class="form-select me-2" required
                                                        name="itemCategory" style="flex:1;">
                                                    </select>
                                                    <a class="btn btn-sm btn-outline-primary" data-toggle='modal'
                                                        data-target='#itemcatModal'>
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label fw-bold">Subcategory <span
                                                        class="text-danger">*</span></label>
                                                <div class="d-flex">
                                                    <select id="subCategory" class="form-select me-2" required
                                                        name="subCategory" style="flex:1;">
                                                    </select>
                                                    <a class="btn btn-sm btn-outline-primary" data-toggle='modal'
                                                        data-target='#itemsubcatModal'>
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="itemdescription" id="itemdescription" class="form-control"
                                                required rows="2" placeholder="Enter item description"></textarea>
                                        </div>

                                        <!-- Codes Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Item Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="itemarticleNo" id="itemarticleNo"
                                                    class="form-control" required data-parsley-minlength="6"
                                                    data-parsley-maxlength="16" data-parsley-trigger="keyup"
                                                    placeholder="Enter code" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">HSN Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="itemhsncode" id="itemhsncode"
                                                    class="form-control" data-parsley-type="email"
                                                    data-parsley-maxlength="150" data-parsley-trigger="keyup"
                                                    placeholder="Enter HSN code" />
                                            </div>
                                        </div>

                                        <!-- Quantity & Unit Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Quantity <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="itemsize" id="itemsize" class="form-control"
                                                    required data-parsley-trigger="change" placeholder="Enter qty" />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Unit <span
                                                        class="text-danger">*</span></label>
                                                <select id="unit" class="form-select" required name="unit">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Factor <span
                                                        class="text-danger">*</span></label>
                                                <select id="unitFactor" class="form-select" required name="unitFactor">
                                                </select>
                                            </div>
                                        </div>

                                        <!-- SPU -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <span title="Standard Packing Unit">SPU</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="itempu" id="itempu" class="form-control" required
                                                data-parsley-minlength="6" data-parsley-maxlength="16"
                                                data-parsley-trigger="keyup" placeholder="Enter SPU" />
                                        </div>

                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Item Image <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="itemimage" id="itemimage" class="form-control"
                                                accept="image/*" style="padding: 8px;" />
                                            <small class="text-muted">Upload product image (JPG, PNG, GIF)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN - Financial & Pricing -->
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-header"
                                        style="background: #f1f3f5; border-bottom: 2px solid #764ba2;">
                                        <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Pricing & Financials</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- MRP & GST Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">MRP <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="itemMRP" id="itemMRP" class="form-control"
                                                        required data-parsley-minlength="6" data-parsley-maxlength="16"
                                                        data-parsley-trigger="keyup" placeholder="0.00" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <span title="Goods and Service Tax">GST</span>
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <select name="itemGST" id="itemGST" class="form-select" required>
                                                        <option value="">Select GST</option>

                                                        <?php foreach ($taxList as $tax) { ?>
                                                            <option value="<?= (float) $tax->get_GST(); ?>">
                                                                <?= (float) $tax->get_GST(); ?> %
                                                            </option>
                                                        <?php } ?>

                                                    </select>

                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Discount -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Company Discount (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="itemDiscount" id="itemDiscount"
                                                    class="form-control" placeholder="0.00" />
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>

                                        <!-- Calculated Values -->
                                        <div class="bg-light p-3 rounded-3 mb-3"
                                            style="background: #f8f9fa !important;">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Amount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="text" name="itemAmount" id="itemAmount"
                                                            class="form-control" readonly
                                                            style="background: #e9ecef; font-weight: bold;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Price <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="text" name="itemPrice" id="itemPrice"
                                                            class="form-control" required readonly
                                                            style="background: #e9ecef; font-weight: bold;" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label fw-bold">Total Value <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="itemTotalValue" id="itemTotalValue"
                                                        class="form-control" required readonly
                                                        style="background: #e9ecef; font-weight: bold; color: #764ba2;" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden Fields -->
                                        <input type="hidden" name="itemcreatedby" id="itemcreatedby"
                                            class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                        <input type="hidden" name="itemmodifiedby" id="itemmodifiedby"
                                            class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Indicator -->
                        <div id="item_form_message" class="mt-3"></div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            </i>Close
                        </button>
                        <button type="submit" name="submit" id="submit_button" class="btn btn-success">
                            </i>Add Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade inventory-item-modal" id="edititemdetailsModal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <form method="post" id="editeditemdetails_form" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-content">
                    <!-- Modern Header with Gradient -->
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                        <h4 class="modal-title text-white">
                            </i>Edit Item Information
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="background: #f8f9fa; padding: 25px;">
                        <span id="form_message"></span>

                        <!-- Two Column Grid Layout -->
                        <div class="row g-3">
                            <!-- LEFT COLUMN -->
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-header"
                                        style="background: #f1f3f5; border-bottom: 2px solid #f093fb;">
                                        <h6 class="mb-0"><i class="fas fa-tag me-2"></i>Item Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Item Name -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Item Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="itemname" id="editeditemname" class="form-control"
                                                required data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup"
                                                placeholder="Enter item name" />
                                            <input type="hidden" id="itemid" name="itemid" value="">
                                            <input type="hidden" id="editeditemcatid" name="itemcatid" value="">
                                            <input type="hidden" id="editeditemsubcatid" name="itemsubcatid" value="">
                                            <input type="hidden" id="editeditemcompid" name="itemcompid" value="">
                                        </div>

                                        <!-- Brand -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Brand <span
                                                    class="text-danger">*</span></label>
                                            <select id="editedcompany" class="form-select" required name="company">
                                            </select>
                                        </div>

                                        <!-- Category & Subcategory Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-7">
                                                <label class="form-label fw-bold">Category <span
                                                        class="text-danger">*</span></label>
                                                <div class="d-flex">
                                                    <select id="editeditemCategory" class="form-select me-2" required
                                                        name="itemCategory" style="flex:1;">
                                                    </select>
                                                    <a class="btn btn-sm btn-outline-primary" data-toggle='modal'
                                                        data-target='#itemcatModal'>
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label fw-bold">Subcategory <span
                                                        class="text-danger">*</span></label>
                                                <div class="d-flex">
                                                    <select id="editedsubCategory" class="form-select me-2" required
                                                        name="subCategory" style="flex:1;">
                                                    </select>
                                                    <a class="btn btn-sm btn-outline-primary" data-toggle='modal'
                                                        data-target='#itemsubcatModal'>
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="itemdescription" id="editeditemdescription"
                                                class="form-control" required rows="2"
                                                placeholder="Enter item description"></textarea>
                                        </div>

                                        <!-- Codes Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Item Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="itemarticleNo" id="editeditemarticleNo"
                                                    class="form-control" required data-parsley-minlength="6"
                                                    data-parsley-maxlength="16" data-parsley-trigger="keyup"
                                                    placeholder="Enter code" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">HSN Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="itemhsncode" id="editeditemhsncode"
                                                    class="form-control" data-parsley-type="email"
                                                    data-parsley-maxlength="150" data-parsley-trigger="keyup"
                                                    placeholder="Enter HSN code" />
                                            </div>
                                        </div>

                                        <!-- Quantity & Unit Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Quantity <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="itemsize" id="editeditemsize"
                                                    class="form-control" required data-parsley-trigger="change"
                                                    placeholder="Enter qty" />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Unit <span
                                                        class="text-danger">*</span></label>
                                                <select id="editedunit" class="form-select" required name="unit">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Factor <span
                                                        class="text-danger">*</span></label>
                                                <select id="editedunitFactor" class="form-select" required
                                                    name="unitFactor">
                                                </select>
                                            </div>
                                        </div>

                                        <!-- SPU -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <span title="Standard Packing Unit">SPU</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="itempu" id="editeditempu" class="form-control"
                                                required data-parsley-minlength="6" data-parsley-maxlength="16"
                                                data-parsley-trigger="keyup" placeholder="Enter SPU" />
                                        </div>

                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Item Image</label>
                                            <input type="file" name="itemimage" id="editeditemimage"
                                                class="form-control" accept="image/*" style="padding: 8px;" />
                                            <small class="text-muted">Upload product image (JPG, PNG, GIF)</small>

                                            <!-- Current Image Preview -->
                                            <div class="mt-2">
                                                <img id="itemImage" src="" alt="Item Image"
                                                    style="max-width: 100px; max-height: 100px; border-radius: 8px; border: 1px solid #dee2e6; padding: 5px;" />
                                                <small class="d-block text-muted mt-1">Current image (leave blank to
                                                    keep
                                                    existing)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN - Financial & Pricing -->
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-3">
                                    <div class="card-header"
                                        style="background: #f1f3f5; border-bottom: 2px solid #f5576c;">
                                        <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Pricing & Financials</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- MRP & GST Side by Side -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">MRP <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="itemMRP" id="editeditemMRP"
                                                        class="form-control" required data-parsley-minlength="6"
                                                        data-parsley-maxlength="16" data-parsley-trigger="keyup"
                                                        placeholder="0.00" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <span title="Goods and Service Tax">GST</span>
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <select name="itemGST" id="editeditemGST" class="form-select"
                                                        required>
                                                        <option value="">Select GST</option>

                                                        <?php foreach ($taxList as $tax) { ?>
                                                            <option value="<?= (float) $tax->get_GST(); ?>">
                                                                <?= (float) $tax->get_GST(); ?> %
                                                            </option>
                                                        <?php } ?>

                                                    </select>

                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Discount -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Company Discount (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="itemDiscount"
                                                    id="editeditemDiscount" class="form-control" placeholder="0.00" />
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>

                                        <!-- Calculated Values -->
                                        <div class="bg-light p-3 rounded-3 mb-3"
                                            style="background: #f8f9fa !important;">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Amount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="text" name="itemAmount" id="editeditemAmount"
                                                            class="form-control" readonly
                                                            style="background: #e9ecef; font-weight: bold;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Price <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="text" name="itemPrice" id="editeditemPrice"
                                                            class="form-control" required readonly
                                                            style="background: #e9ecef; font-weight: bold;" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label fw-bold">Total Value <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="itemTotalValue" id="editeditemTotalValue"
                                                        class="form-control" required readonly
                                                        style="background: #e9ecef; font-weight: bold; color: #f5576c;" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden Fields -->
                                        <input type="hidden" name="itemcreatedby" id="editeditemcreatedby"
                                            class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                        <input type="hidden" name="itemmodifiedby" id="editeditemmodifiedby"
                                            class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Success Message Container -->
                        <div id="edit-success-message" class="mt-3"></div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Edit" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            </i>Close
                        </button>
                        <button type="submit" name="submit" id="editbutton" class="btn btn-success">
                            </i>Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id=deleteItemModal tabindex=-1 role=dialog aria-hidden=true>
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" id="delete_item_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header text-white"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                        <h4 class="modal-title" id="modal_title">Delete Item</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p class="lead">
                            Are you sure. Would you like to delete this Item.
                        </p>
                        <input type="hidden" name="itemid" id="deleteitemid" value="">
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

    <div class="modal fade" id="itemcatModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" id="addCategoryForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <!-- Modern Header with Gradient -->
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                        <h4 class="modal-title text-white">
                            Add New Category
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="background: #f8f9fa; padding: 25px;">
                        <span id="form_message"></span>

                        <!-- Category Name -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                <input type="text" name="itemcatname" id="itemcatname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" placeholder="Enter category name" autofocus />
                            </div>
                        </div>

                        <!-- Category Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="itemcatdescription" id="itemcatdescription" class="form-control"
                                    required rows="2" placeholder="Enter category description"></textarea>
                            </div>
                        </div>

                        <!-- Brand Selection - Proper Dropdown Style -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Brands <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                <div class="col-md-9">
                                    <div class="dropdown w-100">
                                        <button
                                            class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center dropdown-toggle"
                                            type="button" id="brandDropdown" data-toggle="dropdown"
                                            aria-expanded="false"
                                            style="border-radius: 8px; padding: 10px 15px; border: 2px solid #e9ecef; background: white;">
                                            <span>
                                                <span id="brandDropdownText">Select Brands</span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu w-80 p-4" id="checkboxes"
                                            style="max-height: 200px; overflow-y: auto; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                                            <!-- Dynamic checkboxes will be loaded here -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary w-100" data-toggle='modal'
                                        data-target='#brandModal'
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                                        <i class="fas fa-plus-circle me-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Selected Brands Display -->
                        <div id="selectedBrandsDisplay" class="mb-3" style="display: none;">
                            <label class="form-label fw-bold">Selected Brands:</label>
                            <div id="selectedBrandsTags" class="d-flex flex-wrap gap-2">
                                <!-- Tags will appear here -->
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="itemcatcreatedby" id="itemcatcreatedby" class="form-control"
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="itemcatmodifiedby" id="itemcatmodifiedby" class="form-control"
                            value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer"
                        style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 8px 8px;">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" name="submit" id="addCategorybtn" class="btn btn-success">
                            Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="itemsubcatModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" id="subCategoryForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <!-- Modern Header with Gradient -->
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                        <h4 class="modal-title text-white">
                            Add New Subcategory
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="background: #f8f9fa; padding: 25px;">
                        <span id="form_message"></span>

                        <!-- Category Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Parent Category <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-folder-open"></i></span>
                                <select id="additemCategory" class="form-select" required name="itemcatid">
                                    <option hidden disabled selected value>-- Select Category --</option>
                                </select>
                            </div>
                        </div>

                        <!-- Subcategory Name -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Subcategory Name <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" name="itemsubcatname" id="itemsubcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" placeholder="Enter subcategory name" autofocus />
                            </div>
                        </div>

                        <!-- Subcategory Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Subcategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="itemsubcatdescription" id="itemsubcatdescription" class="form-control"
                                    required rows="2" placeholder="Enter subcategory description"></textarea>
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="itemsubcatcreatedby" id="itemsubcatcreatedby" class="form-control"
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="itemsubcatmodifiedby" id="itemsubcatmodifiedby" class="form-control"
                            value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer"
                        style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 8px 8px;">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" name="submit" id="addSubCategorybtn" class="btn btn-success">
                            Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="detailsItemModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-content-modern shadow-lg">

                <div class="modal-header modal-header-modern align-items-center"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <div>
                        <h5 class="modal-title font-weight-bold text-white" id="modal_title">
                            <i class="fas fa-cube mr-2"></i> Item Information
                        </h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>

                <div class="modal-body bg-light px-4 py-4">
                    <input type="hidden" id="infoitemid" name="infoitemid">

                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                            <div class="product-img-frame">
                                <img src="" id="infoItemImage" alt="Item Preview">
                            </div>
                        </div>

                        <div class="col-lg-9 col-md-8">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="font-weight-bold text-dark mb-1" id="displayItemName"></h3>
                                    <div class="mb-3">
                                        <span class="badge badge-primary px-3 py-2 mr-1"
                                            id="displayItemCategory"></span>
                                        <span class="badge badge-light border px-3 py-2 text-muted"
                                            id="displayItemSubCategory"></span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <small class="text-muted text-uppercase font-weight-bold">Brand</small>
                                    <h5 class="text-dark font-weight-bold" id="displayItemComapny"></h5>
                                </div>
                            </div>

                            <div class="bg-white p-3 rounded shadow-sm border-0 mt-2">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <small class="text-muted font-weight-bold">Description</small>
                                        <p class="mb-0 text-dark" id="displayItemDescription"></p>
                                    </div>
                                    <div class="col-md-4 border-top pt-2 mt-1">
                                        <small class="text-muted">Code: </small>
                                        <span class="font-weight-bold text-dark" id="displayItemArticleNo"></span>
                                    </div>
                                    <div class="col-md-4 border-top pt-2 mt-1">
                                        <small class="text-muted">HSN Code: </small>
                                        <span class="font-weight-bold text-dark" id="displayItemHSNCode"></span>
                                    </div>

                                    <div class="col-md-4 border-top pt-2 mt-1">
                                        <small class="text-muted">Company Discount: </small>
                                        <span class="font-weight-bold text-success" id="displayItemDiscount"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-primary font-weight-bold mb-3 pl-1 text-uppercase small ls-1">Specifications &
                        Financials</h6>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card card-warn">
                                <span class="label-text"><i class="fas fa-layer-group mr-1"></i> SPU</span>
                                <p class="value-text" id="displayItempu"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card card-warn">
                                <span class="label-text"><i class="fas fa-cubes mr-1"></i> Quantity</span>
                                <p class="value-text" id="displayItemsize"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card">
                                <span class="label-text">Unit</span>
                                <p class="value-text" id="displayunit"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card">
                                <span class="label-text">Unit Factor</span>
                                <p class="value-text" id="displayunitFactor"></p>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card">
                                <span class="label-text">MRP</span>
                                <p class="value-text" id="displayItemMRP"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card">
                                <span class="label-text">GST %</span>
                                <p class="value-text" id="displayItemGST"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card card-highlight">
                                <span class="label-text text-success">Net Price</span>
                                <p class="value-text value-text-lg" id="displayItemppMRP"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="info-card card-highlight">
                                <span class="label-text text-success">Total Value</span>
                                <p class="value-text value-text-lg" id="displayItemTotalValue"></p>
                            </div>
                        </div>

                    </div>

                    <div class="card border-0 shadow-sm mt-3 overflow-hidden rounded-lg">
                        <div class="card-header bg-white border-bottom-0 pt-3">
                            <h6 class="m-0 font-weight-bold text-primary">Price History</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-modern table-hover mb-0" id="details_table" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Supplier Name</th>
                                        <th>PO Code</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                        <th>Rcvd Qty</th>
                                        <th>Received Qty Amt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white border-top-0">
                    <button type="button" class="btn btn-light text-secondary font-weight-bold"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" id="brand_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <!-- Modern Header with Gradient -->
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                        <h4 class="modal-title text-white">
                            Add New Brand
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="background: #f8f9fa; padding: 25px;">
                        <span id="brand_form_message"></span>

                        <!-- Brand Name -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Brand Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" name="brandname" id="brandname" class="form-control" required
                                    placeholder="Enter brand name" autofocus />
                            </div>
                        </div>

                        <!-- Input Types - Enhanced Dropdown -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Input Type <span class="text-danger">*</span></label>
                            <div class="dropdown w-100">
                                <button
                                    class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center dropdown-toggle"
                                    type="button" id="inputTypeDropdown" data-toggle="dropdown" aria-expanded="false"
                                    style="border-radius: 8px; padding: 10px 15px;">
                                    <span><i class="fas fa-list me-2"></i>Select Input Types</span>
                                </button>
                                <ul class="dropdown-menu w-100 p-3" id="brand_inputtypes"
                                    aria-labelledby="inputTypeDropdown"
                                    style="max-height: 200px; overflow-y: auto; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                                    <!-- Dynamic checkboxes will be loaded here -->
                                </ul>
                            </div>
                        </div>

                        <!-- Selected Input Types Display -->
                        <div id="selectedTypesDisplay" class="mb-3" style="display: none;">
                            <label class="form-label fw-bold">Selected Types:</label>
                            <div id="selectedTypesTags" class="d-flex flex-wrap gap-2">
                                <!-- Tags will appear here -->
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="brandcreatedby" value="<?php echo $_SESSION['login_user']; ?>">
                        <input type="hidden" name="brandmodifiedby" value="<?php echo $_SESSION['login_user']; ?>">
                        <input type="hidden" name="action" value="Add">
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer"
                        style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 8px 8px;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success" id="brandSubmitBtn">
                            Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Enhanced CSS -->
    <?php include('footer.php'); ?>

    <script>

        // Enhanced Brand Selection with Tags for Category Modal
        $(document).on('change', '#checkboxes input[type="checkbox"]', function () {
            updateSelectedBrands();
        });

        function updateSelectedBrands() {
            const checked = $('#checkboxes input:checked');
            const count = checked.length;
            const $display = $('#selectedBrandsDisplay');
            const $tags = $('#selectedBrandsTags');
            const $badge = $('#brandSelectedCount');

            // Update badge count
            $badge.text(count);

            if (count > 0) {
                $display.show();
                $tags.empty();

                checked.each(function () {
                    const label = $(this).closest('.form-check').find('.form-check-label').text();
                    const id = $(this).attr('id');

                    $tags.append(`
                <span class="brand-tag">
                    <i class="fas fa-check-circle me-1"></i>${label}
                    <span class="remove-brand-tag" data-id="${id}">&times;</span>
                </span>
            `);
                });

                // Update dropdown button text
                $('#brandDropdown span:first').html(`<i class="fas fa-trademark me-2"></i>${count} brand${count > 1 ? 's' : ''} selected`);
            } else {
                $display.hide();
                $('#brandDropdown span:first').html(`<i class="fas fa-trademark me-2"></i>Select Brands`);
            }
        }

        // Remove brand tag functionality
        $(document).on('click', '.remove-brand-tag', function () {
            const id = $(this).data('id');
            $('#' + id).prop('checked', false).trigger('change');
        });

        // Loading state for buttons
        $('#addCategoryForm').on('submit', function () {
            const $btn = $('#addCategorybtn');
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Adding...');
        });

        $('#subCategoryForm').on('submit', function () {
            const $btn = $('#addSubCategorybtn');
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Adding...');
        });

        // Re-enable buttons after response (add to your success callbacks)
        // $('#addCategorybtn').prop('disabled', false).html('<i class="fas fa-plus-circle me-1"></i>Add Category');
        // $('#addSubCategorybtn').prop('disabled', false).html('<i class="fas fa-plus-circle me-1"></i>Add Subcategory');
        $(document).ready(function () {
            if (window.location.hash === '#itemdetailsModal') {
                $('#itemdetailsModal').modal('show');
            }
        });
        // Enhanced Input Type Selection with Tags
        $(document).on('change', '#brand_inputtypes input[type="checkbox"]', function () {
            updateSelectedTypes();
        });

        function updateSelectedTypes() {
            const checked = $('#brand_inputtypes input:checked');
            const count = checked.length;
            const $display = $('#selectedTypesDisplay');
            const $tags = $('#selectedTypesTags');
            const $badge = $('#selectedCount');

            // Update badge count
            $badge.text(count);

            if (count > 0) {
                $display.show();
                $tags.empty();

                checked.each(function () {
                    const label = $(this).closest('.form-check').find('.form-check-label').text();
                    const id = $(this).attr('id');

                    $tags.append(`
                <span class="type-tag">
                    <i class="fas fa-check-circle me-1"></i>${label}
                    <span class="remove-tag" data-id="${id}">&times;</span>
                </span>
            `);
                });

                // Update dropdown button text
                $('#inputTypeDropdown span:first').html(`<i class="fas fa-list me-2"></i>${count} type${count > 1 ? 's' : ''} selected`);
            } else {
                $display.hide();
                $('#inputTypeDropdown span:first').html(`<i class="fas fa-list me-2"></i>Select Input Types`);
            }
        }

        // Remove tag functionality
        $(document).on('click', '.remove-tag', function () {
            const id = $(this).data('id');
            $('#' + id).prop('checked', false).trigger('change');
        });

        // Loading state for submit button
        $('#brand_form').on('submit', function () {
            const $btn = $('#brandSubmitBtn');
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Adding...');

            // Re-enable after response (in your success callback)
            // Add this to your existing success handler:
            // $('#brandSubmitBtn').prop('disabled', false).html('<i class="fas fa-plus-circle me-1"></i>Add Brand');
        });

        // Enhanced Brand Selection with Better UX
        $(document).on('change', '#checkboxes input[type="checkbox"]', function () {
            updateSelectedBrands();
        });

        function updateSelectedBrands() {
            const checked = $('#checkboxes input:checked');
            const count = checked.length;
            const $display = $('#selectedBrandsDisplay');
            const $tags = $('#selectedBrandsTags');
            const $badge = $('#brandSelectedCount');
            const $text = $('#brandDropdownText');

            // Update badge count
            $badge.text(count);

            if (count > 0) {
                $display.show();
                $tags.empty();

                // Create brand list for dropdown text
                let brandNames = [];
                checked.each(function () {
                    const label = $(this).closest('.form-check').find('.form-check-label').text();
                    const id = $(this).attr('id');
                    brandNames.push(label);

                    $tags.append(`
                <span class="brand-tag" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; animation: fadeIn 0.3s ease; box-shadow: 0 2px 8px rgba(250, 112, 154, 0.3);">
                    <i class="fas fa-check-circle me-1"></i>${label}
                    <span class="remove-brand-tag" data-id="${id}" style="cursor: pointer; opacity: 0.7; transition: opacity 0.2s ease; font-size: 14px; margin-left: 5px;">&times;</span>
                </span>
            `);
                });

                // Update dropdown button text with brand names
                if (count <= 2) {
                    $text.text(brandNames.join(', '));
                } else {
                    $text.text(`${count} brands selected`);
                }

                // Change button style when brands are selected
                $('#brandDropdown').removeClass('btn-outline-secondary').addClass('btn-primary').css({
                    'background': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    'border': 'none',
                    'color': 'white'
                });

            } else {
                $display.hide();
                $text.text('Select Brands');
                $('#brandDropdown').removeClass('btn-primary').addClass('btn-outline-secondary').css({
                    'background': 'white',
                    'border': '2px solid #e9ecef',
                    'color': '#212529'
                });
            }
        }

        // Remove brand tag functionality
        $(document).on('click', '.remove-brand-tag', function () {
            const id = $(this).data('id');
            $('#' + id).prop('checked', false).trigger('change');
        });

        // Close dropdown when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        // Prevent dropdown from closing when clicking inside
        $('#checkboxes').on('click', function (e) {
            e.stopPropagation();
        });
    </script>

    <script>
        $(document).ready(function () {

            // ✅ Load Input Types when Brand Modal opens
            $('#brandModal').on('show.bs.modal', function () {
                const url = config.developmentPath + "/Admin/Controller/inputTypeController.php";
                $('#brand_inputtypes').empty();

                $.getJSON(url, function (data) {
                    $.each(data, function (index, value) {
                        $('#brand_inputtypes').append(
                            `<li class="form-check form-switch px-3">
          <input class="form-check-input me-1" name="inputtype_list[]" value="${value.InputTypeId}" type="checkbox" id="input_${value.InputTypeId}">
          <label class="form-check-label" for="input_${value.InputTypeId}">${value.InputType}</label>
        </li>`
                        );
                    });
                });
            });
            // ✅ Add Brand & Return to Item Modal
            // ✅ Add Brand & Return to Item Modal
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



            function reloadBrandList(selectBrandId = null) {
                const $company = $('#company');
                $company.empty().append('<option hidden disabled selected value>-- select brand --</option>');

                const fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php";
                $.getJSON(fetchcompany, function (data) {
                    $.each(data, function (index, value) {
                        $company.append(`<option value="${value.brandid}">${value.brandname}</option>`);
                    });

                    // ✅ Auto-select the newly added brand (if provided)
                    if (selectBrandId) {
                        $company.val(selectBrandId);
                    }
                });
            }
            function reloadCategoryBrands() {
                $('#checkboxes').empty();

                const InputType = 1;
                const fetchUrl = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputType;

                $.getJSON(fetchUrl, function (data) {
                    $.each(data, function (index, value) {
                        $('#checkboxes').append(
                            `<li class="form-check form-switch px-3">
                    <input class="form-check-input me-1" name="brand_list[]" 
                        value="${value.brandid}" type="checkbox" id="brand_${value.brandid}">
                    <label for="brand_${value.brandid}">${value.brandname}</label>
                </li>`
                        );
                    });
                });
            }


            // REMOVE these old ones:
            // $('#itemMRP').blur(...)
            // $('#itempu').blur(...)
            // $('#itemsize').blur(...)
            // $('#unitFactor').on('change', ...)

            $('#itemMRP, #itemDiscount, #itemGST, #itempu').on('keyup blur change', function () {
                calculatePriceAndValue();
            });
            var InputType = 1;
            var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputType;
            $.getJSON(fetchsubcaturl, function (data) {

                $.each(data, function (index, value) {
                    $('#checkboxes').append(
                        $(document.createElement('li')).prop({
                            class: 'form-check form-switch'
                        }).append(
                            $(document.createElement('input')).prop({
                                class: 'form-check-input me-1',
                                id: 'myCheckBox',
                                name: 'brand_list[]',
                                value: value.brandid,
                                type: 'checkbox'
                            })).append(
                                $(document.createElement('label')).prop({
                                    for: 'myCheckBox'
                                }).html(value.brandname)
                            ).append(document.createElement('br')));
                });
            });

            // ✅ For Add Modal
            function calculatePriceAndValue() {

                let MRP = parseFloat($('#itemMRP').val()) || 0;
                let Discount = parseFloat($('#itemDiscount').val()) || 0;
                let GST = parseFloat($('#itemGST').val()) || 0;
                let SPU = parseFloat($('#itempu').val()) || 0;

                // ✅ Read factor from TEXT of selected option (same as material)
                let factor = parseFloat($('#unitFactor').find(":selected").text()) || 1;

                let price = MRP * factor; // ✅ same formula as material calculation

                if (Discount > 0) {
                    let discounted = price - (price * (Discount / 100));
                    price = discounted * (1 + (GST / 100)); // same GST logic
                }
                let amount = MRP * factor;

                $('#itemAmount').val(amount.toFixed(2));
                $('#itemPrice').val(price.toFixed(2));
                $('#itemTotalValue').val((price * SPU).toFixed(2));
            }



            // ✅ Trigger auto update for Add modal inputs
            $('#itemMRP, #itemDiscount, #itemGST, #itempu, #unitFactor')
                .on('keyup blur change', calculatePriceAndValue);

            // ✅ Auto update when factor changes explicitly
            $('#unitFactor').on('change', function () {
                calculatePriceAndValue();
            });


            // ✅ For Edit Modal
            function calculateEditedPriceAndValue() {

                let MRP = parseFloat($('#editeditemMRP').val()) || 0;
                let Discount = parseFloat($('#editeditemDiscount').val()) || 0;
                let GST = parseFloat($('#editeditemGST').val()) || 0;
                let SPU = parseFloat($('#editeditempu').val()) || 0;

                // ✅ Read factor from TEXT (not ID)
                let factor = parseFloat($('#editedunitFactor').find(":selected").text()) || 1;

                let price = MRP * factor;

                if (Discount > 0) {
                    let discounted = price - (price * (Discount / 100));
                    price = discounted * (1 + (GST / 100));
                }
                let amount = MRP * factor;

                $('#editeditemAmount').val(amount.toFixed(2));
                $('#editeditemPrice').val(price.toFixed(2));
                $('#editeditemTotalValue').val((price * SPU).toFixed(2));
            }



            // ✅ Auto trigger for Edit modal inputs
            $('#editeditemMRP, #editeditemDiscount, #editeditemGST, #editeditempu, #editedunitFactor')
                .on('keyup blur change', calculateEditedPriceAndValue);

            // ✅ Auto update when factor dropdown changes
            $('#editedunitFactor').on('change', function () {
                calculateEditedPriceAndValue();
            });

            $('#edititemdetailsModal').on('show.bs.modal', function (e) {
                var rowid = $(e.relatedTarget).data('id');
                $('#itemid').val(rowid);
            });

            $('#detailsItemModal').on('show.bs.modal', function (e) {

                var rowid = $(e.relatedTarget).data('id');

                let url = config.developmentPath +
                    "/Admin/Controller/item_detailscontroller.php?infoitemid=" + rowid;

                $.getJSON(url, function (data) {

                    console.log("ITEM JSON:", data);

                    if (!data || data.length === 0) return;

                    const i = data[0];

                    function safe(v) { return (v === null || v === "" || v === undefined) ? "-" : v; }

                    // FIXED FIELD NAMES ↓↓↓
                    $('#displayItemName').text(safe(i.itemname));
                    $('#displayItemCategory').text(safe(i.categoryname));
                    $('#displayItemSubCategory').text(safe(i.subcategoryname));
                    $('#displayItemDescription').text(safe(i.itemdescription));
                    $('#displayItemComapny').text(safe(i.brandname));
                    $('#displayItemArticleNo').text(safe(i.itemcode));
                    $('#displayItemHSNCode').text(safe(i.hsncode));
                    $('#displayItemDiscount').text(
                        safe(i.itemDiscount) + "%"
                    );
                    $('#displayItempu').text(safe(i.spu));
                    $('#displayItemsize').text(safe(i.qty));
                    $('#displayunit').text(safe(i.unitname));
                    $('#displayunitFactor').text(safe(i.unitFactor));
                    $('#displayItemMRP').text(safe(i.itemMRP));
                    $('#displayItemGST').text(safe(i.itemGST) + "%");
                    $('#displayItemppMRP').text(safe(i.itemPrice));
                    $('#displayItemTotalValue').text(
                        safe(parseFloat(i.itemTotalValue).toFixed(2))
                    );


                    // IMAGE FIX
                    let img = i.itemimage
                        ? config.developmentPath + "/Admin/img/items/" + encodeURIComponent(i.itemimage)
                        : config.developmentPath + "/Admin/img/no-image.png";

                    console.log("Image Name :", i.itemimage);
                    console.log("Image URL :", img);
                    console.log(img);
                    console.log($("#infoItemImage").length);

                    $('#infoItemImage').attr('src', img);

                    // PURCHASE TABLE
                    // PURCHASE HISTORY TABLE (FIXED)
                    $("#details_table tbody").empty();

                    // Sort by purchase date
                    data.sort((a, b) => new Date(a.DateofPurchase) - new Date(b.DateofPurchase));

                    let hasHistory = false;

                    $.each(data, function (index, r) {

                        // Skip records that have no purchase history
                        if (
                            !r.SupplierName &&
                            !r.POcode &&
                            !r.InvoiceNo &&
                            !r.DateofPurchase
                        ) {
                            return true; // continue
                        }

                        hasHistory = true;

                        let perUnitAmt = "-";

                        if (parseFloat(r.ReceivedQty) > 0) {
                            perUnitAmt = (
                                parseFloat(r.ReceivedQtyAmt) /
                                parseFloat(r.ReceivedQty)
                            ).toFixed(2);
                        }

                        $("#details_table tbody").append(`
        <tr>
            <td>${safe(r.SupplierName)}</td>
            <td>${safe(r.POcode)}</td>
            <td>${safe(r.InvoiceNo)}</td>
            <td>${safe(r.DateofPurchase)}</td>
            <td>${safe(r.ItemPrice)}</td>
            <td>${safe(r.ReceivedQty)}</td>
            <td>${perUnitAmt}</td>
        </tr>
    `);
                    });

                    // Leave tbody empty if no purchase history exists
                    if (!hasHistory) {
                        $("#details_table tbody").empty();
                    }


                });
            });

            // =====================================
            //   ADD ITEM FORM (AJAX SUBMISSION)
            // =====================================
            $('#itemdetails_form').on('submit', function (event) {
                event.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: config.developmentPath + "/Admin/Controller/item_detailscontroller.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#item_form_message').html('<div class="alert alert-info">Saving...</div>');
                    },
                    success: function (res) {

                        let json;
                        try {
                            json = typeof res === "string" ? JSON.parse(res) : res;
                        } catch (e) {
                            $('#item_form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                            return;
                        }

                        // ❌ DUPLICATE ITEM MESSAGE FROM PHP
                        if (json.status === "error") {
                            $('#inventory_message').html(`
    <div class="alert alert-danger alert-dismissible fade show">
        ${json.message}
    </div>
`);

                            $('#itemdetailsModal').modal('hide');

                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            if ($('#inventory_message').length) {
                                $('html, body').animate({
                                    scrollTop: $('#inventory_message').offset().top - 20
                                }, 300);
                            }

                            setTimeout(function () {
                                $('#inventory_message').fadeOut(function () {
                                    $(this).html('').show();
                                });
                            }, 4000);

                            return;
                        }

                        // ✔ SUCCESS
                        // ✔ SUCCESS
                        $('#itemdetailsModal').modal('hide');

                        // remove backdrop
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');

                        // show message above table
                        $('#inventory_message').html(`
    <div class="alert alert-success alert-dismissible fade show">
        ${json.message || "Item added successfully."}
    </div>
`);

                        // scroll to message
                        if ($('#inventory_message').length) {
                            $('html, body').animate({
                                scrollTop: $('#inventory_message').offset().top - 20
                            }, 300);
                        }

                        // hide message after 4 sec
                        setTimeout(function () {
                            $('#inventory_message').fadeOut(function () {
                                $(this).html('').show();
                            });
                        }, 4000);

                        // reload page
                        setTimeout(function () {
                            location.reload();
                        }, 1200);
                    },

                    error: function (xhr, status, error) {
                        $('#item_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    }
                });
            });



            // $('#iteminfo').click(function() {
            //     debugger;
            //     var rowid = $('#infoitemid').val()

            // });


            var uniturl = config.developmentPath +
                "/Admin/Controller/unitsContoller.php"
            $.getJSON(uniturl, function (data) {
                loadEditedUnitFactor(data[0].unitId);
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#editedunit').append('<option value="' + value.unitId + '">' + value
                        .unitName + '</option>');
                });

            });

            function loadEditedUnitFactor(unitId) {

                $('#editedunitFactor').empty();
                unitFactorurl =
                    config.developmentPath +
                    "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
                $.getJSON(unitFactorurl, function (data) {
                    $.each(data, function (index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        $('#editedunitFactor').append('<option value="' + value.unitFactorId +
                            '">' + value.unitFactor + '</option>');
                    });
                });
            }

            var dataTable = $('#item_table').DataTable({});
            var nEditing = null;

            // $('#item_table tbody').on('click', 'tr', function () {
            //     debugger;
            //     /* Get the row as a parent of the link that was clicked on */

            //     $('#editeditemname').val(this.cells[0].innerHTML.replace('&amp;', '&'));
            //     $('#displayItemName').text(this.cells[0].innerHTML.replace('&amp;', '&'));
            //     $('#editeditemdescription').val(this.cells[1].innerHTML);
            //     $('#displayItemDescription').text(this.cells[1].innerHTML);
            //     $('#editeditemCategory').val(this.cells[2].innerHTML);
            //     $('#displayItemCategory').text(this.cells[3].innerHTML)

            //     $('#displayItemSubCategory').text(this.cells[5].innerHTML)
            //     $('#editedcompany').val(this.cells[6].innerHTML);
            //     $('#displayItemComapny').text(this.cells[7].innerHTML)
            //     $('#editeditemhsncode').val(this.cells[8].innerHTML);
            //     $('#displayItemHSNCode').text(this.cells[8].innerHTML)
            //     $('#editeditemarticleNo').val(this.cells[9].innerHTML);
            //     $('#displayItemArticleNo').text(this.cells[9].innerHTML)
            //     $('#editeditempu').val(this.cells[10].innerHTML);
            //     $('#displayItempu').text(this.cells[10].innerHTML);
            //     $('#editeditemsize').val(this.cells[11].innerHTML);
            //     $('#displayItemsize').text(this.cells[11].innerHTML);
            //     $('#editeditemMRP').val(this.cells[12].innerHTML);
            //     $('#displayItemMRP').text(this.cells[12].innerHTML);
            //     $('#editeditemppMRP').val(this.cells[13].innerHTML);
            //     $('#displayItemppMRP').text(this.cells[13].innerHTML);
            //     $('#editeditemGST').val(this.cells[14].innerHTML);
            //     $('#displayItemGST').text(this.cells[14].innerHTML + '%');
            //     $('#editeditemdescriptionforcust').val(this.cells[16].innerHTML);
            //     $('#displayitemdescriptionforcust').text(this.cells[16].innerHTML);
            //     $('#editedunit').val(this.cells[17].innerHTML);
            //     $('#displayunit').text(this.cells[20].innerHTML);
            //     $('#editedunitFactor').val(this.cells[21].innerHTML);
            //     $('#displayunitFactor').text(this.cells[21].innerHTML);
            //     $('#editedtotalMRP').val(this.cells[19].innerHTML);
            //     $('#displaytotalMRP').text(this.cells[19].innerHTML);
            //     loadEditedUnitFactor(this.cells[17].innerHTML);
            //     $('#editedsubCategory').empty();
            //     $('#itemImage').attr('src', config.developmentPath +
            //         "/Admin/img/items/" + this.cells[15].innerHTML)
            //     var fetchsubcaturl = config.developmentPath +
            //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + $(
            //             '#editeditemCategory').val();
            //     var subcatid = this.cells[4].innerHTML;
            //     $.getJSON(fetchsubcaturl, function (data) {
            //         $.each(data, function (index, value) {
            //             // APPEND OR INSERT DATA TO SELECT ELEMENT.

            //             if (value.itemsubcatid == subcatid) {
            //                 $('#editedsubCategory').append('<option selected value="' + value
            //                     .itemsubcatid +
            //                     '">' + value
            //                         .itemsubcatname + '</option>');
            //             } else {
            //                 $('#editedsubCategory').append('<option value="' + value
            //                     .itemsubcatid +
            //                     '">' + value
            //                         .itemsubcatname + '</option>');
            //             }

            //         });
            //     });

            // });
            $('#edititemdetailsModal').on('show.bs.modal', function (e) {
                const $btn = $(e.relatedTarget);     // the Edit button clicked
                const $tr = $btn.closest('tr');      // the table row
                const tds = $tr.find('td');          // all <td> cells inside the row

                // Set hidden item ID
                $('#itemid').val($btn.data('id'));

                // ✅ Basic fields
                $('#editeditemname').val($(tds[0]).text().trim());          // Item Name
                $('#editeditemdescription').val($(tds[1]).text().trim());   // Description
                $('#editeditemarticleNo').val($(tds[9]).text().trim());     // Item Code
                $('#editeditemhsncode').val($(tds[8]).text().trim());       // HSN
                $('#editeditemsize').val($(tds[11]).text().trim());         // Quantity
                $('#editeditempu').val($(tds[10]).text().trim());           // SPU
                $('#editeditemMRP').val($(tds[12]).text().trim());          // MRP
                $('#editeditemGST').val(parseFloat($(tds[14]).text().trim()));

                // ✅ Discount & Price (fixed indexes)
                $('#editeditemDiscount').val($(tds[21]).text().trim());     // Company Discount
                $('#editeditemPrice').val($(tds[22]).text().trim());        // Price
                $('#editeditemAmount').val($(tds[23]).text().trim());



                // ✅ IDs for dropdowns
                const catId = $(tds[2]).text().trim();
                const subcatId = $(tds[4]).text().trim();
                const companyId = $(tds[6]).text().trim();
                const unitId = $(tds[18]).text().trim();
                const unitFactorId = $(tds[19]).text().trim();

                // ✅ Image preview (show placeholder if missing)
                const imgFile = $(tds[15]).text().trim();
                const imagePath = imgFile
                    ? config.developmentPath + "/Admin/img/items/" + imgFile
                    : config.developmentPath + "/Admin/img/no-image.png";
                $('#itemImage').attr('src', imagePath);

                // ✅ Load dropdowns and recalculate
                populateEditDropdowns({ catId, subcatId, companyId, unitId, unitFactorId })
                    .then(() => calculateEditedPriceAndValue());
            });


            function getJSONp(url) { return $.getJSON(url); }
            function fillSelect($sel, list, valueKey, textKey, placeholder) {
                $sel.empty();
                if (placeholder) $sel.append(`<option hidden disabled selected value>${placeholder}</option>`);
                list.forEach(v => $sel.append(`<option value="${v[valueKey]}">${v[textKey]}</option>`));
            }

            function loadCategories() {
                const url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
                return getJSONp(url).then(data => { fillSelect($('#editeditemCategory'), data, 'itemcatid', 'itemcatname', '-- select --'); return data; });
            }
            function loadSubcategories(catId) {
                const url = config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php/?catId=" + catId;
                return getJSONp(url).then(data => { fillSelect($('#editedsubCategory'), data, 'itemsubcatid', 'itemsubcatname', '-- select --'); return data; });
            }
            function loadBrands(catId) {
                const url = config.developmentPath + "/Admin/Controller/brandcontroller.php?categoryId=" + catId;
                return getJSONp(url).then(data => { fillSelect($('#editedcompany'), data, 'brandid', 'brandname', '-- select --'); return data; });
            }
            function loadUnits() {
                const url = config.developmentPath + "/Admin/Controller/unitsContoller.php";
                return getJSONp(url).then(data => { fillSelect($('#editedunit'), data, 'unitId', 'unitName', '-- select --'); return data; });
            }
            function loadUnitFactors(unitId) {
                const url = config.developmentPath + "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
                return getJSONp(url).then(data => { fillSelect($('#editedunitFactor'), data, 'unitFactorId', 'unitFactor', '-- select --'); return data; });
            }

            // Orchestrator
            function populateEditDropdowns({ catId, subcatId, companyId, unitId, unitFactorId }) {
                return loadCategories()
                    .then(() => { $('#editeditemCategory').val(catId); return $.when(loadSubcategories(catId), loadBrands(catId)); })
                    .then(() => {
                        if (subcatId) $('#editedsubCategory').val(subcatId);
                        if (companyId) $('#editedcompany').val(companyId);
                        return loadUnits();
                    })
                    .then(() => loadUnitFactors(unitId))
                    .then(() => {
                        if (unitId) $('#editedunit').val(unitId);
                        if (unitFactorId) $('#editedunitFactor').val(unitFactorId);
                    });
            }

            var uniturl = config.developmentPath +
                "/Admin/Controller/unitsContoller.php"
            $.getJSON(uniturl, function (data) {
                loadUnitFactor(data[0].unitId);
                $.each(data, function (index, value) {
                    $('#unit').append(
                        '<option hidden disabled selected value>-- select an option --</option>');
                    $('#unit').append('<option value="' + value.unitId + '">' + value
                        .unitName + '</option>');
                });

            });

            function loadUnitFactor(unitId) {

                $('#unitFactor').empty();
                $('#unitFactor').append('<option hidden disabled selected value>-- select factor --</option>');

                let unitFactorurl =
                    config.developmentPath +
                    "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;

                $.getJSON(unitFactorurl, function (data) {
                    $.each(data, function (index, value) {
                        $('#unitFactor').append(
                            `<option value="${value.unitFactorId}" data-factor="${value.unitFactor}">
                    ${value.unitFactor}
                </option>`
                        );
                    });
                });
            }


            $('#editeditemdetails_form').on('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: config.developmentPath + "/Admin/Controller/item_detailscontroller.php/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#editbutton').prop('disabled', true);
                        $('#form_message').html('<div class="alert alert-info">Saving...</div>');
                    }
                })
                    .done(function (res) {

                        console.log("Response:", res);

                        let json;

                        try {
                            json = (typeof res === "string") ? JSON.parse(res) : res;
                        } catch (e) {

                            $('#edititemdetailsModal').modal('hide');

                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            $('#inventory_message').html(`
    <div class="alert alert-danger alert-dismissible fade show">
        ${json.message}
    </div>
`);

                            $('html, body').animate({
                                scrollTop: $('#inventory_message').offset().top - 20
                            }, 300);

                            setTimeout(function () {
                                $('#inventory_message').fadeOut(function () {
                                    $(this).html('').show();
                                });
                            }, 4000);

                            $('#editbutton').prop('disabled', false);

                            return;

                            $("#editbutton").prop("disabled", false);
                            return;
                        }

                        // -----------------------------
                        // DUPLICATE / ERROR
                        // -----------------------------
                        if (json.status === "error") {

                            $('#edititemdetailsModal').modal('hide');

                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            $('#inventory_message')
                                .stop(true, true)
                                .html(`
            <div class="alert alert-danger alert-dismissible fade show">
                ${json.message}
            </div>
        `)
                                .show();

                            $('html, body').animate({
                                scrollTop: $('#inventory_message').offset().top - 20
                            }, 300);

                            setTimeout(function () {
                                $('#inventory_message').fadeOut(function () {
                                    $(this).html('').show();
                                });
                            }, 4000);

                            $("#editbutton").prop("disabled", false);

                            return;
                        }

                        // -----------------------------
                        // SUCCESS
                        // -----------------------------
                        if (json.status === "success") {

                            $("#edit-success-message")
                                .html(`
                <div class="alert alert-success alert-dismissible fade show">
                    ${json.message}
                </div>
            `);

                            setTimeout(function () {

                                $("#edititemdetailsModal").modal("hide");

                                location.reload();

                            }, 1200);
                        }

                        $("#editbutton").prop("disabled", false);

                    })
                    .fail(function (xhr, status, error) {
                        console.error("❌ AJAX Failed:", error);
                        $('#form_message').html('<div class="alert alert-danger">Save failed: ' + error + '</div>');
                        $('#editbutton').prop('disabled', false);
                    });
            });




            // var url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
            // let catId = 0;
            // $.getJSON(url, function (data) {
            //     $('#itemCategory').append(
            //         '<option hidden disabled selected value>-- select an option --</option>'
            //     );
            //     $.each(data, function (index, value) {

            //         $('#itemCategory').append('<option  value="' + value.itemcatid +
            //             '">' +
            //             value
            //                 .itemcatname + '</option>');
            //         $('#editeditemCategory').append('<option  value="' + value
            //             .itemcatid +
            //             '">' + value
            //                 .itemcatname + '</option>');

            //     });
            // });

            function setSubCategory(catId) {
                var fetchsubcaturl = config.developmentPath +
                    "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
                    catId;
                $.getJSON(fetchsubcaturl, function (data) {
                    $('#subCategory').append(
                        '<option hidden disabled selected value>-- select an option --</option>');
                    $.each(data, function (index, value) {
                        $('#subCategory').append('<option value="' + value.itemsubcatid + '">' +
                            value
                                .itemsubcatname + '</option>');
                        $('#editedsubCategory').append('<option value="' + value.itemsubcatid +
                            '">' +
                            value
                                .itemsubcatname + '</option>');
                    });
                });
            }


            $('#unit').on('change', function () {
                $('#unitFactor').empty();
                unitFactorurl =
                    config.developmentPath +
                    "/Admin/Controller/unitFactorController.php/?unitId=" + this
                        .value;
                $.getJSON(unitFactorurl, function (data) {

                    $.each(data, function (index, value) {

                        $('#unitFactor').append('<option value="' + value.unitFactorId +
                            '">' +
                            value
                                .unitFactor + '</option>');
                    });
                });
            });

            $('#editedunit').on('change', function () {
                $('#editedunitFactor').empty();
                unitFactorurl =
                    config.developmentPath +
                    "/Admin/Controller/unitFactorController.php/?unitId=" + this
                        .value;
                $.getJSON(unitFactorurl, function (data) {
                    $.each(data, function (index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        $('#editedunitFactor').append(
                            `<option value="${value.unitFactorId}" data-factor="${value.unitFactor}">
        ${value.unitFactor}
     </option>`
                        );

                    });
                });
            });

            // $('#itemCategory').on('change', function () {

            //     debugger;
            //     $('#subCategory').empty();
            //     $('#company').empty();
            //     fetchsubcaturl =
            //         config.developmentPath +
            //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
            //             .value;
            //     $.getJSON(fetchsubcaturl, function (data) {
            //         $.each(data, function (index, value) {
            //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
            //             $('#subCategory').append(
            //                 '<option hidden disabled selected value>-- select an option --</option>'
            //             );
            //             $('#subCategory').append('<option value="' + value.itemsubcatid +
            //                 '">' +
            //                 value
            //                     .itemsubcatname + '</option>');
            //         });
            //     });
            //     var fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php?categoryId=" + this
            //         .value;
            //     $.getJSON(fetchcompany, function (data) {
            //         $.each(data, function (index, value) {
            //             $('#company').append(
            //                 '<option hidden disabled selected value>-- select an option --</option>'
            //             );
            //             $('#company').append('<option value="' + value.brandid + '">' + value
            //                 .brandname + '</option>');
            //             $('#editedcompany').append('<option value="' + value.brandid + '">' + value
            //                 .brandname + '</option>');
            //         });
            //     });
            // });
            // =======================================
            // BRAND → LOAD CATEGORIES
            // =======================================
            $('#company').on('change', function () {

                let brandId = this.value;

                $('#itemCategory').empty();
                $('#subCategory').empty();

                if (!brandId) return;

                let url = config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php?brandId=" + brandId;

                $.getJSON(url, function (data) {

                    $('#itemCategory')
                        .append('<option hidden disabled selected value>-- select category --</option>');

                    if (!data || data.length === 0) {
                        alert("No categories mapped to this brand.");
                        return;
                    }

                    $.each(data, function (index, value) {
                        $('#itemCategory').append(
                            `<option value="${value.itemcatid}">
                    ${value.itemcatname}
                 </option>`
                        );
                    });

                });
            });
            // =======================================
            // LOAD BRANDS WHEN ITEM MODAL OPENS
            // =======================================
            $('#itemdetailsModal').on('show.bs.modal', function () {
                reloadBrandListSimple();   // Load all brands first
            });
            // =======================================
            // CATEGORY → LOAD SUBCATEGORY (ADD MODAL)
            // =======================================
            $('#itemCategory').on('change', function () {

                let catId = this.value;

                $('#subCategory').empty();

                if (!catId) return;

                let fetchsubcaturl =
                    config.developmentPath +
                    "/Admin/Controller/item_subcategorycontroller.php/?catId=" + catId;

                $.getJSON(fetchsubcaturl, function (data) {

                    $('#subCategory')
                        .append('<option hidden disabled selected value>-- select subcategory --</option>');

                    if (!data || data.length === 0) {
                        alert("No subcategories found.");
                        return;
                    }

                    $.each(data, function (index, value) {
                        $('#subCategory').append(
                            `<option value="${value.itemsubcatid}">
                    ${value.itemsubcatname}
                 </option>`
                        );
                    });

                });
            });

            // $('#editeditemCategory').on('change', function () {
            //     debugger;
            //     $('#editedsubCategory').empty();
            //     fetchsubcaturl =
            //         config.developmentPath +
            //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
            //             .value;

            //     $.getJSON(fetchsubcaturl, function (data) {
            //         $.each(data, function (index, value) {
            //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
            //             $('#editedsubCategory').append('<option value="' + value
            //                 .itemsubcatid +
            //                 '">' +
            //                 value
            //                     .itemsubcatname + '</option>');
            //         });
            //     });
            //     var fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php?categoryId=" + this
            //         .value;
            //     $.getJSON(fetchcompany, function (data) {
            //         $.each(data, function (index, value) {
            //             $('#company').append(
            //                 '<option hidden disabled selected value>-- select an option --</option>'
            //             );
            //             $('#company').append('<option value="' + value.brandid + '">' + value
            //                 .brandname + '</option>');
            //             $('#editedcompany').append('<option value="' + value.brandid + '">' + value
            //                 .brandname + '</option>');
            //         });
            //     });
            // });

            $('#itemsubcatModal').on('show.bs.modal', function () {

                $('#additemCategory').empty();

                const url = config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php";

                $.getJSON(url, function (data) {

                    $('#additemCategory')
                        .append('<option hidden disabled selected value>-- select category --</option>');

                    $.each(data, function (index, value) {
                        $('#additemCategory').append(
                            `<option value="${value.itemcatid}">
                    ${value.itemcatname}
                 </option>`
                        );
                    });

                });
            });

            $('#deleteItemModal').on('show.bs.modal', function (e) {
                var rowid = $(e.relatedTarget).data('id');
                $('#deleteitemid').val(rowid);
            });

            $('#delete_item_form').on('submit', function (e) {

                e.preventDefault();

                $.ajax({
                    url: config.developmentPath + "/Admin/Controller/item_detailscontroller.php/",
                    type: "POST",
                    data: {
                        id: $('#deleteitemid').val(),
                        action: "delete"
                    },
                    dataType: "json",

                    beforeSend: function () {
                        $("#deletebutton")
                            .prop("disabled", true)
                            .val("Deleting...");
                    },

                    success: function (response) {

                        $('#deleteItemModal').modal('hide');

                        if (response.status === "success") {

                            $('#inventory_message').html(`
                    <div class="alert alert-success alert-dismissible fade show">
                        ${response.message}
                    </div>
                `);

                        } else {

                            $('#inventory_message').html(`
                    <div class="alert alert-danger alert-dismissible fade show">
                        ${response.message}
                    </div>
                `);

                        }

                        // Scroll only if the message container exists
                        if ($('#inventory_message').length) {
                            $('html, body').animate({
                                scrollTop: $('#inventory_message').offset().top - 20
                            }, 300);
                        }

                        // Hide the message after 4 seconds
                        setTimeout(function () {
                            $('#inventory_message').fadeOut(function () {
                                $(this).html('').show();
                            });
                        }, 4000);

                        // Reload only on success
                        if (response.status === "success") {
                            setTimeout(function () {
                                location.reload();
                            }, 1200);
                        }

                    },

                    error: function () {

                        $('#deleteItemModal').modal('hide');

                        $('#inventory_message').html(`
                <div class="alert alert-danger">
                    Something went wrong while deleting the item.
                </div>
            `);

                    },

                    complete: function () {
                        $("#deletebutton")
                            .prop("disabled", false)
                            .val("Confirmed");
                    }

                });

            });

            $('#addCategoryForm').on('submit', function (event) {
                event.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: config.developmentPath + "/Admin/Controller/item_categorycontroller.php/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        let json;

                        try {
                            json = typeof res === "string" ? JSON.parse(res) : res;
                        } catch (e) {
                            console.log("Invalid JSON:", res);
                            $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                            return;
                        }

                        if (json.status === "success") {

                            // ✅ Success Message (same style as brand form)
                            $('#form_message').html(
                                '<div class="alert alert-success">Category added successfully!</div>'
                            );

                            // Small delay to let user read the message
                            setTimeout(() => {
                                // Close modal
                                $('#itemcatModal').modal('hide');

                                // Remove ghost backdrop (Bootstrap bug fix)
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open');

                                // Reload categories inside item modal
                                reloadCategoryList(() => {
                                    $('#itemCategory').val(json.newCategoryId);
                                });

                                // Reopen the Item Modal
                                setTimeout(() => {
                                    $('#itemdetailsModal').modal('show');
                                }, 200);

                                // Reset category form
                                $('#addCategoryForm')[0].reset();

                            }, 600);
                        } else {
                            $('#form_message').html(
                                `<div class="alert alert-danger">${json.message || 'Error adding category.'}</div>`
                            );
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    }
                });
            });

            $('#subCategoryForm').on('submit', function (event) {
                event.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function (res) {
                        let json;

                        try {
                            json = typeof res === "string" ? JSON.parse(res) : res;
                        } catch (e) {
                            console.log("Invalid JSON:", res);
                            $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                            return;
                        }

                        if (json.status === "success") {

                            // SUCCESS MESSAGE
                            $('#form_message').html(
                                '<div class="alert alert-success">SubCategory added successfully!</div>'
                            );

                            setTimeout(() => {
                                // Close modal
                                $('#itemsubcatModal').modal('hide');

                                // Remove backdrop
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open');

                                // Reset form fields
                                $('#user_form')[0].reset();

                                // Reload table (if required)
                                // dataTable.ajax.reload();

                            }, 600);

                        } else {
                            $('#form_message').html(
                                `<div class="alert alert-danger">${json.message || 'Error adding subcategory.'}</div>`
                            );
                        }
                    },

                    error: function (xhr, status, error) {
                        $('#form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    }
                });

            });


            // $('#subCategoryForm').submit(function (event) {
            //     var formData = new FormData(this);
            //     $.ajax({
            //         type: "POST",
            //         url: config.developmentPath +
            //             "/Admin/Controller/item_subcategorycontroller.php/",
            //         data: formData,
            //         processData: false,
            //         contentType: false
            //     }).done(function (data) {
            //         console.log(data);
            //     });
            //     reloadSubCategoryList();
            //     $('#itemsubcatModal').hide();
            // });

            function reloadCategoryList(callback = null) {
                $('#itemCategory').empty();

                $.getJSON(config.developmentPath + "/Admin/Controller/item_categorycontroller.php", function (data) {
                    $('#itemCategory').append('<option hidden disabled selected value>-- select an option --</option>');

                    $.each(data, function (index, value) {
                        $('#itemCategory').append(`<option value="${value.itemcatid}">${value.itemcatname}</option>`);
                    });

                    if (callback) callback();
                });
            }


            function reloadSubCategoryList() {
                var selectedCategory = $('#itemCategory').val();
                fetchcompany = config.developmentPath +
                    "/Admin/Controller/item_compdetailscontroller.php/?catId=" + selectedCategory;

                $('#subCategory').empty();
                $.getJSON(fetchsubcaturl, function (data) {
                    $.each(data, function (index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.

                        $('#subCategory').append('<option value="' + value.itemsubcatid + '">' +
                            value.itemsubcatname + '</option>');
                    });
                });
            }
            // ✅ Refresh Brand Dropdown after adding new brand
            // $('#brand_form').on('submit', function (event) {
            //     event.preventDefault();
            //     var formData = new FormData(this);
            //     $.ajax({
            //         type: "POST",
            //         url: config.developmentPath + "/Admin/Controller/brandcontroller.php/",
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         success: function (res) {
            //             try {
            //                 const json = typeof res === "string" ? JSON.parse(res) : res;
            //                 if (json.status === "success") {
            //                     // Hide modal
            //                     $('#brandModal').modal('hide');

            //                     // Refresh Brand list
            //                     reloadBrandList();
            //                 }
            //             } catch (e) {
            //                 console.log("Unexpected response:", res);
            //             }
            //         }
            //     });
            // });

            // ✅ Function to reload brand list
            function reloadBrandListSimple() {

                const InputType = 1;   // 🔥 Confirm: 1 = Item in your inputtype table

                $('#company')
                    .empty()
                    .append('<option hidden disabled selected value>-- select brand --</option>');

                const fetchcompany =
                    config.developmentPath +
                    "/Admin/Controller/brandcontroller.php?InputId=" + InputType;

                $.getJSON(fetchcompany, function (data) {

                    if (!data || data.length === 0) {
                        alert("No brands mapped to Item.");
                        return;
                    }

                    $.each(data, function (index, value) {
                        $('#company').append(
                            `<option value="${value.brandid}">
                    ${value.brandname}
                </option>`
                        );
                    });
                });
            }
            /* =========================================================
   INVENTORY MODAL DRAG SYSTEM
   Mouse + Touch + Pen
   No jQuery UI required
   ========================================================= */

            (function () {

                const modalSelectors = [
                    '#itemdetailsModal',
                    '#edititemdetailsModal',
                    '#detailsItemModal',
                    '#deleteItemModal',
                    '#itemcatModal',
                    '#itemsubcatModal',
                    '#brandModal'
                ];

                let activeDrag = null;


                function isInteractiveElement(target) {

                    return $(target).closest(
                        'button, input, select, textarea, a, option, label'
                    ).length > 0;

                }


                function clamp(value, min, max) {

                    return Math.min(Math.max(value, min), max);

                }


                function centerDialog(dialog) {

                    const rect = dialog.getBoundingClientRect();

                    const viewportWidth = window.innerWidth;
                    const viewportHeight = window.innerHeight;

                    const width = dialog.offsetWidth;
                    const height = dialog.offsetHeight;

                    let left = (viewportWidth - width) / 2;
                    let top = (viewportHeight - height) / 2;

                    /*
                     * Always keep modal inside viewport.
                     */
                    left = clamp(
                        left,
                        0,
                        Math.max(0, viewportWidth - width)
                    );

                    top = clamp(
                        top,
                        0,
                        Math.max(0, viewportHeight - height)
                    );

                    dialog.style.position = 'fixed';
                    dialog.style.margin = '0';
                    dialog.style.transform = 'none';

                    dialog.style.left = left + 'px';
                    dialog.style.top = top + 'px';

                }


                function keepInsideViewport(dialog) {

                    const viewportWidth = window.innerWidth;
                    const viewportHeight = window.innerHeight;

                    const width = dialog.offsetWidth;
                    const height = dialog.offsetHeight;

                    let left = parseFloat(dialog.style.left);

                    let top = parseFloat(dialog.style.top);

                    if (isNaN(left)) {
                        left = (viewportWidth - width) / 2;
                    }

                    if (isNaN(top)) {
                        top = (viewportHeight - height) / 2;
                    }

                    left = clamp(
                        left,
                        0,
                        Math.max(0, viewportWidth - width)
                    );

                    top = clamp(
                        top,
                        0,
                        Math.max(0, viewportHeight - height)
                    );

                    dialog.style.left = left + 'px';
                    dialog.style.top = top + 'px';

                }


                function setupModalDrag(modal) {

                    const dialog = modal.querySelector('.modal-dialog');

                    const header = modal.querySelector('.modal-header');

                    if (!dialog || !header) {
                        return;
                    }


                    /*
                     * Prevent duplicate event registration.
                     */
                    if (dialog.dataset.inventoryDragReady === '1') {
                        centerDialog(dialog);
                        return;
                    }

                    dialog.dataset.inventoryDragReady = '1';


                    header.addEventListener('pointerdown', function (event) {

                        /*
                         * Do not drag when clicking controls.
                         */
                        if (isInteractiveElement(event.target)) {
                            return;
                        }

                        /*
                         * Only primary mouse button.
                         */
                        if (
                            event.pointerType === 'mouse' &&
                            event.button !== 0
                        ) {
                            return;
                        }

                        const rect = dialog.getBoundingClientRect();

                        /*
                         * Convert Bootstrap dialog positioning
                         * into fixed viewport positioning.
                         */
                        dialog.style.position = 'fixed';
                        dialog.style.margin = '0';
                        dialog.style.transform = 'none';

                        dialog.style.left = rect.left + 'px';
                        dialog.style.top = rect.top + 'px';


                        activeDrag = {

                            dialog: dialog,

                            pointerId: event.pointerId,

                            startX: event.clientX,
                            startY: event.clientY,

                            startLeft: rect.left,
                            startTop: rect.top

                        };


                        try {

                            header.setPointerCapture(
                                event.pointerId
                            );

                        } catch (error) {
                            // Ignore pointer capture errors.
                        }


                        header.style.cursor = 'grabbing';

                        event.preventDefault();

                    });


                    header.addEventListener('pointermove', function (event) {

                        if (!activeDrag) {
                            return;
                        }

                        if (
                            activeDrag.pointerId !==
                            event.pointerId
                        ) {
                            return;
                        }


                        const dialog = activeDrag.dialog;

                        const deltaX =
                            event.clientX -
                            activeDrag.startX;

                        const deltaY =
                            event.clientY -
                            activeDrag.startY;


                        const viewportWidth =
                            window.innerWidth;

                        const viewportHeight =
                            window.innerHeight;


                        const dialogWidth =
                            dialog.offsetWidth;

                        const dialogHeight =
                            dialog.offsetHeight;


                        const maxLeft =
                            Math.max(
                                0,
                                viewportWidth - dialogWidth
                            );

                        const maxTop =
                            Math.max(
                                0,
                                viewportHeight - dialogHeight
                            );


                        const newLeft = clamp(

                            activeDrag.startLeft + deltaX,

                            0,

                            maxLeft

                        );


                        const newTop = clamp(

                            activeDrag.startTop + deltaY,

                            0,

                            maxTop

                        );


                        dialog.style.left =
                            newLeft + 'px';

                        dialog.style.top =
                            newTop + 'px';


                        event.preventDefault();

                    });


                    function stopDrag(event) {

                        if (!activeDrag) {
                            return;
                        }

                        if (
                            event &&
                            activeDrag.pointerId !==
                            event.pointerId
                        ) {
                            return;
                        }


                        try {

                            if (
                                event &&
                                header.hasPointerCapture(
                                    event.pointerId
                                )
                            ) {

                                header.releasePointerCapture(
                                    event.pointerId
                                );

                            }

                        } catch (error) {
                            // Ignore pointer release errors.
                        }


                        header.style.cursor = 'grab';

                        activeDrag = null;

                    }


                    header.addEventListener(
                        'pointerup',
                        stopDrag
                    );

                    header.addEventListener(
                        'pointercancel',
                        stopDrag
                    );

                }


                /*
                 * Initialize when Bootstrap finishes opening.
                 */
                $(document).on(
                    'shown.bs.modal',
                    modalSelectors.join(','),
                    function () {

                        const dialog =
                            this.querySelector('.modal-dialog');

                        if (!dialog) {
                            return;
                        }

                        /*
                         * Bootstrap's centered transform is removed
                         * only after the modal is visible.
                         */
                        dialog.style.position = 'fixed';
                        dialog.style.margin = '0';
                        dialog.style.transform = 'none';

                        centerDialog(dialog);

                        setupModalDrag(this);

                    }
                );


                /*
                 * Keep currently open modal inside viewport
                 * when screen size/orientation changes.
                 */
                $(window).on(
                    'resize orientationchange',
                    function () {

                        $(modalSelectors.join(','))
                            .filter('.show')
                            .each(function () {

                                const dialog =
                                    this.querySelector(
                                        '.modal-dialog'
                                    );

                                if (!dialog) {
                                    return;
                                }

                                keepInsideViewport(dialog);

                            });

                    }
                );


                /*
                 * Clean up drag position when modal closes.
                 *
                 * This is important because the next opening should
                 * start centered again.
                 */
                $(document).on(
                    'hidden.bs.modal',
                    modalSelectors.join(','),
                    function () {

                        const dialog =
                            this.querySelector('.modal-dialog');

                        if (!dialog) {
                            return;
                        }

                        dialog.style.position = '';
                        dialog.style.left = '';
                        dialog.style.top = '';
                        dialog.style.margin = '';
                        dialog.style.transform = '';

                    }
                );

            })();


        });
    </script>