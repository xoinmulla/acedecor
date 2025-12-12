<?php
include('session.php');
include('lineitemNavigation.php');
include('../DB Operations/lineItemOps.php');
include('../DB Operations/quotationOps.php');
$id = $_GET['matId'];
?>
<style>
fieldset {
    border: 1px solid lightgray !important;
}

legend {
    float: none;
    width: inherit !important;
    max-width: none !important;
    padding: 0;
    margin-bottom: .5rem;
    font-size: 16px;
    line-height: inherit;
}

fieldset label {
    margin-left: .5rem !important;
}
</style>
<h1 class="h3 mb-4 text-gray-800">Customer Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Quotation Item List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#AddModal data-id=<?php echo $id?>>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
        <?php $quotationList = DBQuotation::getQuotations($id) ?>
        <fieldset>
            <legend>Quote Info :</legend>
            <div class="row">
                <div class="col">
                    <label>Customer Id :
                        <span><?php echo $quotationList->getCustomerCode() ?></span>
                    </label>
                </div>
                <div class="col">
                    <label>Customer Name :
                        <span><?php echo $quotationList->get_customerName() ?></span>
                    </label>
                </div>
                <div class="col">
                    <label>DOE :
                        <span><?php echo $quotationList->getDOE() ?></span>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Quote Id :
                        <span><?php echo $quotationList->getQuoteCode() ?></span>
                    </label>
                </div>
                <div class="col">
                    <label>Description :
                        <span><?php echo $quotationList->get_quoteDescription() ?></span>
                    </label>
                </div>

                <div class="col">
                    <label>DOQ :
                        <span><?php echo $quotationList->getDOQ() ?></span>
                    </label>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <label>Total Amount :
                        <span id="displaySumTotalAmount"></span> <i class="fas fa-rupee-sign"></i>
                    </label>
                </div>

                <div class="col">
                    <label>Total Value :
                        <span id="displaysumTotalValue"></span> <i class="fas fa-rupee-sign"></i>

                    </label>
                </div>

                <div class="col">
                    <label>Total Price :
                        <span id="displaysumTotalPrice"></span> <i class="fas fa-rupee-sign"></i>

                    </label>
                </div>
                <!-- <div class="col">

                </div> -->
            </div>
            <div class="row">
                <div class="col">
                    <label>Quote Type :
                        <span><?php echo $quotationList->get_quoteType() ?></span>
                    </label>
                </div>
                <div class="col">
                    <label>Quote Value :
                        <span><?php echo $quotationList->getQuoteValue() ?> <i class="fas fa-rupee-sign"></i></span>
                    </label>
                </div>
                <div class="col">
                    <label>Status :
                        <span><?php echo $quotationList->get_quoteStatus() ?></span>
                    </label>
                </div>
            </div>

    </div>
    </fieldset>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered" id="lineItem_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Type</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Total Value</th>
                        <th>Discount(%)</th>
                        <th>GST</th>
                        <th>Total Price</th>
                        <th style='display:none'>QuoteId</th>
                        <th style='display:none'>MRP</th>
                        <th style='display:none'>unitFactor</th>
                        <th style='display:none'>Item Catid</th>
                        <th style='display:none'>Item SubCatid</th>
                        <th style='display:none'>Item Category</th>
                        <th style='display:none'>Item SubCategory</th>
                        <th style='display:none'>Discount Amt</th>
                        <th style='display:none'>QuoteCode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ListItem = DBLineItem::getMaterialLineItemByQuoteIdforOrder($id);
                    $sumTotalAmount=0;
                    $sumTotalPrice=0;
                    $sumTotalValue=0;
                    foreach ($ListItem as $Item) {
                        echo "<tr>
                        <td>" . $Item->getImage() . "</td>
                        <td>" . $Item->get_inputType() . "</td>
                        <td>" . $Item->getItemcode() . "</td>
                        <td>" . $Item->getName() . "</td>
                        <td>" . $Item->get_itemquantity() . "</td>
                        <td>" . $Item->get_totalAmount() . "</td>
                        <td>" . $Item->get_totalValue() . "</td>
                        <td>" . $Item->get_discount1() . "</td>
                        <td>" . $Item->get_GST() . "</td>
                        <td>" . $Item->get_totalPrice() . "</td>
                        <td style='display:none'>" . $id . "</td>
                        <td style='display:none'>" . $Item->get_ppMRP() . "</td>
                        <td style='display:none'>" . $Item->getUnitFactor() . "</td>
                        <td style='display:none'>" .$Item->get_itemcatid() . "</td>
                        <td style='display:none'>" .$Item->get_itemsubcatid() . "</td>
                        <td style='display:none' >" .$Item->get_itemcatname() . "</td>
                        <td style='display:none' >" .$Item->get_itemsubcatname() . "</td>
                        <td style='display:none'>" .$Item->get_discount1Amt() . "</td>
                        <td style='display:none'>" .$Item->getQuoteCode() . "</td>
                        <td><div class='dropdown'>
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
                            data-target='#EditModal' 
                            role='button' 
                            data-id='" . $Item->get_lineItemId() . "'>
                            <i class='fas fa-user-edit'></i> 
                                Edit Item
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' data-target='#deleteLineItemModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $Item->get_lineItemId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Item
                          </button>
                        </div>
                    </div> </td></tr>";
                    $sumTotalAmount=floatval($sumTotalAmount)+floatval($Item->get_totalAmount());
                    $sumTotalPrice=floatval($sumTotalPrice)+floatval($Item->get_totalPrice());
                    $sumTotalValue=floatval($sumTotalValue)+floatval($Item->get_totalValue());
                    
                    }
                    echo "<div style='display:none' id='sumTotalAmount'>". $sumTotalAmount."</div>
                    <div  style='display:none' id='sumTotalPrice'>". $sumTotalPrice."</div>
                    <div  style='display:none' id='sumTotalValue'>". $sumTotalValue."</div>";

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=AddModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="add_form" enctype="multipart/form-data"
            action="../Controller/lineItemController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Line Item Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Input Type <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="inputType" class="form-select" required name="inputType">

                                </select>
                            </div>

                            <label class="col-md-3 text-right">Brand<span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="brand" class="form-select" required name="brand">

                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemCategory" class="form-select" required name="itemCategory">

                                </select>
                            </div>

                            <label class="col-md-3 text-right">Item Sub Category Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemsubCategory" class="form-select" required name="itemsubCategory">

                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemid" class="form-select" required name="itemid">

                                </select>
                                <input type="hidden" name="quoteCode" id="quoteCode" value="">
                                <input type="hidden" name="quoteId" id="quoteId" value="">
                                <input type="hidden" name="selectedItemName" id="addselectedItemName"
                                    class="form-control" value="" />
                                <input type="hidden" name="unitFactor" id="addunitFactor" class="form-control"
                                    value="" />
                                <input type="hidden" name="customerCode" id="customerCode" class="form-control"
                                    value="<?php echo $quotationList->getCustomerCode() ?>" />
                                <input type='hidden' id='totalAmt' name='totalAmt' value="" />

                            </div>

                            <label class="col-md-3 text-right">Item Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="itemquantity" id="additemquantity" class="form-control"
                                    required />
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Item per piece MRP <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="itemppMRP" id="additemppMRP" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>

                            <label class="col-md-3 text-right">Total Amount <span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="totalAmount" id="addtotalAmount" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Discount</label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="discount1" id="adddiscount1" class="form-control" />
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            </div>

                            <label class="col-md-3 text-right">Discounted Amount <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="discountAmount1" id="adddiscountAmount1" class="form-control"
                                    required readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">GST<span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="GST" id="addGST" class="form-control" required readonly />
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                <input type="hidden" name="GSTAmount" id="addGSTAmount" class="form-control" value="" />
                            </div>

                            <label class="col-md-3 text-right">Total Price<span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="totalPrice" id="addtotalPrice" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="">Add Line Item</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
    </div>
    </form>
</div>
</div>
<div class="modal fade" id=EditModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="edit_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Line Item Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type=text id="editeditemCategory" class="form-control" required readonly
                                    name="itemCategory">
                            </div>
                            <label class="col-md-3 text-right"> Sub Category Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type=text id="editeditemsubCategory" class="form-control" required readonly
                                    name="itemsubCategory">

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Material Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type=text id="editeditemname" class="form-control" required readonly
                                    name="editeditemname">
                                <input type="hidden" name="lineItemId" id="lineItemId" class="form-control" value="" />
                                <input type="hidden" name="quoteId" id="editedquoteId" value="">
                                <input type="hidden" name="unitFactor" id="unitFactor" class="form-control" value="" />
                                <input type="hidden" name="customerId" id="customerId" class="form-control"
                                    value=<?php echo $quotationList->getCustomerCode() ?> />
                            </div>
                            <label class="col-md-3 text-right">Material Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="itemquantity" id="itemquantity" class="form-control"
                                    required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Material per piece MRP <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="itemppMRP" id="itemppMRP" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                            <label class="col-md-3 text-right">Total Amount <span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="totalAmount" id="totalAmount" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Discount-1</label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="discount1" id="discount1" class="form-control" />
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            </div>
                            <label class="col-md-3 text-right">Discounted-1 Amount <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="discountAmount1" id="discountAmount1" class="form-control"
                                    required readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">GST<span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="GST" id="GST" class="form-control" required readonly />
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                <input type="hidden" name="GSTAmount" id="GSTAmount" class="form-control" value="" />
                            </div>
                            <label class="col-md-3 text-right">Total Price<span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="totalPrice" id="totalPrice" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="UpdateLineItem">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteLineItemModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_lineItem_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Line Item</h4>
                    <button type="button" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Line Item.
                    </p>
                    <input type="hidden" name="lineItemId" id="lineItemId" value="">
                    <input type="hidden" name="quoteId" id="deletequoteId" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="deleteLineItembutton" class="btn btn-danger"
                        value="Confirmed" />
                    <button type="button" class="btn btn-default">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {

    var catId;
    var subcatId;
    var dataTable = $('#lineItem_table').DataTable({

    });
    $('#displaySumTotalAmount').text($('#sumTotalAmount').text())
    $('#displaysumTotalPrice').text($('#sumTotalPrice').text());
    $('#displaysumTotalValue').text($('#sumTotalValue').text());
    $('#totalAmt').text($('#sumTotalAmount').text());

    $('#deleteLineItemModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#lineItemId').val(rowid);

    });
    $('#EditModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#lineItemId').val(rowid);

        var url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
        let isSelectedSet1 = false;
        $('#editeditemCategory').empty();
        $('#editeditemsubCategory').empty();
        $('#additemid').empty();

        // var catid=
        $.getJSON(url, function(data) {
            $.each(data, function(index, value) {
                if (catId == value.itemcatid) {
                    $('#editeditemCategory').append('<option selected value ="' + value
                        .itemcatid + '">' +
                        value
                        .itemcatname + '</option>');

                } else {
                    $('#editeditemCategory').append('<option value="' + value
                        .itemcatid + '">' +
                        value
                        .itemcatname + '</option>');
                }


            });

        });
        setSubCategory(catId);
    });

    function mappItemPrice(price, gst, name, unitFactor) {
        $('#additemppMRP').val(price);
        $('#addGST').val(gst);
        $('#addselectedItemName').val(name);
        $('#addunitFactor').val(unitFactor);
    }

    function mappMaterialPrice(price, gst, name, unitFactor, materialcode, materialimage) {
        debugger;
        $('#additemppMRP').val(price);
        $('#addGST').val(gst);
        $('#addselectedItemName').val(name);
        $('#addunitFactor').val(unitFactor);
        
    }

    $('#additemid').on('change', function(e) {
        debugger;
        if ($('#inputType').val() == 1) {
            for (var i = 0; i < itemDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (itemDetails[i].itemid == this.value) {
                    $('#additemquantity').val("");
                    $('#addtotalPrice').val("");
                    $('#addtotalAmount').val("");
                    $('#adddiscountAmount1').val("");
                    $('#adddiscountAmount2').val("");
                    $('#addsumTotalAmount').val("");
                    $('#addsumTotalPrice').val("");
                    $('#adddiscount1').val("");
                    $('#adddiscount2').val("");
                    mappItemPrice(itemDetails[i].itemppMRP,
                        itemDetails[i].itemGST,
                        itemDetails[i].itemname,
                        itemDetails[i].unitFactor);
                }
            }
        } else if ($('#inputType').val() == 2) {
            let catId = 0;
            let subcatId = 0;
            let brandId = 0;
            var url = config.developmentPath + "/Admin/Controller/materialController.php?catId=" +
                catId +
                "&subcatId=" + subcatId +
                "&brandId=" + brandId + "&matId=" + this.value;
                console.log(url);
            $.getJSON(url, function(data) {
                materialDetails = data;
                mappMaterialPrice(data[0].MaterialPPMRP,
                    data[0].MaterialGST,
                    data[0].MaterialName,
                    data[0].MaterialUnitFactor,
                    data[0].MaterialCode,
                    data[0].MaterialImage);
            });


            for (var i = 0; i < materialDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (materialDetails[i].MaterialId == this.value) {
                    $('#additemquantity').val("");
                    $('#addtotalPrice').val("");
                    $('#addtotalAmount').val("");
                    $('#adddiscountAmount1').val("");
                    $('#adddiscountAmount2').val("");
                    $('#addsumTotalAmount').val("");
                    $('#addsumTotalPrice').val("");
                    $('#adddiscount1').val("");
                    $('#adddiscount2').val("");
                    mappMaterialPrice(materialDetails[i].MaterialPPMRP,
                        materialDetails[i].MaterialGST,
                        materialDetails[i].MaterialName,
                        materialDetails[i].MaterialUnitFactor,
                        materialDetails[i].MaterialCode,
                        materialDetails[i].MaterialImage);
                }
            }
        }

    });




    $('#delete_lineItem_form').submit(function(event) {
        $.ajax({
            url: config.developmentPath +
                "/Admin/Controller/lineItemController.php/",
            method: "POST",
            data: {
                id: $('#lineItemId').val(),
                quoteId: $('#deletequoteId').val(),
                action: 'delete'
            },
        }).done(function(data) {
            console.log(data);
        });
    });
    $('#lineItem_table tbody').on('click', 'tr', function() {
        debugger;
        $('#deletequoteId').val(this.cells[7].innerHTML);
        $('#editeditemname').val(this.cells[3].innerHTML.replace('&amp;', '&'));
        $('#itemquantity').val(this.cells[4].innerHTML);
        $('#itemppMRP').val(this.cells[11].innerHTML);
        $('#unitFactor').val(this.cells[12].innerHTML);
        $('#GST').val(this.cells[8].innerHTML);
        $('#discount1').val(this.cells[7].innerHTML);
        $('#editedquoteId').val(this.cells[10].innerHTML);
        $('#quoteId').val(this.cells[10].innerHTML);
        $('#editeditemCategory').val(this.cells[15].innerHTML);
        $('#editeditemsubCategory').val(this.cells[16].innerHTML);
        $('#discountAmount1').val(this.cells[17].innerHTML);
        $('#quoteCode').val(this.cells[18].innerHTML);
        calculateAmount();
    });
    $('#adddiscount1').on('keydown', function(e) {
        addcalculateAmount();
    });
    $('#adddiscount2').on('keydown', function(e) {
        addcalculateAmount();
    });
    $('#adddiscount1').on('keyup', function(e) {
        addcalculateAmount();
    });
    $('#adddiscount2').on('keyup', function(e) {
        addcalculateAmount();
    });
    $('#additemquantity').on('keydown', function(e) {
        addcalculateAmount();
    });
    $('#additemquantity').on('keyup', function(e) {
        addcalculateAmount();
    });

    function addcalculateAmount() {
        $('#addtotalAmount').val((parseFloat($('#additemquantity').val() * parseFloat($(
                    '#additemppMRP')
                .val()) *
            parseFloat($('#addunitFactor').val()))).toFixed(2));

        $('#addtotalPrice').val((parseFloat(($('#addtotalAmount').val()) * (parseFloat($('#addGST')
            .val() /
            100))) + parseFloat($('#addtotalAmount').val())).toFixed(2));
        $('#addGSTAmount').val((parseFloat(($('#addtotalAmount').val()) * (parseFloat($('#addGST')
            .val() /
            100)))).toFixed(2));

        $('#addtotalPrice').val((parseFloat($('#addtotalAmount').val())) - (parseFloat(($(
                '#addtotalAmount')
            .val()) * (parseFloat($('#adddiscount1').val() / 100)))).toFixed(2));
        if (parseFloat($('#adddiscount1').val()) > 0 || $('#adddiscount1').val() != "") {

            $('#adddiscountAmount1').val((parseFloat($('#addtotalAmount').val())) - (parseFloat(($(
                    '#addtotalAmount')
                .val()) * (parseFloat($('#adddiscount1').val() / 100)))).toFixed(2));
            $('#addtotalPrice').val((parseFloat(($('#adddiscountAmount1').val()) * (parseFloat($(
                    '#addGST')
                .val() /
                100))) + parseFloat($('#addtotalAmount').val())).toFixed(2));
            $('#addGSTAmount').val((parseFloat(($('#adddiscountAmount1').val()) * (parseFloat($(
                    '#addGST')
                .val() / 100)))).toFixed(2));
            //     if (parseFloat($('#adddiscount2').val()) > 0 || $('#adddiscount2').val() != "") {
            //         $('#adddiscountAmount2').val(((parseFloat($('#adddiscountAmount1').val())) - (
            //             parseFloat(($(
            //                     '#adddiscountAmount1')
            //                 .val()) * (parseFloat($('#adddiscount2').val() / 100))))).toFixed(
            //             2));
            //         $('#addtotalPrice').val((parseFloat(($('#adddiscountAmount2').val()) * (parseFloat(
            //             $('#addGST')
            //             .val() /
            //             100))) + parseFloat($('#adddiscountAmount2').val())).toFixed(2));
            //         $('#addGSTAmount').val((parseFloat(($('#adddiscountAmount2').val()) * (parseFloat($(
            //                 '#addGST')
            //             .val() / 100)))).toFixed(2));
            //     } else {
            //         $('#adddiscountAmount2').val("");
            //         $('#adddiscount2').val("");
            //     }
        } else {
            $('#adddiscountAmount1').val("");
            $('#adddiscountAmount2').val("");
            $('#adddiscount2').val("");
        }
    }



    function calculateAmount() {
        $('#totalAmount').val((parseFloat($('#itemquantity').val() * parseFloat($('#itemppMRP')
                .val()) *
            parseFloat($('#unitFactor').val()))).toFixed(2));
        $('#totalPrice').val((parseFloat(($('#totalAmount').val()) * (parseFloat($('#GST').val() /
            100))) + parseFloat($('#totalAmount').val())).toFixed(2));
        $('#GSTAmount').val((parseFloat(($('#totalAmount').val()) * (parseFloat($('#GST').val() /
            100)))).toFixed(2));
        if (parseFloat($('#discount1').val()) > 0 || $('#discount1').val() != "") {

            $('#totalPrice').val((parseFloat($('#totalAmount').val())) - (parseFloat(($(
                    '#totalAmount')
                .val()) * (parseFloat($('#discount1').val() / 100)))).toFixed(2));
            $('#discountAmount1').val((parseFloat($('#totalAmount').val())) - (parseFloat(($(
                    '#totalAmount')
                .val()) * (parseFloat($('#discount1').val() / 100)))).toFixed(2));
            $('#totalPrice').val((parseFloat(($('#discountAmount1').val()) * (parseFloat($('#GST')
                .val() /
                100))) + parseFloat($('#totalAmount').val())).toFixed(2));
            $('#GSTAmount').val((parseFloat(($('#discountAmount1').val()) * (parseFloat($('#GST')
                .val() / 100)))).toFixed(2));
            // if (parseFloat($('#discount2').val()) > 0 || $('#discount2').val() != "") {
            //     $('#discountAmount2').val(((parseFloat($('#discountAmount1').val())) - (parseFloat((
            //         $(
            //             '#discountAmount1')
            //         .val()) * (parseFloat($('#discount2').val() / 100))))).toFixed(2));
            //     $('#totalPrice').val((parseFloat(($('#discountAmount2').val()) * (parseFloat($(
            //             '#GST')
            //         .val() /
            //         100))) + parseFloat($('#discountAmount2').val())).toFixed(2));
            //     $('#GSTAmount').val((parseFloat(($('#discountAmount2').val()) * (parseFloat($(
            //             '#GST')
            //         .val() / 100)))).toFixed(2));
            // } else {
            //     $('#discountAmount2').val("");
            //     $('#discount2').val("");
            // }
        } else {
            $('#discountAmount1').val("");
            $('#discountAmount2').val("");
            $('#discount2').val("");
        }
    }
    $('#discount1').on('keydown', function(e) {
        calculateAmount();
    });
    $('#discount2').on('keydown', function(e) {
        calculateAmount();
    });
    $('#discount1').on('keyup', function(e) {
        calculateAmount();
    });
    $('#discount2').on('keyup', function(e) {
        calculateAmount();
    });
    $('#itemquantity').on('keydown', function(e) {
        calculateAmount();
    });
    $('#itemquantity').on('keyup', function(e) {
        calculateAmount();
    });

    $('#edit_form').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            url: config.developmentPath +
                "/Admin/Controller/lineItemController.php/",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });

    $('#AddModal').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $('#quoteId').val(rowid);
    });
    fetchinputTypeurl =
        config.developmentPath +
        "/Admin/Controller/inputTypeController.php/";
    console.log(fetchinputTypeurl);
    $.getJSON(fetchinputTypeurl, function(data) {
        $('#inputType').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#inputType').append('<option value="' + value.InputTypeId +
                '">' +
                value
                .InputType + '</option>');
        });
    });

    $('#inputType').on('change', function() {
        debugger;
        $('#brand').empty();
        $('#itemCategory').empty();
        $('#itemsubCategory').empty();
        fetchbrandurl =
            config.developmentPath +
            "/Admin/Controller/brandcontroller.php/?InputId=" + this.value;
        console.log(fetchbrandurl);
        $.getJSON(fetchbrandurl, function(data) {
            $('#brand').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#brand').append('<option value="' + value.brandid +
                    '">' +
                    value
                    .brandname + '</option>');
            });
        });
    });

    $('#brand').on('change', function() {
        debugger;
        $('#itemid').empty();
        $('#additemCategory').empty();
        if ($('#inputType').val() == 1) {
            var url = config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php/?brandId=" +
                this.value;
            let isSelectedSet1 = false;
            let catId = 0;

            $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    $('#additemCategory').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $('#additemCategory').append('<option value="' + value.itemcatid +
                        '">' + value
                        .itemcatname + '</option>');
                    $('#editedadditemCategory').append('<option value="' + value
                        .itemcatid + '">' +
                        value
                        .itemcatname + '</option>');
                    isSelectedSet = true;
                    // setSubCategory(value.itemcatid);
                });
            });
        } else if ($('#inputType').val() == 2) {
            var url = config.developmentPath +
                "/Admin/Controller/material_CategoryController.php/?brandId=" +
                this.value;
            let isSelectedSet1 = false;
            let MatcatId = 0;

            $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    $('#additemCategory').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $('#additemCategory').append('<option value="' + value
                        .materialcatId +
                        '">' + value
                        .materialCatname + '</option>');
                    $('#editedadditemCategory').append('<option value="' + value
                        .materialcatId + '">' +
                        value
                        .materialCatname + '</option>');
                    isSelectedSet = true;

                });
            });

        };
    });

    function setSubCategory(catId) {

        var fetchsubcaturl = config.developmentPath +
            "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
            catId;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#additemsubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#additemsubCategory').append('<option value="' +
                    value
                    .itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
                if (subcatId == value.itemsubcatid) {
                    $('#editeditemsubCategory').append('<option selected value="' +
                        value
                        .itemsubcatid +
                        '">' +
                        value
                        .itemsubcatname + '</option>');
                } else {
                    $('#editeditemsubCategory').append('<option value="' +
                        value
                        .itemsubcatid +
                        '">' +
                        value
                        .itemsubcatname + '</option>');
                }
            });
        });
    }

    function setMatSubCategory(catId) {

        var fetchsubcaturl = config.developmentPath +
            "/Admin/Controller/material_SubcategoryController.php/?catId=" +
            catId;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#additemsubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#additemsubCategory').append('<option value="' +
                    value
                    .materialsubcatId +
                    '">' +
                    value
                    .materialsubcatName + '</option>');
                if (subcatId == value.itemsubcatid) {
                    $('#editeditemsubCategory').append('<option selected value="' +
                        value
                        .materialsubcatId +
                        '">' +
                        value
                        .materialsubcatName + '</option>');
                } else {
                    $('#editeditemsubCategory').append('<option value="' +
                        value
                        .materialsubcatId +
                        '">' +
                        value
                        .materialsubcatName + '</option>');
                }
            });
        });
    }

    function setItemlist(catId, subcatId, brandId, thicknessId = 0) {
        let projId = 0;
        // let brandId = 0;
        debugger;
        $('#itemquantity').val("");
        $('#totalPrice').val("");
        $('#totalAmount').val("");
        $('#discountAmount1').val("");
        $('#discountAmount2').val("");
        $('#sumTotalAmount').val("");
        $('#sumTotalPrice').val("");
        $('#discount1').val("");
        $('#discount2').val("");
        $('#itemppMRP').val("");
        $('#GST').val("");
        if ($('#inputType').val() == 1) {
            var fetchitemlisturl = config.developmentPath +
                "/Admin/Controller/item_detailscontroller.php/?catId=" + catId +
                "&subcatId=" + subcatId + "&projId=" + projId + "&brandId=" + brandId;
            console.log(fetchitemlisturl);
            $.getJSON(fetchitemlisturl, function(data) {
                itemDetails = data;
                $('#additemid').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function(index, value) {
                    $('#additemid').append('<option value="' + value
                        .itemid + '">' +
                        value
                        .itemname + '</option>');
                });
            });
        } else if ($('#inputType').val() == 2) {
            var fetchitemlisturl = config.developmentPath +
                "/Admin/Controller/materialController.php/?catId=" + catId + "&subcatId=" +
                subcatId +
                "&brandId=" + brandId + "&thicknessId=" + thicknessId;
            console.log(fetchitemlisturl);
            $.getJSON(fetchitemlisturl, function(data) {
                materialDetails = data;
                $('#additemid').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function(index, value) {
                    $('#additemid').append('<option value="' + value.MaterialId + '">' +
                        value
                        .MaterialName + '</option>');

                    // $('#editedsubCategory').append('<option value="' + value.itemsubcatid +
                    //     '">' +
                    //     value
                    //     .itemsubcatname + '</option>');
                });
            });
        }
    }

    $('#additemCategory').on('change', function() {
        debugger;
        $('#additemsubCategory').empty();
        $('#additemid').empty();
        $('#itemquantity').val("");
        $('#totalPrice').val("");
        $('#totalAmount').val("");
        $('#discountAmount1').val("");
        $('#discountAmount2').val("");
        $('#sumTotalAmount').val("");
        $('#sumTotalPrice').val("");
        $('#discount1').val("");
        $('#discount2').val("");
        $('#itemppMRP').val("");
        $('#GST').val("");
        fetchsubcaturl =
            config.developmentPath +
            "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
            .value;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#additemsubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#additemsubCategory').append(
                    '<option value="' + value
                    .itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
            });
        });
        setMatSubCategory(this.value);
    });

    $('#editeditemCategory').on('change', function() {
        $('#editeditemsubCategory').empty();
        $('#additemid').empty();
        $('#itemquantity').val("");
        $('#totalPrice').val("");
        $('#totalAmount').val("");
        $('#discountAmount1').val("");
        $('#discountAmount2').val("");
        $('#sumTotalAmount').val("");
        $('#sumTotalPrice').val("");
        $('#discount1').val("");
        $('#discount2').val("");
        $('#itemppMRP').val("");
        $('#GST').val("");
        fetchsubcaturl =
            config.developmentPath +
            "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
            .value;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#editeditemsubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#editeditemsubCategory').append(
                    '<option value="' + value
                    .itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
            });
        });
    });

    $('#additemsubCategory').on('change', function() {
        $('#additemid').empty();
        setItemlist($('#additemCategory').val(), this.value, $('#brand').val());

    });
    $('#editeditemsubCategory').on('change', function() {
        $('#additemid').empty();
        setItemlist($('#editeditemCategory').val(), this.value);
    });

});
</script>