<?php
require_once "../Model/GLModel.php";
require_once "../Utilities/Sanitization.php";
require_once "../DB Operations/GLOps.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editGLId'])) {
        $GL = new GL();
        error_log($_POST['editGLId']);
        $GL->setGL(Sanitization::test_input($_POST["GLs"]));
        $GL->setGL_Id(Sanitization::test_input($_POST['editGLId']));
        DBGL::update($GL);

    } else if ($_POST["action"] == 'delete') {
        error_log($_POST["id"]);
        DBGL::delete($_POST["id"]);

    } else {
        $GL = new GL();
        $GL->setGL(Sanitization::test_input($_POST["GL"]));
        DBGL::insert($GL);
    }
   
    header("location:../View/GL.php");
}
if($_SERVER["REQUEST_METHOD"]=="GET"){

    DBGL::selectGLs();
}

?>
