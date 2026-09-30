<?php

include('inventoryheader.php');
// include('session.php');
include "../DB Operations/dashboardOps.php";

$InwardedandAvailable = DBDashboard::InwardedandAvailable();

?>

<head>

    <style>
        /* =========================================================
           INVENTORY DASHBOARD - RESPONSIVE STYLES
           Page-specific only; existing application design preserved.
           ========================================================= */

        .topbar {
            position: relative;
            z-index: 1050;
        }

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

        /* Do not override Bootstrap's .col-sm-3 globally. */

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .inventory-dashboard-card {
            width: 100%;
            max-width: 100%;
        }

        /* =========================================================
           CHART WRAPPER
           Only the chart can scroll horizontally on small screens.
           The complete page will NOT get horizontal scrolling.
           ========================================================= */

        .inventory-chart-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: auto;
        }

        /*
         * Desktop chart.
         * JavaScript will control the actual width.
         */
        #stock_div {
            width: 100%;
            max-width: 100%;
            min-height: 400px;
            overflow: visible;
        }

        /*
         * Optional visual indication that the chart is scrollable.
         * Does not change the existing design significantly.
         */
        .inventory-chart-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .inventory-chart-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .inventory-chart-wrapper::-webkit-scrollbar-thumb {
            background: #b8b8b8;
            border-radius: 10px;
        }

        .inventory-chart-wrapper::-webkit-scrollbar-thumb:hover {
            background: #888;
        }

        /* =========================================================
           MODAL RESPONSIVENESS
           Existing modal design preserved.
           ========================================================= */

        #itemcatModal .modal-dialog,
        #itemsubcatModal .modal-dialog {
            max-width: 600px;
            width: calc(100% - 30px);
            margin-left: auto;
            margin-right: auto;
        }

        #itemcatModal .modal-body,
        #itemsubcatModal .modal-body {
            overflow-y: auto;
        }

        /* =========================================================
           TABLET
           ========================================================= */

        @media (max-width: 991.98px) {

            .inventory-dashboard-card {
                margin-left: 0;
                margin-right: 0;
            }

            .inventory-dashboard-card .card-header {
                padding: 0.75rem 1rem;
            }

            /*
             * Keep chart readable on tablet.
             * Horizontal scrolling is available if required.
             */
            #stock_div {
                min-height: 400px;
            }

            .inventory-chart-wrapper {
                overflow-x: auto;
                overflow-y: hidden;
            }
        }

        /* =========================================================
           MOBILE
           ========================================================= */

        @media (max-width: 767.98px) {

            .inventory-dashboard-card .card-header {
                padding: 0.75rem;
            }

            .inventory-dashboard-card .card-body {
                padding: 0.5rem !important;
            }

            /*
             * IMPORTANT:
             *
             * Do NOT make the chart width equal to the mobile
             * viewport width.
             *
             * The chart needs enough width for:
             * - title
             * - legend
             * - Y axis
             * - X axis
             * - two data series
             *
             * Therefore the chart remains 700px wide and
             * the wrapper provides horizontal scrolling.
             */
            .inventory-chart-wrapper {
                width: 100%;
                max-width: 100%;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                padding-left: 0 !important;
                padding-right: 0 !important;
                padding-bottom: 8px;
            }

            #stock_div {
                width: 700px !important;
                min-width: 700px !important;
                max-width: none !important;
                min-height: 400px;
                height: 400px;
                overflow: visible;
            }

            /* Stack modal labels and fields on phones. */

            #itemcatModal .form-group .row,
            #itemsubcatModal .form-group .row {
                margin-left: 0;
                margin-right: 0;
            }

            #itemcatModal .form-group label,
            #itemsubcatModal .form-group label,
            #itemcatModal .form-group .col-md-4,
            #itemsubcatModal .form-group .col-md-4 {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
                text-align: left !important;
                padding-left: 0;
                padding-right: 0;
                margin-bottom: 0.4rem;
            }

            #itemcatModal .form-group .col-md-8,
            #itemsubcatModal .form-group .col-md-8 {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
                padding-left: 0;
                padding-right: 0;
            }

            #itemcatModal .modal-dialog,
            #itemsubcatModal .modal-dialog {
                width: calc(100% - 20px);
                max-width: none;
                margin: 10px auto;
            }

            #itemcatModal .modal-content,
            #itemsubcatModal .modal-content {
                max-height: calc(100vh - 20px);
            }

            #itemcatModal .modal-body,
            #itemsubcatModal .modal-body {
                max-height: calc(100vh - 150px);
                overflow-y: auto;
            }

            #itemcatModal .modal-footer,
            #itemsubcatModal .modal-footer {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }

        /* =========================================================
           VERY SMALL PHONES
           ========================================================= */

        @media (max-width: 400px) {

            .inventory-dashboard-card .card-header h6 {
                font-size: 1rem !important;
            }

            /*
             * Keep the same readable chart width even on
             * 320px / 375px / 390px devices.
             *
             * User can horizontally swipe the chart.
             */
            #stock_div {
                width: 700px !important;
                min-width: 700px !important;
                min-height: 400px;
                height: 400px;
            }

            #itemcatModal .modal-dialog,
            #itemsubcatModal .modal-dialog {
                width: calc(100% - 12px);
                margin: 6px auto;
            }

            #itemcatModal .modal-footer,
            #itemsubcatModal .modal-footer {
                padding: 0.75rem;
            }

            #itemcatModal .modal-footer .btn,
            #itemsubcatModal .modal-footer .btn {
                flex: 1 1 auto;
            }
        }

    </style>

    <script type="text/javascript"
        src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">

        // =========================================================
        // GOOGLE CHARTS
        // =========================================================

        google.charts.load('current', {
            'packages': ['corechart']
        });

        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawCustomerChart);
        google.charts.setOnLoadCallback(drawProjectStatusChart);


        // =========================================================
        // INVENTORY STOCK CHART
        // =========================================================

        function drawChart() {

            // Create the data table.
            var data = new google.visualization.arrayToDataTable([
                ['MONTH', 'Inwarded Quantity', 'Available Quantity'],

                <?php

                while ($row = mysqli_fetch_array($InwardedandAvailable)) {

                    echo "['" .
                        $row['MONTH'] .
                        "'," .
                        intval($row['ReceivedQty']) .
                        "," .
                        intval($row['AvailableQty']) .
                        "],";
                }

                ?>

            ]);


            // -----------------------------------------------------
            // Chart container
            // -----------------------------------------------------

            var chartContainer = document.getElementById('stock_div');

            if (!chartContainer) {
                return;
            }


            // -----------------------------------------------------
            // Determine viewport
            // -----------------------------------------------------

            var viewportWidth = window.innerWidth ||
                document.documentElement.clientWidth ||
                document.body.clientWidth;


            var containerWidth =
                chartContainer.parentElement
                    ? chartContainer.parentElement.clientWidth
                    : chartContainer.clientWidth;


            if (!containerWidth || containerWidth < 1) {
                containerWidth = viewportWidth || 320;
            }


            // -----------------------------------------------------
            // RESPONSIVE CHART WIDTH
            //
            // Desktop:
            //     Use available container width.
            //
            // Mobile:
            //     Minimum 700px.
            //
            // The wrapper will horizontally scroll.
            // -----------------------------------------------------

            var availableWidth;

            if (viewportWidth <= 767.98) {

                /*
                 * Mobile chart intentionally remains wide enough
                 * to display the chart correctly.
                 */
                availableWidth = 700;

            } else {

                /*
                 * Desktop / tablet:
                 * Use the available width but never allow the
                 * chart to become too small.
                 */
                availableWidth = Math.max(containerWidth, 500);
            }


            // -----------------------------------------------------
            // Chart height
            // -----------------------------------------------------

            var chartHeight;

            if (viewportWidth <= 767.98) {

                chartHeight = 400;

            } else if (viewportWidth <= 991.98) {

                chartHeight = 400;

            } else {

                chartHeight = 400;
            }


            // -----------------------------------------------------
            // Chart area
            // -----------------------------------------------------

            var chartLeft;

            if (viewportWidth <= 767.98) {

                chartLeft = 65;

            } else {

                chartLeft = 70;
            }


            // -----------------------------------------------------
            // Chart options
            // -----------------------------------------------------

            var options = {

                'title': 'InwardedStock V/S AvailableStock',

                'width': availableWidth,

                'height': chartHeight,

                'chartArea': {
                    'left': chartLeft,
                    'top': 45,
                    'width': '82%',
                    'height': '70%'
                },

                'legend': {
                    'position': 'top'
                },

                /*
                 * Keep the chart readable on smaller screens.
                 */
                'fontSize': 12,

                /*
                 * Do not force labels to become tiny.
                 */
                'hAxis': {
                    'textStyle': {
                        'fontSize': 11
                    }
                },

                'vAxis': {
                    'textStyle': {
                        'fontSize': 11
                    }
                }
            };


            // -----------------------------------------------------
            // Draw chart
            // -----------------------------------------------------

            var chart =
                new google.visualization.ColumnChart(chartContainer);

            chart.draw(data, options);
        }


        // =========================================================
        // REDRAW CHART WHEN SCREEN SIZE CHANGES
        // =========================================================

        var inventoryChartResizeTimer;

        window.addEventListener('resize', function () {

            clearTimeout(inventoryChartResizeTimer);

            inventoryChartResizeTimer = setTimeout(function () {

                if (
                    typeof google !== 'undefined' &&
                    google.visualization &&
                    google.visualization.ColumnChart
                ) {

                    drawChart();
                }

            }, 150);

        });


        // =========================================================
        // REDRAW AFTER ORIENTATION CHANGE
        // =========================================================

        window.addEventListener('orientationchange', function () {

            clearTimeout(inventoryChartResizeTimer);

            inventoryChartResizeTimer = setTimeout(function () {

                if (
                    typeof google !== 'undefined' &&
                    google.visualization &&
                    google.visualization.ColumnChart
                ) {

                    drawChart();
                }

            }, 300);

        });

    </script>

</head>


<body>

    <h1 class="h3 mb-4 text-gray-800">
        Inventory Management
    </h1>


    <span id="message"></span>


    <div class="card shadow mb-4 inventory-dashboard-card">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary"
                style="font-size: 1.2rem; font-weight: bolder;">

                Inventory Dashboard

            </h6>


            <div class="row">

                <div class="col">

                </div>


                <!--
                <div class="col" align="right">

                    <span data-toggle=modal data-target=#itemdetailsModal>

                        <button type="button"
                            class="btn btn-success btn-circle btn-sm">

                            <i class="fas fa-plus"></i>

                        </button>

                    </span>

                </div>
                -->

            </div>

        </div>


        <div class="card-body">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-12">

                        <!--
                        =====================================================
                        CHART SCROLL CONTAINER
                        =====================================================

                        Desktop:
                            No visible horizontal scrolling required.

                        Mobile:
                            Chart remains 700px wide.
                            User can swipe horizontally.
                        -->

                        <div class="inventory-chart-wrapper">

                            <div id="stock_div"></div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =====================================================
                 CATEGORY MODAL
                 ===================================================== -->

            <div class="modal fade"
                id="itemcatModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true">

                <div class="modal-dialog">

                    <form method="POST"
                        id="addCategoryForm"
                        enctype="multipart/form-data">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h4 class="modal-title"
                                    id="modal_title">

                                    Add Data

                                </h4>

                                <button type="button"
                                    class="close"
                                    data-dismiss="modal">

                                    &times;

                                </button>

                            </div>


                            <div class="modal-body">

                                <span id="form_message"></span>


                                <div class="form-group">

                                    <div class="row">

                                        <label class="col-md-4 text-right">

                                            Category Name

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <div class="col-md-8">

                                            <input type="text"
                                                name="itemcatname"
                                                id="itemcatname"
                                                class="form-control"
                                                required
                                                data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                data-parsley-maxlength="150"
                                                data-parsley-trigger="keyup" />

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <div class="row">

                                        <label class="col-md-4 text-right">

                                            Category Description

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <div class="col-md-8">

                                            <input type="text"
                                                name="itemcatdescription"
                                                id="itemcatdescription"
                                                class="form-control"
                                                required
                                                data-parsley-type="integer"
                                                data-parsley-minlength="10"
                                                data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup" />

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-md-8">

                                            <input type="hidden"
                                                name="itemcatcreatedby"
                                                id="itemcatcreatedby"
                                                class="form-control"
                                                required
                                                data-parsley-type="integer"
                                                data-parsley-minlength="10"
                                                data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-md-8">

                                            <input type="hidden"
                                                name="itemcatmodifiedby"
                                                id="itemcatmodifiedby"
                                                class="form-control"
                                                required
                                                data-parsley-type="integer"
                                                data-parsley-minlength="10"
                                                data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="modal-footer">

                                <input type="hidden"
                                    name="hidden_id"
                                    id="hidden_id" />

                                <input type="hidden"
                                    name="action"
                                    id="action"
                                    value="Add" />

                                <input type="submit"
                                    name="submit"
                                    id="addCategorybtn"
                                    class="btn btn-success"
                                    value="Add" />

                                <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal">

                                    Close

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            <!-- =====================================================
                 SUB CATEGORY MODAL
                 ===================================================== -->

            <div class="modal fade"
                id="itemsubcatModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true">

                <div class="modal-dialog">

                    <form method="POST"
                        id="subCategoryForm"
                        enctype="multipart/form-data">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h4 class="modal-title"
                                    id="modal_title">

                                    Add Data

                                </h4>


                                <button type="button"
                                    class="close"
                                    data-dismiss="modal">

                                    &times;

                                </button>

                            </div>


                            <div class="modal-body">

                                <span id="form_message"></span>


                                <div class="form-group">

                                    <div class="row">

                                        <label class="col-md-4 text-right">

                                            Category Name

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <div class="col-md-8">

                                            <select id="additemCategory"
                                                class="form-select"
                                                required
                                                name="itemcatid">

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <div class="row">

                                        <label class="col-md-4 text-right">

                                            SubCategory Name

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <div class="col-md-8">

                                            <input type="text"
                                                name="itemsubcatname"
                                                id="itemsubcatname"
                                                class="form-control"
                                                required
                                                data-parsley-pattern="/^[a-zA-Z\s]+$/"
                                                data-parsley-maxlength="150"
                                                data-parsley-trigger="keyup" />

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <div class="row">

                                        <label class="col-md-4 text-right">

                                            SubCategory Description

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <div class="col-md-8">

                                            <input type="text"
                                                name="itemsubcatdescription"
                                                id="itemsubcatdescription"
                                                class="form-control"
                                                required
                                                data-parsley-type="integer"
                                                data-parsley-minlength="10"
                                                data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup" />

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-md-8">

                                            <input type="hidden"
                                                name="itemsubcatcreatedby"
                                                id="itemsubcatcreatedby"
                                                class="form-control"
                                                required
                                                data-parsley-type="integer"
                                                data-parsley-minlength="10"
                                                data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />

                                        </div>

                                    </div>

                                </div>


                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-md-8">

                                            <input type="hidden"
                                                name="itemsubcatmodifiedby"
                                                id="itemsubcatmodifiedby"
                                                class="form-control"
                                                required
                                                data-parsley-type="integer"
                                                data-parsley-minlength="10"
                                                data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup"
                                                value="<?php echo $_SESSION['login_user']; ?>" />

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="modal-footer">

                                <input type="hidden"
                                    name="hidden_id"
                                    id="hidden_id" />

                                <input type="hidden"
                                    name="action"
                                    id="action"
                                    value="Add" />

                                <input type="submit"
                                    name="submit"
                                    id="addSubCategorybtn"
                                    class="btn btn-success"
                                    value="Add" />

                                <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal">

                                    Close

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <?php include('footer.php'); ?>


    <script>

        // =========================================================
        // DIMENSIONS
        // =========================================================

        var dimensionurl =
            config.developmentPath +
            "/Admin/Controller/dimensionsContoller.php";


        $.getJSON(dimensionurl, function (data) {

            $.each(data, function (index, value) {

                $('#dimensions').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );

                $('#dimensions').append(
                    '<option value="' +
                    value.dimensionId +
                    '">' +
                    value.dimensionName +
                    '</option>'
                );

            });

        });


        // =========================================================
        // ROTATION
        // =========================================================

        var rotationurl =
            config.developmentPath +
            "/Admin/Controller/rotationController.php";


        console.log(rotationurl);


        $.getJSON(rotationurl, function (data) {

            $.each(data, function (index, value) {

                $('#materialrotation').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );

                $('#materialrotation').append(
                    '<option value="' +
                    value.rotationId +
                    '">' +
                    value.sides +
                    '</option>'
                );

            });

        });


        // =========================================================
        // UNITS
        // =========================================================

        var uniturl =
            config.developmentPath +
            "/Admin/Controller/unitsContoller.php";


        $.getJSON(uniturl, function (data) {

            loadUnitFactor(data[0].unitId);


            $.each(data, function (index, value) {

                $('#unit').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );

                $('#productunit').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );

                $('#materialunit').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );


                $('#unit').append(
                    '<option value="' +
                    value.unitId +
                    '">' +
                    value.unitName +
                    '</option>'
                );


                $('#productunit').append(
                    '<option value="' +
                    value.unitId +
                    '">' +
                    value.unitName +
                    '</option>'
                );


                $('#materialunit').append(
                    '<option value="' +
                    value.unitId +
                    '">' +
                    value.unitName +
                    '</option>'
                );

            });

        });


        // =========================================================
        // UNIT FACTOR
        // =========================================================

        function loadUnitFactor(unitId) {

            $('#unitFactor').empty();
            $('#productunitFactor').empty();
            $('#materialunitFactor').empty();


            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" +
                unitId;


            $.getJSON(unitFactorurl, function (data) {

                $.each(data, function (index, value) {

                    $('#unitFactor').append(
                        '<option hidden disabled selected value>' +
                        'Blank' +
                        '</option>'
                    );

                    $('#productunitFactor').append(
                        '<option hidden disabled selected value>' +
                        'Blank' +
                        '</option>'
                    );

                    $('#materialunitFactor').append(
                        '<option hidden disabled selected value>' +
                        'Blank' +
                        '</option>'
                    );


                    $('#unitFactor').append(
                        '<option value="' +
                        value.unitFactorId +
                        '">' +
                        value.unitFactor +
                        '</option>'
                    );


                    $('#productunitFactor').append(
                        '<option value="' +
                        value.unitFactorId +
                        '">' +
                        value.unitFactor +
                        '</option>'
                    );


                    $('#materialunitFactor').append(
                        '<option value="' +
                        value.unitFactorId +
                        '">' +
                        value.unitFactor +
                        '</option>'
                    );

                });

            });

        }


        // =========================================================
        // CATEGORY
        // =========================================================

        var url =
            config.developmentPath +
            "/Admin/Controller/item_categorycontroller.php";


        let isSelectedSet = false;
        let catId = 0;


        $.getJSON(url, function (data) {

            $.each(data, function (index, value) {

                if (isSelectedSet === false) {

                    $('#itemCategory').append(
                        '<option selected value="' +
                        value.itemcatid +
                        '">' +
                        value.itemcatname +
                        '</option>'
                    );


                    $('#productitemCategory').append(
                        '<option value="' +
                        value.itemcatid +
                        '">' +
                        value.itemcatname +
                        '</option>'
                    );


                    $('#materialCategory').append(
                        '<option value="' +
                        value.itemcatid +
                        '">' +
                        value.itemcatname +
                        '</option>'
                    );


                    isSelectedSet = true;

                    setSubCategory(value.itemcatid);

                } else {

                    $('#itemCategory').append(
                        '<option hidden disabled selected value>' +
                        '-- select an option --' +
                        '</option>'
                    );


                    $('#productitemCategory').append(
                        '<option hidden disabled selected value>' +
                        '-- select an option --' +
                        '</option>'
                    );


                    $('#materialCategory').append(
                        '<option hidden disabled selected value>' +
                        '-- select an option --' +
                        '</option>'
                    );


                    $('#itemCategory').append(
                        '<option value="' +
                        value.itemcatid +
                        '">' +
                        value.itemcatname +
                        '</option>'
                    );


                    $('#productitemCategory').append(
                        '<option value="' +
                        value.itemcatid +
                        '">' +
                        value.itemcatname +
                        '</option>'
                    );


                    $('#materialCategory').append(
                        '<option value="' +
                        value.itemcatid +
                        '">' +
                        value.itemcatname +
                        '</option>'
                    );

                }

            });

        });


        // =========================================================
        // SUB CATEGORY
        // =========================================================

        function setSubCategory(catId) {

            let subcatId = 0;


            var fetchsubcaturl =
                config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
                catId;


            $.getJSON(fetchsubcaturl, function (data) {

                $('#subCategory').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );


                $('#productsubCategory').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );


                $('#materialsubCategory').append(
                    '<option hidden disabled selected value>' +
                    '-- select an option --' +
                    '</option>'
                );


                $.each(data, function (index, value) {

                    $('#subCategory').append(
                        '<option value="' +
                        value.itemsubcatid +
                        '">' +
                        value.itemsubcatname +
                        '</option>'
                    );


                    $('#productsubCategory').append(
                        '<option value="' +
                        value.itemsubcatid +
                        '">' +
                        value.itemsubcatname +
                        '</option>'
                    );


                    $('#materialsubCategory').append(
                        '<option value="' +
                        value.itemsubcatid +
                        '">' +
                        value.itemsubcatname +
                        '</option>'
                    );

                });

            });

        }


        // =========================================================
        // BRAND
        // =========================================================

        function setBrand(catId) {

            var fetchcompany =
                config.developmentPath +
                "/Admin/Controller/brandcontroller.php/?catId=" +
                catId;


            $.getJSON(fetchcompany, function (data) {

                $.each(data, function (index, value) {

                    $('#company').append(
                        '<option hidden disabled selected value>' +
                        '-- select an option --' +
                        '</option>'
                    );


                    $('#productbrand').append(
                        '<option hidden disabled selected value>' +
                        '-- select an option --' +
                        '</option>'
                    );


                    $('#materialbrand').append(
                        '<option hidden disabled selected value>' +
                        '-- select an option --' +
                        '</option>'
                    );


                    $('#company').append(
                        '<option value="' +
                        value.brandid +
                        '">' +
                        value.brandname +
                        '</option>'
                    );


                    $('#productbrand').append(
                        '<option value="' +
                        value.brandid +
                        '">' +
                        value.brandname +
                        '</option>'
                    );


                    $('#materialbrand').append(
                        '<option value="' +
                        value.brandid +
                        '">' +
                        value.brandname +
                        '</option>'
                    );

                });

            });

        }


        // =========================================================
        // MATERIAL
        // =========================================================

        function setMaterial(brandId, catId) {

            var fetchmaterial =
                config.developmentPath +
                "/Admin/Controller/materialController.php/?brandId=" +
                brandId +
                "&catId=" +
                catId;


            $.getJSON(fetchmaterial, function (data) {

                $.each(data, function (index, value) {

                    $('#productmaterial').append(
                        '<option hidden disabled selected value>' +
                        '-- select an option --' +
                        '</option>'
                    );


                    $('#productmaterial').append(
                        '<option value="' +
                        value.MaterialId +
                        '">' +
                        value.MaterialName +
                        '</option>'
                    );

                });

            });

        }


        // =========================================================
        // MATERIAL CATEGORY CHANGE
        // =========================================================

        $('#materialCategory').on('change', function () {

            $('#materialsubCategory').empty();

            $('#materialbrand').empty();

            setSubCategory(
                this.value,
                $('#materialsubCategory').val()
            );

            setBrand(
                this.value,
                $('#materialbrand').val()
            );

        });


        // =========================================================
        // ITEM CATEGORY CHANGE
        // =========================================================

        $('#itemCategory').on('change', function () {

            $('#subCategory').empty();

            $('#brand').empty();

            setSubCategory(
                this.value,
                $('#subCategory').val()
            );

            setBrand(
                this.value,
                $('#brand').val()
            );

        });


        // =========================================================
        // PRODUCT BRAND CHANGE
        // =========================================================

        $('#productbrand').on('change', function () {

            $('#productmaterial').empty();

            setMaterial(
                this.value,
                $('#productitemCategory').val()
            );

        });


        // =========================================================
        // PRODUCT CATEGORY CHANGE
        // =========================================================

        $('#productitemCategory').on('change', function () {

            $('#productsubCategory').empty();

            $('#productbrand').empty();

            setSubCategory(
                this.value,
                $('#productsubCategory').val()
            );

            setBrand(
                this.value,
                $('#productbrand').val()
            );

        });


        // =========================================================
        // PRODUCT UNIT CHANGE
        // =========================================================

        $('#productunit').on('change', function () {

            $('#productunitFactor').empty();


            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" +
                this.value;


            $.getJSON(unitFactorurl, function (data) {

                $.each(data, function (index, value) {

                    $('#productunitFactor').append(
                        '<option value="' +
                        value.unitFactorId +
                        '">' +
                        value.unitFactor +
                        '</option>'
                    );

                });

            });

        });


        // =========================================================
        // MATERIAL UNIT CHANGE
        // =========================================================

        $('#materialunit').on('change', function () {

            $('#materialunitFactor').empty();


            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" +
                this.value;


            $.getJSON(unitFactorurl, function (data) {

                $.each(data, function (index, value) {

                    $('#materialunitFactor').append(
                        '<option value="' +
                        value.unitFactorId +
                        '">' +
                        value.unitFactor +
                        '</option>'
                    );

                });

            });

        });


        // =========================================================
        // UNIT CHANGE
        // =========================================================

        $('#unit').on('change', function () {

            $('#unitFactor').empty();

            $('#productunitFactor').empty();


            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" +
                this.value;


            $.getJSON(unitFactorurl, function (data) {

                $.each(data, function (index, value) {

                    $('#unitFactor').append(
                        '<option value="' +
                        value.unitFactorId +
                        '">' +
                        value.unitFactor +
                        '</option>'
                    );


                    $('#productunitFactor').append(
                        '<option value="' +
                        value.unitFactorId +
                        '">' +
                        value.unitFactor +
                        '</option>'
                    );

                });

            });

        });


        // =========================================================
        // ADD CATEGORY
        // =========================================================

        $('#addCategoryForm').submit(function (event) {

            event.preventDefault();


            var formData = new FormData(this);


            $.ajax({

                type: "POST",

                url:
                    config.developmentPath +
                    "/Admin/Controller/item_categorycontroller.php/",

                data: formData,

                processData: false,

                contentType: false

            }).done(function (data) {

                console.log(data);

            });


            reloadCategoryList();

            $('#itemcatModal').hide();

        });


        // =========================================================
        // ADD SUB CATEGORY
        // =========================================================

        $('#subCategoryForm').submit(function (event) {

            event.preventDefault();


            var formData = new FormData(this);


            $.ajax({

                type: "POST",

                url:
                    config.developmentPath +
                    "/Admin/Controller/item_subcategorycontroller.php/",

                data: formData,

                processData: false,

                contentType: false

            }).done(function (data) {

                console.log(data);

            });


            reloadSubCategoryList();

            $('#itemsubcatModal').hide();

        });

    </script>

</body>