<?php
header("Content-Type: application/json");

require_once '../../config/database.php';

$db = getDatabaseConnection();

$query = "SELECT * FROM items";
$stmt = $db->prepare($query);
$stmt->execute();

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

http_response_code(200);
echo json_encode($items);
?>
