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
    <link rel="shortcut icon" href="./assets/Favicon_Retro.png" type="image/x-icon">
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

    <!-- RELATED ARTICLES -->
    <div class="lg:grid lg:grid-cols-2 lg:w-full lg:max-w-full lg:items-end lg:justify-between">
        <div class="w-full max-w-full h-[60vh] bg-gradient-to-t from-[#FF1695] to-transparent flex flex-col items-center justify-center gap-3 px-4 mobilemd:px-6 sm:h-[70vh] sm:max-h-[70vh] sm:p-8 sm:gap-4 md:px-10 md:h-[80vh] md:max-h-[80vh] lg:p-12 xl:p-14 laptopxxl:p-16 2xl:px-20 2xl:py-8">
            <div class="w-full h-[10vh] flex items-center justify-center">
                <p class="text-[#33FCFF] text-2xl oswald uppercase mobilelg:font-bold sm:text-[2rem] 2xl:text-4xl 2xl:tracking-wider">related articles</p>
            </div>
            <a href="https://kidshealth.org/en/teens/e-cigarettes.html" target="_blank" class="w-full h-[60%] bg-[#1A1D3B] flex flex-col items-center justify-center blog-bg-one border border-[#1A1D3B]  border-x-2 border-y-8 rounded-md hover:border-[#FF1695] hover:border-2 iphone:justify-end sm:h-[80%] sm:max-h-[80%] md:h-full md:max-h-full lg:p-4">

                <div class="w-full h-[50%] overflow-hidden flex items-center justify-center iphone:hidden lg:w-full">

                </div>

                <div class="flex flex-col w-[90%] items-start justify-center bg-[#1a1d3bd5] px-1 mobilelg:w-full mobilelg:p-2 sm:p-4">
                    <p class="text-white oswald  text-xs sm:text-sm">January 2024</p>
                    <h1 class="text-white text-lg sm:text-xl">Vaping: What You Need to Know</h1>
                    <p class="text-white text-xs oswald sm:text-sm">Medically reviewed by: Elana Pearl Ben-Joseph, MD</p>
                </div>
            </a>
        </div>

        <div class="w-full max-w-full h-[40vh] max-h-[40vh] bg-gradient-to-b from-[#FF1695] to-transparent flex flex-col items-center justify-start mobilelg:px-6 sm:h-[70vh] sm:max-h-[70vh] sm:p-8 sm:gap-4 md:px-10 md:h-[80vh] md:max-h-[80vh] lg:grid lg:col-span-1 lg:bg-gradient-to-t lg:from-[#FF1695] lg:to-transparent lg:justify-end lg:p-14 laptopxxl:p-16 2xl:pr-20 2xl:pl-0 2xl:py-8 2xl:justify-end">
            <div class="w-full max-w-full h-[100%] flex flex-col px-4 mobilemd:px-6 mobilelg:gap-4 mobilelg:px-0 2xl:gap-12 2xl:flex-1 2xl:px-0 2xl:pl-0 2xl:w-[600px] 2xl:max-w-[600px]">
                <div class="w-full max-w-full h-[50%] flex items-center justify-around iphone:justify-between iphone:gap-4 lg:h-full 2xl:flex-1">
                    <a href="https://newsinhealth.nih.gov/2020/05/risks-vaping" target="_blank" class="w-[45%] h-[95%] bg-[#1A1D3B] border border-3 border-[#33FCFF] hover:border-[#FF1695] flex flex-col items-center justify-center blog-bg-two iphone:w-1/2 iphone:justify-end iphone:h-[130px] sm:h-full sm:max-h-full 2xl:w-full">
                        <div class="bg-[#1a1d3bd5] w-[90%] mobilelg:w-full iphone:p-1 sm:p-2">
                            <p class="text-white oswald text-xs px-1 sm:text-sm">May 2020</p>
                            <h1 class="text-white text-sm px-1 sm:text-base">The Risks of Vaping</h1>
                        </div>
                    </a>
                    <a href="https://www.medicalnewstoday.com/articles/vaping-vs-smoking" target="_blank" class="w-[45%] h-[95%] bg-[#1A1D3B] border border-3 border-[#33FCFF] hover:border-[#FF1695] flex flex-col items-center justify-center blog-bg-three iphone:w-1/2 iphone:justify-end iphone:h-[130px] sm:h-full sm:max-h-full 2xl:w-full">
                        <div class="bg-[#1a1d3bd5] w-[90%] mobilelg:w-full iphone:p-1 sm:p-2">
                            <p class="text-white oswald text-xs px-1 sm:text-sm">May 2024</p>
                            <h1 class="text-white text-sm px-1 sm:text-base">Vaping vs. smoking: Which is safer?</h1>
                        </div>
                    </a>
                </div>
                <div class="w-full max-w-full h-[50%] flex items-center justify-around iphone:justify-between iphone:gap-4 lg:h-full 2xl:flex-1">
                    <a href="https://archpublichealth.biomedcentral.com/articles/10.1186/s13690-022-00998-w" target="_blank" class="w-[45%] h-[95%] bg-[#1A1D3B] border border-3 border-[#33FCFF] hover:border-[#FF1695] flex flex-col items-center justify-center blog-bg-four iphone:w-1/2 iphone:justify-end iphone:h-[130px] sm:h-full sm:max-h-full 2xl:w-full">
                        <div class="bg-[#1a1d3bd5] w-[90%] mobilelg:w-full iphone:p-1 sm:p-2">
                            <p class="text-white oswald text-xs px-1 sm:text-sm">November 2022</p>
                            <h1 class="text-white text-sm px-1 sm:text-base">The prevalence of electronic cigarettes</h1>
                        </div>
                    </a>
                    <a href="#" class="w-[45%] h-[95%] bg-[#1A1D3B] border border-3 border-[#33FCFF] hover:border-[#FF1695] flex flex-col items-center justify-center blog-bg-five iphone:w-1/2 iphone:justify-end iphone:h-[130px] sm:h-full sm:max-h-full 2xl:w-full">
                        <div class="bg-[#1a1d3bd5] w-[90%] mobilelg:w-full iphone:p-1 sm:p-2">
                            <p class="text-white oswald text-xs px-1 sm:text-sm">April 2018</p>
                            <h1 class="text-white text-sm px-1 sm:text-base">Vaping’s potential to benefit public...</h1>
                        </div>
                    </a>
                </div>
            </div>
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
