<?php
// require "../Admin/session.php";
require_once "../DB Operations/dbconnection.php";
require_once "../Model/enquirymodel.php";
require_once "../Model/enq_cat_mappingmodel.php";
require_once "../DB Operations/enq_cat_mappingOps.php";
class DBenq
{
  public static function getAllenq()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM enquiry_details";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $enquiryList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $enqModel = new Enquiry();
        $enqModel->set_id($row["enqid"]);
        $enqModel->set_enqname($row["enq_name"]);
        $enqModel->set_enqemail($row["enq_email"]);
        $enqModel->set_enqphone($row["enq_phone"]);
        $enqModel->set_enqaddress($row["enq_address"]);
        $enqModel->setEnq_Country($row["enq_country"]);
        $enqModel->set_isCustomerCreated($row["isCustomerCreated"]);
        $enqModel->setStatus($row["enqStatus"]);
        // $enqModel->set_enqmodifiedby($row["enq_modifiedBy"]);
        $enqModel->setCreatedDate(date('m/d/Y', strtotime($row["enq_createdOn"])));
        $enqModel->set_interestList(DBenqCatMapping::getCategoryForEnq($row["enqid"]));
        array_push($enquiryList, $enqModel);
      }
    }
    return $enquiryList;
  }


  public static function getAllenqBySection($enqFor)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM enquiries WHERE " . $enqFor . "!=''";
    $result = mysqli_query($connectionObj, $sql);
    $enquirylist = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $enqModel = new Enquiry();
        $enqModel->set_Id($row["id"]);
        $enqModel->set_enqname($row["enq_name"]);
        $enqModel->set_enqemail($row["enq_email"]);
        $enqModel->set_enqphone($row["enq_phone"]);
        $enqModel->set_enqaddress($row["enq_address"]);
        // $enqModel->set_enqcontactmode($row["enq_preffered_contact_mode"]);
        $enqModel->set_interestList(DBenqCatMapping::getCategoryForEnq($row["id"]));
        // $enqModel->set_enqFor($row["$enqFor"]);
        array_push($enquirylist, $enqModel);
      }
    } else {
      echo "0 results";
    }
    return $enquirylist;

  }
  public static function insert($enqObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "insert into enquiry_details (`enq_name`, `enq_email`, `enq_phone`,`enq_address`,`enq_city`,`enq_country`,`enq_state`) 
                values ('" . $enqObj->get_enqname() . "','" . $enqObj->get_enqemail() . "','" . $enqObj->get_enqphone() . "','" . $enqObj->get_enqaddress() . "','" . $enqObj->get_enqcity() . "','" . $enqObj->getEnq_Country() . "','" . $enqObj->getEnq_State() . "')";
    error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
      $lastInsertedId = $connectionObj->insert_id;
      foreach ($enqObj->get_interestList() as $interest) {
        $map = new enqCatMappingModel();
        $map->set_enqId($lastInsertedId);
        $map->set_catId($interest);
        DBenqCatMapping::insert($map);
      }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function delete($enquiryId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // 🔒 SAFETY CHECK: Is customer already created?
    $checkSql = "SELECT isCustomerCreated FROM enquiry_details WHERE enqid = '$enquiryId'";
    $checkResult = $connectionObj->query($checkSql);

    if ($row = $checkResult->fetch_assoc()) {
      if ((int) $row['isCustomerCreated'] === 1) {
        // ❌ Stop deletion
        echo "Cannot delete enquiry. Customer already created.";
        return false;
      }
    }

    // ✅ Safe to delete
    $connectionObj->query("DELETE FROM enq_cat_mapping WHERE enq_id='$enquiryId'");
    $connectionObj->query("DELETE FROM enquiry_followups WHERE followup_enq_id='$enquiryId'");
    $connectionObj->query("DELETE FROM enquiry_details WHERE enqid='$enquiryId'");

    return true;
  }

  public static function readById($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM enquiry_details WHERE enqid = '$id'";
    $result = $connectionObj->query($sql);

    if ($row = $result->fetch_assoc()) {
      $enqModel = new Enquiry();
      $enqModel->set_id($row["enqid"]);
      $enqModel->set_enqname($row["enq_name"]);
      $enqModel->set_enqemail($row["enq_email"]);
      $enqModel->set_enqphone($row["enq_phone"]);
      $enqModel->set_enqaddress($row["enq_address"]);
      $enqModel->set_enqcity($row["enq_city"]);
      $enqModel->setEnq_State($row["enq_state"]);
      $enqModel->setEnq_Country($row["enq_country"]);
      $enqModel->setCreatedDate(date('d-m-Y', strtotime($row["enq_createdOn"]))); // ✅ ADD THIS
      $enqModel->set_interestList(DBenqCatMapping::getCategoryForEnq($row["enqid"]));
      return $enqModel;
    }

    return null;
  }


  public static function update($enqObj)
{
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // 1️⃣ Update enquiry_details
    $sql = "UPDATE enquiry_details 
            SET enq_name = '" . $enqObj->get_enqname() . "',
                enq_email = '" . $enqObj->get_enqemail() . "',
                enq_phone = '" . $enqObj->get_enqphone() . "',
                enq_address = '" . $enqObj->get_enqaddress() . "',
                enq_city = '" . $enqObj->get_enqcity() . "',
                enq_state = '" . $enqObj->getEnq_State() . "',
                enq_country = '" . $enqObj->getEnq_Country() . "'
            WHERE enqid = '" . $enqObj->get_id() . "'";
    $connectionObj->query($sql);

    // 2️⃣ 🔥 NEW: Check if customer exists
    $checkSql = "SELECT customerId FROM customer WHERE enq_id = '" . $enqObj->get_id() . "'";
    $result = $connectionObj->query($checkSql);

    if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $customerId = $row['customerId'];

        // 3️⃣ 🔥 Update customer table also
        $updateCustomer = "UPDATE customer SET
                customerName = '" . $enqObj->get_enqname() . "',
                customerEmail = '" . $enqObj->get_enqemail() . "',
                customerContactNumber = '" . $enqObj->get_enqphone() . "',
                customerAddress = '" . $enqObj->get_enqaddress() . "',
                customerCity = '" . $enqObj->get_enqcity() . "',
                customerState = '" . $enqObj->getEnq_State() . "',
                customerCountry = '" . $enqObj->getEnq_Country() . "'
            WHERE customerId = '" . $customerId . "'";

        $connectionObj->query($updateCustomer);
    }

    // 4️⃣ Update category mapping
    $connectionObj->query("DELETE FROM enq_cat_mapping WHERE enq_id = '" . $enqObj->get_id() . "'");

    foreach ($enqObj->get_interestList() as $interest) {
        $map = new enqCatMappingModel();
        $map->set_enqId($enqObj->get_id());
        $map->set_catId($interest);
        DBenqCatMapping::insert($map);
    }

}

}