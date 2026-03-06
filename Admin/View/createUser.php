<?php
include('header.php');
if ($_SESSION['User_type'] !== 'Admin') {
    header("Location: noaccess.php");
    exit;
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header & Navigation -->
            <div class="mb-4">
                <a href="userManagement.php" class="text-decoration-none small text-muted">
                    <i class="fas fa-arrow-left mr-1"></i> Back to User Directory
                </a>
                <h2 class="h3 mt-2 font-weight-bold text-gray-800">Create New User</h2>
                <p class="text-muted">Register a new team member and assign their system role.</p>
            </div>

            <!-- Main Form Card -->
            <div class="card shadow border-0 rounded-lg overflow-hidden">
                <div class="bg-primary py-1"></div> <!-- Accent line -->
                <div class="card-body p-5">
                    <form method="post" action="../Controller/userController.php" id="createUserForm">
                        <input type="hidden" name="action" value="create">

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-1">Full
                                        Name</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-user text-primary"></i></span>
                                        </div>
                                        <input type="text" name="user_name" class="form-control border-left-0 pl-0"
                                            placeholder="John Doe" required>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-1">Email
                                        Address</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-envelope text-primary"></i></span>
                                        </div>
                                        <input type="email" name="user_email" class="form-control border-left-0 pl-0"
                                            placeholder="name@gmail.com" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-1">Contact
                                        Number</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-phone text-primary"></i></span>
                                        </div>
                                        <input type="text" name="user_contact" class="form-control border-left-0 pl-0"
                                            placeholder="+91 00000-00000">
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-1">Account
                                        Role</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-shield-alt text-primary"></i></span>
                                        </div>
                                        <select name="user_type"
                                            class="form-control border-left-0 pl-0 custom-select-style">
                                            <option value="Normal"> User </option>
                                            <option value="Admin"> Admin </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Full Width Column -->
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="text-xs font-weight-bold text-uppercase text-muted mb-1">Security
                                        Password</label>
                                    <div class="input-group input-group-alternative" id="show_hide_password">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-key text-primary"></i></span>
                                        </div>
                                        <input type="password" name="user_password"
                                            class="form-control border-left-0 border-right-0 pl-0"
                                            placeholder="········" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-left-0"><a href=""><i
                                                        class="fa fa-eye-slash text-muted"
                                                        aria-hidden="true"></i></a></span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Ensure password is at least 8 characters with
                                        numbers.</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="sendEmail" checked>
                                <label class="custom-control-label small text-muted" for="sendEmail">Send welcome email
                                    with credentials</label>
                            </div>
                            <button type="submit"
                                class="btn btn-primary px-5 py-2 shadow-sm rounded-pill font-weight-bold">
                                <i class="fas fa-user-check mr-2"></i> Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center mt-4 text-muted small">
                All account creations are logged for security auditing purposes.
            </p>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fc;
    }

    /* Input Styling */
    .form-control {
        border: 1px solid #e3e6f0;
        padding: 0.6rem 0.75rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #4e73df;
        background-color: #fff;
    }

    .input-group-text {
        border: 1px solid #e3e6f0;
        color: #d1d3e2;
    }

    .text-xs {
        font-size: 0.7rem;
    }

    /* Custom Select */
    .custom-select-style {
        appearance: none;
        background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23d1d3e2' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right .75rem center/8px 10px;
    }

    /* Form Animations */
    .card {
        transition: all 0.3s ease;
        border-radius: 15px !important;
    }

    .btn-primary {
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 14px rgba(78, 115, 223, 0.2) !important;
    }
</style>

<script>
    $(document).ready(function () {
        // Password visibility toggle
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
    });
</script>


<?php include('footer.php'); ?>