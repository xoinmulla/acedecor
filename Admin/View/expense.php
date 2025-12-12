<?php
include('session.php');
include('paymentNavigation.php');
require_once("../DB Operations/expenseOps.php");
require_once("../Controller/expenseController.php");
require_once("../DB Operations/expenseCategoryOps.php");
require_once("../DB Operations/customerOps.php");
require_once("../DB Operations/customerpaymentOps.php");
require_once("../Model/customerModel.php");
require_once("../DB Operations/employeePaymentOps.php");
require_once("../DB Operations/employeeOps.php");
require_once("../Controller/employeePaymentController.php");


$employees = DBEmployee::readAll();
$payments = DBEmployeePayment::readAll();
$expenses = DBExpense::readAll();
$expenseCategories = DBExpenseCategory::getAll();

// Category → Type map
$categoryTypeMap = [];
foreach ($expenseCategories as $cat) {
    $categoryTypeMap[$cat->getName()] = $cat->getType();
}
?>

<style>
    .nav-tabs .nav-link.active {
        background-color: #e3f2fd;
        color: gray !important;
        border-radius: 8px 8px 0 0;
    }

    .nav-tabs .nav-link {
        color: rgb(0, 0, 0);
        font-weight: 500;
    }
</style>

<div class="card shadow mb-4 mt-4 mx-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">💸 Expense Management</h6>
        <button class="btn btn-success btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#expenseModal">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="expenseTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                    role="tab"><b>All Expenses</b></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer" type="button"
                    role="tab"><b>Customer Payment</b></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers"
                    type="button" role="tab"><b>Suppliers Payment</b></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="employee-tab" data-bs-toggle="tab" data-bs-target="#employee" type="button"
                    role="tab"><b>Employee Payment</b></button>
            </li>
        </ul>

        <div class="tab-content" id="expenseTabsContent">
            <!-- 🔹 All Expenses Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover" id="allExpenseTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Amount (₹)</th>
                                <th>Payment Mode</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expenses as $exp):
                                $catName = htmlspecialchars($exp['category']);
                                $type = $categoryTypeMap[$catName] ?? 'N/A';
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($exp['expense_date']); ?></td>
                                    <td><?= $catName; ?></td>
                                    <td><span
                                            class="badge <?= $type === 'Income' ? 'bg-success' : 'bg-danger'; ?>"><?= $type; ?></span>
                                    </td>
                                    <td>₹<?= number_format($exp['amount'], 2); ?></td>
                                    <td><?= htmlspecialchars($exp['payment_type']); ?></td>
                                    <td><?= nl2br(htmlspecialchars($exp['notes'])); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item text-primary edit-btn" data-bs-toggle="modal"
                                                    data-bs-target="#editExpenseModal" data-id="<?= $exp['id']; ?>"
                                                    data-date="<?= $exp['expense_date']; ?>"
                                                    data-category="<?= $catName; ?>" data-type="<?= $type; ?>"
                                                    data-amount="<?= $exp['amount']; ?>"
                                                    data-payment="<?= htmlspecialchars($exp['payment_type']); ?>"
                                                    data-notes="<?= htmlspecialchars($exp['notes']); ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="dropdown-item text-danger delete-btn" data-bs-toggle="modal"
                                                    data-bs-target="#deleteExpenseModal" data-id="<?= $exp['id']; ?>">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 🔹 Customer Payment Tab -->
            <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
                            </div>
                            <!-- <div class="col" align="right">
                                <span data-toggle=modal data-target=#customerModal>
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
                                        <th style=display:none>Payment Id</th>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Customer Contact No.</th>
                                        <th style=display:none> Customer Address</th>
                                        <th>DOQ</th>
                                        <th>DOE</th>
                                        <th>Quote Code</th>
                                        <th>Total Amt</th>
                                        <th>Paid Amt</th>
                                        <th>Balance Amt</th>
                                        <th>Credit Discount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $customerList = DBpayment::getAllcustomerpayment();
                                    foreach ($customerList as $customer) {
                                        echo "<tr> <td style=display:none >" . $customer->get_paymentid() . "</td>
                                        <td >" . $customer->get_custid() . "</td>
                                        <td>" . $customer->get_custname() . "</td>
                                        <td>" . $customer->get_custcontactnumber() . "</td>
                                        <td style=display:none >" . $customer->getcustomerAddress() . "</td>
                                        <td>" . $customer->getcustomerDOV() . "</td>
                                        <td>" . $customer->getDOQ() . "</td>
                                        <td>" . $customer->getQuoteCode() . "</td>
                                        <td>" . $customer->get_totalamt() . "</td>
                                        <td>" . $customer->get_receivedamt() . "</td>
                                        <td>" . $customer->get_pendingamt() . "</td>
                                        <td>" . $customer->get_creditdiscount() . "</td>
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
                                                    <button class='btn btn-danger dropdown-item' 
                                                    id='Payment'
                                                    data-toggle='modal'
                                                    data-target='#paymentinfoModal' 
                                                    name='delete_button' 
                                                    role='button' 
                                                    data-id='" . $customer->get_custid() . "'>
                                                    <i class='fas fa-rupee-sign'></i>
                                                    Payment Updates  
                                                    </button>
                                                    <button class='btn btn-danger dropdown-item' 
                                                    id='Payment'
                                                    data-toggle='modal'
                                                    data-target='#CreditdiscountModal' 
                                                    name='delete_button' 
                                                    role='button' 
                                                    data-id='" . $customer->get_custid() . "'>
                                                    <i class='fas fa-percentage'></i>
                                                    Credit Discount
                                                    </button>
                                                    <button class='btn btn-primary dropdown-item'
                                                    data-toggle='modal' 
                                                    data-target='#TransactionModal' 
                                                    role='button' 
                                                
                                                    data-id='" . $customer->get_custid() . "'> 
                                                    <i class='fas fa-info'></i>
                                                        View Transaction
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
                    <div class="modal fade" id=TransactionModal tabindex=-1 role=dialog aria-hidden=true>
                        <div class="modal-dialog modal-xl">
                            <div class="row gutters-sm">
                                <div class="col-md-2 mb-2">

                                    <br />
                                    <!-- <div class="form-check text-center">
                                        <input type="radio" class="btn-check" name="edit" id="option2">
                                        <label class="btn btn-danger" for="option2">Edit</label>
                                    </div> -->
                                </div>
                                <div class="col-md-10">
                                    <form class="form" method="POST" id="TransactionForm" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="col-12" id="printTransaction">

                                                    <table class="table table-bordered  container"
                                                        id="Transactiontable">
                                                        <thead>
                                                            <tr>
                                                                <td style="text-align:center" colspan="5">
                                                                    <h1>Payment Receipt</h1>
                                                                    <p>Ace Decors Dharwad</p>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <!-- <th >Customer Name </th> -->
                                                                <td colspan="3">
                                                                    <h5>Customer Details</h5>
                                                                </td>
                                                                <td colspan="3">
                                                                    <h5>Transaction Details</h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    Customer Name :<span
                                                                        id="transactioncustname"></span>
                                                                </td>
                                                                <td colspan="3">
                                                                    Customer Code :<span
                                                                        id="transactioncustcode"></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    Address :<span
                                                                        id="transactioncustomerAddress"></span>

                                                                </td>
                                                                <td colspan="3">
                                                                    Date :<?php echo $date = date('d/m/Y '); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">

                                                                    Phone :<span id="transactioncustcontactno"></span>
                                                                </td>
                                                                <td colspan="3">

                                                                    Total Amount : <span
                                                                        id="transactiontotalamt"></span>
                                                                </td>
                                                                <div id="Custcode" style="display:none"></div>
                                                            </tr>
                                                            <tr>

                                                            </tr>
                                                            <tr>
                                                                <th style="text-align:center" colspan="1">Sl</th>
                                                                <th style="text-align:center">Payment Date</th>
                                                                <th style="text-align:center">Mode of payment</th>
                                                                <th style="text-align:center">Pending Amount</th>
                                                                <th style="text-align:center">Paid Amount</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td style="text-align:center" colspan=2></td>

                                                                <td style="text-align:right" rowspan="" colspan="">Total
                                                                </td>
                                                                <td id="pending" style="text-align:center"></td>
                                                                <td id="totalpaidAmount" style="text-align:center"></td>
                                                            </tr>
                                                        </tfoot>
                                                        <tr>

                                                        </tr>

                                                    </table>
                                                    <div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <input type="hidden" name="createdby" id="createdby"
                                                                    class="form-control" required
                                                                    value="<?php echo $_SESSION['login_user']; ?>" />
                                                                <input type="hidden" name="modifiedby" id="modifiedby"
                                                                    class="form-control" required
                                                                    value="<?php echo $_SESSION['login_user']; ?>" />
                                                                <input type="hidden" id="supplierId"
                                                                    value="<?php echo $customer->get_custid(); ?>" />
                                                            </div>
                                                        </div>
                                                        <input type="submit" name="submit" id="printPDF"
                                                            class="btn btn-success" value="Save AS PDF" />
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id=paymentinfoModal tabindex=-1 role=dialog aria-hidden=true>
                        <div class="modal-dialog modal-xl">
                            <div class="row gutters-sm">
                                <div class="col-md-2 mb-2">

                                    <br />
                                    <!-- <div class="form-check text-center">
                                        <input type="radio" class="btn-check" name="edit" id="option2">
                                        <label class="btn btn-danger" for="option2">Edit</label>
                                    </div> -->
                                </div>
                                <div class="col-md-10">
                                    <form class="form" action="../Controller/customerpaymentcontroller.php"
                                        method="POST" id="myForm" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="col-md-6 control-label">Customer Name <span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="custname" id="custname"
                                                                class="form-control" required
                                                                data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                                data-parsley-maxlength="150"
                                                                data-parsley-trigger="keyup" readonly />
                                                            <input type="hidden" id="custid" name="custid" value="">
                                                            <input type="hidden" id="paymentid" name="paymentid"
                                                                value="">
                                                            <input type="hidden" id="quoteid" name="quoteid" value="">
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <label class="col-md-6 control-label">Customer Contact No.<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="custcontactno" id="custcontactno"
                                                                class="form-control" required
                                                                data-parsley-trigger="keyup" readonly />
                                                        </div>
                                                    </div>
                                                    <br />


                                                    <div class="col-md-6">
                                                        <label class="col-md-6 control-label">Total Amount<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="totalamt" id="totalamt"
                                                                class="form-control" required
                                                                data-parsley-trigger="keyup" readonly value="" />
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <label class="col-md-6 control-label">Paid Amount<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="paidamt" id="paidamt"
                                                                class="form-control" required
                                                                data-parsley-trigger="keyup" readonly value="" />
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <label class="col-md-6 control-label">Received Amount<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="receivedamt" id="receivedamt"
                                                                class="form-control" required
                                                                data-parsley-trigger="keyup" />
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <label class="col-md-6 control-label">Pending Amount<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="pendingamt" id="pendingamt"
                                                                class="form-control" required
                                                                data-parsley-trigger="keyup" readonly value="" />
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <label class="col-md-6 control-label">Payment Plan<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-12">
                                                            <select class="form-select" id="paymentplan"
                                                                name="paymentplan" required>
                                                                <option value="">Payment Plan</option>
                                                                <option value="Part Payment">Part Payment</option>
                                                                <option value="Full Payment">Full Payment</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br />


                                                    <div id="duedatediv" class="col-md-6" style="display: none">
                                                        <label for="duedate" class="col-md-6 control-label"> Next
                                                            payment on:</label>
                                                        <div class="col-sm-12">
                                                            <input type="date" id="duedate" name="duedate"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <label for="pmode" class="col-md-6 control-label">Payment
                                                            Mode</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-select" id="paymentmode"
                                                                name="paymentmode" required>
                                                                <option value="">Select Mode</option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="Net Banking">Net Banking</option>
                                                                <option value="Debit/Credit Card">Debit/Credit Card
                                                                </option>
                                                                <option value="UPI transaction">UPI transaction</option>
                                                                <option value="Cheque">Cheque</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div id="rtgsdiv" class="col-md-6" style="display: none">
                                                        <label for="rtgsno" class="col-md-6 control-label">Enter RTGS
                                                            number:</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" id="RTGSno" name="RTGSno"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div id="chequediv" class="col-md-6" style="display: none">
                                                        <label for="chequeimg" class=" col-md-6 form-label">Upload the
                                                            image of
                                                            cheque</label>
                                                        <div class="col-sm-12">
                                                            <input type="file" name="chequeimg" id="chequeimg"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <label for="paymentdescription"
                                                            class="col-md-6 control-label">Payment
                                                            Description</label>
                                                        <div class="col-sm-12">
                                                            <textarea type="text" id="paymentdescription"
                                                                name="paymentdescription"
                                                                placeholder="Payment Description" class="form-control"
                                                                required></textarea>
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="col-md-6">
                                                        <input type="hidden" name="modifiedby" id="modifiedby"
                                                            class="form-control" required data-parsley-type="integer"
                                                            data-parsley-minlength="10" data-parsley-maxlength="12"
                                                            data-parsley-trigger="keyup"
                                                            value="<?php echo $_SESSION['login_user']; ?>" />

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" id="btn" type="submit"
                                                            name="submit">Update</button>
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                        <br />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id=CreditdiscountModal tabindex=-1 role=dialog aria-hidden=true>
                        <div class="modal-dialog">
                            <form method="POST" id="creditDiscount_form" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modal_title">Credit Discount</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="lead">
                                            Are you sure. Would you like to credit discount.
                                        </p>

                                        <input type="hidden" name="paymentId" id="paymentId" value="">
                                        <input type="hidden" name="paidAmount" id="paidAmount" value="">
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="submit" name="submit" id="allocatebutton" class="btn btn-danger"
                                            value="Confirmed" />
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Employee Payment Tab -->
            <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">Employee Payment List</h6>
                            </div>
                            <div class="col" align="right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addPaymentModal"
                                    role="button">
                                    <i class="fas fa-plus-circle"></i> Add Payment
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="container-fluid">
                            <table class="table table-bordered table-hover" id="employee_payment_table" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">S.No</th>
                                        <th>Date</th>
                                        <th>Employee</th>
                                        <th>Amount (₹)</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $serial = 1;
                                    foreach ($payments as $p): ?>
                                        <tr>
                                            <td><?= $serial++; ?></td>
                                            <td><?= $p['payment_date']; ?></td>
                                            <td><?= htmlspecialchars($p['emp_name']); ?></td>
                                            <td>₹<?= number_format($p['amount'], 2); ?></td>
                                            <td><?= htmlspecialchars($p['payment_type']); ?></td>
                                            <td>
                                                <?php if ($p['status'] == 'Paid'): ?>
                                                    <span class="badge badge-success">Paid</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning text-dark">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= nl2br(htmlspecialchars($p['remarks'])); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                                            data-target="#editPaymentModal" data-id="<?= $p['id']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button class="btn btn-danger dropdown-item delete-btn"
                                                            data-toggle="modal" data-target="#deletePaymentModal"
                                                            data-id="<?= $p['id']; ?>">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($payments)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No payments found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- ADD PAYMENT MODAL -->
                <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form method="POST" action="../Controller/employeePaymentController.php">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Payment</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="add">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Date *</label>
                                        <div class="col-md-8">
                                            <input type="date" name="payment_date" class="form-control"
                                                value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="due_amount" id="add_due_amount" class="form-control"
                                        readonly>

                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Employee *</label>
                                        <div class="col-md-8">
                                            <select name="emp_id" class="form-control" required>
                                                <option value="">Select Employee</option>
                                                <?php foreach ($employees as $emp): ?>
                                                    <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Due Amount (₹)</label>
                                        <div class="col-md-8">
                                            <input type="text" name="due_amount" id="add_due_amount"
                                                class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Amount *</label>
                                        <div class="col-md-8">
                                            <input type="number" step="0.01" name="amount" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Payment Type</label>
                                        <div class="col-md-8">
                                            <select name="payment_type" class="form-control">
                                                <option>Cash</option>
                                                <option>Bank Transfer</option>
                                                <option>UPI</option>
                                                <option>Cheque</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Status</label>
                                        <div class="col-md-8">
                                            <select name="status" class="form-control">
                                                <option>Paid</option>
                                                <option>Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Remarks</label>
                                        <div class="col-md-8">
                                            <textarea name="remarks" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- EDIT PAYMENT MODAL -->
                <div class="modal fade" id="editPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form method="POST" action="../Controller/employeePaymentController.php">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Payment</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" id="edit_id">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Date *</label>
                                        <div class="col-md-8">
                                            <input type="date" name="payment_date" id="edit_payment_date"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Employee *</label>
                                        <div class="col-md-8">
                                            <select name="emp_id" id="edit_emp_id" class="form-control" required>
                                                <option value="">Select Employee</option>
                                                <?php foreach ($employees as $emp): ?>
                                                    <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Due Amount (₹)</label>
                                        <div class="col-md-8">
                                            <input type="text" id="edit_due_amount" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Amount *</label>
                                        <div class="col-md-8">
                                            <input type="number" step="0.01" name="amount" id="edit_amount"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Payment Type</label>
                                        <div class="col-md-8">
                                            <select name="payment_type" id="edit_payment_type" class="form-control">
                                                <option>Cash</option>
                                                <option>Bank Transfer</option>
                                                <option>UPI</option>
                                                <option>Cheque</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Status</label>
                                        <div class="col-md-8">
                                            <select name="status" id="edit_status" class="form-control">
                                                <option>Paid</option>
                                                <option>Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-right">Remarks</label>
                                        <div class="col-md-8">
                                            <textarea name="remarks" id="edit_remarks" class="form-control"
                                                rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- DELETE MODAL -->
                <div class="modal fade" id="deletePaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" id="deleteForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Payment</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this payment?</p>
                                    <input type="hidden" id="delete_id">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== ADD MODAL ===================== -->
<div class="modal fade" id="expenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="../Controller/expenseController.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">➕ Add Expense</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input type="date" name="expense_date" class="form-control" value="<?= date('Y-m-d'); ?>"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" id="addCategorySelect" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php foreach ($expenseCategories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat->getName()); ?>"
                                        data-type="<?= htmlspecialchars($cat->getType()); ?>">
                                        <?= htmlspecialchars($cat->getName()); ?> (<?= $cat->getType(); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Type</label>
                            <input type="text" id="addCategoryType" name="category_type" class="form-control bg-light"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Amount (₹)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Mode</label>
                            <select name="payment_type" class="form-select">
                                <option>Cash</option>
                                <option>Bank Transfer</option>
                                <option>UPI</option>
                                <option>Cheque</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ===================== EDIT MODAL ===================== -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="../Controller/expenseController.php">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" id="editExpenseId">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">✏️ Edit Expense</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input type="date" name="expense_date" id="editExpenseDate" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" id="editCategorySelect" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php foreach ($expenseCategories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat->getName()); ?>"
                                        data-type="<?= htmlspecialchars($cat->getType()); ?>">
                                        <?= htmlspecialchars($cat->getName()); ?> (<?= $cat->getType(); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Type</label>
                            <input type="text" id="editCategoryType" name="category_type" class="form-control bg-light"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Amount (₹)</label>
                            <input type="number" step="0.01" name="amount" id="editAmountField" class="form-control"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Mode</label>
                            <select name="payment_type" id="editPaymentType" class="form-select">
                                <option>Cash</option>
                                <option>Bank Transfer</option>
                                <option>UPI</option>
                                <option>Cheque</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" id="editNotes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ===================== DELETE MODAL ===================== -->
<div class="modal fade" id="deleteExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="GET" action="../Controller/expenseController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Expense</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this expense?</p>
                    <input type="hidden" name="delete" id="deleteExpenseId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // All Expenses table
        $('#allExpenseTable').DataTable({
            pageLength: 10,
            order: [[0, "desc"]],
            columnDefs: [{ orderable: false, targets: [6] }]
        });

        // Category -> Type (Add)
        const addCat = document.getElementById("addCategorySelect");
        if (addCat) {
            addCat.addEventListener("change", function () {
                document.getElementById("addCategoryType").value =
                    this.selectedOptions[0]?.dataset.type || "";
            });
        }

        // Edit Expense (All Expenses tab)
        document.querySelectorAll(".edit-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                document.getElementById("editExpenseId").value = this.dataset.id;
                document.getElementById("editExpenseDate").value = this.dataset.date;
                document.getElementById("editCategorySelect").value = this.dataset.category;
                document.getElementById("editCategoryType").value = this.dataset.type;
                document.getElementById("editAmountField").value = this.dataset.amount;
                document.getElementById("editPaymentType").value = this.dataset.payment;
                document.getElementById("editNotes").value = this.dataset.notes;
            });
        });

        // Delete Expense (All Expenses tab)
        document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                document.getElementById("deleteExpenseId").value = this.dataset.id;
            });
        });
    });

    $(document).ready(function () {
        // ---------- Customer tab existing code (unchanged) ----------
        $('#Customer_table tbody').on('click', 'tr', function () {
            $('#paymentid').val(this.cells[0].innerHTML);
            $('#transactioncustcode').text(this.cells[1].innerHTML);
            $('#paymentId').val(this.cells[0].innerHTML);
            $('#custname').val(this.cells[2].innerHTML);
            $('#transactioncustname').text(this.cells[2].innerHTML);
            $('#custcontactno').val(this.cells[3].innerHTML);
            $('#transactioncustcontactno').text(this.cells[3].innerHTML);
            $('#transactioncustomerAddress').text(this.cells[4].innerHTML);
            $('#totalamt').val(this.cells[8].innerHTML);
            $('#transactiontotalamt').text(this.cells[8].innerHTML);
            $('#paidamt').val(this.cells[9].innerHTML);
            $('#paidAmount').val(this.cells[9].innerHTML);
            $('#pendingamt').val(this.cells[10].innerHTML);
            $('#quoteid').val(this.cells[7].innerHTML);
        });

        $('#Payment').on('click', 'tr', function () {
            if (!parseInt($('#totalamt').val())) {
                $('#totalamt').focus();
                $('#paidamt').attr('disabled', true);
            } else {
                $('#totalamt').attr('readonly', true);
            }
        });

        $('#paymentinfoModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            var TotalPendingAmount = 0;
            $('#custid').val(rowid);
            var transactionUrl = config.developmentPath + "/Admin/Controller/customerpaymentcontroller.php?id=" + rowid;
            $.getJSON(transactionUrl, function (data) {
                $.each(data, function (index, value) {
                    TotalPendingAmount = parseInt(value.pendingamt);
                });
                $('#pendingamt').text(TotalPendingAmount);
            });
        });

        $('#TransactionModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#custid').val(rowid);
            var quoteId = $('#quoteid').val();
            var transactionUrl = config.developmentPath + "/Admin/Controller/customerpaymentcontroller.php?id=" + quoteId;
            $.getJSON(transactionUrl, function (data) {
                var count = 1, TotalPendingAmount = 0, TotalPaidAmount = 0;
                $("#Transactiontable tbody").find("tr:gt(0)").remove();
                $.each(data, function (index, value) {
                    $('#Transactiontable tbody').append(
                        '<tr>' +
                        '<td>' + (count++) + '</td>' +
                        '<td>' + value.modifieddate + '</td>' +
                        '<td>' + value.paymentmode + '</td>' +
                        '<td>' + value.pendingamt + '</td>' +
                        '<td>' + value.receivedamt + '</td>' +
                        '</tr>'
                    );
                    TotalPendingAmount = parseInt(value.pendingamt);
                    TotalPaidAmount = parseInt(TotalPaidAmount) + parseInt(value.receivedamt);
                });
                $('#pending').text(TotalPendingAmount);
                $('#totalpaidAmount').text(TotalPaidAmount);
            });
        });

        $('#Customer_table').DataTable({});

        $("#paymentplan").change(function () {
            if ($(this).val() == "Part Payment") {
                $("#duedatediv").show();
                var today = new Date(), dd = String(today.getDate()).padStart(2, '0'),
                    mm = String(today.getMonth() + 1).padStart(2, '0'), yyyy = today.getFullYear();
                $("#duedate").attr({ min: yyyy + '-' + mm + '-' + dd, disabled: false });
                $("#btn").attr("disabled", false);
            } else {
                if (parseInt($("#paidamt").val()) > 0 && parseInt($("#pendingamt").val()) != 0) {
                    $("#btn").attr("disabled", true);
                    alert("Payment is still due");
                }
                $("#duedate").attr('disabled', true);
            }
        });

        $("#totalamt").change(function () {
            if (parseInt($(this).val()) > 0) $('#paidamt').attr('disabled', false);
        });

        $("#receivedamt").change(function () {
            $("#pendingamt").val(parseInt($("#pendingamt").val()) - $(this).val());
            $('#paidamt').val($('#totalamt').val() - $("#pendingamt").val());
            if (+$(this).val() > parseInt($('#totalamt').val())) {
                $("#btn").addClass('disabled');
                alert("Received Amount is greater than Total Amount");
            } else {
                $("#btn").removeClass('disabled');
            }
        });

        if (parseInt($("#paidamt").val()) == parseInt($("#totalamt").val())) {
            $("#myForm :input").prop("disabled", true);
            $("#option2").prop("disabled", true);
        }

        $("#paymentmode").change(function () {
            if ($(this).val() == "Net Banking") {
                $("#rtgsdiv").show(); $("#chequediv").hide();
            } else if ($(this).val() == "Cheque") {
                $("#rtgsdiv").hide(); $("#chequediv").show();
            } else {
                $("#rtgsdiv").hide(); $("#chequediv").hide();
            }
        });

        $('#TransactionForm').submit(function (e) {
            e.preventDefault();
            $('#printPDF').remove();
            var content = $('#printTransaction').html();
            var fileName = $('#transactioncustcode').text() + '_CustTransaction';
            var uniturl = config.developmentPath + "/Admin/Controller/pdfGeneratorContorller.php";
            $.ajax({
                type: "POST",
                url: uniturl,
                data: {
                    "modifiedby": $('#modifiedby').val(),
                    "custId": $('#transactioncustcode').val(),
                    "fileType": "customerpayment",
                    "fileName": fileName,
                    "html": content
                },
                dataType: "json"
            }).done(function () {
                setTimeout(function () { $('#printTransaction').html(''); }, 10000);
            });
            window.open(config.developmentPath + '/Admin/pdfs/customerpayment/' + fileName.trim() + '.pdf');
        });

        $('#creditDiscount_form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/customerpaymentcontroller.php/",
                data: {
                    paidAmount: $('#paidAmount').val(),
                    id: $('#paymentId').val(),
                    action: 'credit'
                },
                success: function (data) {
                    $('#message').html(data);
                    $('#Customer_table').DataTable().ajax?.reload?.();
                    setTimeout(function () { $('#message').html(''); }, 5000);
                }
            });
        });

        // ===== DUE AMOUNT (Add & Edit modals) =====
        $(document).on("change", 'select[name="emp_id"], input[name="payment_date"]', function () {
            var modal = $(this).closest(".modal");
            var empId = modal.find('select[name="emp_id"]').val();
            var dueField = modal.find("#add_due_amount, #edit_due_amount");

            if (!empId) {
                dueField.val("");
                return;
            }

            $.getJSON("../Controller/employeePaymentController.php",
                { action: "getTotalDue", emp_id: empId },
                function (data) {
                    const v = parseFloat(data.due);
                    dueField.val(isFinite(v) ? "₹ " + v.toFixed(2) : "₹ 0.00");
                }
            );
        });



        // ===== EDIT (Employee Payment tab) – robust delegated handler =====
        $(document).on('click', '[data-target="#editPaymentModal"], [data-bs-target="#editPaymentModal"]', function () {
            var id = $(this).data('id');
            if (!id) return;
            $('#edit_id').val(id);

            $.getJSON('../Controller/employeePaymentController.php', { action: 'fetch', id: id }, function (data) {
                if (data && !data.error) {
                    $('#edit_payment_date').val(data.payment_date);
                    $('#edit_emp_id').val(data.emp_id);
                    $('#edit_amount').val(data.amount);
                    $('#edit_payment_type').val(data.payment_type);
                    $('#edit_status').val(data.status);
                    $('#edit_remarks').val(data.remarks);

                    // trigger due calculation after fields are set
                    $('#edit_emp_id').trigger('change');
                } else {
                    alert(data && data.error ? data.error : 'Could not load payment.');
                }
            });
        });

        // Also trigger due calc when modal becomes visible (in case values pre-exist)
        $('#addPaymentModal, #editPaymentModal').on('shown.bs.modal', function () {
            var modal = $(this);
            var empId = modal.find('select[name="emp_id"]').val();
            if (empId) modal.find('select[name="emp_id"]').trigger('change');
        });

        // ===== DELETE (Employee Payment tab) – Fixed binding =====
        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            $('#delete_id').val(id); // Store ID in hidden field inside modal
        });

        $('#deleteForm').off('submit').on('submit', function (e) {
            e.preventDefault();
            var id = $('#delete_id').val();

            if (!id) {
                alert('No record selected for deletion.');
                return;
            }

            if (!confirm('Are you sure you want to delete this payment?')) return;

            $.ajax({
                url: '../Controller/employeePaymentController.php',
                type: 'GET',
                data: { delete: id },
                success: function () {
                    // Redirect and open employee tab
                    window.location.href = 'expense.php?deleted=1#employee';
                },
                error: function (xhr) {
                    alert('Delete failed: ' + xhr.statusText);
                }
            });
        });



        // Employee payments table
        // $('#employee_payment_table').DataTable({
        //     order: [[1, "desc"]],
        //     pageLength: 10,
        //     columnDefs: [{ orderable: false, targets: [0, 7] }]
        // });

    });
</script>
<script>
    // Auto-open "Employee Payment" tab when redirected
    $(document).ready(function () {
        if (window.location.hash === '#employee') {
            $('#employee-tab').tab('show');
        }

        if (window.location.search.includes('success=1')) {
            alert('✅ Payment added successfully');
        } else if (window.location.search.includes('updated=1')) {
            alert('✅ Payment updated successfully');
        } else if (window.location.search.includes('deleted=1')) {
            alert('✅ Payment deleted successfully');
        }
    });
</script>