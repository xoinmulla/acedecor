<?php
require_once("../Model/usermodel.php");
require_once("../DB Operations/userOps.php");

if ($_POST['action'] == 'create') {

    $user = new User();
    $user->set_username($_POST['user_name']);
    $user->set_usercontact($_POST['user_contact']);
    $user->set_useremail($_POST['user_email']);
    $user->set_userpassword($_POST['user_password']);
    $user->set_usertype($_POST['user_type']);
    $user->set_userstatus('Enable');

    DBuser::insert($user);

    header("Location: ../View/userManagement.php");
}   