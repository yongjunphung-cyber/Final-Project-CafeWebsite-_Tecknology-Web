<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Account created!'); window.location='login.html';</script>";
    } else {
        if ($conn->errno === 1062) {
            echo "<script>alert('Email already registered.'); history.back();</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>