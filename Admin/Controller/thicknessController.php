<?php
require_once "../Model/thicknessModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/thicknessOps.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ThicknessId'])) {
        $thickness = new Thickness();
        error_log($_POST['brandid']);
        $thickness->set_Thickness(Sanitization::test_input($_POST["Thickness"]));
        $thickness->set_ThicknessId(Sanitization::test_input($_POST['ThicknessId']));
        $thickness->set_Thicknesscreatedby(Sanitization::test_input($_POST["Thicknesscreatedby"]));
        $thickness->set_Thicknessmodifiedby(Sanitization::test_input($_POST["Thicknessmodifiedby"]));
        DBthickness::update($thickness);
    } else if ($_POST["action"] == 'delete') {
        DBthickness::delete($_POST["id"]);
    } else {
        $thickness = new Thickness();
        $thickness->set_Thickness(Sanitization::test_input($_POST["Thickness"]));
        $thickness->set_Thicknesscreatedby(Sanitization::test_input($_POST["Thicknesscreatedby"]));
        $thickness->set_Thicknessmodifiedby(Sanitization::test_input($_POST["Thicknessmodifiedby"]));
        DBthickness::insert($thickness);
    }
    header("location: ../View/thickness.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

    DBthickness::selectThickness();
}

?>
