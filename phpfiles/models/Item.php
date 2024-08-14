<?php
function createItem($db, $item_number, $title, $current_price, $condition, $description, $note, $image_url, $creator_id, $end_date) {
    $query = "INSERT INTO items (item_number, title, current_price, item_condition, description, note, image_url, creator_id, end_date) VALUES (:item_number, :title, :current_price, :item_condition, :description, :note, :image_url, :creator_id, :end_date)";

    $stmt = $db->prepare($query);

    // Use variables for each value
    $itemNumber = $item_number;
    $titleValue = $title;
    $currentPrice = $current_price;
    $conditionValue = $condition;
    $descriptionValue = $description;
    $noteValue = $note;
    $imageUrl = $image_url;
    $creatorId = $creator_id;
    $endDate = $end_date;

    $stmt->bindParam(':item_number', $itemNumber);
    $stmt->bindParam(':title', $titleValue);
    $stmt->bindParam(':current_price', $currentPrice);
    $stmt->bindParam(':item_condition', $conditionValue);
    $stmt->bindParam(':description', $descriptionValue);
    $stmt->bindParam(':note', $noteValue);
    $stmt->bindParam(':image_url', $imageUrl);
    $stmt->bindParam(':creator_id', $creatorId);
    $stmt->bindParam(':end_date', $endDate);

    $stmt->execute();
}
?>