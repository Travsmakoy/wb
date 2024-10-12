<?php
// footer.php
?>
<?php include './chat-widget.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cool Compact Footer</title>
    <style>
        .footer {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, #3498db22, transparent 50%);
            animation: pulse 15s infinite;
        }
        @keyframes pulse {
            0% { transform: translate(0, 0); }
            50% { transform: translate(-30px, 20px); }
            100% { transform: translate(0, 0); }
        }
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            position: relative;
            z-index: 1;
        }
        .footer-section {
            flex: 1;
            min-width: 200px;
            margin: 0.5rem;
        }
        .footer h3 {
            color: #3498db;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .footer p, .footer li {
            font-size: 0.8rem;
            margin: 0;
            line-height: 1.4;
        }
        .footer ul {
            list-style-type: none;
            padding: 0;
        }
        .footer a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #3498db;
        }
        .social-icons {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .social-icons a {
            color: #fff;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }
        .social-icons a:hover {
            transform: translateY(-3px);
        }
        .map-container {
            width: 100%;
            height: 150px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .copyright {
            text-align: center;
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 1px solid #333;
            font-size: 0.7rem;
            opacity: 0.7;
        }
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
            .footer-section {
                margin-bottom: 1rem;
            }
            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>I.M. VAPESHOP OPC</h3>
                <p>Your go-to for premium vaping products.</p>
                <div class="social-icons">
                    <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index">Home</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact & Location</h3>
                <p>123 Vape St, Vapor City, 12345</p>
                <p>info@imvapeshop.com | (123) 456-7890</p>
            </div>
            <div class="footer-section">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5475.853392321806!2d120.58785647638878!3d16.444113429290514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a34c5dd40137%3A0x8292047954a4b493!2sI.M.%20VAPESHOP%20OPC!5e1!3m2!1sen!2sae!4v1728719128645!5m2!1sen!2sae" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="copyright">
            &copy; 2024 I.M. VAPESHOP OPC. All rights reserved.
        </div>
    </footer>

    <!-- Font Awesome for social icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>