<?php
function registerUser($db, $username, $password, $email, $bio = null, $image_url = null) {
    $query = "INSERT INTO users SET username=:username, password=:password, email=:email, bio=:bio, image_url=:image_url";
    $stmt = $db->prepare($query);

    $username = htmlspecialchars(strip_tags($username));
    $password = password_hash($password, PASSWORD_BCRYPT);
    $email = htmlspecialchars(strip_tags($email));
    $bio = $bio ? htmlspecialchars(strip_tags($bio)) : null;
    $image_url = $image_url ? htmlspecialchars(strip_tags($image_url)) : null;

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":bio", $bio);
    $stmt->bindParam(":image_url", $image_url);

    return $stmt->execute();
}
function loginUser($db, $username, $password) {
    $query = "SELECT id, username, password, role FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}

?>
