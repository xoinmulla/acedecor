<?php
require_once("../Model/userLoginModel.php");
require_once("../DB Operations/userOps.php");
error_log($_SERVER["REQUEST_METHOD"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 
   $db = ConnectDb::getInstance();
   $myusername = mysqli_real_escape_string($db->getConnection(), $_POST['user_email']);
   $mypassword = mysqli_real_escape_string($db->getConnection(), $_POST['user_password']);
   
   $loginModel = new userLoginModel();
   $loginModel->set_username($myusername);
   $loginModel->set_userpassword($mypassword);
   $user = DBuser::checkUser($loginModel);

   // If result matched $myusername and $mypassword, table row must be 1 row
   if ($user && $user->get_userstatus() == 'Enable') {
      // echo "Validateed successfully";
      session_start();
      $_SESSION['login_user'] = $user->get_username();
      $_SESSION['User_type'] = $user->get_usertype();
      $_SESSION['user_id'] = $user->get_userid();  // ADD THIS
      header("location: ../View/maindashboard.php");
   } else {
      header("location: ../View/login.php");
   }
}
?>