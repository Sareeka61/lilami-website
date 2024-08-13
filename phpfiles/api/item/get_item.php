<?php
include '../../cors.php';

header("Content-Type: application/json");

require_once '../../config/database.php';

$db = getDatabaseConnection();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $query = "SELECT id, item_number, title, current_price, item_condition, description, note, image_url FROM items WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        http_response_code(200);
        echo json_encode($item);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Item not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid ID."));
}
?>
