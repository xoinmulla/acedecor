<?php 
   class Sanitization 
  { 
    public Static function test_input($data){
      if (!is_string($data)) {
        $data = '';
      }
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = htmlspecialchars_decode($data);
      error_log($data);
      return $data;
    }
  }

?>