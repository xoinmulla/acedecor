<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/productsmodel.php";
class DBproductdetails
{
  /*
  function accepts the input item object and inserts the record in 
  item details table.
  */
  public static function insert($productObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "insert into products (`Name`, 
        `Length`,
        `Width`,
        `Quantity`,
        `CL_ID`,
        `CategoryId`,
        `SubcategoryId`,
        `FinishId`,
        `Code`,
        `CabinetType`,
        `Mat_Brand`,
        `Rotation`,
        `Mat_Category`,
        `Mat_Subcategory`,
        `Thickness`,
        `Material`,
        `PEB`,
        `PEB_Thickness`,
        `SEB`,
        `SEB_Thickness`,
        `Comments`,
        `product_modified`,
        `byproduct_createdby`) 
                values ('" . $productObj->getName() .
      "','" . $productObj->getLength() .
      "','" . $productObj->getWidth() .
      "','" . $productObj->getQuantity() .
      "','" . $productObj->getCL_ID() .
      "','" . $productObj->getCategoryId() .
      "','" . $productObj->getSubcategoryId() .
      "','" . $productObj->getFinishId() .
      "','" . $productObj->getCode() .
      "','" . $productObj->getCabinetType() .
      "','" . $productObj->getMat_Brand() .
      "','" . $productObj->getRotation() .
      "','" . $productObj->getMat_Category() .
      "','" . $productObj->getMat_Subcategory() .
      "','" . $productObj->getThickness() .
      "','" . $productObj->getMaterial() .
      "','" . $productObj->getPEB() .
      "','" . $productObj->getPEB_Thickness() .
      "','" . $productObj->getSEB() .
      "','" . $productObj->getSEB_Thickness() .
      "','" . $productObj->getComments() .

      "')";
error_log( $sql );
    if ($connectionObj->query($sql) === true) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getallproductdetails()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT P.product_id AS Productid,
    P.Code as ProductCode,
    P.Name AS ProductName,
    P.CategoryId AS CategoryId,
    P.SubcategoryId AS SubcategoryId,
    C.item_catName AS CategoryName,
    SC.item_subcatName AS SubCategoryName,
    P.Mat_Brand AS MatBrandid,
    B.brand_name AS ProductBrand,
    P.Material as Material,
    M.Material_Name as MaterialName
    FROM products P
    JOIN item_category C ON P.CategoryId=C.item_catid 
    JOIN item_subcategory SC ON P.SubcategoryId=SC.item_subcatid 
    JOIN brands B ON P.Mat_Brand=B.brand_id
    JOIN material M on P.Material=M.Material_Id";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $productdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Products();
        $view->set_productid($row['Productid']);
        $view->setName($row['ProductName']);
        $view->setCategoryId($row["CategoryId"]);
        $view->setCategoryName($row["CategoryName"]);
        $view->setSubcategoryName($row["SubCategoryName"]);
        $view->setSubcategoryId($row["SubCategoryId"]);
        $view->setMat_BrandName($row["ProductBrand"]);
        $view->setMat_Brand($row["ProductBrandid"]);
        $view->setCode($row["ProductCode"]);
        $view->setMaterial($row["Material"]);
        $view->setMaterialName($row["MaterialName"]);
    
        array_push($productdetailslist, $view);
      }
    } else {
      // echo "0 results";
    }

    return $productdetailslist;
  }

  public static function update($detailsObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE products SET Name='" . $detailsObj->getName() .
      "', Length='" . $detailsObj->getLength() .
      "', Width='" . $detailsObj->getWidth() .
      "', Quantity='" . $detailsObj->getQuantity() .
      "', CL_ID='" . $detailsObj->getCL_ID() .
      "', CategoryId='" . $detailsObj->getCategoryId() .
      "', SubcategoryId='" . $detailsObj->getSubcategoryId() .
      "', FinishId='" . $detailsObj->getFinishId() .
      "', Code='" . $detailsObj->getCode() .
      "', CabinetType='" . $detailsObj->getCabinetType() .
      "', Mat_Brand='" . $detailsObj->getMat_Brand() .
      "', Rotation='" . $detailsObj->getRotation() .
      "', Mat_Category='" . $detailsObj->getMat_Category() .
      "', Mat_Subcategory='" . $detailsObj->getMat_Subcategory() .
      "', Thickness='" . $detailsObj->getThickness() .
      "', Material='" . $detailsObj->getMaterial() .
      "', PEB='" . $detailsObj->getPEB() .
      "', PEB_Thickness='" . $detailsObj->getPEB_Thickness() .
      "', SEB='" . $detailsObj->getSEB() .
      "', SEB_Thickness='" . $detailsObj->getSEB_Thickness() .
      "', Comments='" . $detailsObj->getComments() .
      "' WHERE product_id=" . $detailsObj->get_productid() ;
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function selectproduct()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT product_id,Name from products";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $productdetailslist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new Item_Details();
        $view->set_productid($row['product_id']);
        $view->setName($row['product_name']);
        array_push($productdetailslist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($productdetailslist);
    }
  }

  public static function delete($itemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE from products where product_id='" . $itemObj . "'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  
  
}
