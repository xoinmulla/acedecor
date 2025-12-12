<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/product_subcategorymodel.php";


class DBproductsubcategory
{
  public static function insert($productsubcatObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "insert into product_subcategory (`product_catid`,`product_subcatName`, `product_subcatDescription`,`product_subcatCreatedby`,`product_subcatModifiedby`) 
                values ('" . $productsubcatObj->get_productcatid() . "','" . $productsubcatObj->get_productsubcatname() . "','" . $productsubcatObj->get_productsubcatdescription() . "','" . $productsubcatObj->get_productsubcatcreatedby() . "','" . $productsubcatObj->get_productsubcatmodifiedby() . "')";

    if ($connectionObj->query($sql) === true) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getallproductsubcategory()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM product_subcategory";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $productsubcatlist = [];
    if ($count > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $view = new product_subcategory();
            $view->set_productcatid($row['product_catid']);
            $view->set_productsubcatid($row['product_subcatid']);
            $view->set_productsubcatname($row['product_subcatName']);
            $view->set_productsubcatdescription($row["product_subcatDescription"]);
            $view->set_productsubcatcreatedby($row["product_subcatCreatedby"]);
            $view->set_productsubcatmodifiedby($row["product_subcatModifiedby"]);
            array_push($productsubcatlist, $view);
        }
    }else {
        //  echo "0 results";
      }
      return $productsubcatlist;
  
      }

  public static function update($catObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE product_subcategory SET product_subcatName='" . $catObj->get_productsubcatname() .
      "', product_subcatDescription='" . $catObj->get_productsubcatdescription() .
      "', product_subcatCreatedBy='" . $catObj->get_productsubcatcreatedby() .
      "', product_subcatModifiedBy='" . $catObj->get_productsubcatmodifiedby() .
      "' WHERE product_subcatid=" . $catObj->get_productsubcatid();
    echo $sql;
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function selectproductsubcategory($productcatid)
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $result = mysqli_query($db->getConnection(), 'SELECT product_subcatid,product_subcatName FROM product_subcategory where product_catid='.$productcatid.'' );
    $productsubcatlist = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $view = new product_subcategory();
        $view->set_productsubcatid($row['product_subcatid']);
        $view->set_productsubcatname($row['product_subcatName']);
        array_push($productsubcatlist, $view);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($productsubcatlist);
  }

  public static function delete($productsubcatObj){
    $db=ConnectDb::getInstance();
    $connectionObj=$db->getConnection();
    $sql="DELETE from product_subcategory where product_subcatid='".$productsubcatObj."'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

  }
}
