<?php
require_once("../model/postModel.php");
require_once("../dblayer/postOps.php");
require_once "../Utilities/Sanitization.php";
require_once "../Utilities/Helper.php";
require_once("../../vendor/autoload.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['postId'])) {
    // ---------- UPDATE ----------
    $post = new Post();
    $post->setPostId(Sanitization::test_input($_POST["postId"]));
    $post->setPostTitle(Sanitization::test_input($_POST["title"]));
    $post->setTitleTag(Sanitization::test_input($_POST["titleTag"]));
    $post->setLinkUnder(Sanitization::test_input($_POST["LinkUnder"]));

    // ✅ Safe handling for checkbox
    $post->setOnHome(isset($_POST["onHome"]) ? 1 : 0);

    $post->setPostUrl(Sanitization::test_input($_POST["postURL"]));
    $quill_json = str_replace("'", "''", $_POST['hidden_element']);

    try {
      $quill = new DBlackborough\Quill\Render($quill_json, 'HTML');
      $result = $quill->render();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    $post->setPostDescription($result);
    $post->setKeywords(Sanitization::test_input($_POST["Keywords"]));
    $post->setMappedSubCategory(isset($_POST["category"]) ? $_POST["category"] : null);
    $post->setPostCreatedBy(Sanitization::test_input($_POST["postcreatedby"]));
    $post->setModifiedBy(Sanitization::test_input($_POST["postmodifiedby"]));
    $post->setAltTextImage(Sanitization::test_input($_POST["alttext"]));

    if (isset($_FILES["image"])) {
      $filetoupload = $_FILES["image"];
      Helper::fileupload($filetoupload, "../img/Post/");
      $post->setImage($_FILES["image"]['name']);
    }
    DBpost::update($post);

  } else if ($_POST['action'] == "delete") {
    error_log($_POST["id"]);
    DBpost::delete($_POST["id"]);

  } else {
    // ---------- INSERT ----------
    $post = new Post();
    $post->setPostTitle(Sanitization::test_input($_POST["title"]));
    $post->setTitleTag(Sanitization::test_input($_POST["titleTag"]));
    $post->setPostUrl(Sanitization::test_input($_POST["postURL"]));

    // ✅ Safe handling for checkbox
    $post->setOnHome(isset($_POST["onHome"]) ? 1 : 0);

    $quill_json = str_replace("'", "''", $_POST['hidden_element']);
    try {
      $quill = new DBlackborough\Quill\Render($quill_json, 'HTML');
      $result = $quill->render();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    $post->setPostDescription($result);
    $post->setKeywords(Sanitization::test_input($_POST["Keywords"]));
    $post->setMappedSubCategory(isset($_POST["category"]) ? $_POST["category"] : null);
    $post->setLinkUnder(Sanitization::test_input($_POST["LinkUnder"]));
    $post->setPostCreatedBy(Sanitization::test_input($_POST["postcreatedby"]));
    $post->setModifiedBy(Sanitization::test_input($_POST["postmodifiedby"]));
    $post->setAltTextImage(Sanitization::test_input($_POST["alttext"]));

    if (isset($_FILES["image"])) {
      $filetoupload = $_FILES["image"];
      Helper::fileupload($filetoupload, "../img/Post/");
      $post->setImage($_FILES["image"]['name']);
    }
    DBpost::insert($post);
  }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
}

header("location:../views/post.php");
