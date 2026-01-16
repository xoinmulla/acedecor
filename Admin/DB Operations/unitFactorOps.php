<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/unitFactorModel.php";

class DBunitFactor
{
  public static function insert($unitFactor)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "INSERT INTO unitsfactor (`unitId`, 
      `unitFactorDescription`,
      `unitFactor`,
      `createdBy`,
      `modifiedBy`) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $connectionObj->prepare($sql)) {
      $stmt->bind_param(
        "issss",
        $unitId,
        $unitFactorDescription,
        $unitFactorValue,
        $createdBy,
        $modifiedBy
      );

      $unitId = intval($unitFactor->get_unitId());
      $unitFactorDescription = $unitFactor->get_unitFactorDescription();
      $unitFactorValue = $unitFactor->get_unitFactor();
      $createdBy = $unitFactor->get_CreatedBy();
      $modifiedBy = $unitFactor->get_ModifiedBy();

      if (!$stmt->execute()) {
        error_log("DBunitFactor::insert execute error: " . $stmt->error);
      }
      $stmt->close();
    } else {
      error_log("DBunitFactor::insert prepare error: " . $connectionObj->error);
    }
  }

  public static function getAllUnitFactor()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "SELECT uF.unitFactorId AS unitFactorId
      ,U.unitName AS unitName
      ,uF.unitFactor AS unitFactor
      ,uF.unitId As unitId
      ,uF.unitFactorDescription As unitFactorDescription
      ,uF.createdBy AS createdBy
      ,uF.modifiedBy As modifiedBy
      FROM unitsfactor uF
      JOIN units U ON uF.unitId=U.unitId";

    $result = $connectionObj->query($sql);
    $unitList = [];

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $unitFactor = new unitFactor();
        $unitFactor->set_unitId($row['unitId']);
        $unitFactor->set_unitName($row['unitName']);
        $unitFactor->set_unitFactorId($row['unitFactorId']);
        $unitFactor->set_unitFactor($row['unitFactor']);
        $unitFactor->set_unitFactorDescription($row["unitFactorDescription"]);
        $unitFactor->set_createdby($row["createdBy"]);
        $unitFactor->set_modifiedby($row["modifiedBy"]);
        array_push($unitList, $unitFactor);
      }
    }

    return $unitList;
  }

  public static function update($unitFactor)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "UPDATE unitsfactor SET unitId = ?, unitFactorDescription = ?, unitFactor = ?, createdBy = ?, modifiedBy = ? WHERE unitFactorId = ?";

    if ($stmt = $connectionObj->prepare($sql)) {
      $stmt->bind_param(
        "issssi",
        $unitId,
        $unitFactorDescription,
        $unitFactorValue,
        $createdBy,
        $modifiedBy,
        $unitFactorId
      );

      $unitId = intval($unitFactor->get_unitId());
      $unitFactorDescription = $unitFactor->get_unitFactorDescription();
      $unitFactorValue = $unitFactor->get_unitFactor();
      $createdBy = $unitFactor->get_CreatedBy();
      $modifiedBy = $unitFactor->get_ModifiedBy();
      $unitFactorId = intval($unitFactor->get_unitFactorId());

      if (!$stmt->execute()) {
        error_log("DBunitFactor::update execute error: " . $stmt->error);
      }
      $stmt->close();
    } else {
      error_log("DBunitFactor::update prepare error: " . $connectionObj->error);
    }
  }

  /**
   * Fetch unit factors.
   * If $unitId is provided (non-empty), returns factors for that unit.
   * If $unitId is empty/null, returns all unit factors.
   * Always echoes JSON and sets Content-Type.
   */
  public static function selectUnitsFactor($unitId = null)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $unitFactorList = [];

    if ($unitId !== null && $unitId !== '' && is_numeric($unitId)) {
      $sql = "SELECT unitFactorId, unitFactor 
                FROM unitsfactor 
                WHERE unitId = ? 
                ORDER BY unitFactor ASC";

      if ($stmt = $connectionObj->prepare($sql)) {
        $uid = intval($unitId);
        $stmt->bind_param("i", $uid);
        if ($stmt->execute()) {
          $res = $stmt->get_result();
          while ($row = $res->fetch_assoc()) {
            $unitFactorList[] = $row;
          }
        }
        $stmt->close();
      }
    }

    header('Content-Type: application/json');
    echo json_encode($unitFactorList);
  }


  public static function delete($unitId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();

    $sql = "DELETE FROM unitsfactor WHERE unitFactorId = ?";
    if ($stmt = $connectionObj->prepare($sql)) {
      $id = intval($unitId);
      $stmt->bind_param("i", $id);
      if (!$stmt->execute()) {
        error_log("DBunitFactor::delete execute error: " . $stmt->error);
      }
      $stmt->close();
    } else {
      error_log("DBunitFactor::delete prepare error: " . $connectionObj->error);
    }
  }
  // 🔍 Check if UnitFactor is used in ITEM
  // 🔒 ITEM CHECK (NUMERIC SAFE)
  public static function isUnitFactorMappedToItemById($unitFactorId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    // get unitFactor value
    $stmt = $conn->prepare(
      "SELECT unitFactorId FROM unitsfactor WHERE unitFactorId = ?"
    );
    $stmt->bind_param("i", $unitFactorId);
    $stmt->execute();
    $unitFactor = $stmt->get_result()->fetch_row()[0];
    $stmt->close();

    // compare numerically
    $stmt = $conn->prepare(
      "SELECT COUNT(*) FROM item_details WHERE item_unitFactor = ?"
    );
    $stmt->bind_param("d", $unitFactor);
    $stmt->execute();
    $count = $stmt->get_result()->fetch_row()[0];

    return $count > 0;
  }


  // 🔒 MATERIAL CHECK (NUMERIC SAFE)
  public static function isUnitFactorMappedToMaterialById($unitFactorId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    $stmt = $conn->prepare(
      "SELECT unitFactorId FROM unitsfactor WHERE unitFactorId = ?"
    );
    $stmt->bind_param("i", $unitFactorId);
    $stmt->execute();
    $unitFactor = $stmt->get_result()->fetch_row()[0];
    $stmt->close();

    $stmt = $conn->prepare(
      "SELECT COUNT(*) FROM material WHERE Mat_factor = ?"
    );
    $stmt->bind_param("d", $unitFactor);
    $stmt->execute();
    $count = $stmt->get_result()->fetch_row()[0];

    return $count > 0;
  }




}
