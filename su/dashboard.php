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
            $message = "<p class='success'>Product added successfully!</p>";
        } else {
            $message = "<p class='error'>Error adding product: " . $stmt->error . "</p>";
        }
    } else {
        $message = "<p class='error'>Error uploading image.</p>";
    }
}

// Handle new category submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $new_category = $_POST['new_category'];
    
    // Insert new category into the database
    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param('s', $new_category);

    if ($stmt->execute()) {
        $message = "<p class='success'>Category added successfully!</p>";
    } else {
        $message = "<p class='error'>Error adding category: " . $stmt->error . "</p>";
    }
}

// Handle new brand submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_brand'])) {
    $category_id = $_POST['category_id'];
    $new_brand = $_POST['new_brand'];
    
    // Insert new brand into the database
    $stmt = $conn->prepare("INSERT INTO brands (brand_name, category_id) VALUES (?, ?)");
    $stmt->bind_param('si', $new_brand, $category_id);

    if ($stmt->execute()) {
        $message = "<p class='success'>Brand added successfully!</p>";
    } else {
        $message = "<p class='error'>Error adding brand: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - VapeShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .sidebar {
            width: 250px;
            background: #333;
            color: #fff;
            padding: 20px;
            height: 100vh;
            position: fixed;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin: 15px 0;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
        }
        .success {
            color: #28a745;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        hr {
            border: 0;
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-boxes"></i> Products</a>
        <a href="#"><i class="fas fa-comments"></i> Chats</a>
        <a href="#"><i class="fas fa-users"></i> Users</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <header>
            <h1>VapeShop - Admin Dashboard</h1>
        </header>

        <div class="container">
            <!-- Add New Product Form -->
            <h2>Add New Product</h2>
            <?php if ($message) { echo $message; } ?>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="add_product">

                <!-- Category Dropdown -->
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required onchange="loadBrands(this.value)">
                    <option value="">Select Category</option>
                    <?php
                    $categories = $conn->query("SELECT category_id, category_name FROM categories");
                    while ($row = $categories->fetch_assoc()) {
                        echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                    }
                    ?>
                </select>

                <!-- Brand Dropdown -->
                <label for="brand_id">Brand:</label>
                <select id="brand_id" name="brand_id" required>
                    <option value="">Select Brand</option>
                </select>

                <!-- Other Product Fields -->
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required>

                <label for="price">Price:</label>
                <input type="text" id="price" name="price" required>

                <label for="flavor">Flavor:</label>
                <input type="text" id="flavor" name="flavor" required>

                <label for="color">Color:</label>
                <input type="text" id="color" name="color" required>

                <label for="puffs">Puffs:</label>
                <input type="number" id="puffs" name="puffs" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <button type="submit">Add Product</button>
            </form>

            <hr>

            <!-- Add New Category Form -->
            <h2>Add New Category</h2>
            <form method="post">
                <input type="hidden" name="add_category">
                <label for="new_category">New Category Name:</label>
                <input type="text" id="new_category" name="new_category" required>
                <button type="submit">Add Category</button>
            </form>

            <hr>

            <!-- Add New Brand for a Specific Category Form -->
            <h2>Add New Brand for Category</h2>
            <form method="post">
                <input type="hidden" name="add_brand">
                <label for="category_id_brand">Category:</label>
                <select id="category_id_brand" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php
                    $categories = $conn->query("SELECT category_id, category_name FROM categories");
                    while ($row = $categories->fetch_assoc()) {
                        echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                    }
                    ?>
                </select>

                <label for="new_brand">New Brand Name:</label>
                <input type="text" id="new_brand" name="new_brand" required>
                <button type="submit">Add Brand</button>
            </form>

        </div>

        <footer>
            <p>&copy; 2024 VapeShop - Admin Dashboard</p>
        </footer>
    </div>
    
    <!-- JavaScript Section -->
    <script>
    // AJAX to dynamically load brands based on category
    function loadBrands(categoryId) {
        if (categoryId) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_brands.php?category_id=' + categoryId, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('brand_id').innerHTML = this.responseText;
                }
            };
            xhr.send();
        } else {
            document.getElementById('brand_id').innerHTML = '<option value="">Select Brand</option>';
        }
    }
    </script>

</body>
</html>