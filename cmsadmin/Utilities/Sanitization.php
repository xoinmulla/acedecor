<?php 
   class Sanitization 
  { 
    public static function test_input($data){
      if (!is_string($data)) {
        $data = (string)$data;
      }
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = htmlspecialchars_decode($data);
      $data = str_replace("'", "''", $data);
      return $data;
    }
  }
?>