<?php
session_start();
require_once 'conf/config.php';

// Check if the user is logged in and an admin
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

// Redirect admin users to their dashboard
if ($is_admin) {
    header("Location: su/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VapeShop - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 0;
            position: relative;
            width: 100%;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #444;
            padding: 0.5rem 0;
        }
        nav a {
            color: #fff;
            padding: 1rem;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        nav a:hover {
            background-color: #555;
        }
        .hero {
            background: url('your-hero-image.jpg') no-repeat center center/cover;
            height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
            padding: 2rem;
        }
        .hero h1 {
            font-size: 3rem;
            margin: 0;
        }
        .hero p {
            font-size: 1.25rem;
            margin: 1rem 0;
        }
        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: auto;
        }
        .welcome {
            text-align: center;
            padding: 2rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        footer {
            text-align: center;
            padding: 1rem;
            background-color: #333;
            color: #fff;
            margin-top: 2rem;
        }
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
            }
            nav a {
                padding: 0.75rem;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .welcome {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
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
        <div class="hero">
            <h1>Welcome to VapeShop</h1>
            <p>Your one-stop shop for the best vape products!</p>
        </div>
    </header>
    <div class="container">
        <div class="welcome">
            <h2>Shop the Best Vape Products!</h2>
            <p>Explore our wide range of products and enjoy great deals.</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Innocous Mist. All rights reserved.</p>
    </footer>
</body>
</html>
