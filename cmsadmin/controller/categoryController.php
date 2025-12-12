<?php
require "../model/categoryModel.php";
require "../Utilities/Sanitization.php";
include "../dblayer/categoryOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $category = new Category();
    $category->setCategoryName(Sanitization::test_input($_POST["itemcatname"] ?? ""));
    $category->setCategoryDescription(Sanitization::test_input($_POST["itemcatdescription"] ?? ""));
    $category->setCategoryCreatedBy(Sanitization::test_input($_POST["itemcatcreatedby"] ?? ""));
    $category->setCategoryModifiedBy(Sanitization::test_input($_POST["itemcatmodifiedby"] ?? ""));

    // Delete category
if (isset($_POST["action"]) && $_POST["action"] === 'delete') {
    if (isset($_POST["id"])) {
        $id = intval(Sanitization::test_input($_POST["id"]));
        $result = DBCategory::delete($id);

        // ✅ If request came via AJAX, send JSON response
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }

        // ✅ If normal form POST, handle redirect with message
        if (!$result['success']) {
            echo "<script>alert('" . $result['message'] . "'); window.location='../views/category.php';</script>";
        } else {
            header("location:../views/category.php");
        }
        exit;
    }
}

    // Update category
    elseif (!empty($_POST['itemcatid'])) {
        $categoryId = intval(Sanitization::test_input($_POST["itemcatid"]));
        $category->setCategoryId($categoryId);

        // 🔹 Fetch current subcategory count for HasSubcategory
        $category->setHasSubcategory(DBCategory::countSubCategories($categoryId) > 0 ? 1 : 0);

        DBCategory::update($category);
    }
    // Insert new category
    else {
        $category->setHasSubcategory(0);
        DBCategory::insert($category);
    }

    header("location:../views/category.php");
    exit;
}

// GET requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["subCatId"])) {
        DBCategory::getMappedCategories($_GET["subCatId"]);
    } elseif (isset($_GET["postId"])) {
        DBCategory::getPostMappedCategories($_GET["postId"]);
    } elseif (isset($_GET["HasSubcategory"])) {
        DBCategory::getAjaxCategorydoesnthavesubcategory();
    } else {
        DBCategory::selectcategory();
    }
}
?>
