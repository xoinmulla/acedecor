<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once "../Model/Project_IssuesModel.php";
class DBProjectIssues
{
    public static function getIssuesByProjId($projId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql= "SELECT * FROM project_issues WHERE Issue_ProjectId =" . $projId;
        error_log($sql);
        $result = $connectionObj->query($sql);
        $followUpList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $followUp = new ProjectIssues();
                $followUp->setIssueId($row['IssueId']);
                $followUp->setIssue_Description($row['Issue_Description']);
                $followUp->setIssue_ContactName($row['Issue_ContactName']);
                $followUp->setIssue_ContactDetails($row['Issue_ContactDetails']);
                $followUp->setIssue_createdby($row['Issue_createdby']);
                $followUp->setIssue_createdon(date('d-m-Y', strtotime($row['Issue_createdon'])));
                array_push($followUpList, $followUp);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($followUpList);
    }

   

    public static function insert($followObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "insert into project_issues (`Issue_ProjectId`, `Issue_ProjCode`,`Issue_Description`,
         `Issue_ContactName`,`Issue_ContactDetails`,`Issue_createdby`,`Issue_modifiedby`) 
                values ('" . $followObj->getIssue_ProjectId() .
                "','" . $followObj->getIssue_ProjCode() . 
      "','" . $followObj->getIssue_Description() .
      "','" . $followObj->getIssue_ContactName() .
      "','" . $followObj->getIssue_ContactDetails() .
      "','" . $followObj->getIssue_createdby() . 
      "','" . $followObj->getIssue_modifiedby() ."')";
        error_log($sql);
    
        if ($connectionObj->query($sql) === true) {
            return $followObj->getIssue_ProjectId() ;
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function update($follow)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE project_issues SET followup_ProjCode='". $follow->getFollowup_ProjCode() . 
            "', Status='" . $follow->getStatus() .
            "' WHERE 	followupId=" . $follow->getFollowupId();
            error_log( $sql);
        if ($connectionObj->query($sql) === TRUE) {
           
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

}
