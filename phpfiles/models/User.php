<?php
function registerUser($db, $username, $password, $email) {
    $query = "INSERT INTO users SET username=:username, password=:password, email=:email";
    $stmt = $db->prepare($query);

    $username = htmlspecialchars(strip_tags($username));
    $password = password_hash($password, PASSWORD_BCRYPT);
    $email = htmlspecialchars(strip_tags($email));

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":email", $email);

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

