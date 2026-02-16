<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/quotationModel.php";

class DBQuotation
{
  public static function insert($quotationObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "INSERT INTO quotation_details ( 
        `enqCatId`,
        `quo_enq_id`, 
        `customerId`,
        `quoteCode`,
        `quoteDescription`, 
        `itemListName`, 
        `orderListName`,
        `quoteValue`, 
        `quo_type`, 
        `quo_pdf_name`,  
        `inputType`,
        `quo_createdby`,
        `modifiedby`,
        `quo_status`, 
        `quo_comments`) 
        VALUES (
        '" . $quotationObj->getCatId() . "',
        '" . $quotationObj->get_enqId() . "',
        '" . $quotationObj->get_customerId() . "',
        '" . $quotationObj->getQuoteCode() . "',
        '" . $quotationObj->get_quoteDescription() . "',
        '" . $quotationObj->get_itemListName() . "',
        '" . $quotationObj->get_orderListName() . "',
        '" . $quotationObj->getQuoteValue() . "',
        '" . $quotationObj->get_quoteType() . "',
        '" . $quotationObj->get_quotePDFName() . "',
        '" . $quotationObj->getInputType() . "',
        '" . $quotationObj->get_createdby() . "',
        '" . $quotationObj->get_modifiedby() . "',
        '" . $quotationObj->get_quoteStatus() . "',
        '" . $quotationObj->get_quoteComments() . "'
        )";

    error_log("INSERT QUOTATION SQL: " . $sql);

    if ($connectionObj->query($sql) === TRUE) {
      $quoteId = $connectionObj->insert_id;
      $sql = "SELECT COUNT(*) FROM quotation_details WHERE customerId=" . $quotationObj->get_customerId();
      $count = $connectionObj->query($sql);
      $row = mysqli_fetch_array($count);
      $total = $row[0];

      $sql = "UPDATE quotation_details SET 
              quoteCode='" . $quotationObj->getQuoteCode() . "-0" . $total . "'
              WHERE quoteId=" . $quoteId;
      error_log("UPDATE QUOTATION CODE SQL: " . $sql);

      if ($connectionObj->query($sql) === TRUE) {
        $sql = "UPDATE `customer` SET `isQuoteGenerated`=1
                WHERE customerId=" . $quotationObj->get_customerId();
        $connectionObj->query($sql);
      }

      return $quoteId;
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getAllquotations()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM quotation_details AS Q
            JOIN customer AS C ON C.customerId=Q.customerId
            LEFT JOIN units AS U ON Q.unitId=U.unitId";
    $result = $connectionObj->query($sql);
    $quotationList = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $quotation = new Quotation();
        $quotation->setCatId($row["enqCatId"]);
        $quotation->setInputType($row["inputType"]);
        $quotation->set_quoteId($row["quoteId"]);
        $quotation->set_quoteType($row["quo_type"]);
        $quotation->set_quoteStatus($row["quo_status"]);
        $quotation->set_quoteComments($row["quo_comments"]);
        $quotation->set_quoteDescription($row["quoteDescription"]);
        $quotation->set_itemListName($row['itemListName']);
        $quotation->set_quotePDFName($row['quo_pdf_name']);
        $quotation->set_customerName($row['customerName']);
        $quotation->set_customerId($row['customerId']);
        $quotation->setcustomerAddress($row['customerAddress']);
        $quotation->setCustomerphone($row['customerContactNumber']);
        $quotation->set_customerEmail($row['customerEmail']);
        $quotation->setCustomerCity($row['customerCity']);
        $quotation->set_customerState($row['customerState']);
        $quotation->setCustomerCode($row['customerCode']);
        $quotation->setDOE(date('d/m/Y', strtotime($row['customerDOV'])));
        $quotation->setQuoteCode($row['quoteCode']);
        $quotation->setDOQ(date('m/d/Y', strtotime($row["quo_createdon"])));
        $quotation->setQuoteValue($row['quoteValue']);
        $quotation->setUnitId($row['unitId']);
        $quotation->setQuantity($row['quantity']);
        $quotation->setUnitName($row['unitName']);
        array_push($quotationList, $quotation);
      }
    }

    return $quotationList;
  }
  // ==================== LINE ITEM UPDATE ====================
  public static function updateLineItem($data)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "UPDATE quotelineitem 
            SET quantity = ?, 
                discount1 = ?, 
                totalPrice = ?, 
                modifiedby = 'Admin', 
                modifiedon = NOW()
            WHERE lineItemId = ?";

    $stmt = $connectionObj->prepare($sql);
    error_log("UPDATE LINE ITEM SQL: " . $sql);
    $stmt->bind_param(
      "dddi",
      $data['itemquantity'],   // numeric (quantity)
      $data['tradeDiscount'],  // numeric (discount)
      $data['tradePrice'],     // numeric (price)
      $data['id']              // lineItemId
    );

    if ($stmt->execute()) {
      // ✅ Now fetch updated record and return it
      $select = $connectionObj->prepare("SELECT lineItemId, InputName, quantity, discount1, totalPrice, totalValue, totalAmount, GST, item_catid, item_subcatid 
                                           FROM quotelineitem 
                                           WHERE lineItemId = ?");
      $select->bind_param("i", $data['id']);
      $select->execute();
      $result = $select->get_result();
      $updatedRow = $result->fetch_assoc();

      return [
        'status' => 'success',
        'message' => 'Line item updated successfully',
        'data' => $updatedRow
      ];
    } else {
      return ['status' => 'error', 'message' => $stmt->error];
    }
  }



  // ==================== LINE ITEM DELETE ====================
  public static function deleteLineItem($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    // ✅ Correct column name
    $sql = "DELETE FROM quotelineitem WHERE lineItemId = ?";
    $stmt = $connectionObj->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
        return ['status' => 'success', 'message' => 'Line item deleted successfully'];
      } else {
        return ['status' => 'error', 'message' => 'No line item found with given ID'];
      }
    } else {
      return ['status' => 'error', 'message' => $stmt->error];
    }
  }


  public static function getQuotations($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM quotation_details AS Q
            JOIN customer AS C ON C.customerId=Q.customerId
            LEFT JOIN units AS U ON U.unitId=Q.unitId
            WHERE Q.quoteId=" . $id;

    $result = $connectionObj->query($sql);
    $quotation = null;

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $quotation = new Quotation();
        $quotation->setCatId($row["enqCatId"]);
        $quotation->set_quoteId($row["quoteId"]);
        $quotation->set_quoteType($row["quo_type"]);
        $quotation->set_quoteStatus($row["quo_status"]);
        $quotation->set_quoteComments($row["quo_comments"]);
        $quotation->set_quoteDescription($row["quoteDescription"]);
        $quotation->set_itemListName($row['itemListName']);
        $quotation->set_orderListName($row['orderListName']);
        $quotation->set_customerName($row['customerName']);
        $quotation->setCustomerCode($row['customerCode']);
        $quotation->setDOE(date('d/m/Y', strtotime($row['customerDOV'])));
        $quotation->setQuoteCode($row['quoteCode']);
        $quotation->setDOQ(date('d/m/Y', strtotime($row['quo_createdon'])));
        $quotation->setQuoteValue($row['quoteValue']);
        $quotation->setCustomerAddress($row['customerAddress']);
        $quotation->setCustomerCity($row['customerCity']);
        $quotation->setUnitId($row['unitId']);
        $quotation->setQuantity($row['quantity']);
        $quotation->setUnitName($row['unitName']);
      }
    }

    return $quotation;
  }

  public static function getquotationdetailsbasedonCustId($custId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT 
            Q.quoteCode AS quoteCode,
            Q.quo_createdon AS dateOfQuote,
            Q.enqCatId AS enqCatId,
            Q.quoteValue AS quoteValue,
            Q.quo_status AS quo_status,   -- ✅ ADDED THIS
            E.enq_cat_name AS enqCatName
        FROM quotation_details Q 
        JOIN enquiry_category E ON E.enq_catid = Q.enqCatId
        WHERE Q.customerId = " . $custId;

    $result = $connectionObj->query($sql);
    $quodetails = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $quotation = new Quotation();
        $quotation->setCatId($row["enqCatId"]);
        $quotation->setQuoteCode($row['quoteCode']);
        $quotation->setDOQ(date('d/m/Y', strtotime($row['dateOfQuote'])));
        $quotation->setEnqCatName($row['enqCatName']);
        $quotation->setQuoteValue($row['quoteValue']);
        $quotation->set_quoteStatus($row['quo_status']); // ✅ ADD THIS

        array_push($quodetails, $quotation);
      }
    }

    return $quodetails;
  }



  public static function getQuotationsForPrint($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM quotation_details AS Q
            JOIN customer AS C ON C.customerId=Q.customerId
            LEFT JOIN units AS U ON U.unitId=Q.unitId
            WHERE Q.customerId=" . $id;

    $result = $connectionObj->query($sql);
    $quoteList = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $quotation = new Quotation();
        $quotation->setCatId($row["enqCatId"]);
        $quotation->set_quoteId($row["quoteId"]);
        $quotation->set_quoteType($row["quo_type"]);
        $quotation->set_quoteStatus($row["quo_status"]);
        $quotation->set_quoteComments($row["quo_comments"]);
        $quotation->set_quoteDescription($row["quoteDescription"]);
        $quotation->set_itemListName($row['itemListName']);
        $quotation->set_orderListName($row['orderListName']);
        $quotation->set_customerName($row['customerName']);
        $quotation->setCustomerCode($row['customerCode']);
        $quotation->setDOE(date('d/m/Y', strtotime($row['customerDOV'])));
        $quotation->setQuoteCode($row['quoteCode']);
        $quotation->setDOQ(date('d/m/Y', strtotime($row['quo_createdon'])));
        $quotation->setQuoteValue($row['quoteValue']);
        $quotation->setCustomerAddress($row['customerAddress']);
        $quotation->setCustomerCity($row['customerCity']);
        $quotation->setUnitId($row['unitId']);
        $quotation->setQuantity($row['quantity']);
        $quotation->setUnitName($row['unitName']);
        $quotation->setCustomerphone($row['customerContactNumber']);
        array_push($quoteList, $quotation);
      }
    }

    return $quoteList;
  }

  public static function update($quotationObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE quotation_details SET 
            quoteDescription='" . $quotationObj->get_quoteDescription() .
      "', unitId='" . $quotationObj->getUnitId() .
      "', quantity='" . $quotationObj->getQuantity() .
      "', quoteValue='" . $quotationObj->getQuoteValue() .
      "', quo_type='" . $quotationObj->get_quoteType() .
      "', quo_status='" . $quotationObj->get_quoteStatus() .
      "', quo_comments='" . $quotationObj->get_quoteComments() .
      "', modifiedby='" . $quotationObj->get_modifiedby() .
      "' WHERE quoteId=" . $quotationObj->get_quoteId();

    error_log("UPDATE QUOTATION SQL: " . $sql);

    if ($connectionObj->query($sql) !== TRUE) {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    } else {
      // ✅ Sync project status with quotation status (no impact on other logic)
      $quoteCode = $quotationObj->getQuoteCode();
      $status = $quotationObj->get_quoteStatus();

      if ($status === 'Approved') {
        // If quotation approved, ensure related project is marked In Progress
        $syncSql = "UPDATE projects 
                    SET project_status = 'In Progress' 
                    WHERE quoteId = '$quoteCode'";
        error_log("Quotation Approved → Project In Progress: " . $syncSql);
        $connectionObj->query($syncSql);
      } elseif ($status === 'Pending' || $status === 'Rejected') {
        // If quotation changed to Pending/Rejected, mark project as Pending
        $syncSql = "UPDATE projects 
                    SET project_status = 'Pending' 
                    WHERE quoteId = '$quoteCode'";
        error_log("Quotation $status → Project Pending: " . $syncSql);
        $connectionObj->query($syncSql);
      }
    }

  }

  public static function updateFileName($quotationObj)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE quotation_details SET ";

    if ($quotationObj->get_itemListName() != "") {
      $sql .= "itemListName='" . $quotationObj->get_itemListName() . "'";
    } else {
      $sql .= "quo_pdf_name='" . $quotationObj->get_quotePDFName() . "'";
    }

    $sql .= ", modifiedby='" . $quotationObj->get_modifiedby() .
      "' WHERE quoteId=" . $quotationObj->get_quoteId();

    error_log("UPDATE FILE SQL: " . $sql);

    if ($connectionObj->query($sql) !== TRUE) {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function selectenqbasedonQuoteid($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT quo_enq_id FROM quotation_details WHERE quoteId ='$id'";
    $result = mysqli_query($connectionObj, $sql);
    $customer = null;

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $customer = new customer();
        $customer->set_enqId($row["quo_enq_id"]);
      }
    }

    return $customer;
  }

  public static function selectQuoteCodebasedonQuoteId($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT quoteCode FROM quotation_details WHERE quoteId ='$id'";
    $result = mysqli_query($connectionObj, $sql);
    $customer = null;

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $customer = new customer();
        $customer->set_quoteCode($row["quoteCode"]);
      }
    }

    return $customer;
  }

  public static function getQuoteById($quoteId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT quoteId, inputType, quoteCode, customerId 
            FROM quotation_details 
            WHERE quoteId = " . intval($quoteId) . " LIMIT 1";
    error_log("getQuoteById SQL: " . $sql);

    $result = $connectionObj->query($sql);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $quotation = new Quotation();
      $quotation->set_quoteId($row["quoteId"]);
      $quotation->setInputType($row["inputType"]);
      $quotation->setQuoteCode($row["quoteCode"]);
      $quotation->set_customerId($row["customerId"]);
      return $quotation;
    }
    return null;
  }


  public static function delete($quoteId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $check = $connectionObj->query(
      "SELECT quo_status FROM quotation_details WHERE quoteId = $quoteId LIMIT 1"
    );

    if ($check && $row = $check->fetch_assoc()) {
      if (strtolower($row['quo_status']) === 'approved') {
        throw new Exception("Approved quotation cannot be deleted");
      }
    }
    $enqId = DBQuotation::selectenqbasedonQuoteid($quoteId);
    $quoteCode = DBQuotation::selectQuoteCodebasedonQuoteId($quoteId);

    $sql = "DELETE FROM quotelineitem WHERE quoteId=" . $quoteId;
    error_log($sql);

    if ($connectionObj->query($sql) === TRUE) {
      $sql = "DELETE FROM quotation_details WHERE quoteId=" . $quoteId;
      error_log($sql);

      if ($connectionObj->query($sql) === TRUE) {
        $sql = "UPDATE customer SET isQuoteGenerated=0 WHERE enq_id='" . $enqId->get_enqId() . "'";
        error_log($sql);

        if ($connectionObj->query($sql) === TRUE) {
          $sql = "DELETE FROM projects WHERE quoteId='" . $quoteCode->get_quoteCode() . "'";
          error_log($sql);

          if ($connectionObj->query($sql) === TRUE) {
            $sql = "DELETE FROM customerpaymentinfo WHERE quotation_id ='" . $quoteCode->get_quoteCode() . "'";
            error_log($sql);
            $connectionObj->query($sql);
          }
        }
      }
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
}
?>