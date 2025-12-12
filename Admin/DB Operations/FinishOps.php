<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/FinishModel.php";

class DBFinish
    {
      public static function insert($finishObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "INSERT INTO finish (`Finish`, `CreatedBy`, `ModifiedBy`) 
                values ('".$finishObj->getFinish().
                "','".$finishObj->getCreatedBy().
                "','".$finishObj->getModifiedBy().
                 "')";
                 error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }
      

      public static function getAllFinish(){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "SELECT * FROM  finish";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $FinishList=[];
        if($count>0){
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $finish=new Finish();
            $finish->setFinishId($row["FinishId"]);
            $finish->setFinish($row["Finish"]);
            array_push($FinishList,$finish);
          }
        }
        return $FinishList;
      }

      public static function update($finishObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="UPDATE finish SET Finish='".$finishObj->getFinish()."'
        WHERE FinishId=".$finishObj->getFinishId();
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }

      public static function delete($finishObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="DELETE from finish where FinishId='".$finishObj."'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }

      }


      public static function selectfinish()
      {
    
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $result = mysqli_query($db->getConnection(), 'SELECT FinishId,Finish FROM finish');
        $finishlist = [];
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $view = new finish();
            $view->setFinishId($row['FinishId']);
            $view->setFinish($row['Finish']);
            array_push($finishlist, $view);
          }
        } else {
          echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($finishlist);
      }

  

    
  }
