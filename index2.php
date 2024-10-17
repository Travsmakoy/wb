<?php include 'navbar.php'; // Include your database connection file ?>
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

<!-- <?php
        define('SOURCE_PATH', './assets/mist-logo.png');
        include("navv.php");
    ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innocuous Mist - Home</title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/output.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="shortcut icon" href="./assets/Favicon_Inno.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>.product-showcase {
    padding: 2rem 0;
}

.product-row {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    overflow-x: auto;
    padding-bottom: 1rem;
}

.product-column {
    flex: 0 0 auto;
    width: calc(33.333% - 1rem);
    min-width: 250px;
}

.product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: box-shadow 0.3s ease;
}

.product-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.browse-button {
    display: inline-block;
    background-color: #ff7f50;
    color: white;
    padding: 0.5rem 1rem;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.browse-button:hover {
    background-color: #e06943;
}

@media (max-width: 768px) {
    .product-row {
        flex-wrap: nowrap;
        justify-content: flex-start;
    }
    
    .product-column {
        width: 80%;
    }
}</style>

    <!-- STYLE FOR SLIDER -->
    <style>
    .hero {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .slider {
        position: absolute;
        width: 100%;
        height: 100%;
        display: flex;
        transition: transform 1s ease;
    }

    .slide {
        min-width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        display: none;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .slide.active {
        display: flex;
    }

    .hero-content {
        color: #fff;
        /* background: rgba(0, 0, 0, 0.5); */
        padding: 20px;
        border-radius: 8px;
    }

    .cta-button {
        background-color: #ff7f50;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .cta-button:hover {
        background-color: #e06943;
    }
</style>
</head>
<body>
    <main>
    <section class="hero">
    <div class="slider">
        <div class="slide active" style="background-image: url('assets/slider1.jpg');">
            <div class="hero-content">
                <h1>Welcome to Innocuous Mist</h1>
                <p>Experience the future of vaping with our cutting-edge products and flavors.</p>
                <a href="catalog" class="cta-button">Explore Our Catalog</a>
            </div>
        </div>
        <div class="slide" style="background-image: url('assets/slider2.jpg');">
            <div class="hero-content">
                <h1>Discover Our New Arrivals</h1>
                <p>Fresh flavors and the latest vape devices available now.</p>
                <a href="catalog" class="cta-button">Shop Now</a>
            </div>
        </div>
        <div class="slide" style="background-image: url('assets/slider3.jpg');">
            <div class="hero-content">
                <h1>Quality Vaping Products</h1>
                <p>Premium products for an exceptional vaping experience.</p>
                <a href="catalog" class="cta-button">Browse Our Products</a>
            <!-- </div> -->
        </div>
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
<!-- DYNAMIC DISPLAY SECTION -->
<section class="partners_bg py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-[#33FCFF] mb-10 oswald">Featured Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Fetch categories
            $cat_stmt = $conn->prepare("SELECT category_id, category_name FROM categories LIMIT 3");
            $cat_stmt->execute();
            $categories = $cat_stmt->get_result();

            while ($category = $categories->fetch_assoc()) {
                // Fetch one product for each category
                $prod_stmt = $conn->prepare("SELECT product_name, description, REPLACE(img_dir, '../', '') AS img_dir, price FROM products WHERE category_id = ? LIMIT 1");
                $prod_stmt->bind_param("i", $category['category_id']);
                $prod_stmt->execute();
                $product = $prod_stmt->get_result()->fetch_assoc();

                if ($product) {
                    ?>
                    <div class="bg-[#1A1D3B] rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105">
                        <div class="relative h-64">
                            <img src="<?php echo $product['img_dir']; ?>" alt="<?php echo $product['product_name']; ?>" class="w-full h-full object-cover">
                            <div class="absolute top-0 left-0 bg-[#FF1695] text-white px-3 py-1 rounded-br-lg oswald">
                                <?php echo strtoupper($category['category_name']); ?>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-[#33FCFF] mb-2"><?php echo $product['product_name']; ?></h3>
                            <p class="text-gray-300 mb-4 line-clamp-2"><?php echo $product['description']; ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-[#FF1695] font-bold">₱<?php echo number_format($product['price'], 2); ?></span>
                                <button onclick="openPopup('<?php echo $product['img_dir']; ?>', '<?php echo htmlspecialchars($product['product_name']); ?>', '<?php echo htmlspecialchars($product['description']); ?>', '<?php echo $product['price']; ?>')" class="bg-[#33FCFF] text-[#1A1D3B] px-4 py-2 rounded-full hover:bg-[#FF1695] hover:text-white transition-colors duration-300">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div class="px-6 pb-6">
                            <a href="catalog.php?category=<?php echo $category['category_id']; ?>" class="block w-full text-center bg-[#FF1695] text-white py-2 rounded-full hover:bg-[#33FCFF] hover:text-[#1A1D3B] transition-colors duration-300">
                                Browse <?php echo $category['category_name']; ?>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                $prod_stmt->close();
            }
            $cat_stmt->close();
            ?>
        </div>
    </div>
</section>

    </main>
    <!-- Pop-up structure -->
    <div id="productPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-[#1A1D3B] rounded-lg p-8 max-w-md w-full mx-4">
        <button onclick="closePopup()" class="absolute top-2 right-2 text-gray-500 hover:text-white">&times;</button>
        <img id="popupImage" src="" alt="Product Image" class="w-full h-64 object-cover rounded-lg mb-4">
        <h3 id="popupTitle" class="text-2xl font-bold text-[#33FCFF] mb-2"></h3>
        <p id="popupDescription" class="text-gray-300 mb-4"></p>
        <p id="popupPrice" class="text-[#FF1695] font-bold text-xl mb-4"></p>
        <a href="#" class="block w-full text-center bg-[#FF1695] text-white py-2 rounded-full hover:bg-[#33FCFF] hover:text-[#1A1D3B] transition-colors duration-300">
            Inquire via Chat
        </a>
    </div>
</div>


    <!-- SCRIPT FOR SLIDER -->
    <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // Automatically change slides every 5 seconds
    setInterval(nextSlide, 5000);
</script>
</body>
<?php include 'conf/foot.php'; ?>
</html>
