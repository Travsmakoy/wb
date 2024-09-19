<?php
session_start();
?>

<nav>
    <a href="index.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="su/dashboard.php">Dashboard</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</nav>
