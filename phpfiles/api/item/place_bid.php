<?php
include '../../cors.php';
require_once '../../config/database.php'; 
require_once '../../middleware/authenticateJWT.php'; 

$auth = new AuthenticateJWT();
$auth->validateToken();

$data = json_decode(file_get_contents("php://input"));

// Check for the correct property names
if (isset($data->itemId, $data->bidAmount)) {
    $db = getDatabaseConnection();

    $user_id = $_SESSION['user']->data->id;

    $db->beginTransaction();

    try {
        // Insert the bid
        $query = "INSERT INTO bids (item_id, bid_amount, bid_time, user_id) VALUES (:item_id, :bid_amount, NOW(), :user_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':item_id', $data->itemId);
        $stmt->bindParam(':bid_amount', $data->bidAmount);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Update the current price of the item
        $query = "UPDATE items SET current_price = :bid_amount WHERE id = :item_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':bid_amount', $data->bidAmount);
        $stmt->bindParam(':item_id', $data->itemId);
        $stmt->execute();

        // Get the total number of bids for the item
        $query = "SELECT COUNT(*) AS total_bids FROM bids WHERE item_id = :item_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':item_id', $data->itemId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $total_bids = $result['total_bids'];

        $db->commit();

        http_response_code(201);
        echo json_encode(array(
            "message" => "Bid placed successfully.",
            "total_bids" => $total_bids
        ));
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
