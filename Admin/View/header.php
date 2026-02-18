<?php
include('session.php');
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BMS | Business Management System </title>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css" />

    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap-select/bootstrap-select.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --bg-main: #F1F5F9;
        --sidebar-gradient: linear-gradient(180deg,rgb(140, 14, 14) 0%, #1E293B 100%);
        --accent: #3B82F6;
        --accent-light: #60A5FA;
        --card-bg: #ffffff;
        --shadow-soft: 0 8px 25px rgba(0, 0, 0, 0.06);
        --shadow-strong: 0 20px 50px rgba(0, 0, 0, 0.08);
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg-main);
    }

    /* ================= SIDEBAR ================= */

    .sidebar {
        background: var(--sidebar-gradient) !important;
        box-shadow: 8px 0 40px rgba(0, 0, 0, 0.2);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sidebar-brand {
        font-weight: 800;
        font-size: 20px;
        letter-spacing: .5px;
        color: #fff !important;
    }

    .sidebar .nav-item {
        margin: 6px 12px;
    }

    .sidebar .nav-link {
        color: #cbd5e1 !important;
        padding: 14px 18px;
        border-radius: 14px;
        transition: all .3s ease;
        position: relative;
    }

    .sidebar .nav-link i {
        margin-right: 12px;
        font-size: 15px;
    }

    /* Hover Glow */
    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #fff !important;
        transform: translateX(6px);
    }

    /* Active State Glow */
    .sidebar .nav-item.active .nav-link {
        background: linear-gradient(90deg, var(--accent), var(--accent-light));
        color: #fff !important;
        box-shadow: 0 5px 20px rgba(59, 130, 246, .4);
    }

    /* ================= TOPBAR ================= */

    .topbar {
        background: rgba(255, 255, 255, 0.65) !important;
        backdrop-filter: blur(18px);
        border-radius: 20px;
        margin: 20px;
        padding: 12px 20px;
        box-shadow: var(--shadow-soft);
    }

    /* Username */
    .sidebar-brand-text {
        font-weight: 600;
        font-size: 14px;
    }

    /* Dropdown */
    .dropdown-menu {
        border: none;
        border-radius: 20px;
        padding: 10px;
        box-shadow: var(--shadow-strong);
    }

    .dropdown-item {
        border-radius: 12px;
        padding: 10px 15px;
        transition: .3s;
    }

    .dropdown-item:hover {
        background: var(--accent);
        color: white;
    }

    /* ================= CONTENT AREA ================= */

    #content-wrapper {
        background: var(--bg-main);
    }

    .container-fluid {
        padding-left: 30px;
        padding-right: 30px;
    }

    /* ================= CARDS GLOBAL ================= */

    .card {
        border: none;
        border-radius: 20px;
        background: var(--card-bg);
        box-shadow: var(--shadow-soft);
        transition: .3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-strong);
    }

    /* ================= BUTTON IMPROVEMENT ================= */

    .btn {
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 500;
        transition: .3s;
    }

    .btn-primary {
        background: linear-gradient(90deg, var(--accent), var(--accent-light));
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, .4);
    }

    /* ================= SCROLLBAR ================= */

    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--accent);
        border-radius: 10px;
    }

    /* ================= SMOOTH TRANSITIONS ================= */

    * {
        transition: all .2s ease-in-out;
    }

    /* ===== FIX DROPDOWN BEHIND ISSUE ===== */

    .topbar {
        position: relative;
        z-index: 1050;
    }

    .dropdown-menu {
        z-index: 9999 !important;
    }

    #content-wrapper {
        position: relative;
        z-index: 1;
    }

    .container-fluid {
        position: relative;
        z-index: 1;
    }

    /* Sidebar Collapsed Mode */
    .sidebar.toggled {
        width: 80px !important;
    }

    .sidebar.toggled .nav-link span {
        display: none;
    }

    .sidebar.toggled .sidebar-brand span {
        display: none;
    }

    .sidebar.toggled .nav-link i {
        margin-right: 0;
        font-size: 18px;
    }

    .sidebar {
        transition: width .3s ease;
    }
</style>


<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <i class="fas fa-layer-group mr-2"></i>
                <span>Ace Decors</span>
            </a>



            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="maindashboard.php">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enquiry.php">
                    <i class="fas fa-question-circle"></i>
                    <span>Enquiries</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="channelpartnerDashboard.php">
                    <i class="fas fa-hands-helping"></i>
                    <span>Channel Partners</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inventorydashboard.php">
                    <i class="fas fa-percent"></i>
                    <span>Inventory</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="employeeDashboard.php">
                    <i class="fas fa-user-tie"></i>
                    <span>Employees</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="customer.php">
                    <i class="fas fa-user-astronaut"></i>
                    <span>Customers</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="projectView.php">
                    <i class="fab fa-product-hunt"></i>
                    <span>Projects</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="POview.php">
                    <i class="fas fa-users-cog"></i>
                    <span>Purchase Orders</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="paymentdashboard.php">
                    <i class="far fa-edit"></i>
                    <span>Payments</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="sidebar-brand-text mx-3 font-weight-600 text-dark">
                        <i class="fas fa-user-circle text-primary mr-2"></i>
                        <?php echo $_SESSION['login_user']; ?>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>



                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="user_profile_name"></span>
                                <i class="fas fa-chevron-circle-down 7x"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                <a class="dropdown-item" href="setting.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <script src="../js/sb-admin-2.min.js"></script>
                    <script>
                        $(document).ready(function () {

                            $("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {
                                e.preventDefault();

                                $("body").toggleClass("sidebar-toggled");
                                $(".sidebar").toggleClass("toggled");

                                if ($(".sidebar").hasClass("toggled")) {
                                    $(".sidebar .collapse").collapse("hide");
                                }
                            });

                        });
                    </script>