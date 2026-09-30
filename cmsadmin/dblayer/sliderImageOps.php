<?php
require_once "dbconnection.php";
require_once __DIR__ . "/../model/sliderImageModel.php";

class DBsliderImageFile {

    // Insert new slider image
    public static function insert($sliderImageFile) {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "INSERT INTO sliderimages (
            `image`, 
            `imageCaption`,
            `alternatetext`, 
            `createdBy`, 
            `modifiedBY`,
            `postId`,
            `fileType`,
            `videoUrl`,
            `videoFile`
            
        ) VALUES (
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getImage()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getImageFileCaption()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getImageAlternateText()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getCreatedby()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getModifiedby()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getPostId()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getFileType()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getVideoUrl()) . "',
            '" . $connectionObj->real_escape_string((string)$sliderImageFile->getVideoFile()) . "'
        )";
  error_log("Insert SQL: " . $sql);
        if ($connectionObj->query($sql) === true) {
            return true;
        } else {
            error_log("Insert Error: " . $connectionObj->error);
            return false;
        }
    }

    // Delete image by ID
   public static function delete($designFileId) {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // Fetch file name before deleting
    $sqlSelect = "SELECT image, videoFile FROM sliderimages WHERE imageId=" . intval($designFileId);
    $result = $connectionObj->query($sqlSelect);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['image']) && file_exists(__DIR__ . "/../img/Slider/" . $row['image'])) {
            unlink(__DIR__ . "/../img/Slider/" . $row['image']);
        }
        if (!empty($row['videoFile']) && file_exists(__DIR__ . "/../img/Slider/" . $row['videoFile'])) {
            unlink(__DIR__ . "/../img/Slider/" . $row['videoFile']);
        }
    }

    // Delete record from DB
    $sqlDelete = "DELETE FROM sliderimages WHERE imageId=" . intval($designFileId);
    if ($connectionObj->query($sqlDelete) === true) {
        return true;
    } else {
        error_log("Delete Error: " . $connectionObj->error);
        return false;
    }
}


    // Fetch all images
    public static function readAll() {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM sliderimages ORDER BY imageId DESC";
        $result = $connectionObj->query($sql);

        $designFileList = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $designFile = new sliderImage();
                $designFile->setImageFileId($row['imageId']);
                $designFile->setImage($row["image"]);
                $designFile->setImageFileCaption($row["imageCaption"]);
                $designFile->setImageAlternateText($row["alternatetext"]);
                $designFile->setCreatedby($row["createdBy"]);
                $designFile->setModifiedby($row["modifiedBY"]);
                $designFile->setFileType($row["fileType"]);
                $designFile->setVideoUrl($row["videoUrl"]);
                $designFile->setVideoFile($row["videoFile"]);

                $designFileList[] = $designFile;
            }
        }
        return $designFileList;
    }

    public static function readByPostId($id) {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM sliderimages WHERE postId=".$id." ORDER BY imageId DESC";
        error_log("SQL Query: " . $sql);
        $result = $connectionObj->query($sql);

        $designFileList = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $designFile = new sliderImage();
                $designFile->setImageFileId($row['imageId']);
                $designFile->setImage($row["image"]);
                $designFile->setImageFileCaption($row["imageCaption"]);
                $designFile->setImageAlternateText($row["alternatetext"]);
                $designFile->setCreatedby($row["createdBy"]);
                $designFile->setModifiedby($row["modifiedBY"]);
                $designFile->setFileType($row["fileType"]);
                $designFile->setVideoUrl($row["videoUrl"]);
                $designFile->setVideoFile($row["videoFile"]);

                $designFileList[] = $designFile;
            }
        }
        return $designFileList;
    }
}
