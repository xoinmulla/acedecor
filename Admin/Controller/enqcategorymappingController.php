<?php
require_once "../DB Operations/enq_cat_mappingOps.php";
  if($_SERVER["REQUEST_METHOD"] == "GET"){     
    DBenqCatMapping::getCategoryForEnqJson($_GET['id']);
    
  }

?>