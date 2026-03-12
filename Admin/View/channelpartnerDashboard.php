<?php
include('session.php');
include('channelpartnerheader.php');


include "../DB Operations/dashboardOps.php";
$customer = DBDashboard::customerenqpercentage();
$projectstatus = DBDashboard::projectstatus();
$EnqAndCustomer = DBDashboard::EnqandCustomer();
$totalbrands = DBDashboard::totalbrands();
$totalsuppliers = DBDashboard::totalsupplierscount();
// $inwardedbrand=DBDashboard::totalbrandinwarded();
// $completedprojects=DBDashboard::CompletedProjects();
// $pendingprojects=DBDashboard::PendingProjects();
?>

<head>
    <style>
        /* ===== Dashboard Theme ===== */
        :root {
            --primary: #4f6bed;
            --secondary: #00c6ff;
            --success: #2ecc71;
            --warning: #f39c12;
            --info: #3498db;
            --dark: #2c3e50;
        }

        /* Page background */
        body {
            background: linear-gradient(135deg, #eef2f7, #f8fbff);
            font-family: 'Poppins', sans-serif;
        }

        /* Card Grid */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            padding: 25px;
        }

        /* Ultimate Card */
        .dashboard-card {
            position: relative;
            height: 210px;
            border-radius: 22px;
            padding: 25px;
            color: #fff;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.15);
            transition: all 0.4s ease;
        }

        /* Hover Effect */
        .dashboard-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.25);
        }

        /* Glass Overlay */
        .dashboard-card::after {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.08);
            transform: rotate(25deg);
        }

        /* Icon */
        .dashboard-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        /* Title */
        .dashboard-title {
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.85;
        }

        /* Value */
        .dashboard-value {
            font-size: 42px;
            font-weight: 800;
            margin-top: 8px;
        }

        /* Different Card Colors */
        .card-brands {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .card-suppliers {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }

        .card-inward {
            background: linear-gradient(135deg, #f7971e, #ffd200);
        }

        /* =========================
   RESPONSIVE FIXES
========================= */

        /* Large Screens (Desktop) */
        @media (min-width: 1200px) {
            .dashboard-cards {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Tablets */
        @media (max-width: 992px) {
            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
                padding: 20px;
                gap: 20px;
            }

            .dashboard-card {
                height: 170px;
                padding: 22px;
            }

            .dashboard-value {
                font-size: 36px;
            }
        }

        /* Mobile */
        @media (max-width: 576px) {

            /* Header spacing */
            .card-header h6 {
                font-size: 1.2rem !important;
                text-align: center;
            }

            /* Card grid */
            .dashboard-cards {
                grid-template-columns: 1fr;
                padding: 15px;
                gap: 18px;
            }

            /* Card size */
            .dashboard-card {
                height: auto;
                padding: 20px;
                border-radius: 18px;
            }

            /* Icon */
            .dashboard-icon {
                width: 50px;
                height: 50px;
                font-size: 22px;
                margin-bottom: 10px;
            }

            /* Title */
            .dashboard-title {
                font-size: 13px;
            }

            /* Value */
            .dashboard-value {
                font-size: 32px;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 360px) {
            .dashboard-value {
                font-size: 28px;
            }

            .dashboard-title {
                font-size: 12px;
            }
        }
    </style>


    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
            ['MONTH', 'Enquiries', 'Customer', 'Projects'],
            <?php
            while ($row = mysqli_fetch_array($EnqAndCustomer)) {
                echo "['" . $row['MONTH'] . "'," . intval($row['Enquiries']) . "," . intval($row['Customer']) . "," . intval($row['Projects']) . "],";
            }
            ?>
        ]);

        // Set chart options
        var options = {
            'title': 'Enqueries,Customers & Projects',

            'width': 800,
            'height': 400
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('enquiries_div'));
        chart.draw(data, options);
    }

    function drawCustomerChart() {

        // Create the data table.
        var data = new google.visualization.arrayToDataTable([
            ['Entity', 'Count'],
            <?php
            $row = mysqli_fetch_array($customer);
            echo "['Enquiries'," . intval($row['Enquiries']) . "],";
            echo "['Customer'," . intval($row['Customer']) . "]";

            ?>

        ]);

        // Set chart options
        var options = {
            'title': 'Enqueries Converted To Customers',
            'pieHole': 0.4,
            'width': 500,
            'height': 400
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('customer_div'));
        chart.draw(data, options);
    }

    function drawProjectStatusChart() {

        // Create the data table.
        var data = new google.visualization.arrayToDataTable([
            ['Entity', 'Count'],
            <?php
            $row = mysqli_fetch_array($projectstatus);
            echo "['Ongoing Projects'," . intval($row['OngoingProjects']) . "],";
            echo "['Completed Projects'," . intval($row['CompletedProjects']) . "]";

            ?>

        ]);

        // Set chart options
        var options = {
            'title': 'Project Ongoing V/S Completed',
            'pieHole': 0.4,
            'width': 500,
            'height': 400
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('projectstatus_div'));
        chart.draw(data, options);
    } -->
    </script>
</head>

<body>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 text-primary" style="font-size: 1.5rem; font-weight: bolder;">Channel Partners Dashboard</h6>
        </div></br>
        <div class="dashboard-cards">

            <!-- Total Brands -->
            <div class="dashboard-card card-brands">
                <div class="dashboard-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="dashboard-title">Total Brands</div>
                <div class="dashboard-value">
                    <?php echo $totalbrands['total']; ?>
                </div>
            </div>

            <!-- Total Suppliers -->
            <div class="dashboard-card card-suppliers">
                <div class="dashboard-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="dashboard-title">Total Suppliers</div>
                <div class="dashboard-value">
                    <?php echo $totalsuppliers['total']; ?>
                </div>
            </div>

            <!-- Inwarded Brand -->
            <div class="dashboard-card card-inward">
                <div class="dashboard-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="dashboard-title">Inwarded Brands</div>
                <div class="dashboard-value">
                    0
                    <!-- <?php // echo $inwardedbrand['total']; ?> -->
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div id="enquiries_div"></div>
            </div>
            <div class="col-lg-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div id="customer_div"></div>
            </div>
            <div class="col-md-5">
                <div id="projectstatus_div"></div>
            </div>
            <div class="col-md-1"></div>
        </div>

    </div>
    </div>
</body>

</html>