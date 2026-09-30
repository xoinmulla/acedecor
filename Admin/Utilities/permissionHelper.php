<?php
// /Utilities/permissionHelper.php

require_once "../DB Operations/dbconnection.php";

function hasPermission($module, $type)
{
    if (!isset($_SESSION['user_id'])) return false;
    if ($_SESSION['User_type'] === 'Admin') return true;

    // Cache in session to avoid repeat DB hits
    $cacheKey = "perm_{$module}_{$type}";
    if (isset($_SESSION[$cacheKey])) {
        return $_SESSION[$cacheKey];
    }

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT up.can_read, up.can_write
        FROM user_permissions up
        WHERE up.user_id = ? AND up.module_name = ?
    ");
    $stmt->bind_param("is", $user_id, $module);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION[$cacheKey] = false;
        return false;
    }

    $row = $result->fetch_assoc();
    $allowed = ($type == 'read') ? ($row['can_read'] == 1) : ($row['can_write'] == 1);
    $_SESSION[$cacheKey] = $allowed;
    return $allowed;
}

function hasActionPermission($module, $action)
{
    if (!isset($_SESSION['user_id'])) return false;
    if ($_SESSION['User_type'] === 'Admin') return true;

    // ✅ Cache ALL module actions in one query instead of 1 query per action
    $cacheKey = "action_perms_{$module}";

    if (!isset($_SESSION[$cacheKey])) {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("
            SELECT ma.action_key, uap.allowed
            FROM user_action_permissions uap
            JOIN module_actions ma ON ma.id = uap.action_id
            WHERE uap.user_id = ? AND ma.module_name = ?
        ");
        $stmt->bind_param("is", $user_id, $module);
        $stmt->execute();
        $result = $stmt->get_result();

        $_SESSION[$cacheKey] = [];
        while ($row = $result->fetch_assoc()) {
            $_SESSION[$cacheKey][$row['action_key']] = (bool)$row['allowed'];
        }
    }

    return $_SESSION[$cacheKey][$action] ?? false;
}

function hasAnyActionPermission($module)
{
    if (!isset($_SESSION['user_id'])) return false;
    if ($_SESSION['User_type'] === 'Admin') return true;

    // Reuse the cached module permissions
    $cacheKey = "action_perms_{$module}";
    if (!isset($_SESSION[$cacheKey])) {
        // trigger cache load by calling hasActionPermission with a dummy key
        hasActionPermission($module, '__init__');
    }

    foreach ($_SESSION[$cacheKey] as $allowed) {
        if ($allowed) return true;
    }
    return false;
}
?>