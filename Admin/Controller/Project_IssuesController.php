<?php

require "../Model/Project_IssuesModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/Project_IssuesfollowupOps.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['IssueId'])) {
      $follow=new ProjectIssues();
      $follow->setIssueId(Sanitization::test_input($_POST["IssueId"]));
      $follow->setIssue_ProjectId(Sanitization::test_input($_POST["projectId"]));
      $follow->setIssue_ProjCode(Sanitization::test_input($_POST["projectCode"]));
      $follow->setIssue_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
      $follow->setStatus(Sanitization::test_input($_POST["editedstatus"]));
      $itemId=DBProjectIssues::update($follow);
    }else{
      $follow=new ProjectIssues();
      $follow->setIssue_ProjectId(Sanitization::test_input($_POST["projectId"]));
      $follow->setIssue_ProjCode(Sanitization::test_input($_POST["projectCode"]));
      $follow->setIssue_createdby(Sanitization::test_input($_POST["modifiedby"]));
      $follow->setIssue_Description(Sanitization::test_input($_POST["Description"]));
      $follow->setIssue_ContactName(Sanitization::test_input($_POST["ContName"]));
      $follow->setIssue_ContactDetails(Sanitization::test_input($_POST["ContNumber"]));
      $follow->setIssue_createdby(Sanitization::test_input($_POST["createdby"]));
      $follow->setIssue_modifiedby(Sanitization::test_input($_POST["modifiedby"]));
        $itemId=DBProjectIssues::insert($follow);
        error_log($itemId);
      
        header("location:../View/ItemAllocation.php?id=".$_POST["projectId"]);
    }
  } else if($_SERVER["REQUEST_METHOD"] == "GET"){
    if ($_GET['id']!= 0) {
        DBProjectIssues::getIssuesByProjId($_GET['id']);
}
// else if($_GET['id']!= 0 && $_GET['POID']==0){
//     DBProjectIssuefollow::getFollowUpByItemId($_GET['id']);
// }
  }
?>