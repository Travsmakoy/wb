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

        .section {
            padding: 50px 20px;
            text-align: center;
        }

        .section h2 {
            font-size: 2.5rem;
            color: var(--accent-blue);
            margin-bottom: 20px;
        }

        .section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .product-card {
            background-color: var(--secondary-bg);
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            width: 250px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        /* Pop-up styles */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--secondary-bg);
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
        }

        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-light);
        }

        .popup-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .popup-title {
            font-size: 24px;
            color: var(--accent-blue);
            margin-bottom: 10px;
        }

        .popup-description {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .popup-price {
            font-size: 20px;
            color: var(--accent-pink);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .add-to-cart {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--accent-blue);
            color: var(--text-light);
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .add-to-cart:hover {
            background-color: #3399ff;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }

            .products {
                flex-direction: column;
                align-items: center;
            }

            .product-card {
                width: 90%;
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

        <section class="section" id="vapes">
            <h2>Vapes</h2>
            <p>Discover our range of high-quality vapes for a superior experience.</p>
            <div class="products">
                <div class="product-card">
                    <img src="images/vape1.jpg" alt="Vape 1" class="product-image">
                    <h3>Vape Model 1</h3>
                    <p>Description of Vape Model 1.</p>
                </div>
                <div class="product-card">
                    <img src="images/vape2.jpg" alt="Vape 2" class="product-image">
                    <h3>Vape Model 2</h3>
                    <p>Description of Vape Model 2.</p>
                </div>
                <!-- Add more products as needed -->
            </div>
        </section>

        <section class="section" id="juice">
            <h2>Juice</h2>
            <p>Explore our delicious selection of vape juices.</p>
            <div class="products">
                <div class="product-card">
                    <img src="images/juice1.jpg" alt="Juice 1" class="product-image">
                    <h3>Juice Flavor 1</h3>
                    <p>Description of Juice Flavor 1.</p>
                </div>
                <div class="product-card">
                    <img src="images/juice2.jpg" alt="Juice 2" class="product-image">
                    <h3>Juice Flavor 2</h3>
                    <p>Description of Juice Flavor 2.</p>
                </div>
                <!-- Add more products as needed -->
            </div>
        </section>

        <section class="section" id="disposables">
            <h2>Disposables</h2>
            <p>Check out our convenient disposable vapes.</p>
            <div class="products">
                <div class="product-card">
                    <img src="images/disposable1.jpg" alt="Disposable 1" class="product-image">
                    <h3>Disposable Vape 1</h3>
                    <p>Description of Disposable Vape 1.</p>
                </div>
                <div class="product-card">
                    <img src="images/disposable2.jpg" alt="Disposable 2" class="product-image">
                    <h3>Disposable Vape 2</h3>
                    <p>Description of Disposable Vape 2.</p>
                </div>
                <!-- Add more products as needed -->
            </div>
        </section>
    </main>

    <!-- Pop-up structure -->
    <div class="popup-overlay" id="productPopup">
        <div class="popup-content">
            <span class="close-popup" onclick="closePopup()">&times;</span>
            <img src="" alt="Product Image" class="popup-image" id="popupImage">
            <h3 class="popup-title" id="popupTitle"></h3>
            <p class="popup-description" id="popupDescription"></p>
            <p class="popup-price" id="popupPrice"></p>
            <a href="#" class="add-to-cart">Add to Cart</a>
        </div>
    </div>

    <script>
        // JavaScript for handling the pop-up
        function openPopup(image, title, description, price) {
            document.getElementById('popupImage').src = image;
            document.getElementById('popupTitle').textContent = title;
            document.getElementById('popupDescription').textContent = description;
            document.getElementById('popupPrice').textContent = price;
            document.getElementById('productPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('productPopup').style.display = 'none';
        }

        // Add click event listeners to all product cards
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                card.addEventListener('click', function() {
                    const image = this.querySelector('.product-image').src;
                    const title = this.querySelector('h3').textContent;
                    const description = this.querySelector('p').textContent;
                    const price = '$XX.XX'; // Replace with actual price when available
                    openPopup(image, title, description, price);
                });
            });
        });
    </script>
</body>
</html>