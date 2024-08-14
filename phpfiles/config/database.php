<?php
function getDatabaseConnection() {
    $host = "localhost";
    $db_name = "lilami";
    $username = "root";
    $password = "new_password";
    $conn = null;

    try {
        $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
        $conn->exec("set names utf8");
    } catch(PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
    }

    return $conn;
}
?>

