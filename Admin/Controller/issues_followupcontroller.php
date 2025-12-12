<?php

require "../Model/issues_followupmodel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/issues_followupOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['followupId'])) {
      $follow=new Issuesfollowup();
      $follow->set_followid(Sanitization::test_input($_POST["followupId"]));
      $follow->set_followupItemId(Sanitization::test_input($_POST["itemid"]));
      $follow->set_followupBy(Sanitization::test_input($_POST["modifiedby"]));
      $follow->set_followupPOID(Sanitization::test_input($_POST["followupPOID"]));
      $follow->set_followupStatus(Sanitization::test_input($_POST["editedstatus"]));
      $itemId=DBIssuefollow::update($follow);
    }else{
        $follow=new Issuesfollowup();
        $follow->set_followupItemId(Sanitization::test_input($_POST["followupItemId"]));
        $follow->set_followcomment(Sanitization::test_input($_POST["followcomment"]));
        $follow->set_followupBy(Sanitization::test_input($_POST["followupBy"]));
        $follow->set_followupPOID(Sanitization::test_input($_POST["followupPOID"]));
    
        $itemId=DBIssuefollow::insert($follow);
        error_log($itemId);
        header("location:../View/itemstocklist.php");
    }
  } else if($_SERVER["REQUEST_METHOD"] == "GET"){
    if ($_GET['id']!= 0 && $_GET['POID']!=0) {
      DBIssuefollow::getFollowUpByItemIdPOID($_GET['id'],$_GET['POID']);
}else if($_GET['id']!= 0 && $_GET['POID']==0){
  DBIssuefollow::getFollowUpByItemId($_GET['id']);
}
  }
?>