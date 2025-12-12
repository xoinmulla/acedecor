<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/thicknessModel.php";

class DBthickness
    {
      public static function insert($thicknessObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "INSERT INTO thickness (`Thickness`, `Thickness_createdby`, `Thickness_modifiedby`) 
                values ('".$thicknessObj->get_Thickness().
                "','".$thicknessObj->get_Thicknesscreatedby().
                "','".$thicknessObj->get_Thicknessmodifiedby()."')";
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }
      

      public static function getAllthickness(){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "SELECT * FROM  thickness";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $thicknessList=[];
        if($count>0){
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $thickness=new Thickness();
            $thickness->set_ThicknessId($row["Thickness_Id"]);
            $thickness->set_Thickness($row["Thickness"]);
            array_push($thicknessList,$thickness);
          }
        }
        return $thicknessList;
      }

      public static function update($thicknessObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="UPDATE thickness SET Thickness='".$thicknessObj->get_Thickness().
        "' WHERE Thickness_Id=".$thicknessObj->get_ThicknessId();
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }

      public static function delete($thicknessObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="DELETE from thickness where Thickness_Id='".$thicknessObj."'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }

      }


      public static function selectthickness()
      {
    
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $result = mysqli_query($db->getConnection(), 'SELECT Thickness_Id,Thickness FROM thickness');
        $thicknesslist = [];
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $view = new thickness();
            $view->set_ThicknessId($row['Thickness_Id']);
            $view->set_Thickness($row['Thickness']);
            array_push($thicknesslist, $view);
          }
        } else {
          echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($thicknesslist);
      }

  

    
  }
