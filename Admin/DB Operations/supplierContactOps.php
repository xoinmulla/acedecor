<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/supplierContactModel.php";
class DBsupplierContact
{
  public static function insert($supplierContact)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "INSERT INTO suppliercontactdetails (`name`, 
    `supplierId`,
    `emailId`,
    `designation`,
    `phone`,
    `createdby`,
    `modifiedby`) 
                values ('" . $supplierContact->getName() .
                "','" . $supplierContact->getSupplierId() .
                "','" . $supplierContact->getEmail() .
                "','" . $supplierContact->getDesignation() .
                 "','" . $supplierContact->getPhone() . 
                 "','" . $supplierContact->getCreatedby() . 
                 "','" . $supplierContact->getModifiedby() . 
                 "')";
      error_log($sql);
    if ($connectionObj->query($sql) === true) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getAllContact($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT contactId,supplierId,name,phone,emailId,designation,
    C.createdby,
    C.modifiedby,
    S.item_compName supplier
    FROM suppliercontactdetails C
    JOIN item_companydetails S ON S.item_compid=C.supplierId
    WHERE supplierId=".$id;

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $contactList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $contactInfo = new contactInfo();
        $contactInfo->setSupplier($row['supplier']);
        $contactInfo->setContactId($row['contactId']);
        $contactInfo->setSupplierId($row['supplierId']);
        $contactInfo->setName($row['name']);
        $contactInfo->setPhone($row['phone']);
        $contactInfo->setEmail($row['emailId']);
        $contactInfo->setDesignation($row["designation"]);
        $contactInfo->setCreatedby($row["createdby"]);
        $contactInfo->setModifiedby($row["modifiedby"]);
        array_push($contactList, $contactInfo);
      }
    
    } else {
      // echo "0 results";
    }
    return $contactList;
  }
  public static function getAllContactJson($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT contactId,supplierId,name,phone,emailId,designation,
    C.createdby,
    C.modifiedby,
    S.item_compName supplier
    FROM suppliercontactdetails C
    JOIN item_companydetails S ON S.item_compid=C.supplierId
    WHERE supplierId=".$id;

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $contactList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $contactInfo = new contactInfo();
        $contactInfo->setSupplier($row['supplier']);
        $contactInfo->setContactId($row['contactId']);
        $contactInfo->setSupplierId($row['supplierId']);
        $contactInfo->setName($row['name']);
        $contactInfo->setPhone($row['phone']);
        $contactInfo->setEmail($row['emailId']);
        $contactInfo->setDesignation($row["designation"]);
        $contactInfo->setCreatedby($row["createdby"]);
        $contactInfo->setModifiedby($row["modifiedby"]);
        array_push($contactList, $contactInfo);
      }
    
    } else {
      // echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($contactList);
  }

  public static function update($supplierContact)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE suppliercontactdetails SET
       name='" . $supplierContact->getName() .
      "', emailId='" . $supplierContact->getEmail() .
      "', designation='" . $supplierContact->getDesignation() .
      "', phone='" . $supplierContact->getPhone() .
      "', createdby='" . $supplierContact->getCreatedby() .
      "', modifiedby='" . $supplierContact->getModifiedby() .
      "' WHERE 	contactId =" . $supplierContact->getContactId();
      error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  

  public static function delete($contactId){
    $db=ConnectDb::getInstance();
    $connectionObj=$db->getConnection();
    $sql="DELETE from suppliercontactdetails where contactId =" . $contactId;
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

  }
}
