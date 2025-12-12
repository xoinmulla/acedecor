
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
    $sql='SELECT unitId,unitName FROM units';
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

  public static function delete($unitId){
    $db=ConnectDb::getInstance();
    $connectionObj=$db->getConnection();
    $sql="DELETE from units where unitId='".$unitId."'";
    if ($connectionObj->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $connectionObj->error;
    }

  }
}
