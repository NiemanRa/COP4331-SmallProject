<?php
/*
 * api errors should be returned as json w/ "error" tag embedded.
 * please attach correct response code as well (500 = general error, 403 = unauthenticated)
 */
declare(strict_types=1);

/*
 * we can also use ini_set(display_errors, 0)
 * then use the tag log_errors (1) w/ error_log, __DIR__ . /phpErrors.txt for document logging
 * error_reporting(E_ALL) // reports everything
 */
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/phpErrors.txt');
error_reporting(E_ALL);

// GET for contacts/search
$requestType = $_SERVER['REQUEST_METHOD'];
if ($requestType === "POST") {
    $searchTerm = $_POST["api"];
    $input = json_decode(
        file_get_contents('php://input'),
        true
    );
} else {
    // setup for json and post requests (assuming we use post for login)
    $searchTerm = $_GET["api"];
    header('Content-Type: application/json');
}

require './components/db.php';

if (!$searchTerm){
    http_response_code(404);
    echo json_encode(["error" => "No API provided"]);
    exit;
} else {
    switch ($searchTerm) {
        case 'edit':
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