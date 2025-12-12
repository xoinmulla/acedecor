
<?php
include('session.php');
include('channelpartnerheader.php');


        include "../DB Operations/dashboardOps.php";
        $customer = DBDashboard::customerenqpercentage();
        $projectstatus=DBDashboard::projectstatus();       
        $EnqAndCustomer = DBDashboard::EnqandCustomer();
        $totalbrands=DBDashboard::totalbrands();
        $totalsuppliers=DBDashboard::totalsupplierscount();
        // $inwardedbrand=DBDashboard::totalbrandinwarded();
        // $completedprojects=DBDashboard::CompletedProjects();
        // $pendingprojects=DBDashboard::PendingProjects();
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
            echo "['" . $row['MONTH'] . "'," .intval($row['Enquiries'])."," .intval($row['Customer']). "," .intval($row['Projects']). "],";
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
        $row = mysqli_fetch_array($customer) ;
            echo "['Enquiries'," .intval($row['Enquiries']). "],";
            echo "['Customer'," .intval($row['Customer']). "]";

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
$row = mysqli_fetch_array($projectstatus) ;
    echo "['Ongoing Projects'," .intval($row['OngoingProjects']). "],";
    echo "['Completed Projects'," .intval($row['CompletedProjects']). "]";

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
            <h6 class="m-0 font-weight-bold text-primary">CHANNEL PARTNER DASHBOARD</h6>
        </div></br>
        <div class="row">
            <div class="col-sm-4" style="height: 5rem;">
                <div class="card mb-1" style="max-width: 327px;height: 6 rem; ">
                    <div class="card-body text-center " style="height: 6 rem;">
                        <i class="card-fas fas fa-question-circle fa-2x"></i></br></br>
                        <h6 class="text-center font-weight-bold card-title" style="color:#B97A57;">Total Brands
                        </h6>
                        <h3 class="text-center font-weight-bold" style=font-size:50px;color:#6699cc>
                            <?php
                                 echo $totalbrands['total'];
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card mb-1" style="max-width: 327px;height: 6 rem; ">
                    <div class="card-body text-center" style="height: 6 rem;">
                        <i class="card-fas fas fa-users fa-2x"></i></br></br>
                        <h6 class=" text-center font-weight-bold card-title" style="color:#B97A57;">Total Suppliers
                        </h6>
                        <h3 class=" text-center font-weight-bold" style=font-size:50px;color:#6699cc>
                        <?php
                                 echo $totalsuppliers['total'];
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card mb-1" style="max-width: 327px;height: 6 rem; ">
                    <div class="card-body text-center" style="height: 6 rem;">
                        <i class="card-fas fas fa-check-circle fa-2x"></i></br></br>
                        <h6 class=" text-center font-weight-bold card-title" style="color:#B97A57;">Inwarded Brand
                        </h6>
                        <h3 class=" text-center font-weight-bold" style=font-size:50px;color:#6699cc>
                        <!-- <?php
                                 echo $inwardedbrand['total'];
                            ?>  -->
                        </h3>

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
<?php include('footer.php'); ?>
</html>