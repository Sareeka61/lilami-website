<?php
include '../../cors.php';
header("Content-Type: application/json");


require_once '../../config/database.php';
require_once '../../models/User.php';
require_once '../../vendor/autoload.php';

use \Firebase\JWT\JWT;

$key = "your_secret_key"; 
$issuer = "localhost"; 

$db = getDatabaseConnection();
$data = json_decode(file_get_contents("php://input"));

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid JSON format: " . json_last_error_msg()));
    exit();
}

if (!empty($data->username) && !empty($data->password)) {
    $user = loginUser($db, $data->username, $data->password);

    if ($user) {
        $token = array(
            "iss" => $issuer, 
            "aud" => $issuer,
            "iat" => time(), 
            "nbf" => time(),
            "exp" => time() + 3600, 
            "data" => array(
                "id" => $user['id'],
                "username" => $user['username'],
                "role" => $user['role'],
            )
        );

        $jwt = JWT::encode($token, $key, 'HS256'); // Added 'HS256' as the third parameter
        http_response_code(200);
        echo json_encode(array(
            "message" => "Login successful.",
            "token" => $jwt,
            "user_id" => $user['id'],
            "username" => $user['username'],
            "role" => $user['role'],
        ));
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Login failed."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
