<?php
require_once("../DB Operations/generalSubcategoryOps.php");
require_once("../Utilities/Sanitization.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["action"]) && $_POST["action"] === "Add") {
        error_log("Received Add action for general subcategory.");
        if (empty($_POST["subcategory_name"])) {
            echo "empty";
            exit;
        }

        $name = Sanitization::test_input($_POST["subcategory_name"]);

        $result = DBGeneralSubcategory::add($name);

        echo $result ? "success" : "error";
        exit;
    }

    if ($_POST["action"] === "Edit") {
        $id = Sanitization::test_input($_POST["edit_id"]);
        $name = Sanitization::test_input($_POST["edit_subcategory_name"]);
        echo DBGeneralSubcategory::update($id, $name) ? "success" : "error";
        exit;
    }

    if ($_POST["action"] === "Delete") {
        $id = Sanitization::test_input($_POST["delete_id"]);
        echo DBGeneralSubcategory::delete($id) ? "success" : "error";
        exit;
    }
}
