<?php
include('session.php');
require_once("../Utilities/permissionHelper.php");
include('customerNavigation.php');
require_once("../DB Operations/customerOps.php");
require_once("../Model/customerModel.php");
require_once("../Model/enq_cat_mappingmodel.php");
?>
<style>
    .table-responsive {
        overflow: visible !important;
    }

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
    .card-body #Customer_table th {
        font-weight: 500;
    }
</style>
<style>
    /* Collapse only for Quote Modal */
    #quoteModal.modal-collapsed .qm-body,
    #quoteModal.modal-collapsed .qm-footer {
        display: none;
    }

    #quoteModal.modal-collapsed .modal-dialog {
        max-width: 700px;
        transition: all .3s ease;
    }

    #quoteModal .modal-dialog {
        transition: all .3s ease;
    }

    #quoteModal.modal-collapsed .qm-header {
        border-radius: 12px;
    }

    /* Scoped to this modal only — won't leak into the rest of the app */
    #quoteModal .qm-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    #quoteModal .qm-header {
        background: linear-gradient(90deg, #6a5cf5 0%, #8a5cf0 100%);
        color: #fff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #quoteModal .qm-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.15rem;
    }

    #quoteModal .qm-header .btn-close {
        filter: invert(1) brightness(2);
        opacity: .9;
    }

    #quoteModal .qm-body {
        background: #f4f5fb;
        padding: 20px;
    }

    #quoteModal .qm-panel {
        background: #fff;
        border-radius: 10px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        height: 100%;
    }

    #quoteModal .qm-panel-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #333;
        font-size: 1rem;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #6a5cf5;
    }

    #quoteModal .qm-panel-title i {
        color: #6a5cf5;
    }

    #quoteModal .qm-toggle {
        background: none;
        border: none;
        padding: 0;
        color: #6a5cf5;
        font-size: .8rem;
        font-weight: 500;
        cursor: pointer;
        margin-left: auto;
    }

    #quoteModal .qm-field {
        margin-bottom: 14px;
    }

    #quoteModal .qm-field label {
        font-weight: 600;
        font-size: .82rem;
        color: #333;
        margin-bottom: 4px;
        display: block;
    }

    #quoteModal .qm-field label .text-danger {
        margin-left: 2px;
    }

    #quoteModal .qm-field .form-control,
    #quoteModal .qm-field .form-select {
        font-size: .85rem;
        border-radius: 6px;
        border: 1px solid #dcdfe6;
    }

    #quoteModal .qm-field .input-group-text {
        background: #f4f5fb;
        border: 1px solid #dcdfe6;
    }

    #quoteModal .qm-add-inline {
        border: 1px dashed #6a5cf5;
        color: #6a5cf5;
        background: #fff;
        border-radius: 6px;
        padding: 0 10px;
        margin-left: 6px;
    }

    #quoteModal .qm-items-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    #quoteModal .qm-items-header .qm-panel-title {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    #quoteModal .btn-add-item {
        border: 1px solid #6a5cf5;
        color: #6a5cf5;
        background: #fff;
        border-radius: 6px;
        font-size: .82rem;
        font-weight: 500;
        padding: 6px 14px;
    }

    #quoteModal .btn-add-item:hover {
        background: #6a5cf5;
        color: #fff;
    }

    #quoteModal .btn-clear-all {
        border: 1px solid #e5546b;
        color: #e5546b;
        background: #fff;
        border-radius: 6px;
        font-size: .82rem;
        font-weight: 500;
        padding: 6px 14px;
        margin-left: 8px;
    }

    #quoteModal .btn-clear-all:hover {
        background: #e5546b;
        color: #fff;
    }

    #quoteModal .qm-table-wrap {
        position: relative;
        overflow-x: auto;
        overflow-y: auto;
        border-radius: 8px;
        border: 1px solid #eee;
        height: 420px;
        /* fixed height so the scrollbar sits at the bottom edge */
    }

    #quoteModal #lineItemTable {
        margin-bottom: 0;
        height: 100%;
    }

    #quoteModal #lineItemTable thead th {
        background: #6a5cf5;
        color: #fff;
        font-size: .78rem;
        font-weight: 600;
        white-space: nowrap;
        border-color: #6a5cf5;
        vertical-align: middle;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    #quoteModal #lineItemTable tbody td {
        font-size: .82rem;
        vertical-align: middle;
    }

    /* Empty state now lives INSIDE the table area, centered over the
       (empty) tbody, instead of appearing as a separate block below it.
       Toggle this with #qmEmptyState.style.display in your existing
       "add row" / "clear all" JS. */
    #quoteModal .qm-empty-state {
        position: absolute;
        top: 46px;
        /* clears the sticky header */
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        color: #9aa0b4;
        pointer-events: none;
    }

    #quoteModal .qm-empty-state .qm-empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #f1eefe;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        color: #6a5cf5;
        font-size: 1.6rem;
    }

    #quoteModal .qm-empty-state strong {
        color: #555;
        display: block;
        font-size: .95rem;
    }

    #quoteModal .qm-empty-state span {
        font-size: .8rem;
    }

    #quoteModal .qm-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 16px;
        align-items: stretch;
    }

    #quoteModal .qm-sum-card {
        flex: 1;
        min-width: 130px;
        text-align: center;
        background: #f8f8fb;
        border-radius: 8px;
        padding: 10px 8px;
    }

    #quoteModal .qm-sum-card label {
        font-size: .68rem;
        text-transform: uppercase;
        font-weight: 600;
        color: #777;
        display: block;
        margin-bottom: 4px;
    }

    #quoteModal .qm-sum-card .val {
        font-weight: 700;
        color: #333;
        font-size: 1rem;
    }

    #quoteModal .qm-sum-card.qm-quote-value {
        background: #f1eefe;
        border: 1px solid #6a5cf5;
    }

    #quoteModal .qm-sum-card.qm-quote-value label {
        color: #6a5cf5;
    }

    #quoteModal .qm-sum-card.qm-quote-value input {
        font-weight: 700;
        color: #6a5cf5;
        text-align: center;
        border-color: #6a5cf5;
    }

    #quoteModal .qm-footer {
        background: #f4f5fb;
        padding: 14px 24px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    #quoteModal .qm-footer .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 8px 20px;
    }

    #quoteModal .btn-qm-close {
        background: #e5546b;
        border-color: #e5546b;
        color: #fff;
    }

    #quoteModal .btn-qm-save {
        background: #4a6cf7;
        border-color: #4a6cf7;
        color: #fff;
    }

    #quoteModal .btn-qm-create {
        background: #29b06b;
        border-color: #29b06b;
        color: #fff;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Customer Management</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-white"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 text-white" style="font-size: 1.2rem;">Customer
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
                        $quotes = DBcustomer::getQuotationSummaryByCustomer($customer->get_customerId());

                        $hasQuote = !empty($quotes);
                        ?>
                        <tr>
                            <td align="center"><?= $customer->getCustomerCode(); ?></td>
                            <td><?= $customer->get_customerName(); ?></td>
                            <td align="center"><?= $customer->get_customerDov(); ?></td>
                            <td align="center"><?= $customer->get_customerCity(); ?></td>

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
                                <div class="dropdown" >
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Actions
                                    </button>

                                    <div class="dropdown-menu">
                                        <?php if (hasActionPermission('customers', 'edit_customer')) { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#editCustomerModal" data-id="<?= $customer->get_customerId(); ?>"
                                                data-enqid="<?= trim($customer->get_enqId()); ?>">
                                                <i class="fas fa-user-edit"></i> Edit Customer
                                            </button>
                                        <?php } ?>

                                        <?php if (hasActionPermission('customers', 'customer_info')) { ?>

                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#infoCustomerModal" data-id="<?= $customer->get_customerId(); ?>">
                                                <i class="fas fa-info"></i> Customer Info
                                            </button>
                                        <?php } ?>

                                        <?php if (hasActionPermission('customers', 'designs')) { ?>
                                            <a class="btn btn-primary dropdown-item"
                                                href="design.php?id=<?= $customer->get_customerId(); ?>">
                                                <i class="fas fa-file-image"></i> Designs
                                            </a>
                                        <?php } ?>

                                        <?php if (hasActionPermission('customers', 'customer_inputs')) { ?>
                                            <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                data-target="#quoteModal" data-id="<?= $customer->get_customerId(); ?>">
                                                <i class="fas fa-edit"></i> Inputs
                                            </button>
                                        <?php } ?>



                                        <!-- <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#optiModal" data-id="<?= $customer->get_customerId(); ?>">
                                            <i class="fas fa-ankh"></i> Opti
                                        </button> -->

                                        <div class="dropdown-divider"></div>

                                        <?php if (hasActionPermission('customers', 'delete_customer')) { ?>
                                            <?php if ($hasQuote): ?>
                                                <button class="btn btn-danger dropdown-item disabled" disabled>Delete
                                                    Customer</button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-danger dropdown-item" data-toggle="modal"
                                                    data-target="#deleteUserModal" data-id="<?= $customer->get_customerId(); ?>">
                                                    Delete Customer
                                                </button>
                                            <?php endif; ?>
                                        <?php } ?>
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
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #editCustomerModal .ec-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    #editCustomerModal .ec-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #editCustomerModal .ec-header .ec-header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    #editCustomerModal .ec-header h4 {
        margin: 0;
        flex-grow: 1;
        font-weight: 600;
        font-size: 1.2rem;
    }

    #editCustomerModal .ec-header .close {
        color: #fff;
        opacity: .9;
        font-size: 1.6rem;
        font-weight: 400;
        text-shadow: none;
    }

    #editCustomerModal .ec-header .close:hover {
        opacity: 1;
    }

    #editCustomerModal .ec-body {
        background: #f4f5fb;
        padding: 20px;
    }

    #editCustomerModal .ec-panel {
        background: #fff;
        border-radius: 10px;
        padding: 18px 22px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        height: 100%;
    }

    #editCustomerModal .ec-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #4a3fbf;
        font-size: 1.02rem;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 2px solid #6a5cf5;
    }

    #editCustomerModal .ec-panel-title .ec-icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #ece9fd;
        color: #6a5cf5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
    }

    #editCustomerModal .ec-field-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }

    #editCustomerModal .ec-field-row label {
        width: 155px;
        flex-shrink: 0;
        text-align: right;
        font-weight: 600;
        color: #4a4a5a;
        font-size: .9rem;
        margin: 0;
    }

    #editCustomerModal .ec-field-row label .text-danger {
        margin-left: 2px;
    }

    #editCustomerModal .ec-field-row .ec-field-input {
        flex-grow: 1;
    }

    #editCustomerModal .ec-field-row .form-control,
    #editCustomerModal .ec-field-row .form-select {
        border-radius: 8px;
        border: 1px solid #dcdfe6;
        font-size: .9rem;
        padding: 9px 12px;
    }

    #editCustomerModal .ec-field-row .form-control[readonly] {
        background: #f0eefe;
        color: #6a5cf5;
    }

    /* ---- Looking For list ---- */
    #editCustomerModal .ec-interest-wrap {
        max-height: 460px;
        overflow-y: auto;
    }

    #editCustomerModal #editCustomerInterestList {
        display: flex;
        flex-direction: column;
    }

    /* Best-effort styling for whatever checkbox markup your JS generates
       inside #editCustomerInterestList. Covers plain <label><input> pairs
       and Bootstrap .form-check markup. If your JS uses different classes,
       tell me the generated HTML and I'll tighten these selectors. */
    #editCustomerModal #editCustomerInterestList>* {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 4px;
        border-bottom: 1px solid #f0f0f5;
        font-size: .95rem;
        color: #333;
        pointer-events: auto;
    }

    #editCustomerModal #editCustomerInterestList>*:last-child {
        border-bottom: none;
    }

    #editCustomerModal #editCustomerInterestList input[type="checkbox"] {
        all: revert !important;
        /* wipe out any global appearance:none / width:0 reset fighting us */
        -webkit-appearance: checkbox !important;
        appearance: checkbox !important;
        display: inline-block !important;
        width: 20px !important;
        height: 20px !important;
        min-width: 20px !important;
        margin: 0 !important;
        opacity: 1 !important;
        position: static !important;
        pointer-events: auto !important;
        accent-color: #4a6cf7 !important;
        cursor: pointer !important;
        flex-shrink: 0 !important;
        vertical-align: middle !important;
    }

    #editCustomerModal #editCustomerInterestList input[type="checkbox"]:disabled {
        cursor: not-allowed !important;
        opacity: .6 !important;
    }

    #editCustomerModal #editCustomerInterestList label {
        margin: 0;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #editCustomerModal #editCustomerInterestList input[type="checkbox"]:disabled+label,
    #editCustomerModal #editCustomerInterestList *:has(input[type="checkbox"]:disabled) label {
        color: #a8a8c0;
    }

    /* Lock icon: add class="ec-locked" (or data-locked="true") from your JS
       on any row that should show the padlock, e.g.:
       <div class="ec-locked"><input ...><label>Sliding Wardrobe</label></div> */
    #editCustomerModal .ec-locked::after {
        content: "\f023";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #f0a020;
        margin-left: auto;
        font-size: .85rem;
    }

    #editCustomerModal .ec-footer {
        background: #fff;
        padding: 14px 24px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #eee;
    }

    #editCustomerModal .ec-footer .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 9px 22px;
    }

    #editCustomerModal .btn-ec-save {
        background: #29b06b;
        border-color: #29b06b;
        color: #fff;
    }

    #editCustomerModal .btn-ec-close {
        background: #e5546b;
        border-color: #e5546b;
        color: #fff;
    }
</style>

<div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" id="editedCustomer_form" enctype="multipart/form-data">
            <div class="modal-content ec-content">

                <!-- ===== Header ===== -->
                <div class="ec-header">
                    <div class="ec-header-icon"><i class="fas fa-user"></i></div>
                    <h4 id="modal_title">Edit Customer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="ec-body">
                    <span id="form_message"></span>

                    <div class="row g-3">
                        <!-- ===== LEFT: Customer Information ===== -->
                        <div class="col-lg-7">
                            <div class="ec-panel">
                                <div class="ec-panel-title">
                                    <span class="ec-icon-badge"><i class="fas fa-user"></i></span>
                                    Customer Information
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerCode">Customer Id <span
                                            class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <input type="text" class="form-control" id="editedcustomerCode"
                                            name="customerCode" readonly>
                                    </div>
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerName">Name <span class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <input type="text" class="form-control" id="editedcustomerName"
                                            name="customerName">
                                        <input type="hidden" name="customerId" id="editedcustomerId" value="">
                                    </div>
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerDov">Date of Enquiry. <span
                                            class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <input type="date" class="form-control" id="editedcustomerDov"
                                            name="customerDov">
                                    </div>
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerEmail">Email <span class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <input type="email" class="form-control" id="editedcustomerEmail"
                                            name="customerEmail">
                                    </div>
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerPhone">Mobile <span class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <input type="text" class="form-control" id="editedcustomerPhone"
                                            name="customerPhone">
                                    </div>
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerAddress">Address line <span
                                            class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <input type="text" class="form-control" id="editedcustomerAddress"
                                            placeholder="1234 Main St" name="customerAddress">
                                    </div>
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerCity">City <span class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <input type="text" class="form-control" id="editedcustomerCity"
                                            name="customerCity">
                                    </div>
                                </div>

                                <div class="ec-field-row">
                                    <label for="editedcustomerState">State <span class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <select id="editedcustomerState" name="customerState" class="form-select"
                                            required>
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

                                <div class="ec-field-row">
                                    <label for="editedSelectedCountry">Country <span
                                            class="text-danger">*</span></label>
                                    <div class="ec-field-input">
                                        <select id="editedSelectedCountry" name="SelectedCountry" class="form-select">
                                            <!-- <option value="">Select Country</option> -->
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                                <input type="hidden" id="editedEnqId" name="editedEnqId">
                            </div>
                        </div>

                        <!-- ===== RIGHT: Looking For ===== -->
                        <div class="col-lg-5">
                            <div class="ec-panel">
                                <div class="ec-panel-title">
                                    <span class="ec-icon-badge"><i class="fas fa-tags"></i></span>
                                    Looking For
                                </div>
                                <div class="ec-interest-wrap">
                                    <div id="editCustomerInterestList">
                                        <!-- populated by your existing JS — untouched -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== Footer ===== -->
                <div class="ec-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <button type="submit" name="submit" id="editCustomer" value="Save" class="btn btn-ec-save">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <button type="button" class="btn btn-ec-close" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<style>
    #infoCustomerModal .ic-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    #infoCustomerModal .ic-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    #infoCustomerModal .ic-header .ic-header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    #infoCustomerModal .ic-header h4 {
        margin: 0;
        flex-grow: 1;
        font-weight: 600;
        font-size: 1.2rem;
    }

    #infoCustomerModal .ic-header .close {
        color: #fff;
        opacity: .9;
        font-size: 1.6rem;
        font-weight: 400;
        text-shadow: none;
    }

    #infoCustomerModal .ic-header .close:hover {
        opacity: 1;
    }

    #infoCustomerModal .ic-body {
        background: #f4f5fb;
        padding: 20px;
    }

    #infoCustomerModal .ic-panel {
        background: #fff;
        border-radius: 10px;
        padding: 18px 22px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        margin-bottom: 18px;
    }

    #infoCustomerModal .ic-panel:last-child {
        margin-bottom: 0;
    }

    #infoCustomerModal .ic-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #4a3fbf;
        font-size: 1.02rem;
        margin-bottom: 4px;
        padding-bottom: 12px;
        border-bottom: 2px solid #6a5cf5;
    }

    #infoCustomerModal .ic-panel-title .ic-icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #ece9fd;
        color: #6a5cf5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
    }

    #infoCustomerModal .ic-toggle {
        margin-left: auto;
        background: none;
        border: none;
        color: #6a5cf5;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
    }

    #infoCustomerModal .ic-detail-row {
        display: flex;
        align-items: center;
        padding: 12px 4px;
        border-bottom: 1px solid #f0f0f5;
    }

    #infoCustomerModal .ic-detail-row:last-child {
        border-bottom: none;
    }

    #infoCustomerModal .ic-detail-row label {
        width: 220px;
        flex-shrink: 0;
        margin: 0;
        color: #6b6b7b;
        font-size: .92rem;
        font-weight: 500;
    }

    #infoCustomerModal .ic-detail-row .ic-value {
        margin: 0;
        font-weight: 600;
        color: #2d2d3a;
        font-size: 1rem;
    }

    #infoCustomerModal .ic-table-wrap {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    #infoCustomerModal #quotationdetails_table {
        margin-bottom: 0;
    }

    #infoCustomerModal #quotationdetails_table thead th {
        background: #ece9fd;
        color: #4a3fbf;
        font-size: .82rem;
        font-weight: 700;
        white-space: nowrap;
        border-color: #ece9fd;
        text-align: center;
        vertical-align: middle;
        padding: 12px 10px;
    }

    #infoCustomerModal #quotationdetails_table tbody td {
        font-size: .9rem;
        color: #2d2d3a;
        text-align: center;
        vertical-align: middle;
        padding: 12px 10px;
    }

    /* Best-effort status badge styling. Have your JS add class="ic-status-approved"
       or class="ic-status-pending" (etc.) on the status cell's inner element when
       it renders each row, and these will pick up the pill look automatically.
       See comment block at bottom for details / how to adjust. */
    #infoCustomerModal .ic-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: .8rem;
        font-weight: 600;
        color: #fff;
    }

    #infoCustomerModal .ic-status-approved {
        background: #29b06b;
    }

    #infoCustomerModal .ic-status-pending {
        background: #f0a020;
    }

    #infoCustomerModal .ic-status-rejected {
        background: #e5546b;
    }

    #infoCustomerModal .ic-footer {
        background: #fff;
        padding: 14px 24px;
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid #eee;
    }

    #infoCustomerModal .ic-footer .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 9px 22px;
    }

    #infoCustomerModal .btn-ic-close {
        background: #e5546b;
        border-color: #e5546b;
        color: #fff;
    }
</style>

<div class="modal fade" id="infoCustomerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ic-content">

            <!-- ===== Header ===== -->
            <div class="ic-header">
                <div class="ic-header-icon">
                    <i class="fas fa-user"></i>
                </div>

                <h4 id="modal_title">
                    Customer Info - 
                    <span id="displaycustomerNameHeader" class="customer-name"></span>
                </h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="ic-body">

                <!-- ===== Customer Details (collapsible) ===== -->
                <div class="ic-panel">
                    <div class="ic-panel-title">
                        <span class="ic-icon-badge"><i class="fas fa-user"></i></span>
                        Customer Details
                        <button type="button" class="ic-toggle" id="toggleCustomerDetails" data-toggle="collapse"
                            data-target="#customerDetailsCollapse" aria-expanded="true"
                            aria-controls="customerDetailsCollapse">Hide</button>
                    </div>

                    <div id="customerDetailsCollapse" class="collapse show">
                        <input type="hidden" id="customerId" name="customerId" value="">

                        <div class="ic-detail-row">
                            <label for="displayusername">Customer Id</label>
                            <h5 class="ic-value" id="displayusername"></h5>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerName">Name</label>
                            <h5 class="ic-value" id="displaycustomerName"></h5>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerDov">Date Of Enquiry</label>
                            <p class="ic-value" id="displaycustomerDov"></p>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerEmail">Email</label>
                            <p class="ic-value" id="displaycustomerEmail"></p>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerPhone">Mobile Number</label>
                            <p class="ic-value" id="displaycustomerPhone"></p>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerAddress">Address</label>
                            <p class="ic-value" id="displaycustomerAddress"></p>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerCity">City</label>
                            <p class="ic-value" id="displaycustomerCity"></p>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerState">State</label>
                            <p class="ic-value" id="displaycustomerState"></p>
                        </div>
                        <div class="ic-detail-row">
                            <label for="displaycustomerCountry">Country</label>
                            <p class="ic-value" id="displaycustomerCountry"></p>
                        </div>
                    </div>
                </div>

                <!-- ===== Quotation History ===== -->
                <div class="ic-panel">
                    <div class="ic-panel-title">
                        <span class="ic-icon-badge"><i class="fas fa-file-invoice"></i></span>
                        Quotation History
                    </div>
                    <div class="ic-table-wrap">
                        <table class="table table-bordered mb-0" id="quotationdetails_table" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Quote Id</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Quote Value</th>
                                    <th>Quote Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- rows injected here by your existing JS — untouched -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- ===== Footer ===== -->
            <div class="ic-footer">
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <button type="button" class="btn btn-ic-close" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    // Flips the "Hide"/"Show" label on the Customer Details toggle.
    // Purely cosmetic — doesn't touch any of your existing logic.
    (function () {
        var btn = document.getElementById('toggleCustomerDetails');
        var section = document.getElementById('customerDetailsCollapse');
        if (!btn || !section) return;
        btn.addEventListener('click', function () {
            setTimeout(function () {
                var isOpen = section.classList.contains('show');
                btn.textContent = isOpen ? 'Hide' : 'Show';
            }, 0);
        });
    })();
</script>


<div class="modal fade" id="quoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" id="quote_form" enctype="multipart/form-data">
            <div class="modal-content qm-content">

                <!-- ===== Header ===== -->
                <div class="qm-header">
                    <h5 id="exampleModalLabel">Add Quotation Details</h5>

                    <div class="d-flex align-items-center">

                        <!-- Collapse -->
                        <button type="button" class="btn btn-sm btn-light mr-2" id="quoteCollapseBtn" title="Collapse">
                            <i class="fas fa-compress-alt"></i>
                        </button>

                        <!-- Close -->
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        </button>

                    </div>
                </div>

                <div class="qm-body">
                    <div class="row g-3">

                        <!-- ===== LEFT: Customer + Quotation Information ===== -->
                        <div class="col-lg-5">
                            <div class="qm-panel">

                                <!-- Customer Details kept fully intact, collapsed by default to match the
                                     screenshot's single-panel look (all original fields/ids preserved) -->
                                <div class="qm-panel-title">
                                    <i class="fas fa-user"></i> Customer Details
                                    <button type="button" class="qm-toggle" data-toggle="collapse"
                                        data-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">Show / Hide</button>
                                </div>
                                <div id="flush-collapseOne" class="collapse">
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-12 qm-field">
                                            <label for="quotecustomerCode">Customer Id</label>
                                            <input id="quotecustomerCode" name="customerCode" class="form-control"
                                                required readonly />
                                        </div>
                                        <div class="col-md-8 qm-field">
                                            <label for="quotecustomerName">Name</label>
                                            <input type="text" class="form-control" id="quotecustomerName"
                                                name="customerName" readonly>
                                            <input type="hidden" class="form-control" id="quoteenqId" name="enqId" />
                                            <input type="hidden" class="form-control" id="quotecustomerId"
                                                name="customerId" />
                                        </div>
                                        <div class="col-md-4 qm-field">
                                            <label for="quotecustomerDov">Date of Enquiry</label>
                                            <input type="date" class="form-control" id="quotecustomerDov"
                                                name="customerDov" readonly>
                                        </div>
                                        <div class="col-md-8 qm-field">
                                            <label for="quotecustomerEmail">Email</label>
                                            <input type="email" class="form-control" id="quotecustomerEmail"
                                                name="customerEmail" readonly>
                                        </div>
                                        <div class="col-md-4 qm-field">
                                            <label for="quotecustomerPhone">Mobile</label>
                                            <input type="text" class="form-control" id="quotecustomerPhone"
                                                name="customerPhone" readonly>
                                        </div>
                                        <div class="col-md-6 qm-field">
                                            <label for="quotecustomerAddress">Address line</label>
                                            <input type="text" class="form-control" id="quotecustomerAddress"
                                                name="customerAddress" readonly>
                                        </div>
                                        <div class="col-md-3 qm-field">
                                            <label for="quotecustomerCity">City</label>
                                            <input type="text" class="form-control" id="quotecustomerCity"
                                                name="customerCity" readonly>
                                        </div>
                                        <div class="col-md-3 qm-field">
                                            <label for="quotecustomerState">State</label>
                                            <input id="quotecustomerState" name="customerState" class="form-control"
                                                required readonly />
                                        </div>

                                        <input type="hidden" name="createdby" id="createdby" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control"
                                            required data-parsley-type="integer" data-parsley-minlength="10"
                                            data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                            value="<?php echo $_SESSION['login_user']; ?>" />
                                    </div>
                                </div>

                                <div class="qm-panel-title">
                                    <i class="fas fa-file-invoice"></i> Quotation Information
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-6 qm-field">
                                        <label>Quotation Type <span class="text-danger">*</span></label>
                                        <select id="quoteType" class="form-select" required name="quoteType">
                                            <option value='General'>General</option>
                                            <option value='Bank'>Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Quotation For <span class="text-danger">*</span></label>
                                        <select id="enqCategory" class="form-select" required
                                            name="enqCategory"></select>
                                        <input type="hidden" name="encatName" id="encatName" class="form-control"
                                            value="" />
                                    </div>

                                    <div class="col-md-6 qm-field">
                                        <label>Input Type <span class="text-danger">*</span></label>
                                        <select id="inputType" class="form-select" required name="inputType"></select>
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Brand <span class="text-danger">*</span></label>
                                        <select id="brand" class="form-select" required name="brand"></select>
                                    </div>

                                    <div class="col-md-6 qm-field d-flex align-items-end">
                                        <div class="flex-grow-1">
                                            <label>Category Name <span class="text-danger">*</span></label>
                                            <select id="itemCategory" class="form-select" required
                                                name="itemCategory"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 qm-field d-flex align-items-end">
                                        <div class="flex-grow-1">
                                            <label>Sub Category Name <span class="text-danger">*</span></label>
                                            <select id="itemsubCategory" class="form-select" required
                                                name="itemsubCategory"></select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 qm-field">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <select id="itemid" class="form-select" required name="itemid"></select>
                                        <input type="hidden" name="selectedItemName" id="selectedItemName"
                                            class="form-control" value="" />
                                        <input type="hidden" name="unitFactor" id="unitFactor" class="form-control"
                                            value="" />
                                        <input type="hidden" name="spu" id="spu" class="form-control" value="" />
                                        <input type="hidden" name="itemarticleNo" id="itemarticleNo"
                                            class="form-control" value="" />
                                        <input type="hidden" name="itemimage" id="itemimage" class="form-control"
                                            value="" />
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Quantity <span class="text-danger">*</span></label>
                                        <input type="text" name="itemquantity" id="itemquantity" class="form-control" />
                                    </div>

                                    <div class="col-md-6 qm-field">
                                        <label>Per piece MRP <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            <input type="text" name="itemppMRP" id="itemppMRP" class="form-control"
                                                required readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Total Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            <input type="text" name="totalAmount" id="totalAmount" class="form-control"
                                                required readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-6 qm-field">
                                        <label>Company Discount</label>
                                        <div class="input-group">
                                            <input type="text" name="companyDiscount" id="companyDiscount"
                                                class="form-control" readonly />
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Company Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            <input type="text" name="companyPrice" id="companyPrice"
                                                class="form-control" readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-6 qm-field">
                                        <label>Trade Discount</label>
                                        <div class="input-group">
                                            <input type="text" name="tradeDiscount" id="tradeDiscount"
                                                class="form-control" />
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Trade Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            <input type="text" name="tradePrice" id="tradePrice" class="form-control"
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-6 qm-field">
                                        <label>GST <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="GST" id="GST" class="form-control" required
                                                readonly />
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            <input type="hidden" name="GSTAmount" id="GSTAmount" class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Total Value <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            <input type="text" name="totalValue" id="totalValue" class="form-control"
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-6 qm-field">
                                        <label>Reference</label>
                                        <input type="text" name="quoteReference" id="tradequoteReferencePrice"
                                            class="form-control" placeholder="Enter reference" />
                                    </div>
                                    <div class="col-md-6 qm-field">
                                        <label>Note</label>
                                        <input type="text" name="quoteNote" id="quoteNote" class="form-control"
                                            placeholder="Enter note" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== RIGHT: Quotation Items ===== -->
                        <div class="col-lg-7">
                            <div class="qm-panel">
                                <div class="qm-items-header">
                                    <div class="qm-panel-title"><i class="fas fa-clipboard-list"></i> Quotation Items
                                    </div>
                                    <div>
                                        <!-- This is your original "Add" button (id="createQuote") — same id,
                                             same behavior, just relocated + relabeled to match the screenshot -->
                                        <button type="button" class="btn btn-add-item" id="createQuote">
                                            <i class="fas fa-plus"></i> Add Item
                                        </button>
                                        <!-- New button, not wired to any existing logic. Hook this up to
                                             whatever clears #lineItemTable tbody if/when you want it live. -->

                                    </div>
                                </div>

                                <div class="qm-table-wrap">
                                    <table class="table table-bordered mb-0" id="lineItemTable" width="100%"
                                        cellspacing="0">
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
                                            <!-- rows injected here by your existing JS — untouched -->
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>

                                    <!-- Empty-state placeholder — now sits inside the table area itself.
                                         Show/hide this with your existing JS based on whether #lineItemTable
                                         tbody has rows: document.getElementById('qmEmptyState').style.display
                                         = hasRows ? 'none' : 'flex'; -->

                                </div>

                                <div class="qm-summary">
                                    <div class="qm-sum-card">
                                        <label>Sum Total Amount</label>
                                        <input type="text" id="sumTotalAmount" name="sumTotalAmount"
                                            class="form-control text-center fw-bold border-0 bg-transparent p-0"
                                            readonly>
                                    </div>
                                    <div class="qm-sum-card">
                                        <label>Sum Company Price</label>
                                        <input type="text" id="sumCompanyPrice" name="sumCompanyPrice"
                                            class="form-control text-center fw-bold border-0 bg-transparent p-0"
                                            readonly>
                                    </div>
                                    <div class="qm-sum-card">
                                        <label>Sum Total Value</label>
                                        <input type="text" id="sumTotalValue" name="sumTotalValue"
                                            class="form-control text-center fw-bold border-0 bg-transparent p-0"
                                            readonly>
                                    </div>
                                    <div class="qm-sum-card">
                                        <label>Sum Trade Price</label>
                                        <input type="text" id="sumTradeValue" name="sumTradeValue"
                                            class="form-control text-center fw-bold border-0 bg-transparent p-0"
                                            readonly>
                                    </div>
                                    <div class="qm-sum-card qm-quote-value">
                                        <label>Quote Value</label>
                                        <input type="text" id="quoteValue" name="quoteValue"
                                            class="form-control text-center fw-bold">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ===== Footer ===== -->
                <div class="qm-footer">
                    <button type="submit" class="btn btn-qm-create" id="submitQuoteBtn">Create Quote</button>
                    <button type="button" class="btn btn-qm-close btn-danger" data-dismiss="modal">Close</button>
                    <!-- New button, not wired to any existing logic yet -->
                    <!-- Your original submit button, same purpose (submits #quote_form) -->

                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=optiModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quotation Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                                    data-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Customer Details
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
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
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                                    data-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Opti Details
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-parent="#accordionFlushExample">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="">Add Item</button>
                    <button type="submit" class="btn btn-primary" id="">Create Quote</button>
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
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="infoItemModal" tabindex="-1" data-backdrop="false" data-keyboard="true" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title">Item Info/Material Info</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                <button class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">Edit Item/Material</h6>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
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
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary btn-sm" id="updateLineItemBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let ROW_BEING_EDITED = null;

        var select = document.getElementById("editedSelectedCountry");

        // var countries = new Array("Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antarctica",
        //     "Antigua and Barbuda",
        //     "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
        //     "Barbados", "Belarus", "Belgium", "Belize",
        //     "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei",
        //     "Bulgaria",
        //     "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde",
        //     "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros",
        //     "Congo, Democratic Republic", "Congo, Republic of the",
        //     "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
        //     "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt",
        //     "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France",
        //     "Gabon",
        //     "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guatemala",
        //     "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong",
        //     "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq",
        //     "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
        //     "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho",
        //     "Liberia", "Libya",
        //     "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia",
        //     "Maldives", "Mali",
        //     "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova",
        //     "Mongolia", "Morocco", "Monaco", "Mozambique",
        //     "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua",
        //     "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Panama", "Papua New Guinea", "Paraguay", "Peru",
        //     "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia",
        //     "Rwanda", "Samoa", "San Marino", " Sao Tome", "Saudi Arabia", "Senegal", "Serbia and Montenegro",
        //     "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia",
        //     "Solomon Islands", "Somalia", "South Africa", "Spain", "Sri Lanka", "Sudan", "Suriname",
        //     "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand",
        //     "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
        //     "Turkmenistan", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom",
        //     "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia",
        //     "Zimbabwe");
        var countries = new Array("India");

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
            debugger;
            const f = $('#quote_form').serializeJSON();
            console.log(f);

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
            const selectedName = $('#itemid option:selected').text();

            $tr.append(
                $('<td/>').text(selectedName)
            );

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
            f.id = rowId;   // 🔥 VERY IMPORTANT — store ID inside customers array
            const rowPayload = {
                id: rowId,
                typeText,
                code: f['itemarticleNo'] || '',
                name: selectedName,
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
            const $btn = $('<button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions</button>');
            const $menu = $('<ul class="dropdown-menu dropdown-menu-end"></ul>');

            // Info
            // Info
            const $info = $('<a class="dropdown-item" href="#" data-toggle="modal" data-target="#infoItemModal">Info</a>')
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

        $(document).on('click', '.dropdown-item[data-target="#infoItemModal"]', function (e) {
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

            const MRP = Number(payload.mrp || 0);
            const GST = Number(payload.gst || 0);

            const companyBase = Number(payload.companyBase || 0);
            const unitFactor = Number(payload.unitFactor || 1);

            $('#editItemQty, #editTradeDiscount')
                .off('keyup change')
                .on('keyup change', function () {

                    const qty = Number($('#editItemQty').val()) || 0;
                    const tDis = Number($('#editTradeDiscount').val()) || 0;

                    let tradeTotal;

                    // ✅ No discount → Company Price
                    if (tDis <= 0) {

                        tradeTotal = companyBase * qty;

                    } else {

                        const discounted = MRP - (MRP * tDis / 100);

                        const perPieceTrade =
                            discounted + (discounted * GST / 100);

                        tradeTotal = perPieceTrade * qty * unitFactor;
                    }

                    $('#editTradePrice').val(tradeTotal.toFixed(2));

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

                    let status = value.quoteStatus;

                    let badge = '';

                    if (status === 'Approved') {
                        badge = '<span class="badge bg-success">Approved</span>';
                    } else if (status === 'Pending') {
                        badge = '<span class="badge bg-warning text-dark">Pending</span>';
                    } else if (status === 'Rejected') {
                        badge = '<span class="badge bg-danger">Rejected</span>';
                    }

                    $('#quotationdetails_table tr:last')
                        .append($('<td/>').html(badge));


                });
                console.log(data);
            });
        });

        $('#quote_form').submit(function (event) {
            debugger;
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
                "/Admin/Controller/product_SubcategoryController.php/?productcatid=" +
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
                "/Admin/Controller/productDefinitionController.php/?catId=" + catId + "&subcatId=" +
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
                "/Admin/Controller/materialController.php/?thicknessId=" +
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

            const button = $(e.relatedTarget);

            // ✅ FIX
            const enqIdFromBtn = button.data('enqid');
            $('#editedEnqId').val(enqIdFromBtn);

            const enqId = $('#editedEnqId').val();

            console.log("CORRECT ENQ ID:", enqId);

            let isQuoteGenerated = false;
            let quotedCategories = []; // ✅ OUTSIDE

            $.ajax({
                url: "../Controller/quotationController.php",
                type: "GET",
                data: { checkQuoteByEnq: enqId },
                async: false,

                success: function (res) {
                    quotedCategories = res;   // ✅ already array
                }
            });
            console.log("TYPE:", typeof quotedCategories);
            console.log("DATA:", quotedCategories);
            console.log("BUTTON ENQ ID:", enqId);
            console.log("QUOTE (attr):", $(e.relatedTarget).attr('data-quote'));
            console.log("RAW:", button.data('quote'));
            console.log("TYPE:", typeof button.data('quote'));
            console.log("FINAL:", isQuoteGenerated);

            const customerId = button.data('id');
            $('#editedcustomerId').val(customerId);

            // ✅ FIXED LINE

            $.getJSON("../Controller/enqcategoryController.php?type=enquiry", function (categories) {

                $('#editCustomerInterestList').empty();

                $.getJSON("../Controller/enqcategorymappingController.php?enq_id=" + enqId, function (selected) {

                    const selectedIds = selected.map(x => String(x.catId));

                    categories.forEach(cat => {

                        const catId = String(cat.CatId);
                        const isChecked = selectedIds.includes(catId);

                        // 🔥 ONLY disable if THIS category has quote
                        const shouldDisable = quotedCategories.includes(catId);

                        const html = `
<div class="form-check">
    <input class="form-check-input"
           type="checkbox"
           name="interest_list[]"
           value="${catId}"
           ${isChecked ? 'checked' : ''}
           ${shouldDisable ? 'disabled' : ''}>

    ${shouldDisable ? `<input type="hidden" name="interest_list[]" value="${catId}">` : ''}

    <label class="form-check-label">${cat.catname} ${shouldDisable ? '🔒' : ''}</label>
</div>`;

                        $('#editCustomerInterestList').append(html);
                    });
                });
            });
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
                "/Admin/Controller/enqcategorymappingController.php?enq_id=" + $(
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

            // 🔥 LOAD EXISTING LINE ITEMS (WITH REF & NOTE)
            const quoteId = $('#quoteenqId').val(); // ⚠️ confirm this is your quoteId

            $.getJSON(
                config.developmentPath + "/Admin/Controller/lineItemController.php?quoteId=" + quoteId,
                function (data) {

                    if (!data || !data.length) return;

                    $('#lineItemTable tbody').empty();

                    data.forEach(function (item) {

                        const ref = item.reference || '-';
                        const note = item.note || '';

                        const $tr = $('<tr/>');

                        // REF
                        $tr.append($('<td/>').text(ref));

                        // IMAGE
                        $tr.append(
                            $('<td/>').append(
                                $('<img/>', {
                                    src: "../uploads/" + item.image,
                                    width: "70",
                                    height: "70"
                                })
                            )
                        );

                        $tr.append($('<td/>').text(item.Type));
                        $tr.append($('<td/>').text(item.lineItemId)); // or correct code field if needed
                        $tr.append($('<td/>').text(item.Name));
                        $tr.append($('<td/>').text(item.quantity));
                        $tr.append($('<td/>').text(item.mrp));
                        $tr.append($('<td/>').text(item.gst));
                        $tr.append($('<td/>').text(item.companyDiscount));
                        $tr.append($('<td/>').text(item.tradeDiscount));
                        $tr.append($('<td/>').text(item.totalAmount));
                        $tr.append($('<td/>').text(item.companyPrice));
                        $tr.append($('<td/>').text(item.totalValue));
                        $tr.append($('<td/>').text(item.tradePrice));

                        // 🔥 VERY IMPORTANT (for edit/info to work)
                        const payload = {
                            id: item.lineItemId,
                            ref: ref,
                            note: note,
                            qty: item.quantity,
                            tAmt: item.totalAmount,
                            cPri: item.companyPrice,
                            tVal: item.totalValue,
                            tPri: item.tradePrice,
                            mrp: item.mrp,
                            gst: item.gst,
                            tDis: item.tradeDiscount,
                            unitFactor: item.unitFactor,
                            spu: item.spu,
                            companyBase: item.companyPrice,
                            baseTotalValue: item.totalValue,
                            img: "../uploads/" + item.image
                        };

                        $tr.data('rowPayload', payload);

                        $tr.append($('<td/>').append(makeActionDropdown(payload)));

                        $('#lineItemTable tbody').append($tr);
                    });

                    recalcTotals();
                }
            );
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

            $.getJSON(
                config.developmentPath + "/Admin/Controller/item_detailscontroller.php?infoitemid=" + itemId,
                function (data) {

                    if (!data || !data.length) return;

                    const r = data[0];

                    $('#selectedItemName').val(r.itemname || '');
                    $('#itemarticleNo').val(r.itemcode || '');
                    // ✅ ADD THIS (VERY IMPORTANT)
                    $('#itemimage').val(r.itemimage);

                    const mrp = parseFloat(r.itemMRP || 0);
                    const gst = parseFloat(r.itemGST || 18);
                    const cDisc = parseFloat(r.itemDiscount || 0);
                    const cPrice = parseFloat(r.itemPrice || 0);
                    const tVal = parseFloat(r.itemTotalValue || 0);
                    const spu = parseFloat(r.spu || 0);
                    const uFact = parseFloat(r.unitfactor || r.unitFactor || 1);
                    console.log("API unitfactor:", r.unitfactor, "unitFactor:", r.unitFactor);

                    $('#unitFactor').val(uFact);
                    $('#spu').val(spu.toFixed(2));
                    $('#itemppMRP').val(mrp.toFixed(2));
                    $('#GST').val(gst.toFixed(2));
                    $('#companyDiscount').val(cDisc.toFixed(2));
                    $('#companyPrice').val(cPrice.toFixed(2));
                    $('#totalValue').val(tVal.toFixed(2));

                    $('#totalValue').data('base', tVal);
                    $('#totalValue').data('spu', spu);

                    $('#companyPrice').data('base', cPrice);
                    $('#tradePrice').val(cPrice.toFixed(2));
                }
            );
        }
        console.log("Item Image Field:", $('#itemimage').val());

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
                let uFac = Number($('#unitFactor').val());
                if (!uFac || uFac <= 0) {
                    console.warn("⚠ unitFactor missing, defaulting to 1");
                    uFac = 1;
                }
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
                console.log("uFac:", uFac, "TradeTotal:", tradeTotal);

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
            $('#displaycustomerNameHeader').text(" " + this.cells[1].innerHTML);
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
            $('#editedEnqId').val(this.cells[10].innerHTML);
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
        $('#infoCustomerModal').on('hidden.bs.modal', function () {
            $('#displaycustomerNameHeader').text('');
        });
        $('#editedCustomer_form').submit(function (event) {
            event.preventDefault();   // 🔥 ADD THIS

            var formData = new FormData(this);
            console.log("Submitting customerId:", formData.get("customerId"));

            $.ajax({
                type: "POST",
                url: config.developmentPath +
                    "/Admin/Controller/customerController.php/",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                $('#message').html(data);
                // dataTable.ajax.reload();
                setTimeout(function () {
                    $('#message').html('');
                }, 100);
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
        $('#updateLineItemBtn').on('click', function () {
            debugger;
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
                        alert('✅Updated successfully!');

                        // Read the new values directly from the edit modal
                        const newRef = $('#editQuoteRef').val();
                        const newQty = $('#editItemQty').val();
                        const newDisc = $('#editTradeDiscount').val();
                        const newTP = parseFloat($('#editTradePrice').val() || 0).toFixed(2);

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
                            let tradeTotal;

                            if (tDis <= 0) {

                                // ✅ No Trade Discount
                                tradeTotal = companyTotal;

                            } else {

                                const discounted = mrp - (mrp * tDis / 100);

                                const perPieceTrade =
                                    discounted + (discounted * gst / 100);

                                tradeTotal = perPieceTrade * qty * unitFactor;
                            }

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

                            for (let i = 0; i < customers.length; i++) {

                                if (customers[i].id == id) {

                                    customers[i].itemquantity = qty;
                                    customers[i].tradeDiscount = tDis;
                                    customers[i].tradePrice = tradeTotal;
                                    customers[i].totalAmount = totalAmount;
                                    customers[i].companyPrice = companyTotal;
                                    customers[i].totalValue = totalValue;
                                    customers[i].quoteReference = newRef;
                                    customers[i].quoteNote = quoteNote;

                                    console.log("✅ Updated customers array item:", customers[i]);
                                    break;
                                }
                            }
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



    $(function () {

        $("#quoteCollapseBtn").on("click", function () {

            $("#quoteModal").toggleClass("modal-collapsed");

            var icon = $(this).find("i");

            if ($("#quoteModal").hasClass("modal-collapsed")) {
                icon.removeClass("fa-compress-alt")
                    .addClass("fa-expand-alt");

                $(this).attr("title", "Expand");
            } else {
                icon.removeClass("fa-expand-alt")
                    .addClass("fa-compress-alt");

                $(this).attr("title", "Collapse");
            }

        });

        // Reset every time modal opens
        $('#quoteModal').on('shown.bs.modal', function () {

            $("#quoteModal").removeClass("modal-collapsed");

            $("#quoteCollapseBtn i")
                .removeClass("fa-expand-alt")
                .addClass("fa-compress-alt");

            $("#quoteCollapseBtn").attr("title", "Collapse");

        });

    });


</script>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.js"></script>


<style id="customer-page-responsive">
/* =========================================================
   CUSTOMER MANAGEMENT - RESPONSIVE OVERRIDES
   Scoped to this page/modal IDs so existing logic is untouched.
   ========================================================= */

/* Main customer table: allow horizontal scrolling on small screens. */
.card-body #Customer_table {
    min-width: 900px;
}

.card-body .table-responsive {
    overflow-x: auto !important;
    overflow-y: visible !important;
    -webkit-overflow-scrolling: touch;
}

#Customer_table_wrapper {
    width: 100%;
    overflow-x: auto;
    overflow-y: visible;
    -webkit-overflow-scrolling: touch;
}

#Customer_table th,
#Customer_table td {
    white-space: nowrap;
    vertical-align: middle;
}

#Customer_table td:nth-child(2),
#Customer_table td:nth-child(5),
#Customer_table td:nth-child(6) {
    white-space: normal;
}

#Customer_table td ul {
    padding-left: 18px;
    margin-bottom: 0;
}

#Customer_table .dropdown-menu {
    z-index: 1060;
}

/* All customer-page modals: keep them within the viewport. */
#customerModal .modal-dialog,
#editCustomerModal .modal-dialog,
#infoCustomerModal .modal-dialog,
#quoteModal .modal-dialog,
#infoItemModal .modal-dialog,
#editItemModal .modal-dialog,
#deleteUserModal .modal-dialog {
    width: calc(100vw - 32px);
    max-width: calc(100vw - 32px);
    margin: 16px auto;
}

#customerModal .modal-content,
#editCustomerModal .modal-content,
#infoCustomerModal .modal-content,
#quoteModal .modal-content,
#infoItemModal .modal-content,
#editItemModal .modal-content,
#deleteUserModal .modal-content {
    max-height: calc(100vh - 32px);
}

#customerModal .modal-body,
#editCustomerModal .modal-body,
#infoCustomerModal .modal-body,
#quoteModal .qm-body,
#infoItemModal .modal-body,
#editItemModal .modal-body,
#deleteUserModal .modal-body {
    overflow-y: auto;
}

/* Normal desktop widths. */
@media (min-width: 992px) {
    #customerModal .modal-dialog {
        max-width: 650px;
    }

    #editCustomerModal .modal-dialog {
        max-width: 1050px;
    }

    #infoCustomerModal .modal-dialog {
        max-width: 900px;
    }

    #quoteModal .modal-dialog {
        max-width: 1100px;
    }

    #infoItemModal .modal-dialog {
        max-width: 480px;
    }

    #editItemModal .modal-dialog {
        max-width: 650px;
    }

    #deleteUserModal .modal-dialog {
        max-width: 500px;
    }
}

/* Tablet */
@media (min-width: 768px) and (max-width: 991.98px) {
    #customerModal .modal-dialog {
        max-width: 620px;
    }

    #editCustomerModal .modal-dialog {
        max-width: 760px;
    }

    #infoCustomerModal .modal-dialog {
        max-width: 720px;
    }

    #quoteModal .modal-dialog {
        max-width: 760px;
    }

    #editCustomerModal .ec-body,
    #infoCustomerModal .ic-body,
    #quoteModal .qm-body {
        padding: 16px;
    }

    /* Edit Customer: let the two panels stack when necessary. */
    #editCustomerModal .ec-field-row {
        gap: 12px;
    }

    #editCustomerModal .ec-field-row label {
        width: 135px;
    }

    #infoCustomerModal .ic-detail-row label {
        width: 180px;
    }

    #quoteModal .qm-table-wrap {
        height: 340px;
    }
}

/* Mobile */
@media (max-width: 767.98px) {
    /* Page heading/card spacing. */
    .card-body {
        padding: 12px !important;
    }

    .card-header {
        padding: 12px !important;
    }

    .card-header h6 {
        font-size: 1rem !important;
    }

    /* Keep table usable without shrinking every column into unreadable text. */
    .card-body #Customer_table {
        min-width: 850px;
    }

    /* Modal safe width. */
    #customerModal .modal-dialog,
    #editCustomerModal .modal-dialog,
    #infoCustomerModal .modal-dialog,
    #quoteModal .modal-dialog,
    #infoItemModal .modal-dialog,
    #editItemModal .modal-dialog,
    #deleteUserModal .modal-dialog {
        width: calc(100vw - 20px) !important;
        max-width: calc(100vw - 20px) !important;
        margin: 10px auto !important;
    }

    #customerModal .modal-content,
    #editCustomerModal .modal-content,
    #infoCustomerModal .modal-content,
    #quoteModal .modal-content,
    #infoItemModal .modal-content,
    #editItemModal .modal-content,
    #deleteUserModal .modal-content {
        max-height: calc(100vh - 20px);
    }

    /* Add Customer form: labels above controls. */
    #customerModal .modal-body .row {
        margin-left: 0;
        margin-right: 0;
    }

    #customerModal .modal-body .row > label {
        max-width: 100%;
        flex: 0 0 100%;
        text-align: left !important;
        padding-left: 0;
        padding-right: 0;
        margin-bottom: 5px;
    }

    #customerModal .modal-body .row > .col-md-8 {
        max-width: 100%;
        flex: 0 0 100%;
        padding-left: 0;
        padding-right: 0;
    }

    /* Edit Customer form: switch horizontal label/input rows to vertical. */
    #editCustomerModal .ec-body {
        padding: 12px;
    }

    #editCustomerModal .ec-panel {
        padding: 14px;
    }

    #editCustomerModal .ec-field-row {
        display: block;
        margin-bottom: 14px;
    }

    #editCustomerModal .ec-field-row label {
        width: auto;
        display: block;
        text-align: left;
        margin-bottom: 5px;
        font-size: .84rem;
    }

    #editCustomerModal .ec-field-row .ec-field-input {
        width: 100%;
    }

    #editCustomerModal .ec-interest-wrap {
        max-height: 300px;
    }

    #editCustomerModal .ec-footer,
    #infoCustomerModal .ic-footer {
        padding: 10px 12px;
    }

    /* Customer Info: stack labels and values. */
    #infoCustomerModal .ic-body {
        padding: 12px;
    }

    #infoCustomerModal .ic-panel {
        padding: 14px;
        margin-bottom: 12px;
    }

    #infoCustomerModal .ic-detail-row {
        display: block;
        padding: 10px 2px;
    }

    #infoCustomerModal .ic-detail-row label {
        width: auto;
        display: block;
        margin-bottom: 3px;
        font-size: .8rem;
    }

    #infoCustomerModal .ic-detail-row .ic-value {
        font-size: .9rem;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    #infoCustomerModal .ic-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    #infoCustomerModal #quotationdetails_table {
        min-width: 650px;
    }

    /* Quote modal. */
    #quoteModal .qm-header {
        padding: 12px 14px;
    }

    #quoteModal .qm-header h5 {
        font-size: .98rem;
        max-width: 70%;
    }

    #quoteModal .qm-body {
        padding: 10px;
    }

    #quoteModal .qm-panel {
        padding: 12px;
    }

    #quoteModal .qm-panel-title {
        font-size: .9rem;
    }

    #quoteModal .qm-items-header {
        align-items: flex-start;
        gap: 8px;
        flex-wrap: wrap;
    }

    #quoteModal .btn-add-item,
    #quoteModal .btn-clear-all {
        font-size: .76rem;
        padding: 5px 9px;
        margin-left: 0;
    }

    #quoteModal .qm-table-wrap {
        height: 280px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    #quoteModal #lineItemTable {
        min-width: 1050px;
    }

    #quoteModal .qm-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
        margin-top: 10px;
    }

    #quoteModal .qm-sum-card {
        min-width: 0;
        padding: 8px 6px;
    }

    #quoteModal .qm-sum-card .val {
        font-size: .9rem;
        overflow-wrap: anywhere;
    }

    #quoteModal .qm-footer {
        padding: 10px 12px;
        flex-wrap: wrap;
        justify-content: stretch;
    }

    #quoteModal .qm-footer .btn {
        flex: 1 1 100%;
        padding: 8px 12px;
    }

    /* Small item/info modals. */
    #infoItemModal .modal-body,
    #editItemModal .modal-body {
        padding: 12px;
    }

    #infoItemModal input,
    #infoItemModal textarea {
        width: 100%;
        max-width: 100%;
    }

    /* Make modal headers usable as a consistent drag handle if draggable is enabled. */
    #customerModal .modal-header,
    #editCustomerModal .ec-header,
    #infoCustomerModal .ic-header,
    #quoteModal .qm-header,
    #infoItemModal .modal-header,
    #editItemModal .modal-header,
    #deleteUserModal .modal-header {
        cursor: move;
        user-select: none;
    }
}

/* Very small phones */
@media (max-width: 399.98px) {
    #quoteModal .qm-summary {
        grid-template-columns: 1fr;
    }

    #quoteModal .qm-header h5 {
        font-size: .9rem;
    }

    #editCustomerModal .ec-footer .btn,
    #infoCustomerModal .ic-footer .btn {
        width: 100%;
    }

    #editCustomerModal .ec-footer,
    #infoCustomerModal .ic-footer {
        flex-direction: column;
    }
}

/* Prevent accidental horizontal page overflow from wide modal/table content. */
html,
body {
    overflow-x: hidden;
}

/* =========================================================
   Customer Modal Responsive Scrolling
   - Only controls modal layout/scrolling.
   - Does not change PHP, JS, form IDs, or existing logic.
   ========================================================= */

#editCustomerModal .ec-content,
#infoCustomerModal .ic-content {
    display: flex;
    flex-direction: column;
    max-height: calc(100vh - 32px);
}

#editCustomerModal .ec-header,
#editCustomerModal .ec-footer,
#infoCustomerModal .ic-header,
#infoCustomerModal .ic-footer {
    flex: 0 0 auto;
}

#editCustomerModal .ec-body,
#infoCustomerModal .ic-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
}

/* Keep the existing inner "Looking For" and quotation-table scrolling. */
#editCustomerModal .ec-interest-wrap,
#infoCustomerModal .ic-table-wrap {
    -webkit-overflow-scrolling: touch;
}

/* Tablet / mobile: leave a little more usable viewport space. */
@media (max-width: 991.98px) {
    #editCustomerModal .ec-content,
    #infoCustomerModal .ic-content {
        max-height: calc(100vh - 20px);
    }
}

/* Mobile: the modal body becomes the only vertical scroll area. */
@media (max-width: 767.98px) {
    #editCustomerModal .ec-body,
    #infoCustomerModal .ic-body {
        overflow-y: auto;
        overflow-x: hidden;
    }
}

</style>