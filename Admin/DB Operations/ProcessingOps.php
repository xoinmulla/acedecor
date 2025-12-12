<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/ProcessingModel.php";

class DBProcessing
    {
      public static function insert($ProcessingObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "INSERT INTO processing (`Processing`, `CreatedBy`, `ModifiedBy`) 
                values ('".$ProcessingObj->getProcessing().
                "','".$ProcessingObj->getCreatedBy().
                "','".$ProcessingObj->getModifiedBy().
                 "')";
                 error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }
      

      public static function getAllProcessing(){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "SELECT * FROM  processing";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $ProcessingList=[];
        if($count>0){
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $Processing=new Processing();
            $Processing->setProcessingId($row["ProcessingId"]);
            $Processing->setProcessing($row["Processing"]);
            array_push($ProcessingList,$Processing);
          }
        }
        return $ProcessingList;
      }

      public static function update($ProcessingObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="UPDATE processing SET Processing='".$ProcessingObj->getProcessing()."'
        WHERE ProcessingId=".$ProcessingObj->getProcessingId();
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }

      public static function delete($ProcessingObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="DELETE from processing where ProcessingId='".$ProcessingObj."'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }

      }


      public static function selectProcessing()
      {
    
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $result = mysqli_query($db->getConnection(), 'SELECT ProcessingId,Processing FROM processing');
        $Processinglist = [];
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $view = new Processing();
            $view->setProcessingId($row['ProcessingId']);
            $view->setProcessing($row['Processing']);
            array_push($Processinglist, $view);
          }
        } else {
          echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($Processinglist);
      }

  

    
  }
