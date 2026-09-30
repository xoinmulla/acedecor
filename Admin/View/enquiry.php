<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include "enquiryNavigation.php";
require_once("../DB Operations/enquiryOps.php");
require_once("../Model/enquirymodel.php");
?>
<style>
    .topbar {
        position: relative;
        z-index: 1050;
    }

    .form-check-input {
        position: static;
        margin-top: .3rem;
        margin-left: 0rem;
    }

    /* =========================================================
       RESPONSIVE ENQUIRY PAGE
       Visual/layout only - existing PHP/JS logic is untouched.
       ========================================================= */

    .enquiry-page {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    .enquiry-page .page-title {
        font-size: clamp(1.35rem, 2.2vw, 2rem);
        line-height: 1.25;
        word-break: break-word;
    }

    .enquiry-page .card {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .enquiry-page .card-header {
        padding: .85rem 1rem !important;
    }

    .enquiry-page .card-header>.row {
        align-items: center;
    }

    .enquiry-page .actions-dropdown {
        display: flex;
        justify-content: flex-end;
    }

    .enquiry-page .table-responsive-custom {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .enquiry-page #enquiry_table {
        width: 100% !important;
        min-width: 1050px;
        margin-bottom: 0;
    }

    .enquiry-page #enquiry_table th,
    .enquiry-page #enquiry_table td {
        vertical-align: middle;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    .enquiry-page #enquiry_table th {
        white-space: nowrap;
        font-weight: 500;
    }

    .enquiry-page #enquiry_table td:last-child {
        min-width: 145px;
        white-space: nowrap;
        overflow: visible;
    }

    .enquiry-page #enquiry_table .dropdown-menu {
        z-index: 2000;
    }

    /* DataTables controls */
    .enquiry-page .dataTables_wrapper {
        width: 100%;
        max-width: 100%;
    }

    .enquiry-page .dataTables_wrapper .dataTables_length,
    .enquiry-page .dataTables_wrapper .dataTables_filter {
        margin-bottom: .75rem;
    }

    .enquiry-page .dataTables_wrapper .dataTables_filter input {
        max-width: 100%;
    }

    /* =========================================================
   RESPONSIVE MODALS
   Layout only - existing modal design untouched
   ========================================================= */

    .modal {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Default / Desktop */
    .modal .modal-dialog {
        width: calc(100% - 30px);
        max-width: 700px;
        margin: 15px auto;
        box-sizing: border-box;
    }

    .modal .modal-dialog.modal-lg {
        width: calc(100% - 30px);
        max-width: 700px;
    }

    .modal .modal-content {
        width: 100%;
        max-width: 100%;
        max-height: calc(100vh - 30px);
        overflow: hidden;
        box-sizing: border-box;
    }

    .modal .modal-body {
        max-height: calc(100vh - 150px);
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .modal .modal-footer {
        flex-wrap: wrap;
        gap: .5rem;
    }

    .modal .modal-footer .btn {
        margin: 0;
    }

    .modal .form-control,
    .modal .form-select,
    .modal select,
    .modal textarea {
        max-width: 100%;
        box-sizing: border-box;
    }

    .modal table {
        width: 100%;
        max-width: 100%;
    }

    /* Header = draggable area */
    .modal .modal-header {
        cursor: move;
        user-select: none;
        -webkit-user-select: none;
        touch-action: none;
    }

    /* =========================================================
   TABLET
   ========================================================= */

    @media (min-width: 768px) and (max-width: 991.98px) {

        .modal .modal-dialog,
        .modal .modal-dialog.modal-lg {
            width: calc(100% - 30px) !important;
            max-width: 650px !important;
            margin: 15px auto !important;
        }

        .modal .modal-content {
            max-height: calc(100vh - 30px);
        }

        .modal .modal-body {
            max-height: calc(100vh - 145px);
        }
    }

    /* =========================================================
   MOBILE
   ========================================================= */

    @media (max-width: 767.98px) {

        .modal .modal-dialog,
        .modal .modal-dialog.modal-lg {
            width: calc(100vw - 16px) !important;
            max-width: none !important;
            margin: 8px auto !important;
        }

        .modal .modal-content {
            width: 100%;
            max-width: 100%;
            max-height: calc(100vh - 16px);
            border-radius: .5rem;
        }

        .modal .modal-body {
            max-height: calc(100vh - 135px);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal .modal-header {
            padding: .75rem;
            cursor: move;
            touch-action: none;
        }

        .modal .modal-footer {
            padding: .75rem;
        }

        .modal .modal-footer .btn {
            flex: 1 1 auto;
            min-width: 100px;
        }
    }

    /* =========================================================
   VERY SMALL PHONES
   ========================================================= */

    @media (max-width: 399.98px) {

        .modal .modal-dialog,
        .modal .modal-dialog.modal-lg {
            width: calc(100vw - 10px) !important;
            max-width: none !important;
            margin: 5px auto !important;
        }

        .modal .modal-content {
            max-height: calc(100vh - 10px);
        }

        .modal .modal-body {
            max-height: calc(100vh - 125px);
        }

        .modal .modal-footer {
            padding: .6rem;
        }

        .modal .modal-footer .btn {
            min-width: 0;
        }
    }

    /* =========================================================
   EDIT ENQUIRY MODAL
   Keep existing visual design.
   Only make its outer dialog responsive.
   ========================================================= */

    #editEnquiryModal .modal-dialog {
        width: calc(100% - 30px) !important;
        max-width: 900px !important;
        margin: 15px auto !important;
        box-sizing: border-box;
    }

    #editEnquiryModal .modal-content {
        width: 100%;
        max-width: 100%;
        max-height: calc(100vh - 30px);
        overflow: hidden;
    }

    #editEnquiryModal .ee-body {
        max-height: calc(100vh - 155px);
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Tablet */
    @media (min-width: 768px) and (max-width: 991.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100% - 30px) !important;
            max-width: 850px !important;
            margin: 15px auto !important;
        }

        #editEnquiryModal .ee-body {
            max-height: calc(100vh - 145px);
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100vw - 16px) !important;
            max-width: none !important;
            margin: 8px auto !important;
        }

        #editEnquiryModal .modal-content {
            max-height: calc(100vh - 16px);
        }

        #editEnquiryModal .ee-body {
            max-height: calc(100vh - 135px);
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px;
        }

        #editEnquiryModal .ee-field-row {
            display: block;
        }

        #editEnquiryModal .ee-field-row label {
            display: block;
            width: 100%;
            min-width: 0;
            text-align: left;
            margin-bottom: 5px;
        }

        #editEnquiryModal .ee-field-input {
            width: 100%;
        }
    }

    /* Very small phones */
    @media (max-width: 399.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100vw - 10px) !important;
            margin: 5px auto !important;
        }

        #editEnquiryModal .modal-content {
            max-height: calc(100vh - 10px);
        }

        #editEnquiryModal .ee-body {
            max-height: calc(100vh - 125px);
            padding: 8px;
        }
    }
</style>
<style>
    /* =========================================================
       EDIT ENQUIRY MODAL
       Same design language as Edit Customer
       Scoped ONLY to #editEnquiryModal
       ========================================================= */

    #editEnquiryModal .ee-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    /* ---------- Header ---------- */
    #editEnquiryModal .ee-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #editEnquiryModal .ee-header .ee-header-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    #editEnquiryModal .ee-header h4 {
        margin: 0;
        flex-grow: 1;
        font-weight: 600;
        font-size: 1.2rem;
    }

    #editEnquiryModal .ee-header .close {
        color: #fff;
        opacity: .9;
        font-size: 1.6rem;
        font-weight: 400;
        text-shadow: none;
        margin: 0;
        padding: 0;
    }

    #editEnquiryModal .ee-header .close:hover {
        opacity: 1;
    }

    /* ---------- Body ---------- */
    #editEnquiryModal .ee-body {
        background: #f4f5fb;
        padding: 20px;
    }

    /* ---------- Panels ---------- */
    #editEnquiryModal .ee-panel {
        background: #fff;
        border-radius: 10px;
        padding: 18px 22px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        height: 100%;
    }

    #editEnquiryModal .ee-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #4a3fbf;
        font-size: 1.02rem;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 2px solid #6a5cf5;
    }

    #editEnquiryModal .ee-panel-title .ee-icon-badge {
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 50%;
        background: #ece9fd;
        color: #6a5cf5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
    }

    /* ---------- Form Fields ---------- */
    #editEnquiryModal .ee-field-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }

    #editEnquiryModal .ee-field-row label {
        width: 125px;
        min-width: 125px;
        flex-shrink: 0;
        text-align: right;
        font-weight: 600;
        color: #4a4a5a;
        font-size: .9rem;
        margin: 0;
    }

    #editEnquiryModal .ee-field-input {
        flex-grow: 1;
        min-width: 0;
    }

    #editEnquiryModal .ee-field-row .form-control,
    #editEnquiryModal .ee-field-row .form-select {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #dcdfe6;
        font-size: .9rem;
        padding: 9px 12px;
        min-height: 40px;
    }

    #editEnquiryModal .ee-field-row .form-control:focus,
    #editEnquiryModal .ee-field-row .form-select:focus {
        border-color: #6a5cf5;
        box-shadow: 0 0 0 .15rem rgba(106, 92, 245, .12);
    }

    /* ---------- Looking For ---------- */
    #editEnquiryModal .ee-interest-wrap {
        max-height: 460px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    #editEnquiryModal #edit_interestList {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    /* Works with existing checkbox HTML generated by JS */
    #editEnquiryModal #edit_interestList>* {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 4px;
        border-bottom: 1px solid #f0f0f5;
        font-size: .95rem;
        color: #333;
        width: 100%;
        min-height: 48px;
    }

    #editEnquiryModal #edit_interestList>*:last-child {
        border-bottom: none;
    }

    #editEnquiryModal #edit_interestList input[type="checkbox"] {
        all: revert !important;
        -webkit-appearance: checkbox !important;
        appearance: checkbox !important;

        display: inline-block !important;

        width: 20px !important;
        height: 20px !important;
        min-width: 20px !important;

        margin: 0 !important;
        opacity: 1 !important;
        position: static !important;

        pointer-events: auto !important;
        accent-color: #4a6cf7;

        cursor: pointer !important;
        flex-shrink: 0 !important;
    }

    #editEnquiryModal #edit_interestList input[type="checkbox"]:disabled {
        cursor: not-allowed !important;
        opacity: .6 !important;
    }

    #editEnquiryModal #edit_interestList label {
        margin: 0;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
    }

    /* If your JS adds ec-locked / data-locked */
    #editEnquiryModal .ee-locked::after {
        content: "\f023";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #f0a020;
        margin-left: auto;
        font-size: .85rem;
    }

    /* Disabled selected items */
    #editEnquiryModal #edit_interestList input[type="checkbox"]:disabled+label,
    #editEnquiryModal #edit_interestList *:has(input[type="checkbox"]:disabled) label {
        color: #a8a8c0;
    }

    /* ---------- Footer ---------- */
    #editEnquiryModal .ee-footer {
        background: #fff;
        padding: 14px 24px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #eee;
    }

    #editEnquiryModal .ee-footer .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 9px 22px;
    }

    #editEnquiryModal .btn-ee-save {
        background: #29b06b;
        border-color: #29b06b;
        color: #fff;
    }

    #editEnquiryModal .btn-ee-save:hover {
        background: #22985c;
        border-color: #22985c;
        color: #fff;
    }

    #editEnquiryModal .btn-ee-close {
        background: #e5546b;
        border-color: #e5546b;
        color: #fff;
    }

    #editEnquiryModal .btn-ee-close:hover {
        background: #d9435a;
        border-color: #d9435a;
        color: #fff;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    /* Tablet */
    @media (max-width: 991.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100% - 30px);
            max-width: 850px;
            margin: 15px auto;
        }

        #editEnquiryModal .ee-body {
            padding: 15px;
        }

        #editEnquiryModal .ee-panel {
            padding: 16px;
        }

        #editEnquiryModal .ee-field-row label {
            width: 115px;
            min-width: 115px;
        }
    }


    /* Mobile */
    @media (max-width: 767.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100% - 20px);
            max-width: none;
            margin: 10px auto;
        }

        #editEnquiryModal .modal-content {
            max-height: calc(100vh - 20px);
        }

        #editEnquiryModal .ee-header {
            padding: 13px 15px;
            gap: 10px;
        }

        #editEnquiryModal .ee-header .ee-header-icon {
            width: 34px;
            height: 34px;
            min-width: 34px;
            font-size: 1rem;
        }

        #editEnquiryModal .ee-header h4 {
            font-size: 1.05rem;
        }

        #editEnquiryModal .ee-body {
            padding: 12px;
            max-height: calc(100vh - 145px);
            overflow-y: auto;
        }

        #editEnquiryModal .ee-panel {
            padding: 15px;
            margin-bottom: 12px;
        }

        #editEnquiryModal .ee-panel-title {
            font-size: .95rem;
            margin-bottom: 12px;
        }

        /* Stack label + input */
        #editEnquiryModal .ee-field-row {
            display: block;
            margin-bottom: 13px;
        }

        #editEnquiryModal .ee-field-row label {
            display: block;
            width: 100%;
            min-width: 0;
            text-align: left;
            margin-bottom: 5px;
            font-size: .85rem;
        }

        #editEnquiryModal .ee-field-input {
            width: 100%;
        }

        #editEnquiryModal .ee-field-row .form-control,
        #editEnquiryModal .ee-field-row .form-select {
            width: 100%;
            font-size: .88rem;
        }

        #editEnquiryModal .ee-interest-wrap {
            max-height: 280px;
        }

        #editEnquiryModal .ee-footer {
            padding: 12px 15px;
            flex-direction: row;
        }

        #editEnquiryModal .ee-footer .btn {
            flex: 1;
            padding: 9px 12px;
        }
    }


    /* Small phones */
    @media (max-width: 399.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100% - 10px);
            margin: 5px auto;
        }

        #editEnquiryModal .ee-body {
            padding: 8px;
        }

        #editEnquiryModal .ee-panel {
            padding: 12px;
        }

        #editEnquiryModal .ee-header {
            padding: 11px 12px;
        }

        #editEnquiryModal .ee-header h4 {
            font-size: 1rem;
        }

        #editEnquiryModal .ee-footer {
            padding: 10px;
            gap: 7px;
        }

        #editEnquiryModal .ee-footer .btn {
            font-size: .85rem;
        }
    }

    /* =========================================================
   EDIT ENQUIRY - ALWAYS CENTERED
   Does NOT affect other modals
   ========================================================= */

    #editEnquiryModal .modal-dialog {
        width: calc(100% - 2rem) !important;
        max-width: 900px !important;
        margin: 1.75rem auto !important;

        position: relative !important;
        left: auto !important;
        top: auto !important;

        transform: none !important;
    }

    /* Keep the modal vertically centered by Bootstrap */
    #editEnquiryModal.show .modal-dialog {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* Tablet */
    @media (min-width: 768px) and (max-width: 991.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100% - 2rem) !important;
            max-width: 850px !important;

            margin: 1.5rem auto !important;

            position: relative !important;
            left: auto !important;
            top: auto !important;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100% - 1rem) !important;
            max-width: 500px !important;

            margin: .5rem auto !important;

            position: relative !important;
            left: auto !important;
            top: auto !important;

            transform: none !important;
        }

        #editEnquiryModal .modal-content {
            max-height: calc(100vh - 1rem);
        }
    }

    /* Very small phones */
    @media (max-width: 399.98px) {

        #editEnquiryModal .modal-dialog {
            width: calc(100% - .5rem) !important;
            margin: .25rem auto !important;
        }
    }
</style>
<div class="enquiry-page">
    <h1 class="h3 mb-4 text-gray-800">Enquiry Management</h1>
    <!-- DataTales Example -->
    <span id="message"></span>
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-white"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 text-white" style="font-size: 1.2rem;">Enquiry
                        List</h6>
                </div>
                <div class="col actions-dropdown" align="right">

                    <div class='dropdown'>
                        <button class='btn btn-light dropdown-toggle' type='button' id='dropdownMenu2'
                            data-toggle='dropdown' aria-expanded='false'>
                            Actions
                        </button>

                        <div class='dropdown-menu' aria-labelledby='dropdownMenu2'>

                            <?php if (hasActionPermission('enquiry', 'enquiry_category')) { ?>
                                <a class='btn btn-primary dropdown-item' href="enqcategory.php" role='button'>
                                    <i class="fas fa-plus-circle"></i>
                                    Enquiry Category
                                </a>
                            <?php } ?>

                            <?php if (hasActionPermission('enquiry', 'create_enquiry')) { ?>
                                <button class='btn btn-primary dropdown-item' data-toggle='modal'
                                    data-target='#addEnquiryModal' role='button'>
                                    <i class="fas fa-plus-circle"></i>
                                    Create Enquiry
                                </button>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="table-responsive-custom">
                    <table class="table table-bordered" id="enquiry_table" width="100%" cellspacing="0">
                        <thead align="center">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Country</th>
                                <th>Phone</th>
                                <th>DOE</th>
                                <th>Status</th>
                                <th style='display:none'>Email</th>
                                <th>Enrolled</th>
                                <th>Enquiry</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $enquiryList = DBenq::getAllenq();

                            foreach ($enquiryList as $enquiry) {
                                ?>
                                <tr>

                                    <td><?= $enquiry->get_enqname() ?></td>
                                    <td><?= $enquiry->get_enqaddress() ?></td>
                                    <td align="center"><?= $enquiry->getEnq_Country() ?></td>
                                    <td align="center"><?= $enquiry->get_enqphone() ?></td>
                                    <td align="center"><?= $enquiry->getCreatedDate() ?></td>
                                    <td align="center"><?= $enquiry->getStatus() ?></td>

                                    <td style="display:none"><?= $enquiry->get_enqemail() ?></td>

                                    <td align="center">
                                        <?= $enquiry->get_isCustomerCreated() == 1 ? 'Yes' : 'No' ?>
                                    </td>

                                    <td>
                                        <?php
                                        foreach ($enquiry->get_interestList() as $interest) {
                                            echo "<ul><li>$interest</li></ul>";
                                        }
                                        ?>
                                    </td>

                                    <td>

                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>

                                            <div class="dropdown-menu">

                                                <?php if (hasActionPermission('enquiry', 'follow_up')) { ?>
                                                    <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                        data-target="#enqModal" data-id="<?= $enquiry->get_id() ?>">
                                                        <i class="fas fa-comment-dots"></i>
                                                        Follow Up
                                                    </button>
                                                <?php } ?>

                                                <?php if (hasActionPermission('enquiry', 'enquiry_info')) { ?>
                                                    <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                        data-target="#infoEnquiryModal" data-id="<?= $enquiry->get_id() ?>">
                                                        <i class="fas fa-info"></i>
                                                        Enquiry Info
                                                    </button>
                                                <?php } ?>

                                                <?php if (hasActionPermission('enquiry', 'create_customer')) { ?>
                                                    <button class="btn btn-primary dropdown-item" <?php if ($enquiry->get_isCustomerCreated() == 1)
                                                        echo "style='pointer-events:none;'"; ?> data-toggle="modal"
                                                        data-target="#customerModal" data-id="<?= $enquiry->get_id() ?>">
                                                        <i class="fas fa-angle-double-right"></i>
                                                        Create Customer
                                                    </button>
                                                <?php } ?>

                                                <?php if (hasActionPermission('enquiry', 'delete_enquiry')) { ?>
                                                    <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                        data-target="#deleteEnquiryModal" data-id="<?= $enquiry->get_id() ?>"
                                                        <?= ($enquiry->get_isCustomerCreated() == 1 ? "style='pointer-events:none;opacity:0.5;'" : "") ?>>
                                                        <i class="fas fa-trash-alt"></i>
                                                        Delete Enquiry
                                                    </button>
                                                <?php } ?>

                                                <?php if (hasActionPermission('enquiry', 'edit_enquiry')) { ?>
                                                    <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                        data-target="#editEnquiryModal" data-id="<?= $enquiry->get_id() ?>">
                                                        <i class="fas fa-edit"></i>
                                                        Edit Enquiry
                                                    </button>
                                                <?php } ?>

                                            </div>
                                        </div>

                                    </td>

                                </tr>
                                <?php
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
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="" method="POST" id="customer_form" enctype="multipart/form-data"
            action="../Controller/customerController.php">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-8">
                        <label for="customerName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="customerName" name="customerName"
                            style="text-transform: capitalize;">
                        <input type="hidden" class="form-control" id="enqId" name="enqId" />
                    </div>
                    <div class="col-md-4">
                        <label for="customerDov" class="form-label">Date of Enquiry</label>
                        <input type="date" class="form-control" id="customerDov" name="customerDov" required>
                    </div>
                    <div class="col-md-8">
                        <label for="customerEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customerEmail" name="customerEmail">
                    </div>
                    <div class="col-md-4">
                        <label for="customerPhone" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="customerPhone" name="customerPhone">
                    </div>
                    <div class="col-md-8">
                        <label for="customerAddress" class="form-label">Address line</label>
                        <input type="text" class="form-control" id="customerAddress" placeholder="1234 Main St"
                            name="customerAddress" style="text-transform: capitalize;">
                    </div>
                    <div class="col-md-4">
                        <label for="customerCity" class="form-label">City</label>
                        <input type="text" class="form-control" id="customerCity" name="customerCity"
                            style="text-transform: capitalize;">
                    </div>
                    <div class="col-md-4">
                        <label for="State" class="form-label">State</label>
                        <select id="customerState" name="customerState" class="form-select" required>
                            <option selected="selected" value="">Select State</option>
                            <option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
                            <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
                            <option value="ASSAM">ASSAM</option>
                            <option value="BIHAR">BIHAR</option>
                            <option value="CHANDIGARH">CHANDIGARH</option>
                            <option value="CHATTISGARH">CHATTISGARH</option>
                            <option value="DADRA & NAGAR HAVELI">DADRA & NAGAR HAVELI</option>
                            <option value="DAMAN & DIU">DAMAN & DIU</option>
                            <option value="DELHI">DELHI</option>
                            <option value="GOA">GOA</option>
                            <option value="GUJARAT">GUJARAT</option>
                            <option value="HARYANA">HARYANA</option>
                            <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                            <option value="JAMMU & KASHMIR">JAMMU & KASHMIR</option>
                            <option value="JHARKHAND">JHARKHAND</option>
                            <option value="KARNATAKA">KARNATAKA</option>
                            <option value="KERALA">KERALA</option>
                            <option value="LAKSHADWEEP">LAKSHADWEEP</option>
                            <option value="MADHYA PRADESH">MADHYA PRADESH</option>
                            <option value="MAHARASHTRA">MAHARASHTRA</option>
                            <option value="MANIPUR">MANIPUR</option>
                            <option value="MEGHALAYA">MEGHALAYA</option>
                            <option value="MIZORAM">MIZORAM</option>
                            <option value="NAGALAND">NAGALAND</option>
                            <option value="ODISHA">ODISHA</option>
                            <option value="PONDICHERRY">PONDICHERRY</option>
                            <option value="PUNJAB">PUNJAB</option>
                            <option value="RAJASTHAN">RAJASTHAN</option>
                            <option value="SIKKIM">SIKKIM</option>
                            <option value="TAMIL NADU">TAMIL NADU</option>
                            <option value="TELANGANA">TELANGANA</option>
                            <option value="TRIPURA">TRIPURA</option>
                            <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                            <option value="UTTARAKHAND">UTTARAKHAND</option>
                            <option value="WEST BENGAL">WEST BENGAL</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="Country" class="form-label">Country</label>
                        <select id="selectCountry" name="SelectCountry" class="form-select">
                            <option value="India">India</option>
                        </select>
                    </div>


                    <div class="col-md-8">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                            data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                            data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="createCustomer">Create Customer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="addEnquiryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <form class="" method="POST" id="customer_form" enctype="multipart/form-data"
            action="../Controller/newenquiry.php">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Enquiry Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required maxlength="150">
                                <input type="hidden" name="isAdmin" id="isAdmin" value="true">
                            </div>

                            <div class="col-md-6">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="phone" class="form-control" required maxlength="10">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Address</label>
                                <input type="text" name="address" id="address" class="form-control" maxlength="500">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>City</label>
                                <input type="text" name="city" id="city" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Country</label>
                                <select id="selectedCountry" name="SelectCountry" class="form-control">
                                    <option value="India">India</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>State</label>
                                <select name="SelectState" id="state" class="form-control">
                                    <option value="">Select State</option>
                                    <!-- Your state options -->
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Looking For</label>
                                <div id="checkboxes" class="border rounded p-2" style="height:120px;overflow-y:auto;">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="createCustomer">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="enqModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <form method="post" id="followup_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title text-white">Follow Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="followuptable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>

                                    Follwed By

                                </th>
                                <th>

                                    Comments

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
                            <div class="col-md-12">
                                <fieldset>
                                    <legend>Comments:</legend>
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here"
                                            id="followcomment" style="height: 100px"
                                            data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup"
                                            name="followcomment"></textarea>
                                        <label for="followcomment">Comments</label>
                                    </div>
                                    <input type="hidden" name="followenqid" id="followenqid" value="">
                                    <fieldset>
                            </div>
                        </div>
                    </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="FollowupBtn">FollowUp</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=enqcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data"
            action="../Controller/enqcategoryController.php">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="catname" id="catname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="catcreatedby" id="catcreatedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcatmodifiedby" id="itemcatmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="deleteEnquiryModal" tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_enquiry_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this user.
                    </p>
                    <input type="hidden" name="deleteenqid" id="deleteenqid" value="">
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
<div class="modal fade" id=infoEnquiryModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h4 class="modal-title text-white" id="modal_title">Customer Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerName">Name</label>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title" id="displaycustomerName"></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerDov">Date Of Enquiry</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerDov"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerEmail">Email</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerEmail"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerPhone">Mobile Number</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerPhone"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerAddress">Address</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerAddress"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerCity">City</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerCity"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerState">State</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerState"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerCountry">Country</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerCountry"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerLooking">Looking For</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycustomerLooking"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editEnquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form method="POST" id="edit_enquiry_form" enctype="multipart/form-data" action="../Controller/newenquiry.php">

            <div class="modal-content ee-content">

                <!-- ================= HEADER ================= -->
                <div class="ee-header">

                    <div class="ee-header-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>

                    <h4 class="modal-title">
                        Edit Enquiry
                    </h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>

                </div>


                <!-- ================= BODY ================= -->
                <div class="ee-body">

                    <!-- Existing hidden fields - DO NOT REMOVE -->
                    <input type="hidden" name="action" value="update">

                    <input type="hidden" name="enqid" id="edit_enqid">


                    <div class="row g-3">

                        <!-- =================================================
                             LEFT : ENQUIRY INFORMATION
                             ================================================= -->
                        <div class="col-lg-7">

                            <div class="ee-panel">

                                <div class="ee-panel-title">

                                    <span class="ee-icon-badge">
                                        <i class="fas fa-user"></i>
                                    </span>

                                    Enquiry Information

                                </div>


                                <!-- Name -->
                                <div class="ee-field-row">

                                    <label for="edit_name">
                                        Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="ee-field-input">

                                        <input type="text" class="form-control" name="name" id="edit_name" required>

                                    </div>

                                </div>


                                <!-- Email -->
                                <div class="ee-field-row">

                                    <label for="edit_email">
                                        Email
                                    </label>

                                    <div class="ee-field-input">

                                        <input type="email" class="form-control" name="email" id="edit_email">

                                    </div>

                                </div>


                                <!-- Phone -->
                                <div class="ee-field-row">

                                    <label for="edit_phone">
                                        Phone
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="ee-field-input">

                                        <input type="text" class="form-control" name="phone" id="edit_phone" required
                                            maxlength="10">

                                    </div>

                                </div>


                                <!-- Address -->
                                <div class="ee-field-row">

                                    <label for="edit_address">
                                        Address
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="ee-field-input">

                                        <input type="text" class="form-control" name="address" id="edit_address"
                                            required>

                                    </div>

                                </div>


                                <!-- City -->
                                <div class="ee-field-row">

                                    <label for="edit_city">
                                        City
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="ee-field-input">

                                        <input type="text" class="form-control" name="city" id="edit_city" required>

                                    </div>

                                </div>


                                <!-- State -->
                                <div class="ee-field-row">

                                    <label for="edit_state">
                                        State
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="ee-field-input">

                                        <select class="form-select" name="SelectState" id="edit_state" required>

                                            <option value="">
                                                Select State
                                            </option>

                                            <option>ANDHRA PRADESH</option>
                                            <option>ARUNACHAL PRADESH</option>
                                            <option>ASSAM</option>
                                            <option>BIHAR</option>
                                            <option>CHANDIGARH</option>
                                            <option>CHHATTISGARH</option>
                                            <option>DELHI</option>
                                            <option>GOA</option>
                                            <option>GUJARAT</option>
                                            <option>HARYANA</option>
                                            <option>HIMACHAL PRADESH</option>
                                            <option>JHARKHAND</option>
                                            <option>KARNATAKA</option>
                                            <option>KERALA</option>
                                            <option>MADHYA PRADESH</option>
                                            <option>MAHARASHTRA</option>
                                            <option>MANIPUR</option>
                                            <option>MEGHALAYA</option>
                                            <option>MIZORAM</option>
                                            <option>NAGALAND</option>
                                            <option>ODISHA</option>
                                            <option>PUNJAB</option>
                                            <option>RAJASTHAN</option>
                                            <option>SIKKIM</option>
                                            <option>TAMIL NADU</option>
                                            <option>TELANGANA</option>
                                            <option>TRIPURA</option>
                                            <option>UTTAR PRADESH</option>
                                            <option>UTTARAKHAND</option>
                                            <option>WEST BENGAL</option>

                                        </select>

                                    </div>

                                </div>


                                <!-- Country -->
                                <div class="ee-field-row">

                                    <label for="edit_country">
                                        Country
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="ee-field-input">

                                        <select class="form-select" name="SelectCountry" id="edit_country">

                                            <option value="India">
                                                India
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- =================================================
                             RIGHT : LOOKING FOR
                             ================================================= -->
                        <div class="col-lg-5">

                            <div class="ee-panel">

                                <div class="ee-panel-title">

                                    <span class="ee-icon-badge">
                                        <i class="fas fa-tags"></i>
                                    </span>

                                    Looking For

                                </div>


                                <div class="ee-interest-wrap">

                                    <!--
                                        IMPORTANT:
                                        Existing JS populates this element.
                                        ID intentionally unchanged.
                                    -->
                                    <div id="edit_interestList">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================= FOOTER ================= -->
                <div class="ee-footer">

                    <button type="button" class="btn btn-ee-save"
                        onclick="document.getElementById('edit_enquiry_form').requestSubmit();">

                        <i class="fas fa-save"></i>
                        Save Changes

                    </button>

                    <button type="button" class="btn btn-ee-close" data-dismiss="modal">

                        <i class="fas fa-times"></i>
                        Close

                    </button>

                </div>

            </div>

        </form>

    </div>
</div>
<script>
    $(document).ready(function () {
        debugger;

        var select = document.getElementById("selectCountry");
        var select2 = document.getElementById("selectedCountry");

        var countries = new Array("Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antarctica",
            "Antigua and Barbuda",
            "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
            "Barbados", "Belarus", "Belgium", "Belize",
            "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei",
            "Bulgaria",
            "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde",
            "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros",
            "Congo, Democratic Republic", "Congo, Republic of the",
            "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
            "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt",
            "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France",
            "Gabon",
            "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guatemala",
            "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong",
            "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq",
            "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
            "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho",
            "Liberia", "Libya",
            "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia",
            "Maldives", "Mali",
            "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova",
            "Mongolia", "Morocco", "Monaco", "Mozambique",
            "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua",
            "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Panama", "Papua New Guinea", "Paraguay", "Peru",
            "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia",
            "Rwanda", "Samoa", "San Marino", " Sao Tome", "Saudi Arabia", "Senegal", "Serbia and Montenegro",
            "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia",
            "Solomon Islands", "Somalia", "South Africa", "Spain", "Sri Lanka", "Sudan", "Suriname",
            "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand",
            "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
            "Turkmenistan", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom",
            "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia",
            "Zimbabwe");

        for (var i = 0; i < countries.length; i++) {

            var option = document.createElement("option");
            var txt = document.createTextNode(countries[i]);
            option.appendChild(txt);
            option.setAttribute("value", countries[
                i]); //for every turn of the loop set the value attribute to corresponding country name
            select.insertBefore(option, select.lastChild);
        }
        for (var i = 0; i < countries.length; i++) {

            var option = document.createElement("option");
            var txt = document.createTextNode(countries[i]);
            option.appendChild(txt);
            option.setAttribute("value", countries[
                i]); //for every turn of the loop set the value attribute to corresponding country name
            select2.insertBefore(option, select2.lastChild);
        }


        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;

        document.getElementById("customerDov").value = today;



        $('#deleteEnqCat').click(function () { });
        $('#closeEnqCat').click(function () {
            $('#deletenqcatModal').trigger('hidden.bs.modal');
            $('#deletenqcatModal').toggle();
            $('.modal-backdrop').remove();
            $('#deletenqcatModal').removeAttr('style');
            $('#deletenqcatModal').attr('style', 'display:none');
            $('#deletenqcatModal').attr('aria-hidden', 'true');
            $('#deletenqcatModal').removeAttr('aria-modal');
            $('#deletenqcatModal').removeClass('show');
            $('.modal-backdrop:last').remove();
            $('#deletenqcatModal').removeAttr('role');
        });
        $('#deletenqcatModal').on('show.bs.modal', function (e) {
            reloadCategory();
        });
        $('#confirmModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#enqcatId').val(rowid);
        });

        function reloadCategory() {
            var uniturl = config.developmentPath +
                "/Admin/Controller/enqcategoryController.php";
            $.getJSON(uniturl, function (data) {
                $("#enqCategoryTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#enqCategoryTable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.CatId
                        }));
                    $('#enqCategoryTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.catname
                        }));
                    $('#enqCategoryTable tr:last').
                        append($(document.createElement('td')).append(
                            '<a class="btn btn-danger" id="deleteEnqCat" data-toggle="modal" data-target="#confirmModal" data-id="' +
                            value.CatId + '">delete</a>'
                        ));
                });
            });
        }

        $('#deleteLineItembutton').click(function () {
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/enqcategoryController.php/",
                method: "POST",
                data: {
                    id: $('#enqcatId').val(),
                    action: 'delete'
                }
            });
            reloadCategory();
            $('#confirmModal').attr('aria-hidden', 'true');
            $('#confirmModal').removeAttr('style');
            $('#confirmModal').removeAttr('aria-modal');
            $('#confirmModal').removeClass('show');
            $('#confirmModal').attr('style', 'display:none');
            $('.modal-backdrop:last').remove();
            $('#confirmModal').removeAttr('role');
        });
        debugger;
        var fetchsubcaturl = config.developmentPath +
            "/Admin/Controller/enqcategoryController.php?type=enquiry";

        $.getJSON(fetchsubcaturl, function (data) {
            $.each(data, function (index, value) {
                debugger;
                $('#checkboxes').append(
                    $(document.createElement('div')).prop({
                        class: 'form-check'
                    }).append(
                        $(document.createElement('label')).prop({
                            for: 'myCheckBox'
                        }).html(value.catname)
                    ).append(
                        $(document.createElement('input')).prop({
                            class: 'form-check-input',
                            id: 'myCheckBox',
                            name: 'interest_list[]',
                            value: value.CatId,
                            type: 'checkbox'
                        })
                    ).append(document.createElement('br')));
            });
        });
        var baseurl = ""
        var dataTable = $('#enquiry_table').DataTable({

        });

        $('#enqModal').on('show.bs.modal', function (e) {
            $('#FollowupBtn').addClass('disabled');
            var rowid = $(e.relatedTarget).data('id');
            $('#followenqid').val(rowid);
            var contactUrl = config.developmentPath + "/Admin/Controller/followupController.php/?id=" +
                rowid;
            $.getJSON(contactUrl, function (data) {
                $("#followuptable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#followuptable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.followupid
                        }));

                    $('#followuptable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.followup_by
                        }));
                    $('#followuptable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.followup_comments
                        }));
                    $('#followuptable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.followup_on
                        }));
                });
            });
        });


        $('#selectCountry').on('change', function (e) {
            debugger;
            if ($('#selectCountry').val() != 'India') {
                $('#customerState').val() == 'Other';
            }
        });

        $(document).on('blur', '#followcomment', function () {
            debugger;
            if ($("#followcomment").val() == "") {
                $("#FollowupBtn").addClass('disabled');
            } else {
                $("#FollowupBtn").removeClass('disabled');
            }
        });

        $("#followup_form").submit(function (event) {
            var formData = {
                followenqid: $("#followenqid").val(),
                followupBy: $("#followupBy").val(),
                followcomment: $("#followcomment").val(),
                enqStatus: 'Attended'
            };
            if (followcomment == "") {
                $("#FollowupBtn").addClass('disabled');
            }
            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/followupController.php/",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                location.reload(true);
                console.log(data);
            });
        });
        $('#infoEnquiryModal').on('show.bs.modal', function (e) {

            var rowid = $(e.relatedTarget).data('id');

            $.ajax({
                url: "../Controller/newenquiry.php",
                type: "GET",
                data: { action: "fetch", id: rowid },
                dataType: "json",
                success: function (data) {
                    console.log("Created Date from DB:", data.created_date);

                    $('#displaycustomerName').text(data.name);
                    $('#displaycustomerDov').text(data.created_date);
                    $('#displaycustomerEmail').text(data.email);
                    $('#displaycustomerPhone').text(data.phone);
                    $('#displaycustomerAddress').text(data.address);
                    $('#displaycustomerCity').text(data.city);
                    $('#displaycustomerState').text(data.state);
                    $('#displaycustomerCountry').text(data.country);

                    // convert interest array to readable text
                    if (data.interests && data.interests.length > 0) {
                        $('#displaycustomerLooking').text(data.interests.join(", "));
                    } else {
                        $('#displaycustomerLooking').text("Not Specified");
                    }
                }
            });
        });


        $('#customerModal').on('show.bs.modal', function (e) {

            var rowid = $(e.relatedTarget).data('id');
            $('#enqId').val(rowid);

            $.ajax({

                url: "../Controller/newenquiry.php",
                type: "GET",
                data: { action: "fetch", id: rowid },
                dataType: "json",
                success: function (data) {
                    console.log("State from DB:", data.state);

                    $('#customerName').val(data.name);
                    $('#customerEmail').val(data.email);
                    $('#customerAddress').val(data.address);
                    $('#customerCity').val(data.city);   // ✅ THIS FIXES IT
                    $('#customerState').val(data.state);
                    $('#customerPhone').val(data.phone);
                    $('#selectCountry').val(data.country);

                }
            });
        });



        $('#deleteEnquiryModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#deleteenqid').val(rowid);
        });
        $('#deletebutton').click(function () {
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/newenquiry.php/",
                method: "POST",
                data: {
                    id: $('#deleteenqid').val(),
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

        // ==================== EDIT ENQUIRY ====================
        // ==================== EDIT ENQUIRY ====================
        $(function () {

            $('#editEnquiryModal').on('show.bs.modal', function (e) {

                console.log("Edit modal triggered");

                const rowid = $(e.relatedTarget).data('id');
                $('#edit_enqid').val(rowid);
                let quotedCategories = [];

                $.ajax({
                    url: "../Controller/quotationController.php",
                    type: "GET",
                    data: { checkQuoteByEnq: rowid },
                    async: false,
                    success: function (res) {
                        quotedCategories = res.map(x => String(x)); // convert to string
                    }
                });
                // 🔥 STEP 1: Get quoted items from table (customer.php)
                // STEP 1: Get quoted items



                // 🔥 STEP 2: Fetch enquiry data
                $.ajax({
                    url: "../Controller/newenquiry.php",
                    type: "GET",
                    data: { action: "fetch", id: rowid },
                    dataType: "json",

                    success: function (data) {

                        if (data && !data.error) {

                            // ✅ Fill fields
                            $('#edit_name').val(data.name || "");
                            $('#edit_email').val(data.email || "");
                            $('#edit_phone').val(data.phone || "");
                            $('#edit_address').val(data.address || "");
                            $('#edit_city').val(data.city || "");
                            $('#edit_state').val(data.state || "");
                            $('#edit_country').val(data.country || "India");

                            // ✅ Selected items
                            const selected = new Set(
                                (data.interests || []).map(x => String(x).toLowerCase())
                            );

                            // 🔥 STEP 3: Load categories
                            $.getJSON("../Controller/enqcategoryController.php?type=enquiry", function (categories) {

                                $('#edit_interestList').empty();

                                categories.forEach(cat => {

                                    const idStr = String(cat.CatId).toLowerCase();
                                    const nameStr = String(cat.catname).toLowerCase();

                                    const isChecked = selected.has(idStr) || selected.has(nameStr);

                                    // ✅ FINAL LOGIC: disable only quoted items

                                    const catId = String(cat.CatId);

                                    // ✅ check if this category is quoted
                                    const shouldDisable = quotedCategories.includes(catId);

                                    const html = `
<div class="form-check">

    <input class="form-check-input"
           type="checkbox"
           name="interest_list[]"
           value="${catId}"
           ${isChecked ? 'checked' : ''}
           ${shouldDisable ? 'disabled' : ''}>

    ${shouldDisable ? `<input type="hidden" name="interest_list[]" value="${catId}">` : ''}

    <label class="form-check-label">
        ${cat.catname} ${shouldDisable ? '🔒' : ''}
    </label>

</div>`;

                                    $('#edit_interestList').append(html);
                                });
                            });

                        } else {
                            alert("Error loading enquiry");
                        }
                    },

                    error: function (xhr) {
                        console.error("AJAX Error:", xhr.status);
                    }
                });
            });
        });
        $('#edit_enquiry_form').submit(function (e) {
            e.preventDefault(); // stop normal submit

            let formData = new FormData(this);

            $.ajax({
                url: "../Controller/newenquiry.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {

                    let res = JSON.parse(response);

                    if (res.status === "success") {

                        $('#message').html(`
            <div class="alert alert-success">
                ${res.message}
            </div>
        `);

                        $('#editEnquiryModal').modal('hide');

                        setTimeout(() => $('#message').html(''), 3000);
                    }
                }
            });
        });

        /* =========================================================
   RESPONSIVE DRAGGABLE MODALS
   Mouse + Touch + Pen
   Does not modify existing modal/form logic
   ========================================================= */

        (function () {

            function setupDraggableModal(modal) {

                var dialog = modal.querySelector('.modal-dialog');
                var header = modal.querySelector('.modal-header');

                if (!dialog || !header) {
                    return;
                }

                /* Prevent duplicate initialization */
                if (dialog.dataset.dragReady === '1') {
                    return;
                }

                dialog.dataset.dragReady = '1';

                var isDragging = false;
                var startX = 0;
                var startY = 0;
                var startLeft = 0;
                var startTop = 0;

                header.addEventListener('pointerdown', function (e) {

                    /*
                     * Do not start dragging when clicking
                     * buttons, links, inputs, selects, textareas etc.
                     */
                    if (
                        e.target.closest(
                            'button, a, input, select, textarea, option, label'
                        )
                    ) {
                        return;
                    }

                    var rect = dialog.getBoundingClientRect();

                    /*
                     * Convert the dialog to viewport-based positioning
                     * only after Bootstrap has displayed it.
                     */
                    dialog.style.position = 'fixed';
                    dialog.style.margin = '0';
                    dialog.style.transform = 'none';

                    /*
                     * Make sure the current position is inside viewport.
                     */
                    var viewportWidth = window.innerWidth;
                    var viewportHeight = window.innerHeight;

                    var dialogWidth = dialog.offsetWidth;
                    var dialogHeight = dialog.offsetHeight;

                    var currentLeft = Math.max(
                        0,
                        Math.min(
                            rect.left,
                            viewportWidth - dialogWidth
                        )
                    );

                    var currentTop = Math.max(
                        0,
                        Math.min(
                            rect.top,
                            viewportHeight - dialogHeight
                        )
                    );

                    dialog.style.left = currentLeft + 'px';
                    dialog.style.top = currentTop + 'px';

                    startX = e.clientX;
                    startY = e.clientY;

                    startLeft = currentLeft;
                    startTop = currentTop;

                    isDragging = true;

                    header.setPointerCapture(e.pointerId);

                    e.preventDefault();
                });

                header.addEventListener('pointermove', function (e) {

                    if (!isDragging) {
                        return;
                    }

                    var deltaX = e.clientX - startX;
                    var deltaY = e.clientY - startY;

                    var viewportWidth = window.innerWidth;
                    var viewportHeight = window.innerHeight;

                    var dialogWidth = dialog.offsetWidth;
                    var dialogHeight = dialog.offsetHeight;

                    /*
                     * Keep the complete dialog inside the viewport.
                     */
                    var maxLeft = Math.max(
                        0,
                        viewportWidth - dialogWidth
                    );

                    var maxTop = Math.max(
                        0,
                        viewportHeight - dialogHeight
                    );

                    var newLeft = Math.max(
                        0,
                        Math.min(
                            startLeft + deltaX,
                            maxLeft
                        )
                    );

                    var newTop = Math.max(
                        0,
                        Math.min(
                            startTop + deltaY,
                            maxTop
                        )
                    );

                    dialog.style.left = newLeft + 'px';
                    dialog.style.top = newTop + 'px';

                    e.preventDefault();
                });

                function stopDragging(e) {

                    if (!isDragging) {
                        return;
                    }

                    isDragging = false;

                    try {
                        if (e && header.hasPointerCapture(e.pointerId)) {
                            header.releasePointerCapture(e.pointerId);
                        }
                    } catch (error) {
                        // Ignore pointer-release errors.
                    }
                }

                header.addEventListener('pointerup', stopDragging);
                header.addEventListener('pointercancel', stopDragging);

            }


            /*
             * When Bootstrap finishes opening the modal,
             * position it safely inside the viewport.
             */
            $('.modal').on('shown.bs.modal', function () {

                var modal = this;
                var dialog = modal.querySelector('.modal-dialog');

                if (!dialog) {
                    return;
                }

                /*
                 * Reset previous drag position whenever modal opens.
                 * This prevents an old position from being reused
                 * after changing screen size.
                 */
                dialog.style.position = 'fixed';
                dialog.style.margin = '0';
                dialog.style.transform = 'none';

                /*
                 * Get actual Bootstrap-calculated position.
                 */
                var rect = dialog.getBoundingClientRect();

                var viewportWidth = window.innerWidth;
                var viewportHeight = window.innerHeight;

                var dialogWidth = dialog.offsetWidth;
                var dialogHeight = dialog.offsetHeight;

                /*
                 * Center horizontally.
                 */
                var left = (viewportWidth - dialogWidth) / 2;

                /*
                 * Center vertically when possible.
                 */
                var top = (viewportHeight - dialogHeight) / 2;

                /*
                 * Never allow negative coordinates.
                 */
                left = Math.max(
                    0,
                    Math.min(
                        left,
                        viewportWidth - dialogWidth
                    )
                );

                top = Math.max(
                    0,
                    Math.min(
                        top,
                        viewportHeight - dialogHeight
                    )
                );

                dialog.style.left = left + 'px';
                dialog.style.top = top + 'px';

                setupDraggableModal(modal);

            });


            /*
             * Reposition open modal when browser/device size changes.
             */
            $(window).on('resize orientationchange', function () {

                $('.modal.show').each(function () {

                    var dialog = this.querySelector('.modal-dialog');

                    if (!dialog) {
                        return;
                    }

                    var viewportWidth = window.innerWidth;
                    var viewportHeight = window.innerHeight;

                    var dialogWidth = dialog.offsetWidth;
                    var dialogHeight = dialog.offsetHeight;

                    var currentLeft = parseFloat(dialog.style.left) || 0;
                    var currentTop = parseFloat(dialog.style.top) || 0;

                    var maxLeft = Math.max(
                        0,
                        viewportWidth - dialogWidth
                    );

                    var maxTop = Math.max(
                        0,
                        viewportHeight - dialogHeight
                    );

                    dialog.style.left =
                        Math.max(
                            0,
                            Math.min(currentLeft, maxLeft)
                        ) + 'px';

                    dialog.style.top =
                        Math.max(
                            0,
                            Math.min(currentTop, maxTop)
                        ) + 'px';

                });

            });

        })();

    });
</script>