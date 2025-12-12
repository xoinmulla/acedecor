<?php
require_once "dbconnection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/acedecor/cmsadmin/model/categoryModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/acedecor/cmsadmin/model/subcategorymodel.php";
class DBcategory
{
   // ✅ Insert New Category
    public static function insert($catObj)
        {
            $db = ConnectDb::getInstance();
            $connectionObj = $db->getConnection();
    
            // Check for duplicate categoryName
            $categoryName = $catObj->getCategoryName();
            $checkSql = "SELECT categoryId FROM category WHERE categoryName = ?";
            $checkStmt = $connectionObj->prepare($checkSql);
            if ($checkStmt === false) {
                error_log("Prepare failed (Check Duplicate): " . $connectionObj->error);
                return false;
            }
            $checkStmt->bind_param("s", $categoryName);
            $checkStmt->execute();
            $checkStmt->store_result();
            if ($checkStmt->num_rows > 0) {
                // Duplicate found
                error_log("Duplicate categoryName: " . $categoryName);
                return false;
            }
            $checkStmt->close();
    
            $sql = "INSERT INTO category 
                    (categoryName, categoryDescription, HasSubcategory, categoryCreatedBy, categorytModifiedBy, createdOn, modifiedOn) 
                    VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    
            $stmt = $connectionObj->prepare($sql);
            if ($stmt === false) {
                error_log("Prepare failed (Insert): " . $connectionObj->error);
                return false;
            }
    
            $categoryDescription = $catObj->getCategoryDescription();
            $hasSubcategory = $catObj->getHasSubcategory();
            $categoryCreatedBy = $catObj->getCategoryCreatedBy();
            $categoryModifiedBy = $catObj->getCategoryModifiedBy();
    
            $stmt->bind_param(
                "ssiss",
                $categoryName,
                $categoryDescription,
                $hasSubcategory,
                $categoryCreatedBy,
                $categoryModifiedBy
            );
    
            if (!$stmt->execute()) {
                error_log("Insert failed: " . $stmt->error);
                return false;
            }
    
            return $connectionObj->insert_id;
        }

  public static function getAllCategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM category ";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $categorylist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $category = new Category();
        $category->setCategoryId($row['categoryId']);
        $category->setCategoryName($row['categoryName']);
        $category->setCategoryDescription($row["categoryDescription"]);

        if ($row["HasSubcategory"] == 1) {
          $category->setHasSubcategory("true");
        } else {
          $category->setHasSubcategory("false");
        }
        $category->setCategoryCreatedBy($row["categoryCreatedBy"]);
        $category->setCategoryModifiedBy($row["categorytModifiedBy"]);
        $category->setMappedSubCategory(DBcategory::getMappedSubcategoryList($row['categoryId']));
        array_push($categorylist, $category);
      }
    } else {
      echo "";
    }
    return $categorylist;
  }
  public static function getMappedSubcategoryList($categoryId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM catsubcatmapping AS M 
    JOIN subcategory SC ON M.sucatId= SC.subCategoryId
    WHERE M.catId=" . $categoryId;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $subCategorylist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $subCategory = new Subcategory();
        $subCategory->setSubCategoryName($row['subCategoryName']);
        $subCategory->setSubCategoryId($row['subCategoryId']);
        $subCategory->setSubCategoryDescription($row["subCategoryDescription"]);

        $subCategory->setSubCategoryCreatedBy($row["subCategoryCreatedBy"]);
        $subCategory->setSubCategoryModifiedBy($row["subCategoryModifiedBy"]);
        array_push($subCategorylist, $subCategory);
      }
    } else {
      // echo "0 results";
    }

    return $subCategorylist;
  }

  public static function getMappedPostList($categoryId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM postcatmapping AS M 
    JOIN category SC ON M.catId= SC.CategoryId
    WHERE M.catId=" . $categoryId;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $Postlist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post = new Post();
        $post->setPostId($row['postId']);
        $post->setPostTitle($row["PostTitle"]);
        $post->setPostDescription($row["PostDescription"]);
        $post->setPostUrl($row["PostUrl"]);
        $post->setPostCreatedBy($row["PostCreatedBy"]);
        array_push($Postlist, $post);
      }
    } else {
      // echo "0 results";
    }

    return $Postlist;
  }
  public static function setHasSubcategoryTrue($categoryId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE category SET HasSubcategory = 1 WHERE categoryId = " . intval($categoryId);
    error_log($sql);
    if ($connectionObj->query($sql) !== TRUE) {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  // ✅ Update Category (without touching HasSubcategory!)
    public static function update($catObj)
{
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // Use proper column names
    $sql = "UPDATE category 
            SET categoryName = ?, 
                categoryDescription = ?, 
                HasSubcategory = ?, 
                categorytModifiedBy = ? 
            WHERE categoryId = ?";

    $stmt = $connectionObj->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $connectionObj->error);
        echo "Error: " . $connectionObj->error;
        return false;
    }

    $stmt->bind_param(
        "ssisi",
        $catObj->getCategoryName(),
        $catObj->getCategoryDescription(),
        $catObj->getHasSubcategory(),
        $catObj->getCategoryModifiedBy(),
        $catObj->getCategoryId()
    );

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        error_log("Update failed: " . $stmt->error);
        echo "Error: " . $stmt->error;
        return false;
    }
}

  public static function selectcategory()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();

        $sql = "SELECT * FROM category ORDER BY categoryId DESC";
        $result = $connectionObj->query($sql);
        error_log($sql);

        $categories = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $catObj = new Category();
                $catObj->setCategoryId($row["categoryId"]);
                $catObj->setCategoryName($row["categoryName"]);
                $catObj->setCategoryDescription($row["categoryDescription"]);
                $catObj->setHasSubcategory($row["HasSubcategory"]);
                $catObj->setCategoryCreatedBy($row["categoryCreatedBy"]);
                $catObj->setCategoryModifiedBy($row["categorytModifiedBy"]);
                array_push($categories, $catObj);

            }
        }
        header('Content-Type: application/json');
    echo json_encode($categories);

    }

  // ✅ Delete Category
    public static function delete($id)
{
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // 🔹 Step 1: Check if category has subcategories
    $sqlCheck = "SELECT COUNT(*) AS cnt FROM catsubcatmapping WHERE catId = ?";
    $stmtCheck = $connectionObj->prepare($sqlCheck);
    if ($stmtCheck === false) {
        error_log("Prepare failed (Check Subcategories): " . $connectionObj->error);
        return ["success" => false, "message" => "Internal error (check failed)."];
    }

    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();
    $row = $result->fetch_assoc();
    $stmtCheck->close();

    if (intval($row["cnt"]) > 0) {
        // Category has subcategories — block deletion
        return ["success" => false, "message" => "Cannot delete: Category has subcategories linked."];
    }

    // 🔹 Step 2: Safe to delete
    $sql = "DELETE FROM category WHERE categoryId = ?";
    $stmt = $connectionObj->prepare($sql);
    if ($stmt === false) {
        error_log("Prepare failed (Delete): " . $connectionObj->error);
        return ["success" => false, "message" => "Internal error (delete failed)."];
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        error_log("Delete failed: " . $stmt->error);
        return ["success" => false, "message" => "Database error during deletion."];
    }

    return ["success" => true, "message" => "Category deleted successfully."];
}


  public static function getMappedCategories($subCategoryId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT C.categoryName,
    C.categoryId, C.HasSubcategory, 
    CASE WHEN TEMP.subCatId IS NULL THEN
    FALSE
    ELSE
    TRUE 
    END AS subCatId 
    FROM category AS C 
    LEFT JOIN ( SELECT subC.subCategoryId AS subCatId, 
    M.catId AS catId from subcategory AS subC 
    LEFT JOIN catsubcatmapping AS M on subC.subCategoryId=M.sucatId 
    WHERE subC.subCategoryId=" . $subCategoryId . " ) AS TEMP ON C.categoryId= TEMP.catId";
    $result = mysqli_query($connectionObj, $sql);
    $itemcatlist = [];
    error_log(mysqli_num_rows($result));
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $category = new Category();
        $category->setCategoryId($row['categoryId']);
        $category->setCategoryName($row['categoryName']);
        $category->setMappedSubCategory($row['subCatId']);
        array_push($itemcatlist, $category);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($itemcatlist);
  }
  public static function  getPostMappedCategories($postId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT
    cat.CategoryId,
    cat.CategoryName,
    CASE WHEN TEMP.postId IS NULL THEN FALSE ELSE TRUE
END AS postId
FROM
    category AS cat
LEFT JOIN(
    SELECT
        p.postId AS postId,
        M.catId AS CatId
    FROM
        post AS p
    LEFT JOIN postcatmapping AS M
    ON
        p.postId = M.postId
        WHERE
       p.postId = " . $postId . "
) AS TEMP
ON
    cat.CategoryId = TEMP.catId";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $Categorylist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $Category = new category();
        $Category->setCategoryName($row['CategoryName']);
        $Category->setCategoryId($row['CategoryId']);
        $Category->setMappedPost($row["postId"]);
        array_push($Categorylist, $Category);
      }
    } else {
      // echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($Categorylist);
  }

public static function getCategoryHasSubCategory(){
  $db = ConnectDb::getInstance();
  $connectionObj = $db->getConnection();
  $sql = "SELECT * FROM category where HasSubcategory = 1";
  $result = $connectionObj->query($sql);
  $count = mysqli_num_rows($result);
  $categorylist = [];
  if ($count > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $category = new Category();
      $category->setCategoryId($row['categoryId']);
      $category->setCategoryName($row['categoryName']);
      $category->setCategoryDescription($row["categoryDescription"]);

      if ($row["HasSubcategory"] == 1) {
        $category->setHasSubcategory("true");
      } else {
        $category->setHasSubcategory("false");
      }
      $category->setCategoryCreatedBy($row["categoryCreatedBy"]);
      $category->setCategoryModifiedBy($row["categorytModifiedBy"]);
      $category->setMappedSubCategory(DBcategory::getMappedSubcategoryList($row['categoryId']));
      array_push($categorylist, $category);
    }
  } else {
    echo "";
  }
  return $categorylist;
}

  public static function getCategorydoesnthavesubcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM category where HasSubcategory = 0";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $categorylist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $category = new Category();
        $category->setCategoryId($row['categoryId']);
        $category->setCategoryName($row['categoryName']);
        $category->setCategoryDescription($row["categoryDescription"]);

        if ($row["HasSubcategory"] == 1) {
          $category->setHasSubcategory("true");
        } else {
          $category->setHasSubcategory("false");
        }
        $category->setCategoryCreatedBy($row["categoryCreatedBy"]);
        $category->setCategoryModifiedBy($row["categorytModifiedBy"]);
        $category->setMappedSubCategory(DBcategory::getMappedSubcategoryList($row['categoryId']));
        array_push($categorylist, $category);
      }
    } else {
      echo "";
    }
    return $categorylist;
  }
  public static function getAjaxCategorydoesnthavesubcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM category where HasSubcategory = 0";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $categorylist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $category = new Category();
        $category->setCategoryId($row['categoryId']);
        $category->setCategoryName($row['categoryName']);
        $category->setCategoryDescription($row["categoryDescription"]);

        if ($row["HasSubcategory"] == 1) {
          $category->setHasSubcategory("true");
        } else {
          $category->setHasSubcategory("false");
        }
        $category->setCategoryCreatedBy($row["categoryCreatedBy"]);
        $category->setCategoryModifiedBy($row["categorytModifiedBy"]);
        $category->setMappedSubCategory(DBcategory::getMappedSubcategoryList($row['categoryId']));
        array_push($categorylist, $category);
      }
    } else {
      echo "";
    }
    header('Content-Type: application/json');
    echo json_encode($categorylist);
  }
  public static function setHasSubcategoryFalse($categoryId)
{
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE category SET HasSubcategory = 0 WHERE categoryId = " . intval($categoryId);
    error_log($sql);
    if ($connectionObj->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
}
public static function countSubCategories($categoryId)
{
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT COUNT(*) AS cnt FROM catsubcatmapping WHERE catId = " . intval($categoryId);
    $result = $connectionObj->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        return intval($row['cnt']);
    }
    return 0;
}

}
