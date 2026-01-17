
<?php
include('session.php');
include('supplierpaymentNavigation.php');
require_once("../DB Operations/customerOps.php");
require_once("../DB Operations/supplierpaymentOps.php");
require_once("../Model/customerModel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Supplier Payment Management</h1>
<!-- DataTales Example -->
<span id="message"></span>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Supplier's List</h6>
            </div>

        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="Customer_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style=display:none>Supplier ID</th>
                        <th style=display:none>Payment ID</th>
                        <th style=display:none>PO ID</th>
                        <th>Supplier Name</th>
                        <th style=display:none>Supplier Address</th>
                        <th>PO Code</th>
                        <th>Total Amt</th>
                        <th>Paid Amt</th>
                        <th>Balance Amt</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $supplierList = DBsupplierpayment::getAllsupplierpayment();
                    foreach ($supplierList as $supplier) {
                        echo "<tr><td style=display:none >" . $supplier->get_supplierId() . "</td>
                        <td style=display:none >" . $supplier->get_supplierpaymentId() . "</td>
                        <td style=display:none >" . $supplier->getPOID() . "</td>
                        <td>" . $supplier->get_suppliername() . "</td>
                        <td style=display:none >" . $supplier->get_supplierAddress() . "</td>
                        <td>" . $supplier->getPOCode() . "</td>
                        <td>" . $supplier->get_totalamt() . "</td>
                        <td>" . $supplier->get_receivedamt() . "</td>
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
                                    <button class='btn btn-danger dropdown-item' 
                                    id='Payment'
                                    data-toggle='modal'
                                    data-target='#paymentinfoModal' 
                                    name='delete_button' 
                                    role='button' 
                                    data-id='" . $supplier->get_supplierId() . "'>
                                    <i class='fas fa-rupee-sign'></i>
                                       Payment Updates  
                                    </button>
                                    <button class='btn btn-primary dropdown-item'
                                    data-toggle='modal' 
                                    data-target='#TransactionModal' 
                                    role='button' 
                                    data-id='" . $supplier->get_supplierId() . "'> 
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
</div>

<?php include('footer.php'); ?>

<div class="modal fade" id=paymentinfoModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <div class="row gutters-sm">
            <div class="col-md-2 mb-2">
            </div>
            <div class="col-md-10">
                <form class="form" action="../Controller/supplierpaymentcontroller.php" method="POST" id="myForm"
                    enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Supplier Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="suppliername" id="suppliername" class="form-control"
                                            required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                            data-parsley-trigger="keyup" readonly />
                                        <input type="hidden" id="supplierId" name="supplierId" value="">
                                        <input type="hidden" id="supplierpaymentid" name="supplierpaymentid" value="">
                                        <input type="hidden" id="POID" name="POID" value="">

                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Total Amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="totalamt" id="totalamt" class="form-control" required
                                            data-parsley-trigger="keyup"
                                            value="<?php echo $supplier->get_totalamt()  ?>" />
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Paid Amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="paidamt" id="paidamt" class="form-control" required
                                            data-parsley-trigger="keyup" readonly
                                            value="<?php echo $supplier->get_receivedamt()  ?>" />
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Payment<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="receivedamt" id="receivedamt" class="form-control"
                                            required data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label">Pending Amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="pendingamt" id="pendingamt" class="form-control"
                                            required data-parsley-trigger="keyup" readonly
                                            value="<?php echo $supplier->get_pendingamt()  ?>" />
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
                                            <option value="">Select Mode</option>
                                            <option value="Advance Payment">Advance Payment</option>
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
                                        <textarea type="text" id="paymentdescription" name="paymentdescription"
                                            placeholder="Payment Description" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <br />

                                <div class="col-md-6">
                                    <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                        data-parsley-type="integer" data-parsley-minlength="10"
                                        data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                        value="<?php echo $_SESSION['login_user']; ?>" />

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success" id="btn" type="submit" name="submit">Update</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
<div class="modal fade" id=TransactionModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <div class="row gutters-sm">
            <div class="col-md-2 mb-2">
            </div>
            <div class="col-md-10">
                <form class="form" method="POST" id="TransactionForm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="col-12" id="printTransaction">

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
                                                Supplier Name :<span id="transactionsuppliername"></span>
                                            </td>
                                            <td colspan="3">
                                                PO Code : <span id="transactionPOcode"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                Address : <span id="transactionsupplierAddress"></span>

                                            </td>
                                            <td colspan="3">
                                                Date :<?php echo $date = date('d/m/Y '); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">

                                               
                                            </td>
                                            <td colspan="3">

                                                Total Amount : <span id="transactiontotalamt"></span>
                                            </td>
                                            <div id="POcode" style="display:none"></div>
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

                                            <td style="text-align:right" rowspan="" colspan="">Total</td>
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
                                            <input type="hidden" name="createdby" id="createdby" class="form-control"
                                                required value="<?php echo $_SESSION['login_user']; ?>" />
                                            <input type="hidden" name="modifiedby" id="modifiedby" class="form-control"
                                                required value="<?php echo $_SESSION['login_user']; ?>" />
                                            <input type="hidden" id="supplierId"
                                                value="<?php echo $supplier->get_supplierId(); ?>" />
                                        </div>
                                    </div>
                                    <input type="submit" name="submit" id="PDF" class="btn btn-success"
                                        value="Save AS PDF" />
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    $('#Customer_table tbody').on('click', 'tr', function() {
        debugger;
        /* Get the row as a parent of the link that was clicked on */
        $('#supplierId').val(this.cells[0].innerHTML);
        $('#paymentid').val(this.cells[1].innerHTML);
        $('#POID').val(this.cells[2].innerHTML);
        $('#suppliername').val(this.cells[3].innerHTML);
        $('#transactionsuppliername').text(this.cells[3].innerHTML);
        $('#supplierAddress').text(this.cells[4].innerHTML);
        $('#transactionsupplierAddress').text(this.cells[4].innerHTML);
        $('#transactionPOcode').text(this.cells[5].innerHTML);
        $('#totalamt').val(this.cells[6].innerHTML);
        $('#transactiontotalamt').text(this.cells[6].innerHTML);
        $('#paidamt').val(this.cells[7].innerHTML);
        $('#pendingamt').val(this.cells[8].innerHTML);
    });

    $("#myForm :input").prop("disabled", false);
    $('#Payment').on('click', 'tr', function() {

        if (!parseInt($('#totalamt').val())) {
            $('#totalamt').focus();
            $('#paidamt').attr('disabled', true);
        } else {
            $('#totalamt').attr('readonly', true);
        }
    });

    $('#paymentinfoModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        
        var TotalPendingAmount=0;
        $('#supplierId').val(rowid);
        var PurchaseId=$('#POID').val();
        var transactionUrl = config.developmentPath +
            "/Admin/Controller/supplierpaymentcontroller.php?id=" + rowid+ "&POID=" + PurchaseId;
        console.log(transactionUrl);

        $.getJSON(transactionUrl, function(data) {
            $.each(data, function(index, value) {
                debugger;
                TotalPendingAmount = parseInt(value.pendingamt)
                
            });
            $('#pendingamt').text(TotalPendingAmount);
        });


    });

    $('#TransactionModal').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $('#supplierId').val(rowid);
        var PurchaseId=$('#POID').val();

        var transactionUrl = config.developmentPath +
            "/Admin/Controller/supplierpaymentcontroller.php?id=" + rowid+ "&POID=" + PurchaseId;
        console.log(transactionUrl);

        $.getJSON(transactionUrl, function(data) {
            console.log(data);
            var count = 1;
            var TotalPendingAmount = 0;
            var TotalPaidAmount = 0;
            $("#SupplierTransaction tbody").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {

                $('#SupplierTransaction tbody').
                append($(document.createElement('tr')).prop({

                }));

                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: count++

                }));

                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.modifieddate

                }));

                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.paymentmode
                }));
                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.pendingamt
                }));
                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.receivedamt
                }));

                TotalPendingAmount = parseInt(value.pendingamt)
                TotalPaidAmount = parseInt(TotalPaidAmount) + parseInt(value
                    .receivedamt)
            });
            $('#pending').text(TotalPendingAmount);
            $('#totalpaidAmount').text(TotalPaidAmount);
        });
    });

    var dataTable = $('#Customer_table').DataTable({

    });

    var nEditing = null;

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
            if (parseInt($("#paidamt").val()) > 0 && parseInt($("#pendingamt").val()) !=
                0) {
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

    $("#receivedamt").change(function(e) {
        debugger;
        $("#pendingamt").val(parseInt($("#pendingamt").text()) - $(this).val());
        $('#paidamt').val($('#totalamt').val() - $("#pendingamt").val());
        if($(this).val() > parseInt($('#totalamt').val()) ){
            $("#btn").addClass('disabled');
            alert("Received Amount is greater than Total Amount");
        }else{
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

    $("#paymentmode").change(function() {
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

    $('#TransactionForm').submit(function(e) {
        debugger;
        $('#PDF').remove();
        var content = $('#printTransaction').html();
        var fileName = $('#transactionPOcode').text() + '_Transaction';

        var uniturl = config.developmentPath +
            "/Admin/Controller/pdfGeneratorContorller.php";

        $.ajax({
            type: "POST",
            url: uniturl,
            data: {
                "modifiedby": $('#modifiedby').val(),
                "supplierId": $('#supplierId').val(),
                "fileType": "supplierpayment",
                // "waterMarked": waterMarked,
                "fileName": fileName,
                "html": content
            },
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
            setTimeout(function() {
                $('#printTransaction').html('');
            }, 10000);
        });

        window.open(config.developmentPath + '/Admin/pdfs/supplierpayment/' + fileName
            .trim() + '.pdf');
    });
});
</script>