<?php
// require "../../Admin/fpdf182/fpdf.php";
   class Helper
   {
      public static function fileupload($filetoupload, $directoryToStore)
{
    $target_dir = $directoryToStore;
    $target_file = $target_dir . basename($filetoupload["name"]);
    $uploadOk = 1;

    // First check if tmp_name is set and file uploaded successfully
    if (!isset($filetoupload["tmp_name"]) || $filetoupload["tmp_name"] == "" || $filetoupload["error"] !== UPLOAD_ERR_OK) {
        echo "No valid file uploaded.";
        return false;
    }

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or a document
    if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif", "webp"])) {
        $check = getimagesize($filetoupload["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not a valid image.";
            $uploadOk = 0;
        }
    } elseif ($imageFileType === "pdf" || $imageFileType === "docx") {
        $source_file = $filetoupload['tmp_name'];
        $target_file = $directoryToStore . $filetoupload['name'];

        if (file_exists($target_file)) {
            unlink($target_file);
        }
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($filetoupload["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($filetoupload["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
}