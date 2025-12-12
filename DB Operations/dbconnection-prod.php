<?php 
// Singleton to connect db.
class ConnectDb {
  // Hold the class instance.
  private static $instance = null;
  public static function getInstance()
  {
    if (!self::$instance)
    {
      
      self::$instance = new ConnectDb();
    }
    return self::$instance;
  }
  private function __clone(){}
  // [/Singleton]

  private $connection = null;

  private function __construct()
  {
    $this->connection = new mysqli('184.168.97.124','acedecors','Acedecors@123','acedecors');
    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
    
  }
  public function getConnection()
  {
    return $this->connection;
  }
}
?>