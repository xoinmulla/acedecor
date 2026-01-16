<?php
require_once("dbconnection.php");
require_once(__DIR__ . "/../Model/generalSubcategoryModel.php");

class DBGeneralSubcategory
{
    private static function conn()
    {
        return ConnectDb::getInstance()->getConnection();
    }

    public static function add($name)
    {
        $conn = self::conn();
        error_log("Adding general subcategory with name: " . $name);

        $stmt = $conn->prepare(
            "INSERT INTO general_subcategory (subcategory_name, category)
             VALUES (?, 'General')"
        );

        if (!$stmt) {
            die("PREPARE ERROR: " . $conn->error);
        }

        $stmt->bind_param("s", $name);

        if (!$stmt->execute()) {
            die("EXECUTE ERROR: " . $stmt->error);
        }

        return true;
    }

    public static function getAll()
    {
        $conn = self::conn();
        $result = $conn->query(
            "SELECT * FROM general_subcategory ORDER BY id DESC"
        );

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $obj = new GeneralSubcategory();
            $obj->setId($row['id']);
            $obj->setName($row['subcategory_name']);
            $obj->setCategory($row['category']);
            $data[] = $obj;
        }
        return $data;
    }


    public static function update($id, $name)
    {
        $conn = self::conn();
        $stmt = $conn->prepare(
            "UPDATE general_subcategory SET subcategory_name = ? WHERE id = ?"
        );
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public static function delete($id)
    {
        $conn = self::conn();
        $stmt = $conn->prepare(
            "DELETE FROM general_subcategory WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>