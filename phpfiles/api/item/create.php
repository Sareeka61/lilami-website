<?php
header("Content-Type: application/json");

include_once '../../config/database.php';
include_once '../../models/Item.php';

$db = getDatabaseConnection();

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->description) && !empty($data->starting_price) && !empty($data->end_time) && !empty($data->user_id)) {
    if(createItem($db, $data->name, $data->description, $data->starting_price, $data->end_time, $data->user_id)) {
        http_response_code(201);
        echo json_encode(array("message" => "Item was created."));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create item."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>

