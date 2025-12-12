<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/CLDimensionModel.php";
class DBCLDimensions
{
    public static function insert($CLDimension)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO cl_dimension (`CL_Dimensions`) 
                values ('". $CLDimension->getCL_Dimensions() ."')";
            error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getAllCLDimension()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM cl_dimension";

        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $CLDimensionList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $CLDimension = new CLDimension();
                $CLDimension->setCLDimensionId($row['CLDimensionId']);
                $CLDimension->setCL_Dimensions($row['CL_Dimensions']);
                array_push($CLDimensionList, $CLDimension);
            }
        } else {
            // echo "0 results";
        }
        return $CLDimensionList;
    }

    public static function update($CLDimension)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE cl_dimension SET CL_Dimensions='" . $dimension->getCL_Dimensions() .
            "' WHERE CLDimensionId =" . $dimension->getCLDimensionId();

        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
    public static function selectCLDimensions()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT CLDimensionId,CL_Dimensions FROM cl_dimension';
        $result = mysqli_query($db->getConnection(), $sql);
        $CLDimensionList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $CLDimension = new CLDimension();
                $CLDimension->setCLDimensionId($row['CLDimensionId']);
                $CLDimension->setCL_Dimensions($row['CL_Dimensions']);
                array_push($CLDimensionList, $CLDimension);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($CLDimensionList);
    }

    public static function delete($CLDimensionId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE from cl_dimension where CLDimensionId='" . $CLDimensionId . "'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}