<?php
include('session.php');
include "purchaseorderheader.php";
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
                <h6 class="m-0 font-weight-bold text-primary">Purchase Order</h6>
            </div>
            <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
                <div class="accordion-item">
                    <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                        <div class="form-group">
                                <div class="row">
                                    
                                    <label class="col-md-2 text-right">Supplier <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <select id="supplier" class="form-select" required name="supplier">

                                        </select>
                                    </div>

                                    <label class="col-md-2 text-right">Brands <span class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <select id="brands" class="form-select" required name="brands">

                                        </select>
                                    </div>

                                    <label class="col-md-2 text-right">DOP <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" id="purchaseddate" name="purchaseddate">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 text-right">Category<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <select id="itemCategory" class="form-select" required name="itemCategory">

                                        </select>
                                    </div>

                                    <label class="col-md-2 text-right">Sub Category <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <select id="itemsubCategory" class="form-select" required
                                            name="itemsubCategory">

                                        </select>
                                    </div>
                                    <label class="col-md-2 text-right">Item <span class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <select id="itemid" class="form-select" required name="itemid">

                                        </select>
                                        <input type="hidden" name="selectedItemName" id="selectedItemName"
                                            class="form-control" value="" />
                                        <input type="hidden" name="unitFactor" id="unitFactor" class="form-control"
                                            value="" />
                                        <input type="hidden" name="Articleno" id="Articleno" class="form-control"
                                            value="" />

                                        <input type="hidden" name="itemdescription" id="itemdescription"
                                            class="form-control" value="" />
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">

                                    <label class="col-md-2 text-right">Item Quantity <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <input type="text" name="itemquantity" id="itemquantity" class="form-control"
                                            required />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">



                                    
                                </div>
                            </div>
                            <table class="table table-bordered" id="lineItemTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                            <div class="form-group">
                                <div class="row ">


                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-primary" id="createQuote">Add
                                        Item</button>
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
$(document).ready(function() {
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;

    document.getElementById("purchaseddate").value = today;
    var purchases = [];
    $('#createQuote').click(function() {
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
                innerHTML: formData['itemdescription']
            }));

            $('#lineItemTable tr:last').
            append($(document.createElement('td')).prop({
                innerHTML: formData['itemquantity']
            }));
            // $('#lineItemTable tr:last').
            // append($(document.createElement('td')).prop({
            //     innerHTML: formData['itemperpieceprice']
            // }));

        } else {
            alert("Please add the appropriate values in the Quantity")
        }

    });

    $('#quote_form').submit(function(event) {

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
        }).done(function(data) {
            console.log(data);
        });

    });

    var uniturl = config.developmentPath +
        "/Admin/Controller/unitsContoller.php"
    $.getJSON(uniturl, function(data) {
        loadUnitFactor(data[0].unitId);
        $.each(data, function(index, value) {
            $('#unit').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $('#unit').append('<option value="' + value.unitId + '">' + value
                .unitName + '</option>');
        });

    });

    function loadUnitFactor(unitId) {
        $('#unitFactor').empty();
        unitFactorurl =
            config.developmentPath +
            "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
        $.getJSON(unitFactorurl, function(data) {
            $.each(data, function(index, value) {
                $('#unitFactor').append(
                    '<option hidden disabled selected value>Blank</option>');
                $('#unitFactor').append('<option value="' + value.unitFactorId +
                    '">' + value.unitFactor + '</option>');

            });
        });
    }



    $('#itemperpieceprice').blur(function(e) {

        $('#totalAmount').val((parseFloat($('#itemquantity').val() * parseFloat($(
                '#itemperpieceprice')
            .val()) * parseFloat($('#unitFactor').val()))).toFixed(2));

    });



    $('#itemid').empty();

    var url = config.developmentPath + "/Admin/Controller/item_detailscontroller.php";
    $.getJSON(url, function(data) {

        itemDetails = data;
        mappItemPrice(data[0].itemperpieceprice,
            data[0].itemname,
            data[0].unitFactor,
            data[0].itemarticleNo,
            data[0].itemdescription);
        $.each(data, function(index, value) {
            $('#itemid').append('<option value="' + value.itemid + '">' + value
                .itemname + '</option>');
        });
    });

    $('#itemid').on('change', function(e) {
        debugger;
        // $('#brands').empty();
        for (var i = 0; i < itemDetails.length; i++) {
            // look for the entry with a matching `code` value
            if (itemDetails[i].itemid == this.value) {
                $('#itemquantity').val("");
                $('#totalAmount').val("");
                mappItemPrice(itemDetails[i].itemperpieceprice,
                    itemDetails[i].itemname,
                    itemDetails[i].unitFactor,
                    itemDetails[i].itemarticleNo,
                    itemDetails[i].itemdescription);
            }
        }

    });
    var fetchCompanylist = config.developmentPath +
        "/Admin/Controller/item_compdetailscontroller.php/";
    console.log(fetchCompanylist);
    console.log(this.value);
    $.getJSON(fetchCompanylist, function(data) {

        $.each(data, function(index, value) {
            $('#supplier').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $('#supplier').append('<option value="' + value.itemcompid + '">' +
                value
                .itemcompname + '</option>');
            $('#editedcompany').append('<option value="' + value.itemcompid + '">' +
                value
                .itemcompname + '</option>');
        });
    });
    $('#supplier').on('change', function(e) {
        debugger;
        $('#brands').empty();
        fetchbrandlist =
            config.developmentPath +
            "/Admin/Controller/brandcontroller.php/?supplierId=" + this.value;
        console.log(fetchbrandlist);
        console.log(this.value);
        $.getJSON(fetchbrandlist, function(data) {
            console.log(data)
            $('#brands').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#brands').append('<option value="' + value.brandid +
                    '">' + value.brandname + '</option>');
            });
        });

    });
    $('#brands').on('change', function() {
        debugger;
        let brandId=0;
        $('#itemCategory').empty();

        fetchcatlist = config.developmentPath +
            "/Admin/Controller/item_categorycontroller.php/?brandId=" + this.value;
        console.log(fetchcatlist);
        $.getJSON(fetchcatlist, function(data) {
            $('#itemCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {

                $('#itemCategory').append('<option value="' + value
                    .itemcatid +
                    '">' +
                    value
                    .itemcatname + '</option>');
            });
        });

    });
    $('#itemCategory').on('change', function() {
        debugger;
        $('#itemsubCategory').empty();
        var fetchsubcaturl = config.developmentPath +
            "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
            this.value;
        let subcatId = 0;
        let projId = 0;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#itemsubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#itemsubCategory').append('<option value="' + value.itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
                $('#editeditemsubCategory').append('<option value="' + value
                    .itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
            });
        });
    });

  

    function mappItemPrice(price, name, unitFactor, itemarticleNo, itemdescription) {
        debugger;
        $('#itemperpieceprice').val(price);
        $('#selectedItemName').val(name);
        $('#unitFactor').val(unitFactor);
        $('#Articleno').val(itemarticleNo);
        $('#itemdescription').val(itemdescription);
    }

    function setItemlist(catId,subcatId,brandId) {
        debugger;
        let itemId = 0;
        
        var fetchitemlisturl = config.developmentPath +
            "/Admin/Controller/item_detailscontroller.php/?catId=" + catId + "&subcatId=" + subcatId + "&brandId=" + brandId;
        console.log(fetchitemlisturl);
        $.getJSON(fetchitemlisturl, function(data) {
            itemDetails = data;
            $('#itemid').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function(index, value) {
                $('#itemid').append('<option value="' + value.itemid + '">' + value.itemname +
                    '</option>');
            });
        });
    }

    // function setBrandlist(itemId) {
    //     debugger;
    //     let brandId = 0;
    //     var fetchbrandlisturl = config.developmentPath +
    //         "/Admin/Controller/brandcontroller.php/?itemId=";
    //     console.log(fetchbrandlisturl);
    //     $.getJSON(fetchbrandlisturl, function(data) {

    //         // console.log(itemDetails);
    //         $('#brands').append(
    //             '<option hidden disabled selected value>-- select an option --</option>'
    //         );
    //         $.each(data, function(index, value) {
    //             $('#brands').append('<option value="' + value.brandid + '">' + value
    //                 .brandname +
    //                 '</option>');
    //         });
    //     });
    // }

    function setCompanylist(brandId) {
        debugger;
        var fetchCompanylist = config.developmentPath +
            "/Admin/Controller/item_compdetailscontroller.php/?brandId=" + brandId;
        $.getJSON(fetchCompanylist, function(data) {

            $.each(data, function(index, value) {
                $('#supplier').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#supplier').append('<option value="' + value.itemcompid + '">' + value
                    .itemcompname + '</option>');
                $('#editedcompany').append('<option value="' + value.itemcompid + '">' + value
                    .itemcompname + '</option>');
            });
        });

    }




    // $('#itemCategory').on('change', function() {
    //     $('#itemsubCategory').empty();

    //     fetchsubcaturl =
    //         config.developmentPath +
    //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
    //         .value;
    //     $.getJSON(fetchsubcaturl, function(data) {
    //         $('#itemsubCategory').append(
    //             '<option hidden disabled selected value>-- select an option --</option>'
    //         );
    //         $.each(data, function(index, value) {
    //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
    //             $('#itemsubCategory').append('<option value="' + value.itemsubcatid +
    //                 '">' + value.itemsubcatname + '</option>');
    //         });
    //     });
    // });
    $('#itemsubCategory').on('change', function() {
        debugger;
        $('#itemid').empty();
        setItemlist($('#itemCategory').val(), this.value,$('#brands').val());

    });
});
</script>