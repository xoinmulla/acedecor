<?php
include('userNavbar.php');
require_once("../DB Operations/userOps.php");

if ($_SESSION['User_type'] !== 'Admin') {
    header("Location: noaccess.php");
    exit;
}

$userList = DBuser::getAllUsers();
?>

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">User Management</h1>
            <p class="text-muted small mb-0">Monitor system access and update user privileges.</p>
        </div>
        <a href="createUser.php" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="fas fa-user-plus fa-sm mr-2"></i> Create New User
        </a>
    </div>

    <!-- Stats Overview (Optional but looks great) -->
    <!-- <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 border-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($userList); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Main Content Card -->
    <div class="card shadow border-0 mb-4 rounded-lg">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">System Directory</h6>
            <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" id="userTableSearch" class="form-control bg-light border-0 small"
                    placeholder="Search users..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success">User deleted successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'selfdelete'): ?>
            <div class="alert alert-danger">You cannot delete your own account.</div>
        <?php endif; ?>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle" id="userTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted">User</th>
                            <th class="border-0 py-3 text-xs text-uppercase text-muted">Account Type</th>
                            <th class="border-0 py-3 text-xs text-uppercase text-muted">Status</th>
                            <th class="border-0 py-3 text-xs text-uppercase text-muted text-right px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userList as $user):
                            $name = $user->get_username();
                            $email = $user->get_useremail();
                            $status = $user->get_userstatus();
                            $type = $user->get_usertype();
                            $initial = strtoupper(substr($name, 0, 1));
                            ?>
                            <tr class="user-row">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle mr-3">
                                            <span><?= $initial ?></span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-gray-800"><?= $name ?></div>
                                            <div class="small text-muted"><?= $email ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span
                                        class="badge <?= $type === 'Admin' ? 'badge-soft-danger' : 'badge-soft-info' ?> px-3 py-2">
                                        <?= $type ?>
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <?php if (strtolower($status) == 'active'): ?>
                                        <span class="status-indicator status-online"></span> <small class="text-gray-600">Active
                                            Account</small>
                                    <?php else: ?>
                                        <span class="status-indicator status-offline"></span> <small
                                            class="text-gray-600">Inactive</small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right px-4 align-middle">
                                    <?php if ($type !== 'Admin'): ?>
                                        <div class="btn-group">
                                            <!-- Edit Button -->
                                            <a href="editUser.php?id=<?= $user->get_id(); ?>"
                                                class="btn btn-light btn-sm border rounded-pill px-3 shadow-sm hover-primary">
                                                <i class="fas fa-edit mr-1 text-primary"></i> Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <a href="deleteUser.php?id=<?= $user->get_id(); ?>"
                                                class="btn btn-light btn-sm border rounded-pill px-3 shadow-sm ml-2 text-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge badge-success rounded-pill px-3 py-2">
                                            <i class="fas fa-shield-alt mr-1"></i> Root Access
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Avatars */
    .avatar-circle {
        width: 42px;
        height: 42px;
        background-color: #4e73df;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Soft Badges */
    .badge-soft-danger {
        background-color: #ffe8e8;
        color: #e74a3b;
    }

    .badge-soft-info {
        background-color: #e0f2ff;
        color: #36b9cc;
    }

    /* Status Pulse Indicators */
    .status-indicator {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .status-online {
        background-color: #1cc88a;
        box-shadow: 0 0 0 2px rgba(28, 200, 138, 0.2);
    }

    .status-offline {
        background-color: #858796;
    }

    /* Table Hover Styling */
    .user-row {
        transition: all 0.2s;
    }

    .user-row:hover {
        background-color: #fcfdfe;
    }

    .hover-primary:hover {
        background-color: #4e73df !important;
        color: white !important;
    }

    .hover-primary:hover i {
        color: white !important;
    }

    /* Clean Card */
    .rounded-lg {
        border-radius: 0.75rem !important;
    }

    .text-xs {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.05rem;
    }
</style>

<script>
    $(document).ready(function () {
        // Real-time Search Filter
        $("#userTableSearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#userTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<?php include('footer.php'); ?>