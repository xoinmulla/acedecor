<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once "../Model/enq_followupmodel.php";
class DBfollow
{
  public static function getFollowUpByEnqId($enqId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM enquiry_followups WHERE followup_enq_id=" . $enqId;
    $result = $connectionObj->query($sql);
    $followUpList = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $followUp = new Enqfollowup();
        $followUp->set_followid($row['followupid']);
        $followUp->set_followenqid($row['followup_enq_id']);
        $followUp->set_followcomment($row['followup_comments']);
        $followUp->set_followupBy($row['followup_by']);
        $followUp->set_followupOn(date('d-m-Y',strtotime($row['followup_createdon'])));
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
    $sql = "insert into enquiry_followups (`followup_enq_id`, `followup_comments`, `followup_by`) 
                values ('" . $followObj->get_followenqid() .
      "','" . $followObj->get_followcomment() .
      "','" . $followObj->get_followupBy() . "')";

    if ($connectionObj->query($sql) === TRUE) {
      $sql="UPDATE enquiry_details SET enqStatus='".$followObj->getEnqStatus()."'
      WHERE enqid=".$followObj->get_followenqid();
      error_log($sql);
      if ($connectionObj->query($sql) === TRUE) {

      }else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

 



}
