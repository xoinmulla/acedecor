<?php
require_once("../DB Operations/dbconnection.php");

$db = ConnectDb::getInstance();
$conn = $db->getConnection();

$user_id = (int) $_POST['user_id'];

/* --------------------------------
   SAVE MODULE PERMISSIONS
-------------------------------- */

$conn->query("DELETE FROM user_permissions WHERE user_id = $user_id");

if (isset($_POST['permissions'])) {

    foreach ($_POST['permissions'] as $module => $perm) {

        $read = isset($perm['read']) ? 1 : 0;
        $write = isset($perm['write']) ? 1 : 0;

        $stmt = $conn->prepare("
            INSERT INTO user_permissions (user_id, module_name, can_read, can_write)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("isii", $user_id, $module, $read, $write);
        $stmt->execute();
    }
}


/* --------------------------------
   SAVE BUTTON / ACTION PERMISSIONS
-------------------------------- */

$conn->query("DELETE FROM user_action_permissions WHERE user_id = $user_id");

if (isset($_POST['actions'])) {

    foreach ($_POST['actions'] as $action_id => $value) {

        $stmt = $conn->prepare("
            INSERT INTO user_action_permissions (user_id, action_id, allowed)
            VALUES (?, ?, 1)
        ");

        $stmt->bind_param("ii", $user_id, $action_id);
        $stmt->execute();
    }
}


/* --------------------------------
   REDIRECT
-------------------------------- */

header("Location: ../View/userManagement.php");
exit;
?>