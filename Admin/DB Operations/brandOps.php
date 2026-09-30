<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/brandmodel.php";
require_once "../Model/inputTypeBrandMappingModel.php";
require_once "../DB Operations/InputType_Brand_MappingOps.php";
class DBbrand
{
  public static function insert($brandObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // Escape input
    $brand_name = mysqli_real_escape_string($connectionObj, $brandObj->get_brandname());
    $brand_createdby = mysqli_real_escape_string($connectionObj, $brandObj->get_brandcreatedby());
    $brand_modifiedby = mysqli_real_escape_string($connectionObj, $brandObj->get_brandmodifiedby());

    // 🔍 CHECK IF BRAND NAME EXISTS
    $checkSql = "SELECT COUNT(*) FROM brands WHERE brand_name = ?";
    $checkStmt = $connectionObj->prepare($checkSql);
    $checkStmt->bind_param("s", $brand_name);
    $checkStmt->execute();
    $checkStmt->bind_result($exists);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($exists > 0) {
      return [
        "status" => "error",
        "message" => "Brand name already exists!",
        "newBrandId" => null
      ];
    }

    // Prepared insert
    $stmt = $connectionObj->prepare(
      "INSERT INTO brands (`brand_name`, `brand_createdby`, `brand_modifiedby`) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $brand_name, $brand_createdby, $brand_modifiedby);

    if ($stmt->execute()) {
      $lastInsertedId = $connectionObj->insert_id;

      // InputType mappings
      $inputList = $brandObj->get_inputTypeList();
      if (!empty($inputList) && is_array($inputList)) {
        foreach ($inputList as $inputType) {
          $map = new InputTypeBrandMappingModel();
          $map->set_brandId($lastInsertedId);
          $map->set_inputTypeId($inputType);
          $map->set_ModifiedBy($brand_modifiedby);
          $map->set_CreatedBy($brand_createdby);
          DBInputTypeBrandMapping::insert($map);
        }
      }

      return [
        "status" => "success",
        "message" => "Brand added successfully!",
        "newBrandId" => $lastInsertedId
      ];

    } else {
      return [
        "status" => "error",
        "message" => "Database insert failed: " . $stmt->error,
        "newBrandId" => null
      ];
    }
  }


  public static function getAllbrands()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM  brands";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $brandList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $brand = new brand();
        $brand->set_brandid($row["brand_id"]);
        $brand->set_brandname($row["brand_name"]);
        array_push($brandList, $brand);
      }
    }
    return $brandList;
  }

  public static function update($brandObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "UPDATE brands SET 
                brand_name='" . $brandObj->get_brandname() . "',
                brand_createdby='" . $brandObj->get_brandcreatedby() . "',
                brand_modifiedby='" . $brandObj->get_brandmodifiedby() . "'
            WHERE brand_id=" . $brandObj->get_brandid();

    error_log($sql);

    if ($connectionObj->query($sql) === TRUE) {

      $brandId = $brandObj->get_brandid();

      // ---------------------------------------
      // ✅ 1️⃣ DELETE OLD INPUT-TYPE MAPPINGS
      // ---------------------------------------
      DBInputTypeBrandMapping::delete($brandId);

      // ---------------------------------------
      // ✅ 2️⃣ INSERT NEW INPUT-TYPE MAPPINGS
      // ---------------------------------------
      foreach ($brandObj->get_inputTypeList() as $inputTypeId) {

        $map = new InputTypeBrandMappingModel();
        $map->set_brandId($brandId);
        $map->set_inputTypeId($inputTypeId);
        $map->set_ModifiedBy($brandObj->get_brandmodifiedby());
        $map->set_CreatedBy($brandObj->get_brandcreatedby());

        DBInputTypeBrandMapping::insert($map);
      }

    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }


  public static function delete($brandId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "DELETE FROM brands WHERE brand_id = ?";
    $stmt = $connectionObj->prepare($sql);
    $stmt->bind_param("i", $brandId);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      echo "Error: " . $stmt->error;
      $stmt->close();
      return false;
    }
  }


  public static function selectbrands()
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $result = mysqli_query($db->getConnection(), 'SELECT brand_id,brand_name FROM brands');
    $brandlist = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $view = new Brand();
        $view->set_brandid($row['brand_id']);
        $view->set_brandname($row['brand_name']);
        array_push($brandlist, $view);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($brandlist);
  }



  public static function selectbrandsbasedonProjId($projId)
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT I.item_id AS ItemId,
      I.item_name AS ItemName,
      I.item_compid AS CompanyId,
      B.brand_name AS BrandName,
      B.brand_id AS BrandId,
      QLI.itemId as QuoteItemId,
      QLI.quantity as ReqItemQuantity,
      Q.quoteId as QuoteId,
      Q.quoteCode As quoteCode,
      PR.quoteId as ProjectQuoteId
      FROM item_details I 
      JOIN brands B ON I.item_compid=B.brand_id
      JOIN quotelineitem QLI ON I.item_name=QLI.InputName
      JOIN quotation_details Q ON Q.quoteId=QLI.quoteId
      JOIN projects PR ON PR.quoteId=Q.quoteCode
      where PR.projectId=$projId
       group by BrandName
       UNION
       SELECT M.Material_Id  AS ItemId,
      M.Material_Name AS ItemName,
     M.Brand AS CompanyId,
      B.brand_name AS BrandName,
      B.brand_id AS BrandId,
      QLI.itemId as QuoteItemId,
      QLI.quantity as ReqItemQuantity,
      Q.quoteId as QuoteId,
      Q.quoteCode As quoteCode,
      PR.quoteId as ProjectQuoteId
      FROM material M 
      JOIN brands B ON M.Brand=B.brand_id
      JOIN quotelineitem QLI ON M.Material_Id =QLI.itemId
      JOIN quotation_details Q ON Q.quoteId=QLI.quoteId
      JOIN projects PR ON PR.quoteId=Q.quoteCode
      where PR.projectId='" . $projId . "'
       group by BrandName";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Brand();

        $view->set_brandname($row['BrandName']);
        $view->set_brandid($row["BrandId"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  public static function selectbrandsbasedonItemId($itemId)
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT I.item_id AS ItemId,
      I.item_name AS ItemName,
      I.item_catid AS CategoryId,
      C.item_catName AS CategoryName,
      I.item_subcatid AS SubCategoryId,
      SC.item_subcatName AS SubCategoryName,
      I.item_compid AS CompanyId,
      B.brand_name AS BrandName,
      B.brand_id AS BrandId
   
      FROM item_details I 
      JOIN item_category C ON I.item_catid=C.item_catid 
      JOIN item_subcategory SC ON I.item_subcatid=SC.item_subcatid 
      JOIN brands B ON I.item_compid=B.brand_id
      where I.item_id=$itemId ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Brand();

        $view->set_brandname($row['BrandName']);
        $view->set_brandid($row["BrandId"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  public static function selectbrandsbasedonCategoryId($categoryId)
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
      C.item_catName AS CategoryName,
      C.item_catid  as CategoryId,
      B.brand_name AS BrandName,
      B.brand_id AS BrandId,
      CB.brandId as MappedId,
      CB.item_categoryId as MappedCatId

      FROM item_category C
      JOIN brand_category_mapping CB on  CB.item_categoryId=C.item_catid
      JOIN brands B ON CB.brandId=B.brand_id
      where C.item_catid =$categoryId 
      group by BrandName ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Brand();

        $view->set_brandname($row['BrandName']);
        $view->set_brandid($row["BrandId"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  public static function selectbrandsbasedonSupplierId($supplierid)
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
      S.item_compid AS SupplierId,
      S.	item_compName AS SupplierName,
      B.brand_name AS BrandName,
      B.brand_id AS BrandId,
      SB.brandId as MappedId,
      SB.supplierId as MappedSupplierId
   
      FROM item_companydetails S
      JOIN supplier_brand_mapping SB on  SB.supplierId=S.item_compid
      JOIN brands B ON SB.brandId=B.brand_id
      where S.item_compid =$supplierid 
      group by BrandName ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Brand();

        $view->set_brandname($row['BrandName']);
        $view->set_brandid($row["BrandId"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  public static function selectbrandsbasedonInputTypeId($inputId)
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
      I.InputTypeId  AS InputTypeId ,
      I.InputType AS InputType,
      B.brand_name AS BrandName,
      B.brand_id AS BrandId,
      IB.brandId as MappedId,
      IB.InputTypeId as MappedInputTypeId
   
      FROM inputtype I
      JOIN inputtype_brand_mapping IB on  IB.InputTypeId=I.InputTypeId
      JOIN brands B ON IB.brandId=B.brand_id
      where I.InputTypeId =$inputId 
      group by BrandName ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Brand();

        $view->set_brandname($row['BrandName']);
        $view->set_brandid($row["BrandId"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }


  public static function selectbrandsbasedonMatcatId($matcatId)
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
      M.material_catName AS CategoryName,
      M.material_catId  as CategoryId,
      B.brand_name AS BrandName,
      B.brand_id AS BrandId,
      MB.brandId as MappedId,
      MB.material_categoryId as MappedCatId
   
      FROM material_category M
      JOIN brand_matcat_mapping MB on MB.material_categoryId=M.material_catId
      JOIN brands B ON  MB.brandId=B.brand_id
      where M.material_catId =$matcatId 
      group by BrandName ";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $itemdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Brand();

        $view->set_brandname($row['BrandName']);
        $view->set_brandid($row["BrandId"]);
        array_push($itemdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($itemdetailslist);
    }
  }

  // public static function isMapped($brandId)
  // {
  //   $db = ConnectDb::getInstance();
  //   $conn = $db->getConnection();

  //   $stmt = $conn->prepare("SELECT COUNT(*) FROM inputtype_brand_mapping WHERE brandId = ?");
  //   $stmt->bind_param("i", $brandId);
  //   $stmt->execute();
  //   $stmt->bind_result($count);
  //   $stmt->fetch();
  //   $stmt->close();

  //   return ($count > 0);
  // }
  public static function isMappedInInventory($brandId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    // Check if brand is used in inventory items
    $stmt = $conn->prepare("SELECT COUNT(*) FROM item_details WHERE item_compid = ?");
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return ($count > 0); // True if brand is used in item_details
  }
  public static function isMappedInItemCategory($brandId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM brand_category_mapping WHERE brandId = ?");
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return ($count > 0); // mapped → cannot delete
  }
  public static function insertWithoutMappings($brandObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $stmt = $connectionObj->prepare(
      "INSERT INTO brands (`brand_name`, `brand_createdby`, `brand_modifiedby`) VALUES (?, ?, ?)"
    );

    $brand_name = $brandObj->get_brandname();
    $created = $brandObj->get_brandcreatedby();
    $modified = $brandObj->get_brandmodifiedby();

    $stmt->bind_param("sss", $brand_name, $created, $modified);
    $stmt->execute();

    // Save ID back to object
    $brandObj->set_brandid($connectionObj->insert_id);

    $stmt->close();
  }
  public static function getInventoryTypesByBrand($brandId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $item = false;
    $material = false;

    $sql = "
        SELECT I.InputType
        FROM inputtype I
        JOIN inputtype_brand_mapping IBM 
            ON IBM.InputTypeId = I.InputTypeId
        WHERE IBM.brandId = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $type = strtolower(trim($row['InputType']));

      if ($type === 'item') {
        $item = true;
      }
      if ($type === 'material') {
        $material = true;
      }
    }

    echo json_encode([
      "item" => $item,
      "material" => $material
    ]);
  }



}
