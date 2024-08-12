<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
    $language = htmlspecialchars(trim($_POST['language']));
    $notifications = isset($_POST['notifications']) ? 1 : 0;

    $conn = new mysqli("localhost", "username", "password", "database");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (first_name, last_name, email, password, phone_number, language, notifications)
            VALUES ('$firstName', '$lastName', '$email', '$password', '$phoneNumber', '$language', '$notifications')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
