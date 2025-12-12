<?php
include('session.php');
include "inwardstocknavigation.php";
require_once("../DB Operations/purchaseorderOps.php");
require_once("../Model/purchaseModel.php");
require_once("../DB Operations/POlineitemOps.php");

$purchaseOrder=null;
$id=$_GET["id"];
$purchaseOrder=DBpurchase::GetPurchaseOrderBasedOnId($id);

?>
<!-- <meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" /> -->

<h1 class="h3 mb-4 text-gray-800">Stock Upgrades</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Purchase Order</h6>

            </div>
            <div class=col align='right'>
                <button type="submit" class="btn btn-primary btn-circle btn-md" id="Save" formnovalidate="off"><i
                        class="fas fa-save fa-lg"></i></button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row ">
            <div class="col">

            </div>
            <div class="col"></div>
        </div> </br></br>
        <div id="printTable">
            <?php 
        {
            // $id=$purchaseOrder->get_Id();
             echo '
                <div class="row">
                    <div class="col" >
                        <label>PO Code :
                            <span id="POcode">'. $purchaseOrder->getPOcode() .' </span>
                        </label>
                    </div>
                    <div class="col">
                        <label>Supplier Name :
                            <span>  '. $purchaseOrder->getSupplierName() .'</span>
                        </label>
                    </div>
                   <div class="col">
                        <label>PO Date :
                            <span> '.$purchaseOrder->get_purchaseddate().'</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Total Amount :
                            ₹<span> '.$purchaseOrder->get_totalAmount().' </span>
                        </label>
                    </div>
                    <div class="col">
                        <label>Paid Amount :
                            ₹<span> '.$purchaseOrder->get_paidAmount().' </span>
                        </label>
                    </div>
                    <div class="col">
                         <label>Total Qty Raised :
                             <span> '.$purchaseOrder->getTotalQuantity().' </span>
                        </label>
                    </div>
                    <div class="col">
                    <label>Total Qty Received :
                        <span> '.$purchaseOrder->getTotalReceivedQty().' </span>
                   </label>
               </div>
                </div>

                    <table class="table table-bordered" id="lineItem_table" width="100%" cellspacing="0">
                    
                        <thead>
                            <tr>
                            <th>Sl No</th>
                            <th id="Itemcodehideheader" style="display:none">ItemCode</th>
                            <th id="POIDhideheader" style="display:none">POID</th>
                            <th id="Stockhideheader" style="display:none">StockId</th>
                            <th>ItemCode </th>
                            <th>Item Image</th>
                            <th>Item Name</th>
                            <th id="Itemhideheader" style="display:none">Item ID</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Rate/<br>Item </th>
                            <th>Total Amount</th>
                            <th style="display:none">Invoice No</th>
                            <th>Qty Received</th>
                            <th style="display:none">Received Qty Amt</th>
                            <th >Balance Qty</th>
                            <th id="Actionehideheader">Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $POListItem = DBPOLineItem::getLineItemByPurchaseIdForOrder($id);
                            $sumTotalAmount=0;
                            $sumQuantity=0;
                            $sumOtherCharges=0;
                            $sumDiscount=0;
                            $sumCD=0;
                            $sumTaxable=0;
                            $totalinovice=0;
                            $sumGSTamt=0;
                            $count=1;
                            $invoiceNo=0;
                            foreach ($POListItem as $POItem) {
                                $row ='<tr  id= "'.$count.'">
                                    <td id="SLno" style="text-align:center">'. $count.' </td>
                                    <td id="Itemcode'. $count.'" style="display:none"><input type="hidden" id="Itemcode_'. $POItem->get_POlineitemId().'" value="'. $POItem->getItemcode() . '"></td>
                                    <td id="POIDprint_'. $count.'" style="display:none">' . $POItem->get_POID() . '</td>
                                    <td  id="Stockprint_'. $count.'"  style="display:none">' . $POItem->getStockId() . '</td>
                                    <td>'. $POItem->getItemcode() . '</td>
                                    <td><img src="../img/items/'. $POItem->getItemImage() .'" style="width:100px;height:100px;"></td>
                                    <td>' . $POItem->getName() . '</td>
                                   
                                    <td id="Itemidprint_'. $count.'" style="display:none">' . $POItem->get_itemid() . '</td>
                                    <td id="quantity_'. $POItem->get_POlineitemId().'">' . $POItem->get_quantity() . '</td>
                                    <td id= "unit_'. $POItem->get_POlineitemId() .'">' . $POItem->getunitName() . '</td>
                                    <td id= "price_'. $POItem->get_POlineitemId() .'">'. $POItem->get_price() . '</td>
                                    <td id= "totalamt_'. $POItem->get_POlineitemId() .'">'. $POItem->get_totalamt() . '</td>
                                    <td id= "invoiceno_'. $POItem->get_POlineitemId() .'" style="display:none">'. $POItem->getInvoiceNo() . '</td>
                                    <td id="receivedqtycount_'. $POItem->get_POlineitemId() .'"> '. $POItem->get_ReceivedQty() .' </td>
                                    <td style="display:none" id="receivedqtyprint_'. $count.'"> '. $POItem->get_ReceivedQty() .'</td>      
                                    <input type="hidden" id="POlineitemId" name="POlineitemId" value=' . $POItem->get_POlineitemId() . '></td>
                                   


                                    <td class="';
                    
                                   
                                   $row.= '" id="receivedqtyamtcount_'. $POItem->get_POlineitemId() .'" style="display:none"> '. $POItem->get_ReceivedQtyAmt() .' </td>
                                    <td style="display:none" id="receivedqtyamtprint_'. $count.'"> '. $POItem->get_ReceivedQtyAmt() .'</td>      
                                    <input type="hidden" id="POlineitemId" name="POlineitemId" value=' . $POItem->get_POlineitemId() . '></td>
                                    
                                    <td id="balanceqty_'. $POItem->get_POlineitemId().'" >' . $POItem->get_BalanceQty() . '</td>
                                   
                                    <td id="actionprint"> <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle"
                                    type="button"
                                    id="dropdownMenu2"
                                    data-toggle="dropdown"
                                   
                                    aria-expanded="false">
                                    Actions
                                   
                                    </button> 
                                    <div class="dropdown-menu" 
                                    aria-labelledby="dropdownMenu2"><div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button class="btn btn-primary dropdown-item"
                                        data-toggle="modal"
                                        data-target="#editinwardModal" 
                                        role="button"
                                        data-id='. $POItem->get_POlineitemId() .'>
                                        <i class="fas fa-user-edit"></i> 
                                             Update 
                                    </button>
                                    </div>

                                    <button class="btn btn-primary dropdown-item"
                                    data-toggle="modal"
                                    data-target="#inwardDetailsModal" 
                                    role="button"
                                    data-id='. $POItem->get_POlineitemId() .'>
                                    <i class="fas fa-info-circle"></i>
                                         Inward Details
                                    </button>

                           </div>
                                       
                                    </div></td></tr>';
                                    
                                echo $row;
                                $count++;

                                
                                $sumTotalAmount = $sumTotalAmount + floatval($POItem->get_totalamt());
                                $sumQuantity = $sumQuantity + floatval($POItem->get_quantity());
                                $sumOtherCharges=$sumOtherCharges + floatval($POItem->getOtherCharges());
                                $sumDiscount=$sumDiscount + floatval($POItem->getDiscount());
                                $sumCD=$sumCD + floatval($POItem->getCD());
                                $sumTaxable=$sumTaxable + floatval($POItem->getTaxableValue() );
                                $sumGSTamt= $sumGSTamt + floatval($POItem->getGSTamt());
                                $totalinovice=$sumTotalAmount   ;
                                if($invoiceNo==0){
                                    $invoiceNo=$POItem->getInvoiceNo();
                                }
                                
                                
                            }
                            echo '<input type="hidden" id="lastinsertedSLno" value='.--$count.'> ';
                            echo '<tr>
                                    <th colspan="4" style="text-align:right">Sub Total</th>
                                     <td id="sumquantity">
                                        '.$sumQuantity.' 
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td id="subtotal">
                                    '.$sumTotalAmount.' 
                                    </td>
                                    </tr>';
                                echo '<tr>
                                     <th colspan="5" style="text-align:right">Total Invoice Value</th>
                                        <td colspan="8" id="totalinovice" style="text-align:right">
                                        '.$totalinovice.' INR
                                        </td>

                                    </tr>';
                                    // echo '<tr> 
                                    // <th colspan="5" style="text-align:right"><label>Invoice No:</label></th>
                                    // <td  colspan="8"  style="text-align:right"> 
                                    // <input type="text" readonly id="InvoiceNo" value="'.$invoiceNo.'" ></td>
                            
                                    // </tr>';
                       echo '</tbody>
                    </table>';  
        }
    
    ?>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="hidden" name="action" id="action" value="Add" />
            <a name="button" id="printPDF" class="btn btn-success">Print/Save as PDF</a>
        </div>
        <img id="barcode" />
    </div>
    <div class="modal fade" id=editinwardModal tabindex=-1 role=dialog aria-hidden=true>
        <div class="modal-dialog ">
            <form method="post" id="editInward" enctype="multipart/form-data" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Edit Inward</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <span id="form_message"></span>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-5 text-right">Invoice Number <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" name="InvoiceNo" id="InvoiceNo" class="form-control" />
                                    <input type="hidden" name="StockId" id="StockId" value="">
                                    <input type="hidden" name="POID" id="POID" value="">
                                    <input type="hidden" name="quantity" id="quantity" value="">
                                    <input type="hidden" name="itemid" id="itemid" value="">
                                    <input type="hidden" name="price" id="price" value="">
                                    <input type="hidden" name="totalamt" id="totalamt" value="">
                                    <input type="hidden" name="unit" id="unit" value="">
                                    <input type="hidden" name="ItemCode" id="ItemCode" value="">
                                    <input type="hidden" name="ItemName" id="ItemName" value="">
                                    <!-- <image type="hidden" id="barcode"></image> -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-5 text-right">Quantity Received <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" name="ReceivedQty" id="ReceivedQty" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-5 text-right">Total Amt of Quantity Received<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input id="ReceivedQtyAmt" name="ReceivedQtyAmt" class="form-control "
                                         required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-5 text-right">GST<span class="text-danger">*</span></label>
                                <div class="col-md-7 input-group">
                                    <input id="GST" name="GST" class="form-control" required />
                                    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-5 text-right">Balance Quantity<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" id="BalanceQty" class="form-control" required name="BalanceQty"
                                        readonly />
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
                        <input type="submit" name="submit" id="editInwardbtn" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </div>
    </div>
    <div class="modal fade" id=inwardDetailsModal tabindex=-1 role=dialog aria-hidden=true>
        <div class="modal-dialog modal-xl">
            <div class="row gutters-sm">
                <div class="col-md-2 mb-2">
                </div>
                <div class="col-md-10">
                    <form class="form" method="POST" id="InwardForm" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="col-12" id="Inwarddetails">

                                    <table class="table table-bordered  container" id="SupplierTransaction">
                                        <thead>
                                            <tr>
                                                <td style="text-align:center" colspan="7">
                                                    <h1>Inward Details</h1>
                                                    <p>Ace Decors Dharwad</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- <th >Customer Name </th> -->
                                                <td colspan="3">
                                                    <h5>Supplier Details</h5>
                                                </td>
                                                <td colspan="3">
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    Supplier Name
                                                    :<span><?php echo $purchaseOrder->getSupplierName()?></span>
                                                </td>
                                                <td colspan="3">
                                                    PO Code : <span><?php echo $purchaseOrder->getPOcode()?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    Address :
                                                    <span><?php echo $purchaseOrder->getSupplierAddress()?></span>

                                                </td>
                                                <td colspan="3">
                                                    Date :<?php echo $date = date('d/m/Y '); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">

                                                Total Amount :
                                                    <span><?php echo $purchaseOrder->get_totalAmount()?></span>
                                                </td>
                                                <td colspan="3">

                                                   
                                                </td>
                                                <div id="POcode" style="display:none"></div>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center" colspan="1">Sl</th>
                                                <th style="text-align:center">Inwarded Date</th>
                                                <th style="text-align:center">Invoice No</th>
                                                <th style="text-align:center">Rate/Item</th>
                                                <th style="text-align:center">Received Qty</th>
                                                <th style="text-align:center">Received Qty Amt</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <!-- <tr>
                                                <td style="text-align:center" colspan=2></td>

                                                <td style="text-align:right" rowspan="" colspan=""></td>
                                                <td id="pending" style="text-align:center"></td>
                                                <td id="totalpaidAmount" style="text-align:center"></td>
                                            </tr> -->
                                        </tfoot>
                                        <tr>

                                        </tr>
                                    </table>
                                    <div>
                                        <!-- <input type="submit" name="submit" id="PDF" class="btn btn-success"
                                            value="Save AS PDF" /> -->
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
</div>
</form>
<?php include('footer.php');  ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js"
    integrity="sha512-QEAheCz+x/VkKtxeGoDq6nsGyzTx/0LMINTgQjqZ0h3+NjP+bCsPYz3hn0HnBkGmkIFSr7QcEZT+KyEM7lbLPQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
var pricechange = [];

// function editItem(POlineitemId) {

//     document.getElementById("received_" + POlineitemId).removeAttribute("readonly");
//     document.getElementById("receivedqtyamt" + POlineitemId).removeAttribute("readonly");
//     // document.getElementById("IGST_" + POlineitemId).removeAttribute("readonly");
//     // // document.getElementById("taxable_" + POlineitemId).removeAttribute("readonly");
//     // document.getElementById("CD_" + POlineitemId).removeAttribute("readonly");
//     // document.getElementById("discount_" + POlineitemId).removeAttribute("readonly");
//     // document.getElementById("charges_" + POlineitemId).removeAttribute("readonly");
//     document.getElementById("edit_" + POlineitemId).classList.add('disabled');
//     // document.getElementById("charges_" + POlineitemId).focus();
//     document.getElementById("save_" + POlineitemId).classList.remove('disabled');
//     document.getElementById("InvoiceNo").removeAttribute("readonly");
//     var row = document.getElementById(POlineitemId);



// }

// function qChange(POlineitemId) {

//     var othercharges = document.getElementById('editeditemperpieceprice').value;
//     var issues = document.getElementById('issues').value;
//     pricechange.forEach(function(item, index, arr) {
//         if (item.itemid == itemId) {
//             item.itemperpieceprice = price;
//             item.totalAmount = parseFloat(quantity) * parseFloat(price);
//         }
//     })

// }

// function saveItem(POlineitemId) {
//     debugger;
//     if (document.getElementById("InvoiceNo").value == "") {
//         alert("Please Enter the invoice no.")
//     } else {
//         document.getElementById("received_" + POlineitemId).removeAttribute("readonly", "readonly");
//         document.getElementById("receivedqtyamt" + POlineitemId).removeAttribute("readonly",
//             "readonly");
//         // document.getElementById("GSTamt_" + POlineitemId).setAttribute("readonly", "readonly");
//         // document.getElementById("IGST_" + POlineitemId).setAttribute("readonly", "readonly");
//         // document.getElementById("taxable_" + POlineitemId).setAttribute("readonly", "readonly");
//         // document.getElementById("CD_" + POlineitemId).setAttribute("readonly", "readonly");
//         // document.getElementById("discount_" + POlineitemId).setAttribute("readonly", "readonly");
//         // document.getElementById("charges_" + POlineitemId).setAttribute("readonly", "readonly");
//         document.getElementById("InvoiceNo").setAttribute("readonly", "readonly");
//         document.getElementById("save_" + POlineitemId).classList.add('disabled');
//         document.getElementById("edit_" + POlineitemId).classList.remove('disabled');
//         var row = document.getElementById(POlineitemId);
//         // var othercharges = document.getElementById('charges').value;

//         var ReceivedQty = document.getElementById("received_" + POlineitemId).value;
//         var ReceivedQtyAmt = document.getElementById("receivedqtyamt" + POlineitemId).value;

//         var Invoice = document.getElementById("InvoiceNo").value;
//         var ItemCode = document.getElementById("Itemcode_" + POlineitemId).value;
//         // var IGST = document.getElementById("IGST_" + POlineitemId).value;
//         // var CD = document.getElementById("CD_" + POlineitemId).value;
//         // var discount = document.getElementById("discount_" + POlineitemId).value;
//         // var othercharges = document.getElementById("charges_" + POlineitemId).value;
//         var quantity = document.getElementById("quantity_" + POlineitemId).innerHTML;
//         var price = document.getElementById("price_" + POlineitemId).innerHTML;
//         var unit = document.getElementById("unit_" + POlineitemId).innerHTML;
//         var totalamt = document.getElementById("totalamt_" + POlineitemId).innerHTML;
//         var itemid = document.getElementById("itemid_" + POlineitemId).value;
//         var POID = document.getElementById("POID_" + POlineitemId).value;
//         var StockId = document.getElementById("StockId_" + POlineitemId).value;
//         // var taxable = parseInt(totalamt) + parseInt(othercharges) - parseInt(discount) - parseInt(CD);
//         // var GSTAmt = parseFloat(IGST / 100) * parseInt(taxable);
//         var data = document.getElementById("Itemcode_" + POlineitemId).value + "-" + document
//             .getElementById("POcode")
//             .innerHTML;
//         console.log("#barcode_" + POlineitemId);
//         JsBarcode("#barcode_" + POlineitemId, data);
//         var barcodeimg = document.getElementById("barcode_" + POlineitemId);

//         var editedPrice = {
//             POlineitemId: POlineitemId,
//             // charges: othercharges,
//             // discount: discount,
//             // CD: CD,
//             // taxablevalue: taxable,
//             // IGST: IGST,
//             quantity: quantity,
//             unit: unit,
//             price: price,
//             itemid: itemid,
//             POID: POID,
//             StockId: StockId,
//             totalamt: totalamt,
//             barcode: barcodeimg.src,
//             // GSTamt: GSTAmt,
//             ReceivedQty: ReceivedQty,
//             ReceivedQtyAmt: ReceivedQtyAmt,
//             InvoiceNo: Invoice

//         }

//         pricechange.push(editedPrice);
//     }
// }

$(document).ready(function() {

    $('#lineItem_table tbody').on('click', 'tr', function() {
debugger;
        /* Get the row as a parent of the link that was clicked on */
        $('#StockId').val(this.cells[3].innerHTML);
        $('#POID').val(this.cells[2].innerHTML);
        $('#quantity').val(this.cells[8].innerHTML);
        $('#itemid').val(this.cells[7].innerHTML);
        $('#price').val(this.cells[10].innerHTML);
        $('#ItemCode').val(this.cells[4].innerHTML); 
        $('#unit').val(this.cells[9].innerHTML);
        $('#totalamt').val(this.cells[11].innerHTML);
        $('#BalanceQty').val(this.cells[17].innerHTML);
        $('#ItemName').val(this.cells[6].innerHTML); 


    });
   

    $('#inwardDetailsModal').on('show.bs.modal', function() {
        debugger;
        var rowid = $('#itemid').val();
        
        
        var PurchaseId=$('#POID').val();

        var inwardUrl = config.developmentPath +
            "/Admin/Controller/item_stockscontroller.php?id=" + rowid+ "&POID=" + PurchaseId;
        console.log(inwardUrl); 
        var classvalue = '';
        
        $.getJSON(inwardUrl, function(data) {
            console.log(data);
            var count = 1;
            // var TotalPendingAmount = 0;
            // var TotalPaidAmount = 0;var 
       
       var classvalue="";
            $("#SupplierTransaction tbody").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
debugger;
                if(parseInt(value.price) < parseInt(value.ReceivedQtyAmt)){
                   
                        classvalue="bg-danger";
                }else{
                    classvalue="bg-success";
                    }
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
                    innerHTML: value.InvoiceNo
                }));
                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.price
                }));
                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.ReceivedQty
                }));
                $('#SupplierTransaction tr:last').
                append($(document.createElement('td')).prop({
                    class: classvalue,
                    style: "color:black",
                    innerHTML: value.ReceivedQtyAmt
                }));
            });
            
        });
    });

    // $('#lineItem_table tbody tr').each(function() {
    //     var POlineitemId = ($('#POlineitemId').val());
    //     $(this).find('td:id=[receivedqtyamtcount_' + POlineitemId]).each(function() {

    //         var price = document.getElementById("price_" + POlineitemId).innerHTML;
    //         var qty = document.getElementById("receivedqtycount_" + POlineitemId).innerHTML;
    //         var receivedqtyamt = document.getElementById("receivedqtyamtcount_" + POlineitemId)
    //             .innerHTML;
    //         var InwardedAmt = price * qty;
    //         var classvalue = '';
    //         if (receivedqtyamy = "") {
    //             classvalue = "bg-white";
    //         } else if (InwardedAmt > receivedqtyamt) {

    //             classvalue = "bg-success";

    //         } else {
    //             classvalue = "bg-danger";
    //         }
    //         $("#receivedqtyamtcount_" + POlineitemId).addClass(classvalue);
    //     });
    // });

    var waterMarked = false;
    $('#flexSwitchCheckDefault').on('click', function(e) {
        if ($(this).attr('checked') != 'checked') {
            $(this).attr('checked', 'checked');
            waterMarked = true;
        } else {
            $(this).removeAttr('checked');
            waterMarked = false;
        }
    })
    // $('#editinwardModal').on('show.bs.modal', function() {
    //     var rowid = $(e.relatedTarget).data('id');
    //     $('#StockId').val(rowid);
    // });

    $('#editInward').submit(function(event) {
        debugger;
        // var data = $("#Itemcode_").val() + $("#POlineitemId").val() + "-" + $("#POcode").val();
        // JsBarcode("#barcode_", data);
        // var barcodeimg = document.getElementById("barcode_" + POlineitemId);

        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/item_stockscontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
    });

    $("#ReceivedQty").change(function(e) {
        debugger;
        if ($("#BalanceQty").val() == "") {
            var BalanceQty = 0;
            if(parseInt($("#ReceivedQty").val()) > parseInt($("#quantity").val()) ){
                $("#BalanceQty").val(parseInt($("#quantity").val()) - $(this).val());
                alert("Enter Valid Quantity");
                $("#editInwardbtn").addClass('disabled');
            }else{
                $("#BalanceQty").val(parseInt($("#quantity").val()) - $(this).val());
                $("#editInwardbtn").removeClass('disabled');
            }
        } else {
            if(parseInt($("#ReceivedQty").val()) > parseInt($("#BalanceQty").val()) ){
                alert("Enter Valid Quantity");
                $("#editInwardbtn").addClass('disabled');
            }else{
                $("#BalanceQty").val(parseInt($("#BalanceQty").val()) - $(this).val());
                $("#editInwardbtn").removeClass('disabled');
            }  
        }
    });

    $('#printPDF').click(function(event) {
        debugger;
        count = 1;
        // var POlineitemid=$('#POlineitemId').val();
        var lastinsertedSL = $('#lastinsertedSLno').val();
        for (i = 1; i <= lastinsertedSL; i++) {

            // var chargesprintid = "#chargesprint_" + count;
            // var discountprint = "#discountprint_" + count;
            // var CDprint = "#CDprint_" + count;
            // var taxableprint = "#taxableprint_" + count;
            // var IGSTprint = "#IGSTprint_" + count;
            // var GSTamtprint = "#GSTamtprint_" + count;
            var receivedqtyprint = "#receivedqtyprint_" + count;
            var receivedqtyamtprint = "#receivedqtyamtprint_" + count;
            var POID = "#POID_" + count;
            // var myobj = document.getElementById("chargescount_" + count);
            // myobj.remove();
            // $(chargesprintid).show();

            // var receivedqtyinput = document.getElementById("receivedqtycount_" + count);
            // receivedqtyinput.remove();
            // $(receivedqtyprint).show();


            // var receivedqtyinput = document.getElementById("receivedqtyamtcount_" +
            //     count);
            // receivedqtyinput.remove();
            // $(receivedqtyamtprint).show();

            // var discountinput = document.getElementById("discountcount_" + count);
            // discountinput.remove();
            // $(discountprint).show();

            // var CDinput = document.getElementById("CDcount_" + count);
            // CDinput.remove();
            // $(CDprint).show();

            // var taxableinput = document.getElementById("taxablecount_" + count);
            // taxableinput.remove();
            // $(taxableprint).show();

            // var IGSTinput = document.getElementById("IGSTcount_" + count);
            // IGSTinput.remove();
            // $(IGSTprint).show();

            // var GSTamtinput = document.getElementById("GSTamtcount_" + count);
            // GSTamtinput.remove();
            // $(GSTamtprint).show();

            var Itemcodeinput = document.getElementById("Itemcode" + count);
            Itemcodeinput.remove();
            $('#Itemcode').remove();

            var POIDinput = document.getElementById("POIDprint_" + count);
            POIDinput.remove();
            $('#POIDprint_').remove();

            var Stockinput = document.getElementById("Stockprint_" + count);
            Stockinput.remove();
            $('#Stockprint_').remove();


            var Itemidinput = document.getElementById("Itemidprint_" + count);
            Itemidinput.remove();
            $('#Itemidprint_').remove();
            // var Barcodeinput = document.getElementById("Barcodeimg_" + count);
            // Barcodeinput.remove();
            // $('#Barcodeimg_').remove();


            $('#Stockhideheader').remove();
            $('#Itemhideheader').remove();
            $('#POIDhideheader').remove();
            $('#Itemcodehideheader').remove();
            $('#Actionehideheader').remove();
            $('#Barcodehideheader').remove();
            $('#actionprint').remove();
            $('#printPDF').remove();
            count++;
        }
        // var POIDinput = document.getElementById("POID_" + POlineitemid);
        //     POIDinput.remove();
        var content = $('#printTable').html();
        var fileName = $('#POcode').text() + '_SI';

        var uniturl = config.developmentPath +
            "/Admin/Controller/pdfGeneratorContorller.php";
        $.ajax({
            type: "POST",
            url: uniturl,
            data: {
                "modifiedby": $('#modifiedby').val(),
                "fileType": "stockinward",
                "waterMarked": waterMarked,
                "fileName": fileName,
                "html": content
            },
            dataType: "json",
            encode: true,
        }).done(function(data) {
            console.log(data);
            setTimeout(function() {
                $('#printTable').html('');
            }, 8000);
        });

        window.open(config.developmentPath + '/Admin/pdfs/stockinward/' + fileName
            .trim() + '.pdf');
    });


    $('#Save').click(function(event) {
        debugger;
        console.log(pricechange)
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/item_stockscontroller.php",
            data: {
                "obj": pricechange
            },
            dataType: "json",
            encode: true,
        }).done(function(data) {
            setTimeout(function() {
                $('#printTable').html('');
            }, 8000);
            window.location.replace(config.developmentPath +
                "/Admin/View/itemstocks.php");
        });

    });




});
</script>