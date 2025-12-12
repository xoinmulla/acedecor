<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/enq_cat_mappingmodel.php";
class DBenqCatMapping
{
    public static function insert($obj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO enq_cat_mapping (`enq_id`,`cat_id`) 
                values ('" . $obj->get_enqId() .
            "','" . $obj->get_catId() .
            "')";
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getCategoryForEnq($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT C.enq_cat_name AS name FROM enq_cat_mapping AS M
        JOIN enquiry_category AS C
        ON M.cat_id=C.enq_catid
        WHERE enq_id=" . $id;
        $result = mysqli_query($connectionObj, $sql);
        $enquiryCatlist = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($enquiryCatlist, $row['name']);
            }
        }
        return $enquiryCatlist;
    }
    public static function getCategoryForEnqJson($id){
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT C.enq_cat_name AS name,C.enq_catid AS catId FROM enq_cat_mapping AS M
        JOIN enquiry_category AS C
        ON M.cat_id=C.enq_catid
        WHERE enq_id=" . $id;
        $result = mysqli_query($connectionObj, $sql);
        $enquiryCatlist = [];
        error_log($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $enqcatMap =new enqCatMappingModel();
                $enqcatMap->setName($row['name']);
                $enqcatMap->set_catId($row['catId']);
                array_push($enquiryCatlist, $enqcatMap);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($enquiryCatlist);
    }
}
