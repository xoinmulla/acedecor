<?php
include('header.php');
require_once("../DB Operations/dbconnection.php");

if ($_SESSION['User_type'] !== 'Admin') {
    header("Location: noaccess.php");
    exit;
}

$db = ConnectDb::getInstance();
$conn = $db->getConnection();
$user_id = (int) $_GET['id'];

$userQuery = $conn->query("SELECT user_name, user_password FROM user WHERE user_id = $user_id");
$userData = $userQuery->fetch_assoc();

// Data Fetching (Keep your existing logic)
$modules = $conn->query("SELECT * FROM modules");
$existing = [];
$res = $conn->query("SELECT * FROM user_permissions WHERE user_id = $user_id");
while ($row = $res->fetch_assoc()) { $existing[$row['module_name']] = $row; }

$actions = [];
$actRes = $conn->query("SELECT * FROM module_actions");
while ($row = $actRes->fetch_assoc()) { $actions[$row['module_name']][] = $row; }

$existingActions = [];
$resActions = $conn->query("SELECT action_id FROM user_action_permissions WHERE user_id = $user_id");
while ($row = $resActions->fetch_assoc()) { $existingActions[$row['action_id']] = 1; }
?>

<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                    <li class="breadcrumb-item active">Permissions</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Access Control</h1>
            <div style="max-width: 420px; margin-top: 15px; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0,0,0,0.08); font-family: 'Segoe UI', sans-serif;">
    
    <!-- Header -->
    <div style="background: linear-gradient(135deg, #4e73df, #224abe); padding: 15px 20px; color: #fff;">
        <h5 style="margin: 0;"> <i class='fas fa-user-alt' style='font-size:20px;color:white'></i> User Details</h5>
    </div>

    <!-- Body -->
    <div style="background: #fff; padding: 20px;">
        
        <div style="margin-bottom: 12px;">
            <span style="color: #6c757d; font-size: 13px;">Username</span><br>
            <strong style="font-size: 16px;"><?= $userData['user_name'] ?></strong>
        </div>

        <div style="margin-bottom: 12px;">
            <span style="color: #6c757d; font-size: 13px;">Password</span><br>
            <strong style="font-size: 16px; "><?= $userData['user_password'] ?></strong>
        </div>

        <div style="margin-top: 15px;">
            <span style="padding: 5px 10px; background: #e3fcef; color: #1cc88a; border-radius: 20px; font-size: 12px;">
                Active User
            </span>
        </div>

    </div>

</div>
        </div>
        <div class="btn-group shadow-sm">
            <button class="btn btn-white border" id="collapseAllBtn"><i class="fas fa-compress-alt mr-1"></i> Collapse</button>
            <button class="btn btn-white border" id="expandAllBtn"><i class="fas fa-expand-alt mr-1"></i> Expand</button>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card border-0 shadow-sm mb-4 rounded-lg">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-joined">
                        <div class="input-group-prepend">
                            <span class="input-group-text border-right-0 bg-transparent">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control border-left-0" id="moduleSearch" placeholder="Search modules by name...">
                    </div>
                </div>
                <div class="col-md-8 text-right">
                    <span class="badge badge-soft-primary p-2 mr-2"><i class="fas fa-info-circle mr-1"></i> Changes are autosaved to local state until you hit Submit.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <form method="post" action="../Controller/userPermissionController.php" id="permissionForm">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">

        <div id="moduleContainer">
            <?php while ($m = $modules->fetch_assoc()): 
                $mod = $m['module_name'];
                $label = $m['module_label'];
                $read = isset($existing[$mod]) ? $existing[$mod]['can_read'] : 0;
                $write = isset($existing[$mod]) ? $existing[$mod]['can_write'] : 0;
                $hasActions = isset($actions[$mod]);
            ?>
            <div class="card shadow-sm mb-3 module-card border-left-lg" data-label="<?= htmlspecialchars($label) ?>">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Module Info -->
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-stack bg-light text-primary mr-3">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 font-weight-bold"><?= $label ?></h5>
                                    <small class="text-muted">System Module: <?= $mod ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Read/Write Toggles -->
                        <!-- <div class="col-lg-5 d-flex justify-content-center">
                            <div class="permission-toggle-group">
                                <div class="custom-control custom-switch mx-4">
                                    <input type="checkbox" class="custom-control-input read-checkbox" name="permissions[<?= $mod ?>][read]" value="1" id="read_<?= $mod ?>" <?= $read ? 'checked' : '' ?>>
                                    <label class="custom-control-label font-weight-600" for="read_<?= $mod ?>">Read Access</label>
                                </div>
                                <div class="custom-control custom-switch mx-4">
                                    <input type="checkbox" class="custom-control-input write-checkbox" name="permissions[<?= $mod ?>][write]" value="1" id="write_<?= $mod ?>" <?= $write ? 'checked' : '' ?>>
                                    <label class="custom-control-label font-weight-600 text-warning" for="write_<?= $mod ?>">Write Access</label>
                                </div>
                            </div>
                        </div> -->

                        <!-- Action Toggle Button -->
                        <div class="col-lg-8 text-right">
                            <?php if ($hasActions): ?>
                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" data-toggle="collapse" data-target="#actions_<?= $mod ?>">
                                    Manage Actions <i class="fas fa-chevron-down ml-1 toggle-icon"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Actions Expansion -->
                    <?php if ($hasActions): ?>
                    <div class="collapse mt-4" id="actions_<?= $mod ?>">
                        <div class="p-3 rounded bg-light border-top">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 font-weight-bold text-xs text-uppercase tracking-wider text-muted">Specific Operations</h6>
                                <div>
                                    <button type="button" class="btn btn-xs btn-link select-all-actions" data-module="<?= $mod ?>">Check All</button>
                                    <button type="button" class="btn btn-xs btn-link text-danger deselect-all-actions" data-module="<?= $mod ?>">Uncheck All</button>
                                </div>
                            </div>
                            <div class="row">

<?php if ($mod === 'projects'): ?>

<?php
$tasks = [];
$ongoing = [];
$pending = [];
$completed = [];

foreach ($actions[$mod] as $act) {
    $key = $act['action_key'];

    if (in_array($key, ['task_followup','task_edit','task_delete'])) {
        $tasks[] = $act;
    }
    elseif (in_array($key, ['ongoing_info','ongoing_allocate'])) {
        $ongoing[] = $act;
    }
    elseif (in_array($key, ['pending_info','pending_allocate','pending_delete'])) {
        $pending[] = $act;
    }
    elseif (in_array($key, ['completed_info','completed_delete'])) {
        $completed[] = $act;
    }
}
?>

<!-- ===== PROJECT TASKS PAGE ===== -->
<div class="col-12 mb-3">
    <h6 class="text-primary font-weight-bold mb-2">
        <i class="fas fa-tasks"></i> Project Tasks Page
    </h6>
    <div class="row">
        <?php foreach ($tasks as $act): ?>
        <div class="col-md-3 mb-2">
            <div class="action-chip">
                <input type="checkbox" class="action-checkbox"
                       name="actions[<?= $act['id'] ?>]" value="1"
                       id="act_<?= $act['id'] ?>"
                       <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                       data-module="<?= $mod ?>">
                <label for="act_<?= $act['id'] ?>">
                    <i class="fas fa-fingerprint mr-1"></i>
                    <?= $act['action_label'] ?>
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== ONGOING PROJECTS PAGE ===== -->
<div class="col-12 mb-3">
    <h6 class="text-success font-weight-bold mb-2">
        <i class="fas fa-spinner"></i> Ongoing Projects List
    </h6>
    <div class="row">
        <?php foreach ($ongoing as $act): ?>
        <div class="col-md-3 mb-2">
            <div class="action-chip">
                <input type="checkbox" class="action-checkbox"
                       name="actions[<?= $act['id'] ?>]" value="1"
                       id="act_<?= $act['id'] ?>"
                       <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                       data-module="<?= $mod ?>">
                <label for="act_<?= $act['id'] ?>">
                    <i class="fas fa-fingerprint mr-1"></i>
                    <?= $act['action_label'] ?>
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== PENDING PROJECTS PAGE ===== -->
<div class="col-12 mb-3">
    <h6 class="text-warning font-weight-bold mb-2">
        <i class="fas fa-clock"></i> Pending Projects List
    </h6>
    <div class="row">
        <?php foreach ($pending as $act): ?>
        <div class="col-md-3 mb-2">
            <div class="action-chip">
                <input type="checkbox" class="action-checkbox"
                       name="actions[<?= $act['id'] ?>]" value="1"
                       id="act_<?= $act['id'] ?>"
                       <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                       data-module="<?= $mod ?>">
                <label for="act_<?= $act['id'] ?>">
                    <i class="fas fa-fingerprint mr-1"></i>
                    <?= $act['action_label'] ?>
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== COMPLETED PROJECTS PAGE ===== -->
<div class="col-12">
    <h6 class="text-dark font-weight-bold mb-2">
        <i class="fas fa-check-circle"></i> Completed Projects List
    </h6>
    <div class="row">
        <?php foreach ($completed as $act): ?>
        <div class="col-md-3 mb-2">
            <div class="action-chip">
                <input type="checkbox" class="action-checkbox"
                       name="actions[<?= $act['id'] ?>]" value="1"
                       id="act_<?= $act['id'] ?>"
                       <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                       data-module="<?= $mod ?>">
                <label for="act_<?= $act['id'] ?>">
                    <i class="fas fa-fingerprint mr-1"></i>
                    <?= $act['action_label'] ?>
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php elseif ($mod === 'customers'): ?>
    <?php
    $customerActions = [];
    $quotationActions = [];

    foreach ($actions[$mod] as $act) {
        $key = $act['action_key'];

        if (in_array($key, [
            'edit_customer',
            'customer_info',
            'designs',
            'customer_inputs',
            'delete_customer'
        ])) {
            $customerActions[] = $act;
        } else {
            $quotationActions[] = $act;
        }
    }
    ?>

    <!-- ===== CUSTOMER PAGE ===== -->
    <div class="col-12 mb-3">
        <h6 class="text-primary font-weight-bold mb-2">
            <i class="fas fa-user"></i> Customer Page
        </h6>
        <div class="row">
            <?php foreach ($customerActions as $act): ?>
                <div class="col-md-3 mb-2">
                    <div class="action-chip">
                        <input type="checkbox"
                               class="action-checkbox"
                               name="actions[<?= $act['id'] ?>]"
                               value="1"
                               id="act_<?= $act['id'] ?>"
                               <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                               data-module="<?= $mod ?>">
                        <label for="act_<?= $act['id'] ?>">
                            <i class="fas fa-fingerprint mr-1"></i>
                            <?= $act['action_label'] ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ===== QUOTATION PAGE ===== -->
    <div class="col-12">
        <h6 class="text-success font-weight-bold mb-2">
            <i class="fas fa-file-invoice"></i> Quotation Page
        </h6>
        <div class="row">
            <?php foreach ($quotationActions as $act): ?>
                <div class="col-md-3 mb-2">
                    <div class="action-chip">
                        <input type="checkbox"
                               class="action-checkbox"
                               name="actions[<?= $act['id'] ?>]"
                               value="1"
                               id="act_<?= $act['id'] ?>"
                               <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                               data-module="<?= $mod ?>">
                        <label for="act_<?= $act['id'] ?>">
                            <i class="fas fa-fingerprint mr-1"></i>
                            <?= $act['action_label'] ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php elseif ($mod === 'purchase_orders'): ?>

<div class="col-12 mb-3">
    <h6 class="text-primary font-weight-bold mb-2">
        <i class="fas fa-file-invoice"></i> Purchase Orders Pages
    </h6>
    <div class="row">
        <?php foreach ($actions[$mod] as $act): ?>
        <div class="col-md-3 mb-2">
            <div class="action-chip">
                <input type="checkbox"
                       class="action-checkbox"
                       name="actions[<?= $act['id'] ?>]"
                       value="1"
                       id="act_<?= $act['id'] ?>"
                       <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                       data-module="<?= $mod ?>">
                <label for="act_<?= $act['id'] ?>">
                    <i class="fas fa-fingerprint mr-1"></i>
                    <?= $act['action_label'] ?>
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php elseif ($mod === 'payments'): ?>

<div class="col-12 mb-3">
    <h6 class="text-primary font-weight-bold mb-2">
        <i class="fas fa-credit-card"></i> Payments Pages
    </h6>
    <div class="row">
        <?php foreach ($actions[$mod] as $act): ?>
        <div class="col-md-3 mb-2">
            <div class="action-chip">
                <input type="checkbox"
                       class="action-checkbox"
                       name="actions[<?= $act['id'] ?>]"
                       value="1"
                       id="act_<?= $act['id'] ?>"
                       <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                       data-module="<?= $mod ?>">
                <label for="act_<?= $act['id'] ?>">
                    <i class="fas fa-fingerprint mr-1"></i>
                    <?= $act['action_label'] ?>
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>

    <!-- ===== DEFAULT (UNCHANGED) FOR OTHER MODULES ===== -->
    <?php foreach ($actions[$mod] as $act): ?>
        <div class="col-md-3 mb-2">
            <div class="action-chip">
                <input type="checkbox"
                       class="action-checkbox"
                       name="actions[<?= $act['id'] ?>]"
                       value="1"
                       id="act_<?= $act['id'] ?>"
                       <?= isset($existingActions[$act['id']]) ? 'checked' : '' ?>
                       data-module="<?= $mod ?>">
                <label for="act_<?= $act['id'] ?>">
                    <i class="fas fa-fingerprint mr-1"></i>
                    <?= $act['action_label'] ?>
                </label>
            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

</div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Sticky Footer Save Bar -->
        <div class="sticky-save-bar shadow-lg border-top bg-white p-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted d-none d-md-block">
                        <i class="fas fa-shield-alt text-success mr-2"></i> Confirm that the selected permissions align with company security policy.
                    </div>
                    <div class="ml-auto">
                        <a href="users.php" class="btn btn-link text-muted mr-3">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm btn-rounded">
                            <strong>Update Permissions</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    body { background-color: #f8f9fc; padding-bottom: 100px; }
    
    /* Custom Card Design */
    .module-card { border: none; transition: transform 0.2s, box-shadow 0.2s; border-radius: 12px; }
    .module-card:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08)!important; }
    .border-left-lg { border-left: 4px solid #4e73df !important; }
    
    /* Icon Stack */
    .icon-stack { height: 40px; width: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
    
    /* iOS Switches */
    .custom-switch .custom-control-label::before { height: 1.5rem; width: 2.75rem; border-radius: 1rem; }
    .custom-switch .custom-control-label::after { width: calc(1.5rem - 4px); height: calc(1.5rem - 4px); background-color: #adb5bd; border-radius: 1rem; }
    .custom-switch .custom-control-input:checked ~ .custom-control-label::after { transform: translateX(1.25rem); background-color: #fff; }
    
    /* Action Chips */
    .action-chip { position: relative; }
    .action-chip input { position: absolute; opacity: 0; cursor: pointer; }
    .action-chip label { 
        display: block; padding: 8px 12px; background: #fff; border: 1px solid #ddd; 
        border-radius: 8px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; margin-bottom: 0;
    }
    .action-chip input:checked + label { background: #4e73df; color: white; border-color: #4e73df; box-shadow: 0 4px 6px rgba(78,115,223,0.2); }
    
    /* Sticky Footer */
    .sticky-save-bar { position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030; }
    
    /* Animations */
    .toggle-icon { transition: transform 0.3s; }
    .show + .btn .toggle-icon, [aria-expanded="true"] .toggle-icon { transform: rotate(180deg); }
    .btn-rounded { border-radius: 50px; }
    .badge-soft-primary { background-color: #e0e7ff; color: #4e73df; }
</style>

<script>
$(document).ready(function() {
    // Search Filter
    $('#moduleSearch').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.module-card').filter(function() {
            $(this).toggle($(this).data('label').toLowerCase().indexOf(value) > -1);
        });
    });

    // Expand/Collapse All
    $('#expandAllBtn').click(function() { $('.collapse').collapse('show'); });
    $('#collapseAllBtn').click(function() { $('.collapse').collapse('hide'); });

    // Select All Logic
    $('.select-all-actions').click(function() {
        var mod = $(this).data('module');
        $('#actions_' + mod + ' .action-checkbox').prop('checked', true);
    });

    $('.deselect-all-actions').click(function() {
        var mod = $(this).data('module');
        $('#actions_' + mod + ' .action-checkbox').prop('checked', false);
    });
});
</script>

<?php include('footer.php'); ?>