<?php
require_once '../../config/database.php';
require_once '../../models/Item.php';
require_once '../../middleware/authenticateJWT.php'; 

$auth = new AuthenticateJWT();

$auth->validateToken();

$user = $_SESSION['user']->data; 
if ($user->role != 'bank') {
    http_response_code(403); // Forbidden
    echo json_encode(array("message" => "Access denied. Banks only."));
    exit();
}

// Retrieve input data
$data = json_decode(file_get_contents("php://input"));

// Check if bank username is provided
if (isset($data->username)) {
    $username = htmlspecialchars(strip_tags($data->username));
    
    $db = getDatabaseConnection();
    
    // Fetch user ID for the given username
    $query = "SELECT id FROM users WHERE username = :username AND role = 'bank'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $userId = $stmt->fetchColumn();
        
        // Retrieve items created by the bank user
        $query = "SELECT * FROM items WHERE creator_id = :creator_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':creator_id', $userId);
        $stmt->execute();
        
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($items)) {
            http_response_code(200);
            echo json_encode($items);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No items found for this bank user."));
        }
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Bank user not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
