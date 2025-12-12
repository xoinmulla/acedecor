<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/material_subcategoryModel.php";

class DBMaterialsubcategory
{
  public static function insert($matsubcatObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // CHECK duplicate within same category
    $sql = "SELECT * FROM material_subcategory 
            WHERE material_subcatName = '" . $matsubcatObj->get_materialsubcatName() . "'
              AND material_catId = '" . $matsubcatObj->get_materialcatId() . "'";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
      // Keep parity with item_subcategory behavior (echo message; controller returns JSON)
      echo "SubCategory already exist";
      return;
    }

    $sql = "INSERT INTO material_subcategory 
            (`material_catId`,`material_subcatName`, `material_subcatDescription`,`material_subcatCreatedBy`,`material_subcatModifiedBy`) 
            VALUES (
              '" . $matsubcatObj->get_materialcatId() . "',
              '" . $matsubcatObj->get_materialsubcatName() . "',
              '" . $matsubcatObj->get_materialsubcaDescription() . "',
              '" . $matsubcatObj->get_materialsubcatCreatedby() . "',
              '" . $matsubcatObj->get_materialsubcatModifiedby() . "'
            )";
    error_log($sql);
    if ($connectionObj->query($sql) === true) {
      // success
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getallmatsubcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM material_subcategory AS MatsubCat
            JOIN material_category Matcat 
            ON MatsubCat.material_catId = Matcat.material_catId";

    $result = $connectionObj->query($sql);
    $materialsubcatlist = [];
    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Material_Subcategory();
        $view->set_materialcatName($row['material_catName']);
        $view->set_materialcatId($row['material_catId']);
        $view->set_materialsubcatId($row['material_subcatId']);
        $view->set_materialsubcatName($row['material_subcatName']);
        $view->set_materialsubcaDescription($row["material_subcatDescription"]);
        $view->set_materialsubcatCreatedby($row["material_subcatCreatedBy"]);
        $view->set_materialsubcatModifiedby($row["material_subcatModifiedBy"]);

        array_push($materialsubcatlist, $view);
      }
    }
    return $materialsubcatlist;
  }

  public static function update($subcatObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE material_subcategory SET
              material_catId = '" . $subcatObj->get_materialcatId() . "',
              material_subcatName = '" . $subcatObj->get_materialsubcatName() . "',
              material_subcatDescription = '" . $subcatObj->get_materialsubcaDescription() . "',
              material_subcatCreatedBy = '" . $subcatObj->get_materialsubcatCreatedby() . "',
              material_subcatModifiedBy = '" . $subcatObj->get_materialsubcatModifiedby() . "'
            WHERE material_subcatId = " . $subcatObj->get_materialsubcatId();
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
      // success
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function selectsubcategory($catid)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $result = mysqli_query($connectionObj, 'SELECT material_subcatId, material_subcatName FROM material_subcategory WHERE material_catId=' . intval($catid));
    $materialsubcatlist = [];
    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $view = new Material_Subcategory();
        $view->set_materialsubcatId($row['material_subcatId']);
        $view->set_materialsubcatName($row['material_subcatName']);
        array_push($materialsubcatlist, $view);
      }
    }
    header('Content-Type: application/json');
    echo json_encode($materialsubcatlist);
  }

  public static function delete($subCatId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // 1️⃣ Check if any materials are using this subcategory ID
    $checkSql = "SELECT COUNT(*) AS total FROM material WHERE SubCategory = ?";
    $stmt = $connectionObj->prepare($checkSql);
    $stmt->bind_param("i", $subCatId);
    $stmt->execute();
    $linked = intval($stmt->get_result()->fetch_assoc()['total']);
    $stmt->close();

    if ($linked > 0) {
      return "<div class='alert alert-danger'>
                    ❌ Cannot delete: Materials are linked to this SubCategory.
                </div>";
    }

    // 2️⃣ Safe delete
    $deleteSql = "DELETE FROM material_subcategory WHERE material_subcatId = ?";
    $del = $connectionObj->prepare($deleteSql);
    $del->bind_param("i", $subCatId);

    if ($del->execute()) {
      return "<div class='alert alert-success'>
                    ✔️ SubCategory deleted successfully.
                </div>";
    } else {
      return "<div class='alert alert-danger'>
                    ❌ Failed to delete SubCategory.
                </div>";
    }
  }

}
