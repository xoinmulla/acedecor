<?php
// ...existing code...

class DBpost {
    // ...existing code...

    // Get all images for a post
    public static function getPostImages($postId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT postImageId, postImage, imageAlternateText FROM postimages WHERE postId = ?");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add an image for a post
    public static function addPostImage($postId, $fileName, $altText = '') {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO postimages (postImage, imageAlternateText, postId, createdOn) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$fileName, $altText, $postId]);
    }

    // ...existing code...
}