<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/designfilesModel.php";
class DBdesignFile
{
    public static function insert($designFile)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        // NOTE: using simple concatenation as in original; consider prepared statements to avoid SQL injection
        $sql = "INSERT INTO designimages (`customerId`, `designCategory`, `designFilePath`, `designDescription`, `createdby`, `modifiedby`)
                VALUES (
                    '" . $designFile->getCustomerId() . "',
                    '" . $designFile->getDesignCategory() . "',
                    '" . $designFile->getDesignFilePath() . "',
                    '" . $designFile->getDesignFileDescription() . "',
                    '" . $designFile->getCreatedby() . "',
                    '" . $designFile->getModifiedby() . "'
                )";
        error_log($sql);
        if ($connectionObj->query($sql) === true) {
            // success
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function delete($designFileId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE FROM designimages WHERE designImgId=" . intval($designFileId);
        if ($connectionObj->query($sql) === true) {
            // success
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function readAll($customerId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "SELECT d.*, c.enq_cat_name 
            FROM designimages d
            LEFT JOIN enquiry_category c 
               ON d.designCategory = c.enq_catid
            WHERE d.customerId = $customerId
            ORDER BY d.designCategory, d.designImgId";

        $result = $connectionObj->query($sql);

        $grouped = [];

        while ($row = mysqli_fetch_assoc($result)) {

            $catId = $row['designCategory'];
            $catName = $row['enq_cat_name'] ?: "Uncategorized";

            if (!isset($grouped[$catId])) {
                $grouped[$catId] = [
                    "catName" => $catName,
                    "images" => []
                ];
            }

            $grouped[$catId]["images"][] = [
                "id" => $row['designImgId'],
                "path" => $row['designFilePath'],
                "desc" => $row['designDescription']
            ];
        }

        return $grouped;
    }



}
?>