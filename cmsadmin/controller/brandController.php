<?php
require_once "../dblayer/brandOps.php";

if ($_POST['action'] == "Add") {

    $name = $_POST['name'];
    $image = "";

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../img/brands/" . $image);
    }

    DBbrand::insert($name, $image);
    header("Location: ../views/brands.php");
}

if (isset($_GET['delete'])) {
    DBbrand::delete($_GET['delete']);
    header("Location: ../views/brands.php");
}