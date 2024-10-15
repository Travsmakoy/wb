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
    <!-- <title>Modern Vape Shop Catalog</title> -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="./styles/catalog.css">


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