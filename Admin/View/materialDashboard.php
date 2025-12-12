<?php
include('session.php');
include('materialNavigation.php');
require_once("../DB Operations/item_stocksOps.php");
require_once("../DB Operations/POlineitemOps.php");
require_once("../Model/item_stocksmodel.php");
require_once("../DB Operations/item_detailsOps.php");
require_once("../DB Operations/item_stocksOps.php");
require_once("../DB Operations/item_detailsOps.php");
require_once("../DB Operations/POlineitemOps.php");
require_once("../Model/item_stocksmodel.php");

?>
<style>
#editedPOlineItemTable {
    height: 200px;
    display: inline-block;
    width: 100%;
    overflow: auto;
}

#editedPOlineItemTable thead {
    background-color: grey;
    color: whitesmoke;
    position: sticky;
    top: 0;
}

.pad {
    padding-right: .5rem;
}
</style>
<h1 class="h3 mb-4 text-gray-800">Material Stock Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Material List With Issues </h6>
            </div>
            <!-- <div class="col" align="right">
                <span data-toggle=modal data-target=#purchaseModal>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <div class="col-md-9">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="Issues-tab" data-bs-toggle="tab" data-bs-target="#Issues"
                        type="button" role="tab" aria-controls="Issues" aria-selected="true"><b>Issues</b></button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="PricingIssues-tab" data-bs-toggle="tab" data-bs-target="#PricingIssues"
                        type="button" role="tab" aria-controls="PricingIssues" aria-selected="false"><b>Pricing
                            Issues</b></button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ItemList-tab" data-bs-toggle="tab" data-bs-target="#ItemList"
                        type="button" role="tab" aria-controls="ItemList" aria-selected="false"><b>Item
                            List</b></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ItemStockList-tab" data-bs-toggle="tab" data-bs-target="#ItemStockList"
                        type="button" role="tab" aria-controls="ItemStockList" aria-selected="false"><b>Item Stock
                            List</b></button>
                </li> -->
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="Issues" role="tabpanel" aria-labelledby="Issues-tab">
                <br />
                <div class="table-responsive">
                    <table class="table table-bordered" id="quote_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style='display:none'>Material Stock Id</th>
                                <th style='display:none'>Material Id</th>
                                <th>Material Name</th>
                                <th style='display:none'>Purchase Order ID</th>
                                <th>Purchase Order Code</th>
                                <th>Invoice No</th>
                                <th>Status</th>
                                <th style='display:none'> FollowupId</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php
                    $stockList = DBitemstock::getStockList();
                    foreach ($stockList as $stockObj) {
                        echo "<tr>
                        <td style='display:none'>" . $stockObj->get_StockId() . "</td>
                        <td style='display:none'>" . $stockObj->get_itemid() . "</td>
                        <td>" . $stockObj->getItemname() . "</td>
                        <td style='display:none'>" . $stockObj->get_POID() . "</td>
                        <td >" . $stockObj->getPOcode() . "</td>
                        <td >" . $stockObj->get_InvoiceNo() . "</td>
                        <td style='display:none'>" . $stockObj->getfollowupId() . "</td>
                        <td>" . $stockObj->get_followupStatus() . "</td>
                        <td>
                        <div class='dropdown'>
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
                            data-target='#editIssuesModal' 
                            role='button' 
                            data-id='".$stockObj->get_itemid()."'>
                            <i class='fas fa-user-edit'></i> 
                                Edit
                           </button>

                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#IssuesfollowupModal' 
                           role='button' data-id='" . $stockObj->get_itemid() . "'> 
                           <i class='fas fa-info-circle'></i>
                              Issues
                           </button>

                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteCategoryModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $stockObj->get_itemid() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete 
                          </button>
                        </div>
                    </div>     
                        
                   </td>
                       </tr>";
                    }
                    ?> -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade " id="PricingIssues" role="tabpanel" aria-labelledby="PricingIssues-tab">
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered" id="priceissue_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style='display:none'>Material ID</th>
                                <th>POID</th>
                                <th>Invoice No</th>
                                <th>Supplier</th>
                                <th>Name</th>
                                <th>MRP</th>
                                <th>Paid Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- <?php
                    $ItemList = DBitemstock::getallItemsWithHighPrices();
                    foreach ($ItemList as $Items) {
                        echo "<tr><td style='display:none'>" . $Items->get_itemid() . "</td>
                        <td>" . $Items->getPOcode() . "</td>
                        <td>" . $Items->get_InvoiceNo() . "</td>
                        <td >" . $Items->get_SupplierName() . "</td>
                        <td >" . $Items->getitemname() . "</td>
                        <td >" . $Items->get_price() . "</td>
                        <td >" . $Items->get_ReceivedQtyAmt() . "</td>
                        <td>" . $Items->getStatus() . "</td>
                        <td>
                        <div class='dropdown'>
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
                            data-target='#editPricingIssuesModal' 
                            role='button' 
                            data-id='".$stockObj->get_itemid()."'>
                            <i class='fas fa-user-edit'></i> 
                                Edit
                           </button>

                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deletePricingIssuesModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $stockObj->get_itemid() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete 
                          </button>
                        </div>
                    </div>     
                        
                   </td>
                       </tr>";
                    }
                    ?> -->
                        </tbody>
                        <tbody>
                    </table>
                </div>
            </div>
          
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=itemdetailsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemdetails_form" enctype="multipart/form-data"
            action="../Controller/item_detailscontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Item Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemname" id="itemname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" id="itemcatid" name="itemcatid" value="">
                                <input type="hidden" id="itemsubcatid" name="itemsubcatid" value="">
                                <input type="hidden" id="itemcompid" name="itemcompid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Category<span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="itemCategory" class="form-select" required name="itemCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Subcategory<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="subCategory" class="form-select" required name="subCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemsubcatModal'><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <textarea name="itemdescription" id="itemdescription" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="company" class="form-select" required name="company">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Code <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemarticleNo" id="itemarticleNo" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">HSNcode <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemhsncode" id="itemhsncode" class="form-control"
                                    data-parsley-type="email" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Order Number <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemOrderNo" id="itemOrderNo" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type='text' name="itemsize" id="itemsize" class="form-control" required
                                    data-parsley-trigger="change" />

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">unit <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="unit" class="form-select" required name="unit">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">factor <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="unitFactor" class="form-select" required name="unitFactor">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Standard Packing Unit">SPU<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itempu" id="itempu" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">MRP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemMRP" id="itemMRP" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Goods and Service Tax">GST <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemGST" id="itemGST" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Total MRP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="totalMRP" id="totalMRP" class="form-control" required
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Amount <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemppMRP" id="itemppMRP" class="form-control" required
                                    readonly data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Upload Item Image <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="itemimage" id="itemimage" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcreatedby" id="itemcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemmodifiedby" id="itemmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade " id=edititemdetailsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="editeditemdetails_form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Item Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemname" id="editeditemname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" id="itemid" name="itemid" value="">
                                <input type="hidden" id="editeditemcatid" name="itemcatid" value="">
                                <input type="hidden" id="editeditemsubcatid" name="itemsubcatid" value="">
                                <input type="hidden" id="editeditemcompid" name="itemcompid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Category<span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="editeditemCategory" class="form-select" required name="itemCategory">

                                </select>

                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Subcategory <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="editedsubCategory" class="form-select" required name="subCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemsubcatModal'><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemdescription" id="editeditemdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="editedcompany" class="form-select" required name="company">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Code<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemarticleNo" id="editeditemarticleNo" class="form-control"
                                    required data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">HSNcode <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemhsncode" id="editeditemhsncode" class="form-control"
                                    data-parsley-type="email" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Order Number <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemOrderNo" id="editeditemOrderNo" class="form-control"
                                    required data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type='text' name="itemsize" id="editeditemsize" class="form-control" required
                                    data-parsley-trigger="change" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">unit <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedunit" class="form-select" required name="unit">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">factor <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="editedunitFactor" class="form-select" required name="unitFactor">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Standard Packing Unit">SPU<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itempu" id="editeditempu" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">MRP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemMRP" id="editeditemMRP" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Goods and Service Tax">GST <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemGST" id="editeditemGST" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Total MRP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="totalMRP" id="editedtotalMRP" class="form-control" required
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Amount<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemppMRP" id="editeditemppMRP" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="keyup"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Upload Item Image <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="itemimage" id="editeditemimage" class="form-control"
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcreatedby" id="editeditemcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemmodifiedby" id="editeditemmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=detailsItemModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Item Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <img src="" alt="..." id="itemImage" width="200px" height="200px">
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemName">Item Name </label>
                                    </div>
                                    <input type="hidden" id="infoitemid" name="infoitemid" value="">
                                    <div class="col-8">
                                        <h5 class="card-title" id="displayItemName"></h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemCategory">Item Category</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemCategory"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemSubCategory">Item Subcategory</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemSubCategory"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemDescription">Description</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemDescription"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemComapny">Brand</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemComapny"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemArticleNo">Item Code</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemArticleNo"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemHSNCode">HSN Code</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemHSNCode"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItempu">SPU</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItempu"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemsize">Quantity</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemsize"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayunit">unit</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayunit"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayunitFactor">unitFactor</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayunitFactor"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemMRP">MRP</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemMRP"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemGST">GST</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemGST"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaytotalMRP">Total MRP</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaytotalMRP"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemppMRP">Amount</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemppMRP"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-bordered" id="details_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>PO Code</th>
                                            <th>Invoice No</th>
                                            <th>Date of Purchase </th>
                                            <th>Item Price</th>
                                            <th>ReceivedQty</th>
                                            <th>ReceivedQtyAmt</th>
                                            <th>TotalAmount</th>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id=itemcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="addCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatname" id="itemcatname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatdescription" id="itemcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemcatcreatedby" id="itemcatcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
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
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addCategorybtn" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=itemsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="subCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="additemCategory" class="form-select" required name="itemcatid">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SubCategory Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatname" id="itemsubcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SubCategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatdescription" id="itemsubcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatcreatedby" id="itemsubcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatmodifiedby" id="itemsubcatmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addSubCategorybtn" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=viewModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Purchase Order Information</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    PO Details
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Item Details
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <table class="table table-bordered" id="displayPOlineItemTable" width="100%"
                                        cellspacing="0">
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
                                    <div class="form-group">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                                    <input type="hidden" name="action" id="action" value="Add" />
                                    <a name="button" id="editPOLineItem" class="btn btn-success">Edit Line item
                                    </a>
                                    <a name="button" id="printPDF" class="btn btn-success">Print/Save as PDF</a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=editIssuesModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog ">
        <form method="POST" id="editedIssues_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Issues</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedItemName" id="editedItemName" class="form-control"
                                    readonly />
                                <input type="hidden" name="followupId" id="followupId" value="">
                                <input type="hidden" name="POcode" id="POcode" value="">
                                <input type="hidden" name="followupPOID" id="followupPOID" value="">
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
                        <label class="col-md-4 text-right">Status<span class="text-danger">*</span></label>
                        <div class="col-md-8 input-group">
                            <select class="form-select" id="editedstatus" name="editedstatus" required>
                                <option value="">--Select an Option--</option>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>

                            </select>
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

                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id=editPricingIssuesModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog ">
        <form method="POST" id="editedPricingIssues_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Issues</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedPriceItemName" id="editedPriceItemName"
                                    class="form-control" readonly />
                                <input type="hidden" name="PricingIssueId" id="PricingIssueId" value="">
                                <input type="hidden" name="POcode" id="POcode" value="">
                                <input type="hidden" name="PricingPOID" id="PricingPOID" value="">
                                <input type="hidden" name="purchaseddate" id="purchaseddate" value="">
                                <input type="hidden" name="itemid" id="itemid" value="">
                                <input type="hidden" name="invoiceNo" id="invoiceNo" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Supplier Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedPriceSupplierName" id="editedPriceSupplierName"
                                    class="form-control" readonly />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Status<span class="text-danger">*</span></label>
                            <div class="col-md-8 input-group">
                                <select class="form-select" id="editedPricestatus" name="editedPricestatus" required>
                                    <option value="">--Select an Option--</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>

                                </select>
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

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="IssuesfollowupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <form method="post" id="followup_form" enctype="multipart/form-data"
            action="../Controller/issues_followupcontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Issue Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="Issuesfollowuptable" width="100%" cellspacing="0">
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
                    <!-- <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend>Issues:</legend>
                                            <div class="form-floating">
                                                <textarea class="form-control" id="followcomment" style="height: 100px;text-transform:capitalize"
                                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup"
                                                    name="followcomment"></textarea>
                                                <label for="followcomment">Leave a issue here</label>
                                            </div>
                                            <input type="hidden" name="followupItemId" id="followupItemId" value="">
                                            <input type="hidden" name="followupPOID" id="followupPOID" value="">
                                            <fieldset>
                                    </div>
                                </div>
                            </div> -->
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
                <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">FollowUp</button>
                        </div> -->
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=itemListModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemListForm" enctype="multipart/form-data" action="">
            <div class="modal-content">
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deleteItemModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_item_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=cancelPurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
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
                    <input type="submit" name="submit" id="deletebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=ResumePurchaseModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#IssuesfollowupModal').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $('#followupItemId').val(rowid);
        var POID=0;
        var contactUrl = config.developmentPath +
            "/Admin/Controller/issues_followupcontroller.php/?id=" +
            rowid + "&POID=" +POID;
        $.getJSON(contactUrl, function(data) {
            $("#Issuesfollowuptable").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#Issuesfollowuptable tbody').
                append($(document.createElement('tr')).prop({
                    id: value.followupPOID
                }));

                $('#Issuesfollowuptable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.followup_by
                }));
                $('#Issuesfollowuptable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.followup_comments
                }));
                $('#Issuesfollowuptable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.followup_on
                }));
            });
        });
    });

    $('#AllocateModal').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $('#followupItemId').val(rowid);
        var contactUrl = config.developmentPath +
            "/Admin/Controller/allocateitemsController.php/?id=" +
            rowid;
        $.getJSON(contactUrl, function(data) {
            $("#Allocationtable").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#Allocationtable tbody').
                append($(document.createElement('tr')).prop({
                    id: value.followupItemId
                }));

                $('#Allocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.CustomerName
                }));
                $('#Allocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.ProjectCode
                }));
                $('#Allocationtable tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.AllocatedQty
                }));
            });
        });
    });


    $('#editedIssues_form').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/issues_followupcontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });

    $('#editedPricingIssues_form').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/pricingissueController.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });


    var dataTable = $('#quote_table').DataTable({});
    var nEditing = null;

    var dataTable = $('#priceissue_table').DataTable({});
    var nEditing = null;

    $('#quote_table tbody').on('click', 'tr', function() {
        debugger;
        /* Get the row as a parent of the link that was clicked on */
        $('#id').val(this.cells[0].innerHTML);
        $('#POcode').val(this.cells[1].innerHTML);
        $('#followupPOID').val(this.cells[3].innerHTML);
        $('#PricingPOID').val(this.cells[1].innerHTML);
        $('#itemid').val(this.cells[1].innerHTML);
        $('#purchaseddate').val(this.cells[2].innerHTML);
        $('#POtype').val(this.cells[3].innerHTML);
        $('#supplier').val(this.cells[4].innerHTML);
        $('#editedItemName').val(this.cells[2].innerHTML);
        $('#editedPriceItemName').val(this.cells[4].innerHTML);
        $('#displaySupplierName').val(this.cells[2].innerHTML);
        $('#editedPriceSupplierName').val(this.cells[3].innerHTML);
        $('#followupId').val(this.cells[6].innerHTML);
        $('#invoiceNo').val(this.cells[2].innerHTML);

    });
    $('#priceissue_table tbody').on('click', 'tr', function() {
        debugger;
        /* Get the row as a parent of the link that was clicked on */

        $('#POcode').val(this.cells[1].innerHTML);
        $('#PricingPOID').val(this.cells[1].innerHTML);
        $('#editedPriceItemName').val(this.cells[4].innerHTML.replace('&amp;', '&'));
        $('#editedPriceSupplierName').val(this.cells[3].innerHTML);
        $('#invoiceNo').val(this.cells[2].innerHTML);

    });

    
   
});
</script>