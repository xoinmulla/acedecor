<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/projectModel.php";
require_once "../Model/customerModel.php";
require_once "../Model/quotationModel.php";
require_once "../DB Operations/quotationOps.php";
class DBproject
{
  public static function insert($project)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * from projects where quoteId='" . $project->get_quoteid() . "'";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    error_log($count);
    if ($count < 1) {
      $sql = "INSERT INTO projects (`projectCode`,`customerName`,`custId`, 
    `quoteId`
    ) 
                values ('" . $project->get_projectCode() .
        "','" . $project->get_custName() .
        "','" . $project->get_custid() .
        "','" . $project->get_quotecode() .

        "')";
      error_log($sql);
      if ($connectionObj->query($sql) === true) {
        $projId = $connectionObj->insert_id;

        $sql = "UPDATE projects SET projectCode='" . $project->get_projectCode() . $projId . "' WHERE projectId=" . $projId;
        error_log($sql);
        $connectionObj->query($sql);
        return $projId;
      } else {
        echo "Error: " . $sql . "<br>" . $connectionObj->error;
      }
    } else {
      echo "Record already exists";
    }
  }

  public static function getAllprojectsbasedonId($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT 
        C.customerName as customerName,
        C.customerCode as customerCode,
        C.customerCity as customerCity,
        P.projectId as projectId,
        P.projectCode as projectCode,
        P.project_status as projectStatus,

        Q.quoteId as quoteId,
        Q.quoteCode as quoteCode,
        Q.quo_type as quo_type,
        Q.quantity as quantity,
        Q.quoteValue as quoteValue,
        Q.enqCatId as enqCatId,

        U.unitId as unitId,
        U.unitName as unitName,

        S.Quantity as AllocatedQty,
        S.item_id as ItemId,
        S.item_stockid as StockId,

        EC.enq_cat_name as EnqCatname

     FROM projects P
     JOIN customer C ON C.customerCode = P.custId
     JOIN quotation_details Q ON Q.quoteCode = P.quoteId
     JOIN quotelineitem QLI ON Q.quoteId = QLI.quoteId
     JOIN enquiry_category EC ON EC.enq_catid = Q.enqCatId
     LEFT JOIN units U ON U.unitId = Q.unitId
     LEFT JOIN item_stock S ON S.item_id = QLI.itemId

     WHERE P.projectId = '$id'
     GROUP BY C.customerCode";

    error_log($sql);

    $result = $connectionObj->query($sql);
    $project = new Project();

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      $project->set_projectId($row['projectId']);
      $project->set_projectCode($row['projectCode']);
      $project->set_custName($row['customerName']);
      $project->set_custid($row['customerCode']);
      $project->set_customerCity($row['customerCity']);

      $project->set_quoteid($row['quoteId']);   // ✅ FIXED
      $project->set_quotecode($row['quoteCode']);
      $project->set_quoteType($row['quo_type']);
      $project->set_quoteamt($row['quoteValue']);

      $project->setQuantity($row['quantity']);
      $project->setUnitId($row['unitId']);
      $project->setUnitName($row['unitName']);

      $project->setEnqCatName($row['EnqCatname']);
      $project->setCatId($row['enqCatId']);
      $project->set_projectstatus($row['projectStatus']);

      $project->setAllocatedQty($row['AllocatedQty']);
      $project->setItemId($row['ItemId']);
      $project->setStockId($row['StockId']);
    }

    return $project;
  }


  public static function getAllprojects()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    C.customerName as customerName,
    C.customerCode as customerCode,
    C.customerCity as customerCity,
    P.projectId as projectId,
    P.projectCode as projectCode,
    P.project_status as projectStatus,
    Q.quoteCode as quoteCode,
    Q.quoid as quoid,
    Q.quo_type as quo_type,
    Q.quantity as quantity,
    Q.quoteValue as quoteValue,
    Q.quoteCode as quoteCode,
    Q.enqCatId as enqCatId,
    U.unitId as unitId,
    U.unitName as unitName,
    EC.enq_cat_name as EnqCatname
     FROM `projects` as P
     JOIN `customer`  C on C.customerCode=P.custId
     JOIN `quotation_details`  Q on Q.quoteCode=P.quoteId
     JOIN enquiry_category AS EC ON EC.enq_catid=Q.enqCatId
     LEFT JOIN units AS U ON U.unitId=Q.unitId";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $projectList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $project = new Project();
        $project->set_projectId($row['projectId']);
        $project->set_projectCode($row['projectCode']);
        $project->set_custName($row['customerName']);
        $project->set_custid($row['customerCode']);
        $project->set_customerCity($row['customerCity']);
        $project->set_quoteid($row["quoid"]);
        $project->set_quoteType($row["quo_type"]);
        $project->set_quotecode($row['quoteCode']);
        $project->set_quoteamt($row['quoteValue']);
        $project->setQuantity($row['quantity']);
        $project->setUnitId($row['unitId']);
        $project->setUnitName($row['unitName']);
        $project->setEnqCatName($row["EnqCatname"]);
        $project->setCatId($row["enqCatId"]);
        $project->set_projectstatus($row["projectStatus"]);
        array_push($projectList, $project);
      }

    } else {
      // echo "0 results";
    }
    return $projectList;
  }

  public static function getAllprojectsbasedonStatus()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    C.customerName as customerName,
    C.customerCode as customerCode,
    C.customerCity as customerCity,
    P.projectId as projectId,
    P.projectCode as projectCode,
    P.project_status as projectStatus,
    Q.quoteCode as quoteCode,
    Q.quoteId as quoteId,
    Q.quo_type as quo_type,
    Q.quantity as quantity,
    Q.quoteValue as quoteValue,
    Q.enqCatId as enqCatId,
    U.unitId as unitId,
    U.unitName as unitName,
    EC.enq_cat_name as EnqCatname,
    Q.quoteCode as quoteCode,
    Q.modifiedon as modifiedon,
    Q.inputType as InputType,
     DATEDIFF(CURDATE(),Q.modifiedon) AS DateDiff
     FROM `projects` as P
     JOIN `customer`  C on C.customerCode=P.custId
     JOIN `quotation_details`  Q on Q.quoteCode=P.quoteId
     JOIN enquiry_category AS EC ON EC.enq_catid=Q.enqCatId
     LEFT JOIN units AS U ON U.unitId=Q.unitId
     where P.project_status='In Progress'

     ";

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $projectList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $project = new Project();
        $project->set_projectId($row['projectId']);
        $project->set_projectCode($row['projectCode']);
        $project->set_custName($row['customerName']);
        $project->set_custid($row['customerCode']);
        $project->set_customerCity($row['customerCity']);
        $project->set_quoteid($row["quoteCode"]);
        $project->set_quoteType($row["quo_type"]);
        $project->set_quotecode($row['quoteCode']);
        $project->set_quoteamt($row['quoteValue']);
        $project->setQuantity($row['quantity']);
        $project->setUnitId($row['unitId']);
        $project->setUnitName($row['unitName']);
        $project->setEnqCatName($row["EnqCatname"]);
        $project->setCatId($row["enqCatId"]);
        $project->set_projectstatus($row["projectStatus"]);
        $project->setDOA(date('Y-m-d', strtotime($row["modifiedon"])));
        $project->setDayCount($row["DateDiff"]);
        $project->setInputType($row["InputType"]);
        array_push($projectList, $project);
      }

    } else {
      // echo "0 results";
    }
    return $projectList;
  }
  public static function getCustomersWithApprovedQuotes()
  {
    $db = ConnectDb::getInstance()->getConnection();

    $sql = "
        SELECT DISTINCT
            C.customerCode,
            C.customerName,
            C.customerCity
        FROM quotation_details Q
        JOIN customer C ON C.customerId = Q.customerId
        WHERE Q.quo_status = 'Approved'
        ORDER BY C.customerName
    ";

    return $db->query($sql)->fetch_all(MYSQLI_ASSOC);
  }

  public static function getAllprojectsbasedonPendingStatus()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    C.customerName as customerName,
    C.customerCode as customerCode,
    C.customerCity as customerCity,
    P.projectId as projectId,
    P.projectCode as projectCode,
    P.project_status as projectStatus,
    Q.quoteCode as quoteCode,
    Q.quoteId as quod,
    Q.quo_type as quo_type,
    Q.quantity as quantity,
    Q.quoteValue as quoteValue,
    Q.enqCatId as enqCatId,
    U.unitId as unitId,
    U.unitName as unitName,
    EC.enq_cat_name as EnqCatname,
    Q.quoteCode as quoteCode,
    Q.modifiedon as modifiedon,
    Q.inputType as InputType,
     DATEDIFF(CURDATE(),Q.modifiedon) AS DateDiff
     FROM `projects` as P
     JOIN `customer`  C on C.customerCode=P.custId
     JOIN `quotation_details`  Q on Q.quoteCode=P.quoteId
     JOIN enquiry_category AS EC ON EC.enq_catid=Q.enqCatId
     LEFT JOIN units AS U ON U.unitId=Q.unitId
     where P.project_status='Pending'";

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $projectList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $project = new project();
        $project->set_projectId($row['projectId']);
        $project->set_projectCode($row['projectCode']);
        $project->set_custName($row['customerName']);
        $project->set_custid($row['customerCode']);
        $project->set_customerCity($row['customerCity']);
        $project->set_quoteid($row["quoteCode"]);
        $project->set_quoteType($row["quo_type"]);
        $project->set_quotecode($row['quoteCode']);
        $project->set_quoteamt($row['quoteValue']);
        $project->setQuantity($row['quantity']);
        $project->setUnitId($row['unitId']);
        $project->setUnitName($row['unitName']);
        $project->setEnqCatName($row["EnqCatname"]);
        $project->setCatId($row["enqCatId"]);
        $project->set_projectstatus($row["projectStatus"]);
        $project->setDOA(date('Y-m-d', strtotime($row["modifiedon"])));
        $project->setDayCount($row["DateDiff"]);
        $project->setInputType($row["InputType"]);

        array_push($projectList, $project);
      }

    } else {
      // echo "0 results";
    }
    return $projectList;
  }


  public static function getAllprojectsbasedonCompletedStatus()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT 
    C.customerName as customerName,
    C.customerCode as customerCode,
    C.customerCity as customerCity,
    P.projectId as projectId,
    P.projectCode as projectCode,
    P.project_status as projectStatus,
    Q.quoteCode as quoteCode,
    Q.quoteId as quoteId,
    Q.quo_type as quo_type,
    Q.quantity as quantity,
    Q.quoteValue as quoteValue,
    Q.enqCatId as enqCatId,
    U.unitId as unitId,
    U.unitName as unitName,
    EC.enq_cat_name as EnqCatname,
    Q.quoteCode as quoteCode
     FROM `projects` as P
     
     JOIN `customer`  C on C.customerCode=P.custId
     JOIN `quotation_details`  Q on Q.quoteCode=P.quoteId
     JOIN enquiry_category AS EC ON EC.enq_catid=Q.enqCatId
     LEFT JOIN units AS U ON U.unitId=Q.unitId
     where P.project_status='Completed'";

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $projectList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $project = new project();
        $project->set_projectId($row['projectId']);
        $project->set_projectCode($row['projectCode']);
        $project->set_custName($row['customerName']);
        $project->set_custid($row['customerCode']);
        $project->set_customerCity($row['customerCity']);
        $project->set_quoteid($row["quoteCode"]);
        $project->set_quoteType($row["quo_type"]);
        $project->set_quotecode($row['quoteCode']);
        $project->set_quoteamt($row['quoteValue']);
        $project->setQuantity($row['quantity']);
        $project->setUnitId($row['unitId']);
        $project->setUnitName($row['unitName']);
        $project->setEnqCatName($row["EnqCatname"]);
        $project->setCatId($row["enqCatId"]);
        $project->set_projectstatus($row["projectStatus"]);

        array_push($projectList, $project);
      }

    } else {
      // echo "0 results";
    }
    return $projectList;
  }


  public static function update($project)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE projects SET progressNote='" . $project->get_progressNote() .
      "', project_status='" . $project->get_projectstatus() .
      "' WHERE projectId=" . $project->get_projectId();
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function selectprojects()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = 'SELECT P.projectId as ProjectId,
    P.projectCode as ProjectCode,
    C.customerCode as customerId,
    C.customerName as customerName 
    FROM projects P
    Join `customer` C on C.customerCode=P.custId
    where P.project_status!="Completed"
    ';
    $result = mysqli_query($db->getConnection(), $sql);
    error_log($sql);
    $projectList = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $project = new project();
        $project->set_projectId($row['ProjectId']);
        $project->set_projectCode($row['ProjectCode']);
        $project->set_custName($row['customerName']);
        $project->set_custid($row['customerId']);
        array_push($projectList, $project);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($projectList);
  }


  public static function selectcustomer($id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT customerName FROM customer where customerCode='$id'";
    error_log($sql);
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $view = new customer();
        $view->set_customerName($row['customerName']);

      }
    } else {
      // echo "0 results";
    }
    return $view;
  }


  public static function delete($projectId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE from projects where projectId='" . $projectId . "'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

  }
}