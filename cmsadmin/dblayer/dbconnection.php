<?php
// dbconnection.php

if (!class_exists('ConnectDb')) {
    class ConnectDb {
        private static $instance = null;
        private $connection = null;

        private function __construct() {
            $this->connection = new mysqli('localhost','root','','acedecors');
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
        }

        private function __clone() {}

        public static function getInstance() {
            if (!self::$instance) {
                self::$instance = new ConnectDb();
            }
            return self::$instance;
        }

        public function getConnection() {
            return $this->connection;
        }
    }
}
