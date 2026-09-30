<?php
require "../Model/unitsModel.php";
require "../Utilities/Sanitization.php";
include "../DB Operations/unitOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header('Content-Type: application/json');

    // ✅ UPDATE
    if (isset($_POST['unitId']) && !empty($_POST['unitId'])) {

        $unit = new unit();
        $unit->set_unitName(Sanitization::test_input($_POST["unitName"]));
        $unit->set_unitDescription(Sanitization::test_input($_POST["unitDescription"]));
        $unit->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
        $unit->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        $unit->set_unitId(Sanitization::test_input($_POST["unitId"]));

        if (DBunit::isUnitExists($unit->get_unitName(), $unit->get_unitId())) {
            echo json_encode([
                "status" => "error",
                "message" => "Unit name already exists."
            ]);
            exit;
        }

        DBunit::update($unit);

        echo json_encode([
            "status" => "success",
            "message" => "✅ Unit updated successfully"
        ]);
        exit;
    }

    // ✅ DELETE
    if (isset($_POST["action"]) && $_POST["action"] == 'delete') {
        DBunit::delete($_POST["id"]);
        exit;
    }

    // ✅ INSERT
    $unit = new unit();
    $unit->set_unitName(Sanitization::test_input($_POST["unitName"]));
    $unit->set_unitDescription(Sanitization::test_input($_POST["unitDescription"]));
    $unit->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $unit->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    if (DBunit::isUnitExists($unit->get_unitName())) {
        echo json_encode([
            "status" => "error",
            "message" => "Unit name already exists."
        ]);
        exit;
    }
    DBunit::insert($unit);

    echo json_encode([
        "status" => "success",
        "message" => "✅ Unit added successfully"
    ]);
    exit;

}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo DBunit::selectUnits();
}
exit;

