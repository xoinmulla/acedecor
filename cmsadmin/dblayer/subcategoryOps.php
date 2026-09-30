<?php
require_once "../dblayer/dbconnection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cmsadmin/model/subcategorymodel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cmsadmin/dblayer/categoryOps.php";

class DBsubcategory
{
    // Insert new subcategory
    public static function insert($subcatObj)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $sql = "INSERT INTO subcategory 
                (`subCategoryName`, `subCategoryDescription`, `subCategoryCreatedBy`, `subCategoryModifiedBy`) 
                VALUES (
                    '" . $subcatObj->getSubCategoryName() . "',
                    '" . $subcatObj->getSubCategoryDescription() . "',
                    '" . $subcatObj->getSubCategoryCreatedBy() . "',
                    '" . $subcatObj->getSubCategoryModifiedBy() . "'
                )";

        if ($conn->query($sql) === true) {
            $subcatId = $conn->insert_id;
            $mappedCategories = $subcatObj->getMappedCategories();

            // Insert category mapping and update HasSubcategory flag
            foreach ($mappedCategories as $catId) {
                $catId = intval($catId);
                $conn->query("INSERT INTO catsubcatmapping (`sucatId`, `catId`) VALUES ($subcatId, $catId)");
                DBcategory::setHasSubcategoryTrue($catId);
            }
        } else {
            error_log("Subcategory insert error: " . $conn->error);
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Update existing subcategory
    public static function update($subcatObj)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();

        $subcatId = intval($subcatObj->getSubCategoryId());
        $sql = "UPDATE subcategory SET
                    subCategoryName = '" . $subcatObj->getSubCategoryName() . "',
                    subCategoryDescription = '" . $subcatObj->getSubCategoryDescription() . "',
                    subCategoryModifiedBy = '" . $subcatObj->getSubCategoryModifiedBy() . "'
                WHERE subCategoryId = $subcatId";

        if ($conn->query($sql) === TRUE) {
            // 1️⃣ Get old mapped categories
            $oldCats = [];
            $res = $conn->query("SELECT catId FROM catsubcatmapping WHERE sucatId = $subcatId");
            while ($row = $res->fetch_assoc()) {
                $oldCats[] = $row['catId'];
            }

            // 2️⃣ Delete old mappings
            $conn->query("DELETE FROM catsubcatmapping WHERE sucatId = $subcatId");

            // 3️⃣ Insert new mappings
            $newCats = $subcatObj->getMappedCategories();
            foreach ($newCats as $catId) {
                $catId = intval($catId);
                $conn->query("INSERT INTO catsubcatmapping (`sucatId`, `catId`) VALUES ($subcatId, $catId)");
                DBcategory::setHasSubcategoryTrue($catId);
            }

            // 4️⃣ Reset HasSubcategory for old categories if they lost all subcategories
            foreach ($oldCats as $catId) {
                if (DBcategory::countSubCategories($catId) == 0) {
                    DBcategory::setHasSubcategoryFalse($catId);
                }
            }
        } else {
            error_log("Subcategory update error: " . $conn->error);
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Delete subcategory
    // Delete subcategory (with dependency check)
public static function delete($subcatId)
{
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();
    $subcatId = intval($subcatId);

    if ($subcatId <= 0) return;

    // 1️⃣ Check if subcategory is mapped with any post
    $postCheck = $conn->query("SELECT COUNT(*) AS cnt FROM postsubcatmapping WHERE subCatId = $subcatId");
    $postCount = $postCheck->fetch_assoc()['cnt'] ?? 0;

    // 2️⃣ Check if subcategory is mapped with any category
    $catCheck = $conn->query("SELECT COUNT(*) AS cnt FROM catsubcatmapping WHERE sucatId = $subcatId");
    $catCount = $catCheck->fetch_assoc()['cnt'] ?? 0;

    // 3️⃣ Prevent deletion if mapped
    if ($postCount > 0 || $catCount > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Cannot delete this subcategory because it is mapped with existing posts or categories."
        ]);
        return;
    }

    // 4️⃣ Safe to delete if not mapped
    $conn->query("DELETE FROM subcategory WHERE subCategoryId = $subcatId");

    if ($conn->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Subcategory deleted successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Subcategory not found or could not be deleted."
        ]);
    }
}


    // Get all subcategories
    public static function getAllSubCategory()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();
        $result = $conn->query("SELECT * FROM subcategory");

        $list = [];
        while ($row = $result->fetch_assoc()) {
            $subcat = new Subcategory();
            $subcat->setSubCategoryId($row['subCategoryId'])
                   ->setSubCategoryName($row['subCategoryName'])
                   ->setSubCategoryDescription($row['subCategoryDescription'])
                   ->setSubCategoryCreatedBy($row['subCategoryCreatedBy'])
                   ->setSubCategoryModifiedBy($row['subCategoryModifiedBy']);
            $list[] = $subcat;
        }
        return $list;
    }

    // Get mapped subcategories for a post (AJAX)
    public static function getMappedSubCategories($postId)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();
        $sql = "SELECT sub.subCategoryId, sub.subCategoryName,
                       CASE WHEN TEMP.postId IS NULL THEN FALSE ELSE TRUE END AS postId
                FROM subcategory AS sub
                LEFT JOIN (
                    SELECT p.postId AS postId,
                    M.subCatId AS subCatId
                    FROM post AS p
                    LEFT JOIN postsubcatmapping AS M ON p.postId = M.postId
                    WHERE p.postId = $postId
                ) AS TEMP
                ON sub.subCategoryId = TEMP.subCatId";
        $result = $conn->query($sql);
        error_log("getMappedSubCategories SQL: " . $sql);

        $list = [];
        while ($row = $result->fetch_assoc()) {
            $subcat = new Subcategory();
            $subcat->setSubCategoryId($row['subCategoryId'])
                   ->setSubCategoryName($row['subCategoryName'])
                   ->setMappedPost((bool)$row['postId']);
            // $list[] = $subcat;
            array_push($list, $subcat);
        }

        header('Content-Type: application/json');
        echo json_encode($list);
    }

    // Get subcategory by ID
    public static function getSubCategoryById($id)
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();
        $id = intval($id);

        $res = $conn->query("SELECT * FROM subcategory WHERE subCategoryId = $id");
        if ($row = $res->fetch_assoc()) {
            $subcat = new Subcategory();
            $subcat->setSubCategoryId($row['subCategoryId'])
                   ->setSubCategoryName($row['subCategoryName'])
                   ->setSubCategoryDescription($row['subCategoryDescription'])
                   ->setSubCategoryCreatedBy($row['subCategoryCreatedBy'])
                   ->setSubCategoryModifiedBy($row['subCategoryModifiedBy']);
            return $subcat;
        }
        return null;
    }

    // Get list of subcategories for select dropdown (AJAX)
    public static function selectsubcategory()
    {
        $db = ConnectDb::getInstance();
        $conn = $db->getConnection();
        $res = $conn->query("SELECT subCategoryId, subCategoryName FROM subcategory");

        $list = [];
        while ($row = $res->fetch_assoc()) {
            $subcat = new Subcategory();
            $subcat->setSubCategoryId($row['subCategoryId'])
                   ->setSubCategoryName($row['subCategoryName']);
            $list[] = $subcat;
        }

        header('Content-Type: application/json');
        echo json_encode($list);
    }
}
