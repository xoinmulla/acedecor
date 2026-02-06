<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/material_CategoryModel.php";
require_once "../Model/brand_matcat_mappingModel.php";
require_once "../DB Operations/brand_matcat_mappingOps.php";

class DBMaterialcategory
{
  public static function insert($materialcatObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // CHECK duplicate
    $sql = "SELECT * FROM material_category WHERE material_catName='" . $materialcatObj->get_materialCatname() . "'";
    $result = $connectionObj->query($sql);

    if (mysqli_num_rows($result) > 0) {
      return [
        "status" => "error",
        "message" => "Category already exists"
      ];
    }

    // INSERT CATEGORY
    $sql = "INSERT INTO material_category 
            (`material_catName`, `material_catDescription`, `material_catCreatedBy`, `material_catModifiedBy`)
            VALUES (
                '" . $materialcatObj->get_materialCatname() . "',
                '" . $materialcatObj->get_materialCatdescription() . "',
                '" . $materialcatObj->get_materialCatcreatedby() . "',
                '" . $materialcatObj->get_materialCatmodifiedby() . "'
            )";
    error_log($sql);
    if ($connectionObj->query($sql)) {

      $newId = $connectionObj->insert_id;

      // INSERT BRAND MAPPING IF ANY
      if (!empty($materialcatObj->get_brandList())) {
        foreach ($materialcatObj->get_brandList() as $brand) {
          $map = new MaterialcatBrandMappingModel();
          $map->set_materialcategoryId($newId);
          $map->set_brandId($brand);

          // Use consistent setter names for created/modified on mapping model
          if (method_exists($map, 'set_CreatedBy')) {
            $map->set_CreatedBy($materialcatObj->get_materialCatcreatedby());
          } elseif (method_exists($map, 'setCreatedBy')) {
            $map->setCreatedBy($materialcatObj->get_materialCatcreatedby());
          }

          if (method_exists($map, 'set_ModifiedBy')) {
            $map->set_ModifiedBy($materialcatObj->get_materialCatmodifiedby());
          } elseif (method_exists($map, 'setModifiedBy')) {
            $map->setModifiedBy($materialcatObj->get_materialCatmodifiedby());
          }

          DBMatcategoryBrandMapping::insert($map);
        }
      }

      // RETURN JSON-LIKE ARRAY
      return [
        "status" => "success",
        "newCategoryId" => $newId,
        "message" => "Category added successfully"
      ];
    }

    return [
      "status" => "error",
      "message" => "Database error: " . $connectionObj->error
    ];
  }

  public static function getallMaterialcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM material_category";

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $materialcatlist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_category();
        $view->set_materialcatId($row['material_catId']);
        $view->set_materialCatname($row['material_catName']);
        $view->set_materialCatdescription($row["material_catDescription"]);
        $view->set_materialCatcreatedby($row["material_catCreatedBy"]);
        $view->set_materialCatmodifiedby($row["material_catModifiedBy"]);
        array_push($materialcatlist, $view);
      }
      return $materialcatlist;
    } else {
      return [];
    }
  }

  public static function selectMatcategorybasedonBrandId($brandId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT MB.material_categoryId as material_categoryId,
                   B.brand_id as brandId,
                   M.material_catName as CategoryName
            FROM brand_matcat_mapping MB
            JOIN `brands` B on B.brand_id = MB.brandId
            JOIN `material_category` M on M.material_catId = MB.material_categoryId
            WHERE B.brand_id = $brandId
            GROUP BY CategoryName";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $materialcatdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_category();
        $view->set_materialcatId($row['material_categoryId']);
        $view->set_materialCatname($row['CategoryName']);
        array_push($materialcatdetailslist, $view);
      }
    }
    header('Content-Type: application/json');
    echo json_encode($materialcatdetailslist);
  }

  public static function update($catObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "UPDATE material_category SET material_catName='" . $catObj->get_materialCatname() .
      "', material_catDescription='" . $catObj->get_materialCatdescription() .
      "', material_catCreatedBy='" . $catObj->get_materialCatcreatedby() .
      "', material_catModifiedBy='" . $catObj->get_materialCatmodifiedby() .
      "' WHERE material_catId=" . $catObj->get_materialcatId();

    error_log($sql);

    if ($connectionObj->query($sql) === TRUE) {

      // Delete existing mappings for this material category
      if (method_exists('DBMatcategoryBrandMapping', 'delete')) {
        // Ensure we call the correct delete method name on your mapping ops
        DBMatcategoryBrandMapping::delete($catObj->get_materialcatId());
      }

      // Insert new mappings
      if (!empty($catObj->get_brandList())) {
        foreach ($catObj->get_brandList() as $brand) {
          $map = new MaterialcatBrandMappingModel();
          $map->set_materialcategoryId($catObj->get_materialcatId());
          $map->set_brandId($brand);

          if (method_exists($map, 'set_CreatedBy')) {
            $map->set_CreatedBy($catObj->get_materialCatcreatedby());
          } elseif (method_exists($map, 'setCreatedBy')) {
            $map->setCreatedBy($catObj->get_materialCatcreatedby());
          }

          if (method_exists($map, 'set_ModifiedBy')) {
            $map->set_ModifiedBy($catObj->get_materialCatmodifiedby());
          } elseif (method_exists($map, 'setModifiedBy')) {
            $map->setModifiedBy($catObj->get_materialCatmodifiedby());
          }

          DBMatcategoryBrandMapping::insert($map);
        }
      }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function selectMatcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $result = mysqli_query($db->getConnection(), 'SELECT material_catId, material_catName FROM material_category');
    $materialcatlist = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $view = new Material_category();
        $view->set_materialcatId($row['material_catId']);
        $view->set_materialCatname($row['material_catName']);
        array_push($materialcatlist, $view);
      }
    }
    header('Content-Type: application/json');
    echo json_encode($materialcatlist);
  }

  public static function delete($materialcatId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    /*
    -----------------------------------------
    1️⃣ CHECK: Category mapped in MATERIAL table
    -----------------------------------------
    */
    $checkSql = "SELECT COUNT(*) AS total FROM material WHERE Category = ?";
    $stmt = $connectionObj->prepare($checkSql);
    $stmt->bind_param("i", $materialcatId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['total'] > 0) {
      return "<div class='alert alert-danger'>
                    ❌ Cannot delete: Materials are linked to this category.
                </div>";
    }

    /*
    -----------------------------------------
    2️⃣ CHECK: Category mapped in SUBCATEGORY (material_subcategory)
    -----------------------------------------
    */
    $checkSubSql = "SELECT COUNT(*) AS total FROM material_subcategory WHERE material_catId = ?";
    $stmt2 = $connectionObj->prepare($checkSubSql);
    $stmt2->bind_param("i", $materialcatId);
    $stmt2->execute();
    $subResult = $stmt2->get_result()->fetch_assoc();

    if ($subResult['total'] > 0) {
      return "<div class='alert alert-danger'>
                    ❌ Cannot delete: Subcategories exist under this category.
                </div>";
    }

    /*
    -----------------------------------------
    3️⃣ DELETE brand mappings for this material category
    -----------------------------------------
    */
    if (method_exists('DBMatcategoryBrandMapping', 'delete')) {
      DBMatcategoryBrandMapping::delete($materialcatId);
    }

    /*
    -----------------------------------------
    4️⃣ DELETE the category itself
    -----------------------------------------
    */
    $deleteSql = "DELETE FROM material_category WHERE material_catId = ?";
    $delStmt = $connectionObj->prepare($deleteSql);
    $delStmt->bind_param("i", $materialcatId);

    if ($delStmt->execute()) {
      return "<div class='alert alert-success'>
                    ✔️ Category deleted successfully.
                </div>";
    } else {
      return "<div class='alert alert-danger'>
                    ❌ Failed to delete category.
                </div>";
    }
  }
  public static function canDelete($materialcatId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    // check material
    $q1 = $conn->prepare("SELECT COUNT(*) FROM material WHERE Category=?");
    $q1->bind_param("i", $materialcatId);
    $q1->execute();
    $q1->bind_result($c1);
    $q1->fetch();
    $q1->close();

    // check subcategory
    $q2 = $conn->prepare("SELECT COUNT(*) FROM material_subcategory WHERE material_catId=?");
    $q2->bind_param("i", $materialcatId);
    $q2->execute();
    $q2->bind_result($c2);
    $q2->fetch();
    $q2->close();

    return ($c1 == 0 && $c2 == 0);
  }

}
