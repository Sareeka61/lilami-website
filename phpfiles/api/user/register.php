<?php
include '../../cors.php';
header("Content-Type: application/json");

include_once '../../config/database.php';
include_once '../../models/User.php';

$db = getDatabaseConnection();

$data = json_decode(file_get_contents("php://input"));
if(!empty($data->username) && !empty($data->email) && !empty($data->password)) {
    if (registerUser($db, $data->username, $data->password, $data->email)) {
        http_response_code(201);
        echo json_encode(array("message" => "User was registered."));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to register user."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>

