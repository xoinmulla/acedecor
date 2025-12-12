<?php
// require "../../Admin/fpdf182/fpdf.php";
class Helper
{
    public static function fileupload($filetoupload, $directoryToStore)
    {
        $target_dir = rtrim($directoryToStore, '/') . '/';
        $fileName = basename($filetoupload["name"]);
        $target_file = $target_dir . $fileName;

        // Allowed file types
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'docx'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            return false; // ❌ invalid file
        }

        // If file already exists, delete it
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        // Move file
        if (move_uploaded_file($filetoupload["tmp_name"], $target_file)) {
            return true;  // ✅ success
        }

        return false; // ❌ upload failed
    }
}
