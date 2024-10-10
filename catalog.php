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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="catalogApp()">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Vape Shop Catalog</h1>
        
        <template x-for="category in categories" :key="category.category_id">
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-4 text-gray-800" x-text="category.category_name"></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                    <template x-for="product in products[category.category_id]" :key="product.product_id">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                            <img :src="product.img_dir" :alt="product.product_name" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 text-gray-800" x-text="product.product_name"></h3>
                                <p class="text-gray-700 text-base mb-3" x-text="'₱' + parseFloat(product.price).toFixed(2)"></p>
                                <button @click="openProductModal(product)" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="mt-6 text-center">
                    <button @click="loadAllProducts(category.category_id)" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        View All <span x-text="category.category_name"></span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Modal for single product -->
    <div x-show="selectedProduct" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full" @click.away="selectedProduct = null">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-4 text-gray-800" x-text="selectedProduct?.product_name"></h2>
                <img :src="selectedProduct?.img_dir" :alt="selectedProduct?.product_name" class="w-full h-64 object-cover mb-6 rounded-lg">
                <p class="text-2xl font-bold mb-4 text-gray-700" x-text="'₱' + parseFloat(selectedProduct?.price).toFixed(2)"></p>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <p><strong>Flavor:</strong> <span x-text="selectedProduct?.flavor || 'N/A'"></span></p>
                    <p><strong>Color:</strong> <span x-text="selectedProduct?.color || 'N/A'"></span></p>
                    <p><strong>Puffs:</strong> <span x-text="selectedProduct?.puffs || 'N/A'"></span></p>
                </div>
                <p class="mb-6"><strong>Description:</strong> <span x-text="selectedProduct?.description || 'No description available.'"></span></p>
                <button @click="selectedProduct = null" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for all products in a category -->
    <div x-show="showAllProducts" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full" @click.away="showAllProducts = false">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-6 text-gray-800" x-text="'All ' + selectedCategory?.category_name"></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-h-[70vh] overflow-y-auto">
                    <template x-for="product in allProducts" :key="product.product_id">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img :src="product.img_dir" :alt="product.product_name" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 text-gray-800" x-text="product.product_name"></h3>
                                <p class="text-gray-700 text-base mb-3" x-text="'$' + parseFloat(product.price).toFixed(2)"></p>
                                <button @click="openProductModal(product); showAllProducts = false" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="mt-6 text-center">
                    <button @click="showAllProducts = false" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        Close
                    </button>
                </div>
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
<?php include 'chat-widget.php'; ?>
</html>