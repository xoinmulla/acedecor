<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once "../Model/pricingissuesModel.php";
class DBPricingIssues
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
                $followUp = new PricingIssues();
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
        $sql = "insert into item_pricingissues (`InvoiceNo`, `SupplierName`,`ItemName`, `POID`,`Status`) 
                values ('" . $followObj->get_InvoiceNo() .
                "','" . $followObj->get_SupplierName() . 
      "','" . $followObj->get_ItemName() .
      "','" . $followObj->get_POID() .
      "','" . $followObj->get_Status() . "')";
        error_log($sql);
    
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function update($follow)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE item_pricingissues SET POID='". $follow->get_POID() . 
            "', Status='" . $follow->get_Status() .
            "' WHERE 	PricingIssues_Id=" . $follow->get_PricingIssuesId();
            error_log( $sql);
        if ($connectionObj->query($sql) === TRUE) {
           
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

}
