<?php
require_once("../DB Operations/dbconnection.php");

function hasPermission($module, $type)
{
    if (!isset($_SESSION['user_id']))
        return false;

    // 🔥 Admin always full access
    if ($_SESSION['User_type'] === 'Admin') {
        return true;
    }

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT up.can_read, up.can_write
        FROM user_permissions up
        JOIN modules m ON up.module_name = m.module_name
        WHERE up.user_id = ? AND up.module_name = ?
    ");
    $stmt->bind_param("is", $user_id, $module);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0)
        return false;

    $row = $result->fetch_assoc();

    if ($type == 'read')
        return $row['can_read'] == 1;
    if ($type == 'write')
        return $row['can_write'] == 1;

    return false;
}


/* ----------------------------------------------------
   BUTTON / ACTION PERMISSIONS
---------------------------------------------------- */

function hasActionPermission($module, $action)
{
    if (!isset($_SESSION['user_id']))
        return false;

    // 🔥 Admin always full access
    if ($_SESSION['User_type'] === 'Admin') {
        return true;
    }

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT uap.allowed
        FROM user_action_permissions uap
        JOIN module_actions ma ON ma.id = uap.action_id
        WHERE uap.user_id = ? 
        AND ma.module_name = ? 
        AND ma.action_key = ?
    ");

    $stmt->bind_param("iss", $user_id, $module, $action);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0)
        return false;

    $row = $result->fetch_assoc();

    return $row['allowed'] == 1;
}

function hasAnyActionPermission($module)
{
    if (!isset($_SESSION['user_id']))
        return false;

    if ($_SESSION['User_type'] === 'Admin')
        return true;

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT 1
        FROM user_action_permissions uap
        JOIN module_actions ma ON ma.id = uap.action_id
        WHERE uap.user_id = ?
        AND ma.module_name = ?
        AND uap.allowed = 1
        LIMIT 1
    ");

    $stmt->bind_param("is", $user_id, $module);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}
?>