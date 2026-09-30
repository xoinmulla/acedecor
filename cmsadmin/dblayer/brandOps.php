<?php

require_once __DIR__ . "/dbconnection.php";
require_once __DIR__ . "/../model/brandModel.php";

class DBbrand
{

    public static function getAll()
    {
        $db = ConnectDb::getInstance()->getConnection();
        $result = $db->query("SELECT * FROM cms_brands WHERE status=1 ORDER BY id DESC");

        $brands = [];
        while ($row = $result->fetch_assoc()) {
            $b = new Brand();
            $b->setId($row['id']);
            $b->setName($row['name']);
            $b->setImage($row['image']);
            $brands[] = $b;
        }

        return $brands;
    }

    public static function insert($name, $image)
    {
        $db = ConnectDb::getInstance()->getConnection();

        $stmt = $db->prepare(
            "INSERT INTO cms_brands (name, image) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $name, $image);

        return $stmt->execute();
    }

    public static function delete($id)
    {
        $db = ConnectDb::getInstance()->getConnection();

        return $db->query(
            "DELETE FROM cms_brands WHERE id=" . (int) $id
        );
    }
}