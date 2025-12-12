
<?php
include('session.php');
require_once "purchaseorderheader.php";
include('../DB Operations/purchaseorderOps.php');
$purchaseId=$_GET['id'];
$purchaselist= DBpurchase::getPurchasesForPrint($purchaseId);
$firstpurchase=$purchaselist[0];
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


<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class='container-fluid' id="printPurchase">
            <table class="table table-bordered " id="GeneralQuote">
                <tr>
                    <td style="text-align:left" colspan="8">
                        <h1>Ace Decors</h1>
                    </td>
                </tr>
                <tr>
                    <th colspan="2">Supplier Name </th>
                    <td><?php echo $firstpurchase->getSupplierName() ?></td>
                    <th colspan="2">Date</th>
                    <td><?php echo $firstpurchase->get_purchaseddate() ?></td>
                </tr>
                <tr>
                    <th colspan="2">Address</th>
                    <td><?php echo $firstpurchase->getSupplierAddress() ?></td>
                    <th colspan="2">Purchase Id</th>
                    <td id="purchasecode"><?php echo $firstpurchase->getPOCode() ?></td>
                </tr>

                <tr>
                    <th>#</th>
                    <th >Item Code</th>
                    <th>Item Name</th>
                    <th colspan="2">Description</th>
                    <th>Qty</th>
                </tr>
                <?php
        $count=1;
        $sum=0;
        foreach($purchaselist as $purchase){
        echo '<tr id="'.$count.'">
            <td>'.$count.'<button type="button" onclick="callMe('.$count.')" class="btn btn-secondary btn-sm">Remove</button></td>
            <td>'.$purchase->getArticleNo().'</td>
            <td>'.$purchase->getName().'</td>
            <td colspan="2">'.$purchase->getDescription().'</td>
          
            <td>'.$purchase->getQuantity().'</td>
          
        </tr>';
        $sum=$sum+floatval($purchase->get_totalAmount());
        $count++;
        }
        echo "<input type='hidden' id='totalRow' value='".--$count."'/>";
        ?>
              
               
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

$(document).ready(function() {
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


    $('#flexSwitchCheckDefault').on('click', function(e) {
        if ($(this).attr('checked') != 'checked') {
            $(this).attr('checked', 'checked');
            waterMarked = true;
        } else {
            $(this).removeAttr('checked');
            waterMarked = false;
        }
    })
    $('#PDF').on('click', function(e) {

        $('#GeneralQuote tr').each(function() {
            $(this).find('td:first button').remove();
        })
    });
    $('#PI-PDF').on('click', function(e) {

        $('#PI-table tr').each(function() {
            $(this).find('td:first button').remove();
        })
    })
    $('#itemListForm').submit(function(e) {
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
        }).done(function(data) {
            console.log(data);
            setTimeout(function() {
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