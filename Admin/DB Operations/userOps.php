<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/usermodel.php";
require_once("../Model/userLoginModel.php");
class DBuser
    {
      public static function insert($userObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "INSERT INTO user (`user_name`, `user_contact`, `user_email`,`user_password`,`user_type`) 
                values ('".$userObj->get_username().
                "','".$userObj->get_usercontact().
                "','".$userObj->get_useremail().
                "','".$userObj->get_userpassword().
                "','".$userObj->get_usertype()."')";
                
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }
      public static function checkUser($userObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "SELECT * FROM  user WHERE user_name = '".$userObj->get_username()."' AND user_password = '".$userObj->get_userpassword()."'";
        $result = $connectionObj->query($sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count==1){
        $userObj->set_usertype($row['user_type']);
        $userObj->set_userstatus($row['user_status']);
        return $userObj;
        }
        return 0;
      }

      public static function getAllUsers(){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "SELECT * FROM  user";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $userList=[];
        if($count>0){
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $user=new User();
            $user->set_id($row["user_id"]);
            $user->set_username($row["user_name"]);
            $user->set_usercontact($row["user_contact"]);
            $user->set_useremail($row["user_email"]);
            $user->set_userpassword($row["user_password"]);
            $user->set_usertype($row["user_type"]);
            $user->set_userstatus($row["user_status"]);
            array_push($userList,$user);
          }
        }
        return $userList;
      }

      public static function update($userObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="UPDATE user SET user_name='".$userObj->get_username().
        "', user_contact='".$userObj->get_usercontact().
        "', user_email='".$userObj->get_useremail().
        "', user_password='".$userObj->get_userpassword().
        "', user_type='".$userObj->get_usertype().
        "', user_status='".$userObj->get_userstatus().
        "' WHERE user_id=".$userObj->get_id();
        echo $sql;
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }

      public static function delete($userObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="DELETE from user where user_id='".$userObj."'";
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }

      }

    }
