<?php
require_once 'config.php';

$admin_email = 'admin@admin.com';
$admin_password = 'admin'; // The plaintext password you want to use

// Hash the admin password
$hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);

// Update the admin password in the database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param('ss', $hashed_password, $admin_email);
$stmt->execute();

echo "Admin password updated successfully.";
?>
