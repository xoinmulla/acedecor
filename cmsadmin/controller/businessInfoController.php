<?php
ob_start(); // Prevent header issues

require "../model/businessModel.php";
require "../Utilities/Sanitization.php";
require "../DBlayer/businessOps.php";
require "../Utilities/Helper.php";
require_once("../../vendor/autoload.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ================= ADD BUSINESS MEDIA SLIDE =================
    if (isset($_POST['action']) && $_POST['action'] === 'AddMedia') {
        $businessId = Sanitization::test_input($_POST['businessId']);
        $mediaType  = Sanitization::test_input($_POST['mediaType']);
        $caption    = Sanitization::test_input($_POST['caption']);
        $videoUrl   = null;
        $fileName   = null;

        if ($mediaType === 'image' && isset($_FILES["mediaFile"]) && !empty($_FILES["mediaFile"]["name"])) {
            $filetoupload = $_FILES["mediaFile"];
            Helper::fileupload($filetoupload, "../img/Slider/");
            $fileName = $_FILES["mediaFile"]["name"];
        }

        if ($mediaType === 'video') {
            if (!empty($_FILES["mediaFile"]["name"])) {
                $filetoupload = $_FILES["mediaFile"];
                Helper::fileupload($filetoupload, "../img/Slider/");
                $fileName = $_FILES["mediaFile"]["name"];
            } elseif (!empty($_POST['videoUrl'])) {
                $videoUrl = Sanitization::test_input($_POST['videoUrl']);
            }
        }

        DBbusiness::addBusinessMedia($businessId, $mediaType, $fileName, $videoUrl, $caption);
        header("Location: ../views/business.php");
        exit;
    }

    // ================= NORMAL BUSINESS INSERT / UPDATE =================
    if (isset($_POST['companyId']) || isset($_POST['companyname'])) {
        $business = new Business();

        // If editing
        if (isset($_POST['companyId']) && !empty($_POST['companyId'])) {
            $business->setBusinessId(Sanitization::test_input($_POST["companyId"]));
        }

        // Basic fields (safe optional access)
        $business->setBusinessName(Sanitization::test_input($_POST["companyname"] ?? ""));
        $business->setBusinessContact(Sanitization::test_input($_POST["companycontact"] ?? ""));
        $business->setBusinessContact2(Sanitization::test_input($_POST["companycontact2"] ?? ""));
        $business->setBusinessEmail(Sanitization::test_input($_POST["companyemail"] ?? ""));
        $business->setBusinessTag(Sanitization::test_input($_POST["companytag"] ?? ""));
        $business->setBusinessAddress(Sanitization::test_input($_POST["companyaddress"] ?? ""));
        $business->setBusinessGSTIN(Sanitization::test_input($_POST["companyGSTIN"] ?? ""));

        // About section from Quill editor
        $quill_json = $_POST['hidden_element'] ?? '';
        $result = '';
        if (!empty($quill_json)) {
            try {
                $quill = new DBlackborough\Quill\Render(trim($quill_json), 'HTML');
                $result = $quill->render();
            } catch (Exception $e) {
                error_log("Quill render error: " . $e->getMessage());
            }
        }
        $business->setBusinessAboutBusiness(Sanitization::test_input($result));

        // Upload business logo
        if (isset($_FILES["logoImage"]) && !empty($_FILES["logoImage"]["name"])) {
            $filetoupload = $_FILES["logoImage"];
            Helper::fileupload($filetoupload, "../img/");
            $business->setBusinessLogoImage($_FILES["logoImage"]['name']);
        }

        // --- About section fields ---
        $business->setAboutHeader(Sanitization::test_input($_POST["aboutHeader"] ?? ""));
        $business->setAboutSubheading(Sanitization::test_input($_POST["aboutSubheading"] ?? ""));
        $business->setAboutTitle(Sanitization::test_input($_POST["aboutTitle"] ?? ""));

        // Upload about image
        if (isset($_FILES["aboutImage"]) && !empty($_FILES["aboutImage"]["name"])) {
            $filetoupload = $_FILES["aboutImage"];
            Helper::fileupload($filetoupload, "../img/");
            $business->setAboutImage($_FILES["aboutImage"]['name']);
        }

        // Decide Insert or Update
        if (!empty($business->getBusinessId())) {
            DBbusiness::update($business);
        } else {
            DBbusiness::insert($business);
        }
    }

} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    // ================= DELETE MEDIA =================
    if (isset($_GET['deleteMediaId'])) {
        DBbusiness::deleteBusinessMedia($_GET['deleteMediaId']);
        header("Location: ../views/business.php");
        exit;
    }
}

// Default redirect
header("Location: ../views/business.php");
ob_end_flush();
exit;
?>
