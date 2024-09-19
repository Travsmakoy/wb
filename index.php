<?php
session_start(); // Ensure session is started
include 'navbar.php'; // Include the navigation
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
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
        }
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        .menu-toggle span {
            background: #fff;
            height: 3px;
            width: 25px;
            margin: 3px 0;
            transition: 0.3s;
        }
        #navbar {
            display: flex;
            align-items: center;
        }
        #navbar a {
            color: #fff;
            padding: 1rem;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        #navbar a:hover {
            background-color: #555;
        }
        .hero {
            padding: 100px 2rem 2rem;
            background: url('hero-image.jpg') no-repeat center center;
            background-size: cover;
            text-align: center;
            color: #fff;
            border-bottom: 2px solid #444;
        }
        .hero h1 {
            font-size: 3rem;
            margin: 0;
        }
        .hero p {
            font-size: 1.5rem;
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
            .menu-toggle {
                display: flex;
            }
            #navbar {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: #333;
                position: absolute;
                top: 60px; /* Adjust based on header height */
                left: 0;
                z-index: 1000;
            }
            #navbar.active {
                display: flex;
            }
            #navbar a {
                padding: 1rem;
                text-align: center;
                border-bottom: 1px solid #555;
            }
            #navbar a:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>
<body>
    <header>
        <?php include 'navbar.php'; // Include the navigation bar once ?>
    </header>
    <div class="hero">
        <h1>Welcome to VapeShop</h1>
        <p>Your one-stop shop for the best vape products!</p>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Shop the Best Vape Products!</h2>
            <p>Explore our wide range of products and enjoy great deals.</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 VapeShop. All rights reserved.</p>
    </footer>
</body>
</html>
