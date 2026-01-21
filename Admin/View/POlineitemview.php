<?php
include('session.php');
include "purchaseorderheader.php";
include('../DB Operations/POlineitemOps.php');
include('../DB Operations/purchaseorderOps.php');
include('../DB Operations/item_compdetailsOps.php');
$id = $_GET['id'];
?>

<h1 class="h3 mb-4 text-gray-800">Purchase Order Management</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">

            <div class="col" align="right">

                <button type="submit" class="btn btn-primary btn-circle btn-sm" id="Save" formnovalidate="off"><i
                        class="fas fa-save"></i></button>

                <span data-toggle=modal data-target=#AddModal data-id=<?php echo $id ?> <button type="button"
                    class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>

        </div>
        <?php $purchaseList = DBpurchase::GetPurchaseOrderBasedOnId($id) ?>
        <fieldset>

            <div class="row">
                <div class="col">
                    <label>Supplier Name :
                        <span><?php echo $purchaseList->getSupplierName() ?></span>
                    </label>
                </div>
                <div class="col">
                    <label>Supplier Address :
                        <span><?php echo $purchaseList->getSupplierAddress() ?></span>
                    </label>
                </div>
                <div class="col">
                    <label>Supplier location :
                        <span><?php echo $purchaseList->getSupplierLocation() ?></span>
                    </label>
                </div>


            </div>
            <div class="row">
                <div class="col">
                    <label>PO Type :
                        <span><?php echo $purchaseList->getPOtype() ?></span>
                    </label>
                </div>
                <div class="col">
                    <label>PO Id :
                        <span>
                            <?php echo $purchaseList->getPOcode() ?>
                        </span>
                    </label>
                </div>
                <div class="col">
                    <label>Date of Purchase :
                        <span><?php echo $purchaseList->get_purchaseddate() ?></span>
                    </label>
                </div>

            </div>

    </div>
    </fieldset>


    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered" id="lineItem_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'>POlineitem ID</th>
                        <th style='display:none'>Supplier ID</th>
                        <th style='display:none'>POID</th>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Brand</th>
                        <th>MRP</th>
                        <th>Quantity</th>

                        <th> Price</th>
                        <th>Total Amount</th>
                        <th style='display:none'>Item Category</th>
                        <th style='display:none'>Item Sub Category</th>
                        <th style='display:none'>Unit factor</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $POListItem = DBPOLineItem::getLineItemByPurchaseIdForOrder($id);
                    foreach ($POListItem as $Item) {
                        echo "<tr>
                        <td style='display:none'>" . $Item->get_POlineitemId() . "</td>
                        <td style='display:none' id='supplierid'>" . $Item->get_supplierId() . "</td>
                        <td style='display:none' id='Pid'>" . $Item->get_POID() . "</td>
                        <td>" . $Item->getName() . "</td>
                        <td>" . $Item->getItemCode() . "</td>
                        <td>" . $Item->getBrand() . "</td>
                        <td>" . $Item->get_PPMRP() . "</td>
                        
                        <td ><input class='form-control' readonly type='text' id= 'quantity_" . $Item->get_POlineitemId() . "' name='quantity' value='" . $Item->get_quantity() . "'/>
                        <input type='hidden' id='POlineitemId' name='POlineitemId' value='" . $Item->get_POlineitemId() . "'/></td>
                        <td >
                        <input class='form-control' readonly type='text' id= 'price_" . $Item->get_POlineitemId() . "' name='price' value='" . $Item->get_price() . "'/>
                        <input type='hidden' id='POlineitemId' name='POlineitemId' value='" . $Item->get_POlineitemId() . "'/>
                        
                        </td>
                        <td></td>
                        <td style='display:none'>" . $Item->getItemcatname() . "</td>
                        <td style='display:none'>" . $Item->getItemsubcatname() . "</td>
                        <td style='display:none'>" . $Item->getunitName() . "</td>
                        <td> 
                        
                          <a class='btn btn-primary ' onclick='editItem(" . $Item->get_POlineitemId() . ")' id='edit_" . $Item->get_POlineitemId() . "' class='btn btn-warning btn-small' href='#' role='button'><i class='fas fa-pencil-alt'></i></a>
                          <a class='btn btn-success disabled' onclick='saveItem(" . $Item->get_POlineitemId() . ")' id='save_" . $Item->get_POlineitemId() . "' class='btn btn-primary btn-small disabled' href='#' role='button' ><i class='fas fa-sd-card'></i></a>
                          <button class='btn btn-danger'
                          data-toggle='modal' 
                          data-target='#deleteLineItemModal' 
                          role='button' 
                          data-id='" . $Item->get_POlineitemId() . "'>
                           <i class='fas fa-trash-alt'></i>
                         </button>
                       </td> </tr>";
                    }

                    ?>


                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<div class="modal fade" id=AddModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form class="" method="POST" id="add_form" enctype="multipart/form-data"
            action="../Controller/POlineitemcontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Line Item Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Supplier <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="SupplierId" class="form-select" required name="SupplierId">

                                </select>
                            </div>

                            <label class="col-md-3 text-right">Brand<span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="brand" class="form-select" required name="brand">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemCategory" class="form-select" required name="itemCategory">

                                </select>
                            </div>
                            <label class="col-md-3 text-right">Sub Category Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemsubCategory" class="form-select" required name="itemsubCategory">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-3 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <select id="additemid" class="form-select" required name="additemid">
                                </select>
                                <input type='hidden' id='supplierid' name='supplierid'
                                    value="<?php echo $purchaseList->get_supplier() ?>" />
                                <input type='hidden' id='totalAmt' name='totalAmt'
                                    value="<?php echo $purchaseList->get_totalAmount() ?>" />
                                <input type="hidden" name="POID" id="POID">
                                <input type="hidden" name="Pid" id="Pid">
                                <input type="hidden" name="selectedItemName" id="addselectedItemName"
                                    class="form-control" value="" />
                                <input type="hidden" name="unitFactor" id="unitFactor" class="form-control" value="" />
                                <input type="hidden" name="POLineItemId" id="POLineItemId" class="form-control"
                                    value="" />
                            </div>

                            <label class="col-md-3 text-right">Item Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="quantity" id="quantity" class="form-control" required />
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class=row>

                            <label class="col-md-3 text-right">Item per piece MRP <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="price" id="price" class="form-control" required />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                            <label class="col-md-3 text-right">Total Amount <span class="text-danger">*</span></label>
                            <div class="col-md-3 input-group">
                                <input type="text" name="totalamt" id="totalamt" class="form-control" required />
                                <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="createdby" id="createdby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required
                                    data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="">Add Line Item</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deleteLineItemModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_lineItem_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Purchase Order Line Item</h4>
                    <button type="button" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Line Item.
                    </p>
                    <input type="hidden" name="POlineItemId" id="POlineItemId" value="">
                    <input type="hidden" name="POID" id="deletePOID" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="deleteLineItembutton" class="btn btn-danger"
                        value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var pricechange = [];

    var projId = 0;

    function editItem(POlineitemId) {

        document.getElementById("price_" + POlineitemId).removeAttribute("readonly");
        document.getElementById("quantity_" + POlineitemId).removeAttribute("readonly");
        document.getElementById("edit_" + POlineitemId).classList.add('disabled');
        document.getElementById("quantity_" + POlineitemId).focus();
        document.getElementById("save_" + POlineitemId).classList.remove('disabled');
        var row = document.getElementById(POlineitemId);



    }

    function qChange(POlineitemId) {

        var price = document.getElementById('editeditemperpieceprice').value;
        pricechange.forEach(function (item, index, arr) {
            if (item.itemid == itemId) {
                item.itemperpieceprice = price;
                item.totalAmount = parseFloat(quantity) * parseFloat(price);
            }
        })

    }

    function saveItem(POlineitemId) {
        debugger;
        document.getElementById("quantity_" + POlineitemId).setAttribute("readonly", "readonly");
        document.getElementById("price_" + POlineitemId).setAttribute("readonly", "readonly");
        document.getElementById("save_" + POlineitemId).classList.add('disabled');
        document.getElementById("edit_" + POlineitemId).classList.remove('disabled');
        var row = document.getElementById(POlineitemId);
        var price = document.getElementById('price').value;
        var price = document.getElementById("price_" + POlineitemId).value;
        var quantity = document.getElementById("quantity_" + POlineitemId).value;
        var supplierId = document.getElementById("supplierid").value;
        var PurchaseId = document.getElementById("Pid").value;
        var editedPrice = {
            POlineitemId: POlineitemId,
            totalamt: price * quantity,
            price: price,
            quantity: quantity,
            Pid: PurchaseId,
            supplierid: supplierId

        }
        pricechange.push(editedPrice);
    }

    $(document).ready(function () {


        var catId;
        var subcatId;
        var dataTable = $('#lineItem_table').DataTable({

        });
        $('#deleteLineItemModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#POlineItemId').val(rowid);

        });


        $('#Save').click(function (event) {
            debugger;
            console.log(pricechange)
            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/POlineitemcontroller.php",
                data: {
                    "obj": pricechange
                },
                dataType: "json",
                encode: true,
            }).done(function (data) {
                window.location.replace(config.developmentPath +
                    "/Admin/View/POlineitemview.php");
            });

        });



        $('#EditModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#POlineItemId').val(rowid);

            var url = config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php";
            let isSelectedSet1 = false;
            $('#editeditemCategory').empty();
            $('#editeditemsubCategory').empty();
            $('#additemid').empty();

            // var catid=
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    if (catId == value.itemcatid) {
                        $('#editeditemCategory').append(
                            '<option selected value ="' + value
                                .itemcatid + '">' +
                            value
                                .itemcatname + '</option>');

                    } else {
                        $('#editeditemCategory').append('<option value="' +
                            value
                                .itemcatid + '">' +
                            value
                                .itemcatname + '</option>');
                    }


                });

            });
            setSubCategory(catId);
        });

        $('#additemid').empty();
        var url = config.developmentPath + "/Admin/Controller/item_detailscontroller.php";
        $.getJSON(url,
            function (
                data) {

                itemDetails = data;
                mappItemPrice(data[0].price,
                    data[0].name,
                    data[0].unitFactor);
                $.each(data, function (index, value) {
                    $('#additemid').append('<option value="' + value.itemid + '">' +
                        value
                            .itemname + '</option>');
                });
            });

        function mappItemPrice(price, name, unitFactor) {
            $('#price').val(price);
            $('#addselectedItemName').val(name);
            $('#unitFactor').val(unitFactor);
        }

        $('#additemid').on('change', function (e) {

            for (var i = 0; i < itemDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (itemDetails[i].itemid == this.value) {
                    $('#quantity').val("");
                    $('#totalamt').val("");
                    mappItemPrice(itemDetails[i].price,
                        itemDetails[i].name,
                        itemDetails[i].unitFactor);
                }
            }
        });
        $('#price').blur(function (e) {
            debugger;
            $('#totalamt').val((parseFloat($('#quantity').val() * parseFloat($(
                '#price')
                .val()) * parseFloat($('#unitFactor').val()))).toFixed(2));

        });



        $('#delete_lineItem_form').submit(function (event) {
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/POlineItemController.php/",
                method: "POST",
                data: {
                    id: $('#POlineItemId').val(),
                    quoteId: $('#deletePOID').val(),
                    action: 'delete'
                },
            }).done(function (data) {
                console.log(data);
            });
            location.reload();
        });
        $('#lineItem_table tbody').on('click', 'tr', function () {
            debugger;
            $('#POlineItemId').val(this.cells[0].innerHTML);

            $('#supplierid').val(this.cells[1].innerHTML);
            $('#Pid').val(this.cells[2].innerHTML);
            $('#editeditemname').val(this.cells[3].innerHTML);
            $('#editedquantity').val(this.cells[4].innerHTML);
            $('#editedtotalamt').val(this.cells[5].innerHTML);

            $('#editedprice').val(this.cells[6].innerHTML);

            $('#editeditemCategory').val(this.cells[7].innerHTML);
            $('#editeditemsubCategory').val(this.cells[8].innerHTML);
            $('#unitFactor').val(this.cells[9].innerHTML);
        });
        $('#editedquantity').blur(function (e) {
            calculateAmount();
        });

        function calculateAmount() {
            var quantity = $('#editedquantity').val();
            var price = $('#editedprice').val();
            var unitFactor = $('#unitFactor').val();

            $('#editedtotalamt').val((parseFloat($('#editedquantity').val() * parseFloat($(
                '#editedprice').val()) * parseFloat($('#unitFactor').val()))).toFixed(2));

        };
        $('#editedquantity').on('keydown', function (e) {
            calculateAmount();
        });
        $('#editedquantity').on('keyup', function (e) {
            calculateAmount();
        });

        $('#edit_form').submit(function (event) {

            var formData = new FormData(this);
            $.ajax({
                url: config.developmentPath +
                    "/Admin/Controller/POlineitemcontroller.php/",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data) {
                console.log(data);
            });
        });



        $('#AddModal').on('show.bs.modal', function (e) {
            debugger;
            var rowid = $(e.relatedTarget).data('id');
            $('#POID').val(rowid);
            $('#Pid').val(rowid);
            var fetchCompanylist = config.developmentPath +
                "/Admin/Controller/item_compdetailscontroller.php/?POID=" + rowid;
            console.log(fetchCompanylist);
            console.log(this.value);
            let suppId = 0;
            $.getJSON(fetchCompanylist, function (data) {
                $.each(data, function (index, value) {
                    $('#SupplierId').append('<option value="' + value.itemcompid + '">' +
                        value.itemcompname + '</option>');
                    setBrand(value.itemcompid);
                });

            });
        });


        function setBrand(suppId) {
            fetchbrandurl = config.developmentPath + "/Admin/Controller/brandcontroller.php/?supplierId=" + suppId;
            console.log(fetchbrandurl);
            $.getJSON(fetchbrandurl, function (data) {
                $('#brand').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#brand').append('<option value="' + value.brandid +
                        '">' +
                        value
                            .brandname + '</option>');
                });
            });
        }

        function setSubCategory(catId) {
            var fetchsubcaturl = config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
                catId;
            let brandId = 0;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#additemsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#additemsubCategory').append('<option value="' +
                        value
                            .itemsubcatid +
                        '">' +
                        value
                            .itemsubcatname + '</option>');
                    if (subcatId == value.itemsubcatid) {
                        $('#editeditemsubCategory').append(
                            '<option selected value="' +
                            value
                                .itemsubcatid +
                            '">' +
                            value
                                .itemsubcatname + '</option>');
                    } else {
                        $('#editeditemsubCategory').append('<option value="' +
                            value
                                .itemsubcatid +
                            '">' +
                            value
                                .itemsubcatname + '</option>');
                    }
                });
            });
        }

        function setItemlist(catId, subcatId, brandId, projId = 0) {
            debugger;

            $('#quantity').val("");
            $('#totalamt').val("");
            $('#price').val("");

            var fetchitemlisturl = config.developmentPath +
                "/Admin/Controller/item_detailscontroller.php/?catId=" + catId +
                "&subcatId=" +
                subcatId + "&brandId=" + brandId + "&projId=" + projId;
            console.log(fetchitemlisturl);
            $.getJSON(fetchitemlisturl, function (data) {
                itemDetails = data;
                $('#additemid').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    $('#additemid').append('<option value="' + value
                        .itemid + '">' +
                        value
                            .itemname + '</option>');

                    // $('#editedsubCategory').append('<option value="' + value.itemsubcatid +
                    //     '">' +
                    //     value
                    //     .itemsubcatname + '</option>');
                });
            });
        }

        $('#brand').on('change', function () {
            debugger;
            var url = config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php/?brandId=" + this.value;
            let isSelectedSet1 = false;
            let catId = 0;
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    if (isSelectedSet1 === false) {
                        $('#additemCategory').append(
                            '<option selected value="' + value
                                .itemcatid +
                            '">' +
                            value
                                .itemcatname + '</option>');

                        isSelectedSet1 = true;
                        setSubCategory(value.itemcatid);

                    } else {
                        $('#additemCategory').append(
                            '<option hidden disabled selected value>-- select an option --</option>'
                        );
                        $('#additemCategory').append('<option value="' +
                            value
                                .itemcatid +
                            '">' + value
                                .itemcatname + '</option>');
                        $('#editeditemCategory').append('<option value="' +
                            value
                                .itemcatid + '">' +
                            value
                                .itemcatname + '</option>');
                    }
                });
            });
        });


        $('#additemCategory').on('change', function () {
            debugger;
            $('#additemsubCategory').empty();
            $('#additemid').empty();
            $('#quantity').val("");
            $('#totalamt').val("");
            $('#price').val("");

            fetchsubcaturl =
                config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
                    .value;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#additemsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#additemsubCategory').append(
                        '<option value="' + value
                            .itemsubcatid +
                        '">' +
                        value
                            .itemsubcatname + '</option>');
                });
            });



        });

        $('#editeditemCategory').on('change', function () {
            $('#editeditemsubCategory').empty();
            $('#additemid').empty();
            $('#editedquantity').val("");
            $('#editedtotalamt').val("");
            $('#editedprice').val("");

            fetchsubcaturl =
                config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
                    .value;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#editeditemsubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#editeditemsubCategory').append(
                        '<option value="' + value
                            .itemsubcatid +
                        '">' +
                        value
                            .itemsubcatname + '</option>');
                });
            });
        });

        $('#additemsubCategory').on('change', function () {
            $('#additemid').empty();
            setItemlist($('#additemCategory').val(), this.value, $('#brand').val());
        });
        $('#editeditemsubCategory').on('change', function () {
            $('#additemid').empty();
            setItemlist($('#editeditemCategory').val(), this.value);
        });
    });
</script>