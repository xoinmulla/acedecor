<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/taxmodel.php";
class DBTax
{
  public static function insert($tax)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql="";
    if($tax->get_IGST()!=""){
          $sql = "INSERT INTO `tax_table`(`IGST`,`GST`,`Created_By`,`Modified_By`) VALUES (
      '". $tax->get_IGST() .
      "','" . $tax->get_GST() .
      "','" . $tax->get_createdby() .
      "','" . $tax->get_modifiedby() .
       "');";
    }else{
      $sql= "INSERT INTO `tax_table`(`CGST`, `SGST`,`GST`,`Created_By`,`Modified_By`) VALUES ('" .
      $tax->get_CGST() .
      "','" . $tax->get_SGST() .
      "','" . $tax->get_GST() .
      "','" . $tax->get_createdby() .
      "','" . $tax->get_modifiedby() .
       "');";
    }

    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function getAll()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM  tax_table";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $taxList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $tax = new Taxinfo();
        $tax->set_taxid($row["tax_id"]);
        $tax->set_SGST($row["SGST"]);
        $tax->set_CGST($row["CGST"]);
        $tax->set_IGST($row["IGST"]);
        $tax->set_GST($row["GST"]);
        array_push($taxList, $tax);
      }
    }
    return $taxList;
  }
  public static function getById($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM  tax_table WHERE tax_id="+$id;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $tax = new Taxinfo();
      $ $tax->set_taxid($row["tax_id"]);
      $tax->set_SGST($row["SGST"]);
      $tax->set_CGST($row["CGST"]);
      $tax->set_IGST($row["IGST"]);
      $tax->set_GST($row["GST"]);
    }
  }
  public static function update($tax){
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql="";
    if($tax->get_IGST()!=""){
    $sql = "UPDATE tax_table SET IGST='".$tax->get_IGST().
    "',GST='".$tax->get_GST().
    "',Modified_By='".$tax->get_modifiedby().
    "' WHERE tax_id=".$tax->get_taxid();
    }else{
      $sql = "UPDATE tax_table SET SGST='".$tax->get_SGST().
      "',CGST='".$tax->get_CGST().
      "',GST='".$tax->get_GST().
      "',Modified_By='".$tax->get_modifiedby().
      "' WHERE tax_id=".$tax->get_taxid();
    }
    error_log($sql);
    try{
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  catch(Exception $e){
    echo $e->message;
  }
  }

  public static function delete($taxObj){
    $db=ConnectDb::getInstance();
    $connectionObj=$db->getConnection();
    $sql="DELETE from tax_table where tax_id='".$taxObj."'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
}
