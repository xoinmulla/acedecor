<?php

require_once __DIR__ . "/../DB Operations/dbconnection.php";
require_once __DIR__ . "/../Model/enq_categorymodel.php";


class DBcategory
{
  public static function insert($enqcatObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "INSERT INTO enquiry_category 
        (enq_cat_name, enq_cat_type, enq_cat_createdby, enq_cat_modifiedby) 
        VALUES (
            '" . $enqcatObj->get_catname() . "',
            '" . $enqcatObj->get_catType() . "',
            '" . $enqcatObj->get_catcreatedby() . "',
            '" . $enqcatObj->get_catModifiedby() . "'
        )";

    if ($connectionObj->query($sql) === true) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
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
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "UPDATE enquiry_category SET 
                enq_cat_name='" . $enqCat->get_catname() . "',
                enq_cat_type='" . $enqCat->get_catType() . "',
                enq_cat_modifiedby='" . $enqCat->get_catModifiedby() . "'
            WHERE enq_catid=" . $enqCat->get_catid();

    error_log($sql);

    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function delete($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE FROM enq_cat_mapping WHERE enq_id=" . $id;
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
      $sql = "DELETE FROM enquiry_category WHERE enq_catid=" . $id;
      if ($connectionObj->query($sql) === TRUE) {
      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }
    }
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

}
