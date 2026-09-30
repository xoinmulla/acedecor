<?php
require_once "../Model/brandmodel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/brandOps.php";
require_once "../DB Operations/supplier_brand_mappingOps.php";
require_once "../DB Operations/brand_category_mappingOps.php";
require_once "../DB Operations/brand_matcat_mappingOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ---------------------------
    // DELETE BRAND
    // ---------------------------
    if (isset($_POST["action"]) && $_POST["action"] == 'delete') {

        $id = $_POST["id"];

        // Block delete if mapped
        // ❌ Block delete if brand is used in Inventory
        // ❌ Block delete if Brand is mapped with Item Category
        if (DBbrand::isMappedInItemCategory($id)) {
            echo "<div class='alert alert-danger'>Brand is mapped with Item Category, cannot delete</div>";
            exit;
        }
        if (DBbrand::isMappedInInventory($id)) {
            echo "<div class='alert alert-danger'>Brand is used in Inventory, cannot delete</div>";
            exit;
        }
        if (DBbrand::delete($id)) {
            echo "<div class='alert alert-success alert-dismissible fade show'>
            <strong>Success!</strong> Brand deleted successfully.
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
          </div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show'>
            <strong>Error!</strong> Unable to delete brand.
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
          </div>";
        }
        exit;
    }

    // ---------------------------
    // UPDATE BRAND (editbrand_form)
    // ---------------------------
    if (isset($_POST['editBrandId'])) {

        $brand = new Brand();

        $brand->set_brandid(Sanitization::test_input($_POST["editBrandId"]));
        $brand->set_brandname(Sanitization::test_input($_POST["brandname"]));
        $brand->set_brandcreatedby(Sanitization::test_input($_POST["brandcreatedby"]));
        $brand->set_brandmodifiedby(Sanitization::test_input($_POST["brandmodifiedby"]));

        if (!empty($_POST["inputtype_list"])) {
            $brand->set_inputTypeList($_POST["inputtype_list"]);
        }

        DBbrand::update($brand);

        echo json_encode(["status" => "success", "message" => "Brand updated successfully"]);
        exit;
    }

    // ---------------------------
    // INSERT BRAND (Add Brand)
    // ---------------------------
    else {

        $brand = new Brand();

        $brand->set_brandname(Sanitization::test_input($_POST["brandname"]));
        $brand->set_brandcreatedby(Sanitization::test_input($_POST["brandcreatedby"]));
        $brand->set_brandmodifiedby(Sanitization::test_input($_POST["brandmodifiedby"]));

        // Detect request origin
        $origin = isset($_POST['origin']) ? Sanitization::test_input($_POST['origin']) : '';

        if ($origin === 'inventory') {
            // Insert without mappings
            DBbrand::insertWithoutMappings($brand);

            // Return JSON (only here)
            echo json_encode([
                "status" => "success",
                "message" => "Brand added successfully!",
                "newBrandId" => $brand->get_brandid()
            ]);
            exit;
        }

        // Else → Brand Management Page: accept inputtype_list (if any)
        if (!empty($_POST["inputtype_list"])) {
            $brand->set_inputTypeList($_POST["inputtype_list"]);
        }

        // Use DBbrand::insert() which now returns result array
        $result = DBbrand::insert($brand);

        // Return JSON once (controller is authoritative)
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }


}

// ---------------------------
// GET Requests
// ---------------------------
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['id'])) {
        DBsupplierBrandMapping::getMappedBrands($_GET['id']);
        exit;
    } else if (isset($_GET['catId'], $_GET['InputId'])) {
        DBcategoryBrandMapping::getMappedBrands($_GET['catId'], $_GET['InputId']);
        exit;
    } else if (isset($_GET['matcatId'], $_GET['InputId'])) {
        DBMatcategoryBrandMapping::getMappedBrands($_GET['matcatId'], $_GET['InputId']);
        exit;
    } else if (isset($_GET['inputId'])) {
        DBInputTypeBrandMapping::getMappedInputType($_GET['inputId']);
        exit;
    } else if (isset($_GET['projId'])) {
        DBbrand::selectbrandsbasedonProjId(Sanitization::test_input($_GET['projId']));
        exit;
    } else if (isset($_GET['itemId'])) {
        DBbrand::selectbrandsbasedonItemId(Sanitization::test_input($_GET['itemId']));
        exit;
    } else if (isset($_GET['categoryId'])) {
        DBbrand::selectbrandsbasedonCategoryId(Sanitization::test_input($_GET['categoryId']));
        exit;
    } else if (isset($_GET['supplierId'])) {
        DBbrand::selectbrandsbasedonSupplierId(Sanitization::test_input($_GET['supplierId']));
        exit;
    } else if (isset($_GET['matcatId'])) {
        DBbrand::selectbrandsbasedonMatcatId(Sanitization::test_input($_GET['matcatId']));
        exit;
    } else if (isset($_GET['InputId'])) {
        DBbrand::selectbrandsbasedonInputTypeId(Sanitization::test_input($_GET['InputId']));
        exit;
    } else if (isset($_GET['action']) && $_GET['action'] === 'inventoryTypes' && isset($_GET['brandId'])) {
        header('Content-Type: application/json');
        DBbrand::getInventoryTypesByBrand(
            Sanitization::test_input($_GET['brandId'])
        );
        exit;
    }

    // ✅ ONLY ADDITION — SAFE DEFAULT (NO PARAMS)
    header('Content-Type: application/json');
    DBbrand::selectbrands();
    exit;
}

?>