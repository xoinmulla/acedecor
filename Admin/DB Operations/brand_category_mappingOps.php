<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/brandmodel.php";
class DBcategoryBrandMapping
{
    public static function insert($obj)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO brand_category_mapping (`item_categoryId`,
        `brandId`,
        `createdBy`,
    `modifiedBy`) 
                values ('" . $obj->get_itemcategoryId() .
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
   

    public static function getMappedBrands($catId,$InputId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT B.brand_id AS Id,
        B.brand_name AS name,
        CASE WHEN TEMP.categoryId is NULL then 
        FALSE 
        ELSE 
        TRUE 
        end as categoryId
        from brands as B
        LEFT JOIN (Select C.item_catid as categoryId,
        CB.brandId as BrandId
        From
        item_category as C
        LEFT JOIN brand_category_mapping as CB
        on 
        C.item_catid=CB.item_categoryId
        where C.item_catid=".$catId." ) as TEMP on B.brand_id=TEMP.BrandId
        LEFT JOIN inputtype_brand_mapping as IB on IB.brandId=B.brand_id where IB.InputTypeId=".$InputId." 
        group by Id";
        error_log($sql);
        $result = mysqli_query($connectionObj, $sql);
        $brandlist = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $brand = new brand();
                $brand->set_brandid($row["Id"]);
                $brand->set_brandname($row["name"]);
                if (($row["categoryId"])==0) {
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
        $sql = "DELETE FROM brand_category_mapping WHERE item_categoryId=" . $id;
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}