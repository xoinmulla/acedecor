<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/EB_LWModel.php";
class DB_EBLW
{
    public static function insert($EBLW)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO eb_lw (`EB_LW`,`CreatedBy`,`ModifiedBy`) 
                values ('". $EBLW->getEB_LW() ."',
                '". $EBLW->getCreatedBy() ."',
                '". $EBLW->getModifiedBy() ."')";
            error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getAllEBLW()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM eb_lw";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $EBLWList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $EBLW = new EBLW();
                $EBLW->setEBLW_Id($row['EBLW_Id']);
                $EBLW->setEB_LW($row['EB_LW']);
                array_push($EBLWList, $EBLW);
            }
        } else {
            // echo "0 results";
        }
        return $EBLWList;
    }

    public static function update($EBLW)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE eb_lw SET EB_LW='" . $EBLW->getEB_LW() .
            "' WHERE EBLW_Id =" . $EBLW->getEBLW_Id();
error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
    public static function selectEBLW()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT EBLW_Id ,EB_LW FROM eb_lw ';
        $result = mysqli_query($db->getConnection(), $sql);
        $EBLWList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $EBLW = new EBLW();
                $EBLW->setEBLW_Id($row['EBLW_Id']);
                $EBLW->setEB_LW($row['EB_LW']);
                array_push($EBLWList, $EBLW);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($EBLWList);
    }

    public static function delete($EBLWId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE from eb_lw where EBLW_Id='" . $EBLWId . "'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}