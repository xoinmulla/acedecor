<?php
   if (session_status() === PHP_SESSION_NONE) {
       session_start();
   }
   
   $user_check = $_SESSION['login_user'];
   if(!isset($_SESSION['login_user'])){
      header("location:../View/login.php");
   }
?>