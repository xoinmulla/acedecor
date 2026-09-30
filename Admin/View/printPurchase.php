<?php
include('session.php');
require_once "purchaseorderheader.php";
include('../DB Operations/purchaseorderOps.php');
$purchaseId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

require_once "../DB Operations/POlineitemOps.php";

// ✅ Header data (KEEP OLD LOGIC)
$purchaselist = DBpurchase::getPurchasesForPrint($purchaseId);

if (!is_array($purchaselist) || count($purchaselist) == 0) {
    die("No Purchase Data Found");
}

$firstpurchase = $purchaselist[0];

// ✅ Line items (NEW — does NOT affect old logic)
$lineItems = DBPOLineItem::getPOLineItemByPurchaseId($purchaseId);
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

    .boq-wrapper {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .boq-header {
        display: flex;
        justify-content: space-between;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .company-block h2 {
        margin: 0;
        font-weight: bold;
    }

    .company-block p {
        margin: 5px 0 0;
        font-size: 13px;
    }

    .boq-title h3 {
        margin: 0;
        text-align: right;
        font-weight: bold;
    }

    .boq-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .boq-table {
        width: 100%;
        border-collapse: collapse;
    }

    .boq-table th {
        background: #343a40;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    .boq-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    .boq-table img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }

    .boq-footer {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
    }
</style>


<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div id="printPurchase" class="boq-wrapper">

            <!-- Header -->
            <div class="boq-header">
                <div class="company-block">
                    <h2>ACE DECORS</h2>
                    <p>
                        Dharwad, Karnataka <br>
                        Phone: +91-9742268112 | +91-9742367112 <br>
                        Email: sales@acedecors.co.in
                    </p>
                </div>

                <div class="boq-title">
                    <h3>BOQ (Bill Of Quantity)</h3>
                </div>
            </div>

            <!-- Info Row -->
            <table width="100%" style="margin-bottom:15px;">
                <tr>
                    <td><strong>Supplier Name:</strong> <?php echo $firstpurchase->getSupplierName(); ?></td>
                    <td align="center"><strong>Date:</strong> <?php echo $firstpurchase->get_purchaseddate(); ?></td>
                    <td align="right"><strong>PO Id:</strong> <?php echo $firstpurchase->getPOCode(); ?></td>
                </tr>
            </table>

            <!-- Table -->
            <table class="boq-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <!-- <th>Description</th> -->
                        <th width="10%">Quantity</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lineItems as $item) {
                        echo '<tr>
        <td align="center" width="20%"><img src="../img/items/' . $item->getItemImage() . '"></td>
        <td width="44%">' . $item->getName() . '</td>
        <td align="center">' . $item->getBrand() . '</td>
        <!--<td>' . $item->getDescription() . '</td>-->
        <td align="center" width="10%">' . $item->get_quantity() . '</td>
        <td align="center" width="10%">' . $item->getunitName() . '</td>
    </tr>';
                    }
                    ?>
                </tbody>
            </table>
            <!-- Footer -->
            <table width="100%" style="margin-top:40px;">
                <tr>
                    <td width="35%">Authorized Signature</td>
                    <td align="right">Thank you for your business!</td>
                </tr>
            </table>

        </div>
        <div>
            <form name="PurchaseOrder" method="POST" id="itemListForm" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="createdby" id="createdby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                            value="<?php echo $_SESSION['login_user']; ?>" />
                        <input type="hidden" id="purchaseId" value="<?php echo $firstpurchase->get_Id(); ?>" />
                    </div>
                </div>
                <input type="submit" name="submit" id="PDF" class="btn btn-success" value="Save AS PDF" />
            </form>
        </div>
    </div>



</div>


<?php
require_once "footer.php";
?>
<script src="../js/inword.js"></script>
<script>
    // function callMe(rowId) {
    //     var newTotal = 0;
    //     console.log(parseFloat($("#totalAmount").text()));
    //     console.log(parseFloat($('#' + rowId + ' td[id=purchase-' + rowId + ']').text()));
    //     newTotal = parseFloat($("#totalAmount").text()) - parseFloat($('#' + rowId + ' td[id=purchase-' + rowId + ']')
    //         .text());
    //     $("#totalAmount").text(newTotal);
    //     $('#totalAmount').inword({
    //         type: "placer",
    //         value: parseFloat($("#totalAmount").text()),
    //         placerId: "inwords",
    //         case: "ucfirst"
    //     });
    //     $("#" + rowId + "").remove();
    //     rowId;
    //     var totalRow = $('#totalRow').val();
    //     while (rowId <= totalRow) {

    //         $("#" + rowId + " td:first").text(rowId - 1);
    //         $("#" + rowId + " td:first").append('<button type="button" onclick="callMe(' + rowId +
    //             ')" class="btn btn-secondary btn-sm">Remove</button>');
    //         rowId++;
    //     }
    // }

    // function callmeForPI(rowId) {
    //     debugger;
    //     rowId = "PI-TR-" + rowId;
    //     var res = rowId.split("-");
    //     var totalRow = $('#totalRow').val();
    //     var newTotal = 0;
    //     console.log(parseFloat($("#subtotal").text()));
    //     console.log(parseFloat($('#' + rowId + ' td[id=PI-' + res[2] + ']').text()));
    //     newTotal = parseFloat($("#subtotal").text()) - parseFloat($('#' + rowId + ' td[id=PI-' + res[2] + ']').text());
    //     $("#subtotal").text(newTotal);
    //     $('#subtotal').inword({
    //         type: "placer",
    //         value: parseFloat($("#subtotal").text()),
    //         placerId: "PIinwords",
    //         case: "ucfirst"
    //     });
    //     $("#" + rowId + "").remove();
    //     rowId;
    //     while (res[2] <= totalRow) {

    //         $("#" + rowId + " td:first").text(res[2] - 1);
    //         $("#" + rowId + " td:first").append('<button type="button" onclick="callMe(' + rowId +
    //             ')" class="btn btn-secondary btn-sm">Remove</button>');
    //         res[2]++;
    //         rowId = res.join('-');
    //     }
    // }

    $(document).ready(function () {
        var waterMarked = false;
        // $('#estimatedTotal').text($('#subtotal').text() + '/-');
        // $('#totalAmount').inword({
        //     type: "placer",
        //     value: parseFloat($("#totalAmount").text()),
        //     placerId: "inwords",
        //     case: "ucfirst"
        // });
        // $('#subtotal').inword({
        //     type: "placer",
        //     value: parseFloat($("#subtotal").text()),
        //     placerId: "PIinwords",
        //     case: "ucfirst"
        // });


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
            debugger;
            var content = $('#printPurchase').html();
            var fileName = $('#purchasecode').text() + $('#listquoteCode').text() + '_PO';

            var uniturl = config.developmentPath + "/Admin/Controller/pdfGeneratorContorller.php";
            $.ajax({
                type: "POST",
                url: uniturl,
                data: {
                    "modifiedby": $('#modifiedby').val(),
                    "purchaseId": $('#purchaseId').val(),
                    "fileType": "purchaseorder",
                    "waterMarked": waterMarked,
                    "fileName": fileName,
                    "html": content
                },
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data);
                setTimeout(function () {
                    $('#printPurchase').html('');
                }, 7000);
            });

            window.open(config.developmentPath + '/Admin/pdfs/purchaseorder/' + fileName.trim() + '.pdf');
        });
        // $('#PIForm').submit(function(e) {
        //     var content = $('#printPI').html();
        //     var fileName = $('#customerCode').text() + $('#listquoteCode').text() + '_PROFORMA_Invoice';
        //     var uniturl = config.developmentPath +
        //         "/Admin/Controller/pdfGeneratorContorller.php";
        //     $.ajax({
        //         type: "POST",
        //         url: uniturl,
        //         data: {
        //             "modifiedby": $('#modifiedby').val(),
        //             "quoteId": $('#quoteId').val(),
        //             "fileType": "quotations",
        //             "waterMarked": waterMarked,
        //             "fileName": fileName,
        //             "html": content
        //         },
        //         dataType: "json",
        //         encode: true,
        //     }).done(function(data) {
        //         console.log(data);
        //     });
        // });
    });
</script>