<?php
$host = "0.0.0.0";
$port = "3306";
$dbName = "test";
$user = "root";
$password = "root";
$charset = "utf8";

$dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=$charset";
$options = []; // edit later, no clue

try{
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e){
    http_response_code(500);
    echo json_encode([
        "error" => "Connection failed, please try again later: " . $e->getMessage()
    ]);
    exit;
}