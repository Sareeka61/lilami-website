<?php
require_once '../../config/database.php'; 
require_once '../../middleware/authenticateJWT.php'; 

$auth = new AuthenticateJWT();
$auth->validateToken();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->item_id, $data->bid_amount)) {
    $db = getDatabaseConnection();

    $user_id = $_SESSION['user']->data->id;

    $db->beginTransaction();

    try {
        $query = "INSERT INTO bids (item_id, bid_amount, bid_time, user_id) VALUES (:item_id, :bid_amount, NOW(), :user_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':item_id', $data->item_id);
        $stmt->bindParam(':bid_amount', $data->bid_amount);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $query = "UPDATE items SET current_price = :bid_amount WHERE id = :item_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':bid_amount', $data->bid_amount);
        $stmt->bindParam(':item_id', $data->item_id);
        $stmt->execute();

        $db->commit();

        http_response_code(201);
        echo json_encode(array("message" => "Bid placed successfully."));
    } catch (PDOException $e) {
        $db->rollBack();
        http_response_code(500);
        echo json_encode(array("message" => "Database error: " . $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
