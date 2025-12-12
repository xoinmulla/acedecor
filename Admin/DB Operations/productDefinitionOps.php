<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/productDefinitionModel.php";
class DBProductDefinition
{
  /*
  function accepts the input item object and inserts the record in 
  item details table.
  */
  public static function insert($productObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "insert into product_definition (`Prod_Name`, 
        `Prod_Description`,
        `Rotation`,
        `Override`,
        `Type`,
        `Finish`,
        `Prod_Category`,
        `Prod_SubCategory`,
        `Quantity`,
        `LengthValue`,
        `Dimension1`,
        `WidthValue`,
        `Dimension2`,
        `DepthValue`,
        `Dimension3`,
        `CLFormula`,
        `CW`,
        `GL`,
        `FL`,
        `BL`,
        `RL`,
		`RW`,
		`EB_LW`,
        `ModifiedBy`,
        `CreatedBy`) 
                values ('" . $productObj->getProd_Name() .
      "','" . $productObj->getProd_Description() .
      "','" . $productObj->getRotation() .
      "','" . $productObj->getOverride() .
      "','" . $productObj->getType() .
      "','" . $productObj->getFinish() .
      "','" . $productObj->getProd_Category() .
      "','" . $productObj->getProd_SubCategory() .
      "','" . $productObj->getQuantity() .
      "','" . $productObj->getLengthValue() .
      "','" . $productObj->getDimension1() . 
      "','" . $productObj->getWidthValue() . 
      "','" . $productObj->getDimension2() . 
      "','" . $productObj->getDepthValue() . 
      "','" . $productObj->getDimension3() . 
      "','" . $productObj->getCLFormula() . 
      "','" . $productObj->getCW() . 
      "','" . $productObj->getGL() .
      "','" . $productObj->getFL() .
      "','" . $productObj->getBL() .
      "','" . $productObj->getRL() .
      "','" . $productObj->getRW() .
      "','" . $productObj->getEB_LW() .
      "','" . $productObj->getModifiedby() .
      "','" . $productObj->getCreatedby() .
      "')";
error_log( $sql );
    if ($connectionObj->query($sql) === true) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  
  public static function update($detailsObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE product_definition SET Prod_Name='" . $detailsObj->getProd_Name() .
      "', Prod_Description='" . $detailsObj->getProd_Description() .
      "', Rotation='" . $detailsObj->getRotation() .
      "', Override='" . $detailsObj->getOverride() .
      "', Type='" . $detailsObj->getType() .
      "', Finish='" . $detailsObj->getFinish() .
      "', Prod_Category='" . $detailsObj->getProd_Category() .
      "', Prod_SubCategory='" . $detailsObj->getProd_SubCategory() .
      "', Quantity='" . $detailsObj->getQuantity() .
      "', LengthValue='" . $detailsObj->getLengthValue() .
      "', Dimension1='" . $detailsObj->getDimension1() .
      "', WidthValue='" . $detailsObj->getWidthValue() .
      "', Dimension2='" . $detailsObj->getDimension2() .
      "', DepthValue='" . $detailsObj->getDepthValue() .
      "', Dimension3='" . $detailsObj->getDimension3() .	
      "', CLFormula='" . $detailsObj->getCLFormula() .
      "', CW='" . $detailsObj->getCW() .
      "', GL='" . $detailsObj->getGL() .
      "', FL='" . $detailsObj->getFL() .
      "', BL='" . $detailsObj->getBL() .
      "', RL='" . $detailsObj->getRL() .
      "', RW='" . $detailsObj->getRW() .
      "', EB_LW='" . $detailsObj->getEB_LW() .
      "' WHERE prodDefinition_Id=" . $detailsObj->getProdDefinition_Id() ;
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getallproductdefinition()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT PD.prodDefinition_Id  AS prodDefinition_Id,
    PD.Prod_Name AS Prod_Name,
    PD.Prod_Description AS Prod_Description,
    PD.Prod_Category AS Prod_Category,
    PC.product_catName AS product_catName,
    PSC.product_subcatName AS product_subcatName,
    PD.Prod_SubCategory AS Prod_SubCategory,
    PD.Rotation AS RotationId,
    R.sides AS Sides,
    PD.Override AS OverrideId,
    C.CabinetType as CabinetType,
    PD.Type as TypeId,
    F.Finish as Finish,
    PD.Finish as FinishId
    FROM product_definition PD
    JOIN product_category PC ON PC.product_catid = PD.Prod_Category
    JOIN product_subcategory PSC ON PSC.product_subcatid = PD.Prod_SubCategory
    JOIN rotation R ON R.rotationId = PD.Rotation
    JOIN cabinettype C on C.CabinetType_Id = PD.Type
    JOIN finish F on F.Finishid = PD.Finish ";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $productDefinitionlist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new ProductDefinition();
        $view->setProdDefinition_Id($row['prodDefinition_Id']);
        $view->setProd_Name($row['Prod_Name']);
        $view->setProd_Description($row['Prod_Description']);
        $view->setProd_Category($row["Prod_Category"]);
        $view->setProd_CategoryName($row["product_catName"]);
        $view->setProd_SubCategoryName($row["product_subcatName"]);
        $view->setProd_SubCategory($row["Prod_SubCategory"]);
        $view->setRotation($row["RotationId"]);
        $view->setRotationSide($row["Sides"]);
        $view->setOverride($row["OverrideId"]);
        $view->setType($row["TypeId"]);
        $view->setCabinetType($row["CabinetType"]);
        $view->setFinish($row["FinishId"]);
        $view->setFinishtype($row["Finish"]);
        array_push($productDefinitionlist, $view);
      }
    } else {
      // echo "0 results";
    }

    return $productDefinitionlist;
  }


  public static function selectproduct($catId,$subcatId,$finishId,$typeId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT prodDefinition_Id ,Prod_Name from  product_definition where Prod_Category=$catId and
    Prod_SubCategory=$subcatId and Finish=$finishId and Type=$typeId";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $productDefinitionlist = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new ProductDefinition();
        $view->setProdDefinition_Id($row['prodDefinition_Id']);
        $view->setProd_Name($row['Prod_Name']);
        array_push($productDefinitionlist, $view);
      }
      header('Content-Type: application/json');
      echo json_encode($productDefinitionlist);
    }
  }

  public static function delete($itemObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE from product_definition where prodDefinition_Id='" . $itemObj . "'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  
  
}
