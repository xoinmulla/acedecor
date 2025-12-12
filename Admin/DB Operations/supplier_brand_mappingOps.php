<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/brandmodel.php";
class DBsupplierBrandMapping
{
    public static function insert($obj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO supplier_brand_mapping (`supplierId`,
        `brandId`,
        `createdBy`,
    `modifiedBy`) 
                values ('" . $obj->get_supplierId() .
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
    
    public static function getMappedBrands($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT B.brand_id AS Id,
        B.brand_name AS name,
        CASE When TEMP.SupplierId is null then
        FALSE
        ELSE 
        TRUE
        end as supplierId
        FROM brands as B
        LEFT JOIN (SELECT S.item_compid as SupplierId,
        SB.brandId as brandId
        from
        item_companydetails as S 
        Left join supplier_brand_mapping as SB
        on
        S.item_compid=SB.supplierId 
        where S.item_compid=".$id.") as TEMP on B.brand_id=TEMP.brandId";
        error_log($sql);
        $result = mysqli_query($connectionObj, $sql);
        $brandlist = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $brand = new brand();
                $brand->set_brandid($row["Id"]);
                $brand->set_brandname($row["name"]);
                if (($row["supplierId"])==0) {
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
    public static function delete($id)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE FROM supplier_brand_mapping WHERE supplierId=" . $id;
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}
