<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Business Management System </title>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css" />

    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap-select/bootstrap-select.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ================= GLOBAL ================= */

        :root {
            --bg-main: #F4F7FC;
            --sidebar-dark: rgb(0, 0, 0);
            --sidebar-dark-2: rgb(0, 0, 0);
            --accent-blue: #2563EB;
            --accent-cyan: #06B6D4;
            --accent-purple: #7C3AED;
            --text-light: #d1d5db;
            --shadow-soft: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-strong: 0 25px 60px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-main);
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 260px !important;
            background: linear-gradient(180deg, var(--sidebar-dark), var(--sidebar-dark-2));
            position: relative;
            overflow: hidden;
            box-shadow: 15px 0 40px rgba(0, 0, 0, 0.45);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Animated texture */
        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            background: transparent url("https://www.transparenttextures.com/patterns/inspiration-geometry.png") repeat;
            animation: movePattern 80s linear infinite;
            z-index: 0;
        }

        @keyframes movePattern {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 1200px 1200px;
            }
        }

        /* Glow overlay */
        .sidebar::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.25), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(124, 58, 237, 0.2), transparent 50%);
            z-index: 0;
        }

        .sidebar * {
            position: relative;
            z-index: 1;
        }

        /* Brand */
        .sidebar-brand {
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 0.5px;
            color: #f3f4f6 !important;
            padding: 24px 0;
        }

        /* Nav */
        .sidebar .nav-item {
            margin: 6px 16px;
        }

        .sidebar .nav-link {
            color: var(--text-light) !important;
            padding: 14px 20px;
            border-radius: 14px;
            transition: all .3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            margin-right: 14px;
            font-size: 16px;
            transition: .3s ease;
        }

        /* Hover */
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(6px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
            color: #ffffff !important;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.15);
            color: var(--accent-cyan);
        }

        /* Active */
        .sidebar .nav-item.active .nav-link {
            background: linear-gradient(90deg, var(--accent-blue), var(--accent-purple));
            color: #fff !important;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.5);
        }

        /* Collapse support */
        .sidebar.toggled {
            width: 95px !important;
        }

        .sidebar.toggled .nav-link span {
            display: none;
        }

        .sidebar.toggled .nav-link i {
            margin-right: 0;
            font-size: 20px;
        }

        /* ================= TOPBAR ================= */

        .topbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(25px);
            border-radius: 18px;
            margin: 20px;
            padding: 14px 24px;
            box-shadow: var(--shadow-soft);
        }

        .sidebar-brand-text {
            font-weight: 500;
            font-size: 14px;
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            border-radius: 16px;
            padding: 10px;
            box-shadow: var(--shadow-strong);
        }

        .dropdown-item {
            border-radius: 12px;
            padding: 10px 15px;
            transition: .3s;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: var(--accent-blue);
            color: white;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-blue);
            border-radius: 10px;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                Ace Decors
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->


            <li class="nav-item">
                <a class="nav-link" href="employeeDashboard.php?action=list">
                    <i class="fas fa-solid fa-store stat-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="employee.php?action=list">
                    <i class="fas fa-user-tie"></i>
                    <span>Employee</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="attendance.php?action=list">
                    <i class="fas fa-calendar-check"></i>
                    <span>Attendance</span>
                </a>
            </li>

            <!-- <li class="nav-item">
            <a class="nav-link" href="monthlyReport.php?action=list">
                <i class="fas fa-atlas"></i>
                <span>Monthly Reports</span>
            </a>
        </li> -->
            <li class="nav-item">
                <a class="nav-link" href="attendanceReport.php?action=list">
                    <i class="fas fa-atlas"></i>
                    <span>Attendance Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settings.php?action=list">
                    <i class="fas fa-bahai"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="expense.php?action=list">
                    <i class="fas fa-calendar-check"></i>
                    <span>Transaction</span>
                </a>
            </li>

            <br>
            <hr class="sidebar-divider">


            <li class="nav-item">
                <a class="nav-link" href="maindashboard.php">
                    <i class="fas fa-home"></i>
                    <span>Home</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="maindashboard.php">
                    <i class="fas fa-home"></i>
                    <span>Home</span></a>
            </li> -->


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
                    <div class="sidebar-brand-text mx-3"><i class="fas fa-user"></i>
                        <?php echo $_SESSION['login_user']; ?></div>
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
                    <!-- Bootstrap core JavaScript-->
                    <script src="../vendor/jquery/jquery.min.js"></script>
                    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                    <!-- Core plugin JavaScript-->
                    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

                    <!-- Custom scripts for all pages-->
                    <script src="../js/sb-admin-2.min.js"></script>
                    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
                    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>