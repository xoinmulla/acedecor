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

    .form-group label {
        font-weight: 600;
        margin-bottom: 6px;
    }
</style>
<h1 class="h3 mb-4 text-gray-800">Purchase Order</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Purchase
                    Order</h6>
            </div>
            <form class="" method="POST" id="quote_form" enctype="multipart/form-data">
                <div class="accordion-item">
                    <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="form-group">
                                <div class="row">
                                    <input type="hidden" name="selectedItemName" id="selectedItemName">
                                    <input type="hidden" name="Articleno" id="Articleno">
                                    <input type="hidden" name="itemdescription" id="itemdescription">
                                    <input type="hidden" name="unitFactor" id="unitFactor">
                                    <input type="hidden" name="selectedBrandName" id="selectedBrandName">


                                    <div class="col-md-3">
                                        <label>Supplier <span class="text-danger">*</span></label>
                                        <select id="supplier" class="form-select" required name="supplier"></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Brands <span class="text-danger">*</span></label>
                                        <select id="brands" class="form-select" required name="brands"></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>DOP <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="purchaseddate" name="purchaseddate">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Inventory <span class="text-danger">*</span></label>
                                        <select id="inventoryType" name="inventoryType" class="form-select" required>
                                            <option value="" hidden>-- Select --</option>
                                            <option value="item">Item</option>
                                            <option value="material">Material</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="row">

                                    <div class="col-md-3">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <select id="itemCategory" class="form-select" required></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Sub Category <span class="text-danger">*</span></label>
                                        <select id="itemsubCategory" class="form-select" required></select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Name *</label>
                                        <select id="itemid" name="itemid" class="form-select" required></select>

                                    </div>

                                    <div class="col-md-3">
                                        <label>Quantity *</label>
                                        <input type="text" id="itemquantity" name="itemquantity" class="form-control"
                                            required>
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
                                        <th>Inventory</th>
                                        <th> Code</th>
                                        <th> Name</th>
                                        <th>Brand</th>
                                        <th> Description</th>
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

    let inventoryType = "";
    let itemDetails = [];
    $('#inventoryType').on('change', function () {
        inventoryType = this.value;
        $('#itemCategory, #itemsubCategory, #itemid').empty();
        if (!inventoryType) return;
        loadCategoryByInventory();
    });

    function loadCategoryByInventory() {

        let brandId = $('#brands').val();
        if (!brandId) {
            alert("Please select Brand first");
            $('#inventoryType').val('');
            return;
        }

        let url = inventoryType === "item"
            ? config.developmentPath + "/Admin/Controller/item_categorycontroller.php?brandId=" + brandId
            : config.developmentPath + "/Admin/Controller/material_CategoryController.php?brandId=" + brandId;

        $.getJSON(url, function (data) {

            console.log("Category API Data:", data); // debug

            $('#itemCategory')
                .empty()
                .append('<option hidden selected>-- select --</option>');

            if (!data || data.length === 0) {
                alert("No categories found");
                return;
            }

            data.forEach(v => {

                let id, name;

                if (inventoryType === "item") {
                    id = v.itemcatid;
                    name = v.itemcatname;
                } else {
                    // ✅ EXACT keys from your API
                    id = v.materialcatId;
                    name = v.materialCatname;
                }

                if (id && name) {
                    $('#itemCategory').append(
                        `<option value="${id}">${name}</option>`
                    );
                }
            });
        });
    }
    $('#brands').on('change', function () {
        let brandName = $('#brands option:selected').text();
        $('#selectedBrandName').val(brandName);

        $('#inventoryType').val('');
        $('#itemCategory, #itemsubCategory, #itemid').empty();
    });


    $('#itemCategory').on('change', function () {

        $('#itemsubCategory').empty();
        $('#itemid').empty();

        let url = inventoryType === "item"
            ? config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php?catId=" + this.value
            : config.developmentPath + "/Admin/Controller/material_SubcategoryController.php?catId=" + this.value;

        $.getJSON(url, function (data) {

            console.log("Material SubCategory API:", data); // debug

            $('#itemsubCategory')
                .append('<option hidden selected>-- select --</option>');

            if (!data || data.length === 0) return;

            data.forEach(v => {

                let id, name;

                if (inventoryType === "item") {
                    id = v.itemsubcatid;
                    name = v.itemsubcatname;
                } else {
                    // ✅ EXACT keys from your JSON
                    id = v.materialsubcatId;
                    name = v.materialsubcatName;
                }

                if (id && name) {
                    $('#itemsubCategory').append(
                        `<option value="${id}">${name}</option>`
                    );
                }
            });
        });
    });


    $('#itemsubCategory').on('change', function () {

        $('#itemid').empty();

        let url = inventoryType === "item"
            ? config.developmentPath + "/Admin/Controller/item_detailscontroller.php?catId=" +
            $('#itemCategory').val() + "&subcatId=" + this.value + "&brandId=" + $('#brands').val()
            : config.developmentPath + "/Admin/Controller/materialController.php?catId=" +
            $('#itemCategory').val() + "&subcatId=" + this.value + "&brandId=" + $('#brands').val();

        $.getJSON(url, function (data) {

            console.log("Material Items API:", data); // 🔍 DEBUG

            itemDetails = data;

            $('#itemid')
                .empty()
                .append('<option hidden selected>-- select --</option>');

            if (!data || data.length === 0) return;

            data.forEach(v => {

                if (inventoryType === "item") {
                    $('#itemid').append(
                        `<option value="${v.itemid}">${v.itemname}</option>`
                    );
                } else {
                    // ✅ MATERIAL (EXACT KEYS FROM API)
                    $('#itemid').append(
                        `<option value="${v.MaterialId}">${v.MaterialName}</option>`
                    );
                }
            });
        });
    });






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
            var formData = $('#quote_form').serializeJSON();
            purchases.push(formData);
            if (formData['itemquantity'] != "" && formData['itemquantity'] != "0") {
                $('#lineItemTable tbody').
                    append($(document.createElement('tr')).prop({

                    }));
                $('#lineItemTable tr:last').append(
                    `<td>${inventoryType.toUpperCase()}</td>`
                );

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
                        innerHTML: formData['selectedBrandName']
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

        $('#quote_form').submit(function (event) {

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
                console.log(data);
            });

        });

        var uniturl = config.developmentPath +
            "/Admin/Controller/unitsContoller.php"
        $.getJSON(uniturl, function (data) {
            loadUnitFactor(data[0].unitId);
            $.each(data, function (index, value) {
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
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#unitFactor').append(
                        '<option hidden disabled selected value>Blank</option>');
                    $('#unitFactor').append('<option value="' + value.unitFactorId +
                        '">' + value.unitFactor + '</option>');

                });
            });
        }



        $('#itemperpieceprice').blur(function (e) {

            $('#totalAmount').val((parseFloat($('#itemquantity').val() * parseFloat($(
                '#itemperpieceprice')
                .val()) * parseFloat($('#unitFactor').val()))).toFixed(2));

        });



        // $('#itemid').empty();

        // var url = config.developmentPath + "/Admin/Controller/item_detailscontroller.php";
        // $.getJSON(url, function (data) {

        //     itemDetails = data;
        //     mappItemPrice(data[0].itemperpieceprice,
        //         data[0].itemname,
        //         data[0].unitFactor,
        //         data[0].itemarticleNo,
        //         data[0].itemdescription);
        //     $.each(data, function (index, value) {
        //         $('#itemid').append('<option value="' + value.itemid + '">' + value
        //             .itemname + '</option>');
        //     });
        // });

        $('#itemid').on('change', function () {

            let id = this.value;

            let item = inventoryType === "item"
                ? itemDetails.find(x => x.itemid == id)
                : itemDetails.find(x => x.MaterialId == id);

            if (!item) return;

            if (inventoryType === "item") {
                $('#selectedItemName').val(item.itemname);
                $('#Articleno').val(item.itemarticleNo || '');
                $('#itemdescription').val(item.itemdescription || '');
                $('#unitFactor').val(item.unitFactor || 1);
            } else {
                // ✅ MATERIAL
                $('#selectedItemName').val(item.MaterialName);
                $('#Articleno').val(item.MaterialCode || '');
                $('#itemdescription').val(item.MaterialDescription || '');
                $('#unitFactor').val(1);
            }
        });



        var fetchCompanylist = config.developmentPath +
            "/Admin/Controller/item_compdetailscontroller.php/";
        console.log(fetchCompanylist);
        console.log(this.value);
        $.getJSON(fetchCompanylist, function (data) {

            $.each(data, function (index, value) {
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
        $('#supplier').on('change', function (e) {
            debugger;
            $('#brands').empty();
            fetchbrandlist =
                config.developmentPath +
                "/Admin/Controller/brandcontroller.php/?supplierId=" + this.value;
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
        // $('#brands').on('change', function () {
        //     debugger;
        //     let brandId = 0;
        //     $('#itemCategory').empty();

        //     fetchcatlist = config.developmentPath +
        //         "/Admin/Controller/item_categorycontroller.php/?brandId=" + this.value;
        //     console.log(fetchcatlist);
        //     $.getJSON(fetchcatlist, function (data) {
        //         $('#itemCategory').append(
        //             '<option hidden disabled selected value>-- select an option --</option>'
        //         );
        //         $.each(data, function (index, value) {

        //             $('#itemCategory').append('<option value="' + value
        //                 .itemcatid +
        //                 '">' +
        //                 value
        //                     .itemcatname + '</option>');
        //         });
        //     });

        // });
        // $('#itemCategory').on('change', function () {
        //     debugger;
        //     $('#itemsubCategory').empty();
        //     var fetchsubcaturl = config.developmentPath +
        //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
        //         this.value;
        //     let subcatId = 0;
        //     let projId = 0;
        //     $.getJSON(fetchsubcaturl, function (data) {
        //         $('#itemsubCategory').append(
        //             '<option hidden disabled selected value>-- select an option --</option>');
        //         $.each(data, function (index, value) {
        //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
        //             $('#itemsubCategory').append('<option value="' + value.itemsubcatid +
        //                 '">' +
        //                 value
        //                     .itemsubcatname + '</option>');
        //             $('#editeditemsubCategory').append('<option value="' + value
        //                 .itemsubcatid +
        //                 '">' +
        //                 value
        //                     .itemsubcatname + '</option>');
        //         });
        //     });
        // });



        function mappItemPrice(price, name, unitFactor, itemarticleNo, itemdescription) {
            debugger;
            $('#itemperpieceprice').val(price);
            $('#selectedItemName').val(name);
            $('#unitFactor').val(unitFactor);
            $('#Articleno').val(itemarticleNo);
            $('#itemdescription').val(itemdescription);
        }

        // function setItemlist(catId, subcatId, brandId) {
        //     debugger;
        //     let itemId = 0;

        //     var fetchitemlisturl = config.developmentPath +
        //         "/Admin/Controller/item_detailscontroller.php/?catId=" + catId + "&subcatId=" + subcatId + "&brandId=" + brandId;
        //     console.log(fetchitemlisturl);
        //     $.getJSON(fetchitemlisturl, function (data) {
        //         itemDetails = data;
        //         $('#itemid').append(
        //             '<option hidden disabled selected value>-- select an option --</option>');
        //         $.each(data, function (index, value) {
        //             $('#itemid').append('<option value="' + value.itemid + '">' + value.itemname +
        //                 '</option>');
        //         });
        //     });
        // }

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
            $.getJSON(fetchCompanylist, function (data) {

                $.each(data, function (index, value) {
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
        // $('#itemsubCategory').on('change', function () {
        //     debugger;
        //     $('#itemid').empty();
        //     setItemlist($('#itemCategory').val(), this.value, $('#brands').val());

        // });
    });
</script>