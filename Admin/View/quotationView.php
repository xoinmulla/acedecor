<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('quotationNavigation.php');
require_once("../DB Operations/quotationOps.php");
require_once("../Model/quotationModel.php");
?>
<style>
    /* =========================================================
   QUOTATION MODAL - FINAL RESPONSIVE + DRAG FIX
   ---------------------------------------------------------
   IMPORTANT:
   - Does NOT change PHP
   - Does NOT change AJAX
   - Does NOT change calculations
   - Does NOT change existing desktop design
   - Uses existing jQuery UI draggable
   ========================================================= */


/* =========================================================
   COMMON MODAL SAFETY
   ========================================================= */

#viewModal .modal-dialog,
#editquoteModal .modal-dialog,
#customerModal .modal-dialog,
#inputListModal .modal-dialog,
#deleteQuotationModal .modal-dialog {

    box-sizing: border-box;

    max-width: calc(100vw - 24px);

}


/* Keep content inside dialog */

#viewModal .modal-content,
#editquoteModal .modal-content,
#customerModal .modal-content,
#inputListModal .modal-content,
#deleteQuotationModal .modal-content {

    width: 100%;
    max-width: 100%;

    box-sizing: border-box;

}


/* Modal header is the drag handle */

#viewModal .modal-header,
#editquoteModal .modal-header,
#customerModal .modal-header,
#inputListModal .modal-header,
#deleteQuotationModal .modal-header {

    cursor: move;

    user-select: none;
    -webkit-user-select: none;

}


/* Never make the close button part of the drag action */

#viewModal .modal-header .close,
#editquoteModal .modal-header .close,
#customerModal .modal-header .close,
#inputListModal .modal-header .close,
#deleteQuotationModal .modal-header .close {

    cursor: pointer;

}


/* =========================================================
   DESKTOP
   1024px AND ABOVE
   ---------------------------------------------------------
   Existing desktop design is preserved.
   ========================================================= */

@media (min-width: 1024px) {

    #viewModal .modal-dialog,
    #editquoteModal .modal-dialog {

        width: 75%;
        max-width: 1200px;

    }

    #customerModal .modal-dialog,
    #inputListModal .modal-dialog {

        max-width: 900px;

    }

    #deleteQuotationModal .modal-dialog {

        max-width: 500px;

    }

}


/* =========================================================
   TABLET
   768px - 1023px
   ========================================================= */

@media (min-width: 768px) and (max-width: 1023.98px) {


    /* -----------------------------------------------------
       MODAL WIDTH
       ----------------------------------------------------- */

    #viewModal .modal-dialog,
    #editquoteModal .modal-dialog,
    #customerModal .modal-dialog,
    #inputListModal .modal-dialog,
    #deleteQuotationModal .modal-dialog {

        width: calc(100vw - 24px) !important;

        max-width: calc(100vw - 24px) !important;

        margin: 12px auto !important;

        box-sizing: border-box;

    }


    /* -----------------------------------------------------
       MODAL HEIGHT
       ----------------------------------------------------- */

    #viewModal .modal-content,
    #editquoteModal .modal-content,
    #customerModal .modal-content,
    #inputListModal .modal-content,
    #deleteQuotationModal .modal-content {

        max-height: calc(100vh - 24px);

        display: flex;

        flex-direction: column;

        overflow: hidden;

    }


    /* -----------------------------------------------------
       BODY SCROLL
       ----------------------------------------------------- */

    #viewModal .modal-body,
    #editquoteModal .modal-body,
    #customerModal .modal-body,
    #inputListModal .modal-body,
    #deleteQuotationModal .modal-body {

        min-height: 0;

        max-height: calc(100vh - 120px);

        overflow-y: auto;

        overflow-x: hidden;

        -webkit-overflow-scrolling: touch;

    }


    /* =====================================================
       EDIT QUOTATION FORM
       -----------------------------------------------------
       IMPORTANT FIX FOR YOUR SCREENSHOT
       ===================================================== */

    #editquoteModal .modal-body > .form-group > .row {

        display: grid;

        grid-template-columns:
            110px minmax(0, 1fr)
            110px minmax(0, 1fr);

        column-gap: 12px;

        row-gap: 12px;

        margin-left: 0;
        margin-right: 0;

    }


    /*
     * Bootstrap col-md-2 is overridden ONLY inside
     * Edit Quotation at tablet size.
     */

    #editquoteModal .modal-body > .form-group > .row > .col-md-2 {

        width: auto !important;

        max-width: none !important;

        flex: none !important;

        padding-left: 0;
        padding-right: 0;

        min-width: 0;

    }


    /*
     * Labels
     */

    #editquoteModal .modal-body > .form-group > .row > label {

        display: flex;

        align-items: center;

        justify-content: flex-end;

        text-align: right !important;

        min-width: 0;

        overflow-wrap: anywhere;

    }


    /*
     * Inputs
     */

    #editquoteModal .modal-body > .form-group > .row
    > .col-md-2
    .form-control,

    #editquoteModal .modal-body > .form-group > .row
    > .col-md-2
    select,

    #editquoteModal .modal-body > .form-group > .row
    > .col-md-2
    textarea {

        width: 100%;

        max-width: 100%;

        min-width: 0;

        box-sizing: border-box;

    }


    /*
     * Textareas should have enough height.
     */

    #editquoteModal textarea.form-control {

        min-height: 70px;

        resize: vertical;

    }


    


    /* =====================================================
       VIEW QUOTATION
       ===================================================== */

    #viewModal .display-line-item-scroll {

        width: 100%;

        max-width: 100%;

        overflow-x: auto !important;

        overflow-y: auto !important;

        max-height: 300px;

        -webkit-overflow-scrolling: touch;

    }


    #viewModal #displaylineItemTable {

        width: 900px !important;

        min-width: 900px !important;

    }


    /* =====================================================
       CUSTOMER INFO
       ===================================================== */

    #customerModal .modal-body {

        overflow-x: auto;

    }


    #customerModal #quotationdetails_table {

        min-width: 650px;

        width: 650px;

    }


    /* =====================================================
       BOQ
       ===================================================== */

    #inputListModal .boq-table-wrapper {

        width: 100%;

        max-width: 100%;

        overflow-x: auto !important;

        overflow-y: auto !important;

        max-height: 350px;

        -webkit-overflow-scrolling: touch;

    }


    #inputListModal .boq-table-wrapper .boq-table {

        min-width: 900px;

        width: 900px;

    }


    /* =====================================================
       FOOTER
       ===================================================== */

    #viewModal .modal-footer,
    #editquoteModal .modal-footer,
    #customerModal .modal-footer,
    #inputListModal .modal-footer,
    #deleteQuotationModal .modal-footer {

        display: flex;

        flex-wrap: wrap;

        gap: 8px;

    }

}


/* =========================================================
   MOBILE
   <= 767px
   ========================================================= */

@media (max-width: 767.98px) {


    /* -----------------------------------------------------
       MODAL WIDTH
       ----------------------------------------------------- */

    #viewModal .modal-dialog,
    #editquoteModal .modal-dialog,
    #customerModal .modal-dialog,
    #inputListModal .modal-dialog,
    #deleteQuotationModal .modal-dialog {

        width: calc(100vw - 12px) !important;

        max-width: calc(100vw - 12px) !important;

        margin: 6px auto !important;

        box-sizing: border-box;

    }


    /* -----------------------------------------------------
       MODAL HEIGHT
       ----------------------------------------------------- */

    #viewModal .modal-content,
    #editquoteModal .modal-content,
    #customerModal .modal-content,
    #inputListModal .modal-content,
    #deleteQuotationModal .modal-content {

        max-height: calc(100vh - 12px);

        display: flex;

        flex-direction: column;

        overflow: hidden;

    }


    /* -----------------------------------------------------
       HEADER
       ----------------------------------------------------- */

    #viewModal .modal-header,
    #editquoteModal .modal-header,
    #customerModal .modal-header,
    #inputListModal .modal-header,
    #deleteQuotationModal .modal-header {

        padding: 12px 14px;

        flex: 0 0 auto;

    }


    #viewModal .modal-title,
    #editquoteModal .modal-title,
    #customerModal .modal-title,
    #inputListModal .modal-title,
    #deleteQuotationModal .modal-title {

        font-size: 1.05rem;

        line-height: 1.3;

    }


    /* -----------------------------------------------------
       BODY
       ----------------------------------------------------- */

    #viewModal .modal-body,
    #editquoteModal .modal-body,
    #customerModal .modal-body,
    #inputListModal .modal-body,
    #deleteQuotationModal .modal-body {

        min-height: 0;

        max-height: calc(100vh - 120px);

        padding: 12px !important;

        overflow-y: auto;

        overflow-x: hidden;

        -webkit-overflow-scrolling: touch;

    }


    /* =====================================================
       EDIT QUOTATION
       ===================================================== */

    /*
     * One field per row.
     *
     * This is the important mobile fix.
     */

    #editquoteModal .modal-body > .form-group > .row {

        display: block;

        margin-left: 0;

        margin-right: 0;

    }


    #editquoteModal .modal-body > .form-group > .row > label {

        display: block;

        width: 100% !important;

        max-width: 100% !important;

        flex: none !important;

        padding: 0 !important;

        margin-bottom: 5px;

        text-align: left !important;

    }


    #editquoteModal .modal-body > .form-group > .row
    > .col-md-2 {

        display: block;

        width: 100% !important;

        max-width: 100% !important;

        flex: none !important;

        padding: 0 !important;

        margin-bottom: 12px;

    }


    #editquoteModal .modal-body
    .form-control,

    #editquoteModal .modal-body
    select,

    #editquoteModal .modal-body
    textarea {

        width: 100%;

        max-width: 100%;

        box-sizing: border-box;

    }


    #editquoteModal textarea.form-control {

        min-height: 80px;

    }


    


    /* =====================================================
       VIEW QUOTATION
       ===================================================== */

    #viewModal .display-line-item-scroll {

        width: 100%;

        max-width: 100%;

        max-height: 260px;

        overflow-x: auto !important;

        overflow-y: auto !important;

        -webkit-overflow-scrolling: touch;

    }


    #viewModal #displaylineItemTable {

        width: 850px !important;

        min-width: 850px !important;

    }


    /* =====================================================
       CUSTOMER
       ===================================================== */

    #customerModal .modal-body {

        overflow-x: hidden;

    }


    #customerModal #quotationdetails_table {

        min-width: 650px;

        width: 650px;

    }


    #customerModal .row {

        margin-left: 0;

        margin-right: 0;

    }


    #customerModal .col-8 {

        width: 100%;

        max-width: 100%;

        flex: 0 0 100%;

    }


    /* =====================================================
       BOQ
       ===================================================== */

    #inputListModal .boq-table-wrapper {

        width: 100%;

        max-width: 100%;

        max-height: 280px;

        overflow-x: auto !important;

        overflow-y: auto !important;

        -webkit-overflow-scrolling: touch;

    }


    #inputListModal .boq-table-wrapper .boq-table {

        width: 850px;

        min-width: 850px;

    }


    /* =====================================================
       FOOTER
       ===================================================== */

    #viewModal .modal-footer,
    #editquoteModal .modal-footer,
    #customerModal .modal-footer,
    #inputListModal .modal-footer,
    #deleteQuotationModal .modal-footer {

        padding: 10px 12px;

        display: flex;

        flex-wrap: wrap;

        gap: 6px;

    }


    #viewModal .modal-footer .btn,
    #editquoteModal .modal-footer .btn,
    #customerModal .modal-footer .btn,
    #inputListModal .modal-footer .btn,
    #deleteQuotationModal .modal-footer .btn {

        margin: 0;

        max-width: 100%;

    }

}


/* =========================================================
   VERY SMALL PHONES
   <= 400px
   ========================================================= */

@media (max-width: 399.98px) {


    #viewModal .modal-dialog,
    #editquoteModal .modal-dialog,
    #customerModal .modal-dialog,
    #inputListModal .modal-dialog,
    #deleteQuotationModal .modal-dialog {

        width: calc(100vw - 8px) !important;

        max-width: calc(100vw - 8px) !important;

        margin: 4px auto !important;

    }


    #viewModal .modal-body,
    #editquoteModal .modal-body,
    #customerModal .modal-body,
    #inputListModal .modal-body,
    #deleteQuotationModal .modal-body {

        padding: 8px !important;

    }


    #viewModal .modal-title,
    #editquoteModal .modal-title,
    #customerModal .modal-title,
    #inputListModal .modal-title,
    #deleteQuotationModal .modal-title {

        font-size: 1rem;

    }


    #viewModal .modal-footer .btn,
    #editquoteModal .modal-footer .btn,
    #customerModal .modal-footer .btn,
    #inputListModal .modal-footer .btn,
    #deleteQuotationModal .modal-footer .btn {

        font-size: .85rem;

        padding: 6px 10px;

    }

}
    .card-body #quote_table th {
        font-weight: 500;
    }

    /* Scrollable BOQ table inside Input List modal */
    #inputListModal .boq-table-wrapper {
        max-height: 450px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #dee2e6;
    }

    /* Keep BOQ header visible while scrolling */
    #inputListModal .boq-table-wrapper .boq-table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #343a40;
        color: #fff;
    }

    /* Keep table width properly aligned */
    #inputListModal .boq-table-wrapper .boq-table {
        margin-bottom: 0;
        min-width: 900px;
    }

    .modal-dialog {
        max-width: 1200px;
        width: 75%;
    }

    .table-responsive {
        overflow-x: auto;
        overflow-y: visible;
        -webkit-overflow-scrolling: touch;
    }

    #editedlineItemTable thead {
        background-color: grey;
        color: whitesmoke;
        position: sticky;
        top: 0;
    }

    .pad {
        padding-right: .5rem;
    }

    .boq-wrapper {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .boq-header {
        display: flex;
        justify-content: space-between;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .company-block h2 {
        margin: 0;
        font-weight: bold;
    }

    .company-block p {
        margin: 5px 0 0;
        font-size: 13px;
    }

    .boq-title h3 {
        margin: 0;
        text-align: right;
        font-weight: bold;
    }

    .boq-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .boq-table {
        width: 100%;
        border-collapse: collapse;
    }

    .boq-table th {
        background: #343a40;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    .boq-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    .boq-table img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }

    .boq-footer {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
    }

    .signature .sign-line {
        margin-top: 40px;
        width: 200px;
        border-bottom: 1px solid #000;
    }

    .thank-you {
        align-self: flex-end;
        font-style: italic;
    }

    /* Scrollable Quote Info line-item table */
    .display-line-item-scroll {
        max-height: 350px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #dee2e6;
    }

    /* Keep table width intact while scrolling */
    .display-line-item-scroll #displaylineItemTable {
        width: 100%;
        margin-bottom: 0;
    }

    /* Keep table header visible while scrolling */
    .display-line-item-scroll #displaylineItemTable thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: #f8f9fa;
    }




    /* =========================================================
   QUOTATION LIST - TABLET / MOBILE RESPONSIVE FIX
   ---------------------------------------------------------
   Desktop (1024px and above): existing layout is preserved.
   Below 1024px: the quotation table keeps readable column
   widths and scrolls horizontally inside its container.
   DataTables search / length / pagination remain functional.
   No PHP / AJAX / JavaScript logic is changed.
   ========================================================= */

    /* IMPORTANT:
   The existing rule sets .table-responsive to overflow: visible.
   That prevents Bootstrap's horizontal table scrolling.
   Keep it unchanged above 1024px, but enable scrolling below it.
*/

    @media (max-width: 1023.98px) {

        /* Prevent the quotation card itself from creating page-wide
       horizontal overflow. */
        .card:has(#quote_table) {
            max-width: 100%;
            overflow: hidden;
        }

        .card:has(#quote_table) .card-body {
            min-width: 0;
            max-width: 100%;
            overflow: hidden;
        }

        /* Main quotation table viewport */
        .card:has(#quote_table) .table-responsive {
            display: block;
            width: 100%;
            max-width: 100%;
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: auto;
        }

        /* DataTables wrapper must be allowed to become wider than
       the viewport without widening the page itself. */
        .card:has(#quote_table) .dataTables_wrapper {
            width: 100%;
            min-width: 0;
        }

        /* Keep the many quotation columns readable.
       Hidden PHP/DataTables columns are unaffected. */
        .card:has(#quote_table) #quote_table {
            min-width: 1180px !important;
            width: 1180px !important;
            max-width: none !important;
            table-layout: auto;
        }

        .card:has(#quote_table) #quote_table th,
        .card:has(#quote_table) #quote_table td {
            white-space: nowrap;
        }

        /* Give long text columns enough room instead of squeezing them. */
        .card:has(#quote_table) #quote_table th:nth-child(2),
        .card:has(#quote_table) #quote_table td:nth-child(2) {
            min-width: 125px;
        }

        .card:has(#quote_table) #quote_table th:nth-child(3),
        .card:has(#quote_table) #quote_table td:nth-child(3) {
            min-width: 145px;
        }

        .card:has(#quote_table) #quote_table th:nth-child(7),
        .card:has(#quote_table) #quote_table td:nth-child(7) {
            min-width: 140px;
        }

        .card:has(#quote_table) #quote_table th:nth-child(8),
        .card:has(#quote_table) #quote_table td:nth-child(8) {
            min-width: 190px;
            white-space: normal;
            word-break: normal;
        }

        .card:has(#quote_table) #quote_table th:last-child,
        .card:has(#quote_table) #quote_table td:last-child {
            min-width: 120px;
        }

        /* DataTables controls */
        .card:has(#quote_table) .dataTables_length,
        .card:has(#quote_table) .dataTables_filter {
            margin-bottom: 10px;
        }

        .card:has(#quote_table) .dataTables_filter {
            text-align: left;
        }

        .card:has(#quote_table) .dataTables_filter input {
            max-width: 100%;
        }

        .card:has(#quote_table) .dataTables_info {
            white-space: normal;
            margin-top: 10px;
        }

        .card:has(#quote_table) .dataTables_paginate {
            margin-top: 10px;
            white-space: nowrap;
        }
    }

    /* Tablet */
    @media (min-width: 768px) and (max-width: 1023.98px) {

        .card:has(#quote_table) .card-body {
            padding-left: 12px;
            padding-right: 12px;
        }

        .card:has(#quote_table) #quote_table {
            min-width: 1180px !important;
            width: 1180px !important;
        }

        .card:has(#quote_table) .dataTables_length,
        .card:has(#quote_table) .dataTables_filter {
            display: inline-block;
            vertical-align: middle;
        }

        .card:has(#quote_table) .dataTables_filter {
            float: right;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {

        .card:has(#quote_table) .card-body {
            padding-left: 8px;
            padding-right: 8px;
        }

        .card:has(#quote_table) .table-responsive {
            margin-left: 0;
            margin-right: 0;
        }

        .card:has(#quote_table) #quote_table {
            min-width: 1180px !important;
            width: 1180px !important;
        }

        /* Stack DataTables controls cleanly on phones. */
        .card:has(#quote_table) .dataTables_length,
        .card:has(#quote_table) .dataTables_filter {
            float: none !important;
            display: block;
            width: 100%;
            text-align: left;
        }

        .card:has(#quote_table) .dataTables_length {
            margin-bottom: 8px;
        }

        .card:has(#quote_table) .dataTables_filter {
            margin-bottom: 10px;
        }

        .card:has(#quote_table) .dataTables_filter input {
            width: min(100%, 220px);
        }

        .card:has(#quote_table) .dataTables_info,
        .card:has(#quote_table) .dataTables_paginate {
            float: none !important;
            display: block;
            width: 100%;
        }

        .card:has(#quote_table) .dataTables_paginate {
            text-align: left;
        }
    }

    /* Very small phones */
    @media (max-width: 480px) {

        .card:has(#quote_table) .card-header {
            padding-left: 12px;
            padding-right: 12px;
        }

        .card:has(#quote_table) .card-body {
            padding-left: 5px;
            padding-right: 5px;
        }

        .card:has(#quote_table) .dataTables_length select {
            max-width: 80px;
        }

        .card:has(#quote_table) .dataTables_filter input {
            width: 100%;
            max-width: 220px;
        }
    }

    /* =========================================================
   QUOTATION PAGE - FINAL RESPONSIVE MODAL SYSTEM
   =========================================================
   Desktop >= 1024px:
   - Existing layout remains unchanged.

   Tablet <= 1023px:
   - Modal fits viewport.
   - Modal body scrolls vertically.
   - Tables scroll independently.
   - Draggable modal continues working.

   Mobile <= 767px:
   - Modal uses almost full available width.
   - Form columns stack.
   - Tables remain readable through internal scrolling.
   - Footer buttons wrap.
   ========================================================= */


    /* =========================================================
   COMMON MODAL BASE
   ========================================================= */

    #viewModal .modal-content,
    #editquoteModal .modal-content,
    #customerModal .modal-content,
    #inputListModal .modal-content,
    #deleteQuotationModal .modal-content {
        display: flex;
        flex-direction: column;
        max-height: calc(100vh - 40px);
        overflow: hidden;
    }

    #viewModal .modal-header,
    #editquoteModal .modal-header,
    #customerModal .modal-header,
    #inputListModal .modal-header,
    #deleteQuotationModal .modal-header {
        flex: 0 0 auto;
    }

    #viewModal .modal-footer,
    #editquoteModal .modal-footer,
    #customerModal .modal-footer,
    #inputListModal .modal-footer,
    #deleteQuotationModal .modal-footer {
        flex: 0 0 auto;
    }


    /* =========================================================
   MODAL BODY
   ========================================================= */

    #viewModal .modal-body,
    #editquoteModal .modal-body,
    #customerModal .modal-body,
    #inputListModal .modal-body,
    #deleteQuotationModal .modal-body {
        min-height: 0;
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }


    /* =========================================================
   DRAG HANDLE
   Existing jQuery UI draggable logic remains untouched.
   ========================================================= */

    #viewModal .modal-header,
    #editquoteModal .modal-header,
    #customerModal .modal-header,
    #inputListModal .modal-header,
    #deleteQuotationModal .modal-header {
        cursor: move;
        user-select: none;
    }

    #viewModal .modal-header .close,
    #editquoteModal .modal-header .close,
    #customerModal .modal-header .close,
    #inputListModal .modal-header .close,
    #deleteQuotationModal .modal-header .close {
        cursor: pointer;
    }


    /* =========================================================
   VIEW / QUOTE INFO TABLE
   ========================================================= */

    #viewModal .display-line-item-scroll {
        width: 100%;
        max-width: 100%;
        max-height: 350px;
        overflow-x: auto;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    #viewModal #displaylineItemTable {
        min-width: 900px;
        width: 100%;
        margin-bottom: 0;
    }

    #viewModal #displaylineItemTable th,
    #viewModal #displaylineItemTable td {
        white-space: nowrap;
    }





    /* =========================================================
   CUSTOMER INFO
   ========================================================= */

    #customerModal .modal-body {
        overflow-y: auto;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /*
   Customer quotation history must remain readable.
*/
    #customerModal #quotationdetails_table {
        min-width: 650px;
        width: 100%;
    }

    #customerModal #quotationdetails_table th,
    #customerModal #quotationdetails_table td {
        white-space: nowrap;
    }


    /* =========================================================
   INPUT LIST / BOQ
   ========================================================= */

    #inputListModal .modal-body {
        overflow-y: auto;
        overflow-x: hidden;
    }

    /*
   Your existing BOQ wrapper becomes the horizontal scroll
   container. This prevents the modal itself from becoming
   wider than the screen.
*/
    #inputListModal .boq-table-wrapper {
        width: 100%;
        max-width: 100%;
        max-height: 450px;
        overflow-x: auto !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch;
    }

    #inputListModal .boq-table-wrapper .boq-table {
        min-width: 900px;
        width: 100%;
        margin-bottom: 0;
    }

    #inputListModal .boq-table-wrapper .boq-table th,
    #inputListModal .boq-table-wrapper .boq-table td {
        white-space: nowrap;
    }


    /* =========================================================
   DELETE MODAL
   ========================================================= */

    #deleteQuotationModal .modal-body {
        overflow-y: auto;
        overflow-x: hidden;
    }


    /* =========================================================
   TABLET
   768px - 1023px
   ========================================================= */

    @media (min-width: 768px) and (max-width: 1023.98px) {

        /*
       IMPORTANT:
       Override Bootstrap modal-xl/modal-lg sizing.

       The existing jQuery UI draggable code can still
       calculate the dialog position normally.
    */

        #viewModal .modal-dialog,
        #editquoteModal .modal-dialog,
        #customerModal .modal-dialog,
        #inputListModal .modal-dialog,
        #deleteQuotationModal .modal-dialog {

            width: calc(100vw - 40px) !important;
            max-width: calc(100vw - 40px) !important;

            margin: 20px auto !important;
        }


        /*
       Keep the modal inside the visible viewport.
    */

        #viewModal .modal-content,
        #editquoteModal .modal-content,
        #customerModal .modal-content,
        #inputListModal .modal-content,
        #deleteQuotationModal .modal-content {

            max-height: calc(100vh - 40px);
        }


        /*
       Slightly smaller modal header.
    */

        #viewModal .modal-header,
        #editquoteModal .modal-header,
        #customerModal .modal-header,
        #inputListModal .modal-header,
        #deleteQuotationModal .modal-header {

            padding: 14px 18px;
        }


        #viewModal .modal-title,
        #editquoteModal .modal-title,
        #customerModal .modal-title,
        #inputListModal .modal-title,
        #deleteQuotationModal .modal-title {

            font-size: 1.25rem;
        }


        /*
       Modal body gets a safe scroll area.
    */

        #viewModal .modal-body,
        #editquoteModal .modal-body,
        #customerModal .modal-body,
        #inputListModal .modal-body,
        #deleteQuotationModal .modal-body {

            max-height: calc(100vh - 135px);
            overflow-y: auto;
        }


        /*
       EDIT QUOTATION FORM
       Keep fields usable on tablet.
    */

        #editquoteModal .modal-body .form-group {
            margin-bottom: 12px;
        }


        #editquoteModal .modal-body .form-control,
        #editquoteModal .modal-body select,
        #editquoteModal .modal-body textarea {

            max-width: 100%;
        }


        /*
       BOQ table height on tablet.
    */

        #inputListModal .boq-table-wrapper {

            max-height: 360px;
        }


        /*
       Quote Info table height.
    */

        #viewModal .display-line-item-scroll {

            max-height: 300px;
        }


        /*
       Footer buttons can wrap.
    */

        #viewModal .modal-footer,
        #editquoteModal .modal-footer,
        #customerModal .modal-footer,
        #inputListModal .modal-footer,
        #deleteQuotationModal .modal-footer {

            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }


        #viewModal .modal-footer .btn,
        #editquoteModal .modal-footer .btn,
        #customerModal .modal-footer .btn,
        #inputListModal .modal-footer .btn,
        #deleteQuotationModal .modal-footer .btn {

            margin: 0;
        }
    }


    /* =========================================================
   MOBILE
   <= 767px
   ========================================================= */

    @media (max-width: 767.98px) {

        /*
       Modal occupies almost the complete phone width.
    */

        #viewModal .modal-dialog,
        #editquoteModal .modal-dialog,
        #customerModal .modal-dialog,
        #inputListModal .modal-dialog,
        #deleteQuotationModal .modal-dialog {

            width: calc(100vw - 16px) !important;
            max-width: calc(100vw - 16px) !important;

            margin: 8px auto !important;
        }


        /*
       Maximum modal height.
    */

        #viewModal .modal-content,
        #editquoteModal .modal-content,
        #customerModal .modal-content,
        #inputListModal .modal-content,
        #deleteQuotationModal .modal-content {

            max-height: calc(100vh - 16px);
            border-radius: 10px;
        }


        /*
       Smaller header.
    */

        #viewModal .modal-header,
        #editquoteModal .modal-header,
        #customerModal .modal-header,
        #inputListModal .modal-header,
        #deleteQuotationModal .modal-header {

            padding: 12px 14px;
            min-height: 52px;
        }


        #viewModal .modal-title,
        #editquoteModal .modal-title,
        #customerModal .modal-title,
        #inputListModal .modal-title,
        #deleteQuotationModal .modal-title {

            font-size: 1.05rem;
            line-height: 1.3;
        }


        /*
       Close button stays easy to tap.
    */

        #viewModal .modal-header .close,
        #editquoteModal .modal-header .close,
        #customerModal .modal-header .close,
        #inputListModal .modal-header .close,
        #deleteQuotationModal .modal-header .close {

            font-size: 1.6rem;
            padding: 4px 8px;
            margin: -4px -6px -4px auto;
        }


        /*
       Modal body.
    */

        #viewModal .modal-body,
        #editquoteModal .modal-body,
        #customerModal .modal-body,
        #inputListModal .modal-body,
        #deleteQuotationModal .modal-body {

            max-height: calc(100vh - 125px);
            padding: 12px !important;
            overflow-y: auto;
            overflow-x: hidden;
        }


        /* =====================================================
       EDIT QUOTATION - STACK FORM COLUMNS
       ===================================================== */

        #editquoteModal .modal-body .row {
            margin-left: 0;
            margin-right: 0;
        }


        #editquoteModal .modal-body [class*="col-"] {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
            padding-left: 4px;
            padding-right: 4px;
        }


        #editquoteModal .modal-body label {
            text-align: left !important;
            margin-bottom: 4px;
            display: block;
        }


        #editquoteModal .modal-body .form-group {
            margin-bottom: 12px;
        }


        #editquoteModal .modal-body .form-control,
        #editquoteModal .modal-body select,
        #editquoteModal .modal-body textarea {

            width: 100%;
            max-width: 100%;
        }


        


        /* =====================================================
       QUOTE INFO TABLE
       ===================================================== */

        #viewModal .display-line-item-scroll {

            width: 100%;
            max-width: 100%;
            max-height: 280px;
            overflow-x: auto !important;
            overflow-y: auto !important;
        }


        #viewModal #displaylineItemTable {

            min-width: 850px;
            width: 850px;
        }


        /* =====================================================
       CUSTOMER INFO TABLE
       ===================================================== */

        #customerModal .modal-body {

            overflow-x: auto;
        }


        #customerModal #quotationdetails_table {

            min-width: 650px;
            width: 650px;
        }


        /* =====================================================
       BOQ
       ===================================================== */

        #inputListModal .boq-table-wrapper {

            max-height: 300px;
            width: 100%;
            max-width: 100%;
            overflow-x: auto !important;
            overflow-y: auto !important;
        }


        #inputListModal .boq-table-wrapper .boq-table {

            min-width: 850px;
            width: 850px;
        }


        /* =====================================================
       FOOTER
       ===================================================== */

        #viewModal .modal-footer,
        #editquoteModal .modal-footer,
        #customerModal .modal-footer,
        #inputListModal .modal-footer,
        #deleteQuotationModal .modal-footer {

            padding: 10px 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }


        #viewModal .modal-footer .btn,
        #editquoteModal .modal-footer .btn,
        #customerModal .modal-footer .btn,
        #inputListModal .modal-footer .btn,
        #deleteQuotationModal .modal-footer .btn {

            margin: 0;
            max-width: 100%;
        }
    }


    /* =========================================================
   VERY SMALL PHONES
   <= 400px
   ========================================================= */

    @media (max-width: 399.98px) {

        #viewModal .modal-dialog,
        #editquoteModal .modal-dialog,
        #customerModal .modal-dialog,
        #inputListModal .modal-dialog,
        #deleteQuotationModal .modal-dialog {

            width: calc(100vw - 8px) !important;
            max-width: calc(100vw - 8px) !important;

            margin: 4px auto !important;
        }


        #viewModal .modal-body,
        #editquoteModal .modal-body,
        #customerModal .modal-body,
        #inputListModal .modal-body,
        #deleteQuotationModal .modal-body {

            padding: 8px !important;
        }


        #viewModal .modal-title,
        #editquoteModal .modal-title,
        #customerModal .modal-title,
        #inputListModal .modal-title,
        #deleteQuotationModal .modal-title {

            font-size: 1rem;
        }


        #viewModal .modal-footer .btn,
        #editquoteModal .modal-footer .btn,
        #customerModal .modal-footer .btn,
        #inputListModal .modal-footer .btn,
        #deleteQuotationModal .modal-footer .btn {

            font-size: .85rem;
            padding: 6px 10px;
        }
    }
    /* =========================================================
   EDIT QUOTATION - LINE ITEM TABLE
   HORIZONTAL SCROLL
   ========================================================= */

/* Scroll container */
#editquoteModal .edit-line-item-scroll {

    width: 100%;
    max-width: 100%;

    overflow-x: auto !important;
    overflow-y: hidden !important;

    -webkit-overflow-scrolling: touch;

    scrollbar-width: auto;

    margin: 0;
    padding-bottom: 4px;

}


/* Keep the table wider than the modal */
#editquoteModal .edit-line-item-scroll #editedlineItemTable {

    display: table !important;

    width: 900px !important;
    min-width: 900px !important;

    max-width: none !important;

    margin-bottom: 0;

}


/* Keep columns readable */
#editquoteModal .edit-line-item-scroll #editedlineItemTable th,
#editquoteModal .edit-line-item-scroll #editedlineItemTable td {

    white-space: nowrap !important;

}


/* Keep normal table layout */
#editquoteModal .edit-line-item-scroll #editedlineItemTable thead,
#editquoteModal .edit-line-item-scroll #editedlineItemTable tbody,
#editquoteModal .edit-line-item-scroll #editedlineItemTable tfoot {

    min-width: 900px;

}


/* =========================================================
   TABLET
   768px - 1023px
   ========================================================= */

@media (min-width: 768px) and (max-width: 1023.98px) {

    #editquoteModal .edit-line-item-scroll {

        width: 100%;
        max-width: 100%;

        overflow-x: auto !important;
        overflow-y: hidden !important;

    }

    #editquoteModal .edit-line-item-scroll #editedlineItemTable {

        width: 900px !important;
        min-width: 900px !important;

    }

}


/* =========================================================
   MOBILE
   <= 767px
   ========================================================= */

@media (max-width: 767.98px) {

    #editquoteModal .edit-line-item-scroll {

        width: 100%;
        max-width: 100%;

        overflow-x: auto !important;
        overflow-y: hidden !important;

        -webkit-overflow-scrolling: touch;

    }

    #editquoteModal .edit-line-item-scroll #editedlineItemTable {

        width: 900px !important;
        min-width: 900px !important;

    }

}


/* =========================================================
   VERY SMALL MOBILE
   <= 400px
   ========================================================= */

@media (max-width: 400px) {

    #editquoteModal .edit-line-item-scroll #editedlineItemTable {

        width: 850px !important;
        min-width: 850px !important;

    }

}
</style>
<h1 class="h3 mb-4 text-gray-800">Quotation Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Quotation
                    List</h6>
            </div>
            <!-- <div class="col" align="right">
                <span data-toggle=modal data-target=#quoteModal>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="quote_table" width="100%" cellspacing="0">
                <thead align="center">
                    <tr>
                        <th style='display:none'>Customer Id </th>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>DOE</th>
                        <th>Quote ID</th>
                        <th>DOQ</th>
                        <th>Quotation For</th>
                        <th>Quote Description</th>
                        <th style='display:none'>Quote Type</th>
                        <th>Quote Value.</th>
                        <th>Quote Status.</th>
                        <th style='display:none'>Comments</th>
                        <th style='display:none'>unitId</th>
                        <th style='display:none'>Quantity</th>
                        <th style='display:none'>unitName</th>
                        <th style='display:none'>listItemFile</th>
                        <th style='display:none'>QuoteFile</th>
                        <th style='display:none'>Customer Email</th>
                        <th style='display:none'>Customer Phone</th>
                        <th style='display:none'>Customer Address</th>
                        <th style='display:none'>Customer Place</th>
                        <th style='display:none'>Customer State</th>
                        <th style='display:none'>InputType</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once("../Utilities/permissionHelper.php");

                    $quotationList = DBQuotation::getAllquotations();

                    foreach ($quotationList as $quotationObj) {

                        // ✅ Check approval status
                        $isApproved = strtolower($quotationObj->get_quoteStatus()) === 'approved';

                        echo "<tr>
        <td style='display:none'>{$quotationObj->get_customerId()}</td>
        <td>{$quotationObj->getCustomerCode()}</td>
        <td>{$quotationObj->get_customerName()}</td>
        <td align='center'>{$quotationObj->getDOE()}</td>
        <td align='center'>{$quotationObj->getQuoteCode()}</td>
        <td align='center'>{$quotationObj->getDOQ()}</td>
        <td>{$quotationObj->getEnqCatName()}</td>
        <td>{$quotationObj->get_quoteDescription()}</td>
        <td style='display:none'>{$quotationObj->get_quoteType()}</td>
        <td align='center'>{$quotationObj->getQuoteValue()}</td>
        <td align='center'>" . ucfirst(strtolower($quotationObj->get_quoteStatus())) . "</td>
        <td style='display:none'>{$quotationObj->get_quoteComments()}</td>
        <td style='display:none'>{$quotationObj->getUnitId()}</td>
        <td style='display:none'>{$quotationObj->getQuantity()}</td>
        <td style='display:none'>{$quotationObj->getUnitName()}</td>
        <td style='display:none'>{$quotationObj->get_quotePDFName()}</td>
        <td style='display:none'>{$quotationObj->get_itemListName()}</td>
        <td style='display:none'>{$quotationObj->get_customerEmail()}</td>
        <td style='display:none'>{$quotationObj->getCustomerphone()}</td>
        <td style='display:none'>{$quotationObj->getCustomerAddress()}</td>
        <td style='display:none'>{$quotationObj->getCustomerCity()}</td>
        <td style='display:none'>{$quotationObj->get_customerState()}</td>
        <td style='display:none'>{$quotationObj->getInputType()}</td>

        <td>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle'
                    type='button'
                    data-toggle='dropdown'>
                    Actions
                </button>

                <div class='dropdown-menu'>";

                        // ✅ Input List
                        if (hasActionPermission('customers', 'input_list')) {
                            echo "<button class='btn btn-primary dropdown-item'
                data-toggle='modal'
                data-target='#inputListModal'
                data-id='{$quotationObj->get_quoteId()}'>
                <i class='fas fa-list-alt'></i> Input List
              </button>";
                        }

                        // ✅ Customer Info
                        if (hasActionPermission('customers', 'quotation_customer_info')) {
                            echo "<button class='btn btn-primary dropdown-item'
                data-toggle='modal'
                data-target='#customerModal'
                data-id='{$quotationObj->get_customerId()}'>
                <i class='fas fa-info'></i> Customer Info
              </button>";
                        }

                        // ✅ Edit Quotation
                        if (hasActionPermission('customers', 'edit_quotation')) {
                            echo "<button class='btn btn-primary dropdown-item'
                data-toggle='modal'
                data-target='#editquoteModal'
                data-id='{$quotationObj->get_quoteId()}'>
                <i class='fas fa-user-edit'></i> Edit Quotation
              </button>";
                        }

                        // ✅ Quotation Info
                        if (hasActionPermission('customers', 'quotation_info')) {
                            echo "<button class='btn btn-primary dropdown-item'
                data-toggle='modal'
                data-target='#viewModal'
                data-id='{$quotationObj->get_quoteId()}'>
                <i class='fas fa-info'></i> Quotation Info
              </button>";
                        }

                        // ✅ Print Quote
                        // Print Quote
                        // ✅ Print Quote
                        if (hasActionPermission('customers', 'print_quote')) {

                            if ($isApproved) {

                                echo "<a class='btn btn-primary dropdown-item'
            href='printQuote.php?id={$quotationObj->get_customerId()}'>
            <i class='fas fa-print'></i> Print Quote
        </a>";

                            } else {

                                echo "<button class='btn btn-secondary dropdown-item disabled'
            disabled
            title='Quotation is not approved'>
            <i class='fas fa-lock'></i> Print Quote
        </button>";

                            }
                        }

                        // ✅ Delete Quotation (with approval lock)
                        if (hasActionPermission('customers', 'delete_quotation')) {

                            if ($isApproved) {
                                echo "<button class='btn btn-secondary dropdown-item disabled' disabled
                    title='Approved quotation cannot be deleted'>
                    <i class='fas fa-lock'></i> Approved – Locked
                  </button>";
                            } else {
                                echo "<button class='btn btn-primary dropdown-item'
                    data-toggle='modal'
                    data-target='#deleteQuotationModal'
                    name='delete_button'
                    data-id='{$quotationObj->get_quoteId()}'>
                    <i class='fas fa-trash-alt'></i> Delete Quotation
                  </button>";
                            }
                        }

                        echo "      </div>
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
<div class="modal fade" id=viewModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);  ">
                <h4 class="modal-title" id="modal_title">Quote Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_message"></span>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 text-right">Customer Name <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayCustName" class=""></p>
                        </div>
                        <label class="col-md-2 text-right">Customer Id <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displaycustomerCode" class=""></p>
                        </div>
                        <label class="col-md-2 text-right">Quote Id. <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayquoteCode" class=""></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">

                        <label class="col-md-2 text-right">Quantity <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayquantity" class=""></p>
                        </div>
                        <label class="col-md-2 text-right">unit <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayUnit" class=""></p>
                        </div>
                        <label class="col-md-2 text-right">Quote Type <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayquoteType" class=""></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 text-right">Total Amount<span class="text-danger">*</span></label>
                        <div class="col-md-2 input-group">
                            <span class="pad"> <i class="fas fa-rupee-sign"></i></span>
                            <p id="displaysumTotalAmount" class="pad"></p>

                        </div>
                        <label class="col-md-2 text-right">Trade Price<span class="text-danger">*</span></label>
                        <div class="col-md-2 input-group">
                            <span class="pad"> <i class="fas fa-rupee-sign"></i></span>
                            <p id="displaysumTotalPrice" class="pad"></p>

                        </div>
                        <label class="col-md-2 text-right">Quote Amount. <span class="text-danger">*</span></label>
                        <div class="col-md-2 input-group">
                            <span class="pad"> <i class="fas fa-rupee-sign"></i></span>
                            <p id="displayQuoteAmount" class="pad"></p>

                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">

                        <label class="col-md-2 text-right">Quote Status <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayStatus" class=""></p>
                        </div>
                        <label class="col-md-2 text-right">Quote Description<span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayquoteDecription" class=""></p>
                        </div>
                        <label class="col-md-2 text-right">Quote Comments <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <p id="displayquoteComments" class=""></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">

                </div>


                <div class="display-line-item-scroll">

                    <table class="table table-bordered" id="displaylineItemTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Image</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: center;">Discount (%)</th>
                                <th style="text-align: center;">Total Amount</th>
                                <th style="text-align: center;">Company Price</th>
                                <th style="text-align: center;">Trade Price</th>
                                <th style="text-align: center;">Reference</th>
                                <th style="text-align: center;">Note</th>
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
                <input type="hidden" id="viewQuoteId">
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="hidden" name="action" id="action" value="Add" />
                <a href="javascript:void(0);" id="downloadLineItem" class="btn btn-success">
                    WQ - BOQ
                </a>
                <a href="javascript:void(0);" id="downloadWOInputList" class="btn btn-primary">
                    WOQ - BOQ
                </a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id=editquoteModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form method="post" id="editQuote" enctype="multipart/form-data" action="">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Edit Quotation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Customer Name <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <input type="text" name="customeName" id="editedCustomerName" class="form-control"
                                    readonly />
                                <input type="hidden" name="quoteid" id="quoteid" value="">
                                <input type="hidden" name="unitId" id="unitId" value="">
                            </div>

                            <label class="col-md-2 text-right">Customer Id <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <input type="text" name="customerCode" id="quotecustomerCode" class="form-control"
                                    readonly />
                            </div>

                            <label class="col-md-2 text-right">Quote Id. <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <input id="quoteCode" name="quoteCode" class="form-control" required readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <input type="text" id="quantity" class="form-control" required name="quantity" />
                            </div>

                            <label class="col-md-2 text-right">unit <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="unit" class="form-select" required name="unit">

                                </select>
                            </div>
                            <!-- <label class="col-md-2 text-right">Quote Type <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="quoteType" class="form-select" required name="quoteType">
                                    <option value='General'>General</option>
                                    <option value='Bank'>Bank</option>
                                </select>
                            </div> -->
                            <label class="col-md-2 text-right">Quotation For</label>
                            <div class="col-md-2">
                                <input type="text" id="editedQuotationFor" class="form-control" readonly />
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Total Amount<span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <input id="sumTotalAmount" name="sumTotalAmount" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>

                            <label class="col-md-2 text-right">Trade Price<span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <input id="sumTotalPrice" name="sumTotalPrice" class="form-control" required readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>

                            <label class="col-md-2 text-right">Quote Amount. <span class="text-danger">*</span></label>
                            <div class="col-md-2 input-group">
                                <input id="editedQuoteAmount" name="QuoteAmount" class="form-control" required />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Quote Status <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select name="quoteStatus" id="editedStatus" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="Approved">Approved</option>
                                </select>
                            </div>


                            <label class="col-md-2 text-right">Quote Comments <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <textarea name="quoteComments" id="editedquoteComments" class="form-control"></textarea>
                            </div>

                            <label class="col-md-2 text-right">Quote Description<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <textarea name="quoteDescription" id="editedquoteDecription"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
<div class="edit-line-item-scroll">

    <table class="table table-bordered"
           id="editedlineItemTable"
           width="100%"
           cellspacing="0">

        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Discount (%)</th>
                <th>GST</th>
                <th>Total Amount</th>
                <th>Company Price</th>
                <th>Total Value</th>
                <th>Trade Price</th>
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
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <a name="button" id="editLineItem" class="btn btn-warning">Edit</a>
                    <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=customerModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h4 class="modal-title" id="modal_title">Customer Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerinfoCode">Customer Id</label>
                                    </div>
                                    <input type="hidden" id="customerId" name="customerId" value="">
                                    <div class="col-8">
                                        <h5 class="card-title" id="displaycustomerinfoCode"></h5>
                                    </div>

                                </div>
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
                                        <label for="displaycustomerCity">Place</label>
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
                            </div>

                            <div class="row">
                                <table class="table table-bordered" id="quotationdetails_table" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Quote Id</th>
                                            <th>Date</th>
                                            <th>Description </th>
                                            <th>Quote Value</th>
                                            <th>Quote Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id=inputListModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemListForm" enctype="multipart/form-data" action="">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">BOQ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="printtopdf" class="boq-wrapper">

                        <!-- Company Header -->
                        <div class="boq-header">
                            <div class="company-block">
                                <h2>ACE DECORS</h2>
                                <p>
                                    Dharwad, Karnataka <br>
                                    Phone: +91-9742268112 | +91-9742367112 <br>
                                    Email: sales@acedecors.co.in
                                </p>
                            </div>

                            <div class="boq-title">
                                <h3>BOQ (Bill Of Quantity)</h3>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <table width="100%" style="margin-bottom:15px;">
                            <tr>
                                <td width="46%"><strong>Customer Name:</strong> <span id="boqCustomerName"></span></td>
                                <td align="center"><strong>Customer ID:</strong> <span id="boqCustomerCode"></span></td>
                                <td align="center" width="20%" ><strong>Q-ID:</strong> <span
                                        id="boqQuoteCode"></span>
                                </td>
                            </tr>
                        </table>

                        <!-- Line Item Table -->
                        <div class="boq-table-wrapper">
                            <table class="boq-table" id="lineItemTable">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th width="17%">Name</th>
                                        <th>Brand</th>
                                        <th width="35%">Description</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Footer -->
                        <table width="100%" style="margin-top:40px;">
                            <tr>
                                <td width="46%">Authorized Signature</td>
                                <td align="right">Thank you for your business!</td>
                            </tr>
                        </table>

                    </div>
                    <!-- ===========================
     INPUT LIST PDF TEMPLATE
     (Hidden - Used only for Download Input List)
============================ -->
                    <div id="inputListPrint" style="display:none; font-family:Arial;">

                        <!-- Company Header -->
                        <table width="100%" style="margin-bottom:15px;">
                            <tr>
                                <td>
                                    <h2 style="margin:0;">ACE DECORS</h2>
                                    Dharwad, Karnataka<br>
                                    Phone: +91-9742268112 | +91-9742367112<br>
                                    Email: sales@acedecors.co.in
                                </td>

                                <td align="center" width="30%">
                                    <h2 style="font-weight: bold;">
                                        BOQ
                                    </h2>
                                </td>
                            </tr>
                        </table>

                        <!-- Customer Details -->
                        <table width="100%" border="1" cellspacing="0" cellpadding="6"
                            style="border-collapse:collapse;margin-bottom:20px;">

                            <tr>
                                <td width="35%">
                                    <strong>Customer Name :</strong>
                                    <span id="pdfCustomerName"></span>
                                </td>

                                <td width="35%">
                                    <strong>Customer ID :</strong>
                                    <span id="pdfCustomerCode"></span>
                                </td>

                                <td>
                                    <strong>Quote ID :</strong>
                                    <span id="pdfQuoteCode"></span>
                                </td>
                            </tr>

                        </table>

                        <!-- Item List Table -->
                        <table id="inputListTable" width="100%" border="1" cellspacing="0" cellpadding="6"
                            style="border-collapse: collapse; table-layout: fixed; width: 100%;">

                            <colgroup>
                                <col style="width: 11mm;">
                                <col style="width: 18mm;">
                                <col style="width: 31mm;">
                                <col style="width: 41mm;">
                                <col style="width: 25mm;">
                                <col style="width: 16mm;">
                                <col style="width: 13mm;">
                                <col style="width: 25mm;">
                            </colgroup>

                            <thead style="background:#343a40;color:#fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>

                        </table>
                        <table width="100%" border="1" cellspacing="0" cellpadding="8"
                            style="border-collapse:collapse;margin-top:10px;">

                            <tr>

                                <td width="64%">

                                    <strong>In Words :</strong>
                                    <span id="inputListTotalWords"></span>

                                </td>

                                <td width="27%" align="right" style="font-size:20px;">


                                    ₹ <span id="inputListTotal">0.00</span>

                                </td>

                            </tr>

                        </table>
                        <br><br>

                        <table width="100%" style="border: 1px solid #dee2e6;">

                            <tr>

                                <td width="28%">
                                    Authorized Signature
                                </td>

                                <td align="right" width="56%">
                                    Thank you for your business!
                                </td>

                            </tr>

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
                </div>
                <div class="modal-footer">
                    <!-- <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Water Mark</label>
                    </div> -->
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" id="wqPdfBtn" class="btn btn-success" value="WQ - PDF" />
                    <input type="submit" id="woqPdfBtn" class="btn btn-primary" value="WOQ - PDF" />
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- <div class="modal fade" id=projectModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form class="" method="POST" id="customer_form" enctype="multipart/form-data"
            action="../Controller/projectController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-8">
                        <label for="projCustomerName" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="projCustomerName" name="projCustomerName">
                        <input type="hidden" class="form-control" id="enqId" name="enqId" />
                    </div>
                   
                    <div class="col-md-8">
                        <label for="projcustomerCode" class="form-label">Customer Code</label>
                        <input type="text" class="form-control" id="projcustomerCode" name="projcustomerCode">
                        
                    </div>

                    <div class="col-md-8">
                        <label for="projquoteCode" class="form-label">Quote Code</label>
                        <input type="text" class="form-control" id="projquoteCode" name="projquoteCode">
                        <input type="hidden" class="form-control" id="enqId" name="enqId" />
                    </div>


                    <div class="col-md-8">
                        <label for="projQuoteAmount" class="form-label">Quote Value</label>
                        <input type="text" class="form-control" id="projQuoteAmount" name="projQuoteAmount">
                        <input type="hidden" class="form-control" id="enqId" name="enqId" />
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="createProject">Create Project</button>
                </div>
            </div>
        </form>
    </div>
</div> -->

<div class="modal fade" id=deleteQuotationModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="modal-title" id="modal_title">Delete quote</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this quotation.
                    </p>
                    <input type="hidden" name="quoteid" id="quoteid" value="">
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
        var waterMarked = false;
        $('#flexSwitchCheckDefault').on('click', function (e) {
            if ($(this).attr('checked') != 'checked') {
                $(this).attr('checked', 'checked');
                waterMarked = true;
            } else {
                $(this).removeAttr('checked');
                waterMarked = false;
            }
        })
        let printType = "WQ"; // default

        // Detect which button was clicked
        $('#wqPdfBtn').on('click', function () {
            printType = "WQ";
        });

        $('#woqPdfBtn').on('click', function () {
            printType = "WOQ";
        });

        $('#itemListForm').submit(function (e) {
            e.preventDefault();

            var originalContent = document.getElementById("printtopdf");
            var clonedContent = originalContent.cloneNode(true);

            // 🔵 WOQ logic (KEEP SAME)
            if (printType === "WOQ") {

                clonedContent.querySelector(".boq-title h3").innerText =
                    "BOQ (Bill of Quantity)";

                var table = clonedContent.querySelector("#lineItemTable");

                if (table) {
                    table.querySelectorAll("thead tr th")[5]?.remove();
                    table.querySelectorAll("thead tr th")[4]?.remove();

                    table.querySelectorAll("tbody tr").forEach(function (row) {
                        row.children[5]?.remove();
                        row.children[4]?.remove();
                    });
                }
            }

            // 🔥 CONVERT TO STRING
            var content = clonedContent.outerHTML;

            // 🔥 UNIQUE FILE NAME
            var fileName = $('#customerCode').text() + '_BOQ_' + printType;

            var uniturl = config.developmentPath +
                "/Admin/Controller/pdfGeneratorContorller.php";

            $.ajax({
                type: "POST",
                url: uniturl,
                data: {
                    "modifiedby": $('#modifiedby').val(),
                    "quoteId": $('#quoteid').val(),
                    "fileType": "itemList", // or create "boq" if needed
                    "waterMarked": waterMarked,
                    "fileName": fileName,
                    "html": content
                }
            }).done(function () {

                // ✅ OPEN GENERATED PDF
                window.open(
                    config.developmentPath +
                    '/Admin/pdfs/itemList/' +
                    fileName.trim() +
                    '.pdf'
                );
            });
        });



        $('#orderListForm').submit(function (e) {
            var content = $('#orderprinttopdf').html();
            var uniturl = config.developmentPath +
                "/Admin/Controller/pdfGeneratorContorller.php";
            $.ajax({
                type: "POST",
                url: uniturl,
                data: {
                    "html": content
                },
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data);
            });
        });

        $('#editquoteModal').on('show.bs.modal', function (e) {
            debugger;
            let projId = 0;
            var rowid = $(e.relatedTarget).data('id');
            $('#viewQuoteId').val(rowid);

            $('#quoteid').val(rowid);
            const button = $(e.relatedTarget);   // Edit button
            const row = button.closest('tr');    // ✅ Correct row

            const quoteCode = row.find('td:eq(4)').text().trim();
            const customerCode = row.find('td:eq(1)').text().trim();

            // const inputType = row.children('td').eq(22).text().trim();

            // console.log("Detected InputType:", inputType);

            // let apiFile = (inputType === "1")
            //     ? "itemListController.php"
            //     : "materialListController.php";
            // 🔥 FIX ENDS HERE
            // Safety check
            if (!quoteCode || !customerCode) {
                console.warn('Missing quoteCode or customerCode');
                return;
            }

            $.getJSON(
                config.developmentPath +
                "/Admin/Controller/customerpaymentcontroller.php",
                {
                    action: "checkQuotePaymentLock",
                    quoteCode: quoteCode,
                    customerCode: customerCode
                },
                function (res) {

                    const isApproved =
                        $.trim($('#editedStatus').val()).toLowerCase() === "approved";

                    if (res.locked === true || isApproved) {
                        $('#editedStatus')
                            .prop('disabled', true)
                            .addClass('bg-light');
                    } else {
                        $('#editedStatus')
                            .prop('disabled', false)
                            .removeClass('bg-light');
                    }
                }
            );
            $('#editLineItem').attr('href', 'lineItemView.php?id=' + rowid);

            // ▼ Decide API based on InputType


            var uniturl = config.developmentPath +
                "/Admin/Controller/boqLineItemController.php?id=" + rowid;


            var sumTotalAmount = 0;
            var sumTotalPrice = 0;

            // Clear old rows
            $('#editedlineItemTable tbody').empty();

            $.getJSON(uniturl, function (data) {
                console.log("EDIT MODAL DATA:", data); // keep for checking

                $.each(data, function (index, value) {
                    const name = value.Name ?? "";
                    const qty = value.itemquantity ?? value.itemquantity ?? 0;
                    const disc = value.discount1 ?? value.discount1 ?? 0;
                    const gst = value.GST ?? value.gst ?? value.GSTValue ?? 0;
                    const tAmt = parseFloat(value.totalAmount ?? value.TotalAmount ?? 0);
                    const comp = value.companyPrice ?? 0;
                    const tVal = value.totalValue ?? 0;


                    const trade = parseFloat(value.totalPrice ?? value.TradePrice ?? 0);

                    $('#editedlineItemTable tbody').append(
                        $('<tr/>', { id: value.lineItemId })
                            .append($('<td/>').text(name))
                            .append($('<td/>').text(qty))
                            .append($('<td/>').text(disc))
                            .append($('<td/>').text(gst))
                            .append($('<td/>').text(tAmt.toFixed(2)))
                            .append($('<td/>').text(comp.toFixed(2)))
                            .append($('<td/>').text(tVal.toFixed(2)))  // ✅ FIX: use calculated total value
                            .append($('<td/>').text(trade.toFixed(2)))
                    );

                    sumTotalAmount += tAmt;
                    sumTotalPrice += trade;
                });


                // Update summary fields
                $('#sumTotalAmount').val(sumTotalAmount.toFixed(2));
                $('#sumTotalPrice').val(sumTotalPrice.toFixed(2));

            });
            let unitApiUrl = config.developmentPath + "/Admin/Controller/unitsContoller.php";
            $.getJSON(unitApiUrl, function (unitsData) {
                $('#unit').empty();
                $('#unit').append(`<option value="">Select Unit</option>`);

                $.each(unitsData, function (i, u) {
                    $('#unit').append(
                        `<option value="${u.unitId}">${u.unitName}</option>`
                    );
                });

                // ✅ IMPORTANT: set value AFTER loading options
                let savedUnitId = $('#unitId').val();
                if (savedUnitId) {
                    $('#unit').val(savedUnitId);
                }
            });


        });

        $('#viewModal').on('show.bs.modal', function (e) {

            var rowid = $(e.relatedTarget).data('id');
            $('#viewQuoteId').val(rowid);
            let projId = 0;
            $('#editLineItem').attr('href', 'lineItemView.php?id=' + rowid);
            var uniturl = config.developmentPath +
                "/Admin/Controller/itemListController.php?id=" + rowid +
                "&projId=" + projId;
            var sumTotalAmount = 0;
            var sumTotalPrice = 0;
            $.getJSON(uniturl, function (data) {
                console.log("VIEW MODAL DATA:", data); // keep for checking
                $("#displaylineItemTable tbody").empty(); // ✅ clear correctly

                let sumTotalAmount = 0;
                let sumTotalPrice = 0;

                $.each(data, function (index, value) {
                    const qty = parseFloat(value.Quantity ?? value.itemquantity ?? 0);
                    const comp = parseFloat(value.CompanyPrice ?? value.companyPrice ?? 0);
                    const tVal = parseFloat(value.TotalValue ?? value.totalValue ?? 0);
                    const trade = parseFloat(value.TradePrice ?? value.totalPrice ?? 0);

                    const img = value.Image ?? '';
                    const ref = value.Reference ?? '';
                    const note = value.Note ?? '';

                    const imgFolder = (value.Type == "1") ? "items" : "materials";

                    $('#displaylineItemTable tbody').append(
                        $('<tr/>', { id: value.lineItemId })
                            .append($('<td/>').html(`<img src="../img/${imgFolder}/${img}" style="width:60px;height:60px">`))
                            .append($('<td/>').text(value.Name || ""))
                            .append($('<td/>').text(qty))
                            .append($('<td/>').text(value.discount1 ?? value.CompanyDiscount ?? 0))
                            .append($('<td/>').text(value.totalAmount?.toFixed(2) ?? 0))
                            .append($('<td/>').text(comp.toFixed(2)))
                            .append($('<td/>').text(trade.toFixed(2)))
                            .append($('<td/>').text(ref))
                            .append($('<td/>').text(note))
                    );

                    sumTotalAmount += tAmt = parseFloat(value.totalAmount ?? 0);
                    sumTotalPrice += trade;
                });

                $('#displaysumTotalAmount').text(sumTotalAmount.toFixed(2));
                $('#displaysumTotalPrice').text(sumTotalPrice.toFixed(2));
            });

        });

        // $('#deleteLineItemModal').on('show.bs.modal', function(e) {

        //     var rowid = $(e.relatedTarget).data('id');
        //     $('#lineItemId').val(rowid);

        // });
        $('#inputListModal').on('show.bs.modal', function (e) {

            const button = $(e.relatedTarget);
            const row = button.closest('tr');

            const rowid = button.data('id');

            // ✅ GET CORRECT DATA FROM TABLE
            const customerCode = row.find('td:eq(1)').text().trim(); // ✅ Customer Code
            const customerName = row.find('td:eq(2)').text().trim(); // ✅ Customer Name
            const quoteCode = row.find('td:eq(4)').text().trim();    // ✅ Quote Id

            // ✅ SET INTO MODAL
            $('#boqCustomerName').text(customerName);
            $('#boqCustomerCode').text(customerCode);
            $('#boqQuoteCode').text(quoteCode);

            $('#pdfCustomerName').text(customerName);
            $('#pdfCustomerCode').text(customerCode);
            $('#pdfQuoteCode').text(quoteCode);

            $('#quoteid').val(rowid);

            reloadloadItemTable(rowid);
            loadInputListTable(rowid);
        });



        $('#orderinputListModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#quoteid').val(rowid);
            var uniturl = config.developmentPath +
                "/Admin/Controller/orderListController.php?id=" + rowid;
            $.getJSON(uniturl, function (data) {
                $("#orderItemTable").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#orderItemTable tbody').
                        append($(document.createElement('tr')).prop({
                            id: value.id
                        }));

                    $('#orderItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.orderNo,
                        }));
                    $('#orderItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.ArticleNo
                        }));
                    $('#orderItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.SAP
                        }));
                    $('#orderItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Description
                        }));
                    $('#orderItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Quantity
                        }));
                    $('#orderItemTable tr:last').
                        append($(document.createElement('td')).prop({
                            innerHTML: value.Units
                        }));
                    $('#orderItemTable tr:last').
                        append($(document.createElement('td')).append(
                            '<div class="dropdown">\
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">Actions</button>\
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">\
                        <a class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#orderinputListModal"  data-id="' +
                            value.id +
                            '">\
                        <i class="fas fa-user-edit"></i> Edit</a>\
                        <a class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#deleteLineItemModal"  data-id="' +
                            value.id + '">\
                        <i class="fas fa-trash-alt"></i> Delete</a>\
                        </div>'));
                });
            });
        });

        var dataTable = $('#quote_table').DataTable({

        });

        var nEditing = null;

        $('#quote_table tbody').on('click', 'tr', function () {
            debugger;
            /* Get the row as a parent of the link that was clicked on */
            $('#quotecustomerCode').val(this.cells[1].innerHTML);
            $('#quoteCode').val(this.cells[4].innerHTML);
            $('#editedCustomerName').val(this.cells[2].innerHTML);
            $('#customerName').text(this.cells[2].innerHTML);
            $('#displaycustomerinfoCode').text(this.cells[1].innerHTML);
            $('#editedQuotationFor').val(this.cells[6].innerHTML);
            $('#editedQuoteAmount').val(this.cells[9].innerHTML);
            $('#editedStatus').val(this.cells[10].innerHTML);
            // Lock Quote Status once Approved
            if ($.trim(this.cells[10].innerHTML).toLowerCase() === "approved") {
                $('#editedStatus')
                    .prop('disabled', true)
                    .addClass('bg-light');
            } else {
                $('#editedStatus')
                    .prop('disabled', false)
                    .removeClass('bg-light');
            }
            $('#editedquoteDecription').val(this.cells[7].innerHTML);
            $('#editedquoteComments').val(this.cells[11].innerHTML);
            $('#customerCode').text(this.cells[1].innerHTML);
            $('#listquoteCode').text(this.cells[4].innerHTML);
            $('#unitId').val(this.cells[12].innerHTML);   // unitId
            $('#quantity').val(this.cells[13].innerHTML); // Quantity
            $('#unit').val(this.cells[12].innerHTML);     // select by unitId
            $('#displaycustomerCode').text(this.cells[1].innerHTML);
            $('#projcustomerCode').val(this.cells[1].innerHTML);
            $('#displayquoteCode').text(this.cells[4].innerHTML);
            $('#projquoteCode').val(this.cells[4].innerHTML);
            $('#displayCustName').text(this.cells[2].innerHTML);
            $('#displaycustomerName').text(this.cells[2].innerHTML);
            $('#projCustomerName').val(this.cells[2].innerHTML);
            $('#displayQuoteAmount').text(this.cells[9].innerHTML + ' ');
            $('#projQuoteAmount').val(this.cells[8].innerHTML + ' ');
            $('#displayStatus').text(this.cells[10].innerHTML);
            $('#displayquoteDecription').text(this.cells[7].innerHTML);
            $('#displayquoteComments').text(this.cells[11].innerHTML);
            $('#displayquoteType').text(this.cells[6].innerHTML)
            $('#displayUnit').text(this.cells[12].innerHTML);
            $('#displayquantity').text(this.cells[13].innerHTML);
            $('#displaycustomerDov').text(this.cells[3].innerHTML);
            $('#displaycustomerEmail').text(this.cells[17].innerHTML);
            $('#displaycustomerPhone').text(this.cells[18].innerHTML);
            $('#displaycustomerAddress').text(this.cells[19].innerHTML);
            $('#displaycustomerCity').text(this.cells[20].innerHTML);
            $('#displaycustomerState').text(this.cells[21].innerHTML);
            $('#InputType').text(this.cells[21].innerHTML);
            console.log("Cell14 =", this.cells[14].innerHTML);
            console.log("Cell15 =", this.cells[15].innerHTML);
            console.log("Cell16 =", this.cells[16].innerHTML);
            if (this.cells[16].innerHTML != "") {
                $('#downloadLineItem').attr('href', '../pdfs/itemList/' + this.cells[16].innerHTML);
            } else {
                $('#downloadLineItem').removeAttr('target');
                $('#downloadLineItem').attr('onclick', 'alert("Please save the Item List as PDF")');
            }
            if (this.cells[13].innerHTML != "") {

                $('#downloadQuote').attr('href', '../pdfs/quotations/' + this.cells[14].innerHTML);
            } else {
                $('#downloadQuote').removeAttr('target');
                $('#downloadQuote').attr('onclick', 'alert("Please save the Quotation as PDF")');
            }

            let unitId = this.cells[12].innerHTML;

            $.getJSON(config.developmentPath + "/Admin/Controller/unitsContoller.php", function (units) {
                let unitName = unitId;

                $.each(units, function (i, u) {
                    if (u.unitId == unitId) {
                        unitName = u.unitName;
                    }
                });

                $('#displayUnit').text(unitName);
            });
        });

        $('#editQuote').submit(function (event) {

            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/quotationController.php/",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                console.log(data);
            });
        });

        $('#delete_lineItem_form').submit(function (event) {
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/lineItemController.php/",
                method: "POST",
                data: {
                    id: $('#lineItemId').val(),
                    action: 'delete'
                },

            }).done(function (data) {
                console.log(data);
            });
            event.preventDefault();
            reloadloadItemTable($('#quoteid').val());

        });

        function reloadloadItemTable(rowid) {
            const uniturl = config.developmentPath +
                "/Admin/Controller/boqLineItemController.php?id=" + rowid;

            $.getJSON(uniturl, function (data) {

                console.log("BOQ Combined Data:", data);

                $("#lineItemTable tbody").empty();

                $.each(data, function (index, value) {

                    const name = value.Name ?? '';
                    const brand = value.Brand ?? '';
                    const desc = value.Description ?? '';
                    const qty = value.Quantity ?? value.itemquantity ?? 0;
                    const unit = value.Units ?? '';

                    // 🔥 Decide image folder per row
                    const imgFolder = (value.Type == "1") ? "items" : "materials";
                    const img = value.Image ?? '';

                    $("#lineItemTable tbody").append(`
                <tr>
                    <td align="center">
                        <img 
                        
                        src="../img/${imgFolder}/${img}"
     style="width:100px;height:100px"
     class="img-fluid">
                    </td>
                    <td align="left">${name}</td>
                    <td align="center">${brand}</td>
                    <td align="left">${desc}</td>
                    <td align="center">${qty}</td>
                    <td align="center">${unit}</td>
                </tr>
            `);
                });
            });
        }
        function loadInputListTable(id, callback) {

            const uniturl = config.developmentPath +
                "/Admin/Controller/boqLineItemController.php?id=" + id;

            $.getJSON(uniturl, function (data) {

                $("#inputListTable tbody").empty();
                let grandTotal = 0;
                $.each(data, function (index, value) {

                    const imgFolder = (value.Type == "1") ? "items" : "materials";

                    const img = value.Image ?? "";

                    const name = value.Name ?? "";

                    const desc = value.Description ?? "";

                    const brand = value.Brand ?? "";

                    const qty = value.Quantity ?? value.itemquantity ?? 0;

                    const unit = value.Units ?? "";

                    const trade = parseFloat(
                        value.TradePrice ??
                        value.totalPrice ??
                        0
                    );

                    grandTotal += trade;

                    $("#inputListTable tbody").append(`
        <tr>

            <td align="center">${index + 1}</td>

            <td align="center">
                <img
                    src="../img/${imgFolder}/${img}"
                    style="width:70px;height:70px;">
            </td>

            <td>${name}</td>

            <td>${desc}</td>

            <td align="center">${brand}</td>

            <td align="center">${qty}</td>

            <td align="center">${unit}</td>

            <td align="right">${trade.toFixed(2)}</td>

        </tr>
    `);
                });
                $("#inputListTotal").text(grandTotal.toFixed(2));
                $("#inputListTotalWords").text(numberToWords(Math.round(grandTotal)));
                if (typeof callback === "function") {
                    callback();
                }

            });

        }

        $('#customerModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#customerId').val(rowid);

            var contactUrl = config.developmentPath +
                "/Admin/Controller/quotationController.php?custId=" + rowid;

            $.getJSON(contactUrl, function (data) {
                $("#quotationdetails_table").find("tr:gt(0)").remove();

                $.each(data, function (index, value) {
                    let statusBadge = '';

                    if (value.quoteStatus === "Approved") {
                        statusBadge = `<span class="badge badge-success">Approved</span>`;
                    } else if (value.quoteStatus === "Pending") {
                        statusBadge = `<span class="badge badge-warning">Pending</span>`;
                    } else if (value.quoteStatus === "Rejected") {
                        statusBadge = `<span class="badge badge-danger">Rejected</span>`;
                    } else {
                        statusBadge = value.quoteStatus;
                    }

                    $('#quotationdetails_table tbody').append(
                        $("<tr>").append(
                            $("<td>").text(value.QuoteCode),
                            $("<td>").text(value.DOQ),
                            $("<td>").text(value.EnqCatName),
                            $("<td>").text(value.quoteValue),
                            $("<td>").html(statusBadge)
                        )
                    );

                });
            });
        });



        $('#deleteQuotationModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#quoteid').val(rowid);
        });
        $('#deletebutton').click(function () {
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/quotationController.php/",
                method: "POST",
                data: {
                    id: $('#quoteid').val(),
                    action: 'delete'
                },
                success: function (data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();

                }
            });
        });

/* =========================================================
   RESPONSIVE MODAL + DRAG SYSTEM
   ---------------------------------------------------------
   Uses existing jQuery UI draggable.
   No new library required.
   ========================================================= */

function keepQuotationModalInsideViewport($dialog) {

    if (!$dialog || !$dialog.length) {
        return;
    }

    var viewportWidth = $(window).width();
    var viewportHeight = $(window).height();

    var dialogWidth = $dialog.outerWidth();
    var dialogHeight = $dialog.outerHeight();

    var currentLeft = parseFloat($dialog.css('left'));
    var currentTop = parseFloat($dialog.css('top'));

    if (isNaN(currentLeft)) {
        currentLeft =
            (viewportWidth - dialogWidth) / 2;
    }

    if (isNaN(currentTop)) {
        currentTop = 20;
    }


    /*
     * Never allow the dialog outside the viewport.
     */

    var maxLeft =
        Math.max(4, viewportWidth - dialogWidth - 4);

    var maxTop =
        Math.max(4, viewportHeight - dialogHeight - 4);


    currentLeft = Math.max(
        4,
        Math.min(currentLeft, maxLeft)
    );

    currentTop = Math.max(
        4,
        Math.min(currentTop, maxTop)
    );


    $dialog.css({

        position: 'fixed',

        margin: 0,

        transform: 'none',

        left: currentLeft + 'px',

        top: currentTop + 'px'

    });

}


/*
 * Initialize every Bootstrap modal after it is visible.
 */

$('.modal').on('shown.bs.modal', function () {

    var $modal = $(this);

    var $dialog =
        $modal.find('.modal-dialog');


    if (
        !$dialog.length ||
        typeof $dialog.draggable !== 'function'
    ) {

        return;

    }


    /*
     * Destroy previous draggable instance.
     */

    if ($dialog.hasClass('ui-draggable')) {

        $dialog.draggable('destroy');

    }


    /*
     * Get current viewport.
     */

    var viewportWidth =
        $(window).width();

    var viewportHeight =
        $(window).height();


    /*
     * Measure modal after Bootstrap
     * has completely displayed it.
     */

    var dialogWidth =
        $dialog.outerWidth();

    var dialogHeight =
        $dialog.outerHeight();


    /*
     * Center horizontally.
     */

    var left =
        (viewportWidth - dialogWidth) / 2;


    /*
     * Small margin on all screens.
     */

    var minimumMargin =
        viewportWidth <= 767 ? 4 : 12;


    left = Math.max(
        minimumMargin,
        left
    );


    /*
     * Center vertically when possible.
     *
     * If modal is taller than viewport,
     * place it at the top and let the
     * body scroll.
     */

    var top;

    if (dialogHeight + (minimumMargin * 2)
        <= viewportHeight) {

        top =
            (viewportHeight - dialogHeight) / 2;

    } else {

        top =
            minimumMargin;

    }


    /*
     * Prevent initial position from
     * going outside viewport.
     */

    var maxLeft =
        Math.max(
            minimumMargin,
            viewportWidth -
            dialogWidth -
            minimumMargin
        );


    var maxTop =
        Math.max(
            minimumMargin,
            viewportHeight -
            dialogHeight -
            minimumMargin
        );


    left =
        Math.min(
            Math.max(minimumMargin, left),
            maxLeft
        );


    top =
        Math.min(
            Math.max(minimumMargin, top),
            maxTop
        );


    /*
     * Convert Bootstrap's dialog into
     * a fixed-position draggable dialog.
     */

    $dialog.css({

        position: 'fixed',

        margin: 0,

        left: left + 'px',

        top: top + 'px',

        transform: 'none',

        zIndex: 1055

    });


    /*
     * Existing jQuery UI draggable.
     */

    $dialog.draggable({

        handle: '.modal-header',

        containment: 'window',

        scroll: false,

        cancel:
            '.close, button, input, select, textarea, a',

        start: function () {

            $(this).css(
                'transform',
                'none'
            );

        },

        drag: function () {

            $(this).css(
                'transform',
                'none'
            );

        },

        stop: function () {

            keepQuotationModalInsideViewport(
                $(this)
            );

        }

    });

});


/*
 * Recalculate position when browser
 * is resized or device orientation changes.
 */

$(window).on(
    'resize orientationchange',
    function () {

        $('.modal.show').each(function () {

            var $dialog =
                $(this).find('.modal-dialog');


            if (!$dialog.length) {
                return;
            }


            /*
             * Don't destroy the user's
             * current drag position unnecessarily.
             */

            keepQuotationModalInsideViewport(
                $dialog
            );

        });

    }
);


/*
 * Reset position after modal closes.
 *
 * Next time it opens it starts centered again.
 */

$('.modal').on(
    'hidden.bs.modal',
    function () {

        var $dialog =
            $(this).find('.modal-dialog');


        if (!$dialog.length) {
            return;
        }


        if ($dialog.hasClass('ui-draggable')) {

            $dialog.draggable('destroy');

        }


        $dialog.css({

            position: '',

            left: '',

            top: '',

            margin: '',

            transform: '',

            zIndex: ''

        });

    }
);

        $('#downloadLineItem').on('click', function (e) {

            e.preventDefault();

            var clonedContent =
                document.getElementById("inputListPrint").cloneNode(true);

            clonedContent.style.display = "block";

            clonedContent.querySelector("#pdfCustomerName").innerHTML =
                $('#displayCustName').text();

            clonedContent.querySelector("#pdfCustomerCode").innerHTML =
                $('#displaycustomerCode').text();

            clonedContent.querySelector("#pdfQuoteCode").innerHTML =
                $('#displayquoteCode').text();

            var fileName =
                $('#displaycustomerCode').text().trim() + "_INPUT_LIST";
            console.log("Quote ID =", $('#viewQuoteId').val());
            loadInputListTable($('#viewQuoteId').val(), function () {

                clonedContent.querySelector("#inputListTable tbody").innerHTML =
                    $("#inputListTable tbody").html();

                clonedContent.querySelector("#inputListTotal").innerHTML =
                    $("#inputListTotal").text();

                clonedContent.querySelector("#inputListTotalWords").innerHTML =
                    $("#inputListTotalWords").text();

                var content = clonedContent.outerHTML;

                generateInputListPdf(content, fileName);

            });

        });
        $('#downloadWOInputList').on('click', function (e) {

            e.preventDefault();

            var clonedContent =
                document.getElementById("inputListPrint").cloneNode(true);

            clonedContent.style.display = "block";

            clonedContent.querySelector("#pdfCustomerName").innerHTML =
                $('#displayCustName').text();

            clonedContent.querySelector("#pdfCustomerCode").innerHTML =
                $('#displaycustomerCode').text();

            clonedContent.querySelector("#pdfQuoteCode").innerHTML =
                $('#displayquoteCode').text();

            var fileName =
                $('#displaycustomerCode').text().trim() + "_WO_INPUT_LIST";

            loadInputListTable($('#viewQuoteId').val(), function () {

                clonedContent.querySelector("#inputListTable tbody").innerHTML =
                    $("#inputListTable tbody").html();

                clonedContent.querySelector("#inputListTotal").innerHTML =
                    $("#inputListTotal").text();

                clonedContent.querySelector("#inputListTotalWords").innerHTML =
                    $("#inputListTotalWords").text();

                //=============================
                // BLANK QUANTITY & PRICE
                //=============================

                clonedContent.querySelectorAll("#inputListTable tbody tr").forEach(function (row) {

                    // Quantity Column (6th column)
                    row.cells[5].innerHTML = "";

                    // Price Column (8th column)
                    row.cells[7].innerHTML = "";

                });

                var content = clonedContent.outerHTML;

                generateInputListPdf(content, fileName);

            });

        });
    });
    function generateInputListPdf(content, fileName) {

        $.ajax({

            type: "POST",

            url: config.developmentPath +
                "/Admin/Controller/pdfGeneratorContorller.php",

            data: {

                modifiedby: $('#modifiedby').val(),

                quoteId: $('#viewQuoteId').val(),

                fileType: "itemList",

                waterMarked: false,

                fileName: fileName,

                html: content

            },

            success: function (response) {

                console.log(response);

                if (response.indexOf("PDF CREATED") !== -1) {

                    window.open(
                        config.developmentPath +
                        "/Admin/pdfs/itemList/" +
                        fileName +
                        ".pdf?" + new Date().getTime(),
                        "_blank"
                    );

                } else {

                    alert(response);

                }

            },

            error: function (xhr) {

                console.log(xhr.responseText);

            }

        });

    }

    function numberToWords(num) {

        const ones = [
            "", "One", "Two", "Three", "Four", "Five", "Six",
            "Seven", "Eight", "Nine", "Ten", "Eleven",
            "Twelve", "Thirteen", "Fourteen", "Fifteen",
            "Sixteen", "Seventeen", "Eighteen", "Nineteen"
        ];

        const tens = [
            "", "", "Twenty", "Thirty", "Forty",
            "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"
        ];

        function convert(n) {

            if (n < 20) return ones[n];

            if (n < 100)
                return tens[Math.floor(n / 10)] +
                    (n % 10 ? " " + ones[n % 10] : "");

            if (n < 1000)
                return ones[Math.floor(n / 100)] +
                    " Hundred " +
                    convert(n % 100);

            if (n < 100000)
                return convert(Math.floor(n / 1000)) +
                    " Thousand " +
                    convert(n % 1000);

            if (n < 10000000)
                return convert(Math.floor(n / 100000)) +
                    " Lakh " +
                    convert(n % 100000);

            return convert(Math.floor(n / 10000000)) +
                " Crore " +
                convert(n % 10000000);

        }

        return "Rupees " + convert(num).replace(/\s+/g, " ").trim() + " Only";
    }
</script>