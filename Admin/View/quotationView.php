<?php
include('session.php');
include('quotationNavigation.php');
require_once("../DB Operations/quotationOps.php");
require_once("../Model/quotationModel.php");
?>
<style>
    /* #editedlineItemTable {
    height: 200px;
    display: inline-block;
    width: 100%;
    overflow: auto;
} */

    #editedlineItemTable thead {
        background-color: grey;
        color: whitesmoke;
        position: sticky;
        top: 0;
    }

    .pad {
        padding-right: .5rem;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Customer Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Quotation
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
                <thead>
                    <tr>
                        <th style='display:none'>Customer Id </th>
                        <th>Customer Code</th>
                        <th>Customer Name</th>
                        <th>DOE</th>
                        <th>Quote Id</th>
                        <th>DOQ</th>
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
                    $quotationList = DBQuotation::getAllquotations();

                    foreach ($quotationList as $quotationObj) {

                        // ✅ Check approval status
                        $isApproved = strtolower($quotationObj->get_quoteStatus()) === 'approved';

                        // ✅ Prepare delete button safely
                        if ($isApproved) {
                            $deleteBtn = "
            <button class='btn btn-secondary dropdown-item disabled' disabled
                title='Approved quotation cannot be deleted'>
                <i class='fas fa-lock'></i> Approved – Locked
            </button>";
                        } else {
                            $deleteBtn = "
            <button class='btn btn-primary dropdown-item'
                data-toggle='modal'
                data-target='#deleteQuotationModal'
                name='delete_button'
                role='button'
                data-id='" . $quotationObj->get_quoteId() . "'>
                <i class='fas fa-trash-alt'></i> Delete Quotation
            </button>";
                        }

                        echo "
    <tr>
        <td style='display:none'>{$quotationObj->get_customerId()}</td>
        <td>{$quotationObj->getCustomerCode()}</td>
        <td>{$quotationObj->get_customerName()}</td>
        <td>{$quotationObj->getDOE()}</td>
        <td>{$quotationObj->getQuoteCode()}</td>
        <td>{$quotationObj->getDOQ()}</td>
        <td>{$quotationObj->get_quoteDescription()}</td>
        <td style='display:none'>{$quotationObj->get_quoteType()}</td>
        <td>{$quotationObj->getQuoteValue()}</td>
        <td>{$quotationObj->get_quoteStatus()}</td>
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

                <div class='dropdown-menu'>

                    <button class='btn btn-primary dropdown-item'
                        data-toggle='modal'
                        data-target='#inputListModal'
                        data-id='{$quotationObj->get_quoteId()}'>
                        <i class='fas fa-list-alt'></i> Input List
                    </button>

                    <button class='btn btn-primary dropdown-item'
                        data-toggle='modal'
                        data-target='#customerModal'
                        data-id='{$quotationObj->get_customerId()}'>
                        <i class='fas fa-info'></i> Customer Info
                    </button>

                    <button class='btn btn-primary dropdown-item'
                        data-toggle='modal'
                        data-target='#editquoteModal'
                        data-id='{$quotationObj->get_quoteId()}'>
                        <i class='fas fa-user-edit'></i> Edit Quotation
                    </button>

                    <button class='btn btn-primary dropdown-item'
                        data-toggle='modal'
                        data-target='#viewModal'
                        data-id='{$quotationObj->get_quoteId()}'>
                        <i class='fas fa-info'></i> Quotation Info
                    </button>

                    <a class='btn btn-primary dropdown-item'
                        href='printQuote.php?id={$quotationObj->get_customerId()}'>
                        <i class='fas fa-print'></i> Print Quote
                    </a>

                    $deleteBtn

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
<div class="modal fade" id=viewModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
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
                        <label class="col-md-2 text-right">Total Price<span class="text-danger">*</span></label>
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


                <table class="table table-bordered" id="displaylineItemTable" width="100%" cellspacing="0">
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
                            <!-- <th>Quote Value</th> -->
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
                <a name="button" target="_blank" href="" id="downloadLineItem" class="btn btn-success">Download Input
                    List</a>
                <a name="button" target="_blank" href="" id="downloadQuote" class="btn btn-success">Download Quote</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id=editquoteModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form method="post" id="editQuote" enctype="multipart/form-data" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Data</h4>
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
                            <label class="col-md-2 text-right">Quote Type <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="quoteType" class="form-select" required name="quoteType">
                                    <option value='General'>General</option>
                                    <option value='Bank'>Bank</option>
                                </select>
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

                            <label class="col-md-2 text-right">Total Price<span class="text-danger">*</span></label>
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
                                    <option value="pending">Revised</option>
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
                    <table class="table table-bordered" id="editedlineItemTable" width="100%" cellspacing="0">
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
                                <!-- <th>Quote Value</th> -->
                            </tr>
                        </thead>

                        <tbody>


                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
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
            <div class="modal-header">
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
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">BOQ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="printtopdf">
                        <div class="card">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>
                                            Customer Name :<span id='customerName'></span>
                                        </td>
                                        <td>
                                            Customer Id : <span id='customerCode'></span>
                                        </td>
                                        <td>
                                            Quote Id : <span id='listquoteCode'></span>
                                        </td>
                                        <td style='display:none'>
                                            <span id="Input">InputType :</span> <span id='InputType'></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="lineItemTable" width="100%" cellspacing="0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
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
                        <label class="form-check-label" for="flexSwitchCheckDefault">Water Mark</label>
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
                <div class="modal-header">
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
        $('#itemListForm').submit(function (e) {
            e.preventDefault();

            var content = document.getElementById("printtopdf").outerHTML;
            var fileName = $('#customerCode').text() + $('#listquoteCode').text();

            var printWindow = window.open("", "", "width=900,height=700");
            printWindow.document.write(`
        <html>
        <head>
            <title>Print PDF</title>
            <style>
                body { font-family: Arial; padding: 15px; }
                img { width:100px; height:100px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #333; padding: 8px; text-align:center; }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.print();  // You can choose “Save as PDF” in print dialog
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

            $('#quoteid').val(rowid);
            const button = $(e.relatedTarget);   // Edit button
            const row = button.closest('tr');    // ✅ Correct row

            const quoteCode = row.find('td:eq(4)').text().trim();
            const customerCode = row.find('td:eq(1)').text().trim();

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
                    if (res.locked === true) {
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
            let apiFile = ($('#InputType').text().trim() == "1")
                ? "itemListController.php"
                : "materialListController.php";

            var uniturl = config.developmentPath +
                "/Admin/Controller/" + apiFile + "?id=" + rowid + "&projId=" + projId;

            var sumTotalAmount = 0;
            var sumTotalPrice = 0;

            // Clear old rows
            $('#editedlineItemTable tbody').empty();

            $.getJSON(uniturl, function (data) {

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

                    $('#displaylineItemTable tbody').append(
                        $('<tr/>', { id: value.lineItemId })
                            .append($('<td/>').text(value.Name || ""))          // Name ✅
                            .append($('<td/>').text(qty))                       // Quantity ✅
                            .append($('<td/>').text(value.discount1 ?? value.CompanyDiscount ?? 0)) // Discount ✅
                            .append($('<td/>').text(value.GST ?? 0))            // GST ✅
                            .append($('<td/>').text(value.totalAmount?.toFixed(2) ?? 0)) // Total Amount ✅
                            .append($('<td/>').text(comp.toFixed(2)))            // Company Price ✅
                            .append($('<td/>').text(tVal.toFixed(2)))            // ✅ ADD TOTAL VALUE
                            .append($('<td/>').text(trade.toFixed(2)))           // ✅ ADD TRADE PRICE
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
            const button = $(e.relatedTarget);     // Input List button
            const row = button.closest('tr');      // Parent table row

            const rowid = button.data('id');

            // ✅ SAFELY get InputType from row cells
            const inputType = row.children('td').eq(21).text().trim();

            console.log("InputType from row =", inputType);

            $('#quoteid').val(rowid);
            $('#InputType').text(inputType);

            reloadloadItemTable(rowid);
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
            $('#editedQuoteType').val(this.cells[7].innerHTML);
            $('#editedQuoteAmount').val(this.cells[8].innerHTML);
            $('#editedStatus').val(this.cells[9].innerHTML);
            $('#editedquoteDecription').val(this.cells[6].innerHTML);
            $('#editedquoteComments').val(this.cells[10].innerHTML);
            $('#quoteType').val(this.cells[7].innerHTML)
            $('#customerCode').text(this.cells[1].innerHTML);
            $('#listquoteCode').text(this.cells[4].innerHTML);
            $('#unitId').val(this.cells[11].innerHTML);
            $('#unit').val(this.cells[13].innerHTML);
            $('#quantity').val(this.cells[12].innerHTML);
            $('#displaycustomerCode').text(this.cells[1].innerHTML);
            $('#projcustomerCode').val(this.cells[1].innerHTML);
            $('#displayquoteCode').text(this.cells[4].innerHTML);
            $('#projquoteCode').val(this.cells[4].innerHTML);
            $('#displayCustName').text(this.cells[2].innerHTML);
            $('#displaycustomerName').text(this.cells[2].innerHTML);
            $('#projCustomerName').val(this.cells[2].innerHTML);
            $('#displayQuoteType').text(this.cells[7].innerHTML);
            $('#displayQuoteAmount').text(this.cells[8].innerHTML + ' ');
            $('#projQuoteAmount').val(this.cells[8].innerHTML + ' ');
            $('#displayStatus').text(this.cells[9].innerHTML);
            $('#displayquoteDecription').text(this.cells[6].innerHTML);
            $('#displayquoteComments').text(this.cells[10].innerHTML);
            $('#displayquoteType').text(this.cells[7].innerHTML)
            $('#displayUnit').text(this.cells[13].innerHTML);
            $('#displayquantity').text(this.cells[12].innerHTML);
            $('#displaycustomerDov').text(this.cells[3].innerHTML);
            $('#displaycustomerEmail').text(this.cells[16].innerHTML);
            $('#displaycustomerPhone').text(this.cells[17].innerHTML);
            $('#displaycustomerAddress').text(this.cells[18].innerHTML);
            $('#displaycustomerCity').text(this.cells[19].innerHTML);
            $('#displaycustomerState').text(this.cells[20].innerHTML);
            $('#InputType').text(this.cells[21].innerHTML);
            if (this.cells[15].innerHTML != "") {
                $('#downloadLineItem').attr('href', '../pdfs/itemList/' + this.cells[15].innerHTML);
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
                    <td>
                        <img src="../img/${imgFolder}/${img}"
                             style="width:100px;height:100px"
                             class="img-fluid"
                             onerror="this.src='../img/no-image.png'">
                    </td>
                    <td>${name}</td>
                    <td>${brand}</td>
                    <td>${desc}</td>
                    <td>${qty}</td>
                    <td>${unit}</td>
                </tr>
            `);
                });
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
                    $('#quotationdetails_table tbody').append(
                        $("<tr>").append(
                            $("<td>").text(value.QuoteCode),
                            $("<td>").text(value.DOQ),
                            $("<td>").text(value.EnqCatName),
                            $("<td>").text(value.quoteValue)  // ✔ shows now
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
    });
</script>