<?php
require_once "../dblayer/brandSectionOps.php";

if ($_POST['action'] == "Save") {

    $heading = $_POST['heading'];
    $paragraph = $_POST['paragraph'];

    DBbrandSection::save($heading, $paragraph);

    header("Location: ../views/brands.php");
}