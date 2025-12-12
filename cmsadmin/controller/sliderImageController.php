<?php
require "../model/sliderImageModel.php";
require "../Utilities/Sanitization.php";
require "../Utilities/Helper.php";
require "../dblayer/sliderImageOps.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // ---------- DELETE ----------
    if (isset($_POST["action"]) && $_POST["action"] === 'delete') {
        $id = intval($_POST["id"]);
        if (DBsliderImageFile::delete($id)) {
            echo "<div class='alert alert-success'>Image deleted successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to delete image</div>";
        }
        exit;
    }

    // ---------- ADD ----------
    if (isset($_POST["action"]) && $_POST["action"] === 'Add') {
        $designFile = new sliderImage();

        // $designFile->setImageFileCaption(Sanitization::test_input($_POST["designFileDescription"]));
        $designFile->setCreatedby(Sanitization::test_input($_POST["createdby"]));
        $designFile->setModifiedby(Sanitization::test_input($_POST["modifiedby"]));
        $designFile->setImageAlternateText(Sanitization::test_input($_POST["alternateText"]));
        $designFile->setPostId(intval($_POST["postId"]));

        // Handle file upload
        if (!empty($_FILES["designFilePath"]["name"])) {
            $designFile->setImage($_FILES["designFilePath"]["name"]);
            $filetoupload = $_FILES["designFilePath"];
           Helper::fileupload($filetoupload, "../img/Slider/");
            
        }
        $designFile->setFileType($_POST["fileType"]);

        if ($_POST["fileType"] === "image") {
            if (!empty($_FILES["designFilePath"]["name"])) {
                $designFile->setImage($_FILES["designFilePath"]["name"]);
                $filetoupload = $_FILES["designFilePath"];
                Helper::fileupload($filetoupload, "../img/Slider/");
            }
            $designFile->setVideoUrl(null);
            $designFile->setVideoFile(null);

        } elseif ($_POST["fileType"] === "video") {
            // Case 1: YouTube/Vimeo URL
            if (!empty($_POST["videoUrl"])) {
                $designFile->setVideoUrl(Sanitization::test_input($_POST["videoUrl"]));
                $designFile->setVideoFile(null);
            }
            // Case 2: Local MP4 upload
            elseif (!empty($_FILES["videoFile"]["name"])) {
                $designFile->setVideoFile($_FILES["videoFile"]["name"]);
                $filetoupload = $_FILES["videoFile"];
                Helper::fileupload($filetoupload, "../img/Slider/");
                $designFile->setVideoUrl(null);
            }
            $designFile->setImage(null);
        }


        DBsliderImageFile::insert($designFile);
        header("Location: ../views/sliderImage.php?postId=" . intval($_POST["postId"]));    
           
    }
}

// ---------- GET (optional API) ----------
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['id'])) {
        $images = DBsliderImageFile::readAll();
        header('Content-Type: application/json');
        echo json_encode($images);
        exit;
    }
}
