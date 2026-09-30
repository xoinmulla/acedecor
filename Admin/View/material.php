<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('materialListNavigation.php');
require_once("../DB Operations/materialOps.php");
require_once("../DB Operations/item_categoryOps.php");
require_once("../DB Operations/item_subcategoryOps.php");
require_once("../Model/materialModel.php");

if (!hasActionPermission('inventory', 'material')) {
    header("Location: noaccess.php");
    exit;
}
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<style>
    .card-body #item_table th {
        font-weight: 500;
    }

    /* Edit Material Modal Styles */
    #edititemdetailsModal .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    /* Cards */
    #edititemdetailsModal .card {
        border: none;
        border-radius: 10px;
        transition: box-shadow 0.3s ease;
    }

    #edititemdetailsModal .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }

    #edititemdetailsModal .card-header {
        border-radius: 10px 10px 0 0 !important;
        font-weight: 600;
    }

    /* Form Controls */
    #edititemdetailsModal .form-control,
    #edititemdetailsModal .form-select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    #edititemdetailsModal .form-control:focus,
    #edititemdetailsModal .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    #edititemdetailsModal .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
        color: #495057;
    }

    /* Input Group */
    #edititemdetailsModal .input-group-text {
        background: #f1f3f5;
        border: 1px solid #ced4da;
        border-radius: 8px 0 0 8px;
        font-weight: 500;
    }

    #edititemdetailsModal .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    /* Buttons */
    #edititemdetailsModal .btn-outline-primary {
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        border-color: #667eea;
        color: #667eea;
    }

    #edititemdetailsModal .btn-outline-primary:hover {
        background: #667eea;
        color: white;
    }

    #edititemdetailsModal .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 8px;
        padding: 8px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #edititemdetailsModal .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(56, 239, 125, 0.4);
    }

    #edititemdetailsModal .btn-success:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    #edititemdetailsModal .btn-secondary {
        border-radius: 8px;
        padding: 8px 25px;
    }

    /* Image Preview */
    #editedPreviewImage {
        transition: transform 0.3s ease;
        background: white;
    }

    #editedPreviewImage:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Scrollbar */
    #edititemdetailsModal .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    #edititemdetailsModal .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #edititemdetailsModal .modal-body::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    /* Draggable Handle */
    #edititemdetailsModal .modal-header {
        cursor: grab;
        padding: 15px 20px;
    }

    #edititemdetailsModal .modal-header:active {
        cursor: grabbing;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #edititemdetailsModal .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Alert Messages */
    #edititemdetailsModal .alert {
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        margin-bottom: 20px;
        animation: slideDown 0.3s ease;
    }

    #edititemdetailsModal .alert-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #155724;
        font-weight: 500;
    }

    #edititemdetailsModal .alert-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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

    #edititemdetailsModal .btn-success:focus {
        animation: glow 1.5s ease-in-out infinite;
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

    /* Brand Modal Styles */
    #brandModal .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    /* Header */
    #brandModal .modal-header {
        border-bottom: none;
        padding: 18px 25px;
    }

    #brandModal .modal-header .close {
        opacity: 0.8;
        text-shadow: none;
        font-size: 28px;
        transition: transform 0.3s ease;
    }

    #brandModal .modal-header .close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    /* Form Controls */
    #brandModal .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 10px 15px;
        font-size: 0.95rem;
    }

    #brandModal .form-control:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
    }

    #brandModal .form-label {
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        color: #2d3436;
        font-weight: 600;
    }

    /* Input Group */
    #brandModal .input-group-text {
        background: #f1f3f5;
        border: 2px solid #e9ecef;
        border-right: none;
        border-radius: 8px 0 0 8px;
        color: #4facfe;
    }

    #brandModal .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    #brandModal .input-group .form-control:focus {
        border-left: none;
    }

    /* Dropdown */
    #brandModal .dropdown-toggle {
        transition: all 0.3s ease;
    }

    #brandModal .dropdown-toggle:hover {
        border-color: #4facfe;
    }

    #brandModal .dropdown-menu {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
        margin-top: 5px;
    }

    #brandModal .dropdown-menu .form-check {
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s ease;
        margin: 2px 0;
    }

    #brandModal .dropdown-menu .form-check:hover {
        background: #f8f9fa;
    }

    #brandModal .dropdown-menu .form-check-input {
        cursor: pointer;
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
    }

    #brandModal .dropdown-menu .form-check-input:checked {
        background-color: #4facfe;
        border-color: #4facfe;
    }

    #brandModal .dropdown-menu .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #2d3436;
        padding-left: 5px;
    }

    /* Type Tags */
    .type-tag {
        animation: fadeIn 0.3s ease;
    }

    .type-tag .remove-type-tag:hover {
        opacity: 1 !important;
        transform: scale(1.2);
    }

    /* Dropdown button when types are selected */
    #inputTypeDropdown.btn-primary {
        color: white !important;
    }

    #inputTypeDropdown.btn-primary .badge {
        background: white !important;
        color: #4facfe !important;
    }

    /* Buttons */
    #brandModal .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #brandModal .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(56, 239, 125, 0.4);
    }

    #brandModal .btn-success:active {
        transform: translateY(0px);
    }

    #brandModal .btn-success:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    #brandModal .btn-secondary {
        border-radius: 8px;
        padding: 10px 25px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    #brandModal .btn-secondary:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Badge */
    #brandModal .badge {
        font-size: 0.75rem;
        padding: 5px 10px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    #brandModal .badge-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

    /* Alert Messages */
    #brandModal .alert {
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        margin-bottom: 20px;
        animation: slideDown 0.3s ease;
    }

    #brandModal .alert-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #155724;
        font-weight: 500;
    }

    #brandModal .alert-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        font-weight: 500;
    }

    /* =========================================================
   MATERIAL PAGE MODAL SIZING
   ========================================================= */

    .modal-dialog {
        max-width: 1200px;
        width: 65%;
    }

    /* Delete modal keeps its compact size */
    #deleteMaterialModal .modal-dialog {
        max-width: 420px !important;
        width: 100%;
    }


    /* =========================================================
   TABLET
   ========================================================= */

    @media (max-width: 991.98px) {

        #itemdetailsModal .modal-dialog,
        #edititemdetailsModal .modal-dialog,
        #detailsItemModal .modal-dialog {

            width: calc(100% - 24px);
            max-width: none;

        }

    }


    /* =========================================================
   MOBILE
   ========================================================= */

    @media (max-width: 767.98px) {

        #itemdetailsModal .modal-dialog,
        #edititemdetailsModal .modal-dialog,
        #detailsItemModal .modal-dialog {

            width: calc(100% - 16px);
            max-width: none;

        }

        #deleteMaterialModal .modal-dialog,
        #itemcatModal .modal-dialog,
        #itemsubcatModal .modal-dialog,
        #brandModal .modal-dialog {

            width: calc(100% - 20px);
            max-width: none !important;

        }

    }

    /* Responsive */
    @media (max-width: 576px) {
        #brandModal .modal-dialog {
            margin: 10px;
        }

        #brandModal .modal-body {
            padding: 15px !important;
        }

        #brandModal .btn-success,
        #brandModal .btn-secondary {
            width: 100%;
            margin-bottom: 5px;
        }
    }

    /* Material Brand Tags */
    .material-brand-tag {
        animation: fadeIn 0.3s ease;
    }

    .material-brand-tag .remove-material-brand-tag:hover {
        opacity: 1 !important;
        transform: scale(1.2);
    }

    /* Material Checkbox Styles */
    #materialCheckboxes .form-check {
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s ease;
        margin: 2px 0;
    }

    #materialCheckboxes .form-check:hover {
        background: #f8f9fa;
    }

    #materialCheckboxes .form-check-input {
        cursor: pointer;
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
    }

    #materialCheckboxes .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    #materialCheckboxes .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #2d3436;
        padding-left: 5px;
    }

    /* Dropdown button when brands are selected */
    #materialBrandDropdown.btn-primary {
        color: white !important;
    }

    #materialBrandDropdown.btn-primary .badge {
        background: white !important;
        color: #667eea !important;
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

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .row.g-2 {
            flex-direction: column;
        }

        .col-md-9,
        .col-md-3 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-md-3 .btn {
            margin-top: 5px;
        }
    }

    /* Modal Polish */
    .modal-content-modern {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }

    .modal-header-modern {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem;
    }

    /* Image Box */
    .product-img-frame {
        background-color: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 10px;
    }

    .product-img-frame img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    /* Info Cards */
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

    /* Card Colors */
    .card-highlight {
        border-left-color: #1cc88a;
        background-color: #f0fdf4;
    }

    /* Green/Money */
    .card-spec {
        border-left-color: #4e73df;
    }

    /* Blue/Specs */
    .card-warn {
        border-left-color: #f6c23e;
    }

    /* Yellow/Units */

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
        font-size: 1.4rem;
        color: #1cc88a;
    }

    /* Modern Table */
    .table-modern thead th {
        background-color: #eaecf4;
        color: #4e73df;
        font-size: 0.8rem;
        text-transform: uppercase;
        border: none;
    }
</style>
<!-- Enhanced CSS -->
<style>
    /* =========================================================
   DRAGGABLE MODAL HEADER
   ========================================================= */

#itemdetailsModal .modal-header,
#edititemdetailsModal .modal-header,
#detailsItemModal .modal-header,
#deleteMaterialModal .modal-header,
#itemcatModal .modal-header,
#itemsubcatModal .modal-header,
#brandModal .modal-header {

    cursor: grab;
    user-select: none;
    -webkit-user-select: none;
    touch-action: none;

}


#itemdetailsModal .modal-header:active,
#edititemdetailsModal .modal-header:active,
#detailsItemModal .modal-header:active,
#deleteMaterialModal .modal-header:active,
#itemcatModal .modal-header:active,
#itemsubcatModal .modal-header:active,
#brandModal .modal-header:active {

    cursor: grabbing;

}
    /* =========================================================
   MATERIAL LIST TABLE RESPONSIVENESS
   ========================================================= */

    #item_table_wrapper {

        width: 100% !important;
        max-width: 100% !important;

    }


    /* Keep horizontal scrolling inside the table area */
    #item_table_wrapper .dataTables_scroll,
    #item_table_wrapper .dataTables_scrollBody {

        max-width: 100%;
        overflow-x: auto !important;

    }


    /* Prevent the whole page from becoming horizontally scrollable */
    #item_table_wrapper {

        overflow-x: auto;
        overflow-y: hidden;

    }


    /* Table minimum width */
    #item_table {

        width: 100% !important;
        min-width: 850px;

    }


    /* Don't allow table text to destroy column sizing */
    #item_table th,
    #item_table td {

        white-space: nowrap;

    }


    /* Mobile */
    @media (max-width: 767.98px) {

        #item_table {

            min-width: 850px;

        }

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
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
        border-color: #667eea;
        color: #667eea;
    }

    .btn-outline-primary:hover {
        background: #667eea;
        color: white;
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

    /* Modal Body Scrollbar */
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

    /* =========================================================
   RESPONSIVE MODAL CONTENT
   ========================================================= */

    #itemdetailsModal .modal-content,
    #edititemdetailsModal .modal-content,
    #detailsItemModal .modal-content,
    #deleteMaterialModal .modal-content,
    #itemcatModal .modal-content,
    #itemsubcatModal .modal-content,
    #brandModal .modal-content {

        max-height: calc(100vh - 24px);

    }


    /* Large Add/Edit modals */
    #itemdetailsModal .modal-body,
    #edititemdetailsModal .modal-body,
    #detailsItemModal .modal-body {

        overflow-y: auto;
        overflow-x: hidden;

        max-height: calc(100vh - 150px);

    }


    /* Small modals */
    #deleteMaterialModal .modal-body,
    #itemcatModal .modal-body,
    #itemsubcatModal .modal-body,
    #brandModal .modal-body {

        overflow-y: auto;
        max-height: calc(100vh - 150px);

    }


    /* =========================================================
   RESPONSIVE FORM GRID
   ========================================================= */

    @media (max-width: 767.98px) {

        #itemdetailsModal .modal-body,
        #edititemdetailsModal .modal-body,
        #detailsItemModal .modal-body {

            padding: 15px !important;

        }

        #itemdetailsModal .row.g-3>[class*="col-"],
        #edititemdetailsModal .row.g-3>[class*="col-"] {

            width: 100%;
            flex: 0 0 100%;
            max-width: 100%;

        }

        #itemdetailsModal .row.g-2>[class*="col-"],
        #edititemdetailsModal .row.g-2>[class*="col-"] {

            margin-bottom: 10px;

        }

        #itemdetailsModal .modal-footer,
        #edititemdetailsModal .modal-footer {

            flex-wrap: wrap;
            gap: 8px;

        }

    }


    /* =========================================================
   VERY SMALL DEVICES
   ========================================================= */

    @media (max-width: 400px) {

        #itemdetailsModal .modal-body,
        #edititemdetailsModal .modal-body,
        #detailsItemModal .modal-body {

            padding: 12px !important;

        }

        #itemdetailsModal .modal-header,
        #edititemdetailsModal .modal-header,
        #detailsItemModal .modal-header {

            padding: 12px 15px !important;

        }

    }
</style>
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Material
                    List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle="modal" data-target="#itemdetailsModal">
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered" id="item_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th style="display:none">Material Id</th>
                        <th>Material Name</th>
                        <th>Thickness</th>
                        <th>Description</th>
                        <th style="display:none">Category Id</th>
                        <th>Category</th>
                        <th style="display:none">SubCategory Id</th>
                        <th>Subcategory</th>
                        <th style="display:none">Brand Id</th>
                        <th>Brand</th>

                        <th style="display:none">Image</th>
                        <th style="display:none">Unit</th>
                        <th style="display:none">UnitFactor</th>
                        <th style="display:none">Material Code</th>
                        <th style="display:none">HSN Code</th>
                        <th style="display:none">SPU</th>
                        <th style="display:none">Qty</th>
                        <th style="display:none">MRP</th>
                        <th style="display:none">PP MRP</th>
                        <th style="display:none">GST</th>
                        <th style="display:none">Total MRP</th>
                        <th style="display:none">Unit ID</th>
                        <th style="display:none">Discount</th>
                        <th style="display:none">Price</th>
                        <th style="display:none">Total Value</th>

                        <th>Inwarded Qty</th>
                        <th>Allocated Qty</th>
                        <th>Available Qty</th>

                        <th style="display:none">Thickness ID</th>
                        <th style="display:none">Grains ID</th>

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $materialdetailslist = DBmaterialdetails::getallMaterialdetails();

                    foreach ($materialdetailslist as $material) {

                        $id = $material->get_MaterialId();

                        // 🔐 DELETE BUTTON LOGIC
                        if ($material->getCanDelete()) {
                            $deleteAction = "
<button type='button' class='dropdown-item'
    data-toggle='modal'
    data-target='#deleteMaterialModal'
    data-id='{$id}'>
    Delete Material
</button>";

                        } else {
                            $deleteAction = "
            <button class='dropdown-item text-muted' disabled
                title='Material is used in Quotation or Purchase Order'>
                Cannot Delete
            </button>";
                        }

                        echo "
    <tr>
        <td style='display:none'>{$id}</td>
        <td>{$material->get_MaterialName()}</td>
        <td>{$material->get_MaterialThickness()}</td>
        <td>{$material->get_MaterialDescription()}</td>

        <td style='display:none'>{$material->get_Category()}</td>
        <td>{$material->get_CategoryName()}</td>

        <td style='display:none'>{$material->get_SubCategory()}</td>
        <td>{$material->get_SubCategoryName()}</td>

        <td style='display:none'>{$material->get_Brand()}</td>
        <td>{$material->get_BrandName()}</td>

        <td style='display:none'>{$material->get_MaterialImage()}</td>
        <td style='display:none'>{$material->get_MaterialUnit()}</td>
        <td style='display:none'>{$material->get_MaterialUnitFactorId()}</td>

        <td style='display:none'>{$material->get_MaterialCode()}</td>
        <td style='display:none'>{$material->get_MaterialHSNcode()}</td>
        <td style='display:none'>{$material->get_MaterialSPU()}</td>
        <td style='display:none'>{$material->get_MaterialQty()}</td>
        <td style='display:none'>{$material->get_MaterialMRP()}</td>
        <td style='display:none'>{$material->get_MaterialPPMRP()}</td>
        <td style='display:none'>{$material->get_MaterialGST()}</td>
        <td style='display:none'>{$material->get_MaterialTotalMRP()}</td>
        <td style='display:none'>{$material->get_MaterialUnitId()}</td>
        <td style='display:none'>{$material->get_MaterialDiscount()}</td>
        <td style='display:none'>{$material->get_MaterialPrice()}</td>
        <td style='display:none'>{$material->get_MaterialTotalValue()}</td>

        <td>{$material->get_ReceivedQty()}</td>
        <td>{$material->getAllocatedQty()}</td>
        <td>{$material->getAvailableQty()}</td>

        <td style='display:none'>{$material->get_MaterialThicknessID()}</td>
        <td style='display:none'>{$material->get_MaterialGrainsId()}</td>

        <td>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle'
                    type='button' data-toggle='dropdown'>
                    Actions
                </button>
                <div class='dropdown-menu'>

                    <button class='dropdown-item'
                        data-toggle='modal'
                        data-target='#detailsItemModal'
                        data-id='{$id}'>
                        Material Info
                    </button>

                   <button class='dropdown-item'
                       data-toggle='modal'
                       data-target='#edititemdetailsModal'

    data-id='" . $material->get_MaterialId() . "'
    data-name='" . htmlspecialchars($material->get_MaterialName()) . "'
    data-desc='" . htmlspecialchars($material->get_MaterialDescription()) . "'

    data-cat='" . $material->get_Category() . "'
    data-subcat='" . $material->get_SubCategory() . "'
    data-brand='" . $material->get_Brand() . "'

    data-unit='" . $material->get_MaterialUnitId() . "'
    data-factor='" . $material->get_MaterialUnitFactorId() . "'

    data-code='" . $material->get_MaterialCode() . "'
    data-hsn='" . $material->get_MaterialHSNcode() . "'

    data-qty='" . $material->get_MaterialQty() . "'
    data-spu='" . $material->get_MaterialSPU() . "'
    data-mrp='" . $material->get_MaterialMRP() . "'
    data-gst='" . $material->get_MaterialGST() . "'
    data-discount='" . $material->get_MaterialDiscount() . "'

    data-price='" . $material->get_MaterialPrice() . "'
    data-total='" . $material->get_MaterialTotalValue() . "'

    data-thickness='" . $material->get_MaterialThicknessID() . "'
    data-grains='" . $material->get_MaterialGrainsId() . "'

    data-image='" . $material->get_MaterialImage() . "'>
    Edit Material
</button>


                    {$deleteAction}

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

<?php include('footer.php'); ?>

<div class="modal fade" id="itemdetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form method="post" id="itemdetails_form" enctype="multipart/form-data">
            <input type="hidden" name="from_modal" value="1">
            <div class="modal-content">
                <!-- Modern Header with Gradient -->
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title text-white">
                        <i class="fas fa-cubes me-2"></i>Add Material
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
                                <div class="card-header" style="background: #f1f3f5; border-bottom: 2px solid #667eea;">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Material Details</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Material Name -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Material Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="materialname" id="materialname" class="form-control"
                                            required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                            data-parsley-trigger="keyup" placeholder="Enter material name" />
                                        <input type="hidden" id="itemcatid" name="itemcatid" value="">
                                        <input type="hidden" id="itemsubcatid" name="itemsubcatid" value="">
                                        <input type="hidden" id="itemcompid" name="itemcompid" value="">
                                    </div>

                                    <!-- Brand -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Brand <span
                                                class="text-danger">*</span></label>
                                        <select id="company" class="form-select" required name="company">
                                            <option hidden disabled selected value>-- select brand --</option>
                                        </select>
                                    </div>

                                    <!-- Category & Subcategory Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold">Category <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <select id="materialCategory" class="form-select me-2" required
                                                    name="materialCategory" style="flex:1;">
                                                    <option hidden disabled selected value>-- select category --
                                                    </option>
                                                </select>
                                                <a class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#itemcatModal">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label fw-bold">Subcategory <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <select id="materialsubCategory" class="form-select me-2" required
                                                    name="materialsubCategory" style="flex:1;">
                                                    <option hidden disabled selected value>-- select subcategory --
                                                    </option>
                                                </select>
                                                <a class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#itemsubcatModal">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="materialdescription" id="materialdescription"
                                            class="form-control" required rows="2"
                                            placeholder="Enter material description"></textarea>
                                    </div>

                                    <!-- Codes Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Material Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="materialCode" id="materialCode"
                                                class="form-control" required data-parsley-minlength="6"
                                                data-parsley-maxlength="16" data-parsley-trigger="keyup"
                                                placeholder="Enter code" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">HSN Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="materialhsncode" id="materialhsncode"
                                                class="form-control" data-parsley-maxlength="150"
                                                data-parsley-trigger="keyup" placeholder="Enter HSN code" />
                                        </div>
                                    </div>

                                    <!-- Quantity & Unit Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="materialQty" id="materialQty" class="form-control"
                                                required data-parsley-trigger="change" placeholder="Enter qty" />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Unit <span
                                                    class="text-danger">*</span></label>
                                            <select id="materialunit" class="form-select" required name="materialunit">
                                                <option hidden disabled selected value>-- select unit --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Factor <span
                                                    class="text-danger">*</span></label>
                                            <select id="materialunitFactor" class="form-select" required
                                                name="materialunitFactor">
                                                <option hidden disabled selected value>-- select factor --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Thickness & Grains Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Thickness <span
                                                    class="text-danger">*</span></label>
                                            <select id="thickness" class="form-select" required name="thickness">
                                                <option hidden disabled selected value>-- select thickness --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Grains <span
                                                    class="text-danger">*</span></label>
                                            <select id="materialGrains" class="form-select" required
                                                name="materialGrains">
                                                <option hidden disabled selected value>-- select grains --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- SPU -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <span title="Standard Packing Unit">SPU</span>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="materialSPU" id="materialSPU" class="form-control"
                                            required data-parsley-minlength="1" data-parsley-maxlength="16"
                                            data-parsley-trigger="keyup" placeholder="Enter SPU" />
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Material Image <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="materialimage" id="materialimage" class="form-control"
                                            accept="image/*" style="padding: 8px;" />
                                        <small class="text-muted">Upload material image (JPG, PNG, GIF)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN - Financial & Pricing -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-3">
                                <div class="card-header" style="background: #f1f3f5; border-bottom: 2px solid #764ba2;">
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
                                                <input type="text" name="materialMRP" id="materialMRP"
                                                    class="form-control" required data-parsley-minlength="1"
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
                                                <input type="text" name="materialGST" id="materialGST"
                                                    class="form-control" required placeholder="0" />
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Discount -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Company Discount (%)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="materialDiscount"
                                                id="materialDiscount" class="form-control" placeholder="0.00" />
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <!-- Calculated Values -->
                                    <div class="bg-light p-3 rounded-3 mb-3" style="background: #f8f9fa !important;">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Amount <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="materialAmount" id="materialAmount"
                                                        class="form-control" required readonly
                                                        style="background: #e9ecef; font-weight: bold;" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Price <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="materialPrice" id="materialPrice"
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
                                                <input type="text" name="materialTotalValue" id="materialTotalValue"
                                                    class="form-control" required readonly
                                                    style="background: #e9ecef; font-weight: bold; color: #764ba2;" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="materialcreatedby" id="materialcreatedby"
                                        class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                    <input type="hidden" name="materialmodifiedby" id="materialmodifiedby"
                                        class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Indicator -->
                    <div id="item_form_message" class="mt-3"></div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer"
                    style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 8px 8px;">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">
                        </i>Close
                    </button>
                    <button type="submit" name="submit" id="submit_button" class="btn btn-success">
                        </i>Add Material
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="edititemdetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form method="post" id="editeditemdetails_form" enctype="multipart/form-data"
            action="../Controller/materialController.php">
            <div class="modal-content">
                <!-- Modern Header with Gradient -->
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title text-white">
                        <i class="fas fa-edit me-2"></i>Edit Material Information
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="background: #f8f9fa; padding: 25px;">
                    <span id="edit_form_message"></span>

                    <!-- Two Column Grid Layout -->
                    <div class="row g-3">
                        <!-- LEFT COLUMN - Material Details -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-3">
                                <div class="card-header" style="background: #f1f3f5; border-bottom: 2px solid #667eea;">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Material Details</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Material Name -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Material Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="editedmaterialname" id="editedmaterialname"
                                            class="form-control" required placeholder="Enter material name" />
                                        <input type="hidden" name="materialid" id="materialid" />
                                    </div>

                                    <!-- Brand -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Brand <span
                                                class="text-danger">*</span></label>
                                        <select id="editedmaterialbrand" class="form-select" name="editedmaterialbrand">
                                            <option hidden disabled selected value>-- select brand --</option>
                                        </select>
                                    </div>

                                    <!-- Category & Subcategory Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold">Category <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <select id="editedmaterialCategory" class="form-select me-2"
                                                    name="editedmaterialCategory" style="flex:1;">
                                                    <option hidden disabled selected value>-- select category --
                                                    </option>
                                                </select>
                                                <a class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#itemcatModal">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label fw-bold">Subcategory <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <select id="editedsubCategory" class="form-select me-2"
                                                    name="editedsubCategory" style="flex:1;">
                                                    <option hidden disabled selected value>-- select subcategory --
                                                    </option>
                                                </select>
                                                <a class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#itemsubcatModal">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="editedmaterialdescription" id="editedmaterialdescription"
                                            class="form-control" required rows="2"
                                            placeholder="Enter material description"></textarea>
                                    </div>

                                    <!-- Codes Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Material Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="editedmaterialCode" id="editedmaterialCode"
                                                class="form-control" required placeholder="Enter code" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">HSN Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="editedmaterialhsncode" id="editedmaterialhsncode"
                                                class="form-control" placeholder="Enter HSN code" />
                                        </div>
                                    </div>

                                    <!-- Quantity & Unit Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="editedmaterialQty" id="editedmaterialQty"
                                                class="form-control" required placeholder="Enter qty" />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Unit <span
                                                    class="text-danger">*</span></label>
                                            <select id="editedunit" class="form-select" name="editedunit">
                                                <option hidden disabled selected value>-- select unit --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Factor <span
                                                    class="text-danger">*</span></label>
                                            <select id="editedunitFactor" class="form-select" name="editedunitFactor">
                                                <option hidden disabled selected value>-- select factor --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Thickness & Grains Side by Side -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Thickness <span
                                                    class="text-danger">*</span></label>
                                            <select id="editedthickness" class="form-select" name="editedthickness">
                                                <option hidden disabled selected value>-- select thickness --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Grains <span
                                                    class="text-danger">*</span></label>
                                            <select id="editedRotation" class="form-select" name="editedRotation">
                                                <option hidden disabled selected value>-- select grains --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- SPU -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <span title="Standard Packing Unit">SPU</span>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="editedmaterialSPU" id="editedmaterialSPU"
                                            class="form-control" required placeholder="Enter SPU" />
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Material Image</label>
                                        <input type="file" name="editedmaterialimage" id="editedmaterialimage"
                                            class="form-control" accept="image/*" style="padding: 8px;" />
                                        <small class="text-muted">Upload new image (JPG, PNG, GIF) - Leave blank to keep
                                            existing</small>
                                    </div>

                                    <!-- Image Preview -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Current Image</label>
                                        <div>
                                            <img id="editedPreviewImage" src="" alt="Material Image"
                                                style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 2px solid #e9ecef; padding: 5px;" />
                                            <small class="d-block text-muted mt-1">Current image preview</small>
                                        </div>
                                        <input type="hidden" name="existing_image" id="existing_image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN - Financial & Pricing -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-3">
                                <div class="card-header" style="background: #f1f3f5; border-bottom: 2px solid #764ba2;">
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
                                                <input type="text" name="editedmaterialMRP" id="editedmaterialMRP"
                                                    class="form-control" required placeholder="0.00" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">
                                                <span title="Goods and Service Tax">GST</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="editedmaterialGST" id="editedmaterialGST"
                                                    class="form-control" required placeholder="0" />
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Discount -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Company Discount (%)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="editedmaterialDiscount"
                                                id="editedmaterialDiscount" class="form-control" placeholder="0.00" />
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <!-- Calculated Values -->
                                    <div class="bg-light p-3 rounded-3 mb-3" style="background: #f8f9fa !important;">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Amount <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="editedmaterialAmount"
                                                        id="editedmaterialAmount" class="form-control" required readonly
                                                        style="background: #e9ecef; font-weight: bold;" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Price <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" name="editedmaterialPrice"
                                                        id="editedmaterialPrice" class="form-control" required readonly
                                                        style="background: #e9ecef; font-weight: bold;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label class="form-label fw-bold">Total Value <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">₹</span>
                                                <input type="text" name="editedmaterialTotalValue"
                                                    id="editedmaterialTotalValue" class="form-control" required readonly
                                                    style="background: #e9ecef; font-weight: bold; color: #764ba2;" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="materialcreatedby" id="editedmaterialcreatedby"
                                        class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                    <input type="hidden" name="materialmodifiedby" id="editedmaterialmodifiedby"
                                        class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer"
                    style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 8px 8px;">
                    <input type="hidden" name="hidden_id" id="edited_hidden_id" />
                    <input type="hidden" name="action" id="edit_action" value="Edit" />
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">
                        </i>Close
                    </button>
                    <button type="submit" name="edit_submit" id="editbutton" class="btn btn-success">
                        </i>Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="deleteMaterialModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" id="deleteMaterialModalDialog">
        <form method="POST" id="delete_material_form">
            <div class="modal-content">

                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title">Delete Material</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p class="lead">Are you sure you want to delete this Material?</p>

                    <!-- Correct ID -->
                    <input type="hidden" name="id" id="deleteMaterialId">

                    <!-- Required for delete -->
                    <input type="hidden" name="action" value="delete">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteMaterial">
                        Confirm
                    </button>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="itemcatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="addMaterialCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <!-- Modern Header with Gradient -->
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title text-white">
                        <i class="fas fa-folder-plus me-2"></i>Add Material Category
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
                            <input type="text" name="materialCatname" id="materialCatname" class="form-control" required
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
                            <textarea name="materialCatdescription" id="materialCatdescription" class="form-control"
                                required rows="2" placeholder="Enter category description"></textarea>
                        </div>
                    </div>

                    <!-- Brand Selection - Enhanced Dropdown -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Brands <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-md-9">
                                <div class="dropdown w-100">
                                    <button
                                        class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center dropdown-toggle"
                                        type="button" id="materialBrandDropdown" data-toggle="dropdown"
                                        aria-expanded="false"
                                        style="border-radius: 8px; padding: 10px 15px; border: 2px solid #e9ecef; background: white;">
                                        <span>
                                            <i class="fas fa-trademark me-2"></i>
                                            <span id="materialBrandDropdownText">Select Brands</span>
                                        </span>
                                        <span class="badge bg-primary rounded-pill"
                                            id="materialBrandSelectedCount">0</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 p-3" id="materialCheckboxes"
                                        style="max-height: 200px; overflow-y: auto; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                                        <!-- Dynamic checkboxes will be loaded here -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary w-100" data-toggle='modal'
                                    data-target='#brandModal'
                                    style="border-radius: 8px; padding: 10px 15px; white-space: nowrap; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none;">
                                    <i class="fas fa-plus-circle me-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Brands Display -->
                    <div id="materialSelectedBrandsDisplay" class="mb-3" style="display: none;">
                        <label class="form-label fw-bold">Selected Brands:</label>
                        <div id="materialSelectedBrandsTags" class="d-flex flex-wrap gap-2">
                            <!-- Tags will appear here -->
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="materialCatcreatedby" id="materialCatcreatedby" class="form-control"
                        value="<?php echo $_SESSION['login_user']; ?>" />
                    <input type="hidden" name="materialCatmodifiedby" id="materialCatmodifiedby" class="form-control"
                        value="<?php echo $_SESSION['login_user']; ?>" />
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer"
                    style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 8px 8px;">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">
                        </i>Close
                    </button>
                    <button type="submit" name="submit" id="submit_button" class="btn btn-success">
                        </i>Add Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="itemsubcatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="addMaterialSubcatForm" enctype="multipart/form-data">
            <div class="modal-content">
                <!-- Modern Header with Gradient -->
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title text-white">
                        <i class="fas fa-list-ul me-2"></i>Add Material Subcategory
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="background: #f8f9fa; padding: 25px;">
                    <span id="form_message_add"></span>

                    <!-- Parent Category Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Material Category <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-folder-open"></i></span>
                            <select id="materialcatid" name="materialcatid" class="form-select" required>
                                <option hidden disabled selected value>-- Select Material Category --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Subcategory Name -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Subcategory Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" name="materialsubcatname" id="materialsubcatname" class="form-control"
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
                            <textarea name="materialsubcatdescription" id="materialsubcatdescription"
                                class="form-control" required rows="2"
                                placeholder="Enter subcategory description"></textarea>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="materialsubcatcreatedby" id="materialsubcatcreatedby"
                        class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                    <input type="hidden" name="materialsubcatmodifiedby" id="materialsubcatmodifiedby"
                        class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer"
                    style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 8px 8px;">
                    <input type="hidden" name="action" value="Add" />
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">
                        </i>Close
                    </button>
                    <button type="submit" id="submit_button" class="btn btn-success">
                        </i>Add Subcategory
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="detailsItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-modern shadow-lg">

            <div class="modal-header text-white"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                <div>
                    <h5 class="modal-title font-weight-bold" id="modal_title">
                        <i class="fas fa-info-circle mr-2"></i> Material Information
                    </h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                </button>
            </div>

            <div class="modal-body bg-light px-4 py-4">
                <input type="hidden" id="infoitemid">

                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                        <div class="product-img-frame">
                            <img id="itemImage" src="" alt="Item Image">
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-8">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="font-weight-bold text-dark mb-1" id="displayItemName"></h3>
                                <div class="mb-3">
                                    <span class="badge badge-primary px-3 py-2 mr-1" id="displayItemCategory"></span>
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
                                <div class="col-md-14 mb-2">
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

                <h6 class="text-primary font-weight-bold mb-3 pl-1 text-uppercase small ls-1">
                    Product Specifications & Financials
                </h6>

                <!-- ROW 1 -->
                <div class="row mb-2">
                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card card-warn">
                            <span class="label-text">SPU</span>
                            <p class="value-text" id="displayItempu"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Unit</span>
                            <p class="value-text" id="displayunit"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Unit Factor</span>
                            <p class="value-text" id="displayunitFactor"></p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card card-spec">
                            <span class="label-text">Thickness</span>
                            <p class="value-text" id="displayItemThickness"></p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card card-spec">
                            <span class="label-text">Grains</span>
                            <p class="value-text" id="displayItemGrains"></p>
                        </div>
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="row">
                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card card-warn">
                            <span class="label-text">Quantity</span>
                            <p class="value-text" id="displayItemsize"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">MRP</span>
                            <p class="value-text" id="displayItemMRP"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">GST</span>
                            <p class="value-text" id="displayItemGST"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Discount</span>
                            <p class="value-text" id="displayCardDiscount"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card card-highlight">
                            <span class="label-text text-success">Net Price</span>
                            <p class="value-text value-text-lg" id="displayItemppMRP"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
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
                        <table class="table table-modern table-hover mb-0" id="details_table" width="100%">
                            <thead>
                                <tr>
                                    <th>Supplier</th>
                                    <th>PO Code</th>
                                    <th>Invoice No</th>
                                    <th>Date of Purchase</th>
                                    <th>Item Price</th>
                                    <th>ReceivedQty</th>
                                    <th>ReceivedQtyAmt</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer bg-white border-top-0">
                <button class="btn btn-danger text-white font-weight-bold" data-dismiss="modal">Close</button>
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
                        <i class="fas fa-trademark me-2"></i>Add New Brand
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
                                style="border-radius: 8px; padding: 10px 15px; border: 2px solid #e9ecef; background: white;">
                                <span>
                                    <i class="fas fa-list me-2"></i>
                                    <span id="inputTypeDropdownText">Select Input Types</span>
                                </span>
                                <span class="badge bg-primary rounded-pill" id="inputTypeSelectedCount">0</span>
                            </button>
                            <ul class="dropdown-menu w-100 p-3" id="brand_inputtypes"
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
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">
                        </i>Close
                    </button>
                    <button type="submit" class="btn btn-success" id="brandSubmitBtn">
                        </i>Add Brand
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        // ✅ BRAND HANDLER (SINGLE BIND + NO DUPLICATE OPTIONS)
        let isSubmittingBrand = false;

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
                        $('#form_message').html('<div class="alert alert-success">Brand added successfully!</div>');

                        let newBrandId = json.newBrandId || null;

                        setTimeout(function () {
                            $('#brandModal').one('hidden.bs.modal', function () {

                                // AUTO-RELOAD BRAND DROPDOWN
                                reloadBrandList(newBrandId);

                                // REOPEN MATERIAL DETAILS MODAL
                                $('#itemdetailsModal').modal('show');
                            });

                            $('#brandModal').modal('hide');
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
        function reloadBrandListSimple() {
            $('#company').empty().append('<option hidden disabled selected value>-- select brand --</option>');
            var fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php";
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (index, value) {
                    $('#company').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
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
        /* =========================
           MATERIAL MODAL JS (TOP)
           Namespaced with mat* to avoid collisions
           ========================= */

        // helper to get JSON
        function matGetJSON(url) { return $.getJSON(url); }

        // --- Controller base: use relative paths from your View file ---
        const baseCtrl = "../Controller";

        // URLs (use relative controller paths)
        const matThicknessUrl = baseCtrl + "/thicknessController.php";
        const matRotationUrl = baseCtrl + "/rotationController.php";
        const matCatUrl = baseCtrl + "/material_CategoryController.php";
        const matSubcatBase = baseCtrl + "/material_SubcategoryController.php?catId=";
        const matBrandBase = baseCtrl + "/brandcontroller.php?matcatId=";
        const matUnitsUrl = baseCtrl + "/unitsContoller.php";
        const matUnitFactorBase = baseCtrl + "/unitFactorController.php?unitId=";

        // helper: safe AJAX JSON parse (returns object or throws)
        function parseJsonSafe(res) {
            if (typeof res === "object") return res;
            // detect HTML responses quickly
            const trimmed = (res || "").trim();
            if (trimmed.startsWith("<")) {
                // server returned HTML (likely a full page) — throw with raw response
                const err = new Error("Server returned HTML instead of JSON");
                err.raw = res;
                throw err;
            }
            return JSON.parse(res);
        }

        // safe table reload helper
        function safeReloadTable(tableSelector) {
            try {
                if ($.fn.DataTable && $(tableSelector).length) {
                    const dt = $(tableSelector).DataTable();
                    if (dt && dt.ajax && typeof dt.ajax.reload === "function") {
                        dt.ajax.reload(null, false);
                        return;
                    }
                }
            } catch (e) {
                console.warn("DataTable reload failed, falling back to full reload", e);
            }
            // fallback
            location.reload();
        }

        // ---------- Load thickness & grains ----------
        $.getJSON(matThicknessUrl, function (data) {
            $('#thickness, #editedthickness').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#thickness, #editedthickness').append(`<option value="${v.ThicknessId}">${v.Thickness}</option>`);
            });
        }).fail(function (xhr, status, err) {
            console.error("Failed to load thickness:", status, err);
        });

        $.getJSON(matRotationUrl, function (data) {
            $('#materialGrains, #editedRotation').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#materialGrains, #editedRotation').append(`<option value="${v.rotationId}">${v.sides}</option>`);
            });
        }).fail(function () { console.error("Failed to load rotation"); });

        // ---------- Categories ----------
        $.getJSON(matCatUrl, function (data) {
            $('#materialCategory, #editedmaterialCategory').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#materialCategory, #editedmaterialCategory').append(`<option value="${v.materialcatId}">${v.materialCatname}</option>`);
            });
        }).fail(function () { console.error("Failed to load categories"); });

        function matSetSubCategory(selId, catId) {
            const $sel = $(selId);
            $sel.empty().append('<option hidden disabled selected value>-- select an option --</option>');
            if (!catId) return;
            $.getJSON(matSubcatBase + catId, function (data) {
                $.each(data, function (i, v) {
                    $sel.append(`<option value="${v.materialsubcatId}">${v.materialsubcatName}</option>`);
                });
            }).fail(function () { console.error("Failed to load subcategories for cat", catId); });
        }

        function matSetBrand(selId, catId) {
            const $sel = $(selId);
            $sel.empty().append('<option hidden disabled selected value>-- select an option --</option>');
            if (!catId) return;
            $.getJSON(matBrandBase + catId, function (data) {
                $.each(data, function (i, v) {
                    $sel.append(`<option value="${v.brandid}">${v.brandname}</option>`);
                });
            }).fail(function () { console.error("Failed to load brands for cat", catId); });
        }

        // $('#materialCategory').on('change', function () {
        //     $('#materialsubCategory').empty();
        //     $('#company').empty(); // correct brand dropdown

        //     matSetSubCategory('#materialsubCategory', this.value);
        //     matSetBrand('#company', this.value); // FIXED
        // });
        $('#company').on('change', function () {

            let brandId = $(this).val();

            $('#materialCategory').empty();
            $('#materialsubCategory').empty();

            if (!brandId) return;

            $.getJSON(
                config.developmentPath + "/Admin/Controller/material_CategoryController.php?brandId=" + brandId,
                function (data) {

                    $('#materialCategory')
                        .append('<option hidden disabled selected>-- select category --</option>');

                    $.each(data, function (i, v) {
                        $('#materialCategory').append(
                            `<option value="${v.materialcatId}">${v.materialCatname}</option>`
                        );
                    });
                }
            );
        });

        $('#materialCategory').on('change', function () {

            let catId = $(this).val();

            $('#materialsubCategory').empty();

            if (!catId) return;

            $.getJSON(
                config.developmentPath + "/Admin/Controller/material_SubcategoryController.php?catId=" + catId,
                function (data) {

                    $('#materialsubCategory')
                        .append('<option hidden disabled selected>-- select subcategory --</option>');

                    $.each(data, function (i, v) {
                        $('#materialsubCategory').append(
                            `<option value="${v.materialsubcatId}">${v.materialsubcatName}</option>`
                        );
                    });
                }
            );
        });
        function loadMaterialBrands() {

            $('#company').empty()
                .append('<option hidden disabled selected>-- select brand --</option>');

            $.getJSON(
                config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=2",
                function (data) {

                    $.each(data, function (i, v) {
                        $('#company').append(
                            `<option value="${v.brandid}">${v.brandname}</option>`
                        );
                    });

                }
            );
        }
        $('#itemdetailsModal').on('show.bs.modal', function () {
            loadMaterialBrands();
        });



        $('#editedmaterialCategory').on('change', function () {
            $('#editedsubCategory').empty();
            $('#editedmaterialbrand').empty();
            matSetSubCategory('#editedsubCategory', this.value);
            matSetBrand('#editedmaterialbrand', this.value);
        });

        // ---------- Units & Unit Factors (material) ----------
        $.getJSON(matUnitsUrl, function (data) {
            $('#materialunit').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#materialunit').append(`<option value="${v.unitId}">${v.unitName}</option>`);
            });
            if (data.length) matLoadUnitFactor(data[0].unitId);
        }).fail(function () { console.error("Failed to load units"); });

        function matLoadUnitFactor(unitId) {
            $('#materialunitFactor').empty();
            $.getJSON(matUnitFactorBase + unitId, function (data) {
                $('#materialunitFactor').append('<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (i, v) {
                    $('#materialunitFactor').append(`<option value="${v.unitFactorId}">${v.unitFactor}</option>`);
                });
            }).fail(function () { console.error("Failed to load unit factors for", unitId); });
        }

        $('#materialunit').on('change', function () {
            matLoadUnitFactor(this.value);
            matRecalcMaterialPriceAndValue();
        });

        // ---------- Edited units/factors (material edit modal) ----------
        $.getJSON(matUnitsUrl, function (data) {
            $('#editedunit').empty();
            $.each(data, function (i, v) {
                $('#editedunit').append(`<option value="${v.unitId}">${v.unitName}</option>`);
            });
            if (data.length) matLoadEditedUnitFactor(data[0].unitId);
        }).fail(function () { console.error("Failed to load units for edit"); });

        function matLoadEditedUnitFactor(unitId) {
            $('#editedunitFactor').empty();
            $.getJSON(matUnitFactorBase + unitId, function (data) {
                $('#editedunitFactor').append('<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (i, v) {
                    // Use unitFactorId as value, unitFactor as text
                    $('#editedunitFactor').append(`<option value="${v.unitFactorId}">${v.unitFactor}</option>`);
                });
            }).fail(function () { console.error("Failed to load edited unit factors for", unitId); });
        }

        $('#editedunit').on('change', function () {
            matLoadEditedUnitFactor(this.value);
            matCalculateEditedMaterialPriceAndValue();
        });

        // ---------- Calculation logic (material) ----------
        function matRecalcMaterialPriceAndValue() {
            let MRP = parseFloat($('#materialMRP').val()) || 0;
            let Discount = parseFloat($('#materialDiscount').val()) || 0;
            let GST = parseFloat($('#materialGST').val()) || 0;
            let SPU = parseFloat($('#materialSPU').val()) || 0;
            let factor = parseFloat($('#materialunitFactor').find(":selected").text()) || 1; // ✅ read factor text

            let price = MRP * factor; // ✅ NEW CHANGE (MRP × factor)

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100)); // ✅ same GST logic
            }

            let amount = MRP * factor;

            $('#materialAmount').val(amount.toFixed(2));
            $('#materialPrice').val(price.toFixed(2));
            $('#materialTotalValue').val((price * SPU).toFixed(2)); // ✅ same total logic
        }

        // bind event again
        $('#materialMRP, #materialDiscount, #materialGST, #materialSPU, #materialunitFactor')
            .on('keyup blur change', matRecalcMaterialPriceAndValue);

        // Edited calc
        function matCalculateEditedMaterialPriceAndValue() {
            let MRP = parseFloat($('#editedmaterialMRP').val()) || 0;
            let Discount = parseFloat($('#editedmaterialDiscount').val()) || 0;
            let GST = parseFloat($('#editedmaterialGST').val()) || 0;
            let SPU = parseFloat($('#editedmaterialSPU').val()) || 0;
            let factor = parseFloat($('#editedunitFactor').find(":selected").text()) || 1; // ✅ read factor

            let price = MRP * factor; // ✅ NEW CHANGE for edited modal

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100)); // ✅ same GST rule
            }

            let amount = MRP * factor;

            $('#editedmaterialAmount').val((MRP * factor).toFixed(2)); // ✅ amount calc
            $('#editedmaterialPrice').val(price.toFixed(2));
            $('#editedmaterialTotalValue').val((price * SPU).toFixed(2)); // ✅ same final
        }

        // bind edited events
        $('#editedmaterialMRP, #editedmaterialDiscount, #editedmaterialGST, #editedmaterialSPU, #editedunitFactor')
            .on('keyup blur change', matCalculateEditedMaterialPriceAndValue);

        // ---------- Edit modal open handler (material) ----------
        $('#edititemdetailsModal').on('show.bs.modal', function (e) {
            debugger; //
            const btn = $(e.relatedTarget); // clicked action button

            $('#materialid').val(btn.data('id'));
            $('#editedmaterialname').val(btn.data('name'));
            $('#editedmaterialdescription').val(btn.data('desc'));

            const catId = btn.data('cat');
            const subcatId = btn.data('subcat');
            const brandId = btn.data('brand');

            const unitId = btn.data('unit');
            const unitFactorId = btn.data('factor');

            const thicknessId = btn.data('thickness');
            const grainsId = btn.data('grains');

            $('#editedmaterialCode').val(btn.data('code'));
            $('#editedmaterialhsncode').val(btn.data('hsn'));
            $('#editedmaterialSPU').val(btn.data('spu'));
            $('#editedmaterialQty').val(btn.data('qty'));
            $('#editedmaterialMRP').val(btn.data('mrp'));
            $('#editedmaterialGST').val(btn.data('gst'));
            $('#editedmaterialDiscount').val(btn.data('discount'));
            $('#editedmaterialPrice').val(btn.data('price'));
            $('#editedmaterialTotalValue').val(btn.data('total'));

            const img = btn.data('image');
            $('#editedPreviewImage').attr("src",
                img ? (baseCtrl + "/../img/materials/" + img) : (baseCtrl + "/../img/default.png")
            );
            $('#existing_image').val(img);


            // Now populate dropdowns
            matPopulateEditedDropdowns({
                catId, subcatId, brandId, unitId, unitFactorId
            }).then(() => {
                $('#editedthickness').val(thicknessId);
                $('#editedRotation').val(grainsId);
            }).catch(err => {
                console.error("Failed populating edited dropdowns:", err);
            });
            setTimeout(() => {
                matCalculateEditedMaterialPriceAndValue();
            }, 300);

        });

        // helpers for edited dropdown population (material)
        function matFillSelect($sel, list, valueKey, textKey, placeholder) {
            $sel.empty();
            if (placeholder) $sel.append(`<option hidden disabled selected value>${placeholder}</option>`);
            list.forEach(v => $sel.append(`<option value="${v[valueKey]}">${v[textKey]}</option>`));
        }

        function matLoadEditedCategories() {
            return $.getJSON(matCatUrl).then(data => {
                matFillSelect($('#editedmaterialCategory'), data, 'materialcatId', 'materialCatname', '-- select --');
                return data;
            });
        }
        function matLoadEditedSubcategories(catId) {
            if (!catId) return Promise.resolve([]);
            return $.getJSON(matSubcatBase + catId).then(data => {
                matFillSelect($('#editedsubCategory'), data, 'materialsubcatId', 'materialsubcatName', '-- select --');
                return data;
            });
        }
        function matLoadEditedBrands(catId) {
            if (!catId) return Promise.resolve([]);
            return $.getJSON(matBrandBase + catId).then(data => {
                matFillSelect($('#editedmaterialbrand'), data, 'brandid', 'brandname', '-- select --');
                return data;
            });
        }
        function matLoadEditedUnits() {
            return $.getJSON(matUnitsUrl).then(data => {
                matFillSelect($('#editedunit'), data, 'unitId', 'unitName', '-- select --');
                return data;
            });
        }

        function matLoadEditedUnitFactors(unitId) {
            if (!unitId) return Promise.resolve([]);
            return $.getJSON(matUnitFactorBase + unitId).then(data => {
                // Use unitFactorId as value, unitFactor as text
                matFillSelect($('#editedunitFactor'), data, 'unitFactorId', 'unitFactor', '-- select --');
                return data;
            });
        }

        function matPopulateEditedDropdowns({ catId, subcatId, brandId, unitId, unitFactorId }) {
            return matLoadEditedCategories()
                .then(() => { if (catId) $('#editedmaterialCategory').val(catId); return $.when(matLoadEditedSubcategories(catId), matLoadEditedBrands(catId)); })
                .then(() => {
                    if (subcatId) $('#editedsubCategory').val(subcatId);
                    if (brandId) $('#editedmaterialbrand').val(brandId);
                    return matLoadEditedUnits();
                })
                .then(() => matLoadEditedUnitFactors(unitId))
                .then(() => {
                    if (unitId) $('#editedunit').val(unitId);
                    if (unitFactorId) $('#editedunitFactor').val(unitFactorId);

                    matCalculateEditedMaterialPriceAndValue();
                });
        }

        // ---------- Material form submit ----------
        $('#itemdetails_form').off('submit').on('submit', function (e) {
            e.preventDefault();

            console.log("Material submit triggered ✔"); // DEBUG

            let formData = new FormData(this);

            $.ajax({
                url: "../Controller/materialController.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",

                beforeSend: function () {
                    $("#submit_button").prop("disabled", true);
                    $("#form_message").html(`<div class="alert alert-info">Saving...</div>`);
                }
            })
                .done(function (res) {
                    console.log("Server JSON ✔", res);

                    if (res.status === "success") {
                        $("#form_message").html(`<div class="alert alert-success">${res.message}</div>`);

                        setTimeout(() => {
                            $("#itemdetailsModal").modal("hide");
                            location.reload();
                        }, 700);
                    } else {
                        $("#form_message").html(`<div class="alert alert-danger">${res.message}</div>`);
                    }
                })
                .fail(function (xhr) {
                    console.error("AJAX FAIL ❌", xhr.responseText);

                    $("#form_message").html(`
                <div class="alert alert-danger">
                    Server Error: Invalid response<br>
                </div>
                <pre>${xhr.responseText}</pre>
            `);
                })
                .always(function () {
                    $("#submit_button").prop("disabled", false);
                });
        });


        // ---------- Edited material submit ----------
        $('#editeditemdetails_form').on('submit', function (e) {
            debugger;
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: baseCtrl + "/materialController.php",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () { $('#editbutton').prop('disabled', true); $('#edit_form_message').html('<div class="alert alert-info">Saving...</div>'); }
            }).done(function (res) {
                try {
                    debugger;
                    const json = parseJsonSafe(res);
                    if (json.status === "success") {
                        $('#edit_form_message').html('<div class="alert alert-success">' + (json.message || 'Saved') + '</div>');
                        setTimeout(() => {
                            $('#edititemdetailsModal').modal('hide');
                            //safeReloadTable('#item_table');
                        }, 700);
                    } else {
                        $('#edit_form_message').html('<div class="alert alert-danger">' + (json.message || 'Error') + '</div>');
                    }
                } catch (err) {
                    console.error('Unexpected response', err.raw || err, err);
                    $('#edit_form_message').html('<div class="alert alert-danger">Server Error: Invalid response from server.</div>');
                }
                $('#editbutton').prop('disabled', false);
            }).fail(function (xhr, status, error) {
                $('#edit_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                $('#editbutton').prop('disabled', false);
            });
        });

        // ---------- OPTIONAL: reloadMaterialBrandList function ----------
        function reloadMaterialBrandList(selectBrandId = null) {
            const fetchcompany = baseCtrl + "/brandcontroller.php";
            const $sel = $('#materialbrand');
            $sel.empty().append('<option hidden disabled selected value>-- select brand --</option>');
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (i, v) { $sel.append(`<option value="${v.brandid}">${v.brandname}</option>`); });
                if (selectBrandId) $sel.val(selectBrandId);
            }).fail(() => console.error("Failed loading brand list"));
            const $edited = $('#editedmaterialbrand');
            $edited.empty().append('<option hidden disabled selected value>-- select brand --</option>');
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (i, v) { $edited.append(`<option value="${v.brandid}">${v.brandname}</option>`); });
            }).fail(() => console.error("Failed loading brand list for edit"));
        }

        /* =========================
           ITEM MODAL JS (kept after material)
           ========================= */

        // ✅ Load Input Types when Brand Modal opens
        // $('#brandModal').on('show.bs.modal', function () {
        //     const url = baseCtrl + "/inputTypeController.php";
        //     $('#brand_inputtypes').empty();

        //     $.getJSON(url, function (data) {
        //         $.each(data, function (index, value) {
        //             $('#brand_inputtypes').append(
        //                 `<li class="form-check form-switch px-3">
        //     <input class="form-check-input me-1" name="inputtype_list[]" value="${value.InputTypeId}" type="checkbox" id="input_${value.InputTypeId}">
        //     <label class="form-check-label" for="input_${value.InputTypeId}">${value.InputType}</label>
        //   </li>`
        //             );
        //         });
        //     }).fail(() => console.error("Failed loading input types"));
        // });

        // Add Brand & Return to Item Modal
        // $('#brand_form').on('submit', function (e) {
        //     e.preventDefault();
        //     const formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: baseCtrl + "/brandcontroller.php",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function (res) {
        //             try {
        //                 const json = parseJsonSafe(res);
        //                 if (json.status === "success") {
        //                     $('#brand_form_message').html('<div class="alert alert-success">Brand added successfully!</div>');
        //                     setTimeout(() => {
        //                         $('#brandModal').modal('hide');
        //                         $('#brandModal').on('hidden.bs.modal', function () {
        //                             $(this).off('hidden.bs.modal');
        //                             reloadBrandList(json.newBrandId || null);
        //                             $('#itemdetailsModal').modal('show');
        //                         });
        //                         $('#brand_form')[0].reset();
        //                     }, 600);
        //                 } else {
        //                     $('#brand_form_message').html('<div class="alert alert-danger">' + (json.message || 'Error adding brand.') + '</div>');
        //                 }
        //             } catch (err) {
        //                 console.error("Unexpected response:", err.raw || err);
        //                 $('#brand_form_message').html('<div class="alert alert-danger">Server Error.</div>');
        //             }
        //         },
        //         error: function (xhr, status, error) {
        //             $('#brand_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
        //         }
        //     });
        // });

        // function reloadBrandList(selectBrandId = null) {
        //     const $company = $('#company');
        //     $company.empty().append('<option hidden disabled selected value>-- select brand --</option>');
        //     const fetchcompany = baseCtrl + "/brandcontroller.php";
        //     $.getJSON(fetchcompany, function (data) {
        //         $.each(data, function (index, value) {
        //             $company.append(`<option value="${value.brandid}">${value.brandname}</option>`);
        //         });
        //         if (selectBrandId) {
        //             $company.val(selectBrandId);
        //         }
        //     }).fail(() => console.error("Failed to reload brand list"));
        // }

        // Item calculation changes (kept)
        $('#itemMRP, #itemDiscount, #itemGST, #itempu').on('keyup blur change', function () {
            calculatePriceAndValue();
        });

        function calculatePriceAndValue() {
            let MRP = parseFloat($('#itemMRP').val()) || 0;
            let Discount = parseFloat($('#itemDiscount').val()) || 0;
            let GST = parseFloat($('#itemGST').val()) || 0;
            let SPU = parseFloat($('#itempu').val()) || 0;

            let price = 0;

            if (Discount > 0) {
                let discountedPrice = MRP - (MRP * (Discount / 100));
                price = discountedPrice * (1 + (GST / 100));
            } else {
                price = MRP;
            }

            $('#itemPrice').val(price.toFixed(2));
            let totalValue = price * SPU;
            $('#itemTotalValue').val(totalValue.toFixed(2));
        }

        function calculateEditedPriceAndValue() {
            const MRP = parseFloat($('#editeditemMRP').val()) || 0;
            const Discount = parseFloat($('#editeditemDiscount').val()) || 0;
            const GST = parseFloat($('#editeditemGST').val()) || 0;
            const SPU = parseFloat($('#editeditempu').val()) || 0;

            let price = 0;

            if (Discount > 0) {
                let discounted = MRP - (MRP * (Discount / 100));
                price = discounted * (1 + (GST / 100));
            } else {
                price = MRP;
            }

            $('#editeditemPrice').val(price.toFixed(2));
            const totalValue = price * SPU;
            $('#editeditemTotalValue').val(totalValue.toFixed(2));
        }

        $('#editeditemMRP, #editeditemDiscount, #editeditemGST, #editeditempu')
            .on('keyup blur change', calculateEditedPriceAndValue);

        $('#edititemdetailsModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#itemid').val(rowid);
        });

        $('#detailsItemModal').on('show.bs.modal', function (e) {

            var matId = $(e.relatedTarget).data('id');

            $.getJSON(baseCtrl + "/materialController.php?matInfoId=" + matId, function (data) {

                if (!data || !data.length) return;

                let m = data[0];
                console.log(m);

                function safe(v) { return (v === null || v === "" ? "-" : v); }

                $('#displayItemName').text(safe(m.MaterialName));
                $('#displayItemCategory').text(safe(m.CategoryName));
                $('#displayItemSubCategory').text(safe(m.SubCategoryName));
                $('#displayItemDescription').text(safe(m.MaterialDescription));
                $('#displayItemComapny').text(safe(m.BrandName));

                $('#displayItemArticleNo').text(safe(m.MaterialCode));
                $('#displayItemHSNCode').text(safe(m.HSNCode));
                $('#displayItempu').text(safe(m.MaterialSPU));

                $('#displayItemsize').text(safe(m.Qty));

                $('#displayunit').text(safe(m.Unit));
                $('#displayunitFactor').text(safe(m.MaterialUnitFactor));

                $('#displayItemThickness').text(safe(m.Thickness));
                $('#displayItemGrains').text(safe(m.Grains));

                $('#displayItemMRP').text(safe(m.MaterialPPMRP));

                $('#displayItemGST').text(safe(m.MaterialGST) + "%");

                $('#displayItemppMRP').text(safe(m.MaterialCompanyPrice));
                $('#displayItemDiscount').text(
                    safe(m.MaterialDiscount ? m.MaterialDiscount + "%" : "0%")
                );

                $('#displayItemTotalValue').text(
                    safe(parseFloat(m.MaterialTotalValue || 0).toFixed(2))
                );
                $('#displayCardDiscount').text(
                    safe(m.MaterialDiscount) + "%"
                );


                // IMAGE
                const img = m.MaterialImage
                    ? ("../img/materials/" + m.MaterialImage)
                    : ("../img/default.png");

                $('#itemImage').attr("src", img);

                // PURCHASE TABLE
                $("#details_table tbody").empty();

                let runningTotal = 0;

                // ✅ Sort by date / id if needed (important)
                data.sort((a, b) => new Date(a.DateofPurchase) - new Date(b.DateofPurchase));

                let hasHistory = false;

                $.each(data, function (index, r) {

                    // Skip rows where there is no inward history
                    if (
                        !r.SupplierName &&
                        !r.POcode &&
                        !r.InvoiceNo &&
                        !r.DateofPurchase &&
                        (r.ReceivedQty == null || r.ReceivedQty == "")
                    ) {
                        return true; // continue
                    }

                    hasHistory = true;

                    let qty = parseFloat(r.ReceivedQty) || 0;
                    let amt = parseFloat(r.ReceivedQtyAmt) || 0;

                    let perUnitAmt = qty > 0 ? (amt / qty).toFixed(2) : "-";

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

                if (!hasHistory) {
                    $("#details_table tbody").empty();
                }

            }).fail(function (xhr, status, err) {
                console.error("Failed to fetch material details:", status, err);
            });

        });

        // units for item modal (kept)
        var uniturl = baseCtrl + "/unitsContoller.php";
        $.getJSON(uniturl, function (data) {
            if (data && data[0]) loadUnitFactor(data[0].unitId);
            $.each(data, function (index, value) {
                $('#unit').append('<option hidden disabled selected value>-- select an option --</option>');
                $('#unit').append('<option value="' + value.unitId + '">' + value.unitName + '</option>');
            });
        }).fail(() => console.error("Failed to load units for item modal"));

        function loadUnitFactor(unitId) {
            $('#unitFactor').empty();
            unitFactorurl = baseCtrl + "/unitFactorController.php?unitId=" + unitId;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#unitFactor').append('<option hidden disabled selected value>Blank</option>');
                    $('#unitFactor').append('<option value="' + value.unitFactor + '">' + value.unitFactor + '</option>');
                });
            }).fail(() => console.error("Failed to load unit factors for item modal"));
        }

        $('#editeditemdetails_form').on('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: baseCtrl + "/item_detailscontroller.php",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () { $('#editbutton').prop('disabled', true); $('#form_message').html('<div class="alert alert-info">Saving...</div>'); }
            }).done(function (res) {
                try {
                    const json = parseJsonSafe(res);
                    if (json.status === "success") {
                        $('#form_message').html('<div class="alert alert-success">' + json.message + '</div>');
                        setTimeout(() => {
                            try {
                                const modalEl = document.getElementById('edititemdetailsModal');
                                if (window.bootstrap && bootstrap.Modal) {
                                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                    modalInstance.hide();
                                } else {
                                    $('#edititemdetailsModal').modal('hide');
                                }
                            } catch (e) {
                                $('#edititemdetailsModal').removeClass('show').hide();
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open');
                            }
                            // safeReloadTable('#item_table');
                        }, 800);
                    } else {
                        $('#form_message').html('<div class="alert alert-danger">' + (json.message || 'Error') + '</div>');
                    }
                } catch (e) {
                    console.error("Invalid JSON:", e.raw || e);
                    $('#form_message').html('<div class="alert alert-danger">Unexpected response.</div>');
                }
                $('#editbutton').prop('disabled', false);
            }).fail(function (xhr, status, error) {
                console.error("❌ AJAX Failed:", error);
                $('#form_message').html('<div class="alert alert-danger">Save failed: ' + error + '</div>');
                $('#editbutton').prop('disabled', false);
            });
        });

        // Item categories load
        var url = baseCtrl + "/item_categorycontroller.php";
        let catId = 0;
        $.getJSON(url, function (data) {
            $('#itemCategory').append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (index, value) {
                $('#itemCategory').append('<option  value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
                $('#editeditemCategory').append('<option  value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
            });
        }).fail(() => console.error("Failed to load item categories"));

        function setSubCategory(catId) {
            var fetchsubcaturl = baseCtrl + "/item_subcategorycontroller.php?catId=" + catId;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#subCategory').append('<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (index, value) {
                    $('#subCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                    $('#editedsubCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                });
            }).fail(() => console.error("Failed to load subcategories for", catId));
        }

        $('#unit').on('change', function () {
            $('#unitFactor').empty();
            unitFactorurl = baseCtrl + "/unitFactorController.php?unitId=" + this.value;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#unitFactor').append('<option value="' + value.unitFactor + '">' + value.unitFactor + '</option>');
                });
            }).fail(() => console.error("Failed to load unit factors on unit change"));
        });



        $('#itemCategory').on('change', function () {
            $('#subCategory').empty();
            $('#company').empty();
            fetchsubcaturl = baseCtrl + "/item_subcategorycontroller.php?catId=" + this.value;
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    $('#subCategory').append('<option hidden disabled selected value>-- select an option --</option>');
                    $('#subCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                });
            }).fail(() => console.error("Failed to load subcategories for itemCategory"));

            var fetchcompany = baseCtrl + "/brandcontroller.php?categoryId=" + this.value;
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (index, value) {
                    $('#company').append('<option hidden disabled selected value>-- select an option --</option>');
                    $('#company').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                    $('#editedcompany').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                });
            }).fail(() => console.error("Failed to load companies for category", this.value));
        });

        $('#editeditemCategory').on('change', function () {
            $('#editedsubCategory').empty();
            fetchsubcaturl = baseCtrl + "/item_subcategorycontroller.php?catId=" + this.value;
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    $('#editedsubCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                });
            }).fail(() => console.error("Failed to load edited subcategories for", this.value));

            var fetchcompany = baseCtrl + "/brandcontroller.php?categoryId=" + this.value;
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (index, value) {
                    $('#company').append('<option hidden disabled selected value>-- select an option --</option>');
                    $('#company').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                    $('#editedcompany').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                });
            }).fail(() => console.error("Failed to load edited companies for category", this.value));
        });

        $('#itemsubcatModal').on('show.bs.modal', function (e) {
            $('#additemCategory').empty();
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#additemCategory').append('<option value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
                });
            }).fail(() => console.error("Failed to populate additemCategory"));
        });

        // $('#deleteItemModal').on('show.bs.modal', function (e) {
        //     var rowid = $(e.relatedTarget).data('id');
        //     $('#deleteitemid').val(rowid);
        // });

        // $('#deletebutton').click(function () {
        //     $.ajax({
        //         url: baseCtrl + "/item_detailscontroller.php",
        //         method: "POST",
        //         data: { id: $('#deleteitemid').val(), action: 'delete' },
        //         success: function (data) {
        //             $('#message').html(data);
        //             // safeReloadTable('#item_table');
        //             setTimeout(function () { $('#message').html(''); }, 5000);
        //         },
        //         error: function (xhr, status, err) {
        //             console.error("Delete item failed:", status, err);
        //         }
        //     });
        // });

        $('#addMaterialCategoryForm').on('submit', function (event) {
            debugger;
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_CategoryController.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    var json;
                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        console.log("Invalid JSON:", res);
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {
                        $('#form_message').html('<div class="alert alert-success">Category added successfully!</div>');

                        let newCategoryId = json.newCategoryId || null;

                        setTimeout(() => {

                            $('#itemcatmodal').one('hidden.bs.modal', function () {

                                // 1️⃣ RELOAD CATEGORY LIST
                                $.getJSON(config.developmentPath + "/Admin/Controller/material_CategoryController.php", function (data) {

                                    $('#materialCategory').empty()
                                        .append('<option hidden disabled selected value>-- select category --</option>');

                                    $.each(data, function (i, v) {
                                        $('#materialCategory').append(
                                            `<option value="${v.materialcatId}">${v.materialCatname}</option>`
                                        );
                                    });

                                    // 2️⃣ AUTO SELECT NEW CATEGORY
                                    if (newCategoryId) {
                                        $('#materialCategory').val(newCategoryId).trigger("change");
                                    }
                                });

                                // 3️⃣ REOPEN DETAILS MODAL  
                                $('#itemdetailsModal').modal('show');

                            });

                            $('#itemcatmodal').modal('hide');
                            $('#addMaterialCategoryForm')[0].reset();

                        }, 600);
                    }
                    else {
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

        $('#addMaterialSubcatForm').on('submit', function (event) {
            debugger;
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_SubcategoryController.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    var json;
                    try {
                        json = (typeof res === "string") ? JSON.parse(res) : res;
                    } catch (e) {

                        $('#form_message_add').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {

                        $('#form_message_add').html(
                            '<div class="alert alert-success">' + (json.message || 'SubCategory added!') + '</div>'
                        );

                        let newSubcatId = json.newSubcatId || null;

                        setTimeout(function () {

                            $('#itemsubcatModal').one('hidden.bs.modal', function () {

                                // 1️⃣ RELOAD SUBCATEGORY LIST
                                const catId = $('#materialCategory').val();

                                $.getJSON(
                                    config.developmentPath + "/Admin/Controller/material_SubcategoryController.php?catId=" + catId,
                                    function (data) {

                                        $('#materialsubCategory').empty()
                                            .append('<option hidden disabled selected value>-- select subcategory --</option>');

                                        $.each(data, function (i, v) {
                                            $('#materialsubCategory').append(
                                                `<option value="${v.materialsubcatId}">${v.materialsubcatName}</option>`
                                            );
                                        });

                                        // 2️⃣ AUTO-SELECT NEW SUBCATEGORY
                                        if (newSubcatId) {
                                            $('#materialsubCategory').val(newSubcatId);
                                        }
                                    }
                                );

                                // 3️⃣ REOPEN MATERIAL DETAILS MODAL
                                $('#itemdetailsModal').modal('show');

                            });

                            $('#itemsubcatModal').modal('hide');
                            $('#addMaterialSubcatForm')[0].reset();

                        }, 600);
                    }
                    else {
                        $('#form_message_add').html(
                            `<div class="alert alert-danger">${json.message || 'Error adding subcategory.'}</div>`
                        );
                    }

                },
                error: function (xhr, status, error) {
                    $('#form_message_add').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });
        });
        $('#itemsubcatModal').on('show.bs.modal', function () {

            $('#materialcatid').empty()
                .append('<option hidden disabled selected value>-- select category --</option>');

            $.getJSON("../Controller/material_CategoryController.php", function (data) {
                $.each(data, function (index, value) {
                    $('#materialcatid').append(
                        `<option value="${value.materialcatId}">${value.materialCatname}</option>`
                    );
                });
            }).fail(function () {
                console.error("Failed to load material categories!");
            });
        });

        function reloadCategoryList() {
            $('#itemCategory').empty();
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#itemCategory').append('<option value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
                });
            }).fail(() => console.error("Failed to reload category list"));
        }

        function reloadSubCategoryList() {
            var selectedCategory = $('#itemCategory').val();
            fetchcompany = baseCtrl + "/item_compdetailscontroller.php?catId=" + selectedCategory;

            $('#subCategory').empty();
            if (typeof fetchsubcaturl !== 'undefined') {
                $.getJSON(fetchsubcaturl, function (data) {
                    $.each(data, function (index, value) {
                        $('#subCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                    });
                }).fail(() => console.error("Failed to reload subcategory list"));
            }
        }

        // brand_form submit refresh
        // $('#brand_form').on('submit', function (event) {
        //     event.preventDefault();
        //     var formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: baseCtrl + "/brandcontroller.php",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function (res) {
        //             try {
        //                 const json = parseJsonSafe(res);
        //                 if (json.status === "success") {
        //                     $('#brandModal').modal('hide');
        //                     reloadBrandList();
        //                 }
        //             } catch (e) {
        //                 console.log("Unexpected response:", e.raw || e);
        //             }
        //         },
        //         error: function (xhr, status, err) {
        //             console.error("Failed brand_form submit:", status, err);
        //         }
        //     });
        // });

        // initialize DataTable (no ajax source here)
        $('#item_table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        $('#deleteMaterialModal').on('show.bs.modal', function (e) {

            const matId = $(e.relatedTarget).data('id');
            $('#deleteMaterialId').val(matId);

            const $confirmBtn = $(this).find("button[type='submit']");
            const $msg = $(this).find(".modal-body .text-danger");

            // reset
            $confirmBtn.prop("disabled", false);
            $msg.remove();

            $.getJSON(
                "../Controller/materialController.php?checkDelete=1&id=" + matId,
                function (res) {

                    if (res.blocked) {
                        $confirmBtn.prop("disabled", true);
                        $('.modal-body').append(
                            `<p class="text-danger mt-2">${res.message}</p>`
                        );
                    }
                }
            );
        });


        $('#confirmDeleteMaterial').off('click').on('click', function () {

            const $btn = $(this);
            $btn.prop('disabled', true);

            $.ajax({
                url: baseCtrl + "/materialController.php",
                type: "POST",
                data: $('#delete_material_form').serialize(),
                dataType: "json",
                success: function (response) {

                    if (response.status === "success") {

                        $('#deleteMaterialModal').modal('hide');

                        $('#message').html(`
            <div class="alert alert-success alert-dismissible fade show">
                ${response.message}
            </div>
        `);

                        $('html, body').animate({
                            scrollTop: $('#message').offset().top - 20
                        }, 300);

                        setTimeout(function () {
                            $('#message').fadeOut(function () {
                                $(this).html('').show();
                            });
                        }, 4000);

                        setTimeout(function () {
                            location.reload();
                        }, 1000);

                    } else {

                        $('#deleteMaterialModal').modal('hide');

                        $('#message').html(`
            <div class="alert alert-danger alert-dismissible fade show">
                ${response.message}
            </div>
        `);

                        $('html, body').animate({
                            scrollTop: $('#message').offset().top - 20
                        }, 300);

                        setTimeout(function () {
                            $('#message').fadeOut(function () {
                                $(this).html('').show();
                            });
                        }, 4000);
                    }
                },
                error: function () {

                    $('#deleteMaterialModal').modal('hide');

                    $('#message').html(`
        <div class="alert alert-danger alert-dismissible fade show">
            Something went wrong while deleting the material.
        </div>
    `);

                    $('html, body').animate({
                        scrollTop: $('#message').offset().top - 20
                    }, 300);

                    setTimeout(function () {
                        $('#message').fadeOut(function () {
                            $(this).html('').show();
                        });
                    }, 4000);
                },
            });
        });
        const MATERIAL_INPUT_TYPE = 2;

        $.getJSON(
            config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + MATERIAL_INPUT_TYPE,
            function (data) {
                $('#checkboxes').empty();

                $.each(data, function (index, value) {
                    $('#checkboxes').append(`
        <li class="form-check form-switch px-3">
          <input class="form-check-input me-1"
                 name="brand_list[]"
                 value="${value.brandid}"
                 type="checkbox"
                 id="brand_${value.brandid}">
          <label for="brand_${value.brandid}">
            ${value.brandname}
          </label>
        </li>
      `);
                });
            }
        );
        // Material Modal - Auto-calculations
        function calculateMaterialPriceAndValue() {
            let MRP = parseFloat($('#materialMRP').val()) || 0;
            let Discount = parseFloat($('#materialDiscount').val()) || 0;
            let GST = parseFloat($('#materialGST').val()) || 0;
            let SPU = parseFloat($('#materialSPU').val()) || 0;
            let factor = parseFloat($('#materialunitFactor').find(":selected").text()) || 1;

            let price = MRP * factor;

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100));
            }

            let amount = MRP * factor;

            $('#materialAmount').val(amount.toFixed(2));
            $('#materialPrice').val(price.toFixed(2));
            $('#materialTotalValue').val((price * SPU).toFixed(2));
        }

        // Trigger calculations on input changes
        $('#materialMRP, #materialDiscount, #materialGST, #materialSPU, #materialunitFactor')
            .on('keyup blur change', calculateMaterialPriceAndValue);



        // Load category dropdown with Add button integration
        function loadMaterialCategories() {
            const url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
            $.getJSON(url, function (data) {
                $('#materialCategory').empty().append('<option hidden disabled selected value>-- select category --</option>');
                $.each(data, function (index, value) {
                    $('#materialCategory').append(`<option value="${value.itemcatid}">${value.itemcatname}</option>`);
                });
            });
        }

        // Load subcategories when category changes
        $('#materialCategory').on('change', function () {
            $('#materialsubCategory').empty().append('<option hidden disabled selected value>-- select subcategory --</option>');

            let catId = this.value;
            if (!catId) return;

            let url = config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php/?catId=" + catId;
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#materialsubCategory').append(`<option value="${value.itemsubcatid}">${value.itemsubcatname}</option>`);
                });
            });
        });
        // =============================================
        // MATERIAL CATEGORY - Brand Selection
        // =============================================
        $(document).on('change', '#materialCheckboxes input[type="checkbox"]', function () {
            updateMaterialSelectedBrands();
        });

        function updateMaterialSelectedBrands() {
            const checked = $('#materialCheckboxes input:checked');
            const count = checked.length;
            const $display = $('#materialSelectedBrandsDisplay');
            const $tags = $('#materialSelectedBrandsTags');
            const $badge = $('#materialBrandSelectedCount');
            const $text = $('#materialBrandDropdownText');

            // Update badge count
            $badge.text(count);

            if (count > 0) {
                $display.show();
                $tags.empty();

                let brandNames = [];
                checked.each(function () {
                    const label = $(this).closest('.form-check').find('.form-check-label').text();
                    const id = $(this).attr('id');
                    brandNames.push(label);

                    $tags.append(`
                <span class="material-brand-tag" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; animation: fadeIn 0.3s ease; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);">
                    <i class="fas fa-check-circle me-1"></i>${label}
                    <span class="remove-material-brand-tag" data-id="${id}" style="cursor: pointer; opacity: 0.7; transition: opacity 0.2s ease; font-size: 14px; margin-left: 5px;">&times;</span>
                </span>
            `);
                });

                // Update dropdown button text
                if (count <= 2) {
                    $text.text(brandNames.join(', '));
                } else {
                    $text.text(`${count} brands selected`);
                }

                // Change button style when brands are selected
                $('#materialBrandDropdown').removeClass('btn-outline-secondary').addClass('btn-primary').css({
                    'background': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    'border': 'none',
                    'color': 'white'
                });

            } else {
                $display.hide();
                $text.text('Select Brands');
                $('#materialBrandDropdown').removeClass('btn-primary').addClass('btn-outline-secondary').css({
                    'background': 'white',
                    'border': '2px solid #e9ecef',
                    'color': '#212529'
                });
            }
        }

        // Remove brand tag functionality
        $(document).on('click', '.remove-material-brand-tag', function () {
            const id = $(this).data('id');
            $('#' + id).prop('checked', false).trigger('change');
        });

        // =============================================
        // MATERIAL CATEGORY - Load Brands
        // =============================================
        function loadMaterialCategoryBrands() {
            const InputType = 1; // 1 = Material
            const url = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputType;

            $('#materialCheckboxes').empty();

            $.getJSON(url, function (data) {
                if (data && data.length > 0) {
                    $.each(data, function (index, value) {
                        $('#materialCheckboxes').append(`
                    <li class="form-check form-switch px-3" style="padding: 8px 12px; border-radius: 6px; transition: background 0.2s ease; margin: 2px 0;">
                        <input class="form-check-input me-1" name="brand_list[]" 
                            value="${value.brandid}" type="checkbox" id="materialBrand_${value.brandid}"
                            style="cursor: pointer; width: 18px; height: 18px;">
                        <label class="form-check-label" for="materialBrand_${value.brandid}" 
                            style="cursor: pointer; font-weight: 500; color: #2d3436; padding-left: 5px;">
                            ${value.brandname}
                        </label>
                    </li>
                `);
                    });
                } else {
                    $('#materialCheckboxes').append(`
                <li class="text-center text-muted p-3">
                    <i class="fas fa-info-circle me-1"></i>No brands available
                </li>
            `);
                }
            });
        }

        // =============================================
        // MATERIAL SUBCATEGORY - Load Categories
        // =============================================
        function loadMaterialCategoriesForSubcat() {
            const url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";

            $('#materialcatid').empty().append('<option hidden disabled selected value>-- Select Material Category --</option>');

            $.getJSON(url, function (data) {
                if (data && data.length > 0) {
                    $.each(data, function (index, value) {
                        $('#materialcatid').append(`<option value="${value.itemcatid}">${value.itemcatname}</option>`);
                    });
                }
            });
        }

        // =============================================
        // LOAD WHEN MODALS OPEN
        // =============================================
        $('#itemcatModal').on('show.bs.modal', function () {
            loadMaterialCategoryBrands();
            // Reset form
            $('#addMaterialCategoryForm')[0].reset();
            $('#materialSelectedBrandsDisplay').hide();
            $('#materialBrandDropdownText').text('Select Brands');
            $('#materialBrandSelectedCount').text('0');
            $('#materialBrandDropdown').removeClass('btn-primary').addClass('btn-outline-secondary').css({
                'background': 'white',
                'border': '2px solid #e9ecef',
                'color': '#212529'
            });
        });

        $('#itemsubcatModal').on('show.bs.modal', function () {
            loadMaterialCategoriesForSubcat();
            // Reset form
            $('#addMaterialSubcatForm')[0].reset();
        });

        // =============================================
        // FORM SUBMISSIONS WITH LOADING STATES
        // =============================================
        $('#addMaterialCategoryForm').on('submit', function (event) {
            event.preventDefault();

            const $btn = $('#submit_button');
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Adding...');

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/item_categorycontroller.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    let json;
                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        $btn.prop('disabled', false);
                        $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Category');
                        return;
                    }

                    if (json.status === "success") {
                        $('#form_message').html(`<div class="alert alert-success">${json.message || "Category added successfully!"}</div>`);

                        setTimeout(() => {
                            $('#itemcatModal').modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // Reload categories in the main modal
                            if (typeof loadMaterialCategories === 'function') {
                                loadMaterialCategories();
                            }

                            // Reset form
                            $('#addMaterialCategoryForm')[0].reset();

                        }, 800);
                    } else {
                        $('#form_message').html(`<div class="alert alert-danger">${json.message || "Error adding category."}</div>`);
                    }

                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Category');
                },
                error: function (xhr, status, error) {
                    $('#form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Category');
                }
            });
        });

        $('#addMaterialSubcatForm').on('submit', function (event) {
            event.preventDefault();

            const $btn = $('#submit_button');
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Adding...');

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
                        $('#form_message_add').html('<div class="alert alert-danger">Invalid server response.</div>');
                        $btn.prop('disabled', false);
                        $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Subcategory');
                        return;
                    }

                    if (json.status === "success") {
                        $('#form_message_add').html(`<div class="alert alert-success">${json.message || "Subcategory added successfully!"}</div>`);

                        setTimeout(() => {
                            $('#itemsubcatModal').modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // Reset form
                            $('#addMaterialSubcatForm')[0].reset();

                        }, 800);
                    } else {
                        $('#form_message_add').html(`<div class="alert alert-danger">${json.message || "Error adding subcategory."}</div>`);
                    }

                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Subcategory');
                },
                error: function (xhr, status, error) {
                    $('#form_message_add').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Subcategory');
                }
            });
        });

        // =============================================
        // BRAND MODAL - Input Type Selection
        // =============================================
        $(document).on('change', '#brand_inputtypes input[type="checkbox"]', function () {
            updateSelectedTypes();
        });

        function updateSelectedTypes() {
            const checked = $('#brand_inputtypes input:checked');
            const count = checked.length;
            const $display = $('#selectedTypesDisplay');
            const $tags = $('#selectedTypesTags');
            const $badge = $('#inputTypeSelectedCount');
            const $text = $('#inputTypeDropdownText');

            // Update badge count
            $badge.text(count);

            if (count > 0) {
                $display.show();
                $tags.empty();

                let typeNames = [];
                checked.each(function () {
                    const label = $(this).closest('.form-check').find('.form-check-label').text();
                    const id = $(this).attr('id');
                    typeNames.push(label);

                    $tags.append(`
                <span class="type-tag" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; animation: fadeIn 0.3s ease; box-shadow: 0 2px 8px rgba(79, 172, 254, 0.3);">
                    <i class="fas fa-check-circle me-1"></i>${label}
                    <span class="remove-type-tag" data-id="${id}" style="cursor: pointer; opacity: 0.7; transition: opacity 0.2s ease; font-size: 14px; margin-left: 5px;">&times;</span>
                </span>
            `);
                });

                // Update dropdown button text
                if (count <= 2) {
                    $text.text(typeNames.join(', '));
                } else {
                    $text.text(`${count} types selected`);
                }

                // Change button style when types are selected
                $('#inputTypeDropdown').removeClass('btn-outline-secondary').addClass('btn-primary').css({
                    'background': 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                    'border': 'none',
                    'color': 'white'
                });

            } else {
                $display.hide();
                $text.text('Select Input Types');
                $('#inputTypeDropdown').removeClass('btn-primary').addClass('btn-outline-secondary').css({
                    'background': 'white',
                    'border': '2px solid #e9ecef',
                    'color': '#212529'
                });
            }
        }

        // Remove type tag functionality
        $(document).on('click', '.remove-type-tag', function () {
            const id = $(this).data('id');
            $('#' + id).prop('checked', false).trigger('change');
        });

        // =============================================
        // BRAND MODAL - Load Input Types
        // =============================================
        function loadBrandInputTypes() {
            const url = config.developmentPath + "/Admin/Controller/inputTypeController.php";

            $('#brand_inputtypes').empty();

            $.getJSON(url, function (data) {
                if (data && data.length > 0) {
                    $.each(data, function (index, value) {
                        $('#brand_inputtypes').append(`
                    <li class="form-check form-switch px-3" style="padding: 8px 12px; border-radius: 6px; transition: background 0.2s ease; margin: 2px 0;">
                        <input class="form-check-input me-1" name="inputtype_list[]" 
                            value="${value.InputTypeId}" type="checkbox" id="inputType_${value.InputTypeId}"
                            style="cursor: pointer; width: 18px; height: 18px;">
                        <label class="form-check-label" for="inputType_${value.InputTypeId}" 
                            style="cursor: pointer; font-weight: 500; color: #2d3436; padding-left: 5px;">
                            ${value.InputType}
                        </label>
                    </li>
                `);
                    });
                } else {
                    $('#brand_inputtypes').append(`
                <li class="text-center text-muted p-3">
                    <i class="fas fa-info-circle me-1"></i>No input types available
                </li>
            `);
                }
            });
        }

        // =============================================
        // LOAD WHEN MODAL OPENS
        // =============================================
        $('#brandModal').on('show.bs.modal', function () {
            loadBrandInputTypes();
            // Reset form and selections
            $('#brand_form')[0].reset();
            $('#selectedTypesDisplay').hide();
            $('#inputTypeDropdownText').text('Select Input Types');
            $('#inputTypeSelectedCount').text('0');
            $('#inputTypeDropdown').removeClass('btn-primary').addClass('btn-outline-secondary').css({
                'background': 'white',
                'border': '2px solid #e9ecef',
                'color': '#212529'
            });
            $('#brand_form_message').empty();
        });

        // =============================================
        // BRAND FORM SUBMISSION WITH LOADING STATE
        // =============================================
        $('#brand_form').on('submit', function (event) {
            event.preventDefault();

            const $btn = $('#brandSubmitBtn');
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Adding...');

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
                        $('#brand_form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        $btn.prop('disabled', false);
                        $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Brand');
                        return;
                    }

                    if (json.status === "success") {
                        $('#brand_form_message').html(`
                    <div class="alert alert-success">${json.message || "Brand added successfully!"}</div>
                `);

                        setTimeout(() => {
                            // Close modal
                            $('#brandModal').modal('hide');

                            // Remove backdrop
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // Reset form
                            $('#brand_form')[0].reset();
                            $('#selectedTypesDisplay').hide();
                            $('#inputTypeDropdownText').text('Select Input Types');
                            $('#inputTypeSelectedCount').text('0');
                            $('#inputTypeDropdown').removeClass('btn-primary').addClass('btn-outline-secondary').css({
                                'background': 'white',
                                'border': '2px solid #e9ecef',
                                'color': '#212529'
                            });

                            // Reload brand lists in parent modals
                            if (typeof reloadBrandListSimple === 'function') {
                                reloadBrandListSimple();
                            }
                            if (typeof loadMaterialCategoryBrands === 'function') {
                                loadMaterialCategoryBrands();
                            }
                            if (typeof loadMaterialBrands === 'function') {
                                loadMaterialBrands();
                            }

                        }, 800);

                    } else {
                        $('#brand_form_message').html(`
                    <div class="alert alert-danger">${json.message || "Error adding brand."}</div>
                `);
                    }

                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Brand');
                },
                error: function (xhr, status, error) {
                    $('#brand_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-plus-circle me-1"></i>Add Brand');
                }
            });
        });

        // =============================================
        // PREVENT DROPDOWN CLOSE ON INSIDE CLICK
        // =============================================
        $('#brand_inputtypes').on('click', function (e) {
            e.stopPropagation();
        });

        // =============================================
        // CLOSE DROPDOWN WHEN CLICKING OUTSIDE
        // =============================================
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });
        // =============================================================
        // RESPONSIVE + DRAGGABLE MODALS
        // Works on:
        // Desktop
        // Laptop
        // Tablet
        // Mobile
        // Touch devices
        // =============================================================

        (function () {

            function clamp(value, min, max) {
                return Math.min(Math.max(value, min), max);
            }


            function centerModal($modal) {

                const $dialog = $modal.find('.modal-dialog').first();

                if (!$dialog.length) {
                    return;
                }

                const dialog = $dialog[0];

                // Reset previous positioning
                $dialog.css({
                    position: 'fixed',
                    margin: '0',
                    transform: 'none',
                    left: '0px',
                    top: '0px'
                });

                // Force browser layout calculation
                const rect = dialog.getBoundingClientRect();

                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;

                const dialogWidth = rect.width;
                const dialogHeight = rect.height;

                const left = Math.max(
                    8,
                    (viewportWidth - dialogWidth) / 2
                );

                const top = Math.max(
                    8,
                    (viewportHeight - dialogHeight) / 2
                );

                $dialog.css({
                    left: left + 'px',
                    top: top + 'px'
                });

                $modal.data('modal-dragged', false);
            }


            function keepDialogInsideWindow($dialog) {

                if (!$dialog.length) {
                    return;
                }

                const dialog = $dialog[0];
                const rect = dialog.getBoundingClientRect();

                const margin = 8;

                const maxLeft = Math.max(
                    margin,
                    window.innerWidth - rect.width - margin
                );

                const maxTop = Math.max(
                    margin,
                    window.innerHeight - rect.height - margin
                );

                const currentLeft = parseFloat($dialog.css('left')) || 0;
                const currentTop = parseFloat($dialog.css('top')) || 0;

                $dialog.css({
                    left: clamp(currentLeft, margin, maxLeft) + 'px',
                    top: clamp(currentTop, margin, maxTop) + 'px'
                });
            }


            function makeModalDraggable($modal) {

                const $dialog = $modal.find('.modal-dialog').first();
                const $header = $modal.find('.modal-header').first();

                if (!$dialog.length || !$header.length) {
                    return;
                }


                // Remove previous handlers
                $header.off('.materialModalDrag');


                let dragging = false;
                let startX = 0;
                let startY = 0;
                let startLeft = 0;
                let startTop = 0;


                $header.on(
                    'pointerdown.materialModalDrag',
                    function (e) {

                        // Don't drag when clicking buttons/interactive elements
                        if (
                            $(e.target).closest(
                                'button, a, input, select, textarea, .close'
                            ).length
                        ) {
                            return;
                        }

                        const rect = $dialog[0].getBoundingClientRect();

                        dragging = true;

                        startX = e.clientX;
                        startY = e.clientY;

                        startLeft = rect.left;
                        startTop = rect.top;

                        $modal.data('modal-dragged', true);

                        $header.css('cursor', 'grabbing');

                        if (this.setPointerCapture) {
                            try {
                                this.setPointerCapture(e.pointerId);
                            } catch (err) {
                                // Ignore pointer capture errors
                            }
                        }

                        e.preventDefault();
                    }
                );


                $header.on(
                    'pointermove.materialModalDrag',
                    function (e) {

                        if (!dragging) {
                            return;
                        }

                        const dialog = $dialog[0];

                        const rect = dialog.getBoundingClientRect();

                        const deltaX = e.clientX - startX;
                        const deltaY = e.clientY - startY;

                        const margin = 8;

                        const maxLeft = Math.max(
                            margin,
                            window.innerWidth - rect.width - margin
                        );

                        const maxTop = Math.max(
                            margin,
                            window.innerHeight - rect.height - margin
                        );

                        const newLeft = clamp(
                            startLeft + deltaX,
                            margin,
                            maxLeft
                        );

                        const newTop = clamp(
                            startTop + deltaY,
                            margin,
                            maxTop
                        );

                        $dialog.css({
                            left: newLeft + 'px',
                            top: newTop + 'px'
                        });

                        e.preventDefault();
                    }
                );


                $header.on(
                    'pointerup.materialModalDrag pointercancel.materialModalDrag',
                    function () {

                        dragging = false;

                        $header.css('cursor', 'grab');

                        keepDialogInsideWindow($dialog);

                    }
                );

            }


            // ---------------------------------------------------------
            // WHEN MODAL OPENS
            // ---------------------------------------------------------

            $('.modal').on('shown.bs.modal.materialResponsive', function () {

                const $modal = $(this);

                centerModal($modal);

                makeModalDraggable($modal);

            });


            // ---------------------------------------------------------
            // WHEN MODAL CLOSES
            // RESET POSITION
            // ---------------------------------------------------------

            $('.modal').on('hidden.bs.modal.materialResponsive', function () {

                const $modal = $(this);
                const $dialog = $modal.find('.modal-dialog').first();

                if (!$dialog.length) {
                    return;
                }

                $dialog.css({
                    position: '',
                    left: '',
                    top: '',
                    margin: '',
                    transform: ''
                });

                $modal.removeData('modal-dragged');

            });


            // ---------------------------------------------------------
            // WINDOW RESIZE
            // ---------------------------------------------------------

            $(window).on('resize.materialResponsive', function () {

                $('.modal.show').each(function () {

                    const $modal = $(this);
                    const $dialog = $modal.find('.modal-dialog').first();

                    if (!$dialog.length) {
                        return;
                    }

                    // If user has not manually moved the modal,
                    // keep it centered.
                    if (!$modal.data('modal-dragged')) {

                        centerModal($modal);

                    } else {

                        // If user dragged it, just keep it
                        // inside the viewport.
                        keepDialogInsideWindow($dialog);

                    }

                });

            });

        })();
        // =============================================
        // EDIT MATERIAL - Load Data into Modal
        // =============================================
        $('#edititemdetailsModal').on('show.bs.modal', function (e) {
            const $btn = $(e.relatedTarget);
            const materialId = $btn.data('id');

            $('#materialid').val(materialId);
            $('#edited_hidden_id').val(materialId);

            // Load material data
            loadMaterialData(materialId);

            // Load dropdowns
            loadEditedMaterialCategories();
            loadEditedMaterialBrands();
            loadEditedMaterialUnits();
            loadEditedThickness();
            loadEditedGrains();
        });

        // =============================================
        // LOAD MATERIAL DATA
        // =============================================
        function loadMaterialData(materialId) {
            const url = config.developmentPath + "/Admin/Controller/materialController.php?materialid=" + materialId;

            $.getJSON(url, function (data) {
                if (data && data.length > 0) {
                    const m = data[0];

                    // Basic fields
                    $('#editedmaterialname').val(m.materialname || '');
                    $('#editedmaterialdescription').val(m.materialdescription || '');
                    $('#editedmaterialCode').val(m.materialcode || '');
                    $('#editedmaterialhsncode').val(m.materialhsncode || '');
                    $('#editedmaterialQty').val(m.materialqty || '');
                    $('#editedmaterialSPU').val(m.materialspu || '');
                    $('#editedmaterialMRP').val(m.materialmrp || '');
                    $('#editedmaterialGST').val(m.materialgst || '');
                    $('#editedmaterialDiscount').val(m.materialdiscount || '');

                    // Dropdown values
                    $('#editedmaterialCategory').val(m.catid || '');
                    $('#editedsubCategory').val(m.subcatid || '');
                    $('#editedmaterialbrand').val(m.brandid || '');
                    $('#editedunit').val(m.unitid || '');
                    $('#editedunitFactor').val(m.unitfactorid || '');
                    $('#editedthickness').val(m.thicknessid || '');
                    $('#editedRotation').val(m.grainsid || '');

                    // Calculations
                    calculateEditedMaterialPriceAndValue();

                    // Image preview
                    if (m.materialimage) {
                        const imgPath = config.developmentPath + "/Admin/img/materials/" + m.materialimage;
                        $('#editedPreviewImage').attr('src', imgPath);
                        $('#existing_image').val(m.materialimage);
                    } else {
                        $('#editedPreviewImage').attr('src', '');
                        $('#existing_image').val('');
                    }
                }
            });
        }

        // =============================================
        // LOAD DROPDOWNS
        // =============================================
        function loadEditedMaterialCategories() {
            const url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
            $('#editedmaterialCategory').empty().append('<option hidden disabled selected value>-- select category --</option>');

            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#editedmaterialCategory').append(`<option value="${value.itemcatid}">${value.itemcatname}</option>`);
                });
            });
        }

        function loadEditedMaterialBrands() {
            const InputType = 1; // Material
            const url = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputType;
            $('#editedmaterialbrand').empty().append('<option hidden disabled selected value>-- select brand --</option>');

            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#editedmaterialbrand').append(`<option value="${value.brandid}">${value.brandname}</option>`);
                });
            });
        }

        function loadEditedMaterialUnits() {
            const url = config.developmentPath + "/Admin/Controller/unitsContoller.php";
            $('#editedunit').empty().append('<option hidden disabled selected value>-- select unit --</option>');

            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#editedunit').append(`<option value="${value.unitId}">${value.unitName}</option>`);
                });
            });
        }

        function loadEditedThickness() {
            // Add your thickness loading logic here
        }

        function loadEditedGrains() {
            // Add your grains loading logic here
        }

        // =============================================
        // AUTO-CALCULATIONS
        // =============================================
        function calculateEditedMaterialPriceAndValue() {
            let MRP = parseFloat($('#editedmaterialMRP').val()) || 0;
            let Discount = parseFloat($('#editedmaterialDiscount').val()) || 0;
            let GST = parseFloat($('#editedmaterialGST').val()) || 0;
            let SPU = parseFloat($('#editedmaterialSPU').val()) || 0;
            let factor = parseFloat($('#editedunitFactor').find(":selected").text()) || 1;

            let price = MRP * factor;

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100));
            }

            let amount = MRP * factor;

            $('#editedmaterialAmount').val(amount.toFixed(2));
            $('#editedmaterialPrice').val(price.toFixed(2));
            $('#editedmaterialTotalValue').val((price * SPU).toFixed(2));
        }

        // Trigger calculations on input changes
        $('#editedmaterialMRP, #editedmaterialDiscount, #editedmaterialGST, #editedmaterialSPU, #editedunitFactor')
            .on('keyup blur change', calculateEditedMaterialPriceAndValue);

        // =============================================
        // UNIT FACTOR LOADING
        // =============================================
        $('#editedunit').on('change', function () {
            $('#editedunitFactor').empty().append('<option hidden disabled selected value>-- select factor --</option>');

            const unitFactorurl = config.developmentPath + "/Admin/Controller/unitFactorController.php/?unitId=" + this.value;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#editedunitFactor').append(`<option value="${value.unitFactorId}">${value.unitFactor}</option>`);
                });
            });
        });

        // =============================================
        // CATEGORY SUBCATEGORY LOADING
        // =============================================
        $('#editedmaterialCategory').on('change', function () {
            $('#editedsubCategory').empty().append('<option hidden disabled selected value>-- select subcategory --</option>');

            const catId = this.value;
            if (!catId) return;

            const url = config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php/?catId=" + catId;
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#editedsubCategory').append(`<option value="${value.itemsubcatid}">${value.itemsubcatname}</option>`);
                });
            });
        });

        // =============================================
        // FORM SUBMISSION
        // =============================================
        $('#editeditemdetails_form').on('submit', function (event) {
            event.preventDefault();

            const $btn = $('#editbutton');
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Saving...');

            const formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/materialController.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    let json;
                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        $('#edit_form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        $btn.prop('disabled', false);
                        $btn.html('<i class="fas fa-save me-1"></i>Save Changes');
                        return;
                    }

                    if (json.status === "success") {
                        $('#edit_form_message').html(`<div class="alert alert-success">${json.message || "Material updated successfully!"}</div>`);

                        setTimeout(() => {
                            $('#edititemdetailsModal').modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            location.reload();
                        }, 800);
                    } else {
                        $('#edit_form_message').html(`<div class="alert alert-danger">${json.message || "Error updating material."}</div>`);
                    }

                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-save me-1"></i>Save Changes');
                },
                error: function (xhr, status, error) {
                    $('#edit_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    $btn.prop('disabled', false);
                    $btn.html('<i class="fas fa-save me-1"></i>Save Changes');
                }
            });
        });

        // =============================================
        // IMAGE PREVIEW
        // =============================================
        $('#editedmaterialimage').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#editedPreviewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });


    }); // end document ready
</script>