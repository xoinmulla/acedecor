<?php
require_once "../dblayer/dbconnection.php";
require_once "../dblayer/contentOps.php";
require_once "../Utilities/Sanitization.php";

function safe_filename($name) {
    $name = preg_replace('/[^A-Za-z0-9._-]/', '_', $name);
    return time() . "_" . $name;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- Content Add/Edit ---
    if (isset($_POST["action"]) && ($_POST["action"] === "Add" || $_POST["action"] === "Edit")) {

        $content = new Content();
        $content->setTitle(Sanitization::test_input($_POST["title"] ?? ""));
        $content->setParagraph(Sanitization::test_input($_POST["paragraph"] ?? ""));
        $content->setType(Sanitization::test_input($_POST["type"] ?? ""));
        $content->setBrief(Sanitization::test_input($_POST["brief"] ?? ""));

        // Optional single hero image (legacy field)
        $imageName = "";
        if (!empty($_FILES["image"]["name"])) {
            $imageName = safe_filename(basename($_FILES["image"]["name"]));
            $target = "../img/" . $imageName;
            @move_uploaded_file($_FILES["image"]["tmp_name"], $target);
        }
        $content->setImage($imageName);

        if ($_POST["action"] === "Add") {
            DBcontent::insert($content);

            // get last inserted id
            $db = ConnectDb::getInstance()->getConnection();
            $contentId = $db->insert_id;

            // (Optional) directly process media here if the Add modal includes them
            if (!empty($_FILES['media_files']['name'][0])) {
                foreach ($_FILES['media_files']['tmp_name'] as $k => $tmpName) {
                    if (!$_FILES['media_files']['name'][$k]) continue;
                    $filename = safe_filename(basename($_FILES['media_files']['name'][$k]));
                    $targetFile = "../img/Slider/" . $filename;
                    @move_uploaded_file($tmpName, $targetFile);

                    $caption = $_POST['caption'][$k] ?? '';
                    $alt     = $_POST['alt_text'][$k] ?? '';
                    DBcontent::addMedia($contentId, 'image', $filename, null, null, $caption, $alt);
                }
            }

            if (!empty($_POST['video_url'])) {
                foreach ((array)$_POST['video_url'] as $idx => $url) {
                    $url = trim($url);
                    if ($url === '') continue;
                    $caption = $_POST['caption_video'][$idx] ?? '';
                    $alt     = $_POST['alt_text_video'][$idx] ?? '';
                    DBcontent::addMedia($contentId, 'video', null, $url, null, $caption, $alt);
                }
            }

            if (!empty($_FILES['video_file']['name'][0])) {
                foreach ($_FILES['video_file']['tmp_name'] as $k => $tmpName) {
                    if (!$_FILES['video_file']['name'][$k]) continue;
                    $vname = safe_filename(basename($_FILES['video_file']['name'][$k]));
                    $target = "../img/Slider/" . $vname;
                    @move_uploaded_file($tmpName, $target);

                    $caption = $_POST['caption_video_file'][$k] ?? '';
                    $alt     = $_POST['alt_text_video_file'][$k] ?? '';
                    DBcontent::addMedia($contentId, 'video', null, null, $vname, $caption, $alt);
                }
            }

            // redirect as per your logic
            if ($content->getType() === "post") {
                header("Location: ../views/post.php");
            } else {
                header("Location: ../views/content.php");
            }
            exit();
        }

        if ($_POST["action"] === "Edit") {
            $content->setId((int)($_POST["id"] ?? 0));

            // keep old hero image if none uploaded
            if (empty($imageName)) {
                $existing = DBcontent::getContentDetails($content->getId());
                if ($existing) {
                    $content->setImage($existing->getImage());
                }
            }

            DBcontent::update($content);
            header("Location: ../views/content.php");
            exit();
        }
    }

    // --- Media Add (single modal submit) ---
    if (isset($_POST['action']) && $_POST['action'] === 'AddMedia') {
        $contentId = (int)($_POST['content_id'] ?? 0);
        $fileType  = $_POST['fileType'] ?? 'image';
        $caption   = Sanitization::test_input($_POST['media_caption'] ?? '');
        $alt       = Sanitization::test_input($_POST['media_alt'] ?? '');

        if ($fileType === 'image' && !empty($_FILES['media_image']['name'])) {
            $filename = safe_filename(basename($_FILES['media_image']['name']));
            $target   = "../img/Slider/" . $filename;
            @move_uploaded_file($_FILES['media_image']['tmp_name'], $target);
            DBcontent::addMedia($contentId, 'image', $filename, null, null, $caption, $alt);
        } elseif ($fileType === 'video') {
            // prefer URL; otherwise file
            $videoUrl = trim($_POST['media_video_url'] ?? '');
            if ($videoUrl !== '') {
                DBcontent::addMedia($contentId, 'video', null, $videoUrl, null, $caption, $alt);
            } elseif (!empty($_FILES['media_video_file']['name'])) {
                $vname  = safe_filename(basename($_FILES['media_video_file']['name']));
                $target = "../img/Slider/" . $vname;
                @move_uploaded_file($_FILES['media_video_file']['tmp_name'], $target);
                DBcontent::addMedia($contentId, 'video', null, null, $vname, $caption, $alt);
            }
        }

        header("Location: ../views/content.php");
        exit();
    }
}

// --- Media delete ---
if (isset($_GET['action']) && $_GET['action'] === 'deleteMedia' && isset($_GET['id'])) {
    DBcontent::deleteMedia((int)$_GET['id']);
    header("Location: ../views/content.php");
    exit();
}

// --- Content delete ---
if (isset($_GET['action']) && $_GET['action'] === 'Delete' && isset($_GET['id'])) {
    DBcontent::delete((int)$_GET['id']);
    header("Location: ../views/content.php");
    exit();
}

// fallback
header("Location: ../views/content.php");
exit();
