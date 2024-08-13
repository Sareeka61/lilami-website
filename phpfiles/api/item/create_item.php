<?php
require_once '../../config/database.php';
require_once '../../models/Item.php';
require_once '../../middleware/authenticateJWT.php';

$auth = new AuthenticateJWT();

$auth->validateToken();

$username = $_SESSION['user']->data->username;
$role = $_SESSION['user']->data->role;

if ($role != 'bank') {
    http_response_code(403); // Forbidden
    echo json_encode(array("message" => "Access denied. Admins only."));
    exit();
}

$user = $_SESSION['user']->data; 

$db = getDatabaseConnection();

$data = json_decode(file_get_contents("php://input"));
if (isset($data->item_number, $data->title, $data->current_price, $data->item_condition, $data->description, $data->note, $data->image_url, $data->end_date)) {
    $creator_id = $user->id;
    $end_date = $data->end_date;

    $result = createItem($db, $data->item_number, $data->title, $data->current_price, $data->item_condition, $data->description, $data->note, $data->image_url, $creator_id, $end_date);

    if ($result) {
        http_response_code(201);
        echo json_encode(array("message" => "Item created successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to create item."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
