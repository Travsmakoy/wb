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
    <link rel="shortcut icon" href="./assets/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
    
    .category-slider-container {
    position: relative;
}

.category-slider {
    display: flex;
    overflow-x: hidden;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.category-slider::-webkit-scrollbar {
    display: none;
}

.category-slider > div {
    flex: 0 0 100%;
    max-width: 100%;
}

.slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 22, 149, 0.7);
    color: white;
    padding: 8px;
    border: none;
    cursor: pointer;
    border-radius: 50%;
    font-size: 18px;
    transition: background-color 0.3s;
}

.slider-nav:hover {
    background-color: rgba(255, 22, 149, 1);
}

.slider-nav.left-0 {
    left: 0;
}

.slider-nav.right-0 {
    right: 0;
}
    
    .product-showcase {
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
    <!-- DYNAMIC DISPLAY SECTION -->
<section class="partners_bg py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-[#33FCFF] mb-10 oswald">Featured Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            // Fetch categories
            $cat_stmt = $conn->prepare("SELECT category_id, category_name FROM categories LIMIT 3");
            $cat_stmt->execute();
            $categories = $cat_stmt->get_result();

            while ($category = $categories->fetch_assoc()) {
                ?>
                <div class="category-slider-container">
                    <h3 class="text-xl font-semibold text-[#FF1695] mb-4"><?php echo $category['category_name']; ?></h3>
                    <div class="relative">
                        <div class="category-slider" id="slider-<?php echo $category['category_id']; ?>">
                            <?php
                            // Fetch products for each category
                            $prod_stmt = $conn->prepare("SELECT product_id, product_name, REPLACE(img_dir, '../', '') AS img_dir, price FROM products WHERE category_id = ? LIMIT 5");
                            $prod_stmt->bind_param("i", $category['category_id']);
                            $prod_stmt->execute();
                            $products = $prod_stmt->get_result();

                            while ($product = $products->fetch_assoc()):
                            ?>
                                <div class="bg-[#1A1D3B] rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105">
                                    <div class="relative h-48">
                                        <img src="<?php echo $product['img_dir']; ?>" alt="<?php echo $product['product_name']; ?>" class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-4">
                                        <h4 class="text-lg font-semibold text-[#33FCFF] mb-2 truncate"><?php echo $product['product_name']; ?></h4>
                                        <span class="text-[#FF1695] font-bold">₱<?php echo number_format($product['price'], 2); ?></span>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            $prod_stmt->close();
                            ?>
                        </div>
                        <button class="slider-nav left-0" onclick="moveSlider('<?php echo $category['category_id']; ?>', 'left')">&#10094;</button>
                        <button class="slider-nav right-0" onclick="moveSlider('<?php echo $category['category_id']; ?>', 'right')">&#10095;</button>
                    </div>
                </div>
                <?php
            }
            $cat_stmt->close();
            ?>
        </div>
    </div>
</section>
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
   </main>

<script>
    
</script>
<script>
    
function moveSlider(categoryId, direction) {
    const slider = document.getElementById(`slider-${categoryId}`);
    const scrollAmount = slider.offsetWidth;
    if (direction === 'left') {
        slider.scrollBy(-scrollAmount, 0);
    } else {
        slider.scrollBy(scrollAmount, 0);
    }
}
</script>

    <!-- SCRIPT FOR SLIDER HERO -->
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
    setInterval(nextSlide,3000);
</script>

</body>
<?php include 'conf/foot.php'; ?>
</html>
