<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/inputTypeModel.php";

class DBinputType
    {
     
      public static function getMappedInputType($brandId)
      {
    
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql="SELECT I.InputTypeId as InputTypeId,
        I.InputType as InputType,
        Case When TEMP.brandId is null then
        FALSE
        ELSE
        TRUE
        end as brandId
        FROM inputtype as I
        left Join(Select B.brand_id as brandId,
        IB.InputTypeId as InputTypeId 
        FROM
          brands as B
          Left Join inputtype_brand_mapping as IB 
          On 
          B.brand_id=IB.brandId 
          where B.brand_id=".$brandId.") as TEMP On I.InputTypeId=TEMP.InputTypeId
            group by InputType";
          error_log($sql);
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $inputTypelist = [];
        if ($count > 0) {
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $view = new InputType();
            $view->set_InputTypeId($row['InputTypeId']);
            $view->set_InputType($row['InputType']);
            if (($row["brandId"]) == 0) {
              $view->set_isMapped(false);
          } else {
              $view->set_isMapped(true);
          }
            array_push($inputTypelist, $view);
          }
        } else {
          echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($inputTypelist);
      }

      public static function selectInputType()
      {
    
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $result = mysqli_query($db->getConnection(), 'SELECT InputTypeId,InputType FROM inputtype');
   
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
