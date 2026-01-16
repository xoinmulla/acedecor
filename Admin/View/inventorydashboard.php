<?php
include('inventoryheader.php');
// include('session.php');
include "../DB Operations/dashboardOps.php";

$InwardedandAvailable = DBDashboard::InwardedandAvailable();



?>
<head>
    <style>
    .widget-stat,
    .media {

        align-items: center;
        background-color: white;
        height: 100px;
    }

    .card {

        padding: 0.5rem;
    }

    .card-body {

        padding: 0rem;
    }


    .card-fas {

        color: #6699cc;
    }

    .col-sm-3 {
        flex: 0 0 22%;
        max-width: 20%;
    }
    </style>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
        'packages': ['corechart']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawCustomerChart);
    google.charts.setOnLoadCallback(drawProjectStatusChart);
    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.arrayToDataTable([
            ['MONTH', 'Inwarded Quantity', 'Available Quantity'],
            <?php
        while ($row = mysqli_fetch_array($InwardedandAvailable)) {
            echo "['" . $row['MONTH'] . "'," .intval($row['ReceivedQty'])."," .intval($row['AvailableQty']). "],";
        }
         ?>
        ]);

        // Set chart options
        var options = {
            'title': 'InwardedStock V/S AvailableStock',

            'width': 800,
            'height': 400
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('stock_div'));
        chart.draw(data, options);
    }
    </script>
</head>
<body>
    <h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
    <span id="message"></span>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bolder;">INVENTORY DASHBOARD</h6>
            <div class="row">
                <div class="col">

                </div>
                <!-- <div class="col" align="right">
                    <span data-toggle=modal data-target=#itemdetailsModal>
                        <button type="button" class="btn btn-success btn-circle btn-sm"><i
                                class="fas fa-plus"></i></button>
                    </span>
                </div> -->
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                    <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div id="stock_div"></div>
                </div>
                <div class="col-lg-1"></div>
            </div>
                    </div>
                   
                </div>
            </div>
            <div class="modal fade" id=itemcatModal tabindex=-1 role=dialog aria-hidden=true>
                <div class="modal-dialog">
                    <form method="POST" id="addCategoryForm" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Add Data</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <span id="form_message"></span>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 text-right">Category Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="itemcatname" id="itemcatname" class="form-control"
                                                required data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 text-right">Category Description <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="itemcatdescription" id="itemcatdescription"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="10" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <input type="hidden" name="itemcatcreatedby" id="itemcatcreatedby"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="10" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="hidden" name="itemcatmodifiedby" id="itemcatmodifiedby"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="10" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="submit" name="submit" id="addCategorybtn" class="btn btn-success"
                                    value="Add" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade" id=itemsubcatModal tabindex=-1 role=dialog aria-hidden=true>
                <div class="modal-dialog">
                    <form method="POST" id="subCategoryForm" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Add Data</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <span id="form_message"></span>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 text-right">Category Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <select id="additemCategory" class="form-select" required name="itemcatid">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 text-right">SubCategory Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="itemsubcatname" id="itemsubcatname"
                                                class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 text-right">SubCategory Description <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="itemsubcatdescription" id="itemsubcatdescription"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="10" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <input type="hidden" name="itemsubcatcreatedby" id="itemsubcatcreatedby"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="10" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <input type="hidden" name="itemsubcatmodifiedby" id="itemsubcatmodifiedby"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="10" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="submit" name="submit" id="addSubCategorybtn" class="btn btn-success"
                                    value="Add" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include('footer.php'); ?>
    <script>
    var dimensionurl = config.developmentPath +
        "/Admin/Controller/dimensionsContoller.php"
    $.getJSON(dimensionurl, function(data) {
        $.each(data, function(index, value) {
            $('#dimensions').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $('#dimensions').append('<option value="' + value.dimensionId + '">' + value
                .dimensionName + '</option>');
        });

    });
    debugger;
    var rotationurl = config.developmentPath +
        "/Admin/Controller/rotationController.php"
    console.log(rotationurl);
    $.getJSON(rotationurl, function(data) {
        $.each(data, function(index, value) {
            $('#materialrotation').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $('#materialrotation').append('<option value="' + value.rotationId + '">' + value
                .sides + '</option>');
        });

    });

    var uniturl = config.developmentPath +
        "/Admin/Controller/unitsContoller.php"
    $.getJSON(uniturl, function(data) {
        loadUnitFactor(data[0].unitId);
        $.each(data, function(index, value) {
            $('#unit').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $('#productunit').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $('#materialunit').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $('#unit').append('<option value="' + value.unitId + '">' + value
                .unitName + '</option>');
            $('#productunit').append('<option value="' + value.unitId + '">' + value
                .unitName + '</option>');
            $('#materialunit').append('<option value="' + value.unitId + '">' + value
                .unitName + '</option>');
        });

    });

    function loadUnitFactor(unitId) {
        $('#unitFactor').empty();
        $('#productunitFactor').empty();
        $('#materialunitFactor').empty();
        unitFactorurl =
            config.developmentPath +
            "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
        $.getJSON(unitFactorurl, function(data) {
            $.each(data, function(index, value) {
                $('#unitFactor').append(
                    '<option hidden disabled selected value>Blank</option>');
                $('#productunitFactor').append(
                    '<option hidden disabled selected value>Blank</option>');
                $('#materialunitFactor').append(
                    '<option hidden disabled selected value>Blank</option>');
                $('#unitFactor').append('<option value="' + value.unitFactorId +
                    '">' + value.unitFactor + '</option>');
                $('#productunitFactor').append('<option value="' + value.unitFactorId +
                    '">' + value.unitFactor + '</option>');
                $('#materialunitFactor').append('<option value="' + value.unitFactorId +
                    '">' + value.unitFactor + '</option>');
            });
        });
    }

    var url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
    let isSelectedSet = false;
    let catId = 0;
    $.getJSON(url, function(data) {
        $.each(data, function(index, value) {
            if (isSelectedSet === false) {
                $('#itemCategory').append('<option selected value="' + value.itemcatid +
                    '">' +
                    value
                    .itemcatname + '</option>');
                $('#productitemCategory').append('<option value="' + value
                    .itemcatid +
                    '">' + value
                    .itemcatname + '</option>');
                $('#materialCategory').append('<option value="' + value
                    .itemcatid +
                    '">' + value
                    .itemcatname + '</option>');
                isSelectedSet = true;
                setSubCategory(value.itemcatid);

            } else {
                $('#itemCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#productitemCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#materialCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );

                $('#itemCategory').append('<option value="' + value.itemcatid + '">' + value
                    .itemcatname + '</option>');
                $('#productitemCategory').append('<option value="' + value.itemcatid + '">' +
                    value
                    .itemcatname + '</option>');
                $('#materialCategory').append('<option value="' + value.itemcatid + '">' +
                    value
                    .itemcatname + '</option>');
            }
        });
    });

    function setSubCategory(catId) {
       let subcatId=0;
        var fetchsubcaturl = config.developmentPath +
            "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
            catId;
        $.getJSON(fetchsubcaturl, function(data) {

            $('#subCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $('#productsubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $('#materialsubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function(index, value) {

                $('#subCategory').append('<option value="' + value.itemsubcatid + '">' +
                    value
                    .itemsubcatname + '</option>');
                $('#productsubCategory').append('<option value="' + value.itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
                $('#materialsubCategory').append('<option value="' + value.itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
            });
        });
    }


    function setBrand(catId) {
        debugger;
        var fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php/?catId=" + catId;
        $.getJSON(fetchcompany, function(data) {
            $.each(data, function(index, value) {
                $('#company').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $('#productbrand').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $('#materialbrand').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $('#company').append('<option value="' + value.brandid + '">' + value
                    .brandname + '</option>');
                $('#productbrand').append('<option value="' + value.brandid + '">' + value
                    .brandname + '</option>');
                $('#materialbrand').append('<option value="' + value.brandid + '">' + value
                    .brandname + '</option>');
            });
        });
    }

    function setMaterial(brandId,catId) {
        debugger;
        var fetchmaterial = config.developmentPath + "/Admin/Controller/materialController.php/?brandId=" +
            brandId +
            "&catId=" + catId;
        $.getJSON(fetchmaterial, function(data) {
            $.each(data, function(index, value) {
                $('#productmaterial').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#productmaterial').append('<option value="' + value.MaterialId + '">' +
                    value
                    .MaterialName + '</option>');

            });
        });

    }

    $('#materialCategory').on('change', function() {
        $('#materialsubCategory').empty();
        $('#materialbrand').empty();
        setSubCategory(this.value, $('#materialsubCategory').val());
        setBrand(this.value, $('#materialbrand').val());
    });

    $('#itemCategory').on('change', function() {
        $('#subCategory').empty();
        $('#brand').empty();
        setSubCategory(this.value, $('#subCategory').val());
        setBrand(this.value, $('#brand').val());
    });

    $('#productbrand').on('change', function() {
        debugger;
        $('#productmaterial').empty();
        setMaterial(this.value, $('#productitemCategory').val());
    });

    $('#productitemCategory').on('change', function() {
        debugger;
        $('#productsubCategory').empty();
        $('#productbrand').empty();
        setSubCategory(this.value, $('#productsubCategory').val());
        setBrand(this.value, $('#productbrand').val());
    });

    $('#productunit').on('change', function() {
        $('#productunitFactor').empty();
        unitFactorurl =
            config.developmentPath +
            "/Admin/Controller/unitFactorController.php/?unitId=" + this
            .value;
        $.getJSON(unitFactorurl, function(data) {

            $.each(data, function(index, value) {
                $('#productunitFactor').append('<option value="' + value.unitFactorId +
                    '">' +
                    value
                    .unitFactor + '</option>');
            });
        });
    });

    $('#materialunit').on('change', function() {
        $('#materialunitFactor').empty();
        unitFactorurl =
            config.developmentPath +
            "/Admin/Controller/unitFactorController.php/?unitId=" + this
            .value;
        $.getJSON(unitFactorurl, function(data) {

            $.each(data, function(index, value) {
                $('#materialunitFactor').append('<option value="' + value.unitFactorId +
                    '">' +
                    value
                    .unitFactor + '</option>');
            });
        });
    });


    $('#unit').on('change', function() {
        $('#unitFactor').empty();
        $('#productunitFactor').empty();
        unitFactorurl =
            config.developmentPath +
            "/Admin/Controller/unitFactorController.php/?unitId=" + this
            .value;
        $.getJSON(unitFactorurl, function(data) {

            $.each(data, function(index, value) {

                $('#unitFactor').append('<option value="' + value.unitFactorId +
                    '">' +
                    value
                    .unitFactor + '</option>');

                $('#productunitFactor').append('<option value="' + value.unitFactorId +
                    '">' +
                    value
                    .unitFactor + '</option>');
            });
        });
    });


    $('#addCategoryForm').submit(function(event) {

        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        reloadCategoryList();
        $('#itemcatModal').hide();
    });

    $('#subCategoryForm').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        reloadSubCategoryList();
        $('#itemsubcatModal').hide();
    });
    </script>