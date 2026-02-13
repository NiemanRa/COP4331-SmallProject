<?php
/*
 * cookie passed "authentication"
 * json:
 * {
 *  firstName: "",
 *  lastName: "",
 *  email: "",
 *  phone: "",
 *  dateCreated: ""
 * }
 *
 *
 */

/*  Add sql query
*   $sql = "
*   INSERT INTO contacts (first_name, last_name, email, personal_phone, work_phone)
*   VALUES (?, ?, ?, ?, ?, ?);
*    ";
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "method not allowed";
    exit();
}

// Requirements
use function components\cookies\checkCookie;
require '../components/db.php';
header("Content-Type: application/json; charset=utf-8");

// Decode incoming data
$req_data = json_decode(file_get_contents('php://input'), true);
$user_token = $_COOKIE['authentication'];
$uid = checkCookie($pdo, $user_token);

try{
    // SQL update query
    $add_query = $pdo->prepare("INSERT INTO contacts (user_id, first_name, last_name, email, personal_phone, work_phone) VALUES (?, ?, ?, ?, ?, ?)");
    $add_query->bindParam(1, $uid, PDO::PARAM_INT);
    $add_query->bindParam(2, $req_data['first_name'], PDO::PARAM_STR);
    $add_query->bindParam(3, $req_data['last_name'], PDO::PARAM_STR);
    $add_query->bindParam(4, $req_data['email'], PDO::PARAM_STR);
    $add_query->bindParam(5, $req_data['personal_phone'], PDO::PARAM_STR);
    $add_query->bindParam(6, $req_data['work_phone'], PDO::PARAM_STR);
    $add_query->execute();
    // Return success
    echo json_encode([
        "query" => "ok"
    ]);
}
// DB Error
catch(PDOException $e){
    http_response_code(500);    
    echo json_encode([
        "query" => "error",
        "error" => "Database Error"
    ]);
}
// Other Error
catch(Exception $e){
    http_response_code(500);    
    echo json_encode([
        "query" => "error",
        "error" => "Unknown error"
    ]);
}