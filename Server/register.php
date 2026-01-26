<?php
namespace API\accRegister;

require './components/db.php';

/*
 * cookie notes:
 * cookie val should be bin2hex(random_bytes(32))
 * use time() for expiration
 * path should be '/'
 * domain should be left empty for current domain
 * secure must be true when using https (server is hosting) and not when testing locally
 * httpOnly = true prevents js from accessing the cookie (which isn't needed as the browser will append it to all requests
 *
 * setcookie func
 * $_COOKIE is the location of request cookie
 */

function processRegistration(string $username, string $pass){
    if (!isset($pdo)){
        http_response_code(500);
        echo json_encode(['error' => 'Failed to connect to database']);
        exit;
    }


    if (!isset($username, $pass)){
        http_response_code(500);
        echo json_encode(["error" => "Username and password are required."]);
        exit;
    }

    // we can remove this if MYSQL already hashes + salts? I don't think it does.
    // just remembering from writing in node.js that storing plain text is bad
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    // $pdo::prepare("INSERT INTO users (username, password, )");

    try{
        // sql here
        exit;
    } catch (\PDOException $exception) {
        $errorCode = $exception->getCode();
        http_response_code(500);
        // fill with cases, not sure what they all are, googled already existing key code
        switch ($errorCode) {
            case 23000:
                echo json_encode(["error" => "Username already taken."]);
                break;
            default:
                http_response_code(500);
        }
    }
}