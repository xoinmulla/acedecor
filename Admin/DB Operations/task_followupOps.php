<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once "../Model/task_followupModel.php";
class DBTaskFollow
{
    public static function getFollowUpByTaskId($TaskID)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql= "SELECT * FROM taskfollowup WHERE TaskID =" . $TaskID ;
        error_log($sql);
        $result = $connectionObj->query($sql);
        $followUpList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $followUp = new Taskfollowup();
                $followUp->setFollowUp_Id($row['FollowUp_Id']);
                $followUp->setFollowUp_Comments($row['FollowUp_Comments']);
                $followUp->setFollowUp_createdBy($row['FollowUp_createdBy']);
                $followUp->setFollowUp_createdOn(date('d-m-Y', strtotime($row['FollowUp_createdOn'])));
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
        $sql = "insert into taskfollowup (`TaskID`,`FollowUp_Comments`, `FollowUp_createdBy`) 
                values ('" . $followObj->getTaskID() .
                "','" . $followObj->getFollowUp_Comments() . 
      "','" . $followObj->getFollowUp_createdBy() ."')";
        error_log($sql);
    
        if ($connectionObj->query($sql) === true) {
            return $followObj->getTaskID() ;
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function update($follow)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE taskfollowup SET TaskID='". $follow->getTaskID() . 
            "', FollowUp_Comments='" . $follow->getFollowUp_Comments() .
            "', FollowUp_createdBy='" . $follow->getFollowUp_createdBy() .
            "' WHERE 	FollowUp_Id =" . $follow->getFollowUp_Id();
            error_log( $sql);
        if ($connectionObj->query($sql) === TRUE) {
           
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

}
