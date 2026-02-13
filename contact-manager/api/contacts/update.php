<?php
/*  Update sql query
*   $sql = "
*   UPDATE contacts
*   SET first_name = ?, last_name = ?, email = ?, personal_phone = ?, work_phone = ?
*   WHERE id = ? AND user_id = ?;
*    ";
*/

// Requirements
use function components\cookies\checkCookie;
require '../components/db.php';
require '../components/cookies.php';
header("Content-Type: application/json; charset=utf-8");

// Decode incoming data
$req_data = json_decode(file_get_contents('php://input'), true);
$user_token = $_COOKIE['authentication'];
$uid = checkCookie($pdo, $user_token);

try{
    // SQL update query
    $update_query = $pdo->prepare("UPDATE contacts SET first_name = ?, last_name = ?, email = ?, personal_phone = ?, work_phone = ? WHERE user_id=? AND id=?");
    $update_query->bindParam(1, $req_data['first_name'], PDO::PARAM_STR);
    $update_query->bindParam(2, $req_data['last_name'], PDO::PARAM_STR);
    $update_query->bindParam(3, $req_data['email'], PDO::PARAM_STR);
    $update_query->bindParam(4, $req_data['personal_phone'], PDO::PARAM_STR);
    $update_query->bindParam(5, $req_data['work_phone'], PDO::PARAM_STR);
    $update_query->bindParam(6, $uid, PDO::PARAM_INT);
    $update_query->bindParam(7, $req_data['contact_id'], PDO::PARAM_INT);
    $update_query->execute();
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