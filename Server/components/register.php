<?php
namespace API\accRegister;

require 'db.php';

function processRegistration(string $username, string $pass){
    if (!isset($username, $pass)){
        http_response_code(500);
        echo json_encode(["error" => "Username and password are required."]);
        exit;
    }

    // we can remove this if MYSQL already hashes + salts? I don't think it does.
    // just remembering from writing in node.js that storing plain text is bad
    $hash = password_hash($pass, PASSWORD_DEFAULT);

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