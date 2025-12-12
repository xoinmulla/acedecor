<?php

require "../Model/task_followupmodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/task_followupOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // if (isset($_POST['taskfollowupid'])) {
      //     $follow=new Taskfollowup();
      //     $follow->setFollowUp_Id(Sanitization::test_input($_POST["taskfollowupid"]));
      //     $follow->setTaskID(Sanitization::test_input($_POST["taskfollowupid"]));
      //     $follow->setFollowUp_Comments(Sanitization::test_input($_POST["followcomment"]));
      //     $follow->setFollowUp_createdBy(Sanitization::test_input($_POST["followupBy"]));
      //     DBTaskFollow::update($follow);
      // } else {
          $follow=new Taskfollowup();
          $follow->setTaskID(Sanitization::test_input($_POST["taskfollowupid"]));
          $follow->setFollowUp_Comments(Sanitization::test_input($_POST["followcomment"]));
          $follow->setFollowUp_createdBy(Sanitization::test_input($_POST["followupBy"]));
          DBTaskFollow::insert($follow);
          header("location:../View/projectView.php");
      // }
  }else if($_SERVER["REQUEST_METHOD"] == "GET"){
    DBTaskFollow::getFollowUpByTaskId($_GET['id']);
}
  
?>