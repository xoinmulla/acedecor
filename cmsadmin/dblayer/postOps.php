<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/acedecor/cmsadmin/model/postModel.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/acedecor/cmsadmin/model/subcategorymodel.php");
require_once("dbconnection.php");
class DBpost
{
  public static function insert($post)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $stmt = $connectionObj->prepare(
      "INSERT INTO `post`(
         `postTitle`,
         `postUrl`,
         `appearOnHome`, 
         `postDescription`,
         `LinkUnder`, 
         `postCreatedBy`, 
         `titleTag`, 
         `keywords`,
         `modifiedBy`) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $postTitle = $post->getPostTitle();
    $postUrl = $post->getPostUrl();
    $appearOnHome = $post->getOnHome();
    $postDescription = $post->getPostDescription();
    $linkUnder = $post->getLinkUnder();
    $postCreatedBy = $post->getPostCreatedBy();
    $titleTag = $post->getTitleTag();
    $keywords = $post->getKeywords();
    $modifiedBy = $post->getModifiedBy();

    $stmt->bind_param(
      "ssissssss",
      $postTitle,
      $postUrl,
      $appearOnHome,
      $postDescription,
      $linkUnder,
      $postCreatedBy,
      $titleTag,
      $keywords,
      $modifiedBy
    );
    if ($stmt->execute()) {
      $lastInsertedId = $connectionObj->insert_id;
      $stmt->close();
      $postImage = $post->getImage();
      $createdBy = $post->getPostCreatedBy();
      $modifiedByImg = $post->getModifiedBy();
      $imageAltText = $post->getAltTextImage();

      if (!empty($postImage)) {
        $stmtImg = $connectionObj->prepare(
          "INSERT INTO `postimages`(`postImage`,`createdBy`, `modifiedBy`, `imageAlternateText`, `postId`) VALUES (?, ?, ?, ?, ?)"
        );
        $stmtImg->bind_param(
          "ssssi",
          $postImage,
          $createdBy,
          $modifiedByImg,
          $imageAltText,
          $lastInsertedId
        );
        if ($stmtImg->execute()) {
          $stmtImg->close();
        } else {
          echo "Error: " . $stmtImg->error;
          $stmtImg->close();
        }
      } else {
        error_log("Error: postImage is empty for postId " . $lastInsertedId);
      }

      if ($post->getLinkUnder() == "1") {
        if (is_array($post->getMappedSubCategory())) {
          $count = count($post->getMappedSubCategory());
          $mapped = $post->getMappedSubCategory();
          for ($i = 0; $i < $count; $i++) {
            $stmtMap = $connectionObj->prepare(
              "INSERT INTO `postcatmapping`(`postId`, `CatId`) VALUES (?, ?)"
            );
            $stmtMap->bind_param("ii", $lastInsertedId, $mapped[$i]);
            $stmtMap->execute();
            $stmtMap->close();
          }
        }
      } else {
        if (is_array($post->getMappedSubCategory())) {
          $count = count($post->getMappedSubCategory());
          $mapped = $post->getMappedSubCategory();
          for ($i = 0; $i < $count; $i++) {
            if (!empty($mapped[$i]) && is_numeric($mapped[$i])) {
              $stmtMap = $connectionObj->prepare(
                "INSERT INTO `postsubcatmapping`(`postId`, `subCatId`) VALUES (?, ?)"
              );
              $stmtMap->bind_param("ii", $lastInsertedId, $mapped[$i]);
              $stmtMap->execute();
              $stmtMap->close();
            } else {
              error_log("Error: subCatId is invalid for postId " . $lastInsertedId);
            }
          }
        } else {
          $subCatId = $post->getMappedSubCategory();
          if (!empty($subCatId) && $subCatId !== null && is_numeric($subCatId)) {
            $stmtMap = $connectionObj->prepare(
              "INSERT INTO `postsubcatmapping`(`postId`, `subCatId`) VALUES (?, ?)"
            );
            $stmtMap->bind_param("ii", $lastInsertedId, $subCatId);
            $stmtMap->execute();
            $stmtMap->close();
          } else {
            error_log("Error: subCatId is null, empty, or invalid for postId " . $lastInsertedId);
          }
        }
      }
    } else {
      echo "Error: " . $stmt->error;
      $stmt->close();
    }
  }

  public static function getPostByCategoryFornt($CatId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM postcatmapping
    JOIN category ON 
    postcatmapping.CatId=category.CategoryId
    JOIN  post ON postcatmapping.postId=post.postId
    JOIN postimages AS pI ON post.postId=pI.postId
    WHERE category.CategoryId=" . $CatId;
    
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $postList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post = new Post();
        $post->setPostId($row["postId"]);
        $post->setPostTitle($row["postTitle"]);
        $post->setPostDescription($row["postDescription"]);
        $post->setPostCreatedBy($row["postCreatedOn"]);
        $post->setKeywords($row["keywords"]);
        $post->setTitleTag($row["titleTag"]);
        $post->setImage($row["postImage"]);
        $post->setPostUrl($row["postUrl"]);
        $post->setOnHome($row["appearOnHome"]);
        $post->setAltTextImage($row["imageAlternateText"]);
        $post->setPostCreatedBy(date_format(date_create($row["postCreatedOn"]), "d-m-Y"));
        $post->setMappedSubCategory(DBpost::getMappedSubCategories($row["postId"]));
        array_push($postList, $post);
      }
    }
    return $postList;
  }
  public static function getPostBySubCategoryFornt($subId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM postsubcatmapping
    JOIN subcategory ON 
    postsubcatmapping.subCatId=subcategory.subCategoryId
    JOIN  post ON postsubcatmapping.postId=post.postId
    JOIN postimages AS pI ON post.postId=pI.postId
    WHERE subcategory.subCategoryId = ?";
    $stmt = $connectionObj->prepare($sql);
    $stmt->bind_param("i", $subId);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = mysqli_num_rows($result);
    $postList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post = new Post();
        $post->setPostId($row["postId"]);
        $post->setPostTitle($row["postTitle"]);
        $post->setPostDescription($row["postDescription"]);
        $post->setPostCreatedBy($row["postCreatedOn"]);
        $post->setKeywords($row["keywords"]);
        $post->setTitleTag($row["titleTag"]);
        $post->setImage($row["postImage"]);
        $post->setPostUrl($row["postUrl"]);
        $post->setOnHome($row["appearOnHome"]);
        $post->setAltTextImage($row["imageAlternateText"]);
        $post->setPostCreatedBy(date_format(date_create($row["postCreatedOn"]), "d-m-Y"));
        $post->setMappedSubCategory(DBpost::getMappedSubCategories($row["postId"]));
        array_push($postList, $post);
      }
    }
    return $postList;
  }
  public static function getPostBySubCategoryId($postId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM postsubcatmapping
    JOIN subcategory ON 
    postsubcatmapping.subCatId=subcategory.subCategoryId
    JOIN  post ON postsubcatmapping.postId=post.postId
    JOIN postimages AS pI ON post.postId=pI.postId
    WHERE post.postId <> ? AND post.appearOnHome = 1";
    $stmt = $connectionObj->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = mysqli_num_rows($result);
    $postList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post = new Post();
        $post->setPostId($row["postId"]);
        $post->setPostTitle($row["postTitle"]);
        $post->setPostDescription($row["postDescription"]);
        $post->setPostCreatedBy($row["postCreatedOn"]);
        $post->setKeywords($row["keywords"]);
        $post->setTitleTag($row["titleTag"]);
        $post->setImage($row["postImage"]);
        $post->setPostUrl($row["postUrl"]);
        $post->setOnHome($row["appearOnHome"]);
        $post->setAltTextImage($row["imageAlternateText"]);
        $post->setPostCreatedBy(date_format(date_create($row["postCreatedOn"]), "d-m-Y"));
        $post->setMappedSubCategory(DBpost::getMappedSubCategories($row["postId"]));
        array_push($postList, $post);
      }
    }
    $stmt->close();
    return $postList;
  }
  public static function getPostByUrl($postUrl)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT *  FROM post AS p 
    JOIN postimages AS pI ON p.postId= pI.postId 
    WHERE p.postUrl='" . $postUrl . "'";
    
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $post = new Post();
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post->setPostId($row["postId"]);
        $post->setPostTitle($row["postTitle"]);
        $post->setPostDescription($row["postDescription"]);
        $post->setPostCreatedBy($row["postCreatedOn"]);
        $post->setKeywords($row["keywords"]);
        $post->setTitleTag($row["titleTag"]);
        $post->setImage($row["postImage"]);
        $post->setOnHome($row["appearOnHome"]);
        $post->setAltTextImage($row["imageAlternateText"]);
        $post->setMappedSubCategory(DBpost::getMappedSubCategories($row["postId"]));
      }
    }
    return $post;
  }
  public static function getPostById($Id)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT *  FROM post AS p JOIN postimages AS pI ON p.postId=pI.postId WHERE p.postId=" . $Id;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $post = new Post();
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post->setPostId($row["postId"]);
        $post->setPostTitle($row["postTitle"]);
        $post->setPostDescription($row["postDescription"]);
        $post->setPostCreatedBy($row["postCreatedOn"]);
        $post->setKeywords($row["keywords"]);
        $post->setTitleTag($row["titleTag"]);
        $post->setPostUrl($row["postUrl"]);
        $post->setOnHome($row["appearOnHome"]);
        $post->setImage($row["postImage"]);
        $post->setAltTextImage($row["imageAlternateText"]);
        $post->setLinkUnder($row["LinkUnder"]);
        $post->setMappedSubCategory(DBpost::getMappedSubCategories($row["postId"]));
      }
    }
    return $post;
  }
  public static function getPostList()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT *  FROM post AS p JOIN postimages AS pI ON p.postId=pI.postId";
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $postList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post = new Post();
        $post->setPostId($row["postId"]);
        $post->setPostTitle($row["postTitle"]);
        $post->setPostDescription($row["postDescription"]);
        $post->setPostCreatedBy($row["postCreatedOn"]);
        $post->setKeywords($row["keywords"]);
        $post->setTitleTag($row["titleTag"]);
        $post->setImage($row["postImage"]);
        $post->setAltTextImage($row["imageAlternateText"]);
        $post->setMappedSubCategory(DBpost::getMappedSubCategories($row["postId"]));
        array_push($postList, $post);
      }
    }
    return $postList;
  }
  public static function getMappedSubCategories($postId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT subCategoryName, 
    subCategoryId FROM postsubcatmapping 
    JOIN subcategory ON 
    postsubcatmapping.subCatId=subcategory.subCategoryId 
    WHERE postsubcatmapping.postId=" . $postId;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $count = mysqli_num_rows($result);
    $mappedCategoriesList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $subCategory = new Subcategory();
        $subCategory->setSubCategoryId($row['subCategoryId']);
        $subCategory->setSubCategoryName($row['subCategoryName']);
        array_push($mappedCategoriesList, $subCategory);
      }
    }
    return $mappedCategoriesList;
  }
 


  public static function getPostOnHome()
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "SELECT * FROM   post
    JOIN postimages AS pI ON post.postId=pI.postId
    WHERE post.appearOnHome=" . 1;
    $result = $connectionObj->query($sql);
    $count = mysqli_num_rows($result);
    $postList = [];
    if ($count > 0) {
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $post = new Post();
        $post->setPostId($row["postId"]);
        $post->setPostTitle($row["postTitle"]);
        $post->setPostDescription($row["postDescription"]);
        $post->setPostCreatedBy($row["postCreatedOn"]);
        $post->setKeywords($row["keywords"]);
        $post->setTitleTag($row["titleTag"]);
        $post->setImage($row["postImage"]);
        $post->setPostUrl($row["postUrl"]);
        $post->setOnHome($row["appearOnHome"]);
        $post->setAltTextImage($row["imageAlternateText"]);
        $post->setPostCreatedBy(date_format(date_create($row["postCreatedOn"]), "d-m-Y"));
        $post->setMappedSubCategory(DBpost::getMappedSubCategories($row["postId"]));
        array_push($postList, $post);
      }
    }
    return $postList;
  }
  public static function update($post)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "UPDATE `post` SET 
    `postTitle`='" . $post->getPostTitle() .
      "', `postUrl`='" . $post->getPostUrl() .
      "', `appearOnHome`='" . $post->getOnHome() .
      "', `postDescription`='" . $post->getPostDescription() .
      "', `LinkUnder`='" . $post->getLinkUnder() .
      "', `titleTag`='" . $post->getTitleTag() .
      "', `keywords`='" . $post->getKeywords() .
      "', `modifiedBy`='" . $post->getModifiedBy() .
      "' WHERE `postId`=" . $post->getPostId();
    
    if ($connectionObj->query($sql) === true) {
      if (!empty($post->getImage())) {
        $sql = "UPDATE `postimages` SET `postImage`='" . $post->getImage() .
          "' , `modifiedBy`='" . $post->getModifiedBy() .
          "' , `imageAlternateText`='" . $post->getAltTextImage() .
          "' WHERE `postId`=" . $post->getPostId();
        if ($connectionObj->query($sql) === true) {
        }
      }

      error_log($post->getLinkUnder());
      if ($post->getLinkUnder() == "1") {
        $sql = "DELETE FROM postcatmapping WHERE postId=". $post->getPostId();
        if ($connectionObj->query($sql) === true) {
        }
        if (is_array($post->getMappedSubCategory())) {
          $count = count($post->getMappedSubCategory());
          $mapped = $post->getMappedSubCategory();
         
          for ($i = 0; $i < $count; $i++) {
            $sql = "INSERT INTO `postcatmapping`(`postId`, `CatId`) VALUES (" .
              $post->getPostId() .
              "," . $mapped[$i] . ")";
            if ($connectionObj->query($sql) === true) {
            }
          }
        }else {
          $sql = "INSERT INTO `postcatmapping`(`postId`, `CatId`) VALUES (" .
          $post->getPostId() .
            "," . $post->getMappedSubCategory() . ")";
          if ($connectionObj->query($sql) === true) {
          }
        }
      } else {
        $sql = "DELETE FROM postsubcatmapping WHERE postId=". $post->getPostId();
        if ($connectionObj->query($sql) === true) {
        }
        if (is_array($post->getMappedSubCategory())) {
          $count = count($post->getMappedSubCategory());
          $mapped = $post->getMappedSubCategory();
          for ($i = 0; $i < $count; $i++) {
            $sql = "INSERT INTO `postsubcatmapping`(`postId`, `subCatId`) VALUES (" .
            $post->getPostId() .
              "," . $mapped[$i] . ")";
            if ($connectionObj->query($sql) === true) {
            }
          }
        } else {
          $subCatId = $post->getMappedSubCategory();
          if (!empty($subCatId) && $subCatId !== null && is_numeric($subCatId)) {
            $sql = "INSERT INTO `postsubcatmapping`(`postId`, `subCatId`) VALUES (" .
              $post->getPostId() .
              "," . $subCatId . ")";
            if ($connectionObj->query($sql) === true) {
            }
          } else {
            error_log("Error: subCatId is null, empty, or invalid for postId " . $post->getPostId());
          }
        }
      }
    }
  }
  public static function delete($postId)
  {
    $db = ConnectDb::getInstance();
    $connectionObj = $db->getConnection();
    $sql = "DELETE FROM postsubcatmapping WHERE postId=" . $postId;
    if ($connectionObj->query($sql) === true) {
      $sql = "DELETE FROM postimages WHERE postId=" . $postId;
      if ($connectionObj->query($sql) === true) {
      }
      $sql = "DELETE FROM post WHERE postId=" . $postId;
      if ($connectionObj->query($sql) === true) {
      }
    }
  }
}
