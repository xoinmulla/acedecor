<?php
require "../Model/designfilesModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/designFileOps.php";
require_once "../Utilities/Helper.php";

// helper to send JSON and exit
function jsonResponse($data)
{
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($data);
  exit;
}

// detect AJAX call
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Delete case
  if (isset($_POST["action"]) && $_POST["action"] === 'delete') {
    try {
      $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
      if ($id <= 0) {
        $resp = ['success' => false, 'message' => 'Invalid file id'];
      } else {
        DBdesignFile::delete($id);
        $resp = ['success' => true, 'message' => 'File deleted'];
      }
    } catch (Exception $ex) {
      error_log("DesignFile delete error: " . $ex->getMessage());
      $resp = ['success' => false, 'message' => 'Delete failed'];
    }

    if ($isAjax) {
      jsonResponse($resp);
    } else {
      header("Location: ../View/design.php?id=" . ($_POST['customerId'] ?? ''));
      exit;
    }
  }

  // Add / Insert case
  try {
    $designFile = new designFile();

    $customerId = Sanitization::test_input($_POST["customerId"] ?? '');
    $designFile->setCustomerId($customerId);

    // set designCategory id if provided
    if (isset($_POST['designCategory'])) {
      if (method_exists($designFile, 'setDesignCategory')) {
        $designFile->setDesignCategory(Sanitization::test_input($_POST["designCategory"]));
      }
    }

    $designFile->setDesignFileDescription(Sanitization::test_input($_POST["designFileDescription"] ?? ''));
    $designFile->setCreatedby(Sanitization::test_input($_POST["createdby"] ?? ''));
    $designFile->setModifiedby(Sanitization::test_input($_POST["modifiedby"] ?? ''));

    if (isset($_FILES["designFilePath"]) && $_FILES["designFilePath"]['error'] !== UPLOAD_ERR_NO_FILE) {
      $filetoupload = $_FILES["designFilePath"];
      // Helper::fileupload should move the file to ../img/Designs/ and return true/false (or at least not false)
      $uploaded = Helper::fileupload($filetoupload, "../img/Designs/");
      if ($uploaded === false) {
        throw new Exception("File upload failed.");
      }
      $designFile->setDesignFilePath(basename($filetoupload['name']));
    } else {
      throw new Exception("No file uploaded.");
    }

    // Insert into DB
    DBdesignFile::insert($designFile);

    $resp = ['success' => true, 'message' => 'Design file added'];
  } catch (Exception $ex) {
    error_log("DesignFile insert error: " . $ex->getMessage());
    $resp = ['success' => false, 'message' => 'Add failed: ' . $ex->getMessage()];
  }

  // Respond
  if ($isAjax) {
    jsonResponse($resp);
  } else {
    header("Location: ../View/design.php?id=" . ($customerId ?? ''));
    exit;
  }
}

// GET or other methods (if you need to return list as JSON)
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  if (isset($_GET['id'])) {
    $list = DBdesignFile::readAll(intval($_GET['id']));
    if ($isAjax) {
      jsonResponse(['success' => true, 'data' => $list]);
    } else {
      header("Location: ../View/design.php?id=" . intval($_GET['id']));
      exit;
    }
  }
}
?>
