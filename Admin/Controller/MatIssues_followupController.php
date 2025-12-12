<?php

require "../Model/MatIssues_followupModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/MatIssues_followupOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['followupId'])) {
      $follow=new MatIssuesfollowup();
      $follow->set_followid(Sanitization::test_input($_POST["followupId"]));
      $follow->set_followupMaterialId(Sanitization::test_input($_POST["materialId"]));
      $follow->set_followupBy(Sanitization::test_input($_POST["modifiedby"]));
      $follow->set_followupPOID(Sanitization::test_input($_POST["followupPOID"]));
      $follow->set_followupStatus(Sanitization::test_input($_POST["editedstatus"]));
      $itemId=DBMatIssuefollow::update($follow);
    }else{
        $follow=new MatIssuesfollowup();
        $follow->set_followupMaterialId(Sanitization::test_input($_POST["followupmaterialId"]));
        $follow->set_followcomment(Sanitization::test_input($_POST["followcomment"]));
        $follow->set_followupBy(Sanitization::test_input($_POST["followupBy"]));
        $follow->set_followupPOID(Sanitization::test_input($_POST["followupPOID"]));
    
        $itemId=DBMatIssuefollow::insert($follow);
        error_log($itemId);
        header("location:../View/MaterialStocklist.php");
    }
  } else if($_SERVER["REQUEST_METHOD"] == "GET"){
    if ($_GET['id']!= 0 && $_GET['POID']!=0) {
      DBMatIssuefollow::getFollowUpByMaterialIdPOID($_GET['id'],$_GET['POID']);
}else if($_GET['id']!= 0 && $_GET['POID']==0){
  DBMatIssuefollow::getFollowUpByMaterialId($_GET['id']);
}
  }
?>