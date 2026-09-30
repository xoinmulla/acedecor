<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/unitsModel.php";
class DBunit
{
  public static function insert($unit)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "INSERT INTO units (`unitName`, 
    `unitDescription`,
    `createdBy`,
    `modifiedBy`) 
                values ('" . $unit->get_unitName() .
      "','" . $unit->get_unitDescription() .
      "','" . $unit->get_CreatedBy() .
      "','" . $unit->get_ModifiedBy() .
      "')";

    if ($connectionObj->query($sql) === true) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }

  public static function getAllUnit()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM units";

    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $unitList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $unit = new unit();
        $unit->set_unitId($row['unitId']);
        $unit->set_unitName($row['unitName']);
        $unit->set_unitDescription($row["unitDescription"]);
        $unit->set_createdby($row["createdBy"]);
        $unit->set_modifiedby($row["modifiedBy"]);
        array_push($unitList, $unit);
      }

    } else {
      // echo "0 results";
    }
    return $unitList;
  }

  public static function update($unit)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE units SET unitName='" . $unit->get_unitName() .
      "', unitDescription='" . $unit->get_unitDescription() .
      "', createdBy='" . $unit->get_CreatedBy() .
      "', modifiedBy='" . $unit->get_ModifiedBy() .
      "' WHERE unitId=" . $unit->get_unitId();
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }
  }
  public static function selectUnits()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = 'SELECT unitId,unitName FROM units';
    $result = mysqli_query($db->getConnection(), $sql);
    error_log($sql);
    $unitList = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $unit = new unit();
        $unit->set_unitId($row['unitId']);
        $unit->set_unitName($row['unitName']);
        array_push($unitList, $unit);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($unitList);
  }

  public static function delete($unitId)
  {
    if (self::isUnitMapped($unitId)) {
      echo json_encode([
        "status" => "error",
        "message" => "❌ Unit is mapped to Unit Factor and cannot be deleted"
      ]);
      exit;
    }

    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("DELETE FROM units WHERE unitId = ?");
    $stmt->bind_param("i", $unitId);
    $stmt->execute();

    echo json_encode([
      "status" => "success",
      "message" => "✅ Unit deleted successfully"
    ]);
  }

  public static function isUnitMapped($unitId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $sql = "SELECT COUNT(*) AS total FROM unitsfactor WHERE unitId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $unitId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return ($result['total'] > 0);
  }

  public static function isUnitExists($unitName, $unitId = 0)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    if ($unitId > 0) {
      // While updating, ignore the current record
      $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM units WHERE LOWER(TRIM(unitName)) = LOWER(TRIM(?)) AND unitId != ?");
      $stmt->bind_param("si", $unitName, $unitId);
    } else {
      // While inserting
      $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM units WHERE LOWER(TRIM(unitName)) = LOWER(TRIM(?))");
      $stmt->bind_param("s", $unitName);
    }

    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return ($result['total'] > 0);
  }

}
