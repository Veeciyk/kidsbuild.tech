<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = $_POST['age'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, age) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $email, $password, $age);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Account created successfully"]);
    } else {
        echo json_encode(["error" => "Username or email already exists"]);
    }

    $stmt->close();
    $conn->close();
}
?>
