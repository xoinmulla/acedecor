<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("DB Operations/generalSubcategoryOps.php");

echo "Trying insert...<br>";

$result = DBGeneralSubcategory::add("DIRECT_TEST_VALUE");

var_dump($result);

echo "<br>Done.";
