<?php
include('session.php');
include('customerNavigation.php');
require_once("../DB Operations/customerOps.php");
require_once("../Model/customerModel.php");
require_once("../Model/enq_cat_mappingmodel.php");
?>
<style>
    .paging-nav {
        text-align: right;
        padding-top: 2px;
    }

    .paging-nav a {
        margin: auto 1px;
        text-decoration: none;
        display: inline-block;
        padding: 1px 7px;
        background: #91b9e6;
        color: white;
        border-radius: 3px;
    }

    .paging-nav .selected-page {
        background: #187ed5;
        font-weight: bold;
    }

    #lineItemTable {
        height: 200px;
        display: inline-block;
        width: 100%;
        overflow: auto;
    }

    #lineItemTable thead {
        background-color: grey;
        color: whitesmoke;
        position: sticky;
        top: 0;
    }

    .table thead th {
        vertical-align: middle;
        border-bottom: 2px solid #e3e6f0;
        text-align: center;
    }

    #quoteModal .form-label {
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    #quoteModal input[readonly] {
        background-color: #f9fafb;
    }

    #quoteModal .input-group-text {
        background-color: #fff;
    }

    #quoteModal .text-primary {
        font-weight: 600;
    }

    /* Compact info modal styles */
    #infoItemModal .modal-dialog {
        max-width: 480px;
        /* smaller modal width */
    }

    #infoItemModal .modal-body {
        padding: 1rem 1.25rem;
    }

    #infoItemModal label {
        font-size: 0.85rem;
        font-weight: 500;
        color: #555;
    }

    #infoItemModal input,
    #infoItemModal textarea {
        font-size: 0.85rem;
        height: 30px;
        border-radius: 6px;
        max-width: 260px;
        /* reduced width */
        margin: 0 auto;
        display: block;
    }

    #infoItemModal textarea {
        height: 60px !important;
    }

    #infoItemModal img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 4px;
        background: #fafafa;
    }

    #infoItemModal .modal-title {
        font-weight: 600;
        font-size: 1rem;
    }

    #infoItemModal .form-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
    }

    .modal-backdrop.modal-stack {
        pointer-events: none !important;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Customer Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Customer
                    List</h6>
            </div>
            <!-- <div class="col" align="right">
                <span data-toggle=modal data-target=#Modal>
                    <button type="button" + class="btn btn-success btn-circle btn-sm"><i
                            class="fas fa-plus"></i></button>
                </span>
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="Customer_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>DOE</th>
                        <th>Place</th>
                        <th>Enquiry</th>
                        <th>Quote Generated</th>
                        <th style="display:none">Customer Contact No.</th>
                        <th style="display:none">Customer Email</th>
                        <th style="display:none">Customer Address</th>
                        <th style="display:none">Customer State</th>
                        <th style="display:none">enqid</th>
                        <th style="display:none">Country</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $customerList = DBcustomer::getAllcustomer();

                    foreach ($customerList as $customer):

                        // ✅ define once per row
                        $hasQuote = ($customer->getQuotationCount() > 0);
                        ?>
                        <tr>
                            <td><?= $customer->getCustomerCode(); ?></td>
                            <td><?= $customer->get_customerName(); ?></td>
                            <td><?= $customer->get_customerDov(); ?></td>
                            <td><?= $customer->get_customerCity(); ?></td>

                            <!-- Enquiry -->
                            <td>
                                <ul class="mb-0">
                                    <?php foreach ($customer->getListOfEnq() as $interest): ?>
                                        <li><?= $interest; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>

                            <!-- Quote Generated -->
                            <td>
                                <ul class="mb-0">
                                    <?php
                                    $quotes = DBcustomer::getQuotationSummaryByCustomer($customer->get_customerId());
                                    if (!empty($quotes)):
                                        foreach ($quotes as $q):
                                            ?>
                                            <li><?= $q['name']; ?> - <?= $q['count']; ?></li>
                                            <?php
                                        endforeach;
                                    else:
                                        echo "<span class='text-muted'>No Quotation</span>";
                                    endif;
                                    ?>
                                </ul>
                            </td>

                            <!-- Hidden fields -->
                            <td style="display:none"><?= $customer->get_customerPhone(); ?></td>
                            <td style="display:none"><?= $customer->get_customerEmail(); ?></td>
                            <td style="display:none"><?= $customer->get_customerAddress(); ?></td>
                            <td style="display:none"><?= $customer->get_customerState(); ?></td>
                            <td style="display:none"><?= $customer->get_enqId(); ?></td>
                            <td style="display:none"><?= $customer->getCustomerCountry(); ?></td>

                            <!-- Actions -->
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>

                                    <div class="dropdown-menu">
                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#editCustomerModal" data-id="<?= $customer->get_customerId(); ?>">
                                            <i class="fas fa-user-edit"></i> Edit Customer
                                        </button>

                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#infoCustomerModal" data-id="<?= $customer->get_customerId(); ?>">
                                            <i class="fas fa-info"></i> Customer Info
                                        </button>

                                        <a class="btn btn-primary dropdown-item"
                                            href="design.php?id=<?= $customer->get_customerId(); ?>">
                                            <i class="fas fa-file-image"></i> Designs
                                        </a>

                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#quoteModal" data-id="<?= $customer->get_customerId(); ?>">
                                            <i class="fab fa-linkedin-in"></i> Inputs
                                        </button>

                                        <!-- <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#optiModal" data-id="<?= $customer->get_customerId(); ?>">
                                            <i class="fas fa-ankh"></i> Opti
                                        </button> -->

                                        <div class="dropdown-divider"></div>

                                        <?php if ($hasQuote): ?>
                                            <button class="btn btn-danger dropdown-item disabled" disabled
                                                title="Customer has quotation(s). Deletion not allowed">
                                                <i class="fas fa-trash-alt"></i> Delete Customer
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-danger dropdown-item" data-toggle="modal"
                                                data-target="#deleteUserModal" data-id="<?= $customer->get_customerId(); ?>">
                                                <i class="fas fa-trash-alt"></i> Delete Customer
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
                            <label class="col-md-4 text-right">Date of Enquiry. <span
                                    class="text-danger">*</span></label>
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
<div class="modal fade" id=editCustomerModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="editedCustomer_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Customer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Customer Id <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="editedcustomerCode" name="customerCode"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="editedcustomerName" name="customerName">
                                <input type="hidden" name="customerId" id="editedcustomerId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Date of Enquiry. <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="editedcustomerDov" name="customerDov">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" id="editedcustomerEmail" name="customerEmail">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Mobile<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="editedcustomerPhone" name="customerPhone">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Address line<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="editedcustomerAddress"
                                    placeholder="1234 Main St" name="customerAddress">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">City <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="editedcustomerCity" name="customerCity">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">State <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="editedcustomerState" name="customerState" class="form-select" required>
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

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Country <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="editedSelectedCountry" name="SelectedCountry" class="form-select">
                                    <option value="">Select Country</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="editCustomer" class="btn btn-success" value="Save" />
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
                                        <label for="displayusername">Customer Id</label>
                                    </div>
                                    <input type="hidden" id="customerId" name="customerId" value="">
                                    <div class="col-8">
                                        <h5 class="card-title" id="displayusername"></h5>
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
                                        <label for="displaycustomerCity">Location</label>
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
                                    Customer Details
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body row g-3">
                                    <div class="col-md-12">
                                        <label for="State" class="form-label">Customer Id</label>
                                        <input id="quotecustomerCode" name="customerCode" class="form-control" required
                                            readonly />
                                    </div>
                                    <div class="col-md-8">
                                        <label for="quotecustomerName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="quotecustomerName"
                                            name="customerName" readonly>
                                        <input type="hidden" class="form-control" id="quoteenqId" name="enqId" />
                                        <input type="hidden" class="form-control" id="quotecustomerId"
                                            name="customerId" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="quotecustomerDov" class="form-label">Date of Enquiry</label>
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
                                            <label class="col-md-3 text-right">Quotation For<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="enqCategory" class="form-select" required
                                                    name="enqCategory">
                                                </select>
                                                <input type="hidden" name="encatName" id="encatName"
                                                    class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right">Input Type <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="inputType" class="form-select" required name="inputType">

                                                </select>
                                            </div>

                                            <label class="col-md-3 text-right">Brand<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="brand" class="form-select" required name="brand">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">


                                            <label class="col-md-3 text-right">Category Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="itemCategory" class="form-select" required
                                                    name="itemCategory">

                                                </select>
                                            </div>

                                            <label class="col-md-3 text-right"> Sub Category Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="itemsubCategory" class="form-select" required
                                                    name="itemsubCategory">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right"> Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="itemid" class="form-select" required name="itemid">

                                                </select>
                                                <input type="hidden" name="selectedItemName" id="selectedItemName"
                                                    class="form-control" value="" />
                                                <input type="hidden" name="unitFactor" id="unitFactor"
                                                    class="form-control" value="" />
                                                <input type="hidden" name="spu" id="spu" class="form-control"
                                                    value="" />
                                                <input type="hidden" name="itemarticleNo" id="itemarticleNo"
                                                    class="form-control" value="" />
                                                <input type="hidden" name="itemimage" id="itemimage"
                                                    class="form-control" value="" />
                                            </div>
                                            <label class="col-md-3 text-right">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <input type="text" name="itemquantity" id="itemquantity"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right">Per piece MRP <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="itemppMRP" id="itemppMRP" class="form-control"
                                                    required readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>

                                            <label class="col-md-3 text-right">Total Amount <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="totalAmount" id="totalAmount"
                                                    class="form-control" required readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right">Company Discount</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="companyDiscount" id="companyDiscount"
                                                    class="form-control" readonly />
                                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            </div>

                                            <label class="col-md-3 text-right">Company Price</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="companyPrice" id="companyPrice"
                                                    class="form-control" readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right">Trade Discount</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="tradeDiscount" id="tradeDiscount"
                                                    class="form-control" />
                                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            </div>

                                            <label class="col-md-3 text-right">Trade Price</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="tradePrice" id="tradePrice"
                                                    class="form-control" readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right">GST<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="GST" id="GST" class="form-control" required
                                                    readonly />
                                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                                <input type="hidden" name="GSTAmount" id="GSTAmount"
                                                    class="form-control" value="" />
                                            </div>
                                            <label class="col-md-3 text-right">Total Value<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="totalValue" id="totalValue"
                                                    class="form-control" readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="quoteNote" class="form-label">Note</label>
                                                <input type="text" class="form-control" id="quoteNote" name="quoteNote">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="quoteReference" class="form-label">Reference</label>
                                                <input type="text" class="form-control" id="quoteReference"
                                                    name="quoteReference">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 text-right">Reference</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="quoteReference" id="tradequoteReferencePrice"
                                                    class="form-control" />
                                            </div>

                                            <label class="col-md-3 text-right">Note</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="quoteNote" id="quoteNote"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered" id="lineItemTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>REF</th>
                                                <th>Image</th>
                                                <th>Type</th>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>MRP</th>
                                                <th>GST</th>
                                                <th>Company Discount</th>
                                                <th>Trade Discount</th>
                                                <th>Total Amount</th>
                                                <th>Company Price</th>
                                                <th>Total Value</th>
                                                <th>Trade Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                    <!-- =================== Summary Totals Section =================== -->
                                    <!-- =================== Centered Summary Totals =================== -->
                                    <div class="form-group mt-4 text-center">
                                        <div class="d-flex flex-wrap justify-content-center gap-4">

                                            <div class="text-center">
                                                <label for="sumTotalAmount"
                                                    class="form-label fw-semibold text-uppercase small d-block">Sum
                                                    Total Amount</label>
                                                <div class="input-group justify-content-center">
                                                    <input type="text" id="sumTotalAmount" name="sumTotalAmount"
                                                        class="form-control text-center fw-bold" style="width:150px;"
                                                        readonly>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-rupee-sign"></i></span>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <label for="sumCompanyPrice"
                                                    class="form-label fw-semibold text-uppercase small d-block">Sum
                                                    Company Price</label>
                                                <div class="input-group justify-content-center">
                                                    <input type="text" id="sumCompanyPrice" name="sumCompanyPrice"
                                                        class="form-control text-center fw-bold" style="width:150px;"
                                                        readonly>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-rupee-sign"></i></span>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <label for="sumTotalValue"
                                                    class="form-label fw-semibold text-uppercase small d-block">Sum
                                                    Total Value</label>
                                                <div class="input-group justify-content-center">
                                                    <input type="text" id="sumTotalValue" name="sumTotalValue"
                                                        class="form-control text-center fw-bold" style="width:150px;"
                                                        readonly>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-rupee-sign"></i></span>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <label for="sumTradeValue"
                                                    class="form-label fw-semibold text-uppercase small d-block">Sum
                                                    Trade Price</label>
                                                <div class="input-group justify-content-center">
                                                    <input type="text" id="sumTradeValue" name="sumTradeValue"
                                                        class="form-control text-center fw-bold" style="width:150px;"
                                                        readonly>
                                                    <span class="input-group-text"><i
                                                            class="fas fa-rupee-sign"></i></span>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <label for="quoteValue"
                                                    class="form-label fw-semibold text-uppercase small text-primary d-block">Quote
                                                    Value</label>
                                                <div class="input-group justify-content-center">
                                                    <input type="text" id="quoteValue" name="quoteValue"
                                                        class="form-control text-center fw-bold text-primary border-primary"
                                                        style="width:150px;">
                                                    <span class="input-group-text text-primary"><i
                                                            class="fas fa-rupee-sign"></i></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- ============================================================ -->

                                    <!-- ============================================================ -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createQuote">Add</button>
                    <button type="submit" class="btn btn-primary" id="createQuote">Create Quote</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=optiModal tabindex=-1 role=dialog aria-hidden=true>
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
                                    Customer Details
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body row g-3">
                                    <div class="col-md-12">
                                        <label for="State" class="form-label">Customer Id</label>
                                        <input id="opticustomerCode" name="customerCode" class="form-control" required
                                            readonly />
                                    </div>
                                    <div class="col-md-8">
                                        <label for="quotecustomerName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="opticustomerName"
                                            name="customerName" readonly>
                                        <input type="hidden" class="form-control" id="optienqId" name="enqId" />
                                        <input type="hidden" class="form-control" id="opticustomerId"
                                            name="customerId" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="opticustomerDov" class="form-label">Date of Enquiry</label>
                                        <input type="date" class="form-control" id="opticustomerDov" name="customerDov"
                                            readonly>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="opticustomerEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="opticustomerEmail"
                                            name="customerEmail" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="opticustomerPhone" class="form-label">Mobile</label>
                                        <input type="text" class="form-control" id="opticustomerPhone"
                                            name="customerPhone" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="opticustomerAddress" class="form-label">Address line</label>
                                        <input type="text" class="form-control" id="opticustomerAddress"
                                            name="customerAddress" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="opticustomerCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="opticustomerCity"
                                            name="customerCity" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="State" class="form-label">State</label>
                                        <input id="opticustomerState" name="customerState" class="form-control" required
                                            readonly />
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
                                    Opti Details
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-2 text-right">Cabinet Dimensions<span
                                                    class="text-danger"></span></label>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-1 text-right">Length<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <input type="text" name="Length" id="Length" class="form-control"
                                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                            </div>

                                            <label class="col-md-1 text-right">Width<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <input type="text" name="Width" id="Width" class="form-control" required
                                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                                    data-parsley-trigger="keyup" />
                                            </div>

                                            <label class="col-md-1 text-right">Depth<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <input type="text" name="Depth" id="Depth" class="form-control" required
                                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                                    data-parsley-trigger="keyup" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="row">



                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            <label class="col-md-2 text-right">Category <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="productCategory" class="form-select" required
                                                    name="productCategory">

                                                </select>
                                            </div>

                                            <label class="col-md-3 text-right"> Sub Category <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="productsubCategory" class="form-select" required
                                                    name="productsubCategory">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">

                                            <label class="col-md-2 text-right">Finish <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="Finish" class="form-select" required name="Finish">

                                                </select>
                                            </div>

                                            <label class="col-md-3 text-right"> Cabinet Type <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="CabinetType" class="form-select" required
                                                    name="CabinetType">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-2 text-right"> Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="productName" class="form-select" required
                                                    name="productName">

                                                </select>

                                            </div>

                                            <label class="col-md-3 text-right">Material Brand <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3">
                                                <select id="MatBrand" class="form-select" required name="MatBrand">

                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-2 text-right">Grains <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="Grains" id="Grains" class="form-control"
                                                    required />

                                            </div>

                                            <label class="col-md-3 text-right">Material Category<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <select id="MatCategory" class="form-select" required
                                                    name="MatCategory">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-2 text-right">Material Sub Category <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <select id="MatSubCategory" class="form-select" required
                                                    name="MatSubCategory">

                                                </select>
                                            </div>

                                            <label class="col-md-3 text-right">Thickness<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <select id="Thickness" class="form-select" required name="Thickness">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-2 text-right">Material Name <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <select id="MatName" class="form-select" required name="MatName">

                                                </select>
                                            </div>
                                            <label class="col-md-3 text-right">PEB</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="PEB" id="PEB" class="form-control" />

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">

                                            <label class="col-md-2 text-right">PEB Thickness <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="PEBThickness" id="PEBThickness"
                                                    class="form-control" required />

                                            </div>
                                            <label class="col-md-3 text-right">SEB</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="SEB" id="SEB" class="form-control" />

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">

                                            <label class="col-md-2 text-right">SEB Thickness <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="SEBThickness" id="SEB" class="form-control"
                                                    required />

                                            </div>
                                            <label class="col-md-3 text-right">Comments</label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="Comments" id="Comments" class="form-control" />

                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">CL-Id</th>
                                                <th rowspan="2">Comments</th>
                                                <th rowspan="2">Finish</th>
                                                <th rowspan="2">Category</th>
                                                <th rowspan="2">Sub Category</th>
                                                <th rowspan="2">Cabinet Size</th>
                                                <th rowspan="2">Cabinet Type</th>
                                                <th rowspan="2"> #</th>
                                                <th rowspan="2">Product Name</th>
                                                <th rowspan="2">Material Code</th>
                                                <th rowspan="2">Grains</th>
                                                <th rowspan="2">Rotation</th>
                                                <th rowspan="2">Product Id</th>
                                                <th rowspan="2">Barcode</th>
                                                <th colspan="1">Groove</th>
                                                <th colspan="2">Cut Size</th>
                                                <th colspan="1">Groove</th>
                                                <th rowspan="2">Quantity</th>
                                                <th colspan="6">EB</th>
                                            </tr>
                                            <tr>
                                                <td>Length Side</td>
                                                <td>Length</td>
                                                <td>Width</td>
                                                <td>Width Side </td>
                                                <td>EB-L</td>
                                                <td>FL</td>
                                                <td>BL</td>
                                                <td>RW</td>
                                                <td>LW</td>
                                                <td>EB-W</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                    <!-- <div class="form-group">
                                        <div class="row ">

                                            <label class="col-md-3 text-right">Sum Total Amount <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="sumTotalAmount" id="sumTotalAmount"
                                                    class="form-control" required readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>

                                            <label class="col-md-3 text-right">Sum Total Value <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="sumTotalValue" id="sumTotalValue"
                                                    class="form-control" required readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row ">
                                            <label class="col-md-3 text-right">Sum Total Price <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="sumTotalPrice" id="sumTotalPrice"
                                                    class="form-control" required readonly />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>
                                            <label class="col-md-3 text-right">Quote Amount <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-3 input-group">
                                                <input type="text" name="QuoteAmount" id="QuoteAmount"
                                                    class="form-control" required />
                                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            </div>
                                        </div>
                                    </div> -->
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
<div class="modal fade" id=deleteUserModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_customer_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this customer.
                    </p>
                    <input type="hidden" name="deletecustomerId" id="deletecustomerId" value="">
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
<div class="modal fade" id="infoItemModal" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="true"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title">Line Item Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-section">
                    <!-- REF -->
                    <div>
                        <label class="form-label mb-0">REF</label>
                        <input type="text" class="form-control form-control-sm text-center" id="infoRef" readonly>
                    </div>

                    <!-- Image -->
                    <img id="infoImg" src="" alt="Item Image">

                    <!-- Code -->
                    <div>
                        <label class="form-label mb-0">Code</label>
                        <input type="text" class="form-control form-control-sm text-center" id="infoCode" readonly>
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="form-label mb-0">Name</label>
                        <input type="text" class="form-control form-control-sm text-center" id="infoName" readonly>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="form-label mb-0">Quantity</label>
                        <input type="text" class="form-control form-control-sm text-center" id="infoQty" readonly>
                    </div>

                    <!-- Trade Price -->
                    <div>
                        <label class="form-label mb-0">Trade Price</label>
                        <input type="text" class="form-control form-control-sm text-center" id="infoTPrice" readonly>
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="form-label mb-0">Note</label>
                        <textarea class="form-control form-control-sm text-center" id="infoNote" rows="2"
                            readonly></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer py-2">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Edit Line Item</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editLineItemId">
                <div class="form-group mb-2">
                    <label>Quantity</label>
                    <input type="number" id="editItemQty" class="form-control form-control-sm">
                </div>
                <div class="form-group mb-2">
                    <label>Trade Discount (%)</label>
                    <input type="number" id="editTradeDiscount" class="form-control form-control-sm">
                </div>
                <div class="form-group mb-2">
                    <label>Trade Price</label>
                    <input type="number" id="editTradePrice" class="form-control form-control-sm">
                </div>
                <div class="form-group mb-2">
                    <label>Reference</label>
                    <input type="text" id="editQuoteRef" class="form-control form-control-sm">
                </div>
                <div class="form-group mb-2">
                    <label>Note</label>
                    <textarea id="editNote" class="form-control form-control-sm" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary btn-sm" id="updateLineItemBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let ROW_BEING_EDITED = null;

        var select = document.getElementById("editedSelectedCountry");

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
        var customers = [];
        var isInitialized = false;
        var lineItemTable
        var sumTotalAmount = 0;
        var sumTotalPrice = 0;
        var sumTotalValue = 0;
        var sumCompanyPrice = 0;
        var sumTradeValue = 0;
        var quantityDetails = [];

        var itemDetails = [];
        var materialDetails = [];
        $('#createQuote').on('click', function () {
            const f = $('#quote_form').serializeJSON();

            // guard
            const qty = parseFloat(f['itemquantity'] || 0);
            if (!qty) { alert('Please add the appropriate values in the Quantity'); return; }

            // image source
            let src = '';
            if (f['inputType'] == 1) src = "../img/items/" + f['itemimage'];
            else if (f['inputType'] == 2) src = "../img/materials/" + f['itemimage'];

            // collect needed values (strings -> numbers safely)
            const mrp = parseFloat(f['itemppMRP'] || 0);
            const gst = parseFloat(f['GST'] || 0);
            const cDis = parseFloat(f['companyDiscount'] || 0);
            const tDis = parseFloat(f['tradeDiscount'] || 0);
            const tAmt = parseFloat(f['totalAmount'] || 0);
            const cPri = parseFloat(f['companyPrice'] || 0);
            const tVal = parseFloat(f['totalValue'] || 0);
            const tPri = parseFloat(f['tradePrice'] || 0);

            // Keep the original customer obj array behavior
            // ✅ Always capture latest REF & NOTE before pushing
            f.quoteReference = $('#tradequoteReferencePrice').val();
            f.quoteNote = $('#quoteNote').val();
            customers.push(f);

            // Build row
            const $tr = $('<tr/>');

            // 1) Ref (Reference)
            const refValue = f['quoteReference'] || '-';
            $tr.append($('<td/>').text(refValue));

            // 2) Image
            $tr.append(
                $('<td/>').append($('<img/>', { src: src, class: 'img-fluid', style: 'width:100px;height:100px' }))
            );

            // 3) Type (show the selected text, not id)
            const typeText = $('#inputType option:selected').text() || f['inputType'];
            $tr.append($('<td/>').text(typeText));

            // 4) Code (article/code)
            $tr.append($('<td/>').text(f['itemarticleNo'] || ''));

            // 5) Name
            $tr.append($('<td/>').text(f['selectedItemName'] || ''));

            // 6) Quantity
            $tr.append($('<td/>').text(qty));

            // 7) MRP (per piece)
            $tr.append($('<td/>').text(mrp.toFixed(2)));

            // 8) GST (%)
            $tr.append($('<td/>').text(gst.toFixed(2)));

            // 9) Company Discount (%)
            $tr.append($('<td/>').text(cDis.toFixed(2)));

            // 10) Trade Discount (%)
            $tr.append($('<td/>').text(tDis.toFixed(2)));

            // 11) Total Amount (MRP × qty × unitFactor)
            $tr.append($('<td/>').text(tAmt.toFixed(2)));

            // 12) Company Price (per piece from inventory.php mapping)
            $tr.append($('<td/>').text(cPri.toFixed(2)));

            // 13) Total Value (from DB × qty)
            $tr.append($('<td/>').text(tVal.toFixed(2)));

            // 14) Trade Price
            $tr.append($('<td/>').text(tPri.toFixed(2)));


            // 15) Action dropdown
            // ✅ FIX — assign temporary unique ID until DB assigns one
            const rowId = Date.now(); // or use Math.random() for uniqueness

            const rowPayload = {
                id: rowId,
                typeText,
                code: f['itemarticleNo'] || '',
                name: f['selectedItemName'] || '',
                qty,
                mrp,
                gst,
                cDis,
                tDis,
                tAmt,
                cPri,          // current total company price
                tVal,          // current total value
                tPri,
                ref: refValue,
                note: f['quoteNote'] || '',
                img: src,

                // ✅ ADD THESE (DO NOT REMOVE ANYTHING ABOVE)
                unitFactor: Number($('#unitFactor').val()) || 1,
                spu: Number($('#spu').val()) || 1,
                companyBase: Number($('#companyPrice').data('base')) || 0,
                baseTotalValue: Number($('#totalValue').data('base')) || 0
            };

            $tr.data('rowPayload', rowPayload);  // 🔹 Save this item’s data to the row itself



            const $actionTd = $('<td/>').append(makeActionDropdown(rowPayload));
            $tr.append($actionTd);

            // attach row
            $('#lineItemTable tbody').append($tr);
            resetQuotationFields();

            // Update totals
            // Update all summary totals
            // sumTotalAmount += tAmt;
            // sumCompanyPrice += cPri;
            // sumTotalValue += tVal;
            // sumTradeValue += tPri;

            // // ✅ Update summary input display
            // $('#sumTotalAmount').val(sumTotalAmount.toFixed(2));
            // $('#sumCompanyPrice').val(sumCompanyPrice.toFixed(2));
            // $('#sumTotalValue').val(sumTotalValue.toFixed(2));
            // $('#sumTradeValue').val(sumTradeValue.toFixed(2));
            recalcTotals();

            // 🧩 Keep Quote Value blank until admin enters it manually
            $('#quoteValue').val('');

        });

        function makeActionDropdown(payload) {
            const $wrap = $('<div class="dropdown"/>');
            const $btn = $('<button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>');
            const $menu = $('<ul class="dropdown-menu dropdown-menu-end"></ul>');

            // Info
            // Info
            const $info = $('<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#infoItemModal">Info</a>')
                .click(function (e) {
                    e.preventDefault();
                    const $tr = $(this).closest('tr');
                    const payload = $tr.data('rowPayload') || {};
                    $('#infoRef').val(payload.ref || '-');
                    $('#infoImg').attr('src', payload.img || '');
                    $('#infoCode').val(payload.code || '');
                    $('#infoName').val(payload.name || '');
                    $('#infoQty').val(payload.qty || 0);
                    $('#infoTPrice').val(Number(payload.tPri ?? 0).toFixed(2));  // ← cast to number
                    $('#infoNote').val(payload.note || '');
                    $('#infoItemModal').modal('show');
                });

            // Edit
            const $edit = $('<a class="dropdown-item text-primary" href="#">Edit</a>').click(function (e) {
                e.preventDefault();
                ROW_BEING_EDITED = $(this).closest('tr');
                const payload = ROW_BEING_EDITED.data('rowPayload') || {};    // ← fresh data
                openEditModal(payload);
            });

            // Delete
            const $delete = $('<a class="dropdown-item text-danger" href="#">Delete</a>').click(function () {
                if (confirm('Are you sure you want to delete this item?')) {
                    deleteLineItem(payload);
                }
            });

            $menu.append($('<li/>').append($info));
            $menu.append($('<li/>').append($edit));
            $menu.append($('<li/>').append($delete));

            $wrap.append($btn).append($menu);
            return $wrap;
        }

        $(document).on('click', '.dropdown-item[data-bs-target="#infoItemModal"]', function (e) {
            const $tr = $(this).closest('tr');
            const payload = $tr.data('rowPayload'); // ✅ Get latest data directly from row
            if (!payload) return;

            $('#infoRef').val(payload.ref || '-');
            $('#infoImg').attr('src', payload.img || '');
            $('#infoCode').val(payload.code || '');
            $('#infoName').val(payload.name || '');
            $('#infoQty').val(payload.qty || 0);
            $('#infoTPrice').val((payload.tPri ?? 0).toFixed(2));
            $('#infoNote').val(payload.note || '');
        });

        // ==================== OPEN EDIT MODAL ====================
        function openEditModal(payload) {
            console.log('🧾 openEditModal payload:', payload);
            $('#editLineItemId').val(payload.id);
            $('#editItemQty').val(payload.qty);
            $('#editTradeDiscount').val(payload.tDis);
            $('#editTradePrice').val(payload.tPri);
            $('#editQuoteRef').val(payload.ref);
            $('#editNote').val(payload.note);

            // Attach live calculations
            attachEditCalculations(payload);

            $('#editItemModal').modal('show');
        }


        // ==================== LIVE CALCULATION IN EDIT MODAL ====================
        function attachEditCalculations(payload) {
            // Store original MRP and GST from the payload
            const MRP = Number(payload.mrp || 0);
            const GST = Number(payload.gst || 0);

            // Listen for changes in Quantity or Trade Discount
            $('#editItemQty, #editTradeDiscount').off('keyup change').on('keyup change', function () {
                const qty = Number($('#editItemQty').val()) || 0;
                const tDis = Number($('#editTradeDiscount').val()) || 0;
                const uFac = Number(payload.unitFactor || $('#unitFactor').val()) || 1;


                let perPieceTrade = MRP;
                if (tDis > 0) {
                    const discounted = MRP - (MRP * (tDis / 100));
                    perPieceTrade = discounted + (discounted * (GST / 100));
                }

                const totalTradePrice = perPieceTrade * qty * uFac;
                $('#editTradePrice').val(totalTradePrice.toFixed(2));
            });
        }

        // ==================== DELETE LINE ITEM ====================
        function deleteLineItem(payload) {
            // 🔹 Handle unsaved or temporary line items (with fake ID)
            if (!payload.id || isNaN(payload.id) || payload.id.toString().length > 6) {
                const $row = $('#lineItemTable tbody tr').filter(function () {
                    return $(this).data('rowPayload')?.id === payload.id;
                });
                $row.remove();
                resetQuotationFields();
                return;
            }

            // 🔹 Handle DB saved line items (real numeric ID)
            $.ajax({
                type: 'POST',
                url: '../Controller/quotationController.php',
                data: {
                    action: 'delete_lineitem',
                    id: payload.id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Item deleted successfully!');
                        const row = $('#lineItemTable tbody tr').filter(function () {
                            return $(this).data('rowPayload')?.id === payload.id;
                        });
                        row.remove();

                        // If no rows remain, clear the table and reset the form
                        if ($('#lineItemTable tbody tr').length === 0) {
                            $('#lineItemTable tbody').empty().append('<tr><td colspan="15" class="text-center text-muted">No line items added</td></tr>');
                            resetQuotationFields();
                        }
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }

        function recalcTotals() {
            debugger;
            const rows = $('#lineItemTable tbody tr').toArray();
            console.log("Real Row count:", rows.length);

            let sumTotalAmount = 0;
            let sumCompanyPrice = 0;
            let sumTotalValue = 0;
            let sumTradeValue = 0;

            for (let i = 0; i < rows.length; i++) {

                const payload = $(rows[i]).data('rowPayload');
                if (!payload) continue;   // Skip rows without payload

                sumTotalAmount += Number(payload.tAmt || 0);
                sumCompanyPrice += Number(payload.cPri || 0);
                sumTotalValue += Number(payload.tVal || 0);
                sumTradeValue += Number(payload.tPri || 0);
            }

            $('#sumTotalAmount').val(sumTotalAmount.toFixed(2));
            $('#sumCompanyPrice').val(sumCompanyPrice.toFixed(2));
            $('#sumTotalValue').val(sumTotalValue.toFixed(2));
            $('#sumTradeValue').val(sumTradeValue.toFixed(2));
        }


        // ✅ Resets all quotation item fields to blank
        function resetQuotationFields() {
            $('#itemquantity').val('');
            $('#itemppMRP').val('');
            $('#companyDiscount').val('');
            $('#tradeDiscount').val('');
            $('#GST').val('');
            $('#totalAmount').val('');
            $('#companyPrice').val('');
            $('#tradePrice').val('');
            $('#totalValue').val('');
            $('#quoteNote').val('');
            $('#tradequoteReferencePrice').val('');
            $('#selectedItemName').val('');
            $('#itemarticleNo').val('');
            $('#itemimage').val('');
            $('#unitFactor').val('');
        }

        $('#infoCustomerModal').on('show.bs.modal', function (e) {
            //debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#customerId').val(rowid);
            var contactUrl = config.developmentPath +
                "/Admin/Controller/quotationController.php?custId=" + rowid;
            //debugger;
            $.getJSON(contactUrl, function (data) {
                $("#quotationdetails_table").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#quotationdetails_table tbody')
                        .append($(document.createElement('tr')).prop({
                            id: value.custId
                        }));

                    $('#quotationdetails_table tr:last')
                        .append($('<td/>').html(value.QuoteCode));

                    $('#quotationdetails_table tr:last')
                        .append($('<td/>').html(value.DOQ));

                    $('#quotationdetails_table tr:last')
                        .append($('<td/>').html(value.EnqCatName));

                    // ✅ NEW Added Column
                    $('#quotationdetails_table tr:last')
                        .append($('<td/>').html(value.quoteValue));

                });
                console.log(data);
            });
        });

        $('#quote_form').submit(function (event) {
            //debugger;
            customers[0].quoteValue = $('#quoteValue').val();
            console.log(customers[0]);
            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/quotationController.php/",
                data: {
                    "obj": customers
                },
                dataType: "json",
                encode: true,
            }).done(function (data) {
                location.reload(true);
                console.log(data);
            });

        });

        fetchinputTypeurl =
            config.developmentPath +
            "/Admin/Controller/inputTypeController.php/";
        console.log(fetchinputTypeurl);
        $.getJSON(fetchinputTypeurl, function (data) {
            $('#inputType').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function (index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#inputType').append('<option value="' + value.InputTypeId +
                    '">' +
                    value
                        .InputType + '</option>');
            });
        });


        $('#inputType').on('change', function () {
            //debugger;
            if ($('#inputType').val() == 4) {
                document.getElementById('brand').required = false;
                document.getElementById('itemCategory').required = false;
                document.getElementById('itemsubCategory').required = false;
                document.getElementById('itemid').required = false;
                document.getElementById('itemquantity').required = false;
                document.getElementById('itemppMRP').required = false;
                document.getElementById('totalAmount').required = false;
                document.getElementById('value').required = false;
                document.getElementById('totalValue').required = false;
                document.getElementById('discount1').required = false;
                document.getElementById('discountAmount1').required = false;
                document.getElementById('GST').required = false;
                document.getElementById('totalPrice').required = false;
            }
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
            $('#value').val("");
            $('#totalValue').val("");
            $('#brand').empty();
            $('#itemCategory').empty();
            $('#itemsubCategory').empty();
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


        function setItemlist(catId, subcatId, brandId, thicknessId = 0) {
            //debugger;
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
                    "/Admin/Controller/item_detailscontroller.php/?catId=" + catId + "&subcatId=" +
                    subcatId +
                    "&brandId=" + brandId;
                console.log(fetchitemlisturl);
                $.getJSON(fetchitemlisturl, function (data) {
                    itemDetails = data;
                    quantityDetails = data;
                    $('#itemid').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $.each(data, function (index, value) {
                        $('#itemid').append('<option value="' + value.itemid + '">' +
                            value
                                .itemname + '</option>');

                        // $('#editedsubCategory').append('<option value="' + value.itemsubcatid +
                        //     '">' +
                        //     value
                        //     .itemsubcatname + '</option>');
                    });
                });
            } else if ($('#inputType').val() == 2) {
                var fetchitemlisturl = config.developmentPath +
                    "/Admin/Controller/materialController.php/?catId=" + catId + "&subcatId=" +
                    subcatId +
                    "&brandId=" + brandId + "&thicknessId=" + thicknessId;
                console.log(fetchitemlisturl);
                $.getJSON(fetchitemlisturl, function (data) {
                    materialDetails = data;
                    $('#itemid').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $.each(data, function (index, value) {
                        $('#itemid').append('<option value="' + value.MaterialId + '">' +
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
        $('#itemCategory').on('change', function () {
            //debugger;
            $('#itemsubCategory').empty();
            if ($('#inputType').val() == 1) {
                fetchsubcaturl =
                    config.developmentPath +
                    "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
                        .value;
                $.getJSON(fetchsubcaturl, function (data) {
                    $('#itemsubCategory').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $.each(data, function (index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        $('#itemsubCategory').append('<option value="' + value
                            .itemsubcatid +
                            '">' +
                            value
                                .itemsubcatname + '</option>');
                    });
                });
            } else if ($('#inputType').val() == 2) {
                var fetchsubcaturl = config.developmentPath +
                    "/Admin/Controller/material_SubcategoryController.php/?catId=" + this
                        .value;
                let subcatId = 0;
                let brandId = 0;
                $.getJSON(fetchsubcaturl, function (data) {
                    $('#itemsubCategory').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $.each(data, function (index, value) {
                        // APPEND OR INSERT DATA TO SELECT ELEMENT.
                        $('#itemsubCategory').append('<option value="' + value
                            .materialsubcatId +
                            '">' +
                            value
                                .materialsubcatName + '</option>');
                        $('#editeditemsubCategory').append('<option value="' + value
                            .materialsubcatId +
                            '">' +
                            value
                                .materialsubcatName + '</option>');
                    });
                });

            }
        });

        $('#itemsubCategory').on('change', function () {
            //debugger;
            $('#itemid').empty();
            setItemlist($('#itemCategory').val(), this.value, $('#brand').val());
        });

        $('#brand').on('change', function () {
            //debugger;
            $('#itemid').empty();
            $('#itemCategory').empty();
            $('#itemsubCategory').empty();
            if ($('#inputType').val() == 1) {
                var url = config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php/?brandId=" +
                    this.value;
                let isSelectedSet1 = false;
                let catId = 0;

                $.getJSON(url, function (data) {
                    $.each(data, function (index, value) {
                        $('#itemCategory').append(
                            '<option hidden disabled selected value>-- select an option --</option>'
                        );
                        $('#itemCategory').append('<option value="' + value.itemcatid +
                            '">' + value
                                .itemcatname + '</option>');
                        $('#editeditemCategory').append('<option value="' + value
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

                $.getJSON(url, function (data) {
                    $.each(data, function (index, value) {
                        $('#itemCategory').append(
                            '<option hidden disabled selected value>-- select an option --</option>'
                        );
                        $('#itemCategory').append('<option value="' + value.materialcatId +
                            '">' + value
                                .materialCatname + '</option>');
                        $('#editeditemCategory').append('<option value="' + value
                            .materialcatId + '">' +
                            value
                                .materialCatname + '</option>');
                        isSelectedSet = true;
                        // setMatSubCategory(value.materialcatId);
                    });
                });

            };
        });


        var url = config.developmentPath +
            "/Admin/Controller/product_categorycontroller.php/?brandId=" +
            this.value;
        let productcatid = 0;

        $.getJSON(url, function (data) {
            $.each(data, function (index, value) {
                $('#productCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#productCategory').append('<option value="' + value.productcatid +
                    '">' + value
                        .productcatname + '</option>');
                $('#editeditemCategory').append('<option value="' + value
                    .productcatid + '">' +
                    value
                        .materialCatname + '</option>');
                // setMatSubCategory(value.materialcatId);
            });
        });

        function setproductSubCategory(productcatid) {
            //debugger;
            var fetchsubcaturl = window.location.origin +
                "/Acedecor/Admin/Controller/product_SubcategoryController.php/?productcatid=" +
                productcatid;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#productsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#productsubCategory').append('<option value="' + value
                        .productsubcatid +
                        '">' +
                        value
                            .productsubcatname + '</option>');
                    $('#editedproductSubCategory').append('<option value="' +
                        value
                            .productsubcatid +
                        '">' +
                        value
                            .productsubcatname + '</option>');
                });
            });
        }


        function setProductName(catId, subcatId, finishId, typeId) {
            //debugger;
            var fetchsubcaturl = window.location.origin +
                "/Acedecor/Admin/Controller/productDefinitionController.php/?catId=" + catId + "&subcatId=" +
                subcatId + "&finishId=" + finishId + "&typeId=" + typeId;
            console.log(fetchsubcaturl);
            $.getJSON(fetchsubcaturl, function (data) {
                $('#productName').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#productName').append('<option value="' + value
                        .ProdDefinition_Id +
                        '">' +
                        value
                            .Prod_Name + '</option>');
                    $('#editedproductName').append('<option value="' +
                        value
                            .ProdDefinition_Id +
                        '">' +
                        value
                            .Prod_Name + '</option>');
                });
            });
        }



        function setMatName(thicknessId, catId, subcatId, brandId) {
            //debugger;
            var fetchsubcaturl = window.location.origin +
                "/Acedecor/Admin/Controller/materialController.php/?thicknessId=" +
                thicknessId + "&catId=" + catId + "&subcatId=" + subcatId + "&brandId=" + brandId;
            console.log(fetchsubcaturl);
            $.getJSON(fetchsubcaturl, function (data) {
                $('#MatName').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#MatName').append('<option value="' + value
                        .MaterialId +
                        '">' +
                        value
                            .MaterialName + '</option>');
                    $('#editedMatName').append('<option value="' +
                        value
                            .MaterialId +
                        '">' +
                        value
                            .MaterialName + '</option>');
                });
            });
        }

        $('#productCategory').on('change', function () {
            //debugger;
            $('#productsubCategory').empty();
            setproductSubCategory(this.value);
        });
        //debugger;

        fetchFinishurl =
            config.developmentPath +
            "/Admin/Controller/FinishController.php/";
        $.getJSON(fetchFinishurl, function (data) {
            $('#Finish').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function (index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#Finish').append('<option value="' + value.FinishId +
                    '">' +
                    value
                        .Finish + '</option>');
            });
        });

        fetchCabinetTypeurl =
            config.developmentPath +
            "/Admin/Controller/CabinetTypeController.php/";
        console.log();
        $.getJSON(fetchCabinetTypeurl, function (data) {
            $('#CabinetType').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function (index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#CabinetType').append('<option value="' + value.CabinetType_Id +
                    '">' +
                    value.CabinetType + '</option>');
            });
        });

        $('#CabinetType').on('change', function () {
            //debugger;
            $('#productName').empty();
            setProductName($('#productCategory').val(), $('#productsubCategory').val(), $('#Finish').val(),
                this.value)
        });



        var InputType = 2;
        fetchbrandurl =
            config.developmentPath +
            "/Admin/Controller/brandcontroller.php/?InputId=" + InputType;
        console.log(fetchbrandurl);
        $.getJSON(fetchbrandurl, function (data) {
            $('#MatBrand').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function (index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#MatBrand').append('<option value="' + value.brandid +
                    '">' +
                    value
                        .brandname + '</option>');
            });
        });

        $('#MatBrand').on('change', function () {
            //debugger;
            $('#MatCategory').empty();
            $('#MatSubCategory').empty();
            var url = config.developmentPath +
                "/Admin/Controller/material_CategoryController.php/?brandId=" +
                this.value;

            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#MatCategory').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $('#MatCategory').append('<option value="' + value.materialcatId +
                        '">' + value
                            .materialCatname + '</option>');
                    $('#editeditemCategory').append('<option value="' + value
                        .materialcatId + '">' +
                        value
                            .materialCatname + '</option>');
                    isSelectedSet = true;

                });
            });
        });


        $('#MatCategory').on('change', function () {
            //debugger; y
            var fetchsubcaturl = config.developmentPath +
                "/Admin/Controller/material_SubcategoryController.php/?catId=" + this
                    .value;
            let subcatId = 0;
            let brandId = 0;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#MatSubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#MatSubCategory').append('<option value="' + value
                        .materialsubcatId +
                        '">' +
                        value
                            .materialsubcatName + '</option>');
                    $('#editeditemsubCategory').append('<option value="' + value
                        .materialsubcatId +
                        '">' +
                        value
                            .materialsubcatName + '</option>');
                });
            });
        });

        var thicknessurl = config.developmentPath +
            "/Admin/Controller/thicknessController.php"
        console.log(thicknessurl);
        $.getJSON(thicknessurl, function (data) {
            $.each(data, function (index, value) {
                $('#Thickness').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $('#editedthickness').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $('#Thickness').append('<option value="' + value.ThicknessId + '">' + value
                    .Thickness + '</option>');
                $('#editedthickness').append('<option value="' + value.ThicknessId + '">' + value
                    .Thickness + '</option>');
            });
        });

        $('#Thickness').on('change', function () {
            //debugger;
            $('#MatName').empty();
            setMatName(this.value, $('#MatCategory').val(), $('#MatSubCategory').val(), $('#MatBrand')
                .val());

        });


        var today = new Date();
        var day = today.getDate();
        var month = today.getMonth() + 1;
        if (month < 10) {
            month = "0" + month.toString();
        }
        var year = today.getFullYear();
        var datetoday = year.toString() + "-" + month.toString() + "-" + day.toString();
        $('#customerDov')
            .val(datetoday);
        $('#editCustomerModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#editedcustomerId').val(rowid);
        });
        var dataTable = $('#Customer_table').DataTable({});
        var nEditing = null;

        $('#discount1').blur(function (e) {
            if (this.value != "" && this.value != 0) {
                $('#totalPrice').val((parseFloat($('#totalAmount').val())) - (parseFloat(($(
                    '#totalAmount')
                    .val()) * (parseFloat($('#discount1').val() / 100)))).toFixed(2));
                $('#discountAmount1').val((parseFloat($('#totalAmount').val())) - (parseFloat((
                    $(
                        '#totalAmount')
                        .val()) * (parseFloat($('#discount1').val() / 100)))).toFixed(2));
                $('#totalPrice').val((parseFloat(($('#discountAmount1').val()) * (parseFloat($(
                    '#GST')
                    .val() /
                    100))) + parseFloat($('#discountAmount1').val())).toFixed(2));
                $('#GSTAmount').val((parseFloat(($('#discountAmount1').val()) * (parseFloat($(
                    '#GST')
                    .val() / 100)))).toFixed(2));
                $('#discount2').removeAttr('readonly');
            } else {
                $('#discountAmount1').val("");
                $('#discountAmount2').val("");
                $('#discount2').val("");

                $('#totalPrice').val((parseFloat(($('#totalAmount').val()))));

            }
        });
        // $('#tradeDiscount').on('keyup', function () {
        //     //debugger;
        //     const mrp = parseFloat($('#itemppMRP').val()) || 0;
        //     const tradeDiscount = parseFloat($(this).val()) || 0;
        //     const companyPrice = parseFloat($('#companyPrice').val()) || 0;
        //     const uFac = Number($('#unitFactor').val()) || 1;

        //     let tradePrice = 0;
        //     if (tradeDiscount > 0) {
        //         const discounted = mrp - (mrp * (tradeDiscount / 100));
        //         tradePrice = (discounted + (discounted * 0.18)) * uFac;
        //     } else {
        //         tradePrice = companyPrice;
        //     }

        //     $('#tradePrice').val(tradePrice.toFixed(2));
        // });


        $('#quoteModal').on('show.bs.modal', function (e) {
            //debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#quotecustomerId').val(rowid);
            $('#itemid').empty();
            var url = config.developmentPath + "/Admin/Controller/item_detailscontroller.php";
            $.getJSON(url, function (data) {
                itemDetails = data;
                mappItemPrice(data[0].itemppMRP,
                    data[0].itemGST,
                    data[0].itemname,
                    data[0].unitFactor,
                    data[0].itemarticleNo,
                    data[0].itemimage
                );

            });

            var url = config.developmentPath +
                "/Admin/Controller/enqcategorymappingController.php?id=" + $(
                    '#quoteenqId').val();
            console.log(url);
            $('#enqCategory').empty();
            $.getJSON(url, function (data) {
                $('#encatName').val(data[0].name);
                $.each(data, function (index, value) {
                    $('#enqCategory').append('<option value="' + value.catId +
                        '">' + value
                            .name + '</option>');
                });
            });

            customers = [];
            sumTotalAmount = 0;
            sumTotalPrice = 0;
            sumTotalValue = 0;
            sumCompanyPrice = 0;
            sumTradeValue = 0;
            $('#itemquantity').val("");
            $('#totalPrice').val("");
            $('#totalAmount').val("");
            $('#discountAmount1').val("");
            $('#discountAmount2').val("");
            $('#sumTotalAmount').val("");
            $('#sumTotalPrice').val("");
            $('#sumCompanyPrice').val('');
            $('#sumTradeValue').val('');
            $('#quoteValue').val('');
            $('#discount1').val("");
            $('#discount2').val("");
            $('#itemppMRP').val("");
            $('#GST').val("");
            $('#tradequoteReferencePrice').val('');
            $('#quoteNote').val('');
            $('#lineItemTable tbody').empty();
        });

        $('#itemid').on('change', function (e) {
            //debugger;
            if ($('#inputType').val() == 1) {
                for (var i = 0; i < itemDetails.length; i++) {
                    // look for the entry with a matching `code` value
                    if (itemDetails[i].itemid == this.value) {
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
                        fetchCompanyValues(this.value);

                    }
                    var url = config.developmentPath +
                        "/Admin/Controller/item_stockscontroller.php?ItemCode=" + $('#itemarticleNo').val();
                    console.log(url);
                    $.getJSON(url, function (data) {
                        quantityDetails = data;
                        mapquantityDetails(data[0].ReceivedQtyAmt);
                    });
                    for (var i = 0; i < quantityDetails.length; i++) {
                        // look for the entry with a matching `code` value
                        if (quantityDetails[i].itemid == this.value) {
                            $('#itemquantity').val("");
                            $('#totalAmount').val("");
                            mapquantityDetails(quantityDetails[i].ReceivedQtyAmt);
                        }
                    }
                }
            } else if ($('#inputType').val() == 2) {

                resetMaterialFields();

                let matId = this.value;

                $.getJSON(
                    config.developmentPath + "/Admin/Controller/materialController.php?infomatid=" + matId,
                    function (mat) {

                        if (!mat || !mat.length) return;

                        const r = mat[0];

                        mappMaterialPrice(
                            parseFloat(r.MaterialPPMRP || 0),
                            parseFloat(r.MaterialGST || 0),
                            r.MaterialName || "",
                            parseFloat(r.MaterialUnitFactor || 1),
                            r.MaterialCode || "",
                            r.MaterialImage || "",

                            parseFloat(r.MaterialCompanyDiscount || 0),
                            parseFloat(r.MaterialCompanyPrice || 0),
                            parseFloat(r.MaterialTotalValue || 0),
                            parseFloat(r.MaterialSPU || 1)
                        );

                        // $.getJSON(
                        //     config.developmentPath +
                        //     "/Admin/Controller/item_stockscontroller.php?ItemCode=" + r.MaterialCode,
                        //     function (stock) {
                        //         if (stock?.length) {
                        //             mapquantityDetails(stock[0].ReceivedQtyAmt);
                        //         }
                        //     }
                        // );
                    }
                );
            }

            for (var i = 0; i < quantityDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (quantityDetails[i].itemid == this.value) {
                    $('#itemquantity').val("");
                    $('#totalAmount').val("");
                    mapquantityDetails(quantityDetails[i].ReceivedQtyAmt);
                }
            }


        });

        function mapquantityDetails(ReceivedQtyAmt) {

            $('#value').val(ReceivedQtyAmt);
        }

        $('#enqCategory').on('change', function (e) {

            $('#encatName').val($("#enqCategory option:selected").text());
        });

        function mappItemPrice(price, gst, name, unitFactor, itemarticleNo, itemimage) {
            //debugger;
            $('#itemppMRP').val(price);
            $('#GST').val(gst);
            $('#selectedItemName').val(name);
            $('#unitFactor').val(unitFactor);
            $('#itemarticleNo').val(itemarticleNo);
            $('#itemimage').val(itemimage);


        }

        let companyBasePrice = 0;
        // 1) Fetch everything we need for a picked item — FROM DB ONLY
        function fetchCompanyValues(itemId) {
            console.log(config.developmentPath + "/Admin/Controller/item_detailscontroller.php?infoitemid=" + itemId,);
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
                    console.log(r.spu);
                    const spu = parseFloat(r.spu || 0);   // ✅ ensure this matches your JSON key exactly
                    const uFact = parseFloat(r.unitFactor || 1);
                    $('#spu').val(spu.toFixed(2));
                    $('#itemppMRP').val(mrp.toFixed(2));
                    $('#GST').val(gst.toFixed(2));
                    $('#companyDiscount').val(cDisc.toFixed(2));
                    $('#companyPrice').val(cPrice.toFixed(2));
                    companyBasePrice = cPrice.toFixed(2);
                    $('#companyPrice').data('base', cPrice);
                    $('#totalValue').val(tVal.toFixed(2));

                    // ✅ add this — store SPU and base values
                    $('#totalValue').data('base', tVal);
                    $('#totalValue').data('spu', spu);

                    // ✅ debugging line (to verify in console)
                    console.log('SPU stored:', spu);

                    const qty = parseFloat($('#itemquantity').val()) || 0;
                    const totalAmount = mrp * qty * uFact;

                    $('#totalAmount').val(totalAmount.toFixed(2));

                    $('#tradePrice').val(cPrice.toFixed(2));
                }
            );
        }

        // ✅ Unified handler: Quantity + Trade Discount + GST + SPU logic
        // ✅ Unified SPU Logic Calculation
        // $(document).off('keyup change', '#itemquantity, #tradeDiscount, #GST').on('keyup change', '#itemquantity, #tradeDiscount, #GST', function () {
        //     const qty = Number($('#itemquantity').val()) || 0;
        //     const mrp = Number($('#itemppMRP').val()) || 0;
        //     const gst = Number($('#GST').val()) || 0;
        //     const tDis = Number($('#tradeDiscount').val()) || 0;
        //     const uFac = Number($('#unitFactor').val()) || 1;

        //     // Total Amount = MRP × Qty × UnitFactor
        //     const totalAmt = mrp * qty * uFac;
        //     $('#totalAmount').val(totalAmt.toFixed(2));

        //     // Company Price
        //     const companyBase = Number($('#companyPrice').data('base')) || Number($('#companyPrice').val()) || 0;
        //     $('#companyPrice').val((companyBase * qty).toFixed(2));

        //     // Trade Price
        //     let perPieceTrade = companyBase;
        //     if (tDis > 0) {
        //         const discounted = mrp - (mrp * (tDis / 100));
        //         perPieceTrade = discounted + (discounted * (gst / 100));
        //     }


        //     const tradeTotal = perPieceTrade * qty * uFac;
        //     $('#tradePrice').val(tradeTotal.toFixed(2));


        //     // ✅ Total Value with SPU logic
        //     const baseTotalValue = Number($('#totalValue').data('base')) || 0;
        //     const spu = Number($('#totalValue').data('spu')) || Number($('#itemSPU').val()) || 1;

        //     let totalValue = 0;
        //     if (baseTotalValue > 0 && spu > 0 && qty > 0) {
        //         totalValue = baseTotalValue * Math.ceil(qty / spu);
        //     } else {
        //         totalValue = baseTotalValue * qty;
        //     }

        //     $('#totalValue').val(totalValue.toFixed(2));
        //     console.log(`SPU=${spu}, Qty=${qty}, Base=${baseTotalValue}, Total=${totalValue}`);
        // });
        $(document)

            .on('change', '#itemquantity, #tradeDiscount, #GST', function () {

                let qty = Number($('#itemquantity').val()) || 0;
                const mrp = Number($('#itemppMRP').val()) || 0;
                const gst = Number($('#GST').val()) || 0;
                const tDis = Number($('#tradeDiscount').val()) || 0;
                const uFac = Number($('#unitFactor').val()) || 1;
                const spu = Number($('#spu').val()) || 1;
                const price = Number($('#companyPrice').val()) || 0;

                // Adjust qty based on SPU

                // 1️⃣ Total Amount
                $('#totalAmount').val((mrp * qty * uFac).toFixed(2));

                // 2️⃣ Company Price (already per-piece base × qty)
                const companyBase = Number($('#companyPrice').data('base')) || 0;
                const companyTotal = companyBase * qty;
                $('#companyPrice').val(companyTotal.toFixed(2));

                // 3️⃣ Trade Price
                let tradeTotal = companyTotal;   // ✅ DEFAULT (NO trade discount)

                if (tDis > 0) {
                    const discounted = mrp - (mrp * (tDis / 100));
                    const perPieceTrade = discounted + (discounted * (gst / 100));
                    tradeTotal = perPieceTrade * qty * uFac;
                }

                $('#tradePrice').val(tradeTotal.toFixed(2));

                // 4️⃣ Total Value with SPU logic
                debugger;
                const baseTotalValue = Number($('#totalValue').data('base')) || 0;
                const spuVal = Number($('#spu').val()) || 1;

                let effectiveQty = qty;
                if (spuVal > 1) {
                    effectiveQty = Math.ceil(qty / spuVal);
                }

                const totalValue = baseTotalValue * effectiveQty;


                $('#totalValue').val(totalValue.toFixed(2));

            });



        // 2) When item changes, pull DB values and reset user-entry fields
        $(document).on('change', '#itemid', function () {
            $('#tradeDiscount').val(''); // optional field
            fetchCompanyValues($(this).val());
        });


        // $('#tradeDiscount').on('keyup', function () {
        //     //debugger;
        //     const mrp = parseFloat($('#itemppMRP').val()) || 0;
        //     const tradeDiscount = parseFloat($(this).val()) || 0;
        //     let tradePrice;

        //     if (tradeDiscount > 0) {
        //         const discounted = mrp - (mrp * (tradeDiscount / 100));
        //         tradePrice = (discounted + (discounted * 0.18)) * uFac;
        //     } else {
        //         tradePrice = parseFloat($('#companyPrice').val()) || 0;
        //     }

        //     $('#tradePrice').val(tradePrice.toFixed(2));
        // });

        function mappMaterialPrice(
            mrp,
            gst,
            name,
            unitFactor,
            materialcode,
            materialimage,
            discount,
            companyPrice,   // NET PRICE
            totalValue,
            spu
        ) {
            mrp = Number(mrp) || 0;
            gst = Number(gst) || 18;
            unitFactor = Number(unitFactor) || 1;
            spu = Number(spu) || 1;

            $('#itemppMRP').val(mrp.toFixed(2));
            $('#GST').val(gst.toFixed(2));
            $('#selectedItemName').val(name);
            $('#unitFactor').val(unitFactor);
            $('#spu').val(spu);

            $('#itemarticleNo').val(materialcode);
            $('#itemimage').val(materialimage);

            // ✅ Company Price = Net Price (per piece)
            const companyBase = Number(companyPrice) || 0;
            $('#companyPrice')
                .val(companyBase.toFixed(2))
                .data('base', companyBase);

            $('#companyDiscount').val(discount ? Number(discount).toFixed(2) : '0.00');

            // 🔥🔥🔥 ADD THIS BLOCK (THIS IS THE FIX)
            const baseTotalValue = companyBase * spu;   // same as material.php
            $('#totalValue')
                .val(baseTotalValue.toFixed(2))
                .data('base', baseTotalValue)
                .data('spu', spu);
        }


        function resetMaterialFields() {
            $('#itemquantity').val("");
            $('#totalAmount').val("");
            $('#tradeDiscount').val("");
            $('#tradePrice').val("");

            $('#companyDiscount').val("");
            $('#companyPrice').val("").data('base', 0);
            $('#totalValue').val("").data('base', 0).data('spu', 1);
        }


        $('#Customer_table tbody').on('click', 'tr', function () {
            /* Get the row as a parent of the link that was clicked on */
            $('#editedcustomerCode').val(this.cells[0].innerHTML);
            $('#editedcustomerName').val(this.cells[1].innerHTML);
            $('#editedcustomerPhone').val(this.cells[6].innerHTML);
            $('#editedcustomerEmail').val(this.cells[7].innerHTML);
            $('#editedcustomerAddress').val(this.cells[8].innerHTML);
            $('#editedcustomerCity').val(this.cells[3].innerHTML);
            $('#editedcustomerState').val(this.cells[9].innerHTML);
            $('#editedcustomerDov').val(this.cells[2].innerHTML);
            $('#displayusername').text(this.cells[0].innerHTML);
            $('#displaycustomerName').text(this.cells[1].innerHTML);
            $('#displaycustomerPhone').text(this.cells[6].innerHTML);
            $('#displaycustomerEmail').text(this.cells[7].innerHTML);
            $('#displaycustomerAddress').text(this.cells[8].innerHTML);
            $('#displaycustomerCity').text(this.cells[3].innerHTML);
            $('#displaycustomerState').text(this.cells[9].innerHTML);
            $('#displaycustomerDov').text(this.cells[2].innerHTML);
            $('#quotecustomerName').val(this.cells[1].innerHTML);
            $('#quotecustomerPhone').val(this.cells[6].innerHTML);
            $('#quotecustomerEmail').val(this.cells[7].innerHTML);
            $('#quotecustomerAddress').val(this.cells[8].innerHTML);
            $('#quotecustomerCity').val(this.cells[3].innerHTML);
            $('#quotecustomerState').val(this.cells[9].innerHTML);
            $('#quotecustomerDov').val(this.cells[2].innerHTML);
            $('#quoteenqId').val(this.cells[10].innerHTML);
            $('#quotecustomerCode').val(this.cells[0].innerHTML);
            $('#opticustomerName').val(this.cells[1].innerHTML);
            $('#opticustomerPhone').val(this.cells[6].innerHTML);
            $('#opticustomerEmail').val(this.cells[7].innerHTML);
            $('#opticustomerAddress').val(this.cells[8].innerHTML);
            $('#opticustomerCity').val(this.cells[3].innerHTML);
            $('#opticustomerState').val(this.cells[9].innerHTML);
            $('#opticustomerDov').val(this.cells[2].innerHTML);
            $('#optienqId').val(this.cells[10].innerHTML);
            $('#opticustomerCode').val(this.cells[0].innerHTML);
            $('#editedSelectedCountry').val(this.cells[11].innerHTML);
            $('#displaycustomerCountry').text(this.cells[11].innerHTML);

        });

        $('#editedCustomer_form').submit(function (event) {
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/customerController.php/",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                console.log(data);
            });
        });


        $('#deleteUserModal').on('show.bs.modal', function (e) {
            // //debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#deletecustomerId').val(rowid);

        });

        $('#delete_customer_form').submit(function () {
            // //debugger;
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/customerController.php/",
                method: "POST",
                data: {
                    id: $('#deletecustomerId').val(),
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
        // ✅ Unified Trade Discount + Quantity + SPU logic
        // $(document).on('keyup change', '#itemquantity, #tradeDiscount, #GST', function () {
        //     const qty = Number($('#itemquantity').val()) || 0;
        //     const mrp = Number($('#itemppMRP').val()) || 0;
        //     const gst = Number($('#GST').val()) || 0;          // %
        //     const tDis = Number($('#tradeDiscount').val()) || 0; // %
        //     const uFac = Number($('#unitFactor').val()) || 1;

        //     // 1️⃣ Total Amount = MRP × Qty × UnitFactor
        //     $('#totalAmount').val((mrp * qty * uFac).toFixed(2));

        //     // 2️⃣ Company Price (total)
        //     const companyBase = Number($('#companyPrice').data('base')) || Number($('#companyPrice').val()) || 0;
        //     const companyTotal = qty > 0 ? companyBase * qty : companyBase;
        //     $('#companyPrice').val(companyTotal.toFixed(2));

        //     // 3️⃣ Trade Price (total)
        //     let perPieceTrade = companyBase;
        //     if (tDis > 0) {
        //         const discounted = mrp - (mrp * (tDis / 100));
        //         perPieceTrade = discounted + (discounted * (gst / 100));
        //     }
        //     const tradeTotal = perPieceTrade * (qty || 0);
        //     $('#tradePrice').val(tradeTotal.toFixed(2));

        //     // 4️⃣ Total Value based on SPU (ceil rule)
        //     // ✅ Safe SPU-based Total Value Calculation
        //     const baseTotalValue = Number($('#totalValue').data('base')) || 0;
        //     const qtyNow = Number($('#itemquantity').val()) || 0;
        //     const spu = Number($('#totalValue').data('spu')) || Number($('#itemSPU').val()) || 1; // fallback

        //     let totalValue = 0;

        //     if (spu > 0 && qty > 0) {
        //         totalValue = baseTotalValue * Math.ceil(qty / spu);
        //     } else {
        //         totalValue = baseTotalValue;
        //     }

        //     $('#totalValue').val(totalValue.toFixed(2));
        //     console.log(`SPU=${spu}, Qty=${qty}, Base=${baseTotalValue}, Total=${totalValue}`);

        // });

        // ✅ Prevent accidental recalculation when typing in Reference or Note fields
        $(document).on('focus', '#tradequoteReferencePrice, #quoteNote', function () {
            $(this).data('manual', true);
        });
        $(document).on('blur', '#tradequoteReferencePrice, #quoteNote', function () {
            $(this).data('manual', false);
        });

        $('#infoItemModal').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove();
            $('body').addClass('modal-open');
        });

        // ✅ Unified Save button handler — only keep this one
        $('#updateLineItemBtn').off('click').on('click', function () {
            const id = $('#editLineItemId').val();
            const itemquantity = $('#editItemQty').val();
            const tradeDiscount = $('#editTradeDiscount').val();
            const tradePrice = $('#editTradePrice').val();
            const quoteReference = $('#editQuoteRef').val();
            const quoteNote = $('#editNote').val();

            if (!id) {
                alert('⚠️ Missing Line Item ID — cannot update.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '../Controller/quotationController.php',
                data: {
                    action: 'update_lineitem',
                    id,
                    itemquantity,
                    tradeDiscount,
                    tradePrice,
                    quoteReference,
                    quoteNote
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('✅ Line item updated successfully!');

                        // Read the new values directly from the edit modal
                        const newRef = $('#editQuoteRef').val();
                        const newQty = $('#editItemQty').val();
                        const newDisc = $('#editTradeDiscount').val();
                        const newTP = parseFloat($('#editTradePrice').val() || 0).toFixed(2);

                        // Update the row cells in the quotation modal table
                        // Column index map in your table:
                        // 0: REF, 1: Image, 2: Type, 3: Code, 4: Name, 5: Quantity,
                        // 6: MRP, 7: GST, 8: Company Discount, 9: Trade Discount,
                        // 10: Total Amount, 11: Company Price, 12: Total Value, 13: Trade Price, 14: Action
                        if (ROW_BEING_EDITED && ROW_BEING_EDITED.length) {

                            const payload = ROW_BEING_EDITED.data('rowPayload') || {};

                            const mrp = Number(payload.mrp || 0);
                            const gst = Number(payload.gst || 0);
                            const unitFactor = Number(payload.unitFactor || 1);
                            const companyBase = Number(payload.companyBase || 0);   // ✅ per-piece base
                            const baseTotalValue = Number(payload.baseTotalValue || 0);  // ✅ base from DB
                            const spu = Number(payload.spu || 1);


                            const qty = Number(newQty || 0);
                            const tDis = Number(newDisc || 0);

                            // 1️⃣ Total Amount
                            const totalAmount = mrp * qty * unitFactor;

                            // 2️⃣ Company Price
                            const companyTotal = companyBase * qty;

                            // 3️⃣ Trade Price
                            let perPieceTrade = companyBase;
                            if (tDis > 0) {
                                const discounted = mrp - (mrp * (tDis / 100));
                                perPieceTrade = discounted + (discounted * (gst / 100));
                            }
                            const tradeTotal = perPieceTrade * qty * unitFactor;

                            // 4️⃣ Total Value (SPU logic)
                            let totalValue = 0;

                            if (spu > 0 && qty > 0) {
                                totalValue = baseTotalValue * Math.ceil(qty / spu);
                            } else {
                                totalValue = baseTotalValue * qty;
                            }


                            // 🔥 Update row cells
                            ROW_BEING_EDITED.find('td:eq(0)').text(newRef);                          // REF
                            ROW_BEING_EDITED.find('td:eq(5)').text(qty);                             // Quantity
                            ROW_BEING_EDITED.find('td:eq(9)').text(tDis.toFixed(2));                 // Trade Discount
                            ROW_BEING_EDITED.find('td:eq(10)').text(totalAmount.toFixed(2));         // Total Amount
                            ROW_BEING_EDITED.find('td:eq(11)').text(companyTotal.toFixed(2));        // Company Price
                            ROW_BEING_EDITED.find('td:eq(12)').text(totalValue.toFixed(2));          // Total Value
                            ROW_BEING_EDITED.find('td:eq(13)').text(tradeTotal.toFixed(2));          // Trade Price

                            // 🔥 Update payload stored in row
                            payload.qty = qty;
                            payload.tDis = tDis;
                            payload.tPri = tradeTotal;
                            payload.tAmt = totalAmount;
                            payload.cPri = companyTotal;
                            payload.tVal = totalValue;
                            payload.ref = newRef;
                            payload.note = quoteNote;

                            ROW_BEING_EDITED.data('rowPayload', payload);
                        }

                        // 🧩 Update stored payload data for Info modal
                        // 🧩 Update stored payload data for Info modal
                        const payload = ROW_BEING_EDITED.data('rowPayload') || {};
                        payload.ref = newRef;
                        payload.qty = Number(newQty);
                        payload.tDis = Number(newDisc);
                        payload.tPri = Number($('#editTradePrice').val() || 0);   // ← store as NUMBER
                        payload.note = $('#editNote').val();
                        ROW_BEING_EDITED.data('rowPayload', payload);


                        // 🧩 If Info modal is open, update its content live
                        if ($('#infoItemModal').hasClass('show')) {
                            $('#infoRef').val(payload.ref || '-');
                            $('#infoQty').val(payload.qty || '');
                            $('#infoTPrice').val(payload.tPri || '');
                            $('#infoNote').val(payload.note || '');
                        }


                        // Close only the edit modal, keep the quotation modal open
                        $('#editItemModal').modal('hide');
                        $('body').addClass('modal-open');

                        // Optional: recalc summary totals after change
                        recalcTotals();
                    } else {
                        alert('⚠️ ' + response.message);
                    }
                },


                error: function (xhr, status, error) {
                    console.error('❌ AJAX Error:', xhr.responseText);
                }
            });
        });




    });

    // 🧩 Fix Bootstrap nested modal recursion & focus trap
    (function ($) {
        // Disable Bootstrap’s recursive focus trap
        if ($.fn.modal && $.fn.modal.Constructor) {
            $.fn.modal.Constructor.prototype._enforceFocus = function () {
                // Completely disabled for nested modals
                return;
            };
        }

        // Fix z-index stacking for nested modals
        $(document).off('show.bs.modal.modalstack').on('show.bs.modal.modalstack', '.modal', function () {
            const openCount = $('.modal:visible').length;
            const zIndex = 1050 + (10 * openCount);
            $(this).css('z-index', zIndex);
            console.log(`🧱 Opening modal #${this.id} at zIndex=${zIndex}`);

            // Adjust backdrop
            setTimeout(() => {
                $('.modal-backdrop')
                    .not('.modal-stack')
                    .css('z-index', zIndex - 1)
                    .addClass('modal-stack')
                    .css('pointer-events', 'none'); // avoid click blocking
            }, 0);
        });

        // Keep body scroll fixed when multiple modals are open
        $(document).off('hidden.bs.modal.modalstack').on('hidden.bs.modal.modalstack', '.modal', function () {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

    })(jQuery);



</script>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.js"></script>