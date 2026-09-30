<?php
require_once "../Model/thicknessModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/thicknessOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header('Content-Type: application/json');

    if (isset($_POST['editedThicknessId'])) {
        $thickness = new Thickness();
        $thickness->set_Thickness(
            Sanitization::test_input($_POST["editedThickness"])
        );

        $thickness->set_ThicknessId(
            Sanitization::test_input($_POST["editedThicknessId"])
        );

        $thickness->set_Thicknesscreatedby(
            Sanitization::test_input($_POST["editedThicknesscreatedby"])
        );

        $thickness->set_Thicknessmodifiedby(
            Sanitization::test_input($_POST["editedThicknessmodifiedby"])
        );
        if (
            DBthickness::isThicknessExists(
                $thickness->get_Thickness(),
                $thickness->get_ThicknessId()
            )
        ) {

            echo json_encode([
                "status" => "error",
                "message" => "Thickness already exists."
            ]);
            exit;
        }

        DBthickness::update($thickness);

        echo json_encode([
            "status" => "success",
            "message" => "Thickness updated successfully."
        ]);
        exit;
    } else if ($_POST["action"] == 'delete') {
        DBthickness::delete($_POST["id"]);

        echo json_encode([
            "status" => "success",
            "message" => "Thickness deleted successfully."
        ]);
        exit;
    } else {
        $thickness = new Thickness();
        $thickness->set_Thickness(Sanitization::test_input($_POST["Thickness"]));
        $thickness->set_Thicknesscreatedby(Sanitization::test_input($_POST["Thicknesscreatedby"]));
        $thickness->set_Thicknessmodifiedby(Sanitization::test_input($_POST["Thicknessmodifiedby"]));
        if (
            DBthickness::isThicknessExists(
                $thickness->get_Thickness()
            )
        ) {

            echo json_encode([
                "status" => "error",
                "message" => "Thickness already exists."
            ]);
            exit;
        }

        DBthickness::insert($thickness);

        echo json_encode([
            "status" => "success",
            "message" => "Thickness added successfully."
        ]);
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    DBthickness::selectThickness();
}

?>