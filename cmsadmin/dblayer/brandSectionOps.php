<?php
require_once __DIR__ . "/dbconnection.php";
require_once __DIR__ . "/../model/brandSectionModel.php";
class DBbrandSection
{

    public static function get()
    {
        $db = ConnectDb::getInstance()->getConnection();
        $result = $db->query("SELECT * FROM cms_brand_section LIMIT 1");

        if ($row = $result->fetch_assoc()) {
            $s = new BrandSection();
            $s->setId($row['id']);
            $s->setHeading($row['heading']);
            $s->setParagraph($row['paragraph']);
            return $s;
        }
        return null;
    }

    public static function save($heading, $paragraph)
    {
        $db = ConnectDb::getInstance()->getConnection();

        $check = $db->query("SELECT id FROM cms_brand_section LIMIT 1");

        if ($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $stmt = $db->prepare("UPDATE cms_brand_section SET heading=?, paragraph=? WHERE id=?");
            $stmt->bind_param("ssi", $heading, $paragraph, $row['id']);
        } else {
            $stmt = $db->prepare("INSERT INTO cms_brand_section (heading, paragraph) VALUES (?, ?)");
            $stmt->bind_param("ss", $heading, $paragraph);
        }

        return $stmt->execute();
    }
}