<?php include 'navbar.php'; ?>
<?php require_once 'conf/config.php'; // Include your database connection file ?>
<?php
// Start the session (optional)
// session_start();

// Get the requested URL
$request = $_SERVER['REQUEST_URI'];

// Remove any leading slashes
$request = ltrim($request, '/');

// Set the default file
$file = 'index.php'; // Change this to your default home page

// If the request is not empty, append .php
if (!empty($request)) {
    $file = $request . '.php';
}

// Check if the requested file exists
// if (file_exists($file)) {
//     include $file;
// } else {
//     // Handle 404 error
//     header("HTTP/1.0 404 Not Found");
//     echo "<h1>404 Not Found</h1>";
//     echo "<p>The page you are looking for does not exist.</p>";
// }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innocuous Mist - Home</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="./styles/output.css">

    <link rel="stylesheet" href="styles/home.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
      
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
        <div class="relative p-4 w-full h-[20vh] bg-gradient-to-l from-[#1F9799] via-[#33FCFF] to-[#1F9799] flex items-center justify-center mobilemd:px-6 sm:px-8 md:h-auto md:px-10 lg:px-12 xl:px-14 xl:py-6 laptopxxl:px-16 2xl:px-20">
        <div class="w-full h-auto flex flex-col items-center justify-center">
            <p class="text-[#610049] text-center font-semibold bebas-neue mobilelg:text-xl lg:text-2xl">Government warning: This product is harmful and contains nicotine which is a highly addictive substance. This is for use only by adults and is not recommended for use by non-smokers.</p>
        </div>
    </div>

    <!-- BRAND PARTNERS -->
    <div class="overflow-x-hidden partners_bg relative w-full h-auto p-4 flex flex-col justify-center items-center flex-wrap gap-4 mobilemd:p-6 mobilelg:gap-6 sm:max-h-[50vh] sm:h-[50vh] sm:p-8 sm:gap-8 md:px-10 lg:px-12 xl:px-14 xl:gap-14 xl:h-[60vh] xl:max-h-[60vh] laptopxxl:px-16 2xl:px-20">
        <div class="w-full flex items-center justify-around gap-2 flex-wrap">
            <a href="https://www.facebook.com/iqphilippine" target="_blank" class="hover:scale-105"><img src="./assets/Infinity Series Brand Logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px] xl:w-[130px] 2xl:w-[160px]"></a>
            <a href="https://www.facebook.com/aeroginvapeph" target="_blank" class="hover:scale-105"><img src="./assets/aerogin-logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px] xl:w-[130px] 2xl:w-[160px]"></a>
            <a href="https://www.facebook.com/NastyPH" target="_blank" class="hover:scale-105"><img src="./assets/nasty-logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px] xl:w-[130px] 2xl:w-[160px]"></a>
        </div>
        <div class="w-full flex items-center justify-around gap-2 flex-wrap">
            <a href="https://www.facebook.com/worldsupersmooth.ph" target="_blank" class="hover:scale-105"><img src="./assets/relx-logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px] xl:w-[130px] 2xl:w-[160px]"></a>
            <p class="text-[#fafafa] oswald text-sm text-nowrap mobilemd:text-base mobilelg:text-lg sm:text-2xl md:text-[2rem] xl:text-4xl">BRAND PARTNERS</p>
            <a href="https://www.facebook.com/profile.php?id=61553286650013" target="_blank" class="hover:scale-105"><img src="./assets/geekvape-logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px] xl:w-[130px] 2xl:w-[160px]"></a>
        </div>
        <div class="w-full flex items-center justify-around gap-2 flex-wrap">
            <a href="https://www.facebook.com/veehoophmain" target="_blank" class="hover:scale-105"><img src="./assets/veehoo-logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px xl:w-[130px]] 2xl:w-[160px]"></a>
            <a href="https://www.facebook.com/Shiftdisposablevape" target="_blank" class="hover:scale-105"><img src="./assets/shft-logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px] xl:w-[130px] 2xl:w-[160px]"></a>
            <a href="https://www.facebook.com/SMPOPH" target="_blank" class="hover:scale-105"><img src="./assets/smpo-logo.png" class="w-[80px] h-auto mobilelg:w-[100px] sm:w-[120px] xl:w-[130px] 2xl:w-[160px]"></a>
        </div>
    </div>


        <section class="section" id="vapes">
            <h2>Vapes</h2>
            <p>Discover our range of high-quality vapes for a superior experience.</p>
            <div class="products">
                <?php
                $stmt = $conn->prepare("SELECT product_name, description, REPLACE(img_dir, '../', '') AS img_dir, price FROM products WHERE category_id = ?");
                $category_id = 2; // Assuming 1 is for 'Vapes'
                $stmt->bind_param("i", $category_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card' onclick=\"openPopup('{$row['img_dir']}', '{$row['product_name']}', '{$row['description']}', '{$row['price']}')\">
                            <img src='{$row['img_dir']}' alt='{$row['product_name']}' class='product-image'>
                            <h3>{$row['product_name']}</h3>
                            <p>{$row['description']}</p>
                          </div>";
                }
                ?>
            </div>
        </section>

        <section class="section" id="juice">
            <h2>Juice</h2>
            <p>Explore our delicious selection of vape juices.</p>
            <div class="products">
                <?php
                $category_id = 1; // Assuming 2 is for 'Juice'
                $stmt->bind_param("i", $category_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card' onclick=\"openPopup('{$row['img_dir']}', '{$row['product_name']}', '{$row['description']}', '{$row['price']}')\">
                            <img src='{$row['img_dir']}' alt='{$row['product_name']}' class='product-image'>
                            <h3>{$row['product_name']}</h3>
                            <p>{$row['description']}</p>
                          </div>";
                }
                ?>
            </div>
        </section>

        <section class="section" id="disposables">
            <h2>Disposables</h2>
            <p>Check out our convenient disposable vapes.</p>
            <div class="products">
                <?php
                $category_id = 3; // Assuming 3 is for 'Disposables'
                $stmt->bind_param("i", $category_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card' onclick=\"openPopup('{$row['img_dir']}', '{$row['product_name']}', '{$row['description']}', '{$row['price']}')\">
                            <img src='{$row['img_dir']}' alt='{$row['product_name']}' class='product-image'>
                            <h3>{$row['product_name']}</h3>
                            <p>{$row['description']}</p>
                          </div>";
                }
                ?>
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
            <a href="#" class="add-to-cart">Inquire via Chat</a>
        </div>
    </div>

    <script>
        // JavaScript for handling the pop-up
        function openPopup(image, title, description, price) {
            document.getElementById('popupImage').src = image;
            document.getElementById('popupTitle').textContent = title;
            document.getElementById('popupDescription').textContent = description;
            document.getElementById('popupPrice').textContent = '₱' + price;
            document.getElementById('productPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('productPopup').style.display = 'none';
        }
    </script>
</body>
<?php include 'conf/foot.php'; ?>
</html>
