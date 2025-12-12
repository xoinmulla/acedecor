<?php
include('session.php');
include('ProjAllocationNavigation.php');
require_once("../DB Operations/projectOps.php");
require_once("../Model/projectModel.php");
require_once("../DB Operations/allocateitemsOps.php");


$id=$_GET["id"];
$db=ConnectDb::getInstance();
        $query="SELECT SUM(ReceivedQty) as TotalStock from item_stock where item_id=$id";
        error_log($query);
        $result=mysqli_query($db->getConnection(),$query);
        $totalstock=mysqli_fetch_assoc($result);

        $query="SELECT SUM(AllocatedQty) as TotalStockUsed from itemallocation where ItemId=$id";
        error_log($query);
        $result=mysqli_query($db->getConnection(),$query);
        $totalstockUsed=mysqli_fetch_assoc($result);

?>

<head>
    <style>
    .table {
        width: 94%;
        margin-bottom: 1 rem;
        margin-left: 3%;
        color: #858796;
    }
    </style>
</head>

<h1 class="h3 mb-4 text-gray-800">Item Allocation Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Item Allocation List</h6>
            </div>
        </div>
    </div>

    <div class="card-body">
    <div class=row>
        <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="widget-stat card">
                    <div class="card-body">
                        <div class="text-center ">
                            <i class="fas fa-layer-group fa-2x"></i><br />
                            <h6>Total Stock Inwarded</h6>
                            <h2 class="text-center font-weight-bold" style=font-size:50px>
                                <?php
                                    
                                    
                                        echo $totalstock['TotalStock'];
                                             
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
                                
                                    echo $totalstockUsed['TotalStockUsed'];
                                
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered" id="projAllocationtable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>
                            Item Name
                        </th>
                        <th>
                            PO Code
                        </th>
                        <th style=display:none>ProjectId</th>
                        <th>

                            Project Code

                        </th>
                        <th>

                            Customer Name

                        </th>
                        <th>

                            Allocated Quantity

                        </th>

                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   $AllocationList= DBallocate::getAllocatedItemInfo($id);
                   foreach ($AllocationList as $Allocation) {
                    echo "<tr><td>" . $Allocation->getItemName() . "</td>
                    <td>" . $Allocation->getPOcode() . "</td>
                    <td style=display:none>" . $Allocation->get_ProjectId() . "</td>
                    <td>" . $Allocation->getProjectCode() . "</td>
                    <td> " . $Allocation->getCustomerName() . "</td>
                    <td>" . $Allocation->get_AllocatedQty() . "</td>
                    <td>
                    <button type='button' class='btn btn-secondary'";
                   
                        echo "data-toggle='modal'
                     data-target='#deallocationModal'
                     data-id=" . $Allocation->get_itemId() . " id='allocatebtn'>
                     De-Allocate
                    </button>
                        ";}
                    echo "
                    </td></tr>";

        
                  
                ?>
                </tbody>
            </table>

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
    </div>

</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=deallocationModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="deallocate_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">De-Allocate Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to De-Allocate this item.
                    </p>
                    <input type="hidden" name="DeallocateItemId" id="DeallocateItemId" value="<?php echo $id?>">
                    <input type="hidden" name="ProjectId" id="ProjectId" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="allocatebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {

    

    $('#projAllocationtable tbody').on('click', 'tr', function() {
        debugger;
        $('#ProjectId').val(this.cells[2].innerHTML);

    });

    $('#deallocate_form').submit(function(event) {
        debugger;
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath + "/Admin/Controller/allocateitemsController.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });




});
</script>