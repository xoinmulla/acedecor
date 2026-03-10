<?php
include('session.php');
require_once("../DB Operations/userOps.php");

if ($_SESSION['User_type'] !== 'Admin') {
    header("Location: noaccess.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$user_id = (int) $_GET['id'];

// 🚫 Extra Safety — Prevent self delete
if ($user_id == $_SESSION['user_id']) {
    header("Location: users.php?error=selfdelete");
    exit;
}

// 🗑️ Delete User
DBuser::delete($user_id);

header("Location: userManagement.php?msg=deleted");
exit;
?>