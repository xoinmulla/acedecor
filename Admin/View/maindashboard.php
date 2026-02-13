<?php
include "header.php";


include "../DB Operations/dashboardOps.php";
$customer = DBDashboard::customerenqpercentage();
$projectstatus = DBDashboard::projectstatus();
$EnqAndCustomer = DBDashboard::EnqandCustomer();
$totalenquiries = DBDashboard::Totalenquiries();
$totalcustomer = DBDashboard::Totalcustomers();
$ongoingprojects = DBDashboard::OngoingProjects();
$completedprojects = DBDashboard::CompletedProjects();
$pendingprojects = DBDashboard::PendingProjects();
$mainprojects = DBDashboard::MainProjects();
?>

<head>
    <style>
        /* ===== Dashboard Theme ===== */
        :root {
            --primary: #4f6bed;
            --success: #2ecc71;
            --warning: #f39c12;
            --info: #3498db;
            --danger: #e74c3c;
            --dark: #2c3e50;
        }

        /* Card Wrapper */
        .dashboard-card {
            border-radius: 22px;
            padding: 26px;
            color: #fff;
            position: relative;
            overflow: hidden;
            height: 190px;
            transition: all 0.4s ease;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .dashboard-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.25), transparent 60%);
            opacity: 0;
            transition: 0.4s;
        }

        .dashboard-card:hover::after {
            opacity: 1;
        }

        .dashboard-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.35);
        }

        .dashboard-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .dashboard-title {
            font-size: 15px;
            font-weight: 600;
            opacity: 0.95;
        }

        .dashboard-value {
            font-size: 46px;
            font-weight: 800;
        }


        /* Gradients */
        .bg-enquiry {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .bg-customer {
            background: linear-gradient(135deg, #43cea2, #185a9d);
        }

        .bg-completed {
            background: linear-gradient(135deg, #56ab2f, #a8e063);
        }

        .bg-main {
            background: linear-gradient(135deg, #ff9966, #ff5e62);
        }

        .bg-ongoing {
            background: linear-gradient(135deg, #36d1dc, #5b86e5);
        }

        .bg-pending {
            background: linear-gradient(135deg, #f7971e, #ffd200);
        }

        /* Remove default card padding */
        .card-body {
            padding: 0;
        }

        /* Make cards clickable */
        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card-link:hover {
            color: inherit;
            text-decoration: none;
        }

        /* ===== Dashboard Horizontal Spacing ===== */
        .dashboard-container {
            padding-left: 24px;
            padding-right: 24px;
        }

        /* Tablet */
        @media (max-width: 992px) {
            .dashboard-container {
                padding-left: 16px;
                padding-right: 16px;
            }
        }

        /* Mobile */
        @media (max-width: 576px) {
            .dashboard-container {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

        .dashboard-container {
            max-width: 1400px;
            margin: auto;
            padding-left: 24px;
            padding-right: 24px;
        }

        /* ===== Graph Analytics Theme ===== */
        .graph-card {
            background: linear-gradient(145deg, #ffffff, #f1f4f9);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            padding: 28px;
            transition: all 0.4s ease;
        }

        .graph-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 60px rgba(0, 0, 0, 0.2);
        }

        .graph-title {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 20px;
            color: #3b4a6b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .graph-subtitle {
            font-size: 13px;
            color: #6c757d;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .graph-container {
            width: 100%;
            min-height: 360px;
        }

        @media (max-width: 768px) {
            .graph-container {
                min-height: 300px;
            }
        }
    </style>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        google.charts.load('current', { packages: ['corechart'] });

        function drawAllCharts() {
            drawChart();
            drawCustomerChart();
            drawProjectStatusChart();
        }

        /* ---------- CHART 1 ---------- */
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['MONTH', 'Enquiries', 'Customer', 'Projects'],
                <?php
                mysqli_data_seek($EnqAndCustomer, 0);
                while ($row = mysqli_fetch_array($EnqAndCustomer)) {
                    echo "['{$row['MONTH']}', {$row['Enquiries']}, {$row['Customer']}, {$row['Projects']}],";
                }
                ?>
            ]);

            var options = {
                height: 420,
                animation: {
                    startup: true,
                    duration: 1200,
                    easing: 'out'
                },
                colors: ['#5b86e5', '#36d1dc', '#a8e063'],
                bar: { groupWidth: '55%' },
                legend: { position: 'top', textStyle: { fontSize: 12 } },
                hAxis: { textStyle: { color: '#6c757d' } },
                vAxis: { minValue: 0, gridlines: { color: '#e9ecef' } },
                backgroundColor: 'transparent'
            };

            var chart = new google.visualization.ColumnChart(
                document.getElementById('enquiries_div')
            );
            chart.draw(data, options);
        }


        /* ---------- CHART 2 ---------- */
        function drawCustomerChart() {
            var data = google.visualization.arrayToDataTable([
                ['Entity', 'Count'],
                <?php
                mysqli_data_seek($customer, 0);
                $row = mysqli_fetch_array($customer);
                echo "['Enquiries', {$row['Enquiries']}],";
                echo "['Customers', {$row['Customer']}]";
                ?>
            ]);

            var options = {
                pieHole: 0.55,
                height: 340,
                animation: {
                    startup: true,
                    duration: 1000,
                    easing: 'out'
                },
                legend: { position: 'bottom', textStyle: { fontSize: 12 } },
                colors: ['#36d1dc', '#5b86e5'],
                pieSliceTextStyle: { color: '#fff', fontSize: 13 },
                backgroundColor: 'transparent'
            };

            var chart = new google.visualization.PieChart(
                document.getElementById('customer_div')
            );
            chart.draw(data, options);
        }


        /* ---------- CHART 3 ---------- */
        function drawProjectStatusChart() {
            var data = google.visualization.arrayToDataTable([
                ['Status', 'Count'],
                <?php
                mysqli_data_seek($projectstatus, 0);
                $row = mysqli_fetch_array($projectstatus);
                echo "['Ongoing', {$row['OngoingProjects']}],";
                echo "['Completed', {$row['CompletedProjects']}]";
                ?>
            ]);

            var options = {
                title: 'Project Status',
                pieHole: 0.45,
                height: 350
            };

            var chart = new google.visualization.PieChart(
                document.getElementById('projectstatus_div')
            );
            chart.draw(data, options);
        }

        /* ---------- TAB EVENT ---------- */
        $(document).ready(function () {

            $('a[href="#graphTab"]').on('shown.bs.tab', function () {
                google.charts.setOnLoadCallback(drawAllCharts);
            });

        });
    </script>


</head>

<body>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 text-primary" style="font-size: 1.5rem; font-weight: bolder;">DASHBOARD</h6>
        </div>
        <ul class="nav nav-pills mb-4 p-4" id="dashboardTabs">
            <li class="nav-item">
                <a class="nav-link active px-4 fw-bold" data-toggle="pill" href="#dashboardTab">
                    <i class="fas fa-layer-group me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-4 fw-bold" data-toggle="pill" href="#graphTab">
                    <i class="fas fa-chart-line me-2"></i>Graphs
                </a>
            </li>
        </ul>
        <div class="tab-content">

            <!-- DASHBOARD TAB -->
            <div class="tab-pane fade show active" id="dashboardTab">

                <div class="row mb-3 p-4">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="dashboard-card bg-enquiry">
                            <div class="dashboard-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="dashboard-title">Total Enquiries</div>
                            <div class="dashboard-value">
                                <?php echo $totalenquiries['total']; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="dashboard-card bg-customer">
                            <div class="dashboard-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="dashboard-title">Total Customers</div>
                            <div class="dashboard-value">
                                <?php echo $totalcustomer['total']; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="dashboard-card bg-main">
                            <div class="dashboard-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div class="dashboard-title">Ongoing Projects</div>
                            <div class="dashboard-value">
                                <?php echo $mainprojects['total']; ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-3 p-4">



                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <a href="ongoingprojects.php" class="card-link">
                            <div class="dashboard-card bg-ongoing">
                                <div class="dashboard-icon">
                                    <i class="fas fa-pencil-ruler"></i>
                                </div>
                                <div class="dashboard-title">Ongoing Sub Projects</div>
                                <div class="dashboard-value">
                                    <?php echo $ongoingprojects['total']; ?>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <a href="pendingprojects.php" class="card-link">
                            <div class="dashboard-card bg-pending">
                                <div class="dashboard-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="dashboard-title">Pending Sub Projects</div>
                                <div class="dashboard-value">
                                    <?php echo $pendingprojects['total']; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="dashboard-card bg-completed">
                            <div class="dashboard-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="dashboard-title">Completed Projects</div>
                            <div class="dashboard-value">
                                <?php echo $completedprojects['total']; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- GRAPH TAB -->
            <!-- GRAPH TAB -->
            <div class="tab-pane fade" id="graphTab">

                <div class="row justify-content-center mb-5">
                    <div class="col-lg-11">
                        <div class="graph-card text-center">
                            <div class="graph-title text-primary">
                                <i class="fas fa-chart-column"></i>
                                Business Growth Overview
                            </div>
                            <div class="graph-subtitle">
                                Monthly Enquiries, Customers & Projects
                            </div>
                            <div id="enquiries_div" class="graph-container"></div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-5 mb-4">
                        <div class="graph-card text-center">
                            <div class="graph-title text-success">
                                <i class="fas fa-user-check"></i>
                                Conversion Ratio
                            </div>
                            <div class="graph-subtitle">
                                Enquiries → Customers
                            </div>
                            <div id="customer_div" class="graph-container"></div>
                        </div>
                    </div>

                    <div class="col-lg-5 mb-4">
                        <div class="graph-card text-center">
                            <div class="graph-title text-info">
                                <i class="fas fa-tasks"></i>
                                Project Status
                            </div>
                            <div class="graph-subtitle">
                                Ongoing vs Completed
                            </div>
                            <div id="projectstatus_div" class="graph-container"></div>
                        </div>
                    </div>
                </div>

            </div>


        </div>




    </div>
    </div>
</body>

</html>