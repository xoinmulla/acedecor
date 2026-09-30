<?php
ob_clean();
error_reporting(E_ALL);
ini_set('display_errors', 1);


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
    DBmaterialdetails::getMaterialWithInwardHistory((int) $_GET['matInfoId']);
    return;
}


/* ======================================================
   CHECK MATERIAL DELETE POSSIBILITY (AJAX)
====================================================== */
/* ======================================================
   CHECK MATERIAL DELETE POSSIBILITY (AJAX)
====================================================== */
if (isset($_GET['checkDelete'], $_GET['id'])) {

    $id = (int) $_GET['id'];

    if (DBmaterialdetails::isUsedInQuotation($id)) {
        jsonResponse([
            "blocked" => true,
            "message" => "❌ Cannot delete: Material is used in Quotation"
        ]);
    }

    if (DBmaterialdetails::isUsedInPO($id)) {
        jsonResponse([
            "blocked" => true,
            "message" => "❌ Cannot delete: Material is used in Purchase Order"
        ]);
    }

    if (DBmaterialdetails::getPendingPOQty($id) > 0) {
        jsonResponse([
            "blocked" => true,
            "message" => "❌ Cannot delete: Material has pending Purchase Orders"
        ]);
    }

    // ✅ ONLY CHECK — NEVER DELETE HERE
    jsonResponse([
        "blocked" => false
    ]);
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

            if (
                DBmaterialdetails::isDuplicateMaterialForUpdate(
                    $materialId,
                    post("editedmaterialname"),
                    post("editedmaterialbrand"),
                    post("editedmaterialCategory"),
                    post("editedsubCategory")
                )
            ) {

                jsonResponse([
                    "status" => "error",
                    "message" => "Material already exists with the same Name, Brand, Category and Subcategory."
                ]);
            }

            DBmaterialdetails::update($details);

            jsonResponse([
                "status" => "success",
                "message" => "Material updated successfully"
            ]);

        } catch (Exception $e) {

            jsonResponse([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);

        }
    }

    // ---------- DELETE MATERIAL ----------
    /* ======================================================
    DELETE MATERIAL (POST ONLY)
 ====================================================== */
    if (
        $_SERVER["REQUEST_METHOD"] === "POST"
        && isset($_POST['action'])
        && $_POST['action'] === 'delete'
    ) {

        $id = (int) $_POST['id'];

        if (DBmaterialdetails::isUsedInQuotation($id)) {
            jsonResponse([
                "blocked" => true,
                "message" => "❌ Material is already used in Quotation"
            ]);
        }

        if (DBmaterialdetails::isUsedInPO($id)) {
            jsonResponse([
                "blocked" => true,
                "message" => "❌ Material is already used in Purchase Order"
            ]);
        }

        DBmaterialdetails::delete($id);   // ✅ DELETE ONLY HERE

        jsonResponse([
            "status" => "success",
            "message" => "Material deleted successfully"
        ]);
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

        if (
            DBmaterialdetails::isDuplicateMaterial(
                post("materialname"),
                post("company"),
                post("materialCategory"),
                post("materialsubCategory")
            )
        ) {

            jsonResponse([
                "status" => "error",
                "message" => "Material already exists with the same Name, Brand, Category and Subcategory."
            ]);
        }

        DBmaterialdetails::insert($details);

        jsonResponse([
            "status" => "success",
            "message" => "Material added successfully"
        ]);

    } catch (Exception $e) {

        jsonResponse([
            "status" => "error",
            "message" => "Insert failed : " . $e->getMessage()
        ], 500);

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
// if ($_SERVER["REQUEST_METHOD"] === "GET" && empty($_GET)) {
//     $thicknessId = isset($_GET['thicknessId']) ? (int) $_GET['thicknessId'] : 0;
//     $catId = isset($_GET['catId']) ? (int) $_GET['catId'] : 0;
//     $subcatId = isset($_GET['subcatId']) ? (int) $_GET['subcatId'] : 0;
//     $brandId = isset($_GET['brandId']) ? (int) $_GET['brandId'] : 0;
//     $matId = isset($_GET['matId']) ? (int) $_GET['matId'] : 0;

//     if ($thicknessId !== 0 && $catId !== 0 && $subcatId !== 0 && $brandId !== 0) {
//         DBmaterialdetails::selectMaterialbasedonThicknessId($thicknessId, $catId, $subcatId, $brandId);
//         exit;
//     }

//     if ($catId !== 0 && $subcatId !== 0 && $brandId !== 0 && $thicknessId === 0) {
//         DBmaterialdetails::selectMaterialbasedonBrandCatSubcatId($catId, $subcatId, $brandId);
//         exit;
//     }

//     // FULL MATERIAL DETAILS FOR QUOTATION
//     if ($matId !== 0) {
//         DBmaterialdetails::getMaterialFullDetailsById($matId);
//         exit;
//     }


//     DBmaterialdetails::selectmaterial();
//     exit;
// }

/* ======================================================
   GET: MATERIAL LIST FOR PURCHASE ORDER
====================================================== */
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $catId = isset($_GET['catId']) ? (int) $_GET['catId'] : 0;
    $subcatId = isset($_GET['subcatId']) ? (int) $_GET['subcatId'] : 0;
    $brandId = isset($_GET['brandId']) ? (int) $_GET['brandId'] : 0;

    if ($catId && $subcatId && $brandId) {
        DBmaterialdetails::selectMaterialbasedonBrandCatSubcatId(
            $catId,
            $subcatId,
            $brandId
        );
        exit;
    }
}

?>