<?php 
class ConnectDb {
  private static $instance = null;
  private $connection = null;

  private function __construct()
  {
    $this->connection = new mysqli('localhost','root','','acedecors');
    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance = new ConnectDb();
    }
    return self::$instance;
  }

  private function __clone(){}

  public function getConnection()
  {
    return $this->connection;
  }
}
?>
