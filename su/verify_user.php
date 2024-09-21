<?php
session_start();
require_once '../conf/config.php';

// Redirect to login if not admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

// Check if user ID is provided
if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    
    // Update the user's verification status in the database
    $query = "UPDATE users SET is_verified = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        // Redirect to the user page with a success message
        $_SESSION['message'] = "User verified successfully!";
        header("Location: user.php");
        exit;
    } else {
        $_SESSION['message'] = "Error verifying user. Please try again.";
        header("Location: user.php");
        exit;
    }
} else {
    // If no user ID is provided, redirect back with an error message
    $_SESSION['message'] = "Invalid user ID.";
    header("Location: user.php");
    exit;
}
?>
