<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once "../Model/MatIssues_followupModel.php";
class DBMatIssuefollow
{
    public static function getFollowUpByMaterialId($MatId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "SELECT * FROM materialissues_followup WHERE followup_MaterialId =" . $MatId;

        error_log($sql);

        $result = $connectionObj->query($sql);

        $followUpList = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $followUp = new MatIssuesfollowup();

                // FIXED: use the actual database column name
                $followUp->set_followupid($row['followup_Id']);

                $followUp->set_followcomment($row['followup_comments']);
                $followUp->set_followupBy($row['followup_by']);
                $followUp->set_followupOn(
                    date('d-m-Y', strtotime($row['followup_createdon']))
                );

                array_push($followUpList, $followUp);
            }
        }

        header('Content-Type: application/json');
        echo json_encode($followUpList);
    }

    public static function getFollowUpByMaterialIdPOID($MatId, $POID)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM materialissues_followup WHERE followup_MaterialId=$MatId and followup_POID=$POID";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $followUpList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $followUp = new MatIssuesfollowup();
                $followUp->set_followupid($row['followup_Id']);
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
        $sql = "insert into materialissues_followup (`followup_MaterialId`, `followup_POID`,`followup_comments`, `followup_by`) 
                values ('" . $followObj->get_followupMaterialId() .
            "','" . $followObj->get_followupPOID() .
            "','" . $followObj->get_followcomment() .
            "','" . $followObj->get_followupBy() . "')";
        error_log($sql);

        if ($connectionObj->query($sql) === true) {
            return $followObj->get_followupMaterialId();
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function update($follow)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE materialissues_followup SET followup_POID='" . $follow->get_followupPOID() .
            "', Status='" . $follow->get_followupStatus() .
            "' WHERE followup_Id=" . $follow->get_followupid();
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

}
