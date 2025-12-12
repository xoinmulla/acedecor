<?php
require_once "../Model/CLDimensionModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/CLDimensionOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedCLDimensionId'])) {
        $CL = new CLDimension();
        error_log($_POST['editedCLDimensionId']);
        $CL->setCL_Dimensions(Sanitization::test_input($_POST["CLDimensions"]));
        $CL->setID(Sanitization::test_input($_POST['editedCLDimensionId']));
        DBCLDimensions::update($CL);
    } else if ($_POST["action"] == 'delete') {
        error_log($_POST["id"]);
        DBCLDimensions::delete($_POST["id"]);
    } else {
        $CL = new CLDimension();
        $CL->setCL_Dimensions(Sanitization::test_input($_POST["CLDimensionside"]));
       
        DBCLDimensions::insert($CL);
    }
   
    header("location:../View/CLDimension.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

    DBCLDimensions::selectCLDimensions();
}

?>
