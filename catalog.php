<?php
// Database connection
include 'navbar.php'; 
require_once 'conf/config.php';

// Fetch categories
$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

$categories = [];
if ($categoryResult->num_rows > 0) {
    while($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch products for each category (limited to 6)
$products = [];
foreach ($categories as $category) {
    $productSql = "SELECT * FROM products WHERE category_id = {$category['category_id']} LIMIT 6";
    $productResult = $conn->query($productSql);
    
    $categoryProducts = [];
    if ($productResult->num_rows > 0) {
        while($row = $productResult->fetch_assoc()) {
            $row['img_dir'] = str_replace("../", "", $row['img_dir']);
            $categoryProducts[] = $row;
        }
    }
    $products[$category['category_id']] = $categoryProducts;
}

// Convert categories and products to JSON for JavaScript use
$categoriesJson = json_encode($categories);
$productsJson = json_encode($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Vape Shop Catalog</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        :root {
            --primary-bg: #121212;
            --secondary-bg: #1e1e1e;
            --text-light: #ffffff;
            --accent-blue: #00ffff;
            --accent-pink: #ff00ff;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-light);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 3rem;
            color: var(--accent-blue);
            text-shadow: 0 0 10px var(--accent-blue);
            margin-bottom: 20px;
            text-align: center;
        }

        .category {
            margin-bottom: 40px;
        }

        .category h2 {
            font-size: 2rem;
            color: var(--accent-pink);
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: var(--secondary-bg);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--accent-blue);
        }

        .product-price {
            font-size: 1rem;
            color: var(--accent-pink);
            font-weight: bold;
        }

        .view-all-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: var(--accent-pink);
            color: var(--text-light);
            text-align: center;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .view-all-btn:hover {
            background-color: #ff33ff;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: var(--secondary-bg);
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
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

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
    </style>
</head>
<body x-data="catalogApp()">
    <div class="container">
        <h1>Vape Shop Catalog</h1>
        
        <template x-for="category in categories" :key="category.category_id">
            <div class="category">
                <h2 x-text="category.category_name"></h2>
                <div class="product-grid">
                    <template x-for="product in products[category.category_id]" :key="product.product_id">
                        <div class="product-card" @click="openProductModal(product)">
                            <img :src="product.img_dir" :alt="product.product_name" class="product-image">
                            <div class="product-info">
                                <h3 class="product-name" x-text="product.product_name"></h3>
                                <p class="product-price" x-text="'₱' + parseFloat(product.price).toFixed(2)"></p>
                            </div>
                        </div>
                    </template>
                </div>
                <a href="#" @click.prevent="loadAllProducts(category.category_id)" class="view-all-btn">
                    View All <span x-text="category.category_name"></span>
                </a>
            </div>
        </template>
    </div>

    <!-- Modal for single product -->
    <div x-show="selectedProduct" class="popup-overlay" x-cloak @click.self="selectedProduct = null">
        <div class="popup-content">
            <span class="close-popup" @click="selectedProduct = null">&times;</span>
            <img :src="selectedProduct?.img_dir" :alt="selectedProduct?.product_name" class="popup-image">
            <h2 class="popup-title" x-text="selectedProduct?.product_name"></h2>
            <p class="popup-description" x-text="selectedProduct?.description || 'No description available.'"></p>
            <p class="popup-price" x-text="'₱' + parseFloat(selectedProduct?.price).toFixed(2)"></p>
            <div>
                <p><strong>Flavor:</strong> <span x-text="selectedProduct?.flavor || 'N/A'"></span></p>
                <p><strong>Color:</strong> <span x-text="selectedProduct?.color || 'N/A'"></span></p>
                <p><strong>Puffs:</strong> <span x-text="selectedProduct?.puffs || 'N/A'"></span></p>
            </div>
        </div>
    </div>

    <!-- Modal for all products in a category -->
    <div x-show="showAllProducts" class="popup-overlay" x-cloak @click.self="showAllProducts = false">
        <div class="popup-content">
            <span class="close-popup" @click="showAllProducts = false">&times;</span>
            <h2 class="popup-title" x-text="'All ' + selectedCategory?.category_name"></h2>
            <div class="product-grid">
                <template x-for="product in allProducts" :key="product.product_id">
                    <div class="product-card" @click="openProductModal(product); showAllProducts = false">
                        <img :src="product.img_dir" :alt="product.product_name" class="product-image">
                        <div class="product-info">
                            <h3 class="product-name" x-text="product.product_name"></h3>
                            <p class="product-price" x-text="'₱' + parseFloat(product.price).toFixed(2)"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function catalogApp() {
            return {
                categories: <?php echo $categoriesJson; ?>,
                products: <?php echo $productsJson; ?>,
                allProducts: [],
                selectedProduct: null,
                selectedCategory: null,
                showAllProducts: false,

                openProductModal(product) {
                    this.selectedProduct = product;
                },

                async loadAllProducts(categoryId) {
                    const response = await fetch(`get_category_products.php?category_id=${categoryId}`);
                    this.allProducts = await response.json();
                    // Remove "../" from img_dir for all products
                    this.allProducts = this.allProducts.map(product => {
                        product.img_dir = product.img_dir.replace("../", "");
                        return product;
                    });
                    this.selectedCategory = this.categories.find(category => category.category_id === categoryId);
                    this.showAllProducts = true;
                }
            }
        }
    </script>
</body>
<?php include 'conf/foot.php'; ?>
</html>