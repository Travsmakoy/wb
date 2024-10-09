<?php
session_start();
require_once 'config.php';
//get_chats.php

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    exit('Unauthorized');
}

$admin_id = $_SESSION['user_id'];

$sql = "SELECT DISTINCT 
            u.id, 
            u.username as customer_name, 
            m.content as last_message,
            m.timestamp as last_message_time,
            (SELECT COUNT(*) FROM messages 
             WHERE sender_id = u.id AND receiver_id = $admin_id AND is_read = 0) as unread_count
        FROM users u
        LEFT JOIN messages m ON (m.sender_id = u.id AND m.receiver_id = $admin_id)
        WHERE u.is_admin = 0 AND m.id = (
            SELECT MAX(id) FROM messages 
            WHERE (sender_id = u.id AND receiver_id = $admin_id) 
               OR (sender_id = $admin_id AND receiver_id = u.id)
        )
        ORDER BY m.timestamp DESC";

$result = $conn->query($sql);
$chats = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($chats);