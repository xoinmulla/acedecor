<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/inputTypeBrandMappingModel.php";


class DBInputTypeBrandMapping
{
    public static function insert($obj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO inputtype_brand_mapping (`InputTypeId`,
        `brandId`,
        `CreatedBy`,
    `ModifiedBy`) 
                values ('" . $obj->get_InputTypeId() .
            "','" . $obj->get_brandId() .
            "','" . $obj->get_CreatedBy() .
            "','" . $obj->get_ModifiedBy() .
            "')";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
    public static function getMappedInputType($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT B.brand_id AS Id,
        B.brand_name AS name,
        CASE When TEMP.InputTypeId is null then
        FALSE
        ELSE 
        TRUE
        end as InputtypeId
        FROM brands as B
        LEFT JOIN (SELECT I.InputTypeId as InputTypeId,
        IB.	brandId as 	brandId
        from 
        inputtype as I
        Left Join inputtype_brand_mapping as IB
       on
       I.InputTypeId=IB.InputTypeId	
       where I.InputTypeId=" . $id . ")as TEMP on B.brand_id=TEMP.brandId";
        error_log($sql);
        $result = mysqli_query($connectionObj, $sql);
        $brandlist = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $brand = new brand();
                $brand->set_brandid($row["Id"]);
                $brand->set_brandname($row["name"]);
                if (($row["InputtypeId"]) == 0) {
                    $brand->set_isMapped(false);
                } else {
                    $brand->set_isMapped(true);
                }
                array_push($brandlist, $brand);
            }
        } else {
            $sql = "SELECT B.brand_id AS Id, B.brand_name AS name FROM brands AS B";
            error_log($sql);
            $result = mysqli_query($connectionObj, $sql);
            $brandlist = [];
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $brand = new brand();
                    $brand->set_brandid($row["Id"]);
                    $brand->set_brandname($row["name"]);
                    $brand->set_isMapped(false);
                    array_push($brandlist, $brand);
                }
            }
        }
        echo json_encode($brandlist);
    }


    public static function update($brandObj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * from inputtype_brand_mapping where brandId=" . $brandObj->get_brandid() . " and InputTypeId=" . $brandObj->get_InputTypeId() . " ";
        error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        error_log($count);
        if ($count < 1) {
            $sql = "INSERT INTO inputtype_brand_mapping (`InputTypeId`,
            `brandId`,
            `CreatedBy`,
        `ModifiedBy`) 
                    values ('" . $brandObj->get_InputTypeId() .
                "','" . $brandObj->get_brandId() .
                "','" . $brandObj->get_CreatedBy() .
                "','" . $brandObj->get_ModifiedBy() .
                "')";
            error_log($sql);
            if ($connectionObj->query($sql) === true) {
            } else {
                echo "Error: " . $sql . "<br>" . $connectionObj->error;
            }

        } else {
            $sql = "UPDATE inputtype_brand_mapping SET InputTypeId='" . $brandObj->get_InputTypeId() .
                "' WHERE brandId=" . $brandObj->get_brandid();
            error_log($sql);
            if ($connectionObj->query($sql) === true) {
            } else {
                echo "Error: " . $sql . "<br>" . $connectionObj->error;
            }
        }

    }

    public static function delete($brandId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM inputtype_brand_mapping WHERE brandId = ?");
        $stmt->bind_param("i", $brandId);
        $stmt->execute();
        $stmt->close();
    }

    

}
