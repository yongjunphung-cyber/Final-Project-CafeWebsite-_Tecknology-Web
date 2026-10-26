<?php
session_start();
require "db.php";

$email    = trim($_POST["email"]);
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"]   = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        header("Location: index.html");
        exit;
    }
}
echo "<script>alert('Invalid email or password.'); history.back();</script>";
?>