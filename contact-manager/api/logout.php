<?php

use function components\cookies\deleteCookie;
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/phpErrors.txt');
error_reporting(E_ALL);


require './components/db.php';

try {
    $token = $_COOKIE['authentication'];

    if (!$token) {
        http_response_code(400);
        echo json_encode(["error" => "NoSession"]);
        exit;
    } else {
        require('./components/cookies.php');

        // delete cookie from db and browser
        deleteCookie($pdo, $token);


        http_response_code(200);
        exit;
    }
    

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred while trying to sign out."]);
    exit;
}
?>