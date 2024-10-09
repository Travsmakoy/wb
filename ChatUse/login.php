<?php
// login.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, is_admin FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: " . ($user['is_admin'] ? "admin_chat.php" : "customer_chat.php"));
            exit();
        }
    }
    $error = "Invalid username or password";
    include 'index.php';
    exit();
}

// If not a POST request, redirect to the login page
header("Location: index.php");
exit();
?>