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
        $enqModel->setCreatedDate(date('m/d/Y',strtotime($row["enq_createdOn"])));
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
    $sql = "insert into enquiry_details (`enq_name`, `enq_email`, `enq_phone`,`enq_address`,`enq_country`) 
                values ('" . $enqObj->get_enqname() . "','" . $enqObj->get_enqemail() . "','" . $enqObj->get_enqphone() . "','" . $enqObj->get_enqaddress() . "','" . $enqObj->getEnq_Country(). "')";
                error_log($sql);
    if ($connectionObj->query($sql) === TRUE) {
      $lastInsertedId =  $connectionObj->insert_id;
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

  public static function delete($enquiryObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "DELETE FROM enq_cat_mapping WHERE enq_id='" . $enquiryObj . "'";
    if ($connectionObj->query($sql) === TRUE) {
      $sql = "DELETE from enquiry_details where enqid='" . $enquiryObj . "'";
      error_log($sql);
      if ($connectionObj->query($sql) === TRUE) {
        $sql = "DELETE from customer where enq_id='" . $enquiryObj . "'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
          $sql = "DELETE from enquiry_followups where followup_enq_id='" . $enquiryObj . "'";
          error_log($sql);
          if ($connectionObj->query($sql) === true) {
          }else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
          }
          
        }else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }

      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
   
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
        $enqModel->setEnq_Country($row["enq_country"]);
        $enqModel->set_interestList(DBenqCatMapping::getCategoryForEnq($row["enqid"]));
        return $enqModel;
    }

    return null;
}


public static function update($enqObj)
{
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE enquiry_details 
            SET enq_name = '" . $enqObj->get_enqname() . "',
                enq_email = '" . $enqObj->get_enqemail() . "',
                enq_phone = '" . $enqObj->get_enqphone() . "',
                enq_address = '" . $enqObj->get_enqaddress() . "',
                enq_country = '" . $enqObj->getEnq_Country() . "'
            WHERE enqid = '" . $enqObj->get_id() . "'";
    $connectionObj->query($sql);

    // Update category mappings
    $connectionObj->query("DELETE FROM enq_cat_mapping WHERE enq_id = '" . $enqObj->get_id() . "'");
    foreach ($enqObj->get_interestList() as $interest) {
        $map = new enqCatMappingModel();
        $map->set_enqId($enqObj->get_id());
        $map->set_catId($interest);
        DBenqCatMapping::insert($map);
    }
}

}
