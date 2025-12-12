<?php
$DB_HOST = "127.0.0.1";   // or "localhost"
$DB_NAME = "acedecors";    // your database name
$DB_USER = "root";        // default WAMP user
$DB_PASS = "";            // default WAMP password is empty

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
