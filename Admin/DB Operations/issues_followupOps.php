<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once "../Model/issues_followupmodel.php";
class DBIssuefollow
{
    public static function getFollowUpByItemId($ItemId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql= "SELECT * FROM itemissues_followup WHERE followup_ItemId=" . $ItemId;
        error_log($sql);
        $result = $connectionObj->query($sql);
        $followUpList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $followUp = new Issuesfollowup();
                $followUp->set_followid($row['followupId']);
                $followUp->set_followcomment($row['followup_comments']);
                $followUp->set_followupBy($row['followup_by']);
                $followUp->set_followupOn(date('d-m-Y', strtotime($row['followup_createdon'])));
                array_push($followUpList, $followUp);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($followUpList);
    }

    public static function getFollowUpByItemIdPOID($ItemId,$POID)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql= "SELECT * FROM itemissues_followup WHERE followup_ItemId=$ItemId and followupPOID=$POID";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $followUpList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $followUp = new Issuesfollowup();
                $followUp->set_followid($row['followupId']);
                $followUp->set_followcomment($row['followup_comments']);
                $followUp->set_followupBy($row['followup_by']);
                $followUp->set_followupOn(date('d-m-Y', strtotime($row['followup_createdon'])));
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
        $sql = "insert into itemissues_followup (`followup_ItemId`, `followupPOID`,`followup_comments`, `followup_by`) 
                values ('" . $followObj->get_followupItemId() .
                "','" . $followObj->get_followupPOID() . 
      "','" . $followObj->get_followcomment() .
      "','" . $followObj->get_followupBy() . "')";
        error_log($sql);
    
        if ($connectionObj->query($sql) === true) {
            return $followObj->get_followupItemId() ;
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function update($follow)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE itemissues_followup SET followupPOID='". $follow->get_followupPOID() . 
            "', Status='" . $follow->get_followupStatus() .
            "' WHERE 	followupId=" . $follow->get_followid();
            error_log( $sql);
        if ($connectionObj->query($sql) === TRUE) {
           
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

}
