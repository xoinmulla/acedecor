<?php
include('session.php');
include "POprojectheader.php";
require_once("../DB Operations/purchaseorderOps.php");
require_once("../Model/purchaseModel.php");
?>
<style>
    .form-check-input {
        position: static;
        margin-top: .3rem;
        margin-left: 0rem;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Purchase Order</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Purchase Order Based O n Project</h6>
            </div><br><br>
            <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
                <div class="accordion-item">
                    <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 text-right">Projects <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select id="project" class="form-select" required name="project">

                                        </select>
                                    </div>
                                    <label class="col-md-2 text-right">Date of Purchase <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" id="purchaseddate" name="purchaseddate">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 text-right">Customer Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="customerName" id="customerName" class="form-control"
                                            required readonly />
                                    </div>
                                    <label class="col-md-2 text-right">Customer Id <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="customerId" id="customerId" class="form-control"
                                            required readonly />
                                    </div>


                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 text-right">Brands <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select id="brands" class="form-select" required name="brands">

                                        </select>
                                    </div>

                                    <label class="col-md-2 text-right">Input <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select id="itemid" class="form-select" name="itemid">

                                        </select>
                                        <input type="hidden" name="selectedItemName" id="selectedItemName"
                                            class="form-control" value="" />
                                        <input type="hidden" name="unitFactor" id="unitFactor" class="form-control"
                                            value="" />
                                        <input type="hidden" name="Articleno" id="Articleno" class="form-control"
                                            value="" />
                                        <input type="hidden" name="HSNcode" id="HSNcode" class="form-control"
                                            value="" />

                                        <input type="hidden" name="UnitName" id="UnitName" class="form-control"
                                            value="" />
                                        <input type="hidden" name="Rate" id="Rate" class="form-control" value="" />
                                        <input type="hidden" name="TotalAmt" id="TotalAmt" class="form-control"
                                            value="" />
                                        <input type="hidden" name="Availableqty" id="Availableqty" class="form-control"
                                            value="" />
                                        <input type="hidden" name="Requiredqty" id="Requiredqty" class="form-control"
                                            value="" />
                                        <input type="hidden" name="Totalamtrequired" id="Totalamtrequired"
                                            class="form-control" value="" />
                                        <input type="hidden" name="itemquantity" id="itemquantity" class="form-control"
                                            value="" />

                                    </div>


                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">

                                    <label class="col-md-2 text-right">Supplier <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select id="supplier" class="form-select" required name="supplier">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 text-right">Item Quantity <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="itemquantity" id="itemquantity" class="form-control"
                                            required />
                                    </div>
                                </div>
                            </div> -->
                            <table class="table table-bordered" id="lineItemTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>HSN</th>
                                        <th>Qty to Order</th>
                                        <th>Unit</th>
                                        <th>Rate/Item</th>
                                        <th>Total Amt</th>
                                        <th>Available Qty</th>
                                        <th>Required Qty</th>
                                        <th>Total Amt Required </th>
                                    </tr>
                                </thead>
                                <tbody style=text-align:center>

                                </tbody>

                                <tfoot>

                                </tfoot>
                            </table>
                            <div class="form-group">
                                <div class="row ">


                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-primary" id="createQuote">Add
                                        Input</button>
                                    <button type="submit" class="btn btn-primary" id="Quote">Create Purchase
                                        Order</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script>
    $(document).ready(function () {
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;

        document.getElementById("purchaseddate").value = today;
        var purchases = [];
        $('#createQuote').click(function () {
            debugger;


            var RequiredQty = $("#Availableqty").val() - $("#itemquantity").val();
            $("#Requiredqty").val(RequiredQty);
            var classvalue = '';
            if (RequiredQty > 0) {
                classvalue = "bg-success";
            } else {
                classvalue = "bg-danger";
            }

            var TotalAmtRequired = $("#Rate").val() * $("#Requiredqty").val();
            $("#Totalamtrequired").val(TotalAmtRequired);
            var formData = $('#quote_form').serializeJSON();
            purchases.push(formData);
            if (formData['itemquantity'] != "" && formData['itemquantity'] != "0") {
                $('#lineItemTable tbody').
                    append($(document.createElement('tr')).prop({

                    }));
                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['Articleno']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['selectedItemName']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['HSNcode']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['itemquantity']
                    }));
                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['UnitName']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['Rate']
                    }));
                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['TotalAmt']
                    }));
                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: formData['Availableqty']
                    }));

                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({

                        class: classvalue,
                        style: "color:white",
                        innerHTML: RequiredQty
                    }));
                $('#lineItemTable tr:last').
                    append($(document.createElement('td')).prop({
                        innerHTML: TotalAmtRequired
                    }));


            } else {
                // alert("Please add the appropriate values in the Quantity")
            }
            var x = document.getElementById("itemid");
            x.remove(x.selectedIndex);
        });

        $('#quote_form').submit(function (event) {
            debugger;
            // purchases[0].totalAmount = $('#totalAmount').val();
            // console.log(purchases[0]);
            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/purchaseordercontroller.php",
                data: {
                    "obj": purchases
                },
                dataType: "json",
                encode: true,
            }).done(function (data) {
                location.reload(true);
                console.log(data);
            });

        });

        // var uniturl = config.developmentPath +
        //     "/Admin/Controller/unitsContoller.php"
        // $.getJSON(uniturl, function(data) {
        //     loadUnitFactor(data[0].unitId);
        //     $.each(data, function(index, value) {
        //         $('#unit').append(
        //             '<option hidden disabled selected value>-- select an option --</option>'
        //         );
        //         $('#unit').append('<option value="' + value.unitId + '">' + value
        //             .unitName + '</option>');
        //     });

        // });

        // function loadUnitFactor(unitId) {
        //     $('#unitFactor').empty();
        //     unitFactorurl =
        //         config.developmentPath +
        //         "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
        //     $.getJSON(unitFactorurl, function(data) {
        //         $.each(data, function(index, value) {
        //             $('#unitFactor').append(
        //                 '<option hidden disabled selected value>Blank</option>');
        //             $('#unitFactor').append('<option value="' + value.unitFactorId +
        //                 '">' + value.unitFactor + '</option>');

        //         });
        //     });
        // }





        $('#itemperpieceprice').blur(function (e) {

            $('#totalAmount').val((parseFloat($('#itemquantity').val() * parseFloat($(
                '#itemperpieceprice')
                .val()) * parseFloat($('#unitFactor').val()))).toFixed(2));

        });


        // var url = config.developmentPath + "/Admin/Controller/item_detailscontroller.php";
        // $.getJSON(url, function(data) {

        //     itemDetails = data;
        //     mappItemPrice(data[0].itemperpieceprice,
        //         data[0].itemname,
        //         data[0].unitFactor,
        //         data[0].itemarticleNo,
        //         data[0].itemhsncode);
        //     $.each(data, function(index, value) {
        //         $('#itemid').append('<option value="' + value.itemid + '">' + value
        //             .itemname + '</option>');
        //     });
        // });

        var url = config.developmentPath + "/Admin/Controller/item_stockscontroller.php";
        $.getJSON(url, function (data) {
            quantityDetails = data;
            mapquantityDetails(data[0].req,
                data[0].price,
                data[0].totalamt,
                data[0].quantity);
            $.each(data, function (index, value) {
                $('#itemid').append('<option value="' + value.itemid + '">' + value
                    .itemname + '</option>');
            });
        });

        var url = config.developmentPath + "/Admin/Controller/lineItemController.php";
        $.getJSON(url, function (data) {

            stockDetails = data;
            // mapStockDetails(data[0].itemquantity);
            $.each(data, function (index, value) {
                $('#itemid').append('<option value="' + value.itemid + '">' + value
                    .itemname + '</option>');
            });
        });


        $('#itemid').on('change', function (e) {
            debugger;
            for (var i = 0; i < itemDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (itemDetails[i].itemid == this.value) {
                    $('#itemquantity').val("");
                    $('#totalAmount').val("");
                    mappItemPrice(itemDetails[i].itemperpieceprice,
                        itemDetails[i].itemname,
                        itemDetails[i].unitFactor,
                        itemDetails[i].itemarticleNo,
                        itemDetails[i].itemhsncode);
                }
            }
            for (var i = 0; i < stockDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (stockDetails[i].itemid == this.value) {
                    $('#itemquantity').val("");
                    $('#totalAmount').val("");
                    mapStockDetails(stockDetails[i].unit,
                        stockDetails[i].price,
                        stockDetails[i].totalamt,
                        stockDetails[i].quantity);
                }
            }
            for (var i = 0; i < quantityDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (quantityDetails[i].itemid == this.value) {
                    $('#itemquantity').val("");
                    $('#totalAmount').val("");
                    mapquantityDetails(quantityDetails[i].itemquantity);
                }
            }

        });

        function mapquantityDetails(itemquantity) {
            debugger;
            $('#itemquantity').val(itemquantity);
        }



        function mapStockDetails(unit, price, totalamt, quantity) {
            debugger;
            $('#UnitName').val(unit);
            $('#Rate').val(price);
            $('#TotalAmt').val(totalamt);
            $('#Availableqty').val(quantity);

        }

        function mappItemPrice(price, name, unitFactor, itemarticleNo, itemhsncode) {
            debugger;
            $('#itemperpieceprice').val(price);
            $('#selectedItemName').val(name);
            $('#unitFactor').val(unitFactor);
            $('#Articleno').val(itemarticleNo);
            $('#HSNcode').val(itemhsncode);
        }
        debugger;
        var fetchproject = config.developmentPath + "/Admin/Controller/projectController.php/"
        let isSelectedSet1 = false;
        let projId = 0;
        $.getJSON(fetchproject, function (data) {

            if (isSelectedSet1 === false) {
                $.each(data, function (index, value) {
                    $('#project').append(
                        '<option hidden disabled selected value>-- select an option --</option>'
                    );
                    $('#project').append('<option value="' + value.projectId + '">' + value
                        .projectCode + '</option>');
                    isSelectedSet1 = true;
                    // setItemlist(value.projectId);
                });
            }
        });

        function setItemlist(brandId, projId, catId = 0, subcatId = 0,) {
            debugger;
            var fetchitemlisturl = config.developmentPath +
                "/Admin/Controller/item_detailscontroller.php/?brandId=" + brandId + "&projId=" + projId +
                "&catId=" + catId + "&subcatId=" + subcatId;
            console.log(fetchitemlisturl);
            $.getJSON(fetchitemlisturl, function (data) {
                itemDetails = data;
                stockDetails = data;
                quantityDetails = data;
                ItemPrice = data;
                // console.log(itemDetails);
                $('#itemid').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (index, value) {
                    $('#itemid').append('<option value="' + value.itemid + '">' + value.itemname +
                        '</option>');
                });
            });
        }


        function setCompanylist(brandId) {
            debugger;
            var fetchCompanylist = config.developmentPath +
                "/Admin/Controller/item_compdetailscontroller.php/?brandId=" + brandId;
            $.getJSON(fetchCompanylist, function (data) {
                $('#supplier').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {

                    $('#supplier').append('<option value="' + value.itemcompid + '">' + value
                        .itemcompname + '</option>');

                });
            });

        }

        var url = config.developmentPath + "/Admin/Controller/projectController.php";
        $.getJSON(url, function (data) {

            custDetails = data;
            // mappCustdetails(data[0].custName,data[0].custid);

        });

        function mappCustdetails(custName, custid) {
            $('#customerName').val(custName);
            $('#customerId').val(custid);
        }
        $('#project').on('change', function (e) {
            debugger;
            for (var i = 0; i < custDetails.length; i++) {
                // look for the entry with a matching `code` value
                if (custDetails[i].projectId == this.value) {
                    mappCustdetails(
                        custDetails[i].custName,
                        custDetails[i].custid);

                }
            }

        });

        $('#project').on('change', function () {
            debugger;
            $('#itemid').empty();
            $('#brands').empty();

            fetchbrandlist =
                config.developmentPath +
                "/Admin/Controller/brandcontroller.php/?projId=" + this.value;
            console.log(fetchbrandlist);
            console.log(this.value);
            $.getJSON(fetchbrandlist, function (data) {
                console.log(data)
                $('#brands').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#brands').append('<option value="' + value.brandid +
                        '">' + value.brandname + '</option>');
                });
            });


        });

        $('#brands').on('change', function () {
            debugger;
            $('#itemid').empty();
            $('#supplier').empty();
            var fetchCompanylist = config.developmentPath +
                "/Admin/Controller/item_compdetailscontroller.php/?brandId=" + this.value;
            console.log(fetchCompanylist);
            console.log(this.value);
            $.getJSON(fetchCompanylist, function (data) {
                $('#supplier').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $.each(data, function (index, value) {

                    $('#supplier').append('<option value="' + value.itemcompid + '">' +
                        value
                            .itemcompname + '</option>');

                });
            });

            setItemlist(this.value, $('#project').val());
            // setCompanylist($('#project').val(), this.value);

        });






    });
</script>