<?php
require_once "../Model/inputTypeModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/inputTypeOps.php";

if($_SERVER["REQUEST_METHOD"]=="GET"){
    if (isset($_GET['brandId'])) {
        DBinputType::getMappedInputType($_GET['brandId']);
    }else{
        DBinputType::selectInputType();
    }
}
?>
