<?php
$dbms = 'mysql';
$host = 'localhost';
$dbName = 'book';
$user = 'root';
$pass = '';
$dsn = "$dbms:host=$host;dbname=$dbName;charset=utf8";

try {

    $options = array(
        PDO::ATTR_PERSISTENT => false,
        // 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    );
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("error!:" . $e->getMessage() . "<br/>");
}
