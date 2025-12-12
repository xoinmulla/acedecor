<?php

require "../Model/enq_followupmodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/followupOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $follow=new Enqfollowup();
    $follow->set_followenqid(Sanitization::test_input($_POST["followenqid"]));
    $follow->set_followcomment(Sanitization::test_input($_POST["followcomment"]));
    $follow->set_followupBy(Sanitization::test_input($_POST["followupBy"]));
    $follow->setEnqStatus(Sanitization::test_input($_POST["enqStatus"]));
    DBfollow::insert($follow); 
  } else if($_SERVER["REQUEST_METHOD"] == "GET"){
    DBfollow::getFollowUpByEnqId($_GET['id']);
}
  
?>
