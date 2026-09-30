<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/item_categorymodel.php";
require_once "../Model/brand_category_mappingModel.php";
require_once "../DB Operations/brand_category_mappingOps.php";

class DBitemcategory
{
  public static function insert($itemcatObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // CHECK duplicate
    if (self::isCategoryExists($itemcatObj->get_itemcatname())) {

      return [
        "status" => "error",
        "message" => "Category already exists."
      ];

    }

    // INSERT CATEGORY
    $sql = "INSERT INTO item_category 
            (`item_catName`, `item_catDescription`, `item_catCreatedby`, `item_catModifiedby`)
            VALUES (
                '" . $itemcatObj->get_itemcatname() . "',
                '" . $itemcatObj->get_itemcatdescription() . "',
                '" . $itemcatObj->get_itemcatcreatedby() . "',
                '" . $itemcatObj->get_itemcatmodifiedby() . "'
            )";

    if ($connectionObj->query($sql)) {

      $newId = $connectionObj->insert_id;

      // INSERT BRAND MAPPING IF ANY
      if (!empty($itemcatObj->get_brandList())) {
        foreach ($itemcatObj->get_brandList() as $brand) {
          $map = new categoryBrandMappingModel();
          $map->set_itemcategoryId($newId);
          $map->set_brandId($brand);
          $map->set_CreatedBy($itemcatObj->get_itemcatcreatedby());
          $map->set_ModifiedBy($itemcatObj->get_itemcatmodifiedby());
          DBcategoryBrandMapping::insert($map);
        }
      }

      // RETURN JSON RESPONSE
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

  public static function isCategoryExists($categoryName, $categoryId = 0)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $categoryName = mysqli_real_escape_string($connectionObj, trim($categoryName));

    $sql = "SELECT item_catid
            FROM item_category
            WHERE LOWER(TRIM(item_catName)) = LOWER(TRIM('$categoryName'))";

    if ($categoryId > 0) {
      $sql .= " AND item_catid != " . (int) $categoryId;
    }

    $result = $connectionObj->query($sql);

    return mysqli_num_rows($result) > 0;
  }


  public static function getallItemcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "
SELECT 
    IC.*,
    (
        SELECT COUNT(*) FROM item_details ID WHERE ID.item_catid = IC.item_catid
    ) AS itemCount,
    (
        SELECT COUNT(*) FROM item_subcategory ISB WHERE ISB.item_catid = IC.item_catid
    ) AS subCatCount
FROM item_category IC
";


    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemcatlist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Category();
        $view->set_itemcatid($row['item_catid']);
        $view->set_itemcatname($row['item_catName']);
        $view->set_itemcatdescription($row["item_catDescription"]);
        $view->set_itemcatcreatedby($row["item_catCreatedBy"]);
        $view->set_itemcatmodifiedby($row["item_catModifiedBy"]);

        $canDelete = ($row['itemCount'] == 0 && $row['subCatCount'] == 0);
        $view->set_canDelete($canDelete);

        array_push($itemcatlist, $view);


      }
      return $itemcatlist;
    } else {
      // echo "0 results";
    }
  }

  public static function selectcategorybasedonBrandId($brandId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT CB.item_categoryId as item_categoryId,
    B.brand_id as brandId,
    I.item_catName as CategoryName
     FROM brand_category_mapping CB
     Join `brands`B on B.brand_id=CB.brandId
     Join `item_category` I on I.item_catid=CB.item_categoryId
     where B.brand_id =$brandId 
     group by CategoryName";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemcatdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Category();
        $view->set_itemcatid($row['item_categoryId']);
        $view->set_itemcatname($row['CategoryName']);
        array_push($itemcatdetailslist, $view);
      }
    } else {
      // echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($itemcatdetailslist);
  }

  public static function update($catObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE item_category SET item_catName='" . $catObj->get_itemcatname() .
      "', item_catDescription='" . $catObj->get_itemcatdescription() .
      "', item_catCreatedBy='" . $catObj->get_itemcatcreatedby() .
      "', item_catModifiedBy='" . $catObj->get_itemcatmodifiedby() .
      "' WHERE item_catid=" . $catObj->get_itemcatid();
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
      DBcategoryBrandMapping::delete($catObj->get_itemcatid());
      foreach ($catObj->get_brandList() as $brand) {
        $map = new categoryBrandMappingModel();
        $map->set_itemcategoryId($catObj->get_itemcatid());
        $map->set_brandId($brand);
        DBcategoryBrandMapping::insert($map);
      }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function selectcategory()
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $result = mysqli_query($db->getConnection(), 'SELECT item_catid,item_catName FROM item_category');
    $itemcatlist = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $view = new Item_Category();
        $view->set_itemcatid($row['item_catid']);
        $view->set_itemcatname($row['item_catName']);
        array_push($itemcatlist, $view);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($itemcatlist);
  }

  public static function delete($itemcatId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    /*
    -----------------------------------------
    1️⃣ CHECK: Category mapped in inventory
    -----------------------------------------
    */
    $checkSql = "SELECT COUNT(*) AS total FROM item_details WHERE item_catid = ?";
    $stmt = $connectionObj->prepare($checkSql);
    $stmt->bind_param("i", $itemcatId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['total'] > 0) {
      return "<div class='alert alert-danger'>
                    ❌ Cannot delete: Inventory items are linked to this category.
                </div>";
    }

    /*
    -----------------------------------------
    2️⃣ CHECK: Category mapped in SUBCATEGORY
    -----------------------------------------
    */
    $checkSubSql = "SELECT COUNT(*) AS total FROM item_subcategory WHERE item_catid = ?";
    $stmt2 = $connectionObj->prepare($checkSubSql);
    $stmt2->bind_param("i", $itemcatId);
    $stmt2->execute();
    $subResult = $stmt2->get_result()->fetch_assoc();

    if ($subResult['total'] > 0) {
      return "<div class='alert alert-danger'>
                    ❌ Cannot delete: Subcategories exist under this category.
                </div>";
    }

    /*
    -----------------------------------------
    3️⃣ DELETE brand mappings for category
    -----------------------------------------
    */
    DBcategoryBrandMapping::delete($itemcatId);

    /*
    -----------------------------------------
    4️⃣ DELETE category
    -----------------------------------------
    */
    $deleteSql = "DELETE FROM item_category WHERE item_catid = ?";
    $delStmt = $connectionObj->prepare($deleteSql);
    $delStmt->bind_param("i", $itemcatId);

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



}