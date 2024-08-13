<?php
function createItem($db, $item_number, $title, $current_price, $item_condition, $description, $note, $image_url) {
    $query = "INSERT INTO items SET item_number=:item_number, title=:title, current_price=:current_price, item_condition=:item_condition, description=:description, note=:note, image_url=:image_url";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":item_number", htmlspecialchars(strip_tags($item_number)));
    $stmt->bindParam(":title", htmlspecialchars(strip_tags($title)));
    $stmt->bindParam(":current_price", $current_price);
    $stmt->bindParam(":item_condition", htmlspecialchars(strip_tags($item_condition)));
    $stmt->bindParam(":description", htmlspecialchars(strip_tags($description)));
    $stmt->bindParam(":note", htmlspecialchars(strip_tags($note)));
    $stmt->bindParam(":image_url", htmlspecialchars(strip_tags($image_url)));

    return $stmt->execute();
}
?>

