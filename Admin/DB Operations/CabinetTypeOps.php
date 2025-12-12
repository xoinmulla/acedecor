<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/CabinetTypeModel.php";
class DBCabinetType
{
    public static function insert($CabinetType)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO cabinettype (`CabinetType`,`CreatedBy`,`ModifiedBy`) 
                values ('". $CabinetType->getCabinetType() ."',
                '". $CabinetType->getCreatedBy() ."',
                '". $CabinetType->getModifiedBy() ."')";
            error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getAllCabinetType()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM cabinettype";

        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $CabinetTypeList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $CabinetType = new CabinetType();
                $CabinetType->setCabinetType_Id($row['CabinetType_Id']);
                $CabinetType->setCabinetType($row['CabinetType']);
                array_push($CabinetTypeList, $CabinetType);
            }
        } else {
            // echo "0 results";
        }
        return $CabinetTypeList;
    }

    public static function update($CabinetType)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE cabinettype SET CabinetType='" . $CabinetType->getCabinetType() .
            "' WHERE CabinetType_Id =" . $CabinetType->getCabinetType_Id();
error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
    
    public static function selectCabinetTypes()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT CabinetType_Id ,CabinetType FROM cabinettype';
        error_log($sql);
        $result = mysqli_query($db->getConnection(), $sql);
        $CabinetTypeList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $CabinetType = new CabinetType();
                $CabinetType->setCabinetType_Id($row['CabinetType_Id']);
                $CabinetType->setCabinetType($row['CabinetType']);
                array_push($CabinetTypeList, $CabinetType);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($CabinetTypeList);
    }

    public static function delete($CabinetTypeId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE from cabinettype where CabinetType_Id='" . $CabinetTypeId . "'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}