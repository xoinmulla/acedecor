<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/product_categorymodel.php";


class DBproductcategory
{
  public static function insert($productcatObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "insert into product_category (`product_catName`, `product_catDescription`,`product_catCreatedby`,`product_catModifiedby`) 
                values ('" . $productcatObj->get_productcatname() . "','" . $productcatObj->get_productcatdescription() . "','" . $productcatObj->get_productcatcreatedby() . "','" . $productcatObj->get_productcatmodifiedby() . "')";

    if ($connectionObj->query($sql) === true) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getallproductcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM product_category";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $productcatlist = [];
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $view = new Product_Category();
            $view->set_productcatid($row['product_catid']);
            $view->set_productcatname($row['product_catName']);
            $view->set_productcatdescription($row["product_catDescription"]);
            $view->set_productcatcreatedby($row["product_catCreatedby"]);
            $view->set_productcatmodifiedby($row["product_catModifiedby"]);
            array_push($productcatlist, $view);
        }
    }else {
        //  echo "0 results";
      }
      return $productcatlist;
  
      }

  public static function update($catObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE product_category SET product_catName='" . $catObj->get_productcatname() .
      "', product_catDescription='" . $catObj->get_productcatdescription() .
      "', product_catCreatedBy='" . $catObj->get_productcatcreatedby() .
      "', product_catModifiedBy='" . $catObj->get_productcatmodifiedby() .
      "' WHERE product_catid=" . $catObj->get_productcatid();
    echo $sql;
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function selectproductcategory()
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $result = mysqli_query($db->getConnection(), 'SELECT product_catid,product_catName FROM product_category');
    $productcatlist = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $view = new product_Category();
        $view->set_productcatid($row['product_catid']);
        $view->set_productcatname($row['product_catName']);
        array_push($productcatlist, $view);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($productcatlist);
  }

  public static function delete($productcatObj){
    $db=ConnectDb::getInstance();
    $connectionObj=$db->getConnection();
    $sql="DELETE from product_category where product_catid='".$productcatObj."'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

  }
}
