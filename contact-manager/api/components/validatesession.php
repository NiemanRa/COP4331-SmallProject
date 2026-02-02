<?php
$env = parse_ini_file("../../../.env");
$charset = "utf8";



// Check if user is logged in
$dsn = "mysql:host={$env['HOST']};port={$env['PORT']};dbname={$env['DB_NAME']};charset=$charset";
$is_logged_in = false;
$username = "";
$firstName = "";
$lastName = "";
$userId = "";

try {
    $pdo = new PDO($dsn, $env["USER"], $env["PASSWORD"], $options);

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
    http_response_code(500);
    echo json_encode([
        "error" => "Connection failed, please try again later: " . $e->getMessage(),
    ]);
    exit;
}


if (!$is_logged_in) {
    header("HTTP/1.1 401 Unauthorized");
    header('Location: ../login', true, 303);
    die();
}
?>