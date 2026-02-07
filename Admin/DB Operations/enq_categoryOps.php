<?php
require_once __DIR__ . "/../DB Operations/dbconnection.php";
require_once __DIR__ . "/../Model/enq_categorymodel.php";


class DBcategory
{
  public static function insert($enqcatObj)
  {
    if (
      self::existsByNameAndType(
        $enqcatObj->get_catname(),
        $enqcatObj->get_catType()
      )
    ) {
      $_SESSION['error'] = "⚠️ Category already exists for this type";
      return false;
    }

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "INSERT INTO enquiry_category 
        (enq_cat_name, enq_cat_type, enq_cat_createdby, enq_cat_modifiedby)
        VALUES (?, ?, ?, ?)"
    );

    // ✅ ASSIGN TO VARIABLES FIRST
    $name = $enqcatObj->get_catname();
    $type = $enqcatObj->get_catType();
    $createdBy = $enqcatObj->get_catcreatedby();
    $modifiedBy = $enqcatObj->get_catModifiedby();

    // ✅ NOW bind (variables only)
    $stmt->bind_param(
      "ssss",
      $name,
      $type,
      $createdBy,
      $modifiedBy
    );

    return $stmt->execute();
  }
  public static function selectAllForDisplay()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM enquiry_category";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $catlist = [];

    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Category();
        $view->set_catid($row['enq_catid']);
        $view->set_catname($row['enq_cat_name']);
        $view->set_catType($row['enq_cat_type']);  // <-- added
        array_push($catlist, $view);
      }
    }

    return $catlist;
  }
  public static function selectall()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM enquiry_category";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $catlist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Category();
        $view->set_catid($row['enq_catid']);
        $view->set_catname($row['enq_cat_name']);
        array_push($catlist, $view);
      }
    } else {
      // echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($catlist);
  }
  public static function update($enqCat)
  {
    if (
      self::existsByNameAndTypeExceptId(
        $enqCat->get_catname(),
        $enqCat->get_catType(),
        $enqCat->get_catid()
      )
    ) {
      $_SESSION['error'] = "⚠️ Duplicate category not allowed";
      return false;
    }

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "UPDATE enquiry_category SET
            enq_cat_name = ?,
            enq_cat_type = ?,
            enq_cat_modifiedby = ?
         WHERE enq_catid = ?"
    );

    // ✅ VARIABLES
    $name = $enqCat->get_catname();
    $type = $enqCat->get_catType();
    $modifiedBy = $enqCat->get_catModifiedby();
    $id = $enqCat->get_catid();

    $stmt->bind_param(
      "sssi",
      $name,
      $type,
      $modifiedBy,
      $id
    );

    return $stmt->execute();
  }
  public static function delete($id)
  {
    // 🔒 Block delete if category is used in enquiry
    if (self::isCategoryUsed($id)) {
      $_SESSION['error'] = "⚠️ Cannot delete category. It is already used in enquiries.";
      return false;
    }

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    // safe delete
    $conn->query("DELETE FROM enq_cat_mapping WHERE cat_id = '$id'");
    $conn->query("DELETE FROM enquiry_category WHERE enq_catid = '$id'");

    return true;
  }

  public static function selectDesignCategories()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT enq_catid, enq_cat_name 
            FROM enquiry_category 
            WHERE enq_cat_type = 'Design'";

    $result = $connectionObj->query($sql);
    $catlist = [];

    while ($row = mysqli_fetch_assoc($result)) {
      $catlist[] = $row;
    }

    return $catlist;
  }
  public static function selectEnquiryCategories()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT enq_catid, enq_cat_name 
            FROM enquiry_category 
            WHERE enq_cat_type = 'Enquiry Category'";

    $result = $connectionObj->query($sql);
    $catlist = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $catlist[] = [
          "CatId" => $row['enq_catid'],
          "catname" => $row['enq_cat_name']
        ];
      }
    }

    header('Content-Type: application/json');
    echo json_encode($catlist);
  }
  public static function existsByNameAndType($name, $type)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "SELECT enq_catid FROM enquiry_category 
         WHERE enq_cat_name = ? AND enq_cat_type = ?"
    );
    $stmt->bind_param("ss", $name, $type);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
  }
  public static function existsByNameAndTypeExceptId($name, $type, $id)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "SELECT enq_catid FROM enquiry_category 
         WHERE enq_cat_name = ? 
         AND enq_cat_type = ?
         AND enq_catid != ?"
    );
    $stmt->bind_param("ssi", $name, $type, $id);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
  }
  public static function isCategoryUsed($catId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "SELECT 1 FROM enq_cat_mapping WHERE cat_id = ? LIMIT 1"
    );
    $stmt->bind_param("i", $catId);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
  }

}
