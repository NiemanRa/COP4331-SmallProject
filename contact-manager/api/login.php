<?php

declare(strict_types=1);
use function components\cookies\createCookie;

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/phpErrors.txt');
error_reporting(E_ALL);

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

require './components/db.php';

try {
    $username = $input["username"];
    $password = $input["password"];

    if (!isset($username, $password)) {
        http_response_code(400);
        echo json_encode(["error" => "Username and password are required."]);
        exit;
    }

    $message = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = ?;");
    $message->execute([$username]);
    $user = $message->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user["password_hash"])) {
        http_response_code(401);
        echo json_encode(["error" => "InvalidCredentials"]);
        exit;
    } else {
        require('./components/cookies.php');
        createCookie($pdo, $user["id"]);
        http_response_code(200);

        header("Location: ../contacts", true);
        exit;
    }
    

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while trying to sign in."]);
    exit;
}