<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innocuous Mist - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-light);
            margin: 0;
            padding: 0;
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(45deg, var(--primary-bg), var(--secondary-bg));
        }

        .hero-content {
            max-width: 800px;
            padding: 20px;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 3rem;
            color: var(--accent-blue);
            text-shadow: 0 0 10px var(--accent-blue);
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--accent-pink);
            color: var(--text-light);
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #ff33ff;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to Innocuous Mist</h1>
                <p>Experience the future of vaping with our cutting-edge products and flavors.</p>
                <a href="catalog.php" class="cta-button">Explore Our Catalog</a>
            </div>
        </section>
    </main>
</body>
</html>