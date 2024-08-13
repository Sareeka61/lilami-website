<?php
include '../../cors.php';

require_once '../../config/database.php';

function getAllBanks($db) {
    $query = "SELECT id, username, role, bio, image_url FROM users WHERE role = 'bank'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$db = getDatabaseConnection();

$banks = getAllBanks($db);

header('Content-Type: application/json');
echo json_encode(array("banks" => $banks));
?>
