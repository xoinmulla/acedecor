<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include "itemstocksnavigation.php";
require_once("../DB Operations/item_stocksOps.php");
require_once("../DB Operations/item_detailsOps.php");
require_once("../DB Operations/POlineitemOps.php");
require_once("../DB Operations/allocateitemsOps.php");
require_once("../Model/item_stocksmodel.php");
if ($_SERVER["REQUEST_METHOD"]=="GET") {
    // error_log($_GET["item"]);
    $POItem=null;
    if (isset($_GET["item"])) {
        $POitemid=$_GET["item"];
        error_log($_GET["item"]);
        $POItem=DBitemdetails::getallItemdetailsbasedonIDforstocks($POitemid);
 
        error_log($POitemid);
        $db=ConnectDb::getInstance();
        $query="SELECT SUM(ReceivedQty) as TotalStock from item_stock where item_id=$POitemid";
        error_log($query);
        $result=mysqli_query($db->getConnection(),$query);
        $totalstock=mysqli_fetch_assoc($result);

        $query="SELECT SUM(AllocatedQty) as TotalStockUsed from itemallocation where ItemId=$POitemid";
        error_log($query);
        $result=mysqli_query($db->getConnection(),$query);
        $totalstockUsed=mysqli_fetch_assoc($result);
    }
   
}
if(!hasActionPermission('inventory','stocklist')){
    header("Location: noaccess.php");
    exit;
}
?>

<style>
/* =========================================================
   ITEM STOCKS - PAGE ONLY RESPONSIVE FIXES
   Existing design / Bootstrap structure preserved.
   ========================================================= */

html,
body {
    max-width: 100%;
    overflow-x: hidden;
}

/* ---------- Stock summary cards ---------- */
.stock-summary-row {
    display: flex;
    flex-wrap: wrap;
}

.stock-summary-row > [class*="col-"] {
    margin-bottom: 1rem;
}

.stock-summary-row .widget-stat {
    height: 100%;
    min-height: 150px;
}

.stock-summary-row .widget-stat h2 {
    max-width: 100%;
    overflow-wrap: anywhere;
}

/* ---------- Filter section ---------- */
.stock-filter-form {
    width: 100%;
}

.stock-filter-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}

.stock-filter-row > label {
    margin-bottom: .5rem;
}

.stock-filter-row > .stock-field {
    margin-bottom: .75rem;
}

/* ---------- Main table: only table scrolls ---------- */
.stock-table-wrapper {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: auto;
}

#itemStockTable {
    min-width: 1050px;
    width: 100%;
}

#itemStockTable th,
#itemStockTable td {
    white-space: nowrap;
    vertical-align: middle;
}

/* ---------- Modal ---------- */
#followupModal .modal-dialog {
    position: absolute;
    width: min(900px, calc(100vw - 20px));
    max-width: none;
    margin: 0;
}

#followupModal .modal-content {
    width: 100%;
    max-height: calc(100vh - 20px);
    overflow: hidden;
}

#followupModal .modal-header {
    cursor: move;
    user-select: none;
    touch-action: none;
}

#followupModal .modal-body {
    overflow-y: auto;
    overflow-x: hidden;
    max-height: calc(100vh - 150px);
}

.followup-table-wrapper {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
}

#followuptable {
    min-width: 650px;
    width: 100%;
}

#followuptable th,
#followuptable td {
    white-space: nowrap;
    vertical-align: middle;
}

#followupModal textarea {
    width: 100%;
    max-width: 100%;
    resize: vertical;
}

/* ---------- Small screens ---------- */
@media (max-width: 991.98px) {

    .stock-filter-row > label {
        text-align: left !important;
    }

    #itemStockTable {
        min-width: 1050px;
    }

    #followupModal .modal-body {
        max-height: calc(100vh - 135px);
    }
}

@media (max-width: 767.98px) {

    .stock-summary-row {
        margin-left: 0;
        margin-right: 0;
    }

    .stock-summary-row > [class*="col-"] {
        flex: 0 0 100%;
        max-width: 100%;
        padding-left: .5rem;
        padding-right: .5rem;
    }

    .stock-summary-row .widget-stat h2 {
        font-size: 40px !important;
    }

    /*
     * Stack every filter control on phones.
     * This prevents the 320px layout from being squeezed.
     */
    .stock-filter-row {
        display: block;
    }

    .stock-filter-row > label,
    .stock-filter-row > .stock-field {
        display: block;
        width: 100%;
        max-width: 100%;
        flex: none;
        padding-left: 0 !important;
        padding-right: 0 !important;
        text-align: left !important;
    }

    .stock-filter-row .input-group {
        width: 100%;
    }

    .stock-filter-row select {
        width: 100%;
        max-width: 100%;
    }

    /*
     * The complete table remains wide enough to be readable.
     * Only this wrapper scrolls horizontally.
     */
    .stock-table-wrapper {
        overflow-x: auto;
        padding-bottom: 8px;
    }

    #itemStockTable {
        min-width: 1050px;
        width: 1050px;
        table-layout: auto;
    }

    /* Modal uses almost the complete viewport width. */
    #followupModal .modal-dialog {
        width: calc(100vw - 12px);
        max-width: none;
    }

    #followupModal .modal-content {
        max-height: calc(100vh - 12px);
    }

    #followupModal .modal-body {
        max-height: calc(100vh - 125px);
        padding: .75rem;
    }

    .followup-table-wrapper {
        overflow-x: auto;
        padding-bottom: 6px;
    }

    #followuptable {
        min-width: 650px;
        width: 650px;
    }

    #followupModal .modal-footer {
        flex-wrap: wrap;
        gap: .5rem;
    }

    #followupModal .modal-footer .btn {
        margin: 0;
    }
}

@media (max-width: 400px) {

    .stock-summary-row .widget-stat h2 {
        font-size: 34px !important;
    }

    .stock-table-wrapper {
        margin-left: 0;
        margin-right: 0;
    }

    /*
     * 320px / 360px / 375px phones:
     * no page-level horizontal scroll.
     * User swipes the table itself.
     */
    #itemStockTable {
        min-width: 1050px;
        width: 1050px;
    }

    #followupModal .modal-dialog {
        width: calc(100vw - 8px);
    }

    #followupModal .modal-body {
        padding: .6rem;
    }

    #followuptable {
        min-width: 650px;
        width: 650px;
    }

    #followupModal .modal-footer {
        padding: .6rem;
    }
}
</style>
<style>
    .card-body #itemStockTable th{
        font-weight: 500;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Stock Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Item Stock</h6>
            </div>
            <div class="col" align="right">
                <!-- <span data-toggle=modal data-target=#itemcatModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span> -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row stock-summary-row">
            <div class="col-md-4">
                <div class="widget-stat card">
                    <div class="card-body">
                        <div class="text-center ">
                            <i class="fas fa-layer-group fa-2x"></i><br />
                            <h6>Total Stock Inwarded</h6>
                            <h2 class="text-center font-weight-bold" style=font-size:50px>
                                <?php
                                    if($POItem==null){
                                        echo "";
                                    }else{
                                        echo $totalstock['TotalStock'];
                                    }         
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="widget-stat card">
                    <div class="card-body">
                        <div class="text-center ">
                            <i class="fas fa-check-square fa-2x"></i><br />
                            <h6>Total Stock Used</h6>
                            <h2 class="text-center font-weight-bold" style=font-size:50px>
                                <?php
                                if($POItem==null){
                                    echo "";
                                }else{
                                    echo $totalstockUsed['TotalStockUsed'];
                                }
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="form-group">
            <div class="row">
                <form class="stock-filter-form">
                    <div class="form-group">
                        <div class="row stock-filter-row">

                            <label class="col-md-2 text-right">Brands <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="brands" class="form-select" required name="brands">

                                </select>
                            </div>

                            <label class="col-md-2 text-right">Category <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="Category" class="form-select" required name="Category">

                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="ui-widget  input-group">

                        <label class="col-md-2 text-right">Sub Category <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <select id="subCategory" class="form-select" required name="subCategory">

                            </select>
                        </div>
                        <label class="col-md-2 text-right" for="tags">Items List </label>
                        <div class="col-md-4  input-group">
                            <select id="item" class="form-select" required name="item">

                            </select>
                            <button class="btn btn-outline-primary" type="submit"><i
                                    class="fas fa-search-dollar"></i></button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
        <div class="stock-table-wrapper">
            <table class="table table-bordered" id="itemStockTable" width="100%" cellspacing="0">
            <thead align="center">
                <tr>
                    <th style='display:none'>Item ID</th>
                    <th style='display:none'>POID</th>
                    <th>Name</th>
                    <th>PO ID</th>
                    <th>PO Type</th>
                    <th>Quantity Raised</th>
                    <th>Quantity Inwarded</th>
                    <th>Total Value</th>
                    <th>Net Rate</th>
                    <th>Inwarded Rate</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($POItem!=null)
                {
                    $id=$POItem->get_itemid();
                    $lineitemList = DBPOLineItem::getPOLineItemByItemId($id);
                    foreach ($lineitemList as $lineitem) {

                        echo "<tr>  <td style='display:none'>" . $lineitem->get_itemid() . "</td>
                        <td style='display:none'>" . $lineitem->get_POID() . "</td>
                        <td>" . $lineitem->getName() . "</td>
                        <td>" . $lineitem->getPOcode() . "</td>
                        <td>" . $lineitem->getPOType() . "</td>
                        <td>" . $lineitem->getRaisedQty() . "</td>
                        <td>" . $lineitem->get_ReceivedQty() . "</td>
                        <td>" . $lineitem->get_totalamt() . "</td>
                        <td>" . $lineitem->get_price() . "</td>
                        <td>" . $lineitem->get_ReceivedQtyAmt() . "</td>
                        <td>  <div class='dropdown'>
                        <button class='btn btn-secondary dropdown-toggle' 
                        type='button' 
                        id='dropdownMenu2' 
                        data-toggle='dropdown' 
                       
                        aria-expanded='false'>
                        Actions
                        </button>
                            <div class='dropdown-menu' 
                                aria-labelledby='dropdownMenu2'>
                                    <button class='btn btn-primary dropdown-item'
                                        data-toggle='modal' 
                                        data-target='#followupModal' 
                                        role='button' data-id='" . $lineitem->get_itemid() . "'> 
                                            <i class='fas fa-info-circle'></i>
                                                Follow Up 
                                    </button>
                            
                                    <a class='btn btn-primary dropdown-item'
                                    role='button' 
                                    href='../View/ProjectItemAllocation.php?id=".$lineitem->get_itemid()."'>
                                    <i class='fas fa-project-diagram'></i>Project Allocation</a> 
                                   
                                   
                            </div>
                        </div>
                       </td></tr>
                        </span></td></tr>";
                    }
                }
                    ?>
            </tbody>
            </table>
        </div>

        <div class="modal fade draggable-modal" id="followupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <form method="post" id="followup_form" enctype="multipart/form-data"
                    action="../Controller/issues_followupcontroller.php">
                    <div class="modal-content">
                        <div class="modal-header draggable-modal-header">
                            <h5 class="modal-title">Issue Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="followup-table-wrapper">
                                <table class="table table-bordered" id="followuptable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>

                                            Followed By

                                        </th>
                                        <th>

                                            Issues

                                        </th>
                                        <th>

                                            Date

                                        </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend>Issues:</legend>
                                            <div class="form-floating">
                                                <textarea class="form-control" id="followcomment"
                                                    style="height: 100px;text-transform:capitalize"
                                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup"
                                                    name="followcomment"></textarea>
                                                <label for="followcomment">Leave a issue here</label>
                                            </div>
                                            <input type="hidden" name="followupItemId" id="followupItemId" value="">
                                            <input type="hidden" name="followupPOID" id="followupPOID" value="">
                                            <fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" name="followupBy" id="followupBy" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value=<?php echo $_SESSION['login_user']; ?> />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="FollowupBtn">FollowUp</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>


<script>
$(document).ready(function() {
    debugger;
    $(document).on('blur', '#followcomment', function (){
        debugger;
        if($("#followcomment").val()==""){
            $("#FollowupBtn").addClass('disabled');
        }else{
            $("#FollowupBtn").removeClass('disabled');
        }
    });
    let InputId = 1;
    var fetchBrand = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputId;
    let brandId = 0;
    $.getJSON(fetchBrand, function(data) {
        $.each(data, function(index, value) {
            $('#brands').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $('#brands').append('<option value="' + value.brandid + '">' + value
                .brandname + '</option>');
        });
    });

    $('#brands').on('change', function() {
    debugger;

    var selectedBrandId = this.value;

    // Clear previously loaded categories
    $('#Category').empty();

    // Reset sub category and item list because brand has changed
    $('#subCategory').empty();
    $('#item').empty();

    // Add default category option
    $('#Category').append(
        '<option hidden disabled selected value>-- select an option --</option>'
    );

    var fetchsubcaturl = config.developmentPath +
        "/Admin/Controller/item_categorycontroller.php/?brandId=" +
        selectedBrandId;

    $.getJSON(fetchsubcaturl, function(data) {

        $.each(data, function(index, value) {

            $('#Category').append(
                '<option value="' + value.itemcatid + '">' +
                value.itemcatname +
                '</option>'
            );

            $('#editedCategory').append(
                '<option value="' + value.itemcatid + '">' +
                value.itemcatname +
                '</option>'
            );

        });

    });
});



    $('#Category').on('change', function() {
        $('#subCategory').empty();
        fetchsubcaturl =
            config.developmentPath +
            "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
            .value;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#subCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#subCategory').append('<option value="' + value
                    .itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
            });
        });
    });


    $('#subCategory').on('change', function() {
        debugger;
        $('#item').empty();
        setItemlist($('#Category').val(), this.value, $('#brands').val());
    });


    function setItemlist(catId, subcatId, brandId) {
        debugger;
        var fetchitemlisturl = config.developmentPath +
            "/Admin/Controller/item_detailscontroller.php/?catId=" + catId + "&subcatId=" +
            subcatId +
            "&brandId=" + brandId;
        console.log(fetchitemlisturl);
        $.getJSON(fetchitemlisturl, function(data) {
            itemDetails = data;
            quantityDetails = data;
            $('#item').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                $('#item').append('<option value="' + value.itemid + '">' +
                    value
                    .itemname + '</option>');

                // $('#editedsubCategory').append('<option value="' + value.itemsubcatid +
                //     '">' +
                //     value
                //     .itemsubcatname + '</option>');
            });
        });
    }

    $('#itemStockTable tbody').on('click', 'tr', function() {
        /* Get the row as a parent of the link that was clicked on */
        $('#followupItemId').val(this.cells[0].innerHTML);
        $('#followupPOID').val(this.cells[1].innerHTML);

    });

    $('#followupModal').on('show.bs.modal', function(e) {
        debugger;
         $('#FollowupBtn').addClass('disabled');
        var rowid = $(e.relatedTarget).data('id');
        $('#followupItemId').val(rowid);
        var POID = $('#followupPOID').val();
        var contactUrl = config.developmentPath +
            "/Admin/Controller/issues_followupcontroller.php/?id=" +
            rowid + "&POID=" + POID;
        $.getJSON(contactUrl, function(data) {
            $("#followuptable").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#followuptable tbody').
                append($(document.createElement('tr')).prop({
                    id: value.followupPOID
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

    $('#projAllocation').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $('#followupItemId').val(rowid);
        var POID = $('#followupPOID').val();
        var contactUrl = config.developmentPath +
            "/Admin/Controller/allocateitemsController.php/?id=" +
            rowid;
        $.getJSON(contactUrl, function(data) {
            $("#projAllocationtable").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#projAllocationtable tbody').
                append($(document.createElement('tr')).prop({
                    id: value.itemId
                }));

                $('#projAllocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.ProjectCode
                }));

                $('#projAllocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.CustomerName
                }));
                $('#projAllocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.AllocatedQty
                }));

            });
        });
    });


    /* =========================================================
       RESPONSIVE + DRAGGABLE BOOTSTRAP MODAL
       Mouse + touch. Constrained to viewport.
       ========================================================= */

    function centerFollowupModal() {

        var $modal = $('#followupModal');
        var $dialog = $modal.find('.modal-dialog');

        if (!$dialog.length) {
            return;
        }

        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();

        var dialogWidth = $dialog.outerWidth();
        var dialogHeight = $dialog.outerHeight();

        var left = Math.max(4, (viewportWidth - dialogWidth) / 2);
        var top = Math.max(4, (viewportHeight - dialogHeight) / 2);

        $dialog.css({
            left: left + 'px',
            top: top + 'px',
            transform: 'none'
        });
    }


    $('#followupModal').on('shown.bs.modal', function () {

        /*
         * Wait one frame so Bootstrap has finished displaying
         * the modal before calculating its dimensions.
         */
        requestAnimationFrame(function () {
            centerFollowupModal();
        });

    });


    $('#followupModal').on('hidden.bs.modal', function () {

        /*
         * Reset position so every new opening starts centered.
         */
        $(this).find('.modal-dialog').css({
            left: '',
            top: '',
            transform: ''
        });

    });


    /* ---------- Drag with mouse + touch ---------- */

    (function () {

        var $dialog = $('#followupModal .modal-dialog');
        var $handle = $('#followupModal .draggable-modal-header');

        var dragging = false;
        var pointerId = null;

        var startPointerX = 0;
        var startPointerY = 0;

        var startLeft = 0;
        var startTop = 0;


        function getBounds() {

            var viewportWidth = $(window).width();
            var viewportHeight = $(window).height();

            var dialogWidth = $dialog.outerWidth();
            var dialogHeight = $dialog.outerHeight();

            return {
                minLeft: 4,
                maxLeft: Math.max(4, viewportWidth - dialogWidth - 4),
                minTop: 4,
                maxTop: Math.max(4, viewportHeight - dialogHeight - 4)
            };

        }


        function startDrag(clientX, clientY, id) {

            if (!$dialog.is(':visible')) {
                return;
            }

            dragging = true;
            pointerId = id;

            startPointerX = clientX;
            startPointerY = clientY;

            startLeft = parseFloat($dialog.css('left'));

            startTop = parseFloat($dialog.css('top'));

            if (isNaN(startLeft)) {
                startLeft = $dialog.offset().left;
            }

            if (isNaN(startTop)) {
                startTop = $dialog.offset().top;
            }

            $dialog.css('transform', 'none');

        }


        function moveDrag(clientX, clientY) {

            if (!dragging) {
                return;
            }

            var bounds = getBounds();

            var newLeft =
                startLeft +
                (clientX - startPointerX);

            var newTop =
                startTop +
                (clientY - startPointerY);


            newLeft = Math.max(
                bounds.minLeft,
                Math.min(bounds.maxLeft, newLeft)
            );

            newTop = Math.max(
                bounds.minTop,
                Math.min(bounds.maxTop, newTop)
            );


            $dialog.css({
                left: newLeft + 'px',
                top: newTop + 'px'
            });

        }


        function stopDrag() {

            dragging = false;
            pointerId = null;

        }


        /*
         * Pointer Events where supported.
         */
        if (window.PointerEvent) {

            $handle.on('pointerdown', function (e) {

                if (e.button !== undefined && e.button !== 0) {
                    return;
                }

                startDrag(
                    e.clientX,
                    e.clientY,
                    e.pointerId
                );

                try {
                    this.setPointerCapture(e.pointerId);
                } catch (ignore) {}

                e.preventDefault();

            });


            $handle.on('pointermove', function (e) {

                if (
                    dragging &&
                    pointerId === e.pointerId
                ) {

                    moveDrag(
                        e.clientX,
                        e.clientY
                    );

                    e.preventDefault();
                }

            });


            $handle.on('pointerup pointercancel', function (e) {

                if (
                    pointerId === e.pointerId
                ) {
                    stopDrag();
                }

            });

        } else {

            /*
             * Mouse fallback.
             */
            $handle.on('mousedown', function (e) {

                startDrag(
                    e.clientX,
                    e.clientY,
                    'mouse'
                );

                e.preventDefault();

            });


            $(document).on('mousemove.stockModalDrag', function (e) {

                if (dragging) {
                    moveDrag(
                        e.clientX,
                        e.clientY
                    );
                }

            });


            $(document).on('mouseup.stockModalDrag', function () {

                stopDrag();

            });


            /*
             * Touch fallback.
             */
            $handle.on('touchstart', function (e) {

                var touch = e.originalEvent.touches[0];

                if (!touch) {
                    return;
                }

                startDrag(
                    touch.clientX,
                    touch.clientY,
                    'touch'
                );

            });


            $(document).on('touchmove.stockModalDrag', function (e) {

                if (!dragging) {
                    return;
                }

                var touch = e.originalEvent.touches[0];

                if (touch) {

                    moveDrag(
                        touch.clientX,
                        touch.clientY
                    );

                    e.preventDefault();
                }

            });


            $(document).on('touchend.stockModalDrag', function () {

                stopDrag();

            });

        }


        /*
         * Keep the modal inside the screen after resize/orientation.
         */
        $(window).on('resize.stockModalDrag orientationchange.stockModalDrag', function () {

            if (!$('#followupModal').hasClass('show')) {
                return;
            }

            setTimeout(function () {

                var bounds = getBounds();

                var currentLeft = parseFloat($dialog.css('left')) || 0;
                var currentTop = parseFloat($dialog.css('top')) || 0;

                currentLeft = Math.max(
                    bounds.minLeft,
                    Math.min(bounds.maxLeft, currentLeft)
                );

                currentTop = Math.max(
                    bounds.minTop,
                    Math.min(bounds.maxTop, currentTop)
                );

                $dialog.css({
                    left: currentLeft + 'px',
                    top: currentTop + 'px'
                });

            }, 100);

        });

    })();

});

</script>