<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/rotationModel.php";
class DBrotation
{
    public static function insert($rotation)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO rotation (`sides`, 
    `createdBy`,
    `modifiedBy`) 
                values ('" . $rotation->get_sides() .
            "','" . $rotation->get_CreatedBy() .
            "','" . $rotation->get_ModifiedBy() .
            "')";
        error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getAllrotation()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM rotation";

        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $rotationList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rotation = new Rotation();
                $rotation->set_rotationId($row['rotationId']);
                $rotation->set_sides($row['sides']);
                $rotation->set_CreatedBy($row["createdBy"]);
                $rotation->set_ModifiedBy($row["modifiedBy"]);
                array_push($rotationList, $rotation);
            }
        } else {
            // echo "0 results";
        }
        return $rotationList;
    }

    public static function update($rotation)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "UPDATE rotation SET 
            sides='" . $rotation->get_sides() . "',
            createdBy='" . $rotation->get_CreatedBy() . "',
            modifiedBy='" . $rotation->get_ModifiedBy() . "'
            WHERE rotationId=" . $rotation->get_rotationId();

        error_log($sql);

        if ($connectionObj->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
            return false;
        }
    }
    public static function selectrotations()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT rotationId,sides FROM rotation';
        $result = mysqli_query($db->getConnection(), $sql);
        $rotationList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rotation = new Rotation();
                $rotation->set_rotationId($row['rotationId']);
                $rotation->set_sides($row['sides']);
                array_push($rotationList, $rotation);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($rotationList);
    }

    public static function delete($rotationId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE from rotation where rotationId='" . $rotationId . "'";
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}