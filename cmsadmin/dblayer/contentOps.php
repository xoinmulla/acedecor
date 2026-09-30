<?php

require_once "dbconnection.php";
require_once __DIR__ . "/../model/contentModel.php";

class DBcontent {

    public static function insert($content) {
        $db = ConnectDb::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO contents (title, paragraph, image, type, brief) VALUES (?, ?, ?, ?, ?)");
        $title = $content->getTitle();
        $paragraph = $content->getParagraph();
        $image = $content->getImage();
        $type = $content->getType();
        $brief = $content->getBrief();
        $stmt->bind_param("sssss", $title, $paragraph, $image, $type, $brief);
        $stmt->execute();
        $stmt->close();
    }

    public static function update($content) {
        $db = ConnectDb::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE contents SET title=?, paragraph=?, image=?, brief=? WHERE id=?");
        $title = $content->getTitle();
        $paragraph = $content->getParagraph();
        $image = $content->getImage();
        $brief = $content->getBrief();
        $id = $content->getId();
        $stmt->bind_param("ssssi", $title, $paragraph, $image, $brief, $id);
        $stmt->execute();
        $stmt->close();
    }

    public static function delete($id) {
        $db = ConnectDb::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM contents WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public static function getAll() {
        $db = ConnectDb::getInstance()->getConnection();
        $result = $db->query("SELECT * FROM contents ORDER BY id DESC");
        $contents = [];
        while ($row = $result->fetch_assoc()) {
            $c = new Content();
            $c->setId($row['id']);
            $c->setTitle($row['title']);
            $c->setParagraph($row['paragraph']);
            $c->setImage($row['image']);
            $c->setType($row['type']);
            $c->setBrief($row['brief']); // <-- Add this line
            $contents[] = $c;
        }
        return $contents;
    }

    public static function getLatestContent($type) {
        $db = ConnectDb::getInstance()->getConnection();
        $result = $db->query("SELECT * FROM contents WHERE type='".$type."' ORDER BY id DESC LIMIT 1 ");
        if ($row = $result->fetch_assoc()) {
            $c = new Content();
            $c->setId($row['id']);
            $c->setTitle($row['title']);
            $c->setParagraph($row['paragraph']);
            $c->setImage($row['image']);
            $c->setType($row['type']);
            $c->setBrief($row['brief']); // <-- Add this line
            return $c;
        }
        return null;
    }

    public static function getContentDetails($id) {
        $db = ConnectDb::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM contents WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $c = new Content();
            $c->setId($row['id']);
            $c->setTitle($row['title']);
            $c->setParagraph($row['paragraph']);
            $c->setImage($row['image']);
            $c->setType($row['type']);
            $c->setBrief($row['brief']); // <-- Add this line
            return $c;
        }
        return null;
    }

    // ================= CONTENT MEDIA SUPPORT =================
        public static function getMediaByContent($contentId) {
            $db = ConnectDb::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM content_media WHERE content_id=? ORDER BY id ASC");
            $stmt->bind_param("i", $contentId);
            $stmt->execute();
            $res = $stmt->get_result();
            $rows = [];
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
            $stmt->close();
            return $rows;
        }

        public static function addMedia($contentId, $fileType, $imageFile = null, $videoUrl = null, $videoFile = null, $caption = null, $altText = null) {
            $db = ConnectDb::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO content_media (content_id, file_type, image_file, video_url, video_file, caption, alt_text) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $contentId, $fileType, $imageFile, $videoUrl, $videoFile, $caption, $altText);
            $stmt->execute();
            $stmt->close();
        }

        public static function deleteMedia($id) {
            $db = ConnectDb::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM content_media WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }

}
?>
