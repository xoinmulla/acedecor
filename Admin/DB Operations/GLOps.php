<?php
require_once "../DB Operations/dbconnection.php";
require_once "../Model/GLModel.php";
class DBGL
{
    public static function insert($GL)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "INSERT INTO gl (`GL`) 
                values ('". $GL->getGL() ."')";
            error_log($sql);
        if ($connectionObj->query($sql) === true) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }

    public static function getAllGL()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "SELECT * FROM gl";

        $result = $connectionObj->query($sql);
        $count = mysqli_num_rows($result);
        $GLList = [];
        if ($count > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $GL = new GL();
                $GL->setGL_Id($row['GL_Id']);
                $GL->setGL($row['GL']);
                array_push($GLList, $GL);
            }
        } else {
            // echo "0 results";
        }
        return $GLList;
    }

    public static function update($GL)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "UPDATE gl SET GL='" . $dimension->getGL() .
            "' WHERE GL_Id =" . $dimension->getGL_Id();

        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
    public static function selectGLs()
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = 'SELECT GL,GL_Id FROM gl';
        $result = mysqli_query($db->getConnection(), $sql);
        $GLList = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $GL = new GL();
                $GL->setGL_Id($row['GL_Id']);
                $GL->setGL($row['GL']);
                array_push($GLList, $GL);
            }
        } else {
            echo "0 results";
        }
        header('Content-Type: application/json');
        echo json_encode($GLList);
    }

    public static function delete($GLId)
    {
        $db = ConnectDb::getInstance();
        $connectionObj = $db->getConnection();
        $sql = "DELETE from gj where GL_Id='" . $GLId . "'";
        error_log($sql);
        if ($connectionObj->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $connectionObj->error;
        }
    }
}