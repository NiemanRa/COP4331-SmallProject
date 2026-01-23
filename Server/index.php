<?php
/*
 * api errors should be returned as json w/ "error" tag embedded.
 * please attach correct response code as well (500 = general error, 403 = unauthenticated)
 */
declare(strict_types=1);
error_reporting(E_ERROR | E_PARSE);

// GET for contacts/search
$requestType = $_SERVER['REQUEST_METHOD'];
if ($requestType === "POST") {
    $searchTerm = $_POST["api"];
    $input = json_decode(
        file_get_contents('php://input'),
        true
    );
}

if (!$searchTerm && $requestType === "GET") {
    header('Content-Type: text/html; charset=utf-8');
    $publicFile = "../PUBLIC/" . $_SERVER["PATH_INFO"];

    if ($publicFile == "../PUBLIC/") {
        readfile("../PUBLIC/login.html");
        exit;
    } elseif (file_exists($publicFile)) {
        readfile($publicFile);
    } else {
        http_response_code(404);
    }
    exit;
} elseif ($requestType === "GET") {
    // setup for json and post requests (assuming we use post for login)
    $searchTerm = $_GET["api"];
    header('Content-Type: application/json');
}

require './components/db.php';

// he said in project file that we should have a max of 2 apis, but preferred one. I guess this is how?
if (!$searchTerm){
    http_response_code(404);
    echo json_encode(["error" => "No API provided"]);
    exit;
} else {
    switch ($searchTerm) {
        case 'login': // post
            break;
        case 'register': // post
            require './components/register.php';
            API\accRegister\processRegistration($input['username'], $input['password']);
            break;
        case 'contacts':
            break;
        case 'search':
            break;
        case 'delete': // post
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'API does not exist']);
    }
}