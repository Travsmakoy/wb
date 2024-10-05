<?php
session_start();
require_once '../conf/config.php';

// Redirect to login if not admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

$message = ''; // Initialize message variable

// Handle new product submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $category_id = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $flavor = $_POST['flavor'];
    $color = $_POST['color'];
    $puffs = $_POST['puffs'];
    $description = $_POST['description'];

    // Handle file upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert product into the database
        $stmt = $conn->prepare("INSERT INTO products (category_id, brand_id, product_name, price, flavor, color, puffs, description, img_dir) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('iisdssiss', $category_id, $brand_id, $product_name, $price, $flavor, $color, $puffs, $description, $target_file);

        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product: " . $stmt->error;
        }
    } else {
        $message = "Error uploading image.";
    }
}

// Handle new category submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $new_category = $_POST['new_category'];

    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param('s', $new_category);

    if ($stmt->execute()) {
        $message = "Category added successfully!";
    } else {
        $message = "Error adding category: " . $stmt->error;
    }
}

// Handle new brand submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_brand'])) {
    $category_id = $_POST['category_id'];
    $new_brand = $_POST['new_brand'];

    $stmt = $conn->prepare("INSERT INTO brands (brand_name, category_id) VALUES (?, ?)");
    $stmt->bind_param('si', $new_brand, $category_id);

    if ($stmt->execute()) {
        $message = "Brand added successfully!";
    } else {
        $message = "Error adding brand: " . $stmt->error;
    }
}

// Handle product deletion
if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Error deleting product: " . $stmt->error;
    }
}

// Handle category deletion
if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);
    if ($stmt->execute()) {
        $message = "Category deleted successfully!";
    } else {
        $message = "Error deleting category: " . $stmt->error;
    }
}

// Handle brand deletion
if (isset($_GET['delete_brand'])) {
    $brand_id = $_GET['delete_brand'];
    $stmt = $conn->prepare("DELETE FROM brands WHERE brand_id = ?");
    $stmt->bind_param('i', $brand_id);
    if ($stmt->execute()) {
        $message = "Brand deleted successfully!";
    } else {
        $message = "Error deleting brand: " . $stmt->error;
    }
}

// Handle product edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    $product_id = $_POST['edit_product_id'];
    $category_id = $_POST['edit_category_id'];
    $brand_id = $_POST['edit_brand_id'];
    $product_name = $_POST['edit_product_name'];
    $price = $_POST['edit_price'];
    $flavor = $_POST['edit_flavor'];
    $color = $_POST['edit_color'];
    $puffs = $_POST['edit_puffs'];
    $description = $_POST['edit_description'];

    $stmt = $conn->prepare("UPDATE products SET category_id = ?, brand_id = ?, product_name = ?, price = ?, flavor = ?, color = ?, puffs = ?, description = ? WHERE product_id = ?");
    $stmt->bind_param('iisdssisi', $category_id, $brand_id, $product_name, $price, $flavor, $color, $puffs, $description, $product_id);

    if ($stmt->execute()) {
        $message = "Product updated successfully!";
    } else {
        $message = "Error updating product: " . $stmt->error;
    }

    // Handle image update if a new image is uploaded
    if ($_FILES['edit_image']['size'] > 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["edit_image"]["name"]);

        if (move_uploaded_file($_FILES["edit_image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE products SET img_dir = ? WHERE product_id = ?");
            $stmt->bind_param('si', $target_file, $product_id);
            $stmt->execute();
        } else {
            $message .= " Error uploading new image.";
        }
    }
}

// Fetch all products with category and brand names
$result = $conn->query("SELECT p.*, c.category_name, b.brand_name 
                        FROM products p 
                        JOIN categories c ON p.category_id = c.category_id 
                        JOIN brands b ON p.brand_id = b.brand_id");
$products = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all categories
$result = $conn->query("SELECT * FROM categories");
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all brands with category names
$result = $conn->query("SELECT b.*, c.category_name 
                        FROM brands b 
                        JOIN categories c ON b.category_id = c.category_id");
$brands = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VapeShop Admin - Dashboard & Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #333;
            --background-color: #f4f4f4;
            --text-color: #333;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            background-color: #0e153e;
            color: var(--text-color);
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--secondary-color);
            color: #fff;
            padding: 2rem;
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            margin-bottom: 2rem;
            
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin: 1rem 0;
            padding: 0.75rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            flex: 1;
            padding: 2rem;
            margin-left: var(--sidebar-width);
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .message {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: space-between;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 1.5rem;
            width: calc(33.333% - 1rem);
            margin-bottom: 1rem;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        #ManageProducts{
            background-color: #2f987c;
            
        }
        #ManageCategories{
            background-color: #296dcc;
            
        }
        #ManageBrands{
            background-color: #a0a0a0;
            
        }
        #icon1{
            color: darkgreen;
            
        }
        #icon2{
            color: darkblue;
            
        }
        #icon3{
            color: brown;
            
        }


        .card:hover {
            transform: translateY(-5px);
            box-shadow: 5px 5px darkblue;
            
        }

        .card h3 {
            margin-bottom: 1rem;
        }

        .card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            font-family: "Tourney", sans-serif;
            
        }


        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .form-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 17px;
        }

        button:hover {
            background-color: #034a1e;
            font-size: 19px; 
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary-color);
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            
        }

        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .edit-modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .edit-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }
        
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>Admin Panel</h2>
        <nav>
            <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="#"><i class="fas fa-boxes"></i> Inventory</a>
            <a href="#"><i class="fas fa-comments"></i> Chats</a>
            <a href="user.php"><i class="fas fa-users"></i> Users</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="content">
        <header class="dashboard-header">
            <h1 style = "color:gray">VapeShop - Admin Dashboard & Inventory</h1>
        </header>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <section id="management-cards" class="card-container">
            <div class="card" id = "ManageProducts" onclick="openModal('productModal')">
                <div class="card-icon" id = "icon1" ><i class="fas fa-box"></i></div>
                <h2>Manage Products</h2>
                <p>Add new products</p>
            </div>
            <div class="card" id = "ManageCategories" onclick="openModal('categoryModal')">
                <div class="card-icon" id = "icon2"><i class="fas fa-tags"></i></div>
                <h2>Manage Categories</h3>
                <p>Add and delete product categories</p>
            </div>
            <div class="card" id = "ManageBrands" id = "ManageBr" onclick="openModal('brandModal')">
                <div class="card-icon" id = "icon3"><i class="fas fa-copyright"></i></div>
                <h2>Manage Brands</h2>
                <p>Add and delete product brands</p>
            </div>
        </section>

        <!-- Modal for Products -->
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('productModal')">&times;</span>
                <h2>Add New Product</h2>
                <div class="form-section">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="add_product">
                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select id="category_id" name="category_id" required onchange="loadBrands(this.value)">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_id">Brand:</label>
                            <select id="brand_id" name="brand_id" required>
                                <option value="">Select Brand</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_name">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="flavor">Flavor:</label>
                            <input type="text" id="flavor" name="flavor" required>
                        </div>
                        <div class="form-group">
                            <label for="color">Color:</label>
                            <input type="text" id="color" name="color">
                        </div>
                        <div class="form-group">
                            <label for="puffs">Puffs:</label>
                            <input type="number" id="puffs" name="puffs">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Product Image:</label>
                            <input type="file" id="image" name="image" accept="image/*" required>
                        </div>
                        <button type="submit">Add Product</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Categories -->
        <div id="categoryModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('categoryModal')">&times;</span>
                <h2>Manage Categories</h2>
                <div class="form-section">
                    <h3>Add New Category</h3>
                    <form method="post">
                        <input type="hidden" name="add_category">
                        <div class="form-group">
                            <label for="new_category">Category Name:</label>
                            <input type="text" id="new_category" name="new_category" required>
                        </div>
                        <button type="submit">Add Category</button>
                    </form>
                </div>
                <h3>Existing Categories</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                                <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                <td class="action-buttons">
                                    <a href="?delete_category=<?php echo $category['category_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Brands -->
        <div id="brandModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('brandModal')">&times;</span>
                <h2>Manage Brands</h2>
                <div class="form-section">
                    <h3>Add New Brand</h3>
                    <form method="post">
                        <input type="hidden" name="add_brand">
                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="new_brand">Brand Name:</label>
                            <input type="text" id="new_brand" name="new_brand" required>
                        </div>
                        <button type="submit">Add Brand</button>
                    </form>
                </div>
                <h3>Existing Brands</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Brand ID</th>
                                <th>Brand Name</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands as $brand): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($brand['brand_id']); ?></td>
                                <td><?php echo htmlspecialchars($brand['brand_name']); ?></td>
                                <td><?php echo htmlspecialchars($brand['category_name']); ?></td>
                                <td class="action-buttons">
                                    <a href="?delete_brand=<?php echo $brand['brand_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this brand?');">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div id="editProductModal" class="edit-modal">
            <div class="edit-modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h2>Edit Product</h2>
                <form id="editProductForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="edit_product" value="1">
                    <input type="hidden" id="edit_product_id" name="edit_product_id">
                    <div class="form-group">
                        <label for="edit_category_id">Category:</label>
                        <select id="edit_category_id" name="edit_category_id" required onchange="loadEditBrands(this.value)">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_brand_id">Brand:</label>
                        <select id="edit_brand_id" name="edit_brand_id" required>
                            <option value="">Select Brand</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_name">Product Name:</label>
                        <input type="text" id="edit_product_name" name="edit_product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Price:</label>
                        <input type="number" id="edit_price" name="edit_price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_flavor">Flavor:</label>
                        <input type="text" id="edit_flavor" name="edit_flavor" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_color">Color:</label>
                        <input type="text" id="edit_color" name="edit_color">
                    </div>
                    <div class="form-group">
                        <label for="edit_puffs">Puffs:</label>
                        <input type="number" id="edit_puffs" name="edit_puffs">
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description:</label>
                        <textarea id="edit_description" name="edit_description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_image">New Product Image (optional):</label>
                        <input type="file" id="edit_image" name="edit_image" accept="image/*">
                    </div>
                    <button type="submit">Update Product</button>
                </form>
            </div>
        </div>

        <!-- Products Table -->
        <section id="products-table">
            <h2 style = "color:gray">Products</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                            <td class="action-buttons">
                                <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($product)); ?>)" class="btn btn-edit">Edit</button>
                                <a href="?delete_product=<?php echo $product['product_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function loadBrands(categoryId) {
            const brandSelect = document.getElementById('brand_id');
            brandSelect.innerHTML = '<option value="">Select Brand</option>';

            <?php foreach ($brands as $brand): ?>
            if (categoryId == '<?php echo $brand['category_id']; ?>') {
                const option = document.createElement('option');
                option.value = '<?php echo $brand['brand_id']; ?>';
                option.textContent = '<?php echo $brand['brand_name']; ?>';
                brandSelect.appendChild(option);
            }
            <?php endforeach; ?>
        }

        function loadEditBrands(categoryId) {
            const brandSelect = document.getElementById('edit_brand_id');
            brandSelect.innerHTML = '<option value="">Select Brand</option>';

            <?php foreach ($brands as $brand): ?>
            if (categoryId == '<?php echo $brand['category_id']; ?>') {
                const option = document.createElement('option');
                option.value = '<?php echo $brand['brand_id']; ?>';
                option.textContent = '<?php echo $brand['brand_name']; ?>';
                brandSelect.appendChild(option);
            }
            <?php endforeach; ?>
        }

        function openEditModal(product) {
            document.getElementById('editProductModal').style.display = "block";
            document.getElementById('edit_product_id').value = product.product_id;
            document.getElementById('edit_category_id').value = product.category_id;
            loadEditBrands(product.category_id);
            document.getElementById('edit_brand_id').value = product.brand_id;
            document.getElementById('edit_product_name').value = product.product_name;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_flavor').value = product.flavor;
            document.getElementById('edit_color').value = product.color;
            document.getElementById('edit_puffs').value = product.puffs;
            document.getElementById('edit_description').value = product.description;
        }

        function closeEditModal() {
            document.getElementById('editProductModal').style.display = "none";
        }

    // Close modals when clicking outside of them
window.onclick = function(event) {
    if (event.target.className === 'modal' || event.target.className === 'edit-modal') {
        event.target.style.display = "none";
    }
}
</script>
</body>
</html>