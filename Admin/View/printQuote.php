
<?php
include('session.php');
require_once "lineitemNavigation.php";
include('../DB Operations/quotationOps.php');
$customerId=$_GET['id'];
$quotation = DBQuotation::getQuotationsForPrint($customerId);
$firstquote=$quotation[0];
?>
<link rel="stylesheet" href="../css/inword.css" />
<style>
.form-switch .form-check-input {
    width: 2em;
    margin-left: 0em;
}
.form-check-label {
    margin-bottom: 0;
    margin-left:2.5em !important;
}
btn-group-sm>.btn, .btn-sm {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem;
    margin-left: 1em;
}

</style>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
            type="button" role="tab" aria-controls="pills-profile" aria-selected="false">PROFORMA INVOICE</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
            type="button" role="tab" aria-controls="pills-home" aria-selected="true">General</button>
    </li>
    <li class="nav-item float-right" role="presentation">
    <button class="nav-link form-check form-switch">
        <input class="form-check-input"  type="checkbox" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Water Mark</label>
    </button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class='container-fluid' id="printQuote">
            <br>  <br>   <br>
         
            <table class="table table-bordered  " id="GeneralQuote">
                <tr>
                    <td style="text-align:center" colspan="5">
                        <h1>General Quotation</h1>
                    </td>
                </tr>
                <td style="text-align:center" colspan="5">
                        <h1></h1>
                    </td>
                <tr>
                    <th>Name </th>
                    <td><?php echo $firstquote->get_customerName() ?></td>
                    <th colspan="2">Customer Id</th>
                    <td id="customerCode"><?php echo $firstquote->getCustomerCode() ?></td>
                </tr>
                <tr>
                    <th>Addres</th>
                    <td><?php echo $firstquote->getCustomerAddress() ?></td>
                    <th colspan="2">Quote Id</th>
                    <td><?php echo $firstquote->getQuoteCode() ?></td>
                </tr>
                <tr>
                    <th>Place</th>
                    <td><?php echo $firstquote->getCustomerCity() ?></td>
                    <th colspan="2">Date</th>
                    <td><?php echo $firstquote->getDOE() ?></td>
                </tr>
               
                <tr>
                <th colspan="4">
                <td style="text-align:center" >
                        <h1></h1>
                    </td>
                </th>
                    </tr>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Amount</th>
                </tr>
                <?php
        $count=1;
        $sum=0;
        foreach($quotation as $quote){
        echo '<tr id="'.$count.'">
            <td>'.$count.'<button type="button" onclick="callMe('.$count.')" class="btn btn-secondary btn-sm">Remove</button></td>
            <td>'.$quote->get_quoteDescription().'</td>
            <td>'.$quote->getUnitName().'</td>
            <td>'.$quote->getQuantity().'</td>
            <td id="quote-'.$count.'">'.$quote->getQuoteValue().'</td>
        </tr>';
        $sum=$sum+floatval($quote->getQuoteValue());
        $count++;
        }
        echo "<input type='hidden' id='totalRow' value='".--$count."'/>";
        ?>
                <tr>
                    <td style="text-align:right" colspan="2">
                        Sum Total
                    </td>
                    <td id="totalAmount" style="text-align:right" colspan="3">
                        <?php echo $sum ?>
                    </td>
                </tr>
                <tr>
                <td colspan="5">
                        <h3 ></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <h3 id="inwords"></h3>
                    </td>
                </tr>
                <td colspan="5">
                        <h3 ></h3>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="5">
                        Terms and Conditions
                    </th>
                </tr>
                <tr>
                    <td colspan="5">
                        <p>This Quotation is not a contract or a bill . It is our best guess at the total price for the
                            service
                            and goods
                            described above. The customer will be billed after indicating acceptance of this quote.
                            Payment will
                            be
                            due prior to the delivery of Service and Goods.</p>
                    </td>
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
                                <input type="hidden" id="quoteId" value="<?php echo $firstquote->get_quoteId(); ?>"/>
                        </div>
                    </div>
                <input type="submit" name="submit" id="PDF" class="btn btn-success" value="Save/Print PDF" />
            </form>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class='container-fluid' id="printPI">
            <table class="table table-bordered table-sm" id="PI-table">
                <tr>
                    <th style="text-align:center" colspan="5">
                        <h1>ACE DECORS</h1>
                    </th>
                </tr>
                <tr>
                    <td style="text-align:center" colspan="5">
                        <p>Manufacturers and Suppliers of Modular Kitchen,Modular Wardrobe & Modular Cabinates</p>
                        <p>PB Road, Lakhmanhalli Industrial Area Near BRTS Stop Dharwad 580004, Karnataka (State), India
                        </p>
                        <p>+91 9742367112, +91 9742268112 Email : acedecorsofficial@gmail.com, info@acedecors.in</p>
                    </td>
                </tr>
                <tr>
                    <td style="border-right:0px" colspan="3">GSTIN:29ABQFA0355B1ZM
                    </td>
                    <td style="text-align:right;border-left:0px" colspan="2">
                        PROFORMA INVOICE
                    </td>
                </tr>
                <tr>
                    <th class='text-center' colspan="5">
                        Customer Details
                    </th>
                </tr>
                <tr>
                    <th>Name </th>
                    <td><?php echo $firstquote->get_customerName() ?></td>
                    <th>Invoice No</th>
                    <td id="customerCode"><?php echo $firstquote->getQuoteCode() ?></td>
                    <th>ESTIMATED TOTAL</th>
                </tr>
                <tr>
                    <th>Addres</th>
                    <td><?php echo $firstquote->getCustomerAddress() ?></td>
                    <th>Date Issued</th>
                    <td><?php echo date("d/M/Y"); ?></td>
                    <td rowspan="3"><h3 id="estimatedTotal"></h3></td>
                </tr>
                <tr>
                    <th>Place</th>
                    <td><?php echo $firstquote->getCustomerCity() ?></td>
                    <th>Due Date</th>
                    <td><?php $date = strtotime("+15 day");
                            echo date('d/M/Y', $date); ?></td>
                </tr>
                <tr>
                    <th>phone</th>
                    <td colspan="5"><?php echo $firstquote->getCustomerPhone() ?></td>
                </tr>
                <tr>
                    <th style="text-align:center" colspan="5">
                        PRODUCTS
                    </th>
                </tr>
                <tr>
                    <th>Sl No.</th>
                    <th colspan="2">Description</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
    </br></br>
                <?php
        $count=1;
        $sum=0;
        foreach($quotation as $quote){
        echo '<tr id="PI-TR-'.$count.'">
            <td>'.$count.'<button type="button" class="btn btn-secondary btn-sm" onclick="callmeForPI('.$count.')">Remove</button></td>
            <td colspan="2">'.$quote->getQuoteCode().'</td>
            <td>'.$quote->getQuantity().'</td>
            <td id="PI-'.$count.'">'.$quote->getQuoteValue().'</td>
        </tr>';
        $count++;
        $sum=$sum+floatval($quote->getQuoteValue());
        }
        ?>
       <tr>
                    <th style="text-align:center" colspan="5">
                    &nbsp;
                    </th>
                </tr>
                <tr>

                    <th colspan="3" style="text-align:center">
                        Total Value in word
                    </th>
                    <th>Sub Total</th>
                    <td id="subtotal">
                        <?php echo $sum ?>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" colspan="3">
                        <h3 id="PIinwords"></h3>
                    </td>
                    <th>Sales Tax</th>
                    <td id="salesTax"></td>
                </tr>
                <tr>

                    <th>Shipment Charges</th>
                    <td id="shipmentCharges"></td>
                </tr>
                <tr>
                    <th style="text-align:center" colspan="3">
                        Payment Terms Advance
                    </th>
                    <th>Total</th>
                    <td id="total"></td>
                </tr>
                <tr>
                    <th style="text-align:center" colspan="3">
                        Bank Details
                    </th>
                    <td style="text-align:center" colspan="2" rowspan="4">
                        Certified that the particulars given above are true and correct.
                    </td>
                </tr>
                <tr>
                    <th>
                        Bank Name
                    </th>
                    <td colspan="2">ICICI Bank</td>
                </tr>
                <tr>
                    <th>
                        Branch Name
                    </th>
                    <td colspan="2">Dharwad Gandhinagar</td>
                </tr>
                <tr>
                    <th>
                        Account Number
                    </th>
                    <td colspan="2">142505002388</td>
                </tr>
                <tr>
                    <th>
                        IFSC Code
                    </th>
                    <td colspan="2">ICICI0001425</td>
                    <td style="text-align:center" colspan="2">For ACE DECORS</td>
                </tr>
                <tr>
                    <th colspan="5">
                        Terms and Conditions
                    </th>
                </tr>
                <tr>
                    <td colspan="5">
                        <ol>
                            <li>Subject to Dharwad Jurisdiction</li>
                            <li>Our responsibility ceases as soon as the goods leave our premises</li>
                            <li>Goods once sold will not be taken back</li>
                            <li>Delivery ex-premises</li>
                        </ol>
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
                            <input type="hidden" id="quoteId" value="<?php $firstquote->get_quoteId(); ?>"/>
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
    function callMe(rowId){
        var newTotal=0;
        console.log(parseFloat($("#totalAmount").text()));
        console.log(parseFloat($('#'+rowId+' td[id=quote-'+rowId+']').text()));
        newTotal=parseFloat($("#totalAmount").text())-parseFloat($('#'+rowId+' td[id=quote-'+rowId+']').text());
        $("#totalAmount").text(newTotal);
        $('#totalAmount').inword({
        type: "placer",
        value: parseFloat($("#totalAmount").text()),
        placerId: "inwords",
        case: "ucfirst"
    });
    $("#"+rowId+"").remove();
    rowId;
    var totalRow=$('#totalRow').val();
    while(rowId<=totalRow){
        
        $("#"+rowId+" td:first").text(rowId-1);
        $("#"+rowId+" td:first").append('<button type="button" onclick="callMe('+rowId+')" class="btn btn-secondary btn-sm">Remove</button>');
        rowId++;
    }
}
function callmeForPI(rowId){
    debugger;
    rowId="PI-TR-"+rowId;
    var res = rowId.split("-");
    var totalRow=$('#totalRow').val();
    var newTotal=0;
        console.log(parseFloat($("#subtotal").text()));
        console.log(parseFloat($('#'+rowId+' td[id=PI-'+res[2]+']').text()));
        newTotal=parseFloat($("#subtotal").text())-parseFloat($('#'+rowId+' td[id=PI-'+res[2]+']').text());
        $("#subtotal").text(newTotal);
        $('#subtotal').inword({
        type: "placer",
        value: parseFloat($("#subtotal").text()),
        placerId: "PIinwords",
        case: "ucfirst"
    });
    $("#"+rowId+"").remove();
    rowId;
    while(res[2]<=totalRow){
        
        $("#"+rowId+" td:first").text(res[2]-1);
        $("#"+rowId+" td:first").append('<button type="button" onclick="callMe('+rowId+')" class="btn btn-secondary btn-sm">Remove</button>');
        res[2]++;
        rowId=res.join('-');
    }
}

$(document).ready(function() {
    var waterMarked=false;
    $('#estimatedTotal').text($('#subtotal').text()+'/-');
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


    $('#flexSwitchCheckDefault').on('click',function(e){
        if($(this).attr('checked')!='checked')
        {
        $(this).attr('checked','checked');
        waterMarked=true;
        }else{
            $(this).removeAttr('checked');
            waterMarked=false;
        }
    })
    $('#PDF').on('click', function(e){
        
        $('#GeneralQuote tr').each(function(){
            $(this).find('td:first button').remove();
        }) 
    });
    $('#PI-PDF').on('click', function(e){
        
        $('#PI-table tr').each(function(){
            $(this).find('td:first button').remove();
        }) 
    })
    $('#itemListForm').submit(function(e) {
        debugger
        var content = $('#printQuote').html();
        var fileName = $('#customerCode').text() + $('#listquoteCode').text() + '_GQ';
       
        var uniturl = config.developmentPath +"/Admin/Controller/pdfGeneratorContorller.php";
        $.ajax({
            type: "POST",
            url: uniturl,
            data: {
                "modifiedby":$('#modifiedby').val(),
                "quoteId":$('#quoteId').val(),
                "fileType":"quotations",
                "waterMarked":waterMarked,
                "fileName": fileName,
                "html": content
            },
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
        });
        window.open(config.developmentPath + '/Admin/pdfs/quotations/' + fileName.trim() + '.pdf');
    });
    $('#PIForm').submit(function(e) {
        debugger;
        var content = $('#printPI').html();
        var fileName = $('#customerCode').text() + $('#listquoteCode').text() + '_PROFORMA_Invoice';
        var uniturl = config.developmentPath +
            "/Admin/Controller/pdfGeneratorContorller.php";
            console.log(uniturl);
        $.ajax({
            type: "POST",
            url: uniturl,
            data: {
                "modifiedby":$('#modifiedby').val(),
                "quoteId":$('#quoteId').val(),
                "fileType":"quotations",
                "waterMarked":waterMarked,
                "fileName": fileName,
                "html": content
            },
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
        });
        window.open(config.developmentPath + '/Admin/pdfs/quotations/' + fileName.trim() + '.pdf');
    });
});
</script>