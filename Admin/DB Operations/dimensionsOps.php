
<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/dimensionsModel.php";
class DBdimension
{
    public static function insert($dimension)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO dimensions (`dimensionsName`, 
    `dimensionsDescription`,
    `length`,
    `breadth`,
    `thickness`,
    `createdBy`,
    `modifiedBy`) 
                values ('" . $dimension->get_dimensionName() .
            "','" . $dimension->get_dimensionDescription() .
            "','" . $dimension->get_length() .
            "','" . $dimension->get_breadth() .
            "','" . $dimension->get_thickness() .
            "','" . $dimension->get_CreatedBy() .
            "','" . $dimension->get_ModifiedBy() .
            "')";
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getAlldimension()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM dimensions";

        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $dimensionList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $dimension = new dimension();
                $dimension->set_dimensionId($row['dimensionsId']);
                $dimension->set_dimensionName($row['dimensionsName']);
                $dimension->set_dimensionDescription($row["dimensionsDescription"]);
                $dimension->set_length($row["length"]);
                $dimension->set_breadth($row["breadth"]);
                $dimension->set_thickness($row["thickness"]);
                $dimension->set_createdby($row["createdBy"]);
                $dimension->set_modifiedby($row["modifiedBy"]);
                array_push($dimensionList, $dimension);
            }
        } else {
            // echo "0 results";
        }
        return $dimensionList;
    }

    public static function update($dimension)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE dimensions SET dimensionsName='" . $dimension->get_dimensionName() .
            "', dimensionsDescription='" . $dimension->get_dimensionDescription() .
            "', length='" . $dimension->get_length() .
            "', breadth='" . $dimension->get_breadth() .
            "', thickness='" . $dimension->get_thickness() .
            "', createdBy='" . $dimension->get_CreatedBy() .
            "', modifiedBy='" . $dimension->get_ModifiedBy() .
            "' WHERE dimensionsId=" . $dimension->get_dimensionId();

        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
    public static function selectdimensions()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT dimensionsId,dimensionsName FROM dimensions';
        $result = mysqli_query($db->getConnection(), $sql);
        $dimensionList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $dimension = new dimension();
                $dimension->set_dimensionId($row['dimensionsId']);
                $dimension->set_dimensionName($row['dimensionsName']);
                array_push($dimensionList, $dimension);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($dimensionList);
    }

    public static function delete($dimensionId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE from dimensions where dimensionId='" . $dimensionId . "'";
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}
