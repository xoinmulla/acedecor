<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/taskModel.php";

class DBTask
    {
      public static function insert($taskObj)
      {
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "INSERT INTO projecttasks (`Date`, `TaskDescription`, `ContactPerson`,`ContactNo`,`Status`,`Task_modifiedBy`,`Task_createdBy`) 
                values ('".$taskObj->get_Date().
                "','".$taskObj->get_TaskDescription().
                "','".$taskObj->get_ContactPerson().
                "','".$taskObj->get_ContactNo().
                "','".$taskObj->get_Status().
                "','".$taskObj->get_TaskmodifiedBy().
                "','".$taskObj->get_TaskcreatedBy().
                 "')";
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }
      

      public static function getAllTasks(){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql = "SELECT * FROM  projecttasks";
        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $TaskList=[];
        if($count>0){
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $task=new Task();
            $task->set_TaskId($row["TaskId"]);
            $task->set_Date($row["Date"]);
            $task->set_TaskDescription($row["TaskDescription"]);
            $task->set_ContactPerson($row["ContactPerson"]);
            $task->set_ContactNo($row["ContactNo"]);
            $task->set_Status($row["Status"]);
            array_push($TaskList,$task);
          }
        }
        return $TaskList;
      }

      public static function update($taskObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="UPDATE projecttasks SET Date='".$taskObj->get_Date()."',
        TaskDescription='".$taskObj->get_TaskDescription()."',
        Status='".$taskObj->get_Status()."',
        ContactPerson='".$taskObj->get_ContactPerson()."',
        ContactNo='".$taskObj->get_ContactNo()."'
        WHERE TaskId=".$taskObj->get_TaskId();
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
      }

      public static function delete($taskObj){
        $db=ConnectDb::getInstance();
        $connectionObj=$db->getConnection();
        $sql="DELETE from  projecttasks where TaskId='".$taskObj."'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
          echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }

      }


      public static function selecttask()
      {
    
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $result = mysqli_query($db->getConnection(), 'SELECT task_Id,task FROM task');
        $tasklist = [];
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $view = new task();
            $view->set_taskId($row['task_Id']);
            $view->set_task($row['task']);
            array_push($tasklist, $view);
          }
        } else {
          echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($tasklist);
      }

  

    
  }
