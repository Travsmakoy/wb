<?php
require_once 'conf/config.php';

// Check if the user is logged in and an admin
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>
<div class="navbar-container">
    <div class="menu-toggle" id="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav id="navbar">
        <a href="index.php">Home</a>
        <a href="#">Shop</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <?php if ($is_logged_in): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</div>
<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        var nav = document.getElementById('navbar');
        if (nav.classList.contains('active')) {
            nav.classList.remove('active');
        } else {
            nav.classList.add('active');
        }
    });
</script>
