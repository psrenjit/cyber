<?php
$host = 'cd-database-1.c1tzojfmrdc3.us-east-1.rds.amazonaws.com';
$db   = 'cyberdome';
$port=3306;
$user = 'admin';
$pass = 'testTEST00';
$charset = 'utf8';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     $insertok = array(
          "status" => true,
          "message" => "internal server error"
      );
}
?>