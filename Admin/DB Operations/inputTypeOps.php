<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/inputTypeModel.php";

class DBinputType
{

  public static function getMappedInputType($brandId)
  {
    $db = ConnectDb::getInstance();
    $conn = $db->getConnection();

    // Get brand name first (needed for material table match)
    $brandNameQuery = "SELECT brand_name FROM brands WHERE brand_id = ?";
    $stmt = $conn->prepare($brandNameQuery);
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $stmt->bind_result($brandName);
    $stmt->fetch();
    $stmt->close();

    $sql = "
    SELECT 
        I.InputTypeId,
        I.InputType,
        CASE WHEN IB.brandId IS NULL THEN 0 ELSE 1 END AS isMapped
    FROM inputtype I
    LEFT JOIN inputtype_brand_mapping IB 
        ON I.InputTypeId = IB.InputTypeId 
        AND IB.brandId = ?
    WHERE I.InputTypeId IN (1,2)
";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $result = $stmt->get_result();

    $inputTypelist = [];

    while ($row = $result->fetch_assoc()) {

      $isUsed = false;

      // 🔥 Check usage in inventory
      if (strtolower($row['InputType']) == 'item') {

        $checkItem = $conn->prepare(
          "SELECT COUNT(*) FROM item_details WHERE item_compid = ?"
        );
        $checkItem->bind_param("i", $brandId);
        $checkItem->execute();
        $checkItem->bind_result($count);
        $checkItem->fetch();
        $checkItem->close();

        if ($count > 0) {
          $isUsed = true;
        }
      }

      if (strtolower($row['InputType']) == 'material') {

        $checkMaterial = $conn->prepare(
          "SELECT COUNT(*) FROM material WHERE Brand = ?"
        );
        $checkMaterial->bind_param("i", $brandId);
        $checkMaterial->execute();
        $checkMaterial->bind_result($count);
        $checkMaterial->fetch();
        $checkMaterial->close();

        if ($count > 0) {
          $isUsed = true;
        }
      }


      $view = [
        "InputTypeId" => $row['InputTypeId'],
        "InputType" => $row['InputType'],
        "isMapped" => (bool) $row['isMapped'],
        "isUsed" => $isUsed
      ];

      $inputTypelist[] = $view;
    }

    header('Content-Type: application/json');
    echo json_encode($inputTypelist);
  }


  public static function selectInputType()
  {

    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $result = mysqli_query(
      $db->getConnection(),
      "SELECT InputTypeId, InputType 
     FROM inputtype 
     WHERE InputTypeId IN (1,2)"
    );
    $inputTypelist = [];
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $view = new InputType();
        $view->set_InputTypeId($row['InputTypeId']);
        $view->set_InputType($row['InputType']);
        array_push($inputTypelist, $view);
      }
    } else {
      echo "0 results";
    }
    header('Content-Type: application/json');
    echo json_encode($inputTypelist);
  }
}
