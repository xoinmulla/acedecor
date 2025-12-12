<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/EBModel.php";
class DB_EB
{
    public static function insert($EB)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO eb (`EB`,`CreatedBy`,`ModifiedBy`) 
                values ('". $EB->getEB() ."',
                '". $EB->getCreatedBy() ."',
                '". $EB->getModifiedBy() ."')";
            error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getAllEB()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM eb";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $EBList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $EB = new EB();
                $EB->setEB_Id($row['EB_Id']);
                $EB->setEB($row['EB']);
                array_push($EBList, $EB);
            }
        } else {
            // echo "0 results";
        }
        return $EBList;
    }

    public static function update($EB)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE eb SET EB='" . $EB->getEB() .
            "' WHERE EB_Id =" . $EB->getEB_Id();
error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
    public static function selectEB()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT EB_Id ,EB FROM eb ';
        $result = mysqli_query($db->getConnection(), $sql);
        $EBList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $EB = new EB();
                $EB->setEB_Id($row['EB_Id']);
                $EB->setEB($row['EB']);
                array_push($EBList, $EB);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($EBList);
    }

    public static function delete($EBId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE from eb where EB_Id='" . $EBId . "'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}