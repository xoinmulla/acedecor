<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

require "../Model/materialModel.php";
require "../Utilities/Sanitization.php";
require "../Utilities/Helper.php";
include "../DB Operations/materialOps.php";

/**
 * Helper to safely read POST inputs (sanitized)
 */
function post($key, $default = "")
{
    return isset($_POST[$key]) ? Sanitization::test_input($_POST[$key]) : $default;
}

/**
 * Send JSON response and exit
 */
function jsonResponse($data = [], $httpCode = 200)
{
    http_response_code($httpCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/* ======================================================
   FETCH MATERIAL INFO BY ID (GET)
====================================================== */
if (isset($_GET['matInfoId'])) {
    $matId = (int) $_GET['matInfoId'];
    DBmaterialdetails::getMaterialWithInwardHistory($matId);
}


/* ======================================================
   POST REQUESTS
====================================================== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ---------- UPDATE MATERIAL ----------
    if (isset($_POST["materialid"]) || isset($_POST["materialId"])) {

        $materialId = isset($_POST["materialid"]) ? (int) Sanitization::test_input($_POST["materialid"]) : (int) Sanitization::test_input($_POST["materialId"]);

        $details = new Material_Details();

        $details->set_MaterialId($materialId);
        $details->set_MaterialName(post("editedmaterialname"));
        $details->set_MaterialDescription(post("editedmaterialdescription"));

        $details->set_Brand(post("editedmaterialbrand"));
        $details->set_MaterialCode(post("editedmaterialCode"));

        $details->set_Category(post("editedmaterialCategory"));
        $details->set_SubCategory(post("editedsubCategory"));

        // Units / Factors / Grains / Thickness
        $details->set_MaterialUnit(post("editedunit"));
        $details->set_MaterialUnitId(post("editedunit"));

        $details->set_MaterialUnitFactor(post("editedunitFactor"));
        $details->set_MaterialUnitFactorId(post("editedunitFactor"));

        $details->set_MaterialGrains(post("editedRotation"));
        $details->set_MaterialGrainsId(post("editedRotation"));

        $details->set_MaterialThickness(post("editedthickness"));

        // Pricing
        $details->set_MaterialQty(post("editedmaterialQty"));
        $details->set_MaterialSPU(post("editedmaterialSPU"));
        $details->set_MaterialMRP(post("editedmaterialMRP"));
        $details->set_MaterialGST(post("editedmaterialGST"));

        $details->set_MaterialDiscount(post("editedmaterialDiscount"));
        $details->set_MaterialAmount(post("editedmaterialAmount"));
        $details->set_MaterialPrice(post("editedmaterialPrice"));
        $details->set_MaterialTotalValue(post("editedmaterialTotalValue"));

        $details->set_MaterialHSNcode(post("editedmaterialhsncode"));

        $details->set_MaterialCreatedBy(post("matcreatedby"));
        $details->set_MaterialModifiedBy(post("matmodifiedby"));

        // IMAGE UPDATE - only set if an image was uploaded
        if (!empty($_FILES["editedmaterialimage"]["name"])) {

            // New image uploaded
            Helper::fileupload($_FILES["editedmaterialimage"], "../img/materials/");
            $details->set_MaterialImage($_FILES["editedmaterialimage"]["name"]);

        } else {

            // No new image — keep old image
            $details->set_MaterialImage(post("existing_image"));
        }


        // Call DB update
        try {
            DBmaterialdetails::update($details);
            jsonResponse(["status" => "success", "message" => "Material updated successfully"]);
        } catch (Exception $e) {
            jsonResponse(["status" => "error", "message" => "Update failed: " . $e->getMessage()], 500);
        }
    }

    // ---------- DELETE MATERIAL ----------
    // Accept a few possible param names (id, materialId, materialid, hidden_id)
    $deleteId = null;
    if (isset($_POST['action']) && strtolower(trim($_POST['action'])) === 'delete') {
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $deleteId = (int) Sanitization::test_input($_POST['id']);
        } elseif (isset($_POST['materialId']) && $_POST['materialId'] !== '') {
            $deleteId = (int) Sanitization::test_input($_POST['materialId']);
        } elseif (isset($_POST['materialid']) && $_POST['materialid'] !== '') {
            $deleteId = (int) Sanitization::test_input($_POST['materialid']);
        } elseif (isset($_POST['hidden_id']) && $_POST['hidden_id'] !== '') {
            $deleteId = (int) Sanitization::test_input($_POST['hidden_id']);
        }

        if ($deleteId !== null) {
            try {
                DBmaterialdetails::delete($deleteId);
                jsonResponse(["status" => "success", "message" => "Material deleted"]);
            } catch (Exception $e) {
                jsonResponse(["status" => "error", "message" => "Delete failed: " . $e->getMessage()], 500);
            }
        } else {
            jsonResponse(["status" => "error", "message" => "No id provided for delete"], 400);
        }
    }

    // Also allow forms that send materialId without action (older code variants)
    if ((isset($_POST['materialId']) || isset($_POST['materialid'])) && !isset($_POST['editedmaterialname'])) {
        // if this POST is intended for delete but missing 'action', treat it as delete request
        $mid = isset($_POST['materialId']) ? (int) Sanitization::test_input($_POST['materialId']) : (int) Sanitization::test_input($_POST['materialid']);
        if ($mid) {
            try {
                DBmaterialdetails::delete($mid);
                jsonResponse(["status" => "success", "message" => "Material deleted"]);
            } catch (Exception $e) {
                jsonResponse(["status" => "error", "message" => "Delete failed: " . $e->getMessage()], 500);
            }
        }
    }

    // ---------- INSERT MATERIAL ----------
    // If code reaches here, it is an insert request
    $details = new Material_Details();

    $details->set_MaterialName(post("materialname"));
    $details->set_MaterialDescription(post("materialdescription"));

    $details->set_Brand(post("company"));
    $details->set_MaterialCode(post("materialCode"));
    $details->set_Category(post("materialCategory"));
    $details->set_SubCategory(post("materialsubCategory"));

    $details->set_MaterialUnit(post("materialunit"));
    $details->set_MaterialUnitId(post("materialunit"));

    $details->set_MaterialUnitFactor(post("materialunitFactor"));
    $details->set_MaterialUnitFactorId(post("materialunitFactor"));

    $details->set_MaterialGrains(post("materialGrains"));
    $details->set_MaterialGrainsId(post("materialGrains"));

    $details->set_MaterialThickness(post("thickness"));

    $details->set_MaterialQty(post("materialQty"));
    $details->set_MaterialSPU(post("materialSPU"));
    $details->set_MaterialMRP(post("materialMRP"));
    $details->set_MaterialGST(post("materialGST"));

    $details->set_MaterialDiscount(post("materialDiscount"));
    $details->set_MaterialAmount(post("materialAmount"));
    $details->set_MaterialPrice(post("materialPrice"));
    $details->set_MaterialTotalValue(post("materialTotalValue"));

    $details->set_MaterialHSNcode(post("materialhsncode"));

    $details->set_MaterialCreatedBy(post("materialcreatedby"));
    $details->set_MaterialModifiedBy(post("materialmodifiedby"));

    // IMAGE UPLOAD
    if (isset($_FILES["materialimage"]) && !empty($_FILES["materialimage"]["name"])) {
        Helper::fileupload($_FILES["materialimage"], "../img/materials/");
        $details->set_MaterialImage($_FILES["materialimage"]["name"]);
    }

    try {
        DBmaterialdetails::insert($details);
        jsonResponse(["status" => "success", "message" => "Material added successfully"]);
    } catch (Exception $e) {
        jsonResponse(["status" => "error", "message" => "Insert failed: " . $e->getMessage()], 500);
    }
}
if (isset($_GET['infomatid'])) {
    $matId = (int) $_GET['infomatid'];
    DBmaterialdetails::getMaterialFullDetailsById($matId);
    exit;
}

/* ======================================================
   GET Requests (filtered selects) — safe checks
====================================================== */
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $thicknessId = isset($_GET['thicknessId']) ? (int) $_GET['thicknessId'] : 0;
    $catId = isset($_GET['catId']) ? (int) $_GET['catId'] : 0;
    $subcatId = isset($_GET['subcatId']) ? (int) $_GET['subcatId'] : 0;
    $brandId = isset($_GET['brandId']) ? (int) $_GET['brandId'] : 0;
    $matId = isset($_GET['matId']) ? (int) $_GET['matId'] : 0;

    if ($thicknessId !== 0 && $catId !== 0 && $subcatId !== 0 && $brandId !== 0) {
        DBmaterialdetails::selectMaterialbasedonThicknessId($thicknessId, $catId, $subcatId, $brandId);
        exit;
    }

    if ($catId !== 0 && $subcatId !== 0 && $brandId !== 0 && $thicknessId === 0) {
        DBmaterialdetails::selectMaterialbasedonBrandCatSubcatId($catId, $subcatId, $brandId);
        exit;
    }

    // FULL MATERIAL DETAILS FOR QUOTATION
    if ($matId !== 0) {
        DBmaterialdetails::getMaterialFullDetailsById($matId);
        exit;
    }


    DBmaterialdetails::selectmaterial();
    exit;
}
?>