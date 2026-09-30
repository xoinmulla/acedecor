<?php
include('session.php');
require_once "lineitemNavigation.php";
include('../DB Operations/quotationOps.php');
$quoteId = intval($_GET['id']);

$quotation = DBQuotation::getQuotationsForPrint($quoteId);

if (empty($quotation)) {
    die("<h3>No Approved quotation found.</h3>");
}

$firstquote = $quotation[0];

function numberToWords($number)
{
    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($number)) . " Rupees Only";
}

?>

<link rel="stylesheet" href="../css/inword.css" />
<style>
    .form-switch .form-check-input {
        width: 2em;
        margin-left: 0em;
    }

    .form-check-label {
        margin-bottom: 0;
        margin-left: 2.5em !important;
    }

    btn-group-sm>.btn,
    .btn-sm {
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem;
        margin-left: 1em;
    }
</style>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile"
            type="button" role="tab" aria-controls="pills-profile" aria-selected="false">PROFORMA INVOICE</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home"
            type="button" role="tab" aria-controls="pills-home" aria-selected="true">General</button>
    </li>

</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div id="printQuote">

            <!-- Header -->
            <table width="100%" cellspacing="0" cellpadding="5">
                <tr>
                    <td width="70%">
                        <h2 style="margin:0;">ACE DECORS</h2><br>
                        <p style="margin:0;">
                            Dharwad, Karnataka<br><br>
                            Phone: +91-9742268112 | +91-9742367112<br><br>
                            Email: sales@acedecors.co.in
                        </p>
                    </td>
                    <td width="30%" align="right">
                        <h3 style="margin:0;">GENERAL QUOTATION</h3>
                        <p style="margin:0; font-size:12px;">
                            Date:
                            <?php echo date("d/M/Y"); ?>
                        </p>
                    </td>

                </tr>
            </table>

            <br>
            <!-- Customer Row -->
            <table width="100%" cellpadding="5">
                <tr>
                    <td width="38%"><strong>Customer Name:</strong> <?php echo $firstquote->get_customerName() ?></td>
                    <td align="center" width="30%"><strong>Customer Id:</strong> <?php echo $firstquote->getCustomerCode() ?></td>
                    <td align="right" width="29%"><strong>Quote Id:</strong> <?php echo $firstquote->getQuoteCode() ?></td>
                </tr>
            </table>

            <br>

            <!-- Item Table -->
            <table width="100%" border="1" cellspacing="0" cellpadding="8">
                <tr style="background:#3c434a; color:#fff;">
                    <th style="text-align:center;" width="5%">#</th>
                    <th style="text-align:center;" width="55%">Description</th>
                    <th style="text-align:center;" width="10%">Qty</th>
                    <th style="text-align:center;" width="10%">Unit</th>
                    <th style="text-align:center;" width="20%">Amount</th>
                </tr>


                <?php
                $count = 1;
                $sum = 0;
                foreach ($quotation as $quote) {
                    echo '<tr>
                <td align="center">' . $count . '</td>
                <td>' . $quote->get_quoteDescription() . '</td>
                <td align="center">' . $quote->getQuantity() . '</td>
                <td align="center">' . $quote->getUnitName() . '</td>
                <td align="right">' . $quote->getQuoteValue() . '</td>
            </tr>';
                    $sum += floatval($quote->getQuoteValue());
                    $count++;
                }
                ?>

                <tr>
                    <td colspan="4" align="right"><strong>Total</strong></td>
                    <td align="right"><strong><?php echo $sum ?></strong></td>
                </tr>
            </table>

            <br>

            <p><strong>In Words:</strong> <?php echo numberToWords($sum); ?></p>


            <br>

            <h4>Terms and Conditions</h4>
            <p>
                This Quotation is not a contract or a bill. It is our best estimate for the service and goods described
                above.
                Payment is due prior to delivery.
            </p>

            <br><br>

            <table width="100%">
                <tr>
                    <td width="39%">Authorized Signature</td>
                    <td align="right">Thank you for your business!</td>
                </tr>
            </table>

        </div>


        <div>
            <form name="generalQuote" method="POST" id="itemListForm" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" id="quoteId" value="<?php echo $firstquote->get_quoteId(); ?>" />
                    </div>
                </div>
                <input type="submit" name="submit" id="PDF" class="btn btn-success" value="Save/Print PDF" />
            </form>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div id="printPI">

            <!-- Header -->
            <table width="100%" cellspacing="0" cellpadding="5">
                <tr>
                    <td width="55%">
                        <h2 style="margin:0;">ACE DECORS</h2><br>
                        <p style="margin:0;">
                            Manufacturers and Suppliers of Modular Kitchen, Wardrobe & Cabinets<br>
                            Dharwad, Karnataka<br>
                            +91 9742367112 | +91 9742268112<br>
                            Email: sales@acedecors.co.in
                        </p>
                        <p style="margin:0;">GSTIN:29ABQFA0355B1ZM</p>
                    </td>
                    <td width="23%" align="right">
                        <h3>PROFORMA INVOICE</h3>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- Customer Details -->
            <table height="100%" cellpadding="5">
                <tr font-size="20px">
                    <td font-size="20px"><strong>Name:</strong> <?php echo $firstquote->get_customerName() ?></td>
                    <td align="center" width="41%"><strong>Invoice No:</strong> <?php echo $firstquote->getQuoteCode() ?></td>
                    <td align="right"><strong>Date Issued:</strong> <?php echo date("d/M/Y"); ?></td>
                </tr>
                <tr>
                    <td><strong>Address:</strong> <?php echo $firstquote->getCustomerAddress() ?></td>
                    <td align="center"><strong>Place:</strong> <?php echo $firstquote->getCustomerCity() ?></td>
                    <td align="right"><strong>Due Date:</strong> <?php echo date('d/M/Y', strtotime("+15 day")); ?></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Phone:</strong> <?php echo $firstquote->getCustomerPhone() ?></td>
                </tr>
            </table>

            <br>

            <!-- Product Table -->
            <table width="100%" border="1" cellspacing="0" cellpadding="8">
                <tr style="background:#3c434a; color:#fff;">
                    <th style="text-align:center;" width="5%">#</th>
                    <th style="text-align:center;" width="55%">Description</th>
                    <th style="text-align:center;" width="10%">Qty</th>
                    <th style="text-align:center;" width="10%">Unit</th>
                    <th style="text-align:center;" width="20%">Amount</th>
                </tr>


                <?php
                $count = 1;
                $sum = 0;
                foreach ($quotation as $quote) {
                    echo '<tr>
                <td align="center">' . $count . '</td>
                <td>' . $quote->get_quoteDescription() . '</td>
                <td align="center">' . $quote->getQuantity() . '</td>
                <td align="center">' . $quote->getUnitName() . '</td>
                <td align="right">' . $quote->getQuoteValue() . '</td>
            </tr>';
                    $count++;
                    $sum += floatval($quote->getQuoteValue());
                }
                ?>

                <tr>
                    <td colspan="3" align="right"><strong>Total</strong></td>
                    <td align="right"><strong><?php echo $sum ?></strong></td>
                </tr>
            </table>

            <br>

            <p><strong>Total in Words:</strong> <?php echo numberToWords($sum); ?></p>

            <br><br>

            <!-- Bank Details -->
            <br>

            <table width="100%" border="1" cellspacing="0" cellpadding="8">
                <tr>
                    <td width="34%">
                        <strong>Bank Details</strong><br><br>
                        Bank Name: ICICI Bank<br>
                        Branch Name: Dharwad Gandhinagar<br>
                        Account Number: 142505002388<br>
                        IFSC Code: ICICI0001425
                    </td>

                    <td width="50%">
                        <strong>Terms and Conditions</strong><br><br>
                        1. Subject to Dharwad Jurisdiction<br>
                        2. Our responsibility ceases as soon as goods leave premises<br>
                        3. Goods once sold will not be taken back<br>
                        4. Delivery ex-premises
                    </td>
                </tr>
            </table>

            <br><br>

            <table width="100%" border="1" cellspacing="0" cellpadding="12">
                <tr>
                    <td width="30%">
                        Authorized Signature
                    </td>

                    <td width="50%" align="right">
                        For ACE DECORS<br><br>
                        Authorized Signatory
                    </td>
                </tr>
            </table>

        </div>

        <div>
            <form method="POST" id="PIForm" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" id="quoteId" value="<?php echo $firstquote->get_quoteId(); ?>" />
                    </div>
                </div>
                <input type="submit" name="submit" id="PI-PDF" class="btn btn-success" value="Save/Print PDF" />
            </form>
        </div>
    </div>
</div>


<?php
require_once "footer.php";
?>
<script src="../js/inword.js"></script>
<script>
    function callMe(rowId) {
        var newTotal = 0;
        console.log(parseFloat($("#totalAmount").text()));
        console.log(parseFloat($('#' + rowId + ' td[id=quote-' + rowId + ']').text()));
        newTotal = parseFloat($("#totalAmount").text()) - parseFloat($('#' + rowId + ' td[id=quote-' + rowId + ']').text());
        $("#totalAmount").text(newTotal);
        $('#totalAmount').inword({
            type: "placer",
            value: parseFloat($("#totalAmount").text()),
            placerId: "inwords",
            case: "ucfirst"
        });
        $("#" + rowId + "").remove();
        rowId;
        var totalRow = $('#totalRow').val();
        while (rowId <= totalRow) {

            $("#" + rowId + " td:first").text(rowId - 1);
            $("#" + rowId + " td:first").append('<button type="button" onclick="callMe(' + rowId + ')" class="btn btn-secondary btn-sm">Remove</button>');
            rowId++;
        }
    }
    function callmeForPI(rowId) {
        debugger;
        rowId = "PI-TR-" + rowId;
        var res = rowId.split("-");
        var totalRow = $('#totalRow').val();
        var newTotal = 0;
        console.log(parseFloat($("#subtotal").text()));
        console.log(parseFloat($('#' + rowId + ' td[id=PI-' + res[2] + ']').text()));
        newTotal = parseFloat($("#subtotal").text()) - parseFloat($('#' + rowId + ' td[id=PI-' + res[2] + ']').text());
        $("#subtotal").text(newTotal);
        $('#subtotal').inword({
            type: "placer",
            value: parseFloat($("#subtotal").text()),
            placerId: "PIinwords",
            case: "ucfirst"
        });
        $("#" + rowId + "").remove();
        rowId;
        while (res[2] <= totalRow) {

            $("#" + rowId + " td:first").text(res[2] - 1);
            $("#" + rowId + " td:first").append('<button type="button" onclick="callMe(' + rowId + ')" class="btn btn-secondary btn-sm">Remove</button>');
            res[2]++;
            rowId = res.join('-');
        }
    }

    $(document).ready(function () {
        var waterMarked = false;
        $('#estimatedTotal').text($('#subtotal').text() + '/-');
        $('#totalAmount').inword({
            type: "placer",
            value: parseFloat($("#totalAmount").text()),
            placerId: "inwords",
            case: "ucfirst"
        });
        $('#subtotal').inword({
            type: "placer",
            value: parseFloat($("#subtotal").text()),
            placerId: "PIinwords",
            case: "ucfirst"
        });


        $('#flexSwitchCheckDefault').on('click', function (e) {
            if ($(this).attr('checked') != 'checked') {
                $(this).attr('checked', 'checked');
                waterMarked = true;
            } else {
                $(this).removeAttr('checked');
                waterMarked = false;
            }
        })
        $('#PDF').on('click', function (e) {

            $('#GeneralQuote tr').each(function () {
                $(this).find('td:first button').remove();
            })
        });
        $('#PI-PDF').on('click', function (e) {

            $('#PI-table tr').each(function () {
                $(this).find('td:first button').remove();
            })
        })
        $('#itemListForm').submit(function (e) {
            e.preventDefault();

            var content = $('#printQuote').html();
            var fileName = $('#customerCode').text() + '_GQ';
            var uniturl = config.developmentPath + "/Admin/Controller/pdfGeneratorContorller.php";

            $.ajax({
                type: "POST",
                url: uniturl,
                data: {
                    "modifiedby": $('#modifiedby').val(),
                    "quoteId": $('#quoteId').val(),
                    "fileType": "quotations",
                    "waterMarked": waterMarked,
                    "fileName": fileName,
                    "html": content
                }
            }).done(function () {

                // OPEN ONLY AFTER FILE CREATED
                window.open(
                    config.developmentPath +
                    '/Admin/pdfs/quotations/' +
                    fileName.trim() +
                    '.pdf'
                );
            });
        });

        $('#PIForm').submit(function (e) {

            e.preventDefault();

            var content = $('#printPI').html();
            var fileName = $('#customerCode').text() + '_PROFORMA_Invoice';

            var uniturl = config.developmentPath +
                "/Admin/Controller/pdfGeneratorContorller.php";

            $.ajax({
                type: "POST",
                url: uniturl,
                data: {
                    "modifiedby": $('#modifiedby').val(),
                    "quoteId": $('#quoteId').val(),
                    "fileType": "quotations",
                    "waterMarked": waterMarked,
                    "fileName": fileName,
                    "html": content
                }
            }).done(function () {

                window.open(
                    config.developmentPath +
                    '/Admin/pdfs/quotations/' +
                    fileName.trim() +
                    '.pdf'
                );

            });

        });

    });
</script>