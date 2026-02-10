<?php
include('session.php');
include('lineitemNavigation.php');
include('../DB Operations/lineItemOps.php');
include('../DB Operations/quotationOps.php');
$id = $_GET['id'];
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
                <span data-toggle=modal data-target=#AddModal data-id=<?php echo $id ?>>
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
                        <a class='btn' id="quoteValue" class='btn btn-warning btn-small' role='button' data-toggle=modal
                            data-target=#QuotevalueModal><i class='fas fa-pencil-alt'></i></a>
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
                        <th style='display:none'>ItemId</th>
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
                        <th style='display:none'>Value</th>
                        <th style='display:none'>Company Discount</th>
                        <th style='display:none'>Company Price</th>
                        <th style='display:none'>Trade Price</th>


                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ListItem = DBLineItem::getLineItemByQuoteIdForOrder($id);
                    $sumTotalAmount = 0;
                    $sumTotalPrice = 0;
                    $sumTotalValue = 0;
                    foreach ($ListItem as $Item) {
                        echo "<tr>
                        <td>" . $Item->getImage() . "</td>
                        <td>" . $Item->get_inputType() . "</td>
                        <td>" . $Item->getItemcode() . "</td>
                        <td>" . $Item->getName() . "</td>
                        <td style='display:none'>" . $Item->get_itemId() . "</td>
                        <td>" . $Item->get_itemquantity() . "</td>
                        <td id='storedTotalAmt'>" . $Item->get_totalAmount() . "</td>
                        <td>" . $Item->get_totalValue() . "</td>
                        <td>" . $Item->get_discount1() . "</td>
                        <td>" . $Item->get_GST() . "</td>
                        <td>" . $Item->get_totalPrice() . "</td>
                        <td style='display:none'>" . $id . "</td>
                        <td style='display:none'>" . $Item->get_ppMRP() . "</td>
                        <td style='display:none'>" . $Item->getUnitFactor() . "</td>
                        <td style='display:none'>" . $Item->get_itemcatid() . "</td>
                        <td style='display:none'>" . $Item->get_itemsubcatid() . "</td>
                        <td style='display:none' >" . $Item->get_itemcatname() . "</td>
                        <td style='display:none' >" . $Item->get_itemsubcatname() . "</td>
                        <td style='display:none'>" . $Item->get_discount1Amt() . "</td>
                        <td style='display:none'>" . $Item->getQuoteCode() . "</td>
                        <td style='display:none'>" . $Item->get_value() . "</td>
                        <td style='display:none'>" . $Item->get_companyDiscount() . "</td>
                        <td style='display:none'>" . $Item->get_companyPrice() . "</td>
                        <td style='display:none'>" . $Item->get_totalValue() . "</td> <!-- This acts as Trade Price -->

                        
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
                                Edit
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' data-target='#deleteLineItemModal' 
                           name='delete_button' 
                           role='button' 
                           data-id='" . $Item->get_lineItemId() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete
                          </button>
                        </div>
                    </div> </td></tr>";
                        $sumTotalAmount = floatval($sumTotalAmount) + floatval($Item->get_totalAmount());
                        $sumTotalPrice = floatval($sumTotalPrice) + floatval($Item->get_totalPrice());
                        $sumTotalValue = floatval($sumTotalValue) + floatval($Item->get_totalValue());

                    }
                    echo "<div style='display:none' id='sumTotalAmount'>" . $sumTotalAmount . "</div>
                    <div  style='display:none' id='sumTotalPrice'>" . $sumTotalPrice . "</div>
                    <div  style='display:none' id='sumTotalValue'>" . $sumTotalValue . "</div>";

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
                    <h5 class="modal-title" id="exampleModalLabel">Add Line Item / Material Details</h5>
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

                            <label class="col-md-3 text-right"> Sub Category Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemsubCategory" class="form-select" required name="itemsubCategory">

                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right"> Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemid" class="form-select" required name="itemid">

                                </select>
                                <input type="hidden" name="quoteCode" id="quoteCode"
                                    value="<?php echo $quotationList->getQuoteCode() ?>">
                                <input type="hidden" name="quoteId" id="quoteId" value="">
                                <input type="hidden" name="selectedItemName" id="addselectedItemName"
                                    class="form-control" value="" />
                                <input type="hidden" name="unitFactor" id="addunitFactor" class="form-control"
                                    value="" />
                                <input type="hidden" name="customerCode" id="customerCode" class="form-control"
                                    value="<?php echo $quotationList->getCustomerCode() ?>" />
                                <input type='hidden' id='totalAmt' name='totalAmt'
                                    value="<?php echo $quotationList->getQuoteValue() ?>" />
                            </div>

                            <label class="col-md-3 text-right"> Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="itemquantity" id="additemquantity" class="form-control"
                                    required />
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right"> Per Piece MRP <span class="text-danger">*</span></label>
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
                            <label class="col-md-3 text-right">Company Discount(%)</label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="companyDiscount" id="addCompanyDiscount" class="form-control"
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            </div>

                            <label class="col-md-3 text-right">Company Price</label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="companyPrice" id="addCompanyPrice" class="form-control"
                                    readonly />
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

                            <label class="col-md-3 text-right">Trade Discount(%)</label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="tradeDiscount" id="addTradeDiscount" class="form-control" />
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Trade Price</label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="tradePrice" id="addTradePrice" class="form-control" readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                            <label class="col-md-3 text-right">Total Value<span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="totalValue" id="addTotalValue" class="form-control" required
                                    readonly />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                        data-parsley-type="integer" data-parsley-minlength="10"
                                        data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                        value="<?php echo $_SESSION['login_user']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                        data-parsley-type="integer" data-parsley-minlength="10"
                                        data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                        value="<?php echo $_SESSION['login_user']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="edit_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Line Item / Material Details </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" id="editeditemCategory" class="form-control" name="itemCategory"
                                    readonly>
                            </div>

                            <label class="col-md-3 text-right">Sub Category <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" id="editeditemsubCategory" class="form-control"
                                    name="itemsubCategory" readonly>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="edit">

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Input Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" id="editeditemname" class="form-control" name="editeditemname"
                                    readonly>

                                <input type="hidden" name="lineItemId" id="lineItemId">
                                <input type="hidden" name="quoteId" id="editedquoteId">
                                <input type="hidden" name="unitFactor" id="unitFactor">
                                <input type="hidden" name="inputValue" id="inputValue">
                                <input type="hidden" name="customerId" id="customerId"
                                    value="<?php echo $quotationList->getCustomerCode() ?>" />
                            </div>

                            <label class="col-md-3 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="itemquantity" id="itemquantity" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Per Piece MRP</label>
                            <div class="col-md-3 input-group">
                                <input type="text" id="itemppMRP" name="itemppMRP" class="form-control" readonly>
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>

                            <label class="col-md-3 text-right">Total Amount</label>
                            <div class="col-md-3 input-group">
                                <input type="text" id="totalAmount" name="totalAmount" class="form-control" readonly>
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Company Discount and Company Price -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Company Discount (%)</label>
                            <div class="col-md-3 input-group">
                                <input type="text" id="editCompanyDiscount" name="companyDiscount" class="form-control"
                                    readonly>
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            </div>

                            <label class="col-md-3 text-right">Company Price</label>
                            <div class="col-md-3 input-group">
                                <input type="text" id="editCompanyPrice" name="companyPrice" class="form-control"
                                    readonly>
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- GST + Trade Discount -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">GST</label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="GST" id="GST" class="form-control" readonly>
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                <input type="hidden" id="GSTAmount" name="GSTAmount">
                            </div>

                            <label class="col-md-3 text-right">Trade Discount (%)</label>
                            <div class="col-md-3 input-group">
                                <input type="text" id="editTradeDiscount" name="tradeDiscount" class="form-control">
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Trade Price & Total Value -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Trade Price</label>
                            <div class="col-md-3 input-group">
                                <input type="text" id="editTradePrice" name="tradePrice" class="form-control" readonly>
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>

                            <label class="col-md-3 text-right">Total Value</label>
                            <div class="col-md-3 input-group">
                                <input type="text" id="totalPrice" name="totalValue" class="form-control" readonly>
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
                <input type="hidden" id="hiddenTotalPrice" name="totalPrice">
                <input type="hidden" id="hiddenTotalValue" name="totalValue">
                <input type="hidden" id="hiddenDiscount1Amt" name="discount1Amt">
                <input type="hidden" id="hiddenGSTAmount" name="GSTAmount">
                <input type="hidden" id="hiddenCompanyPrice" name="companyPrice">
                <input type="hidden" id="hiddenValue" name="value">

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
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
<div class="modal fade" id=QuotevalueModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form class="" method="POST" id="Quotevalue_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Line Item Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Quote Value <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="QuoteAmount" id="QuoteAmount" class="form-control" required />
                                <input type="hidden" name="quoteid" id="quoteid" value=<?php echo $id ?>>
                                <input type="hidden" name="unit" id="unit" value=<?php echo $quotationList->getUnitId() ?>>
                                <input type="hidden" name="quantity" id="quantity" value=<?php echo $quotationList->getQuantity() ?>>
                                <input type="hidden" name="quoteType" id="quoteType" value=<?php echo $quotationList->get_quoteType() ?>>
                                <input type="hidden" name="quoteStatus" id="quoteStatus" value=<?php echo $quotationList->get_quoteStatus() ?>>
                                <input type="hidden" name="quoteDescription" id="quoteDescription" value=<?php echo $quotationList->get_quoteDescription() ?>>
                                <input type="hidden" name="quoteComments" id="quoteComments" value=<?php echo $quotationList->get_quoteComments() ?>>
                                <input type="hidden" name="customerCode" id="customerCode" value=<?php echo $quotationList->getCustomerCode() ?>>
                                <input type="hidden" name="customeName" id="customeName" value=<?php echo $quotationList->get_customerName() ?>>
                                <input type="hidden" name="quoteCode" id="quoteCode" value=<?php echo $quotationList->getQuoteCode() ?>>
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

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="">Edit Quote Value</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        var catId;
        var subcatId;
        var dataTable = $('#lineItem_table').DataTable({

        });
        $('#displaySumTotalAmount').text($('#sumTotalAmount').text());
        $('#QuoteTotalAmt').val($('#sumTotalAmount').text());
        $('#displaysumTotalPrice').text($('#sumTotalPrice').text());
        $('#displaysumTotalValue').text($('#sumTotalValue').text());
        $('#InputTotalValue').val($('#sumTotalValue').text());
        $('#QuoteTotalPrice').val($('#sumTotalPrice').text());
        $('#deleteLineItemModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#lineItemId').val(rowid);

        });

        $('#EditModal').on('show.bs.modal', function (e) {
            let row = $(e.relatedTarget).closest("tr")[0];

            // 🔹 get lineItemId from button data-id
            let lineItemId = $(e.relatedTarget).data('id');
            $('#lineItemId').val(lineItemId);          // ✅ now backend knows which row to update

            // 🔹 common values from table row
            const type = row.cells[1].innerHTML.trim();    // Type = Item / Material
            const itemOrMatId = row.cells[4].innerHTML.trim(); // ItemId / MaterialId (hidden col)

            $('#editeditemname').val(row.cells[3].innerHTML.trim());   // Name
            $('#itemquantity').val(row.cells[5].innerHTML.trim());     // Quantity
            $('#totalAmount').val(row.cells[6].innerHTML.trim());      // Total Amount
            $('#totalPrice').val(row.cells[10].innerHTML.trim());       // Total Value
            $('#editTradeDiscount').val(row.cells[8].innerHTML.trim()); // Trade Discount
            $('#GST').val(row.cells[9].innerHTML.trim());              // GST

            $('#editeditemCategory').val(row.cells[16].innerHTML.trim());   // Category Name
            $('#editeditemsubCategory').val(row.cells[17].innerHTML.trim()); // Sub Category
            $('#editedquoteId').val(row.cells[11].innerHTML.trim());        // QuoteId

            // 🔹 Decide which DB call (item vs material)
            if (type.toLowerCase() === "item") {
                fetchEditCompanyValuesForLineItem(itemOrMatId);
            } else if (type.toLowerCase() === "material") {
                fetchMaterialValuesForEditModal(itemOrMatId);
            }

            // after base values loaded, recalc
            editCalculateAmount();
        });


        // ✅ UPDATED EDIT CALCULATION FUNCTION - Same as AddModal
        // ✅ UPDATED EDIT CALCULATION FUNCTION
        function editCalculateAmount() {
            const qty = Number($('#itemquantity').val()) || 0;
            const mrp = Number($('#itemppMRP').val()) || 0;
            const gst = Number($('#GST').val()) || 0;
            const tDis = Number($('#editTradeDiscount').val()) || 0;
            const uFac = Number($('#unitFactor').val()) || 1;

            const totalAmt = mrp * qty * uFac;
            $('#totalAmount').val(totalAmt.toFixed(2));

            const companyBase = Number($('#editCompanyPrice').data('base')) || 0;
            const companyTotal = companyBase * qty;
            $('#editCompanyPrice').val(companyTotal.toFixed(2));

            let tradePricePerPiece = mrp;
            if (tDis > 0) {
                const discounted = mrp - (mrp * (tDis / 100));
                tradePricePerPiece = discounted + (discounted * (gst / 100));
            }
            const tradeTotal = tradePricePerPiece * qty;
            $('#editTradePrice').val(tradeTotal.toFixed(2));

            const baseTotalValue = Number($('#totalPrice').data('base')) || 0;
            const spu = Number($('#totalPrice').data('spu')) || 1;
            const totalValue = baseTotalValue * Math.ceil(qty / spu);
            $('#totalPrice').val(totalValue.toFixed(2));

            $('#hiddenTotalPrice').val($('#editCompanyPrice').val());
            $('#hiddenTotalValue').val($('#totalPrice').val());
            $('#hiddenDiscount1Amt').val((companyTotal * (tDis / 100)).toFixed(2));
            $('#hiddenGSTAmount').val($('#GSTAmount').val() || "0");
        }

        $('#itemquantity, #editTradeDiscount, #GST').on('keyup change', function () {
            editCalculateAmount();
        });


        // ✅ ADD THIS FUNCTION - For Items (Same as AddModal)
        function fetchCompanyValuesForLineItem(itemId) {
            $.getJSON(
                config.developmentPath + "/Admin/Controller/item_detailscontroller.php?infoitemid=" + itemId,
                function (data) {
                    if (!data || !data.length) return;

                    const r = data[0];

                    const mrp = parseFloat(r.itemMRP || 0);
                    const gst = parseFloat(r.itemGST || 18);
                    const cDisc = parseFloat(r.itemDiscount || 0);
                    const cPrice = parseFloat(r.itemPrice || 0);
                    const tVal = parseFloat(r.itemTotalValue || 0);
                    const spu = parseFloat(r.spu || r.item_PackingUnit || 1);
                    const uFact = parseFloat(r.unitFactor || 1);

                    $('#additemppMRP').val(mrp.toFixed(2));
                    $('#addGST').val(gst.toFixed(2));
                    $('#addCompanyDiscount').val(cDisc.toFixed(2));
                    $('#addCompanyPrice').val(cPrice.toFixed(2));
                    $('#addCompanyPrice').data('base', cPrice);
                    $('#addTotalValue').val(tVal.toFixed(2));

                    // ✅ Store SPU and base values for calculations
                    $('#addTotalValue').data('base', tVal);
                    $('#addTotalValue').data('spu', spu);

                    console.log('Line Item - Base values set:', {
                        companyBase: cPrice,
                        totalValueBase: tVal,
                        spu: spu
                    });

                    const qty = parseFloat($('#additemquantity').val()) || 0;
                    const totalAmount = mrp * qty * uFact;
                    $('#addtotalAmount').val(totalAmount.toFixed(2));

                    $('#addTradePrice').val(cPrice.toFixed(2));

                    // Trigger calculation
                    addcalculateAmount();
                }
            );
        }
        function fetchEditCompanyValuesForLineItem(itemId) {
            $.getJSON(
                config.developmentPath + "/Admin/Controller/item_detailscontroller.php?infoitemid=" + itemId,
                function (data) {
                    if (!data || !data.length) return;

                    const r = data[0];

                    $('#itemppMRP').val(parseFloat(r.itemMRP).toFixed(2));
                    $('#GST').val(parseFloat(r.itemGST).toFixed(2));
                    $('#editCompanyDiscount').val(parseFloat(r.itemDiscount).toFixed(2));

                    $('#editCompanyPrice').data('base', parseFloat(r.itemPrice));
                    $('#totalPrice').data('base', parseFloat(r.itemTotalValue));
                    $('#unitFactor').val(parseFloat(r.unitFactor));
                    $('#totalPrice').data('spu', parseFloat(r.spu || r.item_PackingUnit || 1));


                    console.log("Edit Modal Base Values:", r);

                    editCalculateAmount();
                }
            );
        }
        function fetchMaterialValuesForLineItem(matId) {
            $.getJSON(
                config.developmentPath + "/Admin/Controller/materialController.php?infomatid=" + matId,
                function (data) {
                    if (!data || !data.length) return;

                    const r = data[0];

                    const mrp = parseFloat(r.MaterialPPMRP || 0);
                    const gst = parseFloat(r.MaterialGST || 0);
                    const cDisc = parseFloat(r.MaterialCompanyDiscount || 0);
                    const cPrice = parseFloat(r.MaterialCompanyPrice || 0);
                    const tVal = parseFloat(r.MaterialTotalValue || 0);
                    const spu = parseFloat(r.MaterialSPU || 1);
                    const uFact = parseFloat(r.MaterialUnitFactor || 1);

                    $('#addunitFactor').val(uFact);
                    $('#additemppMRP').val(mrp.toFixed(2));
                    $('#addGST').val(gst.toFixed(2));
                    $('#addCompanyDiscount').val(cDisc.toFixed(2));

                    $('#addCompanyPrice')
                        .val(cPrice.toFixed(2))
                        .data('base', cPrice);

                    $('#addTotalValue')
                        .val(tVal.toFixed(2))
                        .data('base', tVal)
                        .data('spu', spu);

                    const qty = Number($('#additemquantity').val()) || 0;
                    $('#addtotalAmount').val((mrp * qty * uFact).toFixed(2));

                    $('#addTradePrice').val(cPrice.toFixed(2));

                    addcalculateAmount();
                }
            );
        }




        // ✅ ADD THIS FUNCTION - For Materials (Same as AddModal)
        // function fetchMaterialValuesForLineItem(matId) {
        //     $.getJSON(
        //         config.developmentPath + "/Admin/Controller/materialController.php?matId=" + matId,
        //         function (data) {
        //             if (!data || !data.length) return;

        //             const r = data[0];

        //             const mrp = parseFloat(r.MaterialPPMRP || 0);
        //             const gst = parseFloat(r.MaterialGST || 18);
        //             const cDisc = parseFloat(r.MaterialCompanyDiscount || 0);
        //             const cPrice = parseFloat(r.MaterialCompanyPrice || 0);
        //             const tVal = parseFloat(r.MaterialTotalValue || 0);
        //             const spu = parseFloat(r.Mat_SPU || r.spu || 1);
        //             const uFact = parseFloat(r.MaterialUnitFactor || 1);

        //             $('#additemppMRP').val(mrp.toFixed(2));
        //             $('#addGST').val(gst.toFixed(2));
        //             $('#addCompanyDiscount').val(cDisc.toFixed(2));
        //             $('#addCompanyPrice').val(cPrice.toFixed(2));
        //             $('#addCompanyPrice').data('base', cPrice);
        //             $('#addTotalValue').val(tVal.toFixed(2));

        //             // ✅ Store SPU and base values for calculations
        //             $('#addTotalValue').data('base', tVal);
        //             $('#addTotalValue').data('spu', spu);

        //             console.log('Line Item Material - Base values set:', {
        //                 companyBase: cPrice,
        //                 totalValueBase: tVal,
        //                 spu: spu
        //             });

        //             const qty = parseFloat($('#additemquantity').val()) || 0;
        //             const totalAmount = mrp * qty * uFact;
        //             $('#addtotalAmount').val(totalAmount.toFixed(2));

        //             $('#addTradePrice').val(cPrice.toFixed(2));

        //             // Trigger calculation
        //             addcalculateAmount();
        //         }
        //     );
        // }

        function mappItemPrice(price, gst, name, unitFactor, compDisc) {
            $('#additemppMRP').val(price);
            $('#addGST').val(gst);
            $('#addselectedItemName').val(name);
            $('#addunitFactor').val(unitFactor);
            $('#addCompanyDiscount').val(compDisc || 0);

            // Don't set Company Price and Total Value here - let fetchCompanyValuesForLineItem handle it
        }

        function mappMaterialPrice(price, gst, name, unitFactor, materialcode, materialimage) {
            $('#additemppMRP').val(price);
            $('#addGST').val(gst);
            $('#addselectedItemName').val(name);
            $('#addunitFactor').val(unitFactor);

            // Don't set Company Price and Total Value here - let fetchMaterialValuesForLineItem handle it
        }

        $('#additemid').on('change', function (e) {
            debugger;
            if ($('#inputType').val() == 1) {
                // For items - fetch base values from database
                const selectedText = $("#additemid option:selected").text();
                $('#addselectedItemName').val(selectedText);
                fetchCompanyValuesForLineItem(this.value);

            } else if ($('#inputType').val() == 2) {
                // For materials - fetch base values from database
                const selectedText = $("#additemid option:selected").text();
                $('#addselectedItemName').val(selectedText);
                fetchMaterialValuesForLineItem(this.value);

            }
        });

        $('#add_form').submit(function (e) {
            e.preventDefault(); // stop default form submit

            var formData = new FormData(this);

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/lineItemController.php/",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {

                    $('#AddModal').modal('hide');  // close modal

                    // Clear form fields
                    $('#add_form')[0].reset();

                    // Reload datatable only (NO FULL PAGE RELOAD)
                    // dataTable.ajax.reload(null, false);

                    // Show success message (optional)
                    $('#message').html("<div class='alert alert-success'>Item Added Successfully.</div>");
                }
            });
        });

        $('#Quotevalue_form').submit(function (event) {

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
                url: config.developmentPath +
                    "/Admin/Controller/lineItemController.php/",
                method: "POST",
                data: {
                    id: $('#lineItemId').val(),
                    quoteId: $('#deletequoteId').val(),
                    action: 'delete'
                },
            }).done(function (data) {
                console.log(data);
            });
        });

        // ✅ ADD MODAL CALCULATION FUNCTION
        function addcalculateAmount() {
            const qty = Number($('#additemquantity').val()) || 0;
            const mrp = Number($('#additemppMRP').val()) || 0;
            const gst = Number($('#addGST').val()) || 0;
            const tDis = Number($('#addTradeDiscount').val()) || 0;
            const uFac = Number($('#addunitFactor').val()) || 1;

            console.log('Line Item Calculation inputs:', { qty, mrp, gst, tDis, uFac });
            console.log('Line Item Company Price Base:', $('#addCompanyPrice').data('base'));
            console.log('Line Item Total Value Base:', $('#addTotalValue').data('base'));
            console.log('Line Item Total Value SPU:', $('#addTotalValue').data('spu'));

            // 1️⃣ Total Amount = MRP × Qty × UnitFactor
            const totalAmt = mrp * qty * uFac;
            $('#addtotalAmount').val(totalAmt.toFixed(2));

            // 2️⃣ Company Price (total) - use base value from database × quantity
            const companyBase = Number($('#addCompanyPrice').data('base')) || 0;
            const companyTotal = companyBase * qty;
            $('#addCompanyPrice').val(companyTotal.toFixed(2));

            // 3️⃣ Trade Price (total) - calculate based on MRP, trade discount and GST
            let tradePricePerPiece = mrp;
            if (tDis > 0) {
                const discounted = mrp - (mrp * (tDis / 100));
                tradePricePerPiece = discounted + (discounted * (gst / 100));
            }
            const tradeTotal = tradePricePerPiece * qty;
            $('#addTradePrice').val(tradeTotal.toFixed(2));

            // 4️⃣ Total Value - use base value from database with SPU logic
            const baseTotalValue = Number($('#addTotalValue').data('base')) || 0;
            const spu = Number($('#addTotalValue').data('spu')) || 1;

            let totalValue = 0;
            if (baseTotalValue > 0 && spu > 0 && qty > 0) {
                totalValue = baseTotalValue * Math.ceil(qty / spu);
            } else {
                totalValue = baseTotalValue * qty;
            }

            $('#addTotalValue').val(totalValue.toFixed(2));

            console.log('Line Item Calculation results:', {
                totalAmt,
                companyTotal,
                tradeTotal,
                totalValue,
                baseTotalValue,
                spu
            });
        }

        // Attach event listeners for calculation
        $('#additemquantity, #addTradeDiscount, #addGST').on('keyup change', function () {
            addcalculateAmount();
        });

        $('#edit_form').submit(function (event) {
            debugger;
            event.preventDefault();   // ✅ stop normal form post

            var formData = new FormData(this);

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/lineItemController.php/",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log("Edit response:", data);
                    $('#EditModal').modal('hide');
                    location.reload();   // table will refresh with updated values
                }
            });
        });


        $('#AddModal').on('show.bs.modal', function (e) {

            var rowid = $(e.relatedTarget).data('id');
            $('#quoteId').val(rowid);

            // Reset all fields once
            $('#additemquantity, #additemppMRP, #addGST, #adddiscount1, #addtotalAmount, #addGSTAmount, #addtotalPrice, #addCompanyPrice, #addtradePrice, #addtotalValue, #addCompanyDiscount').val("");
            $('#addCompanyDiscount').val("0"); // Set default value

            // ✅ Clear data attributes as well
            $('#addCompanyPrice').removeData('base');
            $('#addTotalValue').removeData('base');
            $('#addTotalValue').removeData('spu');

            $('#additemid, #additemCategory, #additemsubCategory, #brand').empty();

            fetchinputTypeurl = config.developmentPath + "/Admin/Controller/inputTypeController.php/";

            $.getJSON(fetchinputTypeurl, function (data) {
                $('#inputType').empty(); // Clear existing options
                $('#inputType').append('<option hidden disabled selected value>-- select Input Type --</option>');
                $.each(data, function (index, value) {
                    $('#inputType').append('<option value="' + value.InputTypeId + '">' + value.InputType + '</option>');
                });
            });

        });

        $('#inputType').on('change', function () {
            debugger;
            $('#brand').empty();
            $('#additemCategory').empty();
            $('#additemsubCategory').empty();
            $('#additemid').empty();
            fetchbrandurl =
                config.developmentPath +
                "/Admin/Controller/brandcontroller.php/?InputId=" + this.value;
            console.log(fetchbrandurl);
            $.getJSON(fetchbrandurl, function (data) {
                $('#brand').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#brand').append('<option value="' + value.brandid +
                        '">' +
                        value
                            .brandname + '</option>');
                });
            });
        });

        $('#brand').on('change', function () {
            debugger;
            $('#additemid').empty();
            $('#additemCategory').empty();
            $('#additemsubCategory').empty();
            if ($('#inputType').val() == 1) {
                var url = config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php/?brandId=" +
                    this.value;
                let isSelectedSet1 = false;
                let catId = 0;

                $.getJSON(url, function (data) {
                    $('#additemCategory').empty();
                    $('#additemCategory').append('<option hidden disabled selected value>-- select an option --</option>');
                    $.each(data, function (index, value) {
                        $('#additemCategory').append('<option value="' + value.itemcatid +
                            '">' + value
                                .itemcatname + '</option>');
                    });
                });
            } else if ($('#inputType').val() == 2) {
                var url = config.developmentPath +
                    "/Admin/Controller/material_CategoryController.php/?brandId=" +
                    this.value;
                let isSelectedSet1 = false;
                let MatcatId = 0;

                $.getJSON(url, function (data) {
                    $('#additemCategory').empty();
                    $('#additemCategory').append('<option hidden disabled selected value>-- select an option --</option>');
                    $.each(data, function (index, value) {
                        $('#additemCategory').append('<option value="' + value
                            .materialcatId +
                            '">' + value
                                .materialCatname + '</option>');
                    });
                });

            };
        });

        function setSubCategory(catId) {

            var fetchsubcaturl = config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
                catId;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#additemsubCategory').empty();
                $('#additemsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#additemsubCategory').append('<option value="' +
                        value
                            .itemsubcatid +
                        '">' +
                        value
                            .itemsubcatname + '</option>');
                });
            });
        }

        function setMatSubCategory(catId) {

            var fetchsubcaturl = config.developmentPath +
                "/Admin/Controller/material_SubcategoryController.php/?catId=" +
                catId;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#additemsubCategory').empty();
                $('#additemsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#additemsubCategory').append('<option value="' +
                        value
                            .materialsubcatId +
                        '">' +
                        value
                            .materialsubcatName + '</option>');
                });
            });
        }

        function setItemlist(catId, subcatId, brandId, thicknessId = 0) {
            let projId = 0;
            $('#additemid').empty();
            if ($('#inputType').val() == 1) {
                var fetchitemlisturl = config.developmentPath +
                    "/Admin/Controller/item_detailscontroller.php/?catId=" + catId +
                    "&subcatId=" + subcatId + "&projId=" + projId + "&brandId=" + brandId;

                $.getJSON(fetchitemlisturl, function (data) {
                    itemDetails = data;
                    $('#additemid').append('<option hidden disabled selected value>-- select an option --</option>');
                    $.each(data, function (index, value) {
                        $('#additemid').append('<option value="' + value.itemid + '">' +
                            value.itemname + '</option>');
                    });
                });
            } else if ($('#inputType').val() == 2) {
                var fetchitemlisturl = config.developmentPath +
                    "/Admin/Controller/materialController.php/?catId=" + catId +
                    "&subcatId=" + subcatId + "&brandId=" + brandId;

                $.getJSON(fetchitemlisturl, function (data) {
                    materialDetails = data;
                    $('#additemid').append('<option hidden disabled selected value>-- select an option --</option>');
                    $.each(data, function (index, value) {
                        $('#additemid').append('<option value="' + value.MaterialId + '">' +
                            value.MaterialName + '</option>');
                    });
                });
            }
        }


        $('#additemCategory').on('change', function () {
            debugger;
            $('#additemsubCategory').empty();
            $('#additemid').empty();

            if ($('#inputType').val() == 1) {
                setSubCategory(this.value);
            } else if ($('#inputType').val() == 2) {
                setMatSubCategory(this.value);
            }
        });

        $('#editeditemCategory').on('change', function () {
            $('#editeditemsubCategory').empty();
            $('#additemid').empty();
            fetchsubcaturl =
                config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
                    .value;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#editeditemsubCategory').empty();
                $('#editeditemsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
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

        $('#additemsubCategory').on('change', function () {
            $('#additemid').empty();
            setItemlist($('#additemCategory').val(), this.value, $('#brand').val());
        });

        $('#editeditemsubCategory').on('change', function () {
            $('#additemid').empty();
            setItemlist($('#editeditemCategory').val(), this.value);
        });
        function fetchMaterialValuesForEditModal(matId) {
            $.getJSON(
                config.developmentPath + "/Admin/Controller/materialController.php?infomatid=" + matId,
                function (data) {
                    if (!data || !data.length) return;

                    const r = data[0];

                    const mrp = parseFloat(r.MaterialPPMRP || 0);
                    const gst = parseFloat(r.MaterialGST || 0);
                    const cDisc = parseFloat(r.MaterialCompanyDiscount || 0);
                    const cPrice = parseFloat(r.MaterialCompanyPrice || 0);
                    const tVal = parseFloat(r.MaterialTotalValue || 0);
                    const spu = parseFloat(r.MaterialSPU || 1);
                    const uFact = parseFloat(r.MaterialUnitFactor || 1);

                    // 🔹 Populate EDIT modal fields
                    $('#itemppMRP').val(mrp.toFixed(2));
                    $('#GST').val(gst.toFixed(2));
                    $('#editCompanyDiscount').val(cDisc.toFixed(2));
                    $('#unitFactor').val(uFact);

                    // 🔹 Store base values (CRITICAL – used by editCalculateAmount)
                    $('#editCompanyPrice')
                        .val(cPrice.toFixed(2))
                        .data('base', cPrice);

                    $('#totalPrice')
                        .val(tVal.toFixed(2))
                        .data('base', tVal)
                        .data('spu', spu);

                    console.log("Edit Material Base Values:", {
                        companyBase: cPrice,
                        totalValueBase: tVal,
                        spu: spu,
                        unitFactor: uFact
                    });

                    // 🔁 Recalculate after data load
                    editCalculateAmount();
                }
            );
        }

    });
</script>