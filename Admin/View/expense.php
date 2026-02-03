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
require_once(__DIR__ . "/../DB Operations/generalSubcategoryOps.php");
require_once("../DB Operations/projectOps.php");
require_once("../DB Operations/supplierpaymentOps.php");

$employees = DBEmployee::readAll();
$payments = DBEmployeePayment::getEmployeeSummary();
$expenses = DBExpense::readAll();
$generalSubcategories = DBGeneralSubcategory::getAll();
$approvedCustomers = DBpayment::getCustomersWithApprovedQuotes();
$supplierPayments = DBsupplierpayment::getAllsupplierpayment();
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

    .modal-content {
        background-color: #ffffff;
    }

    .form-label {
        font-size: 0.9rem;
    }
</style>

<div class="card shadow mb-4 mt-4 mx-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 text-primary" style="font-size: 25px; font-weight: 800;"> Payments Management</h6>
        <button class="btn btn-success btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#allExpenseModal">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="expenseTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                    role="tab"><b>All Transactions</b></button>
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
                                <th>Type</th>
                                <th>Category</th>
                                <!-- <th>Subcategory</th> -->
                                <th>Amount (₹)</th>
                                <th>Payment Mode</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expenses as $exp):
                                $catName = htmlspecialchars($exp['category']);

                                // ✅ SAFE TYPE HANDLING
                                $typeRaw = $exp['type'] ?? '';
                                $type = trim($typeRaw);

                                // ✅ Infer type if missing
                                if ($type === '') {
                                    if (strtolower($catName) === 'customer') {
                                        $type = 'Income';
                                    } else {
                                        $type = 'Expense';
                                    }
                                }

                                // Badge color
                                if ($type === 'Income') {
                                    $badgeClass = 'bg-success';
                                } elseif ($type === 'Expense') {
                                    $badgeClass = 'bg-danger';
                                } else {
                                    $badgeClass = 'bg-secondary';
                                }


                                $subcategory = 'N/A';

                                if (
                                    $type === 'Expense' &&
                                    strtolower($catName) === 'general' &&
                                    !empty($exp['subcategory_name'])
                                ) {
                                    $subcategory = htmlspecialchars($exp['subcategory_name']);
                                }


                                ?>

                                <tr>
                                    <td><?= htmlspecialchars($exp['expense_date']); ?></td>

                                    <td>
                                        <span class="badge <?= $badgeClass; ?>">
                                            <?= htmlspecialchars($type); ?>
                                        </span>
                                    </td>

                                    <td><?= $catName; ?></td>
                                    <!-- <td><?= $subcategory; ?></td> -->


                                    <td>₹<?= number_format($exp['amount'], 2); ?></td>

                                    <td><?= htmlspecialchars($exp['payment_type']); ?></td>

                                    <td><?= nl2br(htmlspecialchars($exp['notes'])); ?></td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item text-primary edit-btn" data-bs-toggle="modal"
                                                    data-bs-target="#editExpenseModal" data-id="<?= $exp['id']; ?>"
                                                    data-date="<?= $exp['expense_date']; ?>"
                                                    data-type="<?= htmlspecialchars($type); ?>"
                                                    data-category="<?= $catName; ?>" data-amount="<?= $exp['amount']; ?>"
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
                                        <th>Customer No.</th>
                                        <th style=display:none> Customer Address</th>
                                        <th>DOQ</th>
                                        <!-- <th>DOE</th> -->
                                        <!-- <th>Quote Code</th> -->
                                        <th>Total Amt</th>
                                        <th>Paid Amt</th>
                                        <th>Balance Amt</th>
                                        <th>Expenditure</th>
                                        <th>Credit Discount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $customerList = DBpayment::getAllcustomerpayment();

                                    foreach ($customerList as $customer) {

                                        echo "
    <tr>
    <td style='display:none'>" . $customer->get_paymentid() . "</td>
    <td>" . $customer->get_custid() . "</td>
    <td>" . $customer->get_custname() . "</td>
    <td>" . $customer->get_custcontactnumber() . "</td>
    <td style='display:none'>" . $customer->getcustomerAddress() . "</td>
    <td>" . $customer->getcustomerDOV() . "</td>
    <!-- <td>" . $customer->getDOQ() . "</td>-->
    <!-- <td>" . $customer->getQuoteCode() . "</td> -->
    <td>" . $customer->get_totalamt() . "</td>
    <td>" . $customer->get_receivedamt() . "</td>
    <td>" . $customer->get_pendingamt() . "</td>
    <td>" . number_format($customer->get_expenditure(), 2) . "</td>
    <td>" . $customer->get_creditdiscount() . "</td>


        <td>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle'
                        type='button'
                        data-toggle='dropdown'
                        aria-expanded='false'>
                    Actions
                </button>

                <div class='dropdown-menu'>
                    <button class='btn btn-danger dropdown-item'
                            data-toggle='modal'
                            data-target='#paymentinfoModal'
                            data-id='" . $customer->get_custid() . "'>
                        <i class='fas fa-rupee-sign'></i> Payment Updates
                    </button>

                   <button
    class='btn btn-danger dropdown-item credit-discount-btn'
    data-toggle='modal'
    data-target='#CreditdiscountModal'
    data-custid='" . $customer->get_custid() . "'
    data-pending='" . $customer->get_pendingamt() . "'
>
    <i class='fas fa-percentage'></i> Credit Discount
</button>



<button class='btn btn-primary dropdown-item view-transaction'
        data-custid='" . $customer->get_custid() . "'>
    <i class='fas fa-info'></i> View Transaction
</button>


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
                                    <form class="form" method="POST" id="customerTransactionForm"
                                        enctype="multipart/form-data">
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
                                                                    Location :<span
                                                                        id="transactioncustomerLocation"></span>


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
                                                                <td id="cust_pending" style="text-align:center"></td>
                                                                <td id="cust_totalpaidAmount" style="text-align:center">
                                                                </td>
                                                            </tr>
                                                        </tfoot>


                                                    </table>
                                                    <div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <input type="hidden" name="createdby" id="createdby"
                                                                    class="form-control" required
                                                                    value="<?php echo $_SESSION['login_user']; ?>" />
                                                                <input type="hidden" name="cust_modifiedby"
                                                                    id="modifiedby" class="form-control" required
                                                                    value="<?php echo $_SESSION['login_user']; ?>" />
                                                                <input type="hidden" id="custId"
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
                                                        <input type="hidden" name="modifiedby" id="cust_modifiedby"
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
                                        <input type="hidden" id="cd_custId" name="custId">
                                        <input type="hidden" id="cd_pendingAmount" name="pendingAmount">


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
                            <!-- <div class="col" align="right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addPaymentModal"
                                    role="button">
                                    <i class="fas fa-plus-circle"></i> Add Payment
                                </button>
                            </div> -->

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="container-fluid">
                            <table class="table table-bordered table-hover" id="employee_payment_table" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Due (₹)</th>
                                        <th>Paid (₹)</th>
                                        <th>Balance (₹)</th>
                                        <!-- <th>Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody id="employeePaymentBody"></tbody>



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
            <!-- Supplier Payment Tab -->
            <div class="tab-pane fade" id="suppliers" role="tabpanel" aria-labelledby="suppliers-tab">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">Supplier Payment List</h6>
                            </div>
                            <!-- <div class="col" align="right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addSupplierPaymentModal"
                                    role="button">
                                    <i class="fas fa-plus-circle"></i> Add Payment
                                </button>
                            </div> -->
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Supplier_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style=display:none>Supplier ID</th>
                                        <th style=display:none>Payment ID</th>
                                        <th style=display:none>PO ID</th>
                                        <td style='display:none'>0</td> <!-- 2 PO ID -->
                                        <th style=display:none>Supplier Address</th>
                                        <th>Supplier Name</th>
                                        <th>Total Amt</th>
                                        <th>Paid Amt</th>
                                        <th>Balance Amt</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $supplierList = DBsupplierpayment::getAllsupplierpayment();
                                    foreach ($supplierList as $supplier) {
                                        echo "<tr><td style=display:none >" . $supplier->get_supplierId() . "</td>
                        <td style=display:none >" . $supplier->get_supplierpaymentId() . "</td>
                        <td>" . $supplier->get_suppliername() . "</td>
                        <td style=display:none >" . $supplier->get_supplierAddress() . "</td>
                        <td>" . $supplier->get_totalamt() . "</td>
                        <td>" . $supplier->get_paidamt() . "</td>
                        <td>" . $supplier->get_pendingamt() . "</td>
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
                                    
                                    <button class='btn btn-primary dropdown-item view-supplier-transaction'
    data-supplierid='" . $supplier->get_supplierId() . "'
    data-bs-toggle='modal'
    data-bs-target='#supplierTransactionModal'>
    <i class='fas fa-info'></i> View Transaction
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
                <div class="modal fade" id=supplierpaymentinfoModal tabindex=-1 role=dialog aria-hidden=true>
                    <div class="modal-dialog modal-xl">
                        <div class="row gutters-sm">
                            <div class="col-md-2 mb-2">
                            </div>
                            <div class="col-md-10">
                                <form class="form" action="../Controller/supplierpaymentcontroller.php" method="POST"
                                    id="supplierPaymentForm" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="col-md-6 control-label">Supplier Name <span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="suppliername" id="suppliername"
                                                            class="form-control" required
                                                            data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                            data-parsley-maxlength="150" data-parsley-trigger="keyup"
                                                            readonly />
                                                        <input type="hidden" id="sup_supplierId" name="supplierId"
                                                            value="">
                                                        <input type="hidden" id="supplierpaymentid"
                                                            name="supplierpaymentid" value="">
                                                        <input type="hidden" id="POID" name="POID" value="">

                                                    </div>
                                                </div>
                                                <br />

                                                <div class="col-md-6">
                                                    <label class="col-md-6 control-label">Total Amount<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="totalamt" id="sup_totalamt"
                                                            class="form-control" required data-parsley-trigger="keyup"
                                                            value="<?php echo $supplier->get_totalamt() ?>" />
                                                    </div>
                                                </div>
                                                <br />

                                                <div class="col-md-6">
                                                    <label class="col-md-6 control-label">Paid Amount<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="paidamt" id="sup_paidamt"
                                                            class="form-control" required data-parsley-trigger="keyup"
                                                            readonly
                                                            value="<?php echo $supplier->get_receivedamt() ?>" />
                                                    </div>
                                                </div>
                                                <br />

                                                <div class="col-md-6">
                                                    <label class="col-md-6 control-label">Payment<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="receivedamt" id="sup_receivedamt"
                                                            class="form-control" required
                                                            data-parsley-trigger="keyup" />
                                                    </div>
                                                </div>
                                                <br />

                                                <div class="col-md-6">
                                                    <label class="col-md-6 control-label">Pending Amount<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="pendingamt" id="sup_pendingamt"
                                                            class="form-control" required data-parsley-trigger="keyup"
                                                            readonly
                                                            value="<?php echo $supplier->get_pendingamt() ?>" />
                                                    </div>
                                                </div>
                                                <br />

                                                <div class="col-md-6">
                                                    <label class="col-md-6 control-label">Payment Plan<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select" id="sup_paymentplan"
                                                            name="paymentplan" required>
                                                            <option value="">Payment Plan</option>
                                                            <option value="Part Payment">Part Payment</option>
                                                            <option value="Full Payment">Full Payment</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br />


                                                <div id="duedatediv" class="col-md-6" style="display: none">
                                                    <label for="duedate" class="col-md-6 control-label"> Next payment
                                                        on:</label>
                                                    <div class="col-sm-12">
                                                        <input type="date" id="sup_duedate" name="duedate"
                                                            class="form-control" required />
                                                    </div>
                                                </div>
                                                <br />

                                                <div class="col-md-6">
                                                    <label for="pmode" class="col-md-6 control-label">Payment
                                                        Mode</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select" id="sup_paymentmode"
                                                            name="paymentmode" required>
                                                            <option value="">Select Mode</option>
                                                            <option value="Advance Payment">Advance Payment</option>
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
                                                        <input type="text" id=" RTGSno" name="RTGSno"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                                <br />

                                                <div id="chequediv" class="col-md-6" style="display: none">
                                                    <label for="chequeimg" class=" col-md-6 form-label">Upload the image
                                                        of
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
                                                            name="paymentdescription" placeholder="Payment Description"
                                                            class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <br />

                                                <div class="col-md-6">
                                                    <input type="hidden" name="modifiedby" id="sup_modifiedby"
                                                        class="form-control" required data-parsley-type="integer"
                                                        data-parsley-minlength="10" data-parsley-maxlength="12"
                                                        data-parsley-trigger="keyup"
                                                        value="<?php echo $_SESSION['login_user']; ?>" />

                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="sup_btn" type="submit"
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
                <div class="modal fade" id=supplierTransactionModal tabindex=-1 role=dialog aria-hidden=true>
                    <div class="modal-dialog modal-xl">
                        <div class="row gutters-sm">
                            <div class="col-md-2 mb-2">
                            </div>
                            <div class="col-md-10">
                                <form class="form" method="POST" action="../Controller/pdfGeneratorController.php"
                                    target="_blank" id="supplierTransactionForm">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12" id="sup_printTransaction">

                                                <table class="table table-bordered  container" id="SupplierTransaction">
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
                                                                <h5>Supplier Details</h5>
                                                            </td>
                                                            <td colspan="3">
                                                                <h5>Transaction Details</h5>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                Supplier Name :- <span
                                                                    id="transactionsuppliername"></span>
                                                            </td>
                                                            <td colspan="3">
                                                                Location :- <span id="transactionLocation"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td colspan="3">
                                                                Date :-
                                                                <?php echo $date = date('d/m/Y '); ?>
                                                            </td>
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
                                                            <td id="sup_pending" style="text-align:center"></td>
                                                            <td id="sup_totalpaidAmount" style="text-align:center"></td>
                                                        </tr>
                                                    </tfoot>

                                                </table>
                                                <div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <input type="hidden" name="createdby" id="createdby"
                                                                class="form-control" required
                                                                value="<?php echo $_SESSION['login_user']; ?>" />
                                                            <input type="hidden" name="modifiedby" id="sup_modifiedby"
                                                                class="form-control" required
                                                                value="<?php echo $_SESSION['login_user']; ?>" />
                                                            <input type="hidden" id="sup_supplierId"
                                                                value="<?php echo $supplier->get_supplierId(); ?>" />
                                                        </div>
                                                    </div>
                                                    <input type="submit" name="submit" id="PDF" class="btn btn-success"
                                                        value="Save AS PDF" />
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
            </div>
        </div>
    </div>
    <!-- ===================== ALL EXPENSE MODAL ===================== -->
    <div class="modal fade" id="allExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <form id="allExpenseForm" method="POST" action="../Controller/expenseController.php">
                <div class="modal-content shadow-lg rounded-4">

                    <!-- Header -->
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-plus-circle me-2 text-success"></i>
                            Transactions
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body pt-3">
                        <div class="row g-3">

                            <!-- Date -->
                            <!-- <div class="col-12">
                            <label class="form-label fw-medium">Date</label>
                            <input type="date" id="ae_date" class="form-control form-control-lg"
                                value="<?= date('Y-m-d'); ?>" required>
                        </div> -->

                            <!-- Type -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Type</label>
                                <select id="ae_type" name="type" class="form-select form-select-lg" required>
                                    <option value="">Select Type</option>
                                    <option value="Expense">Expense</option>
                                    <option value="Income">Income</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Category</label>
                                <select id="ae_category" class="form-select form-select-lg" required>
                                    <option value="">Select Category</option>
                                    <option value="projects">Customer</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <!-- <div class="col-12">
                            <label class="form-label fw-medium">Notes</label>
                            <textarea id="ae_notes" class="form-control" rows="3"
                                placeholder="Optional remarks..."></textarea>
                        </div> -->

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 pt-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            Next →
                        </button>
                    </div>
                    <input type="hidden" name="action" value="add">

                    <input type="hidden" name="subcategory_id" id="ae_subcategory_id">
                    <input type="hidden" name="subcategory_name" id="ae_subcategory_name">
                    <input type="hidden" name="amount" id="ae_amount">
                    <input type="hidden" name="expense_date" value="<?= date('Y-m-d'); ?>">
                    <input type="hidden" name="payment_type" value="Cash">
                    <input type="hidden" name="notes" id="ae_notes">

                </div>
            </form>
        </div>
    </div>
    <!-- ===================== ADD MODAL ===================== -->
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="../Controller/expenseController.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="type" id="expense_type">

                <div class="modal-content shadow-lg rounded-4">
                    <!-- Header -->
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-wallet2 me-2 text-success"></i>
                            Add Expense
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body pt-0">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label fw-medium">Date</label>
                                <input type="date" name="expense_date" class="form-control form-control-lg"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Category</label>
                                <input type="text" id="addCategoryType" name="category_type"
                                    class="form-control form-control-lg bg-light" value=" General" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-medium">Subcategory</label>
                                <select name="subcategory_id" id="subcategorySelect" class="form-select form-select-lg"
                                    required>

                                    <option value="">Select Subcategory</option>
                                    <?php foreach ($generalSubcategories as $sub): ?>
                                        <option value="<?= $sub->getId(); ?>"
                                            data-name="<?= htmlspecialchars($sub->getName()); ?>">
                                            <?= htmlspecialchars($sub->getName()); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <input type="hidden" name="subcategory_name" id="subcategoryName">
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-medium">Amount (₹)</label>
                                <input type="number" step="0.01" name="amount" class="form-control form-control-lg"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-medium">Payment Mode</label>
                                <select name="payment_type" class="form-select form-select-lg">
                                    <option>Cash</option>
                                    <option>Bank Transfer</option>
                                    <option>UPI</option>
                                    <option>Cheque</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-medium">Notes</label>
                                <textarea name="notes" class="form-control" rows="3"
                                    placeholder="Optional notes..."></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 pt-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            Add Expense
                        </button>
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
                                <input type="date" name="expense_date" id="editExpenseDate" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <select name="category" id="editCategorySelect" class="form-select" required>
                                    <option value="">Select Category</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Type</label>
                                <input type="text" id="editCategoryType" name="category_type"
                                    class="form-control bg-light" readonly>
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
    <!-- ===================== SALARY EXPENSE MODAL ===================== -->
    <div class="modal fade" id="salaryExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="employeePaymentForm">

                <input type="hidden" name="action" value="add">
                <input type="hidden" name="type" id="salary_expense_type">
                <div class="modal-content shadow-lg rounded-4">
                    <!-- Header -->
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-person-badge me-2 text-primary"></i>
                            Employee Payment
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body pt-0">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Date *</label>
                                <input type="date" name="payment_date" class="form-control form-control-lg"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Employee *</label>
                                <select name="emp_id" class="form-select form-select-lg" required>
                                    <option value="">Select Employee</option>
                                    <?php foreach ($employees as $emp): ?>
                                        <option value="<?= $emp['id'] ?>">
                                            <?= htmlspecialchars($emp['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Due Amount (₹)</label>
                                <input type="text" name="due_amount" class="form-control form-control-lg bg-light"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Amount *</label>
                                <input type="number" step="0.01" name="amount" class="form-control form-control-lg"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Payment Type</label>
                                <select name="payment_type" class="form-select form-select-lg">
                                    <option>Cash</option>
                                    <option>Bank Transfer</option>
                                    <option>UPI</option>
                                    <option>Cheque</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Status</label>
                                <select name="status" class="form-select form-select-lg">
                                    <option>Paid</option>
                                    <!-- <option>Pending</option> -->
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-medium">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="3"
                                    placeholder="Optional remarks..."></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 pt-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            Save Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- ===================== PROJECT INCOME MODAL ===================== -->
    <div class="modal fade" id="projectIncomeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="../Controller/customerpaymentcontroller.php">

                <!-- 🔑 identify this as project income -->
                <input type="hidden" name="action" value="project_income">
                <input type="hidden" name="type" id="project_income_type">

                <div class="modal-content shadow-lg rounded-4">

                    <!-- Header -->
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-cash-coin me-2 text-success"></i>
                            Project Income
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body pt-0">
                        <div class="row g-3">

                            <!-- Date -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Date</label>
                                <input type="date" name="paymentdate" class="form-control form-control-lg"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <!-- Category -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Category</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="Customer"
                                    readonly>
                            </div>

                            <!-- Customer -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Customer Name</label>
                                <select id="pi_customer" class="form-select form-select-lg" required>
                                    <option value="">Select Customer</option>

                                    <?php foreach ($approvedCustomers as $c): ?>
                                        <option value="<?= $c['customerCode']; ?>" data-custid="<?= $c['customerCode']; ?>"
                                            data-custname="<?= htmlspecialchars($c['customerName']); ?>"
                                            data-customercity="<?= htmlspecialchars($c['customerCity']); ?>">
                                            <?= htmlspecialchars($c['customerName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                            <!-- Auto Fields -->
                            <div class=" col-md-4">
                                <label class="form-label fw-medium">Customer ID</label>
                                <input type="text" name="custid" id="pi_custid"
                                    class="form-control form-control-lg bg-light" readonly>
                            </div>



                            <div class="col-md-4">
                                <label class="form-label fw-medium">Location</label>
                                <input type="text" name="customercity" id="pi_customercity"
                                    class="form-control form-control-lg bg-light" readonly>
                            </div>


                            <!-- Customer Contact No -->
                            <!-- <div class="col-md-4">
                            <label class="form-label fw-medium">Customer Contact No</label>
                            <input type="text" name="custcontactno" id="pi_custcontact"
                                class="form-control form-control-lg bg-light" readonly>
                        </div> -->

                            <!-- Total Amount -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Total Amount (₹)</label>
                                <input type="number" name="totalamt" id="pi_totalamt"
                                    class="form-control form-control-lg bg-light" readonly>
                            </div>

                            <!-- Received Amount -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Received Amount (₹)</label>
                                <input type="number" step="0.01" name="receivedamt" id="pi_receivedamt"
                                    class="form-control form-control-lg">
                            </div>

                            <!-- Paid Amount -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Paid Amount (₹)</label>
                                <input type="number" name="paidamt" id="pi_paidamt"
                                    class="form-control form-control-lg bg-light" readonly>
                            </div>

                            <!-- Pending Amount -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Pending Amount (₹)</label>
                                <input type="number" name="pendingamt" id="pi_pendingamt"
                                    class="form-control form-control-lg bg-light" readonly>
                            </div>

                            <!-- Payment Plan -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Payment Plan</label>
                                <select name="paymentplan" id="pi_paymentplan" class="form-select form-select-lg">
                                    <option value="Full Payment">Full Payment</option>
                                    <option value="Part Payment">Part Payment</option>
                                </select>
                            </div>

                            <!-- Next Payment Date -->
                            <!-- <div class="col-md-4 d-none" id="pi_nextpayment_div">
                            <label class="form-label fw-medium">Next Payment On</label>
                            <input type="date" name="nextpaymentdate" id="pi_nextpaymentdate"
                                class="form-control form-control-lg">
                        </div> -->



                            <!-- Amount -->
                            <!-- <div class="col-md-4">
                            <label class="form-label fw-medium">Amount (₹)</label>
                            <input type="number" step="0.01" name="receivedamt" class="form-control form-control-lg"
                                required>
                        </div> -->

                            <!-- Payment Mode -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Payment Mode</label>
                                <select name="paymentmode" class="form-select form-select-lg">
                                    <option>Cash</option>
                                    <option>UPI</option>
                                    <option>Bank Transfer</option>
                                    <option>Cheque</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label class="form-label fw-medium">Payment Description</label>
                                <textarea name="paymentdescription" class="form-control" rows="3"
                                    placeholder="Project income notes..."></textarea>
                            </div>

                            <!-- Hidden required fields -->
                            <input type="hidden" name="custname" id="pi_custname">
                            <input type="hidden" name="cust_modifiedby" value="Admin">
                            <input type="hidden" name="paymentid" value="0">


                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 pt-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            Save Income
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- ===================== PROJECT EXPENSE MODAL ===================== -->
    <div class="modal fade" id="projectExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <form id="projectExpenseForm" method="POST" action="../Controller/expenseController.php">

                <div class="modal-content shadow-lg rounded-4">

                    <!-- Header -->
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-briefcase-fill me-2 text-danger"></i>
                            Project Expense
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div id="pe_success_msg" class="alert alert-success d-none fw-semibold" role="alert">
                        ✅ Project expense added successfully
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <div class="row g-3">

                            <!-- Date -->
                            <div class="col-md-3">
                                <label class="form-label fw-medium">Date</label>
                                <input type="date" name="expense_date" class="form-control"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <!-- Category (Fixed) -->
                            <div class="col-md-3">
                                <label class="form-label fw-medium">Category</label>
                                <input type="text" class="form-control" value="Customer" readonly>
                            </div>

                            <!-- Project / Customer -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Customer Name</label>
                                <select id="pe_project" class="form-select" required>
                                    <option value="">Select Project</option>
                                    <?php
                                    $customers = DBpayment::getCustomersWithApprovedQuotes();
                                    foreach ($customers as $c):
                                        ?>
                                        <option value="<?= $c['customerCode'] ?>" data-custid="<?= $c['customerCode'] ?>"
                                            data-projectid="<?= $c['projectId'] ?>"
                                            data-city="<?= htmlspecialchars($c['customerCity']) ?>">
                                            <?= htmlspecialchars($c['customerName']) ?>
                                        </option>
                                    <?php endforeach; ?>


                                </select>
                            </div>

                            <!-- Auto-filled fields -->
                            <div class="col-md-3">
                                <label class="form-label">Customer ID</label>
                                <input type="text" id="pe_custid" class="form-control" readonly>
                            </div>


                            <div class="col-md-3">
                                <label class="form-label">Location</label>
                                <input type="text" id="pe_location" class="form-control" readonly>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Total Amount</label>
                                <input type="text" id="pe_totalamt" class="form-control" readonly>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Paid Amount</label>
                                <input type="text" id="pe_paidamt" class="form-control" readonly>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Expenditure</label>
                                <input type="text" id="pe_expenditure" class="form-control" readonly>
                            </div>

                            <!-- Expense Input -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold text-danger">
                                    Expense Amount
                                </label>
                                <input type="number" name="amount" class="form-control" min="1" step="0.01" required>
                            </div>

                            <!-- Subcategory -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Subcategory</label>
                                <select name="subcategory_id" id="pe_subcategory" class="form-select" required>
                                    <option value="">Select Subcategory</option>
                                    <?php
                                    $subs = DBGeneralSubcategory::getAll();

                                    foreach ($subs as $sub) {
                                        ?>
                                        <option value="<?= $sub->getId(); ?>" data-name="<?= $sub->getName(); ?>">
                                            <?= $sub->getName(); ?>
                                        </option>
                                    <?php } ?>


                                </select>
                            </div>

                            <!-- Payment Mode -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Payment Mode</label>
                                <select name="payment_type" class="form-select" required>
                                    <option value="">Select Mode</option>
                                    <option>Cash</option>
                                    <option>UPI</option>
                                    <option>Bank Transfer</option>
                                    <option>Cheque</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Payment Description</label>
                                <input type="text" name="notes" class="form-control" placeholder="Optional remarks">
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-danger fw-semibold">
                            Save Expense
                        </button>
                    </div>



                    <!-- Hidden values -->
                    <input type="hidden" name="action" value="add_project_expense">
                    <input type="hidden" name="category" value="Projects">
                    <input type="hidden" name="customer_id" id="pe_hidden_custid">
                    <input type="hidden" name="project_id" id="pe_hidden_projectid">
                    <input type="hidden" name="subcategory_name" id="pe_subcategory_name">

                </div>
            </form>
        </div>
    </div>
    <!-- ===================== SUPPLIER EXPENSE MODAL ===================== -->
    <div class="modal fade" id="supplierExpenseModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <form id="supplierExpenseForm" method="POST" action="../Controller/expenseController.php">

                <div class="modal-content shadow-lg rounded-4">

                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            <i class="bi bi-truck me-2"></i> Supplier Expense
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            <!-- Date -->
                            <div class="col-md-3">
                                <label>Date</label>
                                <input type="date" name="expense_date" class="form-control"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <!-- Category -->
                            <div class="col-md-3">
                                <label>Category</label>
                                <input class="form-control" value="Suppliers" readonly>
                            </div>

                            <!-- Supplier -->
                            <div class="col-md-6">
                                <label>Supplier</label>
                                <select id="se_supplier" class="form-select" required>
                                    <option value="">Select Supplier</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <label>Address</label>
                                <input type="text" id="se_address" class="form-control" readonly>
                            </div>

                            <!-- Location -->
                            <div class="col-md-3">
                                <label>Location</label>
                                <input type="text" id="se_location" class="form-control" readonly>
                            </div>

                            <!-- GSTIN -->
                            <div class="col-md-3">
                                <label>GSTIN</label>
                                <input type="text" id="se_gstin" class="form-control" readonly>
                            </div>

                            <!-- Total -->
                            <div class="col-md-4">
                                <label>Total Amount</label>
                                <input type="text" id="se_total" class="form-control" readonly>
                            </div>

                            <!-- Paid -->
                            <div class="col-md-4">
                                <label>Paid Amount</label>
                                <input type="text" id="se_paid" class="form-control" readonly>
                            </div>

                            <!-- Balance -->
                            <div class="col-md-4">
                                <label>Balance Amount</label>
                                <input type="text" id="se_balance" class="form-control" readonly>
                            </div>

                            <!-- Expense -->
                            <div class="col-md-4">
                                <label class="text-danger fw-bold">Expense Amount</label>
                                <input type="number" name="amount" id="se_amount" class="form-control" required>
                            </div>

                            <!-- Payment -->
                            <div class="col-md-4">
                                <label>Payment Mode</label>
                                <select name="payment_type" class="form-select" required>
                                    <option>Cash</option>
                                    <option>UPI</option>
                                    <option>Bank Transfer</option>
                                    <option>Cheque</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="notes" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-danger">Save Expense</button>
                    </div>

                    <!-- hidden -->
                    <input type="hidden" name="action" value="add_supplier_expense">
                    <input type="hidden" name="supplier_id" id="se_supplier_id">

                </div>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https:/supplier_summary/cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script>
        let CD_CUST_ID = null;
        let CD_PENDING = null;

        $(document).on('click', '.credit-discount-btn', function () {
            CD_CUST_ID = $(this).data('custid');
            CD_PENDING = $(this).data('pending');

            console.log('Captured on click:', CD_CUST_ID, CD_PENDING);
        });

        console.count('EXPENSE JS LOADED');
        let seBasePaid = 0;

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
                $('#totalamt').val(this.cells[8].innerHTML);
                $('#transactiontotalamt').text(this.cells[7].innerHTML);
                $('#paidamt').val(this.cells[9].innerHTML);
                $('#paidAmount').val(this.cells[9].innerHTML);
                $('#pendingamt').val(this.cells[10].innerHTML);
                $('#quoteid').val(this.cells[7].innerHTML);

            });
            $('#Supplier_table tbody').on('click', 'tr', function () {

                $('#sup_supplierId').val(this.cells[0].innerHTML);      // Supplier ID
                $('#suppliername').val(this.cells[4].innerHTML);   // Supplier Name

                $('#sup_totalamt').val(this.cells[5].innerHTML);
                $('#sup_paidamt').val(this.cells[6].innerHTML);
                $('#sup_pendingamt').val(this.cells[7].innerHTML);
                // Balance Amt
            });
            $("#sup_paymentplan").change(function () {
                if ($(this).val() === "Part Payment") {
                    $("#sup_duedatediv").show();
                    $("#sup_duedate").prop("disabled", false);
                } else {
                    $("#sup_duedate").prop("disabled", true);
                }
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

            // $('#TransactionModal').on('show.bs.modal', function (e) {

            //     const btn = $(e.relatedTarget);
            //     const quoteCode = btn.data('quotecode');

            //     $('#Transactiontable tbody').empty();

            //     $.ajax({
            //         url: '../Controller/customerpaymentController.php',
            //         type: 'GET',                 // ✅ MUST BE GET
            //         dataType: 'json',
            //         data: {
            //             id: quoteCode            // ✅ MUST BE id
            //         },
            //         success: function (data) {

            //             if (!data || data.length === 0) {
            //                 $('#Transactiontable tbody').append(
            //                     '<tr><td colspan="5" class="text-center">No Transactions Found</td></tr>'
            //                 );
            //                 return;
            //             }

            //             let totalPaid = 0;
            //             let lastPending = 0;

            //             data.forEach((row, index) => {

            //                 totalPaid += parseFloat(row.receivedamt);
            //                 lastPending = row.pendingamt;

            //                 $('#Transactiontable tbody').append(`
            //             <tr>
            //                 <td class="text-center">${index + 1}</td>
            //                 <td class="text-center">${row.modifieddate}</td>
            //                 <td class="text-center">${row.paymentmode}</td>
            //                 <td class="text-center">${row.pendingamt}</td>
            //                 <td class="text-center">${row.receivedamt}</td>
            //             </tr>
            //         `);
            //             });

            //             $('#totalpaidAmount').text(totalPaid.toFixed(2));
            //             $('#pending').text(lastPending);
            //         }
            //     });
            // });

            // $('#Customer_table').DataTable({});

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

            $('#customerTransactionForm').submit(function (e) {
                e.preventDefault();
                $('#printPDF').remove();
                var content = $('#printTransaction').html();
                var fileName = $('#transactioncustcode').text() + '_CustTransaction';
                var uniturl = config.developmentPath + "/Admin/Controller/pdfGeneratorContorller.php";
                $.ajax({
                    type: "POST",
                    url: uniturl,
                    data: {
                        "cust_modifiedby": $('#cust_modifiedby').val(),
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



            // ===== DUE AMOUNT (Add & Edit modals) =====
            // $(document).on("change", 'select[name="emp_id"], input[name="payment_date"]', function () {
            //     var modal = $(this).closest(".modal");
            //     var empId = modal.find('select[name="emp_id"]').val();
            //     var dueField = modal.find("#add_due_amount, #edit_due_amount");

            //     if (!empId) {
            //         dueField.val("");
            //         return;
            //     }

            //     $.getJSON("../Controller/employeePaymentController.php",
            //         { action: "getTotalDue", emp_id: empId },
            //         function (data) {
            //             const v = parseFloat(data.due);
            //             dueField.val(isFinite(v) ? "₹ " + v.toFixed(2) : "₹ 0.00");
            //         }
            //     );
            // });
            function fetchDue(modal) {

                const empSelect = modal.find('select[name="emp_id"]');
                const payDate = modal.find('input[name="payment_date"]');
                const dueField = modal.find('input[name="due_amount"]');

                function updateDue() {
                    const empId = empSelect.val();
                    if (!empId) {
                        dueField.val('');
                        return;
                    }

                    const month = (payDate.val() || new Date().toISOString().slice(0, 10)).slice(0, 7);

                    // $.getJSON('../Controller/employeePaymentController.php',
                    //     { action: 'getDue', emp_id: empId, month: month },
                    //     function (data) {
                    //         const v = parseFloat(data.due);
                    //         dueField.val(isFinite(v) ? '₹ ' + v.toFixed(2) : '₹ 0.00');
                    //     }
                    // );
                }

                empSelect.off('change').on('change', updateDue);
                payDate.off('change').on('change', updateDue);

                updateDue();
            }

            $('#salaryExpenseModal').on('shown.bs.modal', function () {
                fetchDue($(this));
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

            // Populate category based on type
            $('#ae_type').on('change', function () {
                const category = $('#ae_category');
                category.empty().append('<option value="">Select Category</option>');

                if (this.value === 'Expense') {
                    ['General', 'Employee', 'Customer', 'Suppliers'].forEach(c => {
                        category.append(`<option value="${c}">${c}</option>`);
                    });
                }

                if (this.value === 'Income') {
                    ['Customer'].forEach(c => {
                        category.append(`<option value="${c}">${c}</option>`);
                    });
                }
            });


            // Handle NEXT button
            // Handle NEXT button
            $('#allExpenseForm').on('submit', function (e) {
                e.preventDefault();

                const type = $('#ae_type').val();
                const category = $('#ae_category').val();

                if (!type || !category) {
                    alert('Please select Type and Category');
                    return;
                }

                $('#allExpenseModal').modal('hide');

                if (type === 'Expense' && category === 'General') {
                    $('#expenseModal').modal('show');
                    return;
                }

                if (type === 'Expense' && category === 'Employee') {
                    $('#salaryExpenseModal').modal('show');
                    return;
                }

                if (type === 'Expense' && category === 'Customer') {
                    $('#projectExpenseModal').modal('show');
                    return;
                }

                if (type === 'Expense' && category === 'Suppliers') {
                    $('#supplierExpenseModal').modal('show');
                    return;
                }

                if (type === 'Income' && category === 'Customer') {
                    $('#projectIncomeModal').modal('show');
                    return;
                }

                alert('Invalid selection');
            });


            $('#subcategorySelect').on('change', function () {
                const name = $(this).find(':selected').data('name') || '';
                $('#subcategoryName').val(name);
            });
            $('#pi_customer').on('change', function () {

                const opt = $(this).find(':selected');
                if (!opt.val()) return;

                $('#pi_custid').val(opt.data('custid'));
                $('#pi_custname').val(opt.data('custname'));
                // $('#pi_projectcode').val(opt.data('quotecode')); // 🔑 USE QUOTE CODE
                $('#pi_customercity').val(opt.data('customercity'));

                $.ajax({
                    url: '../Controller/customerpaymentcontroller.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'getCustomerProjectSummary',
                        custid: opt.data('custid')
                    },
                    success: function (res) {
                        if (res.status !== 'success') {
                            alert(res.message);
                            return;
                        }

                        $('#pi_totalamt').val(res.total);
                        $('#pi_paidamt').val(res.paid).data('base', res.paid);
                        $('#pi_pendingamt').val(res.pending);
                        $('#pi_receivedamt').val('');
                    }
                });

            });

            // When customer is selected in Project Income modal
            // $('#Customer_table tbody').on('click', 'tr', function () {

            //     $('#pi_custcontact').val(this.cells[3].innerHTML);
            //     $('#pi_totalamt').val(this.cells[8].innerHTML);
            //     $('#pi_paidamt').val(this.cells[9].innerHTML);
            //     $('#pi_pendingamt').val(this.cells[10].innerHTML);

            // });
            $('#pi_receivedamt').on('input', function () {

                let total = parseFloat($('#pi_totalamt').val()) || 0;
                let recv = parseFloat($(this).val()) || 0;

                let basePaid = parseFloat($('#pi_paidamt').data('base')) || 0;

                if (recv + basePaid > total) {
                    alert("Received amount exceeds pending amount");
                    $(this).val('');
                    return;
                }

                let paid = basePaid + recv;
                let pending = total - paid;

                $('#pi_paidamt').val(paid.toFixed());
                $('#pi_pendingamt').val(pending.toFixed(2));
            });

            $('input[name="amount"]').on('input', function () {

                const total = parseFloat($('#se_total').val()) || 0;
                const paid = parseFloat($('#se_paid').val()) || 0;
                const current = parseFloat($(this).val()) || 0;

                const paidPreview = paid + current;
                const balance = total - paidPreview;

                $('#se_paid').val(paidPreview.toFixed(2));
                $('#se_balance').val(balance.toFixed(2));
            });


            // $('#pi_paymentplan').on('change', function () {

            //if ($(this).val() === 'Part Payment') {
            //$('#pi_nextpayment_div').removeClass('d-none');

            //let today = new Date().toISOString().split('T')[0];
            //$('#pi_nextpaymentdate').attr('min', today).prop('required', true);

            //} else {
            //  $('#pi_nextpayment_div').addClass('d-none');
            // $('#pi_nextpaymentdate').val('').prop('required', false);
            // }
            // });
            $('#projectIncomeModal form').on('submit', function (e) {
                debugger;
                e.preventDefault();

                $.ajax({
                    url: '../Controller/customerpaymentcontroller.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (res) {
                        console.log('SUMMARY RESPONSE:', res);

                        if (res.status === 'success') {

                            const cid = res.custid;

                            // ✅ Update table instantly
                            $('#total_' + cid).text(res.total);
                            $('#paid_' + cid).text(res.paid);
                            $('#pending_' + cid).text(res.pending);

                            // ✅ RESET MODAL FORM
                            const modal = $('#projectIncomeModal');

                            modal.find('form')[0].reset();

                            // reset calculated fields explicitly
                            modal.find('#pi_paidamt').val('0.00');
                            modal.find('#pi_pendingamt').val('');
                            modal.find('#pi_totalamt').val('');
                            modal.find('#pi_receivedamt').val('');

                            // hide optional sections
                            // $('#pi_nextpayment_div').addClass('d-none');
                            // $('#pi_nextpaymentdate').val('').prop('required', false);

                            // close modal
                            modal.modal('hide');

                            alert(res.message);
                        }
                    }


                    ,
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Server error while saving income');
                    }

                });
            });
            $('#pe_project').on('change', function () {

                const opt = this.options[this.selectedIndex];
                const custId = opt.dataset.custid;
                const city = opt.dataset.city;
                const projectId = opt.dataset.projectid;

                if (!custId) return;

                $('#pe_custid').val(custId);
                $('#pe_hidden_custid').val(custId);
                $('#pe_location').val(city);
                $('#pe_hidden_projectid').val(projectId);

                // 1️⃣ Fetch TOTAL & PAID
                $.getJSON('../Controller/customerpaymentcontroller.php', {
                    action: 'getCustomerProjectSummary',
                    custid: custId
                }, function (res) {
                    if (res.status === 'success') {
                        $('#pe_totalamt').val(res.total);
                        $('#pe_paidamt').val(res.paid);
                    } else {
                        $('#pe_totalamt').val(0);
                        $('#pe_paidamt').val(0);
                    }
                });

                // 2️⃣ Fetch EXPENDITURE (SEPARATE CALL)
                $.getJSON('../Controller/expenseController.php', {
                    action: 'getCustomerProjectExpense',
                    custid: custId
                }, function (res) {

                    console.log('Expenditure Response:', res);

                    if (res.status === 'success') {
                        $('#pe_expenditure').val(res.expenditure);
                    } else {
                        $('#pe_expenditure').val(0);
                    }
                });
            });


            $('#projectExpenseForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',

                    success: function (res) {

                        if (res.status === 'success') {

                            /* 1️⃣ SHOW SUCCESS MESSAGE */
                            $('#pe_success_msg')
                                .removeClass('d-none')
                                .hide()
                                .fadeIn();

                            /* 2️⃣ RESET INPUT FIELDS (KEEP PROJECT SELECTED) */
                            // clear only user-entered fields
                            $('#projectExpenseForm')
                                .find('input[name="amount"], input[name="notes"]')
                                .val('');

                            $('#projectExpenseForm')
                                .find('select')
                                .not('#pe_project')
                                .prop('selectedIndex', 0);


                            /* 3️⃣ REFRESH EXPENDITURE */
                            $('#pe_project').trigger('change');

                            /* 4️⃣ AUTO-HIDE MESSAGE AFTER 3 SECONDS */
                            setTimeout(function () {
                                $('#pe_success_msg').fadeOut();
                            }, 3000);
                        }
                    },

                    error: function () {
                        alert('Server error while saving expense');
                    }
                });
            });
            $('#projectExpenseModal').modal('hide');

            $('#projectExpenseModal').on('shown.bs.modal', function () {
                const projectId = $('#pe_project').val();
                if (projectId) {
                    $('#pe_project').trigger('change'); // 🔑 force reload
                }
            });
            $('#projectExpenseModal').on('shown.bs.modal', function () {

                const custId = $('#pe_hidden_custid').val();

                if (!custId) return;

                // fetch expenditure every time modal opens
                $.getJSON('../Controller/expenseController.php', {
                    action: 'getCustomerProjectExpense',
                    custid: custId
                }, function (res) {

                    console.log('Expenditure Response:', res);

                    if (res.status === 'success') {
                        $('#pe_expenditure').val(res.expenditure);
                    } else {
                        $('#pe_expenditure').val('0.00');
                    }
                });
            });

            // $('#projectIncomeModal').on('shown.bs.modal', function () {
            //     const quoteId = $('#pi_projectcode').val();
            //     if (!quoteId) return;

            //     $.getJSON('../Controller/customerpaymentcontroller.php', {
            //         action: 'getQuotationTotal',
            //         quoteid: quoteId
            //     }, function (res) {
            //         $('#pi_totalamt').val(res.total);
            //         $('#pi_paidamt').val(res.paid);
            //         $('#pi_pendingamt').val(res.total - res.paid);
            //     });
            // });


            $(document).on('click', '.view-transaction', function (e) {
                e.preventDefault();

                const custId = $(this).data('custid');

                if (!custId) {
                    alert('Customer ID missing');
                    return;
                }
                $.getJSON('../Controller/customerpaymentcontroller.php', {
                    action: 'getCustomerInfo',
                    custid: custId
                }, function (res) {
                    $('#transactioncustomerLocation').text(res.customerCity || '-');
                    $('#transactioncustname').text(res.custname);
                    $('#transactioncustcontactno').text(res.custcontactnumber);
                    $('#transactioncustcode').text(res.custid);
                });
                const tbody = $('#Transactiontable tbody');
                tbody.empty();

                $.ajax({
                    url: '../Controller/customerpaymentController.php',
                    type: 'GET',
                    dataType: 'json',
                    data: { custid: custId },
                    success: function (data) {



                        if (!data || data.length === 0) {
                            tbody.append(`<tr><td colspan="5" class="text-center">No Transactions</td></tr>`);
                            $('#TransactionModal').modal('show');
                            return;
                        }

                        let totalPaid = 0;
                        let totalAmount = 0;

                        data.forEach((row, index) => {
                            const paid = Number(row.receivedamt) || 0;

                            if (index === 0) {
                                totalAmount = Number(row.totalamt) || 0;
                            }

                            tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.modifieddate}</td>
                        <td>${row.paymentmode}</td>
                        <td>${(totalAmount - totalPaid).toFixed(2)}</td>
                        <td>${paid.toFixed(2)}</td>
                    </tr>
                `);

                            totalPaid += paid;
                        });

                        $('#totalpaidAmount').text(totalPaid.toFixed(2));
                        $('#pending').text((totalAmount - totalPaid).toFixed(2));

                        $('#TransactionModal').modal('show');
                    }
                });
            });



            function loadCustomerExpenditure(custId) {
                $('#pe_expenditure').val('0.00'); // default first

                $.getJSON('../Controller/expenseController.php', {
                    action: 'getCustomerProjectExpense',
                    custid: custId
                }, function (res) {

                    console.log('Expenditure Response:', res);

                    if (res.status === 'success') {
                        $('#pe_expenditure').val(res.expenditure);
                    }
                });
            }
            $('#Customer_table tbody').on('click', 'tr', function () {
                debugger;
                /* Get the row as a parent of the link that was clicked on */
                // $('#supplierId').val(this.cells[0].innerHTML);
                $('#paymentid').val(this.cells[1].innerHTML);
                // $('#suppliername').val(this.cells[3].innerHTML);
                // $('#transactionsuppliername').text(this.cells[3].innerHTML);
                $('#supplierAddress').text(this.cells[4].innerHTML);
                // $('#transactionsupplierAddress').text(this.cells[4].innerHTML);
                $('#totalamt').val(this.cells[6].innerHTML);
                $('#transactiontotalamt').text(this.cells[6].innerHTML);
                $('#paidamt').val(this.cells[7].innerHTML);
                $('#pendingamt').val(this.cells[8].innerHTML);
            });

            $("#supplierPaymentForm :input").prop("disabled", false);
            $(document).on('click', '.supplier-payment-btn', function () {
                if (!parseInt($('#totalamt').val())) {
                    $('#totalamt').focus();
                    $('#paidamt').prop('disabled', true);
                } else {
                    $('#totalamt').prop('readonly', true);
                }
            });


            $('#supplierpaymentinfoModal').on('show.bs.modal', function (e) {
                var rowid = $(e.relatedTarget).data('id');

                var TotalPendingAmount = 0;
                $('#supplierId').val(rowid);
                var PurchaseId = $('#POID').val();
                var transactionUrl = config.developmentPath +
                    "/Admin/Controller/supplierpaymentcontroller.php?id=" + rowid + "&POID=" + PurchaseId;
                console.log(transactionUrl);

                $.getJSON(transactionUrl, function (data) {
                    $.each(data, function (index, value) {
                        debugger;
                        TotalPendingAmount = parseInt(value.pendingamt)

                    });
                    $('#sup_pendingamt').text(TotalPendingAmount);
                });


            });

            $(document).on('click', '.view-supplier-transaction', function () {

                const supplierId = $(this).data('supplierid');

                // 1️⃣ Fetch supplier MASTER data (correct source)
                $.getJSON('../Controller/supplierExpenseController.php', {
                    action: 'supplier_summary',
                    supplier_id: supplierId
                }, function (res) {

                    $('#transactionsuppliername').text(res.item_compName || '-');
                    $('#transactionLocation').text(res.item_compLocation || '-');
                });

                // 2️⃣ Load transaction list (existing logic – unchanged)
                const tbody = $('#SupplierTransaction tbody');
                tbody.empty();

                let totalPaid = 0;
                let lastPending = 0;

                $.getJSON(
                    '../Controller/supplierpaymentcontroller.php',
                    { id: supplierId },
                    function (data) {

                        if (!data || data.length === 0) {
                            tbody.append(
                                '<tr><td colspan="5" class="text-center">No Transactions Found</td></tr>'
                            );
                            $('#supplierTransactionModal').modal('show');
                            return;
                        }

                        data.forEach((row, index) => {
                            totalPaid += parseFloat(row.receivedamt);
                            lastPending = row.pendingamt;

                            tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.modifieddate}</td>
                        <td>${row.paymentmode}</td>
                        <td>${row.pendingamt}</td>
                        <td>${row.receivedamt}</td>
                    </tr>
                `);
                        });

                        $('#sup_pending').text(lastPending);
                        $('#sup_totalpaidAmount').text(totalPaid.toFixed(2));
                        $('#supplierTransactionModal').modal('show');
                    }
                );
            });


            var dataTable = $('#Customer_table').DataTable({

            });

            var nEditing = null;

            $("#paymentplan").change(function () {

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
                    if (parseInt($("#paidamt").val()) > 0 && parseInt($("#pendingamt").val()) !=
                        0) {
                        $("#btn").attr("disabled", true);
                        alert("Payment is still due");
                    }

                    $("#duedate").attr('disabled', true);
                }
            });

            $("#totalamt").change(function () {
                if (parseInt($(this).val()) > 0) {
                    $('#paidamt').attr('disabled', false);
                }
            });

            $("#receivedamt").change(function (e) {
                debugger;
                $("#pendingamt").val(parseInt($("#pendingamt").text()) - $(this).val());
                $('#paidamt').val($('#totalamt').val() - $("#pendingamt").val());
                if ($(this).val() > parseInt($('#totalamt').val())) {
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
            if (parseInt($("#totalamt").val()) == 0) {
                $("#myForm :input").prop("disabled", false);
            }

            $("#paymentmode").change(function () {
                debugger;
                if ($(this).val() == "Net Banking") {
                    $("#rtgsdiv").show();
                    $("#chequediv").hide();
                } else if ($(this).val() == "Cheque") {
                    $("#rtgsdiv").hide();
                    $("#chequediv").show();
                } else {
                    $("#rtgsdiv").hide();
                    $("#chequediv").hide();
                }
            });

            $('#supplierTransactionForm').submit(function (e) {
                debugger;
                $('#PDF').remove();
                var content = $('#sup_printTransaction').html();
                var fileName = $('#transactionPOcode').text() + '_Transaction';

                var uniturl = config.developmentPath +
                    "/Admin/Controller/pdfGeneratorContorller.php";

                $.ajax({
                    type: "POST",
                    url: uniturl,
                    data: {
                        "sup_modifiedby": $('#sup_modifiedby').val(),
                        "supplierId": $('#supplierId').val(),
                        "fileType": "supplierpayment",
                        // "waterMarked": waterMarked,
                        "fileName": fileName,
                        "html": content
                    },
                    dataType: "json",
                    encode: true,
                }).done(function (data) {
                    console.log(data);
                    setTimeout(function () {
                        $('#sup_printTransaction').html('');
                    }, 10000);
                });

                window.open(config.developmentPath + '/Admin/pdfs/supplierpayment/' + fileName
                    .trim() + '.pdf');
            });
            // load suppliers
            $.getJSON('../Controller/supplierExpenseController.php?action=suppliers', res => {
                res.forEach(s => {
                    $('#se_supplier').append(`<option value="${s.item_compid}">${s.item_compName}</option>`);
                });
            });

            $('#se_supplier').on('change', function () {
                const sid = this.value;
                $('#se_supplier_id').val(sid);

                $.getJSON('../Controller/supplierExpenseController.php', {
                    action: 'supplier_summary',
                    supplier_id: sid
                }, function (res) {

                    console.log('SUPPLIER SUMMARY RESPONSE:', res);


                    $('#se_address').val(res.item_compAddress || '');
                    $('#se_location').val(res.item_compLocation || '');
                    $('#se_gstin').val(res.item_compGSTIN || '');

                    $('#se_total').val(res.total_amount || 0);
                    $('#se_paid').val(res.paid_amount || 0);
                    $('#se_balance').val(res.balance_amount || 0);

                    seBasePaid = parseFloat(res.paid_amount) || 0;


                    // clear expense input
                    $('#se_amount').val('');
                });
            });
            $('#se_amount').on('input', function () {

                const total = parseFloat($('#se_total').val()) || 0;
                const current = parseFloat(this.value) || 0;

                const paidPreview = seBasePaid + current;
                const balance = total - paidPreview;

                $('#se_paid').val(paidPreview.toFixed(2));
                $('#se_balance').val(balance.toFixed(2));

                if (balance < 0) {
                    this.setCustomValidity('Expense exceeds balance');
                } else {
                    this.setCustomValidity('');
                }
            });
            $('#supplierExpenseForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function () {

                        const sid = $('#se_supplier_id').val();

                        $.getJSON('../Controller/supplierExpenseController.php', {
                            action: 'supplier_summary',
                            supplier_id: sid
                        }, function (res) {

                            $('#Supplier_table tbody tr').each(function () {
                                if ($(this).find('td:eq(0)').text() == sid) {
                                    $(this).find('td:eq(5)').text(res.total_amount);
                                    $(this).find('td:eq(6)').text(res.paid_amount);
                                    $(this).find('td:eq(7)').text(res.balance_amount);
                                }
                            });

                        });

                        $('#supplierExpenseModal').modal('hide');
                    }
                    ,
                    error: function () {
                        alert('Error saving supplier expense');
                    }
                });
            });

            $('#CreditdiscountModal').on('show.bs.modal', function (e) {
                const btn = $(e.relatedTarget);

                const custId = btn.data('custid');
                const pending = btn.data('pending');

                // store on modal
                $(this).data('custid', custId);
                $(this).data('pending', pending);

                console.log('CD custId:', custId);
                console.log('CD pending:', pending);
            });


            $('#creditDiscount_form').on('submit', function (e) {
                e.preventDefault();

                // force values
                $('#cd_custId').val(CD_CUST_ID);
                $('#cd_pendingAmount').val(CD_PENDING);

                console.log('Submitting:', CD_CUST_ID, CD_PENDING);

                $.ajax({
                    type: "POST",
                    url: "../Controller/customerpaymentcontroller.php",
                    dataType: "json",
                    data: $(this).serialize() + '&action=credit',
                    success: function (res) {
                        alert(res.message);
                        if (res.status === 'success') location.reload();
                    }
                });
            });

            // ================= EMPLOYEE DUE AMOUNT (FIXED) =================
            $(document).on('change', 'select[name="emp_id"]', function () {
                const empId = $(this).val();
                const modal = $('#salaryExpenseModal');

                if (!empId) return;

                $.getJSON('../Controller/employeePaymentController.php', {
                    action: 'getEmployeeSummary',
                    emp_id: empId
                }, function (res) {

                    // ✅ Show due amount only
                    modal.find('input[name="due_amount"]').val('₹ ' + res.balance.toFixed(2));

                    // ❌ DO NOT auto-fill amount
                    modal.find('input[name="amount"]').val('');
                });
            });

            function loadEmployeePaymentTable() {
                $.getJSON('../Controller/employeePaymentController.php', {
                    action: 'getEmployeeSummary'
                }, function (data) {

                    const tbody = $('#employeePaymentBody');
                    tbody.empty();

                    data.forEach(row => {
                        tbody.append(`
                <tr>
                    <td>${row.emp_name}</td>
                    <td>₹ ${row.total_amount.toFixed(2)}</td>
                    <td class="text-success">₹ ${row.paid_amount.toFixed(2)}</td>
                    <td class="${row.balance <= 0 ? 'text-success' : 'text-danger'}">
                        ₹ ${row.balance.toFixed(2)}
                    </td>
                </tr>
            `);
                    });

                    // ✅ INIT DATATABLE AFTER ROWS ARE ADDED
                    initEmployeePaymentDataTable();
                });
            }


            // load on page open
            $(document).ready(loadEmployeePaymentTable);

            // reload after payment added
            $('#salaryExpenseModal form').on('submit', function () {
                setTimeout(loadEmployeePaymentTable, 500);
            });
            $('#employeePaymentForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '../Controller/employeePaymentController.php',
                    type: 'POST',
                    data: $(this).serialize() + '&action=add',
                    success: function () {

                        // ✅ close modal
                        $('#addPaymentModal').modal('hide');

                        // ✅ reload employee table
                        loadEmployeePaymentTable();

                        // ✅ reset form
                        $('#employeePaymentForm')[0].reset();

                        alert('Payment added successfully');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Failed to add payment');
                    }
                });
            });
            let employeePaymentDT = null;

            function initEmployeePaymentDataTable() {
                if ($.fn.DataTable.isDataTable('#employee_payment_table')) {
                    employeePaymentDT.destroy();
                }

                employeePaymentDT = $('#employee_payment_table').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50],
                    ordering: true,
                    searching: true,
                    info: true,
                    responsive: true,
                    order: [[1, "desc"]] // Due column
                });
            }

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