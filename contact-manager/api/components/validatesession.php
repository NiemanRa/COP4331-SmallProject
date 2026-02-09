<?php
try {
    require(__DIR__ . '/db.php');
} catch (\Throwable $e) {
    echo "Internal error loading page: " . $e->getMessage();
}

try {

    $sql = "SELECT token, username, first_name, last_name, id FROM users WHERE token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_COOKIE['token']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['token'] === $_COOKIE['token']) {
        $is_logged_in = true;
        $username = $result['username'];
        $firstName = $result['first_name'];
        $lastName = $result['last_name'];
        $userId = $result['id'];
    } else {
        $is_logged_in = false;
    }

} catch (PDOException $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        "error" => "SQL Query failed: " . $e->getMessage(),
    ]);
    exit;
}


if (!$is_logged_in) {
    http_response_code(401);
    header('Location: ../login', true);
    die();
}
?>