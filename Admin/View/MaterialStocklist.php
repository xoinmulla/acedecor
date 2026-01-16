<?php
include('session.php');
include "materialListNavigation.php";
require_once("../DB Operations/item_stocksOps.php");
require_once("../DB Operations/materialOps.php");
require_once("../DB Operations/POlineitemOps.php");
require_once("../DB Operations/allocateitemsOps.php");
require_once("../Model/item_stocksmodel.php");
if ($_SERVER["REQUEST_METHOD"]=="GET") {
    // error_log($_GET["material"]);
    $POmaterial=null;
    if (isset($_GET["material"])) {
        $POmaterialid=$_GET["material"];
        error_log($_GET["material"]);
        $POmaterial=DBmaterialdetails::getallMaterialdetailsbasedonIDforstocks($POmaterialid);
 
        error_log($POmaterialid);
        $db=ConnectDb::getInstance();
        $query="SELECT SUM(ReceivedQty) as TotalStock from item_stock where item_id=$POmaterialid";
        error_log($query);
        $result=mysqli_query($db->getConnection(),$query);
        $totalstock=mysqli_fetch_assoc($result);

        $query="SELECT SUM(AllocatedQty) as TotalStockUsed from itemallocation where ItemId=$POmaterialid";
        error_log($query);
        $result=mysqli_query($db->getConnection(),$query);
        $totalstockUsed=mysqli_fetch_assoc($result);
    }
   
}
?>
<h1 class="h3 mb-4 text-gray-800">Stock Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Material Stock</h6>
            </div>
            <div class="col" align="right">
                <!-- <span data-toggle=modal data-target=#materialcatModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span> -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class=row>
            <div class="col-md-4">
                <div class="widget-stat card">
                    <div class="card-body">
                        <div class="text-center ">
                            <i class="fas fa-layer-group fa-2x"></i><br />
                            <h6>Total Stock Inwarded</h6>
                            <h2 class="text-center font-weight-bold" style=font-size:50px>
                                <?php
                                    if($POmaterial==null){
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
                                if($POmaterial==null){
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
                <form>
                    <div class="form-group">
                        <div class="row">

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
                        <label class="col-md-2 text-right" for="tags">Material List </label>
                        <div class="col-md-4  input-group">
                            <select id="material" class="form-select" required name="material">

                            </select>
                            <button class="btn btn-outline-primary" type="submit"><i
                                    class="fas fa-search-dollar"></i></button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" id="linematerialTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style='display:none'>material ID</th>
                    <th style='display:none'>POID</th>
                    <th>Material Name</th>
                    <th>PO Code</th>
                    <th>PO Type</th>
                    <th>Quantity Raised</th>
                    <th>Quantity Inwarded</th>
                    <th>Total Value of Stock</th>
                    <th>Net Rate of Material</th>
                    <th>Latest Rate of Material</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($POmaterial!=null)
                {
                    $id=$POmaterial->get_materialid();
                    $linematerialList = DBPOLineItem::getPOLineItemByItemId($id);
                    foreach ($linematerialList as $linematerial) {

                        echo "<tr>  <td style='display:none'>" . $linematerial->get_itemid() . "</td>
                        <td style='display:none'>" . $linematerial->get_POID() . "</td>
                        <td>" . $linematerial->getName() . "</td>
                        <td>" . $linematerial->getPOcode() . "</td>
                        <td>" . $linematerial->getPOType() . "</td>
                        <td>" . $linematerial->getRaisedQty() . "</td>
                        <td>" . $linematerial->get_ReceivedQty() . "</td>
                        <td>" . $linematerial->get_totalamt() . "</td>
                        <td>" . $linematerial->get_price() . "</td>
                        <td>" . $linematerial->get_ReceivedQtyAmt() . "</td>
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
                                role='button' data-id='" . $linematerial->get_itemid() . "'> 
                                    <i class='fas fa-info-circle'></i>
                                        Follow Up 
                            </button>
                    
                            <a class='btn btn-primary dropdown-item'
                            role='button' 
                            href='../View/ProjectMaterialAllocation.php?id=".$linematerial->get_itemid()."'>
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
        <div class="modal fade" id="followupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <form method="post" id="followup_form" enctype="multipart/form-data"
                    action="../Controller/MatIssues_followupcontroller.php">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Issue Details</h5>
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

                                            Issues

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
                                            <legend>Issues:</legend>
                                            <div class="form-floating">
                                                <textarea class="form-control" id="followcomment"
                                                    style="height: 100px;text-transform:capitalize"
                                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup"
                                                    name="followcomment"></textarea>
                                                <label for="followcomment">Leave a issue here</label>
                                            </div>
                                            <input type="hidden" name="followupmaterialId" id="followupmaterialId"
                                                value="">
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

    let InputId = 2;
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
        $('#Category').empty();
        var fetchsubcaturl = config.developmentPath +
            "/Admin/Controller/material_CategoryController.php/?brandId=" +
            this.value;
        $.getJSON(fetchsubcaturl, function(data) {

            $('#Category').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function(index, value) {

                $('#Category').append('<option value="' + value.materialcatId + '">' +
                    value
                    .materialCatname + '</option>');
                $('#editedCategory').append('<option value="' + value.materialcatId +
                    '">' +
                    value
                    .materialCatname + '</option>');
            });
        });
    });



    $('#Category').on('change', function() {
        $('#subCategory').empty();
        fetchsubcaturl =
            config.developmentPath +
            "/Admin/Controller/material_SubcategoryController.php/?catId=" + this
            .value;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#subCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#subCategory').append('<option value="' + value
                    .materialsubcatId +
                    '">' +
                    value
                    .materialsubcatName + '</option>');
            });
        });
    });


    $('#subCategory').on('change', function() {
        debugger;
        $('#material').empty();
        setmateriallist($('#Category').val(), this.value, $('#brands').val());
    });


    function setmateriallist(catId, subcatId, brandId, thicknessId = 0) {
        debugger;
        var fetchmateriallisturl = config.developmentPath +
            "/Admin/Controller/materialController.php/?catId=" + catId + "&subcatId=" +
            subcatId +
            "&brandId=" + brandId + "&thicknessId=" + thicknessId;
        console.log(fetchmateriallisturl);
        $.getJSON(fetchmateriallisturl, function(data) {
            materialDetails = data;
            quantityDetails = data;
            $('#material').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                $('#material').append('<option value="' + value.MaterialId + '">' +
                    value
                    .MaterialName + '</option>');
            });
        });
    }

    $('#linematerialTable tbody').on('click', 'tr', function() {
        /* Get the row as a parent of the link that was clicked on */
        $('#followupmaterialId').val(this.cells[0].innerHTML);
        $('#followupPOID').val(this.cells[1].innerHTML);

    });

    $('#followupModal').on('show.bs.modal', function(e) {
        debugger;
        $('#FollowupBtn').addClass('disabled');
        var rowid = $(e.relatedTarget).data('id');
        $('#followupmaterialId').val(rowid);
        var POID = $('#followupPOID').val();
        var contactUrl = config.developmentPath +
            "/Admin/Controller/MatIssues_followupcontroller.php/?id=" +
            rowid + "&POID=" + POID;
            console.log(contactUrl);
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
        $('#followupmaterialId').val(rowid);
        var POID = $('#followupPOID').val();
        var contactUrl = config.developmentPath +
            "/Admin/Controller/allocatematerialsController.php/?id=" +
            rowid;
        $.getJSON(contactUrl, function(data) {
            $("#projAllocationtable").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#projAllocationtable tbody').
                append($(document.createElement('tr')).prop({
                    id: value.materialId
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

});
</script>