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

    // expiration date must be saved
    // temp table until we make one up
    // need to declare this for my ide
    $message = $pdo->prepare("INSERT INTO sessions (user_id, token, expires) VALUES (?, ?, ?)");
    $message->execute([$userId, $token, $expires]);
    //

    setcookie('authentication', $token, $expires, '/', '', false, true);
}

function deleteCookie (\PDO $pdo, string $token) {

}

// https://www.php.net/manual/en/pdostatement.fetch.php
function checkCookie (\PDO $pdo, string $token): int {
    if (empty($token)) {
        http_response_code(401);
        echo json_encode(["error" => "Authentication cookie not provided."]);
        exit;
    }

    $message = $pdo->prepare("SELECT * FROM sessions WHERE token = ?");
    $message->execute([$token]);

    if ($message->rowCount() === 0) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid authentication token provided."]);
        exit;
    }

    $cookieObj = $message->fetch(\PDO::FETCH_OBJ);
    if ($cookieObj->expires < time()) {
        deleteCookie($pdo, $token);

        http_response_code(401);
        echo json_encode(["error" => "Authentication token is expired."]);
        exit;
    }

    // we can update expirations here later if we want

    //

    return $cookieObj->user_id;
}