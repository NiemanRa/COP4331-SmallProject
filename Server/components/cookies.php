<?php
// reminder, $_COOKIE is the location of request cookie in php
declare(strict_types=1);
namespace components\cookies;

// I completely forgot about how php scopes work. Just because db is called globally in file doesn't mean the function call has access (they have their own local scope).
// functions have their own local scope.
// https://www.php.net/manual/en/function.setcookie.php
function createCookie (\PDO $pdo, string $userId) {
    $token = bin2hex(
        random_bytes(32)
    );

    $expires = time() + (60 * 60 * 24);

    // expiration date isn't being stored so sessions are basically permanent (in our db)
    $message = $pdo->prepare("UPDATE users SET token = ? WHERE id = ?");
    $message->execute([$token, $userId]);

    if ($message->rowCount() <= 0) {
        http_response_code(500);
        echo json_encode(["error" => "No user was found with id" . $userId]);
        exit;
    }

    setcookie('authentication', $token, $expires, '/', '', false, true);
}

function deleteCookie (\PDO $pdo, string $token) {
    if (empty($_token)) {
        http_response_code(401);
        echo json_encode(["error" => "Authentication cookie not provided"]);
        exit;
    }

    $message = $pdo->prepare("UPDATE users SET token = ? WHERE token = ?");
    $message->execute(["", $token]);

    if ($message->rowCount() <= 0) {
        http_response_code(500);
        echo json_encode(["error" => "No user was found with id" . $token]);
        exit;
    }

    setcookie('authentication', "", time() - 1000, "/", "", false, true);
}

// https://www.php.net/manual/en/pdostatement.fetch.php
function checkCookie (\PDO $pdo, string $token): int {
    if (empty($token)) {
        http_response_code(401);
        echo json_encode(["error" => "Authentication cookie not provided."]);
        exit;
    }

    $message = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $message->execute([$token]);

    if ($message->rowCount() === 0) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid authentication token provided."]);
        exit;
    }

    $cookieObj = $message->fetch(\PDO::FETCH_OBJ);
    /*if ($cookieObj->expires < time()) {
        deleteCookie($pdo, $token);

        http_response_code(401);
        echo json_encode(["error" => "Authentication token is expired."]);
        exit;
    }

    // we can update expirations here later if we want

    //
    */

    return $cookieObj->id;
}