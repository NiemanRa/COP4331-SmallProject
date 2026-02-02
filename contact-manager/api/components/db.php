<?php
$env = parse_ini_file("../../../.env");
$charset = "utf8";

$dsn = "mysql:host={$env['HOST']};port={$env['PORT']};dbname={$env['DB_NAME']};charset=$charset";
$options = []; // edit later, no clue

try{
    $pdo = new PDO($dsn, $env["USER"], $env["PASSWORD"], $options);
} catch (PDOException $e){
    http_response_code(500);
    echo json_encode([
        "error" => "Connection failed, please try again later: " . $e->getMessage()
    ]);
    exit;
}