<?php
include('customerNavigation.php');
require_once("../DB Operations/customerOps.php");
require_once("../DB Operations/paymentOps.php");
require_once("../Model/customerModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Payment Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#customerModal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="Customer_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Customer Id</th>
                        <th>Customer Name</th>
                        <th>Customer Contact No.</th>
                        <th>Customer Email</th>
                        <th style="display:none">Customer Address</th>
                        <th style="display:none">Customer City</th>
                        <th style="display:none">Customer State</th>
                        <th style="display:none">Customer DOV</th>
                        <th style="display:none">enqid</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $customerList = DBcustomer::getAllcustomer();
                    foreach ($customerList as $customer) {
                        echo "<tr><td>" . $customer->get_customerId() . "</td>
                        <td>" . $customer->get_customerName() . "</td>
                        <td>" . $customer->get_customerPhone() . "</td>
                        <td>" . $customer->get_customerEmail() . "</td>
                        <td style='display:none'>" . $customer->get_customerAddress() . "</td>
                        <td style='display:none'>" . $customer->get_customerCity() . "</td>
                        <td style='display:none'>" . $customer->get_customerState() . "</td>
                        <td style='display:none'>" . $customer->get_customerDov() . "</td>
                        <td style='display:none'>" . $customer->get_enqId() . "</td>
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
                                    data-target='#infoCustomerModal' 
                                    role='button' 
                                    data-id='" . $customer->get_customerId() . "'> 
                                    <i class='fas fa-info'></i>
                                        Customer Info
                                   </button>
                                   <button class='btn btn-primary dropdown-item'
                                   data-toggle='modal' 
                                   data-target='#quoteModal' 
                                   role='button' 
                                   data-id='" . $customer->get_customerId() . "'> 
                                   <i class='fab fa-quora'></i>
                                       Get Quote
                                  </button>
                                   
                                    <button class='btn btn-danger dropdown-item' 
                                    data-toggle='modal'
                                    data-target='#paymentinfoModal' 
                                    name='delete_button' 
                                    role='button' 
                                    data-id='" . $customer->get_customerId() . "'>
                                        <i class='fas fa-trash-alt'></i>
                                        Payment Information
                                    </button>
                                </div>
                            </div>
                      </td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=customerModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="customer_form" enctype="multipart/form-data" action="../Controller/customer.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="customerName" name="customerName">
                                <input type="hidden" class="form-control" id="enqId" name="enqId" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Date of visit. <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="customerDov" name="customerDov">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" id="customerEmail" name="customerEmail">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Mobile<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="customerPhone" name="customerPhone">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-4 text-right">Address line<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="customerAddress" placeholder="1234 Main St"
                                    name="customerAddress">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">City <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="customerCity" name="customerCity">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">State <span class="text-danger">*</span></label>
                            <div class="col-md-8">
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
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                            data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                            data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addCustomer" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=infoCustomerModal tabindex=-1 role=dialog aria-hidden=true>
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
                                        <label for="displaycustomerName">Name</label>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title" id="displaycustomerName"></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycustomerDov">Date Of Visit</label>
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


<div class="modal fade" id=quoteModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quotation Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Customer Deatils
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body row g-3">
                                    <div class="col-md-8">
                                        <label for="quotecustomerName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="quotecustomerName"
                                            name="customerName" readonly>
                                        <input type="hidden" class="form-control" id="quoteenqId" name="enqId" />
                                        <input type="hidden" class="form-control" id="quotecustomerId"
                                            name="customerId" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="quotecustomerDov" class="form-label">Date of visit</label>
                                        <input type="date" class="form-control" id="quotecustomerDov" name="customerDov"
                                            readonly>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="quotecustomerEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="quotecustomerEmail"
                                            name="customerEmail" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="quotecustomerPhone" class="form-label">Mobile</label>
                                        <input type="text" class="form-control" id="quotecustomerPhone"
                                            name="customerPhone" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quotecustomerAddress" class="form-label">Address line</label>
                                        <input type="text" class="form-control" id="quotecustomerAddress"
                                            name="customerAddress" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="quotecustomerCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="quotecustomerCity"
                                            name="customerCity" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="State" class="form-label">State</label>
                                        <input id="quotecustomerState" name="customerState" class="form-control"
                                            required readonly />
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
                                    Quotation Details
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right">Quotation Type <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="quoteType" class="form-select" required name="quoteType">
                                                    <option value='General'>General</option>
                                                    <option value='Bank'>Bank</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 text-right">Item Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <select id="itemid" class="form-select" required name="itemid">

                                            </select>
                                            <input type="hidden" name="selectedItemName" id="selectedItemName"
                                                class="form-control" value="" />
                                        </div>
                                        <label class="col-md-3 text-right">Item Quantity <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="itemquantity" id="itemquantity"
                                                class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 text-right">Item per piece MRP <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="itemppMRP" id="itemppMRP" class="form-control"
                                                required readonly />
                                        </div>
                                        <label class="col-md-3 text-right">Total Amount <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="totalAmount" id="totalAmount" class="form-control"
                                                required readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 text-right">Discount-1<span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="discount1" id="discount1" class="form-control" />
                                        </div>
                                        <label class="col-md-3 text-right">Discount-2 <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="discount2" id="discount2" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 text-right">Discounted-1 Amount <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="discountAmount1" id="discountAmount1"
                                                class="form-control" required readonly />
                                        </div>
                                        <label class="col-md-3 text-right">Discounted-2 Amount <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="discountAmount2" id="discountAmount2"
                                                class="form-control" required readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 text-right">GST<span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="GST" id="GST" class="form-control" required
                                                readonly />
                                            <input type="hidden" name="GSTAmount" id="GSTAmount" class="form-control"
                                                value="" />
                                        </div>
                                        <label class="col-md-3 text-right">Total Price<span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="totalPrice" id="totalPrice" class="form-control"
                                                required readonly />
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered" id="lineItemTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>MRP</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Discount-1 %</th>
                                            <th>Discount-1 Amt</th>
                                            <th>Discount-2 %</th>
                                            <th>Discount-2 Amt</th>
                                            <th>GST %</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 text-right">Sum Total Amount <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="sumTotalAmount" id="sumTotalAmount"
                                                class="form-control" required readonly />
                                        </div>
                                        <label class="col-md-3 text-right">Sum Total Price <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="sumTotalPrice" id="sumTotalPrice"
                                                class="form-control" required readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createQuote">Add Item</button>
                    <button type="submit" class="btn btn-primary" id="createQuote">Create Quote</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=paymentinfoModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <div class="row gutters-sm">
            <div class="col-md-2 mb-2">

                <br />
                <div class="form-check text-center">
                    <input type="radio" class="btn-check" name="edit" id="option2">
                    <label class="btn btn-danger" for="option2">Edit</label>
                </div>
            </div>
            <div class="col-md-10">
                <form class="form" action="../Controller/paymentcontroller.php" method="POST" id="myForm"
                    enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Customer Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="custname" id="custname" class="form-control" required
                                            data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                            data-parsley-trigger="keyup" />
                                        <input type="hidden" id="custid" name="custid" value="">
                                        <input type="hidden" id="paymentid" name="paymentid" value="">
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Customer Contact No.<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="custcontactno" id="custcontactno" class="form-control"
                                            required data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                                <br />


                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Total Amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="totalamt" id="totalamt" class="form-control" required
                                            data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Paid Amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="paidamt" id="paidamt" class="form-control" required
                                            data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Pending Amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="pendingamt" id="pendingamt" class="form-control"
                                            required data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Payment Plan<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <select class="form-select" id="paymentplan" name="paymentplan" required>
                                            <option value="">Payment Plan</option>
                                            <option value="Part Payment">Part Payment</option>
                                            <option value="Full Payment">Full Payment</option>
                                        </select>
                                    </div>
                                </div>
                                <br />


                                <div id="duedatediv" class="col-md-6" style="display: none">
                                    <label for="duedate" class="col-md-6 control-label"> Next payment on:</label>
                                    <div class="col-sm-12">
                                        <input type="date" id="duedate" name="duedate" class="form-control" required />
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label for="pmode" class="col-md-6 control-label">Payment Mode</label>
                                    <div class="col-sm-12">
                                        <select class="form-select" id="paymentmode" name="paymentmode" required>
                                            <option value=""></option>
                                            <option value="Cash">Cash</option>
                                            <option value="Net Banking">Net Banking</option>
                                            <option value="Debit/Credit Card">Debit/Credit Card </option>
                                            <option value="UPI transaction">UPI transaction</option>
                                            <option value="Cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                                <br />

                                <div id="rtgsdiv" class="col-md-6" style="display: none">
                                    <label for="rtgsno" class="col-md-6 control-label">Enter RTGS number:</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="RTGSno" name="RTGSno" class="form-control" />
                                    </div>
                                </div>
                                <br />

                                <div id="chequediv" class="col-md-6" style="display: none">
                                    <label for="chequeimg" class=" col-md-6 form-label">Upload the image of
                                        cheque</label>
                                    <div class="col-sm-12">
                                        <input type="file" name="chequeimg" id="chequeimg" class="form-control">
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label for="paymentdescription" class="col-md-6 control-label">Payment
                                        Description</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="paymentdescription" name="paymentdescription"
                                            placeholder="Payment Description" class="form-control" required>
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                        data-parsley-type="integer" data-parsley-minlength="10"
                                        data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                        value="<?php echo $_SESSION['login_user']; ?>" />

                                </div>

                                <div>
                                    <button class="btn btn-success" id="btn" type="submit" name="submit">Update</button>
                                    <br />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade" id=editedpaymentinfoModal tabindex=-1 role=dialog aria-hidden=true>
        <div class="modal-dialog modal-xl">
            <br />
            <form class="form" action="../Controller/paymentcontroller.php" method="POST" id="myForm"
                enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="col-md-6 control-label">Customer Name <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="custname" id="editedcustname" class="form-control" required
                                        data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                    <input type="hidden" id="custid" name="custid" value="">
                                    <input type="hidden" id="paymentid" name="paymentid" value="">
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <label class="col-md-6 control-label">Customer Contact No.<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="custcontactno" id="editedcustcontactno"
                                        class="form-control" required data-parsley-trigger="keyup" />
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <label class="col-md-6 control-label">Total Amount<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="totalamt" id="editedtotalamt" class="form-control" required
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <label class="col-md-6 control-label">Paid Amount<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="paidamt" id="editedpaidamt" class="form-control" required
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <label class="col-md-6 control-label">Pending Amount<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="pendingamt" id="editedpendingamt" class="form-control"
                                        required data-parsley-trigger="keyup" />
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <label class="col-md-6 control-label">Payment Plan<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <select class="form-select" id="editedpaymentplan" name="paymentplan" required>
                                        <option value="">Payment Plan</option>
                                        <option value="Part Payment">Part Payment</option>
                                        <option value="Full Payment">Full Payment</option>
                                    </select>
                                </div>
                            </div>
                            <br />


                            <div id="duedatediv" class="col-md-6" style="display: none">
                                <label for="duedate" class="col-md-6 control-label"> Next payment on:</label>
                                <div class="col-sm-12">
                                    <input type="date" id="editedduedate" name="duedate" class="form-control"
                                        required />
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <label for="pmode" class="col-md-6 control-label">Payment Mode</label>
                                <div class="col-sm-12">
                                    <select class="form-select" id="editedpaymentmode" name="paymentmode" required>
                                        <option value=""></option>
                                        <option value="Cash">Cash</option>
                                        <option value="Net Banking">Net Banking</option>
                                        <option value="Debit/Credit Card">Debit/Credit Card </option>
                                        <option value="UPI transaction">UPI transaction</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <br />

                            <div id="rtgsdiv" class="col-md-6" style="display: none">
                                <label for="rtgsno" class="col-md-6 control-label">Enter RTGS number:</label>
                                <div class="col-sm-12">
                                    <input type="text" id="editedRTGSno" name="RTGSno" class="form-control" />
                                </div>
                            </div>
                            <br />

                            <div id="chequediv" class="col-md-6" style="display: none">
                                <label for="chequeimg" class=" col-md-6 form-label">Upload the image of
                                    cheque</label>
                                <div class="col-sm-12">
                                    <input type="file" name="chequeimg" id="editedchequeimg" class="form-control">
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <label for="paymentdescription" class="col-md-6 control-label">Payment
                                    Description</label>
                                <div class="col-sm-12">
                                    <input type="text" id="editedpaymentdescription" name="paymentdescription"
                                        placeholder="Payment Description" class="form-control" required>
                                </div>
                            </div>
                            <br />

                            <div class="col-md-6">
                                <input type="hidden" name="modifiedby" id="editedmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />

                            </div>

                            <div>
                                <button class="btn btn-success" id="btn" type="submit" name="submit">Update</button>
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
    $(document).ready(function() {

        $("#myForm :input").prop("disabled", true);
        $('input[type=radio][name=edit]').click(function() {
            $('#myForm :input').prop('disabled', false);
            if (!parseInt($('#totalamt').val())) {
                $('#totalamt').focus();
                $('#paidamt').attr('disabled', true);
            } else {
                $('#totalamt').attr('readonly', true);
            }
        });

        $('#paymentinfoModal').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#custid').val(rowid);

        });
        var dataTable = $('#Customer_table').DataTable({

        });

        var nEditing = null;

        $('#Customer_table tbody').on('click', 'tr', function() {
            /* Get the row as a parent of the link that was clicked on */
            $('#custname').val(this.cells[1].innerHTML);
            $('#custcontactno').val(this.cells[2].innerHTML);
        });
        $('#editbutton').click(function(event) {
            var formData = {
                customerid: $('#custid').val(),
                custname: $('#custname').val(),
                custcontactno: $('#custcontactno').val(),


            };

            $.ajax({
                type: "POST",
                url: window.location.origin +
                    "/acedecor/Admin/Controller/paymentcontroller.php/",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function(data) {
                console.log(data);
            });
            $('#editbutton').dispose();
            event.preventDefault();
        });


        $("#paymentplan").change(function() {

            if ($(this).val() == "Part Payment") {
                $("#duedatediv").show();
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;

                $("#duedate").attr("min", today);
                $("#duedate").attr('disabled', false);
                $("#btn").attr("disabled", false);
            } else {
                debugger;
                if (parseInt($("#paidamt").val()) > 0 && parseInt($("#pendingamt").val()) != 0) {
                    $("#btn").attr("disabled", true);
                    alert("Payment is still due");
                }

                $("#duedate").attr('disabled', true);
            }
        });

        $("#totalamt").change(function() {
            if (parseInt($(this).val()) > 0) {
                $('#paidamt').attr('disabled', false);
            }
        });

        $("#paidamt").change(function() {
            debugger;
            if (parseInt($(this).val()) < parseInt($("#totalamt").val())) {
                if ($("#pendingamt").val() == 0) {
                    var pendingfees = $("#totalamt").val() - $("#paidamt").val();
                } else {
                    var pendingfees = $("#pendingamt").val() - $("#paidamt").val();

                }
                $("#pendingamt").val(pendingfees);
            }


        });

        if (parseInt($("#paidamt").val()) == parseInt($("#totalamt").val())) {
            $("#myForm :input").prop("disabled", true);
            $("#option2").prop("disabled", true);
        }


        $("#paymentmode").change(function() {
            debugger;
            if ($(this).val() == "Net Banking") {
                $("#rtgsdiv").show();
                $("#chequediv").hide();
            } else if ($(this).val() == "Cheque") {
                $("#rtgsdiv").hide();
                $("#chequediv").show();
            } else {
                $("#rtgsdiv").attr('disabled', true);
                $("#chequediv").attr('disabled', true);
            }
        });
    });
    </script>