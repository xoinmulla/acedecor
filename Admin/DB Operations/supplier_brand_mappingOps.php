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

    public static function getMappedBrands($supplierId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "
        SELECT B.brand_id AS Id,
               B.brand_name AS name,
               CASE WHEN SB.brandId IS NULL THEN 0 ELSE 1 END AS isMapped
        FROM brands B
        LEFT JOIN supplier_brand_mapping SB
               ON SB.brandId = B.brand_id
              AND SB.supplierId = $supplierId
    ";

        $result = $conn->query($sql);
        $brandlist = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $brand = new Brand();
            $brand->set_brandid($row["Id"]);
            $brand->set_brandname($row["name"]);
            $brand->set_isMapped((bool) $row["isMapped"]);

            // 🔒 NEW: check PO usage
            $isUsedInPO = DBsupplierBrandMapping::isBrandUsedInPO(
                $supplierId,
                $row["Id"]
            );

            $brand->set_isUsedInPO($isUsedInPO);

            $brandlist[] = $brand;
        }

        echo json_encode($brandlist);
    }
    public static function getExistingBrandIds($supplierId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "SELECT brandId FROM supplier_brand_mapping WHERE supplierId = $supplierId";
        $res = $conn->query($sql);

        $brands = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $brands[] = $row['brandId'];
        }
        return $brands;
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
    public static function isBrandUsedInPO($supplierId, $brandId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        // --- Item based PO ---
        $sqlItem = "
        SELECT 1
        FROM purchaseorder_lineitem PLI
        JOIN item_details I ON PLI.Item_id = I.item_id
        WHERE PLI.SupplierId = $supplierId
          AND I.item_compid = $brandId
        LIMIT 1
    ";

        $resItem = $conn->query($sqlItem);
        if ($resItem && $resItem->num_rows > 0) {
            return true;
        }

        // --- Material based PO ---
        $sqlMat = "
        SELECT 1
        FROM purchaseorder_lineitem PLI
        JOIN material M ON PLI.Item_id = M.Material_Id
        WHERE PLI.SupplierId = $supplierId
          AND M.Brand = $brandId
        LIMIT 1
    ";

        $resMat = $conn->query($sqlMat);
        if ($resMat && $resMat->num_rows > 0) {
            return true;
        }

        return false;
    }

}
