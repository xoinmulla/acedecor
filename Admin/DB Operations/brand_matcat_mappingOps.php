<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/brandmodel.php";
class DBMatcategoryBrandMapping
{
    public static function insert($obj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO brand_matcat_mapping (`material_categoryId`,
        `brandId`,
        `createdBy`,
    `modifiedBy`) 
                values ('" . $obj->get_materialcategoryId() .
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
    public static function getMappedBrands($matcatId, $InputId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "SELECT 
                B.brand_id AS Id,
                B.brand_name AS name,
                CASE 
                    WHEN TEMP.BrandId IS NULL THEN 0
                    ELSE 1
                END AS isMapped
            FROM brands AS B
            LEFT JOIN (
                SELECT 
                    MB.brandId AS BrandId
                FROM brand_matcat_mapping AS MB
                WHERE MB.material_categoryId = $matcatId
            ) AS TEMP ON B.brand_id = TEMP.BrandId
            LEFT JOIN inputtype_brand_mapping AS IB 
                ON IB.brandId = B.brand_id 
            WHERE IB.InputTypeId = $InputId
            GROUP BY Id";

        $result = mysqli_query($connectionObj, $sql);
        $brandlist = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $brand = [
                "brandid" => $row["Id"],
                "brandname" => $row["name"],
                "isMapped" => (int) $row["isMapped"]
            ];
            $brandlist[] = $brand;
        }

        echo json_encode($brandlist);
    }

    public static function delete($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        // Correct table for deleting brand-material-category mapping
        $sql = "DELETE FROM brand_matcat_mapping WHERE material_categoryId = " . $id;
        error_log($sql);

        if (!$connectionObj->query($sql)) {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

}