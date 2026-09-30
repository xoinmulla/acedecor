<?php
require "../Model/unitFactorModel.php";
require "../Utilities/Sanitization.php";
require "../DB Operations/dbconnection.php";
include "../DB Operations/unitFactorOps.php";
include "../DB Operations/item_detailsOps.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    header('Content-Type: application/json');

    /* ==============================
       UPDATE UNIT FACTOR
    ============================== */
    if (isset($_POST['unitFactorId']) && empty($_POST['action'])) {

        $unitFactor = new unitFactor();
        $unitFactor->set_unitFactorId(Sanitization::test_input($_POST["unitFactorId"]));
        $unitFactor->set_unitFactorDescription(Sanitization::test_input($_POST["unitFactorDescription"]));
        $unitFactor->set_unitFactor(Sanitization::test_input($_POST["unitFactor"]));
        $unitFactor->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
        $unitFactor->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
        $unitFactor->set_unitId(Sanitization::test_input($_POST["unitId"]));
        if (
            DBunitFactor::isUnitFactorExists(
                $unitFactor->get_unitId(),
                $unitFactor->get_unitFactor(),
                $unitFactor->get_unitFactorId()
            )
        ) {

            echo json_encode([
                "status" => "error",
                "message" => "Unit Factor already exists for this Unit."
            ]);

            exit;
        }
        DBunitFactor::update($unitFactor);

        // Recalculate affected items
        DBitemdetails::recalculateItemsByUnitFactor(
            $unitFactor->get_unitFactorId(),
            $unitFactor->get_unitFactor()
        );

        echo json_encode([
            "status" => "success",
            "message" => "✅ Unit Factor updated successfully"
        ]);
        exit;
    }

    /* ==============================
       DELETE UNIT FACTOR
    ============================== */
    if (isset($_POST["action"]) && $_POST["action"] === "delete") {

        $unitFactorId = intval($_POST["id"]);

        $isMapped =
            DBunitFactor::isUnitFactorMappedToItemById($unitFactorId) ||
            DBunitFactor::isUnitFactorMappedToMaterialById($unitFactorId);

        if ($isMapped) {
            echo json_encode([
                "status" => "error",
                "message" => "❌ Unit Factor is already used in Item or Material"
            ]);
            exit;
        }

        DBunitFactor::delete($unitFactorId);

        echo json_encode([
            "status" => "success",
            "message" => "✅ Unit Factor deleted successfully"
        ]);
        exit;
    }

    /* ==============================
       INSERT UNIT FACTOR
    ============================== */
    $unitFactor = new unitFactor();
    $unitFactor->set_unitId(Sanitization::test_input($_POST["unitId"]));
    $unitFactor->set_unitFactorDescription(Sanitization::test_input($_POST["unitFactorDescription"]));
    $unitFactor->set_unitFactor(Sanitization::test_input($_POST["unitFactor"]));
    $unitFactor->set_CreatedBy(Sanitization::test_input($_POST["createdby"]));
    $unitFactor->set_ModifiedBy(Sanitization::test_input($_POST["modifiedby"]));
    if (
        DBunitFactor::isUnitFactorExists(
            $unitFactor->get_unitId(),
            $unitFactor->get_unitFactor()
        )
    ) {

        echo json_encode([
            "status" => "error",
            "message" => "Unit Factor already exists for this Unit."
        ]);

        exit;
    }
    DBunitFactor::insert($unitFactor);

    echo json_encode([
        "status" => "success",
        "message" => "✅ Unit Factor added successfully"
    ]);
    exit;
}

/* ==============================
   GET UNIT FACTORS (AJAX)
============================== */
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    DBunitFactor::selectUnitsFactor($_GET["unitId"] ?? null);
    exit;
}
